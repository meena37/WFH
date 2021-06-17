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

  class TasksController extends Controller
  {

    public function index()
    {
      global $task_status;

      $startDate = Carbon::createFromFormat('d/m/Y', date('d/m/Y'));
      $endDate = Carbon::createFromFormat('d/m/Y', '16/05/2021');

      $users = DB::table('tasks')
        ->join('users', 'tasks.User_id', '=', 'users.id')
        ->select('tasks.loss_Hour', 'users.name', 'tasks.created_at')
        ->whereDate('tasks.created_at', '=', $startDate)
        ->orderBy("loss_Hour")->pluck("loss_Hour")->take(1);

      // print_r($users);
      $date_from = date('16-05-2021');
      $date_to = date('16-05-2021');
      $loss_hours = DB::table('tasks')
        //->join('users', 'supervisors.Supervisor_id', '=', 'users.id')
        ->join('users', 'tasks.User_id', '=', 'users.id')
        ->select('tasks.*', 'users.name')->whereBetween('Timestamp', [$date_from, $date_to])
        ->get();


      $user = Auth::id();
      $auth = DB::table('supervisors')
        ->join('users', 'supervisors.Supervisor_id', '=', 'users.id')
        //->join('users', 'supervisors.User_id', '=', 'users.id')
        ->select('supervisors.Supervisor_id')->where('User_id', '=', $user)
        ->value('Supervisor_id');

      // loss  hours
      $date_from = date('16-05-2021 10:00:00');
      $date_to = date('16-05-2021 03:45:08');
      $loss_hours = DB::table('tasks')
        //->join('users', 'supervisors.Supervisor_id', '=', 'users.id')
        ->join('users', 'tasks.User_id', '=', 'users.id')
        ->select('tasks.*', 'users.name')->whereBetween('Timestamp', [$date_from, $date_to])
        ->sum('loss_Hour');

      // Assign Hour


      $assign_hour = DB::table('tasks')
        //->join('users', 'supervisors.Supervisor_id', '=', 'users.id')
        ->join('users', 'tasks.User_id', '=', 'users.id')
        ->select('tasks.*', 'users.name')
        ->sum('To_do_Time');

      // Available Hour

      $available_hour = DB::table('tasks')
        //->join('users', 'supervisors.Supervisor_id', '=', 'users.id')
        ->join('users', 'tasks.User_id', '=', 'users.id')
        ->select('tasks.*', 'users.name')->whereBetween('Timestamp', [$date_from, $date_to])
        ->sum('loss_Hour');
      $submitbtn = $available_hour + $assign_hour + $loss_hours;

      // print_r($submitbtn);

      if ($user == $user) {
        //start call task table and shift table
        $tasktype = DB::table('tasktypes')->get();
        $shift = DB::table('shifts')->get();

        // End
        $tasks = DB::table('tasks')
          //->join('users', 'supervisors.Supervisor_id', '=', 'users.id')
          ->join('users', 'tasks.User_id', '=', 'users.id')
          ->join('shifts', 'tasks.Task_Shift_id', '=', 'shifts.id')
          ->join('tasktypes', 'tasks.Task_type_id', '=', 'tasktypes.id')
          ->select('tasks.*', 'users.name', 'shifts.Task_Shift', 'tasktypes.Task_type')->where('User_id', '=', $user)->whereNull('Complete_Date')->orderBy('id', 'DESC')
          ->get();
        $pending = DB::table('tasks')
          //->join('users', 'supervisors.Supervisor_id', '=', 'users.id')
          ->join('users', 'tasks.User_id', '=', 'users.id')
          ->join('shifts', 'tasks.Task_Shift_id', '=', 'shifts.id')
          ->join('tasktypes', 'tasks.Task_type_id', '=', 'tasktypes.id')
          ->select('tasks.*', 'users.name', 'shifts.Task_Shift', 'tasktypes.Task_type')->where('User_id', '=', $user)->orderBy('id', 'DESC')
          ->get();

        $date_from = date('Y-m-d 10:00:00');
        $date_to = date('Y-m-d 18:00:00');
        // loss  hours

        $start_date = date('Y-m-d' . ' 09:00:00', time());
        $end_date = date('Y-m-d' . ' 18:00:00', time());

        $loss_hour = DB::table('tasks')
          //->join('users', 'supervisors.Supervisor_id', '=', 'users.id')
          ->join('users', 'tasks.User_id', '=', 'users.id')
          ->select('tasks.loss_Hour', 'users.name', 'tasks.created_at')
          ->where('tasks.User_id', '=', $user)
          ->whereDate('tasks.created_at', '=', $startDate)
          ->orderBy("loss_Hour")->pluck('loss_Hour')->take(1);

        /*echo '<pre>';print_r($loss_hour->first());echo '</pre>';
        echo '<pre>';print_r($loss_hour);echo '</pre>';die;*/

        // Tasks which are never started
        $rem_min = DB::table('tasks')
          ->select('Time_acc_to_task')
          ->whereNull('Complete_Date')
          //->whereNull('Start_Date')
          ->where('tasks.User_id', '=', $user)
          ->whereBetween('created_at', [$start_date, $end_date])
          ->sum("Time_acc_to_task");

        $rem_hrs = intdiv($rem_min, 60) . ':' . ($rem_min % 60) . ':00';

        $total_loss_hour = '-';
        if (!empty($loss_hour) && $rem_hrs > 0) {
          $total_loss_hour = $this->addTwoTimes($loss_hour->first(), $rem_hrs);
        }

        $loss_hours = DB::table('tasks')
          //->join('users', 'supervisors.Supervisor_id', '=', 'users.id')
          ->join('users', 'tasks.User_id', '=', 'users.id')
          ->select('tasks.loss_Hour', 'users.name', 'tasks.created_at')
          ->whereDate('tasks.created_at', '=', $startDate)
          ->orderBy("loss_Hour")->sum("loss_Hour");
        // Assign Hour


        $assign_hours = DB::table('tasks')
          //->join('users', 'supervisors.Supervisor_id', '=', 'users.id')
          ->join('users', 'tasks.User_id', '=', 'users.id')
          ->select('tasks.*', 'users.name', 'tasks.created_at')
          ->whereDate('tasks.created_at', '=', $startDate)
          ->sum('To_do_Time');
        if ($assign_hours != 0) {
          $ctime = DateTime::createFromFormat('i', $assign_hours);
          $nassigntime = $assign_hours / 60;
        } else {
          $nassigntime = 00;
        }
        $assign_hour = $assign_hours / 60;

        // Available Hour
        $minutes = $assign_hour;

        $hours = floor($minutes / 60) . ':' . ($minutes - floor($minutes / 60) * 60);
        $available_hour = 8 - $loss_hours - $assign_hour;

        //$ctimes = DateTime::createFromFormat('h', $available_hours);
        //$available_hour = $ctimes->format('H:i:s');

        $Entry_time = DB::table('tasks')
          //->join('users', 'supervisors.Supervisor_id', '=', 'users.id')
          ->join('users', 'tasks.User_id', '=', 'users.id')
          ->select('tasks.*', 'users.name', 'tasks.created_at')
          ->whereDate('tasks.created_at', '=', $startDate)
          ->sum('Entry_time');
        /*$idle = DB::table('tasks')
          //->join('users', 'supervisors.Supervisor_id', '=', 'users.id')
          ->join('users', 'tasks.User_id', '=', 'users.id')
          ->select('tasks.*', 'users.name', 'tasks.created_at')
          ->whereDate('tasks.created_at', '=', $startDate)
          ->sum('resumediff');*/

        // Idle Time
        $task_history = DB::table('task_status_history')
          ->select('task_id', 'task_status_history.from_status', 'task_status_history.to_status', 'task_status_history.created_at')
          ->join('tasks', 'tasks.id', '=', 'task_status_history.task_id')
          ->where('tasks.User_id', $user)
          ->whereBetween('task_status_history.created_at', [$start_date, $end_date])
          ->get();

        $paused_times = [];
        $resumed_times = [];
        foreach ($task_history as $item) {
          $from_status = $item->from_status;
          $to_status = $item->to_status;
          $created_at = $item->created_at;

          if ($from_status == 2 && $to_status == 3) {
            $paused_times[$item->task_id][] = $created_at;// .'---'.$item->task_id;
          } else if ($from_status == 3 && $to_status == 2) {
            $resumed_times[$item->task_id][] = $created_at;// .'---'.$item->task_id;
          }
        }

        /*echo 'Paused <pre>';print_r($paused_times);echo '</pre>';
        echo 'Resumed <pre>';print_r($resumed_times);echo '</pre>';*/

        $old_time = '';
        $idel_times = [];
        foreach ($resumed_times as $task_id => $resumed_time) {
          $count = count($resumed_time);

          for ($i = 0; $i < $count; $i++) {
            $startTime = Carbon::parse($paused_times[$task_id][$i]);
            $endTime = Carbon::parse($resumed_time[$i]);

            $time = $startTime->diff($endTime)->format('%H:%I:%S');
            $idel_times[] = $time;

            if ($i > 0) {
              $time1 = $time;
              $time2 = $old_time;

              $old_time = $this->addTwoTimes($time1, $time2);

            } else {
              $old_time = $time;
            }
          }
        }

        $idle = '-';
        foreach ($idel_times as $key => $item) {
          if ($key == 0) {
            $idle = $item;
          }
          if (isset($idel_times[$key + 1])) {
            $idle = $this->addTwoTimes($idle, $idel_times[$key + 1]);
          }
        }

        $submitbtn = $assign_hour + $loss_hours + $Entry_time;

        return view('tasks.index', ['submitbtn' => $submitbtn, 'tasks' => $tasks, 'auth' => $auth, 'loss_hour' => $total_loss_hour, 'nassigntime' => $nassigntime, 'available_hour' => $available_hour, 'Entry_time' => $Entry_time, 'idle' => $idle, 'tstatus' => $task_status, 'tasktype' => $tasktype, 'shift' => $shift]);
      } else {

        echo "test";
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
      return view('tasks.create', ['tasktype' => $tasktype, 'shift' => $shift]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
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

        $fdate = date('Y-m-d 10:00:00'),


        $tdate = $request->get('Timestamp'),
        $start = Carbon::parse($fdate),
        $end = Carbon::parse($tdate),
        $loss_Hour = $end->diff($start),
        'loss_Hour' => $loss_Hour->format('%H:%I:%S'),

        'status' => 1,
        'Timestamp' => $request->get('Timestamp'),
        'Task_type_id' => $request->get('Task_type_id'),
        'Task_Shift_id' => $request->get('Task_Shift_id'),
        'Task_Title' => $request->get('Task_Title'),
        'Task_Details' => $request->get('Task_Details'),
        'Task_QTY' => $request->get('Task_QTY'),
        'Time_acc_to_task' => $request->get('Time_acc_to_task'),
        'Proposed_Date' => $request->get('Proposed_Date'),
        'Proposed_Time' => $request->get('Proposed_Time'),
        'To_do_Time' => $request->get('Task_QTY') * $request->get('Time_acc_to_task') + 5,
        $time = $request->get('Proposed_Time'),
        $add = $request->get('Task_QTY') * $request->get('Time_acc_to_task'),
        $addMinute = Carbon::parse($add),
        $carbon_date = Carbon::parse($time),
        'Plan' => $carbon_date->addMinute($add),
        'User_id' => Auth::id(),
        'Supervisor_id' => DB::table('supervisors')
          ->join('users', 'supervisors.Supervisor_id', '=', 'users.id')
          //->join('users', 'supervisors.User_id', '=', 'users.id')
          ->select('supervisors.Supervisor_id')->where('User_id', '=', $user)
          ->value('Supervisor_id'),


      ]);

      return redirect()->route('tasks.index')
        ->with('success', 'Work created successfully.');
    }

    /**
     * Display the specified resource.
     *
     * @param \App\Product $product
     * @return \Illuminate\Http\Response
     */
    public function show(Task $task)
    {
      return view('tasks.show', compact('worklist'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param \App\Worklist $product
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request, Task $task)
    {
      global $task_status;

      $user = Auth::id();
      $auth = DB::table('supervisors')
        ->join('users', 'supervisors.Supervisor_id', '=', 'users.id')
        //->join('users', 'supervisors.User_id', '=', 'users.id')
        ->select('supervisors.Supervisor_id')
        ->value('Supervisor_id');

      $supervisor_data = DB::table('supervisors')
        ->select('supervisors.Supervisor_id')
        ->where('User_id', '=', $task->User_id)
        ->get();

      $is_supervisor = FALSE;
      if(!empty($supervisor_data)){
        foreach ($supervisor_data as $supervisor_datum) {
          if($supervisor_datum->Supervisor_id == $user){
            $is_supervisor = TRUE;
          }
        }
      }

      $vars = ['task' => $task, 'auth' => $auth, 'tstatus' => $task_status, 'is_supervisor' => $is_supervisor];
      return view('tasks.edit', $vars);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\Product $product
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Task $task)
    {
      $request_all = $request->all();
      $from_status = $task->status;
      $to_status = $request_all['status'];

      $current_date_time = Carbon::now()->toDateTimeString();

      // Changed to In progress
      if ($to_status == 2 && $request_all['Start_Date'] == '') {
        $request_all['Start_Date'] = $current_date_time;
      }

      // Changed to In Verified/Complete/Done
      if (($to_status == 4 || $to_status == 5) && $request_all['Complete_Date'] == '') {
        $request_all['Complete_Date'] = $current_date_time;
      }

      request()->validate([
        'Proposed_Date' => '',
        'Proposed_Time' => '',
        'Plan' => '',
        'User_id' => '',
        'Supervisor_id' => '',
      ]);
      $task->update($request_all);

      // Task status history
      $data = [
        'task_id' => $task->id,
        'from_status' => $from_status,
        'to_status' => $to_status,
        'created_at' => $current_date_time,
        'updated_at' => $current_date_time,
      ];

      DB::table('task_status_history')->insert($data);

      return redirect()->route('tasks.index')
        ->with('success', 'Work updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\Product $product
     * @return \Illuminate\Http\Response
     */
    public function destroy(Task $task)
    {
      $task->delete();

      return redirect()->route('tasks.index')
        ->with('success', 'Work deleted successfully');
    }

    /**
     * Add two times
     * @param string $time1
     * @param string $time2
     * @return false|string
     */
    public function addTwoTimes($time1 = "00:00:00", $time2 = "00:00:00")
    {
      $time2_arr = [];
      $time1 = $time1;
      $time2_arr = explode(":", $time2);
      //Hour
      if (isset($time2_arr[0]) && $time2_arr[0] != "") {
        $time1 = $time1 . " +" . $time2_arr[0] . " hours";
        $time1 = date("H:i:s", strtotime($time1));
      }
      //Minutes
      if (isset($time2_arr[1]) && $time2_arr[1] != "") {
        $time1 = $time1 . " +" . $time2_arr[1] . " minutes";
        $time1 = date("H:i:s", strtotime($time1));
      }
      //Seconds
      if (isset($time2_arr[2]) && $time2_arr[2] != "") {
        $time1 = $time1 . " +" . $time2_arr[2] . " seconds";
        $time1 = date("H:i:s", strtotime($time1));
      }

      return date("H:i:s", strtotime($time1));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param \App\Worklist $product
     * @return \Illuminate\Http\Response
     */
    public function supervise_task()
    {
      global $task_status;
      $user = Auth::id();

      $supervised_users = DB::table('supervisors')
        ->select('supervisors.User_id')
        ->where('Supervisor_id', '=', $user)
        ->get();

      $supervised_user_ids = [];
      if(!empty($supervised_users)){
        foreach ($supervised_users as $supervised_user) {
          $supervised_user_ids[] = $supervised_user->User_id;
        }
      }

      $tasks_data = DB::table('tasks')
        //->join('users', 'supervisors.Supervisor_id', '=', 'users.id')
        ->join('users', 'tasks.User_id', '=', 'users.id')
        ->join('shifts', 'tasks.Task_Shift_id', '=', 'shifts.id')
        ->join('tasktypes', 'tasks.Task_type_id', '=', 'tasktypes.id')
        ->select('tasks.*', 'users.name', 'shifts.Task_Shift', 'tasktypes.Task_type')
        ->where('tasks.status', 4)
        ->whereIn('User_id', $supervised_user_ids)
        ->orderBy('id', 'DESC')
        ->get();

      $vars = ['tasks' => $tasks_data, 'tstatus' => $task_status];
      return view('tasks.supervisor', $vars);
    }
  }
