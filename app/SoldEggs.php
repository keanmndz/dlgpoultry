<?php

namespace DLG;

use Illuminate\Database\Eloquent\Model;

class SoldEggs extends Model
{
    public $timestamps = false;

     protected $fillable = [
        'trans_id',
        'size',
        'quantity',
        'batch_no',
        'batch_id',
        'trans_date',
        'trans_time',
    ];
}
