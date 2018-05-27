<?php

namespace DLG;

use Illuminate\Database\Eloquent\Model;

class Sales extends Model
{
    public $timestamps = false;
    
    protected $fillable = array(
        'id',
        'trans_id',
        'total_cost',
        'cust_email',
        'handled_by',
        'user_id',
        'order_placed',
        'trans_date',
    );
}
