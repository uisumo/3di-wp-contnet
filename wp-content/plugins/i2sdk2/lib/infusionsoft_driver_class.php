<?php
if ( !defined( 'ABSPATH' ) ) {
	die();
}


if ( ! class_exists( 'Memberium_iSDK' ) ) {
	require_once I2SDK_DIR . '/vendor/isdk/isdk.php';
}


/*
 * Customize iSDK Class to accept connection parameters during instantiation instead of from configuration file
 *
 * @RETURN boolean False = failed connection, true = successful connection
 * @VERSION 1.0
 * @TODO Change XML-RPC User-Agent
 *
 */
class infusionsoft_driver extends Memberium_iSDK {

	private $api_log;
	private $api_log_table;
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
	}

	public function setCRMType( $type ) {
		$success = false;
		$type =  substr( strtolower( trim( $type ) ), 1, 1 );
		switch ( $type ) {
		case 'm':
			$this->$crm_type = 'm';
			$success = TRUE;
			break;
		default:
			$this->$crm_type = 'i';
			$success = TRUE;
			break;
		}
		if ( $this->app_host > '' && $this->key > '' ) {
			$this->configureConnection( $this->app_host, $this->key, $this->crm_type, $this->$dbOn );
		}
		return $success;
	}

	public function setAppName( $appname ) {
		if ( defined( 'I2SDK_APP_NAME' ) ) {
			$appname = strtolower( i2SDK_APP_NAME );
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

	public function getAppName() {
		return $this->app_name;
	}

	public function setAPIKey( $api_key ) {
		if ( defined( 'I2SDK_API_KEY' ) ) {
			$api_key = trim( I2SDK_API_KEY );
		}
		else {
			$api_key = trim( $api_key );
		}

		$api_key = trim( $api_key );
		$this->key = $api_key;
		if ( $this->app_host > '' && $this->key > '' ) {
			$this->configureConnection( $this->app_host, $this->key, $this->crm_type, $this->$dbOn );
		}
	}

	/**
	 * [setApiLog description]
	 *
	 * @param [type]  $api_log [description]
	 */
	public function enableLogging( $status ) {
		if ( is_integer( $status ) && $status == 1 || $status == 0 ) {
			$status = (boolean) $status;
		}
		if ( is_bool( $status ) ) {
			$this->api_log = $status;
			return TRUE;
		}
		return FALSE;
	}

	public function setApiLogTable( $api_log_table ) {
		$api_log_table = trim( $api_log_table );
		$this->api_log_table = $api_log_table;
	}

	public function setEmailNotification( $email_notification ) {
		$this->email_notification = (int) $email_notification;
	}

	public function setEmailTo( $email_to ) {
		$this->email_to = trim( $email_to );
	}

	public function setRetryCount( $retry_count ) {
		$new_retry_count = (int) $retry_count;
		if ( $new_retry_count >= 0 ) {
			$this->max_retries = (int) $retry_count;
		}
	}

	public function getRetryCount() {
		return $this->max_retries;
	}

	//
	// Enhanced iSDK Functions
	//

	public function configureConnection( $appname, $api_key, $crm_type = 'i', $dbOn = 'off' ) {
		$crm_type    = strtolower( $crm_type );
		$this->debug = $dbOn;
		$this->key   = $api_key;

		if ( ! empty( $appname ) ) {
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

		$this->client = new xmlrpc_client( $this->host_url );
		$this->client->setSSLVerifyHost( false );
        $this->client->setCaCertificate( $ca_certificate );
		$this->client->return_type = 'phpvals';

		return true;
	}

	public function methodCaller( $service, $callArray ) {
		if ( $this->api_log == 1 ) {
			global $wpdb;
		}
		if ( ! method_exists( $this->client, 'send' ) ) {
			return '[API Key Error]';
		}

		$start_time  = microtime( true );
		$retry_count = 0;
		do {
			sleep( $retry_count );
			$call = new xmlrpcmsg( $service, $callArray );
			$result = $this->client->send( $call, $this->connection_timeout );

			if ( $result->errno === 10  ) {
				$GLOBALS['i2sdk']->syncCustomFields();
				sleep(1);
				$result = $this->client->send( $call, $this->connection_timeout );
			}

			if ( $this->api_log == 1 ) {
				$current_user = wp_get_current_user();
				// Log Connection
				$wpdb->insert(
					$this->api_log_table,
					array(
						'appname'    => $this->app_name,
						'ip_address' => $_SERVER['REMOTE_ADDR'],
						'duration'   => ( microtime( true ) - $start_time ),
						'user'       => $current_user->user_login,
						'service'    => $service,
						'caller'     => $call->serialize(),
						'result'     => utf8_encode( var_export( $result->value(), true ) ),
						'retries'    => $retry_count,
					)
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
					// @todo Switch to using WordPress email methods
					mail( $this->email_to, 'i2SDK Error Success on Retry', $error_notice );
				}

				$data = $result->value();


				if ( extension_loaded('mbstring') && function_exists('utf8_encode') ) {
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
				case -1: // Failed to invoke method findByEmail in class com.infusion.crm.api.service.xmlrpc.XmlRpcContactService: null
					break;
				case 2:  // Invalid Key
					// $GLOBALS['i2sdk']->setConfigurationOption( 'server_verified', 0 );
					// $GLOBALS['i2sdk']->setConfigurationOption( 'api_key', '' );
					return false;
					break;
				case 5:  // Didn't receive 200 OK from remote server
					break;
				case 6:  // Error Loading Action Set
					break;
				case 8:  // Unable to resolve host
					break;
				case 12: // Cannot update a record with Id < 1
					$retry = false;
					break;
				case 500: // Server Error
					$retry = true;
					if ( $result->faultstring() == 'Server encountered exception: java.lang.Exception: IP access not allowed' ) {
						$retry = false;
					}
					break;
				default:
					$retry = true;
					break;
				}
				if ( $this->email_notification == 1 ) {
					mail( $this->email_to, 'i2SDK Error', $error_notice );
				}
				if ( $this->debug == 'kill' ) {
					die( 'ERROR: ' . $result->faultCode() . ' - ' . $result->faultString() );
				}
				elseif ( $this->debug == 'on' ) {
					return "ERROR: " . $result->faultCode() . ' - ' . $result->faultString();
				} elseif ( $this->debug == 'off' ) {
					// Do nothing
				}
			}

			$retry_count++;
		} while (
			$retry_count < $this->max_retries &&
			$retry == true
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

	public function verify_Connection() {

		// TODO: Check DNS First
		$dns_record = dns_get_record( $this->app_host . '.', DNS_ANY ) ;
		if ( $dns_record === array() ) {
			$this->error_message = 'Hostname (' . $this->app_host . ') does not exist';
			return FALSE;
		}

		$result = trim( $this->dsGetSetting( 'Application', 'api_passphrase' ) );
		if ( strpos( $result, 'InvalidKey' ) == 12 || substr( $result, 0, 6 ) ==  'ERROR:' || empty( $result ) ) {
			$this->error_message = 'Invalid API Key (' . __LINE__ . '): ' . $result;
			return false;
		}
		else {
			$this->error_message = NULL;
			return TRUE;
		}
	}

	public function getWebTrackingScript() {
		$carray = array(
			php_xmlrpc_encode( $this->key ),
		);

		$result = $this->methodCaller( 'WebTrackingService.getWebTrackingScriptTag', $carray );
		return $result;
	}

	public function get_ErrorMessage() {
		return $this->error_message;
	}

	public function set_retry( $retry_count ) {
		$new_retry_count = (int) $retry_count;
		if ( $new_retry_count >= 0 ) {
			$this->max_retries = (int) $retry_count;
		}
	}

	public function dsQueryOrderBy( $tName, $limit, $page, $query, $rFields, $orderByField, $ascending = TRUE ) {
		$ascending = (boolean) $ascending;

		/*
		if ( function_exists( 'iconv' ) ) {
			foreach ( $query as $key=>$value ) {
				if ( is_string( $value ) ) {
					$query[$key] = iconv( 'UTF-8', 'ISO-8859-1//TRANSLIT', $value );
				}
			}
		}
		*/

		$carray = array(
			php_xmlrpc_encode( $this->key ),
			php_xmlrpc_encode( $tName ),
			php_xmlrpc_encode( (int) $limit ),
			php_xmlrpc_encode( (int) $page ),
			php_xmlrpc_encode( $query, array( 'auto_dates' ) ),
			php_xmlrpc_encode( $rFields ),
			php_xmlrpc_encode( $orderByField ),
			php_xmlrpc_encode( $ascending )
		);

		return $this->methodCaller( 'DataService.query', $carray );
	}

	// Contact Link Functions

	public function listLinkedContacts( $contact_id = 0 ) {
		$contact_id = (int) $contact_id;

		$carray = array(
			php_xmlrpc_encode( $this->key ),
			php_xmlrpc_encode( $contact_id ),
		);

		return $this->methodCaller( 'ContactService.listLinkedContacts', $carray );
	}

	public function LinkContacts( $contact1 = 0, $contact2 = 0, $link_type = 0 ) {
		$contact1  = (int) $contact1;
		$contact2  = (int) $contact2;
		$link_type = (int) $link_type;

		$carray = array(
			php_xmlrpc_encode( $this->key ),
			php_xmlrpc_encode( (int) $contact1 ),
			php_xmlrpc_encode( (int) $contact2 ),
			php_xmlrpc_encode( (int) $link_type ),
		);

		return $this->methodCaller( 'ContactService.linkContacts', $carray );
	}

	public function UnlinkContacts( $contact1 = 0, $contact2 = 0, $link_type = 0 ) {
		$contact1  = (int) $contact1;
		$contact2  = (int) $contact2;
		$link_type = (int) $link_type;

		$carray = array(
			php_xmlrpc_encode( $this->key ),
			php_xmlrpc_encode( (int) $contact1 ),
			php_xmlrpc_encode( (int) $contact2 ),
			php_xmlrpc_encode( (int) $link_type ),
		);

		return $this->methodCaller( 'ContactService.unlinkContacts', $carray );
	}

	// Filebox Functions
	public function getFile( $fileID ) {
		$fileID = (int) $fileID;

		$this->client->setAcceptedCompression( '' );

		$carray = array(
			php_xmlrpc_encode( $this->key ),
			php_xmlrpc_encode( $fileID )
		);

		$result = $this->methodCaller( 'FileService.getFile', $carray );

		$this->client->setAcceptedCompression( 'any' );

		return $result;
	}


	//
	// Unique i2SDK Functions
	//
	public function getFieldList( $tablename ) {

		$form_id   = 0;
		$tablename = strtolower( trim( $tablename ) );

		$fields = wp_cache_get( $tablename, 'i2sdk::data_form_fields', FALSE, $found );
		if ( $found ) {
			return $fields;
		}

		switch ( $tablename ) {
		case 'affiliate':
			$fields = array(
				'AffCode',
				'AffName',
				'ContactId',
				'DefCommissionType',
				'Id',
				'LeadAmt',
				'LeadCookieFor',
				'LeadPercent',
				'NotifyLead',
				'NotifySale',
				'ParentId',
				'Password',
				'PayoutType',
				'SaleAmt',
				'SalePercent',
				'Status',
			);
			break;
		case 'actionsequence':
			$fields = array(
				'Id',
				'TemplateName',
			);
			break;
		case 'contact':
			$fields = array(
				// 'AccountId',
				'Address1Type',
				'Address2Street1',
				'Address2Street2',
				'Address2Type',
				'Address3Street1',
				'Address3Street2',
				'Address3Type',
				'Anniversary',
				'AssistantName',
				'AssistantPhone',
				'BillingInformation',
				'Birthday',
				'City',
				'City2',
				'City3',
				'Company',
				'CompanyID',
				'ContactNotes',
				'ContactType',
				'Country',
				'Country2',
				'Country3',
				'CreatedBy',
				'DateCreated',
				'Email',
				'EmailAddress2',
				'EmailAddress3',
				'Fax1',
				'Fax1Type',
				'Fax2',
				'Fax2Type',
				'FirstName',
				'Groups',
				'Id',
				'JobTitle',
				'LastName',
				'LastUpdated',
				'LastUpdatedBy',
				'Leadsource',
				'LeadSourceId',
				'MiddleName',
				'Nickname',
				'OwnerID',
				'Password',
				'Phone1',
				'Phone1Ext',
				'Phone1Type',
				'Phone2',
				'Phone2Ext',
				'Phone2Type',
				'Phone3',
				'Phone3Ext',
				'Phone3Type',
				'Phone4',
				'Phone4Ext',
				'Phone4Type',
				'Phone5',
				'Phone5Ext',
				'Phone5Type',
				'PostalCode',
				'PostalCode2',
				'PostalCode3',
				'ReferralCode',
				'SpouseName',
				'State',
				'State2',
				'State3',
				'StreetAddress1',
				'StreetAddress2',
				'Suffix',
				'Title',
				'Username',
				'Validated',
				'Website',
				'ZipFour1',
				'ZipFour2',
				'ZipFour3',
			);
			$form_id = -1;
			break;
		case 'contactgroup':
			$fields = array(
				'Id',
				'GroupName',
				'GroupCategoryId',
				'GroupDescription',
			);
			break;
		case 'contactgroupassign':
			$fields = array(
				'ContactGroup',
				'ContactId',
				'DateCreated',
				'GroupId',
			);
			break;
		case 'contactgroupcategory':
			$fields = array(
				'Id',
				'CategoryName',
				'CategoryDescription',
			);
			break;
		case 'creditcard':
			$fields = array(
				'Id',
				'ContactId',
				'BillName',
				'FirstName',
				'LastName',
				'PhoneNumber',
				'Email',
				'BillAddress1',
				'BillAddress2',
				'BillCity',
				'BillState',
				'BillZip',
				'BillCountry',
				'ShipFirstName',
				'ShipMiddleName',
				'ShipLastName',
				'ShipCompanyName',
				'ShipPhoneNumber',
				'ShipAddress1',
				'ShipAddress2',
				'ShipCity',
				'ShipState',
				'ShipZip',
				'ShipCountry',
				'ShipName',
				'NameOnCard',
				'CardNumber',
				'Last4',
				'ExpirationMonth',
				'ExpirationYear',
				'CVV2',
				'Status',
				'CardType',
				'StartDateMonth',
				'StartDateYear',
				'MaestroIssueNumber',
			);
			break;
		case 'Job':
			$fields = array(
				'Id',
				'JobTitle',
				'ContactId',
				'StartDate',
				'DueDate',
				'JobNotes',
				'ProductId',
				'JobStatus',
				'DateCreated',
				'JobRecurringId',
				'OrderType',
				'OrderStatus',
				'ShipFirstName',
				'ShipMiddleName',
				'ShipLastName',
				'ShipCompany',
				'ShipPhone',
				'ShipStreet1',
				'ShipStreet2',
				'ShipCity',
				'ShipState',
				'ShipZip',
				'ShipCountry',
			);
			break;
		case 'referral':
			$fields = array(
				'Id',
				'ContactId',
				'AffiliateId',
				'DateSet',
				'DateExpires',
				'IPAddress',
				'Source',
				'Info',
				'Type'
			);
			break;
		default:
			$fields = false;
			break;
		}
		if ( $form_id <> 0 ) {
			global $wpdb;
			$sql = 'SELECT concat(\'_\', name) as name FROM `' . 'i2sdk_dataformfields' . '` WHERE `appname` = "' . $this->app_name . '" AND formid = ' . (int)$form_id; $data_form_fields = $wpdb->get_results( $sql, ARRAY_A );
			foreach ( $data_form_fields as $id=>$row ) {
				$fields[] = $row['name'];
			}
			unset( $data_form_fields );
		}

		wp_cache_set( $tablename, $fields, 'i2sdk::data_form_fields', 600 );
		return $fields;
	}
}
