<?php
if ( !defined( 'ABSPATH' ) ) {
	die();
}


class i2sdk_class {
	const VERSION           = I2SDK_VERSION;
	const DB_API_LOG        = 'i2sdk_apilog';
	const DB_DATAFORMFIELDS = 'i2sdk_dataformfields';

	public  $isdk             = NULL;

	private $configuration    = NULL;
	private $i2sdk_version    = 0;
	private $valid_connection = 0;
	private $tables           = [];

	
	static 
function wpal_i2sdk_generate_key( $length = 12 ) {
		return substr( md5( wp_salt( 'auth' ) . wp_salt( 'logged_in' ) . wp_salt( 'secure_auth' ) . microtime() .  mt_rand(0, PHP_INT_MAX ) ), 0, $length );
	}

	static 
function get_i2sdk_options() {
		$configuration = get_option('i2sdk');

		if (! $configuration) {
			$configuration = [];
		}

		$defaults = [
			'access_token'           => '',
			'api_key'                => '',
			'api_log'                => 0,
			'app_name'               => '',
			'db_prefix'              => '',
			'debug_mode'             => '',
			'delete_on_uninstall'    => 0,
			'email_notification'     => 0,
			'error_email'            => '',
			'error_log'              => 0,
			'http_post_key'          => '',
			'infusionsoft_analytics' => 0,
			'oauth_enabled'          => 0,
			'retry_count'            => 3,
			'server_verified'        => 0,
			'tracking_code'          => '',
			'version'                => I2SDK_VERSION,
		];
		$configuration = wp_parse_args($configuration, $defaults);


		if (empty($configuration['http_post_key'])) {
			$configuration['http_post_key'] = self::wpal_i2sdk_generate_key(12);
		}

		return $configuration;
	}

	
function __construct() {
		global $wpdb;

		include_once I2SDK_DIR . 'lib/infusionsoft_driver_class.php';

		$this->i2sdk_version   = I2SDK_VERSION;

		$this->tables = [
			'api_log'        => self::DB_API_LOG,
			'dataformfields' => self::DB_DATAFORMFIELDS,
		];

		$this->configuration = self::get_i2sdk_options();

		$this->isdk = new infusionsoft_driver;
		$this->isdk->setApiLogTable( $this->tables['api_log'] );
		$this->isdk->enableLogging( $this->configuration['api_log'] );
	}

	
function initialize(){

				$api_key     = false;
		$oauth_token = false;
		if ( !empty($this->configuration['app_name']) ) {
						if ( !empty($this->configuration['api_key']) ){
				$api_key = !empty($this->configuration['api_key']) ? $this->configuration['api_key'] : false;
				$this->isdk->setAPIKey($api_key);
			}

						if( !empty($this->configuration['oauth_enabled']) ){
				if( !empty($this->configuration['access_token']) ){
										add_action('init', [$this, 'registerOauthRefreshCron']);
										add_filter('http_response', [$this, 'handleHttpResponse'], 50, 3 );
					$oauth_token = $this->configuration['access_token'];
					$this->isdk->setOAuthToken($oauth_token);
				}
				else{
					add_action('admin_init', [$this, 'oauthDisconnectedNoticeCheck']);
				}
			}

			if( $api_key || $oauth_token ){
				$valid_connection = false;
				if( $oauth_token ){
					$valid_connection = $this->isdk->configureConnection( $this->configuration['app_name'], $oauth_token );
				}
				if( ! $valid_connection && $api_key ){
					$valid_connection = $this->isdk->configureConnection( $this->configuration['app_name'], $api_key );
				}
				$this->valid_connection = $valid_connection;
			}

						$this->setServerVerified( $this->valid_connection );
		}
		else {
			$this->setServerVerified(false);
		}

		if ( $_SERVER['REQUEST_METHOD'] == 'GET' && isset( $_GET['auth_key'] ) && isset( $_GET['operation'] ) && isset( $_GET['contactId'] ) ) {
			$_POST['contactId']        = (int) $_GET['contactId'];
			$_SERVER['REQUEST_METHOD'] = 'POST';
		}

				if ( $_SERVER['REQUEST_METHOD'] == 'POST' && isset( $_GET['auth_key'] ) && isset( $_GET['operation'] ) ) {
			add_action('init', [$this, 'routeHTTPost']);
		}

				if ( $_SERVER['REQUEST_METHOD'] == 'GET' && ( isset($_GET['is_auth_access_token']) || isset($_GET['is_auth_error']) || isset($_GET['is_auth_license']) ) ){
			$this->accessToken()->handle_authorization();
		}
		if( $_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['is_set_oauth_expiration']) ){
			$this->accessToken()->handle_reset();
		}

	}

	
