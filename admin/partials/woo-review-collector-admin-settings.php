<?php

/**
 * Provide a admin area view for the plugin settings
 *
 * This file is used to markup the admin-facing aspects of the plugin.
 *
 * @link       https://webappick.com
 * @since      1.0.0
 *
 * @package    Woo_Review_Collector
 * @subpackage Woo_Review_Collector/admin/partials
 */
?>
<h2><?php _e( 'Woo Review Collector Settings', 'woo-review-collector' ); ?></h2>
<div class="wrap">
    <form action="" method="post">
    <table class="form-table">
        <tr valign="top">
            <td scope="row"><label for="tablecell"><?php esc_attr_e(
                        'Manual Review Tab Hashtag', 'woo-review-collector'
                    ); ?></label></td>
            <td>
                <input type="text" name="wrc_review_tab" value="<?php echo esc_attr(get_option('wrc_review_tab'))?>" class="regular-text" />
            </td>
        </tr>
        <tr valign="top">
            <td scope="row"><label for="tablecell"><?php esc_attr_e(
                        'Review Success message Page URL', 'woo-review-collector'
                    ); ?></label></td>
            <td>
                <input type="text" name="wrc_thanks_you_page" value="<?php echo esc_attr(get_option('WRC_thanks_you_page_ID'))?>" class="regular-text" />
            </td>
        </tr>
        <tr valign="top">
            <td scope="row"><label for="tablecell"><?php esc_attr_e(
                        'Unsubscription Success Message Page', 'woo-review-collector'
                    ); ?></label></td>
            <td>
                <input type="text" name="wrc_unsubscription_page" value="<?php echo esc_attr(get_option('WRC_unsubscription_page_ID'))?>" class="regular-text" />
            </td>
        </tr>
        <tr valign="top">
            <td scope="row"><label for="tablecell"><?php esc_attr_e(
                        'Start collecting review form last 1 month orders', 'woo-review-collector'
                    ); ?></label></td>
            <td>
                <input type="checkbox" name="wrc_review_collection_from" class="regular-text" <?php echo (get_option('wrc_review_collection_from')=='on')?'checked':""?> />
            </td>
        </tr>
        <tr valign="top">
            <td scope="row"><label for="tablecell"><?php esc_attr_e(
                        'Blacklist Emails', 'woo-review-collector'
                    ); ?></label></td>
            <td>
                <textarea id="wrc_review_collection_email_blacklist" name="wrc_review_collection_email_blacklist" value="" cols="54" rows="10"><?php
                    echo esc_attr(implode(',',get_option('WRC_review_collection_email_blacklist')));
                    ?></textarea>
            </td>
        </tr>
        <tr>
        <td scope="row"><label for="tablecell"><?php esc_attr_e(
                    'Remove Blacklist Email', 'woo-review-collector'
                ); ?></label></td>
        <td>
            <input type="email" name="wrc_review_remove_blackList_email" id="wrc_blackList_email_input" placeholder="Enter Email " value="<?php echo esc_attr(get_option('WRC_review_remove_blackList_email'))?>" class="regular-text" style="width: 45%" />
            <input type="button" class="button-primary " id="wrc_remove_blockList" value="Remove"/>
            <div  id="wrc_blackListEmailStatus"></div>
        </td>
        </tr>
<!--        <tr  valign="top">-->
<!--            <td>-->
<!---->
<!--            </td>-->
<!--            <td >-->
<!--                <input type="button" class="button-primary" value="Remove" style="float: left; margin-left: 280px; overflow: hidden">-->
<!--            </td>-->
<!--        </tr>-->

<!--        <tr>-->
<!--            <td></td>-->
<!--            <td>-->
<!--                <input class="button-primary" id="sendTestEmail" type="button" name="test-wrc-email"-->
<!--                       value="--><?php //esc_attr_e('Remove BlackList Email'); ?><!--"/>-->
<!--            </td>-->
<!--        </tr>-->
<!--        <tr style="display: none;" id="testEmailSection">-->
<!--            <td ></td>-->
<!--            <td>-->
<!--                <input type="email" value="" name="wrc-test-email" id="wrc-test-email" style="height:30px" autocomplete="off"-->
<!--                       placeholder="Enter email" class="regular-text"><br>-->
<!--                <input style="margin-top: 8px;" class="button-primary" type="button" name="send-wrc-email-test"-->
<!--                       id="send-wrc-email-test" value="--><?php //esc_attr_e('Remove'); ?><!--"/  >-->
<!--                <div  id="testEmailStatusSection"></div>-->
<!--            </td>-->
<!---->
<!--        </tr>-->
        <tr valign="top">
            <td scope="row"> </td>
            <td ><input type="submit" name="wrc_settings_submit" class="button button-primary" value="Save Settings"/></td>
        </tr>
    </table>
    </form>
</div>
