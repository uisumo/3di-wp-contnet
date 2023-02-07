<?php
/**
 * Copyright (c) 2017-2022 David J Bullock
 * Web Power and Light, LLC
 * https://webpowerandlight.com
 * support@webpowerandlight.com
 *
 */

 class_exists('m4is_emz57o') || die(); final 
class m4is__d4kf {  static 
function m4is_li9sf( $m4is_rr8f, $m4is_fnc39, $m4is_jprj8 ) { $m4is_kbu63_ = self::m4is_bo96y(); foreach ($m4is_kbu63_ as $m4is_ll9yd5 => $m4is_tenvhx){ $m4is_kbu63_[$m4is_ll9yd5]['id'] = $m4is_rr8f->get_field_id($m4is_tenvhx['name']); $m4is_kbu63_[$m4is_ll9yd5]['field_name'] = $m4is_rr8f->get_field_name($m4is_tenvhx['name']); $m4is_kbu63_[$m4is_ll9yd5]['value'] = isset($m4is_jprj8[$m4is_tenvhx['name']]) ? $m4is_jprj8[$m4is_tenvhx['name']] : ''; } $m4is_eg2e = 'wpal-widget-access'; $m4is_j69qty = $m4is_rr8f->id; $m4is_vhgf = 'widget'; $m4is_kwesq = isset($m4is_jprj8['status']) ? $m4is_jprj8['status'] : ''; $m4is_z_qyn = m4is_v98gbn::m4is_a6x52r()->m4is_ifb6(); include memberium_app()->m4is_n367bl('core-wp-asset-access-meta.php'); return; } static 
function m4is_mip3ym( $m4is_jprj8, $m4is_ojm2g ){ $m4is_kbu63_ = self::m4is_bo96y(); if( is_array($m4is_kbu63_) && ! empty($m4is_kbu63_) ){ $m4is_kwesq = 0;  foreach ($m4is_kbu63_ as $m4is_tenvhx) { $m4is_ho0w2 = $m4is_tenvhx['name']; $m4is_rhfd = ''; if( isset($m4is_ojm2g[$m4is_ho0w2]) ){ $m4is_j1vz = $m4is_tenvhx['type']; $m4is_rhfd = $m4is_ojm2g[$m4is_ho0w2];  if( $m4is_j1vz === 'select2' && !empty($m4is_rhfd) ){ $m4is_rhfd = trim($m4is_rhfd, ',');  if( $m4is_ho0w2 === 'memberships' && !empty($m4is_rhfd) ){ $m4is_f7ow = m4is_v98gbn::m4is_a6x52r()->m4is_ramz($m4is_rhfd); $m4is_rhfd = $m4is_f7ow ? $m4is_f7ow : $m4is_rhfd; $m4is_jprj8['any_membership'] = $m4is_f7ow ? 1 : 0; } } if( $m4is_ho0w2 === 'status' ){ $m4is_kwesq = (int)$m4is_rhfd; } $m4is_jprj8[$m4is_ho0w2] = $m4is_rhfd; } }  if( $m4is_kwesq === 1 ){ $m4is_jprj8['logged_in_only'] = 1; $m4is_jprj8['logged_out_only'] = 0; }  else if( $m4is_kwesq === 2 ){ $m4is_jprj8['logged_in_only'] = 0; $m4is_jprj8['logged_out_only'] = 1; $m4is_jprj8 = m4is_v98gbn::m4is_a6x52r()->m4is_la9pyi($m4is_jprj8); }  else{ $m4is_jprj8['logged_in_only'] = 0; $m4is_jprj8['logged_out_only'] = 0; $m4is_jprj8 = m4is_v98gbn::m4is_a6x52r()->m4is_la9pyi($m4is_jprj8); } } memberium_app()->m4is_sc3a(); return $m4is_jprj8; } static 
function m4is_wzan4(){ static $m4is_akl1zr = false; if ($m4is_akl1zr){ return; } m4is_v98gbn::m4is_a6x52r()->m4is_vqt6('widget'); $m4is_akl1zr = true; }  static 
function m4is_bo96y(){ static $m4is_jitjo = false; if( $m4is_jitjo ){ return $m4is_jitjo; } $m4is_jitjo = m4is_v98gbn::m4is_a6x52r()->m4is_hivk1g('widget'); return apply_filters( 'memberium/widget/fields', $m4is_jitjo ); } }