function __destruct() {
	}

	
function reloadConfiguration() {
		$this->configuration = self::get_i2sdk_options();
	}

	
function getConfigurationOption($key) {
		if (isset($this->configuration[$key]) ) {
			return $this->configuration[$key];
		}
		else {
			return '';
		}
	}

	
function setConfigurationOption( $key, $value ) {
		$this->configuration[$key] = $value;
		update_option( 'i2sdk', $this->configuration );
		return true;
	}

	
function getInfusionsoftDriver() {
		return $this->isdk;
	}

	
function registerOauthRefreshCron(){
		$token_class = $this->accessToken();
		$cron_hook   = 'i2sdkng_refresh_check';
		add_action($cron_hook, [$token_class, 'cron_hourly_refresh_check']);
		if ( ! wp_next_scheduled($cron_hook) ) {
			wp_schedule_event(time() + mt_rand(300,900), 'hourly', $cron_hook);
		}
	}

	
function handleHttpResponse( $response, $args, $url ){
		if( strpos( $url, 'api.infusionsoft.com' ) !== false ){
			$code    = (int) wp_remote_retrieve_response_code($response);
			$body    = json_decode(wp_remote_retrieve_body($response));
			if( $code === 401 ){
				if( is_object($body) ){
			        if( isset($body->fault) && is_object($body->fault) ){
			            if( isset($body->fault->faultstring) && $body->fault->faultstring === 'Invalid Access Token' ){
							$response = $this->accessToken()->handle_http_invalid_access_token($response, $args, $url);
			            }
			        }
			    }
			}
		}
		return $response;
	}

	
function oauthDisconnectedNoticeCheck(){
		if( empty( $this->getConfigurationOption( 'oauth_enabled' ) ) ){
			return "";
		}
		if( empty( $this->getConfigurationOption( 'access_token' ) ) ){
			$this->admin_notice( 'connection' );
		}
	}

	
function accessToken(){
		static $token = null;

		if( is_null( $token ) ) {
			include_once I2SDK_DIR . 'lib/access_token.php';
			$token = new wpal_access_token( $this );
		}

		return $token;
	}

	
function rest(){
		static $rest = null;

		if( is_null( $rest ) ){
			include_once I2SDK_DIR . 'lib/rest.php';
			$config = $this->configuration;
			$rest   = new wpal_infusionsoft_rest( $config['app_name'], $config['access_token'], $config['api_log'] );
		}

		return $rest;
	}

	
function getVersion() {
		return $this->i2sdk_version;
	}

	
function isServerConnected() {
		return $this->valid_connection;
	}

	
function isVerified() {
		return $this->configuration['server_verified'];
	}

	
function isRestAvailable() {
		return !empty($this->configuration['oauth_enabled']) && !empty($this->configuration['server_verified']) && !empty($this->configuration['access_token']);
	}

	
function isLicenseValid(){
		return isset($this->configuration['license_valid']) ? (bool) $this->configuration['license_valid'] : true;
	}

	
function show_infusionsoft_web_analytics() {
		echo $this->configuration['tracking_code'];
	}

	
function getTableName( $table_name ) {
		$table_name = strtolower( trim( $table_name ) );
		return $this->tables[$table_name];
	}

	
function checkTableExists( $table_name ) {
		global $wpdb;

		if ( is_string( $table_name ) ) {
			$count = $wpdb->get_var( 'SHOW TABLES LIKE "' . $table_name . '";' );
			return (boolean) $count == $table_name;
		}
		elseif ( is_array( $table_name ) ) {
			$tables = $wpdb->get_col( 'SHOW TABLES;' );
			foreach( $table_name as $name ) {
				if ( ! in_array( $name, $tables ) ) {
					return false;
				}
			}
			return true;
		}
		return false;
	}

	
