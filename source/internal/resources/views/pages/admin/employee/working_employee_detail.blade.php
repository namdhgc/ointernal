@extends('layouts.admin.master')

@section('title')
	{{ Lang::get('admin/working_employee.working_employee_title') }}
@endsection

@section('content')
<div class="page-content-wrapper">
	<div class="page-content">
		<div class="page-head">
			<h2 class="page_header">{{ Lang::get('admin/working_employee.working_employee_title') }}</h2>
			<br/>
			<br/>

			@if (isset($data['response']))
				@foreach ($data['response'] as $key => $value)
					<form action="{{ URL::Route('adm-working_employee_update') }}" method="POST" id="form_sample_2" class="submit_form">
						<input type="hidden" name="_token" value="{{ csrf_token() }}">

						<div class="portlet box green">
							<div class="portlet-title">
				                <div class="caption">
				                    <i class="fa fa-cogs"></i>{{ Lang::get('admin/working_employee.detail') }}
				            	</div>
				            </div>

				            <div class="portlet-body">

								<input type="hidden" name="id" value="{{ $value->id }}">

								<div class="form-group row" >
                    				<label class="col-form-label col-sm-2 col-sm-offset-2 boldText">{{ Lang::get('admin/working_employee.employee_code') }}</label>

									<div class="col-sm-6">
										{{ $value->employeeCode }}
										<div class="form-control-focus"> </div>
									</div>
								</div>

								<hr class="hr-table-row">

								<div class="form-group row" >
									<label class="col-form-label col-sm-2 col-sm-offset-2 boldText">{{ Lang::get('admin/working_employee.firstname') }}</label>
									<div class="col-sm-6">
										<input type="text" class="form-control input-group input-medium" name="firstname" value="{{ $value->firstname }}">
									</div>
								</div>

								<hr class="hr-table-row">

								<div class="form-group row" >
									<label class="col-form-label col-sm-2 col-sm-offset-2 boldText">{{ Lang::get('admin/working_employee.lastname') }}</label>
									<div class="col-sm-6">
										<input type="text" class="form-control input-group input-medium" name="lastname" value="{{ $value->lastname }}">
									</div>
								</div>

								<hr class="hr-table-row">

								<div class="form-group row" >
									<label class="col-form-label col-sm-2 col-sm-offset-2 boldText">{{ Lang::get('admin/working_employee.birthday') }}</label>
									<div class="col-sm-6">
										<div class="input-group input-medium date date-picker" data-date="" data-date-format="yyyy-mm-dd" data-date-viewmode="years">
		                                    <input type="text" class="form-control" id="birthday" readonly="" name="birthday" value="{{ $value->birthday }}">
		                                    <span class="input-group-btn">
		                                        <button class="btn default" type="button">
		                                            <i class="fa fa-calendar"></i>
		                                        </button>
		                                    </span>
		                                </div>
									</div>
								</div>

								<hr class="hr-table-row">

								<div class="form-group row" >
									<label class="col-form-label col-sm-2 col-sm-offset-2 boldText">{{ Lang::get('admin/working_employee.gender') }}</label>
									<div class="col-sm-6">
										<div class="col-sm-6">
					                    	<div class="md-radio-inline">
					                            <div class="md-radio">
					                                <input type="radio" id="checkbox2_8" name="gender" value="1" class="md-radiobtn" {{ $value->gender==1 ? 'checked' : '' }}>
					                                <label for="checkbox2_8">
					                                    <span></span>
					                                    <span class="check"></span>
					                                    <span class="box"></span> {{ Lang::get('admin/working_employee.male') }} </label>
					                            </div>
					                            <div class="md-radio">
					                                <input type="radio" id="checkbox2_9" name="gender" value="2" class="md-radiobtn" {{ $value->gender==2 ? 'checked' : '' }}>
					                                <label for="checkbox2_9">
					                                    <span></span>
					                                    <span class="check"></span>
					                                    <span class="box"></span> {{ Lang::get('admin/working_employee.female') }} </label>
					                            </div>
				                        	</div>
					                    </div>
									</div>
								</div>

								<hr class="hr-table-row">

								<div class="form-group row" >
									<label class="col-form-label col-sm-2 col-sm-offset-2 boldText">{{ Lang::get('admin/working_employee.address') }}</label>
									<div class="col-sm-6">
										<textarea class="input-medium" rows="5" name="address"></textarea>
									</div>
								</div>

								<hr class="hr-table-row">

								<div class="form-group row" >
									<label class="col-form-label col-sm-2 col-sm-offset-2 boldText">{{ Lang::get('admin/working_employee.phone_number') }}</label>
									<div class="col-sm-6">
										<input type="text" class="form-control input-group input-medium" name="digits" value="{{ $value->phone_number }}">
										<div class="form-control-focus"> </div>
									</div>
								</div>

								<hr class="hr-table-row">

								<div class="form-group row" >
									<label class="col-form-label col-sm-2 col-sm-offset-2 boldText">{{ Lang::get('admin/working_employee.probationary') }}</label>
									<div class="col-sm-6">
										<div class="input-group input-medium date date-picker" data-date="" data-date-format="yyyy-mm-dd" data-date-viewmode="years">
		                                    <input type="text" class="form-control" id="" readonly="" name="probationary" value="{{ $value->probationary }}">
		                                    <span class="input-group-btn">
		                                        <button class="btn default" type="button">
		                                            <i class="fa fa-calendar"></i>
		                                        </button>
		                                    </span>
		                                </div>
									</div>
								</div>

								<hr class="hr-table-row">

								<div class="form-group row" >
									<label class="col-form-label col-sm-2 col-sm-offset-2 boldText">{{ Lang::get('admin/working_employee.official_date') }}</label>
									<div class="col-sm-6">
										<div class="input-group input-medium date date-picker" data-date="" data-date-format="yyyy-mm-dd" data-date-viewmode="years">
		                                    <input type="text" class="form-control" id="" readonly="" name="official_date" value="{{ $value->official_date }}">
		                                    <span class="input-group-btn">
		                                        <button class="btn default" type="button">
		                                            <i class="fa fa-calendar"></i>
		                                        </button>
		                                    </span>
		                                </div>
									</div>
								</div>

								<hr class="hr-table-row">

								<div class="form-group row">
					                <label class="col-form-label col-sm-2 col-sm-offset-2 boldText">{{Lang::get('admin/working_employee.position')}}</label>
					                <div class="col-sm-6">
					                    <?php
					                        $arr_position 		= Config::get('position');
					                        $count_arr_position = count($arr_position);
					                    ?>
					                    <select class="form-control input-medium" id="selectType" name="position" required="">
					                        @for ($i = 1; $i<= $count_arr_position; $i++)
					                            <option value="{{ $i }}" {{ $value->position == $i ? 'selected' : '' }}>
					                                <span>{{ $arr_position[$i] }}</span>
					                            </option>
					                        @endfor
					                    </select>
					                </div>
					            </div>

					            <hr class="hr-table-row">

								<div class="form-group row">
					                <label class="col-form-label col-sm-2 col-sm-offset-2 boldText">{{Lang::get('admin/working_employee.department')}}</label>
					                <div class="col-sm-6">
					                    <?php
					                        $arr_department 		= Config::get('department');
					                        $count_arr_department 	= count($arr_department);
					                    ?>
					                    <select class="form-control input-medium" id="selectType" name="department" required="">
					                        @for ($i = 1; $i<= $count_arr_department; $i++)
					                            <option value="{{ $i }}" {{ $value->departmentId == $i ? 'selected' : '' }}>
					                                <span>{{ $arr_department[$i] }}</span>
					                            </option>
					                        @endfor
					                    </select>
					                </div>
					            </div>

					            <hr class="hr-table-row">

								<div class="form-group row" >
									<label class="col-form-label col-sm-2 col-sm-offset-2 boldText"></label>
									<div class="col-sm-6">
										<input type="submit" class="btn btn-primary" value="{{ Lang::get('admin/working_employee.btn_update') }}">
										<a class="btn btn-success" id="btn_back" href="">
											{{ Lang::get('admin/working_employee.btn_back') }}
										</a>
									</div>
								</div>

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
	<script src="{{ URL::asset('assets/pages/scripts/form-validation-md.js') }}"></script>

	<script src="{{ URL::asset('js/messages_vi.js') }}"></script>
    <script src="{{ URL::asset('assets/global/plugins/jquery-validation/js/additional-methods.min.js') }}"></script>

@endsection