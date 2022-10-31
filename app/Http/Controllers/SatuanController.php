<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Satuan;
use Log;

class SatuanController extends Controller
{
    public function index(){
        $satuans = Satuan::where('deleted_at',NULL)->orderBy('id','ASC')->get();
        return view('satuan.index',compact('satuans'));
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'satuan' => 'required|max:255',
        ]);

        Satuan::create([
            'satuan'=>$request->satuan
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
        $category  = Satuan::where($where)->first();

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
            'satuan' => 'required|max:255',
        ]);

        
        $update = Satuan::find($id)->update([
            'satuan'=>$request->satuan
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
        Satuan::where('id', $id)->first()->update(['deleted_at' => date('Y-m-d H:i:s')]);
        $request->session()->flash('message', 'Data berhasil dihapus');
        return response()->json(['success' => true]);
    }
}