function writeAPILog( $log ){
		global $wpdb;
		$defaults = [
			'appname'    => $this->getConfigurationOption('app_name'),
			'ip_address' => $_SERVER['REMOTE_ADDR'],
			'duration'   => 0,
			'user'       => '',
			'service'    => '',
			'caller'     => '',
			'result'     => '',
			'retries'    => 0
		];
		$log   = wp_parse_args($log, $defaults);
		$start = !empty($log['start']) ? $log['start'] : 0;
		if( !empty($start) ){
			if( empty($log['duration']) ){
				$log['duration'] = ( microtime(true) - $start );
			}
		}
		foreach ($log as $k => $v) {
			if( ! array_key_exists($k, $defaults) ){
				unset($log[$k]);
			}
		}
		$table = $this->getTableName('api_log');
		$wpdb->insert($table, $log);
	}

			
function setApp( $appname, $token = false, $action = false ){

		$original_appname = $this->getConfigurationOption( 'app_name' );
		$appname_changed   = $appname !== $original_appname;
		$appname           = empty($appname) ? false : $appname;
		$token             = $token && is_object($token) ? $token : false;
		$api_key           = $this->getConfigurationOption( 'api_key' );
		$access_token	   = $token ? $token->accessToken : $this->getConfigurationOption( 'access_token' );

		if( ! $appname_changed ){
			return false;
		}

				if( ! $appname ){
			if( $token ){
								if( empty($api_key) ){
										$this->setConfigurationOption( 'app_name', '' );
					$this->setConfigurationOption( 'server_verified', 0 );
					$this->accessToken()->disconnect();
				}
			}
		}
				else{
						if( ! empty($original_appname) ){
				if( $token && ( $action === 'connecting' || $action === 'refresh' ) ) {
										$this->accessToken()->disconnect();
					$message = sprintf('Attempting to connect to a different app %s than was already set %s.', $appname, $original_appname );
										$this->admin_notice( 'error', 'Oauth Error', $message );
				}
			}
						else{
				if( $token ){
					$this->setConfigurationOption( 'app_name', $appname );
					$this->isdk->setOAuthToken($access_token);
					$this->valid_connection = $this->isdk->configureConnection( $appname, $access_token );
				}
			}
		}
	}

	
function setServerVerified($valid_connection) {
		$verified = (boolean) $this->configuration['server_verified'];

		if( ! $valid_connection && $verified ){
			$this->configuration['server_verified'] = 0;
			update_option( 'i2sdk', $this->configuration );
		}
		else if( $valid_connection && ! $verified ){
			$this->configuration['server_verified'] = 0;
			update_option( 'i2sdk', $this->configuration );
		}
	}

	
function manageLicense($invalid_message = false, $admin_notice = false) {
		
		

	}

	
function admin_notice( $type, $title = '', $message = '' ){

	    $license_url = false;
	    if( $type === 'license' || $type === 'connection' ){
			$type    = "error";
	        $license = $type === 'license';
	        $title   = $license ? "No active license found, " : "";
	        $title   .= "Keap OAuth Not Connected";
	        if( $license ){
				$license_url = apply_filters('i2sdk/license/url', '');
	            $message     = $message === 'No active license found' ? '' : $message;
	        }
	        $link = $license ? $license_url : $this->accessToken()->get_connect_url();
			if( ! empty($link) ){
				$message .= ' ' . sprintf('<a class="button-primary" href="%s">%s</a>', $link, __('Click here to authorize') );
			}
	    }

	    add_action( 'admin_notices', function() use ( $type, $title, $message ) {
	        printf( '<div class="notice notice-%s is-dismissible"><p><strong>%s:</strong> %s</p></div>', $type, $title, $message );
	    });
	}

	
