<?php
/**
 * Copyright (C) 2020 David Bullock
 * Web Power and Light, LLC
 */

 if (! defined('ABSPATH') ) { header('HTTP/1.0 403 Forbidden'); die(); } require_once __DIR__ . '/core.php'; if (is_admin() ) { require_once __DIR__ . '/admin.php'; }
