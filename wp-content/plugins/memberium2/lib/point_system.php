<?php
/**
 * Copyright (c) 2012-2020 David J Bullock
 * Web Power and Light, LLC
 * https://webpowerandlight.com
 * support@webpowerandlight.com
 *
 */

 if (! defined('ABSPATH') ) { die(); } final class wplay4d { static function wplxf4tx($vwpllzly5b = 0, $vwplgm_9s = 0) { $vwpllzly5b = $vwpllzly5b == 0 ? get_current_user_id() : (int) $vwpllzly5b; $vwplgm_9s = (int) $vwplgm_9s; if (function_exists('badgeos_get_users_points') ) { $vwpl_qom9 = badgeos_get_users_points($vwpllzly5b); } elseif (function_exists('gamipress_get_user_points') ) { $vwpl_qom9 = gamipress_get_user_points($vwpllzly5b); } else { $vwply17edn = empty($vwplgm_9s) ? '_memberium_points' : "_memberium_{$vwplgm_9s}_points"; $vwpl_qom9 = get_user_meta($vwpllzly5b, $vwply17edn, true); } return (int) $vwpl_qom9; } static function wpltwlx_($vwpllzly5b = 0, $vwplpqo4d9 = 0, $vwplgm_9s = 0) { $vwpllzly5b = $vwpllzly5b == 0 ? get_current_user_id() : (int) $vwpllzly5b; $vwplpqo4d9 = (int) $vwplpqo4d9; $vwplgm_9s = (int) $vwplgm_9s; if ($vwpllzly5b == 0) { return false; } $vwplgm_9s = self::wple3l7($vwplgm_9s); if (function_exists('badgeos_update_users_points') ) { $vwplkjag = badgeos_update_users_points($vwpllzly5b, $vwplpqo4d9); badgeos_log_users_points($vwpllzly5b, $vwplpqo4d9, $vwplkjag, 0, 0); } elseif (function_exists('gamipress_update_user_points') ) { $vwplkjag = gamipress_update_user_points($vwpllzly5b, $vwplpqo4d9); gamipress_log_user_points($vwpllzly5b, $vwplpqo4d9, $vwplkjag, 0, 0); } else { $vwply17edn = empty($vwplgm_9s) ? '_memberium_points' : "_memberium_{$vwplgm_9s}_points"; $vwplkjag = $vwplpqo4d9 + self::wplxf4tx($vwpllzly5b); update_user_meta($vwpllzly5b, $vwply17edn, $vwplkjag); } return $vwplkjag; } static function wplcwty($vwplvpexdn, $vwplckl3 = null, $vwpluvdiz = '') { $vwpllzly5b = isset($vwplvpexdn['user_id']) ? (int) $vwplvpexdn['user_id'] : get_current_user_id(); $vwplgm_9s = isset($vwplvpexdn['type']) ? (int) $vwplvpexdn['type'] : ''; $vwpl_qom9 = self::wplxf4tx($vwpllzly5b, $vwplgm_9s); return $vwpl_qom9; }    private static function wple3l7($vwplmvbe = null) { if (empty($vwplmvbe) ) { return ''; } if (function_exists('gamipress_update_user_points') ) { $vwplgm_9s = gamipress_get_points_type($vwplgm_9s); } else { $vwplgm_9s = (string) $vwplmvbe; } return $vwplgm_9s; } }
