<?php
function learndash_notes_license_menu() {

	$title = ( LD_FINAL_NAME == 'LearnDash Notes' ? __( 'LearnDash Notes', 'sfwd-lms' ) : __( 'User Notes', 'sfwd-lms' ) );

	add_options_page( $title, $title, 'manage_options', 'learndash-notes-license', 'learndash_notes_license_page' );
}
add_action('admin_menu', 'learndash_notes_license_menu');

function learndash_notes_license_page() {
	$license 	= get_option( 'learndash_notes_license_key' );
	$status 	= get_option( 'learndash_notes_license_status' );

	if( isset( $_GET[ 'nt_migrate_notes' ] ) ) {
		ldnt_migrate_notes();
	}

	?>
	<div class="wrap">
		<h2><?php _e('Plugin License Options', 'sfwd-lms'); ?></h2>
		<form method="post" action="options.php">

			<?php
			settings_fields( 'learndash_notes_license' );
			wp_enqueue_script( 'wp-color-picker' );
			wp_enqueue_style( 'wp-color-picker' ); ?>

			<br>

			<h3><?php esc_html_e( 'License', 'sfwd-lms' ); ?></h3>

			<?php if(isset($_GET['lds_activate_response'])): ?>
				<div class="lds-status-message" style="max-height: 500px; overflow: scroll; border: 1px solid #ddd; padding: 15px;">
					<pre>
						<?php nt_check_activation_response(); ?>
					</pre>
				</div>
			<?php endif; ?>

			<table class="form-table">
				<tbody>
					<tr valign="top">
						<th scope="row" valign="top">
							<?php _e('License Key', 'sfwd-lms'); ?>
						</th>
						<td>
							<input id="learndash_notes_license_key" name="learndash_notes_license_key" type="text" class="regular-text" value="<?php esc_attr_e( $license ); ?>" />
							<label class="description" for="learndash_notes_license_key"><?php _e('Enter your license key'); ?></label>
						</td>
					</tr>
					<?php if( false !== $license ) { ?>
						<tr valign="top">
							<th scope="row" valign="top">
								<?php _e('Activate License', 'sfwd-lms' ); ?>
							</th>
							<td>
								<?php if( $status !== false && $status == 'valid' ) { wp_nonce_field( 'learndash_notes_nonce', 'learndash_notes_nonce' ); ?>
									<span style="color:green; padding: 5px 10px; border-radius: 8px; background: #fff;"><?php _e('active', 'sfwd-lms'); ?></span>
									<input type="submit" class="button-secondary" name="learndash_notes_license_deactivate" value="<?php _e('Deactivate License','learndash-skins'); ?>"/>
								<?php } else {
									wp_nonce_field( 'learndash_notes_nonce', 'learndash_notes_nonce' ); ?>
									<input type="submit" class="button-secondary" name="learndash_notes_license_activate" value="<?php _e('Activate License', 'sfwd-lms'); ?>"/>
									<a class="button" href="<?php echo admin_url(); ?>admin.php?page=learndash-notes-license&settings-updated=true&lds_activate_response=true">Check Activation Message</a>
								<?php } ?>
							</td>
						</tr>
					<?php } ?>
				</tbody>
			</table>

			<br>
			<hr>
			<br>

			<h3><?php esc_html_e( 'Settings', 'sfwd-lms' ); ?></h3>

			<?php
			global $wp_roles;

			$supported_types		= (array) get_option( 'ldnt_supported_types' );
			$links					= get_option( 'ldnt_link_new_windows', 'yes' );
			$show_admin				= get_option( 'ldnt_show_notes_in_admin', 'no' );
			$placement				= get_option( 'nt_noteicon_placement', 'top' );
			$hide_mobile			= get_option( 'nt_noteicon_hide_on_mobile', 'no' );
			$colors 				= ldnt_get_the_color_settings();
			$autosave				= get_option( 'ldnt_autosave', 'no' ); ?>

			<script>
				jQuery(document).ready(function($) {
					$( '.wp-color-picker' ).wpColorPicker();
				});
			</script>

			<table class="form-table">
				<tbody>
					<tr valign="top">
						<th scope="row" valign="top">
							<label for="note-support"><?php esc_html_e( 'Enable Notes On', 'sfwd-lms' ); ?></label>
						</th>
						<td>
							<ul class="ldnt-stl">
							<?php
								$post_types = get_post_types( array( 'public' => true ), 'objects' );
								foreach( $post_types as $type ):
									if( $type->name == 'coursenote' ) {
										continue;
									} ?>
									<li><label for="ldnt_notes_<?php echo esc_attr( $type->name ); ?>"><input type="checkbox" name="ldnt_supported_types[]" value="<?php echo esc_attr( $type->name ); ?>" id="ldnt_notes_<?php echo esc_attr( $type->name ); ?>" <?php if( in_array( $type->name, $supported_types ) ) { echo 'checked'; } ?>> <?php echo esc_html( $type->labels->name ); ?></label></li>
								<?php endforeach; ?>
							</ul>
						</td>
					</tr>
					<tr>
						<th scope="row" valign="top">
							<label for="nt-all-notes-page"><?php esc_html_e( 'All notes page', 'sfwd-lms' ); ?></label>
						</th>
						<td>
							<select name="ldnt_all_notes_page">
								<?php
								$all_notes_page = get_option( 'ldnt_all_notes_page' );
								$args 			= array(
													'post_type'			=>	'page',
													'posts_per_page'	=>	-1,
												);

								$pages 			= new WP_Query( $args ); ?>

								<option value=""></option>

								<?php if( $pages->have_posts() ): while( $pages->have_posts() ): $pages->the_post(); global $post; ?>
									<option value="<?php echo esc_attr( $post->ID ); ?>" <?php if( $all_notes_page == $post->ID ) { echo 'selected'; }?>><?php the_title(); ?></option>
								<?php endwhile; endif; ?>

							</select>
							<label for="nt-all-notes-page"><i><?php esc_html_e( 'Recommended you use the', 'sfwd-lms' ); ?> <pre>[learndash_my_notes]</pre> <?php esc_html_e( 'shortcode', 'sfwd-lms' ); ?>.</i></label>
						</td>
					</tr>
					<tr>
						<th scope="row" valign="top">
							<label for="ldnt_autosave"><?php esc_html_e( 'Enable Auto-Save', 'sfwd-lms' ); ?></label>
						</th>
						<td>
							<select name="ldnt_autosave">
								<option value="yes" <?php if( $autosave == 'yes' ) { echo 'selected'; } ?>><?php esc_html_e( 'Yes', 'sfwd-lms' ); ?></option>
								<option value="no" <?php if( $autosave == 'no' ) { echo 'selected'; } ?>><?php esc_html_e( 'No', 'sfwd-lms' ); ?></option>
							</select>
						</td>
					</tr>
					<tr>
						<th scope="row" valign="top">
							<label for="ldnt_show_notes_in_admin"><?php esc_html_e( 'Show notes in the admin', 'sfwd-lms' ); ?></label>
						</th>
						<td>
							<select name="ldnt_show_notes_in_admin">
								<option value="yes" <?php if( $show_admin == 'yes' ) { echo 'selected'; } ?>><?php esc_html_e( 'Yes', 'sfwd-lms' ); ?></option>
								<option value="no" <?php if( $show_admin == 'no' ) { echo 'selected'; } ?>><?php esc_html_e( 'No', 'sfwd-lms' ); ?></option>
							</select>
						</td>
					</tr>
					<tr>
						<th scope="row" valign="top">
							<label for="nt-link-new-windows"><?php esc_html_e( 'Open links in a new window', 'sfwd-lms' ); ?></label>
						</th>
						<td>
							<select name="ldnt_link_new_windows">
								<option value="yes" <?php if( $links == 'yes' ) { echo 'selected'; } ?>><?php esc_html_e( 'Yes', 'sfwd-lms' ); ?></option>
								<option value="no" <?php if( $links == 'no' ) { echo 'selected'; } ?>><?php esc_html_e( 'No', 'sfwd-lms' ); ?></option>
							</select>
						</td>
					</tr>
				</table>

				<?php
				/**
				 * Enabled / disabled by group
				 * @var [type]
				 */
				$groups = learndash_get_groups(true);

				if( $groups && !empty($groups) ): ?>

				<table class="form-table">
					<tbody>
						<tr valign="top">
							<th scope="row" valign="top">
								<label for="note-support"><?php esc_html_e( 'Only allow notes for users within specified LearnDash Groups', 'sfwd-lms' ); ?></label>
							</th>
							<td>
								<?php
								$active_groups = get_option( 'ldnt_groups' );

								if( !$active_groups ) {
									$active_groups = array();
								}

								foreach( $groups as $group_id ) {

									$checked = '';

									foreach( $active_groups as $key => $status ) {
										if( $key == $group_id && $status == 'true' ) {
											$checked = 'checked';
										}
									}

									$group_object = get_post($group_id);

									echo '<p><label for="ldnt-group-' . $group_id . '"><input id="ldnt-group-' . $group_id . '" name="ldnt_groups[' . $group_id . ']" type="checkbox" value="true" ' . $checked . '>'. get_the_title($group_id) .'</label></p>';

								} ?>
							</td>
						</tr>
						<tr>
							<th scope="row" valign="top">
								<label for="note-support"><?php esc_html_e( 'Only allow notes for users with specified WordPress Roles', 'sfwd-lms' ); ?></label>
							</th>
							<td>
								<?php
								$active_roles = get_option('ldnt_roles');

								if( !$active_roles ) {
									$active_roles = array();
								}

								global $wp_roles;

								if ( ! isset( $wp_roles ) ){
									$wp_roles = new WP_Roles();
								}

								$roles = $wp_roles->get_names();

								//remove defaults
								unset($roles['administrator']);
								unset($roles['editor']);
								unset($roles['group_leader']);

								foreach( $roles as $role_value => $role_name ) {

									$checked = '';

									foreach( $active_roles as $slug => $value ){

										if( $slug == $role_value && $value == 'true'){
											$checked = 'checked';
										}

									}
									echo '<p><label for="ldnt-role-' . $role_value . '"><input id="ldnt-role-' . $role_value . '" name="ldnt_roles[' . $role_value . ']" type="checkbox" value="true" ' . $checked . '>' . $role_name . '</label></p>';
								} ?>
							</td>
					</table>

				<?php endif; ?>

				<br>
				<hr>
				<br>

				<h3><?php esc_html_e( 'Apperance', 'sfwd-lms' ); ?></h3>

				<table class="form-table">
					<tr>
						<th scope="row" valign="top">
							<label for="nt_noteicon_placement"><?php esc_html_e( 'Note Icon Placement', 'sfwd-lms' ); ?></label>
						</th>
						<td>
							<select name="nt_noteicon_placement" id="nt_noteicon_placement">
								<option value="bottom" <?php if( $placement == 'bottom' ) { echo 'selected'; } ?>><?php esc_html_e( 'Fixed to the bottom of the screen', 'sfwd-lms' ); ?></option>
								<option value="top" <?php if( $placement == 'top' ) { echo 'selected'; } ?>><?php esc_html_e( 'Fixed to the top of the screen', 'sfwd-lms' ); ?></option>
								<option value="above-content" <?php if( $placement == 'above-content' ) { echo 'selected'; } ?>><?php esc_html_e( 'Above the content', 'sfwd-lms' ); ?></option>
								<option value="below-content" <?php if( $placement == 'below-content' ) { echo 'selected'; } ?>><?php esc_html_e( 'Below the content', 'sfwd-lms' ); ?></option>
								<option value="shortcode" <?php if( $placement == 'shortcode' ) { echo 'selected'; } ?>><?php esc_html_e( 'Using the [notepad] shortcode', 'sfwd-lms' ); ?></option>
							</select>
						</td>
					</tr>
					<tr id="nt-note-placement-right" style="display:none">
						<th scope="row" valign="top">
							<label for="nt_noteicon_placement_right"><?php esc_html_e( 'Distance from Right', 'sfwd-lms' ); ?></label>
						</th>
						<td>
							<input type="text" value="<?php echo get_option('nt_noteicon_placement_right', 30 ); ?>" name="nt_noteicon_placement_right" id="nt_noteicon_placement_right">
							<small><i><?php esc_html_e( 'Number of pixels from the right portion of the screen the button will display', 'sfwd-lms' ); ?></i></small>
						</td>
					</tr>
					<script>
						jQuery(document).ready(function($) {

							function nt_note_side_placement_toggle() {
								if( $('#nt_noteicon_placement').val() == 'bottom' || $('#nt_noteicon_placement').val() == 'top' ) {
									$('#nt-note-placement-right').show();
								} else {
									$('#nt-note-placement-right').hide();
								}
							}

							$('#nt_noteicon_placement').change(function(e) {
								nt_note_side_placement_toggle();
							});

							nt_note_side_placement_toggle();

						});
					</script>
					<tr>
						<th scope="row" valign="top">
							<label for="nt_noteicon_hide_on_mobile"><?php esc_html_e( 'Hide on Mobile', 'sfwd-lms' ); ?></label>
						</th>
						<td>
							<select name="nt_noteicon_hide_on_mobile">
								<option value="yes" <?php if( $hide_mobile == 'yes' ) { echo 'selected'; } ?>><?php esc_html_e( 'Yes', 'sfwd-lms' ); ?></option>
								<option value="no" <?php if( $hide_mobile == 'no' ) { echo 'selected'; } ?>><?php esc_html_e( 'No', 'sfwd-lms' ); ?></option>
							</select>
						</td>
					</tr>
					<tr>
						<th scope="row" valign="top">
							<label for="nt_background_color"><?php esc_html_e( 'Notepad / Icon Background Color', 'sfwd-lms' ); ?></label>
						</th>
						<td>
							<input tpe="text" name="nt_background_color" value="<?php echo esc_attr( $colors[ 'background_color' ] ); ?>" class="wp-color-picker">
						</td>
					</tr>
					<tr>
						<th scope="row" valign="top">
							<label for="nt_text_color"><?php esc_html_e( 'Notepad / Icon Text Color', 'sfwd-lms' ); ?></label>
						</th>
						<td>
							<input tpe="text" name="nt_text_color" value="<?php echo esc_attr( $colors[ 'text_color' ] ); ?>" class="wp-color-picker">
						</td>
					</tr>
					<tr>
						<th scope="row" valign="top">
							<label for="nt_header_background"><?php esc_html_e( 'Notepad Header Background', 'sfwd-lms' ); ?></label>
						</th>
						<td>
							<input tpe="text" name="nt_header_background" value="<?php echo esc_attr( $colors[ 'header_background' ] ); ?>" class="wp-color-picker">
						</td>
					</tr>
					<tr>
						<th scope="row" valign="top">
							<label for="nt_header_text"><?php esc_html_e( 'Notepad Header Text', 'sfwd-lms' ); ?></label>
						</th>
						<td>
							<input tpe="text" name="nt_header_text" value="<?php echo esc_attr( $colors[ 'header_text' ] ); ?>" class="wp-color-picker">
						</td>
					</tr>
					<tr>
						<th scope="row" valign="top">
							<label for="nt_link_color"><?php esc_html_e( 'Notepad Link/Icon Colors', 'sfwd-lms' ); ?></label>
						</th>
						<td>
							<input tpe="text" name="nt_link_color" value="<?php echo esc_attr( $colors[ 'link_color' ] ); ?>" class="wp-color-picker">
						</td>
					</tr>
					<tr>
						<th scope="row" valign="top">
							<label for="nt_button_background"><?php esc_html_e( 'Notepad Button Background', 'sfwd-lms' ); ?></label>
						</th>
						<td>
							<input tpe="text" name="nt_button_background" value="<?php echo esc_attr( $colors[ 'button_background' ] ); ?>" class="wp-color-picker">
						</td>
					</tr>
					<tr>
						<th scope="row" valign="top">
							<label for="nt_button_text"><?php esc_html_e( 'Notepad Button Text', 'sfwd-lms' ); ?></label>
						</th>
						<td>
							<input tpe="text" name="nt_button_text" value="<?php echo esc_attr( $colors[ 'button_text' ] ); ?>" class="wp-color-picker">
						</td>
					</tr>
				</tbody>
			</table>

			<?php
			submit_button(); ?>

		</form>
	<?php
}
function learndash_notes_register_option() {
	// creates our settings in the options table
	register_setting('learndash_notes_license', 'learndash_notes_license_key', 'learndash_notes_sanitize_license' );

	$settings = array(
		'ldnt_notes_courses',
		'ldnt_notes_lessons',
		'ldnt_notes_topics',
		'ldnt_notes_assignments',
		'ldnt_notes_quizes',
		'ldnt_link_new_windows',
		'ldnt_show_notes_in_admin',
		'nt_noteicon_placement',
		'nt_noteicon_hide_on_mobile',
		'nt_text_color',
		'nt_background_color',
		'nt_header_background',
		'nt_header_text',
		'nt_link_color',
		'nt_button_background',
		'nt_button_text',
		'ldnt_all_notes_page',
		'ldnt_supported_types',
		'ldnt_groups',
		'ldnt_roles',
		'nt_noteicon_placement_right',
		'ldnt_autosave'
	);

	foreach( $settings as $setting ) {

		register_setting( 'learndash_notes_license', $setting );

	}

}
add_action('admin_init', 'learndash_notes_register_option');

