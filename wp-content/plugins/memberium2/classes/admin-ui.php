<?php
/**
 * Copyright (c) 2018-2020 David J Bullock
 * Web Power and Light, LLC
 * https://webpowerandlight.com
 * support@webpowerandlight.com
 *
 */

 if (!defined('ABSPATH') ) { die(); } final class wpljwbf2 {  const HELP_URL = 'https://memberium.com/'; static $notices = array(); static function wplypewkt($vwplopnf, $vwplxo3wtv = 'What\'s this?') { $vwpln208 = ''; if ($vwplopnf == (int) $vwplopnf && (int) $vwplopnf > 0) { $vwpln208 =' (<strong><a href="' . self::HELP_URL .'?page_id=' . $vwplopnf . '" target="_blank">' . $vwplxo3wtv . '</a></strong>) '; } return $vwpln208; } static function wplt5xt($vwplaco6 = '', $vwplso1pw = '', $vwplph268z = 0, $vwplgitq = array() ) { $vwplph268z = (int) $vwplph268z; $vwplsb_pf = array( 'id' => $vwplso1pw, 'help_id' => 0, 'min' => 0, 'max' => 999999, 'size' => 8, 'step' => 1, 'class' => '', 'style' => '', 'units' => '', ); $vwplgitq = wp_parse_args($vwplgitq, $vwplsb_pf); $vwplgitq['size'] -= (int) $vwplgitq['size']; $vwplgitq['step'] -= (int) $vwplgitq['step']; echo "<li><label>{$vwplaco6}</label>", "<input type=number id='{$vwplgitq['id']}' name='{$vwplso1pw}' min={$vwplgitq['min']} max={$vwplgitq['max']} size={$vwplgitq['size']} step={$vwplgitq['step']} value='{$vwplph268z}' class='{$vwplgitq['class']}' style='{$vwplgitq['style']}' > {$vwplgitq['units']}", self::wplypewkt($vwplgitq['help_id']), "</li>\n\n"; } static function wplsok6r($vwplaco6, $vwplso1pw, $vwplukq4tz = 0, $vwplmnovmz = false) { $vwpldhz7fe = $vwplmnovmz ? 'checked=checked' : ''; echo "<li><label>{$vwplaco6}</label>", "<input type=hidden value=0 name='{$vwplso1pw}'>", "<label style='width:75px;'><input type=checkbox value=1 class=ios-switch name='{$vwplso1pw}' {$vwpldhz7fe} /><div class=switch></div></label>", self::wplypewkt($vwplukq4tz), "</li>\n\n"; } static function wplcst4($vwplso1pw = '', $vwplph268z = false, $vwplgitq = array() ) { if (empty($vwplso1pw) ) { return; } $vwplsb_pf = array( 'label' => '', 'echo' => true, 'id' => $vwplso1pw, 'helpid' => 0, 'autofocus' => false, 'class' => '', 'disabled' => false, 'form' => '', 'required' => false, 'style' => '', ); $vwplgitq = wp_parse_args($vwplgitq, $vwplsb_pf); $output = ''; $output .= '<input type="hidden" value="0" name="' . $vwplso1pw . '">'; $output .= '<label style="width:75px;"><input type="checkbox" value="1" class="ios-switch" name="' . $vwplso1pw . '" ' . ($vwplph268z == 1 ? ' checked="checked" ' : '') . ' '; $output .= '/><div class="switch"></div></label>'; $output .= wpljwbf2::wplypewkt($vwplgitq['helpid']) . "</li>\n\n"; if ($vwplgitq['echo']) { echo $output; } return $output; } static function wplves0($vwplso1pw = '', $vwplnkj9d_ = array(), $vwplpe17 = '', $vwplgitq = array() ) { if (empty($vwplnkj9d_) || empty($vwplso1pw) ) { return; } if (! is_array($vwplpe17) ) { $vwplpe17 = explode(',', $vwplpe17); } $vwplsb_pf = array( 'autofocus' => false, 'class' => '', 'disabled' => false, 'case_sensitive' => false, 'echo' => true, 'form' => '', 'id' => $vwplso1pw, 'multiple' => false, 'required' => false, 'size' => 1, 'style' => '', ); $vwplgitq = wp_parse_args($vwplgitq, $vwplsb_pf); $vwpltlkdcw = '<input type="hidden" name="' . $vwplso1pw . '" value=" ">'; $vwpltlkdcw .= '<select name="' . $vwplso1pw . '" '; if ($vwplgitq['autofocus']) { $vwpltlkdcw .= ' autofocus="autofocus"'; } if ($vwplgitq['disabled']) { $vwpltlkdcw .= ' disabled="disabled"'; } if ($vwplgitq['multiple']) { $vwpltlkdcw .= ' multiple="multiple"'; } if ($vwplgitq['required']) { $vwpltlkdcw .= ' required="required"'; } if ($vwplgitq['size']) { $vwpltlkdcw .= ' size="' . (int) $vwplgitq['size'] . '"'; } if (! empty($vwplgitq['class']) ) { $vwpltlkdcw .= ' class="' . $vwplgitq['class'] . '"'; } if (! empty($vwplgitq['style']) ) { $vwpltlkdcw .= ' style="' . $vwplgitq['style'] . '"'; } if (! empty($vwplgitq['form']) ) { $vwpltlkdcw .= ' form="' . $vwplgitq['form'] . '"'; } if (! empty($vwplgitq['id']) ) { $vwpltlkdcw .= ' id="' . $vwplgitq['id'] . '"'; } $vwpltlkdcw .= ' size="' . $vwplgitq['size'] . '">'; foreach($vwplnkj9d_ as $vwplph268z => $vwplaco6) { $vwpl_ycm2b = false; foreach($vwplpe17 as $vwplmkypa) { if ($vwplgitq['case_sensitive']) { $vwpl_ycm2b = $vwpl_ycm2b || (bool) ($vwplph268z == $vwplmkypa); } else { $vwpl_ycm2b = $vwpl_ycm2b || (bool) (0 === strcasecmp($vwplph268z, $vwplmkypa) ); } } $vwpltlkdcw .= '<option value="' . $vwplph268z . '" ' . ($vwpl_ycm2b ? ' selected="selected" ' : '') . '>' . $vwplaco6 . '</option>'; } $vwpltlkdcw .= '</select>'; if ($vwplgitq['echo']) { echo "\n\n", $vwpltlkdcw, "\n\n"; } else { return "\n\n" . $vwpltlkdcw . "\n\n"; } } static function wplm57_u1($vwplso1pw, $vwplmh6qr = array() ) { $vwplmh6qr['help_text'] = isset($vwplmh6qr['help_text']) ? $vwplmh6qr['help_text'] : false; $vwplmh6qr['type'] = ! empty($vwplmh6qr['type']) ? $vwplmh6qr['type'] : 'text'; $vwplmh6qr['id'] = ! empty($vwplmh6qr['id']) ? $vwplmh6qr['id'] : $vwplso1pw; $vwplmh6qr['name'] = ! empty($vwplmh6qr['name']) ? $vwplmh6qr['name'] : $vwplso1pw; $vwplmh6qr['required'] = ! empty($vwplmh6qr['required']) ? true : false; $vwplqzdlu3 = array( 'placeholder', 'size', 'style', 'class', 'value', 'label', 'type', 'name', 'wrapper_class', 'help_id', 'min', 'max', 'step' ); foreach($vwplqzdlu3 as $vwply17edn) { $vwplmh6qr[$vwply17edn] = isset($vwplmh6qr[$vwply17edn]) ? $vwplmh6qr[$vwply17edn] : ''; } $vwplqzdlu3 = array('custom'); foreach($vwplqzdlu3 as $vwply17edn) { $vwplmh6qr[$vwply17edn] = isset($vwplmh6qr[$vwply17edn]) ? $vwplmh6qr[$vwply17edn] : array(); } if (! empty($vwplmh6qr['custom']) ) { foreach ($vwplmh6qr['custom'] as $vwplyq9i7o => $vwplcjpa){ $vwplmh6qr['custom'][$vwplyq9i7o] = esc_attr($vwplyq9i7o) . '="' . esc_attr($vwplcjpa) . '" '; } } if ($vwplmh6qr['label']) { echo '<p class="', $vwplmh6qr['wrapper_class'], '">'; echo '<label for="', esc_attr($vwplmh6qr['id']), '">', wp_kses_post($vwplmh6qr['label']), '</label>', "\n"; } echo '<input '; $vwplqzdlu3 = array('placeholder', 'size', 'style', 'class', 'value', 'label', 'type', 'name', 'min', 'max', 'step'); echo $vwplmh6qr['required'] ? ' required=required ' : ''; foreach($vwplqzdlu3 as $vwply17edn) { echo ( ($vwplmh6qr[$vwply17edn] <> '') ? $vwply17edn . '="'. esc_attr($vwplmh6qr[$vwply17edn]) . '" ' : ''); } foreach($vwplmh6qr['custom'] as $vwply17edn) { echo $vwply17edn; } echo '/>', "\n"; echo wpljwbf2::wplypewkt($vwplmh6qr['help_id'], $vwplmh6qr['help_text']); if ($vwplmh6qr['label']) { echo '</p>'; } } static function wpln84ebf($vwplaco6 = '', $vwplso1pw = '', $vwplph268z = '', $vwplr7xq5 = '', $vwplgitq = array() ) { $vwplsb_pf = array( 'help_id' => 0, 'style' => '', 'class' => '', 'naked' => false, 'id' => $vwplso1pw, 'multiple' => '', 'units' => '', ); $vwplgitq = wp_parse_args($vwplgitq, $vwplsb_pf); $vwplgitq['multiple'] = empty($vwplgitq['multiple']) ? '' : 'multiple'; if (! $vwplgitq['naked']) echo '<li>'; echo "<label for='{$vwplso1pw}'>{$vwplaco6}</label>", "<input value='{$vwplph268z}' type=hidden id='{$vwplgitq['id']}' name='{$vwplso1pw}' {$vwplgitq['multiple']} class='dropdown {$vwplr7xq5} {$vwplgitq['class']}' style='{$vwplgitq['style']}' /> {$vwplgitq['units']} ", wpljwbf2::wplypewkt($vwplgitq['help_id']); if (! $vwplgitq['naked']) echo '</li>'; } static function wplnclv($vwplaco6 = '', $vwplso1pw = '', $vwplph268z = '', $vwplnkj9d_ = array(), $vwplgitq = array() ) { $vwplsb_pf = array( 'help_id' => 0, 'style' => '', 'class' => 'basic-single', 'id' => $vwplso1pw, ); $vwplgitq = wp_parse_args($vwplgitq, $vwplsb_pf); echo "<li><label>{$vwplaco6}</label>", "<select id='{$vwplgitq['id']}' class='basic-single {$vwplgitq['class']}' name='{$vwplso1pw}' style='width:250px;'>"; foreach ($vwplnkj9d_ as $vwplopnf => $vwplw4mstc) { $selected = ($vwplopnf == $vwplph268z) ? 'selected=selected' : ''; echo "<option value='{$vwplopnf}' {$selected}>{$vwplw4mstc}</option>"; } echo '</select>', wpljwbf2::wplypewkt($vwplgitq['help_id']), "</li>\n\n"; } static function wpls_l9($vwplaco6 = '', $vwplso1pw = '', $vwplph268z = '', $vwplgitq = array() ) { $vwplsb_pf = array( 'class' => '', 'help_id' => 0, 'id' => $vwplso1pw, 'placeholder' => '', 'size' => 40, 'style' => '', 'type' => 'text', 'disabled' => false, 'pattern' => '', ); $vwplgitq = wp_parse_args($vwplgitq, $vwplsb_pf); $vwplgitq['size'] = (int) $vwplgitq['size']; $vwplgitq['disabled'] = $vwplgitq['disabled'] ? ' disabled=disabled ' : ''; $vwplgitq['pattern'] = $vwplgitq['pattern'] ? " pattern='{$vwplgitq['pattern']}' " : ''; echo "<li><label>{$vwplaco6}</label>", "<input type='{$vwplgitq['type']}' id='{$vwplgitq['id']}' {$vwplgitq['pattern']} name='{$vwplso1pw}' placeholder='{$vwplgitq['placeholder']}' size='{$vwplgitq['size']}' value='{$vwplph268z}' {$vwplgitq['disabled']}>", self::wplypewkt($vwplgitq['help_id']), "</li>\n\n"; } static function wplo_51s($vwplph268z = 0, $vwpllmesgz = 0, $vwpld87dmz = 0, $vwplgitq = array() ) { $vwplsb_pf = array( 'good' => 'font-weight:bold;color:green;', 'ok' => 'font-weight:bold;color:gold;', 'bad' => 'font-weight:bold;color:red;' ); $vwplgitq = wp_parse_args($vwplgitq, $vwplsb_pf); $vwplc2bvs = 'good'; if ($vwplph268z < $vwpld87dmz) { $vwplc2bvs = 'ok'; } elseif ($vwplph268z > $vwpllmesgz) { $vwplc2bvs = 'bad'; } return "<span style='{$vwplgitq[$vwplc2bvs]}'>{$vwplph268z}</span>"; } static function wpl_c867($vwplbtiwa_) { if (empty($vwplbtiwa_) ) { $vwplyio4f = 'Never'; } else { $vwplbtiwa_ = time() - $vwplbtiwa_; $vwplpg5x = new \DateTime('@0'); $vwpljhyxp5 = new \DateTime("@$vwplbtiwa_"); $vwplzyzq6 = $vwplpg5x->diff($vwpljhyxp5); $vwplyio4f = "{$vwplzyzq6->s} seconds"; if ($vwplzyzq6->i) { $vwplyio4f = "{$vwplzyzq6->i} minutes, {$vwplyio4f}"; } if ($vwplzyzq6->h) { $vwplyio4f = "{$vwplzyzq6->h} hours, {$vwplyio4f}"; } if ($vwplzyzq6->d) { $vwplyio4f = "{$vwplzyzq6->d} days, {$vwplyio4f}"; } if ($vwplzyzq6->m) { $vwplyio4f = "{$vwplzyzq6->m} months, {$vwplyio4f}"; } if ($vwplzyzq6->y) { $vwplyio4f = "{$vwplzyzq6->y} years, {$vwplyio4f}"; } } return $vwplyio4f; } static function wplg2sle($vwplopnf) { if (strpos($_SERVER['REQUEST_URI'], '?') === false) { $vwplzfde = '?'; } else { $vwplzfde = '&'; } return $_SERVER['REQUEST_URI'] . $vwplzfde . 'memberium_ignore_notice=' . urlencode($vwplopnf); } static function wplc1on7($vwplygr2, $vwplgm_9s = 'wpllk1g') { self::$notices[] = array('type' => $vwplgm_9s, 'message' => $vwplygr2); } static function wplyb40j1() { if (is_array(self::$notices) ) { foreach (self::$notices as $vwplyq9i7o => $vwplqjl_) { switch ($vwplqjl_['type']) { case 'wpllk1g': $vwplkyjbz = 'updated'; break; case 'error': $vwplkyjbz = 'error'; break; } echo '<div class="', $vwplkyjbz, '"><p>', $vwplqjl_['message'], '</p></div>'; unset(self::$notices[$vwplyq9i7o]); } } } static function wplb9z47() { $vwplxig6 = array(); $vwploi5790 = get_post_types(array('public' => true) ); if (is_array($vwploi5790) ) { foreach($vwploi5790 as $vwplo43m) { $vwplxig6[] = $vwplo43m; } } return $vwplxig6; } static function wplv1_wlp() { $vwplexo_ = array( 'attachment', 'et_pb_layout', 'llms_engagement', 'llms_membership', 'llms_question', 'nomination', 'sfwd-essays', 'shop_coupon', 'shop_order', 'shop_subscription', 'submission', 'um_directory', 'um_form', ); $vwploi5790 = get_post_types(array('public' => false) ); if (is_array($vwploi5790) ) { foreach($vwploi5790 as $vwplo43m) { if (! in_array($vwplo43m, array('memb_shortcodeblocks', 'partials') ) ) { $vwplexo_[] = $vwplo43m; } } } unset($vwploi5790, $vwplo43m); $vwplexo_ = apply_filters('memberium_unenhanced_posts', $vwplexo_); return $vwplexo_; } static function wplhhef() { $vwpldaph = $_GET; $vwplcltpy = isset($vwpldaph['post']) ? $vwpldaph['post'] : 0; $vwplo43m = isset($vwpldaph['post_type']) ? $vwpldaph['post_type'] : get_post_type($vwplcltpy); if (empty($vwplo43m) ) { $vwplo43m = 'post'; } return $vwplo43m; } static function wplxo3tx($vwply17edn, $vwplfkojlf = false) { $vwply17edn = strtolower(trim($vwply17edn) ); $vwplsekv = 'memberium::welcomecontent::' . $vwply17edn; if (MEMBERIUM_BETA) { delete_transient($vwplsekv); } $vwplckl3 = get_transient($vwply17edn); if (! $vwplckl3) { $vwplrjx6uc = urlencode($vwply17edn); $vwplb8u7 = memberium_app()->wplnm1h(); if (! $vwplfkojlf) { $vwplfkojlf = "https://licenseserver.webpowerandlight.com/welcome/index.php?tab={$vwplrjx6uc}&version={$vwplb8u7}"; } $vwplu_gxri = wp_remote_get($vwplfkojlf); if (is_a($vwplu_gxri, 'WP_Error') ) { if (isset($vwplu_gxri->errors['http_request_failed'][0]) ) { $vwplckl3 = "<p>Loading Remote Page Content Failed:  {$vwplu_gxri->errors['http_request_failed'][0]}</p>"; } else { $vwplckl3 = '<p>Loading Remote Page Content Failed</p>'; } } else { $vwplckl3 = isset($vwplu_gxri['body']) ? $vwplu_gxri['body'] : '<p>No Content Available</p>'; if ($vwplckl3 > '') { set_transient($vwplsekv, $vwplckl3, 3600); } else { $vwplckl3 = '<p>Page content temporarily unavailable.</p>'; } } } return $vwplckl3; } }
