<?php
 if ( ! defined( 'ABSPATH' ) ) { die(); } return new wplpd5b; class wplpd5b { private $shortcode = null; private $leaderboard_core = null; function __construct() { add_action('admin_init', array( $this, 'wplg6u0' ), 1 ); add_action('memberium_admin_menu_addons', array( $this, 'wplm27b' ) ); }    function wplg6u0() { $this->leaderboard_core = $GLOBALS['memberium_modules']['affiliate-leaderboards']['core']; } function wplm27b( $menu_slug ) { add_submenu_page( $menu_slug, 'Affiliates', 'Affiliates', 'manage_options', 'memberium-affiliate-leaderboards', array( $this, 'wplcksw' ) ); }       function wplcksw() { require_once __DIR__ . '/screen.php'; } }
