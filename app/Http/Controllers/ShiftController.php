<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Shift;


class ShiftController extends Controller
{
    
     public function index()
    {
        $shift = Shift::latest()->paginate(5);
        return view('shift.index',compact('shift'))
            ->with('i', (request()->input('page', 1) - 1) * 5);
    }
    
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('shift.create');
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
            
            'Task_Shift' => 'required',
        ]);
     
        $shift = Shift::create([
        'Task_Shift' =>$request->get('Task_Shift'),
         
        
		
		
 ]);
    
        return redirect()->route('shift.index')
                        ->with('success','shift created successfully.');
    }
    
    /**
     * Display the specified resource.
     *
     * @param  \App\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function show(Shift $shift)
    {
        return view('shift.show',compact('shift'));
    }
    
    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function edit(Shift $shift)
    {
        return view('shift.edit',compact('shift'));
    }
    
    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Product  $shift
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Shift $shift)
    {
         request()->validate([
            
            'Task_Shift' => 'required',
        ]);
    
        $shift->update($request->all());
    
        return redirect()->route('shift.index')
                        ->with('success','Product updated successfully');
    }
    
    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Product  $tasktype
     * @return \Illuminate\Http\Response
     */
    public function destroy(Shift $shift)
    {
        $shift->delete();
    
        return redirect()->route('shift.index')
                        ->with('success','Product deleted successfully');
    }
}