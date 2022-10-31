<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Gudang;
use App\Models\SaldoGudang;
use App\Models\User;
use App\Models\Supplier;
use App\Models\Product;

class GudangController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        // $datas = Gudang::orderBy('name','ASC')->get();
        // return view('gudang.index',compact('datas'));

        $gudangs = Gudang::orderBy('name', 'ASC')->where('deleted_at','=',NULL)->paginate();
        return view('gudang.index', compact('gudangs'));

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

        ]);

        $gudangs = Gudang::create([
            'name' => $request->name,
            'alamat' => $request->address,
        ]);

        return back()->with(['success' => 'Created Gudang successfully.']);
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
        $gudangs = Gudang::where('id',$id)->first();        

        return response()->json([
            'gudang' => $gudangs
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
        $request->validate([
            'name' => 'required',
            'address' => 'required',
        ]);

        $gudangs = [
            'name' => $request->name,
            'alamat' => $request->address,
        ];

        Gudang::where('id', $id)->update($gudangs);

        return back()->with(['success' => 'Updated Gudang successfully.']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Gudang::where('id', $id)->first()->update(['deleted_at'=>date('Y-m-d H:i:s')]);
        return back()->with('toast_danger','Gudang delete successfully');
    }

    public function get_api(Request $request){
        $gudang = Gudang::where('deleted_at',NULL)->get();
        $suppliers = Supplier::where('deleted_at',NULL)->get();
        $products = Product::where('deleted_at',NULL)->orderBy('product_code','ASC')->get();
        $petugas = User::where('deleted_at',NULL)->where('role_id',2)->get();

        return response()->json([
            'gudangs'=>$gudang,
            'suppliers'=>$suppliers,
            'products'=>$products,
            'petugas'=>$petugas
        ]);
    }
}
