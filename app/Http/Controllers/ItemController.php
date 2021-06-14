<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Item;
use App\Worklist;
use App\Task;
use App\Tasktype;
use App\Shift;
use Auth;
use DB;
use Carbon\Carbon;

class ItemController extends Controller
{

    public function index()
    {$startDate = Carbon::createFromFormat('d/m/Y', date('d/m/Y'));
        $endDate = Carbon::createFromFormat('d/m/Y', '16/05/2021');
  
        $users = DB::table('items')
			
		->join('users', 'items.User_id', '=', 'users.id')
			->select('items.loss_Hour','users.name','items.created_at')
                        ->whereDate('items.created_at', '=', $startDate)
              
                        
       ->orderBy("loss_Hour")->pluck("loss_Hour")->take(1);
  
       // print_r($users);
		$date_from= date('16-05-2021');
		$date_to= date('16-05-2021');
		$loss_hours = DB::table('items')
			//->join('users', 'supervisors.Supervisor_id', '=', 'users.id')
		->join('users', 'items.User_id', '=', 'users.id')
	 
		->select('items.*','users.name')->whereBetween('Timestamp',[$date_from,$date_to])
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
		$loss_hours = DB::table('items')
			//->join('users', 'supervisors.Supervisor_id', '=', 'users.id')
		->join('users', 'items.User_id', '=', 'users.id')
	 
		->select('items.*','users.name')->whereBetween('Timestamp',[$date_from,$date_to])
        ->sum('loss_Hour');
		
		// Assign Hour
		
		
		$assign_hour = DB::table('items')
		//->join('users', 'supervisors.Supervisor_id', '=', 'users.id')
		->join('users', 'items.User_id', '=', 'users.id')
	 
		->select('items.*','users.name')
        ->sum('To_do_Time');
		
		// Available Hour
		
		$available_hour = DB::table('items')
		//->join('users', 'supervisors.Supervisor_id', '=', 'users.id')
		->join('users', 'items.User_id', '=', 'users.id')
	 
		->select('items.*','users.name')->whereBetween('Timestamp', [$date_from, $date_to])
        ->sum('loss_Hour');
		$submitbtn =$available_hour + $assign_hour +$loss_hours;
		 
		 print_r($submitbtn);
		
		if ( $user == $user )
	{
		
		$tasks = DB::table('items')
		//->join('users', 'supervisors.Supervisor_id', '=', 'users.id')
		->join('users', 'items.User_id', '=', 'users.id')
	    ->join('shifts', 'items.Task_Shift_id', '=', 'shifts.id')
		->join('tasktypes', 'items.Task_type_id', '=', 'tasktypes.id')
		->select('items.*','users.name','shifts.Task_Shift','tasktypes.Task_type')->where('User_id', '=', $user)->where('status',0)->orderBy('order')->get();
		
		 $date_from= date('Y-m-d 10:00:00');
	$date_to= date('Y-m-d 18:00:00');
	// loss  hours
		
		$loss_hour = DB::table('items')
			//->join('users', 'supervisors.Supervisor_id', '=', 'users.id')
		->join('users', 'items.User_id', '=', 'users.id')
	   
		->select('items.loss_Hour','users.name','items.created_at')
                        ->whereDate('items.created_at', '=', $startDate)
                        
          ->orderBy("loss_Hour")->sum("loss_Hour");
		 
		 $loss_hours= $loss_hour;
		// Assign Hour
		
		
		$assign_hours = DB::table('items')
		//->join('users', 'supervisors.Supervisor_id', '=', 'users.id')
		->join('users', 'items.User_id', '=', 'users.id')
	 
		->select('items.*','users.name','items.created_at')
                        ->whereDate('items.created_at', '=', $startDate)
                        
        ->sum('To_do_Time');
		$assign_hour= $assign_hours/60; 
		// Available Hour
		$minutes=$assign_hour;

$hours = floor($minutes / 60).':'.($minutes -   floor($minutes / 60) * 60);

		$available_hour = 8 - $loss_hours - $assign_hour;
		
		$Entry_time = DB::table('items')
		//->join('users', 'supervisors.Supervisor_id', '=', 'users.id')
		->join('users', 'items.User_id', '=', 'users.id')
	  
		->select('items.*','users.name','items.created_at')
                        ->whereDate('items.created_at', '=', $startDate)
                        
        ->sum('Entry_time');
		 
		 $submitbtn =  $assign_hour + $loss_hours + $Entry_time;
		 
    	$panddingItem = DB::table('items')
		//->join('users', 'supervisors.Supervisor_id', '=', 'users.id')
		->join('users', 'items.User_id', '=', 'users.id')
	    ->join('shifts', 'items.Task_Shift_id', '=', 'shifts.id')
		->join('tasktypes', 'items.Task_type_id', '=', 'tasktypes.id')
		->select('items.*','users.name','shifts.Task_Shift','tasktypes.Task_type')->where('User_id', '=', $user)->where('status',0)->orderBy('order')->get();
		
    	$completeItem = Item::where('status',1)->orderBy('order')->get();

    	return view('tasklist.index',compact('panddingItem','completeItem','submitbtn' ,'tasks' ,'auth' ,'loss_hours','assign_hour' ,'available_hour' ,'Entry_time'));
    }
 }
   
public function create()
    {
        $tasktype = DB::table('tasktypes')->get();
		$shift = DB::table('shifts')->get();
		return view('tasklist.create',['tasktype' => $tasktype,'shift' => $shift]);
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
        $tasks = Item::create([
		
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
    
        return redirect()->route('tasklist.index')
                        ->with('success','Work created successfully.');
    }
    
    /**
     * Display the specified resource.
     *
     * @param  \App\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function show(Item $item)
    {
        return view('tasklist.show',compact('worklist'));
    }
    
    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Worklist  $product
     * @return \Illuminate\Http\Response
     */
    public function edit(Item $item)
    {  $user = Auth::id();
        $auth =  DB::table('supervisors')
		->join('users', 'supervisors.Supervisor_id', '=', 'users.id')
     //->join('users', 'supervisors.User_id', '=', 'users.id')
		->select('supervisors.Supervisor_id')
         ->value('Supervisor_id');
		 return view('tasklist.edit',['item' => $item,'auth' => $auth]);
    }
    
    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Item $item)
    {
         request()->validate([
            
			 'Proposed_Date' => '',
			 'Proposed_Time' => '',
			 'Plan' => '',
			 'User_id' => '',
			 'Supervisor_id' => '',
        ]);
     $item->update($request->all());
       
        return redirect()->route('tasklist.index')
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
    public function destroy(Item $item)
    {
        $item->delete();
    
        return redirect()->route('tasklist.index')
                        ->with('success','Work deleted successfully');
    }
}