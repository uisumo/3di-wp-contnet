<?php

/* Defines highlight select options. */
function dmb_tmmp_social_links_options()
{
	$options = array(
		__('-', TMMP_TXTDM) => 'nada',
		__('Twitter', TMMP_TXTDM) => 'twitter',
		__('LinkedIn', TMMP_TXTDM) => 'linkedin',
		__('YouTube', TMMP_TXTDM) => 'youtube',
		__('Google+', TMMP_TXTDM) => 'googleplus',
		__('Facebook', TMMP_TXTDM) => 'facebook',
		__('Pinterest', TMMP_TXTDM) => 'pinterest',
		__('VK', TMMP_TXTDM) => 'vk',
		__('Instagram', TMMP_TXTDM) => 'instagram',
		__('Tumblr', TMMP_TXTDM) => 'tumblr',
		__('Research Gate', TMMP_TXTDM) => 'researchgate',
		__('Email', TMMP_TXTDM) => 'email',
		__('Website', TMMP_TXTDM) => 'website',
		__('Phone', TMMP_TXTDM) => 'phone',
		__('Other links', TMMP_TXTDM) => 'customlink'
	);
	return $options;
}


/* Hooks the metabox. */
add_action('admin_init', 'dmb_tmmp_add_team', 1);
function dmb_tmmp_add_team()
{
	add_meta_box(
		'tmm',
		__('Manage your team', TMMP_TXTDM),
		'dmb_tmmp_team_display', // Below
		'tmm',
		'normal',
		'high'
	);
}


