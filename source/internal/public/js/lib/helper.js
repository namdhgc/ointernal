/**
NamDH
**/

var Helper = function() {

	var formatNumber = function (number, decimals)
	{

	    var number = number.toFixed(decimals) + '';
	    var x = number.split('.');
	    var x1 = x[0];
	    var x2 = x.length > 1 ? ',' + x[1] : '';
	    var rgx = /(\d+)(\d{3})/;
	    while (rgx.test(x1)) {
	        x1 = x1.replace(rgx, '$1' + '.' + '$2');
	    }
	    return x1 + x2;
	}

	var getURLParameter = function(name) {

  		return decodeURIComponent((new RegExp('[?|&]' + name + '=' + '([^&;]+?)(&|#|;|$)').exec(location.search) || [null, ''])[1].replace(/\+/g, '%20')) || null;
	}

	return {

		ResetValue: function() {

			$(document).on('click','.btn_reset', function() {

                var form = $(this).closest('form');

				form.find("input[type=text]").val("");
				form.find("input[type=date]").val("");
				form.find('select').val('');

				form.find('input:checkbox').removeAttr('checked');
				form.find('input[type=radio]').prop('checked', false);

            });
		},

		mapMessage: function(msg) {

			var map_message = 	msg.map(function(elem){

		              				return elem;
		          				}).join(".");
			return map_message;
		},
		formatNumber: function(number, decimals) {
			return formatNumber(number, decimals);
		},
		getURLParameter: function(param) {

			return getURLParameter(param);
		}
	};
}();