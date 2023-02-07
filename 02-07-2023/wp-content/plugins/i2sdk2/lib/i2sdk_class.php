<?php
if ( !defined( 'ABSPATH' ) ) {
	die();
}


if ( ! class_exists( 'PluginUpdateChecker_1_4_Memberium' ) ) {
	include_once dirname( I2SDK_HOME ) . '/lib/plugin-update-checker.php';
	$i2sdkUpdateChecker = new PluginUpdateChecker_1_4_Memberium( 'http://licenseserver.webpowerandlight.com/updates/i2sdk.php', I2SDK_HOME, 'i2sdk2/i2sdk2.php' );
}


class i2sdk_class {

	const VERSION           = I2SDK_VERSION;
	const DB_API_LOG        = 'i2sdk_apilog';
	const DB_DATAFORMFIELDS = 'i2sdk_dataformfields';

	private $configuration    = NULL;
	public  $isdk             = NULL;
	private $i2sdk_version    = 0;
	private $valid_connection = 0;
	private $tables           = array();

	function __construct() {
		global $wpdb;

		include_once I2SDK_DIR . 'lib/infusionsoft_driver_class.php';

		$this->i2sdk_version   = I2SDK_VERSION;

		$this->tables = array(
			'api_log'        => self::DB_API_LOG,
			'dataformfields' => self::DB_DATAFORMFIELDS,
		);

		$this->configuration = get_option( 'i2sdk' );

		$this->isdk = new infusionsoft_driver;
		$this->isdk->setApiLogTable( $this->tables['api_log'] );
		$this->isdk->enableLogging( $this->configuration['api_log'] );

		if ( $this->configuration['api_key'] > '' && $this->configuration['app_name'] > '' ) {
			$this->valid_connection = $this->isdk->configureConnection( $this->configuration['app_name'], $this->configuration['api_key'] );

			if ( $this->valid_connection == FALSE && $this->configuration['server_verified'] == 1 ) {
				$this->configuration['server_verified'] = 0;
				update_option( 'i2sdk', $this->configuration );
			}
			elseif ( $this->valid_connection && $this->configuration['server_verified'] == 0 ) {
				$this->configuration['server_verified'] = 1;
				update_option( 'i2sdk', $this->configuration );
			}
		}

		if ( $_SERVER['REQUEST_METHOD'] == 'GET' && isset( $_GET['auth_key'] ) && isset( $_GET['operation'] ) && isset( $_GET['contactId'] ) ) {
			$_POST['contactId']        = (int) $_GET['contactId'];
			$_SERVER['REQUEST_METHOD'] = 'POST';
		}

		// Handle POSTs
		if ( $_SERVER['REQUEST_METHOD'] == 'POST' && isset( $_GET['auth_key'] ) && isset( $_GET['operation'] ) ) {
			add_action( 'init', array( $this, 'routeHTTPost' ) );
		}
		// Updater was here
	}

	function __destruct() {
	}

	function reloadConfiguration() {
		$this->configuration = get_option( 'i2sdk' );
	}

