<?php
/**
 * Copyright (c) 2012-2020 David J Bullock
 * Web Power and Light, LLC
 * https://webpowerandlight.com
 * support@webpowerandlight.com
 *
 */

 if (! defined('ABSPATH') ) { die(); } final class wplhodw { const PLUGIN_FULLSLUG = 'memberium2/memberium2.php'; const PLUGIN_HOME = MEMBERIUM_HOME; const PLUGIN_SLUG = 'memberium2'; const PLUGIN_UPDATE_URL = 'https://licenseserver.webpowerandlight.com/memberium-is/current-version.php'; const PLUGIN_URL = 'https://memberium.com/'; const UPDATE_ID = 3141592654; static function wplbxtwd6($vwplornd, $vwplgitq, $vwploia7_d) { if (! property_exists($vwploia7_d, 'slug') ) { return false; } if ($vwploia7_d->slug == self::PLUGIN_SLUG) { return true; } return false; } static function wpll6pvi($vwplornd, $vwplgitq, $vwploia7_d) { if (! property_exists($vwploia7_d, 'slug') ) { return $vwplornd; } if ($vwploia7_d->slug <> self::PLUGIN_SLUG) { return $vwplornd; } $vwplj57sny = unserialize(wpll72jhi::wplqusm(self::PLUGIN_UPDATE_URL) ); if (is_object($vwplj57sny) ) { return $vwplj57sny; } return $vwplornd; } static function wpllaybf($vwplztb4) { $vwplornd = unserialize(wpll72jhi::wplqusm(self::PLUGIN_UPDATE_URL) ); if (is_object($vwplornd) ) { if (! function_exists('get_plugin_data') ) { require_once ABSPATH . 'wp-admin/includes/plugin.php'; } $vwplpxoyt = get_plugin_data(self::PLUGIN_HOME, false, false); $vwplq5z79 = self::PLUGIN_FULLSLUG; $vwplqa4r_ = $vwplornd->version; $vwpldxwy9n = $vwplpxoyt['Version']; $vwpljvo4 = new stdClass; $vwpljvo4->id = self::UPDATE_ID; $vwpljvo4->slug = self::PLUGIN_SLUG; $vwpljvo4->plugin = $vwplq5z79; $vwpljvo4->new_version = $vwplornd->version; $vwpljvo4->url = self::PLUGIN_URL; $vwpljvo4->package = $vwplornd->download_link; $vwpljvo4->upgrade_notice = $vwplornd->upgrade_notice; $vwpljvo4->tested = $vwplornd->tested; $vwpljvo4->icons = $vwplornd->icons; if (version_compare($vwplqa4r_, $vwpldxwy9n, 'gt') ) { $vwplztb4->response[$vwpljvo4->plugin] = $vwpljvo4; } elseif (! empty($vwplztb4->response) ) { unset($vwplztb4->response[$vwplq5z79]); } } return $vwplztb4; } static function wplf_82is() {  if ($this->license_status) { if (empty($this->options['settings']['autoupdate']) ) { return; } } if (! is_writable(self::PLUGIN_HOME) ) { error_log('MEMBERIUM: Autoupdate failed due to missing file permissions'); return; } if (! function_exists('get_plugin_data') ) { require_once ABSPATH . 'wp-admin/includes/plugin.php'; } $vwplornd = wp_remote_get(self::PLUGIN_UPDATE_URL); $vwplornd = is_array($vwplornd) ? $vwplornd = unserialize($vwplornd['body']) : array(); $vwpltalx = false; $vwpldu04m = get_plugin_data(self::PLUGIN_HOME, false, false); $vwplqa4r_ = (is_object($vwplornd) && property_exists($vwplornd, 'version') ) ? $vwplornd->version : ''; $vwpldxwy9n = memberium_app()->wplnm1h(); if (version_compare($vwplqa4r_, $vwpldxwy9n, 'gt') ) {  ignore_user_abort();  require_once ABSPATH .'/wp-admin/includes/file.php';  $vwplwfqz = WP_PLUGIN_DIR; $vwplunjt8q = download_url($vwplornd->download_link, 300);  if (file_exists($vwplunjt8q) ) {   file_put_contents(ABSPATH . '.maintenance', '<?php $upgrading = time();'); WP_Filesystem(); require_once ABSPATH .'/wp-admin/includes/class-wp-filesystem-direct.php'; $vwplt49lo = new wp_filesystem_direct(null); $vwplqyz2cn = MEMBERIUM_HOME_DIR; $vwplt49lo->delete($vwplqyz2cn, true); unzip_file($vwplunjt8q, $vwplwfqz); unlink($vwplunjt8q); $vwpltalx = true; } } if (file_exists(ABSPATH . '.maintenance') ) { unlink(ABSPATH . '.maintenance'); } return $vwpltalx; } }
