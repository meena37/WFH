@extends('layouts.app')


@section('content')
    <div class="row">
        <div class="col-lg-12 margin-tb">
            <div class="pull-left">
                <h2>Tasks</h2>
            </div>
            <div class="pull-right">

      <a class="btn btn-sm btn-primary" href="{{ route('designation.create') }}" data-bs-toggle="modal" data-bs-target="#add-contact"> New Task</a><!--a class="btn btn-sm btn-warning" >InActive</a-->
 
              
            </div>
        </div>
    </div>

 <!-- Add  Popup Model -->
        <div id="add-contact" class="modal fade in" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                    <h4 class="modal-title" id="myModalLabel">Add New Task</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                     </div>
                    <div class="modal-body">
					{!! Form::open(['route' => ['designation.store'],'class'=>'form-horizontal', ]) !!}
					 @include('designation.create')
                <!-- Submit Form Button -->
					<div class="modal-footer">
					 
					</div> 
					{!! Form::close() !!}
                        
                    
					</div>
             <!-- /.modal-content -->
			</div>
    <!-- /.modal-dialog -->
		</div>   
	 </div>   
    
 <!-- end  Popup Model -->
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
            
            <th>Designation</th>
            <th width="280px">Action</th>
        </tr>
		</thead>
											<!--end::Table head-->
											<!--begin::Table body-->
			@foreach ($designation as $item)
	    <tr>
	        <td>{{$item->designation}}</td>
	        <td>{{ $item->designation }}</td>
	        
	        <td>
                
	        </td>
	    </tr>
	    @endforeach
		
		</tbody>
											<!--end::Table body-->
    </table>


   </div> 

 <!-- Add Contact Popup Model -->
        <div id="deleteyear" class="modal fade " tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                    <h4 class="modal-title" id="myModalLabel">Add New Year</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                     </div>
                    <div class="modal-body">
					   <form action="{{route('designation.update','test')}}" method="post">
      		{{method_field('delete')}}
      		{{csrf_field()}}
	      <div class="modal-body">
				<p class="text-center">
					Are you sure you want to delete this?
				</p>
	      		<input type="hidden" name="=id" id="id" value="">
                 
	      </div>
	      <div class="modal-footer">
	        <button type="button" class="btn btn-success" data-dismiss="modal">No, Cancel</button>
	        <button type="submit" class="btn btn-warning">Yes, Delete</button>
	      </div>
      </form>
                    
					</div>
             <!-- /.modal-content -->
			</div>
    <!-- /.modal-dialog -->
		</div>   
	 </div> 

@endsection