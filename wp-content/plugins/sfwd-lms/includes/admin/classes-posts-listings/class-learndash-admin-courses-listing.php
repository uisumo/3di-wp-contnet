<?php
/**
 * LearnDash Courses (sfwd-courses) Posts Listing Class.
 *
 * @package LearnDash
 * @subpackage admin
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ( class_exists( 'Learndash_Admin_Posts_Listing' ) ) && ( ! class_exists( 'Learndash_Admin_Courses_Listing' ) ) ) {
	/**
	 * Class for LearnDash Courses Listing Pages.
	 */
	class Learndash_Admin_Courses_Listing extends Learndash_Admin_Posts_Listing {

		/**
		 * Public constructor for class
		 */
		public function __construct() {
			$this->post_type = learndash_get_post_type_slug( 'course' );

			parent::__construct();
		}

		/**
		 * Called via the WordPress init action hook.
		 */
		public function listing_init() {
			$this->selectors = array(
				'user_id'  => array(
					'type'                     => 'user',
					'show_all_value'           => '',
					'show_all_label'           => esc_html__( 'All Users', 'learndash' ),
					'selector_filter_function' => array( $this, 'selector_filter_for_author' ),
					'selector_value_function'  => array( $this, 'selector_value_for_author' ),
				),
				'group_id' => array(
					'type'                     => 'post_type',
					'post_type'                => learndash_get_post_type_slug( 'group' ),
					'show_all_value'           => '',
					'show_all_label'           => sprintf(
						// translators: placeholder: Groups.
						esc_html_x( 'All %s', 'placeholder: Groups', 'learndash' ),
						LearnDash_Custom_Label::get_label( 'groups' )
					),
					'show_empty_value'         => 'empty',
					'show_empty_label'         => sprintf(
						// translators: placeholder: Group.
						esc_html_x( '-- No %s --', 'placeholder: Group', 'learndash' ),
						LearnDash_Custom_Label::get_label( 'group' )
					),
					'listing_query_function'   => array( $this, 'listing_filter_by_group' ),
					'selector_filter_function' => array( $this, 'selector_filter_for_group' ),
				),
			);

			// If Group Leader remove the selector empty option.
			if ( learndash_is_group_leader_user() ) {
				$gl_manage_groups_capabilities = learndash_get_group_leader_manage_groups();
				if ( 'advanced' !== $gl_manage_groups_capabilities ) {
					if ( isset( $this->selectors['group_id'] ) ) {
						unset( $this->selectors['group_id']['show_empty_value'] );
						unset( $this->selectors['group_id']['show_empty_label'] );
					}
				}
			}

			parent::listing_init();
		}

		/**
		 * Call via the WordPress load sequence for admin pages.
		 */
		public function on_load_listing() {
			if ( $this->post_type_check() ) {
				parent::on_load_listing();

				add_filter( 'learndash_listing_table_query_vars_filter', array( $this, 'listing_table_query_vars_filter_courses' ), 30, 3 );
			}
		}

		/** This function is documented in includes/admin/class-learndash-admin-posts-listing.php */
		public function listing_table_query_vars_filter_courses( $q_vars, $post_type, $query ) {
			$user_selector = $this->get_selector( 'user_id' );
			if ( ( $user_selector ) && ( isset( $user_selector['selected'] ) ) && ( ! empty( $user_selector['selected'] ) ) ) {
				$user_course_ids = learndash_user_get_enrolled_courses( $user_selector['selected'], true );
				if ( ! empty( $user_course_ids ) ) {
					$q_vars['post__in'] = $user_course_ids;
				} else {
					$q_vars['post__in'] = array( 0 );
				}
			}

			return $q_vars;
		}

		/**
		 * Add Course Builder link to Courses row action array.
		 *
		 * @since 2.5.0
		 *
		 * @param array   $row_actions Existing Row actions for course.
		 * @param WP_Post $course_post Course Post object for current row.
		 *
		 * @return array $row_actions
		 */
		public function post_row_actions( $row_actions = array(), $post = null ) {
			if ( $this->post_type_check() ) {
				$row_actions = parent::post_row_actions( $row_actions, $post );

				if ( ( LearnDash_Settings_Section::get_section_setting( 'LearnDash_Settings_Courses_Builder', 'enabled' ) == 'yes' ) && ( current_user_can( 'edit_post', $post->ID ) ) && ( ! isset( $row_actions['ld-course-builder'] ) ) ) {
					/**
					 * Filters whether to show course builder row actions or not.
					 *
					 * @param boolean      $show_row_actions Whether to show row actions.
					 * @param WP_Post|null $course_post      Course post object.
					 */
					if ( apply_filters( 'learndash_show_course_builder_row_actions', true, $post ) === true ) {
						$course_label = sprintf(
							// translators: placeholder: Course.
							esc_html_x( 'Use %s Builder', 'placeholder: Course', 'learndash' ),
							LearnDash_Custom_Label::get_label( 'course' )
						);

						$row_actions['ld-course-builder'] = sprintf(
							'<a href="%s" rel="bookmark" aria-label="%s">%s</a>',
							add_query_arg(
								array(
									'currentTab' => 'learndash_course_builder',
								),
								get_edit_post_link( $post->ID )
							),
							esc_attr( $course_label ),
							esc_html__( 'Builder', 'learndash' )
						);
					}
				}
			}

			return $row_actions;
		}

		// End of functions.
	}
}
new Learndash_Admin_Courses_Listing();
