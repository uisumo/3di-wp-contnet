<?php
/**
* Copyright (c) 2018-2022 David J Bullock
* Web Power and Light
*/

 class_exists( 'm4is_emz57o' ) || die();  
class m4is_op_x extends \Elementor\Widget_Shortcode {  protected 
function render() { $m4is_amunwi = $this->get_settings_for_display( 'shortcode' ); $m4is_amunwi = apply_filters( 'memberium/elementor/widget/shortcode/render', $m4is_amunwi, $this->get_settings_for_display() ); if ( ! empty( $m4is_amunwi ) ){ global $wp_embed; $m4is_amunwi = do_shortcode( shortcode_unautop( $wp_embed->run_shortcode( $m4is_amunwi ) ) );  echo '<div class="elementor-shortcode">', $m4is_amunwi, '</div>'; } } }
