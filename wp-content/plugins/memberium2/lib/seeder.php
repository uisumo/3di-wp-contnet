<?php
/**
 * Copyright (c) 2012-2020 David J Bullock
 * Web Power and Light, LLC
 * https://webpowerandlight.com
 * support@webpowerandlight.com
 *
 */

 if (! defined('ABSPATH') ) { die(); } final class wplumx4jq { static function wplh9nk() { $vwpltmveju = get_option('m4is/seeder/tag', 0); $vwplho_n = get_option('m4is/seeder/page', 0); $vwplr704 = get_option('m4is/seeder/last_run', 0); if (! $vwpltmveju) { return; } if (time() - $vwplr704 < 5) { return; } } private static function wplm0jq($vwplho_n, $vwpltmveju) { if (empty($vwpltmveju) ) { return; } global $i2sdk; $vwplanieul = 1000; $vwplnzlj0t = 'Contact'; $vwplho_n = (int) $vwplho_n; $vwpldv1yjr = $i2sdk->isdk; $vwplc0g3p = wplj_l2t::wplntnyv($vwplnzlj0t, FALSE); $vwple7lbh = 0; $vwplw5rgd3 = wplz8bid::wplm3z9k('appname'); $vwplv80sz = array('Groups' => $vwpltmveju); $vwply4j8x = $vwpldv1yjr->dsQuery($vwplnzlj0t, $vwplanieul, $vwplho_n, $vwplv80sz, $vwplc0g3p); foreach($vwply4j8x as $row) { memberium_app()->wplto2h4($row, false); } if (count($vwply4j8x) < $vwplanieul) { update_option('m4is/seeder/page', 0, false); } else { update_option('m4is/seeder/page', ($vwplho_n + 1), false); } } }
