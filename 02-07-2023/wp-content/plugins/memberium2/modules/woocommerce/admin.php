<?php
/**
 * Copyright (c) 2012-2022 David J Bullock
 * Web Power and Light
 */

 class_exists('m4is_emz57o') || die(); final 
class m4is_g2kca { private $metas = [ '_memberium_main_tag', '_memberium_canc_tag', '_memberium_payf_tag', '_memberium_susp_tag', ]; static 
function m4is_a6x52r() : self { static $m4is_jprj8 = false; return $m4is_jprj8 ? $m4is_jprj8 : $m4is_jprj8 = new self; } 
function __construct() { $this->m4is_ap508(); } private 
function m4is_ap508() { add_action( 'admin_init', [$this, 'm4is_f2h7'] ); add_filter( 'memberium/modules/active/names', [$this, 'm4is_hj92e'], 10, 1 ); add_filter( 'woocommerce_helper_suppress_admin_notices', '__return_true' ); } 
function m4is_hj92e( $m4is_its6y ) { return array_merge( $m4is_its6y, [ 'WooCommerce for Memberium Support' ] ); } 
function m4is_f2h7() { add_meta_box( 'memberium\woocommerce\actions','Memberium WooCommerce', [$this, 'm4is_gjr9u'], 'product', 'side' ); add_action( 'save_post_product', [$this, 'm4is_vx7tp'] ); } 
function m4is_gjr9u() { global $post; $m4is__h5n = (int) get_post_meta( $post->ID, '_memberium_main_tag', true ); $m4is_r7yf = (int) get_post_meta( $post->ID, '_memberium_canc_tag', true ); $m4is_gvacp7 = (int) get_post_meta( $post->ID, '_memberium_payf_tag', true ); $m4is_h1wv = (int) get_post_meta( $post->ID, '_memberium_susp_tag', true ); echo '<label for="_memberium_main_tag">', _e( "Access Tag", 'memberium' ), ':</label> '; echo '<input name="_memberium_main_tag" class="taglistdropdown" style="width:100%; max-width:100%" value="', $m4is__h5n, '"><br /><br />'; echo '<label for="_memberium_canc_tag">', _e( "Cancel Tag", 'memberium' ), ':</label> '; echo '<input name="_memberium_canc_tag" class="taglistdropdown" style="width:100%; max-width:100%" value="', $m4is_r7yf, '"><br /><br />'; echo '<label for="_memberium_payf_tag">', _e( "Payment Failure Tag", 'memberium' ), ':</label> '; echo '<input name="_memberium_payf_tag"  class="taglistdropdown" style="width:100%; max-width:100%" value="', $m4is_gvacp7, '"><br /><br />'; echo '<label for="_memberium_susp_tag">', _e( "Suspend/On-Hold Tag", 'memberium' ), ':</label> '; echo '<input name="_memberium_susp_tag" class="taglistdropdown" style="width:100%; max-width:100%" value="', $m4is_h1wv, '"><br /><br />'; } 
function m4is_vx7tp( int $m4is__xysg ) {  if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) { return; } if ( ! current_user_can( 'edit_posts', $m4is__xysg ) ) { return; } if ( ! $m4is__xysg ) { return; } foreach( $this->metas as $m4is_ti8od ) { if ( isset( $_POST[$m4is_ti8od] ) ) { $_POST[$m4is_ti8od] = trim( $_POST[$m4is_ti8od], ',' ); update_post_meta( $m4is__xysg, $m4is_ti8od, $_POST[$m4is_ti8od] ); } } } }
