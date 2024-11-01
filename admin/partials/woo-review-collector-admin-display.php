<?php

/**
 * Provide a email template configuration view for the plugin
 *
 * @link       https://webappick.com
 * @since      1.0.0
 *
 * @package    Woo_Review_Collector
 * @subpackage Woo_Review_Collector/admin/partials
 */
?>
<?php
    $wrc_enable_email = esc_attr(get_option('wrc_enable_email'));
    $wrc_product_photo = esc_attr(get_option('wrc_product_photo'));
    $wrc_start_send = esc_attr(get_option('wrc_start_send'));
    $wrc_max_email = esc_attr(get_option('wrc_max_email'));
    $wrc_interval = esc_attr(get_option('wrc_interval'));
    $wrc_email_subject = esc_attr(stripslashes(get_option('wrc_email_subject')));
    $wrc_email_body = esc_attr(stripslashes(get_option('wrc_email_body')));
    $wrc_email_signature = esc_attr(stripslashes(get_option('wrc_email_signature')));
    $wrc_email_from_name=esc_attr(get_option('wrc_email_from_name'));
    if(!$wrc_email_from_name){
        $wrc_email_from_name=get_option('blogname');
    }
    $wrc_email_from_email=esc_attr(get_option('wrc_email_from_email'));

    # Get SMTP Info
    $wrc_email_smtp_host=esc_attr(get_option('wrc_email_smtp_host'));
    $wrc_email_smtp_port=esc_attr(get_option('wrc_email_smtp_port'));
    $wrc_email_smtp_username=esc_attr(get_option('wrc_email_smtp_username'));
    $wrc_email_smtp_password=esc_attr(get_option('wrc_email_smtp_password'));

