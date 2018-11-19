var ChartsAmcharts = function() {

    var callbackLoadDataAnalyticsTotalEnergy = function(resutls) {

       var $data ;
       if(resutls.meta.success && resutls.response.length > 0) {

           $data = resutls.response;
       }

       console.log($data);


       var chart = AmCharts.makeChart("late_time_chart", {

           "type": "serial",
           "theme": "light",

           "fontFamily": 'Open Sans',
           "color":    '#888888',

           "legend": {
               "equalWidths": false,
               "useGraphSettings": true,
               "valueAlign": "left",
               "valueWidth": 120
           },
           "dataProvider": $data,
           "valueAxes": [{
               "id": "usedAxis",
               "axisAlpha": 0,
               "gridAlpha": 0,
               "position": "left",
               "title": "Số người đi muộn"
           }],
           "graphs": [{
               "bullet": "square",
               "bulletBorderAlpha": 1,
               "bulletBorderThickness": 1,
               "dashLengthField": "dashLength",
               "legendValueText": "[[value]]",
               "title": "Số người đi muộn",
               "fillAlphas": 0,
               "valueField": "late_employee",
               "valueAxis": "usedAxis"
           }],
           "chartCursor": {
               "categoryBalloonDateFormat": "DD",
               "cursorAlpha": 0.1,
               "cursorColor": "#000000",
               "fullWidth": true,
               "valueBalloonsEnabled": false,
               "zoomable": false
           },
           "dataDateFormat": "YYYY-MM-DD",
           "categoryField": "date",
           "categoryAxis": {
               "dateFormats": [{
                   "period": "DD",
                   "format": "DD"
               }, {
                   "period": "WW",
                   "format": "MMM DD"
               }, {
                   "period": "MM",
                   "format": "MMM"
               }, {
                   "period": "YYYY",
                   "format": "YYYY"
               }],
               "parseDates": true,
               "autoGridCount": false,
               "axisColor": "#555555",
               "gridAlpha": 0.1,
               "gridColor": "#000000",
               "gridCount": 50
           },
           "exportConfig": {
               "menuBottom": "20px",
               "menuRight": "22px",
               "menuItems": [{
                   "format": 'png'
               }]
           }
       });
   }


    return {
        //main function to initiate the module

        init: function(data) {

            var url     = $('#late_time_chart').attr('data-url');
            Spr.ajaxDefault(url, {}, callbackLoadDataAnalyticsTotalEnergy,".block-main");
        }

    };

}();
