<?php

namespace uncanny_learndash_codes;

use stdClass;
use Uncanny_Automator\InitializePlugin;
use function wp_create_nonce;

/**
 * Class Boot
 * @package uncanny_learndash_codes
 */
class Boot extends Config {

	/**
	 * Boot constructor.
	 */
	public function __construct() {
		parent::__construct();

		global $uncanny_learndash_codes;

		if ( ! isset( $uncanny_learndash_codes ) ) {
			$uncanny_learndash_codes = new stdClass();
		}

		$uncanny_learndash_codes = $this->initialize_internal_classes( $uncanny_learndash_codes );

		add_action( 'admin_init', array( __CLASS__, 'upgrade_database' ) );
		add_action( 'admin_enqueue_scripts', array( __CLASS__, 'uo_codes_admin_scripts' ) );

		// Import Gutenberg Blocks.
		require_once dirname( __FILE__ ) . '/blocks/blocks.php';
		new Blocks( 'uncanny_learndash_codes', UNCANNY_LEARNDASH_CODES_VERSION );

		add_action( 'admin_init', array( __CLASS__, 'actions_before_header' ) );

		add_filter( 'plugin_action_links', array( __CLASS__, 'uncanny_learndash_codes_plugin_settings_link' ), 10, 5 );

		add_action( 'plugins_loaded', array( __CLASS__, 'uncanny_learndash_codes_text_domain' ) );

		// Add WPForms Code Field Functions!
		add_action( 'plugins_loaded', array( __CLASS__, 'add_wpforms_code_field' ) );

		// Add Formidable Code Field Functions!
		add_action( 'plugins_loaded', array( __CLASS__, 'add_formidable_code_field' ) );

		/* Licensing */

		// URL of store powering the plugin.
		define( 'UO_CODES_STORE_URL', 'https://www.uncannyowl.com/' );
		// you should use your own CONSTANT name, and be sure to replace it throughout this file.

		// Store download name/title.
		define( 'UO_CODES_ITEM_NAME', 'Uncanny LearnDash Codes' );
		// you should use your own CONSTANT name, and be sure to replace it throughout this file.

		// include updater.
		include_once 'includes/EDD_SL_Plugin_Updater.php';

		add_action( 'admin_init', array( __CLASS__, 'uo_plugin_updater' ), 0 );
		add_action( 'admin_menu', array( __CLASS__, 'uo_license_menu' ), 50 );
		add_action( 'admin_init', array( __CLASS__, 'uo_activate_license' ) );
		add_action( 'admin_init', array( __CLASS__, 'uo_deactivate_license' ) );

		add_action( 'admin_menu', array( __CLASS__, 'add_help_submenu' ), 30 );
		add_action( 'admin_menu', array( __CLASS__, 'add_uncanny_plugins_page' ), 31 );
		add_action( 'admin_enqueue_scripts', array( __CLASS__, 'enqueue_external_scripts' ) );
		add_action( 'admin_init', array( __CLASS__, 'uo_admin_help_process' ) );

		add_action( 'edit_form_after_title', array( __CLASS__, 'add_codes_automator_notice' ) );
	}

