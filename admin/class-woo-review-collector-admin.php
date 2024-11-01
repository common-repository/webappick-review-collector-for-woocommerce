<?php

/**
 * The admin-specific functionality of the plugin.
 *
 * @link       https://webappick.com
 * @since      1.0.0
 *
 * @package    Woo_Review_Collector
 * @subpackage Woo_Review_Collector/admin
 */

/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    Woo_Review_Collector
 * @subpackage Woo_Review_Collector/admin
 * @author     Md. Ohidul Islam <wahid0003@gmail.com>
 */
class Woo_Review_Collector_Admin {

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
	 * @param      string    $plugin_name       The name of this plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version = $version;

	}

	/**
	 * Register the stylesheets for the admin area.
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

		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/woo-review-collector-admin.css', array(), $this->version, 'all' );

	}

	/**
	 * Register the JavaScript for the admin area.
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




        wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/woo-review-collector-admin.js', array( 'jquery' ), $this->version, false );

        wp_enqueue_script( $this->plugin_name ."amchart", plugin_dir_url( __FILE__ ) . 'js/amcharts.js', array(), $this->version, false );
        wp_enqueue_script( $this->plugin_name ."serial", plugin_dir_url( __FILE__ ) . 'js/serial.js', array(), $this->version, false );
        wp_enqueue_script( $this->plugin_name ."dark", plugin_dir_url( __FILE__ ) . 'js/dark.js', array(), $this->version, false );
        wp_enqueue_script( $this->plugin_name ."reviewcustomchart", plugin_dir_url( __FILE__ ) . 'js/reviewcustomchart.js', array(), $this->version, false );
        wp_enqueue_script( $this->plugin_name ."ratingcustomchart", plugin_dir_url( __FILE__ ) . 'js/ratingcustomchart.js', array(), $this->version, false );

        $wrc_test_email_nonce = wp_create_nonce('wrc_test_email_nonce');
        $wrc_black_list_email_removing_nonce = wp_create_nonce('wrc_black_list_email_removing_nonce');
		$wrc_dismiss_admin_notice_nonce = wp_create_nonce('wrc_dismiss_admin_notice_nonce');

        wp_localize_script($this->plugin_name, 'wrc_test_email_ajax_obj', array(
            'wrc_test_email_ajax_url' => admin_url('admin-ajax.php'),
            'nonce' => $wrc_test_email_nonce,
        ));

        wp_localize_script($this->plugin_name, 'wrc_black_list_email_removing_ajax_obj', array(
            'wrc_black_list_email_removing_ajax_url' => admin_url('admin-ajax.php'),
            'nonce' => $wrc_black_list_email_removing_nonce,
        ));

		wp_localize_script($this->plugin_name, 'wrc_dismiss_admin_notice_ajax_obj', array(
			'wrc_dismiss_admin_notice_ajax_url' => admin_url('admin-ajax.php'),
			'nonce' => $wrc_dismiss_admin_notice_nonce,
		));

        wp_enqueue_script($this->plugin_name);
	}

    /**
     * Register the Plugin's Admin Pages for the admin area.
     *
     * @since    1.0.0
     */
    public function load_admin_pages()
    {
        /**
         * This function is provided for making admin pages into admin area.
         *
         * An instance of this class should be passed to the run() function
         * defined in Woo_Review_Collector_Loader as all of the hooks are defined
         * in that particular class.
         *
         * The Woo_Review_Collector_Loader will then create the relationship
         * between the defined hooks and the functions defined in this
         * class.
         */

        if (function_exists('add_options_page')) {

            add_menu_page(__('Woo Review', 'woo-review-collector'), __('Woo Review', 'woo-review-collector'), 'manage_options', __FILE__, 'woo_review_collector_email_config', 'dashicons-star-filled');
            add_submenu_page(__FILE__, __('Config Email::WooCommerce Review Collector', 'woo-review-collector'), __('Config Email', 'woo-review-collector'), 'manage_options', __FILE__, 'woo_review_collector_email_config');
            add_submenu_page(__FILE__, __('Report::WooCommerce Review Collector', 'woo-review-collector'), __('Report', 'woo-review-collector'), 'manage_options', 'woo_review_collector_stat', 'woo_review_collector_stat');
            //add_submenu_page(__FILE__, __('Widget::WooCommerce Review Collector', 'woo-review-collector'), __('Widget', 'woo-review-collector'), 'manage_options', 'woo_review_collector_settings', 'woo_review_collector_settings');
        }
    }


}
