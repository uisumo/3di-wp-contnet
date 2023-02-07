<?php
 class_exists( 'm4is_emz57o') || die(); final 
class m4is_gzhaw { private $m4is_bxv7u; static 
function m4is_a6x52r() : self { static $m4is_jprj8; return isset( $m4is_jprj8 ) ? $m4is_jprj8 : $m4is_jprj8 = new self; } private 
function __construct() { $this->m4is_bxv7u = memberium_app(); $this->m4is_ap508(); } private 
function m4is_ap508() { add_filter( 'fusion_builder_element_params', [$this, 'm4is_jn2xkt'], 10, 2 ); } public 
function m4is_jn2xkt( $m4is_rxc9n1, $m4is_jnrw ) { $m4is_wmzqp = [ [ 'id' => 'memberium_has_membership', 'title' => esc_html__( 'Has Memberium Membership', 'fusion-builder' ), 'type' => 'select', 'options' => [ 'in' => esc_html__( 'In', 'fusion-builder' ), 'empty' => esc_html__( 'Empty', 'fusion-builder' ), ], 'comparisons' => [ 'equal' => esc_attr__( 'Equal To', 'fusion-builder' ), 'not-equal' => esc_attr__( 'Not Equal To', 'fusion-builder' ), ], ], ]; if ( false ) { echo __LINE__, ' @ ', __METHOD__, '<br>';  echo 'shortcode = ', $m4is_jnrw, '<br>'; echo '<pre>', print_r( $m4is_rxc9n1, true), '</pre>'; } return $m4is_rxc9n1; } }
