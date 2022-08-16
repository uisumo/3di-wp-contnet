<?php 

/* Defines picture filter select options. */
function dmb_tmmp_picture_filter_options() {
	$options = array ( 
		__('None', TMMP_TXTDM ) => 'classic',
		__('Vintage', TMMP_TXTDM ) => 'vintage',
		__('Black & White', TMMP_TXTDM ) => 'blackandwhite',
		__('Saturated', TMMP_TXTDM ) => 'saturated'
	);
	return $options;
}


/* Defines picture position select options. */
function dmb_tmmp_picture_position_options() {
	$options = array ( 
		__('Floating top', TMMP_TXTDM ) => 'floating',
		__('Inside the box', TMMP_TXTDM ) => 'inbox',
		__('Full width', TMMP_TXTDM ) => 'full',
	);
	return $options;
}


/* Defines picture border select options. */
function dmb_tmmp_picture_border_options() {
	$options = array ( 
		__('Yes', TMMP_TXTDM ) => 'yes',
		__('No', TMMP_TXTDM ) => 'no'
	);
	return $options;
}


/* Defines picture shape select options. */
function dmb_tmmp_picture_shape_options() {
	$options = array ( 
		__('Rounded', TMMP_TXTDM ) => 'rounded',
    __('Circular', TMMP_TXTDM ) => 'circular',
		__('Square', TMMP_TXTDM ) => 'square'
    
	);
	return $options;
}


/* Defines force font select options. */
function dmb_tmmp_force_fonts_options() {
	$options = array ( 
		__('Use plugin defaults', TMMP_TXTDM ) => 'yes',
		__('Use fonts from my theme', TMMP_TXTDM ) => 'no'
	);
	return $options;
}


/* Defines picture link behavior options. */
function dmb_tmmp_piclink_beh_options(){
	$options = array ( 
		__('New window', TMMP_TXTDM ) => 'new', 
		__('Same window', TMMP_TXTDM ) => 'same' 
	);
	return $options;
}


/* Defines additional info theme select options. */
function dmb_tmmp_additional_info_theme_options() {
	$options = array ( 
		__('Dark', TMMP_TXTDM ) => 'dark',
		__('Bright', TMMP_TXTDM ) => 'bright'
	);
	return $options;
}


/* Defines bio alignment options. */
function dmb_tmmp_bio_align_options() {
	$options = array ( 
		__('Center', TMMP_TXTDM) => 'center',
		__('Left', TMMP_TXTDM) => 'left',
		__('Right', TMMP_TXTDM) => 'right',
		__('Justify', TMMP_TXTDM) => 'justify'    
	);
	return $options;
}


/* Defines team columns options. */
function dmb_tmmp_columns_options() {
	$options = array ( 
		__('1 per line', TMMP_TXTDM) => '1',
		__('2 per line', TMMP_TXTDM) => '2',
		__('3 per line', TMMP_TXTDM) => '3',
		__('4 per line', TMMP_TXTDM) => '4',
		__('5 per line', TMMP_TXTDM) => '5'    
	);
	return $options;
}


/* Defines equalizer select options. */
function dmb_tmmp_equalizer_options() {
	$options = array ( 
		__('Disabled', TMMP_TXTDM ) => 'no',
		__('Enabled', TMMP_TXTDM ) => 'yes',
	);
	return $options;
}


/* Hooks the metabox. */
add_action('admin_init', 'dmb_tmmp_add_settings', 1);
function dmb_tmmp_add_settings() {
	add_meta_box( 
		'tmm_settings', 
		'Settings', 
		'dmb_tmmp_settings_display', 
		'tmm', 
		'side', 
		'high'
	);
}


