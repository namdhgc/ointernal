<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| This file is where you may define all of the routes that are handled
| by your application. Just tell Laravel the URIs it should respond
| to using a Closure or controller method. Build something great!
|
*/

Route::get('/404', ['as' => '404', function() {

	return view('errors.404');
}]);


Route::group(['as' => 'adm-', 'middleware' => ['auth','role', 'checkIpAddress']], function() {

	Route::group([], function() {

		Route::get(ADMIN_URL . '/', ['as' => 'index', function() {

			// $data = App::make('App\Http\Controllers\DashboardController')->getDataChart();

			return view(ADMIN_PATH . 'home.index');
		}]);

		Route::get(ADMIN_URL . '/device', ['as' => 'device', function() {

			return view(ADMIN_PATH . 'device.index');
		}]);


		Route::get(ADMIN_URL . '/document', ['as' => 'document', function() {

			return view(ADMIN_PATH . 'document.index');
		}]);

		Route::get(ADMIN_URL . '/timesheet', ['as' => 'timesheet', function() {

			$employee 	= App::make('App\Http\Controllers\TimesheetController')->GetAllEmp(true);
			$department = App::make('App\Http\Controllers\DepartmentController')->GetDepartment();


			return view(ADMIN_PATH . 'timesheet.timesheet') ->with('data', $employee)
															->with('department', $department);
		}]);


		Route::get(ADMIN_URL . '/timesheet_detail', ['as' => 'timesheet_detail', function() {

			$app = App::make('App\Http\Controllers\TimesheetController')->GetOneEmp();

			return view(ADMIN_PATH . 'timesheet.timesheet_detail')->with('data', $app);
		}]);

		Route::get(ADMIN_URL . '/export', ['as' => 'export', function() {

			App::make('App\Http\Controllers\TimesheetController')->export();
		}]);

		Route::get(ADMIN_URL . '/export_overtime', ['as' => 'export_overtime', function() {

			App::make('App\Http\Controllers\OvertimeController')->export();
		}]);


		Route::get(ADMIN_URL . '/overtime', ['as' => 'overtime', function() {

			$employee 	= App::make('App\Http\Controllers\OvertimeController')->GetAll();
			$department = App::make('App\Http\Controllers\DepartmentController')->GetDepartment();

			// $search_condition	= App::make('App\Http\Controllers\OvertimeController')->Update();

			return view(ADMIN_PATH . '/overtime.overtime_list')	->with('data', $employee)
																->with('department', $department);
																// ->with('search_condition', $search_condition);
		}]);

		Route::get(ADMIN_URL . '/overtime_detail', ['as' => 'overtime_detail', function() {

			$app = App::make('App\Http\Controllers\OvertimeController')->GetOneEmp();

			return view(ADMIN_PATH . 'overtime.overtime_detail')->with('data', $app);
		}]);

		Route::get(ADMIN_URL . '/leave_request', ['as' => 'leave_request', function() {

			$employee 	= App::make('App\Http\Controllers\LeaveRequestController')->GetAll();
			$department = App::make('App\Http\Controllers\DepartmentController')->GetDepartment();


			return view(ADMIN_PATH . '/leave_request.leave_request_list')	->with('data', $employee)
																			->with('department', $department);
		}]);

		Route::get(ADMIN_URL . '/leave_request_detail', ['as' => 'leave_request_detail', function() {

			$app = App::make('App\Http\Controllers\LeaveRequestController')->GetOneEmp();

			return view(ADMIN_PATH . 'leave_request.leave_request_detail')->with('data', $app);
		}]);



		Route::get(ADMIN_URL . '/export_leave_request', ['as' => 'export_leave_request', function() {

			App::make('App\Http\Controllers\LeaveRequestController')->export();
		}]);

		Route::get(ADMIN_URL . '/export_summary', ['as' => 'export_summary', function() {

			App::make('App\Http\Controllers\SummaryController')->export();
		}]);

		Route::get(ADMIN_URL . '/register_employee', ['as' => 'register_employee', function() {

			return view(ADMIN_PATH . 'register_employee.register_employee');
		}]);

		Route::get(ADMIN_URL . '/admin-summary', ['as' => 'summary', function() {

			$employee 	= App::make('App\Http\Controllers\SummaryController')->GetAll();
			$department = App::make('App\Http\Controllers\DepartmentController')->GetDepartment();


			return view(ADMIN_PATH . '/summary.summary_list')	->with('data', $employee)
																->with('department', $department);
		}]);


		Route::get(ADMIN_URL . '/resigned-employee', ['as' => 'resigned_employee', function() {

			$employee 	= App::make('App\Http\Controllers\EmployeeController')->GetResignedEmployee();

			return view(ADMIN_PATH . '/employee.resigned_employee')	->with('data', $employee);
		}]);


		Route::get(ADMIN_URL . '/working-employee', ['as' => 'working_employee', function() {

			$employee 	= App::make('App\Http\Controllers\EmployeeController')->GetWorkingEmployee();

			return view(ADMIN_PATH . '/employee.working_employee')	->with('data', $employee);
		}]);

		Route::get(ADMIN_URL . '/working-employee-detail', ['as' => 'working_employee_detail', function() {

			$employee 	= App::make('App\Http\Controllers\EmployeeController')->GetOneEmp();

			return view(ADMIN_PATH . '/employee.working_employee_detail')	->with('data', $employee);
		}]);

		Route::get(ADMIN_URL . '/upload-file', ['as' => 'upload-file', function() {

			$app 	= App::make('App\Http\Controllers\UploadFileController')->getData();

			return view(ADMIN_PATH . '/document.upload_file')->with('data', $app);
		}]);

		Route::get(ADMIN_URL . '/upload-news', ['as' => 'get-upload-news', function() {

			return view(ADMIN_PATH . '/news.upload_news');
		}]);

		Route::get(ADMIN_URL . '/news', ['as' => 'news',  function() {

			$app = App::make('App\Http\Controllers\NewsController')->getData();

			return view(ADMIN_PATH . 'news.index')->with('data', $app);
		}]);

		Route::get(ADMIN_URL . '/setting', ['as' => 'setting',  function() {

			$results = App::make('App\Http\Controllers\SettingController')->getData();

			return view(ADMIN_PATH . 'setting.index')->with('data', $results);
		}]);

		Route::get(ADMIN_URL . '/change-password', ['as' => 'change-password',  function() {

			return view(ADMIN_PATH . 'profile.change_password');
		}]);

	});


	Route::group(['as' => ''], function() {

		Route::post(ADMIN_URL . '/timesheet_detail', ['as' => 'update', function() {

			$app = App::make('App\Http\Controllers\TimesheetController')->Update();

			return redirect()->route('adm-timesheet');
		}]);


		Route::post(ADMIN_URL . '/timesheet', ['as' => 'search', function() {

			$app 		= App::make('App\Http\Controllers\TimesheetController')->GetAllEmp(true);
			$department = App::make('App\Http\Controllers\DepartmentController')->GetDepartment();


			return view(ADMIN_PATH . 'timesheet.timesheet')->with('data', $app)
																->with('department', $department);
		}]);

		Route::post(ADMIN_URL . '/overtime', ['as' => 'overtime_search', function() {

			$app 		= App::make('App\Http\Controllers\OvertimeController')->GetAll(true);
			$department = App::make('App\Http\Controllers\DepartmentController')->GetDepartment();


			return view(ADMIN_PATH . 'overtime.overtime_list')	->with('data', $app)
																->with('department', $department);
		}]);

		Route::post(ADMIN_URL . '/overtime_detail', ['as' => 'overtime_update', function() {

			$app = App::make('App\Http\Controllers\OvertimeController')->Update();

			//dd($app);

			return redirect()->route('adm-overtime', [
														'startDate'			=> $app['search_startDate'],
														'endDate'			=> $app['search_endDate'],
														'employeeName'		=> $app['search_empName'],
														'search_approve'	=> $app['search_approve'],
														'slc_department'	=> $app['search_department'],
														'page'				=> $app['current_page']
													]);
		}]);

		Route::post(ADMIN_URL . '/leave_request', ['as' => 'leave_request_search', function() {

			$app 		= App::make('App\Http\Controllers\LeaveRequestController')->GetAll();
			$department = App::make('App\Http\Controllers\DepartmentController')->GetDepartment();


			return view(ADMIN_PATH . 'leave_request.leave_request_list')->with('data', $app)
																   		->with('department', $department);
		}]);

		Route::post(ADMIN_URL . '/leave_request_detail', ['as' => 'leave_request_update', function() {

			$app = App::make('App\Http\Controllers\LeaveRequestController')->Update();

			return redirect()->route('adm-leave_request');
		}]);

		Route::post(ADMIN_URL . '/post_register_employee', ['as' => 'post_register_employee', function() {
			$data 		= App::make('App\Http\Controllers\RegisterEmployeeController')->getDataView();
			$existed 	= array();

			$existed['existedEmail'] 	= App::make('App\Http\Controllers\RegisterEmployeeController')->checkEmail();
			$existed['existedCode'] 	= App::make('App\Http\Controllers\RegisterEmployeeController')->checkCode();

			 if( $existed['existedCode'] == true || $existed['existedEmail'] == true ){

				return view(ADMIN_PATH . 'register_employee.register_employee')->with('existed', $existed)->with('data',$data);
			 }else{

			 	$app = App::make('App\Http\Controllers\RegisterEmployeeController')->addEmployee();

				return redirect()->route('adm-register_employee');
			 }


		}]);

		Route::post(ADMIN_URL . '/admin-summary', ['as' => 'summary_search', function() {

			$app 		= App::make('App\Http\Controllers\SummaryController')->GetAll();
			$department = App::make('App\Http\Controllers\DepartmentController')->GetDepartment();


			return view(ADMIN_PATH . 'summary.summary_list')->with('data', $app)
															->with('department', $department);
		}]);

		Route::post(ADMIN_URL . '/resigned-employee', ['as' => 'resigned_employee_search', function() {

			$app 		= App::make('App\Http\Controllers\EmployeeController')->GetResignedEmployee();

			return view(ADMIN_PATH . 'employee.resigned_employee')->with('data', $app);
		}]);

		Route::post(ADMIN_URL . '/working-employee', ['as' => 'working_employee_search', function() {

			$app 		= App::make('App\Http\Controllers\EmployeeController')->GetWorkingEmployee();

			return view(ADMIN_PATH . 'employee.working_employee')->with('data', $app);
		}]);

		Route::post(ADMIN_URL . '/working_employee_update', ['as' => 'working_employee_update', function() {

			$app 		= App::make('App\Http\Controllers\EmployeeController')->Update();

			return redirect()->route('adm-working_employee_search');
		}]);

		Route::post(ADMIN_URL. '/upload', ['as' => 'upload', function() {

			$app 		= App::make('App\Http\Controllers\UploadFileController')->uploadFile();
			// $direction 	= redirect()->route('adm-upload-file');

			if ($app != false) {

				return redirect()->route('adm-upload-file');
			} else {

				return redirect()->route('adm-upload-file')->with('msg_code', '511');
			}
		}]);

		Route::post(ADMIN_URL . '/post-upload-news', ['as' => 'post-upload-news', function() {

			$app = App::make('App\Http\Controllers\NewsController')->uploadNews();

			return redirect()->route('adm-get-upload-news');
		}]);

		Route::post(ADMIN_URL . '/post-delete-file', ['as' => 'post-delete-file', function() {

			$app = App::make('App\Http\Controllers\UploadFileController')->deleteData();

			return redirect()->route('adm-upload-file');
		}]);

		Route::post(ADMIN_URL . '/post-edit-news', ['as' => 'post-edit-news', function() {

			$app = App::make('App\Http\Controllers\NewsController')->editNews();

			return redirect()->route('adm-news');
		}]);


		Route::post(ADMIN_URL . '/post-update-company-info', ['as' => 'post-update-company-info', function() {

			// $permission = HelperController::checkPermission(Auth::guard('web')->user()->roles, 'manager-agency');
			$permission = true;

			if($permission){

				$config 					= Config::get('spr.param.manage.setting.update_company_info');
				$data_output_get_param 		= App::make('Spr\Base\Controllers\Http\Request')->getDataRequest($config);
				$data_output_validate_param	= App::make('Spr\Base\Validates\Helper')->baseValidate($data_output_get_param);
				$results					= App::make('App\Http\Controllers\SettingController')->updateCompanyInfo($data_output_validate_param);

				return redirect()->back()->with('message', $results);

			}else {

				return view('errors.550');

			}
		}]);

		Route::post(ADMIN_URL . '/post-update-allowed-ip-address', ['as' => 'post-update-allowed-ip-address', function() {

			// $permission = HelperController::checkPermission(Auth::guard('web')->user()->roles, 'manager-agency');
			$permission = true;

			if($permission){

				$config 					= Config::get('spr.param.manage.setting.update_allowed_ip_address');
				$data_output_get_param 		= App::make('Spr\Base\Controllers\Http\Request')->getDataRequest($config);
				$data_output_validate_param	= App::make('Spr\Base\Validates\Helper')->baseValidate($data_output_get_param);
				$results					= App::make('App\Http\Controllers\SettingController')->updateAllowedIpAddress($data_output_validate_param);

				return redirect()->back()->with('message', $results);

			}else {

				return view('errors.550');

			}
		}]);

		Route::post(ADMIN_URL . '/post-change-admin-password', ['as' => 'post-change-admin-password', function() {

			// $permission = HelperController::checkPermission(Auth::guard('web')->user()->roles, 'manager-agency');
			$permission = true;

			if($permission){

				$config 					= Config::get('spr.param.manage.profile.change_password');
				$data_output_get_param 		= App::make('Spr\Base\Controllers\Http\Request')->getDataRequest($config);
				$data_output_validate_param	= App::make('Spr\Base\Validates\Helper')->baseValidate($data_output_get_param);
				$results					= App::make('App\Http\Controllers\UserController')->changePassword($data_output_validate_param);

				return redirect()->back()->with('message', $results);

			}else {

				return view('errors.550');

			}
		}]);

	});

	Route::group(['as' => 'ajax-'], function(){

		Route::post('data-chart', ['as' => 'data-chart', function() {

			$data = App::make('App\Http\Controllers\DashboardController')->getDataChart();

			// return json_encode($data);
			return response()->json($data);
		}]);
	});

});

