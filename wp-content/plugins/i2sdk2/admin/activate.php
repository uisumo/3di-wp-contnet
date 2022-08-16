<?php
if ( !defined( 'ABSPATH' ) ) {
	die();
}


function wpal_i2sdk_activate() {

	global $wpdb;

	// Define Default Keys
	$default_config_keys = array(
		'api_key'                => '',
		'api_log'                => 0,
		'app_name'               => '',
		'db_prefix'              => '',
		'debug_mode'             => '',
		'delete_on_uninstall'    => 0,
		'email_notification'     => 0,
		'error_email'            => '',
		'error_log'              => 0,
		'http_post_key'          => wp_generate_password( 12, FALSE, FALSE ),
		'infusionsoft_analytics' => 0,
		'retry_count'            => 3,
		'server_verified'        => 0,
		'tracking_code'          => 0,
	);

	// Define Keys to Remove (Obsolete or force reset)
	$remove_config_keys = array(
	);

	// Set Options
	$i2sdk_options = get_option( 'i2sdk' );

	// Remove Obsoleted Keys First
	// This allows us also to force a new default on install
	foreach ( $remove_config_keys as $key ) {
		unset( $i2sdk_options[$key] );
	}

	// Set any missing defaults
	foreach ( $default_config_keys as $key=>$value ) {
		if ( empty( $i2sdk_options[$key] ) ) {
			$i2sdk_options[$key] = $value;
		}
	}

	$i2sdk_options['version'] = i2sdk_class::VERSION;

	// Create / Update Options
	add_option( 'i2sdk', $i2sdk_options, '', 'yes' );
	update_option( 'i2sdk', $i2sdk_options );


	require_once ABSPATH . 'wp-admin/includes/upgrade.php';
	$table_name = i2sdk_class::DB_API_LOG;
	$sql = "CREATE TABLE {$table_name} (
		id int(20) NOT NULL AUTO_INCREMENT,
		appname varchar(32) COLLATE utf8mb4_unicode_ci NOT NULL,
		timestamp timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
		duration float NOT NULL DEFAULT '0',
		retries int(11) NOT NULL DEFAULT '0',
		ip_address varchar(15) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
		user varchar(32) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
		service varchar(32) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
		caller longtext COLLATE utf8mb4_unicode_ci,
		result longtext COLLATE utf8mb4_unicode_ci,
		PRIMARY KEY  (id)
	) ENGINE=InnoDB DEFAULT CHARSET=utf8;";
	dbDelta( $sql );

	$table_name = i2sdk_class::DB_DATAFORMFIELDS;
	$sql = "CREATE TABLE {$table_name} (
		id int(11) NOT NULL,
		appname varchar(32) COLLATE utf8mb4_unicode_ci NOT NULL,
		name varchar(64) COLLATE utf8mb4_unicode_ci NOT NULL,
		label varchar(64) COLLATE utf8mb4_unicode_ci NOT NULL,
		datatype smallint(6) NOT NULL,
		formid smallint(6) NOT NULL,
		PRIMARY KEY  (id,appname)
	) ENGINE=InnoDB DEFAULT CHARSET=utf8;";
	dbDelta( $sql );



// 	) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8mb4_unicode_ci;";


}
