<?php

/**
 * Fired during plugin activation
 *
 * @link       https://webappick.com
 * @since      1.0.0
 *
 * @package    Woo_Review_Collector
 * @subpackage Woo_Review_Collector/includes
 */

/**
 * Fired during plugin activation.
 *
 * This class defines all code necessary to run during the plugin's activation.
 *
 * @since      1.0.0
 * @package    Woo_Review_Collector
 * @subpackage Woo_Review_Collector/includes
 * @author     Md. Ohidul Islam <wahid0003@gmail.com>
 */
class Woo_Review_Collector_Activator
{

    /**
     * Short Description. (use period)
     *
     * Long Description.
     *
     * @since    1.0.0
     */
	

    public static function activate()
    {
        # Schedule Cron
        wp_schedule_event(time(), 'woo_review_collector_corn', 'woo_review_collector_update');

        #Test scheduling cron
        wp_schedule_event(time(), 'woo_test_cron', 'my_hourly_event');

        #Add default nonce randomly
        $nonce = md5(uniqid(rand(0,500), true));
        update_option('WRC_NONCE',$nonce);

	    update_option("WRC-MEL",array(date('M Y')=>0));
        update_option('wrc_review_tab', "#tab-reviews");
        update_option('wrc_enable_email', "on");
        update_option('wrc_start_send', "7");
        update_option('wrc_max_email', "1");
        update_option('wrc_interval', "5");
        update_option('wrc_email_subject', "Review your recent purchase at {store_name}");
        update_option('wrc_email_body', "Hi {Customer},-|-You've recently bought {product}, what do you think about it?");
        update_option('wrc_email_signature', "We really appreciate your feedback and hope to see you again.-|-Thank you from {store_name}");

        # Create woo_review_collector_db_version plugin Table
        global $wpdb;
        $woo_review_collector_db_version = "1.0";

        $table_name = $wpdb->prefix . 'woo_review_collector';

        $charset_collate = $wpdb->get_charset_collate();

        $sql = "CREATE TABLE IF NOT EXISTS $table_name (
                  id bigint(20) unsigned NOT NULL AUTO_INCREMENT,
                  order_date date DEFAULT NULL,
                  sent_date date DEFAULT NULL,
                  reviewed_date date DEFAULT NULL,
                  order_id bigint(20) DEFAULT NULL,
                  product_id bigint(20) DEFAULT NULL,
                  status varchar(45) DEFAULT 'Sent',
                  rating tinyint(1) DEFAULT NULL,
                  nonce varchar(255) DEFAULT NULL,
                  total_sent int(20) DEFAULT '0',
                  PRIMARY KEY (id)
                ) $charset_collate;";

        require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
        dbDelta($sql);

        add_option('woo_review_collector_db_version', $woo_review_collector_db_version);


    }


}
