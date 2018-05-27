<?php

namespace DLG;

use Illuminate\Database\Eloquent\Model;

class Supplies extends Model
{
    protected $fillable = array(
    	'name',
    	'price',
    	'quantity',
    	'reorder_level',
    	'added_by'
    );
}
