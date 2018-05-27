<?php

namespace DLG;

use Illuminate\Database\Eloquent\Model;

class TotalChickens extends Model
{
    protected $fillable = array(
    	'id',
    	'batch',
    	'quantity',
    	'total',
    	'updated_by'
    );
}
