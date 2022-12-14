<?php
/**
 * LearnDash Binary Selector Course Users Class.
 *
 * @package LearnDash
 * @subpackage Admin Settings
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ( ! class_exists( 'LearnDash_Binary_Selector_Course_Users' ) ) && ( class_exists( 'Learndash_Binary_Selector_Users' ) ) ) {
	/**
	 * Class for LearnDash Binary Selector Course Users.
	 */
	class Learndash_Binary_Selector_Course_Users extends Learndash_Binary_Selector_Users {

		/**
		 * Public constructor for class
		 *
		 * @param array $args Array of arguments for class.
		 */
		public function __construct( $args = array() ) {

			$this->selector_class = get_class( $this );

			$defaults = array(
				'course_id'          => 0,
				'html_title'         => '<h3>' .
				// translators: placeholder: Course.
				esc_html_x( '%s Users', 'Course Users Label', 'learndash' ) . '</h3>',
				'html_title'         => '<h3>' .
				// translators: placeholder: Course.
				sprintf( esc_html_x( '%s Users', 'Course Users label', 'learndash' ), LearnDash_Custom_Label::get_label( 'course' ) ) . '</h3>',
				'html_id'            => 'learndash_course_users',
				'html_class'         => 'learndash_course_users',
				'html_name'          => 'learndash_course_users',
				'search_label_left'  => sprintf(
					// translators: placeholder: Course.
					esc_html_x( 'Search All %s Users', 'Search All Course Users', 'learndash' ),
					LearnDash_Custom_Label::get_label( 'course' )
				),
				'search_label_right' => sprintf(
					// translators: placeholder: Course.
					esc_html_x( 'Search Assigned %s Users', 'Search Assigned Course Users', 'learndash' ),
					LearnDash_Custom_Label::get_label( 'course' )
				),
			);

			$args = wp_parse_args( $args, $defaults );

			$args['html_id']   = $args['html_id'] . '-' . $args['course_id'];
			$args['html_name'] = $args['html_name'] . '[' . $args['course_id'] . ']';

			parent::__construct( $args );
		}
	}
}
