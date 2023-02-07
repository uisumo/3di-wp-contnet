<?php
if ( !defined( 'ABSPATH' ) ) {
	die();
}




class infusionsoft_driver {
	private $api_log_table;
	private $api_log;
	private $app_host;
	private $app_name;
	private $client;
	private $connection_timeout = 10;
	private $crm_type;
	private $dbOn;
	private $email_notification;
	private $email_to;
	private $error_message;
	private $host_url;
	private $max_retries;
	private $valid_api;

	var $key;
	var $test_string;

	
function __construct() {
		$this->app_host           = '';
		$this->app_name           = '';
		$this->api_log            = 0;
		$this->api_log_table      = '';
		$this->client             = NULL;
		$this->crm_type           = 'i';
		$this->dbOn               = 'off';
		$this->email_notification = 0;
		$this->email_to           = get_option( 'admin_email' );
		$this->error_message      = '';
		$this->host_url           = '';
		$this->key                = NULL;
		$this->max_retries        = 3;
		$this->valid_api          = 0;
		$GLOBALS['xmlrpcName']    = 'i2SDK API / v' . I2SDK_VERSION . ' / ' . get_option( 'siteurl' ) . ' / ' . $this->email_to . ' / XML-RPC';

		if (! function_exists('xmlrpc_encode_entitites') && ! function_exists('xmlrpc_se') ) {
			include_once I2SDK_DIR . '/vendor/isdk/phpxmlrpc-4.2.0/lib/xmlrpc.inc';
		}
	}

	
function set_crm_type( string $type) {
		$success = false;
		$type    = substr( strtolower( trim( $type ) ), 1, 1 );

		switch ( $type ) {
		case 'm':
			$this->$crm_type = 'm';
			$success         = true;
			break;
		default:
			$this->$crm_type = 'i';
			$success         = true;
			break;
		}

		if ( $this->app_host > '' && $this->key > '' ) {
			$this->configureConnection( $this->app_host, $this->key, $this->crm_type, $this->$dbOn );
		}

		return $success;
	}

	
function setAppName( string $appname) {
		if ( defined( 'I2SDK_APP_NAME' ) ) {
			$appname = strtolower( I2SDK_APP_NAME );
		}
		else {
			$appname = strtolower( trim( $appname ) );
		}

		if ( $appname > '' ) {
			$this->app_host = $appname;
			$this->app_name = $appname;
		}

		if ( $this->app_host > '' && $this->key > '' ) {
			$this->configureConnection( $this->app_host, $this->key, $this->crm_type, $this->$dbOn );
		}
	}

	
function getAppName() {
		return $this->app_name;
	}

	
function setAPIKey( string $api_key) {
		if ( defined( 'I2SDK_API_KEY' ) ) {
			$api_key = trim( I2SDK_API_KEY );
		}
		else {
			$api_key = trim( $api_key );
		}

		$api_key   = trim( $api_key );
		$this->key = $api_key;

		if ( $this->app_host > '' && $this->key > '' ) {
			$this->configureConnection( $this->app_host, $this->key, $this->crm_type, $this->$dbOn );
		}
	}

	
function enableLogging( $status ) {
		if ( is_integer( $status ) && $status == 1 || $status == 0 ) {
			$status = (boolean) $status;
		}

		if ( is_bool( $status ) ) {
			$this->api_log = $status;

			return true;
		}

		return false;
	}

	
function setApiLogTable( $api_log_table ) {
		$api_log_table       = trim( $api_log_table );
		$this->api_log_table = $api_log_table;
	}

	
function setEmailNotification($email_notification) {
		$this->email_notification = (int) $email_notification;
	}

	
function setEmailTo( $email_to ) {
		$this->email_to = trim($email_to);
	}

	
function setRetryCount( $retry_count ) {
		$new_retry_count = (int) $retry_count;

		if ($new_retry_count >= 0) {
			$this->max_retries = (int) $retry_count;
		}
	}

	
function getRetryCount() {
		return $this->max_retries;
	}

			
	
function configureConnection(string $appname, string $api_key, string $crm_type = 'i', string $dbOn = 'off') {
		$crm_type    = strtolower($crm_type);
		$this->debug = $dbOn;
		$this->key   = $api_key;

		if (! empty($appname) ) {
			if ( $crm_type == 'i' ) {
				$this->app_host = $appname . '.infusionsoft.com';
				$this->app_name = $appname;
				$this->host_url = 'https://' . $appname . '.infusionsoft.com/api/xmlrpc';
			}
			elseif ( $crm_type == 'm' ) {
				$this->app_host = $appname . '.mortgageprocrm.com';
				$this->host_url = 'https://' . $appname . '.mortgageprocrm.com/api/xmlrpc';
			} else {
				return false;
			}
		}

		$ca_certificate = I2SDK_DIR . 'vendor/isdk/infusionsoft.pem';
		$this->client   = new xmlrpc_client( $this->host_url );

		$this->client->setSSLVerifyHost( false );
        $this->client->setCaCertificate( $ca_certificate );
		$this->client->return_type = 'phpvals';

		return true;
	}

	
function methodCaller( string $service, array $callArray ) {
		global $wpdb;

		if ( ! method_exists( $this->client, 'send' ) ) {
			return '[API Key Error]';
		}

		$retry       = false;
		$start_time  = microtime(true);
		$retry_count = 0;

		do {
			sleep($retry_count);
			$call   = new xmlrpcmsg( $service, $callArray );
			$result = $this->client->send( $call, $this->connection_timeout );

			memberium_app()->m4is_taocq( 0 );

			if ( $result->errno === 10  ) {
				$GLOBALS['i2sdk']->syncCustomFields();
				sleep(1);
				$result = $this->client->send($call, $this->connection_timeout);
				memberium_app()->m4is_taocq( 0 );
			}

			if ( $this->api_log == 1 ) {
				$current_user = wp_get_current_user();
				
				$wpdb->insert(
					$this->api_log_table,
					[
						'appname'    => $this->app_name,
						'ip_address' => $_SERVER['REMOTE_ADDR'],
						'duration'   => ( microtime(true) - $start_time ),
						'user'       => $current_user->user_login,
						'service'    => $service,
						'caller'     => $call->serialize(),
						'result'     => utf8_encode(var_export($result->value(), true) ),
						'retries'    => $retry_count,
					]
				);
			}

			if ( $this->email_notification == 1 ) {
				$error_notice .=
					'Retry:        ' . $retry_count . "\n\n" .
					'FaultCode:    ' . $result->faultCode() . "\n\n" .
					'FaultString:  ' . $result->faultString() . "\n\n" .
					'Service:      ' . $service . "\n\n" .
					'CallArray:    ' . print_r( $callArray, true ) . "\n\n" .
					'DocumentRoot: ' . $_SERVER["DOCUMENT_ROOT"] . "\n\n" .
					'RequestURI:   ' . $_SERVER["REQUEST_URI"] . "\n\n" .
					'Session:      ' . print_r( $_SESSION, true ) . "\n\n" .
					'';
			}

			if ( ! $result->faultCode() ) {
				if ( $retry_count && $this->email_notification ) {
										mail( $this->email_to, 'i2SDK Error Success on Retry', $error_notice );
				}

				$data = $result->value();

				if (extension_loaded('mbstring') && function_exists('utf8_encode') ) {
					if (is_array($data)) {
						array_walk_recursive($data, function(&$v, $k) {
							if (mb_detect_encoding($v) <> 'UTF-8') {
								$v = utf8_encode($v);
							}
						});
					}

					elseif (is_string($data)) {
						if (mb_detect_encoding($data) <> 'UTF-8') {
							$data = utf8_encode($data);
						}
					}
				}

				return $data;
			}
			else {
				switch ( $result->faultCode() ) {
				case -1: 					break;
				case 2:  															return false;
					break;
				case 5:  					break;
				case 6:  					break;
				case 8:  					break;
				case 12: 					$retry = false;
					break;
				case 500: 					$retry = true;
					if ( $result->faultstring() == 'Server encountered exception: java.lang.Exception: IP access not allowed' ) {
						$retry = false;
					}
					break;
				default:
					$retry = true;
					break;
				}

				if ($this->email_notification == 1) {
					mail( $this->email_to, 'i2SDK Error', $error_notice );
				}

				if ($this->debug == 'kill') {
					die( 'ERROR: ' . $result->faultCode() . ' - ' . $result->faultString() );
				}
				elseif ($this->debug == 'on') {
					return "ERROR: " . $result->faultCode() . ' - ' . $result->faultString();
				}
				elseif ($this->debug == 'off') {
									}
			}

			$retry_count++;
		} while (
			$retry_count < $this->max_retries && $retry == true
		);

		if ( $this->debug == 'kill' ) {
			die( 'ERROR: ' . $result->faultCode() . ' - ' . $result->faultString() );
		}
		elseif ( $this->debug == 'on' ) {
			return "ERROR: " . $result->faultCode() . ' - ' . $result->faultString();
		}
		elseif ( $this->debug == 'off' ) {
			return "ERROR: " . $result->faultCode() . ' - ' . $result->faultString();
		}
	}

	
function verify_Connection() {
		if ( ! is_object( $this->client ) )  {
			return false;
		}

		$result = trim( $this->dsGetSetting( 'Application', 'api_passphrase' ) );

		if ( strpos( $result, 'InvalidKey' ) == 12 || substr( $result, 0, 6 ) ==  'ERROR:' || empty( $result ) ) {
			$this->error_message = sprintf( 'Invalid API Key (%d): %s', __LINE__, $result );

			return false;
		}
		else {
			$this->error_message = NULL;

			return true;
		}
	}

	
function getWebTrackingScript() {
		$carray = [
			php_xmlrpc_encode($this->key),
		];

		return $this->methodCaller('WebTrackingService.getWebTrackingScriptTag', $carray);
	}

	
function get_ErrorMessage() {
		return $this->error_message;
	}

	
function set_retry( $retry_count ) {
		$this->max_retries = (int) $retry_count;
	}

			
	
function getFieldList( string $tablename ) {
		return m4is_f84s3h::m4is_cm6nr( $tablename, false );
	}

			
	
function dsQueryOrderBy( string $table, $limit, $page, array $query, array $return_fields, string $sort_field, $ascending = true ) {
		$return_fields = array_values( $return_fields );
		$call_array = [
			php_xmlrpc_encode( $this->key ),
			php_xmlrpc_encode( $table ),
			php_xmlrpc_encode( (int) $limit ),
			php_xmlrpc_encode( (int) $page ),
			php_xmlrpc_encode( $query, ['auto_dates'] ),
			php_xmlrpc_encode( array_values( $return_fields ) ),
			php_xmlrpc_encode( $sort_field ),
			php_xmlrpc_encode( (bool) $ascending )
		];

		return $this->methodCaller( 'DataService.query', $call_array );
	}

	
	
function listLinkedContacts( $contact_id ) {
		$parameters = [
			php_xmlrpc_encode( $this->key ),
			php_xmlrpc_encode( (int) $contact_id ),
		];

		return $this->methodCaller( 'ContactService.listLinkedContacts', $parameters );
	}

	
function LinkContacts( $contact1 = 0, $contact2 = 0, $link_type = 0 ) {
		$parameters = [
			php_xmlrpc_encode( $this->key ),
			php_xmlrpc_encode( (int) $contact1 ),
			php_xmlrpc_encode( (int) $contact2 ),
			php_xmlrpc_encode( (int) $link_type ),
		];

		return $this->methodCaller( 'ContactService.linkContacts', $parameters );
	}

	
function UnlinkContacts( $contact1 = 0, $contact2 = 0, $link_type = 0 ) {
		$carray = [
			php_xmlrpc_encode( $this->key ),
			php_xmlrpc_encode( (int) $contact1 ),
			php_xmlrpc_encode( (int) $contact2 ),
			php_xmlrpc_encode( (int) $link_type ),
		];

		return $this->methodCaller( 'ContactService.unlinkContacts', $carray );
	}

	
	
function getFile( $file_id ) {
		$this->client->setAcceptedCompression('');

		$carray = [
			php_xmlrpc_encode( $this->key ),
			php_xmlrpc_encode( (int) $file_id )
		];
		$result = $this->methodCaller( 'FileService.getFile', $carray );

		$this->client->setAcceptedCompression( 'any' );

		return $result;
	}

		
function uploadFile( string $file_name, string $base64_encoded_data, $cid = 0 ) {
		$cid = (int) $cid;
		$file_name = trim( $file_name );

		if ( $cid == 0 ) {
			$carray = [
				php_xmlrpc_encode( $this->key ),
				php_xmlrpc_encode( $file_name ),
				php_xmlrpc_encode( $base64_encoded_data )
			];
		}
		else {
			$carray = [
				php_xmlrpc_encode( $this->key ),
				php_xmlrpc_encode( (int) $cid ),
				php_xmlrpc_encode( $file_name ),
				php_xmlrpc_encode( $base64_encoded_data )
			];
		}

		return $this->methodCaller( 'FileService.uploadFile', $carray );
	}

		
function replaceFile( $file_id, string $base64_encoded_data ) {
		$carray = [
			php_xmlrpc_encode( $this->key ),
			php_xmlrpc_encode( (int) $file_id ),
			php_xmlrpc_encode( $base64_encoded_data )
		];

		return $this->methodCaller( 'FileService.replaceFile', $carray );
	}

		
function renameFile( $file_id, string $file_name ) {
		$carray = [
			php_xmlrpc_encode( $this->key ),
			php_xmlrpc_encode( (int) $file_id ),
			php_xmlrpc_encode( $file_name )
		];

		return $this->methodCaller( 'FileService.renameFile', $carray );
	}

		
function getDownloadUrl( $file_id ) {
		$carray = [
			php_xmlrpc_encode( $this->key ),
			php_xmlrpc_encode( (int) $file_id )
		];

		return $this->methodCaller( 'FileService.getDownloadUrl', $carray );
	}

	
function addCon( array $cMap, string $optin_reason = '') {
		$parameters = [
			php_xmlrpc_encode( $this->key ),
			php_xmlrpc_encode( $cMap, ['auto_dates'] )
		];

		$contact_id = $this->methodCaller( 'ContactService.add', $parameters );

		if ( ! empty( $cMap['Email'] ) ) {
			if ( empty( $optin_reason ) ) {
				$this->optIn( $cMap['Email'] );
			}
			else {
				$this->optIn($cMap['Email'], $optin_reason);
			}
		}

		return $$contact_id;
	}

		
function updateCon( $cid, array $cMap ) {
		$carray = [
			php_xmlrpc_encode( $this->key ),
			php_xmlrpc_encode( (int) $cid ),
			php_xmlrpc_encode( $cMap, ['auto_dates'] )
		];

		return $this->methodCaller( 'ContactService.update', $carray );
	}

		
function mergeCon( $cid, $dcid ) {
		$carray = [
			php_xmlrpc_encode( $this->key ),
			php_xmlrpc_encode( (int) $cid ),
			php_xmlrpc_encode( (int) $dcid )
		];

		return $this->methodCaller( 'ContactService.merge', $carray );
	}

	
function findByEmail( string $eml, array $fMap ) {
		$carray = [
			php_xmlrpc_encode( $this->key ),
			php_xmlrpc_encode( $eml ),
			php_xmlrpc_encode( array_values( $fMap ) )
		];

		return $this->methodCaller( 'ContactService.findByEmail', $carray );
	}

	
function loadCon( $cid, array $rFields ) {
		$carray = [
			php_xmlrpc_encode( $this->key ),
			php_xmlrpc_encode( (int) $cid ),
			php_xmlrpc_encode( array_values( $rFields ) )
		];

		return $this->methodCaller( 'ContactService.load', $carray );
	}

	
function grpAssign( $cid, $gid ) {
		$carray = [
			php_xmlrpc_encode( $this->key ),
			php_xmlrpc_encode( (int) $cid ),
			php_xmlrpc_encode( (int) $gid )
		];

		return $this->methodCaller( 'ContactService.addToGroup', $carray );
	}

		
function grpRemove( $cid, $gid ) {
		$carray = [
			php_xmlrpc_encode( $this->key ),
			php_xmlrpc_encode( (int) $cid ),
			php_xmlrpc_encode( (int) $gid )
		];

		return $this->methodCaller( 'ContactService.removeFromGroup', $carray );
	}

	
function campAssign( $cid, $campId ) {
		$carray = array(
			php_xmlrpc_encode( $this->key ),
			php_xmlrpc_encode( (int) $cid ),
			php_xmlrpc_encode( (int) $campId )
		);

		return $this->methodCaller( 'ContactService.addToCampaign', $carray );
	}

	
function getNextCampaignStep( $cid, $campId ) {
		$carray = array(
			php_xmlrpc_encode( $this->key ),
			php_xmlrpc_encode( (int) $cid ),
			php_xmlrpc_encode( (int) $campId )
		);

		return $this->methodCaller( 'ContactService.getNextCampaignStep', $carray );
	}

	
function getCampaigneeStepDetails( $cid, $stepId ) {
		$carray = array(
			php_xmlrpc_encode( $this->key ),
			php_xmlrpc_encode( (int) $cid ),
			php_xmlrpc_encode( (int) $stepId )
		);

		return $this->methodCaller( 'ContactService.getCampaigneeStepDetails', $carray );
	}

	
function rescheduleCampaignStep( $cidList, $campId ) {
		$carray = array(
			php_xmlrpc_encode( $this->key ),
			php_xmlrpc_encode( (int) $cidList ),
			php_xmlrpc_encode( (int) $campId )
		);

		return $this->methodCaller( 'ContactService.rescheduleCampaignStep', $carray );
	}

	
function campRemove( $cid, $campId ) {
		$carray = array(
			php_xmlrpc_encode( $this->key ),
			php_xmlrpc_encode( (int) $cid ),
			php_xmlrpc_encode( (int) $campId )
		);

		return $this->methodCaller( 'ContactService.removeFromCampaign', $carray );
	}

	
function campPause( $cid, $campId ) {
		$carray = array(
			php_xmlrpc_encode( $this->key ),
			php_xmlrpc_encode( (int) $cid ),
			php_xmlrpc_encode( (int) $campId )
		);

		return $this->methodCaller( 'ContactService.pauseCampaign', $carray );
	}

	
function runAS( $cid, $aid ) {
		$carray = [
			php_xmlrpc_encode( $this->key ),
			php_xmlrpc_encode( (int) $cid ),
			php_xmlrpc_encode( (int) $aid )
		];

		return $this->methodCaller( 'ContactService.runActionSequence', $carray );
	}

		
function applyActivityHistoryTemplate( $contactId, $historyId, $userId ) {
		$carray = [
			php_xmlrpc_encode( $this->key ),
			php_xmlrpc_encode( (int) $contactId ),
			php_xmlrpc_encode( (int) $historyId ),
			php_xmlrpc_encode( (int) $userId )
		];

		return $this->methodCaller( 'ContactService.applyActivityHistoryTemplate', $carray );
	}

	
function dsGetSetting( string $module, string $setting ) {
		$carray = [
			php_xmlrpc_encode( $this->key ),
			php_xmlrpc_encode( $module ),
			php_xmlrpc_encode( $setting )
		];

		return $this->methodCaller( 'DataService.getAppSetting', $carray );
	}

	
function dsAdd( string $tName, array $iMap ) {
		$carray = array(
			php_xmlrpc_encode( $this->key ),
			php_xmlrpc_encode( $tName ),
			php_xmlrpc_encode( $iMap, ['auto_dates'] )
		);

		return $this->methodCaller( 'DataService.add', $carray );
	}

	
function dsAddWithImage( string $tName, $iMap ) {
		$carray = array(
			php_xmlrpc_encode( $this->key ),
			php_xmlrpc_encode( $tName ),
			php_xmlrpc_encode( $iMap, ['auto_dates', 'auto_base64'] )
		);

		return $this->methodCaller( 'DataService.add', $carray );
	}

	
function dsCount( string $tName, array $query ) {
		$carray = [
			php_xmlrpc_encode( $this->key ),
			php_xmlrpc_encode( $tName ),
			php_xmlrpc_encode( $query )
		];

		return $this->methodCaller( 'DataService.count', $carray );
	}

	
function dsDelete( string $tName, $id ) {
		$carray = [
			php_xmlrpc_encode( $this->key ),
			php_xmlrpc_encode( $tName ),
			php_xmlrpc_encode( (int) $id )
		];

		return $this->methodCaller( 'DataService.delete', $carray );
	}

		
function dsUpdate( string $tName, $id, array $iMap ) {
		$carray = [
			php_xmlrpc_encode( $this->key ),
			php_xmlrpc_encode( $tName ),
			php_xmlrpc_encode( (int) $id ),
			php_xmlrpc_encode( $iMap, ['auto_dates'] )
		];

		return $this->methodCaller( 'DataService.update', $carray );
	}

	
function dsUpdateWithImage( string $tName, $id, array $iMap ) {
		$carray = array(
			php_xmlrpc_encode( $this->key ),
			php_xmlrpc_encode( $tName ),
			php_xmlrpc_encode( (int) $id ),
			php_xmlrpc_encode( $iMap, ['auto_dates', 'auto_base64'] )
		);

		return $this->methodCaller( 'DataService.update', $carray );
	}

		
function dsLoad( string $tName, $id, array $rFields ) {
        $carray  = array(
			php_xmlrpc_encode( $this->key ),
			php_xmlrpc_encode( $tName ),
			php_xmlrpc_encode( (int) $id ),
			php_xmlrpc_encode( array_values( $rFields ) )
		);

		return $this->methodCaller( 'DataService.load', $carray );
	}

		
function dsFind( string $tName, $limit, $page, string $field, string $value, array $rFields ) {
		$carray = array(
			php_xmlrpc_encode( $this->key ),
			php_xmlrpc_encode( $tName ),
			php_xmlrpc_encode( (int) $limit ),
			php_xmlrpc_encode( (int) $page ),
			php_xmlrpc_encode( $field ),
			php_xmlrpc_encode( $value ),
			php_xmlrpc_encode( array_values( $rFields ) )
		);

		return $this->methodCaller( 'DataService.findByField', $carray );
	}

		
function dsQuery(string $table_name, $limit, $page, array $query, array $fields) {
		$carray = [
			php_xmlrpc_encode( $this->key ),
			php_xmlrpc_encode( $table_name ),
			php_xmlrpc_encode( (int) $limit ),
			php_xmlrpc_encode( (int) $page ),
			php_xmlrpc_encode( $query, ['auto_dates'] ),
			php_xmlrpc_encode( array_values( $fields ) )
		];

		return $this->methodCaller( 'DataService.query', $carray );
	}

		
function addCustomField( string $context, string $displayName, string $dataType, $groupID ) {
		$carray = [
			php_xmlrpc_encode( $this->key ),
			php_xmlrpc_encode( $context ),
			php_xmlrpc_encode( $displayName ),
			php_xmlrpc_encode( $dataType ),
			php_xmlrpc_encode( (int) $groupID )
		];

		return $this->methodCaller( 'DataService.addCustomField', $carray );
	}

		
function authenticateUser( string $userName, string $password ) {
		$password = strtolower( md5( $password ) );
		$carray = [
			php_xmlrpc_encode( $this->key ),
			php_xmlrpc_encode( $userName ),
			php_xmlrpc_encode( $password )
		];

		return $this->methodCaller('DataService.authenticateUser', $carray);
	}

	
function updateCustomField( $field_id, $fieldValues ) {
		$carray = [
			php_xmlrpc_encode( $this->key ),
			php_xmlrpc_encode( (int) $field_id ),
			php_xmlrpc_encode( $fieldValues )
		];

		return $this->methodCaller('DataService.updateCustomField', $carray );
	}

		
	
function deleteInvoice( $invoice_id ) {
		$parameters = [
			php_xmlrpc_encode( $this->key ),
			php_xmlrpc_encode( (int) $invoice_id )
		];

		return $this->methodCaller( 'InvoiceService.deleteInvoice', $parameters );
	}

	
function deleteSubscription( $subscription_id ) {
		$parameters = [
			php_xmlrpc_encode( $this->key ),
			php_xmlrpc_encode( (int) $subscription_id )
		];

		return $this->methodCaller( 'InvoiceService.deleteSubscription', $parameters );
	}

	

		
function getPayments( $Id ) {
		$carray = [
			php_xmlrpc_encode( $this->key ),
			php_xmlrpc_encode( (int) $Id )
		];

		return $this->methodCaller( 'InvoiceService.getPayments', $carray );
	}

		
function setInvoiceSyncStatus( $Id, string $syncStatus ) {
		$carray = [
			php_xmlrpc_encode( $this->key ),
			php_xmlrpc_encode( (int) $Id ),
			php_xmlrpc_encode( $syncStatus )
		];

		return $this->methodCaller( 'InvoiceService.setInvoiceSyncStatus', $carray );
	}

	
function setPaymentSyncStatus( $Id, string $Status ) {
		$carray = [
			php_xmlrpc_encode( $this->key ),
			php_xmlrpc_encode( (int) $Id ),
			php_xmlrpc_encode( $Status )
		];

		return $this->methodCaller( 'InvoiceService.setPaymentSyncStatus', $carray );
	}

	
function getPluginStatus( string $className ) {
		$carray = [
			php_xmlrpc_encode( $this->key ),
			php_xmlrpc_encode( $className )
		];

		return $this->methodCaller( 'InvoiceService.getPluginStatus', $carray );
	}
		
function getAllShippingOptions() {
		$carray = array(
			php_xmlrpc_encode( $this->key ) );
		return
		$this->methodCaller( "InvoiceService.getAllShippingOptions", $carray );
	}
		
function getAllPaymentOptions() {
		$carray = array(
			php_xmlrpc_encode( $this->key ) );
		return
		$this->methodCaller( "InvoiceService.getAllPaymentOptions", $carray );
	}

	
function manualPmt( $invId, $amt, string $payDate, $payType, string $payDesc, $bypassComm ) {
		$carray = array(
			php_xmlrpc_encode( $this->key ),
			php_xmlrpc_encode( (int) $invId ),
			php_xmlrpc_encode( $amt ),
			php_xmlrpc_encode( $payDate, array( 'auto_dates' ) ),
			php_xmlrpc_encode( $payType ),
			php_xmlrpc_encode( $payDesc ),
			php_xmlrpc_encode( $bypassComm )
		);

		return $this->methodCaller( 'InvoiceService.addManualPayment', $carray );
	}

		
function commOverride( $invId, $affId, $prodId, $percentage, $amt, $payType, string $desc, string $date ) {
		$carray = [
			php_xmlrpc_encode( $this->key ),
			php_xmlrpc_encode( (int) $invId ),
			php_xmlrpc_encode( (int) $affId ),
			php_xmlrpc_encode( (int) $prodId ),
			php_xmlrpc_encode( (int) $percentage ),
			php_xmlrpc_encode( $amt ),
			php_xmlrpc_encode( (int) $payType ),
			php_xmlrpc_encode( $desc ),
			php_xmlrpc_encode( $date, ['auto_dates'] )
		];

		return $this->methodCaller( 'InvoiceService.addOrderCommissionOverride', $carray );
	}

		
function addOrderItem( $ordId, $prodId, $type, $price, $qty, string $desc, string $notes ) {
		$carray = array(
			php_xmlrpc_encode( $this->key ),
			php_xmlrpc_encode( (int) $ordId ),
			php_xmlrpc_encode( (int) $prodId ),
			php_xmlrpc_encode( (int) $type ),
			php_xmlrpc_encode( (double) $price ),
			php_xmlrpc_encode( (int) $qty ),
			php_xmlrpc_encode( $desc ),
			php_xmlrpc_encode( $notes )
		);

		return $this->methodCaller( 'InvoiceService.addOrderItem', $carray );
	}

		
function payPlan( $ordId, $aCharge, $ccId, $merchId, $retry, $retryAmt, $initialPmt, string $initialPmtDate, string $planStartDate, $numPmts, $pmtDays ) {
		$carray = [
			php_xmlrpc_encode( $this->key ),
			php_xmlrpc_encode( (int) $ordId ),
			php_xmlrpc_encode( (bool) $aCharge ),
			php_xmlrpc_encode( (int) $ccId ),
			php_xmlrpc_encode( (int) $merchId ),
			php_xmlrpc_encode( (int) $retry ),
			php_xmlrpc_encode( (int) $retryAmt ),
			php_xmlrpc_encode( $initialPmt ),
			php_xmlrpc_encode( $initialPmtDate, ['auto_dates'] ),
			php_xmlrpc_encode( $planStartDate, ['auto_dates'] ),
			php_xmlrpc_encode( (int) $numPmts ),
			php_xmlrpc_encode( (int) $pmtDays )
		];

		return $this->methodCaller( 'InvoiceService.addPaymentPlan', $carray );
	}

		
function recurringCommOverride( $recId, $affId, $amt, $payType, string $desc ) {
		$carray = array(
			php_xmlrpc_encode( $this->key ),
			php_xmlrpc_encode( (int) $recId ),
			php_xmlrpc_encode( (int) $affId ),
			php_xmlrpc_encode( $amt ),
			php_xmlrpc_encode( $payType ),
			php_xmlrpc_encode( $desc )
		);

		return
		$this->methodCaller( 'InvoiceService.addRecurringCommissionOverride', $carray )
		;
	}

		
function addRecurring( $cid, $allowDup, $progId, $merchId, $ccId, $affId, $daysToCharge ) {
		$carray = array(
			php_xmlrpc_encode( $this->key ),
			php_xmlrpc_encode( (int) $cid ),
			php_xmlrpc_encode( (bool) $allowDup ),
			php_xmlrpc_encode( (int) $progId ),
			php_xmlrpc_encode( (int) $merchId ),
			php_xmlrpc_encode( (int) $ccId ),
			php_xmlrpc_encode( (int) $affId ),
			php_xmlrpc_encode( (int) $daysToCharge )
		);

		return $this->methodCaller( 'InvoiceService.addRecurringOrder', $carray );
	}

		
function addRecurringAdv( $cid,  $allowDup, $progId, $qty, $price, $allowTax, $merchId, $ccId, $affId = 0, $daysToCharge = 0 ) {
		$carray = array(
			php_xmlrpc_encode( $this->key ),
			php_xmlrpc_encode( (int) $cid ),
			php_xmlrpc_encode( (bool) $allowDup ),
			php_xmlrpc_encode( (int) $progId ),
			php_xmlrpc_encode( (int) $qty ),
			php_xmlrpc_encode( (double) $price ),
			php_xmlrpc_encode( (bool) $allowTax ),
			php_xmlrpc_encode( (int) $merchId ),
			php_xmlrpc_encode( (int) $ccId ),
			php_xmlrpc_encode( (int) $affId ),
			php_xmlrpc_encode( (int) $daysToCharge )
		);

		return $this->methodCaller( 'InvoiceService.addRecurringOrder', $carray );
	}

		
function amtOwed( $invId ) {

		$carray = array(
			php_xmlrpc_encode( $this->key ),
			php_xmlrpc_encode( (int) $invId ) );

		return
		$this->methodCaller( 'InvoiceService.calculateAmountOwed', $carray );
	}

		
function getInvoiceId( $orderId ) {

		$carray = array(
			php_xmlrpc_encode( $this->key ),
			php_xmlrpc_encode( (int) $orderId )
		);

		return $this->methodCaller( 'InvoiceService.getInvoiceId', $carray );
	}

		
function getOrderId( $invoiceId ) {
		$carray = array(
			php_xmlrpc_encode( $this->key ),
			php_xmlrpc_encode( (int) $invoiceId ) );

		return $this->methodCaller( 'InvoiceService.getOrderId', $carray );
	}

		
function chargeInvoice( int $invId, string $notes, int $ccId, int $merchId, bool $bypassComm ) {
		$carray = array(
			php_xmlrpc_encode( $this->key ),
			php_xmlrpc_encode( (int) $invId ),
			php_xmlrpc_encode( $notes ),
			php_xmlrpc_encode( (int) $ccId ),
			php_xmlrpc_encode( (int) $merchId ),
			php_xmlrpc_encode( (bool) $bypassComm )
		);

		return $this->methodCaller( 'InvoiceService.chargeInvoice', $carray );
	}

		
function blankOrder( $conId, string $desc, string $oDate, $leadAff, $saleAff ) {
		$carray = array(
			php_xmlrpc_encode( $this->key ),
			php_xmlrpc_encode( (int) $conId ),
			php_xmlrpc_encode( $desc ),
			php_xmlrpc_encode( $oDate, ['auto_dates'] ),
			php_xmlrpc_encode( (int) $leadAff ),
			php_xmlrpc_encode( (int) $saleAff ) );

		return $this->methodCaller( 'InvoiceService.createBlankOrder', $carray );
	}

		
function recurringInvoice( $rid ) {
		$carray = array(
			php_xmlrpc_encode( $this->key ),
			php_xmlrpc_encode( (int) $rid ) );

		return $this->methodCaller( 'InvoiceService.createInvoiceForRecurring', $carray );
	}

		
function locateCard( $cid, string $last4 ) {
		$carray = array(
			php_xmlrpc_encode( $this->key ),
			php_xmlrpc_encode( (int) $cid ),
			php_xmlrpc_encode( $last4 )
		);

		return $this->methodCaller( 'InvoiceService.locateExistingCard', $carray );
	}

			
function validateCard( $creditCard ) {
		$creditCard = is_array( $creditCard ) ? $creditCard : (int) $creditCard;

		$carray = array(
			php_xmlrpc_encode( $this->key ),
			php_xmlrpc_encode( $creditCard )
		);

		return $this->methodCaller( 'InvoiceService.validateCreditCard', $carray );
	}

		
function updateSubscriptionNextBillDate( $subscriptionId, string $nextBillDate ) {
		$carray = array(
			php_xmlrpc_encode( $this->key ),
			php_xmlrpc_encode( (int) $subscriptionId ),
			php_xmlrpc_encode( $nextBillDate, ['auto_dates'] )
		);

		return $this->methodCaller( 'InvoiceService.updateJobRecurringNextBillDate' , $carray );
	}

		
function attachEmail( $cId, string $fromName, string $fromAddress, string $toAddress, string $ccAddresses, string $bccAddresses, string $contentType, string $subject, string $htmlBody, string $txtBody, string $header, string $strRecvdDate, string $strSentDate, $emailSentType = 1 ) {
		$carray = array(
			php_xmlrpc_encode( $this->key ),
			php_xmlrpc_encode( (int) $cId ),
			php_xmlrpc_encode( $fromName ),
			php_xmlrpc_encode( $fromAddress ),
			php_xmlrpc_encode( $toAddress ),
			php_xmlrpc_encode( $ccAddresses ),
			php_xmlrpc_encode( $bccAddresses ),
			php_xmlrpc_encode( $contentType ),
			php_xmlrpc_encode( $subject ),
			php_xmlrpc_encode( $htmlBody ),
			php_xmlrpc_encode( $txtBody ),
			php_xmlrpc_encode( $header ),
			php_xmlrpc_encode( $strRecvdDate ),
			php_xmlrpc_encode( $strSentDate ),
			php_xmlrpc_encode( (int) $emailSentType )
		);

		return $this->methodCaller( 'APIEmailService.attachEmail', $carray );
	}

		
function getAvailableMergeFields( string $mergeContext ) {
		$carray = array(
			php_xmlrpc_encode( $this->key ),
			php_xmlrpc_encode( $mergeContext )
		);

		return $this->methodCaller( 'APIEmailService.getAvailableMergeFields', $carray );
	}

		
function sendEmail( array $conList, string $fromAddress, string $toAddress, string $ccAddresses, string $bccAddresses, string $contentType, string $subject, string $htmlBody, string $txtBody ) {
		$carray = array(
			php_xmlrpc_encode( $this->key ),
			php_xmlrpc_encode( $conList ),
			php_xmlrpc_encode( $fromAddress ),
			php_xmlrpc_encode( $toAddress ),
			php_xmlrpc_encode( $ccAddresses ),
			php_xmlrpc_encode( $bccAddresses ),
			php_xmlrpc_encode( $contentType ),
			php_xmlrpc_encode( $subject ),
			php_xmlrpc_encode( $htmlBody ),
			php_xmlrpc_encode( $txtBody )
		);

		return $this->methodCaller( 'APIEmailService.sendEmail', $carray );
	}


		
function sendTemplate( array $conList, string $template ) {
		$conList = array_values( $conList );

		$carray = array(
			php_xmlrpc_encode( $this->key ),
			php_xmlrpc_encode( $conList ),
			php_xmlrpc_encode( $template ) );

		return $this->methodCaller( 'APIEmailService.sendEmail', $carray );
	}

		
function createEmailTemplate( string $title, $userID, string $fromAddress, string $toAddress, string $ccAddresses, string $bccAddresses, string $contentType, string $subject, string $htmlBody, string $txtBody ) {
		$carray = array(
			php_xmlrpc_encode( $this->key ),
			php_xmlrpc_encode( $title ),
			php_xmlrpc_encode( (int) $userID ),
			php_xmlrpc_encode( $fromAddress ),
			php_xmlrpc_encode( $toAddress ),
			php_xmlrpc_encode( $ccAddresses ),
			php_xmlrpc_encode( $bccAddresses ),
			php_xmlrpc_encode( $contentType ),
			php_xmlrpc_encode( $subject ),
			php_xmlrpc_encode( $htmlBody ),
			php_xmlrpc_encode( $txtBody ) );

		return
		$this->methodCaller( 'APIEmailService.createEmailTemplate', $carray );
	}

	
function addEmailTemplate( string $title, string $category, string $fromAddress, string $toAddress, string $ccAddresses, string $bccAddresses, string $subject, string $txtBody, string $htmlBody, string $contentType, string $mergeContext ) {
		$carray = array(
			php_xmlrpc_encode( $this->key ),
			php_xmlrpc_encode( $title ),
			php_xmlrpc_encode( $category ),
			php_xmlrpc_encode( $fromAddress ),
			php_xmlrpc_encode( $toAddress ),
			php_xmlrpc_encode( $ccAddresses ),
			php_xmlrpc_encode( $bccAddresses ),
			php_xmlrpc_encode( $subject ),
			php_xmlrpc_encode( $txtBody ),
			php_xmlrpc_encode( $htmlBody ),
			php_xmlrpc_encode( $contentType ),
			php_xmlrpc_encode( $mergeContext ) );

		return $this->methodCaller( 'APIEmailService.addEmailTemplate', $carray );
	}


		
function getEmailTemplate( $templateId ) {
		$carray = array(
			php_xmlrpc_encode( $this->key ),
			php_xmlrpc_encode( (int) $templateId )
		);

		return $this->methodCaller( 'APIEmailService.getEmailTemplate', $carray );
	}

		
function updateEmailTemplate( $templateID, string $title, string $categories, string $fromAddress, string $toAddress, string $ccAddress, string $bccAddress, string $subject, string $textBody, string $htmlBody, string $contentType, string $mergeContext ) {
		$carray = array(
			php_xmlrpc_encode( $this->key ),
			php_xmlrpc_encode( (int) $templateID ),
			php_xmlrpc_encode( $title ),
			php_xmlrpc_encode( $categories ),
			php_xmlrpc_encode( $fromAddress ),
			php_xmlrpc_encode( $toAddress ),
			php_xmlrpc_encode( $ccAddress ),
			php_xmlrpc_encode( $bccAddress ),
			php_xmlrpc_encode( $subject ),
			php_xmlrpc_encode( $textBody ),
			php_xmlrpc_encode( $htmlBody ),
			php_xmlrpc_encode( $contentType ),
			php_xmlrpc_encode( $mergeContext )
		);

		return $this->methodCaller( 'APIEmailService.updateEmailTemplate', $carray );
	}

		
function optStatus( string $email ) {
		$parameters = [
			php_xmlrpc_encode( $this->key ),
			php_xmlrpc_encode( $email )
		];

		return $this->methodCaller( 'APIEmailService.getOptStatus', $parameters );
	}

			
function optIn( string $email, string $reason = 'API Opt In' ) {
		$parameters = [
			php_xmlrpc_encode( $this->key ),
			php_xmlrpc_encode( $email ),
			php_xmlrpc_encode( $reason )
		];

		return $this->methodCaller( 'APIEmailService.optIn', $parameters );
	}

	
function optOut( string $email, string $reason = 'API Opt Out' ) {
		$carray = array(
			php_xmlrpc_encode( $this->key ),
			php_xmlrpc_encode( $email ),
			php_xmlrpc_encode( $reason )
		);

		return $this->methodCaller( 'APIEmailService.optOut', $carray );
	}

		
function affClawbacks( $affId, string $startDate, string $endDate ) {
		$carray = array(
			php_xmlrpc_encode( $this->key ),
			php_xmlrpc_encode( (int) $affId ),
			php_xmlrpc_encode( $startDate, ['auto_dates'] ),
			php_xmlrpc_encode( $endDate, ['auto_dates'] )
		);

		return $this->methodCaller( 'APIAffiliateService.affClawbacks', $carray );
	}

		
function affCommissions( $affId, string $startDate, string $endDate ) {
		$carray = array(
			php_xmlrpc_encode( $this->key ),
			php_xmlrpc_encode( (int) $affId ),
			php_xmlrpc_encode( $startDate, ['auto_dates'] ),
			php_xmlrpc_encode( $endDate, ['auto_dates'] )
		);

		return $this->methodCaller( 'APIAffiliateService.affCommissions', $carray );
	}

		
function affPayouts( $affId, string $startDate, string $endDate ) {
		$carray = array(
			php_xmlrpc_encode( $this->key ),
			php_xmlrpc_encode( (int) $affId ),
			php_xmlrpc_encode( $startDate, ['auto_dates'] ),
			php_xmlrpc_encode( $endDate, ['auto_dates'] )
		);

		return $this->methodCaller( 'APIAffiliateService.affPayouts', $carray );
	}

		
function affRunningTotals( array $affList ) {
		$affList = array_values( $affList );
		$carray = array(
			php_xmlrpc_encode( $this->key ),
			php_xmlrpc_encode( $affList )
		);

		return $this->methodCaller( 'APIAffiliateService.affRunningTotals', $carray );
	}

		
function affSummary( array $affList, string $startDate, string $endDate ) {
		$affList = array_values( $affList );
		$carray = array(
			php_xmlrpc_encode( $this->key ),
			php_xmlrpc_encode( $affList ),
			php_xmlrpc_encode( $startDate, array( 'auto_dates' ) ),
			php_xmlrpc_encode( $endDate, array( 'auto_dates' ) )
		);

		return $this->methodCaller( 'APIAffiliateService.affSummary', $carray );
	}

		
function addMoveNotes( $ticketList, $moveNotes, $moveToStageId, $notifyIds ) {

		$carray = array(
			php_xmlrpc_encode( $this->key ),
			php_xmlrpc_encode( $ticketList ),
			php_xmlrpc_encode( $moveNotes ),
			php_xmlrpc_encode( $moveToStageId ),
			php_xmlrpc_encode( $notifyIds ) );

		return $this->methodCaller( "ServiceCallService.addMoveNotes", $carray );
	}

		
function moveTicketStage( $ticketID, $ticketStage, $moveNotes, $notifyIds ) {

		$carray = array(
			php_xmlrpc_encode( $this->key ),
			php_xmlrpc_encode( (int) $ticketID ),
			php_xmlrpc_encode( $ticketStage ),
			php_xmlrpc_encode( $moveNotes ),
			php_xmlrpc_encode( $notifyIds ) );

		return
		$this->methodCaller( "ServiceCallService.moveTicketStage", $carray );
	}

		
function infuDate( string $dateStr ) {
		$dArray = date_parse( $dateStr );

		if ( $dArray['error_count'] < 1 ) {
			$tStamp = mktime( $dArray['hour'], $dArray['minute'], $dArray['second'], $dArray['month'], $dArray['day'], $dArray['year'] );
			return date( 'Ymd\TH:i:s', $tStamp );
		}
		else {
			foreach ( $dArray['errors'] as $err ) {
				echo 'ERROR: ' . $err . '<br />';
			}
			die( 'The above errors prevented the application from executing properly.' );
		}
	}

		
function savedSearchAllFields( $savedSearchId, $userId, $page ) {
		$carray = array(
			php_xmlrpc_encode( $this->key ),
			php_xmlrpc_encode( (int) $savedSearchId ),
			php_xmlrpc_encode( (int) $userId ),
			php_xmlrpc_encode( (int) $page )
		);

		return $this->methodCaller( 'SearchService.getSavedSearchResultsAllFields', $carray );
	}

		
function savedSearch( $savedSearchId, $userId, $page, array $fields ) {
		$carray = array(
			php_xmlrpc_encode( $this->key ),
			php_xmlrpc_encode( (int) $savedSearchId ),
			php_xmlrpc_encode( (int) $userId ),
			php_xmlrpc_encode( (int) $page ),
			php_xmlrpc_encode( $fields )
		);

		return $this->methodCaller( 'SearchService.getSavedSearchResults', $carray );
	}

		
function getAvailableFields( $savedSearchId, $userId ) {
		$carray = array(
			php_xmlrpc_encode( $this->key ),
			php_xmlrpc_encode( (int) $savedSearchId ),
			php_xmlrpc_encode( (int) $userId )
		);

		return $this->methodCaller( 'SearchService.getAllReportColumns', $carray );
	}

		
function getDefaultQuickSearch( $userId ) {
		$carray = array(
			php_xmlrpc_encode( $this->key ),
			php_xmlrpc_encode( (int) $userId )
		);

		return $this->methodCaller( 'SearchService.getDefaultQuickSearch', $carray );
	}

		
function getQuickSearches( $userId ) {
		$carray = array(
			php_xmlrpc_encode( $this->key ),
			php_xmlrpc_encode( (int) $userId )
		);

		return $this->methodCaller( 'SearchService.getAvailableQuickSearches', $carray );
	}

		
function quickSearch( $quickSearchType, $userId, string $filterData, $page, $limit ) {
		$carray = array(
			php_xmlrpc_encode( $this->key ),
			php_xmlrpc_encode( (int) $quickSearchType ),
			php_xmlrpc_encode( (int) $userId ),
			php_xmlrpc_encode( $filterData ),
			php_xmlrpc_encode( (int) $page ),
			php_xmlrpc_encode( (int) $limit )
		);

		return $this->methodCaller( 'SearchService.quickSearch', $carray );
	}

		
function addWithDupCheck( array $cMap, string $checkType = '' ) {
		$carray = array(
			php_xmlrpc_encode( $this->key ),
			php_xmlrpc_encode( $cMap, ['auto_dates'] ),
			php_xmlrpc_encode( $checkType )
		);

		return $this->methodCaller( 'ContactService.addWithDupCheck', $carray );
	}

		
function recalculateTax( $invoiceId ) {
		$carray = array(
			php_xmlrpc_encode( $this->key ),
			php_xmlrpc_encode( (int) $invoiceId )
		);

		return $this->methodCaller( 'InvoiceService.recalculateTax', $carray );
	}

		
function getWebFormMap() {
		$carray = array(
			php_xmlrpc_encode( $this->key )
		);

		return $this->methodCaller( 'WebFormService.getMap', $carray );
	}

		
function getWebFormHtml( $webFormId ) {
		$carray = array(
			php_xmlrpc_encode( $this->key ),
			php_xmlrpc_encode( (int) $webFormId )
		);

		return $this->methodCaller( "WebFormService.getHTML", $carray );
	}

		
		
function getInventory( $productId ) {
		$carray = array(
			php_xmlrpc_encode( $this->key ),
			php_xmlrpc_encode( (int) $productId )
		);

		return $this->methodCaller( 'ProductService.getInventory', $carray );
	}

		
function incrementInventory( $productId ) {
		$carray = array(
			php_xmlrpc_encode( $this->key ),
			php_xmlrpc_encode( (int) $productId )
		);

		return $this->methodCaller( 'ProductService.incrementInventory', $carray );
	}

		
function decrementInventory( $productId ) {
		$carray = array(
			php_xmlrpc_encode( $this->key ),
			php_xmlrpc_encode( (int) $productId )
		);

		return $this->methodCaller( 'ProductService.decrementInventory', $carray );
	}

		
function increaseInventory( $productId, $quantity ) {
		$carray = array(
			php_xmlrpc_encode( $this->key ),
			php_xmlrpc_encode( (int) $productId ),
			php_xmlrpc_encode( (int) $quantity )
		);

		return $this->methodCaller( 'ProductService.increaseInventory', $carray );
	}

		
function decreaseInventory( $productId, $quantity ) {
		$carray = array(
			php_xmlrpc_encode( $this->key ),
			php_xmlrpc_encode( (int) $productId ),
			php_xmlrpc_encode( (int) $quantity )
		);
		return $this->methodCaller( 'ProductService.decreaseInventory', $carray );
	}

		
function deactivateCreditCard( $creditCardId ) {
		$carray = array(
			php_xmlrpc_encode( $this->key ),
			php_xmlrpc_encode( (int) $creditCardId )
		);

		return $this->methodCaller( 'ProductService.deactivateCreditCard', $carray );
	}

		
		
function getAllConfiguredShippingOptions() {
		$carray = array(
			php_xmlrpc_encode( $this->key )
		);

		return $this->methodCaller( 'ShippingService.getAllShippingOptions', $carray );
	}

		
function getFlatRateShippingOption( $optionId ) {
		$carray = array(
			php_xmlrpc_encode( $this->key ),
			php_xmlrpc_encode( (int) $optionId )
		);

		return $this->methodCaller( 'ShippingService.getFlatRateShippingOption', $carray );
	}

		
function getOrderTotalShippingOption( $optionId ) {
		$carray = array(
			php_xmlrpc_encode( $this->key ),
			php_xmlrpc_encode( (int) $optionId )
		);

		return $this->methodCaller( 'ShippingService.getOrderTotalShippingOption', $carray );
	}

		
function getOrderTotalShippingRanges( $optionId ) {
		$carray = [
			php_xmlrpc_encode( $this->key ),
			php_xmlrpc_encode( (int) $optionId )
		];

		return $this->methodCaller( 'ShippingService.getOrderTotalShippingRanges', $carray );
	}

		
function getProductBasedShippingOption( $optionId ) {
		$carray = [
			php_xmlrpc_encode( $this->key ),
			php_xmlrpc_encode( (int) $optionId )
		];

		return $this->methodCaller( "ShippingService.getProductBasedShippingOption", $carray );
	}

		
function getProductShippingPricesForProductShippingOption( $optionId ) {
		$carray = [
			php_xmlrpc_encode( $this->key ),
			php_xmlrpc_encode( (int) $optionId )
		];

		return $this->methodCaller( 'ShippingService.getProductShippingPricesForProductShippingOption', $carray );
	}

		
function getOrderQuantityShippingOption( $optionId ) {
		$carray = [
			php_xmlrpc_encode( $this->key ),
			php_xmlrpc_encode( (int) $optionId )
		];

		return $this->methodCaller( 'ShippingService.getOrderQuantityShippingOption', $carray );
	}

		
function getWeightBasedShippingOption( $optionId ) {
		$carray = [
			php_xmlrpc_encode( $this->key ),
			php_xmlrpc_encode( (int) $optionId )
		];

		return $this->methodCaller( 'ShippingService.getWeightBasedShippingOption', $carray );
	}

		
function getWeightBasedShippingRanges( $optionId ) {
		$carray = [
			php_xmlrpc_encode( $this->key ),
			php_xmlrpc_encode( (int) $optionId )
		];

		return $this->methodCaller( 'ShippingService.getWeightBasedShippingRanges', $carray );
	}

		
function getUpsShippingOption( $optionId ) {
		$carray = [
			php_xmlrpc_encode( $this->key ),
			php_xmlrpc_encode( (int) $optionId )
		];

		return $this->methodCaller( 'ShippingService.getUpsShippingOption', $carray );
	}

		
function addFreeTrial( string $name, string $description, $freeTrialDays, $hidePrice, $subscriptionPlanId ) {
		$carray = [
			php_xmlrpc_encode( $this->key ),
			php_xmlrpc_encode( $name ),
			php_xmlrpc_encode( $description ),
			php_xmlrpc_encode( (int) $freeTrialDays ),
			php_xmlrpc_encode( (int) $hidePrice ),
			php_xmlrpc_encode( (int) $subscriptionPlanId )
		];

		return $this->methodCaller( 'DiscountService.addFreeTrial', $carray );
	}

		
function getFreeTrial( $trialId ) {
		$carray = [
			php_xmlrpc_encode( $this->key ),
			php_xmlrpc_encode( (int) $trialId )
		];

		return $this->methodCaller( 'DiscountService.getFreeTrial', $carray );
	}

				
function addOrderTotalDiscount( string $name, string $description, $applyDiscountToCommission, $percentOrAmt, $amt, string $payType ) {
		$carray = [
			php_xmlrpc_encode( $this->key ),
			php_xmlrpc_encode( $name ),
			php_xmlrpc_encode( $description ),
			php_xmlrpc_encode( (int) $applyDiscountToCommission ),
			php_xmlrpc_encode( (int) $percentOrAmt ),
			php_xmlrpc_encode( $amt ),
			php_xmlrpc_encode( $payType )
		];

		return $this->methodCaller( 'DiscountService.addOrderTotalDiscount', $carray );
	}

		
function getOrderTotalDiscount( $id ) {
		$carray = [
			php_xmlrpc_encode( $this->key ),
			php_xmlrpc_encode( (int) $id )
		];

		return $this->methodCaller( 'DiscountService.getOrderTotalDiscount', $carray );
	}

		
function addCategoryDiscount( string $name, string $description, $applyDiscountToCommission, $amt ) {
		$carray = [
			php_xmlrpc_encode( $this->key ),
			php_xmlrpc_encode( $name ),
			php_xmlrpc_encode( $description ),
			php_xmlrpc_encode( (int) $applyDiscountToCommission ),
			php_xmlrpc_encode( $amt )
		];

		return $this->methodCaller( 'DiscountService.addCategoryDiscount', $carray );
	}

		
function getCategoryDiscount( $id ) {
		$carray = [
			php_xmlrpc_encode( $this->key ),
			php_xmlrpc_encode( (int) $id )
		];

		return $this->methodCaller( 'DiscountService.getCategoryDiscount', $carray );
	}

		
function addCategoryAssignmentToCategoryDiscount( $categoryDiscountId, $productCategoryId ) {
		$carray = [
			php_xmlrpc_encode( $this->key ),
			php_xmlrpc_encode( (int) $categoryDiscountId ),
			php_xmlrpc_encode( (int) $productCategoryId )
		];

		return $this->methodCaller( 'DiscountService.addCategoryAssignmentToCategoryDiscount', $carray );
	}

		
function getCategoryAssignmentsForCategoryDiscount( $id ) {
		$carray = [
			php_xmlrpc_encode( $this->key ),
			php_xmlrpc_encode( (int) $id )
		];

		return $this->methodCaller( 'DiscountService.getCategoryAssignmentsForCategoryDiscount', $carray );
	}

			
function addProductTotalDiscount( string $name, string $description, $applyDiscountToCommission, $productId, $percentOrAmt, $amt ) {
		$carray = [
			php_xmlrpc_encode( $this->key ),
			php_xmlrpc_encode( $name ),
			php_xmlrpc_encode( $description ),
			php_xmlrpc_encode( (int) $applyDiscountToCommission ),
			php_xmlrpc_encode( (int) $productId ),
			php_xmlrpc_encode( (int) $percentOrAmt ),
			php_xmlrpc_encode( $amt )
		];

		return $this->methodCaller( 'DiscountService.addProductTotalDiscount', $carray );
	}






		
function getProductTotalDiscount( $id ) {
		$carray = [
			php_xmlrpc_encode( $this->key ),
			php_xmlrpc_encode( (int) $id )
		];

		return $this->methodCaller( 'DiscountService.getProductTotalDiscount', $carray );
	}

			
function addShippingTotalDiscount( string $name, string $description, $applyDiscountToCommission, $percentOrAmt, $amt ) {
		$carray = array(
			php_xmlrpc_encode( $this->key ),
			php_xmlrpc_encode( $name ),
			php_xmlrpc_encode( $description ),
			php_xmlrpc_encode( (int) $applyDiscountToCommission ),
			php_xmlrpc_encode( (int) $percentOrAmt ),
			php_xmlrpc_encode( $amt )
		);

		return $this->methodCaller( 'DiscountService.addShippingTotalDiscount', $carray );
	}

	
	
function getShippingTotalDiscount( $id ) {
		$carray = array(
			php_xmlrpc_encode( $this->key ),
			php_xmlrpc_encode( (int) $id )
		);

		return $this->methodCaller( 'DiscountService.getShippingTotalDiscount', $carray );
	}

	
	
function placeOrder( $contactId, $creditCardId, $payPlanId, array $productIds, array $subscriptionIds,  $processSpecials, array $promoCodes, $leadAff = 0, $saleAff = 0 ) {
        $productIds      = array_values( $productIds );
        $promoCodes      = array_values( $promoCodes );
        $subscriptionIds = array_values( $subscriptionIds );

		$carray = array (
			php_xmlrpc_encode( $this->key ),
			php_xmlrpc_encode( (int) $contactId ),
			php_xmlrpc_encode( (int) $creditCardId ),
			php_xmlrpc_encode( (int) $payPlanId ),
			php_xmlrpc_encode( $productIds ),
			php_xmlrpc_encode( $subscriptionIds ),
			php_xmlrpc_encode( (bool) $processSpecials ),
			php_xmlrpc_encode( $promoCodes ),
			php_xmlrpc_encode( (int) $leadAff ),
			php_xmlrpc_encode( (int) $saleAff )
		);

		return $this->methodCaller( 'OrderService.placeOrder', $carray );
	}

	
	
function requestCcSubmissionToken( $contactId, string $successUrl, string $failureUrl ) {
		$carray = [
			php_xmlrpc_encode( $this->key ),
			php_xmlrpc_encode( (int) $contactId ),
			php_xmlrpc_encode( $successUrl ),
			php_xmlrpc_encode( $failureUrl )
		];

		return $this->methodCaller( 'CreditCardSubmissionService.requestSubmissionToken', $carray );
	}

	
function requestCreditCardId( string $token ) {
		$carray = [
			php_xmlrpc_encode( $this->key ),
			php_xmlrpc_encode( $token )
		];

		return $this->methodCaller( 'CreditCardSubmissionService.requestCreditCardId', $carray );
	}

	
function achieveGoal( string $integration, string $callName, $contactId ) {
		$carray = [
			php_xmlrpc_encode( $this->key ),
			php_xmlrpc_encode( $integration ),
			php_xmlrpc_encode( $callName ),
			php_xmlrpc_encode( (int) $contactId )
		];

		return $this->methodCaller( 'FunnelService.achieveGoal', $carray );
	}

	
function achieveWordPressGoal( $contactId, string $optinId ) {
        $carray    = [
			php_xmlrpc_encode( $this->key ),
			php_xmlrpc_encode( (int) $contactId ),
			php_xmlrpc_encode( $optinId )
		];

		return $this->methodCaller( 'FunnelService.achieveWordPressGoal', $carray );
	}

	
function getAffiliatesByProgram(  $programId ) {
		$carray = [
			php_xmlrpc_encode($this->key),
			php_xmlrpc_encode( (int) $programId )
		];

		return $this->methodCaller( 'AffiliateProgramService.getAffiliatesByProgram', $carray );
	}

	
	
function getProgramsForAffiliate( $affiliateId ) {
        $affiliateId = (int) $affiliateId;
        $carray      = [
			php_xmlrpc_encode( $this->key ),
			php_xmlrpc_encode( $affiliateId )
		];

		return $this->methodCaller( 'AffiliateProgramService.getProgramsForAffiliate', $carray );
	}

	
	
function getAffiliatePrograms() {
		$carray = [
			php_xmlrpc_encode( $this->key )
		];

		return $this->methodCaller( 'AffiliateProgramService.getAffiliatePrograms', $carray );
	}

	
	
function getResourcesForAffiliateProgram( $programId ) {
		$programId = (int) $programId;
		$carray = [
			php_xmlrpc_encode( $this->key ),
			php_xmlrpc_encode( $programId ),
		];

		return $this->methodCaller( 'AffiliateProgramService.getResourcesForAffiliateProgram', $carray );
	}


	

		
function cfgCon($name, $key = '', $dbOn = 'on', $type = 'i') {
		$this->debug = ( ( $key == 'on' || $key == 'off' || $key == 'kill' ) ? $key : $dbOn );

		if ( $key != '' && $key != 'on' && $key != 'off' && $key != 'kill' ) {
			$this->key = $key;
		}
		else {
			include 'conn.cfg.php';
			$appLines = $connInfo;

			foreach ( $appLines as $appLine ) {
				$details[substr( $appLine, 0, strpos( $appLine, ":" ) )] = explode( ":", $appLine );
			}

			$appname = $details[$name][1];
			$type = $details[$name][2];
			$this->key = $details[$name][3];
		}

		switch ( $type ) {
		case 'm':
			$this->client = new xmlrpc_client( "https://$appname.mortgageprocrm.com/api/xmlrpc" );
			break;
		case 'i':
		default:
			if ( !isset( $appname ) ) {
				$appname = $name;
			}
			$this->client = new xmlrpc_client( "https://$appname.infusionsoft.com/api/xmlrpc" );
			break;
		}

				$this->client->return_type = 'phpvals';

				$this->client->setSSLVerifyPeer( FALSE );
		
				try {
			$connected = $this->dsGetSetting( 'Contact', 'optiontypes' );
		}
		catch ( Exception $e ) {
			throw new Exception( 'Connection Failed' );
		}
		return true;
	}

}
