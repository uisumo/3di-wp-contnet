<?php
/**
 * Copyright (c) 2012-2022 David J Bullock
 * Web Power and Light
 */

 class_exists('m4is_p7r6h') || die(); final 
class m4is_gnbz {  
function m4is_hthu() { global $post; $m4is_znf9 = m4is_p7r6h::m4is_a6x52r()->m4is_zx1ak($post->ID); echo '<label for="_memberium_access_tag">', _e("Access Tag", 'memberium'), ':</label> '; echo '<input name="_memberium_access_tag" class="taglistdropdown" style="width:100%; max-width:100%" value="', $m4is_znf9['main'], '"><br /><br />'; echo '<label for="_memberium_trial_tag">', _e("Trial Tag", 'memberium'), ':</label> '; echo '<input name="_memberium_trial_tag" class="taglistdropdown" style="width:100%; max-width:100%" value="', $m4is_znf9['trial'], '"><br /><br />'; echo '<label for="_memberium_canc_tag">', _e("Cancel Tag", 'memberium'), ':</label> '; echo '<input name="_memberium_canc_tag" class="taglistdropdown" style="width:100%; max-width:100%" value="', $m4is_znf9['canc'], '"><br /><br />'; echo '<label for="_memberium_payf_tag">', _e("Payment Failure Tag", 'memberium'), ':</label> '; echo '<input name="_memberium_payf_tag"  class="taglistdropdown" style="width:100%; max-width:100%" value="', $m4is_znf9['payf'], '"><br /><br />'; } 
function m4is_vx472w($m4is__xysg) { if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) { return; } if (! $m4is__xysg) { return; } if (! current_user_can('edit_posts', $m4is__xysg) ) { return; } $m4is_dhrs = [ '_memberium_access_tag', '_memberium_canc_tag', '_memberium_payf_tag', '_memberium_trial_tag', ]; foreach($m4is_dhrs as $m4is_ap3_) { if (isset($_POST[$m4is_ap3_]) ) { update_post_meta($m4is__xysg, $m4is_ap3_, trim($_POST[$m4is_ap3_], ',') ); } } } 
function m4is_gopgz() { add_meta_box('memberium\edd\actions','Memberium for EDD', [$this, 'm4is_hthu'], 'download', 'side'); add_action('save_post_download', [$this, 'm4is_vx472w']); } private 
function __construct() { add_action('admin_init', [$this, 'm4is_gopgz']); } static 
function m4is_a6x52r() : self { static $m4is_jprj8 = false; return $m4is_jprj8 ? $m4is_jprj8 : $m4is_jprj8 = new self; } }
