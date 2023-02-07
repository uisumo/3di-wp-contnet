<?php
/**
 * Copyright (c) 2017-2022 David J Bullock
 * Web Power and Light, LLC
 * https://webpowerandlight.com
 * support@webpowerandlight.com
 *
 */

 class_exists('m4is_emz57o') || die(); final 
class m4is_mk38 {  private static 
function m4is_h65n() { return [ 'American Express' => ['34', '37'], 'China UnionPay' => ['62', '88'], 'Diners Club Carte Blanche' => ['300', '305'], 'Diners Club International' => ['300', '305', '309', '36', '38,39'], 'Diners Club' => ['54', '55'], 'Discover Card' => ['6011', '622126', '622925', '644,649', '65'], 'JCB' => ['3528', '3589'], 'Laser' => ['6304', '6706', '6771', '6709'], 'Maestro' => ['5018', '5020', '5038', '5612', '5893', '6304', '6759', '6761', '6762', '6763', '0604', '6390'], 'Dankort' => ['5019'], 'MasterCard' => ['50', '55'], 'Visa' => ['4'], 'Visa Electron' => ['4026', '417500', '4405', '4508', '4844', '4913', '4917'], ]; }  static 
function m4is_hs_f5($m4is_hdlf3h) { $m4is_j1vz = 'Unknown'; $m4is_jqxlh = self::m4is_h65n(); foreach( $m4is_jqxlh as $m4is_ho0w2 => $m4is_hsj98 ) { foreach( $m4is_hsj98 as $m4is_eg2e ) { if ( strpos( $m4is_eg2e, ',' ) ) { $m4is_n9o8w = explode( ',', $m4is_eg2e ); $m4is_m7y1wp = substr( $m4is_hdlf3h, 0, strlen( $m4is_n9o8w[0] ) ); if ( $m4is_m7y1wp >= $m4is_n9o8w[0] and $m4is_m7y1wp <= $m4is_n9o8w[1] ) { $m4is_j1vz = $m4is_ho0w2; } } else {  if ( strpos( $m4is_hdlf3h, $m4is_eg2e) === 0 ) { $m4is_j1vz = $m4is_ho0w2; } } } } return $m4is_j1vz; } static 
function m4is_tzba0p($m4is_m7y1wp) { $m4is_m7y1wp = preg_replace('/\D/', '', $m4is_m7y1wp);  $m4is_otwzx = strlen($m4is_m7y1wp); $m4is_wj3wd = $m4is_otwzx % 2;  $m4is_lxlm0 = 0; for ($m4is_ll9yd5 = 0; $m4is_ll9yd5 < $m4is_otwzx; $m4is_ll9yd5++) { $m4is_yovuq5 = $m4is_m7y1wp[$m4is_ll9yd5];  if ($m4is_ll9yd5 % 2 == $m4is_wj3wd) { $m4is_yovuq5 *= 2;  if ($m4is_yovuq5 > 9) { $m4is_yovuq5-=9; } }  $m4is_lxlm0+=$m4is_yovuq5; }  return ($m4is_lxlm0 % 10 == 0) ? true : false; } }
