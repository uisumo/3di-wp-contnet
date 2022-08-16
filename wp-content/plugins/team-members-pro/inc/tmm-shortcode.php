<?php 

/* Handles team shortcodes. */
add_shortcode("tmm", "tmmp_sc");
function tmmp_sc($atts) {

  global $post;
  
  /* Gets table slug (post name). */
  $all_attr = shortcode_atts( array( "name" => '' ), $atts );
  $name = $all_attr['name'];
    
  /* Gets the team. */
  $args = array('post_type' => 'tmm', 'name' => $name);
  $custom_posts = get_posts($args);

  foreach($custom_posts as $post) : setup_postdata($post);

	  $members = get_post_meta( get_the_id(), '_tmm_head', true );
    $options = get_post_meta( get_the_id(), '_tmm_settings_head', true );
    $visible_members = array();

    $tmm_columns = get_post_meta( $post->ID, '_tmm_columns', true );
    $tmm_picture_shape = get_post_meta( $post->ID, '_tmm_picture_shape', true );
    $tmm_picture_border = get_post_meta( $post->ID, '_tmm_picture_border', true );
    $tmm_picture_position = get_post_meta( $post->ID, '_tmm_picture_position', true );
    $tmm_picture_filter = get_post_meta( $post->ID, '_tmm_picture_filter', true );
    $tmm_picture_tp_border_size = get_post_meta( $post->ID, '_tmm_tp_border_size', true );
    $tmm_picture_tp_border_size = ($tmm_picture_tp_border_size || $tmm_picture_tp_border_size == 0) ? $tmm_picture_tp_border_size : 6;
    $tmm_bio_alignment = get_post_meta( $post->ID, '_tmm_bio_alignment', true );

    /* Gets the PRO options. */
    (!empty($tmm_picture_position)) ? $picture_pos = 'tmm-'.$tmm_picture_position.'-pic' :  $picture_pos = '';
 
    /* Checks if member links open in new window. */
    $tmm_piclink_beh = get_post_meta( $post->ID, '_tmm_piclink_beh', true );
    ($tmm_piclink_beh == 'new' ? $tmm_plb = 'target="_blank"' : $tmm_plb = '');

    /* Checks if forcing original fonts. */
    $original_font = get_post_meta( $post->ID, '_tmm_original_font', true );
    if ($original_font) {
      if ($original_font == "no") { $ori_f = 'tmm_theme_f'; }
      else if ($original_font == "yes") { $ori_f = 'tmm_plugin_f'; }
    } else {
      $ori_f = 'tmm_plugin_f';
    }

    /* Checks comp text theme. */
    $tmm_comp_theme = get_post_meta( $post->ID, '_tmm_comp_theme', true );
    ($tmm_comp_theme == 'bright' ? $tmm_comp_theme = 'bright' : $tmm_comp_theme = 'dark');

    /* Checks equalizer. */
    $tmm_equalizer = get_post_meta( $post->ID, '_tmm_equalizer', true );
    ($tmm_equalizer == 'yes' ? $tmm_equalizer = 'tmm-equalizer' : $tmm_equalizer = '');

    $team_view = '';
    $team_view .= '<div class="tmm tmm_'.$name.' '.$picture_pos.'">';
      $team_view .= '<div class="tmm_'.$tmm_columns.'_columns tmm_wrap '.$ori_f.'">';

        $counter = 1;
        $cols = $tmm_columns;
        $picture_classes = '';

        /* Checks the PRO options */
        if ($tmm_picture_shape == 'square' || $tmm_picture_position == 'full') {
          $picture_classes .= 'tmm_squared-borders ';
        } else if ($tmm_picture_shape == 'circular') {
          $picture_classes .= 'tmm_circular-borders ';
        }

        if ($tmm_picture_border == 'no' || $tmm_picture_position == 'full') 
          $picture_classes .= 'tmm_no-borders ';

        if ($tmm_picture_filter == 'vintage')
          $picture_classes .= 'tmm_filter-vintage ';

        if ($tmm_picture_filter == 'blackandwhite')
          $picture_classes .= 'tmm_filter-bandw ';

        if ($tmm_picture_filter == 'saturated') 
          $picture_classes .= 'tmm_filter-saturated ';

        
        if (is_array($members) || is_object($members)) {

          foreach ($members as $key => $member) {
            if (empty($member['_tmm_hide'])) {
              array_push($visible_members, $member);
            } else if ($member['_tmm_hide'] == '0') {
              array_push($visible_members, $member);
            }
          }

        }

        foreach ($visible_members as $key => $member) {

          /* Creates Team container */
          if($key%2 == 0) {
              /* Checks if group of two (alignment purposes). */
              $team_view .= '<span class="tmm_two_containers_tablet"></span>';
          }
          if($key%$tmm_columns == 0) {
              /* Checks if first div of group and closes. */
              if($key > 0) $team_view .= '</div><span class="tmm_columns_containers_desktop"></span>';
              $team_view .= '<div class="tmm_container '.$tmm_equalizer.'">';
          }

          (empty($member['_tmm_color']) ? $member['_tmm_color'] = '#aaaaaa' : '');

          /* START member. */
          $team_view .= '<div class="tmm_member '.$ori_f.'" style="border-top:'.$member['_tmm_color'].' solid '. $tmm_picture_tp_border_size .'px;">';

            /* Displays member photo. */
            if (!empty($member['_tmm_photo_url']))
              $team_view .= '<a '.$tmm_plb.' href="'.$member['_tmm_photo_url'].'" title="'.$member['_tmm_firstname'].' '.$member['_tmm_lastname'].'">';

              if (!empty($member['_tmm_photo']))
                $team_view .= '<div class="'.$picture_classes.' tmm_photo tmm_pic_'.$name.'_'.$key.'" style="background: url('.$member['_tmm_photo'].'); margin-left: auto; margin-right:auto; background-size:cover !important;"></div>';

              /* Displays hover photo. */
              if (!empty($member['_tmm_photo2'])) {
                $team_view .= '<div style="width:0px !important; height:0px !important; background-image:url(\''.$member['_tmm_photo2'].'\');"></div>';
                $team_view .= '<style>.tmm_pic_'.$name.'_'.$key.':hover {background: url('.$member['_tmm_photo2'].') no-repeat !important;}</style>';
              }
                
            if (!empty($member['_tmm_photo_url']))
              $team_view .= '</a>';

            /* Creates text block. */
            $team_view .= '<div class="tmm_textblock">';

              /* Displays names. */
              $team_view .= '<div class="tmm_names">';
                if (!empty($member['_tmm_firstname']))
                  $team_view .= '<span class="tmm_fname">'.$member['_tmm_firstname'].'</span> ';
                if (!empty($member['_tmm_lastname']))
                  $team_view .= '<span class="tmm_lname">'.$member['_tmm_lastname'].'</span>';
              $team_view .= '</div>';

              /* Displays jobs. */
              if (!empty($member['_tmm_job']))
                $team_view .= '<div class="tmm_job">'.$member['_tmm_job'].'</div>';

              /* Displays bios. */
              if (!empty($member['_tmm_desc']))
                $team_view .= '<div class="tmm_desc" style="text-align:'.$tmm_bio_alignment.'">'.do_shortcode($member['_tmm_desc']).'</div>';

              /* Displays add. info box. */
              if (!empty($member['_tmm_comp_title'])) {
                
                $team_view .= '<div style="margin-top:10px; margin-bottom:15px; color:'.$member['_tmm_color'].'" class="tmm_more_info">';
                /* Displays add. info text. */
                if (!empty($member['_tmm_comp_text']))
                  $team_view .= '<div class="tmm_comp_text tmm_comp_text_'.$tmm_comp_theme. '">'.$member['_tmm_comp_text'].'</div>';

                /* Displays add. info title. */
                $team_view .= $member['_tmm_comp_title'];
                $team_view .= '</div>';

              }

              /* Creates social block. */
              $team_view .= '<div class="tmm_scblock">';

                /* Displays social links. */
                for ($i = 1; $i <= 5; $i++) {

                  if (!isset($member['_tmm_sc_title'.$i]))
                    $member['_tmm_sc_title'.$i] = '';

                  if (!isset($member['_tmm_sc_type'.$i]))
                    $member['_tmm_sc_type'.$i] = 'nada';

                  if ($member['_tmm_sc_type'.$i] != 'nada') {
                    if ($member['_tmm_sc_type'.$i] == 'email') {
                      $team_view .= '<a class="tmm_sociallink" href="mailto:'.(!empty($member['_tmm_sc_url'.$i]) ? $member['_tmm_sc_url'.$i]:'').'" title="'.$member['_tmm_sc_title'.$i].'"><img alt="'.$member['_tmm_sc_title'.$i].'" src="'.plugins_url('img/links/', __FILE__).$member['_tmm_sc_type'.$i].'.png"/></a>';
                    } else if ($member['_tmm_sc_type'.$i] == 'phone') {
                      $team_view .= '<a class="tmm_sociallink" href="tel:'.(!empty($member['_tmm_sc_url'.$i]) ? $member['_tmm_sc_url'.$i]:'').'" title="'.$member['_tmm_sc_title'.$i].'"><img alt="'.$member['_tmm_sc_title'.$i].'" src="'.plugins_url('img/links/', __FILE__).$member['_tmm_sc_type'.$i].'.png"/></a>';
                    } else {
                      $team_view .= '<a target="_blank" class="tmm_sociallink" href="'.(!empty($member['_tmm_sc_url'.$i]) ? $member['_tmm_sc_url'.$i]:'').'" title="'.$member['_tmm_sc_title'.$i].'"><img alt="'.$member['_tmm_sc_title'.$i].'" src="'.plugins_url('img/links/', __FILE__).$member['_tmm_sc_type'.$i].'.png"/></a>';
                    }
                  }    
                }

              $team_view .= '</div>'; // Closes social block.
            $team_view .= '</div>'; // Closes text block.
          $team_view .= '</div>'; // END member.

          $page_count = count( $visible_members );
          if ($key == $page_count - 1) $team_view .= '<div style="clear:both;"></div>';
        }


        $team_view .= '</div>'; // Closes container.
      $team_view .= '</div>'; // Closes wrap.
    $team_view .= '</div>'; // Closes tmm.

  endforeach; wp_reset_postdata();
  return $team_view;

}

?>