function learndash_notes_sanitize_license( $new ) {
	$old = get_option( 'learndash_notes_license_key' );
	if( $old && $old != $new ) {
		delete_option( 'learndash_notes_license_status' ); // new license has been entered, so must reactivate
	}
	return $new;
}

function learndash_notes_activate_license() {
	// listen for our activate button to be clicked
	if( isset( $_POST[ 'learndash_notes_license_activate' ] ) ) {
		// run a quick security check
	 	if( ! check_admin_referer( 'learndash_notes_nonce', 'learndash_notes_nonce' ) )
			return; // get out if we didn't click the Activate button
		// retrieve the license from the database
		$license = trim( $_POST[ 'learndash_notes_license_key'] );

		// data to send in our API request
		$api_params = array(
			'edd_action'=> 'activate_license',
			'license' 	=> $license,
			'item_name' => urlencode( PSP_NOTES_ITEM_NAME ), // the name of our product in EDD,
			'url'       => home_url()
		);

		$response = wp_remote_get( add_query_arg( $api_params, PSP_NOTES_STORE_URL ), array( 'timeout' => 15, 'sslverify' => false ) );

		// make sure the response came back okay
		if ( is_wp_error( $response ) )
			return false;
		// decode the license data
		$license_data = json_decode( wp_remote_retrieve_body( $response ) );

		// $license_data->license will be either "active" or "inactive"
		update_option( 'learndash_notes_license_status', $license_data->license );
	}
}
add_action('admin_init', 'learndash_notes_activate_license');

