<?php
use App\Http\Controllers\TasksController;
?>
@extends('layouts.app')


@section('content')


    @if ($message = Session::get('success'))
        <div class="alert alert-success">
            <p>{{ $message }}</p>
        </div>
    @endif

    <div class="card-header border-0 pt-5">
        <h3 class="card-title align-items-start flex-column">
            <span class="card-label fw-bolder fs-3 mb-1">Supervisor Tasks</span>
            <span class="text-muted mt-1 fw-bold fs-7">Please verify the tasks.</span>
        </h3>
    </div>

    <div class="card-body pt-0">
        <table class="table align-middle table-row-dashed fs-6 gy-5" id="kt_customers_table">
            <!--begin::Table head-->
            <thead>
            <tr class="fw-bolder text-muted bg-light">
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
                           href="{{ url('task-status/'.$task->id.'/change') }}"><?php echo TasksController::task_time_taken($task->id);?></a></td>
                </tr>
                @php $i++ @endphp
            @endforeach

            </tbody>
            <!--end::Table body-->
        </table>


    </div>



@endsection
