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

	//function for short-code
	public function loremtext(){
		return 'Lorem ipsum dolor sit amet, consectetur adipiscing elit.';
	}

	public function add_shortcode_cb(){
		add_shortcode('lorem', array($this, 'loremtext'));
	}

	//callback function for showing the notice in short-code
	public function dashboard_notice_shortcode(){
		ob_start();
		global $post;
		$args = array(
			'posts_per_page' => -1,
			'post_type'      => 'cbxnotice',
			'order'          => 'ASC',
			'post_status'    => 'publish',

		);
		$posts_array = get_posts( $args );

//		$value = get_post_meta($posts_array['ID'], 'cbxnotice_role_meta_key', true);
//		var_dump($posts_array);
//		die();

		if ( $posts_array ) {
			foreach ( $posts_array as $post ) :
				$cbxnotice_role = get_post_meta( $post->ID, 'cbxnotice_role', true );
				if ( empty( $cbxnotice_role ) ) {
					$cbxnotice_role = array();
				}

				$user              = wp_get_current_user();
				$current_user_role = $user->roles;

				setup_postdata( $post ); ?>
				<?php
//				if ( in_array( $cbxnotice_role, $current_user_role ) ):
				if ( array_intersect( $cbxnotice_role, $current_user_role ) ):
					?>
					<li class="title-notice"><?php the_title(); ?></li>

					<div style="display: none;" class="content-notice"><?php the_content(); ?></div>

				<?php
				endif;
			endforeach;

			?>
			<div id="cbx_notice_dialog"></div>
			<?php

			wp_reset_postdata();
		}

		$notice = ob_get_contents();
		ob_end_clean();

		return $notice;
	}

	//short-code for notice
	public function add_shortcode_notice(){
		add_shortcode('notice', array($this, 'dashboard_notice_shortcode'));
	}

	public function basevalue_public_script(){
		wp_enqueue_script('main', plugin_dir_url( __FILE__ ). 'js/public-main.js', array('jquery'), $this->version, true);
		wp_enqueue_script( 'jquery-ui-dialog' );
		wp_enqueue_style( 'wp-jquery-ui-dialog' );
	}

}//end of class Dashboardwidget_Public
