@extends('layouts.app')


@section('content')

    @if ($message = Session::get('success'))
        <div class="alert alert-success">
            <p>{{ $message }}</p>
        </div>
    @endif


    <div class="card-header border-0 pt-5">
        <h3 class="card-title align-items-start flex-column">
            <span class="card-label fw-bolder fs-3 mb-1">Supervisor Management</span>
        </h3>

        <div class="pull-right">
            <a class="btn btn-sm btn-primary" href="{{ route('supervisor.create') }}">New Supervisor</a>
        </div>
    </div>

    <div class="card-body pt-0">
        <table class="table align-middle table-row-dashed fs-6 gy-5" id="kt_customers_table">
            <!--begin::Table head-->
            <thead>
            <tr class="fw-bolder text-muted bg-light">
                <th class="ps-4 min-w-300px rounded-start">Name</th>
                <th>Email</th>
                <th width="280px">Action</th>
            </tr>
            </thead>
            <!--end::Table head-->
            <!--begin::Table body-->
            @php $i=0 @endphp
            <tbody class="fw-bold text-gray-600">
            @foreach ($supervisor as $key => $supervisors)
                <tr class="ps-4 min-w-300px rounded-start">

                    <td>
                        <div class="d-flex align-items-center">
                            <div class="symbol symbol-50px me-5"></div>
                            <div class="d-flex justify-content-start flex-column">
                                <a href="#" class="text-dark fw-bolder text-hover-primary mb-1 fs-6">
                                    {{ $supervisors->name }}
                                </a>
                            </div>
                        </div>
                    </td>
                    <td>{{ $supervisors->email }}</td>

                    <td>
                        <a class="btn btn-sm btn-primary" href="{{ route('supervisor.edit',$supervisors->id) }}">Edit</a>
                        {!! Form::open(['method' => 'DELETE','route' => ['supervisor.destroy', $supervisors->id],'style'=>'display:inline']) !!}
                        {!! Form::submit('Delete', ['class' => 'btn  btn-sm btn-danger']) !!}
                        {!! Form::close() !!}
                    </td>
                </tr>
            @endforeach
            </tbody>
            <!--end::Table body-->
        </table>


    </div>


@endsection