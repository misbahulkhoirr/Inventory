<?php

namespace App\Http\Controllers;

use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('users.index', [
            'users' => User::where('deleted_at', '=', NULL)->get(),
            'roles' => Role::all()
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $roles  = array('roles' => Role::all());
        return response()->json($roles);
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
            'name' => 'required|max:255',
            'username' => 'required|min:5|unique:users',
            'email' => 'required|email:dns|unique:users',
            'password' => 'required|min:6|max:255',
            'phone' => 'required|min:11|max:13',
            'role_id' => 'required'
        ]);

        // $validatedData['password'] = bcrypt($validatedData['password']);
        $validatedData['password'] = Hash::make($validatedData['password']);
        User::create($validatedData);
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
    public function edit(User $user)
    {
        $where = array('id' => $user->id);
        $users  = User::where($where)->first();

        return response()->json($users);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, User $user)
    {
        $rules = [
            'name' => 'required|max:255',
            'phone' => 'required|min:11|max:13',
            'role_id' => 'required'
        ];

        if ($request->username != $user->username) {
            $rules['username'] = ['required', 'min:5', 'unique:users'];
        }

        if ($request->email != $user->email) {
            $rules['email'] = 'required|email:dns|unique:users';
        }
        if ($request->password == true) {
            $rules['password'] = 'required|min:6|max:255';
        } else {
            $rules['password'] = '';
        }

        $validatedData = $request->validate($rules);

        $validatedData['password'] = Hash::make($validatedData['password']);
        User::where('id', $user->id)->update($validatedData);
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
    public function destroy(Request $request, User $user)
    {
        User::where('id', $user->id)->first()->update(['deleted_at' => date('Y-m-d H:i:s')]);

        $request->session()->flash('message', 'Data berhasil dihapus');
        return response()->json(['success' => true]);
    }

    public function changePasswordView()
    {
        return view('viewProfile.index', [
            'users' => User::all()
        ]);
    }

    public function changePasswordDB(Request $request)
    {
        $users = Auth::user();

        $userPassword = $users->password;

        $request->validate([
            'current_password' => 'required',
            'password' => 'required|confirmed|min:6',
        ]);

        if (Hash::check($request->current_password, $userPassword)) {
            $users->update([
                'password' => bcrypt($request->password)
            ]);
        } else {
            return redirect()->back()->with('error', 'wrong current password');
        }
        return redirect()->back()->with('success', 'password successfully updated');
    }
}
