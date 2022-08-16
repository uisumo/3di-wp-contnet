<?php


namespace uncanny_learndash_groups;


/**
 * Class Group_Codes_Handler
 * @package uncanny_learndash_groups
 */
class Group_Management_Seat_Handler {
	/**
	 * @var
	 */
	public static $instance;

	/**
	 * @return Group_Management_Seat_Handler
	 */
	public static function get_instance() {

		if ( null === self::$instance ) {
			self::$instance = new self();
		}

		return self::$instance;
	}

	/**
	 * @param int $count
	 *
	 * @return false|mixed|void
	 */
	public function get_per_seat_text( int $count = 1 ) {
		$seats_label_singular = get_option( 'ulgm_per_seat_text', __( 'Seat', 'uncanny-learndash-groups' ) );
		$seats_label_plural   = get_option( 'ulgm_per_seat_text_plural', __( 'Seats', 'uncanny-learndash-groups' ) );

		return 1 === absint( $count ) ? $seats_label_singular : $seats_label_plural;
	}

	/**
	 * @param $user_id
	 * @param $group_id
	 *
	 * @return string|null
	 */
	public function if_user_redeemed_code( $user_id, $group_id ) {
		global $wpdb;
		$code_group_id = $wpdb->get_var( $wpdb->prepare( 'SELECT ID FROM ' . $wpdb->prefix . ulgm()->db->tbl_group_details . ' WHERE ld_group_id = %d', $group_id ) );
		if ( empty( $code_group_id ) ) {
			return null;
		}

		return $wpdb->get_var( $wpdb->prepare( 'SELECT ID FROM ' . $wpdb->prefix . ulgm()->db->tbl_group_codes . ' WHERE student_id = %d AND group_id = %d LIMIT 0,1', $user_id, $code_group_id ) );
	}

	/**
	 * @param $ld_group_id
	 *
	 * @return int
	 */
	public function total_seats( $ld_group_id ) {

		global $wpdb;
		$group_id = $this->get_code_group_id( $ld_group_id );

		if ( empty( $group_id ) || 0 === absint( $group_id ) ) {
			return 0;
		}

		$total_seats = $wpdb->get_var( $wpdb->prepare( "SELECT COUNT(ID) FROM {$wpdb->prefix}" . ulgm()->db->tbl_group_codes . " WHERE group_id = %d", $group_id ) );

		return absint( $total_seats );
	}

	/**
	 * @param $ld_group_id
	 *
	 * @return string|null
	 */
	public function get_code_group_id( $ld_group_id ) {
		global $wpdb;

		return $wpdb->get_var( $wpdb->prepare( "SELECT ID FROM {$wpdb->prefix}" . ulgm()->db->tbl_group_details . " WHERE ld_group_id = %d", $ld_group_id ) );
	}

	/**
	 * @param $ld_group_id
	 *
	 * @return int
	 */
	public function available_seats( $ld_group_id ) {

		return $this->remaining_seats( $ld_group_id );
	}

	/**
	 * @param $ld_group_id
	 *
	 * @return int
	 */
	public function remaining_seats( $ld_group_id ) {

		$seats_remaining = 0;

		$ld_group_id = absint( $ld_group_id );
		if ( empty( $ld_group_id ) ) {
			return $seats_remaining;
		}

		$group_id = $this->get_code_group_id( $ld_group_id );

		if ( empty( $group_id ) || 0 === absint( $group_id ) ) {
			return $seats_remaining;
		}

		global $wpdb;
		$qry = $wpdb->prepare( 'SELECT COUNT(ID) AS remaining FROM ' . $wpdb->prefix . ulgm()->db->tbl_group_codes . ' WHERE student_id IS NULL AND user_email IS NULL AND group_id = %d', $group_id );

		$seats_remaining = $wpdb->get_var( $qry );

		return absint( $seats_remaining );
	}

	/**
	 * @param $ld_group_id
	 *
	 * @return int
	 */
	public function deleted_seats( $ld_group_id ) {

		$deleted_seats = 0;

		$ld_group_id = absint( $ld_group_id );
		if ( empty( $ld_group_id ) ) {
			return $deleted_seats;
		}

		global $wpdb;
		$qry = $wpdb->prepare( "SELECT COUNT(post_id) AS deleted FROM $wpdb->postmeta WHERE post_id = %d AND meta_key LIKE 'user-id-removed-completed-status-%%%'", $ld_group_id );

		return absint( $wpdb->get_var( $qry ) );
	}
}
