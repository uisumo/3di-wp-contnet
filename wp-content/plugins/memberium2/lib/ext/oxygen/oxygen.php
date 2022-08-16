<?php
/**
 * Copyright (c) 2020 David J Bullock
 * Web Power and Light
 */

 if (! defined('ABSPATH') ) { die(); } if (! is_admin() ) { new wplrveuw6; } class wplrveuw6 { private $safe_tags = array( 'ct_code_block', 'ct_headlines', 'ct_link_button', 'ct_link', 'ct_text_block', 'oxy_rich_text', ); function __construct() { add_action('wp', array($this, 'wplowezq9'), 20); add_filter('do_shortcode_tag', array($this, 'wplmk3a'), PHP_INT_MAX, 4 ); } function wplowezq9() { $this->safe_tags = apply_filters('memberium/oxygen/tags', $this->safe_tags); } function wplmk3a($vwpltlkdcw, $vwpltmveju, $vwply5pvh_, $vwplyay7p) { $vwplp_ca = (strpos($vwpltmveju, 'ct_section') === 0); if (! $vwplp_ca && in_array($vwpltmveju, $this->safe_tags)) { $vwplp_ca = true; } return $vwplp_ca ? do_shortcode($vwpltlkdcw) : $vwpltlkdcw; } }
