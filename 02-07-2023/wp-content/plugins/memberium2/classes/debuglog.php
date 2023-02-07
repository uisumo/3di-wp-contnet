<?php
/**
 * Copyright (c) 2018-2022 David J Bullock
 * Web Power and Light, LLC
 * https://webpowerandlight.com
 * support@webpowerandlight.com
 *
 */

 class_exists('m4is_emz57o') || die(); final 
class m4is_apcu3 { static 
function m4is_ig7yp(string $m4is_qfup8 = '', string $m4is_knsa = '', int $m4is__h0w = 0, string $m4is_ivm3qw = '', $m4is_j0n7 = '') { if (isset($_GET['doing_wp_cron']) ) { return; } if (is_admin() ) { return; } global $user; $m4is_b9hmo = $_SERVER['REMOTE_ADDR'] . '::' . isset($_SERVER['REQUEST_TIME_FLOAT']) ? $_SERVER['REQUEST_TIME_FLOAT'] : $_SERVER['REQUEST_TIME']; $m4is_k2qb08 = $m4is_b9hmo . ' :: ' . microtime(true); $m4is_k2qb08 .= ' :: ' . (function_exists('get_current_user_id') ? get_current_user_id() : 0); if (function_exists('current_filter') ) { $m4is_k2qb08 .= ' :: ' . current_filter(); } $m4is_k2qb08 .= ' :: '; $m4is_k2qb08 .= basename($m4is_qfup8) . ' -> ' . $m4is_knsa . ' -> ' . $m4is__h0w . " :: "; if (! empty($m4is_j0n7) ) { $m4is_k2qb08 .= $m4is_ivm3qw . ' = '; if (is_array($m4is_j0n7) || is_object($m4is_j0n7) ) { $m4is_k2qb08 .= print_r($m4is_j0n7, true); } elseif (is_bool($m4is_j0n7) ) { $m4is_k2qb08 .= $m4is_j0n7 ? 'True' : 'False'; } else { $m4is_k2qb08 .= $m4is_j0n7; } } else { $m4is_k2qb08 .= $m4is_ivm3qw; } $m4is_k2qb08 .= "\n"; if (MEMBERIUM_DEBUGLOG == 'error_log:') { error_log($m4is_k2qb08); } elseif (MEMBERIUM_DEBUGLOG > '') { file_put_contents(MEMBERIUM_DEBUGLOG, $m4is_k2qb08, FILE_APPEND); } else { echo nl2br($m4is_k2qb08); } } }
