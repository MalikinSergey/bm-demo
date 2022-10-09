<?php

namespace App\Http\Controllers\Website\User;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class LoginController extends Controller
{


    public function login(Request $request)
    {

        $this->validate($request, [
            'email' => 'required|email',
            'password' => 'required'
        ]);

        $credentials = $request->only(['email', 'password']);


        if (Auth::attempt($credentials, true)) {

            if(!\auth()->user()->email_verified_at){

                \auth()->logout();

                if($request->expectsJson()){
                    return ['status' => 'error', 'message' => 'Email is not verified'];
                }
                else{
                    return back()->with('login_error', 'Email is not verified')->withInput();

                }

            }

            $request->session()->regenerate();

            if($request->expectsJson()){
                return ['status' => 'success', 'data' => user()->toArray()];
            }
            else{
                return redirect()->intended(route('website.index'));
            }
        }
        else{
            if($request->expectsJson()){
                return ['status' => 'error', 'message' => 'Incorrect username or password'];
            }
            else{
                return back()->with('login_error', 'Incorrect username or password')->withInput();

            }

        }
    }

    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        if($request->expectsJson()){
            return ['status' => 'success'];
        }
        else{
            return redirect()->route('website.index');
        }

    }


}
