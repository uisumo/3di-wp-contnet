<?php
/**
 * Copyright (c) 2017-2022 David J Bullock
 * Web Power and Light, LLC
 * https://webpowerandlight.com
 * support@webpowerandlight.com
 */

 class_exists( 'm4is_zvyj' ) || die(); ?>
<style>
	.columns {
		float:left;
		width:30%;
		display:inline-block;
		text-align:left;
		margin-right:25px;
		min-width:300px;
	}
</style>
<?php
 m4is_nn8y::m4is_y3z1(); final 
class m4is_nn8y { private $m4is_y79zsw; static 
function m4is_y3z1() : self { static $m4is_jprj8; return isset( $m4is_jprj8 ) ? $m4is_jprj8 : $m4is_jprj8 = new self; } private 
function __construct() { $this->m4is_y79zsw = m4is_zvyj::m4is_a6x52r()->m4is_vwja7v(); memberium_app()->m4is_v64c('view_integrations' ); $this->m4is_giqcm0(); } private 
function m4is_giqcm0() { echo '<div style="width:100%;border-color:#000;">'; echo '<div class="columns">'; echo '<h3>Active Modules</h3>'; echo '<p class="indented">'; $this->m4is_omnk6b(); echo '</p>'; echo '<h3>Activated Integrations</h3>'; echo '<p class="indented">'; $this->m4is_qgwpjk(); echo '</p>'; echo '</div>'; echo '<div class="columns">'; echo '<h3>Potential conflicts</h3>'; echo '<p class="indented">'; $this->m4is_cc8p(); echo '</p>';  echo '</div>'; echo '</div>'; echo '<p></p>'; } private 
function m4is_omnk6b() { $m4is_its6y = apply_filters( 'memberium/modules/active/names', [] ); if ( ! empty( $m4is_its6y ) ) { sort( $m4is_its6y ); foreach( $m4is_its6y as $m4is_ho0w2 ) { printf( '<strong class="goodplugin">%s</strong><br>', $m4is_ho0w2 ); } } } private 
function m4is_qgwpjk() { $m4is_in0ti = ! empty( $this->m4is_y79zsw['detected'] ) && is_array( $this->m4is_y79zsw['detected'] ); if ( $m4is_in0ti ) { foreach ( $this->m4is_y79zsw['detected'] as $m4is__i1sg ) { $m4is_xlns = isset( $m4is__i1sg['help'] ) ? m4is__95_::m4is_d6u3( $m4is__i1sg['help'] ) : ''; printf( '<span class="%splugin">%s</span> %s<br />', $m4is__i1sg['class'], $m4is__i1sg['name'], $m4is_xlns ); } } else { echo '<span>None</span><br />'; } } private 
function m4is_cc8p() { $m4is_in0ti = ! empty( $this->m4is_y79zsw['problem'] ) && is_array( $this->m4is_y79zsw['problem'] ); if ( $m4is_in0ti ) { foreach ( $this->m4is_y79zsw['problem'] as $m4is__i1sg ) { $m4is_xlns = empty( $m4is__i1sg['help'] ) ? '' : m4is__95_::m4is_d6u3( $m4is__i1sg['help'] ); printf( '<span class="badplugin %splugin">%s</span> %s<br />', $m4is__i1sg['class'], $m4is__i1sg['name'], $m4is_xlns ); } } else { echo 'No known conflicts detected.<br />'; } } private 
function m4is_za4f() { $m4is_in0ti = ! empty( $this->m4is_y79zsw['available'] ) && is_array( $this->m4is_y79zsw['available'] ); if ( $m4is_in0ti ) { foreach ( $this->m4is_y79zsw['available'] as $m4is__i1sg ) { $m4is_xlns = empty( $m4is__i1sg['help'] ) ? '' : m4is__95_::m4is_d6u3( $m4is__i1sg['help'] ); printf( '%s %s<br />', $m4is__i1sg['name'], $m4is_xlns ); } } else { echo 'No additional available integrations.<br>'; } } }
