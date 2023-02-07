<?php
if ( !defined( 'ABSPATH' ) ) {
	die();
}


class wpal_infusionsoft_rest {

	
function add_remove_tag_contacts( int $tag_id, array $contacts ){

		if( empty($tag_id) || empty($contacts) ){
			return false;
		}

		$action      = $tag_id < 0 ? 'remove' : 'add';
				$results     = [ 'SUCCESS' => [], 'FAILURE' => [] ];
		$batches     = $this->group_batch( $contacts );
		$batched     = count($batches) > 1;
				foreach ($batches as $contact_ids) {
			if( $action === 'add' ){
				$response = $this->post("tags/{$tag_id}/contacts", ['ids' => $contact_ids]);
				if( is_wp_error( $response ) || ! is_object($response) || ! empty($response->message) ){
					foreach ($contact_ids as $contact_id) {
						$results['FAILURE'][] = $contact_id;
					}
				}
				else if( is_object($response) ){
					foreach ($response as $contact_id => $result) {
						$result = $result !== 'SUCCESS' ? 'FAILURE' : 'SUCCESS';
						$results[$result][] = $contact_id;
					}
				}
			}
			else if( $action === 'remove' ){
				$tag_id      = abs($tag_id);
				$contact_ids = implode(",", $contact_ids);
				$response    = $this->delete("tags/{$tag_id}/contacts?ids={$contact_ids}");
				$result      = is_wp_error($response) ? 'FAILURE' : 'SUCCESS';
				foreach ($contacts as $contact_id) {
					$results[$result][] = $contact_id;
				}
			}
			if( $batched ){
				usleep(500000);
			}
		}

		return empty($results) ? false : $results;
	}

	
function add_contact_tags( int $contact_id, array $tag_ids ){

		if( empty($contact_id) || empty($tag_ids) ){
			return false;
		}

				$results     = ['SUCCESS' => [], 'FAILURE' => []];
		$batches     = $this->group_batch( $tag_ids );
		foreach ($batches as $tags) {
			$response = $this->post("contacts/{$contact_id}/tags", ['tagIds' => $tags]);
			if( is_wp_error( $response ) || ! is_object($response) || ! empty($response->message) ){
				foreach ($tags as $tag_id) {
					$results['FAILURE'][] = $tag_id;
				}
			}
			else{
				foreach ($response as $tag_id => $result) {
					$result = $result !== 'SUCCESS' ? 'FAILURE' : 'SUCCESS';
					$results[$result][] = $tag_id;
				}
			}
		}

		return empty($results) ? false : $results;
	}

	
function remove_contact_tags( int $contact_id, array $tag_ids ){

		if( empty($contact_id) || empty($tag_ids) ){
			return false;
		}

		$results     = ['SUCCESS' => [], 'FAILURE' => []];
		$batches     = $this->group_batch( $tag_ids );
		foreach ($batches as $tags) {
			$tag_ids = implode(",", $tags);
			$delete  = $this->delete("contacts/{$contact_id}/tags?ids={$tag_ids}");
			$result  = is_wp_error($delete) ? 'FAILURE' : 'SUCCESS';
			foreach ($tags as $tag_id) {
				$results[$result][] = $tag_id;
			}
		}
		return $results;
	}


		
function get( string $method, $args = false) {

		$start_time = microtime(true);

		$params = ['access_token' => $this->token];
		if( is_array($args) ){
			$params = wp_parse_args($args, $params);
		}
		$url = add_query_arg( $params, $this->api_base.$method );
		$retry_count = 0;

		

		do {
			usleep(500000 * $retry_count);
			$retry = false;
			$response = wp_remote_get($url);
			memberium_app()->m4is_taocq ( 0 );

			if ( is_wp_error($response) ) {
				$retry = $this->is_transient_api_error($response);
			}

			$retry_count++;

		} while ($retry && $retry_count <= $this->$max_retry);

		$this->api_count++;
		$result = (is_wp_error($response)) ? $response : json_decode(wp_remote_retrieve_body($response));
		if( $this->api_log ){
			$this->write_log( [
				'duration' => ( microtime(true) - $start_time ),
				'service'  => $this->get_log_service( 'GET', $url ),
				'caller'   => $url,
				'result'   => utf8_encode( var_export($result, true) ),
				'retries'  => $retry_count
			] );
		}
		return $result;
	}

		
function post( string $method, $body = false){
		return $this->request( $this->api_base.$method, 'POST', $body );
	}

		
function patch( string $method, $body = false ){
		return $this->request( $this->api_base.$method, 'PATCH', $body );
	}

		
function put( string $method, $body = false ){
		return $this->request( $this->api_base.$method, 'PUT', $body );
	}

		
function delete( string $method, $body = false ){
		$code = (int) $this->request( $this->api_base.$method, 'DELETE', $body );

		if( $code != 204 ){
			$errors = [
				0   => 'No Response',
				401 => 'Unauthorized',
				403 => 'Forbidden',
				404 => 'Not Found'
			];
			$error = array_key_exists($code, $errors) ? $errors[$code] : "Response code {$code}";
			return new WP_Error( $code, $errors[$code] );
		}
		else{
			return 'success';
		}
	}

		
function request(string $url, string $method, $body = false){

		$start_time = microtime(true);

		$params = [
			'method'  => $method,
			'headers' => $this->auth_header()
		];

		if($body){
			$params['body'] = ( is_array($body) ) ? json_encode($body) : $body;
		}

		$retry_count = 0;

		do {
			usleep(500000 * $retry_count);
			$retry = false;
			$response = wp_remote_request($url, $params);
			memberium_app()->m4is_taocq( 0 );

			if ( is_wp_error($response) ) {
				$retry = $this->is_transient_api_error($response);
			}
			$retry_count++;

		} while ($retry && $retry_count <= $this->$max_retry);

		$this->api_count++;

		if( $method === 'DELETE' ){
			$result = is_wp_error($response) ? $response : wp_remote_retrieve_response_code($response);
		}
		else{
			$result = is_wp_error($response) ? $response : json_decode(wp_remote_retrieve_body($response));
		}

		if( $this->api_log ){
			$this->write_log( [
				'duration' => ( microtime(true) - $start_time ),
				'service'  => $this->get_log_service( $method, $url ),
				'caller'   => $url,
				'result'   => utf8_encode( var_export($result, true) ),
				'retries'  => $retry_count
			] );
		}

		return $result;
	}

