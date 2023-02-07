<?php
add_action( 'customize_register', 'ldvc_theme_customizer_api' );
function ldvc_theme_customizer_api( $wp_customize ) {

    lds_create_custom_fields();

    $wp_customize->add_panel( 'lds_visual_customizer', array(
        'priority'      =>  100,
        'capability'        =>  'edit_theme_options',
        'theme_supports'    =>  '',
        'title'             =>  __( 'LearnDash Styling', 'lds_skins' ),
        'description'       =>  __( 'Control the LearnDash Styling' )
    ) );


    $sections = array(
        'templates-themes',
        'content-list',
        'colors',
        'fonts',
        'icons',
        'focus',
        'hide'
    );

    foreach( $sections as $section ) {
        include( 'customizer/' . $section . '.php' );
    }

    $wp_customize->add_section( 'lds_visual_customizer_buttons', array(
        'title'     => __( 'Buttons & Elements', 'lds_skins' ),
        'priority'  => 35,
        'panel'     => 'lds_visual_customizer'
    ) );

    $button_settings = apply_filters( 'lds_visual_customizer_color_buttons', array(
        'lds_clear_btn'     =>  array(
            'default'       =>  '',
            'type'          =>  'option',
            'transport'     =>  'refresh',
            'capability'    =>  'edit_theme_options'
        ),
        'lds_status_border_radius' => array(
            'default'        => '',
            'type'           => 'option',
            'transport'      => 'refresh',
            'capability'     => 'edit_theme_options',
        ),
        'lds_button_bg' => array(
            'default'        => '',
            'type'           => 'option',
            'transport'      => 'refresh',
            'capability'     => 'edit_theme_options',
        ),
        'lds_button_border_radius' => array(
            'default'        => '',
            'type'           => 'option',
            'transport'      => 'refresh',
            'capability'     => 'edit_theme_options',
        ),
        'lds_pagination_border_radius' => array(
            'default'        => '',
            'type'           => 'option',
            'transport'      => 'refresh',
            'capability'     => 'edit_theme_options',
        ),
        'lds_button_txt' => array(
            'default'        => '',
            'type'           => 'option',
            'transport'      => 'refresh',
            'capability'     => 'edit_theme_options',
        ),
        'lds_complete_button_bg' => array(
            'default'        => '',
            'type'           => 'option',
            'transport'      => 'refresh',
            'capability'     => 'edit_theme_options',
        ),
        'lds_complete_button_txt' => array(
            'default'        => '',
            'type'           => 'option',
            'transport'      => 'refresh',
            'capability'     => 'edit_theme_options',
        ),
    ) );

    foreach( $button_settings as $slug => $options ) {
        $wp_customize->add_setting( $slug, $options );
    }

    $button_controls = apply_filters( 'lds_visual_customizer_button_controls', array(
        'lds_status_border_radius' => array(
            'label'      => __( 'Status Border Radius', 'lds_skins' ),
            'section'    => 'lds_visual_customizer_buttons',
            'settings'   => 'lds_status_border_radius',
            'min'        => 0,
            'max'        => 50,
            'step'       => 1,
            'default'    => 25,
        ),
        'lds_button_border_radius' => array(
            'label'      => __( 'Button Border Radius', 'lds_skins' ),
            'section'    => 'lds_visual_customizer_buttons',
            'settings'   => 'lds_button_border_radius',
            'min'        => 0,
            'max'        => 50,
            'step'       => 1,
            'default'    => 25,
        ),
        'lds_pagination_border_radius' => array(
            'label'      => __( 'Pagination Border Radius', 'lds_skins' ),
            'section'    => 'lds_visual_customizer_buttons',
            'settings'   => 'lds_pagination_border_radius',
            'min'        => 0,
            'max'        => 50,
            'step'       => 1,
            'default'    => 25,
        ),
    ) );

    foreach( $button_controls as $slug => $control ) {
        $wp_customize->add_control( new WP_Customize_Range( $wp_customize, $slug, $control ) );
    }

    $button_color_controls = apply_filters( 'lds_visual_customizer_button_color_controls', array(
        'lds_button_txt' => array(
            'label'      => __( 'Default Button Text', 'lds_skins' ),
            'section'    => 'lds_visual_customizer_buttons',
            'settings'   => 'lds_button_txt',
        ),
        'lds_button_bg' => array(
            'label'      => __( 'Default Button Background', 'lds_skins' ),
            'section'    => 'lds_visual_customizer_buttons',
            'settings'   => 'lds_button_bg',
        ),
        'lds_complete_button_bg' => array(
            'label'      => __( 'Complete Button Background', 'lds_skins' ),
            'section'    => 'lds_visual_customizer_buttons',
            'settings'   => 'lds_complete_button_bg',
        ),
        'lds_complete_button_txt' => array(
            'label'      => __( 'Complete Button Text', 'lds_skins' ),
            'section'    => 'lds_visual_customizer_buttons',
            'settings'   => 'lds_complete_button_txt',
        ),
    ) );

    foreach( $button_color_controls as $slug => $control ) {
        $wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, $slug, $control ) );
    }

    /*
    $learndash_elements_settings = apply_filters( 'lds_hide_breadcrumbs', array(
        'lds_disable_tabs' => array(
            'label'      => __( 'Disable course & materials tabs', 'lds_skins' ),
            'section'    => 'lds_visual_customizer_content_list',
            'settings'   => 'lds_disable_tabs',
            'type'       => 'checkbox',
        ),
    ) );


    foreach( $learndash_elements_settings as $slug => $options ) {

        $wp_customize->add_control( new WP_Customize_Control(
            $wp_customize,
            $slug,
            $options
        ) );

    }
    */

    $wp_customize->add_section( 'lds_visual_customizer_widgets', array(
        'title'     => __( 'Widgets', 'lds_skins' ),
        'priority'  => 35,
        'panel'     => 'lds_visual_customizer'
    ) );

    $widget_settings = apply_filters( 'lds_visual_customizer_widget_colors', array(
        'lds_widget_txt' => array(
            'default'        => '',
            'type'           => 'option',
            'transport'      => 'refresh',
            'capability'     => 'edit_theme_options',
        ),
        'lds_widget_bg' => array(
            'default'        => '',
            'type'           => 'option',
            'transport'      => 'refresh',
            'capability'     => 'edit_theme_options',
        ),
        'lds_widget_header_txt' => array(
            'default'        => '',
            'type'           => 'option',
            'transport'      => 'refresh',
            'capability'     => 'edit_theme_options',
        ),
        'lds_widget_header_bg' => array(
            'default'        => '',
            'type'           => 'option',
            'transport'      => 'refresh',
            'capability'     => 'edit_theme_options',
        ),
        'lds_widget_links'  => array(
            'default'        => '',
            'type'           => 'option',
            'transport'      => 'refresh',
            'capability'     => 'edit_theme_options',
        ),
    ) );

    /*
    foreach( $widget_settings as $slug => $options ) {
        $wp_customize->add_setting( $slug, $options );
    } */

    /*
    $widget_color_controls = apply_filters( 'lds_visual_customizer_widget_color_controls', array(
        'lds_widget_txt' => array(
            'label'      => __( 'Widget Text', 'lds_skins' ),
            'section'    => 'lds_visual_customizer_widgets',
            'settings'   => 'lds_widget_txt',
        ),
        'lds_widget_bg' => array(
            'label'      => __( 'Widget Background', 'lds_skins' ),
            'section'    => 'lds_visual_customizer_widgets',
            'settings'   => 'lds_widget_bg',
        ),
        'lds_widget_header_txt' => array(
            'label'      => __( 'Widget Header Text', 'lds_skins' ),
            'section'    => 'lds_visual_customizer_widgets',
            'settings'   => 'lds_widget_header_txt',
        ),
        'lds_widget_header_bg' => array(
            'label'      => __( 'Widget Header Background', 'lds_skins' ),
            'section'    => 'lds_visual_customizer_widgets',
            'settings'   => 'lds_widget_header_bg',
        ),
        'lds_widget_links' => array(
            'label'      => __( 'Widget Links', 'lds_skins' ),
            'section'    => 'lds_visual_customizer_widgets',
            'settings'   => 'lds_widget_links',
        ),
    ) );

    foreach( $widget_color_controls as $slug => $control ) {
        $wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, $slug, $control ) );
    }
    */

    $wp_customize->add_section( 'lds_visual_customizer_quiz', array(
        'title'     => __( 'Quiz Colors', 'lds_skins' ),
        'priority'  => 35,
        'panel'     => 'lds_visual_customizer'
    ) );

    $quiz_color_settings = apply_filters( 'lds_visual_customizer_quiz_settings', array(
        'lds_quiz_bg' => array(
            'default'        => '',
            'type'           => 'option',
            'transport'      => 'refresh',
            'capability'     => 'edit_theme_options',
        ),
        'lds_quiz_txt' => array(
            'default'        => '',
            'type'           => 'option',
            'transport'      => 'refresh',
            'capability'     => 'edit_theme_options',
        ),
        'lds_quiz_correct_txt' => array(
            'default'        => '',
            'type'           => 'option',
            'transport'      => 'refresh',
            'capability'     => 'edit_theme_options',
        ),
        'lds_quiz_correct_bg' => array(
            'default'        => '',
            'type'           => 'option',
            'transport'      => 'refresh',
            'capability'     => 'edit_theme_options',
        ),
        'lds_quiz_incorrect_txt' => array(
            'default'        => '',
            'type'           => 'option',
            'transport'      => 'refresh',
            'capability'     => 'edit_theme_options',
        ),
        'lds_quiz_incorrect_bg' => array(
            'default'        => '',
            'type'           => 'option',
            'transport'      => 'refresh',
            'capability'     => 'edit_theme_options',
        ),
    ) );

    foreach( $quiz_color_settings as $slug => $options ) {
        $wp_customize->add_setting( $slug, $options );
    }

    $quiz_color_controls = apply_filters( 'lds_visual_customizer_quiz_color_controls', array(
        'lds_quiz_bg' => array(
            'label'      => __( 'Quiz Question Background', 'lds_skins' ),
            'section'    => 'lds_visual_customizer_quiz',
            'settings'   => 'lds_quiz_bg',
        ),
        'lds_quiz_txt' => array(
            'label'      => __( 'Quiz Question Text', 'lds_skins' ),
            'section'    => 'lds_visual_customizer_quiz',
            'settings'   => 'lds_quiz_txt',
        ),
        'lds_quiz_correct_txt' => array(
            'label'      => __( 'Quiz Question Correct Text', 'lds_skins' ),
            'section'    => 'lds_visual_customizer_quiz',
            'settings'   => 'lds_quiz_correct_txt',
        ),
        'lds_quiz_correct_bg' => array(
            'label'      => __( 'Quiz Question Correct Background', 'lds_skins' ),
            'section'    => 'lds_visual_customizer_quiz',
            'settings'   => 'lds_quiz_correct_bg',
        ),
        'lds_quiz_incorrect_txt' => array(
            'label'      => __( 'Quiz Question Incorrect Text', 'lds_skins' ),
            'section'    => 'lds_visual_customizer_quiz',
            'settings'   => 'lds_quiz_incorrect_txt',
        ),
        'lds_quiz_incorrect_bg' => array(
            'label'      => __( 'Quiz Question Incorrect Background', 'lds_skins' ),
            'section'    => 'lds_visual_customizer_quiz',
            'settings'   => 'lds_quiz_incorrect_bg',
        ),
    ) );

    foreach( $quiz_color_controls as $slug => $control ) {
        $wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, $slug, $control ) );
    }

    return $wp_customize;

}

