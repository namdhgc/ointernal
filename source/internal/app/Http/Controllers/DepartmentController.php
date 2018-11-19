<?php

namespace App\Http\Controllers;

use App\Http\Models\Department;

class DepartmentController extends Controller
{

    public function GetDepartment() {

		$data = Department::GetDepartment();

		return $data;
	}
}