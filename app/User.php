<?php

namespace DLG;

use Mail\ForgotPasswordEmail;
use Mail;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Contracts\Auth\CanResetPassword;


class User extends Authenticatable
{
    use Notifiable;

    protected $table = 'users';
    
    protected $fillable = [
        'fname',
        'lname',
        'username',
        'password',
        'mobile',
        'address',
        'access',
        'token',
        'last_login',
    ];

    protected $hidden = [
        'password'
    ];
}