function lds_create_custom_fields() {

    if( class_exists( 'WP_Customize_Control' ) ) {

    	class WP_Customize_Range extends WP_Customize_Control {
    		public $type = 'range';

            public function __construct( $manager, $id, $args = array() ) {
                parent::__construct( $manager, $id, $args );

                $defaults = array(
                    'min'       => 0,
                    'max'       => 10,
                    'step'      => 1,
                    'default'   => 0
                );
                $args = wp_parse_args( $args, $defaults );

                $this->min = $args['min'];
                $this->max = $args['max'];
                $this->step = $args['step'];
                $this->default = $args['default'];

            }

    		public function render_content() {
    		?>
    		<label>
    			<span class="customize-control-title"><?php echo esc_html( $this->label ); ?></span>
    			<input class='range-slider' min="<?php echo $this->min ?>" max="<?php echo $this->max ?>" default="<?php echo $this->default; ?>" step="<?php echo $this->step ?>" type='range' <?php $this->link(); ?> value="<?php echo esc_attr( $this->value() ); ?>" oninput="jQuery(this).next('input').val( jQuery(this).val() )">
                <input class="lds-range-input" onKeyUp="jQuery(this).prev('input').val( jQuery(this).val() ).trigger('change');" type='number' default="<?php echo $this->default; ?>" value='<?php echo esc_attr( $this->value() ); ?>'>

    		</label>
    		<?php
    		}
    	}

        class LDVC_Customize_Iconpicker_Control extends WP_Customize_Control {

    		/**
    		 * Render the control's content.
    		 */
    		public function render_content() {
    			?>
    			<label>
    				<span class="customize-control-title">
    					<?php echo esc_html( $this->label ); ?>
    				</span>
    				<div class="input-group icp-container">
    					<input data-placement="bottomRight" class="icp icp-auto" <?php $this->link(); ?> value="<?php echo esc_attr( $this->value() ); ?>" type="text">
    					<span class="input-group-addon"></span>
    				</div>
    			</label>
    			<?php
    		}

            public function enqueue() {

                if( get_option( 'lds_fontawesome_ver', '5' ) == '5' ) {

                    wp_register_script( 'fontawesome', LDS_URL . '/assets/js/vendor/fontawesome/all.min.js', LDS_VER );
                    wp_register_script('fontawesome-shims', LDS_URL . '/assets/js/vendor/fontawesome/v4-shims.min.js');

                    wp_register_style( 'fontawesome-iconpicker', LDS_URL . '/assets/css/vendor/fontawesome/fontawesome-iconpicker.min.css', LDS_VER );
                    wp_register_script( 'fontawesome-iconpicker', LDS_URL . '/assets/js/vendor/iconpicker/fontawesome-iconpicker-5.min.js', LDS_VER, array('jquery') );

                    wp_enqueue_script('fontawesome');
                    wp_enqueue_script('fontawesome-shims');

                } else {
                    wp_register_style( 'fontawesome', LDS_URL . '/assets/css/vendor/fontawesome/v4/font-awesome-4.min.css', LDS_VER );
                    wp_register_style( 'fontawesome-iconpicker', LDS_URL . '/assets/css/vendor/fontawesome/fontawesome-iconpicker.min.css', LDS_VER );
                    wp_register_script( 'fontawesome-iconpicker', LDS_URL . '/assets/js/vendor/iconpicker/fontawesome-iconpicker-4.min.js', LDS_VER, array('jquery') );
                }

                wp_enqueue_style('fontawesome');
                wp_enqueue_style('fontawesome-iconpicker');
                wp_enqueue_script('fontawesome-iconpicker');
                wp_register_script( 'iconpicker-control', LDS_URL . '/assets/js/vendor/iconpicker-control.js', LDS_VER, array('jquery'), true );
                wp_enqueue_script( 'iconpicker-control' );

            }

    	}

    }

}

