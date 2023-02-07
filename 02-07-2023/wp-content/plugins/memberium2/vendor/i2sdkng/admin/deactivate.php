<?php
if (!defined('ABSPATH')) {
    die();
}


function wpal_i2sdk_deactivate() {
    $cron_hook      = 'i2sdkng_refresh_check';
    $cron_timestamp = wp_next_scheduled($cron_hook);
    if ( ! empty($cron_timestamp) ) {
        wp_clear_scheduled_hook($cron_hook);
    }
}
