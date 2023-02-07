<?php
/**
 * Copyright (c) 2012-2022 David J Bullock
 * Web Power and Light, LLC
 * https://webpowerandlight.com
 * support@webpowerandlight.com
 */

 class_exists('m4is_emz57o') || die(); $m4is_t7i0bz = 'memberium::welcomecontent::' . $current_tab; if (MEMBERIUM_BETA ) { delete_transient($m4is_t7i0bz ); } $m4is_amunwi = get_transient($m4is_t7i0bz ); if (! $m4is_amunwi ) { $m4is_amunwi = wp_remote_get('https://licenseserver.webpowerandlight.com/welcome/index.php?tab=' . $current_tab . '&version=' . memberium_app()->m4is_gu3m() ); $m4is_amunwi = $m4is_amunwi['body']; if ($m4is_amunwi > '' ) { set_transient($m4is_t7i0bz, $m4is_amunwi, 3600 ); } } echo $m4is_amunwi;
