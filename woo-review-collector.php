<?php

/**
 * The plugin bootstrap file
 *
 * This file is read by WordPress to generate the plugin information in the plugin
 * admin area. This file also includes all of the dependencies used by the plugin,
 * registers the activation and deactivation functions, and defines a function
 * that starts the plugin.
 *
 * @link              https://webappick.com
 * @since             1.0.0
 * @package           Woo_Review_Collector
 *
 * @wordpress-plugin
 * Plugin Name:       WebAppick Review Collector for WooCommerce
 * Plugin URI:        woo-review-collector
 * Description:       WooCommerce Review Collector Plugin is all about collecting reviews and ratings from your WooCommerce customers by email.
 * Version:           1.2.0
 * Author:            Md. Ohidul Islam
 * Author URI:        https://webappick.com
 * License:           GPLv2 or later
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.html
 * Text Domain:       woo-review-collector
 * Domain Path:       /languages
 */

// If this file is called directly, abort.
if (!defined('WPINC')) {
    die;
}
// Exit if accessed directly
if (!defined('ABSPATH')) {
    exit;
}

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path( __FILE__ ) . 'includes/class-woo-review-collector.php';

/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-woo-feed-activator.php
 */
function activate_woo_review_collector()
{
    require plugin_dir_path(__FILE__) . 'includes/class-woo-review-collector-activator.php';
    Woo_Review_Collector_Activator::activate();
}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-woo-feed-deactivator.php
 */
function deactivate_woo_review_collector()
{
    require plugin_dir_path(__FILE__) . 'includes/class-woo-review-collector-deactivator.php';
    Woo_Review_Collector_Deactivator::deactivate();
}

register_activation_hook(__FILE__, 'activate_woo_review_collector');
register_deactivation_hook(__FILE__, 'deactivate_woo_review_collector');


# Test cron...
add_action('my_hourly_event', 'do_this_per_minute');

/** Function Send review request email via cron job
 *
 */
function do_this_per_minute() {
    #Testing review email with the duration of per hour , email will send the customer
    $engine = new Woo_Review_Collector_Engine();
    $engine->prepare_email();

    #Testing cron
    $file = WOO_REVIEW_CRON. 'cron_test.txt';
    $open = fopen( $file, "a" )
    or die();
    $previousTime = get_option('wp_my_cron_test');
    if(empty($previousTime))
    {
        $previousTime = (new DateTime("now"));
    }
    $currentTime = (new DateTime("now"));
    update_option('wp_my_cron_test',$currentTime);

    $timeInterval = $currentTime->diff($previousTime);

    $diff         = $timeInterval->format("%H:%I:%S");
    $set_File_currentTime = $currentTime->format('Y-m-d H:i:s');
    if($open){
        fwrite( $open, $set_File_currentTime." ".$timeInterval->s.PHP_EOL );
        fclose( $open );
    }

#End testing cron


}



/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.0.0
 */
function run_woo_review_collector() {

    $plugin = new Woo_Review_Collector();
    $plugin->run();

}
run_woo_review_collector();


/**
 * Save email template configuration
 */
function woo_review_collector_email_config(){

    # General setting
	if(isset($_POST['wrc_email_general_settings'])){
		if(isset($_POST['wrc_enable_email'])){
			$wrc_enable_email=sanitize_text_field($_POST['wrc_enable_email']);
		}else{
			$wrc_enable_email="off";
		}

		$wrc_start_send=sanitize_text_field($_POST['wrc_start_send']);
		$wrc_max_email=sanitize_text_field($_POST['wrc_max_email']);
		$wrc_interval=sanitize_text_field($_POST['wrc_interval']);

		$wrc_email_from_name=sanitize_text_field($_POST['wrc_email_from_name']);
		$wrc_email_from_email=sanitize_text_field($_POST['wrc_email_from_email']);

		$wrc_email_smtp_host=sanitize_text_field($_POST['wrc_email_smtp_host']);
		$wrc_email_smtp_port=sanitize_text_field($_POST['wrc_email_smtp_port']);
		$wrc_email_smtp_username=sanitize_text_field($_POST['wrc_email_smtp_username']);
		$wrc_email_smtp_password=sanitize_text_field($_POST['wrc_email_smtp_password']);

		update_option('wrc_email_from_name',$wrc_email_from_name);
		update_option('wrc_email_from_email',$wrc_email_from_email);
		update_option('wrc_enable_email',$wrc_enable_email);
		update_option('wrc_start_send',$wrc_start_send);
		update_option('wrc_max_email',$wrc_max_email);
		update_option('wrc_interval',$wrc_interval);

		update_option('wrc_email_smtp_host',$wrc_email_smtp_host);
		update_option('wrc_email_smtp_port',$wrc_email_smtp_port);
		update_option('wrc_email_smtp_username',$wrc_email_smtp_username);
		update_option('wrc_email_smtp_password',$wrc_email_smtp_password);
	}

	# Template Settings
    if(isset($_POST['wrc_settings_submit'])){

        $wrc_email_subject=sanitize_text_field($_POST['wrc_email_subject']);
        $wrc_email_body=sanitize_text_field(preg_replace("/\r\n|\r|\n/",'-|-',$_POST['wrc_email_body']));
        $wrc_email_signature=sanitize_text_field(preg_replace("/\r\n|\r|\n/",'-|-',$_POST['wrc_email_signature']));

        update_option('wrc_email_subject',$wrc_email_subject);
        update_option('wrc_email_body',$wrc_email_body);
        update_option('wrc_email_signature',$wrc_email_signature);
    }

    # Save balcklist emails to update_option
    if(isset($_POST['wrc_blackList_submit'])){
        $blackListEmail = sanitize_textarea_field($_POST['wrc_review_collection_email_blacklist']);
        $blackListEmail = str_replace(' ', '', $blackListEmail);
        $afterExplodeBlackListEmail = explode(',',$blackListEmail);
        $afterExplodeBlackListEmail = array_unique($afterExplodeBlackListEmail);
        update_option('WRC_review_collection_email_blacklist',$afterExplodeBlackListEmail);
    }

    require plugin_dir_path(__FILE__) . 'admin/partials/woo-review-collector-admin-display.php';
}

