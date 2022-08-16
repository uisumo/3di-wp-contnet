<?php

namespace uncanny_learndash_codes;

use DateTime;

/**
 * Class Database
 * @package uncanny_learndash_codes
 */
class Database extends Config {

	/**
	 * Database constructor.
	 */
	public function __construct() {
		parent::__construct();
		add_action( 'uncanny_codes_migrate_users', array( __CLASS__, 'migrate_user_ids' ) );
	}

	/**
	 *
	 */
	public static function reset() {
		global $wpdb;
		$wpdb->query( "DROP TABLE {$wpdb->prefix}" . Config::$tbl_codes );
		$wpdb->query( "DROP TABLE {$wpdb->prefix}" . Config::$tbl_groups );
		$wpdb->query( "DROP TABLE {$wpdb->prefix}" . Config::$tbl_codes_usage );
	}

	/**
	 *
	 */
	public static function reset_data() {
		global $wpdb;
		$wpdb->query( "TRUNCATE {$wpdb->prefix}" . Config::$tbl_codes );
		$wpdb->query( "TRUNCATE {$wpdb->prefix}" . Config::$tbl_groups );
		$wpdb->query( "TRUNCATE {$wpdb->prefix}" . Config::$tbl_codes_usage );
	}

	/**
	 *
	 */
	public static function fix_unique_code_issues() {
		global $wpdb;
		$tbl_codes = $wpdb->prefix . Config::$tbl_codes;
		$results   = $wpdb->get_results( "SELECT `code`, COUNT(`code`) AS `count` FROM {$tbl_codes} GROUP BY `code` HAVING `count` > 1" );
		if ( $results ) {
			// found more than 1 unique code.
			foreach ( $results as $r ) {
				$code = $r->code;
				if ( $r->count > 1 ) {
					$all_codes = $wpdb->get_col( $wpdb->prepare( "SELECT `code` FROM $tbl_codes WHERE `code` LIKE %s ORDER BY ID ASC", $code ) );
					// remove last element as the highest ID.
					array_pop( $all_codes );
					// remove all other codes.
					$wpdb->query( "DELETE FROM $tbl_codes WHERE ID IN (" . join( ',', $all_codes ) . ")" );
				}
			}
		}
		update_option( 'ulc_unique_code_fixes', UNCANNY_LEARNDASH_CODES_DB_VERSION );

		return true;
	}

	/**
	 * @param $group
	 * @param $coupons
	 *
	 * @return int
	 */
	public static function add_code_group_batch( $group ) {
		if ( ! self::is_codes_table_exists() ) {
			self::create_tables( true );
		}

		global $wpdb;

		$now         = current_time( 'mysql' );
		$expiry_date = '0000-00-00 00:00:00';
		$linked_to   = array();
		if ( 'course' === (string) $group['coupon-for'] ) {
			$linked_to = (array) $group['coupon-courses'];
		} elseif ( 'group' === (string) $group['coupon-for'] ) {
			$linked_to = (array) $group['coupon-group'];
		}
		if ( ! empty( $group['expiry-date'] ) ) {
			if ( ! empty( $group['expiry-time'] ) ) {
				$expiry_date = date( 'Y-m-d H:i:s', strtotime( $group['expiry-date'] . ' ' . $group['expiry-time'] ) );
			} else {
				$expiry_date = date( 'Y-m-d 23:59:59', strtotime( $group['expiry-date'] ) );
			}
		}
		if ( ! isset( $group['coupon-character-type'] ) || empty( $group['coupon-character-type'] ) ) {
			$character_types = array( 'uppercase-letters', 'numbers' );
		} else {
			$character_types = $group['coupon-character-type'];
		}
		$insert_array  = array(
			'name'            => $group['group-name'],
			'code_for'        => $group['coupon-for'],
			'paid_unpaid'     => $group['coupon-paid-unpaid'],
			'prefix'          => $group['coupon-prefix'],
			'suffix'          => $group['coupon-suffix'],
			'issue_date'      => $now,
			'linked_to'       => serialize( $linked_to ),
			'character_type'  => serialize( $character_types ),
			'issue_count'     => intval( $group['coupon-amount'] ),
			'issue_max_count' => intval( $group['coupon-max-usage'] ),
			'dash'            => $group['coupon-dash'],
			'expire_date'     => $expiry_date,
		);
		$insert_sanity = array(
			'%s',
			'%s',
			'%s',
			'%s',
			'%s',
			'%s',
			'%s',
			'%s',
			'%d',
			'%d',
			'%s',
			'%s',
		);

		$wpdb->insert(
			$wpdb->prefix . Config::$tbl_groups,
			$insert_array,
			$insert_sanity
		);

		return $wpdb->insert_id;
	}

