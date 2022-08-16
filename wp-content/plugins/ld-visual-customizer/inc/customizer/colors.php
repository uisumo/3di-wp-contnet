<?php

$wp_customize->add_section( 'lds_visual_customizer_colors', array(
    'title'     => __( 'Global Colors', 'lds_skins' ),
    'priority'  => 35,
    'panel'     => 'lds_visual_customizer'
) );

$color_settings = apply_filters( 'lds_visual_customizer_color_settings', array(
    'lds_primary_color' => array(
        'default'             => '',
        'type'                => 'option',
        'transport'           => 'refresh',
        'capability'          => 'edit_theme_options',
        'sanitize_callback'   =>  'lds_update_theme_color'
    ),
    'lds_secondary_color' => array(
        'default'        => '',
        'type'           => 'option',
        'transport'      => 'refresh',
        'capability'     => 'edit_theme_options',
        'sanitize_callback'   =>  'lds_update_theme_color'
    ),
    'lds_alert_color' => array(
        'default'        => '',
        'type'           => 'option',
        'transport'      => 'refresh',
        'capability'     => 'edit_theme_options',
        'sanitize_callback'   =>  'lds_update_theme_color'
    ),
    'lds_tertiary_txt_color' => array(
        'default'        => '',
        'type'           => 'option',
        'transport'      => 'refresh',
        'capability'     => 'edit_theme_options',
    ),
    'lds_tertiary_bg_color' => array(
        'default'        => '',
        'type'           => 'option',
        'transport'      => 'refresh',
        'capability'     => 'edit_theme_options',
    ),
    'lds_content_item_bg' => array(
        'default'        => '',
        'type'           => 'option',
        'transport'      => 'refresh',
        'capability'     => 'edit_theme_options',
    ),
    'lds_expanded_content_bg' => array(
        'default'        => '',
        'type'           => 'option',
        'transport'      => 'refresh',
        'capability'     => 'edit_theme_options',
    ),
    'lds_content_item_border' => array(
        'default'        => '',
        'type'           => 'option',
        'transport'      => 'refresh',
        'capability'     => 'edit_theme_options',
    ),
    'lds_heading_txt' => array(
        'default'        => '',
        'type'           => 'option',
        'transport'      => 'refresh',
        'capability'     => 'edit_theme_options',
    ),
    'lds_heading_bg'    => array(
        'default'       =>  '',
        'type'          =>  'option',
        'transport'     =>  'refresh',
        'capability'     => 'edit_theme_options',
    ),
    'lds_sub_heading_txt' => array(
        'default'        => '',
        'type'           => 'option',
        'transport'      => 'refresh',
        'capability'     => 'edit_theme_options',
    ),
    'lds_sub_heading_bg'    => array(
        'default'       =>  '',
        'type'          =>  'option',
        'transport'     =>  'refresh',
        'capability'     => 'edit_theme_options',
    ),
    'lds_item_txt' => array(
        'default'        => '',
        'type'           => 'option',
        'transport'      => 'refresh',
        'capability'     => 'edit_theme_options',
    ),
    'lds_row_txt' => array(
        'default'        => '',
        'type'           => 'option',
        'transport'      => 'refresh',
        'capability'     => 'edit_theme_options',
    ),
    'lds_row_bg' => array(
        'default'        => '',
        'type'           => 'option',
        'transport'      => 'refresh',
        'capability'     => 'edit_theme_options',
    ),
    'lds_row_bg_alt' => array(
        'default'        => '',
        'type'           => 'option',
        'transport'      => 'refresh',
        'capability'     => 'edit_theme_options',
    ),
    'lds_sub_row_txt' => array(
        'default'        => '',
        'type'           => 'option',
        'transport'      => 'refresh',
        'capability'     => 'edit_theme_options',
    ),
    'lds_sub_row_bg' => array(
        'default'        => '',
        'type'           => 'option',
        'transport'      => 'refresh',
        'capability'     => 'edit_theme_options',
    ),
    'lds_sub_row_bg_alt' => array(
        'default'        => '',
        'type'           => 'option',
        'transport'      => 'refresh',
        'capability'     => 'edit_theme_options',
    ),
    'lds_progress' => array(
        'default'        => '',
        'type'           => 'option',
        'transport'      => 'refresh',
        'capability'     => 'edit_theme_options',
    ),
    'lds_checkbox_complete' => array(
        'default'        => '',
        'type'           => 'option',
        'transport'      => 'refresh',
        'capability'     => 'edit_theme_options',
    ),
    'lds_checkbox_incomplete' => array(
        'default'        => '',
        'type'           => 'option',
        'transport'      => 'refresh',
        'capability'     => 'edit_theme_options',
    ),
    'lds_arrow_complete' => array(
        'default'        => '',
        'type'           => 'option',
        'transport'      => 'refresh',
        'capability'     => 'edit_theme_options',
    ),
    'lds_arrow_incomplete' => array(
        'default'        => '',
        'type'           => 'option',
        'transport'      => 'refresh',
        'capability'     => 'edit_theme_options',
    ),
) );

