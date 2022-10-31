<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\BaseController;
use App\Exports\ProductExport;
use Maatwebsite\Excel\Facades\Excel;
use App\Models\Mutasi;
use App\Models\ListMutasi;
use App\Models\SaldoProduct;
use App\Models\Supplier;
use App\Models\Gudang;
use App\Models\Product;
use Illuminate\Support\Facades\Validator;
use DB;
use Log;
use Cookie;

class ProductOutController extends BaseController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $type = 'Out';
        $gudangs = Gudang::where('deleted_at','=',NULL)->get();
        $gudang = 'all';
        $start = date('Y-m-d');
        $end = date('Y-m-d');
        
        if ($request->from && $request->to) {
            $start = $request->from;
            $end = $request->to;
        }
        if ($request->action == 'export') {
            $gudang =  $request->gudang;
            return Excel::download(new ProductExport($start, $end, 'all', $gudang, $type), 'product_'.$type.'.xlsx');
        }
        $this->cookieLoh('start',$start);
        $this->cookieLoh('end',$end);
        $gudang =  $request->gudang == 'all' ? null : $request->gudang;
        $datas = ListMutasi::whereBetween('created_at',[$start.' 00:00:01',$end.' 23:59:59'])->where('supplier_id',NULL)->where('gudang_id','ILIKE',$gudang)->orderBy('id','ASC')->where('mutasi','Out')->get();
        $url_search = route('product-out.search');
        $gudang =  $request->gudang == null ? 'all' : $request->gudang;
        return view('product.data',compact('datas','type','gudangs','gudang','url_search'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $products = $request->product;
        $tanggal = $request->tanggal;
        $supplier = $request->supplier;
        $gudang = $request->gudang;
        $keterangan = $request->keterangan;
        $validator = Validator::make($request->all(), [
            'gudang' => ['required'],
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
                'no_trx'=>change('Out'),
                'keterangan'=>$keterangan,
                'gudang_id'=>$gudang,
                'supplier_id'=>null,
                'mutasi'=>'Out',
                'created_by'=>$request->user()->id
            ]);
            foreach ($products as $key => $value) {
                if ($value['jumlah'] > 0) {
                    $saldo_akhir = SaldoProduct::where('gudang_id',$gudang)->where('product_id',$value['product']['id'])->first();
                    if (!$saldo_akhir) {
                        DB::rollback();
                        return $this->getError400('Stok '.$value['product']['product_name'].' di gudang '.$gudang.' tidak ada.',);
                    }
                    $saldo = (int)($saldo_akhir->saldo-$value['jumlah']);
                    if ($saldo < 0) {
                        DB::rollback();
                        return $this->getError400('Stok '.$value['product']['product_name'].' di gudang '.$gudang.' kurang.',);
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
                        'mutasi'=>'Out',
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
}
