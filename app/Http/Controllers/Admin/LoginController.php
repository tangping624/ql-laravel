<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use App\Extensions\Auth\Authenticates;

class LoginController extends Controller
{
    use AuthenticatesUsers, Authenticates {
        Authenticates::logout insteadof AuthenticatesUsers;
    }

    protected $guard = 'admin';
    protected $redirectTo = '/admin';


    public function __construct()
    {
        $this->middleware('guest:' . $this->guard, ['except' => 'logout']);
    }

    public function showLoginForm()
    {
        return view('admin.login');
    }

    protected function guard()
    {
        return auth()->guard($this->guard);
    }

    public function username()
    {
        return 'name';
    }
}