foreach( $color_settings as $slug => $options ) {
    $wp_customize->add_setting( $slug, $options );
}

$color_controls = apply_filters( 'lds_visual_customizer_color_controls', array(
    'lds_primary_color' =>  array(
        'label'               =>  __( 'Primary theme color', 'lds_skins' ),
        'section'             =>  'lds_visual_customizer_colors',
        'settings'            =>  'lds_primary_color',
    ),
    'lds_secondary_color' =>  array(
        'label'     =>  __( 'Secondary theme color', 'lds_skins' ),
        'section'   =>  'lds_visual_customizer_colors',
        'settings'  =>  'lds_secondary_color'
    ),
    'lds_alert_color' =>  array(
        'label'     =>  __( 'Alert color', 'lds_skins' ),
        'section'   =>  'lds_visual_customizer_colors',
        'settings'  =>  'lds_alert_color'
    ),
    'lds_tertiary_txt_color' => array(
        'label'      => __( 'Tertiary text color', 'lds_skins' ),
        'description'   =>  __( 'Dark gray by default', 'lds_skins' ),
        'section'    => 'lds_visual_customizer_colors',
        'settings'   => 'lds_tertiary_txt_color',
    ),
    'lds_tertiary_bg_color' => array(
        'label'      => __( 'Tertiary background color', 'lds_skins' ),
        'description' => __( 'Light gray by default', 'lds_skins' ),
        'section'    => 'lds_visual_customizer_colors',
        'settings'   => 'lds_tertiary_bg_color',
    ),
    'lds_item_txt' => array(
        'label'      => __( 'Content item text', 'lds_skins' ),
        'section'    => 'lds_visual_customizer_colors',
        'settings'   => 'lds_item_txt',
    ),
    'lds_content_item_bg' => array(
        'label'      => __( 'Content item background', 'lds_skins' ),
        'section'    => 'lds_visual_customizer_colors',
        'settings'   => 'lds_content_item_bg',
    ),
    'lds_expanded_content_bg' => array(
        'label'      => __( 'Expanded content background', 'lds_skins' ),
        'section'    => 'lds_visual_customizer_colors',
        'settings'   => 'lds_expanded_content_bg',
    ),
    'lds_content_item_border' => array(
        'label'      => __( 'Content item border', 'lds_skins' ),
        'section'    => 'lds_visual_customizer_colors',
        'settings'   => 'lds_content_item_border',
    ),
    'lds_heading_txt' => array(
        'label'      => __( 'Content heading text', 'lds_skins' ),
        'section'    => 'lds_visual_customizer_colors',
        'settings'   => 'lds_heading_txt',
    ),
    'lds_heading_bg' => array(
        'label'      => __( 'Content heading background', 'lds_skins' ),
        'section'    => 'lds_visual_customizer_colors',
        'settings'   => 'lds_heading_bg',
    ),
    'lds_sub_heading_txt' => array(
        'label'      => __( 'Section heading text', 'lds_skins' ),
        'section'    => 'lds_visual_customizer_colors',
        'settings'   => 'lds_sub_heading_txt',
    ),
    'lds_sub_heading_bg' => array(
        'label'      => __( 'Section headings background', 'lds_skins' ),
        'section'    => 'lds_visual_customizer_colors',
        'settings'   => 'lds_sub_heading_bg',
    ),
) );

foreach( $color_controls as $slug => $control ) {
    $wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, $slug, $control ) );
}