/* Displays the metabox. */
function dmb_tmmp_settings_display() { 
	
	global $post;

	/* Retrieves select options. */
	$team_columns = dmb_tmmp_columns_options();
	$team_bio_align = dmb_tmmp_bio_align_options();
	$team_piclink_beh = dmb_tmmp_piclink_beh_options();
	$team_force_font = dmb_tmmp_force_fonts_options();
	$team_picture_shape = dmb_tmmp_picture_shape_options();
	$team_picture_border = dmb_tmmp_picture_border_options();
	$team_picture_position = dmb_tmmp_picture_position_options();
	$team_picture_filter = dmb_tmmp_picture_filter_options();
	$team_comp_theme = dmb_tmmp_additional_info_theme_options();
	$team_equalizer = dmb_tmmp_equalizer_options();

	/* Processes retrieved fields. */
	$settings = array();

	$settings['_tmm_columns'] = get_post_meta( $post->ID, '_tmm_columns', true );
	if (!$settings['_tmm_columns']) { $settings['_tmm_columns'] = '3'; }
	
	$settings['_tmm_bio_alignment'] = get_post_meta( $post->ID, '_tmm_bio_alignment', true );

	/*Checks if member links open in new window. */
	$settings['_tmm_piclink_beh'] = get_post_meta( $post->ID, '_tmm_piclink_beh', true );
	($settings['_tmm_piclink_beh'] == 'new' ? $tmm_plb = 'target="_blank"' : $tmm_plb = '');

	/* Checks if forcing original fonts. */
	$settings['_tmm_original_font'] = get_post_meta( $post->ID, '_tmm_original_font', true );
	if (!$settings['_tmm_original_font']) { $settings['_tmm_original_font'] = 'yes'; }

	/* Checks picture settings. */
	$settings['_tmm_picture_shape'] = get_post_meta( $post->ID, '_tmm_picture_shape', true );
	$settings['_tmm_picture_position'] = get_post_meta( $post->ID, '_tmm_picture_position', true );
	$settings['_tmm_picture_filter'] = get_post_meta( $post->ID, '_tmm_picture_filter', true );
	$settings['_tmm_picture_border'] = get_post_meta( $post->ID, '_tmm_picture_border', true );
	$settings['_tmm_comp_theme'] = get_post_meta( $post->ID, '_tmm_comp_theme', true );
	$settings['_tmm_equalizer'] = get_post_meta( $post->ID, '_tmm_equalizer', true );

	$settings['_tmm_tp_border_size'] = get_post_meta( $post->ID, '_tmm_tp_border_size', true );
	if (
		!isset($settings['_tmm_tp_border_size']) 
		|| $settings['_tmm_tp_border_size'] === null 
		|| $settings['_tmm_tp_border_size'] == '' 
		) { 
			$settings['_tmm_tp_border_size'] = '5'; 
		}

	?>

	<div class="dmb_settings_box dmb_sidebar">

		<div class="dmb_section_title">
			<?php /* translators: General settings */ _e('General', TMMP_TXTDM) ?>
		</div>

		<!-- Team layout -->
		<div class="dmb_grid dmb_grid_50 dmb_grid_first">
			<div class="dmb_field_title">
				<?php _e('Members per line', TMMP_TXTDM ) ?>
			</div>
			<select class="dmb_side_select" name="team_columns">
				<?php foreach ( $team_columns as $label => $value ) { ?>
					<option value="<?php echo $value; ?>"<?php selected( (isset($settings['_tmm_columns'])) ? $settings['_tmm_columns'] : '3', $value ); ?>><?php echo $label; ?></option>
				<?php } ?>
			</select>
		</div>

		<!-- Photo link behavior -->
		<div class="dmb_grid dmb_grid_50 dmb_grid_last">
			<div class="dmb_field_title">
				<?php _e('Photo link behavior', TMMP_TXTDM ) ?>
			</div>
			<select class="dmb_side_select" name="team_piclink_beh">
				<?php foreach ( $team_piclink_beh as $label => $value ) { ?>
					<option value="<?php echo $value; ?>"<?php selected( (isset($settings['_tmm_piclink_beh'])) ? $settings['_tmm_piclink_beh'] : 'new', $value ); ?>><?php echo $label; ?></option>
				<?php } ?>
			</select>
		</div>

			<!-- Font option -->
			<div class="dmb_grid dmb_grid_100 dmb_grid_first dmb_grid_last">
			<div class="dmb_field_title">
				<?php _e('Fonts to use', TMMP_TXTDM ) ?>
			</div>
			<select class="dmb_side_select" name="team_force_font">
				<?php foreach ( $team_force_font as $label => $value ) { ?>
					<option value="<?php echo $value; ?>"<?php selected( (isset($settings['_tmm_original_font'])) ? $settings['_tmm_original_font'] : 'yes', $value ); ?>><?php echo $label; ?></option>
				<?php } ?>
			</select>
		</div>



		<div class="dmb_clearfix"></div>

		<div class="dmb_section_title">
			<span style="color:#8ea93d;">[PRO]</span>
			<?php _e('Styling', TMMP_TXTDM) ?>
		</div>

		<!-- Equalizer -->
		<div class="dmb_grid dmb_grid_50 dmb_grid_first">
			<div class="dmb_field_title">
				<?php _e('Equalizer', TMMP_TXTDM ) ?>
				<a class="dmb_inline_tip dmb_tooltip_medium" data-tooltip="<?php _e('Enabling this will give the same height to all the member boxes.', TMMP_TXTDM ) ?>">[?]</a>
			</div>
			<select class="dmb_side_select" name="team_equalizer">
				<?php foreach ( $team_equalizer as $label => $value ) { ?>
				<option value="<?php echo $value; ?>"<?php selected( (isset($settings['_tmm_equalizer'])) ? $settings['_tmm_equalizer'] : 'no', $value ); ?>><?php echo $label; ?></option>
				<?php } ?>
			</select>
		</div>

		<!-- Picture position -->
		<div class="dmb_grid dmb_grid_50 dmb_grid_last dmb_layout_select">
			<div class="dmb_field_title">
				<?php _e('Layout', TMMP_TXTDM ) ?>
			</div>
			<select class="dmb_side_select" name="team_picture_position">
				<?php foreach ( $team_picture_position as $label => $value ) { ?>
					<option value="<?php echo $value; ?>"<?php selected( (isset($settings['_tmm_picture_position'])) ? $settings['_tmm_picture_position'] : 'floating', $value ); ?>><?php echo $label; ?></option>
				<?php } ?>
			</select>
		</div>
	
    <!-- Border size -->
		<div class="dmb_grid dmb_grid_50 dmb_grid_first">
			<div class="dmb_field_title">
				<?php _e('Top border size', TMMP_TXTDM ) ?>
				<a class="dmb_inline_tip dmb_tooltip_small" data-tooltip="<?php _e('The thickness of the member\'s top border in pixels (e.g. 5).', TMMP_TXTDM ) ?>">[?]</a>
			</div>
			<input class="dmb_field dmb_tp_border_size_of_member" type="number" name="team_tp_border_size" value="<?php echo $settings['_tmm_tp_border_size']; ?>" placeholder="<?php _e('e.g. 5', TMMP_TXTDM ) ?>" />
		</div>

		<!-- Picture filter -->
		<div class="dmb_grid dmb_grid_50 dmb_grid_last">
			<div class="dmb_field_title">
				<?php _e('Photo filter', TMMP_TXTDM ) ?>
			</div>
			<select class="dmb_side_select" name="team_picture_filter">
				<?php foreach ( $team_picture_filter as $label => $value ) { ?>
					<option value="<?php echo $value; ?>"<?php selected( (isset($settings['_tmm_picture_filter'])) ? $settings['_tmm_picture_filter'] : 'classic', $value ); ?>><?php echo $label; ?></option>
				<?php } ?>
			</select>
		</div>

		<!-- Picture border -->
		<div class="dmb_grid dmb_grid_50 dmb_grid_first dmb_picture_border_box">
			<div class="dmb_field_title">
				<?php _e('Photo border', TMMP_TXTDM ) ?>
			</div>
			<select class="dmb_side_select" name="team_picture_border">
				<?php foreach ( $team_picture_border as $label => $value ) { ?>
					<option value="<?php echo $value; ?>"<?php selected( (isset($settings['_tmm_picture_border'])) ? $settings['_tmm_picture_border'] : 'yes', $value ); ?>><?php echo $label; ?></option>
				<?php } ?>
			</select>
		</div>

		<!-- Picture shape -->
		<div class="dmb_grid dmb_grid_50 dmb_grid_last dmb_picture_shape_box">
			<div class="dmb_field_title">
				<?php _e('Photo shape', TMMP_TXTDM ) ?>
			</div>
			<select class="dmb_side_select" name="team_picture_shape">
				<?php foreach ( $team_picture_shape as $label => $value ) { ?>
					<option value="<?php echo $value; ?>"<?php selected( (isset($settings['_tmm_picture_shape'])) ? $settings['_tmm_picture_shape'] : 'rounded', $value ); ?>><?php echo $label; ?></option>
				<?php } ?>
			</select>
		</div>

    <!-- Add. info theme -->
    <div class="dmb_grid dmb_grid_50 dmb_grid_first">
			<div class="dmb_field_title">
				<?php _e('Add. info theme', TMMP_TXTDM ) ?>
				<a class="dmb_inline_tip dmb_tooltip_medium" data-tooltip="<?php _e('This is the color scheme for the additional information toggle box.', TMMP_TXTDM ) ?>">[?]</a>
			</div>
			<select class="dmb_side_select" name="team_comp_theme">
				<?php foreach ( $team_comp_theme as $label => $value ) { ?>
					<option value="<?php echo $value; ?>"<?php selected( (isset($settings['_tmm_comp_theme'])) ? $settings['_tmm_comp_theme'] : 'dark', $value ); ?>><?php echo $label; ?></option>
				<?php } ?>
			</select>
		</div>

		<div class="dmb_clearfix"></div>

	</div>

<?php } ?>