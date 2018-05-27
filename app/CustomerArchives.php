<?php

namespace DLG;

use Illuminate\Database\Eloquent\Model;

class CustomerArchives extends Model
{
    public function customer()
    {
    	return $this->belongsTo('DLG\customers','cust_id');
    }
}