	/**
	 * @return false|int
	 */
	public static function is_codes_table_exists() {
		global $wpdb;
		$qry = "SHOW TABLES LIKE '{$wpdb->prefix}" . Config::$tbl_codes . "';";

		return $wpdb->query( $qry );
	}

	/**
	 * @return false|int
	 */
	public static function is_batch_table_exists() {
		global $wpdb;
		$qry = "SHOW TABLES LIKE '{$wpdb->prefix}" . Config::$tbl_groups . "';";

		return $wpdb->query( $qry );
	}

	/**
	 * @return false|int
	 */
	public static function is_usage_table_exists() {
		global $wpdb;
		$qry = "SHOW TABLES LIKE '{$wpdb->prefix}" . Config::$tbl_codes_usage . "';";

		return $wpdb->query( $qry );
	}

	/**
	 * @param bool $override
	 *
	 * @return bool|void
	 */
	public static function create_tables( $override = false ) {
		$db_version = get_option( 'ulc_database_version', '1.0' );
		if ( ! $override && null !== $db_version && (string) UNCANNY_LEARNDASH_CODES_DB_VERSION === (string) $db_version ) {
			// bail. No db upgrade needed!
			return;
		}

		global $wpdb;

		$tbl_codes       = Config::$tbl_codes;
		$tbl_groups      = Config::$tbl_groups;
		$tbl_usage       = Config::$tbl_codes_usage;
		$charset_collate = $wpdb->get_charset_collate();

		$sql = "CREATE TABLE {$wpdb->prefix}{$tbl_codes} (
`ID` bigint unsigned NOT NULL auto_increment,
`code_group` bigint unsigned NOT NULL,
`code` varchar(180) NOT NULL,
`used_date` datetime,
`user_id` LONGTEXT,
`order_id` bigint unsigned DEFAULT 0 NOT NULL,
`migrated` tinyint(1) NOT NULL DEFAULT '0',
PRIMARY KEY (ID),
UNIQUE KEY `code` (`code`),
KEY `order_id` (`order_id`),
KEY `code_group` (`code_group`)
) ENGINE=InnoDB {$charset_collate};
CREATE TABLE {$wpdb->prefix}{$tbl_usage} (
`ID` bigint unsigned NOT NULL auto_increment,
`code_id` bigint unsigned NOT NULL,
`user_id` bigint signed NOT NULL,
`date_redeemed` datetime,
PRIMARY KEY (ID),
KEY `user_id` (`user_id`)
) ENGINE=InnoDB {$charset_collate};
CREATE TABLE {$wpdb->prefix}{$tbl_groups} (
`ID` bigint unsigned NOT NULL auto_increment,
`name` varchar(200),
`code_for` varchar(30) DEFAULT '' NOT NULL,
`paid_unpaid` varchar(20) DEFAULT 'default' NOT NULL,
`prefix` varchar(20) DEFAULT '' NOT NULL,
`suffix` varchar(20) DEFAULT '' NOT NULL,
`issue_date` datetime,
`expire_date` datetime,
`linked_to` LONGTEXT,
`character_type` varchar(100) DEFAULT '' NOT NULL,
`issue_count` bigint unsigned NOT NULL,
`issue_max_count` bigint unsigned NOT NULL,
`dash` varchar(30) DEFAULT '' NOT NULL,
`product_id` bigint unsigned NOT NULL DEFAULT '0',
PRIMARY KEY (ID),
KEY `code_for` (code_for(5)),
KEY `name` (name(10)),
KEY `prefix` (prefix(4)),
KEY `suffix` (suffix(4)),
KEY `product_id` (`product_id`)
); ENGINE=InnoDB {$charset_collate}";

