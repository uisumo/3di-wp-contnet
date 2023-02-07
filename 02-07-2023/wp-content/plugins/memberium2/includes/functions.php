<?php
/**
 * Copyright (c) 2012-2022 David J Bullock
 * Web Power and Light, LLC
 * https://webpowerandlight.com
 * support@webpowerandlight.com
 *
 */

 class_exists( 'm4is_emz57o' ) || die(); if (! function_exists('wp_new_user_notification') ) {  
function wp_new_user_notification( int $m4is_q4c_xa, $m4is_xpzs = '' ) { $m4is_bxv7u = memberium_app(); $m4is_wxlzb = 0; $m4is_aicfp = 0; $m4is_wmzqp = $m4is_bxv7u->m4is_mmdrl(); $m4is_nzrv1 = get_userdata( $m4is_q4c_xa ); $m4is_led3 = (bool) $m4is_bxv7u->m4is_mmdrl( 'settings', 'sync_new_wp_users' ); $m4is_jyx_t = (string) $m4is_bxv7u->m4is_mmdrl( 'settings', 'password_field' ); $m4is_qy0cg = (bool) $m4is_bxv7u->m4is_mmdrl( 'settings', 'local_auth_only', false ); $m4is_p1nfgu = (int) $m4is_bxv7u->m4is_mmdrl( 'settings', 'new_user_registration_tag', 0 ); $m4is_ein8u7 = (int) $m4is_bxv7u->m4is_mmdrl( 'settings', 'password_reset_tag', 0 ); $m4is_nq7s = [ 'Email' => $m4is_nzrv1->user_email, $m4is_jyx_t => $m4is_xpzs, ]; if ( $m4is_qy0cg ) { unset( $m4is_nq7s[$m4is_jyx_t] ); } if ( ! empty( $m4is_led3 ) ) { $m4is_aicfp = m4is_zbyh::m4is_dj3iv( $m4is_nq7s ); if ( $m4is_p1nfgu ) { $m4is_bxv7u->m4is_wnlbj_()->grpAssign( $m4is_aicfp, $m4is_p1nfgu ); } }   $m4is_dvdxb = wp_specialchars_decode( get_option( 'blogname' ), ENT_QUOTES ); $m4is_fgxy = sprintf( __( 'New user registration on your site %s:' ), $m4is_dvdxb ) . "\r\n\r\n"; $m4is_fgxy .= sprintf( __( 'Username: %s'), $m4is_nzrv1->user_login ) . "\r\n\r\n"; $m4is_fgxy .= sprintf( __( 'E-mail: %s'), $m4is_nzrv1->user_email ) . "\r\n"; @wp_mail( get_option( 'admin_email' ), sprintf( __( '[%s] New User Registration' ), $m4is_dvdxb ), $m4is_fgxy ); if ( empty( $m4is_xpzs ) ) { return; } $m4is_fgxy = sprintf( __( 'Username: %s' ), $m4is_nzrv1->user_login ) . "\r\n"; $m4is_fgxy .= sprintf( __( 'Password: %s' ), $m4is_xpzs ) . "\r\n"; $m4is_fgxy .= wp_login_url() . "\r\n"; wp_mail( $m4is_nzrv1->user_email, sprintf( __( '[%s] Your username and password' ), $m4is_dvdxb ), $m4is_fgxy ); } }
