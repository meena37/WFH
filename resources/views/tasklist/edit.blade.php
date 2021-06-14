@extends('layouts.app')


@section('content')
    <div class="scroll-y px-10 px-lg-15 pt-0 pb-15">
        <div class="col-lg-12 margin-tb">
            <div class="pull-left">
                <br/><h2>Edit item</h2>
            </div>
            <div class="pull-right">
                <!--a class="btn btn-primary" href="{{ route('worklist.index') }}"> Back</a-->
            </div>
        </div>
    </div>


    @if ($errors->any())
        <div class="alert alert-danger">
            <strong>Whoops!</strong> There were some problems with your input.<br><br>
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif


    <form action="{{ route('tasklist.update',$item->id) }}" method="POST">
    	@csrf
        @method('PUT')
<div class="scroll-y px-10 px-lg-15 pt-0 pb-15">
													
												<!--begin::Input group--><?php $user = Auth::id();?> @if ( $user == $auth)
													<div class="d-flex flex-column mb-8 fv-row fv-plugins-icon-container">	
													<label class=" fs-6 fw-bold mb-2">Verified by Head</label>
													<select class="form-select form-select-solid select2-hidden-accessible" data-control="select2" data-hide-search="true" data-placeholder="Select Option" name="Verified_head" id="Verified_head">
													<option value="" data-select2-id="select2-data-12-gk85">Select user...</option>
   <option {{old('Verified_head',$item->Verified_head)=="Verified"? 'selected':''}}  value="Verified">Verified</option>
   <option {{old('Verified_head',$item->Verified_head)=="Not Verified"? 'selected':''}} value="Not Verified">Not Verified</option>
</select>

															</div>@else {{ 'test'}}
															@endif
													<!--end::Input group-->
<input type="hidden" id="currentdate" value="<?php date_default_timezone_set('Asia/Kathmandu');
$date = date('d-m-y h:i:s');
echo $date;?>"><br>		
		 <div class="col-md-4 col-sm-4"><input class="form-control" type="text" id="Start_Date" name="Start_Date"value="{{ $item->Start_Date }}" readonly="readonly"></div>
<div class="col-md-4 col-sm-4"><input class="form-control" type="text" id="Paused_Date"  name="Paused_Date"value="{{ $item->Paused_Date }}" readonly="readonly"></div>
<div class="col-md-4 col-sm-4"><input class="form-control" type="text" id="Resume_Date"  name="Resume_Date"value="{{ $item->Resume_Date }}" readonly="readonly"></div>
 <div class="col-md-4 col-sm-4"><input class="form-control" type="text" id="Complete_Date"  name="Complete_Date"value="{{ $item->Complete_Date }}" readonly="readonly"></div>

 <script>
function startFunction() {
  document.getElementById("Start_Date").value = document.getElementById("currentdate").value;
}
function pauseFunction() {
  document.getElementById("Paused_Date").value = document.getElementById("currentdate").value;
}
function resumeFunction() {
  document.getElementById("Resume_Date").value = document.getElementById("currentdate").value;
}
function stopFunction() {
   document.getElementById("Complete_Date").value = document.getElementById("currentdate").value;
}
</script>
        <?php if($item->Start_Date != ""){
      		echo '<button onclick="startFunction()"    class="btn waves-effect waves-light btn-rounded btn-info" disabled>Start</button>';
		}
		else{
				echo '<button onclick="startFunction()"    class="btn waves-effect waves-light btn-rounded btn-info">Start</button>';
			}
            ?>
			
			<?php if($item->Complete_Date == "" && $item->Paused_Date == ""  ){
      		echo '<button onclick="pauseFunction()"class="btn waves-effect waves-light btn-rounded btn-warning">Pause</button>';
		}elseif($item->Paused_Date >= $item->Resume_Date){
			echo '<button onclick="resumeFunction()"class="btn waves-effect waves-light btn-rounded btn-primary">Resume</button>';
		
		}
		else{
				echo '<button onclick="pauseFunction()"class="btn waves-effect waves-light btn-rounded btn-warning">Pause</button>';
			}
            ?>
			
                                    <button  onclick="stopFunction()"class="btn waves-effect waves-light btn-rounded btn-danger">Stop</button>
                                    
 
                
		    <div class="col-xs-12 col-sm-12 col-md-12 text-center">
		      <button type="submit" class="btn btn-primary">Submit</button>
		    </div>
		</div>
</div>

    </form>



@endsection