add_action( 'customize_controls_enqueue_scripts', 'lds_customizer_preview' );
function lds_customizer_preview() {

    wp_register_style( 'lds-customizer-preview', LDS_URL . '/assets/css/admin/ldvc-customizer.css'  );
    wp_enqueue_style( 'lds-customizer-preview' );

    wp_register_script( 'lds-customizer-fields', LDS_URL . '/assets/js/admin/ldvc-admin.js' );
    wp_enqueue_script( 'lds-customizer-fields' );

}

function lds_reset_settings() {

    return apply_filters( 'lds_reset_settings', array(
        'lds_status_border_radius',
        'lds_button_bg',
        'lds_button_border_radius',
        'lds_button_txt',
        'lds_complete_button_bg',
        'lds_complete_button_txt',
        'lds_widget_txt',
        'lds_widget_bg',
        'lds_widget_header_txt',
        'lds_widget_header_bg',
        'lds_widget_links',
        'lds_tertiary_txt_color',
        'lds_tertiary_bg_color',
        'lds_content_item_bg',
        'lds_content_item_border',
        'lds_heading_txt',
        'lds_heading_bg',
        'lds_sub_heading_txt',
        'lds_sub_heading_bg',
        'lds_content_list_border_size',
        'lds_content_list_border_radius',
        'lds_content_list_spacing',
        'lds_content_list_drop_shadow',
        'lds_font_family',
        'lds_heading_font_family',
        'lds_heading_font_size',
        'lds_section_heading_font_size',
        'lds_item_font_size',
        'lds_item_attribute_font_size',
        'lds_widget_heading_font_size',
        'lds_widget_section_heading_font_size',
        'lds_widget_item_attributes_font_size',
        'lds_widget_item_font_size',
        'lds_widget_sub_item_font_size',
        'lds_button_font_size',
        'lds_content_list_spacing',
        'lds_content_list_drop_shadow',
        'lds_expanded_content_bg',
        'lds_item_txt',
    ) );

}

