<?php
/**
 * Copyright (c) 2012-2022 David J Bullock
 * Web Power and Light, LLC
 * https://webpowerandlight.com
 * support@webpowerandlight.com
 */

 class_exists('m4is_emz57o') || die(); 
class m4is_b_9d { private 
function __construct() {} static 
function init() { if ( defined( 'MEMBERIUM_BETA') && MEMBERIUM_BETA ) { add_action( 'admin_footer-users.php', [ __CLASS__, 'm4is_z6_3k'] ); add_action( 'admin_notices', [ __CLASS__, 'm4is__q1m3'] ); add_action( 'admin_print_styles-users.php', [ __CLASS__, 'm4is_v8jlbu'] ); add_filter( 'bulk_actions-users', [ __CLASS__, 'm4is_f3n8l'] ); add_filter( 'handle_bulk_actions-users', [ __CLASS__, 'm4is_pqdi3'], 10, 3 ); add_action( 'restrict_manage_users', [ __CLASS__, 'm4is_x_yb'] ); } } static 
function m4is_f3n8l( $m4is_sgevh ) { $m4is_sgevh['memb_bulk_tag'] = __( 'Bulk Add/Remove CRM Tag', 'memberium' ); return $m4is_sgevh; } static 
function m4is_pqdi3( $m4is_admy3, $m4is_edow, $m4is_pr3_1 ) { $m4is_w5ky4q = [ 'memb_bulk_tag_error', 'memb_bulk_tag_no_contact', 'memb_bulk_tag_success', ]; $m4is_admy3 = remove_query_arg( $m4is_w5ky4q, $m4is_admy3 );  $m4is_pr3_1 = array_filter( $m4is_pr3_1 ); $m4is_qxtoe = isset( $_GET['memb_bulk_update_tag'] ) ? (int) $_GET['memb_bulk_update_tag'] : 0;  if ( $m4is_edow == 'memb_bulk_tag' ) { $m4is_qxtoe = empty( $_REQUEST['memb_bulk_update_tag'] ) ? 0 : (int) $_REQUEST['memb_bulk_update_tag'];  if( empty( $m4is_qxtoe ) ){ $m4is_admy3 = add_query_arg( 'memb_bulk_tag_error', 'tag', $m4is_admy3 ); return $m4is_admy3; }  $m4is_ifak = $m4is_qxtoe < 0 ? 'remove' : 'add'; $m4is_ulo1 = []; $m4is_l7rgaz = 0; foreach ($m4is_pr3_1 as $m4is_q4c_xa) { $m4is_aicfp = m4is_zbyh::m4is_fhxr6($m4is_q4c_xa); if( !empty($m4is_aicfp) ){ $m4is_ulo1[] = $m4is_aicfp; } else{ ++$m4is_l7rgaz; } }  if( empty($m4is_ulo1) ){ $m4is_admy3 = add_query_arg('memb_bulk_tag_no_contact','all',$m4is_admy3 ); return $m4is_admy3; } $m4is_zv59 = memberium_app()->m4is_m6e2x($m4is_ulo1, $m4is_qxtoe); $m4is_w5ky4q = []; if( is_array($m4is_zv59) ){ $m4is_o2td = !empty($m4is_zv59['SUCCESS']) ? count($m4is_zv59['SUCCESS']) : false; $m4is_jafot = !empty($m4is_zv59['FAILURE']) ? count($m4is_zv59['FAILURE']) : false; if( $m4is_o2td ){ $m4is_w5ky4q['memb_bulk_tag_success'] = $m4is_o2td; } if($m4is_jafot){ $m4is_w5ky4q['memb_bulk_tag_error'] = $m4is_jafot; } } else{ $m4is_w5ky4q['memb_bulk_tag_error'] = count($m4is_ulo1); } if( !empty($m4is_l7rgaz) ){ $m4is_w5ky4q['memb_bulk_tag_no_contact'] = (int) $m4is_l7rgaz; } if( !empty($m4is_w5ky4q) ){ $m4is_admy3 = add_query_arg($m4is_w5ky4q, $m4is_admy3); } } return $m4is_admy3; } static 
function m4is_x_yb() { $m4is_o30y = __( 'Select CRM Tag', 'memberium' );  echo "<div class='memb_bulk_update_tag_wrap'>", "\n";  echo '<select id="memb_bulk_update_tag" name="memb_bulk_update_tag" class="memb_bulk_update_tag" placeholder="' . $m4is_o30y . '">', "\n"; echo '<option value="0">none</option>', "\n"; echo '<option value="1">foo</option>', "\n"; echo '<option value="2">bar</option>', "\n"; echo '<option value="3">baz</option>', "\n"; echo '</select>', "\n"; echo "</div>", "\n"; } static 
function m4is__q1m3() { $m4is__4sba = 'memb_bulk_tag_'; $m4is_kqmsi = $m4is__4sba . 'success'; $m4is_z2mr = $m4is__4sba . 'error'; $m4is_b7mt = $m4is__4sba . 'no_contact'; $m4is_fgxy = ''; $m4is_j1vz = ''; if( empty( $_REQUEST[$m4is_kqmsi] ) && empty( $_REQUEST[$m4is_z2mr] ) && empty( $_REQUEST[$m4is_b7mt] ) ){ return; } $m4is_o2td = empty( $_REQUEST[$m4is_kqmsi] ) ? false : $_REQUEST[$m4is_kqmsi];  $m4is_a6g9qj = empty( $_REQUEST[$m4is_z2mr] ) ? false : $_REQUEST[$m4is_z2mr]; $m4is_l7rgaz = empty( $_REQUEST[$m4is_b7mt] ) ? false : $_REQUEST[$m4is_b7mt]; if( $m4is_o2td ) { $m4is_j1vz = 'success'; if( (int) $m4is_o2td > 1 ){ $m4is_fgxy .= sprintf( __( '%s contacts have been updated.', 'memberium' ), $m4is_o2td ); } else{ $m4is_fgxy .= __( '1 contact has been updated.', 'memberium' ); } } if($m4is_a6g9qj){ $m4is_j1vz = empty($m4is_j1vz) ? 'error' : $m4is_j1vz; $m4is_fgxy .= !empty($m4is_fgxy) ? "<br>" : ""; if( $m4is_a6g9qj === 'tag' ){ $m4is_fgxy .= __( 'No Tag selected.', 'memberium' ); } else{ if( (int)$m4is_a6g9qj > 1 ){ $m4is_fgxy .= sprintf(__( '%s contacts not updated.', 'memberium' ), $m4is_a6g9qj); } else{ $m4is_fgxy .= __( '1 contact not updated.', 'memberium' ); } } }  if( $m4is_l7rgaz ){ $m4is_j1vz = empty( $m4is_j1vz ) ? 'error' : $m4is_j1vz; $m4is_fgxy .= empty( $m4is_fgxy ) ? '' : '<br>'; if( $m4is_l7rgaz === 'all' ){ $m4is_fgxy .= __( 'None of the selected users have an Infusionst Contact ID.', 'memberium' ); } else if( (int) $m4is_l7rgaz > 1 ){ $m4is_fgxy .= sprintf( __( '%s selected users do not have a contact ID.', 'memberium' ), $m4is_l7rgaz ); } else{ $m4is_fgxy .= __( '1 selected User does not have a contact ID.', 'memberium' ); } } if( ! empty( $m4is_fgxy ) ) { echo "<div class=\"notice notice-{$m4is_j1vz} is-dismissible\">"; echo "<h2>Memberium " . __( 'Bulk Tag Contacts', 'memberium' ) . "</h2>"; echo "<p>{$m4is_fgxy}</p>"; echo "</div>"; } return; } static 
function m4is_v8jlbu() { ?>
		<style id="memb_bulk_contact_tags_style">
			/*
			.memb_hidden { display:none; }
			*/
			.memb_bulk_update_tag { width:200px; }
			.memb_bulk_update_tag_wrap { float:left; margin-right:6px; max-width:12.5rem; };
		</style>
		<?php
 } static 
function m4is_z6_3k() { $m4is_q4i2j = []; $m4is_znf9 = memberium_app()->m4is_ee0h(true)['mc']; foreach ($m4is_znf9 as $m4is_b40e_m => $m4is_w9feq2 ) { $m4is_q4i2j[] = [ 'id' => $m4is_b40e_m, 'text' => 'Add ' . $m4is_w9feq2 . ' (' . $m4is_b40e_m . ')' ]; $m4is_q4i2j[] = [ 'id' => '-' . $m4is_b40e_m, 'text' => 'Remove ' . $m4is_w9feq2 . ' (-' . $m4is_b40e_m . ')' ]; } ?>
		<script id="memb_bulk_contact_tags_script">
		(function( $ ) {
			$( document ).ready( function() {
				var bulktaglist = <?php echo json_encode($m4is_q4i2j) ?>,
					$changedMembSel = null;
				// Move Inputs Position
				$('.memb_bulk_update_tag_wrap').each(function(i, $wrap) {
					var $parent  = $($wrap).closest(".tablenav"),
						$input   = $('input', $wrap),
						selector = $parent.hasClass('top') ? '#bulk-action-selector-top' : '#bulk-action-selector-bottom';
						$($wrap).insertAfter( $(selector) );
						$($input).wpalSelect2({
						data        : bulktaglist,
						placeholder : $($input).attr("placeholder")
					}).on('change', function(e) {
						if( $changedMembSel !== e.target ){
							membBulkUpdateTagChange(e.target, e.val);
						}
					});
				});

				// Action Select Changes
				$('select[name="action"], select[name="action2"]').on('change', function(e) {
					if( this.value === 'memb_bulk_tag' ){
						$('.memb_bulk_update_tag_wrap').removeClass('memb_hidden');
					}
					else{
						$('.memb_bulk_update_tag_wrap').addClass('memb_hidden');
					}
				});

				var membBulkUpdateTagChange = function ( $el, val ){
					$('.memb_bulk_update_tag').each(function(i, $input) {
						if( $input !== $el ){
							if( $input.value !== undefined && val !== $input.value ){
								$input.value = val;
								$($input).trigger('change');
							}
						}
						else {
							$changedMembSel = $el;
						}
					});
				};
			});
		})( jQuery );
		</script>
		<?php
 } }
