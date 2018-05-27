<?php

namespace DLG;

use Illuminate\Database\Eloquent\Model;

class order_list extends Model
{

	public $timestamps = false;

    public function order()
    {
    	return $this->hasOne('DLG\order','order_id');
    }
}
