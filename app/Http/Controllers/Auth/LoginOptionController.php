<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class LoginOptionController extends Controller
{
    public function loginOption(Request $request) {
        $request->validate([
            "phone" => "required|min:7|max:11"
        ]);
        return view('auth.login-option');
    }
}
