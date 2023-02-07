<?php
  
class m4is_y7j3 extends TCB\ConditionalDisplay\Field {  public static 
function get_entity() { return 'memberium'; }  public static 
function get_key() { return 'memberium_membership'; }  public static 
function get_label() { return 'Has Any Memberships'; }  static 
function get_conditions() { return [ 'autocomplete' ]; }  public 
function get_value( $m4is_sxfbjo ) { return isset( $m4is_sxfbjo['memb_user']['membership_tags'] ) ? array_filter( explode( ',', $m4is_sxfbjo['memb_user']['membership_tags'] ) ) : []; }  public static 
function get_options( $m4is_vzxyb = [], $m4is_l284 = '' ) { $m4is_fdf0v = m4is_axf1p7::m4is_a6x52r()->m4is_ki2zc( $m4is_l284 ); if ( ! empty( $m4is_vzxyb ) ) { $m4is__ph0v = array_filter( $m4is_fdf0v, function( $m4is_b40e_m ) use ( $m4is_vzxyb ) { return in_array( $m4is_b40e_m, $m4is_vzxyb ); }, ARRAY_FILTER_USE_KEY ); $m4is_fdf0v = $m4is__ph0v; } $m4is_cesjr = []; foreach( $m4is_fdf0v as $m4is_b40e_m => $m4is_tyoak ) { $m4is_cesjr[] = [ 'value' => (string) $m4is_b40e_m, 'label' => sprintf( "%s (%s)", $m4is_tyoak, $m4is_b40e_m ), ]; } return $m4is_cesjr; }  public static 
function get_autocomplete_placeholder() { return 'Search Tags'; }  public static 
function get_display_order() { return 10; } }
