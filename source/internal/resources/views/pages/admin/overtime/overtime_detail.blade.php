@extends('layouts.admin.master')

@section('title')
	Overtime
@endsection

@section('content')
<div class="page-content-wrapper">
	<div class="page-content">
		<div class="page-head">
			<h2 class="page_header">{{ Lang::get('admin/time_sheet.time_management_title') }}</h2>
			<br/>
			<br/>

			@if (isset($data['response']))
				@foreach ($data['response'] as $key => $value)
					<form action="{{ URL::Route('adm-overtime_update') }}" method="POST">
						<input type="hidden" name="_token" value="{{ csrf_token() }}">

						<div class="portlet box green">
							<div class="portlet-title">
				                <div class="caption">
				                    <i class="fa fa-cogs"></i>{{ Lang::get('admin/time_sheet.detail') }}
				            	</div>
				            </div>

				            <div class="portlet-body">
					      		<table class="table table-striped">

									<input type="hidden" name="employee_id" value="{{ $value->employee_id }}">
									<input type="hidden" name="empCode" value="{{ $value->employeeCode }}">
									<input type="hidden" name="startDate" value="{{ Input::get('startDate') }}">
									<input type="hidden" name="endDate" value="{{ Input::get('endDate') }}">
									<input type="hidden" name="employeeName" value="{{ Input::get('employeeName') }}">
									<input type="hidden" name="projectName" value="{{ Input::get('projectName') }}">
									<input type="hidden" name="search_approve" value="{{ Input::get('approve') }}">
									<input type="hidden" name="slc_department" value="{{ Input::get('slc_department') }}">
									<input type="hidden" name="current_page" value="{{ Input::get('current_page') }}">
										<tr>
										<th>{{ Lang::get('admin/time_sheet.employee_code') }}</th>
										<td>{{ $value->employeeCode }}</td>
									</tr>
									<tr>
										<th>{{ Lang::get('admin/time_sheet.employee_name') }}</th>
										<td>
											{{ $value->firstname . ' ' . $value->lastname }}
											<input type="hidden" name="employeeFullName" value="{{ $value->firstname . ' ' . $value->lastname }}">
										</td>
									</tr>
									<tr>
										<th>{{ Lang::get('admin/time_sheet.email') }}</th>
										<td>
											{{ $value->email }}
											<input type="hidden" name="email" value="{{ $value->email }}">
										</td>
									</tr>
									<tr>
										<th>{{ Lang::get('admin/time_sheet.date') }}</th>
										<td>
											<input type="hidden" id="currentDate" name="currentDate" value="{{ $value->date }}">

											<div class="input-group input-medium date date-picker" data-date="" data-date-format="yyyy-mm-dd" data-date-viewmode="years">
			                                    <input type="text" class="form-control" id="date" readonly="" name="date" value="{{ $value->date }}">
			                                    <span class="input-group-btn">
			                                        <button class="btn default" type="button">
			                                            <i class="fa fa-calendar"></i>
			                                        </button>
			                                    </span>
			                                </div>
										</td>
									</tr>
									<tr>
										<th>{{ Lang::get('admin/time_sheet.start_time') }}</th>
										<td>
											<!-- <input type="text" name="startTime" pattern="([0-1]{1}[0-9]{1}|20|21|22|23):[0-5]{1}[0-9]{1}" value="{{ $value->startTime }}" title="Format should contain only HH:MM. e.g. 22:02"> -->
											<div class="input-group input-medium">
		                                        <input type="text" id="startTime" name="startTime" class="form-control timepicker timepicker-24" value="{{ $value->startTime }}">
		                                        <span class="input-group-btn">
		                                            <button class="btn default" type="button">
		                                                <i class="fa fa-clock-o"></i>
		                                            </button>
		                                        </span>
		                                    </div>
										</td>
									</tr>
									<tr>
										<th>{{ Lang::get('admin/time_sheet.end_time') }}</th>
										<td>
											<div class="input-group input-medium">
		                                        <input type="text" id="endTime" name="endTime" class="form-control timepicker timepicker-24" value="{{ $value->endTime }}">
		                                        <span class="input-group-btn">
		                                            <button class="btn default" type="button">
		                                                <i class="fa fa-clock-o"></i>
		                                            </button>
		                                        </span>
		                                    </div>
		                                    <div id="notification" class="input-medium" style="color:#f44242">

		                                    </div>
										</td>
									</tr>
									<tr>
										<th>{{ Lang::get('admin/time_sheet.status') }}</th>
										<td>
											<select name="slc_approve">
												<option value="2" {{ ($value->isApproved == 2) ? 'selected':'' }}>{{ Lang::get('admin/time_sheet.reject') }}</option>
												<option value="1" {{ ($value->isApproved == 1) ? 'selected':'' }}>{{ Lang::get('admin/time_sheet.approved') }}</option>
												<option value="0" {{ ($value->isApproved == 0) ? 'selected':'' }}>{{ Lang::get('admin/time_sheet.not_approved') }}</option>
											</select>
										</td>
									</tr>

									<tr>
										<th>{{ Lang::get('admin/time_sheet.work_overtime') }}</th>
										<td><span id="estimate_time">{{ $value->overTime }}</span></td>
									</tr>
									<tr>
										<th>{{ Lang::get('admin/time_sheet.note') }}</th>
										<td>
											<textarea class="input-medium" rows="5" name="note">{{ $value->note }}</textarea>
										</td>
									</tr>
									<tr>
										<th></th>
										<td>
											<input id="btnUpdate" type="button" class="btn btn-primary" value="{{ Lang::get('admin/time_sheet.btn_update') }}">
											<a class="btn btn-success" id="btn_back" href="{{ URL::Route('adm-overtime') }}?startDate={{Input::get('startDate')}}
											&endDate={{Input::get('endDate')}}
											&employeeName={{Input::get('employeeName')}}">
												{{ Lang::get('admin/time_sheet.btn_back') }}
											</a>
										</td>
									</tr>

								</table>

					      	</div>
				      	</div>

					</form>
				@endforeach
			@endif

		</div>
	</div>
</div>
@endsection

@section('js')
<script type='text/javascript'>
$(document).ready(function() {

	$('#btnUpdate').click(function() {

			var startTime 	= $("#startTime").val();
			var endTime 	= $("#endTime").val();
			var date 		= $("#date").val();
			var form 		= $(this).closest('form');

			var start_time 	= new Date(date + ' ' + startTime);
			var end_time 	= new Date(date + ' ' + endTime);

			if (start_time > end_time) {

	    		$('#btnUpdate').attr("type","button");
	    		$('#notification').text("{{ Lang::get('admin/time_sheet.end_time_after_start_time') }}");

			} else {

				$(form).on("submit", function() {

					$('#btnUpdate').attr("disabled","disabled");

				});

				$('#btnUpdate').attr("type","submit");
				form.submit();
				// window.history.back();

			}
	});

});



</script>

@endsection