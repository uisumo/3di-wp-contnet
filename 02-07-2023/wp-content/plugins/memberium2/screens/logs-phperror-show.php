<?php
/**
 * Copyright (c) 2012-2022 David J Bullock
 * Web Power and Light, LLC
 * https://webpowerandlight.com
 * support@webpowerandlight.com
 */

 class_exists( 'm4is_emz57o' ) || die(); current_user_can( 'manage_options' ) || wp_die( __( 'You do not have sufficient permissions to access this page.' ) ); new m4is_jgkh; 
class m4is_jgkh { 
function __construct() { $this->m4is_y3z1(); } private 
function m4is_y3z1() { $m4is_u2e7w = ini_get( 'error_log' ); echo '<h3>PHP Error Log</h3>'; if ( empty( $m4is_u2e7w ) ) { echo '<p>PHP Error log file is empty.</p>'; } else { if ( file_exists( $m4is_u2e7w ) ) { $m4is_aenh8k = 32 * KB_IN_BYTES; $m4is_n8k90 = filesize( $m4is_u2e7w ); $m4is_c8963p = ceil( $m4is_n8k90 / MB_IN_BYTES ); $m4is_qjvzm = $m4is_aenh8k > $m4is_n8k90 ? $m4is_n8k90 : -$m4is_aenh8k; echo '<textarea style="width:80%" rows="20">'; echo esc_html( file_get_contents( $m4is_u2e7w, null, null, $m4is_qjvzm, $m4is_aenh8k ) ); echo '</textarea><br />'; echo 'Total Error Log Length:  ', $m4is_c8963p, 'MB<br>'; } else { echo '<p>Error log defined, but not found.</p>'; } } } }