	/**
	 * @param $uncanny_learndash_codes
	 *
	 * @return stdClass
	 */
	public function initialize_internal_classes( $uncanny_learndash_codes ) {

		// Add Automator Functions!
		include_once 'classes/automator/class-automator.php';
		$uncanny_learndash_codes->automator = new Automator();

		// Add Database Functions!
		include_once 'classes/helpers/class-database.php';
		$uncanny_learndash_codes->database = new Database();

		// Add LearnDash Functions!
		include_once 'classes/integrations/learndash/class-learndash.php';
		$uncanny_learndash_codes->learndash = new LearnDash();

		// Add Woocommerce Functions!
		include_once 'classes/integrations/woocommerce/class-woocommerce.php';
		$uncanny_learndash_codes->woocommerce = new Woocommerce();

		// Adding Classes!
		include_once 'classes/integrations/woocommerce/class-woo-automator-codes.php';
		$uncanny_learndash_codes->automator_code = new Automator_Codes();

		// Add Woocommerce Functions!
		include_once 'classes/helpers/class-rest-api.php';
		$uncanny_learndash_codes->rest_api = new Rest_Api();

		// Add Gravity Forms Functions!
		include_once 'classes/integrations/gravity-forms/class-gravity-forms.php';
		$uncanny_learndash_codes->gravity_forms = new GravityForms();

		// Add Gravity Forms Code Field Functions!
		include_once 'classes/integrations/gravity-forms/class-gravity-forms-code-field.php';
		$uncanny_learndash_codes->gravity_forms_code_field = new GravityFormsCodeField();

		// Add Shortcodes Functions!
		include_once 'classes/helpers/class-shortcodes.php';
		$uncanny_learndash_codes->shortcodes = new Shortcodes();

		// Add Install_Button Functions!
		include_once 'classes/helpers/class-install-button.php';
		$uncanny_learndash_codes->install_button = new Install_Button();

		// Add CSV Functions!
		include_once 'classes/helpers/class-csv.php';
		$uncanny_learndash_codes->csv = new CSV();

		// Add CSV Functions!
		include_once 'classes/integrations/theme-my-login/class-theme-my-login.php';
		$uncanny_learndash_codes->theme_my_login = new ThemeMyLogin();

		// Add Generate Code Functions!
		include_once 'classes/admin/class-generate-codes.php';
		$uncanny_learndash_codes->generate_codes = new GenerateCodes();

		// Add Generate Code Functions!
		include_once 'classes/admin/class-cancel-codes.php';
		$uncanny_learndash_codes->cancel_codes = new CancelCodes();

		// Add WPForms Integration!
		include_once 'classes/integrations/wpforms/class-wpforms.php';
		$uncanny_learndash_codes->wpforms = new WPForms();

		// Add Formidable Integration!
		include_once 'classes/integrations/formidable/class-formidable.php';
		$uncanny_learndash_codes->formidable = new Formidable();

		// Add Fluent Forms Integration!
		if ( defined( 'FLUENTFORM' ) ) {
			include_once 'classes/integrations/fluent-forms/class-ff-codes-field.php';
			include_once 'classes/integrations/fluent-forms/class-ff-code-redemption.php';
			$uncanny_learndash_codes->fluentforms = new Fluent_Forms_Code_Redemption();
		}
		// Add Fluent Forms Integration!
		if ( class_exists( 'Forminator' ) ) {
			add_filter(
				'forminator_fields',
				function ( $fields ) {
					include_once 'classes/integrations/forminator/class-create-codes-field.php';
					$fields[] = new Forminator_Codes_Field();

					return $fields;
				},
				99,
				1
			);
			include_once 'classes/integrations/forminator/class-forminator-codes-field.php';
			$uncanny_learndash_codes->forminator = new Forminator_Codes_Field_Handler();
		}
		// Adding Classes!
		include_once 'classes/admin/admin-menu.php';
		$uncanny_learndash_codes->admin_menu = new AdminMenu();

		return $uncanny_learndash_codes;
	}

	/**
	 *
	 */
	public static function upgrade_database() {
		$db_version = get_option( 'ulc_database_version', '1.0' );
		if ( null !== $db_version && (string) UNCANNY_LEARNDASH_CODES_DB_VERSION === (string) $db_version ) {
			// bail. No db upgrade needed!
			return;
		}
		$fix_unique   = false;
		$unique_codes = get_option( 'ulc_unique_code_fixes', '1.0' );
		if ( null !== $unique_codes && (string) UNCANNY_LEARNDASH_CODES_DB_VERSION !== (string) $unique_codes ) {
			$fix_unique = true;
		}
		if ( $fix_unique ) {
			// Fix unique code before upgrade database.
			if ( Database::fix_unique_code_issues() ) {
				Database::create_tables();
			}
		} else {
			Database::create_tables();
		}
	}

	/**
	 * Add "Help" submenu
	 */
	public static function add_help_submenu() {
		add_submenu_page(
			'uncanny-learndash-codes',
			esc_html__( 'Uncanny Codes Support', 'uncanny-learndash-codes' ),
			esc_html__( 'Help', 'uncanny-learndash-codes' ),
			'manage_options',
			'uncanny-codes-kb',
			array( __CLASS__, 'include_help_page' )
		);
	}

