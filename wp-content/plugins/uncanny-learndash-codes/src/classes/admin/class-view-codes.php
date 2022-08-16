<?php

namespace uncanny_learndash_codes;

use WP_List_Table;

/**
 * Class ViewCodes
 * @package uncanny_learndash_codes
 */
class ViewCodes extends WP_List_Table {
	/**
	 * @var mixed|string
	 */
	private $group_id;

	/**
	 * ViewCodes constructor.
	 *
	 * @param array $args
	 */
	public function __construct( $args = array() ) {
		parent::__construct();
		$this->group_id = isset( $args['group_id'] ) ? $args['group_id'] : 'all';
	}

	/**
	 *
	 */
	public function prepare_items() {
		if ( empty( $this->group_id ) && SharedFunctionality::ulc_filter_has_var( 'group_id' ) ) {
			$this->group_id = SharedFunctionality::ulc_filter_input( 'group_id' );
		}

		$columns               = $this->get_columns();
		$hidden                = array();
		$sortable              = $this->get_sortable_columns();
		$this->_column_headers = array( $columns, $hidden, $sortable );

		$orderby = ( SharedFunctionality::ulc_filter_has_var( 'orderby' ) ) ? SharedFunctionality::ulc_filter_input( 'orderby' ) : '';
		$order   = ( SharedFunctionality::ulc_filter_has_var( 'order' ) ) ? SharedFunctionality::ulc_filter_input( 'order' ) : '';

		$paged       = SharedFunctionality::ulc_filter_has_var( 'paged' ) ? SharedFunctionality::ulc_filter_input( 'paged' ) : 1;
		$searched    = SharedFunctionality::ulc_filter_has_var( 's' ) ? SharedFunctionality::ulc_filter_input( 's' ) : '';
		$this->items = Database::get_coupons( $this->group_id, $paged, $orderby, $order, $searched );

		$this->set_pagination_args( array(
			'total_items' => Database::get_num_coupons( $this->group_id, $searched ),
			'per_page'    => 100,
		) );
	}

	/**
	 * @return array
	 */
	public function get_columns() {
		return array(
			'coupon'        => esc_html__( 'Code', 'uncanny-learndash-codes' ),
			'used_date'     => esc_html__( 'Redeemed date', 'uncanny-learndash-codes' ),
			'expire_date'   => esc_html__( 'Expiry date', 'uncanny-learndash-codes' ),
			'user_nicename' => esc_html__( 'Redeemed user', 'uncanny-learndash-codes' ),
		);
	}

	/**
	 * @return array
	 */
	protected function get_sortable_columns() {
		return array();
	}

	/**
	 *
	 */
	public function no_items() {
		esc_html_e( 'No codes found.', 'uncanny-learndash-codes' );
	}

	/**
	 *
	 */
	public function display_rows() {
		foreach ( $this->items as $coupon ) {
			echo "\n\t";
			echo $this->single_row( $coupon );
		}
	}

	/**
	 * @param object $coupon
	 *
	 * @return string
	 */
	public function single_row( $coupon ) {
		$r = '<tr>';
		list( $columns ) = $this->get_column_info();

		foreach ( $columns as $column_name => $column_display_name ) {
			$r .= '<td>';
			switch ( $column_name ) {
				case 'coupon' :
					$r .= esc_html( $coupon->code );
					break;

				case 'source' :
					$users = maybe_unserialize( $coupon->user_id );
					if ( $users ) {
						foreach ( $users as $u ) {
							$r .= sprintf( '%s', get_user_meta( $u['user'], Config::$uncanny_codes_tracking, true ) ) . '<br />';
						}
					}
					break;

				case 'used_date' :
					$users = Database::get_users_of_code( $coupon->ID, false );
					if ( $users ) {
						foreach ( $users as $u ) {
							$date_format = get_option( 'date_format', 'F j, Y' );
							$r           .= sprintf( '%s', date_i18n( $date_format, strtotime( $u->date_redeemed ) ) ) . '<br />';
						}
					}
					break;
				case 'expire_date' :
					if ( $coupon->expire_date !== '0000-00-00 00:00:00' ) {
						$date_format = get_option( 'date_format', 'F j, Y' );
						$time_format = get_option( 'time_format', 'g:i a' );
						$r           .= date_i18n( "$date_format $time_format", strtotime( $coupon->expire_date ) );
					} else {
						$r .= esc_html__( 'Unlimited', 'uncanny-learndash-codes' );
					}
					break;

				case 'user_nicename' :
					$users   = Database::get_users_of_code( $coupon->ID, false );
					$display = '';
					if ( $users ) {
						foreach ( $users as $u ) {
							if ( intval( '-1' ) === intval( $u->user_id ) ) {
								$r .= esc_html__( 'Order refunded', 'uncanny-learndash-codes' );
							} else {
								$first_name = get_user_meta( $u->user_id, 'first_name', true );
								$last_name  = get_user_meta( $u->user_id, 'last_name', true );
								if ( empty( $first_name ) && empty( $last_name ) ) {
									$us = get_user_by( 'id', $u->user_id );
									if ( ! empty( $us ) ) {
										$display = $us->user_email;
									}
								} else {
									$display = "{$first_name} {$last_name}";
								}

								$r .= sprintf( '<a href="%s">%s</a>', admin_url( 'user-edit.php?user_id=' . $u->user_id ), $display ) . '<br />';
							}
						}
					}
					break;
			}
			$r .= '</td>';
		}
		$r .= '</tr>';

		return $r;
	}

	/**
	 * @return mixed
	 */
	protected function get_views() {
		$view['download'] = sprintf( '<a href="%s" class="button">%s</a>',
			add_query_arg(
				array( 'group_id' => $this->group_id, 'mode' => 'download', ),
				remove_query_arg( array( 'orderby', 'order' ) )
			),
			esc_html__( 'Download', 'uncanny-learndash-codes' )
		);

		$view['back'] = sprintf( '<a href="%s" class="button">%s</a>',
			remove_query_arg(
				array(
					'group_id',
					'orderby',
					'order',
				)
			),
			esc_html__( 'Back to code group view', 'uncanny-learndash-codes' )
		);

		return $view;
	}

	/**
	 * @return string
	 */
	protected function get_default_primary_column_name() {
		return 'created';
	}
}
