<?php
/**
 * Admin Columns.
 *
 * Used to customize admin columns.
 *
 * @package LearnDash
 */

namespace LearnDash\Admin\Columns;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Removes specific admin columns.
 *
 * @param array $columns The columns to be rendered.
 *
 * @return array An array of posts listing columns.
 */
function remove_columns( $columns ) {
	unset( $columns['categories'] );
	unset( $columns['tags'] );
	unset( $columns['author'] );

	return $columns;
}
add_filter( 'manage_sfwd-courses_posts_columns', 'LearnDash\Admin\Columns\remove_columns' );
add_filter( 'manage_sfwd-lessons_posts_columns', 'LearnDash\Admin\Columns\remove_columns' );
add_filter( 'manage_sfwd-topic_posts_columns', 'LearnDash\Admin\Columns\remove_columns' );
add_filter( 'manage_sfwd-quiz_posts_columns', 'LearnDash\Admin\Columns\remove_columns' );
add_filter( 'manage_sfwd-question_posts_columns', 'LearnDash\Admin\Columns\remove_columns' );

/**
 * Disables the category filters for post listings.
 *
 * @param bool   $disable   Flag to disable/enable the filter.
 * @param string $post_type The post type slug.
 *
 * @return boolean Returns true to disable category filter otherwise false.
 */
function disable_categories_filters( $disable, $post_type ) {
	$post_types = array(
		'sfwd-courses',
		'sfwd-lessons',
		'sfwd-topic',
		'sfwd-quiz',
		'sfwd-question',
	);

	if ( in_array( $post_type, $post_types ) ) {
		return true;
	}

	return false;
}
//add_filter( 'disable_categories_dropdown', 'LearnDash\Admin\Columns\disable_categories_filters', 10, 2 );

/**
 * Disables the tags filters for post listings.
 *
 * @param array  $taxonomies The taxonomies.
 * @param string $post_type  The post type slug.
 *
 * @return array
 */
function disable_tags_filters( $taxonomies, $post_type ) {
	$post_types = array(
		'sfwd-courses',
		'sfwd-lessons',
		'sfwd-topic',
		'sfwd-quiz',
		'sfwd-question',
	);

	$key = array_search( 'post_tag', $taxonomies, true );
	if ( in_array( $post_type, $post_types, true ) && ( false !== $key ) ) {
		unset( $taxonomies[ $key ] );
	}

	return $taxonomies;
}
//add_filter( 'learndash-admin-taxonomy-filters-display', 'LearnDash\Admin\Columns\disable_tags_filters', 10, 2 );
