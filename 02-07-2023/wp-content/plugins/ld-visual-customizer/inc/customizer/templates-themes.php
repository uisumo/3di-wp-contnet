<?php
$wp_customize->add_section( 'lds_styling_scheme', array(
    'title'     => __( 'Templates &amp; Themes', 'lds_skins' ),
    'priority'  => 35,
    'panel'     => 'lds_visual_customizer'
) );

/**
 * Settings for the themes & template settings
 * @var array
 */
$theme_settings = array(
    'lds_listing_style' => array(
        'default'        => 'default',
        'type'           => 'option',
        'transport'      => 'refresh',
        'capability'     => 'edit_theme_options',
    ),
    'lds_skin'  =>  array(
        'default'        => 'default',
        'type'           => 'option',
        'transport'      => 'refresh',
        'capability'     => 'edit_theme_options',
    ),
    'lds_grid_columns'  =>  array(
        'default'        => '2',
        'type'           => 'option',
        'transport'      => 'refresh',
        'capability'     => 'edit_theme_options',
    ),
);

/**
 * Register the settings
 * @var [type]
 */
foreach( $theme_settings as $slug => $options ) {
    $wp_customize->add_setting( $slug, $options );
}

$customize_controls = apply_filters( 'lds_capi_theme_ccontrols', array(
    'lds_listing_style' => array(
        'label'      => __( 'Template', 'lds_skins' ),
        'section'    => 'lds_styling_scheme',
        'settings'   => 'lds_listing_style',
        'type'       => 'select',
        'choices'   =>  array(
            'default'		=>	__( 'Default', 'lds_skins' ),
            'expanded'		=>	__( 'Expanded', 'lds_skins' ),
            'grid-banner'	=>	__( 'Grid', 'lds_skins' ),
            'stacked'       =>  __( 'Stacked', 'lds_skins' ),
        )
    ),
    'lds_grid_columns' => array(
        'label'      => __( 'Number of Columns', 'lds_skins' ),
        'section'    => 'lds_styling_scheme',
        'settings'   => 'lds_grid_columns',
        'type'       => 'select',
        'choices'   =>  array(
            '2'		=>	'2',
            '3'		=>	'3',
            '4'		=>	'4',
        )
    ),
    'lds_skin' => array(
        "label"      => __("Base Skin", "learndash-skins"),
        "section"    => "lds_styling_scheme",
        "settings"   => "lds_skin",
        'type'       => 'select',
        'choices'    => array(
            'default'   => __( 'Default', 'lds_skins' ),
            'modern'    => __( 'Modern', 'lds_skins' ),
            'sleek'     => __( 'Sleek', 'lds_skins' ),
            'minimal'   => __( 'Minimal', 'lds_skins' ),
            'rustic'    => __( 'Rustic', 'lds_skins' ),
            'playful'   => __( 'Playful', 'lds_skins' ),
            'sunny'     => __( 'Sunny', 'lds_skins' ),
        ),
    ),
) );

foreach( $customize_controls as $slug => $options ) {

    $wp_customize->add_control( new WP_Customize_Control(
        $wp_customize,
        $slug,
        $options
    ) );

}
