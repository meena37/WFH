<?php

  namespace App\Http\Controllers;

  use Illuminate\Http\Request;
  use App\Supervisor;
  use App\User;

  use DB;

  class SupervisorController extends Controller
  {
    public function index()
    {

      $supervisor = DB::table('supervisors')
        ->join('users', 'supervisors.Supervisor_id', '=', 'users.id')
        ->select('supervisors.id', 'supervisors.Supervisor_id', 'users.name', 'users.email')->orderBy('users.name', 'ASC')
        ->groupBy('users.id')
        ->get();

      $supervisor_ids = [];
      if (!empty($supervisor)) {
        foreach ($supervisor as $item) {
          $supervisor_ids[] = $item->Supervisor_id;
        }
      }
      $all_users = DB::select('select * from users');

      $normal_users = [];
      foreach ($all_users as $all_user) {
        if (!in_array($all_user->id, $supervisor_ids)) {
          $normal_users[] = $all_user;
        }
      }

      return view('supervisor.index', ['supervisor' => $supervisor, 'all_users' => $all_users, 'normal_users' => $normal_users]);

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
      $supervisor = DB::table('supervisors')
        ->join('users', 'supervisors.Supervisor_id', '=', 'users.id')
        ->select('supervisors.id', 'supervisors.Supervisor_id', 'users.name', 'users.email')->orderBy('users.name', 'ASC')
        ->groupBy('users.id')
        ->get();

      $supervisor_ids = [];
      if (!empty($supervisor)) {
        foreach ($supervisor as $item) {
          $supervisor_ids[] = $item->Supervisor_id;
        }
      }
      $all_users = DB::select('select * from users');

      $normal_users = [];
      foreach ($all_users as $all_user) {
        if (!in_array($all_user->id, $supervisor_ids)) {
          $normal_users[] = $all_user;
        }
      }


      return view('supervisor.create', ['supervisor' => $supervisor, 'all_users' => $all_users, 'normal_users' => $normal_users]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
      $request_all = $request->all();
      
      request()->validate([
        'supervisor_id' => 'required',
        'normal_user_id' => 'required',
      ]);

      $supervisor_id = $request_all['supervisor_id'];
      $normal_user_id = $request_all['normal_user_id'];

      DB::table('supervisors')->where('Supervisor_id', '=', $supervisor_id)->delete();

      foreach ($normal_user_id as $item) {
        $data = [
          'Supervisor_id' => $supervisor_id,
          'User_id' => $item,
        ];

        DB::table('supervisors')->insert($data);
      }

      return redirect()->route('supervisor.index')
        ->with('success', 'Supervisor added successfully.');
    }

    /**
     * Display the specified resource.
     *
     * @param \App\Product $product
     * @return \Illuminate\Http\Response
     */
    public function show(Supervisor $supervisor)
    {
      return view('supervisor.show', compact('supervisor'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param \App\Product $product
     * @return \Illuminate\Http\Response
     */
    public function edit(Supervisor $supervisor)
    {
      $sel_supervisor_id = $supervisor->Supervisor_id;

      $sel_users = DB::table('supervisors')
        ->select('supervisors.User_id')
        ->where('supervisors.Supervisor_id', '=', $sel_supervisor_id)
        ->get();

      $sel_users_ids = [];
      if(!empty($sel_users)){
        foreach ($sel_users as $sel_user) {
          $sel_users_ids[] = $sel_user->User_id;
        }
      }

      $all_users = DB::select('select * from users');

      $normal_users = $all_users;

      $data = [
        'all_users' => $all_users, 'normal_users' => $normal_users,
        'sel_supervisor_id' => $sel_supervisor_id, 'sel_users_ids' => $sel_users_ids,
      ];
      return view('supervisor.edit', $data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\Product $product
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Supervisor $supervisor)
    {
      $request_all = $request->all();

      request()->validate([
        'supervisor_id' => 'required',
        'normal_user_id' => 'required',
      ]);

      return redirect()->route('supervisor.index')
        ->with('success', 'Supervisor updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\Product $product
     * @return \Illuminate\Http\Response
     */
    public function destroy(Supervisor $supervisor)
    {
      $supervisor_id = $supervisor->Supervisor_id;

      DB::table('supervisors')->where('Supervisor_id', '=', $supervisor_id)->delete();

      return redirect()->route('supervisor.index')
        ->with('success', 'Supervisor removed successfully');
    }
  }