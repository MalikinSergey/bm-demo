<?php

namespace App\Http\Controllers\Website\User;

use App\Http\Controllers\Controller;
use Illuminate\Support\Arr;

class UserController extends Controller
{

    public function profile()
    {
        return ['status' => 'success', 'data' => ['user' => user()->only('email')]];
    }
}