// Begin for View: Front GUI
// Route::group(['as' => 'user-'], function() {
Route::group(['as' => 'user-', 'middleware' => ['checkIpAddress']], function() {

	Route::get(USER_URL . '/', ['as' => 'index', function() {
		return view(USER_PATH . 'home.index');

	}]);

	// Route::get(USER_URL . '/news', ['as' => 'news', function() {

	// 	return view(USER_PATH . 'news.index');
	// }]);


	Route::get(USER_URL . 'overtime_log', ['as' => 'overtime_log','middleware' => 'auth', function() {

		return view(USER_PATH . 'overtime.overtime_log');
	}]);


	Route::post(USER_URL . 'overtime_log/addOvertime', ['as' => 'addOvertime', function() {

		$data = App::make('App\Http\Controllers\OvertimeController')->addOvertime();

		return redirect()->route('user-overtime_log');
	}]);


	Route::get(USER_URL.'overtimeReport',['as' => 'overtimeReport','middleware' => 'auth',function(){

		$data = App::make('App\Http\Controllers\OvertimeController')->GetAll_front(true);

		return view(USER_PATH . 'overtime.overtime_report')->with('data',$data);

	}]);

	Route::post(USER_URL.'overtimeReport',['as' => 'overtimeReport',function(){

		$data = App::make('App\Http\Controllers\OvertimeController')->GetAll_front(true);

		return view(USER_PATH . 'overtime.overtime_report')->with('data',$data);

	}]);

	Route::post(USER_URL.'overtimeReport/export',['as'=>'export',function(){

		$data = App::make('App\Http\Controllers\OvertimeController')->exportOvertime();
	}]);

	Route::get(USER_URL.'leaveRequestReport',['as' => 'leaveRequestReport','middleware' => 'auth',function(){

		$data = App::make('App\Http\Controllers\LeaveRequestController')->GetAll_front(true);

		return view(USER_PATH . 'leave_request.leave_request_report')->with('data',$data);

	}]);

	Route::post(USER_URL.'leaveRequestReport',['as' => 'leaveRequestReport',function(){

		$data = App::make('App\Http\Controllers\LeaveRequestController')->GetAll_front(true);

		return view(USER_PATH . 'leave_request.leave_request_report')->with('data',$data);

	}]);

	Route::post(USER_URL.'leaveRequestReport/export',['as'=>'leaveRequestReport/export',function(){

		$data = App::make('App\Http\Controllers\LeaveRequestController')->exportLeaveRequest();
	}]);

	Route::get(USER_URL . 'timesheet_log', ['as' => 'timesheet_log','middleware' => 'auth', function() {

		$timesheet_log 	= App::make('App\Http\Controllers\TimesheetController')->getTimesheetRecent();
		$date_new_check = App::make('App\Http\Controllers\TimesheetController')->getNewestDate();
		$active_button 	= App::make('App\Http\Controllers\TimesheetController')->checkActiveButton();
		$chart 			= App::make('App\Http\Controllers\TimesheetController')->getTimesheetChart();
		$statusCheckIn 	= App::make('App\Http\Controllers\TimesheetController')->checkStatusCheckIn();
		$statusCheckOut = App::make('App\Http\Controllers\TimesheetController')->checkStatusCheckOut();


		return view(USER_PATH.'timesheet.timesheet_log')->with('data', $timesheet_log)
														->with('data_chart',$chart)
														->with('data_new', $date_new_check)
														->with('active',$active_button)
														->with('statusCheckIn',$statusCheckIn)
														->with('statusCheckOut',$statusCheckOut);

	}]);

	Route::post(USER_URL . 'timesheet_log/check-in', ['as' => 'timesheet_log/check-in', function() {

		$app = App::make('App\Http\Controllers\TimesheetController')->checkIn();

		return redirect()->route('user-timesheet_log');

	}]);

	Route::post(USER_URL . 'timesheet_log/check-out', ['as' => 'timesheet_log/check-out', function() {

		$app = App::make('App\Http\Controllers\TimesheetController')->checkOut();

		return redirect()->route('user-timesheet_log');

	}]);

	Route::get(USER_URL . 'timesheetReport', ['as' => 'timesheetReport','middleware' => 'auth', function() {

		$data=App::make('App\Http\Controllers\TimesheetController')->searchTimesheet();

		return view(USER_PATH . 'timesheet.timesheet_report')->with('data', $data);

	}]);

	Route::post(USER_URL .'timesheetReport',['as' => 'timesheetReport',function(){

		$data=App::make('App\Http\Controllers\TimesheetController')->searchTimesheet();

		return view(USER_PATH .'timesheet.timesheet_report')->with('data', $data);

	}]);

	Route::post(USER_URL .'timesheetReport/export',['as' => 'timesheetReport/export',function(){

		App::make('App\Http\Controllers\TimesheetController')->exportTimesheet();

	}]);

	Route::get(USER_URL.'leave_request_create',['as' => 'leave_request_create', function(){

		return view(USER_PATH.'leave_request.leave_request_create');

	}]);
	Route::post(USER_URL.'leave_request_create',['as' => 'add_leave_request', function(){

		$data = App::make('App\Http\Controllers\LeaveRequestController')->addLeaveRequest();

		return redirect()->route('user-leave_request_create');

	}]);


	Route::get(USER_URL . '/leave_request_detail', ['as' => 'user_leave_request_detail', function() {

		$app = App::make('App\Http\Controllers\LeaveRequestController')->GetOneEmp();

		return view(USER_PATH . 'leave_request.leave_request_detail')->with('data', $app);
	}]);

	Route::post(USER_URL . '/leave_request_detail', ['as' => 'user_leave_request_update', function() {

		$app = App::make('App\Http\Controllers\LeaveRequestController')->Update();

		return redirect()->route('user-leaveRequestReport');
	}]);


	Route::get(USER_URL . '/summary', ['as' => 'summary', function() {

		$employeeCode 	= App::make('App\Http\Controllers\SummaryController')->GetEmployeCode();
		$app 			= App::make('App\Http\Controllers\SummaryController')->GetAll(true, $employeeCode);

		return view(USER_PATH . 'summary.summary_list')->with('data', $app);
	}]);

	Route::post(USER_URL . '/summary', ['as' => 'summary_search', function() {

		$employeeCode 	= App::make('App\Http\Controllers\SummaryController')->GetEmployeCode();
		$app 			= App::make('App\Http\Controllers\SummaryController')->GetAll(true, $employeeCode);

		return view(USER_PATH . 'summary.summary_list')->with('data', $app);
	}]);

	Route::get(USER_URL . '/upload-file', ['as' => 'upload-file', function() {

		$app 			= App::make('App\Http\Controllers\UploadFileController')->GetData();

		return view(USER_PATH . 'document.upload_file')->with('data', $app);
	}]);

	Route::post(USER_URL . '/upload', ['as' => 'upload', function() {

		$app 		= App::make('App\Http\Controllers\UploadFileController')->uploadFile();
		// $direction 	= redirect()->route('adm-upload-file');

		if ($app != false) {

			return redirect()->route('user-upload-file');
		} else {

			return redirect()->route('user-upload-file')->with('msg_code', '511');
		}
	}]);

	Route::get(USER_URL . '/news', ['as' => 'news',  function() {

		$app = App::make('App\Http\Controllers\NewsController')->getData();

		return view(USER_PATH . 'news.index')->with('data', $app);
	}]);

	Route::get(USER_URL . '/change-password', ['as' => 'change-password',  function() {

		if (Auth::check()) {

			return view(USER_PATH . 'profile.change_password');
		} else {

			return view('errors.503');
		}

	}]);

	Route::post(ADMIN_URL . '/post-change-password', ['as' => 'post-change-password', function() {

		// $permission = HelperController::checkPermission(Auth::guard('web')->user()->roles, 'manager-agency');
		$permission = true;

		if($permission){

			$config 					= Config::get('spr.param.manage.profile.change_password');
			$data_output_get_param 		= App::make('Spr\Base\Controllers\Http\Request')->getDataRequest($config);
			$data_output_validate_param	= App::make('Spr\Base\Validates\Helper')->baseValidate($data_output_get_param);
			$results					= App::make('App\Http\Controllers\UserController')->changePassword($data_output_validate_param);

			return redirect()->back()->with('message', $results);

		}else {

			return view('errors.550');

		}
	}]);

});
// End Front GUI

