<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Tasktype extends Model
{
    protected $fillable = [
        'Task_code', 'Task_type'
    ];
}
