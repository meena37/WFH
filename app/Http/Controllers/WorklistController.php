<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Worklist;
use App\Supervisor;
use Auth;
use DB;
class WorklistController extends Controller
{
    public function index()
    {
		 $user = Auth::id();
		$auth =  DB::table('supervisors')
		->join('users', 'supervisors.Supervisor_id', '=', 'users.id')
     //->join('users', 'supervisors.User_id', '=', 'users.id')
		->select('supervisors.Supervisor_id')->where('User_id', '=', $user)
         ->value('Supervisor_id');
		
		print_r($auth);
		  
		if ( $user == $user )
{
     $worklist = DB::table('worklists')
		//->join('users', 'supervisors.Supervisor_id', '=', 'users.id')
     ->join('users', 'worklists.User_id', '=', 'users.id')
	 
		->select('worklists.*','users.name')->where('User_id', '=', $user)->orderBy('id', 'DESC')
         ->get();
		  return view('worklist.index',['worklist' => $worklist,'auth' => $auth]);
}else{
	
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
        return view('worklist.create');
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
            
            'Work_Type' => 'required',
			 'Work_Nature' => 'required',
            'Work_Heading' => 'required',
			 'Description' => 'required',
            'Quantity' => 'required',
			 'Minutes' => 'required',
             
			
        ]);
    $user = Auth::id();
        $worklist = Worklist::create([
         'Work_Type' => $request->get('Work_Type'),
        'Work_Nature' => $request->get('Work_Nature'),
        'Work_Heading' => $request->get('Work_Heading'),
        'Description' => $request->get('Description'),
        'Quantity' => $request->get('Quantity'),
        'Minutes' => $request->get('Minutes'),
         'User_id' => Auth::id(),
		'Supervisor_id'=> DB::table('supervisors')
		->join('users', 'supervisors.Supervisor_id', '=', 'users.id')
     //->join('users', 'supervisors.User_id', '=', 'users.id')
		->select('supervisors.Supervisor_id')->where('User_id', '=', $user)
         ->value('Supervisor_id'),
		'Estimate_Time' => $request->get('Quantity') *$request->get('Minutes'),
		
		
 ]);
    
        return redirect()->route('worklist.index')
                        ->with('success','Work created successfully.');
    }
    
    /**
     * Display the specified resource.
     *
     * @param  \App\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function show(Worklist $worklist)
    {
        return view('worklist.show',compact('worklist'));
    }
    
    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Worklist  $product
     * @return \Illuminate\Http\Response
     */
    public function edit(Worklist $worklist)
    {  $user = Auth::id();
        $auth =  DB::table('supervisors')
		->join('users', 'supervisors.Supervisor_id', '=', 'users.id')
     //->join('users', 'supervisors.User_id', '=', 'users.id')
		->select('supervisors.Supervisor_id')
         ->value('Supervisor_id');
		 return view('worklist.edit',['worklist' => $worklist,'auth' => $auth]);
    }
    
    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Worklist $worklist)
    {
         request()->validate([
            'Work_Type' => 'required',
			 'Work_Nature' => 'required',
            'Work_Heading' => 'required',
			 'Description' => 'required',
            'Quantity' => 'required',
			 'Minutes' => 'required',
			 'Estimate_Time' => '',
			 'Verified_head' => '',
        ]);
    
        $worklist->update($request->all());
    
        return redirect()->route('worklist.index')
                        ->with('success','Work updated successfully');
    }
    
    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function destroy(Worklist $worklist)
    {
        $worklist->delete();
    
        return redirect()->route('worklist.index')
                        ->with('success','Work deleted successfully');
    }
}
