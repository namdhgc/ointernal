(function(old) {


  // Get all attr
  $.fn.attr = function() {

    if(arguments.length === 0) {

      if(this.length === 0) {

        return null;
      }

      var obj = {};

      $.each(this[0].attributes, function() {

        if(this.specified) {

          obj[this.name] = this.value;
        }

      });

      return obj;

    }

    return old.apply(this, arguments);
  };

})($.fn.attr);

$(function() {
    $.ajaxSetup({
        headers: {
            'X-CSRF-Token': $('meta[name="_token"]').attr('content'),
        }
    });

    var beforePrint = function() {
        $('.print-preview').addClass("hide");
    };

    var afterPrint = function() {
        $('.print-preview').removeClass("hide");
    };

    if (window.matchMedia) {
        var mediaQueryList = window.matchMedia('print');
        mediaQueryList.addListener(function(mql) {
            if (mql.matches) {
                beforePrint();
            } else {
                afterPrint();
            }
        });
    }

    window.onbeforeprint = beforePrint;
    window.onafterprint = afterPrint;

}());
(function($) {
    $.fn.goTo = function() {
        $('html, body').animate({
            scrollTop: $(this).offset().top + 'px'
        }, 'fast');
        return this; // for chaining...
    }
})(jQuery);

(function ($) {
    $.extend({
        playSound: function () {
            var loop = '';
            if(arguments[1] != undefined && arguments[1]) loop = 'loop="true"';
            if($('embed [src="' + arguments[0] + '"]').length == 0) {

              return $(
                     '<audio class="sound-player" autoplay="autoplay" style="display:none;" '+loop+'>'
                       + '<source src="' + arguments[0] + '" />'
                       + '<embed src="' + arguments[0] + '" hidden="true" autostart="true" '+loop+'/>'
                     + '</audio>'
                   ).appendTo('body');
            }
        },
        stopSound: function () {
            $(".sound-player").remove();
        }
    });
})(jQuery);

$(function(){
  $(window).scroll(function(){
    var aTop = $('.home-cate-block').height();
    var window_scroll = $(this).scrollTop();

    var id_banner = 0;
    $('.home-cate-block').each(function() {

      if ($(window).scrollTop() + $(window).height() >= $(this).offset().top) {
        id_banner= $(this).attr('id');
      } 
    });
    $('ul.menu-list li').removeClass('is-active');
    $('a[data-link="#'+id_banner+'"]').first().parent('li').first().addClass('is-active');
    
  });
});