/**
 * Review Analysis
 */
function woo_review_collector_stat(){
    require plugin_dir_path(__FILE__) . 'admin/partials/woo-review-collector-admin-stats.php';
}


/**
 * Save order info to WRC table
 * @param $order_id
 */

#TODO
add_action('woocommerce_order_status_completed','woo_review_collector_process_order_for_review');
function woo_review_collector_process_order_for_review($order_id){
    global $wpdb;
    $orderInfo=wc_get_order($order_id);
    $items=$orderInfo->get_items();

    $order_date=$orderInfo->get_date_completed();
    $wrc_max_email = get_option('wrc_max_email');
    $wrc_start_send = get_option('wrc_start_send');
    $temp_max_email = $wrc_max_email;
    if(!empty($items)){
        $chooseOneNumberToSendEmail = rand(1,count($items));
        $productCount = 1;
        foreach($items as $key=>$value){
            if($chooseOneNumberToSendEmail == $productCount){
                $wrc_max_email = $temp_max_email;
                $next_sent_date= $order_date;

                $sent_date  = woo_review_date_extend($next_sent_date,$wrc_start_send);
                $nonce=get_option('WRC_NONCE');
                $wpdb->insert(
                    $wpdb->prefix."woo_review_collector",
                    array(
                        'order_date' => $order_date,
                        'sent_date'  => $sent_date,
                        'order_id'   => $order_id,
                        'product_id' => $value['product_id'],
                        'nonce'      => $nonce
                    ),
                    array(
                        '%s',
                        '%s',
                        '%d',
                        '%d',
                        '%s',
                    )
                );

            }
            $productCount++;
        }
    }
}

/** Get Extended Order Date
 * @param $date
 * @param $days
 * @return bool|string
 */
function woo_review_date_extend($date,$days){
    if(!$days){
        return $date;
    }
    $date = strtotime("+".$days."days", strtotime($date));
    return  date("Y-m-d", $date);

}

/**
 * Process Review Form Submit
 */

add_action('admin_post_nopriv_woo-review-collector', 'woo_review_collector_save_review'); // If the user is logged in
add_action('admin_post_woo-review-collector', 'woo_review_collector_save_review'); // If the user in not logged in
function woo_review_collector_save_review($order_id ){
    # Save Review


    if( isset( $_POST['wrc_review_submit'] ) ) {
        $engine=new Woo_Review_Collector_Engine();
        $engine->save_review();
        wp_redirect("http://woo.reviews/r/thankyou");
    }

}

/**
 *  Function Send review request email via cron job
 *
 */
function woo_review_collector_get_products_for_review(){
 //  $engine=new Woo_Review_Collector_Engine();
  // $engine->prepare_email();
}

# Custom Cron Recurrences
function WRC_cron_job_custom_recurrence($schedules)
{
    $schedules['woo_review_collector_corn'] = array(
        'display' => __('Woo Review Collector Interval', 'woo-review-collector'),
        'interval' => 3600,
    );

    return $schedules;
}

function wp_test_cron_job_set_interval($schedules){
        $schedules['woo_test_cron'] = array(
            'display'  => esc_html__( 'Every One hourly' ),
            'interval' => 3600,
    );
        return $schedules;
}

