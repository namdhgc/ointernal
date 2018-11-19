@extends('layouts.admin.master')

@section('title')
	{{ Lang::get('admin/register.register_employee') }}
@endsection

@section('content')
<div class="page-content-wrapper">
	<div class="page-content">
		<div class="page-head">
			
		<form action="{{ URL::Route('adm-post_register_employee') }}" id="form_sample_2" novalidate="novalidate" method="POST" class="form-horizontal">
		<input type="hidden" name="_token" value="{{ csrf_token() }}">
			<div class="portlet box yellow centerForm">
	            <div class="portlet-title">
	                <div class="caption">
	                    <i class="fa fa-cogs"></i>Đăng ký
	                </div>
	            </div>

	            <div class="portlet-body">
	            	<div>
				    	@if (Session::has('success'))
			          		<div id="msgSuccess" class="alert alert-success" style="text-align: center; ;margin: 0px auto 10px;font-weight: 600;font-size: 120%;">{{ Session::get('success') }}</div>
			        	@endif
			        	@if (Session::has('fail'))
			          		<div id="msgFail" class="alert alert-danger" style="text-align: center; ;margin: 0px auto 10px;font-weight: 600;font-size: 120%;">{{ Session::get('fail') }}</div>
			        	@endif
			    	</div>
	                <div class="form-group row" >
	                    <label class="col-form-label col-sm-2 col-sm-offset-2 boldText">Họ</label>
	                    <div class="col-sm-6">
	                        <input type="text" class="form-control " placeholder="Họ" name="lastname" value="<?php echo (isset($data['lastname']) && !empty($data['lastname'])) ? $data['lastname'] :"" ?>">
			                <div class="form-control-focus"> </div>
	                    </div>
	                </div>
	                <div class="form-group row">
	                    <label class="col-form-label col-sm-2 col-sm-offset-2 boldText" >Tên</label>
	                    <div class="col-sm-6">
	                        <input type="text" class="form-control " placeholder="Tên" name="firstname" value="<?php echo (isset($data['firstname']) && !empty($data['firstname'])) ? $data['firstname'] :"" ?>">
                            <div class="form-control-focus"> </div>
	                    </div>
	                </div>
	                <div class="form-group row form-md-radios " >
	                    <label class="col-form-label col-sm-2 col-sm-offset-2 boldText" style="color: #333;" >Giới tính</label>
	                    <div class="col-sm-6">
	                    	<div class="md-radio-inline">
	                            <div class="md-radio">
	                                <input type="radio" id="checkbox2_8" name="gender" value="1" class="md-radiobtn" <?php echo (isset($data['gender']) && !empty($data['gender']) && $data['gender']==1) ? "checked" : "" ?>>
	                                <label for="checkbox2_8">
	                                    <span></span>
	                                    <span class="check"></span>
	                                    <span class="box"></span> Nam </label>
	                            </div>
	                            <div class="md-radio">
	                                <input type="radio" id="checkbox2_9" name="gender" value="2" class="md-radiobtn" <?php echo (isset($data['gender']) && !empty($data['gender']) && $data['gender']==2) ? "checked" : "" ?>>
	                                <label for="checkbox2_9">
	                                    <span></span>
	                                    <span class="check"></span>
	                                    <span class="box"></span> Nữ </label>
	                            </div>
                        	</div>
	                    </div>  
	                </div>
	                <div class="form-group row">
	                    <label class="col-form-label col-sm-2 col-sm-offset-2 boldText">Email</label>
	                    <div class="col-sm-6">
	                        <input type="text" class="form-control" placeholder="Địa chỉ Email" name="email" id="email" value="<?php echo (isset($data['email']) && !empty($data['email'])) ? $data['email'] :"" ?>">
			                <div class="form-control-focus"> </div>
	                    </div>

	                </div>
	                <div class="form-group row form-horizontal">
	                	<div class="col-sm-4"></div>
	                	<div class="col-sm-6" id="notificationEmail" style="color:#f44242; margin: auto;">
                		</div>
                	</div>
                	<div class="form-group row" >
	                    <label class="col-form-label col-sm-2 col-sm-offset-2 boldText">Ngày sinh</label>
	                    <div class="col-sm-6">
	                        <div class="input-group date date-picker" data-date="" data-date-format="yyyy-mm-dd" data-date-viewmode="years">
	                            <input type="text" class="form-control" id="birthday" readonly="" name="birthday" placeholder="Ngày sinh" value="<?php echo (isset($data['birthday']) && !empty($data['birthday'])) ? $data['birthday'] :"" ?>">
	                            <span class="input-group-btn">
	                                <button class="btn default" type="button">
	                                    <i class="fa fa-calendar"></i>
	                                </button>
	                            </span>
	                        </div>
	                    </div>
	                </div>
	                
	                <div class="form-group row">
	                    <label class="col-form-label col-sm-2 col-sm-offset-2 boldText">Số điện thoại</label>
	                    <div class="col-sm-6">
	                        <input type="text" class="form-control" placeholder="Số điện thoại" name="digits" value="<?php echo (isset($data['phone_number']) && !empty($data['phone_number'])) ? $data['phone_number'] :"" ?>">
	                    </div>
	                    <div class="form-control-focus"> </div>
	                </div>
	                <div class="form-group">
	                    <label class="col-form-label col-sm-2 col-sm-offset-2 boldText">Địa chỉ</label>
	                    <div class="col-sm-6">
	                        <textarea type="text" class="form-control" placeholder="Địa chỉ" name="address1"><?php echo (isset($data['address1']) && !empty($data['address1'])) ? $data['address1'] :"" ?></textarea>		                            
	                    </div>
	                    <div class="form-control-focus"> </div>
	                </div>
	                <div class="form-group">
	                    <label class="col-form-label col-sm-2 col-sm-offset-2 boldText">Mã nhân viên</label>
	                    <div class="col-sm-6">
	                    <input type="text" class="form-control" placeholder="Mã nhân viên" name="employeeCode" id="employeeCode" value="<?php echo (isset($data['employeeCode']) && !empty($data['employeeCode'])) ? $data['employeeCode'] :"" ?>">
	                    </div>
	                    <div class="form-control-focus"> </div>
	                </div>
	                <div class="form-group row form-horizontal">
	                	<div class="col-sm-4"></div>
	                	<div class="col-sm-6" id="notificationCode" style="color:#f44242; margin: auto;">
                		</div>
                	</div>
	                <div class="form-group">
	                    <label class="col-form-label col-sm-2 col-sm-offset-2 boldText" >Bằng cấp</label>
	                    <div class="col-sm-6">
                            <select class="form-control" name="diplomaId">  
                            	<option value="" <?php echo (isset($data['diplomaId']) && empty($data['diplomaId'])) ? "selected" : "" ?>>Vui lòng chọn bằng cấp</option>           
                                <option value="1" <?php echo (isset($data['diplomaId']) && !empty($data['diplomaId']) && $data['diplomaId']==1) ? "selected" : "" ?>>Đại học</option>
                                <option value="2" <?php echo (isset($data['diplomaId']) && !empty($data['diplomaId']) && $data['diplomaId']==2) ? "selected" : "" ?>>Cao đẳng</option>
                            </select>
                        </div>
	                    <div class="form-control-focus"> </div>
	                </div>
	                <div class="form-group">
	                    <label class="col-form-label col-sm-2 col-sm-offset-2 boldText" >Phòng ban</label>
	                    <div class="col-sm-6">
                            <select class="form-control" name="departmentId">
                            	<option value="" <?php echo (isset($data['departmentId']) && empty($data['departmentId'])) ? "selected" : "" ?>>Vui lòng chọn phòng ban</option>
                                <option value="1" <?php echo (isset($data['departmentId']) && !empty($data['departmentId']) && $data['departmentId']==1) ? "selected" : "" ?>>Dev</option>
                                <option value="2" <?php echo (isset($data['departmentId']) && !empty($data['departmentId']) && $data['departmentId']==2) ? "selected" : "" ?>>Test</option>
                            </select>
                        </div>
	                    <div class="form-control-focus"> </div>
	                </div>
	                <div class="form-group">
	                    <label class="col-form-label col-sm-2 col-sm-offset-2 boldText" >Quyền truy cập</label>
	                    <div class="col-sm-6">
                            <select class="form-control" name="role">   
                            	<option value=""  <?php echo (isset($data['role']) && empty($data['role'])) ? "selected" : "" ?>>Vui lòng chọn quyền truy cập</option>          
                                <option value="1" <?php echo (isset($data['role']) && !empty($data['role']) && $data['role']==1) ? "selected" : "" ?>>Admin</option>
                                <option value="2" <?php echo (isset($data['role']) && !empty($data['role']) && $data['role']==2) ? "selected" : "" ?>>User</option>
                            </select>
                        </div>
	                    <div class="form-control-focus"> </div>
	                </div>
                 	<div class="form-group">
	                    <div class="col-sm-offset-4 col-sm-5">
	                        <button type="submit" class="btn green" id="btn_search" >Đăng ký</button>
                        	<button type="reset" class="btn default btn-success btnStyle btn_reset">Làm lại</button>  
	                    </div>
                	</div>
	            </div>
	        </div>
		</form>
		



		</div>
	</div>
