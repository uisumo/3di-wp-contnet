<?php
function ldnt_get_supported_types() {

	$types = (array) get_option( 'ldnt_supported_types' );

	return apply_filters( 'learndash_notes_supported_types', $types );

}

// Calls Notes if Template Pages
function nt_course_note_call() {

	$location = get_option( 'nt_noteicon_placement', 'bottom' );

	if( ( $location != 'top' ) && ( $location != 'bottom' ) ) return;

	// Pass if Divi
	if( isset($_GET['et_fb']) && $_GET['et_fb'] == 1 ) {
		return;
	}

	if( !ldnt_user_can_take_notes() ) {
		return;
	}

	  nt_course_note_entry_field();

}
add_action( 'wp_footer', 'nt_course_note_call', 1, 999 );

add_filter( 'the_content', 'ldnt_note_before_content' );
function ldnt_note_before_content( $content ) {

	if( !ldnt_user_can_take_notes() ) {
		return $content;
	}

	$location = get_option( 'nt_noteicon_placement', 'bottom' );

	if( $location != 'above-content' && $location != 'below-content' ) {
		return $content;
	}

	ob_start(); ?>

	<div class="ldnt-content-notes">
		<?php nt_course_note_entry_field(); ?>
	</div>

	<?php
	return ( $location == 'above-content' ? ob_get_clean() . $content : $content . ob_get_clean() );

}

add_action( 'template_redirect', 'nt_save_notes_as_word_doc' );
function nt_save_notes_as_word_doc() {

	if( ( get_post_type() == 'coursenote' ) && ( isset( $_GET[ 'nt_download_doc' ] ) ) ) {

		global $post;

		$cuser 		= wp_get_current_user();
		$filename 	= ldnt_get_note_title( $post->ID );

		if( empty($filename) ) $filename = $cuser->display_name;

		$filename	= sanitize_title( $filename ) . '.doc';

		if( !wp_is_mobile() ):
			header( 'Content-Type: application/vnd.openxmlformats-officedocument.wordprocessingml.document' );
			header( 'Content-Disposition: attachment;Filename="' . $filename . '"' );
		endif;

		$location = get_post_meta( $post->ID, '_nt-course-title', true );

		ob_start(); ?>

		<!doctype html>
		<html>
			<head>
				<meta charset="utf-8">
				<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
				<title><?php echo esc_html($post->post_title); ?></title>
			</head>
			<body>
				<h1><?php echo esc_html($post->post_title); ?></h1>

				<?php if( !empty( $location ) ): ?>
					<p><strong><?php echo esc_html($location); ?></strong></p>
				<?php endif; ?>

				<?php echo wpautop( $post->post_content ); ?>

				<p><?php esc_html_e( 'Location:', 'sfwd-lms' ); ?><?php echo nt_course_breadcrumbs( get_post_meta( $post->ID, '_nt-course-array', true ) ); ?></p>

			</body>
		</html>

		<?php

		echo ob_get_clean();

		exit();

	}

}

