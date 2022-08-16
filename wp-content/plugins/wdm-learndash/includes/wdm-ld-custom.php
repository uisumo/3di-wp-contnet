<?php
function wdm_remove_action($order_id){
	remove_action( 'woocommerce_order_status_completed', array( 'Woocommerce', 'so_payment_complete' ) );
	$order = wc_get_order( $order_id );
	$all_courses = array();
	foreach ($order->get_items() as $key => $value) {
		if(isset($value["product_id"])){
			$related_courses = get_post_meta($value["product_id"],"_related_course",true);
			if($related_courses && !empty($related_courses)){
				$all_courses = array_merge($all_courses, $related_courses);
			}
		}
	}
	$user_id     = $order->user_id;
	$coupon_code = get_post_meta( $order_id, 'uncanny-learndash-codes-used-code', true );
	if ( intval( $user_id ) && ! empty( $coupon_code ) ) {
		$coupon_id = uncanny_learndash_codes\Database::is_coupon_available( $coupon_code );
		if ( is_numeric( $coupon_id ) ) {
			$coupon_id = intval( $coupon_id );
		}

		if ( intval( $coupon_id ) ) {
			update_user_meta( $user_id, uncanny_learndash_codes\Config::$uncanny_codes_tracking, 'Woocommerce' );

			$result = uncanny_learndash_codes\Database::set_user_to_coupon( $user_id, $coupon_id );
			wdm_set_user_to_course_or_group( $user_id, $result, $all_courses );
		}
	}
}
add_action("woocommerce_order_status_completed","wdm_remove_action",8);

function wdm_set_user_to_course_or_group( $user_id, $result, $courses ) {
	if ( is_array( $result ) ) {
		if ( 'group' === $result['for'] ) {
			update_option("wdm_user_".$user_id,"yes");
			$user_groups = learndash_get_users_group_ids( $user_id );
			// remove all groups if any
			if ( 0 === intval( uncanny_learndash_codes\Config::$allow_multiple_groups ) ) {
				if ( $user_groups && ! empty( $user_groups ) ) {
					foreach ( $user_groups as $user_group ) {
						delete_user_meta( $user_id, "wdm_group_".$user_group );
						delete_user_meta( $user_id, 'learndash_group_users_' . $user_group );
						//ld_update_group_access( $user_id, $user_group, true );
					}
				}
				foreach ( $result['data'] as $d ) {
					ld_update_group_access( $user_id, $d );
					store_user_meta_course_enrol($user_id, "wdm_group_".$d, $courses);
					$transient_key         = 'learndash_user_groups_' . $user_id;
					$transient_key_courses = 'learndash_user_courses_' . $user_id;
					delete_transient( $transient_key );
					delete_transient( $transient_key_courses );
					break; //To only assign first group!
				}
			} elseif ( 1 === intval( uncanny_learndash_codes\Config::$allow_multiple_groups ) ) {
				foreach ( $result['data'] as $d ) {
					ld_update_group_access( $user_id, $d );
					store_user_meta_course_enrol($user_id, "wdm_group_".$d, $courses);
					$transient_key         = 'learndash_user_groups_' . $user_id;
					$transient_key_courses = 'learndash_user_courses_' . $user_id;
					delete_transient( $transient_key );
					delete_transient( $transient_key_courses );
				}
			}
		} elseif ( 'course' === $result['for'] ) {
			foreach ( $result['data'] as $course_id ) {
				ld_update_course_access( $user_id, $course_id );
			}
		}
	}
}

function store_user_meta_course_enrol($user_id, $key, $value){
	$data = get_user_meta($user_id, $key, true);
	if( $data ){
		$value = array_merge($value, $data);
	}
	update_user_meta( $user_id, $key, array_unique($value));
}

add_action( 'ld_removed_group_access', 'wdm_delete_access_group_course', 10, 2 );
function wdm_delete_access_group_course($user_id, $group_id){
	$flag = get_option("wdm_user_".$user_id);
	if( $flag == "yes" ){
		delete_option("wdm_user_".$user_id);
		return;
	}
	delete_user_meta( $user_id, "wdm_group_".$group_id );
}

add_filter( 'sfwd_lms_has_access', "wdm_user_access_uncanny_group_course", 0, 3);

