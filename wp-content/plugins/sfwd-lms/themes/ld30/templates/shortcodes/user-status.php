<?php
/**
 * @param array $course_info
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

global $pagenow;

$shortcode_atts_json = htmlspecialchars( wp_json_encode( $shortcode_atts ) );
$class               = 'ld-course-info ld-user-status ' . ( isset( $context ) && 'widget' === $context ? 'ld-is-widget' : '' );
$heading             = ( isset( $context ) && 'widget' === $context ? array( '<h4>', '</h4>' ) : array( '<h2>', '</h2>' ) );

if ( 'profile.php' !== $pagenow && 'user-edit.php' !== $pagenow && $course_info['courses_registered'] && ! empty( $course_info['courses_registered'] ) ) : ?>

	<div class="learndash-wrapper">
	<?php // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- Escaped above ?>
		<div class="<?php echo esc_attr( $class ); ?>" data-shortcode-atts="<?php echo $shortcode_atts_json; ?>">
			<div class="ld-item-list">
				<div class="ld-section-heading">
					<?php
						// translators: placeholder: Courses.
						echo wp_kses_post( $heading[0] . sprintf( esc_html_x( 'Registered %s', 'placeholder: Courses', 'learndash' ),
							LearnDash_Custom_Label::get_label( 'courses' )
						) . $heading[1] );
					?>
				</div>
				<div class="ld-item-list-items">
					<?php
					foreach ( $course_info['courses_registered'] as $course_id ) :
						learndash_get_template_part(
							'shortcodes/user-status/course-row.php',
							array(
								'user_id'            => $course_info['user_id'],
								'courses_registered' => $course_info['courses_registered'],
								'shortcode_atts'     => $shortcode_atts,
								'course_progress'    => $course_info['course_progress'],
								'course_id'          => $course_id,
							),
							true
						);
					endforeach;
					?>
				</div> <!--/.ld-item-list-items-->
			</div> <!--/.ld-item-list-->

			<?php
				learndash_get_template_part(
					'modules/pagination.php',
					array(
						'pager_results' => $course_info['courses_registered_pager'],
						'pager_context' => 'course_info_courses',
					),
					true
				);
			?>

		</div> <!--/.ld-course-info-courses-->
	</div> <!--/.learn-wrapper-->
<?php endif; ?>