add_action( 'template_redirect', 'nt_bulk_download_notes' );
function nt_bulk_download_notes() {

	if( !isset($_GET['lds-bulk-download']) || !isset($_GET['lds-bulk-action-item']) ) return;

	$post_ids 	= $_GET['lds-bulk-action-item'];
	$args 		= array(
					'post_type'			=>	'coursenote',
					'post__in'			=>	$post_ids,
					'posts_per_page'	=>	-1,
				);

	$notes 			= get_posts($args);
	$current_user	= wp_get_current_user();
	$filename 		= sanitize_title( $current_user->display_name ) . '-notes.doc';

	ob_start(); ?>

		<!doctype html>
		<html>
			<head>
				<meta charset="utf-8">
				<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
				<title><?php echo esc_html($current_user->display_name); ?></title>
			</head>
			<body>
				<?php
				foreach( $notes as $note ):

					$location = get_post_meta( $note->ID, '_nt-course-title', true ); ?>

						<h1><?php echo esc_html($note->post_title); ?></h1>

						<?php if( !empty( $location ) ): ?>
							<p><strong><?php echo esc_html($location); ?></strong></p>
						<?php endif; ?>

						<?php echo wpautop($note->post_content); ?>

						<p><?php esc_html_e( 'Location:', 'sfwd-lms' ); ?><?php echo nt_course_breadcrumbs( get_post_meta( $note->ID, '_nt-course-array', true ) ); ?></p>

						<br>
						<hr>
						<br>

				<?php endforeach; ?>
			</body>
		</html>
		<?php
		if( !wp_is_mobile() ):
			header( 'Content-Type: application/vnd.openxmlformats-officedocument.wordprocessingml.document' );
			header( 'Content-Disposition: attachment;Filename="' . $filename . '"' );
		endif;

		echo ob_get_clean();
		exit();

}

add_filter( 'the_content', 'nt_restrict_notes_to_specific_user' );
function nt_restrict_notes_to_specific_user( $content ) {

	global $post;

	$cuser 		= wp_get_current_user();
	$user_id  	= get_post_meta( $post->ID, 'nt-note-user-id', true );

	if( get_post_type() == 'coursenote' ) {

		if ( $user_id != $cuser->ID  && !current_user_can( 'read_others_nt_notes' ) && !learndash_is_group_leader_of_user( $cuser->ID, $user_id ) ) {

 			$content = wpautop( '<strong>' . __( 'You do not have access to this note. ' ) . '</strong>' );

		} else {

			if( isset($_GET[ 'nt_download_doc' ]) ) return $content;

			nt_frontend_note_assets();

			ob_start(); ?>

			<?php
			$all_notes_link = get_option('ldnt_all_notes_page');
			if( $all_notes_link ): ?>
				<p><a href="<?php echo esc_url( get_permalink($all_notes_link) ); ?>">&laquo; <?php esc_html_e( 'Back to All Notes', 'sfwd-lms' ); ?></a></p>
			<?php endif; ?>

			<form id="nt-course-note" action="<?php echo $_SERVER[ 'SELF' ]; ?>" method="post" class="coursenote-embedded-editor">

				  <?php wp_nonce_field( basename(__FILE__), 'nt-course-note-nonce') ?>

				  <input type="hidden" name="nt-note-user-id" id="nt-note-user-id" value="<?php echo esc_attr($post->post_author); ?>">
				  <input type="hidden" name="nt-note-current-lesson-id" id="nt-note-current-lessson-id" value="<?php echo esc_attr( get_post_meta( $post->ID, 'nt-note-current-lessson-id', true ) ); ?>">
				  <input type="hidden" name="nt-note-current-post-type" id="nt-note-current-post-type" value="<?php echo esc_attr( $current_post_type ); ?>">
				  <input type="hidden" name="nt-note-title" id="nt-note-title" value="<?php echo esc_attr( get_the_title() ); ?>">
				  <input type="hidden" name="nt-note-id" id="nt-note-id" value="<?php echo esc_attr( get_the_ID() ); ?>">

				  <input type="text" id="xyz" name="<?php echo apply_filters( 'honeypot_name', 'date-submitted') ?>" value="" style="display:none">

					<?php
					if( current_user_can('edit_others_nt_notes') || learndash_is_group_leader_of_user( $cuser->ID, $user_id ) || $user_id == $cuser->ID ):

						$args = apply_filters( 'notes_editor_settings', array(
							'media_buttons'		=>		false,
							'textarea_name'		=>		'nt-note-body',
							'editor_height'		=>		100,
							'quicktags'			=>		false,
							'teeny'				=>		true,
							'quicktags'			=>		false,
						) );

						add_filter( 'teeny_mce_buttons', 'nt_tiny_mce_buttons', 10, 2);
						wp_editor( $content, 'nt-note-body', $args );
						remove_filter( 'teeny_mce_buttons', 'nt_tiny_mce_buttons' );
						?>

					<?php
					else:

						echo wpautop($content);

					endif; ?>

					<?php $sep = ( get_option( 'permalink_structure' ) ? '?' : '&' ); ?>

					<div id="nt-note-actions-wrapper">

						<ul id="nt-note-actions">
							<li><input type="submit" id="nt-note-submit" value="<?php esc_attr_e( 'Save', 'sfwd-lms' ); ?>"/></li>
							<li><a href="#" class="learndash-notes-print-modal"><i class="nticon-print"></i></a></li>
							<li><a href="<?php the_permalink(); ?><?php echo $sep; ?>nt_download_doc=true" class="learndash-notes-download" target="_new"><i class="nticon-file-word"></i></a></li>
						</ul>

					</div>

				</form>

			<?php

			$content .= '<p class="learndash-note-original">' . esc_html( 'Location:', 'sfwd-lms' ) . ' ' . nt_course_breadcrumbs( get_post_meta( $post->ID, '_nt-course-array', true ) ) . '</p>';

			$content = '<div id="nt-print-wrapper" class="nt-hide">' . $content . '</div>' . ob_get_clean();

		}

	}

	return $content;

}