	function getConfigurationOption( $key ) {
		if ( isset ( $this->configuration[$key] ) ) {
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

	public function getInfusionsoftDriver() {
		return $this->isdk;
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

	function showInfusionsoftWebAnalytics() {
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

	function getCountries() {
		return array(
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
			'Venezuela (Bolivarian Republic of)', 'Viet Nam', 'Virgin Islands (British)', 'Virgin Islands (U.S.)',
			'Wallis and Futuna', 'Western Sahara',
			'Yemen',
			'Zambia', 'Zimbabwe',
		);
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
		$return_fields = array(
			'Id',
			'Name',
			'Label',
			'DataType',
			'FormId'
		);
		$table_name    = $this->tables['dataformfields'];
		$rows_loaded   = 0;
		$found_rows = array();

		// Get Original Field List
		$sql        = "SELECT `name` FROM `{$table_name}` WHERE `appname` = %s ORDER BY `name`;";
		$sql        = $wpdb->prepare( $sql, $this->configuration['app_name'] );
		$old_fields = $wpdb->get_col( $sql );

		do {
			$rows = $this->isdk->dsfind( $table, $limit, $page, $search_field, $search_value, $return_fields );

			if ( is_array( $rows ) ) {
				$wpdb->query( 'START TRANSACTION WITH CONSISTENT SNAPSHOT' );
				// $wpdb->query( "TRUNCATE {$table_name}" );
				if ( ! empty ( $rows ) ) {
					foreach ( $rows as $row ) {
						if ( in_array( $row['FormId'], array( -1, -3, -4, -6, -5, -9, -10 ) ) ) {

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
				$wpdb->query( 'COMMIT' );
			}
			$page++;
		} while ( count( $rows ) == $limit );

		// Cleanup Empty Rows
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
		global $wpdb;

		$ignored_fields = array();
		$new_fields     = array();
		$form_id        = 0;
		$tablename      = strtolower( trim( $tablename ) );

		switch ( $tablename ) {
		case 'actionsequence':
			$fields = array(
				'Id',
				'TemplateName',
				'VisibleToTheseUsers',
			);
			break;
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
		case 'affresource':
			$fields = array(
				'Id',
				'Notes',
				'ProgramIds',
				'ResourceHREF',
				'ResourceHTML',
				'ResourceOrder',
				'ResourceType',
				'Title',
			);
			break;
		case 'campaign':
			$fields = array(
				'Id',
				'Name',
				'Status',
			);
			break;
		case 'campaignee':
			$fields = array(
				'CampaignId',
				'Status',
				'Campaign',
				'ContactId',
			);
			break;
		case 'campaignstep':
			$fields = array(
				'Id',
				'CampaignId',
				'TemplateId',
				'StepStatus',
				'StepTitle',
			);
			break;
		case 'ccharge':
			$fields = array(
				'Id',
				'CCId',
				'PaymentId',
				'MerchantId',
				'OrderNum',
				'RefNum',
				'ApprCode',
				'Amt',
			);
			break;
		case 'company':
			$fields = array(
				'AccountId',
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
			break;
		case 'contact':
			$form_id = -1;
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
			break;
		case 'contactaction':
			$form_id = -5;
			$fields = array(
				'Id',
				'ContactId',
				'OpportunityId',
				'ActionType',
				'ActionDescription',
				'CreationDate',
				'CreationNotes',
				'CompletionDate',
				'ActionDate',
				'EndDate',
				'PopupDate',
				'UserID',
				'Accepted',
				'CreatedBy',
				'LastUpdated',
				'LastUpdatedBy',
				'Priority',
				'IsAppointment',
			);
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
		case 'cprogram':
			$fields = array(
				'Id',
				'ProgramName',
				'DefaultPrice',
				'DefaultCycle',
				'DefaultFrequency',
				'Sku',
				'ShortDescription',
				'BillingType',
				'Description',
				'HideInStore',
				'Status',
				'Active',
				'LargeImage',
				'Taxable',
				'Family',
				'ProductId',
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
		case 'dataformfield':
			$fields = array(
				'DataType',
				'Id',
				'FormId',
				'GroupId',
				'Name',
				'Label',
				'DefaultValue',
				'Values',
				'ListRows',
			);
			break;
		case 'dataformgroup':
			$fields = array(
				'Id',
				'Name',
				'TabId',
			);
			break;
		case 'emailaddstatus':
			$fields = array(
				'DateCreated',
				'Email',
				'Id',
				'LastClickDate',
				'LastOpenDate',
				'LastSentDate',
				'Type',
			);
			break;
		case 'expense':
			$fields = array(
				'ContactId',
				'DateIncurred',
				'ExpenseAmt',
				'ExpenseType',
				'Id',
				'TypeId',
			);
			break;
		case 'filebox':
			$fields = array(
				'ContactId',
				'Extension',
				'FileName',
				'FileSize',
				'Id',
				'Public',
			);
			break;
		case 'groupassign':
			$fields = array(
				'Admin',
				'GroupId',
				'Id',
				'FileSize',
				'Id',
				'UserId',
			);
			break;
		case 'invoice':
			$fields = array(
				'AffiliateId',
				'ContactId',
				'CreditStatus',
				'DateCreated',
				'Description',
				'Id',
				'InvoiceTotal',
				'InvoiceType',
				'JobId',
				'LastUpdated',
				'LeadAffiliateId',
				'LeadAffiliateId',
				'PayStatus',
				'ProductSold',
				'PromoCode',
				'RefundStatus',
				'Synced',
				'TotalDue',
				'TotalPaid',
			);
			break;
		case 'invoiceitem':
			$fields = array(
				'CommissionStatus',
				'DateCreated',
				'Description',
				'Discount',
				'Id',
				'InvoiceAmt',
				'InvoiceId',
				'LastUpdated',
				'OrderItemId',
			);
			break;
		case 'invoicepayment':
			$fields = array(
				'Amt',
				'Id',
				'InvoiceId',
				'LastUpdated',
				'PayDate',
				'PayStatus',
				'PaymentId',
				'SkipCommission',
			);
			break;
		case 'job':
			$form_id = -9;
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
		case 'linkedcontacttype':
			$fields = array(
				'Id',
				'MaxLinked',
				'TypeName',
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
		case 'socialaccount':
			$fields = array(
				'Id',
				'AccountName',
				'AccountType',
				'ContactId',
				'DateCreated',
				'LastUpdated',
			);
			break;
		default:
			$fields = false;
			break;
		}

		if ( $form_id <> 0 ) {
			$table_name = $this->getTableName( 'dataformfields' );
			$sql = 'SELECT concat( \'_\', name) as `name` FROM `' . $table_name . '` WHERE `formid` = ' . (int) $form_id . ' AND `appname` = "' . $this->configuration['app_name'] . '" ';
			$data_form_fields = $wpdb->get_results( $sql, ARRAY_A );
			foreach ( $data_form_fields as $id=>$row ) {
				$fields[] = $row['name'];
			}
			unset( $data_form_fields );
		}

		if ( is_string( $filterlist ) ) {
			$ignored_fields = explode( ',', $filterlist );
		}
		elseif ( is_array( $filterlist ) ) {
			$ignored_fields = $filter_list;
		}

		foreach ( $fields as $field ) {
			if ( ! in_array( $field, $ignored_fields ) ) {
				$new_fields[] = $field;
			}
		}

		return $new_fields;
	}

	function normalizePOSTFields() {
		// Normalize Field Names
		$master_field_list = $this->getInfusionsoftFieldsByTable( 'Contact', FALSE );
		$ignored_fields = explode( ',', $memberium['infusionsoft']['ignore_contact_fields'] );

		$new_post = array();
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
		/*
		208.76.24.0/22
		208.76.24.0/24
		208.76.25.0/24
		208.76.26.0/24
		208.76.27.0/24
		 */

		if ( empty( $_GET['auth_key'] ) ) {
			echo 'No API Key Provided.';
			exit;
		}

		$auth_keys = explode( ',', $this->configuration['http_post_key'] );
		if ( ! in_array( $_GET['auth_key'], $auth_keys ) ) {
			echo 'Invalid API Key.';
			exit;
		}

		$fieldnames = array(
			'Id',
			'contactId',
			'ContactId',
			'Contact0Id',
			);
		foreach( $fieldnames as $fieldname ) {
			if ( isset( $_REQUEST[$fieldname] ) && $_REQUEST[$fieldname] > 0 )  {
				$_POST['contactId'] = (int) $_REQUEST[$fieldname];
			}
		}

		if ( $_POST['contactId'] > 0 && count( $_POST ) == 1 ) {
			$return_fields = $this->getInfusionsoftFieldsByTable( 'Contact', false );
			$contact = $this->isdk->loadCon( (int) $_POST['contactId'], $return_fields );
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
		do_action( 'i2sdk_http_post' );
		exit;
	}
}


// TODO: Log Pruning
// TODO: Analytics / Trending (# of iSDK operations, # of errors)
// TODO: Continue building i2SDK functions
// TODO: Document action hooks
// TODO: Prep for L10N and I18N
// TODO: Add query sorting functionality
