<?php

namespace DLG;

use Illuminate\Database\Eloquent\Model;

class Chickens extends Model
{
   public $timestamps = false;

   protected $fillable = array(
    	'id',
    	'batch',
    	'quantity',
    	'total',
    	'updated_by'
    );
}