//Retreives Post Id from Meta Key
function get_post_id_by_meta_key_and_value($key, $value) {

	global $wpdb;

    $meta = $wpdb->get_results("SELECT * FROM `".$wpdb->postmeta."` WHERE meta_key='".$wpdb->escape($key)."' AND meta_value='".$wpdb->escape($value)."'");

    if (is_array($meta) && !empty($meta) && isset($meta[0])) {
		$meta = $meta[0];
	}
	if (is_object($meta)) {
		return $meta->post_id;
	}
	else {
		return false;
	}

}

//Genereate full title for course, lessson, topic
function nt_generate_course_array( $course_type, $active_id ) {

	$crumbs = array();

	if( $course_type == 'sfwd-lessons' ) {
		$crumbs[]		= 	get_post_meta( $active_id , 'course_id' , true );
	}
	if( $course_type == 'sfwd-topic' ) {
		$crumbs[] 		= 	get_post_meta( $active_id , 'course_id' , true );
		$crumbs[]		=	get_post_meta( $active_id , 'lesson_id' , true );
	}
	$crumbs[] = $active_id;

	return apply_filters( 'learndash_notes_array', $crumbs, $course_type, $active_id );

}

function ldnt_populate_notes( $course_ids ) {

	foreach( $course_ids as $post_id ) {

		$note_count 	= 	0;
		$course_group	=	array();

		$args = array(

		);

	}

}

function ldnt_get_post_relationships( $post_id ) {

	$relationship = array();

	if( get_post_type( $post_id ) == 'sfwd-courses' ) {

		$relationship[ 'course_id' ] 	= $post_id;
		$relationship[ 'type' ] 		= 'course';

	}

	if( get_post_type( $post_id ) == 'sfwd-lessons' ) {

		$relationship[ 'course_id' ] 	= get_post_meta( $post_id, 'course_id', true );
		$relationship[ 'lesson_id' ] 	= $post_id;
		$relationship[ 'type' ] 		= 'lesson';

	}

	if( get_post_type( $post_id ) == 'sfwd-topic' ) {

		$relationship[ 'course_id' ] 	= get_post_meta( $post_id, 'course_id', true );
		$relationship[ 'lesson_id' ] 	= get_post_meta( $post_id, 'lesson_id', true );
		$relationship[ 'topic_id' ]		= $post_id;
		$relationship[ 'type' ] 		= 'topic';

	}

	if( get_post_type( $post_id) == 'sfwd-assignment' ) {

		$relationship[ 'course_id' ] 		= get_post_meta( $post_id, 'course_id', true );
		$relationship[ 'lesson_id' ] 		= get_post_meta( $post_id, 'lesson_id', true );
		$relationship[ 'assignment_id' ]	= $post_id;
		$relationship[ 'type' ] 			= 'assignment';

	}

	return $relationship;

}

