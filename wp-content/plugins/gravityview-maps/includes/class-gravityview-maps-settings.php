<?php
/**
 * GravityView Maps Extension - Settings class
 * Adds a general setting to the GravityView settings screen
 *
 * @package   GravityView_Maps
 * @license   GPL2+
 * @author    GravityView <hello@gravityview.co>
 * @link      http://gravityview.co
 * @copyright Copyright 2015, Katz Web Services, Inc.
 *
 * @since     1.0.0
 */

class GravityView_Maps_Settings extends GravityView_Maps_Component {

	/**
	 * @var string Unique reference name for nonce and UI assets
	 */
	const UNIQUE_HANDLE = 'gravityview_maps_settings';

	/**
	 * @var string AJAX action to verify key
	 */
	const AJAX_ACTION_VERIFY_API_KEY = 'gravityview_maps_verify_api_key';

	/**
	 * @var array Geocoding provider information: [settings key] => name of constant
	 */
	private $providers = array();

	function load() {

		$this->providers = $this->get_providers_api_keys();

		add_action( 'gravityview/settings/extension/sections', array( $this, 'register_settings' ), 10, 1 );
		add_filter( 'option_gravityformsaddon_gravityview_app_settings', array( $this, 'maybe_override_api_key_settings' ) );
		add_filter( 'gravityview_noconflict_styles', array( $this, 'register_no_conflicts' ) );
		add_filter( 'gravityview_noconflict_scripts', array( $this, 'register_no_conflicts' ) );
		add_action( 'admin_enqueue_scripts', array( $this, 'enqueue_scripts' ), 1 );
		add_action( 'wp_ajax_' . self::AJAX_ACTION_VERIFY_API_KEY, array( $this, 'verify_api_key' ) );
	}

	/**
	 * Modify the GravityView Map settings based on the fetched values
	 *
	 * Since our provider array has filtered values, as well as values set using constants, we need to override the
	 * WordPress settings.
	 *
	 * @param array $settings GravityView plugin settings array
	 *
	 * @return array
	 */
	public function maybe_override_api_key_settings( $settings = array() ) {

		$valid_provider_keys = array( 'googlemaps-api-key', 'googlemapsbusiness-api-clientid', 'googlemapsbusiness-api-key', 'bingmaps-api-key', 'mapquest-api-key' );

		foreach ( $this->providers as $name => $api_key ) {

			if ( empty( $api_key ) ) {
				continue;
			}

			// Sanity check
			if ( ! in_array( $name, $valid_provider_keys, true ) ) {
				continue;
			}

			$settings[ $name ] = $api_key;
		}

		return $settings;
	}

	/**
	 * Get an array of geocoding providers with their API keys
	 *
	 * If constants are set for the provider, uses that value.
	 * @see https://docs.gravityview.co/article/304-setting-up-geocoding-services
	 *
	 * Can be overridden using filters:
	 * add_filter( 'gravityview/maps/geocoding/providers/mapquest-api-key/api_key', function() { return 'example'; } );
	 *
	 * @since 1.7
	 *
	 * @param array Providers with keys set to setting key name, values set to API key values (empty string if not set)
	 */
	public function get_providers_api_keys() {

		// Don't process after initialized
		if ( ! empty( $this->providers ) ) {
			return $this->providers;
		}

		if( ! function_exists( 'gravityview' ) ) {
			do_action( 'gravityview_log_error', __METHOD__ . ': GravityView function does not exist, not able to get API keys.' );
			return false;
		}

		$providers = array();

		$keys = array(
			'googlemaps-api-key' => 'GRAVITYVIEW_GOOGLEMAPS_KEY',
			'googlemapsbusiness-api-clientid' => 'GRAVITYVIEW_GOOGLEBUSINESSMAPS_CLIENTID',
			'googlemapsbusiness-api-key' => 'GRAVITYVIEW_GOOGLEBUSINESSMAPS_KEY',
			'bingmaps-api-key' => 'GRAVITYVIEW_BING_KEY',
			'mapquest-api-key' => 'GRAVITYVIEW_MAPQUEST_KEY',
		);

		foreach( $keys as $key => $constant_name ) {

			if ( defined( $constant_name ) ) {
				$api_key = constant( $constant_name );
			} else {
				$api_key = gravityview()->plugin->settings->get( $key, '' );
			}

			/**
			 * @filter Modifies the API key used for a geocoding provider
			 * @since 1.7
			 * @param string $api_key API key pulled from GravityView Maps settings or a constant
			 */
			$api_key = apply_filters( 'gravityview/maps/geocoding/providers/' . $key . '/api_key', trim( $api_key ) );

			$providers[ $key ] = $api_key;
		}

		return $providers;
	}

