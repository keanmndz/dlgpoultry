<?php

namespace DLG;

use Illuminate\Database\Eloquent\Model;

class Cull extends Model
{
    protected $fillable = array(
    	'id',
    	'batch_id',
    	'quantity',
    	'total',
    	'remarks',
    	'added_by'
    );
}
