<?php

namespace DLG\Http\Controllers\Auth;

use DLG\Http\Controllers\Controller;
use DLG\Mail\ForgotPasswordEmail;
use DLG\Mail\ForgotPwUser;
use Illuminate\Http\Request;
use DLG\User;
use DLG\Customers;
use Mail;

class ForgotPasswordController extends Controller
{

	public function __construct()
	{
		$this->middleware('guest');
	}

    // FOR ADMIN

    public function requestToken()
    {
        return view('admin.requesttoken');
    }

    public function forgotPassword()
    {
        $this->validate(request(), [
            'email' => 'required|email|exists:users,email',
        ]);

        $data = User::where('email', '=', request('email'))->first();

        Mail::to(request('email'))->send(new ForgotPasswordEmail($data));

        return redirect('/admin')->with('success', 'Sent an email to ' . request('email') . '!');
    }

    public function resetPwView($token)
    {
        $user = User::where('token', '=', $token)->first();

        if (empty($user))
            return redirect('/admin/request-token')->with('wrong', 'Token is invalid!');

        else
            return view('admin.resetpw')->with('user', $user);
    }

    public function confirmReset()
    {
        $this->validate(request(), [
            'password' => 'required|confirmed|min:4',
        ]);

        $user = User::find(request('userid'));

        $user->password = bcrypt(request('password'));
        $user->token = str_random(10);

        $user->update();

        return redirect('/admin')->with('success', 'You have reset your password! You may now login.');
    }

    // FOR CUSTOMER

    public function tokenUser()
    {
        return view('enduser.requesttoken');
    }

    public function forgotUser()
    {
        $this->validate(request(), [
            'email' => 'required|email|exists:customers,email',
        ]);

        $data = Customers::where('email', '=', request('email'))->first();

        Mail::to(request('email'))->send(new ForgotPwUser($data));

        return redirect('/register')->with('success', 'Sent an email to ' . request('email') . '!');
    }

    public function resetUserPw($token)
    {
        $user = Customers::where('token', '=', $token)->first();

        if (empty($user))
            return redirect('/user/request-token')->with('wrong', 'Token is invalid!');

        else
            return view('enduser.resetpw')->with('user', $user);
    }

    public function confirmUser()
    {
        $this->validate(request(), [
            'password' => 'required|confirmed|min:4',
        ]);

        $user = Customers::find(request('userid'));

        $user->password = bcrypt(request('password'));
        $user->token = str_random(10);

        $user->update();

        return redirect('/register')->with('success', 'You have reset your password! You may now login.');
    }

}
