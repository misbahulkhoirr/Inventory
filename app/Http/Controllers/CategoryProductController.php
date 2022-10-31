<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\CategoryProduct;

class CategoryProductController extends Controller
{
    public function index()
    {
        $categorys = CategoryProduct::where('deleted_at', '=', NULL)->get();
        return view('category_product.index', compact('categorys'));
    }
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

        $validatedData = $request->validate([
            'category' => 'required|max:255',
        ]);

        CategoryProduct::create($validatedData);
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
        $category  = CategoryProduct::where($where)->first();

        return response()->json($category);
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
            'category' => 'required|max:255',
        ]);


        CategoryProduct::where('id', $id)->update($validatedData);
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
        CategoryProduct::where('id', $id)->first()->update(['deleted_at' => date('Y-m-d H:i:s')]);
        $request->session()->flash('message', 'Data berhasil dihapus');
        return response()->json(['success' => true]);
    }
}
