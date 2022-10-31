<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Mutasi;
use App\Models\SaldoProduct;
use App\Models\Opname;

use Log;
class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        // $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $in = Mutasi::where('balancing',false)->where('mutasi','In')->sum('jumlah');
        $out = Mutasi::where('balancing',false)->where('mutasi','Out')->sum('jumlah');
        $stok = SaldoProduct::sum('saldo');
        $opname = Opname::where('status','Approved')->count();
        return view('home',compact('in','out','stok','opname'));
    }
    public function grafik_api(){
        $in = Mutasi::where('balancing',false)->where('mutasi','In')->get();
        $tahun = date('Y');
        $bulans = ['01','02','03','04','05','06','07','08','09','10','11','12'];
        $dataIn = [];
        $dataOut = [];
        $opnameApproved = [];
        foreach ($bulans as $key => $value) {
            $awal = date('Y-m-d H:i:s', strtotime($tahun.'-'.$value.'-01 00:00:01'));
            $akhir = date('Y-m-d H:i:s', strtotime($tahun.'-'.$value.'-31 23:59:59'));
            $dataIn[] = Mutasi::where('balancing',false)->where('mutasi','In')->whereBetween('created_at',[$awal,$akhir])->sum('jumlah');
            $dataOut[] = Mutasi::where('balancing',false)->where('mutasi','Out')->whereBetween('created_at',[$awal,$akhir])->sum('jumlah');
            $opnameApproved[]= Opname::whereBetween('created_at',[$awal,$akhir])->where('status','Approved')->count();
        }
        $datas = [
            [
                'name'=>'Product In',
                'data'=> $dataIn
            ],
            [
                'name'=>'Product Out',
                'data'=> $dataOut
            ],
            [
                'name'=>'Opname Approved',
                'data'=> $opnameApproved
            ]
        ];
        return response()->json($datas);
    }
}
