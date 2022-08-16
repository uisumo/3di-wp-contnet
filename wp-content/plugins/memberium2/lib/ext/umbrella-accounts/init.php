<?php
 if ( ! defined( 'ABSPATH' ) ) { die(); } if ( class_exists( 'wplul1_fc' ) ) { return; } if ( ! wpln9_s::wplq953( array( 'unlimited', 'umbrella' ) ) ) { return; } $GLOBALS['memberium_modules']['umbrella-accounts]']['core'] = require_once __DIR__ . '/core.php'; if ( is_admin() ) { $GLOBALS['memberium_umbrella_accounts'] = require_once __DIR__ . '/admin.php'; }
