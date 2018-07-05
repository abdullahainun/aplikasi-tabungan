<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Student extends Model
{
    public function savings() {
    	return $this->hasOne('App\Saving');
    }

    public function transactions() {
    	return $this->hasMany('App\Transaction');
    }
}