?>
<div class="wrap">
    <!--     Review messages-->
    <h2><?php echo _e('WooCommerce Review Collector', 'woo-review'); ?></h2>
    <?php echo WRC_ReviewMessage()->infoMessage1(); ?>
    <!-- Tab Design Start     -->
    <ul class="webappick_tabs">
            <li>
                <input type="radio" name="webappick_tabs" id="tab1" checked/>
                <label class="webappick-tab-name" for="tab1"><?php echo _e('General', 'webappick-review-collector-for-woocommerce'); ?></label>
                <div id="webappick-tab-content1" class="webappick-tab-content">
                    <div class="wrap">
                        <form method="post" action="">
                            <table class="widefat fixed" border="0">
                                <thead>
                                    <tr>
                                        <th colspan="2" class="row-title" width="30%">
                                            <strong><?php esc_attr_e('General Settings', 'woo-review-collector'); ?></strong></th>
                                    </tr>
                                </thead>
                                <tbody>
                                <tr>
                                    <td class="row-title"><?php esc_attr_e('Enable Email', 'woo-review-collector'); ?></td>
                                    <td>
                                        <fieldset>
                                            <legend class="screen-reader-text"><span></span></legend>
                                            <label for="users_can_register">
                                                <input name="wrc_enable_email" type="checkbox"
                                                       id="users_can_register" <?php if ($wrc_enable_email && $wrc_enable_email == 'on') echo "checked"; ?> />
                                                <span><?php esc_attr_e('Enable to send email', 'woo-review-collector'); ?></span>
                                            </label>
                                        </fieldset>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="row-title"><?php esc_attr_e('Send After: ', 'woo-review-collector'); ?></td>
                                    <td><input type="text" name="wrc_start_send"
                                               value="<?php echo ($wrc_start_send) ? $wrc_start_send : ''; ?>"
                                               class="small-text"/> <?php esc_attr_e(' days of the purchase', 'woo-review-collector'); ?>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="row-title"><?php esc_attr_e('Max Email to Send: ', 'woo-review-collector'); ?></td>
                                    <td><input type="text" name="wrc_max_email" id="wrc_max_email"
                                               value="1" class="small-text"/></td>
                                </tr>
                                <tr style="display: none">
                                    <td class="row-title"><?php esc_attr_e('Email Interval: ', 'woo-review-collector'); ?></td>
                                    <td><input type="text" name="wrc_interval" value="<?php echo ($wrc_interval) ? $wrc_interval : ''; ?>"
                                               class="small-text"/> <?php esc_attr_e('Days', 'woo-review-collector'); ?></td>
                                </tr>


                                </tbody>
                                <tfoot>

                                </tfoot>
                            </table>
                            <br>
                            <table class="widefat fixed">
                                <thead>
                                <tr>
                                    <th colspan="2" width="30%"><strong><?php esc_attr_e('SMTP Settings', 'woo-review-collector'); ?></strong></th>
                                </tr>
                                </thead>
                                <tbody>
                                <tr>
                                    <td class="row-title"><?php esc_attr_e('From Email: ', 'woo-review-collector'); ?></td>
                                    <td><input value="<?php echo ($wrc_email_from_email) ? $wrc_email_from_email : ''; ?>"
                                                autocomplete="off" placeholder="" type="text" required name="wrc_email_from_email"/></td>
                                </tr>


                                <tr>
                                    <td class="row-title"><?php esc_attr_e('From Name: ', 'woo-review-collector'); ?></td>
                                    <td><input value="<?php echo ($wrc_email_from_name) ? $wrc_email_from_name : ''; ?>" autocomplete="off" placeholder="" type="text"
                                               required name="wrc_email_from_name"/></td>
                                </tr>
                                <tr>
                                    <td class="row-title"><?php esc_attr_e('SMTP  Host: ', 'woo-review-collector'); ?></td>
                                    <td><input value="<?php echo ($wrc_email_smtp_host) ? $wrc_email_smtp_host : ''; ?>" autocomplete="off" placeholder="" type="text"
                                               required name="wrc_email_smtp_host"/></td>
                                </tr>
                                <tr>
                                    <td class="row-title"><?php esc_attr_e('SMTP Port: ', 'woo-review-collector'); ?></td>
                                    <td><input value="<?php echo ($wrc_email_smtp_port) ? $wrc_email_smtp_port : ''; ?>" autocomplete="off" placeholder="" type="text"
                                               required name="wrc_email_smtp_port"/></td>
                                </tr>
                                <tr>
                                    <td class="row-title"><?php esc_attr_e('SMTP Username: ', 'woo-review-collector'); ?></td>
                                    <td><input value="<?php echo ($wrc_email_smtp_username) ? $wrc_email_smtp_username : ''; ?>" autocomplete="off" placeholder="" type="text"
                                               required name="wrc_email_smtp_username"/></td>
                                </tr>
                                <tr>
                                    <td class="row-title"><?php esc_attr_e('SMTP Password: ', 'woo-review-collector'); ?></td>
                                    <td><input value="<?php echo ($wrc_email_smtp_password) ? $wrc_email_smtp_password : ''; ?>" autocomplete="off" placeholder="" type="password"
                                               required  name="wrc_email_smtp_password"/></td>
                                </tr>
                                <tr>
                                    <td><input type="submit" name="wrc_email_general_settings" class="button button-primary" value="Save Seetings"></td>
                                    <td></td>
                                </tr>
                                </tbody>

                            </table>
                            <br>

                        </form>
                    </div>

                </div>
            </li>
        <li>
            <input type="radio" name="webappick_tabs" id="tab2"/>
            <label class="webappick-tab-name" for="tab2"><?php echo _e('EMAIL', 'webappick-review-collector-for-woocommerce'); ?></label>

            <div id="webappick-tab-content2" class="webappick-tab-content">
                <div class="wrap">
                    <form action="" method="post">
                        <div id="col-container">
                            <div class="woo_review_left">
                                <div class="col-wrap">
                                    <div class="email_setting_table_dv">
                                        <table class="widefat email_setting_table" border="0">
                                            <thead>
                                            <tr>
                                                <th colspan="2" class="row-title">
                                                    <strong><?php esc_attr_e('Email Settings', 'woo-review-collector'); ?></strong></th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            <tr>
                                                <td class="row-title"><?php esc_attr_e('Email Subject: ', 'woo-review-collector'); ?></td>
                                                <td><input value="<?php echo ($wrc_email_subject) ? $wrc_email_subject : ''; ?>"
                                                           style="width: 100%;height: 30px;" autocomplete="nope"
                                                           placeholder="Review your recent purchase at {store_name}" type="text"
                                                           name="wrc_email_subject"/></td>
                                            </tr>
                                            <tr>
                                                <td class="row-title"><?php esc_attr_e('Email Body: ', 'woo-review-collector'); ?></td>
                                                <td><textarea
                                                            placeholder="Hi {Customer}, <?php echo "\n"; ?>You've recently bought {product}, what do you think about it?"
                                                            name="wrc_email_body" id="wrc_email_body" style="width: 100%"
                                                            rows="5"><?php echo ($wrc_email_body) ? preg_replace("/-\\|-/", "\n", $wrc_email_body) : ''; ?></textarea>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="row-title"><?php esc_attr_e('Email Signature: ', 'woo-review-collector'); ?></td>
                                                <td><textarea placeholder="We really appreciate your feedback and hope to see you again
