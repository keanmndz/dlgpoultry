<?php

namespace DLG\Http\Controllers\Auth;

use DLG\User;
use DLG\Customers;
use DLG\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Http\Request;
use DLG\Mail\SendPassword;
use Mail;

class RegisterController extends Controller
{

    use RegistersUsers;

    public function __construct()
    {
        $this->middleware('admin');
    }

    public function create()
    {
        $this->validate(request(), [
            'fname'         => 'required|regex:/^[\pL\s\-]+$/u|max:255',
            'lname'         => 'required|regex:/^[\pL\s\-]+$/u|max:255',
            'email'         => 'required|email|max:255|unique:users',
            'mobile'        => 'required|numeric|min:11',
            'address'       => 'required|max:255',
            'access'        => 'required',
        ]);
        
        $random = str_random(10);

        $user = new User;

        $user->fname = request('fname');
        $user->lname = request('lname');
        $user->email = request('email');
        $user->password = $random;
        $user->mobile = request('mobile');
        $user->address = request('address');
        $user->access = request('access');
        $user->token = str_random(10);
        $user->remember_token = str_random(10);
        $user->last_login = 'None';

        $user->save();

        $data = [
            'fname' => request('fname'),
            'lname' => request('lname'),
            'pass' => $random
        ];

        Mail::to(request('email'))->send(new SendPassword($data));

        return redirect('admin/dash')->with('success', 'Successfully created this account! Please check your email.');

    }
}
