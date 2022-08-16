<?php
//Prints Note field in front end and retieves exisintg note as placeholder
function nt_course_note_entry_field() {

	global $post;

	//ID's
	$current_user 		= get_current_user_id();
	$current_lesson_id 	= $post->ID;
	$current_post_type 	= get_post_type();

	$hide_on_mobile 	= ( get_option( 'nt_noteicon_hide_on_mobile' ) == 'yes' ? ' nt-hide-mobile ' : '' );
	$location 			= get_option( 'nt_noteicon_placement', 'bottom' );


	//Checks if note exists and changes title and body variables accordingly
	$args = array(
		'post_type'  	 => 'coursenote',
		'post_status'	=>	array( 'draft', 'publish' ),
		'meta_query'	 => array(
			//'relation' => 'AND',
			array(
				'key'     => 'nt-note-current-lessson-id',
				'value'   => $current_lesson_id,
				'compare' => '=',
			)
		),
		 'author' => $current_user
	);

	$the_query = new WP_Query($args);

	$title = false;
	$placeholder = false;

	if ($the_query->have_posts()){

	 	while ( $the_query->have_posts() ) : $the_query->the_post();

	 		$title 		= get_the_title();
	 		$body 		= get_the_content();
			$note_id 	= get_the_ID();

	 	endwhile;

	} else {

		global $post;

		$default_title 	= get_the_title( $post->ID );
		$default_body 	= __( 'Notes:', 'sfwd-lms' );

		$custom_title 	= get_post_meta( $post->ID, '_ldnt_default_note_title', true );
		$custom_body 	= get_post_meta( $post->ID, '_ldnt_default_note_text', true );

		$placeholder 	= ( empty( $custom_title ) ? $default_title : $custom_title );
		$placeholder	= apply_filters( 'ldnt_default_note_title_txt', $placeholder );
		$body 		= ( empty( $custom_body ) ? $default_body : $custom_body );
		$note_id 	= 'new';

	}

	$all_notes_page = get_option( 'ldnt_all_notes_page' );
	$new_window 	= ( get_option( 'ldnt_link_new_windows', 'no' ) == 'no' ? '' : ' target="new" ' );
	$post_id = ( $post->ID == $current_lesson_id ? '' : $post->ID ); ?>

	<a class="nt-note-tab <?php echo esc_attr($hide_on_mobile); ?> <?php echo $location; ?>" href="#" data-postid="<?php echo $post_id; ?>" data-contentid="<?php echo esc_attr( $current_lesson_id ); ?>">
		<i class="nticon-doc"></i> <span class="nt-screen-reader-text"><?php esc_html_e( 'Take Notes', 'sfwd-lms' ); ?></span>
	</a>

	<div class="nt-note-wrapper">

	    <div class="note-header">
			<span class="nt-close-icon">x</span>
			<div class="note-header-actions"></div>
		</div> <!--/note-header-->

		<div id="nt-note-title-bar">
			<?php esc_html_e( 'Take Notes', 'sfwd-lms' ); ?>
		</div>

		<div id="apf-response"></div>

	    <div class="note-body">

	      <form id="nt-course-note" action="" method="post">

				<?php wp_nonce_field( basename(__FILE__), 'nt-course-note-nonce') ?>

				<div id="nt-note-title-field">
					<input type="text" name="nt-note-title" id="nt-note-title" value="<?php if($title) echo esc_attr( $title ); ?>" placeholder="<?php if($placeholder) echo esc_attr($placeholder); ?>">
				</div>

				<input type="hidden" name="nt-note-user-id" id="nt-note-user-id" value="<?php echo esc_attr( $current_user ); ?>">
				<input type="hidden" name="nt-note-current-lesson-id" id="nt-note-current-lessson-id" value="<?php echo esc_attr( $current_lesson_id ); ?>">
				<input type="hidden" name="nt-note-current-post-type" id="nt-note-current-post-type" value="<?php echo esc_attr( $current_post_type ); ?>">
				<input type="hidden" name="nt-note-id" id="nt-note-id" value="<?php echo esc_attr($note_id); ?>">

				<div id="nt-note-editor-body">
					<?php
					$args = apply_filters( 'ld_notes_editor_args', array(
						'media_buttons'		=>		false,
						'textarea_name'		=>		'nt-note-body',
						'editor_height'		=>		175,
						'quicktags'			=>		false,
						'teeny'				=>		true,
						'quicktags'			=>		false,
					) );

					add_filter( 'teeny_mce_buttons', 'nt_tiny_mce_buttons', 10, 2);
					wp_editor( $body, 'nt-note-body', $args );
					remove_filter( 'teeny_mce_buttons', 'nt_tiny_mce_buttons' ); ?>

					<input type="text" id="xyz" name="<?php echo apply_filters( 'honeypot_name', 'date-submitted') ?>" value="" style="display:none">
				</div>

				<div id="nt-note-actions-wrapper">

					<ul id="nt-note-actions">
						<li><input type="submit" id="nt-note-submit" value="<?php esc_attr_e( 'Save', 'sfwd-lms' ); ?>"/></li>
						<li><a href="#" class="learndash-notes-print-modal" data-note="<?php the_ID(); ?>" title="<?php echo esc_attr_e( 'Print', 'sfwd-lms' ); ?>"><i class="nticon-print"></i></a></li>
						<li><a href="#" class="learndash-notes-download-modal" data-note="<?php the_ID(); ?>" title="<?php echo esc_attr_e( 'Download', 'sfwd-lms' ); ?>"><i class="nticon-file-word"></i></a></li>
						<?php if( $note_id != 'new' ): ?>
							<li><a href="<?php echo esc_url(get_permalink()); ?>" <?php echo $new_window; ?> title="<?php echo esc_attr_e( 'Note Page', 'sfwd-lms' ); ?>"><i class="fa fa-sticky-note" aria-hidden="true"></i></a></li>
						<?php endif; ?>
					</ul>

				</div>

				<p id="nt-utility-links" class="<?php if($all_notes_page) echo 'all-notes'; ?>">

					<a href="#" class="nt-reset-dimensions"><i class="fa fa-arrows"></i> <?php esc_html_e( 'Reset Dimensions', 'sfwd-lms' ); ?></a>
					<?php
					if( get_option( 'ldnt_all_notes_page' ) ):
						$new_window 	= ( get_option( 'ldnt_link_new_windows', 'no' ) == 'no' ? '' : ' target="new" ' );
						?>
						<a href="<?php echo esc_url( get_permalink( get_option( 'ldnt_all_notes_page' ) ) ); ?>" <?php echo $new_window; ?>><i class="fa fa-files-o"></i> <?php esc_html_e( 'View All Notes', 'sfwd-lms' ); ?></a>
					<?php endif; ?>

				</p>

		  </form>

	  	</div> <!--/.note-body-->

	</div> <!--/.nt-note-wrapper-->

   <?php

   wp_reset_postdata();

}

