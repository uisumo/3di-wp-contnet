<?php
function lds_appearance_settings() {

	if( !current_user_can( 'manage_options' ) )
		wp_die( __('You do not have sufficient permissions to access this page.') );

	// Listen for license activation
	lds_skins_activate_license();

	$active_tab = ( isset( $_GET[ 'tab' ] ) ? $_GET[ 'tab' ] : 'lds_visuals' ); ?>

    <div class="wrap">
        <div id="icon-tools" class="icon32"></div>

			<form id="poststuff" method="post" action="options.php">

				<?php
                do_settings_sections( 'lds_customizer' );

                settings_fields('lds_customizer'); ?>

                <div class="postbox">
                    <h2 class="hndle ui-sortable-handle">
                        <span><?php esc_html_e( 'Customize LearnDash', 'lds_skins' ); ?></span>
                        <div class="ld-metabox-description"><p><?php esc_html_e( 'LearnDash Visual Customizer is now controlled through the Theme Customizer! Please select a course to preview to start your customizations.', 'lds_skins' ); ?></p></div>
                    </h2>
					<input type="hidden" id="ldvc-preview-url" name="ldvc-preview-url" value="<?php echo esc_attr(admin_url()); ?>">
                    <div class="inside">
						<div class="lds-flex">
	                        <div class="sfwd sfwd_options lds-flex-half lds-preview-setting">
	                            <div class="sfwd_option_label"><?php esc_html_e( 'Preview Course', 'lds_skins' ); ?></div>
	                            <div class="sfwd_option_input">
	                                <?php
	                                $args = array(
	                                    'post_type' =>  'sfwd-courses',
	                                    'posts_per_page'    => 50
	                                );
	                                $courses = new WP_Query($args);

	                                if( $courses->have_posts() ): ?>
	                                    <select name="ldvc_course_preview" id="ldvc_course_preview">
	                                        <?php
	                                        while( $courses->have_posts() ): $courses->the_post(); ?>
	                                            <option value="<?php the_permalink(); ?>"><?php the_title(); ?></option>
	                                        <?php endwhile; ?>
	                                    </select>
	                                    <button class="ldvc-course-preview-btn button-primary"><?php esc_html_e( 'Customize LearnDash', 'lds_skins' ); ?></button>
	                                <?php else: ?>
	                                    <p><em><?php esc_html_e( 'Please create a course to start customizing', 'lds_skins' ); ?></em></p>
	                                <?php endif; ?>

	                            </div> <!--/.sfwd_option_input-->
	                        </div>
							<div class="lds-flex-half">
								<img src="<?php echo LDS_URL; ?>/assets/img/ldvc-customizer-preview.png" alt="Screenshot of where you can customize LearnDash">
							</div>
						</div>
					</div>
                </div> <!--/.postbox-->

                <div class="postbox">
                    <h2 class="hndle ui-sortable-handle">
                        <span><?php esc_html_e( 'Manage License', 'lds_skins' ); ?></span>
                    </h2>
                    <div class="inside">
                        <?php
                        if( isset( $_GET[ 'lds_activate_response' ] ) ): ?>
                            <div class="lds-status-message">
                               <pre>
                                   <?php lds_check_activation_response(); ?>
                               </pre>
                            </div>
                        <?php
                        endif;

                        $fields = apply_filters( 'ldvc_settings_fields', array(
                            array(
                                'slug'  =>  'license_key',
                                'name'  =>  'lds_skins_license_key',
                                'label' =>  __( 'License Key', 'lds_skins' ),
                                'value' =>  get_option('lds_skins_license_key'),
                                'description'   =>  __( 'Enter your license key and then save.', 'lds_skins' ),
                                'type'  =>  'license_key',
                                'status' => get_option('lds_skins_license_status'),
                            ),
                        ) );

                        foreach( $fields as $field ) {
                            call_user_func( 'ldvc_field_' . $field['type'], $field );
                        } ?>

                    </div>

                </div>

				<div class="postbox">
					<h2 class="hndle ui-sortable-handle">
						<span><?php esc_html_e( 'Settings', 'lds_skins' ); ?></span>
					</h2>
					<div class="inside">
						<div class="sfwd sfwd_options ldvc-advanced-settings">
							<?php
							$fields = apply_filters( 'ldvc_advanced_settings_fields', array(
								array(
									'slug'  =>  'lds_fontawesome_ver',
									'name'  =>  'lds_fontawesome_ver',
									'label' =>  __( 'FontAwesome Version', 'lds_skins' ),
									'value' =>  get_option( 'lds_fontawesome_ver' , '5' ),
									'description'   =>  __( 'If you\'re icons are not rendering as intended try switching to V4', 'lds_skins' ),
									'type'  =>  'select',
									'options'	=>	array(
										'5'	=> '5',
										'4'	=> '4',
										'none'	=>	'None',
									),
								),
								array(
									'slug'  =>  'lds_minify_css',
									'name'  =>  'lds_minify_css',
									'label' =>  __( 'Minify CSS', 'lds_skins' ),
									'value' =>  get_option( 'lds_minify_css' , 'yes' ),
									'description'   =>  __( 'If you\'re having styling issues try disabling this', 'lds_skins' ),
									'type'  =>  'select',
									'options'	=>	array(
										'yes'	=> 'yes',
										'no'	=> 'no',
									),
								),
							) );

							foreach( $fields as $field ) {
								call_user_func( 'ldvc_field_' . $field['type'], $field );
							} ?>
						</div>
					</div>

				</div>

		        <p class="submit"><?php submit_button(); ?></p>

        </form>

	</div>

    <?php

}

