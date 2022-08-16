<?php
/**
 * Copyright (c) 2017-2020 David J Bullock
 * Web Power and Light, LLC
 * https://webpowerandlight.com
 * support@webpowerandlight.com
 *
 */

 if (! defined('ABSPATH') ) { die(); } final class wplg_b85d { static function wplywf_r($vwpleetzq) { $vwpl_v0yb = array( 'American Express' => array('34', '37',), 'China UnionPay' => array('62', '88',), 'Diners Club Carte Blanche' => array('300,305',), 'Diners Club International' => array('300,305', '309', '36', '38,39',), 'Diners Club' => array('54', '55',), 'Discover Card' => array('6011', '622126,622925', '644,649', '65',), 'JCB' => array('3528,3589',), 'Laser' => array('6304', '6706', '6771', '6709',), 'Maestro' => array('5018', '5020', '5038', '5612', '5893', '6304', '6759', '6761', '6762', '6763', '0604', '6390',), 'Dankort' => array('5019',), 'MasterCard' => array('50,55',), 'Visa' => array('4',), 'Visa Electron' => array('4026', '417500', '4405', '4508', '4844', '4913', '4917',), ); $vwplgm_9s = 'Unknown'; foreach($vwpl_v0yb as $vwplso1pw => $vwpltn53) { foreach($vwpltn53 as $vwplyct0) { if (strpos($vwplyct0, ',') ) { $vwplmicdu0 = explode(',', $vwplyct0); $vwpltopr = substr($vwpleetzq, 0, strlen($vwplmicdu0[0]) ); if ($vwpltopr >= $vwplmicdu0[0] and $vwpltopr <= $vwplmicdu0[1]) { $vwplgm_9s = $vwplso1pw; } } else {  if (strpos($vwpleetzq, $vwplyct0) === 0) { $vwplgm_9s = $vwplso1pw; } } } } return $vwplgm_9s; } static function wplyhe8bc($vwpltopr) { $vwpltopr = preg_replace('/\D/', '', $vwpltopr);  $vwpljhmqlz = strlen($vwpltopr); $vwplhq907 = $vwpljhmqlz % 2;  $vwplospm43 = 0; for ($vwplt_5ro = 0; $vwplt_5ro < $vwpljhmqlz; $vwplt_5ro++) { $vwplw31i = $vwpltopr[$vwplt_5ro];  if ($vwplt_5ro % 2 == $vwplhq907) { $vwplw31i *= 2;  if ($vwplw31i > 9) { $vwplw31i-=9; } }  $vwplospm43+=$vwplw31i; }  return ($vwplospm43 % 10 == 0) ? true : false; } }