function nt_tiny_mce_buttons( $buttons, $editor_id ) {

	return apply_filters( 'nt_notes_wysiwyg_buttons', array( 'bold', 'italic', 'underline', 'bullist', 'numlist', 'link', 'unlink', 'forecolor', 'undo', 'redo' ) );

}



function nt_course_breadcrumbs( $ids = NULL ) {

	if( empty($ids) || !is_array($ids) ) {
		return false;
	}

	$new_window_option = get_option( 'ldnt_link_new_windows', 'no' );

	$new_window = ( $new_window_option == 'no' ? '' : ' target="new" ' );
	$output		= '';

	foreach( $ids as $id ) {
		$output .= '<a href="' . esc_url( get_the_permalink($id) ) .'" ' . $new_window . '>' . get_the_title($id) . '</a> &raquo; ';
	}

	return rtrim( $output, '&raquo; ' );

}

add_action( 'show_user_profile', 'nt_list_user_notes_on_profile' );
add_action( 'edit_user_profile', 'nt_list_user_notes_on_profile' );
function nt_list_user_notes_on_profile( $user ) {

	$cuser = wp_get_current_user();

	if( ( !current_user_can('edit_others_pages') && !current_user_can('read_others_nt_notes') ) && $cuser->ID != $user->ID ) return;

	$paged = ( isset($_GET['paged']) ) ? $_GET['paged'] : 1;

	$args = array(
			'post_type' 		=> 'coursenote',
			'posts_per_page' 	=> apply_filters( 'lds_nt_user_notes_pagination', get_option( 'posts_per_page' ) ),
			'post_status' 		=> array('draft', 'publish'),
			'author__in' 		=> $user->ID,
			'paged'				=> $paged,
	);

	$notes = new WP_Query( $args );
	$i = 1;

	if( $notes->have_posts() ): ?>
		<h2 id="ld-user-notes"><?php esc_html_e( 'Users Notes', 'sfwd-lms' ); ?></h2>
		<table class="wp-list-table widefat fixed pages">
			<thead>
				<tr>
					<th><?php esc_html_e( 'Title' ); ?></th>
					<th><?php esc_html_e( 'Date' ); ?></th>
				</tr>
			</thead>
			<tbody>
				<?php while( $notes->have_posts() ): $notes->the_post(); global $post; ?>
					<tr <?php if( $i %2 == 0 && $i > 1 ) echo 'class="alternate"'; ?>>
						<td id="post-<?php the_ID(); ?>" class="column-title">
							<a href="<?php echo esc_url( get_edit_post_link(get_the_ID()) ); ?>"><strong><?php the_title(); ?></strong></a>
							<p class="nt-location"><?php esc_html_e( 'Location:', 'sfwd-lms' ); ?> <?php echo nt_course_breadcrumbs( get_post_meta( $post->ID, '_nt-course-array', true ) ); ?></p>
						</td>
						<td>
							<?php echo esc_html( get_the_date( get_option( 'date_format' ) ) ); ?>
						</td>
					</tr>
				<?php $i++; endwhile; ?>
			</tbody>
		</table>
		<?php
		if ( $notes->max_num_pages > 1 ): // check if the max number of pages is greater than 1  ?>
			<div class="tablenav bottom">
				<div class="tablenav-pages">
						<div class="pagination-links">
						<?php
						$big = 999999999;

						$args = array(
							'base' 		=> str_replace( $big, '%#%', esc_url( get_pagenum_link( $big ) ) ) . '#ld-user-notes',
							'format' 	=> '?paged=%#%',
							'current' 	=> max( 1, $_GET['paged'] ),
							'total' 	=> $notes->max_num_pages
						);
						echo paginate_links($args); ?>
						</div>
	    			</div>
	  			</div>
			</div>
		<?php endif;
	endif;
}

