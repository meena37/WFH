<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Item extends Model
{
   protected $fillable = [
        'title', 'order', 'status','Timestamp','Task_type_id','Task_Shift_id','Task_Title',
			'Task_Details',
			'Task_QTY',
			'Time_acc_to_task',
			'To_do_Time',
			'Proposed_Date',
			'Proposed_Time',
			'Plan',
			'Start_Date',
			'Paused_Date',
			'Resume_Date',
			'Complete_Date',
			'Time_Taken',
            'Verification',
			'Partial',
			'Pending',
			'Verification_Task',
			'User_id',
			'Supervisor_id',
			'remainingtime',
    ];
}