// add_action( 'admin_init', 'lds_test_color_update' );
function lds_test_color_update() {

    LearnDash_Settings_Section::set_section_setting( 'LearnDash_Settings_Theme_LD30', 'color_primary', '#dddddd' );

}

function lds_update_theme_color( $value, $setting ) {

    /**
     * This is a bit of a hack because we're using this to update a core setingg
     * @var [type]
     */

     $colors = array(
         'lds_primary_color'    =>  'color_primary',
         'lds_secondary_color'  =>  'color_secondary',
         'lds_alert_color'      =>  'color_tertiary',
     );

    // color_primary;

    LearnDash_Settings_Section::set_section_setting( 'LearnDash_Settings_Theme_LD30', $colors[$setting->id], $value );

    return $value;

    //return $value;

}

add_action( 'init', 'lds_validate_theme_color_settings', 100 );
function lds_validate_theme_color_settings() {

    $colors = array(
        'lds_primary_color'    =>  'color_primary',
        'lds_secondary_color'  =>  'color_secondary',
        'lds_alert_color'      =>  'color_tertiary',
    );

    foreach( $colors as $lds_setting => $learndash_setting ) {

        $learndash_value = LearnDash_Settings_Section::get_section_setting( 'LearnDash_Settings_Theme_LD30', $learndash_setting );
        $lds_value = get_option( $lds_setting );

        if( !$lds_value || empty($lds_value) ) {
            continue;
        }

        if( $learndash_value !== $lds_value ) {
            LearnDash_Settings_Section::set_section_setting( 'LearnDash_Settings_Theme_LD30', $learndash_setting, $lds_value );
        }

    }

}