function wdm_user_access_uncanny_group_course($status, $post_id, $user_id){

	if(is_user_logged_in()){
		$user_id = get_current_user_id();
		if( $status ){
			$course_id = learndash_get_course_id($post_id);
			if( $course_id ){
				$courses_access_from = ld_course_access_from( $course_id, $user_id );
				if ( empty( $courses_access_from ) ) {
					$group_ids = learndash_get_users_group_ids( $user_id ,true);
					$flag = false;
					foreach ( $group_ids as $group_id ) {
						$enrolled_from_temp = learndash_group_course_access_from( $group_id, $course_id );
						if ( ! empty( $enrolled_from_temp ) ) {
							$wdm_user_courses = get_user_meta($user_id, "wdm_group_".$group_id, true);
							if( $wdm_user_courses == "" ){
								return true;
							}
							else if( ! empty( $wdm_user_courses ) && $wdm_user_courses ){
								if( in_array($course_id, $wdm_user_courses) ){
									return true;
								}
								$flag = true;
							}
							else{
								$flag = true;
							}
						}
					}
					if( $flag )
						return false;
				}
			}
		}
	}
	return $status;
}

add_filter( 'uo-dashboard-template', "wdm_dashboard_template_path", 20);

function wdm_dashboard_template_path(){
	return plugin_dir_path(__DIR__)."templates/wdm_dashboard_template.php";
}

// add_action("wp","wdm_script4");
function wdm_script4(){
	if(isset($_GET["wdm_script4"])){
		// $users = get_users(array('role'=>'customer','fields'=>'ID'));
		// if( empty($users) ){
		// 	foreach ($users as $user_id) {
				
		// 	}
		// }
		// echo "<pre>";
		// print_r($users);
		// echo "</pre>";
		// die();
		global $wpdb;
		$rest_user_ids = $wpdb->get_col( "SELECT DISTINCT `user_id` FROM $wpdb->usermeta WHERE `meta_key` LIKE 'wdm_group_%'");
		if(!empty($rest_user_ids)){
			foreach ($rest_user_ids as $rest_user_id) {
				$courses = ld_get_mycourses($rest_user_id);
				$group_ids = learndash_get_users_group_ids($rest_user_id);
				if( !empty($group_ids) ){
					foreach ($group_ids as $group_id) {
						store_user_meta_course_enrol($rest_user_id, "wdm_group_".$group_id, $courses);
					}
				}
			}
		}
		die();
	}
}

// add_action("wp","wdm_script3");
function wdm_script3(){
	if(isset($_GET["wdm_script3"])){
		global $wpdb;
		$user_ids = $wpdb->get_col( "SELECT DISTINCT `user_id` FROM $wpdb->usermeta WHERE `meta_key` LIKE 'wdm_group_%'");
		$args = array(
			'role__not_in' => array('administrator'),
			'exclude'      => $user_ids,
			'fields'       => 'ID',
		);
		$rest_user_ids = get_users( $args );
		if(!empty($rest_user_ids)){
			foreach ($rest_user_ids as $rest_user_id) {
				$courses = ld_get_mycourses($rest_user_id);
				$group_ids = learndash_get_users_group_ids($rest_user_id);
				if( !empty($group_ids) ){
					foreach ($group_ids as $group_id) {
						store_user_meta_course_enrol($rest_user_id, "wdm_group_".$group_id, $courses);
					}
				}
			}
		}
		die();
	}
}

// add_action("wp","wdm_script2");
function wdm_script2(){
	if(isset($_GET["wdm_script2"])){
		global $wpdb;
		$order_ids = $wpdb->get_col( "SELECT `ID` FROM $wpdb->posts WHERE `post_type` = 'shop_order';");
		if( !empty($order_ids) ){
			foreach ($order_ids as $order_id) {
				$order = wc_get_order( $order_id );
				$order_data = $order->get_data();
				if($order_data["status"] == "completed"){
					$all_courses = array();
					foreach ($order->get_items() as $key => $value) {
						if(isset($value["product_id"])){
							$related_courses = get_post_meta($value["product_id"],"_related_course",true);
							if($related_courses && !empty($related_courses)){
								$all_courses = array_merge($all_courses, $related_courses);
							}
						}
					}
					if( !empty($all_courses)){
						$user_id = get_post_meta( $order_id, "_customer_user", true);
						if( !empty($user_id) ){
							$user_meta = get_userdata($user_id);
							if(in_array("customer", $user_meta->roles)){
								$group_ids = learndash_get_users_group_ids($user_id);
								if( !empty($group_ids) ){
									foreach ($group_ids as $group_id) {
										store_user_meta_course_enrol($user_id, "wdm_group_".$group_id, $all_courses);
									}
								}
							}
						}
					}
				}
			}
		}
		echo "Completed Processing";
		die();
	}
}

