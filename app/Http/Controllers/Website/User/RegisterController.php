<?php

namespace App\Http\Controllers\Website\User;

use App\Http\Controllers\Controller;
use App\Mail\ContactFormMessage;
use App\Mail\UserEmailVerification;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Redis;

class RegisterController extends Controller
{

    public function registerForm(Request $request)
    {
        if ($request->input('from_url')) {
            session()->put('from_url', $request->input('from_url'));
        } else {
            session()->forget('from_url');
        }

        if ($request->input('from_title')) {
            session()->put('from_title', $request->input('from_title'));
        } else {
            session()->forget('from_title');
        }

        return view('website.user.register', []);
    }

    public function register(Request $request)
    {
        $this->validate($request, ['email' => 'required|email|unique:users,email', 'password' => 'required|min:6', 'agree_with_rules' => 'accepted']);

        $user = new User();

        $user->fill($request->all());

        $user->password = Hash::make($request->input('password'));

        $user->save();

        session()->put('registered', true);

        $hash = substr(md5($user->id . time()), 0, 8);

        $key = 'user_verification:' . $hash;

        Redis::set($key, $user->id);

        Redis::expire($key, 60 * 60 * 24);

        \Mail::to($user)->send(new UserEmailVerification($user, $hash));

        return redirect()->route('website.user.registered');
    }

    public function registered(Request $request)
    {
        if (!session()->pull('registered')) {
            return redirect()->route('website.index');
        }

        return view('website.user.registered', []);
    }

    public function verifyEmail(Request $request, $hash)
    {
        $userID = Redis::get('user_verification:' . $hash);

//        dd($userID);

        $user = User::find($userID);

        if ($user) {
            $user->email_verified_at = now();
            $user->save();

            Redis::del('user_verification:' . $hash);
        }

        return view('website.user.email_verified', ['user' => $user]);
    }
}
