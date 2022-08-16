<?php
/**
 * Copyright (c) 2017-2020 David J Bullock
 * Web Power and Light, LLC
 * https://webpowerandlight.com
 * support@webpowerandlight.com
 *
 */

 if (!defined('ABSPATH' ) ) { die(); } echo '<form method="POST" action="">'; wp_nonce_field(MEMBERIUM_LIB, 'memberium_options_nonce' ); $vwplrd4c = get_option('memberium_extensions', array() ); $vwplq1e4r = wplb_vo(); $vwplz97jd = array(); $vwplelob86 = wplz8bid::wplvf1d('settings'); foreach($vwplrd4c as $vwplyq9i7o => $vwplcjpa) { if (! array_key_exists($vwplyq9i7o, $vwplq1e4r) ) { unset($vwplrd4c[$vwplyq9i7o]); } } ksort($vwplrd4c); foreach($vwplq1e4r as $vwplm1dqej => $vwplg38x51) { $vwplf_3k79 = dirname(MEMBERIUM_LIB . $vwplg38x51) . '/info.txt'; if (file_exists($vwplf_3k79) ) { $vwplz97jd[] = $vwplf_3k79; } } echo '<ul>'; echo '<h3>Optional Extensions</h3>'; foreach ($vwplz97jd as $vwplu2t0ah => $vwplg38x51 ) { $vwplhe34 = dirname($vwplg38x51) . '/info.txt'; $vwplz4g7n = get_plugin_data($vwplhe34, false, false ); $vwplxmw46 = basename(dirname($vwplg38x51) ); $vwplzv20z = isset($vwplrd4c[$vwplxmw46] ) ? $vwplrd4c[$vwplxmw46] : 1; if (! empty($vwplz4g7n['Name'] ) ) { echo wpljwbf2::wplsok6r($vwplz4g7n['Name'], "extensions[{$vwplxmw46}]", $vwplz4g7n['AuthorURI'], (bool) $vwplzv20z ); } } echo '</ul>'; echo '<ul>'; echo '<h3>Optional Settings</h3>'; wpljwbf2::wpls_l9( 'Facebook App ID', 'facebook_app_id', $vwplelob86['facebook_app_id'], array('help_id' => 2571, 'style' => 'text-align:left;width:100px;' ) ); wpljwbf2::wpls_l9( 'Spiffy Subdomain', 'spiffy_subdomain', $vwplelob86['spiffy_subdomain'], array( 'help_id' => 0000, 'pattern' => '[A-Za-z0-9][A-Za-z0-9\-]+', 'style' => 'text-align:left;width:100px;', 'placeholder' => 'Enter your Spiffy Subdomain here', ) ); echo '</ul>'; echo '<p><input type="submit" value="Update" class="button-primary"></p>'; echo '</form>';
