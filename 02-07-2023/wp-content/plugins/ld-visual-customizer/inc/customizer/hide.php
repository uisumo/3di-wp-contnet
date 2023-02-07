<?php

$wp_customize->add_section( 'lds_hide', array(
    'title'     => __( 'Hide Elements', 'lds_skins' ),
    'priority'  => 35,
    'panel'     => 'lds_visual_customizer'
) );


$hide_settings = apply_filters( 'lds_hide_settings', array(
    'lds_content_list_hide_item_counts' => array(
        'default'       =>  '',
        'type'          => 'option',
        'transport'     =>  'refresh',
        'capability'    =>  'edit_theme_options'
    ),
    'lds_content_list_hide_expand_all' => array(
        'default'       =>  '',
        'type'          => 'option',
        'transport'     =>  'refresh',
        'capability'    =>  'edit_theme_options'
    ),
    'lds_content_list_hide_lesson_expand' => array(
        'default'       =>  '',
        'type'          => 'option',
        'transport'     =>  'refresh',
        'capability'    =>  'edit_theme_options'
    ),
    'lds_hide_breadcrumbs'  => array(
        'default'        => '',
        'type'           => 'option',
        'transport'      => 'refresh',
        'capability'     => 'edit_theme_options',
    ),
    'lds_hide_last_activity'  => array(
        'default'        => '',
        'type'           => 'option',
        'transport'      => 'refresh',
        'capability'     => 'edit_theme_options',
    ),
    'lds_hide_progress_steps'  => array(
        'default'        => '',
        'type'           => 'option',
        'transport'      => 'refresh',
        'capability'     => 'edit_theme_options',
    ),
    'lds_hide_lesson_progress_stats'  => array(
        'default'        => '',
        'type'           => 'option',
        'transport'      => 'refresh',
        'capability'     => 'edit_theme_options',
    ),
) );

/**
 * Register the settings
 * @var [type]
 */
foreach( $hide_settings as $slug => $options ) {
    $wp_customize->add_setting( $slug, $options );
}



$hide_controls = apply_filters( 'ldvc_hide_controls', array(
    'lds_content_list_hide_item_counts' => array(
        'label'      => __( 'Hide topic/quiz counts', 'lds_skins' ),
        'section'    => 'lds_hide',
        'settings'   => 'lds_content_list_hide_item_counts',
        'type'       => 'checkbox',
    ),
    'lds_content_list_hide_lesson_expand' => array(
        'label'      => __( 'Hide lesson expand button', 'lds_skins' ),
        'section'    => 'lds_hide',
        'settings'   => 'lds_content_list_hide_lesson_expand',
        'type'       => 'checkbox',
    ),
    'lds_content_list_hide_expand_all' => array(
        'label'      => __( 'Hide expand all button', 'lds_skins' ),
        'section'    => 'lds_hide',
        'settings'   => 'lds_content_list_hide_expand_all',
        'type'       => 'checkbox',
    ),
    'lds_hide_breadcrumbs' => array(
        'label'      => __( 'Hide breadcrumbs', 'lds_skins' ),
        'section'    => 'lds_hide',
        'settings'   => 'lds_hide_breadcrumbs',
        'type'       => 'checkbox',
    ),
    'lds_hide_last_activity' => array(
        'label'      => __( 'Hide last activity', 'lds_skins' ),
        'section'    => 'lds_hide',
        'settings'   => 'lds_hide_last_activity',
        'type'       => 'checkbox',
    ),
    'lds_hide_progress_steps' => array(
        'label'      => __( 'Hide X/X steps complete', 'lds_skins' ),
        'section'    => 'lds_hide',
        'settings'   => 'lds_hide_progress_steps',
        'type'       => 'checkbox',
    ),
    'lds_hide_lesson_progress_stats' => array(
        'label'      => __( 'Hide lesson progress stats (% complete, X/X steps)', 'lds_skins' ),
        'section'    => 'lds_hide',
        'settings'   => 'lds_hide_lesson_progress_stats',
        'type'       => 'checkbox',
    ),
) );


foreach( $hide_controls as $slug => $options ) {

    $wp_customize->add_control( new WP_Customize_Control(
        $wp_customize,
        $slug,
        $options
    ) );

}
