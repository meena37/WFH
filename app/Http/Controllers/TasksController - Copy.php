<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Worklist;
use App\Task;
use App\Tasktype;
use App\Shift;
use Auth;
use DB;
use Carbon\Carbon;


class TasksController extends Controller
{
    public function index()
    {
		$startDate = Carbon::createFromFormat('d/m/Y', date('d/m/Y'));
        $endDate = Carbon::createFromFormat('d/m/Y', '16/05/2021');
  
        $users = DB::table('tasks')
			
		->join('users', 'tasks.User_id', '=', 'users.id')
			->select('tasks.loss_Hour','users.name','tasks.created_at')
                        ->whereDate('tasks.created_at', '=', $startDate)
              
                        
       ->orderBy("loss_Hour")->pluck("loss_Hour")->take(1);
  
        print_r($users);
		$date_from= date('16-05-2021');
		$date_to= date('16-05-2021');
		$loss_hours = DB::table('tasks')
			//->join('users', 'supervisors.Supervisor_id', '=', 'users.id')
		->join('users', 'tasks.User_id', '=', 'users.id')
	 
		->select('tasks.*','users.name')->whereBetween('Timestamp',[$date_from,$date_to])
        ->get();
		

			$user = Auth::id();
		$auth =  DB::table('supervisors')
		->join('users', 'supervisors.Supervisor_id', '=', 'users.id')
     //->join('users', 'supervisors.User_id', '=', 'users.id')
		->select('supervisors.Supervisor_id')->where('User_id', '=', $user)
         ->value('Supervisor_id');
	
		// loss  hours
		$date_from= date('16-05-2021 10:00:00');
		$date_to= date('16-05-2021 03:45:08');
		$loss_hours = DB::table('tasks')
			//->join('users', 'supervisors.Supervisor_id', '=', 'users.id')
		->join('users', 'tasks.User_id', '=', 'users.id')
	 
		->select('tasks.*','users.name')->whereBetween('Timestamp',[$date_from,$date_to])
        ->sum('loss_Hour');
		
		// Assign Hour
		
		
		$assign_hour = DB::table('tasks')
		//->join('users', 'supervisors.Supervisor_id', '=', 'users.id')
		->join('users', 'tasks.User_id', '=', 'users.id')
	 
		->select('tasks.*','users.name')
        ->sum('To_do_Time');
		
		// Available Hour
		
		$available_hour = DB::table('tasks')
		//->join('users', 'supervisors.Supervisor_id', '=', 'users.id')
		->join('users', 'tasks.User_id', '=', 'users.id')
	 
		->select('tasks.*','users.name')->whereBetween('Timestamp', [$date_from, $date_to])
        ->sum('loss_Hour');
		
		
		if ( $user == $user )
	{
		
		$tasks = DB::table('tasks')
		//->join('users', 'supervisors.Supervisor_id', '=', 'users.id')
		->join('users', 'tasks.User_id', '=', 'users.id')
	    ->join('shifts', 'tasks.Task_Shift_id', '=', 'shifts.id')
		->join('tasktypes', 'tasks.Task_type_id', '=', 'tasktypes.id')
		->select('tasks.*','users.name','shifts.Task_Shift','tasktypes.Task_type')->where('User_id', '=', $user)->orderBy('id', 'DESC')
         ->get();
		 $panddingItem = Item::where('status',0)->orderBy('order')->get();
		 $date_from= date('Y-m-d 10:00:00');
	$date_to= date('Y-m-d 18:00:00');
	// loss  hours
		
		$loss_hour = DB::table('tasks')
			//->join('users', 'supervisors.Supervisor_id', '=', 'users.id')
		->join('users', 'tasks.User_id', '=', 'users.id')
	   
		->select('tasks.loss_Hour','users.name','tasks.created_at')
                        ->whereDate('tasks.created_at', '=', $startDate)
                        
          ->orderBy("loss_Hour")->pluck("loss_Hour")->take(1);
		 
		 $loss_hours= $loss_hour;
		// Assign Hour
		
		
		$assign_hours = DB::table('tasks')
		//->join('users', 'supervisors.Supervisor_id', '=', 'users.id')
		->join('users', 'tasks.User_id', '=', 'users.id')
	 
		->select('tasks.*','users.name','tasks.created_at')
                        ->whereDate('tasks.created_at', '=', $startDate)
                        
        ->sum('To_do_Time');
		$assign_hour= $assign_hours/60; 
		// Available Hour
		$minutes=$assign_hour;

$hours = floor($minutes / 60).':'.($minutes -   floor($minutes / 60) * 60);

		$available_hour = 8  - $assign_hour;
		
		$Entry_time = DB::table('tasks')
		//->join('users', 'supervisors.Supervisor_id', '=', 'users.id')
		->join('users', 'tasks.User_id', '=', 'users.id')
	  
		->select('tasks.*','users.name','tasks.created_at')
                        ->whereDate('tasks.created_at', '=', $startDate)
                        
        ->sum('Entry_time');
		 
		  return view('tasks.index',['panddingItem' => $panddingItem,'tasks' => $tasks,'auth' => $auth,'loss_hours' => $loss_hours,'assign_hour' => $assign_hour,'available_hour' => $available_hour,'Entry_time' => $Entry_time]);
		}
		else{
			
			echo"test";
		}
				
    }
    
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $tasktype = DB::table('tasktypes')->get();
		$shift = DB::table('shifts')->get();
		return view('tasks.create',['tasktype' => $tasktype,'shift' => $shift]);
    }
    
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        request()->validate([
            'loss_Hour' => '',
            'Timestamp' => 'required',
			 'Task_type_id' => 'required',
            'Task_Shift_id' => 'required',
			 'Task_Title' => 'required',
            'Task_Details' => 'required',
			 'Task_QTY' => 'required',
			 'Time_acc_to_task' => 'required',
			 'To_do_Time' => '',
			 'Proposed_Date' => '',
			 'Proposed_Time' => '',
			 'Plan' => '',
			 'User_id' => '',
			 'Supervisor_id' => '',
             
			
        ]);
    $user = Auth::id();
        $tasks = Task::create([
		
		$fdate=date('Y-m-d 10:00:00'),
        $tdate=$request->get('Timestamp'),

        $start = Carbon::parse($fdate),
        $end =  Carbon::parse($tdate),
$loss_Hour = $end->diff($start),
		'loss_Hour' =>$loss_Hour->format('%H:%I:%S'),
         'Timestamp' => $request->get('Timestamp'),
        'Task_type_id' => $request->get('Task_type_id'),
        'Task_Shift_id' => $request->get('Task_Shift_id'),
        'Task_Title' => $request->get('Task_Title'),
        'Task_Details' => $request->get('Task_Details'),
        'Task_QTY' => $request->get('Task_QTY'),
        'Time_acc_to_task' => $request->get('Time_acc_to_task'),
        'Proposed_Time' => $request->get('Proposed_Time'),
		'To_do_Time' => $request->get('Task_QTY')*$request->get('Time_acc_to_task'),
		$time =$request->get('Proposed_Time'),
		$add =  $request->get('Task_QTY')*$request->get('Time_acc_to_task'),
		$addMinute =Carbon::parse($add),
		$carbon_date = Carbon::parse($time),
       'Plan' =>$carbon_date->addMinute($add),
       'User_id' => Auth::id(),
		'Supervisor_id'=> DB::table('supervisors')
		->join('users', 'supervisors.Supervisor_id', '=', 'users.id')
     //->join('users', 'supervisors.User_id', '=', 'users.id')
		->select('supervisors.Supervisor_id')->where('User_id', '=', $user)
         ->value('Supervisor_id'),
		
		
 ]);
    
        return redirect()->route('tasks.index')
                        ->with('success','Work created successfully.');
    }
    
    /**
     * Display the specified resource.
     *
     * @param  \App\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function show(Task $task)
    {
        return view('tasks.show',compact('worklist'));
    }
    
    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Worklist  $product
     * @return \Illuminate\Http\Response
     */
    public function edit(Task $task)
    {  $user = Auth::id();
        $auth =  DB::table('supervisors')
		->join('users', 'supervisors.Supervisor_id', '=', 'users.id')
     //->join('users', 'supervisors.User_id', '=', 'users.id')
		->select('supervisors.Supervisor_id')
         ->value('Supervisor_id');
		 return view('tasks.edit',['task' => $task,'auth' => $auth]);
    }
    
    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Task $task)
    {
         request()->validate([
            
			 'Proposed_Date' => '',
			 'Proposed_Time' => '',
			 'Plan' => '',
			 'User_id' => '',
			 'Supervisor_id' => '',
        ]);
     $task->update($request->all());
       
        return redirect()->route('tasks.index')
                        ->with('success','Work updated successfully');
    }
     public function updateItems(Request $request)
    {
    	$input = $request->all();

    	foreach ($input['panddingArr'] as $key => $value) {
    		$key = $key+1;
    		Item::where('id',$value)->update(['status'=>0,'order'=>$key]);
    	}

    	foreach ($input['completeArr'] as $key => $value) {
    		$key = $key+1;
    		Item::where('id',$value)->update(['status'=>1,'order'=>$key]);
    	}

    	return response()->json(['status'=>'success']);
    }
    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function destroy(Task $task)
    {
        $task->delete();
    
        return redirect()->route('tasks.index')
                        ->with('success','Work deleted successfully');
    }
}