	/**
	 * Create "Uncanny Plugins" submenu
	 */
	public static function add_uncanny_plugins_page() {
		add_submenu_page(
			'uncanny-learndash-codes',
			esc_html__( 'Uncanny LearnDash Plugins', 'uncanny-learndash-codes' ),
			esc_html__( 'LearnDash Plugins', 'uncanny-learndash-codes' ),
			'manage_options',
			'uncanny-codes-plugins',
			array( __CLASS__, 'include_learndash_plugins_page' )
		);
	}

	/**
	 * Include "Help" template
	 */
	public static function include_help_page() {
		include Config::get_template( 'admin-help.php' );
	}

	/**
	 * Include "LearnDash Plugins" template
	 */
	public static function include_learndash_plugins_page() {
		include Config::get_template( 'admin-learndash-plugins.php' );
	}

	/**
	 * Enqueue external scripts from uncannyowl.com
	 */
	public static function enqueue_external_scripts() {
		$pages_to_include = array( 'uncanny-codes-plugins', 'uncanny-codes-kb' );

		if ( SharedFunctionality::ulc_filter_has_var( 'page' ) && in_array( SharedFunctionality::ulc_filter_input( 'page' ), $pages_to_include ) ) {
			wp_enqueue_style( 'uncannyowl-core', 'https://uncannyowl.com/wp-content/mu-plugins/uncanny-plugins-core/dist/bundle.min.css', array(), Config::get_version() );
			wp_enqueue_script( 'uncannyowl-core', 'https://uncannyowl.com/wp-content/mu-plugins/uncanny-plugins-core/dist/bundle.min.js', array( 'jquery' ), Config::get_version() );
		}
	}

	/**
	 * Submit ticket
	 */
	public static function uo_admin_help_process() {
		if ( SharedFunctionality::ulc_filter_has_var( 'ulc-send-ticket', INPUT_POST ) && check_admin_referer( 'uncanny0w1', 'ulc-send-ticket' ) ) {
			$name        = esc_html( SharedFunctionality::ulc_filter_input( 'fullname', INPUT_POST ) );
			$email       = esc_html( SharedFunctionality::ulc_filter_input( 'email', INPUT_POST ) );
			$website     = esc_html( SharedFunctionality::ulc_filter_input( 'website', INPUT_POST ) );
			$license_key = esc_html( SharedFunctionality::ulc_filter_input( 'license_key', INPUT_POST ) );
			$message     = esc_html( SharedFunctionality::ulc_filter_input( 'message', INPUT_POST ) );
			$siteinfo    = stripslashes( $_POST['siteinfo'] );
			$message     = '<h3>Message:</h3><br/>' . wpautop( $message );
			if ( ! empty( $website ) ) {
				$message .= '<hr /><strong>Website:</strong> ' . $website;
			}
			if ( ! empty( $license_key ) ) {
				$message .= '<hr /><strong>License:</strong> <a href="https://www.uncannyowl.com/wp-admin/edit.php?post_type=download&page=edd-licenses&s=' . $license_key . '" target="_blank">' . $license_key . '</a>';
			}
			if ( isset( $_POST['site-data'] ) && 'yes' === sanitize_text_field( $_POST['site-data'] ) ) {
				$message = "$message<hr /><h3>User Site Information:</h3><br />{$siteinfo}";
			}

			$to        = 'support.41077.bb1dda3d33afb598@helpscout.net';
			$subject   = esc_html( SharedFunctionality::ulc_filter_input( 'subject', INPUT_POST ) );
			$headers   = array( 'Content-Type: text/html; charset=UTF-8' );
			$headers[] = 'From: ' . $name . ' <' . $email . '>';
			$headers[] = 'Reply-To:' . $name . ' <' . $email . '>';
			wp_mail( $to, $subject, $message, $headers );
			if ( SharedFunctionality::ulc_filter_has_var( 'page', INPUT_POST ) ) {
				$url = admin_url( 'admin.php' ) . '?page=' . esc_html( SharedFunctionality::ulc_filter_input( 'page', INPUT_POST ) ) . '&sent=true&wpnonce=' . wp_create_nonce();
				wp_safe_redirect( $url );
				exit;
			}
		}
	}

