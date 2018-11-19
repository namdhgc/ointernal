@extends('layouts.user.master')

@section('title')
	Leave Request
@endsection

@section('content')
<div class="page-content-wrapper">
	<div class="page-content">
		<div class="container">
			<center>
				<label>
					<legend class="titleStyle">{{ Lang::get('user/leave_request_detail.leave_request_detail_management_title') }}</legend>					
				</label>
			</center>
			<br/>
			<br/>

			@if (isset($data['response']))
				@foreach ($data['response'] as $key => $value)
					<form action="{{ URL::Route('user-user_leave_request_update') }}" method="POST">
						<input type="hidden" name="_token" value="{{ csrf_token() }}">

						<div class="portlet box green">
							<div class="portlet-title">
				                <div class="caption">
				                    <i class="fa fa-cogs"></i>{{ Lang::get('user/leave_request_detail.detail') }}
				            	</div>
				            </div>

				            <div class="portlet-body">
					      		<table class="table table-striped">

									<input type="hidden" name="empCode" value="{{ $value->employeeCode }}">
									<input type="hidden" name="startDate" value="{{ Input::get('startDate') }}">
									<input type="hidden" name="endDate" value="{{ Input::get('endDate') }}">
										<tr>
										<th>{{ Lang::get('user/leave_request_detail.employee_code') }}</th>
										<td>{{ $value->employeeCode }}</td>
									</tr>
									<tr>
										<th>{{ Lang::get('user/leave_request_detail.employee_name') }}</th>
										<td>{{ $value->firstname . ' ' . $value->lastname }}</td>
									</tr>
									<tr>
										<th>{{ Lang::get('user/leave_request_detail.start_time') }}</th>
										<td>
											<input type="hidden" name="current_start_date" value="{{ $value->start_date }}">
											<input type="hidden" name="current_end_date" value="{{ $value->end_date }}">

											<div class="input-group input-medium date date-picker" data-date="" data-date-format="yyyy-mm-dd" data-date-viewmode="years">
			                                    <input type="text" class="form-control" id="tmp_startDate" readonly="" name="" value="{{ $value->startDate }}">
			                                    <span class="input-group-btn">
			                                        <button class="btn default" type="button">
			                                            <i class="fa fa-calendar"></i>
			                                        </button>
			                                    </span>
			                                </div>
			                                <br/>
											<div class="input-group input-medium">
		                                        <input type="text" id="startTime" name="" class="form-control timepicker timepicker-24" value="{{ $value->startTime }}">
		                                        <span class="input-group-btn">
		                                            <button class="btn default" type="button">
		                                                <i class="fa fa-clock-o"></i>
		                                            </button>
		                                        </span>
		                                    </div>
		                                    <input type="hidden" id="full_startTime" name="start_date" value="{{ $value->startDate }} {{ $value->startTime }}">
										</td>
									</tr>
									<tr>
										<th>{{ Lang::get('user/leave_request_detail.end_time') }}</th>
										<td>
											<div class="input-group input-medium date date-picker" data-date="" data-date-format="yyyy-mm-dd" data-date-viewmode="years">
			                                    <input type="text" class="form-control" id="tmp_endDate" readonly="" name="" value="{{ $value->endDate }}">
			                                    <span class="input-group-btn">
			                                        <button class="btn default" type="button">
			                                            <i class="fa fa-calendar"></i>
			                                        </button>
			                                    </span>
			                                </div>
			                                <br/>
											<div class="input-group input-medium">
		                                        <input type="text" id="endTime" name="" class="form-control timepicker timepicker-24" value="{{ $value->endTime }}">
		                                        <span class="input-group-btn">
		                                            <button class="btn default" type="button">
		                                                <i class="fa fa-clock-o"></i>
		                                            </button>
		                                        </span>
		                                    </div>
		                                    <input type="hidden" id="full_endTime" name="end_date" value="{{ $value->endDate }} {{ $value->endTime }}">
		                                    <div id="notification" class="input-medium" style="color:#f44242">

		                                    </div>
										</td>
									</tr>
									<tr>
										<th>{{Lang::get('user/leave_request_detail.type')}}</th>
										<td>
											<div class="input-group input-medium">
												<?php
													$arr_leave_types = Config::get('leave_types');
													$count_arr_leave_types = count($arr_leave_types);
												?>
												<select class="form-control" id="selectType" name="types" required="">
												@for ($i = 0; $i< $count_arr_leave_types; $i++)
													<option value="{{ $i }}" <?php echo ($i == $value->types) ? 'selected':''; ?>>
														<span>{{ $arr_leave_types[$i] }}</span>
													</option>
												@endfor
						                        </select>
					                        </div>
										</td>
									</tr>
									<tr>
										<th>{{ Lang::get('user/leave_request_detail.note') }}</th>
										<td>
											<textarea class="input-medium" rows="5" name="note">{{ $value->note }}</textarea>
										</td>
									</tr>
									<tr>
										<th></th>
										<td>
											<input id="btnUpdate" type="button" class="btn btn-primary" value="{{ Lang::get('user/leave_request_detail.btn_update') }}">
											<a class="btn btn-success" id="btn_back" href="">
												{{ Lang::get('user/leave_request_detail.btn_back') }}
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

		var startDate = document.getElementById("tmp_startDate").value;
		var endDate = document.getElementById("tmp_endDate").value;

		var startTime = document.getElementById("startTime").value;
		var endTime = document.getElementById("endTime").value;

		var start_time = new Date(startDate + ' ' + startTime);
		start_time = start_time.getTime();

		var end_time = new Date(endDate + ' ' + endTime);
		end_time = end_time.getTime();

		// var form = $(this).closest('form');

		if (start_time > end_time) {

    		$('#btnUpdate').attr("type","button");
    		$('#notification').text("{{ Lang::get('user/time_sheet.end_time_after_start_time') }}");

		}else{

			$('#btnUpdate').attr("type","submit");
			// form.submit();

		}
	});

	$('#tmp_startDate').on("change", function(event) {

		var date = $('#tmp_startDate').val();
		var time = $('#startTime').val();

		$('#full_startTime').val(date + ' ' + time);
	});

	$('#startTime').on("change", function(event) {

		var date = $('#tmp_startDate').val();
		var time = $('#startTime').val();

		$('#full_startTime').val(date + ' ' + time);
	});

	$('#tmp_endDate').on("change", function(event) {

		var date = $('#tmp_endDate').val();
		var time = $('#endTime').val();

		$('#full_endTime').val(date + ' ' + time);
	});

	$('#endTime').on("change", function(event) {

		var date = $('#tmp_endDate').val();
		var time = $('#endTime').val();

		$('#full_endTime').val(date + ' ' + time);
	});


});



</script>

@endsection