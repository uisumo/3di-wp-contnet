<?php

if ( !defined( 'ABSPATH' ) ) {
	die();
}


class i2sdk_ixr_client_class extends IXR_Client {

	
	public $error;
    public $scheme;

    public $i2sdk_xml_request  = '';
    public $i2sdk_api_log      = false;

	
	public 
function __construct( $server, $path = false, $port = false, $timeout = 15 ) {
		if ( ! $path ) {
						$bits         = parse_url( $server );
			$this->scheme = $bits['scheme'];
			$this->server = $bits['host'];
			$this->port   = isset( $bits['port'] ) ? $bits['port'] : $port;
			$this->path   = ! empty( $bits['path'] ) ? $bits['path'] : '/';

						if ( ! $this->path ) {
				$this->path = '/';
			}

			if ( ! empty( $bits['query'] ) ) {
				$this->path .= '?' . $bits['query'];
			}
		} else {
			$this->scheme = 'http';
			$this->server = $server;
			$this->path   = $path;
			$this->port   = $port;
		}
		$this->useragent = 'The Incutio XML-RPC PHP Library';
		$this->timeout   = $timeout;
			}

	public 
function i2sdkcall( $request ){
		$this->error = false;
		if ( ! call_user_func_array( [$this, 'query'], $request ) ) {
			$errorCode    = $this->getErrorCode();
			$errorMessage = $this->getErrorMessage();
			if( is_object($this->message) ){
				if( 'fault' === $this->message->messageType && $this->message->faultCode !== $errorCode ){
					$errorCode    = $this->message->faultCode;
					$errorMessage = $this->message->faultCode;
				}
			}
			return new WP_Error( $errorCode, $errorMessage );
		}
		else{
			return $this->decodeResponse();
		}
	}

	
	public 
function query( ...$args ) {

                $this->i2sdk_xml_request = '';

		$method  = array_shift( $args );
		$request = new IXR_Request( $method, $args );
		$xml     = $request->getXml();

		$port = $this->port ? ":$this->port" : '';
		$url  = $this->scheme . '://' . $this->server . $port . $this->path;
		$args = [
			'headers'    => [ 'Content-Type' => 'text/xml' ],
			'user-agent' => $this->useragent,
			'body'       => $xml,
		];

				foreach ( $this->headers as $header => $value ) {
			$args['headers'][ $header ] = $value;
		}

		
		$args['headers'] = apply_filters( 'wp_http_ixr_client_headers', $args['headers'] );

		if ( false !== $this->timeout ) {
			$args['timeout'] = $this->timeout;
		}

		if ( $this->debug ) {
            echo '<pre class="ixr_request">' . htmlspecialchars( $xml ) . "\n</pre>\n\n";
		}

        if( $this->i2sdk_api_log ){
            $this->i2sdk_xml_request = $xml;
        }

        		$response = wp_remote_post( $url, $args );

		if ( is_wp_error( $response ) ) {
			$errno       = $response->get_error_code();
			$errorstr    = $response->get_error_message();
			$this->error = new IXR_Error( $errno, $errorstr );
            			return false;
		}

		$response_code = wp_remote_retrieve_response_code( $response );
		if ( 200 != $response_code ) {
			$errno    = 5;
			$errorstr = "HTTP status code was not 200 ({$response_code})";
						$message = wp_remote_retrieve_response_message( $response );
			if( $message === 'Unauthorized' ){
				$errno = 2;
				$body  = json_decode( wp_remote_retrieve_body( $response ) );
				if( is_object($body) && isset($body->fault) ){
					$errorstr = $body->fault->faultstring;
				}
			}
            $this->error = new IXR_Error( $errno, $errorstr );
						return false;
		}

		if ( $this->debug ) {
			echo '<pre class="ixr_response">' . htmlspecialchars( wp_remote_retrieve_body( $response ) ) . "\n</pre>\n\n";
		}

				$this->message = new IXR_Message( wp_remote_retrieve_body( $response ) );
		if ( ! $this->message->parse() ) {
						$this->error = new IXR_Error( -32700, 'parse error. not well formed' );
			return false;
		}

				if ( 'fault' === $this->message->messageType ) {
			$this->error = new IXR_Error( $this->message->faultCode, $this->message->faultString );
			return false;
		}

				return true;
	}

    
function decodeResponse(){
        $result = $this->getResponse();
        $can_encode = extension_loaded('mbstring') && function_exists('utf8_encode');
        if( is_array($result) ){
            array_walk_recursive($result, function(&$v, $k) use ($can_encode) {
                if( is_a($v, 'IXR_Date') ){
                    $v = $v->getIso();
                }
                else if ( $can_encode && mb_detect_encoding($v) <> 'UTF-8') {
                    $v = utf8_encode($v);
                }
            });
        }
        else {
            if( is_a($result, 'IXR_Date') ){
                $result = $result->getIso();
            }
            else if( $can_encode && is_string($result) && mb_detect_encoding($result) <> 'UTF-8' ){
                $result = utf8_encode($result);
            }
        }
        return $result;
    }

    
function getXMLRequest(){
        return $this->i2sdk_xml_request;
    }

}
