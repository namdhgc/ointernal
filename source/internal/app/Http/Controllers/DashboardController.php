<?php

namespace App\Http\Controllers;

use Spr\Base\Response\Response;
use App\Http\Controllers\Controller;
use App\Http\Controllers\TimesheetController as ControllerTimesheet;
use App\Http\Models\Dashboard as ModelDashboard;
use Input;
use Auth;
use Config;
use DB;
use Lang;

class DashboardController extends Controller
{

	public function getDataChart() {

		$resutls 		= Response::response();
        $h          	= "7";// Hour for time zone goes here e.g. +7 or -4, just remove the + or -
        $hm         	= $h * 60;
        $ms         	= $hm * 60;
        $gmdate     	= gmdate("m/d/Y g:i:s A", time() + $ms);
        $array_date    	= array();
        $count      	= Config::get('mycnf.count_late_day');

        for ($i = $count; $i > 0 ; $i--) {
            $now = date('Y-m-d', strtotime('-'.$i.' days', strtotime($gmdate)));
            array_push($array_date, array(
                'date'       		=> $now,
                'late_employee' 	=> 0,
            ));
        }

        $now = date('Y-m-d', strtotime($gmdate));
        array_push($array_date, array(
            'date'       => $now,
            'late_employee' 	=> 0,
        ));

        $ModelDashboard  		= new ModelDashboard();
        $ControllerTimesheet 	= new ControllerTimesheet();
        $timesheet_data 		= $ControllerTimesheet->GetAllEmp($paginate = false);
        
        foreach ($array_date as $d_key => $d_value) {
        	
        	foreach ($timesheet_data['response'] as $ts_key => $ts_value) {
        		
        		if ($ts_value->date == $d_value['date']) {
        			
        			if ($ts_value->lateTime != 0) {
        				
        				$array_date[$d_key]['late_employee']++;
        			}
        		}
        	}
        }

        // dd($array_date);
        $resutls['response'] = $array_date;

        return $resutls;
	}
}