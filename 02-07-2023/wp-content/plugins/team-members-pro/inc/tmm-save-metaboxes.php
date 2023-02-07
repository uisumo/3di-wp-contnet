<?php

/* Saves metaboxes. */
add_action('save_post', 'dmb_tmmp_plan_meta_box_save');
function dmb_tmmp_plan_meta_box_save($post_id)
{
    if (
        !isset($_POST['dmb_tmmp_meta_box_nonce']) ||
        !wp_verify_nonce($_POST['dmb_tmmp_meta_box_nonce'], 'dmb_tmmp_meta_box_nonce')
    )
        return;

    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE)
        return;

    if (!current_user_can('edit_post', $post_id))
        return;

    /* Gets members. */
    $old_team = get_post_meta($post_id, '_tmm_head', true);

    /* Inits new team. */
    $new_team = [];

    /* Settings. */
    $old_team_settings = [];

    $old_team_settings['_tmm_columns'] = get_post_meta($post_id, '_tmm_columns', true);
    $old_team_settings['_tmm_bio_alignment'] = get_post_meta($post_id, '_tmm_bio_alignment', true);
    $old_team_settings['_tmm_piclink_beh'] = get_post_meta($post_id, '_tmm_piclink_beh', true);
    $old_team_settings['_tmm_original_font'] = get_post_meta($post_id, '_tmm_original_font', true);
    $old_team_settings['_tmm_display_order'] = get_post_meta($post_id, '_tmm_display_order', true);
    $old_team_settings['_tmm_picture_shape'] = get_post_meta($post_id, '_tmm_picture_shape', true);
    $old_team_settings['_tmm_picture_border'] = get_post_meta($post_id, '_tmm_picture_border', true);
    $old_team_settings['_tmm_picture_position'] = get_post_meta($post_id, '_tmm_picture_position', true);
    $old_team_settings['_tmm_picture_filter'] = get_post_meta($post_id, '_tmm_picture_filter', true);
    $old_team_settings['_tmm_tp_border_size'] = get_post_meta($post_id, '_tmm_tp_border_size', true);
    $old_team_settings['_tmm_comp_theme'] = get_post_meta($post_id, '_tmm_comp_theme', true);

    $old_team_settings['_tmm_equalizer'] = get_post_meta($post_id, '_tmm_equalizer', true);

    $count = count($_POST['tmm_data_dumps']) - 1;

    for ($i = 0; $i < $count; ++$i) {
        if ($_POST['tmm_data_dumps'][$i]) {
            /* Data travels using a single field to avoid max_input_vars issue. */
            $member_data = explode(']--[', $_POST['tmm_data_dumps'][$i]);

            $member_firstname = $member_data[0];
            $member_lastname = $member_data[1];
            $member_job = $member_data[2];
            $member_bio = $member_data[3];

            $member_scl_type1 = $member_data[4];
            $member_scl_title1 = $member_data[5];
            $member_scl_url1 = $member_data[6];

            $member_scl_type2 = $member_data[7];
            $member_scl_title2 = $member_data[8];
            $member_scl_url2 = $member_data[9];

            $member_scl_type3 = $member_data[10];
            $member_scl_title3 = $member_data[11];
            $member_scl_url3 = $member_data[12];

            $member_scl_type4 = $member_data[13];
            $member_scl_title4 = $member_data[14];
            $member_scl_url4 = $member_data[15];

            $member_scl_type5 = $member_data[16];
            $member_scl_title5 = $member_data[17];
            $member_scl_url5 = $member_data[18];

            $member_photo = $member_data[19];
            $member_photo_url = $member_data[20];

            $member_comp_title = $member_data[21];
            $member_comp_text = $member_data[22];
            $member_hover_photo = $member_data[23];
            $member_color = $member_data[24];

            $member_hide = $member_data[25];

            /* Saves the member if at least one of these fields are not empty. */
            if (
                '' != $member_firstname
                || '' != $member_lastname
                || '' != $member_job
                || '' != $member_bio
                || '' != $member_photo
            ) {
                /* Head. */
                (isset($member_firstname) && $member_firstname) ? $new_team[$i]['_tmm_firstname'] = wp_kses_post($member_firstname) : $new_team[$i]['_tmm_firstname'] = __('Untitled', TMMP_TXTDM);
                (isset($member_lastname) && $member_lastname) ? $new_team[$i]['_tmm_lastname'] = wp_kses_post($member_lastname) : $new_team[$i]['_tmm_lastname'] = '';
                (isset($member_job) && $member_job) ? $new_team[$i]['_tmm_job'] = wp_kses_post($member_job) : $new_team[$i]['_tmm_job'] = '';
                (isset($member_bio) && $member_bio) ? $new_team[$i]['_tmm_desc'] = balanceTags($member_bio) : $new_team[$i]['_tmm_desc'] = '';
                (isset($member_photo) && $member_photo) ? $new_team[$i]['_tmm_photo'] = stripslashes(strip_tags(sanitize_text_field($member_photo))) : $new_team[$i]['_tmm_photo'] = '';
                (isset($member_photo_url) && $member_photo_url) ? $new_team[$i]['_tmm_photo_url'] = stripslashes(strip_tags(sanitize_text_field($member_photo_url))) : $new_team[$i]['_tmm_photo_url'] = '';

                (isset($member_scl_type1) && $member_scl_type1) ? $new_team[$i]['_tmm_sc_type1'] = stripslashes(strip_tags(sanitize_text_field($member_scl_type1))) : $new_team[$i]['_tmm_sc_type1'] = '';
                (isset($member_scl_title1) && $member_scl_title1) ? $new_team[$i]['_tmm_sc_title1'] = stripslashes(strip_tags(sanitize_text_field($member_scl_title1))) : $new_team[$i]['_tmm_sc_title1'] = '';
                (isset($member_scl_url1) && $member_scl_url1) ? $new_team[$i]['_tmm_sc_url1'] = stripslashes(strip_tags(sanitize_text_field($member_scl_url1))) : $new_team[$i]['_tmm_sc_url1'] = '';

                (isset($member_scl_type2) && $member_scl_type2) ? $new_team[$i]['_tmm_sc_type2'] = stripslashes(strip_tags(sanitize_text_field($member_scl_type2))) : $new_team[$i]['_tmm_sc_type2'] = '';
                (isset($member_scl_title2) && $member_scl_title2) ? $new_team[$i]['_tmm_sc_title2'] = stripslashes(strip_tags(sanitize_text_field($member_scl_title2))) : $new_team[$i]['_tmm_sc_title2'] = '';
                (isset($member_scl_url2) && $member_scl_url2) ? $new_team[$i]['_tmm_sc_url2'] = stripslashes(strip_tags(sanitize_text_field($member_scl_url2))) : $new_team[$i]['_tmm_sc_url2'] = '';

                (isset($member_scl_type3) && $member_scl_type3) ? $new_team[$i]['_tmm_sc_type3'] = stripslashes(strip_tags(sanitize_text_field($member_scl_type3))) : $new_team[$i]['_tmm_sc_type3'] = '';
                (isset($member_scl_title3) && $member_scl_title3) ? $new_team[$i]['_tmm_sc_title3'] = stripslashes(strip_tags(sanitize_text_field($member_scl_title3))) : $new_team[$i]['_tmm_sc_title3'] = '';
                (isset($member_scl_url3) && $member_scl_url3) ? $new_team[$i]['_tmm_sc_url3'] = stripslashes(strip_tags(sanitize_text_field($member_scl_url3))) : $new_team[$i]['_tmm_sc_url3'] = '';

                (isset($member_scl_type4) && $member_scl_type4) ? $new_team[$i]['_tmm_sc_type4'] = stripslashes(strip_tags(sanitize_text_field($member_scl_type4))) : $new_team[$i]['_tmm_sc_type4'] = '';
                (isset($member_scl_title4) && $member_scl_title4) ? $new_team[$i]['_tmm_sc_title4'] = stripslashes(strip_tags(sanitize_text_field($member_scl_title4))) : $new_team[$i]['_tmm_sc_title4'] = '';
                (isset($member_scl_url4) && $member_scl_url4) ? $new_team[$i]['_tmm_sc_url4'] = stripslashes(strip_tags(sanitize_text_field($member_scl_url4))) : $new_team[$i]['_tmm_sc_url4'] = '';

                (isset($member_scl_type5) && $member_scl_type5) ? $new_team[$i]['_tmm_sc_type5'] = stripslashes(strip_tags(sanitize_text_field($member_scl_type5))) : $new_team[$i]['_tmm_sc_type5'] = '';
                (isset($member_scl_title5) && $member_scl_title5) ? $new_team[$i]['_tmm_sc_title5'] = stripslashes(strip_tags(sanitize_text_field($member_scl_title5))) : $new_team[$i]['_tmm_sc_title5'] = '';
                (isset($member_scl_url5) && $member_scl_url5) ? $new_team[$i]['_tmm_sc_url5'] = stripslashes(strip_tags(sanitize_text_field($member_scl_url5))) : $new_team[$i]['_tmm_sc_url5'] = '';

                (isset($member_hover_photo) && $member_hover_photo) ? $new_team[$i]['_tmm_photo2'] = stripslashes(strip_tags(sanitize_text_field($member_hover_photo))) : $new_team[$i]['_tmm_photo2'] = '';
                (isset($member_comp_title) && $member_comp_title) ? $new_team[$i]['_tmm_comp_title'] = wp_kses_post($member_comp_title) : $new_team[$i]['_tmm_comp_title'] = '';
                (isset($member_comp_text) && $member_comp_text) ? $new_team[$i]['_tmm_comp_text'] = wp_kses_post($member_comp_text) : $new_team[$i]['_tmm_comp_text'] = '';
                (isset($member_color) && $member_color) ? $new_team[$i]['_tmm_color'] = stripslashes(strip_tags(sanitize_hex_color($member_color))) : $new_team[$i]['_tmm_color'] = '';

                (isset($member_hide) && '1' == $member_hide) ? $new_team[$i]['_tmm_hide'] = stripslashes(strip_tags(sanitize_text_field($member_hide))) : $new_team[$i]['_tmm_hide'] = '0';
            }
        }
    }

    /* Settings. */
    (isset($_POST['team_columns']) && $_POST['team_columns']) ? $new_team_settings['_tmm_columns'] = stripslashes(strip_tags(sanitize_text_field($_POST['team_columns']))) : $new_team_settings['_tmm_columns'] = '';
    (isset($_POST['team_bio_align']) && $_POST['team_bio_align']) ? $new_team_settings['_tmm_bio_alignment'] = stripslashes(strip_tags(sanitize_text_field($_POST['team_bio_align']))) : $new_team_settings['_tmm_bio_alignment'] = '';
    (isset($_POST['team_force_font']) && $_POST['team_force_font']) ? $new_team_settings['_tmm_original_font'] = stripslashes(strip_tags(sanitize_text_field($_POST['team_force_font']))) : $new_team_settings['_tmm_original_font'] = '';
    (isset($_POST['team_display_order']) && sanitize_text_field(wp_unslash($_POST['team_display_order']))) ? $new_team_settings['_tmm_display_order'] = stripslashes(strip_tags(sanitize_text_field(wp_unslash($_POST['team_display_order'])))) : $new_team_settings['_tmm_display_order '] = '';
    (isset($_POST['team_piclink_beh']) && $_POST['team_piclink_beh']) ? $new_team_settings['_tmm_piclink_beh'] = stripslashes(strip_tags(sanitize_text_field($_POST['team_piclink_beh']))) : $new_team_settings['_tmm_piclink_beh'] = '';
    (isset($_POST['team_picture_shape']) && $_POST['team_picture_shape']) ? $new_team_settings['_tmm_picture_shape'] = stripslashes(strip_tags(sanitize_text_field($_POST['team_picture_shape']))) : $new_team_settings['_tmm_picture_shape'] = '';
    (isset($_POST['team_picture_border']) && $_POST['team_picture_border']) ? $new_team_settings['_tmm_picture_border'] = stripslashes(strip_tags(sanitize_text_field($_POST['team_picture_border']))) : $new_team_settings['_tmm_picture_border'] = '';
    (isset($_POST['team_picture_position']) && $_POST['team_picture_position']) ? $new_team_settings['_tmm_picture_position'] = stripslashes(strip_tags(sanitize_text_field($_POST['team_picture_position']))) : $new_team_settings['_tmm_picture_position'] = '';
    (isset($_POST['team_picture_filter']) && $_POST['team_picture_filter']) ? $new_team_settings['_tmm_picture_filter'] = stripslashes(strip_tags(sanitize_text_field($_POST['team_picture_filter']))) : $new_team_settings['_tmm_picture_filter'] = '';
    (isset($_POST['team_tp_border_size'])) ? $new_team_settings['_tmm_tp_border_size'] = stripslashes(strip_tags(sanitize_text_field($_POST['team_tp_border_size']))) : $new_team_settings['_tmm_tp_border_size'] = '';
    (isset($_POST['team_comp_theme']) && $_POST['team_comp_theme']) ? $new_team_settings['_tmm_comp_theme'] = stripslashes(strip_tags(sanitize_text_field($_POST['team_comp_theme']))) : $new_team_settings['_tmm_comp_theme'] = '';
    (isset($_POST['team_equalizer']) && $_POST['team_equalizer']) ? $new_team_settings['_tmm_equalizer'] = stripslashes(strip_tags(sanitize_text_field($_POST['team_equalizer']))) : $new_team_settings['_tmm_equalizer'] = '';

    /* Updates plans. */
    if (!empty($new_team) && $new_team != $old_team)
        update_post_meta($post_id, '_tmm_head', $new_team);
    elseif (empty($new_team) && $old_team)
        delete_post_meta($post_id, '_tmm_head', $old_team);

    if (!empty($new_team_settings['_tmm_columns']) && $new_team_settings['_tmm_columns'] != $old_team_settings['_tmm_columns'])
        update_post_meta($post_id, '_tmm_columns', $new_team_settings['_tmm_columns']);

    if (!empty($new_team_settings['_tmm_bio_alignment']) && $new_team_settings['_tmm_bio_alignment'] != $old_team_settings['_tmm_bio_alignment'])
        update_post_meta($post_id, '_tmm_bio_alignment', $new_team_settings['_tmm_bio_alignment']);

    if (!empty($new_team_settings['_tmm_original_font']) && $new_team_settings['_tmm_original_font'] != $old_team_settings['_tmm_original_font'])
        update_post_meta($post_id, '_tmm_original_font', $new_team_settings['_tmm_original_font']);

    if (!empty($new_team_settings['_tmm_display_order']) && $new_team_settings['_tmm_display_order'] != $old_team_settings['_tmm_display_order'])
        update_post_meta($post_id, '_tmm_display_order', $new_team_settings['_tmm_display_order']);

    if (!empty($new_team_settings['_tmm_piclink_beh']) && $new_team_settings['_tmm_piclink_beh'] != $old_team_settings['_tmm_piclink_beh'])
        update_post_meta($post_id, '_tmm_piclink_beh', $new_team_settings['_tmm_piclink_beh']);

    if (!empty($new_team_settings['_tmm_picture_shape']) && $new_team_settings['_tmm_picture_shape'] != $old_team_settings['_tmm_picture_shape'])
        update_post_meta($post_id, '_tmm_picture_shape', $new_team_settings['_tmm_picture_shape']);

    if (!empty($new_team_settings['_tmm_picture_border']) && $new_team_settings['_tmm_picture_border'] != $old_team_settings['_tmm_picture_border'])
        update_post_meta($post_id, '_tmm_picture_border', $new_team_settings['_tmm_picture_border']);

    if (!empty($new_team_settings['_tmm_picture_position']) && $new_team_settings['_tmm_picture_position'] != $old_team_settings['_tmm_picture_position'])
        update_post_meta($post_id, '_tmm_picture_position', $new_team_settings['_tmm_picture_position']);

    if (!empty($new_team_settings['_tmm_picture_filter']) && $new_team_settings['_tmm_picture_filter'] != $old_team_settings['_tmm_picture_filter'])
        update_post_meta($post_id, '_tmm_picture_filter', $new_team_settings['_tmm_picture_filter']);

    if (isset($new_team_settings['_tmm_tp_border_size']) && $new_team_settings['_tmm_tp_border_size'] != $old_team_settings['_tmm_tp_border_size'])
        update_post_meta($post_id, '_tmm_tp_border_size', $new_team_settings['_tmm_tp_border_size']);

    if (!empty($new_team_settings['_tmm_comp_theme']) && $new_team_settings['_tmm_comp_theme'] != $old_team_settings['_tmm_comp_theme'])
        update_post_meta($post_id, '_tmm_comp_theme', $new_team_settings['_tmm_comp_theme']);

    if (!empty($new_team_settings['_tmm_equalizer']) && $new_team_settings['_tmm_equalizer'] != $old_team_settings['_tmm_equalizer'])
        update_post_meta($post_id, '_tmm_equalizer', $new_team_settings['_tmm_equalizer']);
}