function ldnt_migrate_notes() {

	$args = array(
		'post_type'			=>	'coursenote',
		'posts_per_page'	=>	-1,
		'fields'			=>	'ids',
	);

	$notes = get_posts( $args );

	foreach( $notes as $note ) {

		$relationships = ldnt_get_post_relationships( get_post_meta( $note, 'nt-note-current-lessson-id', true ) );

		foreach( $relationships as $key => $val ) {

			update_post_meta( $note, '_' . $key, $val );

		}

	}

	echo 'Migrated';

}

add_action( 'add_meta_boxes', 'ldnt_register_metaboxes' );
function ldnt_register_metaboxes() {

	$types = ldnt_get_supported_types();
	if( in_array( get_post_type(), $types ) ) {

		add_meta_box( 'ldnt_note_options', __( 'Note Options', 'sfwd-lms' ), 'ldnt_note_options_metabox' );

	}

	if( get_post_type() == 'coursenote' ) {

		add_meta_box( 'ldnt_note_details', __( 'Note Details', 'sfwd-lms' ), 'ldnt_note_details_metabox', null, 'advanced' );

	}

}

function ldnt_note_options_metabox() {

	global $post; ?>

	<input type="hidden" name="ldnt_noncename" id="ldnt_noncename" value="<?php echo wp_create_nonce( plugin_basename( __FILE__ ) ); ?>" />

	<?php

	$disabled_setting	= get_post_meta( $post->ID, '_ldnt_disable_notes', true );
	$disabled 			= ( !empty( $disabled_setting ) ? 'checked' : '' );
	$body 				= get_post_meta( $post->ID, '_ldnt_default_note_text', true );
	$title				= get_post_meta( $post->ID, '_ldnt_default_note_title', true ); ?>

	<p class="meta-options"><label for="ldnt_disable_notes"><input type="checkbox" name="ldnt_disable_notes" value="yes" <?php echo $disabled; ?>> <?php esc_html_e( 'Disable notes on this page', 'sfwd-lms' ); ?></label></p>
	<br>
	<p class="meta-options"><label for="ldnt_default_note_title"><strong><?php esc_html_e( 'Default note title', 'sfwd-lms' ); ?></strong></label> <input type="text" name="ldnt_default_note_title" value="<?php echo esc_attr( $title ); ?>"></p>
	<p class="meta-options"><label for="ldnt_default_note_text"><strong><?php esc_html_e( 'Default text in the notes editor', 'sfwd-lms' ); ?></strong></label><br>

		<?php
		$args = array(
			'media_buttons'		=>		false,
			'textarea_name'		=>		'ldnt_default_note_text',
			'editor_height'		=>		175,
			'quicktags'			=>		false,
			'teeny'				=>		true,
			'quicktags'			=>		false,
		);

		add_filter( 'teeny_mce_buttons', 'nt_tiny_mce_buttons', 10, 2);
		wp_editor( $body, 'ldnt_default_note_text', $args );
		remove_filter( 'teeny_mce_buttons', 'nt_tiny_mce_buttons' ); ?>

	<?php
}

