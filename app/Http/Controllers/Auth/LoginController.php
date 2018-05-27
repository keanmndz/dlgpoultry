<?php

namespace DLG\Http\Controllers\Auth;

use DLG\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use DLG\User;

class LoginController extends Controller
{

    public function __construct()
    {
        $this->middleware('guest')->except(['logout', 'loginform']);
    }

    // Login
    public function loginform()
    {
        if(Auth::check())
        {
            return redirect('admin/dash')->with('user', Auth::user());
        }

        else
        {
            return view('admin.admin');
        }
    }

    public function login(Request $request)
    {

        if(Auth::attempt(['email' => $request->email, 'password' => $request->password]))
        { 
            $user = Auth::user();

            return redirect('admin/dash')->with('user', Auth::user());
        }

        else
        {
            return redirect('admin')->withErrors('Access denied.');
        }


    }

    public function logout()
    {
        Auth::logout();
        return redirect('admin');
    }
}
