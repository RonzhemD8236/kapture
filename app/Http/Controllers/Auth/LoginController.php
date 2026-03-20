<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;

class LoginController extends Controller
{
    use AuthenticatesUsers;

    public function __construct()
    {
        $this->middleware('guest')->except('logout');
        $this->middleware('web');
    }

    /**
     * Redirect based on role after login.
     */
    protected function redirectTo()
    {
        if (auth()->user()->role === 'admin') {
            return '/admin/dashboard';
        }

        return '/home';
    }
}