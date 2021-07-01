<?php
use App\Http\Controllers\TasksController;
?>
@extends('layouts.app')


@section('content')

    <div class="card-header border-0 pt-5">
        <h3 class="card-title align-items-start flex-column">
            <span class="card-label fw-bolder fs-3 mb-1">Tasks</span>
        </h3>

        <div class="pull-right">
            <a class="btn btn-sm btn-primary" href="{{ url('tasks.create') }}" data-bs-toggle="modal"
               data-bs-target="#add-contact"> New Task</a>
        </div>
    </div>

    <!-- Add  Popup Model -->
    <div id="add-contact" class="modal fade in" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
         aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="myModalLabel">Add New Task</h4>
                    <!--begin::Close-->
                    <div class="btn btn-sm btn-icon btn-active-color-primary" data-bs-dismiss="modal">
                        <!--begin::Svg Icon | path: icons/stockholm/Navigation/Close.svg-->
                        <span class="svg-icon svg-icon-1">
									<svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink"
                                         width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
										<g transform="translate(12.000000, 12.000000) rotate(-45.000000) translate(-12.000000, -12.000000) translate(4.000000, 4.000000)"
                                           fill="#000000">
											<rect fill="#000000" x="0" y="7" width="16" height="2" rx="1"/>
											<rect fill="#000000" opacity="0.5"
                                                  transform="translate(8.000000, 8.000000) rotate(-270.000000) translate(-8.000000, -8.000000)"
                                                  x="0" y="7" width="16" height="2" rx="1"/>
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

                <th width="280px">Status</th>
                <th width="280px">Time Taken</th>
                <th>Actions</th>
            </tr>
            </thead>
            <!--end::Table head-->
            <!--begin::Table body-->
            @php $i=0 @endphp
            <tbody class="fw-bold text-gray-600">
            @foreach ($tasks as $task)
                <tr>

                    <td><a class="fs-6 text-gray-800 text-hover-primary"
                           href="{{ url('task-status/'.$task->id.'/change') }}">{{ $task->Timestamp }}</a></td>
                    <td><a class="fs-6 text-gray-800 text-hover-primary"
                           href="{{ url('task-status/'.$task->id.'/change') }}">{{$i+1}}</a></td>
                    <td><a class="fs-6 text-gray-800 text-hover-primary"
                           href="{{ url('task-status/'.$task->id.'/change') }}">{{ $task->Task_Shift}}</a></td>
                    <td><a class="fs-6 text-gray-800 text-hover-primary"
                           href="{{ url('task-status/'.$task->id.'/change') }}">{{ $task->Task_type}}</a></td>
                    <td><a class="fs-6 text-gray-800 text-hover-primary"
                           href="{{ url('task-status/'.$task->id.'/change') }}">{{ $task->Task_Title }}</a></td>
                    <td><a class="fs-6 text-gray-800 text-hover-primary"
                           href="{{ url('task-status/'.$task->id.'/change') }}">{{ $task->Task_Details}}</a></td>
                    <td><a class="fs-6 text-gray-800 text-hover-primary"
                           href="{{ url('task-status/'.$task->id.'/change') }}">{{ $task->Task_QTY}}</a></td>
                    <td><a class="fs-6 text-gray-800 text-hover-primary"
                           href="{{ url('task-status/'.$task->id.'/change') }}">{{ $task->Time_acc_to_task}} </a></td>
                    <td><a class="fs-6 text-gray-800 text-hover-primary"
                           href="{{ url('task-status/'.$task->id.'/change') }}">{{ $task->To_do_Time }} minute </a></td>
                    <td><a class="fs-6 text-gray-800 text-hover-primary"
                           href="{{ url('task-status/'.$task->id.'/change') }}">{{ $task->Proposed_Time }}</a></td>
                    <td><a class="fs-6 text-gray-800 text-hover-primary"
                           href="{{ url('task-status/'.$task->id.'/change') }}">{{ $task->Plan }}</a></td>


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

                    <td><a class="fs-6 text-gray-800 text-hover-primary"
                           href="{{ url('task-status/'.$task->id.'/change') }}"><?php echo TasksController::task_time_taken($task->id);?></a>
                    </td>

                    <td class="text-end">
                        <a href="{{ route('tasks.edit',$task->id) }}"
                           class="btn btn-icon btn-bg-light btn-active-color-primary btn-sm me-1">
                            <!--begin::Svg Icon | path: icons/stockholm/Communication/Write.svg-->
                            <span class="svg-icon svg-icon-3">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24px"
                                     height="24px" viewBox="0 0 24 24"
                                     version="1.1">
                                    <path d="M12.2674799,18.2323597 L12.0084872,5.45852451 C12.0004303,5.06114792 12.1504154,4.6768183 12.4255037,4.38993949 L15.0030167,1.70195304 L17.5910752,4.40093695 C17.8599071,4.6812911 18.0095067,5.05499603 18.0083938,5.44341307 L17.9718262,18.2062508 C17.9694575,19.0329966 17.2985816,19.701953 16.4718324,19.701953 L13.7671717,19.701953 C12.9505952,19.701953 12.2840328,19.0487684 12.2674799,18.2323597 Z"
                                          fill="#000000" fill-rule="nonzero"
                                          transform="translate(14.701953, 10.701953) rotate(-135.000000) translate(-14.701953, -10.701953)"></path>
                                    <path d="M12.9,2 C13.4522847,2 13.9,2.44771525 13.9,3 C13.9,3.55228475 13.4522847,4 12.9,4 L6,4 C4.8954305,4 4,4.8954305 4,6 L4,18 C4,19.1045695 4.8954305,20 6,20 L18,20 C19.1045695,20 20,19.1045695 20,18 L20,13 C20,12.4477153 20.4477153,12 21,12 C21.5522847,12 22,12.4477153 22,13 L22,18 C22,20.209139 20.209139,22 18,22 L6,22 C3.790861,22 2,20.209139 2,18 L2,6 C2,3.790861 3.790861,2 6,2 L12.9,2 Z"
                                          fill="#000000" fill-rule="nonzero"
                                          opacity="0.3"></path>
                                </svg>
                            </span>
                            <!--end::Svg Icon-->
                        </a>

                        <form action="{{route('tasks.destroy', $task->id)}}" method="POST" style="float:right;">

                            @csrf
                            @method('DELETE')

                            <button type="submit" title="delete"  class="btn btn-icon btn-bg-light btn-active-color-primary btn-sm">
                                <!--begin::Svg Icon | path: icons/stockholm/General/Trash.svg-->
                                <span class="svg-icon svg-icon-3">
                                <svg xmlns="http://www.w3.org/2000/svg"
                                     xmlns:xlink="http://www.w3.org/1999/xlink"
                                     width="24px" height="24px" viewBox="0 0 24 24"
                                     version="1.1">
                                    <g stroke="none" stroke-width="1" fill="none"
                                       fill-rule="evenodd">
                                        <rect x="0" y="0" width="24"
                                              height="24"></rect>
                                        <path d="M6,8 L6,20.5 C6,21.3284271 6.67157288,22 7.5,22 L16.5,22 C17.3284271,22 18,21.3284271 18,20.5 L18,8 L6,8 Z"
                                              fill="#000000"
                                              fill-rule="nonzero"></path>
                                        <path d="M14,4.5 L14,4 C14,3.44771525 13.5522847,3 13,3 L11,3 C10.4477153,3 10,3.44771525 10,4 L10,4.5 L5.5,4.5 C5.22385763,4.5 5,4.72385763 5,5 L5,5.5 C5,5.77614237 5.22385763,6 5.5,6 L18.5,6 C18.7761424,6 19,5.77614237 19,5.5 L19,5 C19,4.72385763 18.7761424,4.5 18.5,4.5 L14,4.5 Z"
                                              fill="#000000" opacity="0.3"></path>
                                    </g>
                                </svg>
                            </span>
                                <!--end::Svg Icon-->
                            </button>
                        </form>

                    </td>
                </tr>
                @php $i++ @endphp
            @endforeach

            </tbody>
            <!--end::Table body-->
        </table>


    </div>



@endsection