function ldnt_get_the_slug( $post_id ) {

	$slug = basename( get_permalink( $post_id ) );

}

function ldnt_custom_background_color( $hex ) {

	$hex = str_replace("#", "", $hex);

   if(strlen($hex) == 3) {
      $r = hexdec(substr($hex,0,1).substr($hex,0,1));
      $g = hexdec(substr($hex,1,1).substr($hex,1,1));
      $b = hexdec(substr($hex,2,1).substr($hex,2,1));
   } else {
      $r = hexdec(substr($hex,0,2));
      $g = hexdec(substr($hex,2,2));
      $b = hexdec(substr($hex,4,2));
   }

   return 'rgba( ' . $r . ', ' . $g . ', ' . $b . ', 1 )';

}

function ldnt_get_the_color_settings() {

	return array(
		'background_color'	=>	get_option( 'nt_background_color' ),
		'text_color'		=>	get_option( 'nt_text_color' ),
		'header_background'	=>	get_option( 'nt_header_background' ),
		'header_text'		=>	get_option( 'nt_header_text' ),
		'link_color'		=>	get_option( 'nt_link_color' ),
		'button_background'	=>	get_option( 'nt_button_background' ),
		'button_text'		=>	get_option( 'nt_button_text' )
	);

}

function ldnt_get_note_title( $post_id = null, $original_id = null ) {

	$post_id = ( $post_id == null ? get_the_id() : $post_id );
	$original_page_id = get_post_meta( $post_id, 'nt-note-current-lessson-id', true );

    $title = get_the_title();

	if( !empty($title) ) {
		return $title;
	}

	$custom_title = get_post_meta( $post_id, '_ldnt_default_note_title', true );
	if( $custom_title ) {
		return $custom_title;
	}

	return get_the_title($original_page_id);

}

function ldnt_user_can_take_notes() {

	// only show logged-in members on learn dash pages
	$post_type 	= get_post_type();
	$types 		= ldnt_get_supported_types();
	$cuser		= wp_get_current_user();

	global $post;

	/**
	 * Non starters...
	 * @var [type]
	 */

	if( !is_user_logged_in() ) {
		return false;
	}

	if( !in_array( $post_type, $types) ) {
		return false;
	}

	if( get_post_meta( $post->ID, '_ldnt_disable_notes', true ) == 'yes' ) {
		return false;
	}

	/**
	 * Check to see if the user is part of the necissary group
	 * @var boolean
	 */

	$group_return  = false;
	$active_groups = get_option('ldnt_groups');

	if( $active_groups ) {

		$groups = learndash_get_users_group_ids( $cuser->ID );

		foreach( $groups as $group_id ) {
			foreach( $active_groups as $active_group_id => $status ) {
				if( $active_group_id == $group_id ) {
					$group_return = true;
				}
			}
		}

	} else {
		$group_return = true;
	}

	/**
	 * Check to see if the user is a role that can start notes
	 * @var boolean
	 */

	$role_return  = false;
	$active_roles = get_option('ldnt_roles');
	$cuser 		  = wp_get_current_user();
	$roles 		  = (array) $cuser->roles;

	if( $active_roles && !empty($active_roles) ) {

		foreach( $roles as $role ) {

			$defaults = array(
				'administrator',
				'editor',
				'group_leader'
			);

			if( in_array($role, $defaults) ) {
				return true;
			}

			foreach( $active_roles as $active_role => $status ) {
				if( $role == $active_role && $status == "true" ) {
					$role_return = true;
				}
			}
		}

	} else {
		$role_return = true;
	}

	if( $role_return == true && $group_return == true ) {
		return true;
	}

	return false;

}
