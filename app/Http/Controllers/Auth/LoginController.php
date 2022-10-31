<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use App\Models\User;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::HOME;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            // 'email' => ['required', 'string', 'email', 'max:255'],
            'username' => ['required', 'string'],
            'password' => ['required', 'string', 'min:6'],
        ]);
        if ($validator->fails()) {
            $err = [
                // 'email'=>$validator->errors()->first('email'),
                'username' => $validator->errors()->first('username'),
                'password' => $validator->errors()->first('password'),
            ];
            return response()->json([
                'code' => 400,
                'title' => 'Opps..',
                'icon' => 'error',
                'error' => $err
            ]);
        }
        $remember = $request->remember ? true : false;
        $fieldType = filter_var($request->username, FILTER_VALIDATE_EMAIL) ? 'email' : 'username';
        $user = User::where($fieldType, $request->username)->first();
        if (!$user) {
            $err = [
                'username' => $fieldType.' is not registered.',
            ];
            return response()->json([
                'code' => 400,
                'title' => 'Opps..',
                'icon' => 'error',
                'error' => $err
            ]);
        }
        $credential = [
            $fieldType => $request->username,
            'password' => $request->password
        ];
        if (Auth::attempt($credential, $remember)) {
            $request->session()->regenerate();
            return response()->json([
                'code' => 200,
                'title' => 'Berhasil.',
                'icon' => 'success',
            ]);
        }
        $err = [
            'password' => 'Password wrong.',
        ];
        return response()->json([
            'code' => 400,
            'title' => 'Opps..',
            'icon' => 'error',
            'error' => $err
        ]);
    }
}
