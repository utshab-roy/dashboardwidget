<?php

/**
 * The file that defines the cbx notice class
 *
 * A class definition that includes attributes and functions used across both the
 * public-facing side of the site and the admin area.
 *
 * @link       www.github.com/utshab-roy
 * @since      1.0.0
 *
 * @package    Dashboardwidget
 * @subpackage Dashboardwidget/includes
 */

/**
 * The core plugin class.
 *
 * The class is responsible for the Dashboard Notice
 *
 * @since      1.0.0
 * @package    Dashboardwidget
 * @subpackage Dashboardwidget/includes
 * @author     Utshab Roy <utshab.roy@gmail.com>
 */
class Dashboardwidget_Notice {

	public function __construct() {

	}

	//getting all the notice for the user according to the role of the user
	public function get_all_notice() {
		ob_start();
		global $post;
		$args = array(
			'posts_per_page' => - 1,
			'post_type'      => 'cbxnotice',
			'order'          => 'ASC',
			'post_status'    => 'publish',
		);

		$posts_array = get_posts( $args );

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

}//end of class Dashboardwidget_Notice