	/**
	 * Add GravityView Maps settings
	 */
	public function register_settings( $sections ) {

		$providers = $this->get_providers_api_keys();

		$settings = array();

		$settings[] = array(
			'name'        => 'googlemaps-api-key',
			'type'      => 'text',
			'default_value'   => $providers['googlemaps-api-key'],
			'class'    => 'regular-text code',
			'label'     => __( 'Google Maps API Key', 'gravityview-maps' ),
			'required' => true,
			'placeholder' => esc_html__( 'Enter your Google Maps API key here.', 'gravityview-maps' ),
			'description'  => '<span class="inline notice notice-warning" style="width: 90%; box-sizing: border-box;"><p>' . esc_html__( 'A Google Maps API key is required.', 'gravityview-maps' ) . '<br />' . '<a href="http://docs.gravityview.co/article/306-signing-up-for-a-google-maps-api-key" data-beacon-article-modal="5605872bc6979105f62b023a">' . sprintf( esc_html__( 'How to get a %s', 'gravityview-maps' ), __( 'Google Maps API Key', 'gravityview-maps' ) ) . '</a></p></span><span class="wrap" style="display: block">' . sprintf( esc_html__('GravityView will attempt to convert addresses into longitude and latitude values. This process is called geocoding, and is required to display entries on a map. %sLearn more about GravityView Maps geocoding.%s', 'gravityview-maps' ) , '<a href="http://docs.gravityview.co/article/304-setting-up-geocoding-services" data-beacon-article-modal="56057b6dc6979105f62b0216">', '</a>' ) . '</span>',
			'after_input' => $this->get_key_validation_html(),
		);

		if( ! empty( $providers['googlemapsbusiness-api-clientid'] ) ) {
			$settings[] = array(
				'name'          => 'googlemapsbusiness-api-clientid',
				'type'          => 'text',
				'default_value' => $providers['googlemapsbusiness-api-clientid'],
				'class'         => 'regular-text',
				'label'         => __( 'Google Maps API for Work Client ID', 'gravityview-maps' ),
				'placeholder'   => __( 'Google Maps API for Work Client ID', 'gravityview-maps' ),
				'tooltip'       => sprintf( __( 'Read more about %sGoogle Maps API for Work%s  and learn how to obtain your key.', 'gravityview-maps' ), '<a href="https://developers.google.com/maps/documentation/business/">', '</a>' ),
			);
		}

		if( ! empty( $providers['googlemapsbusiness-api-key'] ) ) {
			$settings[] = array(
				'name'          => 'googlemapsbusiness-api-key',
				'type'          => 'text',
				'default_value' => $providers['googlemapsbusiness-api-key'],
				'class'         => 'regular-text',
				'label'         => __( 'Google Maps API for Work Key', 'gravityview-maps' ),
				'placeholder'   => __( 'Google Maps API for Work Key', 'gravityview-maps' ),
				'tooltip'       => sprintf( __( 'Read more about %sGoogle Maps API for Work%s  and learn how to obtain your key.', 'gravityview-maps' ), '<a href="https://developers.google.com/maps/documentation/business/">', '</a>' ),
			);
		}

		if( ! empty( $providers['bingmaps-api-key'] ) ) {
			$settings[] = array(
				'name'          => 'bingmaps-api-key',
				'type'          => 'text',
				'default_value' => $providers['bingmaps-api-key'],
				'class'         => 'regular-text',
				'label'         => __( 'Bing Maps Locations API Key', 'gravityview-maps' ),
				'placeholder'   => __( 'Bing Maps Locations API Key', 'gravityview-maps' ),
				'tooltip'       => '',
				'description'   => '<a href="http://docs.gravityview.co/article/307-signing-up-for-a-bing-maps-api-key" data-beacon-article-modal="56058cebc6979105f62b0251">' . sprintf( esc_html__( 'How to get a %s', 'gravityview-maps' ), __( 'Bing Maps Locations API Key', 'gravityview-maps' ) ) . '</a>',
			);
		}

		if( ! empty( $providers['mapquest-api-key'] ) ) {
			$settings[] = array(
				'name'          => 'mapquest-api-key',
				'type'          => 'text',
				'default_value' => $providers['mapquest-api-key'],
				'class'         => 'regular-text',
				'label'         => __( 'MapQuest Geocoding API Key', 'gravityview-maps' ),
				'placeholder'   => __( 'MapQuest Geocoding API Key', 'gravityview-maps' ),
				'description'   => '<a href="http://docs.gravityview.co/article/305-signing-up-for-a-mapquest-geocoding-api-key" data-beacon-article-modal="56058195c6979105f62b022c">' . sprintf( esc_html__( 'How to get a %s', 'gravityview-maps' ), __( 'MapQuest Geocoding API Key', 'gravityview-maps' ) ) . '</a>',
			);
		}

		// register section
		$sections[] = array(
			'title' => __( 'Maps', 'gravityview-maps' ),
			'description' => wpautop( sprintf( esc_html__( 'GravityView will attempt to convert addresses into longitude and latitude values. This process is called geocoding, and is required to display entries on a map. To ensure entries are geocoded, sign up for one or more of the free services below. %sLearn more about GravityView Maps geocoding.%s', 'gravityview-maps' ), '<a href="http://docs.gravityview.co/article/304-setting-up-geocoding-services">', '</a>' ) ),
			'fields' => $settings,
		);

		return $sections;
	}

