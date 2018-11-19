/**
Custom module for you to write your own javascript functions
**/
var Validate = function () {

    var elem_block_loadding;
    var elm_active;

    $.validator.addMethod("valueNotEquals", function(value, element, arg){
      return arg !== value;
     }, "Value must not equal arg.");

    var basic_validate = function (form, rules) {

        var elm_error   = $('.alert-danger', form);
        var elm_success = $('.alert-success', form);

        form.validate({

            doNotHideMessage: true, //this option enables to show the error/success messages on tab switch.
            errorElement: 'span', //default input error message container
            errorClass: 'help-block help-block-error', // default input error message class
            focusInvalid: false, // do not focus the last invalid input
            rules: rules,
            lang: 'vi',
            ignore: ".ignore", // using for Google captcha hidden field

            errorPlacement: function (elm_error, element) { // render error placement for each input type

                if (element.attr("name") == "gender") { // for uniform radio buttons, insert the after the given container

                    elm_error.insertAfter("#form_gender_error");

                } else if (element.attr("name") == "payment[]") { // for uniform checkboxes, insert the after the given container

                    elm_error.insertAfter("#form_payment_error");

                } else {
                    elm_error.insertAfter(element); // for other inputs, just perform default behavior
                }
            },

            invalidHandler: function (event, validator) { //display error alert on form submit

                elm_success.hide();
                elm_error.show();
                Spr.scrollTo(elm_error, -200);
            },

            highlight: function (element) { // hightlight error inputs

                $(element)
                    .closest('.form-group').removeClass('has-success').addClass('has-error'); // set error class to the control group
            },

            unhighlight: function (element) { // revert the change done by hightlight

                $(element)
                    .closest('.form-group').removeClass('has-error'); // set error class to the control group
            },

            success: function (label) {

                if (label.attr("for") == "gender" || label.attr("for") == "payment[]") { // for checkboxes and radio buttons, no need to show OK icon

                    label
                        .closest('.form-group').removeClass('has-error').addClass('has-success');
                    label.remove(); // remove error label here

                } else { // display success icon for other inputs

                    label
                        .addClass('valid') // mark the current input as valid and display OK icon
                    .closest('.form-group').removeClass('has-error').addClass('has-success'); // set success class to the control group
                }
            }
        });
    }
    // public functions
    return {

        //main function

        base_validate: function (form, rules) {

            basic_validate(form, rules);
       }
    };

}();

/***
Usage
***/
//Custom.init();
//Custom.doSomeStuff();
