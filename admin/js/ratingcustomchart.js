(function($) {

   var chart=AmCharts.makeChart("ratingchart", {
        "type": "serial",
        "theme": "dark",
       "autoMargins": false,
       "marginLeft": 60,
       "marginRight": 8,
       "marginTop": 10,
       "marginBottom": 26,
        "categoryField": "rating",
        "startDuration": -5,
        rotate: true,
        "categoryAxis": {
           "gridPosition": "start",
           "axisAlpha": 0,
           "tickLength": 0
        },

        "valueAxes": [{
            "minimum": 0,
           "gridColor": "#FFFFFF",
           "gridAlpha": 0.2,
           "dashLength": 0,
            "gridCount": 10,
        }],

        "graphs": [{
            type: "column",
            valueField: "rate",
            fillAlphas:1,
            balloonText: "<span style='font-size:13px;color:#000000'>[[title]] in [[category]]:<b>[[value]]</b></span>",
            label:"rating",
            "labelText": "[[value]]",
            "labelPosition": "right",
            "colorField": "color",
            "showAllValueLabels": true,
            "color": "#00000"
        }]
    });



    $.ajax({
        type: 'POST',
        url: wrc_test_email_ajax_obj.wrc_test_email_ajax_url,
        data: {
            action: 'rating_action',
            _ajax_nonce: wrc_test_email_ajax_obj.nonce,
        },
        dataType: 'json',
        success: function (data) {
            console.log(data);
            if(typeof data==='object'){
                chart.dataProvider = data;
                chart.validateNow();
            }
        }
    });


})(jQuery);