add_action( 'admin_menu', 'ldvc_nonexistant_submenu_page' );
function ldvc_nonexistant_submenu_page() {
    add_submenu_page( 'learndash-lms-non-existant',__('LearnDash Visual Customizer','lds_skins'), __('LearnDash Visual Customizer','lds_skins'), 'manage_options', 'learndash-visual-customizer', 'lds_appearance_settings' );
}

/*
 * Add tab to the learndash settings
 *
 */
add_filter("learndash_admin_tabs", "lds_customizer_tabs");
function lds_customizer_tabs($admin_tabs) {

	$admin_tabs["apperance"] = array(
		"link"  		=>      'admin.php?page=learndash-appearance',
		"name" 			=>      __( "Visual Customizer", "lds_skins" ),
		"id"    		=>      "admin_page_learndash-appearance",
		"menu_link"     =>      "edit.php?post_type=sfwd-courses&page=sfwd-lms_sfwd_lms.php_post_type_sfwd-courses",
	);

   	return $admin_tabs;

}


add_filter("learndash_admin_tabs_on_page", "learndash_customizer_learndash_admin_tabs_on_page", 3, 3);
function learndash_customizer_learndash_admin_tabs_on_page($admin_tabs_on_page, $admin_tabs, $current_page_id) {

	$admin_tabs_on_page["admin_page_learndash-appearance"] = array_merge($admin_tabs_on_page["sfwd-courses_page_sfwd-lms_sfwd_lms_post_type_sfwd-courses"], (array) $admin_tabs_on_page["admin_page_learndash-appearance"]);

	foreach ($admin_tabs as $key => $value) {
		if($value["id"] == $current_page_id && $value["menu_link"] == "edit.php?post_type=sfwd-courses&page=sfwd-lms_sfwd_lms.php_post_type_sfwd-courses")
		{
			$admin_tabs_on_page[$current_page_id][] = "apperance";
			return $admin_tabs_on_page;
		}
	}

	return $admin_tabs_on_page;
}

function ldvc_field_select( $field ) { ?>

	<div class="sfwd_input sfwd_input_type_select ">
        <span class="sfwd_option_label">
            <?php echo esc_html( $field['label'] ); ?>
        </span>
        <span class="sfwd_option_input">
			<select class="learndash-section-field learndash-section-field-select" data-ld-select2="1" name="<?php esc_attr_e( $field['name'] ); ?>" id="<?php esc_attr_e( $field['name'] ); ?>">
				<?php
				foreach( $field['options'] as $name => $text ): ?>
					<option name="<?php esc_attr_e($name); ?>" <?php if( $field['value'] == $name ) { echo 'selected'; } ?>><?php esc_html_e($text); ?></option>
				<?php
				endforeach; ?>
			</select>
			<?php if( isset($field['description']) && !empty($field['description']) ): ?>
            	<label class="description" for="lds_skins_license_key"><?php esc_html_e($field['description']); ?></label>
			<?php endif; ?>
		</span>
    </div>

	<?php

}

