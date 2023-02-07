<?php
/**
 * Copyright (c) 2021-2022 David J Bullock
 * Web Power and Light
 */

 class_exists('m4is_emz57o') || die(); final 
class m4is_s9q0 { private 
function __construct() { $this->m4is_ap508(); } private 
function m4is_ap508() { if (is_admin() ) { m4is_n_vod8::m4is_a6x52r(); } else { $this->m4is_gg_4(); add_action('wp_head', [$this, 'm4is_azgha']); } } 
function m4is_azgha() { $m4is__igj6 = memberium_app()->m4is_mmdrl('settings', 'facebook_app_id'); if (! empty($m4is__igj6) ) { echo '
			<script>
				window.fbAsyncInit = function() {
				FB.init({
					appId            : \'' . $m4is__igj6 . '\',
					autoLogAppEvents : true,
					xfbml            : true,
					version          : \'v4.0\'
				});
				};
			</script>
			<script async defer src="https://connect.facebook.net/en_US/sdk.js"></script>
			'; } } static 
function m4is_a6x52r() : self { static $m4is_jprj8 = false; return $m4is_jprj8 ? $m4is_jprj8 : $m4is_jprj8 = new self; } private 
function m4is_gg_4() { $m4is_mn_xj = 'm4is_fyrc'; add_shortcode('memb_fb_comments', [$m4is_mn_xj, 'm4is__461'] ); add_shortcode('memb_fb_embed_comment', [$m4is_mn_xj, 'm4is_zlvk'] ); add_shortcode('memb_fb_follow', [$m4is_mn_xj, 'm4is_vg0ni'] ); add_shortcode('memb_fb_like', [$m4is_mn_xj, 'm4is_cdc3mx'] ); add_shortcode('memb_fb_page', [$m4is_mn_xj, 'm4is_f52uv'] ); add_shortcode('memb_fb_save_button', [$m4is_mn_xj, 'm4is_g50a'] ); add_shortcode('memb_fb_send', [$m4is_mn_xj, 'm4is_cbj3'] ); add_shortcode('memb_fb_share', [$m4is_mn_xj, 'm4is_ct_zq6'] ); add_shortcode('memb_fb_video', [$m4is_mn_xj, 'm4is_e8ztku'] ); } private 
function get_app_id() { if ($this->app_id === false) { $this->app_id = memberium_app()->m4is_mmdrl('settings', 'facebook_app_id'); } return $this->app_id; } }
