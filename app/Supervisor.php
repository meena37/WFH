<?php

namespace App;
use DB;
use Illuminate\Database\Eloquent\Model;
use Eloquent;

 

class Supervisor extends Model
{

	 protected $fillable = [
        'Supervisor_id', 'User_id'
    ];
	
	protected $table = 'supervisors';

   

    
}
