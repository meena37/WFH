@extends('layouts.app')


@section('content')
<div class="row">
    <div class="col-lg-12 margin-tb">
        <div class="pull-left">
            <h2>supervisor Management</h2>
        </div>
        <div class="pull-right">
            <a class="btn btn-success" href="{{ route('supervisor.create') }}"> Create New User</a>
        </div>
    </div>
</div>


@if ($message = Session::get('success'))
<div class="alert alert-success">
  <p>{{ $message }}</p>
</div>
@endif


<table class="table table-bordered">
 <tr>
   
   <th>Name</th>
   <th>Email</th>
   <th>Roles</th>
   <th width="280px">Action</th>
 </tr>
 @foreach ($supervisor as $key => $supervisors)
  <tr>
    
    <td>{{ $supervisors->Supervisor }}</td>
    <td>{{ $supervisors->Staff }}</td>
    
    <td>
       <a class="btn btn-info" href="{{ route('supervisor.show',$supervisors->id) }}">Show</a>
       <a class="btn btn-primary" href="{{ route('supervisor.edit',$supervisors->id) }}">Edit</a>
        {!! Form::open(['method' => 'DELETE','route' => ['supervisor.destroy', $supervisors->id],'style'=>'display:inline']) !!}
            {!! Form::submit('Delete', ['class' => 'btn btn-danger']) !!}
        {!! Form::close() !!}
    </td>
  </tr>
 @endforeach
</table>





@endsection