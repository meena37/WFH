<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Tasktype;
class TasktypeController extends Controller
{
     public function index()
    {
        $tasktypes = Tasktype::latest()->paginate(5);
        return view('tasktype.index',compact('tasktypes'))
            ->with('i', (request()->input('page', 1) - 1) * 5);
    }
    
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('tasktype.create');
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
            'Task_code' => '',
            'Task_type' => 'required',
        ]);
     
        $tasktype = Tasktype::create([
        'Task_code' =>$request->get('Task_code'),
        'Task_type' => $request->get('Task_type'),
        
		
		
 ]);
    
        return redirect()->route('tasktype.index')
                        ->with('success','Tasktype created successfully.');
    }
    
    /**
     * Display the specified resource.
     *
     * @param  \App\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function show(Tasktype $tasktype)
    {
        return view('tasktype.show',compact('tasktype'));
    }
    
    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function edit(Tasktype $tasktype)
    {
        return view('tasktype.edit',compact('tasktype'));
    }
    
    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Product  $tasktype
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Tasktype $tasktype)
    {
         request()->validate([
            'Task_code' => '',
            'Task_type' => 'required',
        ]);
    
        $tasktype->update($request->all());
    
        return redirect()->route('tasktype.index')
                        ->with('success','Product updated successfully');
    }
    
    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Product  $tasktype
     * @return \Illuminate\Http\Response
     */
    public function destroy(Tasktype $tasktype)
    {
        $tasktype->delete();
    
        return redirect()->route('tasktype.index')
                        ->with('success','Product deleted successfully');
    }
}