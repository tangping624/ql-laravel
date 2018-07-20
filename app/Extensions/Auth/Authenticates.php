<?php

namespace App\Extensions\Auth;

use Illuminate\Http\Request;

trait Authenticates
{
    public function logout(Request $request)
    {
        $this->guard()->logout();

        $request->session()->forget($this->guard()->getName());

        $request->session()->regenerate();

        switch ($this->guard) {
            default:
            case 'web':
                return redirect('/');
                break;
            case 'admin':
                return redirect()->route('admin.login');
                break;
        }
    }
}
