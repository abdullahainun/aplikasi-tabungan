<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    public function student() {
    	return $this->belongsTo('App\Student', 'student_id');
    }

    public function savings() {
    	return $this->belongsTo('App\Saving', 'saving_id');
    }
}
