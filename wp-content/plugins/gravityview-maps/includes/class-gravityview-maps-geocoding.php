<?php
/**
 * GravityView Maps Extension - Geocoding
 *
 * Using the Geocoder php lib
 *
 * @package   GravityView_Maps
 * @license   GPL2+
 * @author    GravityView <hello@gravityview.co>
 * @link      http://gravityview.co
 * @copyright Copyright 2015, Katz Web Services, Inc.
 *
 * @since 1.0.0
 */

class GravityView_Maps_Geocoding extends GravityView_Maps_Component {

	/**
	 * @var \GravityView_Maps_HTTP_Adapter
	 */
	protected $adapter = null;

	/**
	 * @var \Geocoder\Geocoder
	 */
	protected $geocoder = null;


	function load() {

		// Loads the composer libs ( Geocoder, ...)
		require_once $this->loader->dir . 'vendor/autoload.php';
		require_once $this->loader->dir . 'includes/class-gravityview-maps-http-adapter.php';

		try {
			$this->adapter = $this->set_http_adapter();
			$this->geocoder = $this->set_geocoder();
			$this->set_providers();
		} catch ( Exception $e ) {
			do_action( 'gravityview_log_error', '[GravityView Maps] Failed during geocoder load. Error message:', $e->getMessage() );
		}
	}

	/**
	 * Configure the http settings used by the Geocoder
	 *
	 * @return \GravityView_Maps_HTTP_Adapter
	 */
	public function set_http_adapter() {
		return new \GravityView_Maps_HTTP_Adapter();
	}

	/**
	 * Returns the Geocoder instance
	 * @since 1.8
	 * @return \Geocoder\Geocoder
	 */
	public function get_geocoder() {
		return $this->geocoder;
	}

	public function set_geocoder() {
		return new \Geocoder\Geocoder();
	}

	public function set_providers() {

		/** @var GravityView_Maps_Settings $settings */
		$settings = $this->loader->component_instances['settings'];

		$keys = $settings->get_providers_api_keys();

		/**
		 * @filter `gravityview/maps/geocoding/providers/locale` Sets the locale for the geocoding provider. [Default: none; provider will decide.]
		 * @since 1.0
		 * @param null|string $locale A locale (optional). [Default: null]
		 */
		$locale  = apply_filters( 'gravityview/maps/geocoding/providers/locale', null );

		/**
		 * @filter `gravityview/maps/geocoding/providers/region` Sets the region for the geocoding provider. [Default: none; provider will decide.]
		 * @since 1.0
		 * @param null|string $region Region biasing (optional). [Default: null]
		 */
		$region  = apply_filters( 'gravityview/maps/geocoding/providers/region', null );

		$providers = array();

		// Google Maps for Work Provider
		if ( ! empty( $keys['googlemapsbusiness-api-clientid'] ) && ! empty( $keys['googlemapsbusiness-api-key'] ) ) {
			$providers[] = new \Geocoder\Provider\GoogleMapsBusinessProvider(
				$this->adapter,
				$keys['googlemapsbusiness-api-clientid'],
				$keys['googlemapsbusiness-api-key'],
				$locale,
				$region,
				true
			);
		} elseif ( apply_filters( 'gravityview/maps/geocoding/providers/googlemaps', true ) ) {

			/**
			 * @filter `gravityview/maps/geocoding/providers/googlemaps/api_key` Filter the Google Maps API key used for Google Maps Geocoding API
			 * @since 1.4
			 * @param string $googlemaps_key Google Maps Geocoding API key
			 */
			$googlemaps_key = apply_filters( 'gravityview/maps/geocoding/providers/googlemaps/api_key', rgar( $keys, 'googlemaps-api-key' ) );

			// Google Maps Provider (even without key)
			$providers[] = new \Geocoder\Provider\GoogleMapsProvider(
				$this->adapter,
				$locale,
				$region,
				true,
				$googlemaps_key
			);

			unset( $googlemaps_key );
		}

		// Bing Maps Provider
		if ( ! empty( $keys['bingmaps-api-key'] ) ) {
			$providers[] = new \Geocoder\Provider\BingMapsProvider(
				$this->adapter,
				$keys['bingmaps-api-key'],
				$locale
			);

		}

		// MapQuest Provider
		if ( ! empty( $keys['mapquest-api-key'] ) ) {
			$providers[] = new \Geocoder\Provider\MapQuestProvider(
				$this->adapter,
				$keys['mapquest-api-key'],
				$locale,
				/**
				 * @filter `gravityview/maps/geocoding/mapquest/licensed_data`
				 * @param boolean $licensed_data True to use MapQuest's licensed endpoints, default is false to use the open endpoints (optional).
				 */
				apply_filters( 'gravityview/maps/geocoding/mapquest/licensed_data', false )
			);
		}

		// OpenStreetMap Provider
		if ( apply_filters( 'gravityview/maps/geocoding/providers/openstreetmap', true ) ) {
			$providers[] = new \Geocoder\Provider\OpenStreetMapProvider(
				$this->adapter,
				$locale
			);
		}

		if( empty( $providers ) ) {
			do_action( 'gravityview_log_error', '[GravityView Maps] Not possible to use Geocoding without providers' );
			return;
		}

		$this->geocoder->registerProvider(
			new \Geocoder\Provider\ChainProvider( $providers )
		);

	}


	/**
	 * Get the position coordinates for a given address.
	 *
	 * @param string $address string Address to be geocoded
	 *
	 * @return array|Geocoder\Exception\RuntimeException
	 */
	public function geocode( $address ) {

		try {
			$result = $this->geocoder->geocode( $address );
			$coordinates = $result->getCoordinates();
			do_action( 'gravityview_log_debug', __METHOD__ . ': Geocoded ['. $address .'] to ' . implode( ', ', $coordinates ) );
			return $coordinates;
		} catch ( Exception $e ) {
			do_action( 'gravityview_log_error', __METHOD__ . ': Trying to fetch the position of address ['. $address .']. Error message:', $e->getMessage() );
			return $e;
		}

	}

}