	/**
	 * @param $actions
	 * @param $plugin_file
	 *
	 * @return array
	 */
	public static function uncanny_learndash_codes_plugin_settings_link( $actions, $plugin_file ) {
		static $plugin;

		if ( ! isset( $plugin ) ) {
			$plugin = 'uncanny-learndash-codes/uncanny-learndash-codes.php';
		}

		if ( $plugin === $plugin_file ) {
			$settings_link[] = sprintf( '<a href="%s">%s</a>', admin_url( 'admin.php?page=uncanny-learndash-codes-settings' ), esc_html__( 'Settings', 'uncanny-learndash-codes' ) );
			$settings_link[] = sprintf( '<a href="%s">%s</a>', admin_url( 'admin.php?page=uncanny-codes-license-activation' ), esc_html__( 'Licensing', 'uncanny-learndash-codes' ) );
			$actions         = array_merge( $settings_link, $actions );
		}

		return $actions;
	}

	/**
	 *
	 */
	public static function uncanny_learndash_codes_text_domain() {
		load_plugin_textdomain( 'uncanny-learndash-codes', false, basename( dirname( __FILE__ ) ) . '/languages/' );
	}

	/**
	 * Add Uncanny Codes field to WpForms
	 */
	public static function add_wpforms_code_field() {
		if ( function_exists( 'wpforms' ) ) {
			require_once self::get_include( 'class-wpforms-code-field.php' );
		}
	}

	/**
	 * Add Uncanny Codes field to WpForms
	 */
	public static function add_formidable_code_field() {
		if ( function_exists( 'load_formidable_forms' ) ) {
			require_once self::get_include( 'class-formidable-code-field.php' );
		}
	}

	/**
	 *
	 */
	public static function actions_before_header() {
		if ( SharedFunctionality::ulc_filter_has_var( 'page' ) && ! empty( SharedFunctionality::ulc_filter_input( 'mode' ) ) ) {
			$page = SharedFunctionality::ulc_filter_input( 'page' );
			$mode = SharedFunctionality::ulc_filter_input( 'mode' );

			switch ( $page ) {
				case 'uncanny-learndash-codes':
					if ( empty( SharedFunctionality::ulc_filter_input( 'group_id' ) ) ) {
						break;
					}

					switch ( $mode ) {
						case 'download':
							self::generate_csv( 'login_coupon' );
							break;

						case 'delete':
							Database::delete_coupon( SharedFunctionality::ulc_filter_input( 'group_id' ) );
							header( 'Location: ' . remove_query_arg( array( 'group_id', 'mode' ) ) );
							die;
					}
					break;
				case 'uncanny-learndash-codes-settings':
					switch ( $mode ) {
						case 'reset':
							Database::reset_data();
							header(
								'Location: ' . add_query_arg(
									array(
										'saved' => 'true',
									),
									remove_query_arg(
										array(
											'mode',
										)
									)
								)
							);
							die;
						case 'tml':
							// verify if there's TML Directory / File in user's theme.
							$dir    = get_stylesheet_directory() . '/theme-my-login/';
							$dest   = get_stylesheet_directory() . ' /theme-my-login/register-form.php';
							$source = Config::get_template( 'frontend-register-form.php' );

							if ( ! file_exists( $dir ) ) {
								mkdir( $dir, 0755, true );
							}

							if ( file_exists( $dest ) ) {
								rename( $dest, $dest . '.bak' );
							}

							if ( ! copy( $source, $dest ) ) {
								header(
									'Location: ' . add_query_arg(
										array(
											'mode' => 'force_download',
										)
									)
								);
								die;
							}

							header(
								'Location: ' . add_query_arg(
									array(
										'saved' => 'true',
									),
									remove_query_arg(
										array(
											'mode',
										)
									)
								)
							);
							die;
						case 'force_download':
							header(
								'Location: ' . add_query_arg(
									array(
										'force_downloaded' => 'true',
									),
									remove_query_arg(
										array(
											'mode',
										)
									)
								)
							);
							die;
						case 'download_file':
							header( 'Content-Type: application/octet-stream' );
							header( 'Content-Transfer-Encoding: Binary' );
							header( 'Content-disposition: attachment; filename="register-form.php"' );
							$source = Config::get_template( 'frontend-register-form.php' );
							echo readfile( $source );
							die;
						case 'destroy':
							Database::reset();
							deactivate_plugins( plugin_basename( dirname( dirname( __FILE__ ) ) . '/uncanny-learndash-codes.php' ) );
							header( 'Location: /wp-admin/ ' );
							die;
					}
					break;
			}
		}
	}

