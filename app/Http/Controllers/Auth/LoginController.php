<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class LoginController extends Controller
{
    use AuthenticatesUsers;

    protected $redirectTo = '/customer/home';

    public function __construct()
    {
        $this->middleware('guest')->except('logout');
        $this->middleware('web');
    }

    /**
     * Check is_active AND redirect based on role after login.
     */
    protected function authenticated(Request $request, $user)
    {
        if (!$user->is_active) {
            $this->guard()->logout();
            $request->session()->invalidate();
            $request->session()->regenerateToken();

            throw ValidationException::withMessages([
                'email' => 'Your account has been deactivated. Please contact support.',
            ]);
        }

        if ($user->role === 'admin') {
            return redirect('/admin/dashboard');
        }

        return redirect('/customer/home');
    }
}