@extends('layouts.app')


@section('content')
    <div class="row">
        <div class="col-lg-12 margin-tb">
            <div class="pull-left">
                <h2>Tasks</h2>
            </div>
            <div class="pull-right">
                 
                    <a class="btn btn-sm btn-primary" href="{{ route('designation.create') }}" data-bs-toggle="modal" data-bs-target="#add-contact"> New Task</a>
                    
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
       <div id="kt_customers_table_wrapper" class="dataTables_wrapper dt-bootstrap4 no-footer">
										<div class="table-responsive">
											<table class="table align-middle table-row-dashed fs-6 gy-5 dataTable no-footer" id="kt_customers_table" role="grid">
											<!--begin::Table head-->   
            <thead>
            <tr>
                <th>S.No</th>
                <th>Designation</th>
			<th width="280px">Action</th>
                <th> </th>
                <th> </th>
                <th> </th>
                <th> </th>
                
                
               
                

              
            </tr>
            </thead>
            <!--end::Table head-->
            <!--begin::Table body-->
            @php $i=0 @endphp
            <tbody class="fw-bold text-gray-600">
            @foreach ($designation as $item)
                <tr>

                       <td><a class="fs-6 text-gray-800 text-hover-primary"
                           href="{{ route('designation.edit',$item->id) }}">{{$i+1}}</a></td>
                    <td><a class="fs-6 text-gray-800 text-hover-primary"
                           href="{{ route('designation.edit',$item->id) }}">{{ $item->designation}}</a></td>
                    <td><a class="fs-6 text-gray-800 text-hover-primary"
                           href="{{ route('designation.edit',$item->id) }}"><span class="svg-icon svg-icon-3">
																			<svg xmlns="http://www.w3.org/2000/svg" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
																				<path d="M12.2674799,18.2323597 L12.0084872,5.45852451 C12.0004303,5.06114792 12.1504154,4.6768183 12.4255037,4.38993949 L15.0030167,1.70195304 L17.5910752,4.40093695 C17.8599071,4.6812911 18.0095067,5.05499603 18.0083938,5.44341307 L17.9718262,18.2062508 C17.9694575,19.0329966 17.2985816,19.701953 16.4718324,19.701953 L13.7671717,19.701953 C12.9505952,19.701953 12.2840328,19.0487684 12.2674799,18.2323597 Z" fill="#000000" fill-rule="nonzero" transform="translate(14.701953, 10.701953) rotate(-135.000000) translate(-14.701953, -10.701953)"></path>
																				<path d="M12.9,2 C13.4522847,2 13.9,2.44771525 13.9,3 C13.9,3.55228475 13.4522847,4 12.9,4 L6,4 C4.8954305,4 4,4.8954305 4,6 L4,18 C4,19.1045695 4.8954305,20 6,20 L18,20 C19.1045695,20 20,19.1045695 20,18 L20,13 C20,12.4477153 20.4477153,12 21,12 C21.5522847,12 22,12.4477153 22,13 L22,18 C22,20.209139 20.209139,22 18,22 L6,22 C3.790861,22 2,20.209139 2,18 L2,6 C2,3.790861 3.790861,2 6,2 L12.9,2 Z" fill="#000000" fill-rule="nonzero" opacity="0.3"></path>
																			</svg>
																		</span></a></td>
                    <td> </td>
                    <td> </td>
                    <td> </td>
                    <td> </td>
                    

                     
                </tr>
                @php $i++ @endphp
            @endforeach

            </tbody>
            <!--end::Table body-->
        </table>
	</div>

    </div>
  </div>
  

@endsection