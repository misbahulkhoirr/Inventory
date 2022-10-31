<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\BaseController;
use App\Models\Mutasi;
use App\Models\Gudang;
use App\Models\Product;
use App\Models\SaldoProduct;
use App\Models\Move;
use DB;
use Log;

class MoveController extends BaseController
{
    public function index(Request $request){
        $dari_gudang = $request->dari_gudang;
        $ke_gudang = $request->ke_gudang;
        $start = date('Y-m-d');
        $end = date('Y-m-d');
        if ($request->from && $request->to) {
            $start = $request->from;
            $end = $request->to;
            // $datas = Move::whereBetween('tanggal',[$start,$end])->where('dari_gudang',$dari_gudang)->where('ke_gudang',$ke_gudang)->orderBy('id','ASC')->get();
        }
        $this->cookieLoh('start',$start);
        $this->cookieLoh('end',$end);
        $datas = Move::whereBetween('tanggal',[$start,$end])->where('dari_gudang',$dari_gudang)->where('ke_gudang',$ke_gudang)->orderBy('id','ASC')->get();
        $gudangs = Gudang::where('deleted_at','=',NULL)->orderBy('name','ASC')->get();
        
        return view('move.index',compact('datas','gudangs','dari_gudang','ke_gudang'));
    }
    public function create(){
        return view('move.create');
    }
    public function store(Request $request){
        $jumlah = array_column($request->product, 'jumlah');
        if(max($jumlah) == 0)
        return response()->json([
            'code'=>400,
            'icon'=>'error',
            'title'=>'Opps...',
            'message'=>'Salah satu Jumlah Harus disi',
        ]);
        DB::beginTransaction();
        try {
            $products = $request->product;
            $gudang_dari = Gudang::find($request->gudang_dari);
            $gudang_ke = Gudang::find($request->gudang_ke);
            foreach ($products as $key => $p) {
                Log::info($p['gudang_id']);
                if ($p['jumlah'] > 0) {
                    $Move = Move::create([
                        'tanggal'=>date('Y-m-d', strtotime($request->tanggal)),
                        'product_id'=>$p['product_id'],
                        'dari_gudang'=> (int)($p['gudang_id']),
                        'ke_gudang'=>$gudang_ke['id'],
                        'amount'=>$p['jumlah']
                    ]);
                    $saldo = SaldoProduct::where('gudang_id',$p['gudang_id'])->where('product_id',$p['product_id'])->first();
                    $saldo->saldo = $saldo->saldo - $p['jumlah'];
                    $saldo->update();
                    $debet = Mutasi::create([
                        'gudang_id'=>$p['gudang_id'],
                        'product_id'=>$p['product_id'],
                        'created_by'=>$request->user()->id,
                        'mutasi'=>'Out',
                        'jumlah'=> $p['jumlah'],
                        'supplier_id'=>NULL,
                        'balance'=>(int)($saldo->saldo),
                        'keterangan'=>'Transfer ke '.$gudang_ke->name,
                        'balancing'=>true,
                    ]);
                    $balance = SaldoProduct::where('gudang_id',$request->gudang_ke)->where('product_id',$p['product_id'])->first();
                    if (!$balance) {
                        $balance = SaldoProduct::create([
                            'gudang_id'=>$request->gudang_ke,
                            'product_id'=>$p['product_id'],
                            'saldo'=>$p['jumlah'],
                        ]);
                    }else {
                        $balance->saldo = (int)($balance->saldo + $p['jumlah']);
                        $balance->update();
                    }
        
                    $kredit = Mutasi::create([
                        'gudang_id'=>$request->gudang_ke,
                        'product_id'=>$p['product_id'],
                        'created_by'=>$request->user()->id,
                        'mutasi'=>'In',
                        'jumlah'=> $p['jumlah'],
                        'supplier_id'=>NULL,
                        'balance'=>(int)($balance->saldo),
                        'keterangan'=>'Transfer dari '.$gudang_dari->name,
                        'balancing'=>true,
                    ]);
                }
                
            }
            
        } catch (\Throwable $th) {
            DB::rollback();
            Log::error('Gagal transfer : ' .$th);
            return response()->json([
                'code'=>400,
                'icon'=>'error',
                'title'=>'Opps...',
                'message'=>'Gagal Transfer'
            ]);
        }
        DB::commit();
        return response()->json([
            'code'=>200,
            'icon'=>'success',
            'title'=>'Berhasil Transfer',
            'message'=>'Berhasil Transfer'
        ]);
    }
}
