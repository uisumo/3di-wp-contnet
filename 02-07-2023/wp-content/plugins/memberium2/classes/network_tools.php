<?php
/**
 * Copyright (c) 2018-2022 David J Bullock
 * Web Power and Light, LLC
 * https://webpowerandlight.com
 * support@webpowerandlight.com
 *
 */

 class_exists('m4is_emz57o') || die(); final 
class m4is_lr56w2 {  static 
function m4is_nnbp() : string { static $m4is_vkuot = ''; if (! empty($m4is_vkuot) ) { return $m4is_vkuot; } $m4is_vkuot = $_SERVER['REMOTE_ADDR']; $m4is_vd4e2 = [ 'HTTP_CLIENT_IP', 'HTTP_X_FORWARDED_FOR', 'HTTP_X_FORWARDED', 'HTTP_X_CLUSTER_CLIENT_IP', 'HTTP_FORWARDED_FOR', 'HTTP_FORWARDED', 'HTTP_X_SUCURI_CLIENTIP', 'HTTP_X_REAL_IP', ]; foreach ($m4is_vd4e2 as $m4is_ap3_) { if (array_key_exists($m4is_ap3_, $_SERVER) === true) { foreach (explode(',', $_SERVER[$m4is_ap3_]) as $m4is_i3i97) { $m4is_i3i97 = trim($m4is_i3i97); if (self::m4is_p7ato2($m4is_i3i97) ) { $m4is_vkuot = $m4is_i3i97; } } } } return $m4is_vkuot; }  private static 
function m4is_p7ato2( string $m4is_i3i97 ) : bool { if (filter_var($m4is_i3i97, FILTER_VALIDATE_IP, FILTER_FLAG_IPV4 | FILTER_FLAG_NO_PRIV_RANGE | FILTER_FLAG_NO_RES_RANGE) === false) { return false; } return true; }  static 
function m4is_moyj( string $m4is__mto = '', bool $m4is_phws = false, array $m4is_w5ky4q = [] ) : string { $m4is_p78sgz = [ 'timeout' => 3, ]; $m4is_w5ky4q = wp_parse_args( $m4is_w5ky4q, $m4is_p78sgz ); $m4is_zv59 = wp_remote_get( $m4is__mto, $m4is_w5ky4q ); if ( is_array( $m4is_zv59 ) ) { if ( empty( $m4is_zv59['body'] ) ) { $m4is_zv59['body'] = ''; } if ( ! $m4is_phws ) { return $m4is_zv59['body']; } else { return $m4is_zv59; } } return ''; }  static 
function m4is_pg04d( string $m4is_i3i97, string $m4is_nli0o ) : bool { list( $subnet, $m4is_mwuxn5 ) = explode( '/', $m4is_nli0o ); if ( ( ip2long( $m4is_i3i97 ) & ~( ( 1 << ( 32 - $m4is_mwuxn5 ) ) - 1 ) ) == ip2long( $subnet ) ) { return true; } return false; }  static 
function m4is_zsmn5() { $m4is_t7i0bz = 'memberium/aws_subnets'; $m4is_xdsga = get_transient($m4is_t7i0bz); if ($m4is_xdsga === false) {  $m4is_zv59 = wp_remote_get('https://ip-ranges.amazonaws.com/ip-ranges.json');  $m4is_zv59 = json_decode($m4is_zv59['body']); $m4is_xdsga = $m4is_zv59->prefixes; set_transient($m4is_t7i0bz, $m4is_xdsga, 24 * HOUR_IN_SECONDS); unset($m4is_zv59); } return $m4is_xdsga; }  static 
function m4is_k26z() : array { $m4is_xdsga = m4is_lr56w2::m4is_zsmn5(); $m4is_gmrohd = []; foreach( $m4is_xdsga as $m4is_ftso ) { if ( 'S3' == $m4is_ftso->service ) { $m4is_gmrohd[ $m4is_ftso->region ] = $m4is_ftso->region; } } ksort( $m4is_gmrohd ); return $m4is_gmrohd; } }
