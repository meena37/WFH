@extends('layouts.app')


@section('content')
    <div class="row">
        <div class="col-lg-12 margin-tb">
            <div class="pull-left">
                <h2>worklist</h2>
            </div>
            <div class="pull-right">
               
                <a class="btn btn-sm btn-primary" href="{{ route('tasktype.create') }}">New Task</a>
              
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
           
            <th>Task Code</th>
            <th>Task Type</th>
			
            <th width="280px">Action</th>
        </tr>
		</thead>
											<!--end::Table head-->
											<!--begin::Table body-->
											<tbody class="fw-bold text-gray-600">
	    @foreach ($tasktypes as $tasktype)
	    <tr>
	        
	        <td>{{ $tasktype->Task_code }}</td>
	        <td>{{ $tasktype->Task_type }}</td>
			   <td>
                <form action="{{ route('tasktype.destroy',$tasktype->id) }}" method="POST">
                     
                    <a class="btn btn-sm btn-flex btn-light btn-active-primary fw-bolder" href="{{ route('tasktype.edit',$tasktype->id) }}">Edit</a>
                   


                    
                </form>
	        </td>
	    </tr>
	    @endforeach
		
		</tbody>
											<!--end::Table body-->
    </table>


   </div> 



@endsection