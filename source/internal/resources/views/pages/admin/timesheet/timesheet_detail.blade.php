@extends('layouts.admin.master')

@section('title')
	Chấm công
@endsection

@section('content')
<?php
	$start_work_time = Config::get('mycnf.start_work_time');
?>
<div class="page-content-wrapper">
	<div class="page-content">
		<div class="page-head">
			<h2 class="page_header">{{ Lang::get('admin/time_sheet.time_management_title') }}</h2>
			<br/>
			<br/>

			@if (isset($data['response']))
				@foreach ($data['response'] as $key => $value)
					<form id="form_detail" action="{{ URL::Route('adm-update') }}" method="POST">
						<input type="hidden" name="_token" value="{{ csrf_token() }}">

						<div class="portlet box green">
							<div class="portlet-title">
				                <div class="caption">
				                    <i class="fa fa-cogs"></i>{{ Lang::get('admin/time_sheet.detail') }}
				            	</div>
				            </div>

				            <div class="portlet-body">
				            	<table class="table table-striped">

									<input type="hidden" name="empCode" value="{{ $value->employeeCode }}">
									<input type="hidden" name="date" value="{{ $value->date }}">
									<input type="hidden" id="start_work_time" name="start_work_time" value="{{ $start_work_time }}">
									<tr>
										<th>{{ Lang::get('admin/time_sheet.employee_code') }}</th>
										<td>{{ $value->employeeCode }}</td>
									</tr>
									<tr>
										<th>{{ Lang::get('admin/time_sheet.employee_name') }}</th>
										<td>{{ $value->firstname . ' ' . $value->lastname }}</td>
									</tr>
									<tr>
										<th>{{ Lang::get('admin/time_sheet.date') }}</th>
										<td>{{ $value->date }}</td>
									</tr>
									<tr>
										<th>{{ Lang::get('admin/time_sheet.start_time') }}</th>
										<td>
											<!-- <input type="text" id='startDate' name="startDate" pattern="([0-1]{1}[0-9]{1}|20|21|22|23):[0-5]{1}[0-9]{1}"  value="{{ $value->startDate }}" title="Format should contain only HH:MM. e.g. 22:02"> -->
											<div class="input-group input-medium">
		                                        <input type="text" id='startTime' name="startDate" class="form-control timepicker timepicker-24" value="{{ $value->startDate }}">
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
											<!-- <input type="text" id='endDate' name="endDate" pattern="([0-1]{1}[0-9]{1}|20|21|22|23):[0-5]{1}[0-9]{1}" value="{{ $value->endDate }}"  title="Format should contain only HH:MM. e.g. 22:02"> -->
											<div class="input-group input-medium">
		                                        <input type="text" id='endTime' name="endDate" class="form-control timepicker timepicker-24" value="{{ $value->endDate }}">
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
										<th>{{ Lang::get('admin/time_sheet.late_time') }}</th>
										<td>
											<span id="late_time">{{ $value->lateTime }}</span>
										</td>
									</tr>
									<tr>
										<th>{{ Lang::get('admin/time_sheet.work_time') }}</th>
										<td>
											<span id="estimate_time">{{ @$value->workTime }}</span>
										</td>
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
											<input id="btnUpdate" type="submit" class="btn btn-primary" value="{{ Lang::get('admin/time_sheet.btn_update') }}">
											<a class="btn btn-success" href="{{ URL::Route('adm-timesheet') }}?startDate={{Input::get('startDate')}}
											&endDate={{Input::get('endDate')}}
											&employeeName={{Input::get('employeeName')}}">{{ Lang::get('admin/time_sheet.btn_back') }}</a>
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

			var startDate 	= $("#startTime").val();
			var endDate 	= $("#endTime").val();
			var form 		= $(this).closest('form');

			var start_time 	= new Date("December 29, 2016 " + startDate);
			var end_time 	= new Date("December 29, 2016 " + endDate);

			if (start_time > end_time) {

	    		$('#btnUpdate').attr("type","button");
	    		$('#notification').text("{{ Lang::get('admin/time_sheet.end_time_after_start_time') }}");

			} else {

				$(form).on("submit", function() {

					$('#btnUpdate').attr("disabled","disabled");

				});

				$('#btnUpdate').attr("type","submit");
				form.submit();

			}
	});
});

</script>

@endsection
