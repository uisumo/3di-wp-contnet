<?php
/**
 * Copyright (c) 2012-2022 David J Bullock
 * Web Power and Light
 */

 class_exists('m4is_emz57o') || die(); 
class m4is_bsv1 { 
function m4is_y_ak($m4is_kbu63_) { if (is_user_logged_in() ) { if (! wp_doing_ajax() ) { $m4is_kbu63_['billing']['billing_email']['required'] = 0; echo '
				<style>
				#billing_email_field {visibility:hidden;}
				#billing_email_field label span {visibility:hidden;}
				</style>'; } } return $m4is_kbu63_; } 
function m4is_gg_4() { $m4is_hn69 = memberium_app()->m4is_oqjptk(); $m4is_znf9['nested'] = [ 'memb_has_in_cart' => [$m4is_hn69, 'm4is__rdak'], 'memb_has_purchased_product' => [$m4is_hn69, 'm4is_dxm9'], 'memb_is_cart_empty' => [$m4is_hn69, 'm4is_svlx1'], ]; $m4is_znf9['standard'] = []; foreach( $m4is_znf9['standard'] as $m4is_w9feq2 => $m4is_oqzu1 ) { add_shortcode( $m4is_w9feq2, [$this, $m4is_oqzu1]); } foreach( $m4is_znf9['nested'] as $m4is_w9feq2 => $m4is_oqzu1 ) { add_shortcode( $m4is_w9feq2, [$this, $m4is_oqzu1[1] ] ); for ( $i = 1; $i < (int) $m4is_oqzu1[0]; $i++ ) { add_shortcode( $m4is_w9feq2 . $i, [$this, $m4is_oqzu1[1]]); } } } 
function m4is_dxm9( $m4is_qvehs, $m4is_amunwi = null, $m4is_rz70ok ) { m4is_d8yr0_::m4is_vsv0mr(); $m4is_p78sgz = [ 'product_id' => '', 'txtfmt' => '', 'capture' => '', ]; $m4is_qvehs =shortcode_atts($m4is_p78sgz, $m4is_qvehs, 'memberium'); $m4is_g0y5i = explode( ',', $m4is_qvehs['product_id'] ); $m4is_q4c_xa = get_current_user_id(); $m4is_in0ti = false; foreach( $m4is_g0y5i as $m4is_sdob0 ) { $m4is_in0ti = $m4is_in0ti || wc_customer_bought_product(null, $m4is_q4c_xa, $m4is_sdob0); } $m4is_k2qb08 = m4is_qipkj::m4is_mngd87($m4is_amunwi, $m4is_rz70ok, true, $m4is_in0ti); return m4is_qipkj::m4is__85o(false, $m4is_k2qb08, $m4is_qvehs['txtfmt'], $m4is_qvehs['capture']); } 
function m4is__rdak($m4is_qvehs, $m4is_amunwi = null, $m4is_rz70ok) { global $woocommerce; m4is_d8yr0_::m4is_vsv0mr(); $m4is_p78sgz = [ 'product_id' => '', 'txtfmt' => '', 'capture' => '', ]; $m4is_qvehs = shortcode_atts($m4is_p78sgz, $m4is_qvehs, 'memberium'); $m4is_in0ti = false; $m4is_g0y5i = explode(',', $m4is_qvehs['product_id']); $m4is_b16cy = $woocommerce->cart->get_cart(); foreach( $m4is_b16cy as $m4is_e3k_mi => $m4is_waxrhu ) { $m4is_in0ti = $m4is_in0ti || in_array( $m4is_waxrhu['product_id'], $m4is_g0y5i ); } $m4is_k2qb08 = m4is_qipkj::m4is_mngd87($m4is_amunwi, $m4is_rz70ok, true, $m4is_in0ti); return m4is_qipkj::m4is__85o(false, $m4is_k2qb08, $m4is_qvehs['txtfmt'], $m4is_qvehs['capture']); } 
function m4is_svlx1($m4is_qvehs, $m4is_amunwi = null, $m4is_rz70ok) { global $woocommerce; m4is_d8yr0_::m4is_vsv0mr(); $m4is_b16cy = $woocommerce->cart->get_cart(); $m4is_in0ti = empty( $m4is_b16cy ); $m4is_m97_i = ''; $m4is_rmz2f = ''; $m4is_k2qb08 = m4is_qipkj::m4is_mngd87($m4is_amunwi, $m4is_rz70ok, true, $m4is_in0ti); return m4is_qipkj::m4is__85o(false, $m4is_k2qb08, $m4is_m97_i, $m4is_rmz2f); } 
function m4is_ogd9($m4is_cmat) { return; if ($_SERVER['REMOTE_ADDR'] !== '71.92.64.210') { return; } else { $m4is_cmat = empty($m4is_cmat) ? 6389 : $m4is_cmat; } $m4is_rprd_t = wc_get_order($m4is_cmat); echo '<Pre>', print_r($m4is_rprd_t, true), '</Pre>'; die(); if (is_object($m4is_rprd_t)) { if (! $m4is_rprd_t->has_status('failed') ) { $m4is_pizyx = trim(get_post_meta($m4is_cmat, 'memberium/purchase/redirect_url', true) ); if (! empty($m4is_pizyx)) { wp_redirect($m4is_pizyx); exit; } } } }    
function m4is_jqe0k() { echo m4is_pewcid::m4is_jga1s('', ['display' => true]); } 
function m4is_ap508() { add_action('init', [$this, 'm4is_gg_4'], 1 ); add_action('woocommerce_thankyou', [$this, 'm4is_ogd9'], 20); add_action('woocommerce_login_form', [$this, 'm4is_jqe0k']); add_filter('woocommerce_checkout_fields', [$this, 'm4is_y_ak'], 100, 1); } private 
function __construct() { $this->m4is_ap508(); if ($_SERVER['REMOTE_ADDR'] == '71.92.64.210') { add_action('template_redirect', [$this, 'm4is_ogd9']); } } static 
function m4is_a6x52r() : self { static $m4is_jprj8 = false; return $m4is_jprj8 ? $m4is_jprj8 : $m4is_jprj8 = new self; } }
