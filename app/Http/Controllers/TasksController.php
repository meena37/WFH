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
  use Illuminate\Support\Facades\Mail;

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


      $user = Auth::id();//start call task table and shift table
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
          ->orderBy("loss_Hour")->pluck('loss_Hour')->take(1)->first();

        /*echo '<pre>';print_r($loss_hour->first());echo '</pre>';
        echo '<pre>';print_r($loss_hour);echo '</pre>';die;*/

        // Tasks which are never started
        $rem_min = DB::table('tasks')
          ->select('Time_acc_to_task')
          ->whereNull('Complete_Date')
          ->whereNull('Start_Date')
          ->where('tasks.User_id', '=', $user)
          ->whereBetween('created_at', [$start_date, $end_date])
          ->sum("Time_acc_to_task");

        $rem_hrs = intdiv($rem_min, 60) . ':' . ($rem_min % 60) . ':00';

        $total_loss_hour = '-';
        if ($loss_hour != '') {
          $total_loss_hour = $loss_hour;
          if ($rem_hrs != '') {
            $total_loss_hour = $this->addTwoTimes($loss_hour, $rem_hrs);
          }

          // Check if total loss hour is greater than 8hrs
          $tmp = explode(':', $total_loss_hour);
          if (count($tmp) == 3) {
            if ($tmp[0] >= 8) {
              $tmp[0] = '08';
              $tmp[1] = '00';
              $tmp[2] = '00';
              $total_loss_hour = implode(':', $tmp);;
            }
          }
        }

        $loss_hours = DB::table('tasks')
          //->join('users', 'supervisors.Supervisor_id', '=', 'users.id')
          ->join('users', 'tasks.User_id', '=', 'users.id')
          ->select('tasks.loss_Hour', 'users.name', 'tasks.created_at')->where('User_id', '=', $user)
          ->whereDate('tasks.created_at', '=', $startDate)
          ->orderBy("loss_Hour")->sum("loss_Hour");
        // Assign Hour


        $assign_hours = DB::table('tasks')
          //->join('users', 'supervisors.Supervisor_id', '=', 'users.id')
          ->join('users', 'tasks.User_id', '=', 'users.id')
          ->select('tasks.*', 'users.name', 'tasks.created_at')->where('User_id', '=', $user)
          ->whereDate('tasks.created_at', '=', $startDate)
          ->sum('To_do_Time');
        if ($assign_hours != 0) {
          $ctime = DateTime::createFromFormat('i', $assign_hours);
          $nassigntime = intdiv($assign_hours, 60) . ':' . ($assign_hours % 60) . ':00';
        } else {
          $nassigntime = intdiv(0, 60) . ':' . (0 % 60) . ':00';
        }
        $assign_hour = $assign_hours;

        // Available Hour
        $minutes = $assign_hour;

        $hours = floor($minutes / 60) . ':' . ($minutes - floor($minutes / 60) * 60);
        $available_hours = 480 - $loss_hours - $assign_hour;
        $available_total = $loss_hours + $assign_hour;

        if ($available_total >= 0 && $available_hours >= 0) {
          $available_hour = intdiv($available_hours, 60) . ':' . ($available_hours % 60) . ':00';
        } else {
          $available_hour = intdiv(0, 60) . ':' . (0 % 60) . ':00';
        }

        //$ctimes = DateTime::createFromFormat('h', $available_hours);
        //$available_hour = $ctimes->format('H:i:s');

        $Entry_time = DB::table('tasks')
          //->join('users', 'supervisors.Supervisor_id', '=', 'users.id')
          ->join('users', 'tasks.User_id', '=', 'users.id')
          ->select('tasks.*', 'users.name', 'tasks.created_at')->where('User_id', '=', $user)
          ->whereDate('tasks.created_at', '=', $startDate)
          ->sum('Entry_time');
        /*$idle = DB::table('tasks')
          //->join('users', 'supervisors.Supervisor_id', '=', 'users.id')
          ->join('users', 'tasks.User_id', '=', 'users.id')
          ->select('tasks.*', 'users.name', 'tasks.created_at')
          ->whereDate('tasks.created_at', '=', $startDate)
          ->sum('resumediff');*/

        $submitbtn = $assign_hour + $loss_hours + $Entry_time;

        // Idle Time
        $startTime = Carbon::parse($date_from);
        $endTime = Carbon::now()->toDateTimeString();


        $passed_time = $startTime->diff($endTime)->format('%H:%I:%S');
        $work_done = self::task_time_taken(0, TRUE);

        /*echo '<pre>';print_r($passed_time);echo '</pre>';
        echo '<pre>';print_r($work_done);echo '</pre>';die;*/


        $idle = '-';
        if ($date_from < $endTime) {
          if ($work_done != '-') {
            $passed_time_time = Carbon::parse($passed_time);
            $idle = $passed_time_time->diff($work_done)->format('%H:%I:%S');
          } else {
            $idle = $passed_time;
          }
        }

        ///echo '<pre>';print_r(self::task_time_taken(70));echo '</pre>';die;

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
        ->with('success', 'Task created successfully.');
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

      $tasktype = DB::table('tasktypes')->get();
      $shift = DB::table('shifts')->get();

      $vars = ['task' => $task, 'auth' => $auth, 'tasktype' => $tasktype, 'shift' => $shift];
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


      $request_all = $request->all();
      $request_all['To_do_Time'] = $request_all['Task_QTY'] * $request_all['Time_acc_to_task'] + 5;
      $task->update($request_all);

      return redirect()->route('tasks.index')
        ->with('success', 'Task updated successfully');
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

      DB::table('task_status_history')->where('task_id', '=', $task->id)->delete();

      return redirect()->route('tasks.index')
        ->with('success', 'Task deleted successfully');
    }

    /**
     * Add two times
     * @param string $time1
     * @param string $time2
     * @return false|string
     */
    public static function addTwoTimes($time1 = "00:00:00", $time2 = "00:00:00")
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
      if (!empty($supervised_users)) {
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

    /**
     * Send email to supervisor
     *
     * @param \App\Worklist $product
     * @return \Illuminate\Http\Response
     */
    public function supervisor_mail($task)
    {
      $task_user = $task->User_id;

      /*$receiver_data = DB::table('users')
        ->select('users.name', 'users.email')
        ->where('id', '=', $task_user);*/

      $supervisor_data = DB::table('supervisors')
        ->join('users', 'supervisors.Supervisor_id', '=', 'users.id')
        ->select('users.id', 'users.name', 'users.email')
        ->where('User_id', '=', $task_user)
        ->get();

      if (!empty($supervisor_data)) {
        foreach ($supervisor_data as $supervisor_datum) {
          $to_name = $supervisor_datum->name;
          $to_email = $supervisor_datum->email;
          $subject = 'A task is ready to be verified';

          $task_url = url('tasks/' . $task->id . '/edit');

          $data = [
            'receiver_name' => $to_name,
            'task_url' => $task_url,
          ];

          Mail::send('emails.supervisor', $data, function ($message) use ($to_name, $to_email, $subject) {
            $message->to($to_email, $to_name)
              ->subject($subject);
            $message->from("hatwhite598@gmail.com", 'WFH Notification');
          });
        }
      }
    }

    /**
     * @param $task_id
     */
    public static function task_time_taken($task_id, $is_all_task = FALSE)
    {
      $time_taken = '-';

      if ($is_all_task) {

        $date_from = date('Y-m-d 10:00:00');
        $date_to = date('Y-m-d 18:00:00');

        $task_history = DB::table('task_status_history')
          ->select('task_status_history.from_status', 'task_status_history.to_status', 'task_status_history.created_at', 'tasks.Start_Date')
          ->join('tasks', 'tasks.id', '=', 'task_status_history.task_id')
          ->whereBetween('tasks.created_at', [$date_from, $date_to])
          ->get();

      } else {

        $task_history = DB::table('task_status_history')
          ->select('task_status_history.from_status', 'task_status_history.to_status', 'task_status_history.created_at', 'tasks.Start_Date')
          ->join('tasks', 'tasks.id', '=', 'task_status_history.task_id')
          ->where('task_status_history.task_id', $task_id)
          ->get();
      }

      $paused_times = [];
      $resumed_times = [];
      $task_start_time = '';
      $task_end_time = '';
      foreach ($task_history as $item) {
        $from_status = $item->from_status;
        $to_status = $item->to_status;
        $created_at = $item->created_at;
        $task_start_time = $item->Start_Date;


        if ($from_status == 2 && $to_status == 3) {
          $paused_times[$task_id][] = $created_at;// .'---'.$item->task_id;
        } else if ($from_status == 3 && $to_status == 2) {
          $resumed_times[$task_id][] = $created_at;// .'---'.$item->task_id;
        } else if ($from_status == 1 && $to_status == 2) {
          $task_start_time = $created_at;
        } else if ($to_status == 4) {
          $task_end_time = $created_at;
        }
      }

      if ($task_end_time != '') {
        $idel_times = [];
        foreach ($resumed_times as $tsk_id => $resumed_time) {
          $count = count($resumed_time);

          for ($i = 0; $i < $count; $i++) {
            $startTime = Carbon::parse($paused_times[$tsk_id][$i]);
            $endTime = Carbon::parse($resumed_time[$i]);

            $time = $startTime->diff($endTime)->format('%H:%I:%S');
            $idel_times[] = $time;
          }
        }

        $idle = '-';
        if (!empty($idel_times)) {
          foreach ($idel_times as $key => $item) {
            if ($key == 0) {
              $idle = $item;
            }
            if (isset($idel_times[$key + 1])) {
              $idle = self::addTwoTimes($idle, $idel_times[$key + 1]);
            }
          }


          $startTime = Carbon::parse($task_start_time);
          $endTime = Carbon::parse($task_end_time);

          $total_time = $startTime->diff($endTime)->format('%H:%I:%S');

          $time1 = new DateTime($total_time);
          $time2 = new DateTime($idle);
          $interval = $time1->diff($time2);
          $time_taken = $interval->format('%H:%I:%S');
        } else {
          $startTime = Carbon::parse($task_start_time);
          $endTime = Carbon::parse($task_end_time);

          $time_taken = $startTime->diff($endTime)->format('%H:%I:%S');
        }

        /*echo '<pre>';print_r($total_time);echo '</pre>';
        echo '<pre>';print_r($idle);echo '</pre>';
        echo '<pre>';print_r($time_taken);echo '</pre>';die;*/
      }

      return $time_taken;
    }

    /**
     * Task status change
     *
     * @param \App\Worklist $product
     * @return \Illuminate\Http\Response
     */
    public function task_status_form($task_id)
    {
      if (!is_numeric($task_id)) {
        return view("404");
      }
      global $task_status;

      $task = DB::table('tasks')
        ->select('*')
        ->where('id', '=', $task_id)
        ->first();

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
      if (!empty($supervisor_data)) {
        foreach ($supervisor_data as $supervisor_datum) {
          if ($supervisor_datum->Supervisor_id == $user) {
            $is_supervisor = TRUE;
          }
        }
      }

      $vars = ['task' => $task, 'auth' => $auth, 'tstatus' => $task_status, 'is_supervisor' => $is_supervisor];
      return view('tasks.status', $vars);
    }


    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\Product $product
     * @return \Illuminate\Http\Response
     */
    public function task_status_update(Request $request)
    {
      $current_user = Auth::id();
      $request_all = $request->all();
      $task_id = $request_all['task_id'];
      $from_status = $request_all['old_status'];
      $to_status = $request_all['status'];

      $current_date_time = Carbon::now()->toDateTimeString();

      // Changed to In progress
//      if ($to_status == 2 && $request_all['Start_Date'] == '') {
      if ($request_all['Start_Date'] == '') {
        $request_all['Start_Date'] = $current_date_time;
      }

      // Changed to In Verified/Complete/Done
      if (($to_status == 4 || $to_status == 5 || $to_status == 6) && $request_all['Complete_Date'] == '') {

        if ($to_status == 4) {
          //$this->supervisor_mail($task);
        }
        $request_all['Complete_Date'] = $current_date_time;
      }

      // unset
      unset($request_all['_token']);
      unset($request_all['_method']);
      unset($request_all['task_id']);
      unset($request_all['old_status']);


      // Update task data
      DB::table('tasks')
        ->where('id', $task_id)
        ->update($request_all);

      // Task status history
      $data = [
        'task_id' => $task_id,
        'from_status' => $from_status,
        'to_status' => $to_status,
        'user_id' => $current_user,
        'created_at' => $current_date_time,
        'updated_at' => $current_date_time,
      ];

      DB::table('task_status_history')->insert($data);

      return redirect()->route('tasks.index')
        ->with('success', 'Task Status Updated Successfully');
    }
  }