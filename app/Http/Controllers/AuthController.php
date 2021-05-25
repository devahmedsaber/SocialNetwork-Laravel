<?php

namespace App\Http\Controllers;

use Auth;
use App\Models\User;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    public function getSignUp(){
        return view('auth.signup');
    }

    public function postSignUp(Request $request){
        $this->validate($request, [
            'email' => 'required|unique:users|email|max:255',
            'username' => 'required|unique:users|alpha_dash|max:20',
            'password' => 'required|min:6'
        ]);
        
        User::create([
            'email' => $request->email,
            'username' => $request->username,
            'password' => bcrypt($request->password)
        ]);

        return redirect()->route('home')->with('info', 'Your Account Has Been Created');

    }

    public function getSignIn(){
        return view('auth.signin');
    }

    public function postSignIn(Request $request){
        $this->validate($request, [
            'email' => 'required',
            'password' => 'required'
        ]);

        if(!Auth::attempt($request->only(['email', 'password']), $request->has('remember'))){
            return redirect()->back()->with('info', 'Could Not Sign You In With Those Details.');
        }

        return redirect()->route('home')->with('info', 'You Are Now Signed In.');
    }

    public function getSignOut(){
        Auth::logout();
        return redirect()->route('home');
    }

}
