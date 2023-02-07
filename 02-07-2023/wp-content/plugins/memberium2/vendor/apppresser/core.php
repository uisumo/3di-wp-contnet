<?php


class_exists('m4is_emz57o') || die();

final 
class wpal_memberium_apppresser_bridge_class {

	
function m4is_ap508() {
		add_action('rest_api_init', [$this, 'add_api_fields']);
		add_action('rest_api_init', [$this, 'appp_cors']); 		add_action('rest_api_init', [$this, 'register_routes']);

		add_filter('wp_authenticate_user', [$this, 'check_app_unverified'], 10, 2); 	}

	
function add_api_fields() {

		
		register_rest_field('post',
		    'featured_image_urls',
		    [
		        'get_callback'    => [$this, 'image_sizes'],
		        'update_callback' => null,
	            'schema'          => null,
			]
		);

				$m4is_dm7i1c = appp_get_setting('media_post_types');

		if (!empty($m4is_dm7i1c) ) {
			foreach ($m4is_dm7i1c as $m4is_j1vz) {
				register_rest_field($m4is_j1vz,
				    'appp_media',
				    [
				        'get_callback'    => [$this, 'get_media_url'],
				        'update_callback' => null,
			            'schema'          => null,
					]
				);
			}
		}
	}

	
	
function api_login($m4is_eewg) {
		$m4is_anax['user_login']    = ($_POST['username'] ? $_POST['username'] : $_SERVER['PHP_AUTH_USER']);
		$m4is_anax['user_password'] = ($_POST['password'] ? $_POST['password'] : $_SERVER['PHP_AUTH_PW']);
		$m4is_anax['remember']      = true;

		if (empty($m4is_anax['user_login']) || empty($m4is_anax['user_password']) ) {
			$m4is_qlt5x = [
				'success' => false,
				'data' => [
					'message' =>  apply_filters('appp_login_error', __('Login missing required fields.', 'apppresser'), ''),
					'success' => false
				]
			];

			return rest_ensure_response($m4is_qlt5x);
		}

		do_action('appp_before_signon', $m4is_anax);
		$m4is_e7rm4s = wp_signon($m4is_anax, false);
		do_action('appp_login_header');

		if (is_wp_error($m4is_e7rm4s) ) {
			$m4is_qlt5x = [
				'success' => false,
				'data'    => [
					'message' =>  apply_filters('appp_login_error', __('The login you have entered is not valid.', 'apppresser'), $m4is_anax['user_login']),
					'success' => false
				]
			];

			return rest_ensure_response($m4is_qlt5x);
		}
		else {
						$m4is_xxk1 = $this->do_cookie_auth($m4is_e7rm4s->ID);
			$m4is_qlt5x = [
				'message'        => apply_filters('appp_login_success', sprintf(__('Welcome back %s!', 'apppresser'), $m4is_e7rm4s->display_name), $m4is_e7rm4s->ID),
				'username'       => $m4is_anax['user_login'],
				'avatar'         => get_avatar_url($m4is_e7rm4s->ID),
				'cookie_auth'    => $m4is_xxk1,
				'login_redirect' => AppPresser_Ajax_Extras::get_login_redirect(),                                                                                               				'success'        => true,
				'user_id'        => $m4is_e7rm4s->ID
			];
		}

		$m4is_qlt5x = apply_filters('appp_login_data', $m4is_qlt5x, $m4is_e7rm4s->ID);
		$retval = rest_ensure_response($m4is_qlt5x);

		return $retval;
	}

	
	
function api_logout($m4is_eewg) {
		do_action('appp_logout_header');

		if (! defined('DOING_AJAX') ) {
			define('DOING_AJAX', true);
		}

		wp_logout();


		$m4is_zv59 = [
			'message' => __('Logout success.', 'apppresser'),
			'success' => true
		];
		$m4is_admy3 = $this->get_logout_redirect();

		if ($m4is_admy3) {
			$m4is_zv59['logout_redirect'] = $m4is_admy3;
		}

		$m4is_qirnk = rest_ensure_response($m4is_zv59);

		return $m4is_qirnk;
	}

	
	
function appp_cors() {
				if (appp_get_setting('ap3_enable_cors', false) ) {
			add_filter('appp_allow_api_origin', function() {
				return '*';
			});
			$this->app_cors_header();
		} else {
			add_filter('appp_allow_api_origin', function() {
				return false;
			});
		}

	}

	
	
function app_cors_header() {
		$m4is_mvcr  = apply_filters('appp_allow_api_origin', '*');
		$m4is_ykzh = apply_filters('appp_allow_api_methods', 'GET,PUT,POST,DELETE,PATCH,OPTIONS');

		if ($appp_allow_origin) {
			header("Access-Control-Allow-Origin: {$m4is_mvcr}");
			header("Access-Control-Allow-Methods: {$m4is_ykzh}");
		}
	}

	
	
function check_app_unverified($m4is_nzrv1, $m4is_p1ug) {
		if (get_user_meta($m4is_nzrv1->ID, 'app_unverified', true) ) {
			return new WP_Error('app_unverified_login',
				__('You have not verified your account by email, please contact support.', 'apppresser'),
				[
					'status' => 404,
				]
			);
		}

		return $m4is_nzrv1;
	}

	
	
function do_cookie_auth($m4is_q4c_xa) {
		if (function_exists('openssl_encrypt') ) {
			$m4is_ap3_        = substr(AUTH_KEY, 2, 5);
			$m4is_l4hq         = substr(AUTH_KEY, 0, 16);
			$m4is_q5ndg     = "AES-128-CBC";
			$m4is_imr0 = openssl_encrypt($m4is_q4c_xa, $m4is_q5ndg, $m4is_ap3_, null, $m4is_l4hq);
		} else {
						$m4is_imr0 = $m4is_q4c_xa;
		}

		update_user_meta($m4is_q4c_xa, 'app_cookie_auth', $m4is_imr0);

		return $m4is_imr0;
	}

	
	
function get_logout_redirect() {
		if (has_filter('appp_logout_redirect') ) {
			$m4is_u4dt3v = apply_filters('appp_logout_redirect', '');

			return AppPresser_Ajax_Extras::add_redirect_title($m4is_u4dt3v);
		}
		else {
			return '';
		}
	}

	
function get_media_url($m4is_pgsbl) {
		$m4is_rhfd = get_post_meta($m4is_pgsbl['id'], 'appp_media_url', true);
		$m4is_j0n7  = [];

		if (empty($m4is_rhfd)) {
			return;
		}

		$m4is_j0n7['media_url'] = $m4is_rhfd;
		$m4is_tofpz = get_post_meta($m4is_pgsbl['id'], 'appp_media_image', true);

		if (! empty($m4is_tofpz) ) {
			$m4is_j0n7['media_image'] = $m4is_tofpz;
		}

		return $m4is_j0n7;

	}

	
	
function get_password_reset_code($m4is_eewg) {
		$m4is_m2h6b = $m4is_eewg['email'];
		$m4is_nzrv1  = get_user_by('email', $m4is_m2h6b);

		if ($m4is_nzrv1) {
			$m4is_il8u4 = current_time('mysql');
			$m4is_jdl7 = $this->get_short_reset_code(); 			update_user_meta($m4is_nzrv1->ID, 'app_hash', $m4is_jdl7);
			$m4is_jiat = __('App Password Reset', 'apppresser');
			$m4is_jiat = apply_filters('appp_pw_reset_email_subject', $m4is_jiat);
			$m4is_fgxy = __('Enter the code into the app to reset your password. Code: ', 'apppresser') . $m4is_jdl7;
			$m4is_fgxy = apply_filters('appp_pw_reset_email', $m4is_fgxy, $m4is_jdl7);
			$mail        = wp_mail($m4is_nzrv1->user_email, $m4is_jiat, $m4is_fgxy);

			$return = [
				'success' => true,
				'got_code' => true,
				'message' =>  __('Please check your email for your verification code.', 'apppresser')
			];

		} else {
			$return = [
				'success' => false,
				'message' =>  __('The email you have entered is not valid.', 'apppresser')
			];

		}

		return $return;
	}

	
function get_short_reset_code() {

		$m4is_qu4_ = str_split('1234567890');
		$m4is_g4yn_ = str_split('abcdefghijklmnopqrstuvwxyz');
		shuffle($m4is_qu4_);
		shuffle($m4is_g4yn_);

		$m4is_rz70ok = $m4is_qu4_[1] . $m4is_g4yn_[1] . $m4is_g4yn_[2] . $m4is_qu4_[3];

		return $m4is_rz70ok;
	}

	
function image_sizes($m4is_pgsbl) {
	    $m4is_ogea0z = get_post_thumbnail_id($m4is_pgsbl['id']);
	    $m4is_alzm85       = wp_get_attachment_metadata($m4is_ogea0z);
	    $m4is_ww_h92   = new stdClass();

		if (! empty($m4is_alzm85['sizes']) ) {

			foreach ($m4is_alzm85['sizes'] as $key => $size) {
								$image_src = wp_get_attachment_image_src($m4is_ogea0z, $key);

				if (! $image_src) {
					continue;
				}

				$m4is_ww_h92->$key = $image_src[0];
			}
		}

		return $m4is_ww_h92;
	}

	
	
function register_routes() {
				if (! class_exists('WP_REST_Controller') ) {
			return;
		}

		$m4is_ahusy0        = 'appp/v1';
		$m4is_nhanw7         = 'methods';
		$m4is__wsdob         = 'callback';
		$m4is_psakzp = WP_REST_Server::CREATABLE;
		$m4is_g5sen  = WP_REST_Server::READABLE;

		register_rest_route($m4is_ahusy0, '/login', [
			[
				$m4is_nhanw7 => $m4is_psakzp,
				$m4is__wsdob => [$this, 'api_login']
			],
		]);

		register_rest_route($m4is_ahusy0, '/logout', [
			[
				$m4is_nhanw7 => $m4is_g5sen,
				$m4is__wsdob => [$this, 'api_logout']
			],
		]);

		register_rest_route($m4is_ahusy0, '/register', [
			[
				$m4is_nhanw7 => $m4is_psakzp,
				$m4is__wsdob => [$this, 'register_user']
			],
		]);

		register_rest_route($m4is_ahusy0, '/verify', [
			[
				$m4is_nhanw7 => $m4is_psakzp,
				$m4is__wsdob => [$this, 'verify_user']
			],
		]);

		register_rest_route($m4is_ahusy0, '/verify-resend', [
			[
				$m4is_nhanw7 => $m4is_psakzp,
				$m4is__wsdob => [$this, 'send_verification_code']
			],
		]);

		register_rest_route($m4is_ahusy0, '/reset-password', [
			[
				$m4is_nhanw7 => $m4is_psakzp,
				$m4is__wsdob => [$this, 'reset_password']
			],
		]);

	}

	
	
function register_user($m4is_eewg) {
		if (empty($m4is_eewg['username']) || empty($m4is_eewg['email']) ) {
			return new WP_Error('rest_invalid_registration',
				__('Missing required fields.', 'apppresser'),
				[
					'status' => 404,
				]
			);
		}

		if (email_exists($m4is_eewg['email']) || username_exists($m4is_eewg['username']) ) {
			return new WP_Error('rest_invalid_registration',
				__('Email or username already exists.', 'apppresser'),
				[
					'status' => 404,
				]
			);
		}

		if (empty($m4is_eewg['password']) ) {
			$m4is_p1ug = wp_generate_password(8); 		}
		else {
			$m4is_p1ug = $m4is_eewg['password'];
		}

		$m4is_li4oh7 = [
		    'user_login'  =>  $m4is_eewg['username'],
		    'user_pass'   =>  $m4is_p1ug,
		    'user_email'  =>  $m4is_eewg['email'],
		    'first_name'  =>  $m4is_eewg['first_name'],
		    'last_name'   =>  $m4is_eewg['last_name']
		];
		$m4is_q4c_xa = wp_insert_user($m4is_li4oh7);

		if (is_wp_error($m4is_q4c_xa) ) {
			return new WP_Error('rest_invalid_registration',
				__('Something went wrong with registration.', 'apppresser'),
				[
					'status' => 404,
				]
			);
		}

		update_user_meta($m4is_q4c_xa, 'app_unverified', true);
		$m4is_q1amw0 = $this->send_verification_code($m4is_eewg); 
		if (! $m4is_q1amw0) {
			return new WP_Error('rest_invalid_registration',
				__('We could not send your verification code by email, please contact support.', 'apppresser'),
				[
					'status' => 404,
				]
			);
		}

		do_action('appp_register_unverified', $m4is_q4c_xa);
		$m4is_o2td = __("Your verification code has been sent, please check your email.", "apppresser");
		$m4is_qirnk  = rest_ensure_response($m4is_o2td);

		return $m4is_qirnk;
	}

	
	
function reset_password($m4is_eewg) {
		$m4is_fnc39 = [
			'success' => false,
			'message' => 'Missing required fields.'
		];

		if (isset($m4is_eewg['code']) && isset($m4is_eewg['password']) ) {
			$m4is_fnc39 = $this->validate_reset_password($m4is_eewg);
		}
		elseif (isset($m4is_eewg['email']) ) {
			$m4is_fnc39 = $this->get_password_reset_code($m4is_eewg);
		}

		return $m4is_fnc39;
	}

	
	
function send_verification_code($m4is_eewg) {
		if (empty($m4is_eewg['email']) || empty($m4is_eewg['username']) ) {
			return new WP_Error('rest_invalid_verification',
				__('Missing required field.', 'apppresser'),
				[
					'status' => 404,
				]
			);
		}

		if (! email_exists($m4is_eewg['email']) || ! username_exists($m4is_eewg['username']) ) {
			return new WP_Error('rest_invalid_verification',
				__('Invalid username or email.', 'apppresser'),
				[
					'status' => 404,
				]
			);
		}


		$m4is_r59z = hash('md5', $m4is_eewg['username'] . $m4is_eewg['email']);                                                                                                           		$m4is_r59z = substr($m4is_r59z, 1, 4);                                                                                                                                    		$m4is_jiat           = __('Your Verification Code', 'apppresser');
		$m4is_jiat           = apply_filters('appp_verification_email_subject', $m4is_jiat);
		$m4is_amunwi           = sprintf(__("Hi, thanks for registering! Here is your verification code: %s \n\nPlease enter this code in the app. \n\nThanks!", "apppresser"), $m4is_r59z);
		$m4is_amunwi           = apply_filters('appp_verification_email', $m4is_amunwi, $m4is_r59z);
		$m4is_q1amw0         = wp_mail($m4is_eewg["email"], $m4is_jiat, $m4is_amunwi);

		return $m4is_q1amw0;
	}

	
	
function validate_reset_password($m4is_eewg) {
		global $wpdb;

		$m4is_rz70ok     = $m4is_eewg['code'];
		$m4is_p1ug = $m4is_eewg['password'];
		$m4is_w5ky4q     = [
			'meta_key'   => 'app_hash',
			'meta_value' => $m4is_rz70ok
		];
		$m4is_nzrv1     = get_users($m4is_w5ky4q);

		if ($m4is_nzrv1) {
			$m4is_w5ky4q = [
				'ID'        => $m4is_nzrv1[0]->data->ID,
				'user_pass' => $m4is_p1ug
			];
			wp_update_user($m4is_w5ky4q) ;
			delete_user_meta($m4is_nzrv1[0]->data->ID, 'app_hash'); 			$m4is_fnc39 = [
				'message' => __('Your password has been changed, please login.', 'apppresser'),
				'pw_changed' => true,
				'success' => true
			];
		}
		else {
			$m4is_fnc39 = [
				'success' => false,
				'message' =>  __('The code you have entered is not valid.', 'apppresser')
			];
		}

		return $m4is_fnc39;
	}

	
	
function verify_user($m4is_eewg) {
		if (empty($m4is_eewg['email']) || empty($m4is_eewg['verification']) ) {
			return new WP_Error('rest_invalid_verification',
				__('Missing required field.', 'apppresser'),
				[
					'status' => 404,
				]
			);
		}

		$m4is_r59z = hash('md5', $m4is_eewg['username'] . $m4is_eewg['email']);
		$m4is_r59z = substr($m4is_r59z, 1, 4);

		if ($m4is_eewg['verification'] != strval($m4is_r59z) ) {
						return new WP_Error('rest_invalid_verification',
			__('The verification code does not match.', 'apppresser'),
				[
					'status' => 404,
				]
			);
		}

		$m4is_nzrv1 = get_user_by('email', $m4is_eewg['email']);
		delete_user_meta($m4is_nzrv1->ID, 'app_unverified');
				$info = [];
		$info['user_login']    = $m4is_eewg['username'];
		$info['user_password'] = $m4is_eewg['password'];
		$info['remember']      = true;
		$user_signon = wp_signon($info, false);

		if (is_wp_error($user_signon) || !$m4is_nzrv1) {
			return new WP_Error('rest_invalid_verification', __('Verification succeeded, please login.', 'apppresser'), ['status' => 200,]);
		}

		$m4is_fgxy = [
			'message'  => apply_filters('appp_login_success', sprintf(__('Welcome back %s!', 'apppresser'), $user_signon->display_name), $user_signon->ID),
			'username' => $info['user_login'],
			'avatar'   => get_avatar_url($user_signon->ID),                                                                                                   			'success'  => true,
			'user_id'  => $user_signon->ID
		];
				$m4is_fgxy = apply_filters('appp_login_data', $m4is_fgxy, $user_signon->ID);
		do_action('appp_register_verified', $user_signon->ID);
		$m4is_qirnk = rest_ensure_response($m4is_fgxy);

		return $m4is_qirnk;
	}

	
	
function __construct() {
		$this->m4is_ap508();
	}

}
