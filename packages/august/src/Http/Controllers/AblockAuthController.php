<?php

namespace Package\August\Http\Controllers;

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class AblockAuthController extends BaseController { 
    public function login() {
        if (Auth::check()) {
            return redirect(route('august.speed.index'));
        }

        return view('August::auth.login');
    }

    public function store(Request $request) {
        if (Auth::check()) {
            return redirect(route('august.speed.index'));
        }

        $agr = array(
            'email' => $request->input('email'),
            'password' => $request->input('password'),
        );

        if (Auth::attempt($agr, true)) {
            return redirect(route('august.speed.index'));
        } else {
            return redirect(route('august.speed.index'));
        }
    }
}