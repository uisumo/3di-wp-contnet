<?php

defined( 'ABSPATH' ) ||	die();


class wpal_access_token {

    const OAUTH_URL  = 'https://oauth-m4is.webpowerandlight.com/';
    const TOKEN_SLUG = 'wpal/oauth/token';
    const REFRESH    = 'wpal/oauth/refresh';
    const PASSKEY    = 'wpal/oauth/passkey';

		
function handle_authorization() {
        $this->log['start'] = microtime(true);
        $connecting         = ! empty( $_GET['is_auth_access_token'] ) && ! empty( $_GET['is_auth_refresh_token'] );
        $error              = ! empty( $_GET['is_auth_error'] ) ? base64_decode( $_GET['is_auth_error'] ) : false;
        $license            = ! empty( $_GET['is_auth_license'] ) ? $_GET['is_auth_license'] : false;

				if( $license ){
			$this->manage_cron_hourly_refresh_check( 'disconnect' );
			$this->i2sdk->manageLicense( $license, true );
			return;
		}

				if( $error ){
			$this->manage_cron_hourly_refresh_check('disconnect');

			if( is_admin() ){
				$error_type = $license ? 'license' : 'connection';
				$this->i2sdk->admin_notice( $error_type, '', $error );
				return;
			}
		}

				if( $connecting ){
						$pass_error = ! empty( $_GET['is_auth_passkey'] ) ? $this->manage_oauth_passkey( 'validate', $_GET['is_auth_passkey'] ) : false;

			if( $pass_error ){
				$this->manage_cron_hourly_refresh_check( 'disconnect' );
				$this->i2sdk->admin_notice( 'connection', '', $pass_error );
				return;
			}

						$new_token = $this->set_token_object( $_GET, 'connecting' );

			if( $new_token ){
				$this->i2sdk->setConfigurationOption( 'oauth_enabled', 1 );
				header( 'Location: ' . $this->get_admin_url() );
				exit;
			}
		}

		return;
	}

		
function handle_reset(){
		if( ! empty($_POST['is_set_oauth_expiration']) && $_POST['is_set_oauth_expiration'] == 'Test Token Refresh' ){
			if ( $_SERVER['REQUEST_METHOD'] == 'POST' ) {
	            	            if( ! empty($_POST['is_set_oauth_expiration']) && $_POST['is_set_oauth_expiration'] == 'Test Token Refresh' ){
	                $this->set_oauth_expiration();
	    		}
	        }
		}
	}

        
function get_token_object(){
        return get_option(self::TOKEN_SLUG, false);
    }

        
function delete_token_object( $log = false ){
		update_option( self::REFRESH, 0 );
		delete_option( self::TOKEN_SLUG );

		$this->token_object = false;

		$this->i2sdk->setConfigurationOption('access_token', '');
		$this->manage_cron_hourly_refresh_check('disconnect');
		if( !empty($log) && $this->api_log ){
			$this->i2sdk->writeAPILog($log);
		}
	}

    
function disconnect( $admin = 0 ){
		$log = false;
		if( (int)$admin > 0 ){
			global $wpdb;
			$user_email = $wpdb->get_var( "SELECT user_email FROM $wpdb->users WHERE ID = {$admin}" );
			$this->log['user']   = $user_email;
			$this->log['result'] = "Oauth Disconnected by User Email : {$user_email}";
			$log = $this->log;
			$this->i2sdk->setConfigurationOption('oauth_enabled', 0);
		}
		$this->delete_token_object($log);
	}

        
function set_token_object( $data, $action ){

		$token = [
			'access_token'  => '',
			'refresh_token' => '',
			'appDomain'     => '',
			'expires_in'    => ''
		];

		if( $action === 'connecting' ){
			foreach ($token as $k => $v) {
				$data_key = "is_auth_{$k}";
				$token[$k] = !empty($data[$data_key]) ? base64_decode($data[$data_key]) : false;
			}
		}
		else if( $action === 'refresh' ){
			if (is_array($data)) {
				$scope_parts = array_key_exists('scope', $data) ? explode( "|", $data['scope'] ) : false;
				if( $scope_parts ){
					$data['appDomain'] = $scope_parts[1];
				}
				foreach ($token as $k => $v) {
					$token[$k] = !empty($data[$k]) ? $data[$k] : false;
				}
			}
		}

		if( !empty($token['access_token']) ){
			$access_token = $token['access_token'];
			$appname      = str_replace(".infusionsoft.com","",$token['appDomain']);
			$this->token_object = (object)[
				'accessToken'   => $access_token,
				'refreshToken'  => $token['refresh_token'],
				'endOfLife'     => time() + $token['expires_in'],
				'appDomain'     => $token['appDomain'],
				'appName'       => $appname,
				'siteUrl'       => $this->site_url_duplicate_lock( $this->get_siteurl() )
			];

						$verified = $this->verify_connection($access_token, $appname);
			$access_token = $verified ? $access_token : '';
			$this->token_object = $verified ? $this->token_object : null;
			update_option( self::TOKEN_SLUG, $this->token_object );
			$this->i2sdk->setConfigurationOption('access_token', $access_token);
			if( $verified ){
				$this->i2sdk->setApp( $appname, $this->token_object, $action );
				$this->i2sdk->manageLicense(false);
				if( $action === 'connecting' ){
					$this->manage_cron_hourly_refresh_check($action);
				}
			}
		}

		return $this->token_object;
	}

	
function verify_connection( $token, $appname ){
		$this->i2sdk->rest()->set_token($token);
		$this->i2sdk->rest()->set_appname($appname);
		return $this->i2sdk->rest()->verify_connection();
	}

			
    
function needs_refresh_check(){
		$token = $this->get_token_object();
		if( ! is_object($token) ){
			return false;
		}
				$expired = (time()+3600) > (int)$token->endOfLife;
				(int) $timestamp = get_option( self::REFRESH, 0 );
				$can_process = (time()-60) > $timestamp;
				return ( $expired && $can_process );
    }

	
function cron_hourly_refresh_check(){
		$this->token_object = $this->get_token_object();
		if( is_object( $this->token_object ) ){
			if( $this->needs_refresh_check() ){
				$this->refresh_token();
			}
		}
	}

	
function manage_cron_hourly_refresh_check( string $action ){
		$cron_hook      = 'i2sdkng_refresh_check';
	    $cron_timestamp = wp_next_scheduled($cron_hook);
				if( ! empty($cron_timestamp) ){
			wp_clear_scheduled_hook($cron_hook);
		}
		if( $action === 'connecting' ){
			wp_schedule_event(time() + mt_rand(300,900), 'hourly', $cron_hook);
		}
	}

    
function refresh_token(){
		$token = $this->get_token_object();
		$token = $token && is_object($token) ? $token : false;
		$refresh_token = $token ? $token->refreshToken : false;
		$this->log['service'] = 'oauth_refresh_token';

		if( ! $refresh_token ){
			if( $token ){
								$access_token = isset($token->accessToken) ? $token->accessToken : '';
				$appname      = isset($token->appName) ? $token->appName : '';
				$verified     = $this->verify_connection($access_token, $appname);
								if( ! $verified ){
					$this->log['result'] = "Invalid refresh token";
					$this->delete_token_object($this->log);
				}
			}
			return false;
		}

				$siteurl_check = $this->site_url_check($token);
		if( ! $siteurl_check ){
			return false;
		}

				update_option( self::REFRESH, time() );

				$body = [
			'operation'     => 'refresh',
			'redirect_uri'  => $this->get_current_url(),
			'refresh_token' => base64_encode( $refresh_token ),
			'appname'       => $token->appDomain,
			'site_url'      => $this->get_siteurl(),
			'version'       => $this->i2sdk->getConfigurationOption('version')
		];

		$response = wp_remote_post( self::OAUTH_URL, [
			'timeout'   => 60,
			'sslverify' => true,
			'body'      => $body
		]);

		$this->log['caller'] = utf8_encode(var_export($body, true) );

		if ( is_wp_error( $response ) ) {
			if( $this->api_log ){
				$this->log['result'] = "Error Code : " . $response->get_error_code() . " | Message : " . $response->get_error_message();
				$this->i2sdk->writeAPILog($this->log);
			}
		}
		else{
			$body    = wp_remote_retrieve_body( $response );
			$decoded = json_decode($body, true);
			if( is_array($decoded) ){
				if ( isset($decoded['error']) || isset($decoded['is_auth_error']) ){
					$error   = isset($decoded['is_auth_error']) ? base64_decode($decoded['is_auth_error']) : $decoded['error'];
					$license = isset($decoded['is_auth_license']) ? $decoded['is_auth_license'] : false;
					if( $error === 'invalid_grant' || $error === 'invalid_request' ){
						$error = 'Invalid Refresh';
					}
					else if( $error === 'No active license found' || $license ){
						$this->i2sdk->manageLicense( $license, true );
					}

					$this->log['result'] = $error;
										$current_token = $this->get_token_object();
					if( is_object($current_token) ){
						if( $current_token->refreshToken === $refresh_token ){
							$this->delete_token_object($this->log);
						}
					}
					return;
				}
								else{
					$token = $this->set_token_object($decoded, 'refresh');
					if( $this->api_log ){
						$this->log['result'] = utf8_encode(var_export($token, true) );
						$this->i2sdk->writeAPILog($this->log);
					}
					return $token;
				}
			}
						else{
				if( $this->api_log ){
					$this->log['result'] = utf8_encode(var_export($decoded, true) );
					$this->i2sdk->writeAPILog($this->log);
				}
			}
		}
	}

		
function handle_http_invalid_access_token( $response, $args, $url ){

				if ( $this->needs_refresh_check() ){
			$token_object = $this->refresh_token();
			if( ! is_wp_error($token_object) && is_object($token_object) ){
				$token = !empty($token_object->accessToken) ? $token_object->accessToken : false;
				if($token){
										$parts   = parse_url($url);
					parse_str($parts['query'], $query);
					$expired = $query['access_token'];
					$url     = str_replace("access_token={$expired}", "access_token={$token}", $url);

										if( !empty($args['headers']) && !empty($args['headers']['Authorization'])){
						$args['headers']['Authorization'] = 'Bearer ' . $token;
					}
										if( strpos( $url, 'api.infusionsoft.com/crm/xmlrpc/' ) !== false ){
						if( ! empty($args['body']) ){
							$args['body'] = str_replace($expired, $token, $args['body']);
						}
					}
					$response = wp_remote_request($url, $args);
				}
			}
		}

		return $response;
	}

    
function manage_oauth_passkey( $action, $check_pass = false ){
		$transient_slug = 'is/oauth/passkey/transient';
		if( $action === 'set' ){
			$passkey = $this->get_passkey();
			set_transient( $transient_slug, $passkey, 60*5 );
			return $passkey;
		}
		else if ( $action === 'validate' ){
			$check_pass = !empty($check_pass) ? base64_decode($check_pass) : false;
			$pass = get_transient( $transient_slug );
			$error = false;
			if ( empty( $pass ) || $check_pass != $pass ){
				$error = __('Could not verify server authorization. Please Refresh the page and try again.');
			}
			delete_option( self::PASSKEY );
			delete_transient( $transient_slug );
			return $error;
		}
	}

    
function get_passkey() {
		static $passkey = null;

		if( is_null($passkey) ){
			$passkey = get_option( self::PASSKEY, false );

			if( ! $passkey ) {
				$passkey = bin2hex(random_bytes(16));
				update_option( self::PASSKEY, $passkey );
			}
		}
		return $passkey;
	}

    
function get_connect_url(){
        static $token_url = null;
        if( is_null($token_url) ){
			$token_url = add_query_arg( [
				'operation'		=> 'connect',
				'redirect_uri'	=> $this->get_current_url(),
				'passkey'		=> $this->manage_oauth_passkey( 'set' ),
				'version'		=> $this->i2sdk->getConfigurationOption('version')
			], self::OAUTH_URL );
		}
		return $token_url;
	}

	
function get_current_url(){
		return ( is_ssl() ? 'https' : 'http' ) . "://{$_SERVER['HTTP_HOST']}{$_SERVER['REQUEST_URI']}";
	}

    
function get_admin_url(){
        return admin_url( 'admin.php?page=i2sdk-admin', is_ssl() ? 'https' : 'http' );
    }

    	
function get_siteurl() {
		static $siteurl = null;
		if( is_null($siteurl) ){
			global $wpdb;
			$sql     = "SELECT `option_value` FROM {$wpdb->options} WHERE `option_name` = 'siteurl' ORDER BY `option_id` LIMIT 1";
			$url     = $wpdb->get_var($sql);
			$parts   = wp_parse_url( $url );
			$host    = isset( $parts['host'] ) ? $parts['host'] : '';
			$path    = isset( $parts['path'] ) ? $parts['path'] : '';
			$return  = strtolower(trim($host . $path));
			$siteurl = rtrim($return, '/');
		}
		return $siteurl;
	}

            
function site_url_check($token){
        $passed  = true;
        $check   = ( is_object($token) && !empty($token->siteUrl) ) ? $token->siteUrl : false;
		$check   = $check ? str_replace('_[memb_site_url]_', '', $check) : $check;
        $siteurl = $this->get_siteurl();
        if( $siteurl != $check ){
			$this->log['result'] = sprintf( __("Site URL (%s) does not match Token URL (%s)" ), $siteurl, $check );
            $this->delete_token_object( $this->log );
            $passed = is_admin() ? false : $passed;
        }
        return $passed;
    }

		
function site_url_duplicate_lock($url){
		return substr_replace( $url, '_[memb_site_url]_', strlen( $url ) / 2, 0 );
	}

        
function set_oauth_expiration(){
		$token = $this->get_token_object();
		if( is_object( $token ) ){
			$this->refresh_token();
			
			header( 'Location: ' . $this->get_admin_url() );
			exit;
		}
	}

    
function __construct( $i2sdk ){
        $this->i2sdk   = $i2sdk;
        $this->api_log = !empty($this->i2sdk->getConfigurationOption('api_log'));
    }

	public $log = [];
    private $token_object = null, $api_log = 0, $i2sdk;

}