function getCountries() {
		return [
			'&Aring;land Islands', 'Aland Islands', 'Afghanistan', 'Albania', 'Algeria', 'American Samoa', 'Andorra', 'Angola', 'Anguilla', 'Antarctica', 'Antigua and Barbuda', 'Argentina', 'Armenia', 'Aruba', 'Australia', 'Austria', 'Azerbaijan',
			'Bahamas (the)', 'Bahrain', 'Bangladesh', 'Barbados', 'Belarus', 'Belgium', 'Belize', 'Benin', 'Bermuda', 'Bhutan', 'Bolivia (Plurinational State of)', 'Bonaire, Sint Eustatius and Saba', 'Bosnia and Herzegovina', 'Botswana', 'Bouvet Island', 'Brazil', 'British Indian Ocean Territory (the)', 'Brunei Darussalam', 'Bulgaria', 'Burkina Faso', 'Burundi',
			"C&ocirc;te d'Ivoire", 'Cabo Verde', 'Cambodia', 'Cameroon', 'Canada', 'Cayman Islands (the)', 'Central African Republic (the)', 'Chad', 'Chile', 'China', 'Christmas Island', 'Cocos (Keeling) Islands (the)', 'Colombia', 'Comoros (the)', 'Congo (the Democratic Republic of the)', 'Congo (the)', 'Cook Islands (the)', 'Costa Rica', 'Croatia', 'Cuba', 'Cura&ccedil;ao', 'Cyprus', 'Czech Republic (the)',
			'Denmark', 'Djibouti', 'Dominica', 'Dominican Republic (the)',
			'Ecuador', 'Egypt', 'El Salvador', 'Equatorial Guinea', 'Eritrea', 'Estonia', 'Ethiopia',
			'Falkland Islands (the) [Malvinas]', 'Faroe Islands (the)', 'Fiji', 'Finland', 'France', 'French Guiana', 'French Polynesia', 'French Southern Territories (the)',
			'Gabon', 'Gambia (the)', 'Georgia', 'Germany', 'Ghana', 'Gibraltar', 'Greece', 'Greenland', 'Grenada', 'Guadeloupe', 'Guam', 'Guatemala', 'Guernsey', 'Guinea', 'Guinea-Bissau', 'Guyana',
			'Haiti', 'Heard Island and McDonald Islands', 'Holy See (the)', 'Honduras', 'Hong Kong', 'Hungary',
			'Iceland', 'India', 'Indonesia', 'Iran (Islamic Republic of)', 'Iraq', 'Ireland', 'Isle of Man', 'Israel', 'Italy',
			'Jamaica', 'Japan', 'Jersey', 'Johnston Island', 'Jordan',
			'Kazakhstan', 'Kenya', 'Kiribati', "Korea (the Democratic People's Republic of)", 'Korea (the Republic of)', 'Kuwait', 'Kyrgyzstan',
			"Lao People's Democratic Republic (the)", 'Laos', 'Latvia', 'Lebanon', 'Lesotho', 'Liberia', 'Libya', 'Liechtenstein', 'Lithuania', 'Luxembourg',
			'Macao', 'Macedonia (the former Yugoslav Republic of)', 'Madagascar', 'Malawi', 'Malaysia', 'Maldives', 'MV', 'Mali', 'Malta', 'Marshall Islands (the)', 'Martinique', 'Mauritania', 'Mauritius', 'Mayotte', 'Mexico', 'Micronesia (Federated States of)', 'Midway Islands', 'Moldova (the Republic of)', 'Monaco', 'Mongolia', 'Montenegro', 'Montserrat', 'Morocco', 'Mozambique', 'Myanmar',
			'Namibia', 'Nauru', 'Nepal', 'Netherlands (the)', 'Netherlands Antilles', 'New Caledonia', 'New Zealand', 'Nicaragua', 'Niger (the)', 'Nigeria', 'Niue', 'Norfolk Island', 'Northern Mariana Islands (the)', 'Norway',
			'Oman',
			'Pakistan', 'Palau', 'Palestine, State of', 'Panama', 'Papua New Guinea', 'Paraguay', 'Peru', 'Philippines (the)', 'Pitcairn', 'Poland', 'Portugal', 'Puerto Rico',
			'Qatar',
			'R&eacute;union', 'Romania', 'Russian Federation (the)', 'Rwanda',
			'Samoa', 'San Marino', 'Sao Tome and Principe', 'Saudi Arabia', 'Senegal', 'Serbia', 'Seychelles', 'Sierra Leone', 'Singapore', 'Sint Maarten (Dutch part)', 'Slovakia', 'Slovenia', 'Solomon Islands', 'Somalia', 'South Africa', 'South Georgia and the South Sandwich Islands', 'South Sudan', 'Southern Rhodesia', 'Spain', 'Sri Lanka', 'Saint Barth&eacute;lemy', 'Saint Helena, Ascension and Tristan da Cunha', 'Saint Kitts and Nevis', 'Saint Lucia', 'Saint Martin (French part)', 'Saint Pierre and Miquelon', 'Saint Vincent and the Grenadines', 'Sudan (the)', 'Suriname', 'Svalbard and Jan Mayen', 'Swaziland', 'Sweden', 'Switzerland', 'Syrian Arab Republic',
			'Taiwan (Province of China)', 'Tajikistan', 'Tanzania, United Republic of', 'Thailand', 'Timor-Leste', 'Togo', 'Tokelau', 'Tonga', 'Trinidad and Tobago', 'Tunisia', 'Turkey', 'Turkmenistan', 'Turks and Caicos Islands (the)', 'Tuvalu',
			'Uganda', 'Ukraine', 'United Arab Emirates (the)', 'United Kingdom', 'United States', 'Upper Volta', 'Uruguay', 'United States Minor Outlying Islands (the)', 'Uzbekistan',
			'Vanuatu', 'Venezuela (Bolivarian Republic of)', 'Viet Nam', 'Virgin Islands (British)', 'Virgin Islands (U.S.)',
			'Wallis and Futuna', 'Western Sahara',
			'Yemen',
			'Zambia', 'Zimbabwe',
		];
	}

	
