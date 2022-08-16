<?php

namespace uncanny_learndash_codes;

/**
 * Class SharedFunctionality
 * @package uncanny_learndash_codes
 */
class SharedFunctionality {
	/**
	 * @var $__instance
	 */
	public static $__instance;

	/**
	 * SharedFunctions constructor.
	 */
	public function __construct() {
	}

	/**
	 * @return SharedFunctionality
	 */
	public static function get_instance() {
		// check if instance is available.
		if ( null === self::$__instance ) {
			// create new instance if not.
			self::$__instance = new self();
		}

		return self::$__instance;
	}

	/**
	 * @param string $plugin
	 *
	 * @return bool
	 */
	public static function is_active( $plugin = 'learndash' ) {

		switch ( $plugin ) {
			case 'woocommerce':
				if ( class_exists( 'WooCommerce' ) ) {
					return true;
				}
				if ( function_exists( 'WC' ) ) {
					return true;
				}
				include_once( ABSPATH . 'wp-admin/includes/plugin.php' );
				if ( is_plugin_active( 'woocommerce/woocommerce.php' ) ) {
					return true;
				} elseif ( is_plugin_active_for_network( 'woocommerce/woocommerce.php' ) ) {
					return true;
				}
				break;
			case 'learndash':
				global $learndash_post_types;

				if ( isset( $learndash_post_types ) ) {
					return true;
				}
				break;
			case 'automator':
				if ( class_exists( '\Uncanny_Automator\InitializePlugin' ) ) {
					return true;
				}
				break;
			default:
				return true;
				break;
		}
	}

	/**
	 * @param      $product_id
	 * @param null $codes_group
	 *
	 * @return string|null
	 */
	public static function get_available_codes_by_group_id( $product_id, $codes_group = null ) {
		if ( null == $codes_group ) {
			$codes_group = self::get_codes_group_id_by_product( $product_id );
		}
		global $wpdb;
		$table1 = $wpdb->prefix . Config::$tbl_codes;
		$table2 = $wpdb->prefix . Config::$tbl_codes_usage;
		$sql    = $wpdb->prepare( "SELECT count(ID) FROM {$table1} WHERE code_group=%d AND order_id=%d AND ID NOT IN (SELECT code_id FROM {$table2})", $codes_group, 0 );

		return $wpdb->get_var( $sql );
	}

	/**
	 * @param $product_id
	 *
	 * @return int
	 */
	public static function get_codes_group_id_by_product( $product_id ) {
		return $current_codes_group = absint( get_post_meta( $product_id, 'codes_group_name', true ) );

	}

	/**
	 * @param null $codes_group
	 *
	 * @return string|null
	 */
	public static function get_products_by_batch_id( $codes_group = null ) {
		if ( null == $codes_group ) {
			return null;
		}

		global $wpdb;
		$table = $wpdb->prefix . Config::$tbl_groups;
		$sql   = $wpdb->prepare( "SELECT product_id FROM {$table} WHERE ID=%d", $codes_group );

		return $wpdb->get_var( $sql );
	}

	/**
	 * @param string $type
	 * @param null   $variable
	 * @param string $flags
	 *
	 * @return mixed
	 */
	public static function ulc_filter_input( $variable = null, $type = INPUT_GET, $flags = FILTER_SANITIZE_STRING ) {
		/*
		 * View input types: https://www.php.net/manual/en/function.filter-input.php
		 * View flags at: https://www.php.net/manual/en/filter.filters.sanitize.php
		 */
		return filter_input( $type, $variable, $flags );
	}


	/**
	 * @param string $type
	 * @param null   $variable
	 * @param string $flags
	 *
	 * @return mixed
	 */
	public static function ulc_filter_has_var( $variable = null, $type = INPUT_GET ) {
		return filter_has_var( $type, $variable );
	}

	/**
	 * @param string $type
	 * @param null   $variable
	 * @param string $flags
	 *
	 * @return mixed
	 */
	public static function ulc_filter_input_array( $variable = null, $type = INPUT_GET, $flags = array() ) {
		if ( empty( $flags ) ) {
			$flags = array(
				'filter' => FILTER_VALIDATE_INT,
				'flags'  => FILTER_REQUIRE_ARRAY,
			);
		}
		/*
		 * View input types: https://www.php.net/manual/en/function.filter-input.php
		 * View flags at: https://www.php.net/manual/en/filter.filters.sanitize.php
		 */
		$args = array( $variable => $flags );
		$val  = filter_input_array( $type, $args );

		return isset( $val[ $variable ] ) ? $val[ $variable ] : array();
	}
}