</div>
@endsection

@section('js')

	<script src="{{ URL::asset('assets/pages/scripts/form-validation-md.js') }}"></script>

	<script src="{{ URL::asset('js/messages_vi.js') }}"></script>
    <script src="{{ URL::asset('assets/global/plugins/jquery-validation/js/additional-methods.min.js') }}"></script>
{{-- scr
$(document).ready(function(){
        //Action and delete for check in button
        $('#btn_add').click(function(){
            $('#timesheetForm').attr("action", "timesheet_log/check-in");
        });

        @if($statusCheckIn == true)
            $('#btn_add').remove();

        @endif

        //Action and delete for check out button
        $('#btn_end').click(function(){
            $('#timesheetForm').attr("action", "timesheet_log/check-out");
        });

        @if ($statusCheckOut == false)
            $('#btn_end').remove();
            $('#form-group').remove();
        @endif

        //Validate neu nguoi dung nghich F12 va doi attr cua input btn

}); --}}
<script type='text/javascript'>
$(document).ready(function() {

	$(document).on('change', function() {

		$('#btn_search').removeAttr("disabled");
	});


	$('#btn_search').click(function() {

	});
		@if (@$existed['existedEmail'] == true) 
    		$('#notificationEmail').text("{{ Lang::get('admin/register.existedEmail') }}");
    	@endif

    	@if (@$existed['existedCode'] == true) 
    		$('#notificationCode').text("{{ Lang::get('admin/register.existedCode') }}");
    	@endif
});



</script>
@endsection

