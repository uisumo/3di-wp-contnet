<?php
 /**
 * Copyright (c) 2016-2020 David J Bullock
 * Web Power and Light, LLC
 * https://webpowerandlight.com
 * support@webpowerandlight.com
 *
 */

 if (!defined('ABSPATH') ) { die(); } add_action('admin_notices', 'wpluxhcdj'); function wpluxhcdj() { $vwpluap7g = '5.4'; $vwplia5gfb = false; $vwplbwir = version_compare(phpversion(), $vwpluap7g, '<'); $vwpldlmyk = ! function_exists('curl_version'); $vwplbdx0s = ! extension_loaded('IonCube Loader'); $vwplia5gfb = $vwplbwir || $vwplbdx0s; if ($vwplia5gfb) { echo '<div class="notice notice-error" style="height:200px;">'; echo '<img style="margin-right:20px;margin-top:10px;margin-bottom:60px;border-radius:10px;" src="https://memberium.com/wp-content/uploads/2014/09/memberium-home-illustration6.png" height=85 width=62 align=left />'; echo '<h3>Memberium Install Alert</h3>'; echo '<p style="color:red;font-weight:bold;">Memberium has been temporarily disabled.</p>'; if ($vwplbwir) { echo '<p><strong>PHP ', $vwpluap7g, ' or newer is required.</strong>  You are running PHP v', phpversion(), '.</p>'; } if ($vwpldlmyk) { echo '<p><strong>The PHP CURL extension is required</strong>, but is not installed or available.</p>'; } if ($vwplbdx0s) { echo '<p><strong>The IonCube PHP extension is required</strong>, but is not installed or available.</p>'; } echo '<p>'; echo '<strong>PHP Version:</strong> ', phpversion(), ' / ', php_sapi_name(), '<br>'; echo '<strong>Path:</strong> ', ABSPATH, '<br>'; echo '<strong>System:</strong> ', php_uname(), '<br>'; echo '<strong>Modules Loaded:</strong> ', implode(', ', get_loaded_extensions() ), '<br>'; echo '</p>'; echo '<p><a target="_blank" href="https://www.memberium.com/?p=11721">Click Here to Learn More</a></p>'; echo '</div>'; } }
