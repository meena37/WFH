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
     //->join('users', 'supervisors.User_id', '=', 'users.id')
		->select('supervisors.id','users.name as Staff','users.name as Supervisor')->orderBy('id', 'DESC')
         ->get();
	
       
		
        return view('supervisor.index',['supervisor' => $supervisor]);
		
    }
    
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
       $users = DB::select('select * from users');
       
		
		return view('supervisor.create', ['users' => $users]);
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
            'Supervisor_id' => 'required',
            'User_id' => 'required',
        ]);
    
        Supervisor::create($request->all());
    
        return redirect()->route('supervisor.index')
                        ->with('success','Product created successfully.');
    }
    
    /**
     * Display the specified resource.
     *
     * @param  \App\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function show(Supervisor $supervisor)
    {
        return view('supervisor.show',compact('supervisor'));
    }
    
    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function edit(Supervisor $supervisor)
    {
        return view('supervisor.edit',compact('product'));
    }
    
    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Supervisor $supervisor)
    {
         request()->validate([
            'Supervisor_id' => 'required',
            'User_id' => 'required',
        ]);
    
        $supervisor->update($request->all());
    
        return redirect()->route('supervisor.index')
                        ->with('success','Product updated successfully');
    }
    
    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function destroy(Supervisor $supervisor)
    {
        $supervisor->delete();
    
        return redirect()->route('supervisor.index')
                        ->with('success','Product deleted successfully');
    }
}