<?php

namespace DLG;

use Illuminate\Database\Eloquent\Model;

class Products extends Model
{
    protected $fillable = array(
    	'name',
    	'price',
    	'stocks',
    	'added_by'
    );
}