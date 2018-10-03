<?php

/**
 * The public-facing functionality of the plugin.
 *
 * @link       www.github.com/utshab-roy
 * @since      1.0.0
 *
 * @package    Dashboardwidget
 * @subpackage Dashboardwidget/public
 */

/**
 * The public-facing functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the public-facing stylesheet and JavaScript.
 *
 * @package    Dashboardwidget
 * @subpackage Dashboardwidget/public
 * @author     Utshab Roy <utshab.roy@gmail.com>
 */
class Dashboardwidget_Public {

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
		 * defined in Dashboardwidget_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Dashboardwidget_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/dashboardwidget-public.css', array(), $this->version, 'all' );

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
		 * defined in Dashboardwidget_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Dashboardwidget_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/dashboardwidget-public.js', array( 'jquery' ), $this->version, false );

	}


	public function basevalue_public_script(){
		wp_enqueue_script('main', plugin_dir_url( __FILE__ ). 'js/public-main.js', array('jquery'), $this->version, true);
		wp_enqueue_script( 'jquery-ui-dialog' );
		wp_enqueue_style( 'wp-jquery-ui-dialog' );
	}

	//callback function for get-notice short-code
//	public function shortcode_notice_callback(){
//		add_shortcode('get-notice', array($this, 'get_all_notice'));
//	}

	public function shortcode_notice_callback(){
		//creating instance for the Dashboardwidget_Notice class
//		$plugin_notice = new Dashboardwidget_Notice();
		$plugin_notice = Dashboardwidget_Notice::get_instance();
		return $plugin_notice->get_all_notice();
	}

}//end of class Dashboardwidget_Public
