<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Designation;
use DB;

class DesignationController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
         $designation = DB::table('designations')
        
        ->select('designations.*')->get();
		
        return view('designation.index',['designation' => $designation]);
    }
    
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('designation.create');
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
            'designation' => 'required',
             
        ]);
    
        Designation::create($request->all());
    
        return redirect()->route('designation.index')
                        ->with('success','Designation created successfully.');
    }
    
    /**
     * Display the specified resource.
     *
     * @param  \App\Designation  $designation
     * @return \Illuminate\Http\Response
     */
    public function show(Designation $designation)
    {
        return view('designation.show',compact('designation'));
    }
    
    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Designation  $designation
     * @return \Illuminate\Http\Response
     */
    public function edit(Designation $designation)
    {
        return view('designation.edit',compact('designation'));
    }
    
    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Designation  $designation
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Designation $designation)
    {
         request()->validate([
            'designation' => 'required',
             
        ]);
    
        $designation->update($request->all());
    
        return redirect()->route('designation.index')
                        ->with('success','Designation updated successfully');
    }
    
    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Designation  $designation
     * @return \Illuminate\Http\Response
     */
    public function destroy(Designation $designation)
    {
        $designation->delete();
    
        return redirect()->route('designation.index')
                        ->with('success','Product deleted successfully');
    }

     
}