function ldvc_field_license_key( $field ) { ?>

    <div class="sfwd sfwd_options lds_license_key">
        <div class="sfwd_option_label">
            <?php echo esc_html( $field['label'] ); ?>
        </div>
        <div class="sfwd_option_input">
            <input id="lds_skins_license_key" name="lds_skins_license_key" type="text" class="regular-text" value="<?php esc_attr_e( $field['value'] ); ?>" />
            <label class="description" for="lds_skins_license_key"><?php esc_html_e($field['description']); ?></label>
        </div>
    </div>
    <?php if( !empty($field['value']) ): ?>
        <div class="sfwd sfwd_options">
            <div class="sfwd_option_label">
                <?php esc_html_e( 'Status', 'lds_skins' ); ?>
            </div>
            <div class="sfwd_option_input">
                <?php if( $field['status'] !== false && $field['status'] == 'valid' ): ?>

                    <span style="color:green;" class="lds-activation-notice"><?php _e('Active','lds_skins'); ?></span>

                    <?php wp_nonce_field( 'lds_nonce', 'lds_nonce' ); ?>

                    <input type="submit" class="button-secondary" name="lds_license_deactivate" value="<?php _e('Deactivate License','lds_skins'); ?>"/>

                <?php else: ?>

                    <span style="color:red;" class="lds-activation-notice"><?php _e('Inactive','lds_skins'); ?></span>

                    <?php wp_nonce_field( 'lds_nonce', 'lds_nonce' ); ?>

                    <input type="submit" class="button-secondary" name="lds_license_activate" value="<?php _e('Activate License','lds_skins'); ?>"/>

                    <a class="button" href="<?php echo admin_url(); ?>admin.php?page=learndash-appearance&tab=lds_license&settings-updated=true&lds_activate_response=true">Check Activation Message</a>

                <?php endif; ?>
            </div>
        </div>
    <?php endif; ?>

    <?php

}

add_action( 'admin_init', 'lds_register_settings' );
function lds_register_settings() {

	$lds_settings = array(
		'lds_skins_license_key',
		'lds_skins_sanitize_license',
		'lds_animation',
		'lds_skin',
		'lds_icon_style',
		'lds_heading_bg',
		'lds_heading_txt',
		'lds_row_bg',
		'lds_row_bg_alt',
		'lds_sub_row_bg',
		'lds_sub_row_bg_alt',
		'lds_sub_row_txt',
		'lds_row_txt',
		'lds_button_bg',
		'lds_button_border_radius',
		'lds_button_txt',
		'lds_complete_button_bg',
		'lds_complete_button_txt',
		'lds_progress',
		'lds_links',
		'lds_content_list_hide_topic_quiz_counts',
		'lds_checkbox_incomplete',
		'lds_checkbox_complete',
		'lds_arrow_incomplete',
		'lds_arrow_complete',
		'lds_complete',
		'lds_widget_bg',
		'lds_widget_header_bg',
		'lds_widget_header_txt',
		'lds_widget_txt',
		'lds_open_css',
		'lds_widget_wrapper',
		'lds_widget_title',
		'ldvc_add_method',
		'lds_table_heading_font_size',
		'lds_table_row_font_size',
		'lds_table_sub_row_font_size',
		'lds_widget_heading_font_size',
		'lds_widget_text_font_size',
		'lds_dequeue_styles',
		'lds_listing_style',
		'lds_quiz_bg',
		'lds_quiz_txt',
		'lds_quiz_border_color',
		'lds_quiz_correct_txt',
		'lds_quiz_correct_bg',
        'lds_quiz_incorrect_bg',
		'lds_show_leaderboard',
		'lds_page_template',
		'lds_fontawesome_ver',
        'lds_grid_columns'
	);

	foreach($lds_settings as $setting) {
		register_setting('lds_customizer', $setting);
	}

}


function lds_options_saved() {
	if( get_option( 'ldvc_add_method' ) == 'generated' ) {
		lds_build_stylesheet();
	}
}


