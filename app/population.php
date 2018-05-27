<?php

namespace DLG;

use Illuminate\Database\Eloquent\Model;

class population extends Model
{
	protected $table='chickens';
    public $timestamps = false;

    public function user()
    {
    	return $this->belongsTo('DLG\user','id');
    }
}
