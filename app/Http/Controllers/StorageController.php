<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Storage;

class StorageController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $storages = Storage::where('deleted_at', '=', NULL)->get();
        return view('storage.index', compact('storages'));
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
        $validatedData = $request->validate([
            'label' => 'required',
            'name' => 'required',
            'temperature' => 'required',
        ]);


        Storage::create($validatedData);
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
        $storage  = Storage::where($where)->first();

        return response()->json($storage);
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
            'label' => 'required',
            'name' => 'required',
            'temperature' => 'required',
        ]);


        Storage::where('id', $id)->update($validatedData);
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
        Storage::where('id', $id)->first()->update(['deleted_at' => date('Y-m-d H:i:s')]);
        // Product::destroy($id)->update();
        $request->session()->flash('message', 'Data berhasil dihapus');
        return response()->json(['success' => true]);
    }
}