//start Login User

	Route::get('/login', ['as' => 'login','middleware' => 'guest', function() {

		return view('pages.login.login');
	}]);

	Route::post('/login', ['as' => 'login', function() {

		$checkLogin = App::make('App\Http\Controllers\UserController')->login();

		if ($checkLogin==true) {

			return Redirect()->route('user-timesheet_log');
		}else{

			return Redirect::back()->withErrors(['email'=>'Đăng nhập thất bại, xin hãy thử lại!']);
		}

	}]);
	Route::get('/logout', ['as' => 'logout', function() {

		$app = App::make('App\Http\Controllers\UserController')->logout();

		return Redirect()->route('user-index');

	}]);


//end Login User

// start Login Admnin

	Route::get('/admin/login', ['as' => 'adminLogin','middleware' => 'guest', function() {

		return view(LOGIN_PATH . 'admin_login');

	}]);


	Route::post('/admin', ['as' => 'postLogin', function() {

			$app = App::make('App\Http\Controllers\PagesController')->postLogin();

			if($app['meta']['success'] ) {

				return redirect()->route($app['response']);
			}else {

				return Redirect::back()->withErrors(['email'=>$app['meta']['msg']]);
			}

	}]);

	Route::get('/adminLogout', ['as' => 'adminLogout', function() {

		$app = App::make('App\Http\Controllers\PagesController')->adminLogout();

		return Redirect()->route('adminLogin');

	}]);

	Route::post('/request-reset-password', ['as' => 'request-reset-password', function() {

		$config 					= Config::get('spr.param.manage.profile.request_reset_password');
		$data_output_get_param 		= App::make('Spr\Base\Controllers\Http\Request')->getDataRequest($config);
		$data_output_validate_param	= App::make('Spr\Base\Validates\Helper')->baseValidate($data_output_get_param);
		$results					= App::make('App\Http\Controllers\UserController')->requestResetPassword($data_output_validate_param);

		// return Redirect()->route('adminLogin');
		return redirect()->back()->with(['message' => $results]);

	}]);

	Route::get('reset-password', ['as' => 'reset-password', function(){

		$config 					= Config::get('spr.param.manage.profile.check_reset_password');
		$data_output_get_param 		= App::make('Spr\Base\Controllers\Http\Request')->getDataRequest($config);
		$data_output_validate_param	= App::make('Spr\Base\Validates\Helper')->baseValidate($data_output_get_param);
		$results 					= App::make('App\Http\Controllers\UserController')->checkResetPassword($data_output_validate_param);

		if ($results == true) {

			return view('pages.profile.reset_password');
		} else {

			return redirect()->route('404');
		}
	}]);

	Route::post('action-reset-password' , ['as' => 'action-reset-password', function () {

  		$config 					= Config::get('spr.param.manage.profile.action_reset_password');
		$data_output_get_param 		= App::make('Spr\Base\Controllers\Http\Request')->getDataRequest($config);
		$data_output_validate_param	= App::make('Spr\Base\Validates\Helper')->baseValidate($data_output_get_param);
        $results    			 	= App::make('App\Http\Controllers\UserController')->actionResetPassword($data_output_validate_param);

       	if ($results['meta']['success']) {

			return Redirect::route('thanks')->with('message', $results);
		} else {

			return Redirect::back()->with('message', $results);
		}
  	}]);

	Route::get('thanks', ['as' => 'thanks', function() {

		return view('success.thanks');
	}]);



//end Login Admin


	// Route::get('login2', 'LoginController@index');
	// Route::post('login2', 'LoginController@postLogin');