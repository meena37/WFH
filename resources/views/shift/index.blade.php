@extends('layouts.app')


@section('content')
    <div class="row">
        <div class="col-lg-12 margin-tb">
            <div class="pull-left">
                <h2>Shift</h2>
            </div>
            <div class="pull-right">
               
                <a class="btn btn-sm btn-primary" href="{{ route('shift.create') }}">New shift</a>
              
            </div>
        </div>
    </div>


    @if ($message = Session::get('success'))
        <div class="alert alert-success">
            <p>{{ $message }}</p>
        </div>
    @endif

<div class="card-body pt-0">
    <table class="table align-middle table-row-dashed fs-6 gy-5" id="kt_customers_table">
											<!--begin::Table head-->
											<thead>
        <tr>
           
            <th>Task Shift</th>
           
			
            <th width="280px">Action</th>
        </tr>
		</thead>
											<!--end::Table head-->
											<!--begin::Table body-->
											<tbody class="fw-bold text-gray-600">
	    @foreach ($shift as $item)
	    <tr>
	        
	        <td>{{ $item->Task_Shift}}</td>
	       
			   <td>
                <form action="{{ route('shift.destroy',$item->id) }}" method="POST">
                     
                    <a class="btn btn-sm btn-flex btn-light btn-active-primary fw-bolder" href="{{ route('shift.edit',$item->id) }}">Edit</a>
                   


                    
                </form>
	        </td>
	    </tr>
	    @endforeach
		
		</tbody>
											<!--end::Table body-->
    </table>


   </div> 



@endsection