	/**
	 * @param $mode
	 */
	public static function generate_csv( $mode ) {
		if ( 'login_coupon' === $mode ) {
			new CSV(
				array(
					'filename' => 'uncanny-codes-' . date_i18n( 'Y-m-d-HisA', current_time( 'timestamp' ) ),
					'data'     => Database::get_coupons_csv( SharedFunctionality::ulc_filter_input( 'group_id' ) ),
				)
			);
		}
	}

	/**
	 *
	 */
	public static function uo_codes_admin_scripts() {
		global $pagenow, $current_screen;

		$allowed_screens = array(
			'uncanny-codes_page_uncanny-codes-kb',
			'uncanny-codes_page_uncanny-codes-plugins',
			'uncanny-codes_page_uncanny-codes-license-activation',
			'toplevel_page_uncanny-learndash-codes',
		);

		if ( 'post' === (string) $current_screen->base && 'product' === (string) $current_screen->id ) {
			$allowed_screens[] = 'post';
		}

		$allowed_screens = apply_filters( 'uc_allowed_screens', $allowed_screens, $current_screen );
		// Only allow custom files to load on Uncanny Codes pages.
		if ( 'admin.php' !== (string) $pagenow && ! strpos( (string) $current_screen->base, 'codes_page_uncanny' ) && ! in_array( $current_screen->base, $allowed_screens ) ) {
			return;
		}
		wp_enqueue_style( 'uncanny-learndash-codes-backend', Config::get_asset( 'backend', 'bundle.min.css' ), false, Config::get_version() );

		// Add select2 option for the dropdowns.
		wp_enqueue_style( 'uoc-select2', Config::get_vendor( 'select2/css/select2.min.css' ), array(), Config::get_version() );
		wp_enqueue_script( 'uoc-select2', Config::get_vendor( 'select2/js/select2.min.js' ), array( 'jquery' ), Config::get_version(), true );

		wp_register_script(
			'uncanny-learndash-codes-backend',
			Config::get_asset( 'backend', 'bundle.min.js' ),
			array(
				'jquery',
				'uoc-select2',
			),
			Config::get_version()
		);

		// Localized translations.
		$translation_array = array(
			'PleaseInputMaximumUsageAmount'     => esc_html__( 'Please Input Maximum Usage Amount', 'uncanny-learndash-codes' ),
			'PleaseSelectLearnDashGroups'       => esc_html__( 'Please Select LearnDash Groups', 'uncanny-learndash-codes' ),
			'PleaseSelectLearnDashCourses'      => esc_html__( 'Please Select LearnDash Courses', 'uncanny-learndash-codes' ),
			'PleaseInputLetterLength'           => esc_html__( 'Please Input Letter Length', 'uncanny-learndash-codes' ),
			'TheLengthofPrefixandSuffixisLongerthanLetterLength' => esc_html__( 'The Length of Prefix and Suffix is Longer than Letter Length', 'uncanny-learndash-codes' ),
			'TheLengthofPrefixandSuffixissameasLetterLength' => esc_html__( 'The Length of Prefix and Suffix is same as Letter Length', 'uncanny-learndash-codes' ),
			'Doyoureallywanttodeletethis'       => esc_html__( 'Do you really want to delete this?', 'uncanny-learndash-codes' ),
			'Doyoureallywanttodeletethesecodes' => esc_html__( 'Are you sure you want to delete these codes?  This action is irreversible.', 'uncanny-learndash-codes' ),
			'avail_characters'                  => GenerateCodes::$chars,
			'root'                              => esc_url_raw( rest_url() . Config::get_rest_api_root_path() ),
			'nonce'                             => wp_create_nonce( 'wp_rest' ),
		);

		$uncanny_codes_js_data = array(
			'restURL'  => esc_url_raw( rest_url() . 'uncanny-codes/v2' ),
			'nonce'    => wp_create_nonce( 'wp_rest' ),

			'generate' => array(
				'hasLearnDashInstalled'   => is_plugin_active( 'sfwd-lms/sfwd_lms.php' ),
				'hasWooCommerceInstalled' => function_exists( 'WC' ),
				'hasAutomatorInstalled'   => is_plugin_active( 'uncanny-automator/uncanny-automator.php' ),
				'hasToUpdateAutomator'    => is_plugin_active( 'uncanny-automator/uncanny-automator.php' ) && version_compare( InitializePlugin::PLUGIN_VERSION, '2.11.1', '<' ),

				'mode'                    => SharedFunctionality::ulc_filter_has_var( 'edit' ) ? 'edit' : 'create',

				'i18n'                    => array(
					'batchName'          => array(
						'errors' => array(
							'nameExists' => esc_html__( 'This name exists; please choose a new name.', 'uncanny-learndash-codes' ),
						),
					),

					'noResults'          => esc_html__( 'No results found', 'uncanny-learndash-codes' ),

					'submitButton'       => array(
						'forLearnDash' => esc_html__( 'Generate codes', 'uncanny-learndash-codes' ),
						'forAutomator' => esc_html__( 'Generate codes and create a recipe', 'uncanny-learndash-codes' ),
						'modifyBatch'  => esc_html__( 'Modify batch', 'uncanny-learndash-codes' ),
					),

					'somethingWentWrong' => esc_html__( 'Something went wrong. Please, try again.', 'uncanny-learndash-codes' ),
				),
			),
		);

		wp_localize_script( 'uncanny-learndash-codes-backend', 'uoCodesStrings', $translation_array );

		wp_localize_script( 'uncanny-learndash-codes-backend', 'UncannyCodes', $uncanny_codes_js_data );

		// Enqueued script with localized data.
		wp_enqueue_script( 'uncanny-learndash-codes-backend' );
	}

