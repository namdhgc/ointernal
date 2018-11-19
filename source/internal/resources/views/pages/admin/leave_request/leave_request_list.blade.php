@extends('layouts.admin.master')

@section('title')
	{{ Lang::get('admin/leave_request.employee') }}
@endsection

@section('content')
<div class="page-content-wrapper">
	<div class="page-content">
		<div class="page-head">
			@if(Session::has('message_success'))
			<p class="alert {{ Session::get('alert-class', 'alert-success') }}">
				{{ Session::get('message_success') }}
			</p>
			@endif
			@if(Session::has('message_fail'))
			<p class="alert {{ Session::get('alert-class', 'alert-danger') }}">
				{{ Session::get('message_fail') }}
			</p>
			@endif

			<h2 class="page_header">{{ Lang::get('admin/leave_request.leave_request_management_title') }}</h2>
			<br/>
			<br/>

			<form action="{{ URL::Route('adm-leave_request_search') }}" method="POST">
				<input type="hidden" name="_token" value="{{ csrf_token() }}">

				<div class="portlet box yellow">
					<div class="portlet-title">
                        <div class="caption">
                            <i class="fa fa-cogs"></i>{{ Lang::get('admin/leave_request.btn_search') }}
                    	</div>

                    </div>

                    <div class="portlet-body">
                    	<div class="table-responsive search_form">
							<table class="table borderless">
								<tr>
									<td>
										<span>{{ Lang::get('admin/leave_request.from') }}</span>
									</td>
									<td>
										<!-- <input type="date" id="startDate" name="startDate" value="{{ isset($data['extra']['search_startDate']) ? $data['extra']['search_startDate'] : '' }}"> -->
										<div class="input-group input-medium date date-picker" data-date="" data-date-format="yyyy-mm-dd" data-date-viewmode="years">
		                                    <input type="text" class="form-control" id="startDate" readonly="" name="startDate" value="{{ isset($data['extra']['search_startDate']) ? $data['extra']['search_startDate'] : '' }}">
		                                    <span class="input-group-btn">
		                                        <button class="btn default" type="button">
		                                            <i class="fa fa-calendar"></i>
		                                        </button>
		                                    </span>
		                                </div>
									</td>
									<td>
										<span>{{ Lang::get('admin/leave_request.employee_name') }}</span>
									</td>
									<td>
										<!-- <input type="text" id="employeeName" name="employeeName" value="{{ isset($data['extra']['search_empName']) ? $data['extra']['search_empName'] : '' }}"> -->
										<div class="input-group input-medium">
											<input type="text" class="form-control" id="employeeName" name="employeeName" value="{{ isset($data['extra']['search_empName']) ? $data['extra']['search_empName'] : '' }}">
										</div>
									</td>
								</tr>
								<tr>
									<td>
										<span>{{ Lang::get('admin/leave_request.to') }}</span>
									</td>
									<td>
										<!-- <input type="date" id="endDate" name="endDate" value="{{ isset($data['extra']['search_endDate']) ? $data['extra']['search_endDate'] : '' }}"> -->
										<div class="input-group input-medium date date-picker" data-date="" data-date-format="yyyy-mm-dd" data-date-viewmode="years">
		                                    <input type="text" class="form-control" id="endDate" readonly="" name="endDate" value="{{ isset($data['extra']['search_endDate']) ? $data['extra']['search_endDate'] : '' }}">
		                                    <span class="input-group-btn">
		                                        <button class="btn default" type="button">
		                                            <i class="fa fa-calendar"></i>
		                                        </button>
		                                    </span>
		                                </div>
									</td>
									<td>
										<span>{{ Lang::get('admin/leave_request.department') }}</span>
									</td>
									<td>
										<div class="input-group input-medium">
											<select name="slc_department" class="form-control" id="slc_department">
												<option value="">All</option>
												@foreach ($department['response'] as $key => $value)
													<option value="{{ $value->id }}" {{ (isset($data['extra']['search_department']) && ($data['extra']['search_department'] == $value->id)) ? 'selected' : '' }}>
														{{ $value->name }}
													</option>
												@endforeach
											</select>
										</div>
									</td>
								</tr>
								<tr>
									<div id="date_notification" style="color:#f44242"></div>
								</tr>
								<tr>
									<td colspan="2">
										<input type="button" class="btn btn-warning btn_reset" value="{{ Lang::get('admin/leave_request.btn_reset') }}">
										<input type="button" class="btn btn-primary" id="btn_search" name="action" value="{{ Lang::get('admin/leave_request.btn_search') }}">
										<!-- <input type="submit" class="btn btn-success" name="action" value="Export"> -->
										<a href="{{ URL::route('adm-export_leave_request') }}?&startDate={{ $data['extra']['search_startDate'] }}
											&endDate={{ $data['extra']['search_endDate'] }}
											&employeeName={{ $data['extra']['search_empName'] }}" class="btn btn-success" id="btn_export">
											{{ Lang::get('admin/leave_request.btn_export') }}
										</a>
									</td>
								</tr>
							</table>
						</div>
                    </div>
				</div>




			</form>

			<div class="portlet box green">
				<div class="portlet-title">
	                <div class="caption">
	                    <i class="fa fa-cogs"></i>{{ Lang::get('admin/leave_request.result') }}
	            	</div>
	            </div>

	            <div class="portlet-body">
	            	<div class="table-responsive">
						@php
							$count 			= $data['response']->total();
							$endDate 		= isset($data['extra']['search_endDate']) ? $data['extra']['search_endDate'] : '';
							$startDate 		= isset($data['extra']['search_startDate']) ? $data['extra']['search_startDate'] : '';
							$employeeName 	= isset($data['extra']['search_empName']) ? $data['extra']['search_empName'] : '';
						@endphp
						@if (isset($data['response']))

							<input type="hidden" id="count" value="{{ $count }}">

							@if ($count != 0)
								<table class="table table-striped table-bordered">
									<tr class="info">
										<th>{{ Lang::get('admin/leave_request.employee_code') }}</th>
										<th>{{ Lang::get('admin/leave_request.employee_name') }}</th>
										<th>{{ Lang::get('admin/leave_request.start_time') }}</th>
										<th>{{ Lang::get('admin/leave_request.end_time') }}</th>
										<th>{{ Lang::get('admin/leave_request.status') }}</th>
										<th>{{ Lang::get('admin/leave_request.approver') }}</th>
										<th>{{ Lang::get('admin/leave_request.note') }}</th>
										<th>{{ Lang::get('admin/leave_request.action') }}</th>
									</tr>

									@foreach ($data['response'] as $key => $value)
									<tr>
										<td>{{ $value->employeeCode }}</td>
										<td>{{ $value->firstname . ' ' . $value->lastname }}</td>
										<td>{{ $value->startDate . ' ' . $value->startTime }}</td>
										<td>{{ $value->endDate   . ' ' . $value->endTime }}</td>
										<td>
											@if ($value->isApproved == 1)
												<span>{{ Lang::get('admin/leave_request.approved') }}</span>
											@else
												<span>{{ Lang::get('admin/leave_request.not_approved') }}</span>
											@endif
										</td>
										<td>{{ $value->approver_firstname . ' ' . $value->approver_lastname }}</td>
										<td>{{ $value->note }}</td>
										<td>
											<?php
												$current_time 	= strtotime(date("Y-m-d"));	
												$row_time 		= strtotime($value->startDate);
												$cutoff_days 	= Config::get('mycnf.cutoff_days');
											?>
											@if ($current_time - $row_time <= $cutoff_days * 24 * 60 * 60)
												<a href="{{ URL::Route('adm-leave_request_detail') }}?id={{ $value->holiday_id }}
												&empCode   ={{ $value->employeeCode }}
												&startDate ={{ $startDate }}
												&endDate   ={{ $endDate }}
												&employeeName={{ $employeeName }}" target="_self">{{ Lang::get('admin/leave_request.edit') }}</a>
												<!-- <input type="hidden" name="employeeCode" value="{{ $value->employeeCode }}"> -->
											@endif

										</td>
									</tr>
									@endforeach

								</table>
							@else
								<h3 class="notification">{{ Lang::get('admin/leave_request.no_record') }}</h3>
							@endif
						@endif

						{{ $data['response']->appends([
							'startDate' 	=> Input::get('startDate'),
							'endDate' 		=> Input::get('endDate'),
							'employeeName' 	=> Input::get('employeeName'),
						])->links() }}
					</div>
	            </div>
	       	</div>


		</div>
	</div>
</div>
@endsection

@section('js')

@endsection