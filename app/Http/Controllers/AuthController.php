<?php

declare( strict_types = 1 );
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\LoginPostRequest;

class AuthController extends Controller
{
    public function index() {
        return view( 'index' );
    }
    
    public function login( LoginPostRequest $request ) {
        $datum = $request->validated();
        
        if ( Auth::attempt( $datum ) === false ) {
            return back()
                    ->withInput()
                    ->withErrors( [ 'auth' => 'Emailかパスワードに誤りがあります' ], );
        }
        
        $request->session()->regenerate();
        return redirect()->intended( '/trainning/record' );
    }
}
