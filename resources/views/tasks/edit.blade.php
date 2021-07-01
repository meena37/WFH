@extends('layouts.app')


@section('content')

    <div class="card-header border-0 pt-5">
        <h3 class="card-title align-items-start flex-column">
            <span class="card-label fw-bolder fs-3 mb-1">Edit Task</span>
        </h3>

        <div class="pull-right">
            <a class="btn btn-sm btn-primary" href="{{ route('tasks.index') }}"> Back</a>
        </div>
    </div>

    @if (count($errors) > 0)
        <div class="alert alert-danger">
            <strong>Whoops!</strong> There were some problems with your input.<br><br>
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif



    <form action="{{ route('tasks.update', $task->id)}}" method="POST">
        @csrf
        @method('PUT')


        <div class="modal-body scroll-y px-10 px-lg-15 pt-0 pb-15">
            <!--begin:Form-->

            <!--begin::Heading-->

            <!--end::Heading-->
            <!--begin::Input group-->
            <div class="d-flex flex-column mb-8 fv-row fv-plugins-icon-container">
                <!--begin::Label-->
                <label class="d-flex align-items-center fs-6 fw-bold mb-2">
                    <span class="required">Date time</span>
                    <i class="fas fa-exclamation-circle ms-2 fs-7" data-bs-toggle="tooltip" title=""
                       data-bs-original-title="Specify a target name for future usage and reference"
                       aria-label="Specify a target name for future usage and reference"></i>
                </label>
                <!--end::Label-->
                <input type="text" class="form-control form-control-solid" placeholder="Enter Timestamp"
                       value="<?php echo $task->Timestamp;?>" name="Timestamp">
                <div class="fv-plugins-message-container"></div>
            </div>
            <!--end::Input group-->
            <!--begin::Input group-->
            <div class="d-flex flex-column mb-8 fv-row fv-plugins-icon-container">
                <!--begin::Label-->
                <label class="d-flex align-items-center fs-6 fw-bold mb-2">
                    <span class="required">Task type</span>
                    <i class="fas fa-exclamation-circle ms-2 fs-7" data-bs-toggle="tooltip" title=""
                       data-bs-original-title="Specify a target name for future usage and reference"
                       aria-label="Specify a target name for future usage and reference"></i>
                </label>
                <!--end::Label-->
                <select name="Task_type_id" class="form-control" required>
                    <option selected="" disabled="" value="">Please Select</option>

                    @foreach($tasktype as $item)
                        <option value="{{ $item->id  }}" <?php echo ($task->Task_type_id == $item->id) ? 'selected' : '';?>>
                            {{ $item->Task_type }}
                        </option>
                    @endforeach
                </select>
                <div class="fv-plugins-message-container"></div>
            </div>
            <!--end::Input group-->
            <!--begin::Input group-->
            <div class="d-flex flex-column mb-8 fv-row fv-plugins-icon-container">
                <!--begin::Label-->
                <label class="d-flex align-items-center fs-6 fw-bold mb-2">
                    <span class="required">Task Shift </span>
                    <i class="fas fa-exclamation-circle ms-2 fs-7" data-bs-toggle="tooltip" title=""
                       data-bs-original-title="Specify a target name for future usage and reference"
                       aria-label="Specify a target name for future usage and reference"></i>
                </label>
                <!--end::Label-->
                <select name="Task_Shift_id" class="form-control" required>
                    <option selected="" disabled="" value="">Please Select</option>

                    @foreach($shift as $item)
                        <option value="{{ $item->id  }}" <?php echo ($task->Task_Shift_id == $item->id) ? 'selected' : '';?>>
                            {{ $item->Task_Shift }}
                        </option>
                    @endforeach
                </select>
                <div class="fv-plugins-message-container"></div>
            </div>
            <!--end::Input group-->
            <!--begin::Input group-->
            <div class="d-flex flex-column mb-8 fv-row fv-plugins-icon-container">
                <!--begin::Label-->
                <label class="d-flex align-items-center fs-6 fw-bold mb-2">
                    <span class="required">Task Title</span>
                    <i class="fas fa-exclamation-circle ms-2 fs-7" data-bs-toggle="tooltip" title=""
                       data-bs-original-title="Specify a target name for future usage and reference"
                       aria-label="Specify a target name for future usage and reference"></i>
                </label>
                <!--end::Label-->
                <input type="text" class="form-control form-control-solid" placeholder="Enter Task Title"
                       name="Task_Title" value="{{$task->Task_Title}}"
                       required>
                <div class="fv-plugins-message-container"></div>
            </div>
            <!--end::Input group-->
            <!--begin::Input group-->
            <div class="d-flex flex-column mb-8 fv-row fv-plugins-icon-container">
                <!--begin::Label-->
                <label class="d-flex align-items-center fs-6 fw-bold mb-2">
                    <span class="required">Task Details</span>
                    <i class="fas fa-exclamation-circle ms-2 fs-7" data-bs-toggle="tooltip" title=""
                       data-bs-original-title="Specify a target name for future usage and reference"
                       aria-label="Specify a target name for future usage and reference"></i>
                </label>
                <!--end::Label-->
                <input type="text" class="form-control form-control-solid" placeholder="Enter Task Details"
                       name="Task_Details" value="{{$task->Task_Details}}"
                       required>
                <div class="fv-plugins-message-container"></div>
            </div>
            <!--end::Input group-->
            <!--begin::Input group-->
            <div class="d-flex flex-column mb-8 fv-row fv-plugins-icon-container">
                <!--begin::Label-->
                <label class="d-flex align-items-center fs-6 fw-bold mb-2">
                    <span class="required">Task QTY</span>
                    <i class="fas fa-exclamation-circle ms-2 fs-7" data-bs-toggle="tooltip" title=""
                       data-bs-original-title="Specify a target name for future usage and reference"
                       aria-label="Specify a target name for future usage and reference"></i>
                </label>
                <!--end::Label-->
                <input type="text" class="form-control form-control-solid" placeholder="Enter QTY" name="Task_QTY"
                       required value="{{$task->Task_QTY}}">
                <div class="fv-plugins-message-container"></div>
            </div>
            <!--end::Input group-->
            <!--begin::Input group-->
            <div class="d-flex flex-column mb-8 fv-row fv-plugins-icon-container">
                <!--begin::Label-->
                <label class="d-flex align-items-center fs-6 fw-bold mb-2">
                    <span class="required">Put Time  in minutes</span>
                    <i class="fas fa-exclamation-circle ms-2 fs-7" data-bs-toggle="tooltip" title=""
                       data-bs-original-title="Specify a target name for future usage and reference"
                       aria-label="Specify a target name for future usage and reference"></i>
                </label>
                <!--end::Label-->
                <input type="text" class="form-control form-control-solid" placeholder="Enter Time in minute "
                       name="Time_acc_to_task" required value="{{$task->Time_acc_to_task}}">
                <div class="fv-plugins-message-container"></div>
            </div>
            <!--end::Input group-->

            <!--begin::Input group-->
            <div class="d-flex flex-column mb-8 fv-row fv-plugins-icon-container">
                <!--begin::Label-->
                <label class="d-flex align-items-center fs-6 fw-bold mb-2">
                    <span class="required">Proposed Date</span>
                    <i class="fas fa-exclamation-circle ms-2 fs-7" data-bs-toggle="tooltip" title=""
                       data-bs-original-title="Specify a target name for future usage and reference"
                       aria-label="Specify a target name for future usage and reference"></i>
                </label>
                <!--end::Label-->
                <input type="Date" class="form-control form-control-solid" placeholder="Enter Proposed Date "
                       name="Proposed_Date" value="{{$task->Proposed_Date}}" required>
                <div class="fv-plugins-message-container"></div>
            </div>
            <!--end::Input group-->

            <!--begin::Input group-->
            <div class="d-flex flex-column mb-8 fv-row fv-plugins-icon-container">
                <!--begin::Label-->
                <label class="d-flex align-items-center fs-6 fw-bold mb-2">
                    <span class="required">Proposed Time</span>
                    <i class="fas fa-exclamation-circle ms-2 fs-7" data-bs-toggle="tooltip" title=""
                       data-bs-original-title="Specify a target name for future usage and reference"
                       aria-label="Specify a target name for future usage and reference"></i>
                </label>
                <!--end::Label-->
                <input type="Time" min="9:40" max="18:00" class="form-control form-control-solid"
                       placeholder="Enter Proposed_Time" name="Proposed_Time" required value="{{$task->Proposed_Time}}">
                <div class="fv-plugins-message-container"></div>
            </div>
            <!--end::Input group-->


        </div>


        <div class="col-xs-12 col-sm-12 col-md-12 text-center">
            <button type="submit" class="btn btn-primary">Submit</button>
        </div>


    </form>


@endsection