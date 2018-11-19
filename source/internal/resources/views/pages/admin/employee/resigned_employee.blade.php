@extends('layouts.admin.master')

@section('title')
	{{ Lang::get('admin/resigned_employee.resigned_employee_title') }}
@endsection

@section('content')
<div class="page-content-wrapper">
	<div class="page-content">
		<div class="page-head">

			<h2 class="page_header">{{ Lang::get('admin/resigned_employee.resigned_employee_title') }}</h2>
			<br/>
			<br/>

			<form action="{{ URL::Route('adm-resigned_employee_search') }}" method="POST">
				<input type="hidden" name="_token" value="{{ csrf_token() }}">

				<div class="portlet box yellow">
					<div class="portlet-title">
                        <div class="caption">
                            <i class="fa fa-cogs"></i>{{ Lang::get('admin/resigned_employee.btn_search') }}
                    	</div>

                    </div>

                    <div class="portlet-body">
                    	<div class="table-responsive search_form">
							<table class="table borderless">
								<tr>
									<td>
										<span>{{ Lang::get('admin/resigned_employee.from_official_date') }}</span>
									</td>
									<td>
										<div class="input-group input-medium date date-picker" data-date="" data-date-format="yyyy-mm-dd" data-date-viewmode="years">
		                                    <input type="text" class="form-control" id="startDate" readonly="" name="search_startDate_official_date" value="{{ isset($data['extra']['search_startDate_official_date']) ? $data['extra']['search_startDate_official_date'] : '' }}">
		                                    <span class="input-group-btn">
		                                        <button class="btn default" type="button">
		                                            <i class="fa fa-calendar"></i>
		                                        </button>
		                                    </span>
		                                </div>
									</td>

									<td>
										<span>{{ Lang::get('admin/resigned_employee.employee_name') }}</span>
									</td>
									<td>
										<div class="input-group input-medium">
											<input type="text" class="form-control" id="employeeName" name="employeeName" value="{{ isset($data['extra']['search_empName']) ? $data['extra']['search_empName'] : '' }}">
										</div>
									</td>
								</tr>
								<tr>
									<td>
										<span>{{ Lang::get('admin/resigned_employee.to_official_date') }}</span>
									</td>
									<td>
										<div class="input-group input-medium date date-picker" data-date="" data-date-format="yyyy-mm-dd" data-date-viewmode="years">
		                                    <input type="text" class="form-control" id="endDate" readonly="" name="search_endDate_official_date" value="{{ isset($data['extra']['search_endDate_official_date']) ? $data['extra']['search_endDate_official_date'] : '' }}">
		                                    <span class="input-group-btn">
		                                        <button class="btn default" type="button">
		                                            <i class="fa fa-calendar"></i>
		                                        </button>
		                                    </span>
		                                </div>
									</td>
								</tr>
								<tr>
									<td>
										<span>{{ Lang::get('admin/resigned_employee.from_out_date') }}</span>
									</td>
									<td>
										<div class="input-group input-medium date date-picker" data-date="" data-date-format="yyyy-mm-dd" data-date-viewmode="years">
		                                    <input type="text" class="form-control" id="startDate" readonly="" name="search_startDate_out_date" value="{{ isset($data['extra']['search_startDate_out_date']) ? $data['extra']['search_startDate_out_date'] : '' }}">
		                                    <span class="input-group-btn">
		                                        <button class="btn default" type="button">
		                                            <i class="fa fa-calendar"></i>
		                                        </button>
		                                    </span>
		                                </div>
									</td>
								</tr>
								<tr>
									<td>
										<span>{{ Lang::get('admin/resigned_employee.to_out_date') }}</span>
									</td>
									<td>
										<div class="input-group input-medium date date-picker" data-date="" data-date-format="yyyy-mm-dd" data-date-viewmode="years">
		                                    <input type="text" class="form-control" id="endDate" readonly="" name="search_endDate_out_date" value="{{ isset($data['extra']['search_endDate_out_date']) ? $data['extra']['search_endDate_out_date'] : '' }}">
		                                    <span class="input-group-btn">
		                                        <button class="btn default" type="button">
		                                            <i class="fa fa-calendar"></i>
		                                        </button>
		                                    </span>
		                                </div>
									</td>
								</tr>
								<tr>
									<div id="date_notification" style="color:#f44242"></div>
								</tr>
								<tr>
									<td colspan="2">
										<input type="button" class="btn btn-warning btn_reset" value="{{ Lang::get('admin/resigned_employee.btn_reset') }}">
										<input type="button" class="btn btn-primary" id="btn_search" name="action" value="{{ Lang::get('admin/resigned_employee.btn_search') }}">
										<!-- <input type="submit" class="btn btn-success" name="action" value="Export"> -->
										<a href="#" class="btn btn-success" id="btn_export">
											{{ Lang::get('admin/resigned_employee.btn_export') }}
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
	                    <i class="fa fa-cogs"></i>{{ Lang::get('admin/resigned_employee.result') }}
	            	</div>
	            </div>

	            <div class="portlet-body">
	            	<div class="table-responsive">
						@php
							$count 			= $data['response']->total();
						@endphp
						@if (isset($data['response']))

							<input type="hidden" id="count" value="{{ $count }}">

							@if ($count != 0)
								<table class="table table-striped table-bordered">
									<tr class="info">
										<th>{{ Lang::get('admin/resigned_employee.employee_code') }}</th>
										<th>{{ Lang::get('admin/resigned_employee.employee_name') }}</th>
										<th>{{ Lang::get('admin/resigned_employee.email') }}</th>
										<th>{{ Lang::get('admin/resigned_employee.birthday') }}</th>
										<th>{{ Lang::get('admin/resigned_employee.address1') }}</th>
										<th>{{ Lang::get('admin/resigned_employee.phone_number') }}</th>
										<th>{{ Lang::get('admin/resigned_employee.official_date') }}</th>
										<th>{{ Lang::get('admin/resigned_employee.out_date') }}</th>
										<th>{{ Lang::get('admin/resigned_employee.diplomaId') }}</th>
										<th>{{ Lang::get('admin/resigned_employee.description') }}</th>
									</tr>

									@foreach ($data['response'] as $key => $value)
									<tr>
										<td>{{ $value->employeeCode }}</td>
										<td>{{ $value->firstname . ' ' . $value->lastname }}</td>
										<td>{{ $value->email }}</td>
										<td>{{ $value->birthday }}</td>
										<td>{{ $value->address1 }}</td>
										<td>{{ $value->phone_number }}</td>
										<td>{{ $value->official_date }}</td>
										<td>{{ $value->out_date }}</td>
										<td>{{ $value->diplomaId }}</td>
										<td>{{ $value->description }}</td>
									</tr>
									@endforeach

								</table>
							@else
								<h3 class="notification">{{ Lang::get('admin/resigned_employee.no_record') }}</h3>
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