@extends('layouts.app')


@section('content')
    <div class="row">
        <div class="col-lg-12 margin-tb">
            <div class="pull-left">
                <h2>worklist</h2>
            </div>
            <div class="pull-right">
               
                <a class="btn btn-sm btn-primary" href="{{ route('worklist.create') }}">New Task</a>
              
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
            <th>No</th>
            <th>Work Type</th>
            <th>Work Nature</th>
			 <th>Work Heading</th>
            <th>Description</th>
			<th>Quantity</th>
			<th>Minutes</th>
			<th>Estimate Time</th>
			<th>Completed Done </th>
            <th width="280px">Action</th>
        </tr>
		</thead>
											<!--end::Table head-->
											<!--begin::Table body-->
											<tbody class="fw-bold text-gray-600">
	    @foreach ($worklist as $worklists)
	    <tr>
	        
	        <td>{{ $worklists->Work_Type }}</td>
	        <td>{{ $worklists->Work_Nature }}</td>
			 <td>{{ $worklists->Work_Heading }}</td>
			 <td>{{ $worklists->Description }}</td>
			 <td>{{ $worklists->Quantity }}</td>
			 <td>{{ $worklists->Minutes }}</td>
			 <td>{{ $worklists->User_id }}</td>
			 <td>{{ $worklists->Estimate_Time }}</td>
			 <td>@php $d1 = new DateTime($worklists->Start_Date );@endphp
@php $d2 = new DateTime($worklists->Paused_Date );
$d3 = new DateTime($worklists->Resume_Date );
$d4 = new DateTime($worklists->Complete_Date );@endphp 
@php 
$interval = $d3->diff($d2);
$interval1 = $d4->diff($d1);

$today = new DateTime();
$today->add($interval);
$today->add($interval1);
$diff_total = $today->diff(new DateTime());

 
 @endphp @php echo $diff_total->format('%d days, %H hours, %I minutes, %S seconds'); @endphp</td>
	        <td>
                <form action="{{ route('worklist.destroy',$worklists->id) }}" method="POST">
                    <a class="btn btn-sm btn-flex btn-light btn-active-primary fw-bolder" href="{{ route('worklist.show',$worklists->id) }}">Detail</a>
                    
                    <a class="btn btn-sm btn-flex btn-light btn-active-primary fw-bolder" href="{{ route('worklist.edit',$worklists->id) }}">Edit</a>
                   


                    
                </form>
	        </td>
	    </tr>
	    @endforeach
		
		</tbody>
											<!--end::Table body-->
    </table>


   </div> 



@endsection