// add_action("wp","wdm_script");
function wdm_script(){
	if(isset($_GET["wdm_script"])){
		global $wpdb;
		$order_ids = $wpdb->get_results( "SELECT `post_id`,`meta_value` FROM $wpdb->postmeta JOIN $wpdb->posts WHERE `meta_key` LIKE 'uncanny-learndash-codes-used-code' AND `post_type` = 'shop_order' AND `post_id` = `ID`");
		foreach ($order_ids as $order_id) {
			$order = wc_get_order( $order_id->post_id );
			$all_courses = array();
			foreach ($order->get_items() as $key => $value) {
				if(isset($value["product_id"])){
					$related_courses = get_post_meta($value["product_id"],"_related_course",true);
					if($related_courses && !empty($related_courses)){
						$all_courses = array_merge($all_courses, $related_courses);
					}
				}
			} 
			$user_id     = $order->user_id;
			$coupon_code = $order_id->meta_value;
			if ( intval( $user_id ) && ! empty( $coupon_code ) ) {
				$results = $wpdb->get_row( $wpdb->prepare( "SELECT c.ID as coupon_id, c.code, g.issue_max_count AS max_count, g.used_code AS is_used, c.user_id FROM {$wpdb->prefix}uncanny_codes_groups g	LEFT JOIN {$wpdb->prefix}uncanny_codes_codes c ON g.ID = c.code_group WHERE c.code LIKE %s", $coupon_code ) );
				$coupon_id = "";
				if( $results ){
					$coupon_id = intval( $results->coupon_id );
				}
				if ( intval( $coupon_id ) ) {
					$result = wdm_fetch_uncanny_data_courses( $user_id, $coupon_id );
					wdm_set_user_to_course_or_group_script( $user_id, $result, $all_courses );
				}
			}
		}
		echo "Completed Processing";
		echo "<pre>";
		print_r($user_id);
		print_r($all_courses);
		echo "</pre>";
		die();
	}
}

function wdm_fetch_uncanny_data_courses($user_id, $coupon_id){
	global $wpdb;
	$get_coupon_details = $wpdb->get_row( $wpdb->prepare(
		"SELECT g.ID as group_id, g.prefix, g.code_for, g.linked_to, c.ID as coupon_id, c.code, g.issue_max_count AS max_count, g.used_code AS is_used, c.user_id 
									FROM {$wpdb->prefix}uncanny_codes_groups g
									LEFT JOIN {$wpdb->prefix}uncanny_codes_codes c
									ON g.ID = c.code_group
									WHERE c.ID = %d", $coupon_id
	) );
	if ( $get_coupon_details ) {
		$max = $get_coupon_details->max_count;

		$coupon_for = $get_coupon_details->code_for;
		$linked_to  = maybe_unserialize( $get_coupon_details->linked_to );
		$data       = array(
			'for'  => $coupon_for,
			'data' => $linked_to,
		);

		return $data;
	}
}

function wdm_set_user_to_course_or_group_script( $user_id, $result, $courses ) {
	if ( is_array( $result ) ) {
		if ( 'group' === $result['for'] ) {
			if ( 0 === intval( uncanny_learndash_codes\Config::$allow_multiple_groups ) ) {
				foreach ( $result['data'] as $d ) {
					store_user_meta_course_enrol($user_id, "wdm_group_".$d, $courses);
					break;
				}
			} elseif ( 1 === intval( uncanny_learndash_codes\Config::$allow_multiple_groups ) ) {
				foreach ( $result['data'] as $d ) {
					store_user_meta_course_enrol($user_id, "wdm_group_".$d, $courses);
				}
			}
		}
	}
}

add_filter( 'learndash_propanel_template',"wdm_propanel_report",12,2);

function wdm_propanel_report($template_path, $template_name) {
	$wdm_user_details = wp_get_current_user();
	if(in_array("group_leader", $wdm_user_details->roles)){
		if( $template_name == "ld-propanel-overview.php"){
?>
<style type="text/css">
	.propanel-assignments{
		display: none;
	}
	.propanel-essays{
		display: none;
	}
</style>
<?php
		}
	}
	return $template_path;
}

add_action("admin_menu","wdm_hide_propanel_report");
function wdm_hide_propanel_report(){
	$wdm_user_details = wp_get_current_user();
	if(in_array("group_leader", $wdm_user_details->roles)){
		global $submenu;
		if(isset($submenu["learndash-lms"])){
			foreach ($submenu["learndash-lms"] as $key => $value) {
				if( in_array("Assignments", $value) || in_array("Submitted Essays", $value)){
					unset($submenu["learndash-lms"][$key]);
				}
			}
		}
	}
}