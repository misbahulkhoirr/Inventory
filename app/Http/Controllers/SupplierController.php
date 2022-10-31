<?php

namespace App\Http\Controllers;

use App\Models\Supplier;
use Illuminate\Http\Request;

class SupplierController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $suppliers = Supplier::orderBy('name', 'ASC')->where('deleted_at','=',NULL)->paginate();

        return view('supplier.index', compact('suppliers'));
        // return view('supplier.index');
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
        $this->validate($request,[
            'name' => 'required|max:100',
            'address' => 'required',
            'phone' => 'required|max:30',

        ]);

        $suppliers = Supplier::create([
            'name' => $request->name,
            'alamat' => $request->address,
            'phone' => $request->phone,
        ]);

        return back()->with(['success' => 'Created supplier successfully.']);
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
        
        $suppliers = Supplier::where('id',$id)->first();        

        return response()->json([
            'supplier' => $suppliers
        ], 200);
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
        
        // $this->validate($request, [
        //     'name' => 'required,',
        //     'phone' => 'required',
        // ]);

        $request->validate([
            'name' => 'required',
            'address' => 'required',
            'phone' => 'required',
        ]);

        $suppliers = [
            'name' => $request->name,
            'alamat' => $request->address,
            'phone' => $request->phone,
        ];

        Supplier::where('id', $id)->update($suppliers);

        return back()->with(['success' => 'Updated supplier successfully.']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Supplier::where('id', $id)->first()->update(['deleted_at'=>date('Y-m-d H:i:s')]);
        return back()->with('toast_danger','Supplier delete successfully');
    }
}
