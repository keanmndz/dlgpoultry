<?php

namespace DLG;

use Illuminate\Database\Eloquent\Model;

class UsersArchives extends Model
{
    public function user()
    {
    	return $this->belongsTo('DLG\User','user_id');
    }
}
