<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class BaseController extends Controller
{
    public function cookieLoh($key, $value){
        unset ($_COOKIE[$key]);
        setcookie($key, $value, time() + (7200 * 30), "/");
    }
    public function validasiError($errorMessages = [], $code = 400)
    {
        $response = [
            'code'=>$code,
            'title'=>'Gagal',
            'icon'=>'error',
            'message'=>$errorMessages->first()
        ];
        return response()->json($response);
    }
    public function getError400($message){
        return response()->json([
            'code'=>400,
            'title'=>'Opps..',
            'message'=>$message,
            'icon'=>'error'
        ]);
    }
    public function getSuccess200($message){
        return response()->json([
            'code'=>200,
            'title'=>'Success',
            'message'=>$message,
            'icon'=>'success'
        ]);
    }
}
