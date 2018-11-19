/**
Custom module for you to write your own javascript functions
**/
var UpdateSetting = function () {

    // public functions
    return {

        //main function

        init: function () {

            $(document).ready(function(){

                var form  = $('#form-update-setting');
                var rules = {

                    image: {
                        // required: true
                    },
                    company_name: {
                        maxlength: 200,
                        required: true
                    },
                    email: {
                        maxlength: 100,
                        required: true,
                        email: true,
                    },
                    phone_number: {
                        maxlength: 20,
                        required: true
                        // number: true,
                    },
                    address: {
                        maxlength: 200,
                        required: true
                    },
                    // description: {
                    //     maxlength: 500,
                    //     required: true
                    // }
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