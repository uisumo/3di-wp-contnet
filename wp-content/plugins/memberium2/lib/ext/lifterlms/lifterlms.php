<?php
if ( !defined( 'ABSPATH' ) ) { die(); }  if ( true || defined( 'LLMS_VERSION' ) ) { new wplp4tme; if (is_admin() ) { require_once __DIR__ . '/admin.php'; } else { require_once __DIR__ . '/frontend.php'; } }
