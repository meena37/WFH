@extends('layouts.app')


@section('content')
    <div class="row">
        <div class="col-lg-12 margin-tb">
            <div class="pull-left">
                <h2>Tasks</h2>
            </div>
            <div class="pull-right">
                @if($submitbtn <= 7.2)
                    <a class="btn btn-sm btn-primary" href="{{ route('tasks.create') }}" data-bs-toggle="modal" data-bs-target="#add-contact"> New Task</a>

                @else
                    <a class="btn btn-sm btn-primary" href="{{ route('tasks.create') }}" data-bs-toggle="modal" data-bs-target="#add-contact"> New Task</a>
                    <!--a class="btn btn-sm btn-warning" >InActive</a-->
                @endif

            </div>
        </div>
    </div>
<!-- Add  Popup Model -->
        <div id="add-contact" class="modal fade in" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                    <h4 class="modal-title" id="myModalLabel">Add New Task</h4>
                        <!--begin::Close-->
						<div class="btn btn-sm btn-icon btn-active-color-primary" data-bs-dismiss="modal">
							<!--begin::Svg Icon | path: icons/stockholm/Navigation/Close.svg-->
								<span class="svg-icon svg-icon-1">
									<svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
										<g transform="translate(12.000000, 12.000000) rotate(-45.000000) translate(-12.000000, -12.000000) translate(4.000000, 4.000000)" fill="#000000">
											<rect fill="#000000" x="0" y="7" width="16" height="2" rx="1" />
											<rect fill="#000000" opacity="0.5" transform="translate(8.000000, 8.000000) rotate(-270.000000) translate(-8.000000, -8.000000)" x="0" y="7" width="16" height="2" rx="1" />
										</g>
									</svg>
								</span>
													<!--end::Svg Icon-->
						</div>
												<!--end::Close-->
                     </div>
                    <div class="modal-body">
					{!! Form::open(['route' => ['tasks.store'],'class'=>'form-horizontal', ]) !!}
					 @include('tasks.create')
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
        <table class="table align-middle table-row-dashed fs-6 gy-5">
            <thead>
            <tr>
                <th>Hour Per day</th>
                <th>Loss Hour</th>

                <th>Assign Hour</th>
                <th>Available Hour</th>
                <th>Entry time calculation</th>
                <th>Idle</th>


            </tr>
            </thead>
            <tr>

                <td>{{ '8 hours' }}</td>
                <td> {{ $loss_hour }}</td>
                <td>{{ $nassigntime }}</td>
                <td>{{ $available_hour }}</td>
                <td>{{ $Entry_time }} min</td>
                <td>{{ $idle }}</td>
            </tr>
        </table>
        <table class="table align-middle table-row-dashed fs-6 gy-5" id="kt_customers_table">
            <!--begin::Table head-->
            <thead>
            <tr>
                <th>Timestamp</th>
                <th>Task Serial Number</th>

                <th>Task Type</th>
                <th>Task Shift</th>
                <th>Task Title</th>
                <th>Task Details</th>
                <th>Task QTY</th>
                <th>Time task</th>
                <th>To do Time</th>
                <th>Proposed Time</th>
                <th>Plan</th>

                <th width="280px">Action</th>
            </tr>
            </thead>
            <!--end::Table head-->
            <!--begin::Table body-->
            @php $i=0 @endphp
            <tbody class="fw-bold text-gray-600">
            @foreach ($tasks as $task)
                <tr>

                    <td><a class="fs-6 text-gray-800 text-hover-primary"
                           href="{{ route('tasks.edit',$task->id) }}">{{ $task->Timestamp }}</a></td>
                    <td><a class="fs-6 text-gray-800 text-hover-primary"
                           href="{{ route('tasks.edit',$task->id) }}">{{$i+1}}</a></td>
                    <td><a class="fs-6 text-gray-800 text-hover-primary"
                           href="{{ route('tasks.edit',$task->id) }}">{{ $task->Task_Shift}}</a></td>
                    <td><a class="fs-6 text-gray-800 text-hover-primary"
                           href="{{ route('tasks.edit',$task->id) }}">{{ $task->Task_type}}</a></td>
                    <td><a class="fs-6 text-gray-800 text-hover-primary"
                           href="{{ route('tasks.edit',$task->id) }}">{{ $task->Task_Title }}</a></td>
                    <td><a class="fs-6 text-gray-800 text-hover-primary"
                           href="{{ route('tasks.edit',$task->id) }}">{{ $task->Task_Details}}</a></td>
                    <td><a class="fs-6 text-gray-800 text-hover-primary"
                           href="{{ route('tasks.edit',$task->id) }}">{{ $task->Task_QTY}}</a></td>
                    <td><a class="fs-6 text-gray-800 text-hover-primary"
                           href="{{ route('tasks.edit',$task->id) }}">{{ $task->Time_acc_to_task}} </a></td>
                    <td><a class="fs-6 text-gray-800 text-hover-primary"
                           href="{{ route('tasks.edit',$task->id) }}">{{ $task->To_do_Time }} minute </a></td>
                    <td><a class="fs-6 text-gray-800 text-hover-primary"
                           href="{{ route('tasks.edit',$task->id) }}">{{ $task->Proposed_Time }}</a></td>
                    <td><a class="fs-6 text-gray-800 text-hover-primary"
                           href="{{ route('tasks.edit',$task->id) }}">{{ $task->Plan }}</a></td>


                    <td>
                      <?php $status = isset($tstatus[$task->status]) ? $tstatus[$task->status] : '-';?>

                        @if( $task->status == 1 )
                            <div class="badge badge-light-warning fw-bolder px-4 py-3">{{$status}}</div>
                        @elseif( $task->status == 2 )
                            <div class="badge badge-light-info fw-bolder px-4 py-3"> {{$status}}</div>
                        @elseif( $task->status == 3)
                            <div class="badge badge-light-danger fw-bolder px-4 py-3"> {{$status}}</div>
                        @else
                            <div class="badge badge-light-success fw-bolder px-4 py-3">{{$status}}</div>
                        @endif

                        {{--@if( $task->Start_Date == 0 )
                            <div class="badge badge-light-warning fw-bolder px-4 py-3"> Pending</div>
                        @elseif( $task->Start_Date != 0 && $task->Paused_Date == 0 )

                            <div class="badge badge-light-info fw-bolder px-4 py-3"> Progress</div>
                        @elseif( $task->Start_Date != 0 && $task->Paused_Date != 0 && $task->Resume_Date == 0 && $task->Complete_Date == 0)

                            <div class="badge badge-light-danger fw-bolder px-4 py-3"> Paused</div>
                        @elseif( $task->Start_Date != 0 && $task->Paused_Date != 0 && $task->Resume_Date != 0 && $task->Complete_Date == 0)
                            <div class="badge badge-light-info fw-bolder px-4 py-3"> Progress</div>
                        @elseif( $task->Start_Date !=  0 && $task->Paused_Date != 0 && $task->Resume_Date != 0  && $task->Complete_Date != 0 )
                            <div class="badge badge-light-success fw-bolder px-4 py-3">Completed</div>
                        @endif--}}


                    </td>
                </tr>
                @php $i++ @endphp
            @endforeach

            </tbody>
            <!--end::Table body-->
        </table>


    </div>



@endsection
