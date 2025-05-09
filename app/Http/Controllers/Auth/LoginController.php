<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Validation\ValidationException;
use Illuminate\Http\Request;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = '/home';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    protected function authenticated(Request $request, $user)
{
    $user = auth()->user();
    session()->flash('success', 'Selamat datang ' . $user->name . ' di central tools PPA.');

    if ($user->hasRole('admin') || ($user)->hasRole('staff')) {
        return redirect()->route('admin.index');
    }

    return redirect()->route('stok_material_fabrikasi.index');
}
protected function sendFailedLoginResponse(Request $request)
{
    throw ValidationException::withMessages([
        $this->username() => ['Email atau password yang Anda masukkan salah.'],
    ]);
}

}
