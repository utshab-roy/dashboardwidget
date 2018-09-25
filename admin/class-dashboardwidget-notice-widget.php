<?php

/**
 * The admin-specific functionality of the notice-widget.
 *
 * @link       www.github.com/utshab-roy
 * @since      1.0.0
 *
 * @package    Dashboardwidget
 * @subpackage Dashboardwidget/admin
 */

/**
 * The admin-specific functionality of the plugin.
 * This class creates the Notice Widget that can be found in the widget section
 *
 * @package    Dashboardwidget
 * @subpackage Dashboardwidget/admin
 * @author     Utshab Roy <utshab.roy@gmail.com>
 */

class Dashboardwidget_Notice_Widget extends WP_Widget {

	public function __construct(  ) {
		$widget_ops = array(
			'classname' => 'notice_widget',
			'description' => 'A widget for showing the notice in the widget panel.',
		);
		parent::__construct( 'notice_widget', 'Notice Widget', $widget_ops );

	}//end of constructor


	public function form( $instance ) {
		$title = ! empty( $instance['title'] ) ? $instance['title'] : esc_html__( 'Title', 'text_domain' );
		?>
		<p>
			<label for="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>">
				<?php esc_attr_e( 'Title:', 'text_domain' ); ?>
			</label>

			<input
				class="widefat"
				id="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>"
				name="<?php echo esc_attr( $this->get_field_name( 'title' ) ); ?>"
				type="text"
				value="<?php echo esc_attr( $title ); ?>">
		</p>
		<?php
	}//end of form function

	public function widget( $args, $instance ) {
		echo $args['before_widget'];
		if ( ! empty( $instance['title'] ) ) {
			echo $args['before_title'] . apply_filters( 'widget_title', $instance['title'] ) . $args['after_title'];
		}
//		echo 'This is the body of the Notice widget...';
        //creating instance for the Dashboardwidget_Notice class
		$plugin_notice = new Dashboardwidget_Notice();
		echo $plugin_notice->get_all_notice();

	}//end of widget function

	public function update( $new_instance, $old_instance ) {
		$instance = array();
		$instance['title'] = ( ! empty( $new_instance['title'] ) ) ? strip_tags( $new_instance['title'] ) : '';

		return $instance;
	}//end of update function

}//end of class
