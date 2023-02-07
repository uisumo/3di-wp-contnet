<?php
  
class m4is_bzal extends TCB\ConditionalDisplay\Field {  public static 
function get_entity() { return 'memberium'; }  public static 
function get_key() { return 'memberium_tag'; }  public static 
function get_label() { return 'Has Any Tags'; }  static 
function get_conditions() { return [ 'autocomplete' ]; } static 
function is_boolean() { return false; }  public 
function get_value( $m4is_sxfbjo ) { return isset( $m4is_sxfbjo['memb_user']['tags'] ) ? array_filter( explode( ',', $m4is_sxfbjo['memb_user']['tags'] ) ) : []; }  public static 
function get_options( $m4is_vzxyb = [], $m4is_l284 = '' ) { $m4is_znf9 = m4is_axf1p7::m4is_a6x52r()->m4is_psb2( $m4is_l284 ); if ( ! empty( $m4is_vzxyb ) ) { $m4is_s5vw7 = array_filter( $m4is_znf9, function( $m4is_w9feq2 ) use ( $m4is_vzxyb ) { return in_array( $m4is_w9feq2->id, $m4is_vzxyb ); } ); $m4is_znf9 = $m4is_s5vw7; } $m4is_cesjr = []; foreach( $m4is_znf9 as $m4is_w9feq2 ) { $m4is_cesjr[] = [ 'value' => (string) $m4is_w9feq2->id, 'label' => sprintf( "%s (%s)", $m4is_w9feq2->name, $m4is_w9feq2->id ), ]; } return $m4is_cesjr; }  public static 
function get_autocomplete_placeholder() { return 'Search Tags'; }  public static 
function get_display_order() { return 10; } }