Thank you from {store_name}" name="wrc_email_signature" style="width: 100%" id="wrc_email_signature"
                                                              rows="5"><?php echo ($wrc_email_signature) ? preg_replace("/-\\|-/", "\n", $wrc_email_signature) : ''; ?></textarea>
                                                </td>
                                            </tr>

                                            <tr>

                                                <td> </td>

                                                <td>
                                                    <strong><?php esc_attr_e('{customer}', 'woo-review-collector'); ?></strong>
                                                    <strong><?php esc_attr_e('{product}', 'woo-review-collector'); ?>
                                                        <strong><?php esc_attr_e('{description}', 'woo-review-collector'); ?></strong>
                                                        <strong><?php esc_attr_e('{order_id}', 'woo-review-collector'); ?></strong>
                                                        <strong><?php esc_attr_e('{order_date}', 'woo-review-collector'); ?></strong>
                                                        <strong><?php esc_attr_e('{store_name}', 'woo-review-collector'); ?></strong>
                                                </td>
                                            </tr>
                                            </tbody>
                                            <tfoot>


                                            <tr>
                                                <td></td>
                                                <td>
                                                    <input class="button-primary" type="submit" name="wrc_settings_submit"
                                                           value="<?php esc_attr_e('Save Setting'); ?>"/>
                                                    <input class="button-primary" id="sendTestEmail" type="button" name="test-wrc-email"
                                                           value="<?php esc_attr_e('Send Test Email'); ?>"/>
                                                </td>
                                            </tr>
                                            <tr style="display: none;" id="testEmailSection">
                                                <td ></td>
                                                <td>
                                                    <input type="email" value="" name="wrc-test-email" id="wrc-test-email" style="height:30px" autocomplete="nope"
                                                           placeholder="Enter email" class="regular-text" ><br>
                                                    <input style="margin-top: 8px;" class="button-primary" type="button" name="send-wrc-email-test"
                                                           id="send-wrc-email-test" value="<?php esc_attr_e('Send'); ?>"/  >
                                                    <div  id="testEmailStatusSection"></div>
                                                </td>

                                            </tr>
                                            </tfoot>
                                        </table>

                                    </div>

                                </div>
                                <!-- /col-wrap -->
                            </div>
                            <!-- /col-left -->
                            <div class="woo_review_right">
                                <div class="col-wrap">
                                    <div class="email_table_bg" style="width: 100%; margin: 0 auto">
                                        <table class="" style="width: 100%">
                                            <thead>
                                            <tr style="padding:10px;background: #fff;">
                                                <th class="row-title" style="text-align:left;display: block;padding: 10px; ">
                                                    <strong><?php esc_attr_e('Email Preview', 'woo-review-collector'); ?></strong></th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            <tr>
                                                <td colspan="2">



                                                    <table cellspacing="0" class="main-table email_table_view"
                                                           style=" background-color: #ffffff; width: 100%; max-width: 600px; margin: 30px auto 5px auto; border-radius: 5px; -webkit-border-radius: 5px; -moz-border-radius: 5px; border-collapse: collapse;box-sizing: content-box">
                                                        <tbody>


                                                        <tr>
                                                            <td style="height:30px;background-color: #f2f2f2;color:#676a6c;text-align: center;font-size: small;  padding: 20px 5px 10px 5px;">
                                                                If you're having problem to see or submit this email, please <a href="$shorturl">review here</a>.
                                                            </td>
                                                        </tr>

                                                        <td class="main-td" style="font-family: Arial; font-family: inherit; color: #676a6c; padding: 0;display: block;">
                                                            <table width="100%" style="border: 2px solid #cbcbcb;">
                                                                <tbody style="margin-top: 20px;">
                                                                <tr >
                                                                    <td width="5%" style="font-family: Arial; font-family: inherit; color: #676a6c"></td>
                                                                    <td style="background-color: white;font-size: 12px;    margin-top: 20px;display: block;"
                                                                        id="emailBodyShow"> <?php echo ($wrc_email_body) ? preg_replace("/-\\|-/", "<br/>", $wrc_email_body) : "Hi Customer,<br/>You've recently bought {product}, what do you think about it?"; ?> </td>
                                                                    <td width="5%" style="font-family: Arial; font-family: inherit; color: #676a6c"></td>
                                                                </tr>


                                                                <tr>
                                                                    <td width="5%" style="font-family: Arial; font-family: inherit; color: #676a6c"></td>
                                                                    <td style="text-align: center;font-size: 20px;color: #393939;padding-top: 50px;">Click below to Rate (1-5) </td>
                                                                    <td width="5%" style="font-family: Arial; font-family: inherit; color: #676a6c"></td>
                                                                </tr>

                                                                <tr>
                                                                    <td style="height: 30px;"></td>
                                                                </tr>

                                                                <tr>
                                                                    <td width="5%" style="font-family: Arial; font-family: inherit; color: #676a6c"></td>
                                                                    <td width="90%"
                                                                        style="font-family: Arial; font-family: inherit; color: #676a6c; color: #FDC705; direction: ltr; text-align: center">
                                                                        <a href="" style="color:#FDC705;display: inline-block; font-size: 60px; text-decoration: none; margin-right: 5px;">&#9734; <span style="display: block;font-size: 12px;color: #000;padding-top: 15px;"> 1</span> </a>
                                                                        <a href="" style="color:#FDC705;display: inline-block; font-size: 60px; text-decoration: none; margin-right: 5px;">&#9734; <span style="display: block;font-size: 12px;color: #000;padding-top: 15px;"> 2</span> </a>
                                                                        <a href="" style="color:#FDC705;display: inline-block; font-size:60px; text-decoration: none; margin-right: 5px;">&#9734; <span style="display: block;font-size: 12px;color: #000;padding-top: 15px;"> 3</span> </a>
                                                                        <a href="" style="color:#FDC705;display: inline-block; font-size: 60px; text-decoration: none; margin-right: 5px;">&#9734; <span style="display: block;font-size: 12px;color: #000;padding-top: 15px;"> 4</span> </a>
                                                                        <a href="" style="color:#FDC705;display: inline-block; font-size: 60px; text-decoration: none; margin-right: 5px;">&#9734; <span style="display: block;font-size: 12px;color: #000;padding-top: 15px;"> 5</span> </a>
                                                                    </td>
                                                                    <td width="5%" style="font-family: Arial; font-family: inherit; color: #676a6c"></td>
                                                                </tr>


                                                                <tr>
                                                                    <td style="height: 30px;"></td>
                                                                </tr>
                                                                </tbody>
                                                            </table>
                                                        </td>
                                                        </tr>




                                                        <tr>
                                                            <td id="emailSignatureShow"style="height:30px;background-color: #f8f8f8;text-align: center;font-size: small;line-height: 150%;border: 2px solid #d8d8d8;border-top: none;">
                                                                <p><?php echo ($wrc_email_signature) ? preg_replace("/-\\|-/", "<br/>", $wrc_email_signature) : "We really appreciate your feedback and hope to see you again.<br/><br/>Thank you from {store_name}"; ?></p>
                                                            </td>
                                                        </tr>





                                                        </tbody>

                                                        <tfoot style="height:30px;background-color: #f2f2f2;color:#676a6c;text-align: center;font-size: small;  padding: 20px 5px 10px 5px;">
                                                        <tr>
                                                            <td> <p style="text-align: center;font-size: 8px;margin:5px;padding:0;font-weight: bold;">
                                                                    <a href="$unsubscribeUrl" target="_blank">Unsubscribe</a>
                                                                </p></td>
                                                        </tr>

                                                        <tr>
                                                            <td>  <p style="margin:5px;padding:0;text-align: center;color:#1cc286!important;font-family: 'Roboto', sans-serif;font-weight:500;font-size:12px">
                                                                    <b><a style="text-decoration:none;color: #000000;font-size: 8px;"
                                                                          href="https://webappick.com/plugin/woocommerce-review-collector-pro/" target="_blank">Powered by <br/> <span
                                                                                    style="font-size: 8px;color:#1cc286;"> WooCommerce Review Collector Pro </span> <br/> <br/>
                                                                        </a></b>
                                                                </p>
                                                            </td>
                                                        </tr>
                                                        </tfoot>
                                                    </table>

                                                </td>
                                            </tr>
                                            </tbody>
                                        </table>

                                        <br/>

                                        <br/>

                                    </div>
                                </div>
                                <!-- /col-wrap -->
                            </div>
                            <!-- /col-right -->
                        </div>
                        <!-- /col-container -->

                    </form>
                </div>

            </div>
        </li>
            <li>
                <input type="radio" name="webappick_tabs" id="tab3"/>
                <label class="webappick-tab-name" for="tab3"><?php echo _e('BlackList', 'webappick-review-collector-for-woocommerce'); ?></label>

                <div id="webappick-tab-content3" class="webappick-tab-content">
                    <div class="wrap">
                        <form action="" method="post">
                            <table class="widefat">
                                <thead>
                                    <tr>
                                        <th colspan="2" class="row-title">
                                            <strong><?php esc_attr_e('BlackList', 'woo-review-collector'); ?></strong></th>
                                    </tr>
                                </thead>
                                <tbody>

                                <tr valign="top">
                                    <td scope="row"><label for="tablecell"><?php esc_attr_e(
                                                'Blacklist Emails', 'woo-review-collector'
                                            ); ?></label></td>
                                    <td>
                                     <textarea id="wrc_review_collection_email_blacklist" name="wrc_review_collection_email_blacklist" value="" cols="54" rows="10"><?php
                                         if(!empty(get_option('WRC_review_collection_email_blacklist')))
                                            echo esc_attr(implode(',',get_option('WRC_review_collection_email_blacklist')));
                                    ?></textarea>
                                    </td>
                                </tr>
                                <tr valign="top">
                                    <td scope="row"> </td>
                                    <td ><input type="submit" name="wrc_blackList_submit" class="button button-primary" value="Save"/></td>
                                </tr>
                                <tr>
                                    <td scope="row"><label for="tablecell"><?php esc_attr_e(
                                                'Remove Blacklist Email', 'woo-review-collector'
                                            ); ?></label></td>
                                    <td>
                                        <input type="email" name="wrc_review_remove_blackList_email" id="wrc_blackList_email_input" placeholder="Enter Email " value="<?php echo esc_attr(get_option('WRC_review_remove_blackList_email'))?>" class="regular-text" style="width: 45%" />
                                    </td>
                                </tr>
                                <tr valign="top">
                                    <td scope="row"> </td>
                                    <td >
                                        <input type="button" class="button-primary " id="wrc_remove_blockList" value="Remove"/>
                                        <div  id="wrc_blackListEmailStatus"></div>
                                    </td>
                                </tr>

                                </tbody>
                            </table>
                        </form>
                    </div>

                </div>
            </li>

    </ul>
    <!--   Tab Design End   -->

</div>