	/**
	 *
	 */
	public static function uo_plugin_updater() {

		// retrieve our license key from the DB.
		$license_key = trim( get_option( 'uo_codes_license_key' ) );

		// setup the updater.
		new EDD_SL_Plugin_Updater(
			UO_CODES_STORE_URL,
			UO_CODES_FILE,
			array(
				'version'   => UNCANNY_LEARNDASH_CODES_VERSION,
				// current version number.
				'license'   => $license_key,
				// license key (used get_option above to retrieve from DB).
				'item_name' => UO_CODES_ITEM_NAME,
				// name of this plugin.
				'author'    => 'Uncanny Owl',
				// author of this plugin.
			)
		);

	}

	// Licence options page.

	/**
	 *
	 */
	public static function uo_license_menu() {

		add_submenu_page(
			'uncanny-learndash-codes',
			esc_html__( 'Uncanny Codes License Activation', 'uncanny-learndash-codes' ),
			esc_html__( 'License activation', 'uncanny-learndash-codes' ),
			'manage_options',
			'uncanny-codes-license-activation',
			array(
				__CLASS__,
				'uo_license_page',
			)
		);

	}

	/**
	 *
	 */
	public static function uo_license_page() {

		self::uo_check_license();

		$license = get_option( 'uo_codes_license_key' );
		$status  = get_option( 'uo_codes_license_status' );
		// $license_data->license will be either "valid", "invalid", "expired", "disabled".

		// Check license status.
		$license_is_active = ( 'valid' === $status ) ? true : false;

		// CSS Classes.
		$license_css_classes = array();

		if ( $license_is_active ) {
			$license_css_classes[] = 'ulc-license--active';
		}

		// Set links. Add UTM parameters at the end of each URL.
		$where_to_get_my_license = 'https://www.uncannyowl.com/plugin-frequently-asked-questions/#licensekey';
		$buy_new_license         = 'https://www.uncannyowl.com/downloads/uncanny-learndash-codes/';
		$knowledge_base          = menu_page_url( 'uncanny-codes-kb', false );

		include Config::get_template( 'admin-license.php' );
	}

