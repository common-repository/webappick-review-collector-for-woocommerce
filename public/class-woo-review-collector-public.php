<?php

/**
 * The public-facing functionality of the plugin.
 *
 * @link       https://webappick.com
 * @since      1.0.0
 *
 * @package    Woo_Review_Collector
 * @subpackage Woo_Review_Collector/public
 */

/**
 * The public-facing functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    Woo_Review_Collector
 * @subpackage Woo_Review_Collector/public
 * @author     Md. Ohidul Islam <wahid0003@gmail.com>
 */
class Woo_Review_Collector_Public {

	/**
	 * The ID of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $plugin_name    The ID of this plugin.
	 */
	private $plugin_name;

	/**
	 * The version of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $version    The current version of this plugin.
	 */
	private $version;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0.0
	 * @param      string    $plugin_name       The name of the plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version = $version;

	}

	/**
	 * Register the stylesheets for the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_styles() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Woo_Review_Collector_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Woo_Review_Collector_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/woo-review-collector-public.css', array(), $this->version, 'all' );

	}

	/**
	 * Register the JavaScript for the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Woo_Review_Collector_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Woo_Review_Collector_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/woo-review-collector-public.js', array( 'jquery' ), $this->version, false );

	}
}

if (isset($_GET['wrc_action']) && $_GET['wrc_action']=="wrc-review-collector-unsubscribe") {

    if($_GET['wrc_order_id']!='test'){
        global $wpdb;
        $order = sanitize_text_field($_GET['wrc_order_id']);
        if(!empty($order)){
            $status = $wpdb->delete( $wpdb->prefix."woo_review_collector", array( 'order_id' => $order ), array( '%d' ) );
            if($status){
                $db_unsubscribe_users = get_option('wrc_unsubscribe_total_users_count');
                if(!$db_unsubscribe_users){
                    $db_unsubscribe_users = 1;
                }else{
                    $db_unsubscribe_users += 1 ;
                }
                update_option('wrc_unsubscribe_total_users_count',$db_unsubscribe_users);
            }
        }
    }
    $location=get_option('WRC_unsubscription_page_ID');
    header("Location: http://woo.reviews/r/unsubscribe");
    exit();
}

