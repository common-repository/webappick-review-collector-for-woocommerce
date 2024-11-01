<?php

/**
 * Fired during plugin deactivation
 *
 * @link       https://webappick.com
 * @since      1.0.0
 *
 * @package    Woo_Review_Collector
 * @subpackage Woo_Review_Collector/includes
 */

/**
 * Fired during plugin deactivation.
 *
 * This class defines all code necessary to run during the plugin's deactivation.
 *
 * @since      1.0.0
 * @package    Woo_Review_Collector
 * @subpackage Woo_Review_Collector/includes
 * @author     Md. Ohidul Islam <wahid0003@gmail.com>
 */
class Woo_Review_Collector_Deactivator
{

    /**
     * Short Description. (use period)
     *
     * Long Description.
     *
     * @since    1.0.0
     */
/*    public static function deactivate()
    {
        # Delete Cron Schedule
        wp_clear_scheduled_hook('woo_review_collector_update');

        # Delete Plugin Pages
        $thanks_page = get_option('WRC_thanks_you_page_ID');
        $unsubscribe_page = get_option('WRC_unsubscription_page_ID');
        wp_delete_post($thanks_page, false);
        wp_delete_post($unsubscribe_page, false);
    }*/


    public static function deactivate()
    {
        # Delete Cron Schedule
        wp_clear_scheduled_hook('woo_review_collector_update');
        wp_clear_scheduled_hook('my_hourly_event');
        # Delete Plugin Pages
        $thanks_page = get_option('WRC_thanks_you_page_delete_ID');
        $unsubscribe_page = get_option('WRC_unsubscription_page_delete_ID');
        delete_option('WRC_thanks_you_page_ID');
        delete_option('WRC_unsubscription_page_ID');
        delete_option('WRC_thanks_you_page_delete_ID');
        delete_option('WRC_unsubscription_page_delete_ID');
        wp_delete_post($thanks_page, false);
        wp_delete_post($unsubscribe_page, false);
    }

}
