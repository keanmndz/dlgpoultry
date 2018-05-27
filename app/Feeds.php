<?php

namespace DLG;

use Illuminate\Database\Eloquent\Model;

class Feeds extends Model
{
    protected $fillable = array(
    	'name',
    	'price',
    	'quantity',
    	'unit',
    	'reorder_level',
    	'added_by'
    );
}