	/**
	 * this illustrates how to check if
	 * a license key is still valid
	 * the updater does this for you,
	 * so this is only needed if you
	 * want to do something custom
	 *
	 * @return false
	 */
	public static function uo_check_license() {

		$license = trim( get_option( 'uo_codes_license_key' ) );

		$api_params = array(
			'edd_action' => 'check_license',
			'license'    => $license,
			'item_name'  => urlencode( UO_CODES_ITEM_NAME ),
			'url'        => home_url(),
		);

		// Call the custom API.
		$response = wp_remote_post(
			UO_CODES_STORE_URL,
			array(
				'timeout' => 15,
				'body'    => $api_params,
			)
		);

		if ( is_wp_error( $response ) ) {
			return false;
		}

		$license_data = json_decode( wp_remote_retrieve_body( $response ) );

		if ( $license_data->license == 'valid' ) {
			update_option( 'uo_codes_license_status', $license_data->license );
			// this license is still valid.
		} else {
			update_option( 'uo_codes_license_status', $license_data->license );
			// this license is no longer valid.
		}

		return false;
	}

	/**
	 * @param $new
	 *
	 * @return mixed
	 */
	public static function uo_sanitize_license( $new ) {

		$old = get_option( 'uo_codes_license_key' );
		if ( $old && $old != $new ) {
			delete_option( 'uo_codes_license_status' );
			// new license has been entered, so must reactivate.
		}

		return $new;
	}


	/**
	 * this illustrates how to activate
	 * a license key
	 *
	 * @return false|null
	 */
	public static function uo_activate_license() {

		// listen for our activate button to be clicked.
		if ( SharedFunctionality::ulc_filter_has_var( 'uo_codes_license_activate', INPUT_POST ) ) {

			// run a quick security check.
			if ( ! check_admin_referer( 'uo_codes_nonce', 'uo_codes_nonce' ) ) {
				return null;
			}
			// get out if we didn't click the Activate button.

			update_option( 'uo_codes_license_key', sanitize_text_field( SharedFunctionality::ulc_filter_input( 'uo_codes_license_key', INPUT_POST ) ) );

			// retrieve the license from the database.
			$license = sanitize_text_field( SharedFunctionality::ulc_filter_input( 'uo_codes_license_key', INPUT_POST ) );

			// data to send in our API request.
			$api_params = array(
				'edd_action' => 'activate_license',
				'license'    => $license,
				'item_name'  => urlencode( UO_CODES_ITEM_NAME ),
				// the name of our product in uo.
				'url'        => home_url(),
			);

			// Call the custom API.
			$response = wp_remote_post(
				UO_CODES_STORE_URL,
				array(
					'timeout' => 15,
					'body'    => $api_params,
				)
			);

			// make sure the response came back okay.
			if ( is_wp_error( $response ) ) {
				return false;
			}

			// decode the license data.
			$license_data = json_decode( wp_remote_retrieve_body( $response ) );

			// $license_data->license will be either "valid" or "invalid".
			update_option( 'uo_codes_license_status', $license_data->license );

		}

		return null;
	}

	/**
	 * Illustrates how to deactivate a license key.
	 * This will decrease the site count
	 *
	 * @return false|null
	 */
	public static function uo_deactivate_license() {

		// listen for our activate button to be clicked.
		if ( SharedFunctionality::ulc_filter_has_var( 'uo_codes_license_deactivate', INPUT_POST ) ) {

			// run a quick security check.
			if ( ! check_admin_referer( 'uo_codes_nonce', 'uo_codes_nonce' ) ) {
				return null;
			}
			// get out if we didn't click the Activate button.

			// retrieve the license from the database.
			$license = trim( get_option( 'uo_codes_license_key' ) );

			// data to send in our API request.
			$api_params = array(
				'edd_action' => 'deactivate_license',
				'license'    => $license,
				'item_name'  => urlencode( UO_CODES_ITEM_NAME ),
				// the name of our product in uo.
				'url'        => home_url(),
			);

			// Call the custom API.
			$response = wp_remote_post(
				UO_CODES_STORE_URL,
				array(
					'timeout' => 15,
					'body'    => $api_params,
				)
			);

			// make sure the response came back okay.
			if ( is_wp_error( $response ) ) {
				return false;
			}

			// decode the license data.
			$license_data = json_decode( wp_remote_retrieve_body( $response ) );

			// $license_data->license will be either "deactivated" or "failed".
			if ( $license_data->license === 'deactivated' ) {
				delete_option( 'uo_codes_license_status' );
			}
		}

		return null;
	}

