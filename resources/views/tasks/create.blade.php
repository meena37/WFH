 
     
    	@csrf


											<div class="modal-body scroll-y px-10 px-lg-15 pt-0 pb-15">
												<!--begin:Form-->
												 
													<!--begin::Heading-->
													 
													<!--end::Heading-->
													<!--begin::Input group-->
													<div class="d-flex flex-column mb-8 fv-row fv-plugins-icon-container">
														<!--begin::Label-->
														<label class="d-flex align-items-center fs-6 fw-bold mb-2">
															<span class="required">Date time</span>
															<i class="fas fa-exclamation-circle ms-2 fs-7" data-bs-toggle="tooltip" title="" data-bs-original-title="Specify a target name for future usage and reference" aria-label="Specify a target name for future usage and reference"></i>
														</label>
														<!--end::Label-->
														<input type="text" class="form-control form-control-solid" placeholder="Enter Timestamp" value="<?php date_default_timezone_set('Asia/Kathmandu');
														$date = date('Y-m-d H:i:s'); echo $date;?>" name="Timestamp">
													<div class="fv-plugins-message-container"></div>
													</div>
													<!--end::Input group-->
													<!--begin::Input group-->
													<div class="d-flex flex-column mb-8 fv-row fv-plugins-icon-container">
														<!--begin::Label-->
														<label class="d-flex align-items-center fs-6 fw-bold mb-2">
															<span class="required">Task type</span>
															<i class="fas fa-exclamation-circle ms-2 fs-7" data-bs-toggle="tooltip" title="" data-bs-original-title="Specify a target name for future usage and reference" aria-label="Specify a target name for future usage and reference"></i>
														</label>
														<!--end::Label-->
														<select name="Task_type_id" class="form-control" required>
															<option selected="" disabled="" value="">Please Select</option>
								  
															  @foreach($tasktype as $item)
																  <option value="{{ $item->id  }}">
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
															<i class="fas fa-exclamation-circle ms-2 fs-7" data-bs-toggle="tooltip" title="" data-bs-original-title="Specify a target name for future usage and reference" aria-label="Specify a target name for future usage and reference"></i>
														</label>
														<!--end::Label-->
														<select name="Task_Shift_id" class="form-control" required>
															<option selected="" disabled="" value="">Please Select</option>
								  
															  @foreach($shift as $item)
																  <option value="{{ $item->id  }}">
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
															<i class="fas fa-exclamation-circle ms-2 fs-7" data-bs-toggle="tooltip" title="" data-bs-original-title="Specify a target name for future usage and reference" aria-label="Specify a target name for future usage and reference"></i>
														</label>
														<!--end::Label-->
														<input type="text" class="form-control form-control-solid" placeholder="Enter Task Title" name="Task_Title" required>
													<div class="fv-plugins-message-container"></div>
													</div>
													<!--end::Input group-->
													<!--begin::Input group-->
													<div class="d-flex flex-column mb-8 fv-row fv-plugins-icon-container">
														<!--begin::Label-->
														<label class="d-flex align-items-center fs-6 fw-bold mb-2">
															<span class="required">Task Details</span>
															<i class="fas fa-exclamation-circle ms-2 fs-7" data-bs-toggle="tooltip" title="" data-bs-original-title="Specify a target name for future usage and reference" aria-label="Specify a target name for future usage and reference"></i>
														</label>
														<!--end::Label-->
														<input type="text" class="form-control form-control-solid" placeholder="Enter Task Details" name="Task_Details" required>
													<div class="fv-plugins-message-container"></div>
													</div>
													<!--end::Input group-->
													<!--begin::Input group-->
													<div class="d-flex flex-column mb-8 fv-row fv-plugins-icon-container">
														<!--begin::Label-->
														<label class="d-flex align-items-center fs-6 fw-bold mb-2">
															<span class="required">Task QTY</span>
															<i class="fas fa-exclamation-circle ms-2 fs-7" data-bs-toggle="tooltip" title="" data-bs-original-title="Specify a target name for future usage and reference" aria-label="Specify a target name for future usage and reference"></i>
														</label>
														<!--end::Label-->
														<input type="text" class="form-control form-control-solid" placeholder="Enter QTY" name="Task_QTY" required>
													<div class="fv-plugins-message-container"></div>
													</div>
													<!--end::Input group-->
													<!--begin::Input group-->
													<div class="d-flex flex-column mb-8 fv-row fv-plugins-icon-container">
														<!--begin::Label-->
														<label class="d-flex align-items-center fs-6 fw-bold mb-2">
															<span class="required">Put Time  in minutes</span>
															<i class="fas fa-exclamation-circle ms-2 fs-7" data-bs-toggle="tooltip" title="" data-bs-original-title="Specify a target name for future usage and reference" aria-label="Specify a target name for future usage and reference"></i>
														</label>
														<!--end::Label-->
														<input type="text" class="form-control form-control-solid" placeholder="Enter Time in minute " name="Time_acc_to_task" required>
													<div class="fv-plugins-message-container"></div>
													</div>
													<!--end::Input group-->
													 
													<!--begin::Input group-->
													<div class="d-flex flex-column mb-8 fv-row fv-plugins-icon-container">
														<!--begin::Label-->
														<label class="d-flex align-items-center fs-6 fw-bold mb-2">
															<span class="required">Proposed Date</span>
															<i class="fas fa-exclamation-circle ms-2 fs-7" data-bs-toggle="tooltip" title="" data-bs-original-title="Specify a target name for future usage and reference" aria-label="Specify a target name for future usage and reference"></i>
														</label>
														<!--end::Label-->
														<input type="Date" class="form-control form-control-solid" placeholder="Enter Proposed Date " name="Proposed_Date" value="<?php echo date('Y-m-d'); ?>" required>
														<div class="fv-plugins-message-container"></div>
													</div>
													<!--end::Input group-->
													 
													<!--begin::Input group-->
													<div class="d-flex flex-column mb-8 fv-row fv-plugins-icon-container">
														<!--begin::Label-->
														<label class="d-flex align-items-center fs-6 fw-bold mb-2">
															<span class="required">Proposed Time</span>
															<i class="fas fa-exclamation-circle ms-2 fs-7" data-bs-toggle="tooltip" title="" data-bs-original-title="Specify a target name for future usage and reference" aria-label="Specify a target name for future usage and reference"></i>
														</label>
														<!--end::Label-->
														<input type="Time"  min="9:40" max="18:00"class="form-control form-control-solid" placeholder="Enter Proposed_Time" name="Proposed_Time" required>
														<div class="fv-plugins-message-container"></div>
													</div>
													<!--end::Input group-->
													
													
													 
											</div>
        
		  
											<div class="col-xs-12 col-sm-12 col-md-12 text-center">
													<button type="submit" class="btn btn-primary">Submit</button>
											</div>
										


    
