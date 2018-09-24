<?php

/**
 * The admin-specific functionality of the plugin.
 *
 * @link       www.github.com/utshab-roy
 * @since      1.0.0
 *
 * @package    Dashboardwidget
 * @subpackage Dashboardwidget/admin
 */

/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    Dashboardwidget
 * @subpackage Dashboardwidget/admin
 * @author     Utshab Roy <utshab.roy@gmail.com>
 */
class Dashboardwidget_Admin {

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
		 * defined in Dashboardwidget_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Dashboardwidget_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/dashboardwidget-admin.css', array(), $this->version, 'all' );

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
		 * defined in Dashboardwidget_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Dashboardwidget_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/dashboardwidget-admin.js', array( 'jquery' ), $this->version, false );

	}


	/**
	 * This function add the custom dashboard
	 */
	public function noticeboard_add_dashboard_widgets(){
		wp_add_dashboard_widget(
			'notice_board',         // Widget slug.
			'Admin Notice Board',         // Title.
			array($this, 'notice_dashboard_widget_function') // Display function.
		);
	}

	/**
	 * Create the function to output the contents of our Dashboard Widget.
	 */
	function notice_dashboard_widget_function() {
//		global $wp_meta_boxes;
//		echo '<pre>';
//		var_dump($wp_meta_boxes['dashboard']['normal']['sorted']["notice_board"]);
//		echo '</pre>';
		// Display whatever it is you want to show.

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
				echo '<pre>';
//				var_dump($cbxnotice_role);
				echo '</pre>';
//				echo '</br>';
				$user              = wp_get_current_user();
				$current_user_role = $user->roles;
//				var_dump($current_user_role);
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
	}


	// Removing all the default widgets using 'wp_dashboard_setup' hook
	function example_remove_dashboard_widget() {
		remove_meta_box( 'dashboard_right_now', 'dashboard', 'normal' );
		remove_meta_box( 'dashboard_activity', 'dashboard', 'normal' );
//		remove_meta_box( 'notice_board', 'dashboard', 'normal' );
		remove_meta_box( 'dashboard_quick_press', 'dashboard', 'side' );
		remove_meta_box( 'dashboard_primary', 'dashboard', 'side' );
	}

	// Creating cbxnotice post type
	function create_cbxnotice_custom_post_type(){
		register_post_type(
			'cbxnotice',
			array(
				'labels'             => array(
					'name'          => __( 'CBXNotice' ),
					'singular_name' => __( 'CBXNotice' ),
				),
				'public'             => true,
				'has_archive'        => true,
				'rewrite'            => array( 'slug' => 'notice' ), // my custom slug
				'publicly_queryable' => false,
			)
		);
	}

	//adding metabox for the cbxnotice post type
	function cbx_notice_add_custom_box(){
		$screens = ['cbxnotice'];
		foreach ($screens as $screen) {
			add_meta_box(
				'cbxnotice_box_id',           // Unique ID
				'Notice assigned for the role',  // Box title
				array($this, 'cbxnotice_custom_box_html'),  // Content callback, must be of type callable
				$screen                   // Post type
			);
		}
	}
	//callback function for cbx_notice_add_custom_box
	function cbxnotice_custom_box_html($post){

		$roles = get_editable_roles();

		$cbxnotice_role = get_post_meta($post->ID, 'cbxnotice_role', true);
		if(!is_array($cbxnotice_role)) $cbxnotice_role = array();

		/*echo '<pre>';
		print_r($cbxnotice_role);
		echo '</pre>';*/
		?>

		<label for="cbxnotice_role">Who can see the notice:</label>
		<!--        <select name="cbxnotice_role[]" id="cbxnotice_role" multiple>-->
		<?php ?>
		<?php foreach ($roles as  $key => $role_details):?>
			<!--            <option --><?php // echo (in_array($key, $cbxnotice_role))? ' selected="selected"': ''; ?><!-- value="--><?php //echo $key; ?><!--" >--><?php //echo $key;?><!--</option>-->

			<input type="checkbox" name="cbxnotice_role[]" id="<?php echo $key; ?>" value="<?php echo $key; ?>" <?php echo in_array( $key, $cbxnotice_role) ? 'checked' : '' ?>><label
				for="<?php echo $key; ?>"><?php echo $key; ?></label>

		<?php endforeach;?>
		<!--        </select>-->
		<?php
	}

	function cbxnotice_save_postdata($post_id)
	{
		/*echo '<pre>';
		print_r($_POST['cbxnotice_role']);
		echo '</pre>';

		exit();*/

		$cbxnotice_role = isset( $_POST['cbxnotice_role'] ) ? $_POST['cbxnotice_role'] : array();

		if (array_key_exists('cbxnotice_role', $_POST)) {
			update_post_meta(
				$post_id,
				'cbxnotice_role',
				$cbxnotice_role
			);
		}
	}

	function basevalue_admin_script($hook){
		if ($hook != 'index.php'){
			return;
		}
		wp_enqueue_script('main', plugin_dir_url( __FILE__ ). 'js/main.js', array('jquery'), $this->version, true);
		wp_enqueue_script( 'jquery-ui-dialog' );
		wp_enqueue_style( 'wp-jquery-ui-dialog' );
	}

}//end of Dashboardwidget_Admin class
