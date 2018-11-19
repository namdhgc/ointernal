/**
Custom module for you to write your own javascript functions
**/
var UpdateAllowedIpAddress = function () {

    // public functions
    return {

        //main function

        init: function () {

            $(document).ready(function(){

                var form  = $('#form-update-allowed-ip-address');
                var rules = {

                    allowed_ip_address: {
                        required: true
                    },
                }
                Validate.base_validate(form, rules);
            });
        },
    };

}();

/***
Usage
***/
//Custom.init();
//Custom.doSomeStuff();