/* Displays the metabox. */
function dmb_tmmp_team_display()
{

	global $post;

	/* Gets team data. */
	$team = get_post_meta($post->ID, '_tmm_head', true);

	$fields_to_process = array(
		'_tmm_hide',
		'_tmm_firstname',
		'_tmm_lastname',
		'_tmm_job',
		'_tmm_desc',
		'_tmm_color',
		'_tmm_comp_title', '_tmm_comp_text',
		'_tmm_sc_type1', '_tmm_sc_title1', '_tmm_sc_url1',
		'_tmm_sc_type2', '_tmm_sc_title2', '_tmm_sc_url2',
		'_tmm_sc_type3', '_tmm_sc_title3', '_tmm_sc_url3',
		'_tmm_sc_type4', '_tmm_sc_title4', '_tmm_sc_url4',
		'_tmm_sc_type5', '_tmm_sc_title5', '_tmm_sc_url5',
		'_tmm_photo',
		'_tmm_photo2',
		'_tmm_photo_url'
	);

	/* Retrieves select options. */
	$social_links_options = dmb_tmmp_social_links_options();

	wp_nonce_field('dmb_tmmp_meta_box_nonce', 'dmb_tmmp_meta_box_nonce'); ?>

<div id="dmb_preview_team">
    <!-- Closes preview button -->
    <a class="dmb_button dmb_button_huge dmb_button_gold dmb_preview_team_close" href="#">
        <?php _e('Close preview', TMMP_TXTDM) ?>
    </a>
</div>

<?php if (!class_exists('acf')) { ?>

<div id="dmb_unique_editor">
    <?php wp_editor('', 'dmb_editor', array('editor_height' => '300px'));  ?>
    <br />
    <a class="dmb_button dmb_button_huge dmb_button_blue dmb_ue_update" href="#">
        <?php _e('Update biography', TMMP_TXTDM) ?>
    </a>
    <a class="dmb_button dmb_button_huge dmb_ue_cancel" href="#">
        <?php _e('Cancel', TMMP_TXTDM) ?>
    </a>
</div>

<?php } ?>

<!-- Toolbar for member metabox -->
<div class="dmb_toolbar">
    <div class="dmb_toolbar_inner">
        <a class="dmb_button dmb_button_large dmb_expand_rows" href="#"><span
                class="dashicons dashicons-editor-expand"></span> <?php _e('Expand all', TMMP_TXTDM) ?></a>
        <a class="dmb_button dmb_button_large dmb_collapse_rows" href="#"><span
                class="dashicons dashicons-editor-contract"></span> <?php _e('Collapse all', TMMP_TXTDM) ?></a>
        <label class="dmb_import_row_label dmb_button dmb_button_large" for="dmb_import_row"><span
                class="dashicons dashicons-download"></span><?php _e('Import a member', TMMP_TXTDM); ?></label>
        <input type="file" name="dmb_import_row" id="dmb_import_row"
            class="dmb_button dmb_button_large dmb_import_row" />
        <a
            class="dmb_show_preview_team dmb_button dmb_button_huge dmb_button_gold"><?php _e('Instant preview', TMMP_TXTDM) ?></a>
        <div class="dmb_clearfix"></div>
    </div>
</div>

<?php if ($team) {

		/* Loops through rows. */
		foreach ($team as $team_member) {

			/* Retrieves each field for current member. */
			$member = array();
			foreach ($fields_to_process as $field) {
				switch ($field) {
					case '_tmm_hide':
						$member[$field] = (isset($team_member[$field])) ? esc_attr($team_member[$field]) : false;
						break;
					default:
						$member[$field] = (isset($team_member[$field])) ? esc_attr($team_member[$field]) : '';
						break;
				}
			} ?>

<!-- START member -->
<div class="dmb_main">

    <textarea class="dmb_data_dump" name="tmm_data_dumps[]"></textarea>

    <!-- member handle bar -->
    <div class="dmb_handle">
        <a class="dmb_button dmb_button_large dmb_button_compact dmb_move_row_up" href="#" title="Move up"><span
                class="dashicons dashicons-arrow-up-alt2"></span></a>
        <a class="dmb_button dmb_button_large dmb_button_compact dmb_move_row_down" href="#" title="Move down"><span
                class="dashicons dashicons-arrow-down-alt2"></span></a>
        <div class="dmb_handle_title"></div>
        <a class="dmb_button dmb_button_large dmb_button_compact dmb_remove_row_btn" href="#" title="Remove"><span
                class="dashicons dashicons-trash"></span></a>
        <a class="dmb_button dmb_button_large dmb_clone_row" href="#" title="Clone"><span
                class="dashicons dashicons-admin-page"></span><?php _e('Clone', TMMP_TXTDM); ?></a>
        <a class="dmb_button dmb_button_large dmb_export_row" href="#" title="Export"><span
                class="dashicons dashicons-upload"></span><?php _e('Export this member', TMMP_TXTDM); ?></a>
        <div class="dmb_clearfix"></div>
    </div>

    <!-- START inner -->
    <div class="dmb_inner">

        <div class="dmb_section_title">
            <?php _e('Member details', TMMP_TXTDM) ?>
        </div>

        <div class="dmb_grid dmb_grid_25 dmb_grid_first">
            <div class="dmb_field_title">
                <?php _e('First name', TMMP_TXTDM) ?>
            </div>
            <input class="dmb_field dmb_highlight_field dmb_firstname_of_member" type="text"
                value="<?php echo $member['_tmm_firstname']; ?>" placeholder="<?php _e('e.g. John', TMMP_TXTDM) ?>" />
        </div>

        <div class="dmb_grid dmb_grid_25 ">
            <div class="dmb_field_title">
                <?php _e('Lastname', TMMP_TXTDM) ?>
            </div>
            <input class="dmb_field dmb_lastname_of_member" type="text" value="<?php echo $member['_tmm_lastname']; ?>"
                placeholder="<?php _e('e.g. Doe', TMMP_TXTDM) ?>" />
        </div>

        <div class="dmb_grid dmb_grid_25">
            <div class="dmb_field_title">
                <?php _e('Job/role', TMMP_TXTDM) ?>
            </div>
            <input class="dmb_field dmb_job_of_member" type="text" value="<?php echo $member['_tmm_job']; ?>"
                placeholder="<?php _e('e.g. Project manager', TMMP_TXTDM) ?>" />
        </div>

        <div class="dmb_grid dmb_grid_25 dmb_grid_last">
            <div class="dmb_field_title">
                <span style="color:#8ea93d;">[PRO]</span>
                <?php _e('Hide', TMMP_TXTDM) ?>
                <a class="dmb_inline_tip dmb_tooltip_large"
                    data-tooltip="<?php _e('Checking this box will hide the member from the team.', TMMP_TXTDM) ?>">[?]</a>
            </div>
            <div style="position:relative; top:8px;">
                <input class="dmb_field dmb_hide_of_member" type="checkbox" value="1" <?php if ($member['_tmm_hide'] == '1') {
																										echo 'checked';
																									} ?> /> Check to hide member
            </div>
        </div>

        <div class="dmb_grid dmb_grid_100 dmb_grid_first dmb_grid_last">

            <?php if (!class_exists('acf')) { ?>

            <div class="dmb_field_title">
                <?php _e('Description/biography', TMMP_TXTDM) ?>
                <a class="dmb_inline_tip dmb_tooltip_large"
                    data-tooltip="<?php _e('Edit your member\'s biography by clicking the button below. Once updated, it will show up here.', TMMP_TXTDM) ?>">[?]</a>
            </div>

            <div class="dmb_field dmb_description_of_member">
                <?php echo $member["_tmm_desc"]; ?>
            </div>

            <?php } else { ?>

            <div class="dmb_field_title">
                <?php _e('Description/biography', TMMP_TXTDM) ?>
            </div>

            <div class="dmb_field dmb_description_of_member_fb" style="display:none !important;">
                <?php echo $member["_tmm_desc"]; ?></div>
            <textarea id="acf-fallback-bio"><?php echo $member["_tmm_desc"]; ?></textarea>

            <?php } ?>

            <div class="dmb_clearfix"></div>

            <?php if (!class_exists('acf')) { ?>
            <div class="dmb_edit_description_of_member dmb_button dmb_button_large dmb_button_blue">
                <?php _e('Edit biography', TMMP_TXTDM) ?>
            </div>
            <?php } ?>

        </div>

        <div class="dmb_clearfix"></div>

        <div class="dmb_section_title">
            <?php _e('Additional information', TMMP_TXTDM) ?>
        </div>

        <div class="dmb_grid dmb_grid_20 dmb_grid_first">
            <div class="dmb_field_title">
                <span style="color:#8ea93d;">[PRO]</span>
                <?php _e('Button text', TMMP_TXTDM) ?>
            </div>
            <input class="dmb_field dmb_comp_title_of_member" type="text"
                value="<?php echo $member['_tmm_comp_title']; ?>"
                placeholder="<?php _e('e.g. Read more', TMMP_TXTDM) ?>" />
        </div>

        <div class="dmb_grid dmb_grid_80 dmb_grid_last">
            <div class="dmb_field_title">
                <span style="color:#8ea93d;">[PRO]</span>
                <?php _e('Revealed content', TMMP_TXTDM) ?>
            </div>
            <input class="dmb_field dmb_comp_text_of_member" type="text"
                value="<?php echo $member['_tmm_comp_text']; ?>"
                placeholder="<?php _e('e.g. John received a prestigious award at an event.', TMMP_TXTDM) ?>" />
        </div>

        <div class="dmb_clearfix"></div>

        <div class="dmb_tip">
            <span class="dashicons dashicons-yes"></span> Additional information will show as a toggle box, below your
            member's biography. <a class="dmb_inline_tip dmb_tooltip_medium"
                data-tooltip="<?php _e('The content will show when your visitors click on the title.', TMMP_TXTDM) ?>">[?]</a>
        </div>

        <div class="dmb_clearfix"></div>

        <div class="dmb_section_title">
            <?php _e('Social links', TMMP_TXTDM) ?>
            <a class="dmb_inline_tip dmb_tooltip_large"
                data-tooltip="<?php _e('These links will appear below your members\' biography.', TMMP_TXTDM) ?>">[?]</a>
        </div>

        <div class="dmb_grid dmb_grid_33 dmb_grid_first">
            <div class="dmb_field_title">
                <?php _e('Link type', TMMP_TXTDM) ?>
            </div>
            <select class="dmb_scl_type_select dmb_scl_type1_of_member">
                <?php foreach ($social_links_options as $label => $value) { ?>
                <option value="<?php echo $value; ?>" <?php selected($member['_tmm_sc_type1'], $value); ?>>
                    <?php echo $label; ?></option>
                <?php } ?>
            </select>
        </div>

        <div class="dmb_grid dmb_grid_33 ">
            <div class="dmb_field_title">
                <?php _e('Title attribute', TMMP_TXTDM) ?>
                <a class="dmb_inline_tip dmb_tooltip_large"
                    data-tooltip="<?php _e('Optional. This is the HTML <a> tag\'s title attribute.', TMMP_TXTDM) ?>">[?]</a>
            </div>
            <input class="dmb_field dmb_scl_title1_of_member" type="text"
                value="<?php echo $member['_tmm_sc_title1']; ?>"
                placeholder="<?php _e('e.g. Faceook page', TMMP_TXTDM) ?>" />
        </div>

        <div class="dmb_grid dmb_grid_33 dmb_grid_last">
            <div class="dmb_field_title">
                <?php _e('Link URL', TMMP_TXTDM) ?>
            </div>
            <input class="dmb_field dmb_scl_url1_of_member" type="text" value="<?php echo $member['_tmm_sc_url1']; ?>"
                placeholder="<?php _e('e.g. http://fb.com/member-profile', TMMP_TXTDM) ?>" />
        </div>

        <div class="dmb_clearfix" style="margin-bottom:6px"></div>

        <div class="dmb_grid dmb_grid_33 dmb_grid_first">
            <select class="dmb_scl_type_select dmb_scl_type2_of_member">
                <?php foreach ($social_links_options as $label => $value) { ?>
                <option value="<?php echo $value; ?>" <?php selected($member['_tmm_sc_type2'], $value); ?>>
                    <?php echo $label; ?></option>
                <?php } ?>
            </select>
        </div>

        <div class="dmb_grid dmb_grid_33 ">
            <input class="dmb_field dmb_scl_title2_of_member" type="text"
                value="<?php echo $member['_tmm_sc_title2']; ?>"
                placeholder="<?php _e('e.g. Twitter page', TMMP_TXTDM) ?>" />
        </div>

        <div class="dmb_grid dmb_grid_33 dmb_grid_last">
            <input class="dmb_field dmb_scl_url2_of_member" type="text" value="<?php echo $member['_tmm_sc_url2']; ?>"
                placeholder="<?php _e('e.g. http://tw.com/member-profile', TMMP_TXTDM) ?>" />
        </div>

        <div class="dmb_clearfix" style="margin-bottom:6px"></div>

        <div class="dmb_grid dmb_grid_33 dmb_grid_first dmb_grid_first">
            <select class="dmb_scl_type_select dmb_scl_type3_of_member">
                <?php foreach ($social_links_options as $label => $value) { ?>
                <option value="<?php echo $value; ?>" <?php selected($member['_tmm_sc_type3'], $value); ?>>
                    <?php echo $label; ?></option>
                <?php } ?>
            </select>
        </div>

        <div class="dmb_grid dmb_grid_33 ">
            <input class="dmb_field dmb_scl_title3_of_member" type="text"
                value="<?php echo $member['_tmm_sc_title3']; ?>"
                placeholder="<?php _e('e.g. Google+ page', TMMP_TXTDM) ?>" />
        </div>

        <div class="dmb_grid dmb_grid_33 dmb_grid_last">
            <input class="dmb_field dmb_scl_url3_of_member" type="text" value="<?php echo $member['_tmm_sc_url3']; ?>"
                placeholder="<?php _e('e.g. http://gp.com/member-profile', TMMP_TXTDM) ?>" />
        </div>

        <div class="dmb_clearfix" style="margin-bottom:6px"></div>

        <div class="dmb_grid dmb_grid_33 dmb_grid_first dmb_grid_first">
            <select class="dmb_scl_type_select dmb_scl_type4_of_member">
                <?php foreach ($social_links_options as $label => $value) { ?>
                <option value="<?php echo $value; ?>" <?php selected($member['_tmm_sc_type4'], $value); ?>>
                    <?php echo $label; ?></option>
                <?php } ?>
            </select>
        </div>

        <div class="dmb_grid dmb_grid_33">
            <input class="dmb_field dmb_scl_title4_of_member" type="text"
                value="<?php echo $member['_tmm_sc_title4']; ?>"
                placeholder="<?php _e('e.g. Google+ page', TMMP_TXTDM) ?>" />
        </div>

        <div class="dmb_grid dmb_grid_33 dmb_grid_last">
            <input class="dmb_field dmb_scl_url4_of_member" type="text" value="<?php echo $member['_tmm_sc_url4']; ?>"
                placeholder="<?php _e('e.g. http://gp.com/member-profile', TMMP_TXTDM) ?>" />
        </div>

        <div class="dmb_clearfix" style="margin-bottom:6px"></div>

        <div class="dmb_grid dmb_grid_33 dmb_grid_first dmb_grid_first">
            <select class="dmb_scl_type_select dmb_scl_type5_of_member">
                <?php foreach ($social_links_options as $label => $value) { ?>
                <option value="<?php echo $value; ?>" <?php selected($member['_tmm_sc_type5'], $value); ?>>
                    <?php echo $label; ?></option>
                <?php } ?>
            </select>
        </div>

        <div class="dmb_grid dmb_grid_33 ">
            <input class="dmb_field dmb_scl_title5_of_member" type="text"
                value="<?php echo $member['_tmm_sc_title5']; ?>"
                placeholder="<?php _e('e.g. Google+ page', TMMP_TXTDM) ?>" />
        </div>

        <div class="dmb_grid dmb_grid_33 dmb_grid_last">
            <input class="dmb_field dmb_scl_url5_of_member" type="text" value="<?php echo $member['_tmm_sc_url5']; ?>"
                placeholder="<?php _e('e.g. http://gp.com/member-profile', TMMP_TXTDM) ?>" />
        </div>

        <div class="dmb_clearfix"></div>

        <div class="dmb_tip">
            <span class="dashicons dashicons-yes"></span> Links with the <strong>email</strong> type open your visitors'
            default mail client. <a class="dmb_inline_tip dmb_tooltip_large"
                data-tooltip="<?php _e('Your member\'s email address must be entered in the Link URL field. Title attribute can be left blank.', TMMP_TXTDM) ?>">[?]</a>
            <br /><span class="dashicons dashicons-yes"></span> Links with the <strong>phone</strong> type open your
            visitors' default phone app. <a class="dmb_inline_tip dmb_tooltip_large"
                data-tooltip="<?php _e('Your member\'s phone number must be entered in the Link URL field (e.g. tel:+11234567890). Title attribute can be left blank.', TMMP_TXTDM) ?>">[?]</a>
        </div>

        <div class="dmb_clearfix"></div>

        <div class="dmb_section_title">
            <?php _e('Photos', TMMP_TXTDM) ?>
        </div>

        <div class="dmb_grid dmb_grid_33 dmb_grid_first">

            <div class="dmb_field_title">
                <?php _e('Primary photo', TMMP_TXTDM) ?>
                <a class="dmb_inline_tip dmb_tooltip_large"
                    data-tooltip="<?php _e('We recommend square images (e.g. 250x250px).', TMMP_TXTDM) ?>">[?]</a>
            </div>

            <div>
                <div class="dmb_field_title dmb_img_data_url dmb_photo_of_member"
                    data-img="<?php echo $member['_tmm_photo']; ?>"></div>
                <div class="dmb_upload_img_btn dmb_button dmb_button_large dmb_button_blue">
                    <?php _e('Upload photo', TMMP_TXTDM) ?>
                </div>
            </div>

        </div>

        <div class="dmb_grid dmb_grid_33 dmb_grid_last">

            <div class="dmb_field_title">
                <span style="color:#8ea93d;">[PRO]</span>
                <?php _e('Secondary photo', TMMP_TXTDM) ?>
                <a class="dmb_inline_tip dmb_tooltip_medium"
                    data-tooltip="<?php _e('This photo will replace the primary photo when your visitors hover over it.', TMMP_TXTDM) ?>">[?]</a>
            </div>

            <div>
                <div class="dmb_field_title dmb_img_data_url dmb_hover_photo_of_member"
                    data-img="<?php echo $member['_tmm_photo2']; ?>"></div>
                <div class="dmb_upload_img_btn dmb_button dmb_button_large dmb_button_blue">
                    <?php _e('Upload photo', TMMP_TXTDM) ?>
                </div>
            </div>

        </div>

        <div class="dmb_clearfix"></div>

        <div class="dmb_grid dmb_grid_100 dmb_grid_first dmb_grid_last" style="margin-top:7px;">
            <div class="dmb_field_title">
                <?php _e('Photo link', TMMP_TXTDM) ?>
                <a class="dmb_inline_tip dmb_tooltip_large"
                    data-tooltip="<?php _e('Your visitors will be redirected to this link if they click the member\'s photo.', TMMP_TXTDM) ?>">[?]</a>
            </div>
            <input class="dmb_field dmb_photo_url_of_member" type="text"
                value="<?php echo $member['_tmm_photo_url']; ?>"
                placeholder="<?php _e('e.g. http://your-site.com/full-member-page/', TMMP_TXTDM) ?>" />
        </div>

        <div class="dmb_clearfix"></div>

        <div class="dmb_section_title">
            <?php _e('Styling', TMMP_TXTDM) ?>
        </div>

        <!-- Main color -->
        <div class="dmb_color_box dmb_grid dmb_grid_100 dmb_grid_first dmb_grid_last">
            <div class="dmb_field_title">
                <?php _e('Main color', TMMP_TXTDM) ?>
            </div>
            <input class="dmb_color_picker dmb_field dmb_color_of_member" name="team_color" type="text"
                value="<?php echo $member['_tmm_color']; ?>" />
        </div>

        <div class="dmb_clearfix"></div>

        <!-- END inner -->
    </div>

    <!-- END row -->
</div>

<?php
		}
	} ?>

<!-- START empty member -->
<div class="dmb_main dmb_empty_row" style="display:none;">

    <textarea class="dmb_data_dump" name="tmm_data_dumps[]"></textarea>

    <!-- member handle bar -->
    <div class="dmb_handle">
        <a class="dmb_button dmb_button_large dmb_button_compact dmb_move_row_up" href="#" title="Move up"><span
                class="dashicons dashicons-arrow-up-alt2"></span></a>
        <a class="dmb_button dmb_button_large dmb_button_compact dmb_move_row_down" href="#" title="Move down"><span
                class="dashicons dashicons-arrow-down-alt2"></span></a>
        <div class="dmb_handle_title"></div>
        <a class="dmb_button dmb_button_large dmb_button_compact dmb_remove_row_btn" href="#" title="Remove"><span
                class="dashicons dashicons-trash"></span></a>
        <a class="dmb_button dmb_button_large dmb_clone_row" href="#" title="Clone"><span
                class="dashicons dashicons-admin-page"></span><?php _e('Clone', TMMP_TXTDM); ?></a>
        <a class="dmb_button dmb_button_large dmb_export_row" href="#" title="Export"><span
                class="dashicons dashicons-upload"></span><?php _e('Export', TMMP_TXTDM); ?></a>
        <div class="dmb_clearfix"></div>
    </div>

    <!-- START inner -->
    <div class="dmb_inner">

        <div class="dmb_section_title">
            <?php _e('Member details', TMMP_TXTDM) ?>
        </div>

        <div class="dmb_grid dmb_grid_25 dmb_grid_first">
            <div class="dmb_field_title">
                <?php _e('First name', TMMP_TXTDM) ?>
            </div>
            <input class="dmb_field dmb_highlight_field dmb_firstname_of_member" type="text" value=""
                placeholder="<?php _e('e.g. John', TMMP_TXTDM) ?>" />
        </div>

        <div class="dmb_grid dmb_grid_25 ">
            <div class="dmb_field_title">
                <?php _e('Lastname', TMMP_TXTDM) ?>
            </div>
            <input class="dmb_field dmb_lastname_of_member" type="text" value=""
                placeholder="<?php _e('e.g. Doe', TMMP_TXTDM) ?>" />
        </div>

        <div class="dmb_grid dmb_grid_25">
            <div class="dmb_field_title">
                <?php _e('Job/role', TMMP_TXTDM) ?>
            </div>
            <input class="dmb_field dmb_job_of_member" type="text" value=""
                placeholder="<?php _e('e.g. Project manager', TMMP_TXTDM) ?>" />
        </div>

        <div class="dmb_grid dmb_grid_25 dmb_grid_last">
            <div class="dmb_field_title">
                <span style="color:#8ea93d;">[PRO]</span>
                <?php _e('Hide', TMMP_TXTDM) ?>
                <a class="dmb_inline_tip dmb_tooltip_large"
                    data-tooltip="<?php _e('Checking this box will hide the member from the team.', TMMP_TXTDM) ?>">[?]</a>
            </div>
            <div style="position:relative; top:8px;">
                <input class="dmb_field dmb_hide_of_member" value='1' type="checkbox" /> Check to hide member
            </div>

        </div>

        <div class="dmb_grid dmb_grid_100 dmb_grid_first dmb_grid_last">

            <?php if (!class_exists('acf')) { ?>

            <div class="dmb_field_title">
                <?php _e('Description/biography', TMMP_TXTDM) ?>
                <a class="dmb_inline_tip dmb_tooltip_large"
                    data-tooltip="<?php _e('Edit your member\'s biography by clicking the button below. Once updated, it will show up here.', TMMP_TXTDM) ?>">[?]</a>
            </div>

            <div class="dmb_field dmb_description_of_member"></div>

            <?php } else { ?>

            <div class="dmb_field_title">
                <?php _e('Description/biography', TMMP_TXTDM) ?>
            </div>

            <div class="dmb_field dmb_description_of_member_fb" style="display:none !important;"></div>
            <textarea id="acf-fallback-bio"></textarea>

            <?php } ?>

            <div class="dmb_clearfix"></div>

            <?php if (!class_exists('acf')) { ?>
            <div class="dmb_edit_description_of_member dmb_button dmb_button_large dmb_button_blue">
                <?php _e('Edit biography', TMMP_TXTDM) ?>
            </div>
            <?php } ?>

        </div>

        <div class="dmb_clearfix"></div>

        <div class="dmb_section_title">
            <?php _e('Additional information', TMMP_TXTDM) ?>
        </div>

        <div class="dmb_grid dmb_grid_20 dmb_grid_first">
            <div class="dmb_field_title">
                <span style="color:#8ea93d;">[PRO]</span>
                <?php _e('Button text', TMMP_TXTDM) ?>
            </div>
            <input class="dmb_field dmb_comp_title_of_member" type="text" value=""
                placeholder="<?php _e('e.g. Read more', TMMP_TXTDM) ?>" />
        </div>

        <div class="dmb_grid dmb_grid_80 dmb_grid_last">
            <div class="dmb_field_title">
                <span style="color:#8ea93d;">[PRO]</span>
                <?php _e('Revealed content', TMMP_TXTDM) ?>
            </div>
            <input class="dmb_field dmb_comp_text_of_member" type="text" value=""
                placeholder="<?php _e('e.g. John received a prestigious award at an event.', TMMP_TXTDM) ?>" />
        </div>

        <div class="dmb_clearfix"></div>

        <div class="dmb_tip">
            <span class="dashicons dashicons-yes"></span> Additional information will show as a toggle box, below your
            member's biography. <a class="dmb_inline_tip dmb_tooltip_medium"
                data-tooltip="<?php _e('The content will show when your visitors click on the title.', TMMP_TXTDM) ?>">[?]</a>
        </div>

        <div class="dmb_clearfix"></div>

        <div class="dmb_section_title">
            <?php _e('Social links', TMMP_TXTDM) ?>
            <a class="dmb_inline_tip dmb_tooltip_large"
                data-tooltip="<?php _e('These links will appear below your members\' biography.', TMMP_TXTDM) ?>">[?]</a>
        </div>

        <div class="dmb_clearfix"></div>

        <div class="dmb_grid dmb_grid_33 dmb_grid_first">
            <div class="dmb_field_title">
                <?php _e('Link type', TMMP_TXTDM) ?>
            </div>

            <select class="dmb_scl_type_select dmb_scl_type1_of_member">
                <?php foreach ($social_links_options as $label => $value) { ?>
                <option value="<?php echo $value; ?>"><?php echo $label; ?></option>
                <?php } ?>
            </select>
        </div>

        <div class="dmb_grid dmb_grid_33">
            <div class="dmb_field_title">
                <?php _e('Title attribute', TMMP_TXTDM) ?>
                <a class="dmb_inline_tip dmb_tooltip_large"
                    data-tooltip="<?php _e('Optional. This is the HTML <a> tag\'s title attribute.', TMMP_TXTDM) ?>">[?]</a>
            </div>
            <input class="dmb_field dmb_scl_title1_of_member" type="text" value=""
                placeholder="<?php _e('e.g. Facebook page', TMMP_TXTDM) ?>" />
        </div>

        <div class="dmb_grid dmb_grid_33 dmb_grid_last">
            <div class="dmb_field_title">
                <?php _e('Link URL', TMMP_TXTDM) ?>
            </div>
            <input class="dmb_field dmb_scl_url1_of_member" type="text" value=""
                placeholder="<?php _e('e.g. http://fb.com/member-profile', TMMP_TXTDM) ?>" />
        </div>

        <div class="dmb_clearfix" style="margin-bottom:6px"></div>

        <div class="dmb_grid dmb_grid_33 dmb_grid_first">
            <select class="dmb_scl_type_select dmb_scl_type2_of_member">
                <?php foreach ($social_links_options as $label => $value) { ?>
                <option value="<?php echo $value; ?>"><?php echo $label; ?></option>
                <?php } ?>
            </select>
        </div>

        <div class="dmb_grid dmb_grid_33">
            <input class="dmb_field dmb_scl_title2_of_member" type="text" value=""
                placeholder="<?php _e('e.g. Twitter page', TMMP_TXTDM) ?>" />
        </div>

        <div class="dmb_grid dmb_grid_33 dmb_grid_last">
            <input class="dmb_field dmb_scl_url2_of_member" type="text" value=""
                placeholder="<?php _e('e.g. http://tw.com/member-profile', TMMP_TXTDM) ?>" />
        </div>

        <div class="dmb_clearfix" style="margin-bottom:6px"></div>

        <div class="dmb_grid dmb_grid_33 dmb_grid_first">
            <select class="dmb_scl_type_select dmb_scl_type3_of_member">
                <?php foreach ($social_links_options as $label => $value) { ?>
                <option value="<?php echo $value; ?>"><?php echo $label; ?></option>
                <?php } ?>
            </select>
        </div>

        <div class="dmb_grid dmb_grid_33">
            <input class="dmb_field dmb_scl_title3_of_member" type="text" value=""
                placeholder="<?php _e('e.g. Google+ page', TMMP_TXTDM) ?>" />
        </div>

        <div class="dmb_grid dmb_grid_33 dmb_grid_last">
            <input class="dmb_field dmb_scl_url3_of_member" type="text" value=""
                placeholder="<?php _e('e.g. http://gp.com/member-profile', TMMP_TXTDM) ?>" />
        </div>

        <div class="dmb_clearfix" style="margin-bottom:6px"></div>

        <div class="dmb_grid dmb_grid_33 dmb_grid_first">
            <select class="dmb_scl_type_select dmb_scl_type4_of_member">
                <?php foreach ($social_links_options as $label => $value) { ?>
                <option value="<?php echo $value; ?>"><?php echo $label; ?></option>
                <?php } ?>
            </select>
        </div>

        <div class="dmb_grid dmb_grid_33">
            <input class="dmb_field dmb_scl_title4_of_member" type="text" value=""
                placeholder="<?php _e('e.g. Google+ page', TMMP_TXTDM) ?>" />
        </div>

        <div class="dmb_grid dmb_grid_33 dmb_grid_last">
            <input class="dmb_field dmb_scl_url4_of_member" type="text" value=""
                placeholder="<?php _e('e.g. http://gp.com/member-profile', TMMP_TXTDM) ?>" />
        </div>

        <div class="dmb_clearfix" style="margin-bottom:6px"></div>

        <div class="dmb_grid dmb_grid_33 dmb_grid_first">
            <select class="dmb_scl_type_select dmb_scl_type5_of_member">
                <?php foreach ($social_links_options as $label => $value) { ?>
                <option value="<?php echo $value; ?>"><?php echo $label; ?></option>
                <?php } ?>
            </select>
        </div>

        <div class="dmb_grid dmb_grid_33">
            <input class="dmb_field dmb_scl_title5_of_member" type="text" value=""
                placeholder="<?php _e('e.g. Google+ page', TMMP_TXTDM) ?>" />
        </div>

        <div class="dmb_grid dmb_grid_33 dmb_grid_last">
            <input class="dmb_field dmb_scl_url5_of_member" type="text" value=""
                placeholder="<?php _e('e.g. http://gp.com/member-profile', TMMP_TXTDM) ?>" />
        </div>

        <div class="dmb_clearfix"></div>

        <div class="dmb_tip">
            <span class="dashicons dashicons-yes"></span> Links with the email type open your visitors' mail client. <a
                class="dmb_inline_tip dmb_tooltip_large"
                data-tooltip="<?php _e('Your member\'s email address must be entered in the Link URL field. Title attribute can be left blank.', TMMP_TXTDM) ?>">[?]</a>
        </div>

        <div class="dmb_clearfix"></div>

        <div class="dmb_section_title">
            <?php _e('Photos', TMMP_TXTDM) ?>
        </div>

        <div class="dmb_grid dmb_grid_33 dmb_grid_first">

            <div class="dmb_field_title">
                <?php _e('Primary photo', TMMP_TXTDM) ?>
                <a class="dmb_inline_tip dmb_tooltip_large"
                    data-tooltip="<?php _e('We recommend square images (e.g. 250x250px).', TMMP_TXTDM) ?>">[?]</a>
            </div>

            <div>
                <div class="dmb_field_title dmb_img_data_url dmb_photo_of_member" data-img=""></div>
                <div class="dmb_upload_img_btn dmb_button dmb_button_large dmb_button_blue">
                    <?php _e('Upload photo', TMMP_TXTDM) ?>
                </div>
            </div>

        </div>

        <div class="dmb_grid dmb_grid_33 dmb_grid_last">

            <div class="dmb_field_title">
                <span style="color:#8ea93d;">[PRO]</span>
                <?php _e('Secondary photo', TMMP_TXTDM) ?>
                <a class="dmb_inline_tip dmb_tooltip_medium"
                    data-tooltip="<?php _e('This photo will replace the primary photo when your visitors hover over it.', TMMP_TXTDM) ?>">[?]</a>
            </div>

            <div>
                <div class="dmb_field_title dmb_img_data_url dmb_hover_photo_of_member" data-img=""></div>
                <div class="dmb_upload_img_btn dmb_button dmb_button_large dmb_button_blue">
                    <?php _e('Upload photo', TMMP_TXTDM) ?>
                </div>
            </div>

        </div>

        <div class="dmb_clearfix"></div>

        <div class="dmb_grid dmb_grid_100 dmb_grid_first dmb_grid_last">
            <div class="dmb_field_title">
                <?php _e('Photo link', TMMP_TXTDM) ?>
                <a class="dmb_inline_tip dmb_tooltip_large"
                    data-tooltip="<?php _e('Your visitors will be redirected to this link if they click the member\'s photo.', TMMP_TXTDM) ?>">[?]</a>
            </div>
            <input class="dmb_field dmb_photo_url_of_member" type="text" value=""
                placeholder="<?php _e('e.g. http://your-site.com/full-member-page/', TMMP_TXTDM) ?>" />
        </div>

        <div class="dmb_clearfix"></div>

        <div class="dmb_section_title">
            <?php _e('Styling', TMMP_TXTDM) ?>
        </div>

        <!-- Main color -->
        <div class="dmb_color_box dmb_grid dmb_grid_100 dmb_grid_first dmb_grid_last">
            <div class="dmb_field_title">
                <?php _e('Main color', TMMP_TXTDM) ?>
            </div>
            <input class="dmb_color_picker_ready dmb_field dmb_color_of_member" name="team_color" type="text"
                value="#444444" />
        </div>

        <div class="dmb_clearfix"></div>

        <!-- END inner -->
    </div>

    <!-- END empty row -->
</div>

<div class="dmb_clearfix"></div>

<div class="dmb_no_row_notice">
    <?php /* translators: Leave HTML tags */ _e('Click the <strong>Add a member</strong> button below to get started.', TMMP_TXTDM) ?>
</div>

<!-- Add row button -->
<a class="dmb_button dmb_button_huge dmb_button_green dmb_add_row" href="#">
    <?php _e('Add a member', TMMP_TXTDM) ?>
</a>

<?php }