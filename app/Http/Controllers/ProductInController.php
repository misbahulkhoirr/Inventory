<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Supplier;
use App\Models\Mutasi;
use App\Models\Gudang;
use App\Models\ListMutasi;
use App\Models\SaldoProduct;
use App\Http\Controllers\BaseController;
use App\Exports\ProductExport;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Validator;
use DB;
use Log;
use Cookie;

class ProductInController extends BaseController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $type = 'In';
        $suppliers = Supplier::where('deleted_at','=',NULL)->get();
        $gudangs = Gudang::where('deleted_at','=',NULL)->get();
        $start = date('Y-m-d');
        $end = date('Y-m-d');
        $supplier = 'all';
        $gudang = 'all';
        if ($request->from && $request->to) {
            $start = $request->from;
            $end = $request->to;
        }
        if ($request->action == 'export') {
            $supplier = $request->supplier;
            $gudang =  $request->gudang;
            return Excel::download(new ProductExport($start, $end, $supplier, $gudang, $type), 'product_'.$type.'.xlsx');
        }
        $supplier = $request->supplier == 'all' ? null : $request->supplier;
        $gudang =  $request->gudang == 'all' ? null : $request->gudang;
        $this->cookieLoh('start',$start);
        $this->cookieLoh('end',$end);
        $datas = ListMutasi::whereBetween('created_at',[$start.' 00:00:01',$end.' 23:59:59'])->where('mutasi','In')->where('supplier_id','ILIKE',$supplier)->where('gudang_id','ILIKE',$gudang)->orderBy('id','ASC')->get();
        $url_search = route('product-in.search');
        $supplier = $request->supplier == null ? 'all' : $request->supplier;
        $gudang =  $request->gudang == null ? 'all' : $request->gudang;
        return view('product.data',compact('datas','type','suppliers','supplier','gudangs','gudang','url_search'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create_in(Request $request)
    {
        $type = 'In';
        return view('product.form',compact('type'));
    }
    public function create_out(Request $request)
    {
        $type = 'Out';
        return view('product.form_out2',compact('type'));
    }
    public function get_api(){
        $products = Product::where('deleted_at','=',NULL)->orderBy('product_name','ASC')->get();
        $suppliers = Supplier::orderBy('name','ASC')->get();
        $gudangs = Gudang::orderBy('name','ASC')->get();
        $saldos = SaldoProduct::get();
        return response()->json([
            'products'=>$products,
            'suppliers'=>$suppliers,
            'gudangs'=>$gudangs,
            'saldos'=>$saldos,
        ]);
    }
    public function get_product2(){
        // $saldos = SaldoProduct::get();
        $product = SaldoProduct::select('*')
        ->join('products','saldo_products.product_id','=','products.id')->get();
        return response()->json([
            'products'=>$product,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, $type)
    {
        $products = $request->product;
        $jumlah = $request->jumlah;
        $supplier = $request->supplier;
        $keterangan = $request->keterangan;
        $gudang = $request->gudang;
        if (max($jumlah) < 1) {
            return $this->getError400('Salah satu Jumlah harus diisi');
        }
        DB::beginTransaction();
        try {
            foreach ($products as $key => $value) {
                if ($jumlah[$key] > 0) {
                    if (count($supplier) > 0) {
                        if ((int)($supplier[$key]) < 1) {
                            DB::rollback();
                            return $this->getError400('Supplier '.$value['product_name'].' Harus dipilih');
                        }elseif ((int)($gudang[$key]) < 1) {
                            DB::rollback();
                            return $this->getError400('Gudang untuk '.$value['product_name'].' Harus dipilih');
                        }
                    }
                    
                    $saldo_akhir = SaldoProduct::where('gudang_id',$gudang[$key])->where('product_id',$value['id'])->first();
                    if ($saldo_akhir) {
                        if ($type == 'In') {
                            $saldo = (int)($saldo_akhir->saldo+$jumlah[$key]);
                        }else{
                            if ($jumlah[$key] > $saldo_akhir->saldo) {
                                DB::rollback();
                                return $this->getError400('Stok '.$value['product_name'].' di gudang '.$saldo_akhir->gudang->name.' Kurang.');
                            }
                            $saldo = (int)($saldo_akhir->saldo-$jumlah[$key]);
                        }
                    }else{
                        if ($type == 'Out'){
                            if ($gudang[$key] == '' || $gudang[$key] == null) {
                                DB::rollback();
                                return $this->getError400('Gudang untuk '.$value['product_name'].' belum dipilih.');
                            }elseif ($gudang[$key] > 0) {
                                $gd = Gudang::find($gudang[$key]);
                                DB::rollback();
                                return $this->getError400('Stok '.$value['product_name'].' di gudang '.$gd->name.' tidak ada.',);
                            }
                        }
                    }
                    
                    $balance = SaldoProduct::updateOrCreate([
                        'gudang_id'=>$gudang[$key],
                        'product_id'=>$value['id']
                    ],[
                        'saldo'=>$saldo_akhir ? (int)($saldo) : $jumlah[$key],
                    ]);
                    Mutasi::create([
                        'gudang_id'=>$gudang[$key],
                        'product_id'=>$value['id'],
                        'created_by'=>$request->user()->id,
                        'mutasi'=>$type,
                        'jumlah'=>$jumlah[$key],
                        'supplier_id'=>$type == 'Out' ? NULL : $supplier[$key],
                        'balance'=>$balance->saldo,
                        'keterangan'=>$keterangan[$key],
                    ]);                    
                }
            }
        } catch (\Throwable $th) {
            Log::error('Gagal IN = '.$th);
            DB::rollback();
            return response()->json([
                'code'=>400,
                'title'=>'Opps..',
                'message'=>'Gagal disimpan',
                'icon'=>'error'
            ]);
        }
        DB::commit();
        return response()->json([
            'code'=>200,
            'title'=>'Berhasil',
            'message'=>'Berhasil disimpan',
            'icon'=>'success'
        ]);
    }
    public function store2(Request $request, $type)
    {
        $products = $request->product;
        $jumlah = $request->jumlah;
        $keterangan = $request->keterangan;
        if (max($jumlah) < 1) {
            return $this->getError400('Salah satu Jumlah harus diisi');
        }
        DB::beginTransaction();
        try {
            foreach ($products as $key => $value) {
                if ($jumlah[$key] > 0) {
                    $saldo_akhir = SaldoProduct::where('gudang_id',$value['gudang_id'])->where('product_id',$value['product_id'])->first();
                    if ($jumlah[$key] > $saldo_akhir->saldo) {
                        DB::rollback();
                        return $this->getError400('Stok '.$value['Produk']['product_name'].' di gudang '.$saldo_akhir->gudang->name.' Kurang.');
                    }
                    $saldo = (int)($saldo_akhir->saldo-$jumlah[$key]);
                    $saldo_akhir->saldo = $saldo;
                    $saldo_akhir->update();
                    Mutasi::create([
                        'gudang_id'=>$value['gudang_id'],
                        'product_id'=>$value['product_id'],
                        'created_by'=>$request->user()->id,
                        'mutasi'=>$type,
                        'jumlah'=>$jumlah[$key],
                        'supplier_id'=>NULL,
                        'balance'=>$saldo,
                        'keterangan'=>$keterangan[$key],
                    ]);                    
                }
            }
        } catch (\Throwable $th) {
            Log::error('Gagal IN = '.$th);
            DB::rollback();
            return response()->json([
                'code'=>400,
                'title'=>'Opps..',
                'message'=>'Gagal disimpan',
                'icon'=>'error'
            ]);
        }
        DB::commit();
        return response()->json([
            'code'=>200,
            'title'=>'Berhasil',
            'message'=>'Berhasil disimpan',
            'icon'=>'success'
        ]);
    }
    public function store3(Request $request)
    {
        $products = $request->product;
        $tanggal = $request->tanggal;
        $supplier = $request->supplier;
        $gudang = $request->gudang;
        $keterangan = $request->keterangan;
        $validator = Validator::make($request->all(), [
            'gudang' => ['required'],
            'supplier' => ['required'],
            'keterangan' => ['required', 'string'],
            'product' => ['required'],
            'tanggal' => ['required'],
        ]);
        if ($validator->fails()) {
            return response()->json([
                'code' => 400,
                'title' => 'Opps..',
                'icon' => 'error',
                'message' => $validator->errors()->first(),
            ]);
        }
        DB::beginTransaction();
        try {
            $list = ListMutasi::create([
                'tanggal'=>date('Y-m-d', strtotime($tanggal)),
                'no_trx'=>change('In'),
                'keterangan'=>$keterangan,
                'gudang_id'=>$gudang,
                'supplier_id'=>$supplier,
                'mutasi'=>'In',
                'created_by'=>$request->user()->id
            ]);
            foreach ($products as $key => $value) {
                if ($value['jumlah'] > 0) {
                    $saldo_akhir = SaldoProduct::where('gudang_id',$gudang)->where('product_id',$value['product']['id'])->first();
                    if ($saldo_akhir) {
                        // if ($type == 'In') {
                            $saldo = (int)($saldo_akhir->saldo+$value['jumlah']);
                        // }else{
                        //     if ($value['jumlah'] > $saldo_akhir->saldo) {
                        //         DB::rollback();
                        //         return $this->getError400('Stok '.$value['product_name'].' di gudang '.$saldo_akhir->gudang->name.' Kurang.');
                        //     }
                        //     $saldo = (int)($saldo_akhir->saldo-$value['jumlah']);
                        // }
                    }else{
                        // if ($type == 'Out'){
                        //     if ($gudang[$key] == '' || $gudang[$key] == null) {
                        //         DB::rollback();
                        //         return $this->getError400('Gudang untuk '.$value['product_name'].' belum dipilih.');
                        //     }elseif ($gudang[$key] > 0) {
                        //         $gd = Gudang::find($gudang[$key]);
                        //         DB::rollback();
                        //         return $this->getError400('Stok '.$value['product_name'].' di gudang '.$gd->name.' tidak ada.',);
                        //     }
                        // }
                    }
                    
                    $balance = SaldoProduct::updateOrCreate([
                        'gudang_id'=>$gudang,
                        'product_id'=>$value['product']['id']
                    ],[
                        'saldo'=>$saldo_akhir ? (int)($saldo) : $value['jumlah'],
                    ]);
                    Mutasi::create([
                        'list_mutasi_id'=>$list->id,
                        'gudang_id'=>$gudang,
                        'product_id'=>$value['product']['id'],
                        'created_by'=>$request->user()->id,
                        'mutasi'=>'In',
                        'jumlah'=>$value['jumlah'],
                        'supplier_id'=>$supplier,
                        'balance'=>$balance->saldo,
                        'keterangan'=>$keterangan,
                    ]);                   
                }
            }
        } catch (\Throwable $th) {
            Log::error('Gagal IN = '.$th);
            DB::rollback();
            return response()->json([
                'code'=>400,
                'title'=>'Opps..',
                'message'=>'Gagal disimpan',
                'icon'=>'error'
            ]);
        }
        DB::commit();
        return response()->json([
            'code'=>200,
            'title'=>'Berhasil',
            'message'=>'Berhasil disimpan',
            'icon'=>'success'
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function no_trx(Request $request){
        return response()->json([
            'no_trx'=>change($request->type)
        ]);
    }
}