	/**
	 * @param $post
	 */
	public static function add_codes_automator_notice( $post ) {
		if ( 'uo-recipe' === (string) $post->post_type && SharedFunctionality::ulc_filter_has_var( 'ecommerce-available' ) ) {

			$create_product_url = add_query_arg( array( 'post_type' => 'product' ), admin_url( 'post-new.php' ) );
			$knowledge_base_url = 'https://www.uncannyowl.com/knowledge-base/sell-uncanny-codes/';

			?>

			<div id="uoc-automator-ecommerce" class="uoc-backend-notification">
				<div class="uoc-backend-notification__title">
					<?php esc_html_e( 'Hey!', 'uncanny-learndash-codes' ); ?> 👋
				</div>
				<div class="uoc-backend-notification__content">
					<?php printf( __( "Once your recipe is set up, don't forget to connect your code batch to a product if you plan to sell your codes. %1\$s to set up a new product. Visit our %2\$s for additional assistance.", 'uncanny-learndash-codes' ), '<a href="' . $create_product_url . '" target="_blank">' . __( 'Click here', 'uncanny-learndash-codes' ) . '</a>', '<a href="' . $knowledge_base_url . '" target="_blank">' . __( 'Knowledge Base', 'uncanny-learndash-codes' ) . '</a>' ); ?>
				</div>
				<div id="uoc-automator-ecommerce-close" class="uoc-backend-notification__close"></div>
			</div>

			<style>

				.uoc-backend-notification {
					box-shadow: 0 3px 7px 0 rgb(0 0 0 / 10%);
					background: #fff;
					border-radius: 5px;
					padding: 15px;
					width: 300px;
					position: fixed;
					right: 20px;
					bottom: 20px;
					z-index: 10000000;
					border: 5px solid #fff3cf;
				}

				.uoc-backend-notification__title {
					font-size: 16px;
					font-weight: 600;
					margin-bottom: 8px;
				}

				.uoc-backend-notification__close {
					width: 20px;
					height: 20px;

					position: absolute;
					top: 15px;
					right: 15px;

					background-image: url("data:image/svg+xml,%3Csvg aria-hidden='true' role='img' xmlns='http://www.w3.org/2000/svg' viewBox='0 0 320 512'%3E%3Cpath fill='currentColor' d='M207.6 256l107.72-107.72c6.23-6.23 6.23-16.34 0-22.58l-25.03-25.03c-6.23-6.23-16.34-6.23-22.58 0L160 208.4 52.28 100.68c-6.23-6.23-16.34-6.23-22.58 0L4.68 125.7c-6.23 6.23-6.23 16.34 0 22.58L112.4 256 4.68 363.72c-6.23 6.23-6.23 16.34 0 22.58l25.03 25.03c6.23 6.23 16.34 6.23 22.58 0L160 303.6l107.72 107.72c6.23 6.23 16.34 6.23 22.58 0l25.03-25.03c6.23-6.23 6.23-16.34 0-22.58L207.6 256z'%3E%3C/path%3E%3C/svg%3E");
					background-size: contain;
					background-position: center;
					background-repeat: no-repeat;

					cursor: pointer;

					opacity: .5;
				}

				.uoc-backend-notification__close:hover {
					opacity: 1;
				}

			</style>

			<script>

				// Get the element of the close button.
				document.getElementById('uoc-automator-ecommerce-close')
					// Listen to clicks.
					.addEventListener('click', function () {
						// Get the element of the whole notification.
						let $notification = document.getElementById('uoc-automator-ecommerce')

						// Remove it.
						$notification.parentNode.removeChild($notification);
					});

			</script>

			<?php
		}
	}
}
