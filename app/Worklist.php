<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use DB;

class Worklist extends Model
{
     protected $fillable = [
        'Work_Period','Work_Type','Work_Nature','Work_Heading',
			'Description',
			'Quantity',
			'Minutes',
			'Estimate_Time',
			'User_id',
			'Supervisor_id',
			'Verified_head',
			'Paused',
			'Resume',
			'Complete',
			'Start_Date',
			'Paused_Date',
			'Resume_Date',
			'Complete_Date'
    ];
	
	function users() {
        return $this->hasMany('App\User');
    }
}
