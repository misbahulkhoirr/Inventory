<?php

namespace App\Http\Controllers;

use App\Models\CategoryProduct;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Storage;
use App\Models\Satuan;
use App\Models\ListMutasi;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        $datas = Product::orderBy('product_code', 'ASC')->where('deleted_at', '=', NULL)->get();
        $category = CategoryProduct::where('deleted_at', '=', NULL)->get();
        $satuans = Satuan::where('deleted_at', '=', NULL)->get();
        return view('product.index', compact(['datas', 'category','satuans']));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $AWAL = 'P';

        $product = Product::max('product_code');
        if ($product) {
            $ganti = sprintf($AWAL . abs($product++));
        }
        return response()->json($product);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        $validatedData = $request->validate([
            'product_code' => 'max:255',
            'product_name' => 'required|max:255',
            'satuan_id' => 'required|max:255',
            'price' => 'required',
            'category_product_id' => 'required',

        ]);

        $add = Product::create([
            'product_code' => $request->product_code,
            'product_name' => $request->product_name,
            'satuan_id' => $request->satuan_id,
            'price' => $request->price,
            'category_product_id' => $request->category_product_id,
            'created_by' => $request->user()->id
        ]);

        $request->session()->flash('message', 'Data berhasil ditambah');
        return response()->json(['success' => true]);

        if ($validatedData()->fails()) {
            return response()->json(['errors' => $validatedData()->errors()]);
        }
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
        $where = array('id' => $id);
        $product  = Product::where($where)->first();

        return response()->json($product);
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
        $validatedData = $request->validate([
            'product_code' => 'max:255',
            'product_name' => 'required|max:255',
            'satuan_id' => 'required|max:255',
            'price' => 'required',
            'category_product_id' => 'required',
        ]);


        $add = Product::where('id', $id)->update([
            'product_code' => $request->product_code,
            'product_name' => $request->product_name,
            'satuan_id' => $request->satuan_id,
            'price' => $request->price,
            'category_product_id' => $request->category_product_id,
            'created_by' => $request->user()->id
        ]);
        $request->session()->flash('message', 'Data berhasil di Update');
        return response()->json(['success' => true]);

        if ($validatedData()->fails()) {
            return response()->json(['errors' => $validatedData()->errors()]);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, $id)
    {
        Product::where('id', $id)->first()->update(['deleted_at' => date('Y-m-d H:i:s')]);
        // Product::destroy($id)->update();
        $request->session()->flash('message', 'Data berhasil dihapus');
        return response()->json(['success' => true]);
    }
    public function invoice(Request $request){
        $data = ListMutasi::find($request->id);
        return view('invoice.index',compact('data'));
    }
}
