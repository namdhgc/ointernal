/**
Custom module for you to write your own javascript functions
**/
var Spr = function () {

    var list_input_on_form = "input[type=text],input[type=hidden], textarea, input[type=date], select, img";
    // public functions
    var clear_form = function(form, modal) {

      form[0].reset();

      var e_list = form.find(list_input_on_form);

      $.each(e_list,function(){

        if($(this).hasClass('no-clear') == false){

          $(this).val("");
          $(this).attr("src","");
        }

      });

      form.find('input:checkbox').removeAttr('checked');
      form.find('input[type=radio]').prop('checked', false);
      form.find('span[class=checked]').removeClass('checked');

      modal.modal('hide');

      $('.alert').hide();

      $('.help-block-error').remove();
      $('.form-group.form-md-line-input.has-error').removeClass("has-error");
    }
    var setting_show_message  =  function(){
      toastr.options = {
            "closeButton": true,
            "debug": false,
            "positionClass": "toast-top-right",
            "onclick": null,
            "showDuration": "1000",
            "hideDuration": "1000",
            "timeOut": "5000",
            "extendedTimeOut": "1000",
            "showEasing": "swing",
            "hideEasing": "linear",
            "showMethod": "fadeIn",
            "hideMethod": "fadeOut"
          }
    }

    var show_message = function(res) {

      var type_message = 'success';
      var show = true;
      if(!res.meta.success) type_message = 'error';
      if(res.meta.success && res.meta.msg.length == 0 ) show = false;

      if(show) {

        var msg = res.meta.msg;

        var message = '' ;
        for(var i = 0 in msg){

          message += msg[i] + "<br>";

        }

        toastr[type_message](message, "Notifications")
      }
    }

    var spr_ajax = function (url, data, callBack, elem_block_loadding)
    {
       if(elem_block_loadding != "") {
        block_element(elem_block_loadding);
       }
       $.ajax({
           method: "POST",
           url: url,
           dataType: 'json',
           data: data,
           success : function(res){

            if(res.meta != undefined){
              show_message(res);
            }
              callBack(res);
              App.unblockUI(elem_block_loadding);
           }
           ,error: function (jqXHR, exception) {
               App.unblockUI(elem_block_loadding);
               var msg = '';
               if (jqXHR.status === 0) {
                   msg = 'Not connect.\n Verify Network.';
               } else if (jqXHR.status == 404) {
                   msg = 'Requested page not found. [404]';
               } else if (jqXHR.status == 500) {
                   msg = 'Internal Server Error [500].';
               } else if (exception === 'parsererror') {
                   msg = 'Requested JSON parse failed.';
               } else if (exception === 'timeout') {
                   msg = 'Time out error.';
               } else if (exception === 'abort') {
                   msg = 'Ajax request aborted.';
               } else {
                   msg = 'Uncaught Error.\n' + jqXHR.responseText;
               }
               // Metronic.unblockUI(elem_block_loadding);
               var submit_button = $('button[type="submit"]');
               var submit_input = $('input[type="submit"]');
               var submit_link = $('a.button-submit');
               submit_button.prop('disabled', false);
               submit_input.prop('disabled', false);
               submit_link.prop('disabled', false);
           },
       });
    }

    var block_element = function (elem_block_loadding) {
        App.blockUI({
            target: elem_block_loadding,
            animate: true
        });
    }

    var fill_data = function(Elm_Data, form_class, action) {

      var data = Elm_Data.attr();
      if(form_class == undefined || form_class == null || form_class.trim() == "") form_class = "form-action";

      var form = $('.' + form_class).first();
      var modal = form.closest('div.modal');

      if(form != undefined && form.length != 0) {

          for (var key in data) {

              if(key != 'id' && key != 'class'){

                  var name = key.split("-");

                  if(name[1] != undefined && name[1] != null) {

                      var elm = form.find('[name="' + name[1] + '"]').first();

                      if(elm.prop("tagName") != undefined && elm.prop("tagName").toLowerCase() == "span" ){
                        if(elm.hasClass('format-currency')){

                          elm.attr('data-value',data[key]);

                        }else if(elm.hasClass('date-time')){

                            var dateTime = new Date(data[key] * 1000);
                            var months = ['01','02','03','04','05','06','07','08','09','10','11','12'];
                            var year = dateTime.getFullYear();
                            var month = months[dateTime.getMonth()];
                            var date = ('0' + dateTime.getDate()).slice(-2);
                            var hour = dateTime.getHours();
                            var min = dateTime.getMinutes();
                            var sec = dateTime.getSeconds();
                            if(hour < 10) hour = '0'+ hour;
                            if(min < 10) min = '0'+ min;
                            if(sec < 10) sec = '0'+ sec;

                            var time = hour + ':' + min + ':' + sec + ' ' + date + '/' + month + '/' + year  ;

                            elm.text(time);
                        }
                        else {
                          elm.text(data[key]);
                        }
                        

                      }else if(elm.prop("tagName") != undefined && elm.prop("tagName").toLowerCase() == "img" ){

                          elm.attr('src','../' + data[key] );

                      }else if(elm.prop("tagName") != undefined && elm.prop("tagName").toLowerCase() == "textarea" && elm.hasClass('ckeditor')==true){

                        CKEDITOR.instances['ckeditor'].setData(data[key]);
                      }
                      else {

                        if(elm.hasClass('date-time')){

                            var dateTime = new Date(data[key] * 1000);
                            var months = ['01','02','03','04','05','06','07','08','09','10','11','12'];
                            var year = dateTime.getFullYear();
                            var month = months[dateTime.getMonth()];
                            var date = ('0' + dateTime.getDate()).slice(-2);
                            var hour = dateTime.getHours();
                            var min = dateTime.getMinutes();
                            var sec = dateTime.getSeconds();
                            if(hour < 10) hour = '0'+ hour;
                            if(min < 10) min = '0'+ min;
                            if(sec < 10) sec = '0'+ sec;

                            var time = hour + ':' + min + ':' + sec + ' ' + date + '/' + month + '/' + year  ;

                            elm.val(time);

                          }else{

                            if(elm.is(':checkbox')){

                                var item_hide = elm.attr('data-item-relation');
                                var item_show = elm.attr('data-show');

                                if(data[key] == 1 ){

                                  elm.closest('span').attr('class','checked');
                                }else{

                                   elm.closest('span').attr('class','');
                                }
                                
                                if(item_show != undefined) {
                                    
                                  if(data[key] == item_show) {

                                    $(item_hide).show();
                                  }else {
                                    $(item_hide).hide();
                                  }
                                }
                                if(data[key] == 1) {

                                  elm.attr("checked", 'checked');
                                  elm.prop("checked", 'checked');
                                } 
                                else {
                                  elm.removeAttr("checked");
                                  elm.prop("checked", false);
                                } 
                                console.log(data[key]);
                            }else{

                              elm.val(data[key]);

                            }

                          }
                      }
                  }
              }
          }
          var title_form = form.find('span.form-title').first();

          if(action == 'edit' || action == "add"){

            form.find(":input").prop("disabled", false);
            form.find("input").prop("disabled", false);
            form.find('input[type="submit"], .btn-submit').show();
            form.valid();


          }
          else if(action == 'delete') {

            form.find(":input").prop("disabled", false);
            form.find(".btn-cancel").prop("disabled", false);
            form.find('input[type="submit"], .btn-submit').show();
          }
          else {

            form.find(":input").prop("disabled", true);
            form.find("input").prop("disabled", true);
            form.find(".btn-cancel").prop("disabled", false);
            form.find(".btn-cancel").prop("disabled", false);
            form.find('input[type="submit"], .btn-submit').hide();
          }

          if(title_form != undefined && title_form.length != 0){

            title_form.text(title_form.attr('data-title-' + action));
          }
      }

      if(modal != undefined && modal.length != 0) {
        modal.modal('show');
      }
      format_all_currency();
      return form;
    }
    var button_event = function() {

      $(document).ready(function(){

        $(document).on('click', '.btn-create-new', function() {

          var form_class = $(this).attr('data-from-action');
          var form  = $('.' + form_class).first();
          form.find('input[type="submit"], .btn-submit').show();
          if(form_class == undefined || form_class == null ) form_class = "form-action";

          var modal = $('.' + form_class).parents('.modal');

          // clear form first
          clear_form(form, modal);
          modal.modal('show');
          var title_form = modal.find('span.form-title').first();

          if(title_form != undefined && title_form.length != 0){

            title_form.text(title_form.attr('data-title-create'));
          }

          $("."+form_class+" :input").prop("disabled", false);
        });

        $(document).on('click','a.btn-submit', function() {

            var form  = $(this).closest('form');

            if( form != undefined && form.valid() ) {

                var data = form.serializeArray();
                var dataInput = {};
                var lengthData = data.length;

                for (var i = lengthData - 1; i >= 0; i--) {

                    dataInput[data[i]['name']] = data[i]['value'];
                }
            }
        });

        $(document).on('click','.btn-edit', function(e){

            e.preventDefault();

            var parent = $(this).parents('tr').first();
            var form_class = $(this).attr('data-from-action');


            fill_data(parent, form_class, "edit");

        });

        $(document).on('click','.btn-view', function(e){

            e.preventDefault();

            var parent = $(this).parents('tr').first();
            var form_class = $(this).attr('data-from-action');
            var form = fill_data(parent, form_class,  "view");
        });

        $(document).on('click','.btn-delete', function(e){

            e.preventDefault();

            var parent = $(this).parents('tr').first();
            var form_class = $(this).attr('data-from-delete');
            var form = fill_data(parent, form_class,  "delete");
        });

        $(document).on('click','.btn-add-more', function(e){

            e.preventDefault();

            var parent = $(this).parents('tr').first();
            var form_class = $(this).attr('data-from-action');
            var form = fill_data(parent, form_class,  "add");
        });

        $(document).on('click','.btn-reset', function(e){

            e.preventDefault();

            var form = $(this).closest('form');

            form[0].reset();

            var e_list = form.find(list_input_on_form);

            $.each(e_list,function(){

              if(!$(this).hasClass('no-clear')){

                var is_fix = $(this).attr('data-fix');
                if(is_fix == null || is_fix == undefined || is_fix == false){

                  $(this).val("");
                  $(this).attr("src","");

                }

              }

            });

            form.find('input:checkbox').removeAttr('checked');
            form.find('input[type=radio]').prop('checked', false);

        });

        $(document).on('click','.btn-cancel', function(e){

            e.preventDefault();

            var form = $(this).closest('form');
            var modal = $(this).closest('div.modal');
            clear_form(form, modal);

        });

        // Convert timestamp to date
        $('.date-time').each(function() {
          var value = $(this).attr('dateTime');
          var dateTime = new Date(value * 1000);
          var months = ['01','02','03','04','05','06','07','08','09','10','11','12'];
          var year = dateTime.getFullYear();
          var month = months[dateTime.getMonth()];
          var date = ('0' + dateTime.getDate()).slice(-2);
          var hour = dateTime.getHours();
          var min = dateTime.getMinutes();
          var sec = dateTime.getSeconds();
          if(hour < 10) hour = '0'+ hour;
          if(min < 10) min = '0'+ min;
          if(sec < 10) sec = '0'+ sec;

          var time = hour + ':' + min + ':' + sec + ' ' + date + '/' + month + '/' + year  ;
          $(this).text(time);
        });

      });
    }

    var addAttr = function(className, id, elmName, attr){
        var elm = document.createElement(elmName);
        elm.className = className;
        elm.id = id;
        if(attr != null && attr != undefined){

          for(var key in attr){

            elm.setAttribute(key, attr[key]);
          }
        }
        return elm;
    }

    var removeParam = function (key, sourceURL) {
      var rtn = sourceURL.split("?")[0],
          param,
          params_arr = [],
          queryString = (sourceURL.indexOf("?") !== -1) ? sourceURL.split("?")[1] : "";
      if (queryString !== "") {
          params_arr = queryString.split("&");
          for (var i = params_arr.length - 1; i >= 0; i -= 1) {
              param = params_arr[i].split("=")[0];
              if (param === key) {
                  params_arr.splice(i, 1);
              }
          }
          rtn = rtn + "?" + params_arr.join("&");
      }
      return rtn;
    }

    var  format_all_currency = function() {
      $('span.format-currency').each(function() {
            
        var price = parseFloat($(this).attr('data-value'));
        var decimal = parseInt($(this).attr('data-decimals'));

        price = Helper.formatNumber(price, decimal);
        $(this).text(price);
      });
    }

    var format_date = function(time_stemp){

          var dateTime = new Date(time_stemp * 1000);

          var year = dateTime.getFullYear();

          var month = dateTime.getMonth() + 1;

          var date = ('0' + dateTime.getDate()).slice(-2);

          var hour = dateTime.getHours();

          var min = dateTime.getMinutes();

          var sec = dateTime.getSeconds();

          var time = date + '-' + month + '-' + year + ' ' + hour + ':' + min + ':' + sec ;

        return time;
    }

    return {

        //main function
        init : function () {

            $(document).ready(function(){

              var current_url = window.location.href;
              var url = new URL(current_url);
              var current_page = url.searchParams.get('page');

              var url_not_page = removeParam('page',current_url);

              if(current_page == null || current_page == 1){

                if(current_page ==  null){
                  current_page = 1;
                }
                var page_two    = parseInt(current_page) + 1;
                var page_next   = parseInt(current_page) + 1;

                $('.page-begin').attr('href','javascript:;');
                $('.page-two').text('Prev');
                $('.page-one').attr('href',url_not_page +'&page='+ current_page);
                $('.page-one').text(current_page);

                $('.page-two').attr('href',url_not_page +'&page='+ page_two)
                $('.page-two').text(page_two);

                $('.page-next').attr('href',url_not_page +'&page='+ page_next)
                $('.page-next').text('Next');

              }else{
                var page_begin  = parseInt(current_page) - 1;
                var page_two    = parseInt(current_page) + 1;
                var page_next   = parseInt(current_page) + 1;

                $('.page-begin').attr('href',url_not_page +'&page=' + page_begin);
                $('.page-begin').text('Prev');

                $('.page-one').attr('href',url_not_page +'&page='+ current_page);
                $('.page-one').text(current_page);

                $('.page-two').attr('href',url_not_page +'&page='+ page_two)
                $('.page-two').text(page_two);

                $('.page-next').attr('href',url_not_page +'&page='+ page_next)
                $('.page-next').text('Next');
              }

              button_event();
              setting_show_message();

              $('span.format-currency').each(function() {
                var price = parseFloat($(this).attr('data-value'));
                var decimal = parseInt($(this).attr('data-decimals'));

                price = Helper.formatNumber(price, decimal);
                $(this).text(price);
                console.log(price);
              });

            });
        },

        scrollTo: function(el, offeset) {
            var pos = (el && el.size() > 0) ? el.offset().top : 0;

            if (el) {
                if ($('body').hasClass('page-header-fixed')) {
                    pos = pos - $('.page-header').height();
                } else if ($('body').hasClass('page-header-top-fixed')) {
                    pos = pos - $('.page-header-top').height();
                } else if ($('body').hasClass('page-header-menu-fixed')) {
                    pos = pos - $('.page-header-menu').height();
                }
                pos = pos + (offeset ? offeset : -1 * el.height());
            }

            $('html,body').animate({
                scrollTop: pos
            }, 'slow');
        },
        ajaxDefault : function(url, data, callBack,elem_block_loadding) {
           spr_ajax(url, data, callBack, elem_block_loadding);
        },

        createElm : function (elmName, className , id , attr){
            if(className == undefined || className == '' || className == null) className = '';
            if(id == undefined || id == '' || id == null) id = '';

          return addAttr(className, id, elmName, attr);
        },

        createTextNode : function (text){
            return document.createTextNode(text);
        },

        createErrorEmptyData : function(){

            var div = addAttr('','','div');
                var center = addAttr('','','center');
                    var b = addAttr('','','b');
                        var text = document.createTextNode('No item Found!');
                    b.appendChild(text);
                center.appendChild(b);
            div.appendChild(center);
            return div;
        },
        show_message : function(res) {

          show_message(res);
        },
        format_all_currency : function() {

          format_all_currency();
          
        },

        format_date:function(timestamp){
          return format_date(timestamp);
        },
    };

}();

/***
Usage
***/
//Custom.init();
//Custom.doSomeStuff();