# Update the schedule interval
add_filter('cron_schedules', 'WRC_cron_job_custom_recurrence');
add_filter('cron_schedules', 'wp_test_cron_job_set_interval');
add_action('woo_review_collector_update', 'woo_review_collector_get_products_for_review');

/* Send Test email
 *
 * @return array
 */
add_action('wp_ajax_send_test_email', 'woo_review_collector_sent_test_email');
function woo_review_collector_sent_test_email()
{

    check_ajax_referer('wrc_test_email_nonce');
    $engine    = new Woo_Review_Collector_Engine();
    $testEmail = $engine->send_test_email(sanitize_text_field($_POST['email']));

    if(!$testEmail){
        return wp_send_json(array('status' => false));
    }else{
        return wp_send_json(array('status' => true));
    }

    wp_die();
}


add_action('wp_ajax_black_list_email_removing', 'woo_review_collector_black_list_email_removing');
/**  For Blacklist email removing by ajax call
 *   Email will be removed if Exists
 *
 */
function woo_review_collector_black_list_email_removing()
{

    check_ajax_referer('wrc_black_list_email_removing_nonce');
    $removeEmail = sanitize_text_field($_POST['email']);
    $check = 0;
    $getAllBlackListEmail = get_option('WRC_review_collection_email_blacklist');
    $index = array_search($removeEmail, $getAllBlackListEmail);
    if($index !== false){
        unset($getAllBlackListEmail[$index]);
        $remaining_email = array_values($getAllBlackListEmail);
        update_option('WRC_review_collection_email_blacklist',$remaining_email);
        $check = 1;
    }

    if(!$check){
        return wp_send_json(array('status' => false));
    }else{
        return wp_send_json(array('status' => true,'remaining_email'=>implode(',',$remaining_email)));
    }

    wp_die();
}



add_action('wp_ajax_rating_action', 'woo_review_rating_action');
function woo_review_rating_action(){
    check_ajax_referer('wrc_test_email_nonce');
    $engine=new Woo_Review_Collector_Engine();
    $result=$engine->webappick_review_count();
    echo  wp_json_encode($result);
    wp_die();
}


add_action('wp_ajax_review_action', 'woo_review_review_action');
function woo_review_review_action(){
    check_ajax_referer('wrc_test_email_nonce');
    $engine=new Woo_Review_Collector_Engine();
    $review_performance=$engine->review_performance();

    $start    = new DateTime('11 months ago');
    $start->modify('first day of this month');
    $end      = new DateTime();
    $interval = new DateInterval('P1M');
    $period   = new DatePeriod($start, $interval, $end);
    $monthsyears=array();
    $months=array();
    foreach ($period as $dt) {
        array_push($monthsyears,$dt->format('F Y'));
        array_push($months,$dt->format('M'));
    }
    $exist_year_array=array();
    $exist_month_array=array();
    foreach($review_performance as $key=>$review){
        array_push($exist_year_array,$review['monthyear']);
        array_push($exist_month_array,$review['MONTH']);
    }
    $notyearmonthexists=array_diff($monthsyears,$exist_year_array);
    $notemonthexists=array_diff($months,$exist_month_array);

    foreach ($notyearmonthexists as  $index => $value) {
        $a['NUMBEROFCOMMENT']=0;
        $a['monthyear']=$notyearmonthexists[$index];
        $a['MONTH']=$notemonthexists[$index];
        array_push($review_performance,$a);
    }

   function sortFunction( $a, $b ) {
       return strtotime($a["monthyear"]) - strtotime($b["monthyear"]);
   }

   usort($review_performance, "sortFunction");
   echo  wp_json_encode($review_performance);
   wp_die();
}

function woo_review_admin_notice() {
	$m      = get_option('WRC-MEL');
	$status = get_option('WRC-MEL_notice');

	$month=date('M Y');
	if($m[$month] >= 20 && !$status){

	?>
		<div class="notice notice-warning is-dismissible wrc_monthly_review_limit">
			<p><?php _e( 'Your monthly review request limit exceed!', 'woo-review-collector' ); ?></p>
		</div>
	<?php
	}
}
add_action( 'admin_notices', 'woo_review_admin_notice' );


function woo_review_dismiss_admin_notice(){

	if($_POST['notice_status'] && $_POST['notice_status']==1){
		update_option('WRC-MEL_notice',1);
		wp_send_json_success(array('status'=>true));
	}
	wp_send_json_error(array('status'=> false));
	wp_die();
}

add_action('wp_ajax_dismiss_admin_notice','woo_review_dismiss_admin_notice');