function ldnt_note_details_metabox() {

	global $post;
	$author = get_the_author_meta( '', $post->post_author );
	?>

	<div class="wrap">

		<table class="form-table">
			<tr>
				<th><?php esc_html_e( 'Author', 'sfwd-lms'); ?></th>
				<td><a href="<?php echo esc_url( get_edit_user_link( $post->post_author ) ); ?>"><?php echo esc_html( get_userdata( $post->post_author )->display_name ); ?></a></td>
			</tr>
			<tr>
				<th><?php esc_html_e( 'Recorded', 'sfwd-lms' ); ?></th>
				<td><?php echo nt_course_breadcrumbs( get_post_meta( $post->ID, '_nt-course-array', true ) ); ?></td>
			</tr>
		</table>
	</div>

	<?php

}

add_action( 'save_post', 'ldnt_note_meta_save' );
function ldnt_note_meta_save( $post_id ) {

	if( !isset( $_POST['ldnt_noncename'] ) ) return $post_id;

	if ( !wp_verify_nonce( $_POST[ 'ldnt_noncename' ], plugin_basename( __FILE__ ) ) )
		return $post_id;

	if ( !current_user_can( 'edit_post', $post_id ) )
		  return $post_id;

	$types = ldnt_get_supported_types();

	if( in_array( get_post_type( $post_id ), $types ) ) {

		$disabled 		= $_POST[ 'ldnt_disable_notes' ];
		$default_notes 	= $_POST[ 'ldnt_default_note_text' ];
		$default_title 	= $_POST[ 'ldnt_default_note_title' ];

		if( $disabled == 'yes' ) {

			update_post_meta( $post_id, '_ldnt_disable_notes', 'yes' );

		} else {

			delete_post_meta( $post_id, '_ldnt_disable_notes' );

		}

		if( !empty( $default_notes ) ) {

			update_post_meta( $post_id, '_ldnt_default_note_text', $default_notes );

		} else {

			delete_post_meta( $post_id, '_ldnt_default_note_text' );

		}

		if( !empty( $default_title ) ) {

			update_post_meta( $post_id, '_ldnt_default_note_title', $default_title );

		} else {

			delete_post_meta( $post_id, '_ldnt_default_note_title' );

		}

	}

}