	/**
	 * Define and localize UI assets
	 *
	 * @return void
	 */
	function enqueue_scripts() {

		if( 'settings' !== gravityview()->request->is_admin( true ) ) {
			return;
		}

		$script_style_name = 'gv-maps-settings';
		$script_debug      = ( defined( 'SCRIPT_DEBUG' ) && SCRIPT_DEBUG ) ? '' : '.min';
		$options           = array(
			'nonce'                 => wp_create_nonce( self::UNIQUE_HANDLE ),
			'action_verify_api_key' => self::AJAX_ACTION_VERIFY_API_KEY,
		);

		wp_enqueue_style( self::UNIQUE_HANDLE, $this->loader->css_url . "${script_style_name}.css", array(), $this->loader->plugin_version );
		wp_enqueue_script( self::UNIQUE_HANDLE, $this->loader->js_url . "${script_style_name}${script_debug}.js", array( 'jquery' ), $this->loader->plugin_version, true );
		wp_localize_script( self::UNIQUE_HANDLE, 'GV_MAPS_SETTINGS', $options );
	}

	/**
	 * Add GravityView scripts and styles to Gravity Forms and GravityView No-Conflict modes
	 *
	 * @param array $registered Existing scripts or styles that have been registered (array of the handles)
	 *
	 * @return array $registered
	 */
	function register_no_conflicts( $registered ) {

		$registered[] = self::UNIQUE_HANDLE;

		return $registered;
	}