	private 
function is_transient_api_error($error) {
		return false;
	}

		
function auth_header() {
		return [
			'Authorization' => 'Bearer ' . $this->token,
			'Content-Type'  => 'application/json',
			'Accept'        => 'application/json',
		];
	}

	
function verify_connection(){
		$response = $this->get('setting/application/enabled');
		$fault    = !empty($response) && is_object($response) && isset($response->fault) ? $response->fault : false;
		if( $fault ){
			$response = new WP_Error( $fault->detail->errorcode, $fault->faultstring);
			if( strpos($fault->detail->errorcode, 'InvalidAccessToken') !== false ){
				global $i2sdk;
				$i2sdk->accessToken()->disconnect();
			}
		}

		return ! is_wp_error($response);
	}

	
function group_batch( array $ids, int $amount = 100 ){
		$batches = [];
		$ids     = array_values($ids);

		if( count($ids) > $amount ){
			$batches = array_chunk($ids, $amount);
		}
		else{
			$batches[] = $ids;
		}

		return $batches;
	}

	
function write_log( $log ){
		if( ! function_exists('wp_get_current_user') ){
			include(ABSPATH . "wp-includes/pluggable.php");
		}
		$log['user'] = wp_get_current_user()->user_login;
		$GLOBALS['i2sdk']->writeAPILog($log);
	}

	
function get_log_service( $method, $url ){
		$result = $method;
		$parts  = [];
		if (substr($url, 0, strlen($this->api_base)) == $this->api_base) {
						$url = substr($url, strlen($this->api_base));
						$parts = explode( '?', $url );
			$parts = !empty($parts[0]) ? explode("/", $parts[0]) : false;
			if( ! $parts ){
				return $result;
			}
						if(!empty($parts[0]) && $parts[0] === 'v2'){
				$result .= "/v2";
				unset($parts[0]);
				$parts = array_values($parts);
			}
						if( !empty($parts[0]) ){
				$result .= "/" . ucfirst($parts[0]);
				unset($parts[0]);
				$parts = array_values($parts);
			}
						if( (int)$parts[0] > 0 ){
				unset($parts[0]);
				$parts = array_values($parts);
			}
						if( !empty($parts[0]) ){
				$result .= "/" . ucfirst($parts[0]);
			}
		}

		$result = strlen($result) > 32 ? substr($result,0,32) : $result;

		return $result;
	}

	
function set_token($token) {
		$this->token = $token;
	}

	
function set_appname($appname) {
		$this->appname = $appname;
	}

	
function __construct($appname, $token, $api_log) {
		$this->appname = $appname;
		$this->token   = $token;
		$this->api_log = !empty($api_log);
	}

	private $token,
		$appname,
		$api_count = 0,
		$api_base  = 'https://api.infusionsoft.com/crm/rest/v1/',
		$max_retry = 3,
		$api_log   = false;

}
