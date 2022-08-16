<?php
$wp_customize->add_section( 'lds_visual_customizer_content_list', array(
    'title'     => __( 'Content List', 'lds_skins' ),
    'priority'  => 35,
    'panel'     => 'lds_visual_customizer'
) );

$content_list_settings = apply_filters( 'lds_visual_customizer_content_list_settings', array(
    'lds_content_list_border_size' => array(
        'default'        => '',
        'type'           => 'option',
        'transport'      => 'refresh',
        'capability'     => 'edit_theme_options',
    ),
    'lds_content_list_border_radius' => array(
        'default'        => '',
        'type'           => 'option',
        'transport'      => 'refresh',
        'capability'     => 'edit_theme_options',
    ),
    'lds_content_list_spacing' => array(
        'default'        => '',
        'type'           => 'option',
        'transport'      => 'refresh',
        'capability'     => 'edit_theme_options',
    ),
    'lds_content_list_padding' => array(
        'default'        => '',
        'type'           => 'option',
        'transport'      => 'refresh',
        'capability'     => 'edit_theme_options',
    ),
    'lds_content_list_drop_shadow' => array(
        'default'        => '',
        'type'           => 'option',
        'transport'      => 'refresh',
        'capability'     => 'edit_theme_options',
    ),
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
    'lds_content_list_hover_effect' => array(
        'default'       =>  '',
        'type'          => 'option',
        'transport'     =>  'refresh',
        'capability'    =>  'edit_theme_options'
    )
) );

/**
 * Register the settings
 * @var [type]
 */
foreach( $content_list_settings as $slug => $options ) {
    $wp_customize->add_setting( $slug, $options );
}

$content_list_ranges = apply_filters( 'ldvc_content_list_ranges', array(
    'lds_content_list_border_radius' => array(
        'label'      => __( 'Content item border radius', 'lds_skins' ),
        'section'    => 'lds_visual_customizer_content_list',
        'settings'   => 'lds_content_list_border_radius',
        'min'        => 0,
        'max'        => 50,
        'step'       => 1,
        'default'    => 12,
    ),
    'lds_content_list_border_size' => array(
        'label'      => __( 'Content item border size', 'lds_skins' ),
        'section'    => 'lds_visual_customizer_content_list',
        'settings'   => 'lds_content_list_border_size',
        'min'        => 0,
        'max'        => 50,
        'step'       => 1,
        'default'    => 3,
    ),
    'lds_content_list_padding' => array(
        'label'      => __( 'Content item padding', 'lds_skins' ),
        'section'    => 'lds_visual_customizer_content_list',
        'settings'   => 'lds_content_list_padding',
        'min'        => 0,
        'max'        => 50,
        'step'       => 1,
        'default'    => 20
    ),
    'lds_content_list_spacing' => array(
        'label'      => __( 'Margin below content items', 'lds_skins' ),
        'section'    => 'lds_visual_customizer_content_list',
        'settings'   => 'lds_content_list_spacing',
        'min'        => 0,
        'max'        => 50,
        'step'       => 1,
        'default'    => 20,
    ),
) );

$content_list_settings = apply_filters( 'ldvc_content_list_settings', array(
    'lds_content_list_drop_shadow' => array(
        'label'      => __( 'Drop shadow', 'lds_skins' ),
        'section'    => 'lds_visual_customizer_content_list',
        'settings'   => 'lds_content_list_drop_shadow',
        'type'       => 'select',
        'choices'   =>  array(
            'none'		    =>	__( 'None', 'lds_skins' ),
            'light'		    =>	__( 'Light', 'lds_skins' ),
            'light-plus'    =>  __( 'Light +', 'lds_skins' ),
            'medium'	    =>	__( 'Medium', 'lds_skins' ),
            'medium-plus'	=>	__( 'Medium +', 'lds_skins' ),
            'heavy'	        =>	__( 'Heavy', 'lds_skins' ),
            'heavy-plus'	=>	__( 'Heavy +', 'lds_skins' ),
        ),
    ), /*
    'lds_content_list_hover_effect' => array(
        'label'      => __( 'Hover effect', 'lds_skins' ),
        'section'    => 'lds_visual_customizer_content_list',
        'settings'   => 'lds_content_list_drop_shadow',
        'type'       => 'select',
        'choices'   =>  array(
            'none'		    =>	__( 'None', 'lds_skins' ),
            'highlight'		=>	__( 'Highlight', 'lds_skins' ),
            'elevate'       =>  __( 'Elevate', 'lds_skins' ),
            'flip'	        =>	__( 'Flip', 'lds_skins' ),
            'reverse'	    =>	__( 'Reverse out', 'lds_skins' ),
        ),
    ), */
) );

foreach( $content_list_ranges as $slug => $control ) {
    $wp_customize->add_control( new WP_Customize_Range( $wp_customize, $slug, $control ) );
}

foreach( $content_list_settings as $slug => $options ) {

    $wp_customize->add_control( new WP_Customize_Control(
        $wp_customize,
        $slug,
        $options
    ) );

}
