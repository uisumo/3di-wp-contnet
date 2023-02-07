<?php 

/* Registers the teams post type. */
add_action( 'init', 'register_tmmp_type' );
function register_tmmp_type() {
	
  /* Defines labels. */
  $labels = array(
		'name'               => __( 'Teams', TMMP_TXTDM ),
		'singular_name'      => __( 'Team', TMMP_TXTDM ),
		'menu_name'          => __( 'Teams', TMMP_TXTDM ),
		'name_admin_bar'     => __( 'Team', TMMP_TXTDM ),
		'add_new'            => __( 'Add New', TMMP_TXTDM ),
		'add_new_item'       => __( 'Add New Team', TMMP_TXTDM ),
		'new_item'           => __( 'New Team', TMMP_TXTDM ),
		'edit_item'          => __( 'Edit Team', TMMP_TXTDM ),
		'view_item'          => __( 'View Team', TMMP_TXTDM ),
		'all_items'          => __( 'All Teams', TMMP_TXTDM ),
		'search_items'       => __( 'Search Teams', TMMP_TXTDM ),
		'not_found'          => __( 'No Teams found.', TMMP_TXTDM ),
		'not_found_in_trash' => __( 'No Teams found in Trash.', TMMP_TXTDM )
	);

  /* Defines permissions. */
	$args = array(
		'labels'             => $labels,
		'public'             => false,
		'publicly_queryable' => false,
		'show_ui'            => true,
    'show_in_admin_bar'  => false,
		'capability_type'    => 'post',
		'has_archive'        => false,
		'hierarchical'       => false,
		'supports'           => array( 'title' ),
    'menu_icon'          => 'dashicons-plus'
	);

  /* Registers post type. */
	register_post_type( 'tmm', $args );  

}


/* Customizes teams update messages. */
add_filter( 'post_updated_messages', 'tmmp_updated_messages' );
function tmmp_updated_messages( $messages ) {
	
	$post             = get_post();
	$post_type        = get_post_type( $post );
  $post_type_object = get_post_type_object( $post_type );
  
  /* Defines update messages. */
	$messages['tmm'] = array(
		1  => __( 'Team updated.', TMMP_TXTDM ),
		4  => __( 'Team updated.', TMMP_TXTDM ),
		6  => __( 'Team published.', TMMP_TXTDM ),
		7  => __( 'Team saved.', TMMP_TXTDM ),
		10 => __( 'Team draft updated.', TMMP_TXTDM )
	);

	return $messages;

}

?>