		require_once ABSPATH . 'wp-admin/includes/upgrade.php';
		dbDelta( $sql );
		wp_schedule_single_event( time() + 60, 'uncanny_codes_migrate_users' );
		update_option( 'ulc_database_version', UNCANNY_LEARNDASH_CODES_DB_VERSION );
	}

	// Login Coupon Methods.

	/**
	 *
	 */
	public static function migrate_user_ids() {
		if ( ! self::is_usage_table_exists() ) {
			self::create_tables( true );
		}
		$users_migrated = get_option( 'ulc_users_migrated', 0 );
		if ( 1 === $users_migrated ) {
			// bail. No db upgrade needed!
			return;
		}
		global $wpdb;
		$tbl_codes = $wpdb->prefix . Config::$tbl_codes;
		$wpdb->query( $wpdb->prepare( "UPDATE {$tbl_codes} SET migrated=%d WHERE user_id IS NULL", 1 ) );
		$results = $wpdb->get_results( $wpdb->prepare( "SELECT ID, user_id FROM {$tbl_codes} WHERE migrated = %d LIMIT 0, 200", 0 ) );
		if ( $results ) {
			foreach ( $results as $result ) {
				$code_id = $result->ID;
				$users   = maybe_unserialize( $result->user_id );
				if ( $users ) {
					foreach ( $users as $user ) {
						$user_id = $user['user'];
						$date    = date( 'Y-m-d H:i:s', $user['redeemed'] );
						$wpdb->insert(
							$wpdb->prefix . Config::$tbl_codes_usage,
							array(
								'code_id'       => $code_id,
								'user_id'       => $user_id,
								'date_redeemed' => $date,
							),
							array(
								'%d',
								'%d',
								'%s',
							)
						);
						// Added usermeta as a backup to store the User ID usermeta before removing from codes table.
						update_user_meta( $user_id, 'ulc_migration_' . $code_id, $date );
					}
				}
				$wpdb->query( $wpdb->prepare( "UPDATE {$tbl_codes} SET migrated=%d WHERE ID=%d", 1, $code_id ) );
			}
		}
		$results = $wpdb->get_var( $wpdb->prepare( "SELECT count(ID) FROM {$tbl_codes} WHERE migrated = %d", 0 ) );
		if ( $results ) {
			// Migrate more codes on next load.
			wp_schedule_single_event( time() + 60, 'uncanny_codes_migrate_users' );
		} else {
			update_option( 'ulc_users_migrated', 1 );
		}
	}

	/**
	 * @param        $group_id
	 * @param        $codes
	 * @param        $args
	 *
	 * @return string|null
	 */
	public static function add_codes_to_batch( $group_id, $codes, $args ) {
		$method = (string) $args['generation_type'];
		if ( 'manual' === $method ) {
			return self::handle_manual_codes( $group_id, $codes, $args );
		}

		$total     = absint( $args['coupon_amount'] );
		$num_codes = self::number_of_codes_per_batch( $total );
		$inserted  = self::handle_auto_code( $group_id, $args, $num_codes );
		if ( absint( $inserted ) === absint( $total ) ) {
			// requested codes added, return count.
			return $inserted;
		}
	}

	/**
	 * @param       $group_id
	 * @param array $codes
	 * @param array $args
	 *
	 * @return int|mixed|string|null
	 */
	public static function handle_manual_codes( $group_id, $codes = array(), $args = array() ) {
		if ( ! self::is_codes_table_exists() ) {
			self::create_tables( true );
		}
		if ( empty( $codes ) ) {
			return 0;
		}
		$total = count( $codes );
		if ( count( $codes ) > 1000 ) {
			$chunks = array_chunk( $codes, 1000 );
		} else {
			$chunks = array( $codes );
		}
		global $wpdb;
		$tbl_codes = $wpdb->prefix . Config::$tbl_codes;
		if ( empty( $chunks ) ) {
			return 0;
		}

		$chunk_no = 1;
		foreach ( $chunks as $chunk ) {
			$chunk_no ++;
			$insert = self::build_insert_query( $group_id, $chunk );
			$query  = "INSERT IGNORE INTO $tbl_codes (ID, code_group, code) VALUES $insert";
			$wpdb->query( $query );

		}

		$inserted = $wpdb->get_var( $wpdb->prepare( "SELECT COUNT(ID) FROM $tbl_codes WHERE code_group=%d", $group_id ) );
		if ( absint( $inserted ) === absint( $total ) ) {
			// requested codes added, return count.
			return $inserted;
		}

		if ( absint( $inserted ) !== absint( $total ) ) {
			// return insert if codes were pasted manually.
			$added = $wpdb->get_col( $wpdb->prepare( "SELECT code FROM $tbl_codes WHERE code_group = %d", $group_id ) );
			$diff  = array_diff( $codes, $added );
			if ( ! empty( GenerateCodes::$rejected_batch_codes ) ) {
				GenerateCodes::$rejected_batch_codes = array_unique( array_merge( (array) $diff, (array) GenerateCodes::$rejected_batch_codes ) );
			} else {
				GenerateCodes::$rejected_batch_codes = array_unique( (array) $diff );
			}
			if ( 0 === $inserted ) {
				// roll back group.
				$tbl_groups = $wpdb->prefix . Config::$tbl_groups;
				$wpdb->query( $wpdb->prepare( "DELETE FROM $tbl_groups WHERE ID = %d", $group_id ) );
			}

			return $inserted;
		}
	}

	/**
	 * @param $group_id
	 * @param $codes
	 *
	 * @return string|void
	 */
	public static function build_insert_query( $group_id, $codes ) {
		if ( empty( $codes ) ) {
			return;
		}
		$raw = array();
		foreach ( $codes as $code ) {
			$raw[] = "(NULL, $group_id, '$code')";
		}

		return join( ',', $raw );
	}

	/**
	 * @param $number
	 *
	 * @return array
	 */
	private static function number_of_codes_per_batch( $number ) {
		$ar = array();
		if ( $number <= 1000 ) {
			$ar[] = $number;
		} else {
			while ( $number > 1000 ) {
				$ar[]   = 1000;
				$number = $number - 1000;
			}
			$ar[] = $number;
		}

		return $ar;
	}

	/**
	 * @param $group_id
	 * @param $args
	 * @param $num_codes
	 *
	 * @return string|null
	 */
	public static function handle_auto_code( $group_id, $args, $num_codes ) {
		if ( ! self::is_codes_table_exists() ) {
			self::create_tables( true );
		}
		$total = absint( $args['coupon_amount'] );
		global $wpdb;
		$tbl_codes = $wpdb->prefix . Config::$tbl_codes;
		if ( $num_codes ) {
			foreach ( $num_codes as $k => $to_generate ) {
				$codes  = GenerateCodes::get_unique_codes( $args, $to_generate );
				$insert = self::build_insert_query( $group_id, $codes );
				$query  = "INSERT IGNORE INTO $tbl_codes (`ID`, `code_group`, `code`) VALUES $insert";
				$wpdb->query( $query );
			}
		}

		$inserted = $wpdb->get_var( $wpdb->prepare( "SELECT COUNT(ID) FROM $tbl_codes WHERE code_group=%d", $group_id ) );
		if ( absint( $inserted ) === absint( $total ) ) {
			// requested codes added, return count.
			return $inserted;
		}
		// May be there were duplicates or failed to add. Repeat until total = inserted.
		$diff = $total - $inserted;
		if ( $diff > 0 ) {
			self::handle_auto_code( $group_id, $args, array( $diff ) );
		}
	}

	/**
	 * @param int $paged
	 * @param string $orderby
	 * @param string $order
	 *
	 * @param string $search
	 *
	 * @return array|null|object
	 */
	public static function get_groups( $paged = 1, $orderby = 'issue_date', $order = 'DESC', $search = '' ) {
		global $wpdb;
		$limit = ( $paged - 1 ) * 100;
		switch ( $orderby ) {
			case 'issue_date' :
				$orderby = 'issue_date';
				break;
		}
		$order      = ( $orderby ) ? ' ORDER BY ' . $orderby . ' ' . $order : '';
		$tbl_groups = $wpdb->prefix . Config::$tbl_groups;
		$tbl_codes  = $wpdb->prefix . Config::$tbl_codes;
		if ( ! empty( $search ) ) {
			$sql = $wpdb->prepare(
				"SELECT g.* FROM {$tbl_groups} g
    LEFT JOIN {$tbl_codes} c
        ON g.ID = c.code_group
WHERE ( g.prefix LIKE '%%%s%%' OR g.suffix LIKE '%%%s%%' OR g.name LIKE '%%%s%%' OR c.code LIKE '%%%s%%' )
GROUP BY g.ID {$order} LIMIT {$limit}, 500", $search, $search, $search, $search
			);
		} else {
			$sql = "SELECT * FROM {$tbl_groups} {$order} LIMIT {$limit}, 500";
		}

		return $wpdb->get_results( $sql );
	}

	/**
	 * @param string $group
	 * @param int $paged
	 * @param string $orderby
	 * @param string $order
	 *
	 * @return array|null|object
	 */
	public static function get_coupons( $group = 'all', $paged = 1, $orderby = '', $order = 'DESC', $search = '' ) {
		global $wpdb;
		$limit = $where = '';

		if ( 'all' !== $group ) {
			$where = 'WHERE c.code_group = ' . $group;
		}
		if ( ! empty( $search ) ) {
			$where .= ( $where == '' ? 'WHERE' : ' AND ' ) . " ( c.code LIKE '%{$search}%' )";
		}
		switch ( $orderby ) {
			case 'used_date' :
				$orderby = 'used_date';
				break;
		}
		$order = ( $orderby ) ? ' ORDER BY ' . $orderby . ' ' . $order : '';

		$limit = ( $paged - 1 ) * 100;
		$limit = "LIMIT {$limit}, 100";

		return $wpdb->get_results( "SELECT c.*, g.expire_date FROM {$wpdb->prefix}" . Config::$tbl_codes . " c LEFT JOIN {$wpdb->prefix}" . Config::$tbl_groups . " g ON g.ID=c.code_group {$where} {$order} {$limit}" );
	}

	/**
	 * @return null|string
	 */
	public static function get_num_groups( $search = '' ) {
		global $wpdb;
		$sql = '';
		if ( ! empty( $search ) ) {
			$sql = $wpdb->prepare( "SELECT COUNT(DISTINCT g.ID) FROM {$wpdb->prefix}" . Config::$tbl_groups . " g LEFT JOIN {$wpdb->prefix}" . Config::$tbl_codes . " c ON g.ID = c.code_group WHERE ( g.prefix LIKE '%%%s%%' OR g.suffix LIKE '%%%s%%' OR c.code LIKE '%%%s%%' ) ", $search, $search, $search );
		} else {
			$sql = "SELECT COUNT(DISTINCT g.ID) FROM {$wpdb->prefix}" . Config::$tbl_groups . ' g ';
		}

		return $wpdb->get_var( $sql );
	}

	/**
	 * @param string $group
	 *
	 * @param string $search
	 *
	 * @return null|string
	 */
	public static function get_num_coupons( $group = "all", $search = "" ) {
		global $wpdb;

		$where = '';
		if ( $group !== 'all' ) {
			$where = 'WHERE c.code_group = ' . $group;
		}
		if ( ! empty( $search ) ) {
			$where .= ( $where == '' ? 'WHERE' : ' AND ' ) . " ( c.code LIKE '%{$search}%' )";
		}

		return $wpdb->get_var( "SELECT COUNT(*) FROM {$wpdb->prefix}" . Config::$tbl_codes . " c " . $where );
	}

	/**
	 * @param $group_id
	 */
	public static function delete_coupon( $group_id ) {
		global $wpdb;
		$wpdb->delete( $wpdb->prefix . Config::$tbl_groups, array( 'ID' => $group_id ) );
		$wpdb->delete( $wpdb->prefix . Config::$tbl_codes, array( 'code_group' => $group_id ) );
	}

	/**
	 * @param      $coupon
	 * @param null $user_id
	 *
	 * @return array
	 */
	public static function is_coupon_available( $coupon, $user_id = null ) {
		global $wpdb;
		if ( is_null( $user_id ) ) {
			$user_id = wp_get_current_user()->ID;
		}
		// Modifying logic here to be able to use 1 coupon maximum times!
		$qry     = $wpdb->prepare(
			"SELECT c.ID as coupon_id, c.code, g.issue_max_count AS max_count, g.expire_date as expiry_date
										FROM {$wpdb->prefix}" . Config::$tbl_groups . " g
										LEFT JOIN {$wpdb->prefix}" . Config::$tbl_codes . " c
										ON g.ID = c.code_group
										WHERE c.code LIKE %s", trim( $coupon )
		);
		$results = $wpdb->get_row( $qry );
		if ( ! $results ) {
			return array(
				'result' => 'failed',
				'error'  => 'invalid',
			);
		}

		$coupon_id = $results->coupon_id;
		$users     = self::get_users_of_code( $coupon_id );
		$max       = $results->max_count;

		if ( $results->expiry_date !== '0000-00-00 00:00:00' ) {
			if ( strtotime( date_i18n( 'Y-m-d H:i:s' ), time() ) > strtotime( $results->expiry_date ) ) {
				return [
					'result' => 'failed',
					'error'  => 'expired',
				];
			}
		}

		if ( ! empty( $users ) ) {
			if ( in_array( $user_id, $users ) ) {
				return array(
					'result' => 'failed',
					'error'  => 'existing',
				);
			}
			if ( count( $users ) === intval( $max ) ) {
				return array(
					'result' => 'failed',
					'error'  => 'max',
				);
			}
		}

		return $coupon_id;

	}

	/**
	 * @param      $code_id
	 * @param bool $user_ids
	 *
	 * @return array
	 */
	public static function get_users_of_code( $code_id, $user_ids = true ) {
		global $wpdb;
		$tbl_usage = $wpdb->prefix . Config::$tbl_codes_usage;
		$data      = $wpdb->get_results( $wpdb->prepare( "SELECT user_id, date_redeemed FROM {$tbl_usage}  WHERE code_id = %d GROUP BY user_id ORDER BY date_redeemed DESC", $code_id ) );
		if ( $data && $user_ids ) {
			$data = array_column( $data, 'user_id' );
		}

		return $data;
	}

	/**
	 * @param $coupon
	 *
	 * @return bool
	 */
	public static function is_coupon_paid( $coupon ) {
		global $wpdb;
		$is_automator = self::is_automator_code( $coupon );
		if ( true === $is_automator ) {
			return false;
		}
		$prepare = $wpdb->prepare(
			"
		SELECT c.ID FROM {$wpdb->prefix}" . Config::$tbl_codes . " c
		LEFT JOIN {$wpdb->prefix}" . Config::$tbl_groups . " cg
		ON c.code_group = cg.ID
		WHERE c.code = %s
		AND cg.paid_unpaid = %s",
			trim( $coupon ),
			'paid'
		);
		if ( ! empty( $wpdb->get_var( $prepare ) ) ) {
			return true;
		}

		return false;
	}

	/**
	 * @param $coupon
	 *
	 * @return bool
	 */
	public static function is_default_code( $coupon ) {
		global $wpdb;
		$is_automator = self::is_automator_code( $coupon );
		if ( true === $is_automator ) {
			return true;
		}
		$prepare = $wpdb->prepare(
			"
		SELECT c.ID FROM {$wpdb->prefix}" . Config::$tbl_codes . " c
		LEFT JOIN {$wpdb->prefix}" . Config::$tbl_groups . " cg
		ON c.code_group = cg.ID
		WHERE c.code = %s
		AND cg.paid_unpaid = %s",
			trim( $coupon ),
			'default'
		);
		if ( ! empty( $wpdb->get_var( $prepare ) ) ) {
			return true;
		}

		return false;
	}

	/**
	 * @param $coupon
	 *
	 * @return bool
	 */
	public static function is_automator_code( $coupon ) {
		global $wpdb;
		$result = $wpdb->get_var( $wpdb->prepare( "SELECT cg.code_for FROM {$wpdb->prefix}" . Config::$tbl_codes . " c
		LEFT JOIN {$wpdb->prefix}" . Config::$tbl_groups . " cg
		ON c.code_group = cg.ID
		WHERE c.code = %s", $coupon ) );

		if ( ! empty( $result ) && 'automator' === (string) $result ) {
			return true;
		}

		return false;
	}

	/**
	 * @param $group_id
	 *
	 * @return int
	 */
	public static function get_group_redeemed_count( $group_id ) {
		global $wpdb;
		$prepare = $wpdb->prepare(
			"SELECT u.user_id
FROM $wpdb->prefix" . Config::$tbl_codes_usage . " u
LEFT JOIN $wpdb->prefix" . Config::$tbl_codes . " c
ON u.code_id = c.ID
WHERE c.code_group = %d
GROUP BY u.user_id", $group_id
		);

		$result = $wpdb->get_results( $prepare );

		return count( $result );
	}

	/**
	 * @param $user_id
	 * @param $coupon_id
	 *
	 * @return array|bool
	 */
	public static function set_user_to_coupon( $user_id, $coupon_id ) {
		if ( ! self::is_codes_table_exists() ) {
			self::create_tables( true );
		}
		global $wpdb;
		$tbl_groups     = $wpdb->prefix . Config::$tbl_groups;
		$tbl_codes      = $wpdb->prefix . Config::$tbl_codes;
		$tbl_code_usage = $wpdb->prefix . Config::$tbl_codes_usage;

		$get_coupon_details = $wpdb->get_row(
			$wpdb->prepare(
				"SELECT g.ID as group_id, g.prefix, g.code_for, g.linked_to, c.ID AS coupon_id, c.code, g.issue_max_count AS max_count
										FROM {$tbl_groups} g
										LEFT JOIN {$tbl_codes} c
										ON g.ID = c.code_group
										WHERE c.ID = %d", $coupon_id
			)
		);

		if ( $get_coupon_details ) {
			//$max   = $get_coupon_details->max_count;
			//$users = self::get_users_of_code( $coupon_id );

			$wpdb->insert(
				$tbl_code_usage,
				array(
					'code_id'       => $coupon_id,
					'user_id'       => $user_id,
					'date_redeemed' => current_time( 'mysql' ),
				),
				array(
					'%d',
					'%d',
					'%s',
				)
			);

			update_user_meta( $user_id, Config::$uncanny_codes_user_prefix_meta, $get_coupon_details->prefix );
			// Add usermeta to store which code ID was used at time (just for backup).
			add_user_meta( $user_id, 'ulc_code_' . $coupon_id, current_time( 'mysql' ) );

			$coupon_for = $get_coupon_details->code_for;
			$linked_to  = maybe_unserialize( $get_coupon_details->linked_to );
			$data       = array(
				'for'  => $coupon_for,
				'data' => $linked_to,
			);

			return $data;
		}

		return array();
	}


	// Generate CSV.

	/**
	 * @param string $group
	 *
	 * @return array
	 */
	public static function get_coupons_csv( $group = 'all' ) {
		global $wpdb;
		$where = '';
		$array = array();

		if ( $group !== 'all' ) {
			$where = 'WHERE c.code_group = ' . $group;
		}

		$results = $wpdb->get_results(
			"SELECT c.ID as Coupon_ID, c.code AS Code, g.code_for AS `Code For`, g.prefix AS Prefix, g.suffix AS Suffix, g.linked_to AS `Linked To`, g.expire_date
										FROM {$wpdb->prefix}" . Config::$tbl_groups . " g
										LEFT JOIN {$wpdb->prefix}" . Config::$tbl_codes . " c
										ON g.ID = c.code_group
										$where"
		);
		if ( $results ) {
			$array = array();
			foreach ( $results as $result ) {
				$val       = (array) $result;
				$linked_to = maybe_unserialize( $val['Linked To'] );
				$dd        = array();
				foreach ( $linked_to as $d ) {
					$dd[] = get_the_title( $d );
				}
				$dd    = join( '|', $dd );
				$users = self::get_users_of_code( $result->Coupon_ID, false );
				if ( ! empty( $users ) ) {
					if ( ! function_exists( 'get_user_by' ) ) {
						include( ABSPATH . 'wp-includes/pluggable.php' );
					}
					foreach ( $users as $u ) {
						$user = get_user_by( 'ID', $u->user_id );
						if ( $user ) {
							$user_email = $user->user_email;
						} else {
							$user_email = '';
						}
						$r = '';
						if ( $val['expire_date'] !== '0000-00-00 00:00:00' ) {
							$_date = DateTime::createFromFormat( 'Y-m-d H:i:s', $val['expire_date'] );
							$r     = $_date->format( 'F j, Y g:i a' );
						} else {
							$r = 'Unlimited';
						}

						$array[] = (object) array(
							'Code'          => $val['Code'],
							'Code For'      => $val['Code For'],
							'Prefix'        => $val['Prefix'],
							'Suffix'        => $val['Suffix'],
							'Linked To'     => $dd,
							'Redeemed Date' => ! empty( $u->date_redeemed ) ? date_i18n( 'Y-m-d', strtotime( $u->date_redeemed ) ) : '',
							'Redeemed User' => $user_email,
							'Expiry Date'   => $r,
						);
					}
				} else {
					$r = '';
					if ( $val['expire_date'] !== '0000-00-00 00:00:00' ) {
						$_date = DateTime::createFromFormat( 'Y-m-d H:i:s', $val['expire_date'] );
						$r     = $_date->format( 'F j, Y g:i a' );
					} else {
						$r = 'Unlimited';
					}
					$array[] = (object) array(
						'Code'          => $val['Code'],
						'Code For'      => $val['Code For'],
						'Prefix'        => $val['Prefix'],
						'Suffix'        => $val['Suffix'],
						'Linked To'     => $dd,
						'Redeemed Date' => '',
						'Redeemed User' => '',
						'Expiry Date'   => $r,
					);
				}
			}
		}

		return $array;
	}

	/**
	 * @param        $code_length
	 * @param string $type
	 *
	 * @return array
	 */
	public static function get_coupon_codes( $code_length, $type = 'auto' ) {
		global $wpdb;
		$codes   = array();
		$prepare = "SELECT code FROM {$wpdb->prefix}" . Config::$tbl_codes;

		$results = $wpdb->get_results( $prepare );
		if ( ! empty( $results ) ) {
			foreach ( $results as $result ) {
				if ( 'auto' === $type ) {
					$code = str_replace( '-', '', $result->code );
					if ( strlen( $code ) == trim( $code_length ) ) {
						$codes[] = $code;
					}
				} else {
					$codes[] = $result->code;
				}
			}
		}

		return $codes;
	}

	/**
	 * @param       $order_id
	 * @param false $is_my_account
	 *
	 * @return array|object|null
	 */
	public static function get_codes_usage_by_order_id( $order_id, $is_my_account = false ) {
		global $wpdb;
		$table1 = $wpdb->prefix . Config::$tbl_codes;
		$table2 = $wpdb->prefix . Config::$tbl_groups;
		$table3 = $wpdb->prefix . Config::$tbl_codes_usage;
		$limit  = "LIMIT 0, 200";
		if ( $is_my_account ) {
			$limit = '';
		}
		$sql = $wpdb->prepare(
			"SELECT c.ID, c.code, g.product_id, u.date_redeemed AS used_date, u.user_id
		FROM {$table1} c
		LEFT JOIN {$table2} g
		ON c.code_group = g.ID
		LEFT JOIN {$table3} u
		ON c.ID = u.code_id
		WHERE c.order_id=%d {$limit}", $order_id
		);

		return $wpdb->get_results( $sql );
	}
}
