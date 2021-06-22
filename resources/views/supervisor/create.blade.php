@extends('layouts.app')


@section('content')

    <div class="card-header border-0 pt-5">
        <h3 class="card-title align-items-start flex-column">
            <span class="card-label fw-bolder fs-3 mb-1">Create Supervisor</span>
        </h3>

        <div class="pull-right">
            <a class="btn btn-sm btn-primary" href="{{ route('supervisor.index') }}"> Back</a>
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



    {!! Form::open(array('route' => 'supervisor.store','method'=>'POST')) !!}
    <div class="modal-body scroll-y px-10 px-lg-15 pt-0 pb-15">

        <!--begin::Input group-->
        <div class="row mb-6">
            <!--begin::Label-->
            <label class="fs-6 fw-bold mb-2">
                <span class="required">Supervisor</span>
                <i class="fas fa-exclamation-circle ms-1 fs-7" data-bs-toggle="tooltip" title=""
                   data-bs-original-title="Supervisor" aria-label="Supervisor"></i>
            </label>
            <!--end::Label-->
            <!--begin::Col-->
            <!--begin::Input-->
            <select name="supervisor_id" aria-label="Select a Supervisor" data-control="select2"
                    data-placeholder="Select a Supervisor..."
                    class="form-select form-select-solid fw-bolder select2-hidden-accessible" required="required">
                <option value="">Select Supervisor...</option>
              <?php foreach ($normal_users as $normal_user) {?>
                <option value="{{$normal_user->id}}">{{$normal_user->name}}</option>
              <?php } ?>
            </select>
            <!--end::Input-->
            <!--end::Col-->
        </div>
        <!--end::Input group-->

        <div class="d-flex flex-column mb-7 fv-row fv-plugins-icon-container" data-select2-id="select2-data-71-qd5z">
            <!--begin::Label-->
            <label class="fs-6 fw-bold mb-2">
                <span class="required">User</span>
                <i class="fas fa-exclamation-circle ms-1 fs-7" data-bs-toggle="tooltip" title=""
                   data-bs-original-title="User" aria-label="User"></i>
            </label>
            <!--end::Label-->
            <!--begin::Input-->
            <select name="normal_user_id[]" class="form-select form-select-solid" data-control="select2" data-placeholder="Select an option" data-allow-clear="true" multiple="multiple" required="required">
                <option value="">Select User...</option>
              <?php foreach ($all_users as $all_user) {?>
                <option value="{{$all_user->id}}">{{$all_user->name}}</option>
              <?php } ?>
            </select>
            <!--end::Input-->
            <div class="fv-plugins-message-container"></div>
        </div>

    </div>


    <div class="col-xs-12 col-sm-12 col-md-12 text-center">
        <button type="submit" class="btn btn-primary">Submit</button>
    </div>
    {!! Form::close() !!}


@endsection