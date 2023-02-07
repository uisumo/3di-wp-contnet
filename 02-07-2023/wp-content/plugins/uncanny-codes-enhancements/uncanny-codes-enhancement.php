<?php
/*
 * Plugin Name:         Uncanny Codes Enhancements
 * Description:         Uncanny Codes override to show "Linked to" column
 * Author:              Uncanny Owl
 * Author URI:          https://www.uncannyowl.com/
 * Plugin URI:          https://www.uncannyowl.com/downloads/uncanny-learndash-codes/
 * License:             GPLv3
 * License URI:         https://www.gnu.org/licenses/gpl-3.0.html
 * Version:             1.0
 * Requires at least:   5.0
 * Requires PHP:        7.0
 */


/**
 * Class Uncanny_Codes_Enhancement
 */
class Uncanny_Codes_Enhancement {
	/**
	 * Uncanny_Codes_Enhancement constructor.
	 */
	public function __construct() {
		add_action( 'plugin_loaded', array( $this, 'plugins_loaded' ) );
	}

	/**
	 *
	 */
	public function plugins_loaded() {
		add_filter( 'ulc_codes_group_columns', array( $this, 'get_columns' ) );
		add_filter( 'ulc_codes_group_row_ld_type', array( $this, 'get_data' ), 10, 2 );
	}

	/**
	 * @param $column
	 *
	 * @return array|mixed
	 */
	public function get_columns( $column ) {
		$new_column = array();
		if ( $column ) {
			foreach ( $column as $key => $name ) {
				if ( 'paid_unpaid' !== $key ) {
					$new_column[ $key ] = $name;
				} else {
					$new_column[ $key ]    = $name;
					$new_column['ld_type'] = __( 'Course/Group', 'uncanny-learndash-codes' );
				}
			}
			$column = $new_column;
		}

		return $column;
	}

	/**
	 * @param $row
	 * @param $group
	 *
	 * @return string
	 */
	public function get_data( $row, $group ) {
		$r = 'N/A';
		if ( $group->linked_to ) {
			$data = maybe_unserialize( $group->linked_to );
			if ( $data ) {
				$r = '';
				foreach ( $data as $d ) {
					$r .= sprintf( '<a href="%s">%s</a>', get_permalink( $d ), get_the_title( $d ) ) . '<br />';
				}
			}
		}

		return $r;
	}
}

new Uncanny_Codes_Enhancement();