	/**
	 * Fetch and cache address field coordinates
	 *
	 * @return void Exit with JSON response or terminate request with error code
	 */
	public function verify_api_key() {

		// Validate AJAX request
		$is_valid_nonce   = wp_verify_nonce( rgar( $_POST, 'nonce' ), self::UNIQUE_HANDLE );
		$is_valid_action  = self::AJAX_ACTION_VERIFY_API_KEY === rgar( $_POST, 'action' );
		$is_valid_api_key = ! empty( rgar( $_POST, 'api_key' ) );

		if ( ! $is_valid_nonce || ! $is_valid_action || ! $is_valid_api_key ) {
			// Return 'forbidden' response if nonce is invalid, otherwise it's a 'bad request'
			wp_die( false, false, array( 'response' => ( ! $is_valid_nonce ) ? 403 : 400 ) );
		}

		$api_key = rgar( $_POST, 'api_key' );

		$http_adapter = new GravityView_Maps_HTTP_Adapter();
		try {
			$address = sprintf( \Geocoder\Provider\GoogleMapsProvider::ENDPOINT_URL_SSL, 'Paris' );
			$api_request = $http_adapter->getContent(  $address . '&key=' . $api_key );
			$api_request = json_decode( $api_request, true );

			do_action( 'gravityview_log_debug', __METHOD__ . ' Google API verification request response:', $api_request );

			$geocoding_success = esc_html__( 'This Google API key is able to convert addresses into longitude and latitude.', 'gravityview-maps' );

			$geocoding_error = esc_html__( 'This Google API key is unable to convert addresses into longitude and latitude. To fix this, please ensure that your key is correct and [link]enable Geocoding API[/link].', 'gravityview-maps' );
			$geocoding_error = str_replace( '[link]', '<a href="' . esc_url( 'https://console.cloud.google.com/apis/library/geocoding-backend.googleapis.com' ) . '">', $geocoding_error );
			$geocoding_error = str_replace( '[/link]', '</a>', $geocoding_error );

			$api_key_success = esc_html__( 'This Google API Key supports embedding a map on your site.', 'gravityview-maps' );
			$api_key_error   = array(
				'referrer_restriction' => esc_html__( 'This Google API Key is has settings that restrict access based on "HTTP referrers". The Maps plugin requires the use of "IP addresses" restrictions in the API key settings.', 'gravityview-maps' ),
				'invalid' => esc_html__( 'This Google API Key is invalid. Please verify that you entered the correct key.', 'gravityview-maps' ),
			);

			$response = array(
				'mapping'   => array(
					'capability' => 'mapping',
					'enabled'    => true,
					'message'    => $api_key_success,
				),
				'geocoding' => array(
					'capability' => 'geocoding',
					'enabled'    => true,
					'message'    => $geocoding_success
				),
			);

			if ( ! empty( $api_request['error_message'] ) ) {

				// API key "Application restrictions" like HTTP referrer
				if( preg_match( '/API keys with referer restrictions/', $api_request['error_message'] ) ) {
					$response['geocoding'] = array_merge( $response['geocoding'], array( 'enabled' => false, 'message' => $api_key_error['referrer_restriction'] ) );
					$response['mapping']   = array_merge( $response['mapping'], array( 'enabled' => false, 'message' => esc_html( $api_key_error['referrer_restriction'] ) ) );
				}
				// API key "Application restrictions" like IP address limitations
				elseif( preg_match( '/(cannot be used with this API)|(Request received from IP)/', $api_request['error_message'] ) ) {
					$response['geocoding'] = array_merge( $response['geocoding'], array( 'enabled' => false, 'message' => esc_html( $api_request['error_message'] ) ) );
					$response['mapping']   = array_merge( $response['mapping'], array( 'enabled' => false, 'message' => esc_html( $api_request['error_message'] ) ) );
				}
				// API key "API restrictions" settings in Google Cloud
				elseif ( preg_match( '/not authorized/', $api_request['error_message'] ) ) {
					$response['geocoding'] = array_merge( $response['geocoding'], array( 'enabled' => false, 'message' => $geocoding_error ) );
				}
				// Purely wrong API key?
				else {
					$response['geocoding'] = array_merge( $response['geocoding'], array( 'enabled' => false, 'message' => $geocoding_error ) );
					$response['mapping']   = array_merge( $response['mapping'], array( 'enabled' => false, 'message' => $api_key_error['invalid'] ) );
				}
			}
			wp_send_json_success( $response );
		} catch ( \Exception $e ) {
			wp_send_json_error( $e->getMessage() );
		}
	}

	/**
	 * Returns HTML for the API key validation box
	 *
	 * @return string HTML for API validation container
	 */
	private function get_key_validation_html() {

		$verification_in_progress = esc_html__( 'Verifying your Google Maps API key&hellip;', 'gravityview-maps' );
		$mapping                  = esc_html_x( 'Mapping (required)', 'Google Maps API capability', 'gravityview-maps' );
		$geocoding                = esc_html_x( 'Geocoding', 'Google Maps API capability', 'gravityview-maps' );
		$verification_failed      = esc_html__( 'Google Maps API key verification failed due to a server error.', 'gravityview-maps' );
		$key_required             = esc_html__( 'The Google Maps API key is required.', 'gravityview-maps' );

		$verify_key = sprintf( '<button type="button" class="gv-map-api-verify button button-small button-secondary hidden">%s</button>', esc_html__( 'Check Again', 'gravityview-maps' ) );

		return <<<HTML
<div class="inline wrap gv-maps-api-validation hidden" aria-live="polite">
	{$verify_key}
	
    <div id="api_key_verification" class="hidden">
        <span class="spinner"></span> {$verification_in_progress}
    </div>
    
    <div id="api_key_verification_error" class="hidden">
        <span class="dashicons dashicons-no"></span> {$verification_failed}
    </div>
    
    <div id="api_key_required_error" class="hidden">
        <span class="dashicons dashicons-no"></span> {$key_required}
    </div>
    
    <div id="api_key_verification_response" class="hidden">
        <div class="gv-maps-api-cap gv-maps-api-cap-mapping">
            <span class="dashicons"></span> {$mapping}
            <span class="description"></span>
        </div>
        <br />
        <div class="gv-maps-api-cap gv-maps-api-cap-geocoding">
            <span class="dashicons"></span> {$geocoding}
            <span class="description"></span>
        </div>
    </div>
</div>
HTML;
	}
}
