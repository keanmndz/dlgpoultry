<?php

namespace DLG;

use Illuminate\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Auth\Passwords\CanResetPassword;
use Illuminate\Foundation\Auth\Access\Authorizable;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\Access\Authorizable as AuthorizableContract;
use Illuminate\Contracts\Auth\CanResetPassword as CanResetPasswordContract;

class customers extends Model implements
AuthenticatableContract,
AuthorizableContract,
CanResetPasswordContract
{
   	use Authenticatable, Authorizable, CanResetPassword;


    protected $table = 'customers';
    
    protected $fillable = [
        'lname',
        'fname',
        'mname',
        'email',
        'password',
        'company',
        'address',
        'contact',
        'type',
        'remember_token',
        'created_at',
        'updated_at',
    ];

    protected $hidden = [
        'password',
    ];
}