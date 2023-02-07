<?php

/**
 * Remote requests
 *
 * @package    tweetdis
 * @subpackage tweetdis/includes
 *
 * This class performs remote requests
 *
 */
class Tweetdis_Connect {
    
        /**
         * The class instance
         * 
         * @var Tweetdis_Connect $instance
         */
        private static $instance;
        
        /**
         * Plugin settings
         * 
         * @var Tweetdis_Settings  instance of this singleton class
         */
        private $settings;

        /**
	 * Initialize only instance of this class
	 */
	private function __construct() {
                $this->settings = Tweetdis_Settings::get_instance();
        }
        
        /**
        * Private clone method to prevent cloning of the class instance.
        *
        * @return void
        */
        private function __clone() {}
       /**
        * Private unserialize method to prevent unserializing of the class instance.
        *
        * @return void
        */
        private function __wakeup() {}
        
        /**
         * Get instance of this class
         * 
         * @return Tweetdis_Connect $instance
         */
        public static function get_instance() {
            
                if (null == self::$instance) {
                    self::$instance = new Tweetdis_Connect();
                }

                return self::$instance;
                
        }
        
        /**
         * Make remote get request
         * 
         * @param string $url Request url
         * @return mixed Requested data
         */
        public function remote_get_request($url, $args = array()) {

                $response = wp_remote_get($url, $args);
                if (is_wp_error($response)) {
                    return 'Failed to get data';
                }
                return wp_remote_retrieve_body($response);

        }
         
        /**
         * Make remote post request
         * 
         * @param string $url Request url
         * @return mixed Requested data
         */
        public function remote_post_request($url, $args = array()) {

                $response = wp_remote_post($url, $args);
                if (is_wp_error($response)) {
                    return 'Failed to get data';
                }
                return wp_remote_retrieve_body($response);

        }
        
        /**
         * Get url shortened by tinyurl
         * 
         * @param string $url URL to shorten
         * @return string
         */
        public function get_tiny_url ($url) {

                $tinyurl = $this->remote_get_request("http://tinyurl.com/api-create.php?url=".$url);
                return $tinyurl;
            
        }
        
        /**
         * Get url shortened by Bit.ly
         * 
         * @param string $long_url URL to shorten
         * @return boolean
         */
        public function get_bitly_url($long_url) {
            
                $url = 'https://api-ssl.bitly.com/v3/shorten';
                $url .= '?access_token='.$this->settings->get_tweet_settings('bitly_token');
                $url .= '&longUrl='.$long_url;

                $json_reply = $this->remote_get_request($url);
                $bitly_arr = json_decode($json_reply, true);
                
                if ( $bitly_arr['status_code'] == 200 ) {
                    return $bitly_arr['data']['url'];
                }
                
                return false;

        }
        
        /**
         * Get token from Bit.ly
         * 
         * @param string $login
         * @param string $password
         * @return string Token or error message
         */
        public function get_bitly_token($login, $password) {
            
                $bitlyAuth = 'Basic ' . base64_encode($login.':'.$password);
                $url = 'https://api-ssl.bitly.com/oauth/access_token';
                $args = array(
                    'headers' => array(
                        'Authorization' => $bitlyAuth,
                        'Content-type' => 'application/x-www-form-urlencoded'
                    )
                );

                $response = $this->remote_post_request($url, $args);
                
                $token = $this->parse_bitly($response, $login);
                return $token;
                
        }
        
        /**
         * Send activation information
         */
        public function send_activation() {
            
                $activation_data = array();
                $activation_data['domain'] = strip_tags( stripslashes($_REQUEST['domain']) );
                $activation_data['key'] = sanitize_text_field($_REQUEST['key']);
                $activation_data['email'] = sanitize_text_field($_REQUEST['email']);
                
                $url = "http://tweetdis.com/activate.php?act=activate&domain=".$activation_data['domain']."&key=".$activation_data['key']."&email=".$activation_data['email'];
                $response = $this->remote_get_request($url);
                if (preg_match('/^[\d\'"]+$/', $response)) {
                    $result = json_encode(array('code' => $activation_data['key'], 'domain' => $activation_data['domain'], 'activated' => true));
                    $this->settings->check_status($result);
                }
                else {
                    print '<p class=tweetdis_warning>'.$response.'</p>';
                }
                
        }

        /**
         * Parse Bit.ly response to get a result
         * 
         * @param mixed $response Bit.ly response
         * @param string $login
         * @return string JSON success or error
         */
        private function parse_bitly($response, $login) {
            
                $result = json_decode($response, true);
                
                //response contains only token string
                if ( $result === null ) {
                    $this->settings->update_bitly_token($response, $login);
                    return json_encode( array('success' => $response) );
                }
                
                $this->settings->update_bitly_token(false, '');
                return json_encode( array('error' => 'Invalid login or password') );
            
        }
        
}