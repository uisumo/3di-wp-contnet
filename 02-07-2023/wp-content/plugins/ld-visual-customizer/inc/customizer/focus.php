<?php
$wp_customize->add_section( 'lds_visual_customizer_focus_mode', array(
    'title'     => __( 'Focus Mode', 'lds_skins' ),
    'priority'  => 35,
    'panel'     => 'lds_visual_customizer'
) );

$focus_settings = apply_filters( 'lds_visual_customizer_focus_settings', array(
    'lds_focus_content_width' => array(
        'default'             => '',
        'type'                => 'option',
        'transport'           => 'refresh',
        'capability'          => 'edit_theme_options',
    ),
) );

$focus_setting_fields = apply_filters( 'ldvc_focus_mode_ranges', array(
    'lds_focus_content_width' => array(
        'label'      => __( 'Focus mode content max-width', 'lds_skins' ),
        'section'    => 'lds_visual_customizer_focus_mode',
        'settings'   => 'lds_focus_content_width',
        'type'       => 'select',
        'choices'   =>  array(
            'default'   =>	__( 'Default (960px)', 'lds_skins' ),
            '768px'	    =>	__( 'Narrow (768px)', 'lds_skins' ),
            '1180px'    =>  __( 'Medium (1180px)', 'lds_skins' ),
            '1600px'	=>	__( 'Wide (1600px)', 'lds_skins' ),
            'inherit'	=>	__( 'Full Width', 'lds_skins' ),
        ),
    )
) );

foreach( $focus_settings as $slug => $options ) {
    $wp_customize->add_setting( $slug, $options );
}


foreach( $focus_setting_fields as $slug => $options ) {

    $wp_customize->add_control( new WP_Customize_Control(
        $wp_customize,
        $slug,
        $options
    ) );

}
