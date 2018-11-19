$(document).ready(function() {

	var count_record = $('#count').val();

	if (count_record == 0) {

		$('#btn_export').css('background-color', 'gray');

		$('#btn_export').bind('click', function(e){

		 	e.preventDefault();
		})

	}


	$('.btn_reset').on("click", function() {

		var form = $(this).closest('form');

		form.find("input[type=text], textarea").val("");
		form.find("input[type=date]").val("");
		form.find('select').val('');

		form.find('input:checkbox').removeAttr('checked');
		form.find('input[type=radio]').prop('checked', false);
	});


	$('#btn_back').on("click", function() {
		window.history.back();
	});


	// $('#btn_search').on("click", function() {
	// 	App.blockUI({

	// 	    target: ".search_form",
	// 	    animate: !0
	// 	}), window.setTimeout(function() {

	// 	    App.unblockUI(".search_form")
	// 	}, 1e3)
	// });

	// $('#btn_export').on("click", function() {
	// 	App.blockUI({

	// 	    target: ".search_form",
	// 	    animate: !0
	// 	}), window.setTimeout(function() {

	// 	    App.unblockUI(".search_form")
	// 	}, 1e3)
	// });

	var blockUI_elements = 'input[type=submit], input[type=button]';

	$(blockUI_elements).on("click", function() {
		App.blockUI({

		    target: ".search_form",
		    animate: !0
		}), window.setTimeout(function() {

		    App.unblockUI(".search_form")
		}, 1e3)
	});

	$(blockUI_elements).on("click", function() {
		App.blockUI({

		    target: ".submit_form",
		    animate: !0
		}), window.setTimeout(function() {

		    App.unblockUI(".submit_form")
		}, 1e3)
	});


	$('#btn_search').on("click", function(e) {

		var startDate 	= $("#startDate").val();
		var endDate 	= $("#endDate").val();
		var form 		= $(this).closest('form');

		if (startDate != '' && endDate != '') {

			if (startDate > endDate) {

	    		e.preventDefault();
	    		$('#date_notification').text(end_time_after_start_time);
			} else {

				$(form).on("submit", function() {

					$('#btn_search').attr("disabled","disabled");
				});

				$('#btn_search').attr("type","submit");
			}
		} else {
			$(form).on("submit", function() {

				$('#btn_search').attr("disabled","disabled");
			});

			$('#btn_search').attr("type","submit");
		}
	});

	$('#startTime').on("change", function(event) {

		get_estimate_time();
	});

	$('#endTime').on("change", function(event) {

		get_estimate_time();
	});
});


function get_estimate_time() {

	var date 			= $("#date").val();
	var endTime 		= $('#endTime').val();
	var startTime 		= $('#startTime').val();
	var startWorkTime	= $("#start_work_time").val();


	if ( date == null || date == '') {

		date = 'December 29, 2016 ';
	}

	var start_time 		= new Date(date + ' ' + startTime);
	var end_time 		= new Date(date + ' ' + endTime);
	var diff		 	= end_time - start_time;

	var seconds			= Math.floor(diff/1000);
	var minutes			= Math.floor(seconds/60);
	var hours			= Math.floor(minutes/60);
	seconds 			= seconds % 60;
	minutes 			= minutes % 60;

	if (startWorkTime != null && startWorkTime != '') {

		var pos 			= startWorkTime.indexOf(".");

		if (pos >= 0) {

			var start_h		= startWorkTime.substring(0, pos);
			var start_m		= startWorkTime.substring(pos, startWorkTime.length);
		} else {

			var start_h		= startWorkTime
			var start_m		= 0;
		}

		var start_work_time 	= new Date (date + ' ' + start_h + ':' + start_m * 60);
		var late_time_diff 		= start_time - start_work_time;

		var late_time_seconds	= Math.floor(late_time_diff/1000);
		var late_time_minutes	= Math.floor(late_time_seconds/60);
		var late_time_hours		= Math.floor(late_time_minutes/60);
		late_time_seconds		= late_time_seconds % 60;
		late_time_minutes		= late_time_minutes % 60;

		if (late_time_minutes >= 0 && late_time_minutes < 10) {

			$('#late_time').text(late_time_hours + ":0" + late_time_minutes);
		} else {

			$('#late_time').text(late_time_hours + ":" + late_time_minutes);
		}
	}

	if (minutes >= 0 && minutes < 10) {

		$('#estimate_time').text(hours + ":0" + minutes);
	} else {

		$('#estimate_time').text(hours + ":" + minutes);
	}


}



