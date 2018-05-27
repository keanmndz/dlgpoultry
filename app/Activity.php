<?php

namespace DLG;

use Illuminate\Database\Eloquent\Model;

class Activity extends Model
{
    protected $fillable = array(
    	'user_id',
    	'email',
    	'module',
    	'activity',
    	'ref_id',
    	'date_time'
    );

    public $timestamps = false;
}
