@extends('layouts.admin.master')

@section('title')
	{{ Lang::get('admin/time_sheet.employee') }}
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

			<h2 class="page_header">{{ Lang::get('admin/time_sheet.time_management_title') }}</h2>
			<br/>
			<br/>

			<form action="{{ URL::Route('adm-search') }}" method="POST">
				<input type="hidden" name="_token" value="{{ csrf_token() }}">

				<div class="portlet box yellow">
					<div class="portlet-title">
                        <div class="caption">
                            <i class="fa fa-cogs"></i>{{ Lang::get('admin/time_sheet.btn_search') }}
                    	</div>

                    </div>

                    <div class="portlet-body">
                    	<div class="table-responsive search_form">
							<table class="table borderless">
								<tr>
									<td>
										<span>{{ Lang::get('admin/time_sheet.from') }}</span>
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
										<span>{{ Lang::get('admin/time_sheet.employee_name') }}</span>
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
										<span>{{ Lang::get('admin/time_sheet.to') }}</span>
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
										<span>{{ Lang::get('admin/time_sheet.department') }}</span>
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
										<input type="button" class="btn btn-warning btn_reset" value="{{ Lang::get('admin/time_sheet.btn_reset') }}">
										<input type="button" class="btn btn-primary" id="btn_search" name="action" value="{{ Lang::get('admin/time_sheet.btn_search') }}">
										<!-- <input type="submit" class="btn btn-success" name="action" value="Export"> -->
										<a href="{{ URL::route('adm-export') }}?&startDate={{ $data['extra']['search_startDate'] }}
											&endDate={{ $data['extra']['search_endDate'] }}
											&employeeName={{ $data['extra']['search_empName'] }}" class="btn btn-success" id="btn_export">
											{{ Lang::get('admin/time_sheet.btn_export') }}
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
	                    <i class="fa fa-cogs"></i>{{ Lang::get('admin/time_sheet.result') }}
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
										<th>{{ Lang::get('admin/time_sheet.employee_code') }}</th>
										<th>{{ Lang::get('admin/time_sheet.employee_name') }}</th>
										<th>{{ Lang::get('admin/time_sheet.date') }}</th>
										<th>{{ Lang::get('admin/time_sheet.start_time') }}</th>
										<th>{{ Lang::get('admin/time_sheet.end_time') }}</th>
										<th>{{ Lang::get('admin/time_sheet.late_time') }}</th>
										<th>{{ Lang::get('admin/time_sheet.work_time') }}</th>
										<th>{{ Lang::get('admin/time_sheet.note') }}</th>
										<th>{{ Lang::get('admin/time_sheet.action') }}</th>
									</tr>

									@foreach ($data['response'] as $key => $value)
									<tr>
										<td>{{ $value->employeeCode }}</td>
										<td>{{ $value->firstname . ' ' . $value->lastname }}</td>
										<td>{{ $value->date }}</td>
										<td>{{ $value->startDate }}</td>
										<td>{{ $value->endDate }}</td>
										<td>{{ $value->lateTime }}</td>
										<td>{{ @$value->workTime }}</td>
										<td>{{ $value->note }}</td>
										<td>
											<?php
												$current_time 	= strtotime(date("Y-m-d"));	
												$row_time 		= strtotime($value->date);
												$cutoff_days 	= Config::get('mycnf.cutoff_days');
											?>
											@if ($current_time - $row_time <= $cutoff_days * 24 * 60 * 60)
												<a href="{{ URL::Route('adm-timesheet_detail') }}?empCode={{ $value->employeeCode }}
												&date={{ $value->date }}
												&startDate={{ $startDate }}
												&endDate={{ $endDate }}
												&employeeName={{ $employeeName }}" target="_self">{{ Lang::get('admin/time_sheet.edit') }}</a>
												<!-- <input type="hidden" name="employeeCode" value="{{ $value->employeeCode }}"> -->
											@endif
										</td>
									</tr>
									@endforeach

								</table>
							@else
								<h3 class="notification">{{ Lang::get('admin/time_sheet.no_record') }}</h3>
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