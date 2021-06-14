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
use DateTime;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
       $user = Auth::id();
	   if ( $user == $user )
	{
		
		$pending = DB::table('tasks')
		//->join('users', 'supervisors.Supervisor_id', '=', 'users.id')
		->join('users', 'tasks.User_id', '=', 'users.id')
	    ->join('shifts', 'tasks.Task_Shift_id', '=', 'shifts.id')
		->join('tasktypes', 'tasks.Task_type_id', '=', 'tasktypes.id')
		->select('tasks.*','users.name','shifts.Task_Shift','tasktypes.Task_type')->where('User_id', '=', $user)
		->whereNull('Start_Date')->whereNull('Paused_Date')->whereNull('Resume_Date')->whereNull('Complete_Date')
		->orderBy('id', 'DESC')
         ->count();
		 
		 $progess = DB::table('tasks')
		//->join('users', 'supervisors.Supervisor_id', '=', 'users.id')
		->join('users', 'tasks.User_id', '=', 'users.id')
	    ->join('shifts', 'tasks.Task_Shift_id', '=', 'shifts.id')
		->join('tasktypes', 'tasks.Task_type_id', '=', 'tasktypes.id')
		->select('tasks.*','users.name','shifts.Task_Shift','tasktypes.Task_type')->where('User_id', '=', $user)
		->whereNotNull('Start_Date')->whereNull('Complete_Date')
		->orderBy('id', 'DESC')
         ->count();
		 
		 $verified = DB::table('tasks')
		//->join('users', 'supervisors.Supervisor_id', '=', 'users.id')
		->join('users', 'tasks.User_id', '=', 'users.id')
	    ->join('shifts', 'tasks.Task_Shift_id', '=', 'shifts.id')
		->join('tasktypes', 'tasks.Task_type_id', '=', 'tasktypes.id')
		->select('tasks.*','users.name','shifts.Task_Shift','tasktypes.Task_type')->where('User_id', '=', $user)
		->whereNotNull('Start_Date')->whereNotNull('Complete_Date')
		->orderBy('id', 'DESC')
         ->count();
		 
		 $completed = DB::table('tasks')
		//->join('users', 'supervisors.Supervisor_id', '=', 'users.id')
		->join('users', 'tasks.User_id', '=', 'users.id')
	    ->join('shifts', 'tasks.Task_Shift_id', '=', 'shifts.id')
		->join('tasktypes', 'tasks.Task_type_id', '=', 'tasktypes.id')
		->select('tasks.*','users.name','shifts.Task_Shift','tasktypes.Task_type')->where('User_id', '=', $user)
		->whereNotNull('Start_Date')->whereNotNull('Complete_Date')->whereNotNull('Verification_Task')
		->orderBy('id', 'DESC')
         ->count();
		 
		 $pendinglist = DB::table('tasks')
		//->join('users', 'supervisors.Supervisor_id', '=', 'users.id')
		->join('users', 'tasks.User_id', '=', 'users.id')
	    ->join('shifts', 'tasks.Task_Shift_id', '=', 'shifts.id')
		->join('tasktypes', 'tasks.Task_type_id', '=', 'tasktypes.id')
		->select('tasks.*','users.name','shifts.Task_Shift','tasktypes.Task_type')->where('User_id', '=', $user)
		->whereNull('Start_Date')->whereNull('Paused_Date')->whereNull('Resume_Date')->whereNull('Complete_Date')
		->orderBy('id', 'DESC')->take(5)->get();
		
		 $progesslist = DB::table('tasks')
		//->join('users', 'supervisors.Supervisor_id', '=', 'users.id')
		->join('users', 'tasks.User_id', '=', 'users.id')
	    ->join('shifts', 'tasks.Task_Shift_id', '=', 'shifts.id')
		->join('tasktypes', 'tasks.Task_type_id', '=', 'tasktypes.id')
		->select('tasks.*','users.name','shifts.Task_Shift','tasktypes.Task_type')->where('User_id', '=', $user)
		->whereNotNull('Start_Date')->whereNull('Complete_Date')
		->orderBy('id', 'DESC')->take(5)->get();
		
		 $completedlist = DB::table('tasks')
		//->join('users', 'supervisors.Supervisor_id', '=', 'users.id')
		->join('users', 'tasks.User_id', '=', 'users.id')
	    ->join('shifts', 'tasks.Task_Shift_id', '=', 'shifts.id')
		->join('tasktypes', 'tasks.Task_type_id', '=', 'tasktypes.id')
		->select('tasks.*','users.name','shifts.Task_Shift','tasktypes.Task_type')->where('User_id', '=', $user)
		->whereNotNull('Start_Date')->whereNotNull('Complete_Date')->whereNotNull('Verification_Task')
		->orderBy('id', 'DESC')->get();
		
    }
	else{
			 echo "test";
			
		}
		 return view('home',['pending' => $pending,'progess' => $progess,'verified' => $verified,'completed' => $completed,'pendinglist'=> $pendinglist,'progesslist'=>$progesslist,'completedlist'=>$completedlist]);
}
}