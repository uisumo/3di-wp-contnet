<?php

/* Enqueues admin scripts. */
add_action( 'admin_enqueue_scripts', 'add_admin_tmmp_style' );
function add_admin_tmmp_style() {

  /* Gets the post type. */
  global $post_type;

  if( 'tmm' == $post_type ) {

    /* CSS for metaboxes. */
    wp_enqueue_style( 'tmmp_dmb_styles', plugins_url('dmb/dmb.min.css', __FILE__));
    /* CSS for previews. */
    wp_enqueue_style( 'tmmp_styles', plugins_url('css/tmm_style.min.css', __FILE__));
    /* Others. */
    wp_enqueue_style( 'wp-color-picker' );

    /* JS for metaboxes. */
    wp_enqueue_script( 'tmmp_admin_js', plugins_url('dmb/dmb.min.js', __FILE__), array( 'jquery', 'thickbox', 'wp-color-picker' ));
    wp_enqueue_script( 'tmmp_front_js', plugins_url('js/tmm.min.js', __FILE__), array( 'jquery', 'thickbox', 'wp-color-picker' ));

    /* Localizes string for JS file. */
    wp_localize_script( 'tmmp_admin_js', 'objectL10n', array(
      'untitled' => __( 'Untitled', TMMP_TXTDM ),
      'noMemberNotice' => __( 'Add at least <strong>1</strong> member to preview the team.', TMMP_TXTDM ),
      'previewAccuracy' => __( 'This is only a preview, shortcodes used in the fields will not be rendered and results may vary depending on your container\'s width.', TMMP_TXTDM )
    ));
    wp_enqueue_style( 'thickbox' );
    
  }

}

?>