<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\BaseController;
use App\Models\Mutasi;
use App\Models\Gudang;
use App\Models\Product;

class MutasiController extends BaseController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        // return $request->all();
        $gudang = $request->gudang;
        $product = $request->product;
        $start = date('Y-m-d');
        $end = date('Y-m-d');
        if ($request->from && $request->to) {
            $start = $request->from;
            $end = $request->to;
        }
        $this->cookieLoh('start',$start);
        $this->cookieLoh('end',$end);
        $datas = Mutasi::whereBetween('created_at',[$start.' 00:00:01',$end.' 23:59:59'])->where('product_id',$product)->where('gudang_id',$gudang)->orderBy('id','ASC')->get();
        $gudangs = Gudang::where('deleted_at','=',NULL)->orderBy('name','ASC')->get();
        $products = Product::where('deleted_at','=',NULL)->orderBy('product_name','ASC')->get();
        return view('product.mutasi',compact('datas','gudangs','products','gudang','product'));
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
        //
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