function lds_sanitize_license( $new ) {

	$old = get_option( 'lds_skins_license_key' );

	if( $old && $old != $new ) {

		delete_option( 'lds_skins_license_status' ); // new license has been entered, so must reactivate

	}

	return $new;
}

function lds_skins_activate_license() {

	// listen for our activate button to be clicked
	if( isset( $_POST['lds_license_activate'] ) ) {

		// run a quick security check
	 	if( ! check_admin_referer( 'lds_nonce', 'lds_nonce' ) )
			return; // get out if we didn't click the Activate button

		// retrieve the license from the database
		$license = trim( get_option( 'lds_skins_license_key' ) );

		// data to send in our API request
		$api_params = array(
			'edd_action'=> 'activate_license',
			'license' 	=> $license,
			'item_name' => urlencode( EDD_LEARNDASH_SKINS ), // the name of our product in EDD
		    'url'   => home_url()
        );

		// Call the custom API.
		$response = wp_remote_get( add_query_arg( $api_params, LDS_STORE_URL ), array( 'timeout' => 15, 'sslverify' => false ) );

		// make sure the response came back okay
		if ( is_wp_error( $response ) )
			return false;

		// decode the license data
		$license_data = json_decode( wp_remote_retrieve_body( $response ) );

		// $license_data->license will be either "active" or "inactive"

		update_option( 'lds_skins_license_status', $license_data->license );

	}

}
add_action('admin_init', 'lds_skins_activate_license',1);

function lds_check_activation_response() {

    // retrieve the license from the database
    $license = trim( get_option( 'lds_skins_license_key' ) );


    // data to send in our API request
    $api_params = array(
        'edd_action'=> 'activate_license',
        'license' 	=> $license,
        'item_name' => urlencode( EDD_LEARNDASH_SKINS ), // the name of our product in EDD
        'url'   => home_url()
    );

    // Call the custom API.
    $response = wp_remote_get( add_query_arg( $api_params, LDS_STORE_URL ), array( 'timeout' => 15, 'sslverify' => false ) );

	var_dump($response);

}


/***********************************************
* Illustrates how to deactivate a license key.
* This will descrease the site count
***********************************************/

function lds_skins_deactivate_license() {

	// listen for our activate button to be clicked
	if( isset( $_POST['lds_license_deactivate'] ) ) {

		// run a quick security check
	 	if( ! check_admin_referer( 'lds_nonce', 'lds_nonce' ) )
			return; // get out if we didn't click the deactivate button

		// retrieve the license from the database
		$license = trim( get_option( 'lds_skins_license_key' ) );


		// data to send in our API request
		$api_params = array(
			'edd_action'=> 'deactivate_license',
			'license' 	=> $license,
			'item_name' => urlencode( EDD_LEARNDASH_SKINS ) // the name of our product in EDD
		);

		// Call the custom API.
		$response = wp_remote_get( add_query_arg( $api_params, LDS_STORE_URL ), array( 'timeout' => 15, 'sslverify' => false ) );

		// make sure the response came back okay
		if ( is_wp_error( $response ) )
			return false;

		// decode the license data
		$license_data = json_decode( wp_remote_retrieve_body( $response ) );

		// $license_data->license will be either "deactivated" or "failed"
		if( $license_data->license == 'deactivated' )
			delete_option( 'lds_skins_license_status' );

	}
}
add_action('admin_init', 'lds_skins_deactivate_license',1);


/************************************
* this illustrates how to check if
* a license key is still valid
* the updater does this for you,
* so this is only needed if you
* want to do something custom
*************************************/

function lds_skins_check_license() {

	global $wp_version;

	$license = trim( get_option( 'lds_skins_license_key' ) );

	$api_params = array(
		'edd_action' => 'check_license',
		'license' => $license,
		'item_name' => urlencode( EDD_LEARNDASH_SKINS )
	);

	// Call the custom API.
	$response = wp_remote_get( add_query_arg( $api_params, LDS_STORE_URL ), array( 'timeout' => 15, 'sslverify' => false ) );

	if ( is_wp_error( $response ) )
		return false;

	$license_data = json_decode( wp_remote_retrieve_body( $response ) );

	if( $license_data->license == 'valid' ) {
		echo 'valid'; exit;
		// this license is still valid
	} else {
		echo 'invalid'; exit;
		// this license is no longer valid
	}
}