function ldnt_get_template( $template ) {
	return apply_filters( 'ldnt_template_' . $template, LD_NOTES_PATH . 'templates/' . $template . '.php' );
}

apply_filters( 'learndash-lesson-row-attributes', 'ldnt_force_lesson_row_attributes' );
function ldnt_force_lesson_row_attributes() {
	return true;
}

add_action( 'learndash-topic-row-title-after', 'ldnt_add_note_icon_to_lesson_row', 999, 3 );
add_action( 'learndash-lesson-components-after', 'ldnt_add_note_icon_to_lesson_row', 10, 3 );
function ldnt_add_note_icon_to_lesson_row( $lesson_id, $course_id, $user_id ) {

	if( !is_user_logged_in() ) {
		return;
	}

	$args = array(
		'post_type'  	 => 'coursenote',
		'post_status'	=>	array( 'draft', 'publish' ),
		'meta_query'	 => array(
			//'relation' => 'AND',
			array(
				'key'     => 'nt-note-current-lessson-id',
				'value'   => $lesson_id,
				'compare' => '=',
			)
		),
		'author' 		 => $user_id,
		'posts_per_page' => 1,
	);

	$notes = get_posts($args);

	if( !$notes || empty($notes) ) {
		return;
	}

	foreach( $notes as $note ): ?>
		<span class="ld-note-icon">
			<i class="fa fa-file-text"></i> <?php esc_html_e( 'Notes', 'sfwd-lms' ); ?>
		</span>
	<?php
	endforeach;

}
