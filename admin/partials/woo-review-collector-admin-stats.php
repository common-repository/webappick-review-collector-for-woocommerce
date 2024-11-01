<?php
    $Woo_Review_Collector_Engine=new Woo_Review_Collector_Engine();
    $review_performance=$Woo_Review_Collector_Engine->review_performance();
?>

<div class="wrap">
    <div class="wrc-stat-group">
        <div class="wrc-stat fl">
            <div class="wrc-heading">
                <?php _e('Review Performance','woo-review-collector') ?>
            </div>
            <div class="wrc-content">
               <div id="reviewchart" style="width:100%; height:300px;"></div>
            </div>
        </div>
        <div class="wrc-stat fr">
            <div class="wrc-heading">
                <?php _e('Rating Performance','woo-review-collector') ?>
            </div>
            <div class="wrc-content">
                <div id="ratingchart" style="width:100%; height:300px;"></div>
            </div>
        </div>
    </div>

    <div class="wrc-stat-group">

        <div class="wrc-stat-review">
            <div class="approved-review">
                <p> <?php _e('Approved Review','woo-review-collector') ?> </p>
                <div class="number">
                    <?php
                        $webappick_approved_reviewd=$Woo_Review_Collector_Engine->approved_reviewd();
                       // print_r($webappick_approved_reviewd);
                        _e($webappick_approved_reviewd,'woo-review-collector');
                    ?>
                </div>
            </div>
            <div class="approved-review">
                <p> <?php _e('unsubscribe Review','woo-review-collector') ?> </p>
                <div class="number">
                    <?php
                        $unsubscribe_users= get_option('wrc_unsubscribe_total_users_count');
                        _e($unsubscribe_users,'woo-review-collector');
                    ?>
                </div>
            </div>
            <div class="approved-review">
                <p> <?php _e(' Pending Review','wcr') ?></p>
                <div class="number">
                    <?php
                        $webappick_unapproved_review=$Woo_Review_Collector_Engine->unapproved_reviewd();
                        _e($webappick_unapproved_review,'woo-review-collector');
                    ?>
                </div>
            </div>
        </div>
    </div>


    <div class="wrc-stat-group review_tabs">

        <ul class="wcr_tabs">
            <li class="wcr_tab_link current" data-tab="wcr_tab1"> <?php _e('Top Rated', 'woo-review-collector'); ?>    </li>
            <li class="wcr_tab_link" data-tab="wcr_tab2"> <?php _e('Lowest Rated', 'woo-review-collector'); ?> </li>
        </ul>

        <div id="wcr_tab1" class="wcr-tab-content current">
            <?php echo $Woo_Review_Collector_Engine->toprated_product('DESC'); ?>
         </div>

        <div id="wcr_tab2" class="wcr-tab-content">
            <?php echo $Woo_Review_Collector_Engine->toprated_product('ASC'); ?>
        </div>
    </div>



</div>

<script>

    (function($) {

        var wrc_reviewStatData;

        $.when(wrc_get_review_data()).done(function () {
            var reviewschart = AmCharts.makeChart( "reviewchart", {
                "type": "serial",
                "addClassNames": true,
                "theme": "light",
                "autoMargins": false,
                "marginLeft": 30,
                "marginRight": 8,
                "marginTop": 10,
                "marginBottom": 26,
                "categoryField": "MONTH",
                "balloon": {
                    "adjustBorderColor": false,
                    "horizontalPadding": 10,
                    "verticalPadding": 8,
                    "color": "#ffffff"
                },
                "startDuration": 1,
                "graphs": [{
                    "alphaField": "alpha",
                    "balloonText": "<span style='font-size:12px;'>[[title]] in [[category]]:<br><span style='font-size:20px;'>[[value]]</span> [[additional]]</span>",
                    "fillAlphas": 1,
                    "lineAlpha": 0.8,
                    "type": "column",
                    "title": "NUMBEROFCOMMENT",
                    "valueField": "NUMBEROFCOMMENT",

                }, {
                    "id": "graph2",
                    "balloonText": "<span style='font-size:12px;'>[[title]] in [[category]]:<br><span style='font-size:20px;'>[[value]]</span> [[additional]]</span>",
                    "bullet": "round",
                    "lineThickness": 3,
                    "bulletSize": 7,
                    "bulletBorderAlpha": 1,
                    "bulletColor": "#FFFFFF",
                    "useLineColorForBulletBorder": true,
                    "bulletBorderThickness": 3,
                    "fillAlphas": 0,
                    "lineAlpha": 1,
                    "title": "NUMBEROFCOMMENT",
                    "valueField": "NUMBEROFCOMMENT",
                    "dashLengthField": "dashLengthLine",

                } ]
            });

            reviewschart.dataProvider = wrc_reviewStatData;
            reviewschart.validateNow();
        });




        function wrc_get_review_data() {
           return $.ajax({
                type: 'POST',
                url: wrc_test_email_ajax_obj.wrc_test_email_ajax_url,
                data: {
                    action: 'review_action',
                    _ajax_nonce: wrc_test_email_ajax_obj.nonce //nonce
                },
                dataType: 'json',
                success: function (data) {
                    wrc_reviewStatData = data;
                }
            });
        }



    })(jQuery);
</script>
