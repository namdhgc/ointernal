<?php
namespace Spr\Base\Controllers\Views;

// use App\Validate\ValidateMedia;

use App\Http\Controllers\Controller;
use Config;
use Lang;

class DataTable extends Controller {

	public function __construct () {

	}

	//insert
	public static function dataInformation($data){

		$html = '<div class="data-info">';
		$formItem = 0;

		if(!empty($data) && !empty($data['data']['response'])){

			$total = 0;
			$toItem = 0;
			$formItem = 0;

			if(isset($data['limit']) && (is_numeric($data['limit']) || $data['limit'] = '')) {

				$total = $data['data']['response']->total();
				$toItem = (int)$data['data']['response']->perPage() * (int)$data['data']['response']->currentPage();
				$formItem = (int)$data['data']['response']->perPage() * ( (int)$data['data']['response']->currentPage() - 1) + 1;

			}else {

				$total = COUNT($data['data']['response']);
				$toItem = $total;
				$formItem = 1;
			}

			$html .= Lang::get('paginate.show').'
			<span data-format="number" data-value="'.$formItem.'">'.$formItem.'</span>
			'.Lang::get('paginate.to').'
			<span data-format="number" data-value="'.$toItem.'">'.$toItem.'</span>
			'.Lang::get('paginate.of').'
			<span data-format="number" data-value="'.$total.'">'.$total.'</span>
			'.Lang::get('paginate.records').'';
		}else {

			$html .= 'Showing 0 to 0 of 0 records';
		}

		$html .= "</div>";
		return array('html' => $html, 'formItem' => $formItem);
	}

	public static function headerCellTable ($data, $label, $class = '', $sort = '', $colspan = '', $rowspan = ''){

		$html = '';
		if($colspan != '') $colspan = "colspan='".$colspan."'";
		if($rowspan != '') $rowspan = "rowspan='".$rowspan."'";
		if($label == 'checkbox') {
			return '<th '.$colspan.' '.$rowspan.' un-sort"><input type="checkbox" class="'.$class.'"></th>';
		}
		if($sort != ''){

			$url = '';
			$param = '';
			$step = '&';
			if(isset($data['limit']) && (is_numeric($data['limit']) || $data['limit']=='')) {

				$url = $data['data']['response']->url($data['data']['response']->currentPage());

			}else {
				$url = explode('?', $_SERVER['REQUEST_URI'])[0].'?';
				$step = "";
			}

			foreach ($data as $key => $value) {
				if($key != 'data' && $key != 'sort' && $key != 'sort_type' && $key != "categories"){
					if(is_array($value)){
						if($key == 'userActive'){
							$param .= $step.$key.'='.implode(',', $value);
							$step = '&';
						}else {
							foreach ($value as $_key => $_value) {
								if(is_array($_value)) break;
								$param .= $step.$key.'['.$_key.']='.$_value;
								$step = '&';
							}
						}
					}else {

						$param .= $step.$key.'='.$value;
						$step = '&';
					}
				}
			}

			if($data['sort'] != $sort){
				$param .= '&sort='.$sort.'&sort_type=ASC';
				$html = '<th '.$colspan.' '.$rowspan.' class="'.$class.' sorting"><a href="'.$url.$param.'"><span>'.$label.'</span></a></th>';
			}else {
				if($data['sort_type'] == 'ASC'){
					$param .= '&sort='.$sort.'&sort_type=DESC';
					$html = '<th '.$colspan.' '.$rowspan.' class="'.$class.' sorting_asc"><a href="'.$url.$param.'"><span>'.$label.'</span></a></th>';
				}else {
					$param .= '&sort='.$sort.'&sort_type=ASC';
					$html = '<th '.$colspan.' '.$rowspan.' class="'.$class.' sorting_desc"><a href="'.$url.$param.'"><span>'.$label.'</span></a></th>';
				}
			}
		}else {
			$html = '<th '.$colspan.' '.$rowspan.' class="'.$class.' un-sort"><a href="javascript:void(0)"><span>'.$label.'</span></a></th>';
		}
		return $html;
	}

	public static function attrData ($dataRow) {

		$dataString = '';

		foreach ($dataRow as $key => $value) {

			if($key != "deleted_at" && $key != "updated_at") {
				// if(strpos($key,"_at") > 0){

				// 	$value = date('m/d/Y h:i:s',(int)$value + );
				// }
				$dataString .= "data-" . $key . "='" . $value . "' ";
			}
		}
		return $dataString;
	}

	public static function paginate ($data) {

		$tableInformation = DataTable::dataInformation($data);
        $formItem = $tableInformation['formItem'];
		$paginate = $tableInformation['html'];

		if(!empty($data)){
			$listParam = [];

			foreach ($data as $key => $value) {

				if($key != "meta" && $key != "response" && $key != 'data') {

					$listParam[$key] = $value;
				}
			}

			$paginate .= $data['data']['response']->appends($listParam)->render();
		}

		return $paginate;
	}

}