function nt_deactivate_license() {

	// listen for our activate button to be clicked
	if( isset( $_POST['learndash_notes_license_deactivate'] ) ) {

		// run a quick security check
	 	if( ! check_admin_referer( 'learndash_notes_nonce', 'learndash_notes_nonce' ) )
			return; // get out if we didn't click the deactivate button

		// retrieve the license from the database
		$license = trim( get_option( 'learndash_notes_license_key' ) );

		// data to send in our API request
		$api_params = array(
			'edd_action'=> 'deactivate_license',
			'license' 	=> $license,
			'item_name' => urlencode( PSP_NOTES_ITEM_NAME ) // the name of our product in EDD
		);

		// Call the custom API.
		$response = wp_remote_get( add_query_arg( $api_params, PSP_NOTES_STORE_URL ), array( 'timeout' => 15, 'sslverify' => false ) );

		// make sure the response came back okay
		if ( is_wp_error( $response ) )
			return false;

		// decode the license data
		$license_data = json_decode( wp_remote_retrieve_body( $response ) );

		// $license_data->license will be either "deactivated" or "failed"
		if( $license_data->license == 'deactivated' )
			delete_option( 'learndash_notes_license_status' );

	}
}
add_action('admin_init', 'nt_deactivate_license',1);

function nt_check_activation_response() {

    // retrieve the license from the database
    $license = trim( get_option( 'lds_skins_license_key' ) );


    // data to send in our API request
    $api_params = array(
        'edd_action'=> 'activate_license',
        'license' 	=> $license,
        'item_name' => urlencode( PSP_NOTES_ITEM_NAME ), // the name of our product in EDD
        'url'   => home_url()
    );

    // Call the custom API.
    $response = wp_remote_get( add_query_arg( $api_params, PSP_NOTES_STORE_URL ), array( 'timeout' => 15, 'sslverify' => false ) );

	var_dump($response);

}

function notes_delete_user_data( $user_id ) {

	if( !isset($user_id) || empty($user_id) || !is_int($user_id) ) {
		return false;
	}

	$notes = get_posts( array(
		'meta_key' 			=> 'nt-note-user-id',
		'meta_value' 		=> $user_id,
		'post_type' 		=> 'coursenote',
		'posts_per_page'	=> -1
	) );

	if( empty($notes) ) {
		return false;
	}

	foreach($notes as $note) {

		if( $user_id !== get_post_field( 'post_author', $note->ID ) ) {
			return false;
		}

		wp_delete_post( $note->ID , true );

	}

}