function getCountryOptions( $current_country ) {
		if ( $current_country == '' ) {
			$current_country = 'United States';
		}

		$countries = $this->getCountries();
		$output = '';
		foreach ( $countries as $country ) {
			$output .= '<option value="' . $country . '" ' . ( ( $current_country == $country ) ? ' selected ' : ' ' ) . '>' . $country . '</option>';
		}
		return $output;
	}

	
function purgeAPILog() {
		global $wpdb;

		$table_name = $this->getTableName( 'api_log' );
		$wpdb->query( "TRUNCATE `{$table_name}`;" );
	}

	
function syncCustomFields() {
		global $wpdb;

		$table         = 'DataFormField';
		$limit         = 1000;
		$page          = 0;
		$search_field  = 'Id';
		$search_value  = '%';
		$return_fields = [
			'DataType',
			'FormId',
			'Id',
			'Label',
			'Name',
		];
		$table_name    = $this->tables['dataformfields'];
		$rows_loaded   = 0;
		$found_rows = [];

				$sql        = "SELECT `name` FROM `{$table_name}` WHERE `appname` = %s ORDER BY `name`;";
		$sql        = $wpdb->prepare( $sql, $this->configuration['app_name'] );
		$old_fields = $wpdb->get_col( $sql );

		do {
			$rows = $this->isdk->dsfind( $table, $limit, $page, $search_field, $search_value, $return_fields );

			if ( is_array( $rows ) ) {
				$wpdb->query( 'START TRANSACTION WITH CONSISTENT SNAPSHOT' );
								if ( ! empty ( $rows ) ) {
					foreach ( $rows as $row ) {
						if ( in_array( $row['FormId'], [ -1, -3, -4, -6, -5, -9, -10 ] ) ) {

							$found_rows[] = (int) $row['Id'];

							$sql = "DELETE FROM `{$table_name}` WHERE `id` = %d AND `appname` = %s;";
							$sql = $wpdb->prepare( $sql, intval( $row['Id'] ), $this->configuration['app_name'] );
							$wpdb->query( $sql );

							$sql = "INSERT INTO `{$table_name}` ( `id`, `appname`, `name`, `label`, `datatype`, `formid` ) VALUES ( %d, %s, %s, %s, %d, %d );";
							$sql = $wpdb->prepare( $sql, intval( $row['Id'] ), $this->configuration['app_name'], $row['Name'], $row['Label'], $row['DataType'], intval( $row['FormId'] ) );
							$wpdb->query( $sql );
						}
					}
				}
				$wpdb->query('COMMIT');
			}

			$page++;

		} while (is_array($rows) && count($rows) == $limit);

				if ( ! empty( $found_rows ) ) {
			$sql = "DELETE FROM `{$table_name}` WHERE `id` NOT IN ( " . implode( ',', $found_rows ). " );";
			$wpdb->query( $sql );
		}


		do_action( 'i2sdk_custom_fields_sync', $rows, $old_fields );
		set_transient( 'i2sdk_customfields_updated', time() );
		wp_cache_delete( '', 'i2sdk::data_form_fields' );

		return $rows_loaded;
	}

	
function getInfusionsoftFieldsByTable( $tablename, $filterlist = NULL ) {
		return m4is_f84s3h::m4is_cm6nr( $tablename, $filterlist );
	}


	

	
function normalizePOSTFields() {
		        $master_field_list = m4is_f84s3h::m4is_cm6nr( 'Contact', false );         $ignored_fields    = array_filter( explode( ',', memberium_app()->m4is_mmdrl( 'settings', 'ignore_contact_fields' ) ) );

		$new_post = [];
		foreach ( $_POST as $key => $value ) {
			if ( $value == 'null' ) {
				$value = '';
			}
			$new_key = '_' . $key;
			if ( in_array( $key, $master_field_list ) && ! in_array( $key, $ignored_fields ) ) {
				$new_post[$key] = $value;
			}
			elseif ( in_array( $new_key, $master_field_list ) && ! in_array( $new_key, $ignored_fields ) ) {
				$new_post[$new_key] = $value;
			}
		}
		$_POST = $new_post;
	}

	
