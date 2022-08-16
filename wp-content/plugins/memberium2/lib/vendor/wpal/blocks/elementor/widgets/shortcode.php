<?php
/**
 * Copyright (c) 2020 David J Bullock
 * Web Power and Light
 */

 if (! defined( 'ABSPATH' ) ) { die(); }  class wpla4vc extends \Elementor\Widget_Shortcode {  protected function wplsfmu3d() { $shortcode = $this->get_settings_for_display( 'shortcode' ); $shortcode = apply_filters( 'wpal/blocks/elementor/widget/shortcode/render', $shortcode, $this->get_settings_for_display() ); if ( !empty($shortcode) ){ $shortcode = do_shortcode( shortcode_unautop( $shortcode ) ); echo '<div class="elementor-shortcode">'; echo $shortcode; echo '</div>'; } } }
