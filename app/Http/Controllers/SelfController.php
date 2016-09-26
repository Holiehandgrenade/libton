<?php

namespace App\Http\Controllers;

use Auth;
use Illuminate\Http\Request;

use App\Http\Requests;

class SelfController extends Controller
{
    public function account()
    {
        $user = Auth::user();
        return view('users.account', compact('user'));
    }

    public function libs()
    {
        $libs = Auth::user()->libs;
        return view('users.libs', compact('libs'));
    }
}
