<?php
/**
 * Displays the User Course Visitor shortcode message.
 * This template is called from the [visitor] shortcode.
 *
 * @param array $shortcode_atts {
 *   integer $course_id Course ID context for message shown.
 *   string  $content Message to be shown.
 *   boolean $autop True to filter message via wpautop() function.
 * }
 *
 * @since 2.5.9
 *
 * @package LearnDash\Course
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

if ( ( isset( $shortcode_atts['content'] ) ) && ( ! empty( $shortcode_atts['content'] ) ) ) {
	?><div class="learndash-course-visitor-message">
	<?php
	if ( ( isset( $shortcode_atts['autop'] ) ) && ( true === $shortcode_atts['autop'] ) ) {
		echo wpautop( $shortcode_atts['content'] );
	} else {
		echo $shortcode_atts['content'];
	}
	?>
	</div>
	<?php
}
