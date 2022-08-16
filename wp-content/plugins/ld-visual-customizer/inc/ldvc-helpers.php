<?php

function ldvc_get_google_font_familes( $key = 'AIzaSyCFz4VraDn77L0PEPDI5PWLORiuDMWTW98' ) {

    $transient = get_transient( 'ldvc_font_families' );

    if( !empty($transient) ) {
        return $transient;
    }

    $handle = curl_init();

    $url = 'https://www.googleapis.com/webfonts/v1/webfonts?key=' . $key;

    // Set the url
    curl_setopt($handle, CURLOPT_URL, $url);
    // Set the result output to be a string.
    curl_setopt($handle, CURLOPT_RETURNTRANSFER, true);

    $output = json_decode(curl_exec($handle));

    curl_close($handle);

    set_transient( 'ldvc_font_families', $output, WEEK_IN_SECONDS );

    return $output;

}

function ldvc_get_google_font( $font_name = null ) {

    if( !$font_name ) {
        return false;
    }

    $fonts = ldvc_get_google_font_familes();

    if( !$fonts ) {
        return false;
    }

    foreach( $fonts->items as $font ) {
        if( $font->family == $font_name ) {
            return $font;
        }
    }

    return false;

}

function ldvc_get_content_icon( $post_id = null ) {

    if( $post_id == null ) {
        $post_id = get_the_ID();
    }

    $custom_icon = ( get_post_meta( $post_id, '_lds_course_icon', true ) ? get_post_meta( $post_id, '_lds_course_icon', true ) : get_post_meta( $post_id, '_lds_content_type', true ) );

    return ( $custom_icon ? $custom_icon : '' );

}

add_filter( 'learndash_wrapper_class', 'lds_theme_template_wrapper_classes' );
function lds_theme_template_wrapper_classes( $class ) {

    $ldvc_theme = get_option('lds_skin');

    if( $ldvc_theme && !empty($ldvc_theme) ) {
        $class .= ' lds-theme-' . $ldvc_theme;
    }

    $ldvc_template = get_option('lds_listing_style');

    if( $ldvc_template == 'grid-banner' ) {

        $columns = get_option('lds_grid_columns');

        $class .= ' lds-columns-' . ( $columns ? $columns : '2' );

    }

    if( $ldvc_template && !empty($ldvc_template) ) {
        $class .= ' lds-template-' . $ldvc_template;
    }

    return $class;

}