function routeHTTPost() {
		

		if ( empty( $_GET['auth_key'] ) ) {
			echo 'No API Key Provided.';
			exit;
		}

		$auth_keys = explode( ',', $this->configuration['http_post_key'] );

		if ( ! in_array( $_GET['auth_key'], $auth_keys ) ) {
			echo 'Invalid API Key.';
			exit;
		}

		$fieldnames = [
			'Id',
			'contactId',
			'ContactId',
			'Contact0Id',
		];

		foreach( $fieldnames as $fieldname ) {
			if ( isset( $_REQUEST[$fieldname] ) && $_REQUEST[$fieldname] > 0 )  {
				$_POST['contactId'] = (int) $_REQUEST[$fieldname];
			}
		}

		if ( $_POST['contactId'] > 0 && count( $_POST ) == 1 ) {
			$return_fields = m4is_f84s3h::m4is_cm6nr( 'Contact', false ); 			$contact = $this->isdk->loadCon( (int) $_POST['contactId'], $return_fields );

			if ( is_array ($contact ) ) {
				$_POST = $contact;
			}
			else {
				echo 'Invalid Data';
				exit;
			}
		}

		if ( ! isset( $_GET['nofetch'] ) ) {
			$this->normalizePOSTFields();
		}

		do_action( 'i2sdk_http_post', $_GET, $_POST );
		exit;
	}

	
function addRemoveTagContacts( array $contact_ids, int $tag_id ){

		$contact_count = count($contact_ids);
		$updated       = [];
		$contacts      = array_values($contact_ids);

				if( $this->isRestAvailable() ){
			$response = $this->rest()->add_remove_tag_contacts($tag_id, $contacts);
			$tag_id   = abs($tag_id);
			if( $response ){
				$updated[$tag_id] = $response;
			}
		}
				else{
			$action = $tag_id < 0 ? 'remove' : 'add';
			$updated[$tag_id] = [];
			foreach ($contacts as $contact_id) {
								if( $action === 'add' ){
					$response = $this->isdk->grpAssign($contact_id, $tag_id);
				}
								else{
					$response = $this->isdk->grpRemove($contact_id, $tag_id);
				}
				$result = $response ? 'SUCCESS' : 'FAILURE';
				if( ! array_key_exists($result, $updated[$tag_id]) ){
					$updated[$tag_id][$result] = [];
				}
				$updated[$tag_id][$result] = $contact_id;
			}
		}

		return $updated;
	}

	
function addRemoveContactTags( int $contact_id, array $tag_ids ){

		$tags    = [];
		$results = [];
		$rest    = $this->isRestAvailable();

				$tags['remove'] = array_filter($tag_ids, function($v) {
			return $v < 0;
		});

		if ( ! empty($tags['remove']) ) {
			$tags['remove'] = array_map('abs', $tags['remove']);
			if( $rest ){
				$response = $this->rest()->remove_contact_tags($contact_id, $tags['remove']);
				if( $response && ! is_wp_error($response) ){
					$results['remove'] = $response;
				}
			}
			else{
				$results['remove'] = ['SUCCESS' => [],'FAILURE' => []];
				foreach ($tags['remove'] as $tag_id) {
					$removed = $this->isdk->grpRemove($contact_id, $tag_id);
					$result  = $added ? 'SUCCESS' : 'FAILURE';
					$results['remove'][$result] = $tag_id;
				}
			}
		}

				$tags['add'] = array_filter($tag_ids, function($v) {
			return $v > 0;
		});

		if ( ! empty($tags['add']) ) {
			if( $rest ){
				$response = $this->rest()->add_contact_tags($contact_id, $tags['add']);
				if( $response && ! is_wp_error($response) ){
					$results['add'] = $response;
				}
			}
			else{
				$results['add'] = ['SUCCESS' => [],'FAILURE' => []];
				foreach ($tags['add'] as $tag_id) {
					$added  = $this->isdk->grpAssign($contact_id, $tag_id);
					$result = $added ? 'SUCCESS' : 'FAILURE';
					$results['add'][$result] = $tag_id;
				}
			}
		}

		return $results;
	}

}
