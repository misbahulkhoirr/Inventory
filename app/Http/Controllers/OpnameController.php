<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\BaseController;
use App\Models\Opname;
use App\Models\Product;
use App\Models\SaldoOpname;
use App\Models\PetugasOpname;
use App\Models\SaldoProduct;
use App\Models\DetailOpname;
use App\Models\User;
use App\Models\Mutasi;
use DB;
use Log;
use Validator;

class OpnameController extends BaseController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $start = date('Y-m-d');
        $end = date('Y-m-d');
        $status = $request->status;
        if ($request->from && $request->to) {
            $start = $request->from;
            $end = $request->to;
        }
        $this->cookieLoh('start',$start);
        $this->cookieLoh('end',$end);
        $datas = Opname::whereBetween('created_at',[$start.' 00:00:01',$end.' 23:59:59'])->where('status','ILIKE',$status)->orderBy('id','DESC')->get();
        return view('opname.index',compact('datas','status'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $products = Product::where('deleted_at','=',NULL)->orderBy('product_name','ASC')->get();
        return view('opname.create',compact('products'));
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
        $fisik = $request->fisik;
        $tanggal = $request->tanggal;
        $petugases = $request->petugas;
        $gudang = $request->gudang;
        $keterangan = $request->keterangan;
        $input = $request->all();
        $validator = Validator::make($input, [
            'tanggal' => 'required',
            'petugas' => 'required',
            'gudang' => 'required',
		],[
			'tanggal.required'=>'Tanggal harus diisi.',
			'petugas.required'=>'Petugas harus dipilih.',
			'gudang.required'=>'Gudang harus dipilih.',
		]);
		if($validator->fails()){
            return $this->validasiError($validator->errors());
        }
        $length = count(array_keys($fisik,""));
        if (count($fisik) == $length) {
            return $this->getError400('Salah satu Stok Fisik harus diisi');
        }
        DB::beginTransaction();
        try {
            $opname = Opname::create([
                'tanggal'=>$tanggal,
                'gudang_id'=>$gudang,
                'status'=>'New',
                'created_by'=>$request->user()->id,
            ]);
            foreach ($petugases as $key => $value) {
                $ptgs = PetugasOpname::create([
                    'opname_id'=>$opname->id,
                    'petugas_id'=>$value['id']
                ]);
            }
            foreach ($products as $key => $value) {
                if ($fisik[$key] >= 0 && $fisik[$key]!= '') {
                    $saldo_akhir = SaldoProduct::where('product_id',$value['product_id'])->where('gudang_id',$gudang)->first();
                    $selisih = (int)($fisik[$key]-$saldo_akhir->saldo);
                    if ($selisih != 0 || $selisih != '') {
                        if($keterangan[$key] == '' || $keterangan[$key] == null){
                            DB::rollback();
                            return $this->getError400('Keterangan '.$saldo_akhir['product']['product_name'].' harus diisi, karena ada selisih');
    
                        }
                    }
                    $balance = DetailOpname::create([
                        'opname_id'=>$opname->id,
                        'seharusnya'=>$saldo_akhir->saldo,
                        'product_id'=>$value['product_id'],
                        'fisik'=>(int)$fisik[$key],
                        'selisih'=>(int)($selisih),
                        'keterangan'=>$keterangan[$key]
                    ]);
                                      
                }
            }
        } catch (\Throwable $th) {
            Log::error('Gagal IN = '.$th);
            DB::rollback();
            return $this->getError400('Gagal disimpan, Ada kesalahan.');
        }
        DB::commit();
        return $this->getSuccess200('Berhasil disimpan.');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $datas = Opname::find($id);
        return view('opname.view',compact('datas'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $datas = Opname::find($id);
        return view('opname.edit',compact('datas'));
    }
    public function petugas($id){
        $datas = Opname::find($id);
        $dt = [];
        foreach ($datas->operators as $key => $value) {
           $dt[] = $value->user;
        }
        return response()->json($dt);
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
        $products = $request->product;
        $fisik = $request->fisik;
        $tanggal = $request->tanggal;
        $petugases = $request->petugas;
        $gudang = $request->gudang;
        $keterangan = $request->keterangan;
        $input = $request->all();
        $validator = Validator::make($input, [
            'tanggal' => 'required',
            'petugas' => 'required',
            'gudang' => 'required'
		],[
			'tanggal.required'=>'Tanggal harus diisi.',
			'petugas.required'=>'Petugas harus dipilih.',
			'gudang.required'=>'Gudang harus dipilih.',
		]);
		if($validator->fails()){
            return $this->validasiError($validator->errors());
        }

        $length = count(array_keys($fisik,""));
        if (count($fisik) == $length) {
            return $this->getError400('Salah satu Stok Fisik harus diisi');
        }
        DB::beginTransaction();
        try {
            $opname = Opname::find($id)->update([
                'tanggal'=>$tanggal,
                'gudang_id'=>$gudang,
                'status'=>'New',
                'created_by'=>$request->user()->id,
            ]);
            $hapus = PetugasOpname::where('opname_id',$id)->delete();
            foreach ($petugases as $key => $value) {
                $ptgs = PetugasOpname::create([
                    'opname_id'=>$id,
                    'petugas_id'=>$value['id']
                ]);
            }
            // Log::info('Product = '. json_encode($products));
            foreach ($products as $key => $value) {
                if ($fisik[$key] >= 0 && $fisik[$key]!= '') {
                    $saldo_akhir = SaldoProduct::where('product_id',$value['product_id'])->where('gudang_id',$gudang)->first();
                    $selisih = (int)($fisik[$key]-$saldo_akhir->saldo);
                    if ($selisih != 0 || $selisih != '') {
                        if($keterangan[$key] == '' || $keterangan[$key] == null){
                            DB::rollback();
                            return $this->getError400('Keterangan '.$value['DetailProduct']['product_name'].' harus diisi, karena ada selisih');
    
                        }
                    }
                    $balance = DetailOpname::where('opname_id',$value['opname_id'])->where('product_id',$value['product_id'])->first()->update([
                        'fisik'=>(int)$fisik[$key],
                        'selisih'=>$selisih,
                        'keterangan'=>$keterangan[$key]
                    ]);                      
                }
            }
        } catch (\Throwable $th) {
            Log::error('Gagal IN = '.$th);
            DB::rollback();
            return $this->getError400('Gagal disimpan, Ada kesalahan.');
        }
        DB::commit();
        return $this->getSuccess200('Berhasil disimpan.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function reject($id)
    {
        $datas = Opname::where('id',$id)->where('status','New')->first();
        $datas->status = 'Rejected';
        if ($datas->update()) {
            return $this->getSuccess200('Berhasil direject.');
        }
        return $this->getSuccess200('Gagal direject.');
    }

    public function approved(Request $request, $id)
    {
        $products = $request->product;
        $fisik = $request->fisik;
        $tanggal = $request->tanggal;
        $petugas = $request->petugas;
        $gudang = $request->gudang;
        $keterangan = $request->keterangan;
        $input = $request->all();
        $validator = Validator::make($input, [
            'tanggal' => 'required',
            'petugas' => 'required',
            'gudang' => 'required'
		],[
			'tanggal.required'=>'Tanggal harus diisi.',
			'petugas.required'=>'Petugas harus dipilih.',
			'gudang.required'=>'Gudang harus dipilih.',
		]);
		if($validator->fails()){
            return $this->validasiError($validator->errors());
        }

        $length = count(array_keys($fisik,""));
        if (count($fisik) == $length) {
            return $this->getError400('Salah satu Stok Fisik harus diisi');
        }
        DB::beginTransaction();
        try {
            $datas = Opname::where('id',$id)->where('status','New')->first();
            $datas->status = 'Approved';
            $datas->update();
            foreach ($products as $key => $value) {
                if ($fisik[$key] >= 0 && $fisik[$key]!= '') {
                    $saldo_akhir = SaldoProduct::where('product_id',$value['product_id'])->where('gudang_id',$gudang)->first();
                    $selisih = (int)($fisik[$key]-$saldo_akhir->saldo);
                    if ($selisih != 0 || $selisih != '') {
                        if($keterangan[$key] == '' || $keterangan[$key] == null){
                            DB::rollback();
                            return $this->getError400('Keterangan '.$value['DetailProduct']['product_name'].' harus diisi, karena ada selisih');
    
                        }
                        $type = $selisih < 0 ? 'Out':'In';
                        Log::info('type = '.$type);
                        $mutasi = Mutasi::create([
                            'gudang_id'=>$gudang,
                            'product_id'=>$value['product_id'],
                            'created_by'=>$request->user()->id,
                            'mutasi'=>$type,
                            'jumlah'=>$selisih < 0 ? (int)($saldo_akhir->saldo - $fisik[$key]):(int)$selisih ,
                            'supplier_id'=>NULL,
                            'balance'=>$fisik[$key],
                            'keterangan'=>$keterangan[$key]." (Balancing)",
                            'balancing'=>true,
                        ]);
                        $saldo_akhir->saldo = $fisik[$key];
                        $saldo_akhir->update();
                        Log::info('fisik = '.$fisik[$key]);
                    } 
                    
                }
            }
        } catch (\Throwable $th) {
            Log::error('Gagal IN = '.$th);
            DB::rollback();
            return $this->getError400('Gagal diapprove.');
        }
        DB::commit();
        return $this->getSuccess200('Berhasil diapprove.');
    }


    public function get_product(Request $request){
        if ($request->page == 'transfer') {
            $product = SaldoProduct::select('*')
            ->join('products','saldo_products.product_id','=','products.id')
            ->join('satuans','products.satuan_id','=','satuans.id')
            ->where('gudang_id',$request->gudang_id)
            ->where('saldo','>',0)
            ->get();
        }else{
            $product = SaldoProduct::select('*')
            ->join('products','saldo_products.product_id','=','products.id')
            ->join('satuans','products.satuan_id','=','satuans.id')
            ->where('gudang_id',$request->gudang_id)->get();
        }

        return response()->json($product);
    }
    public function api(Request $request, $id){
        $datas = Opname::find($id);
        return response()->json($datas);
    }
}
