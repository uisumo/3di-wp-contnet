<?php

/**
 * Tweetdis Image
 *
 * @package    tweetdis
 * @subpackage tweetdis/includes/entities
 *
 * Image properties and functions
 *
 */

class Tweetdis_Image extends Tweetdis_Entity
{            
        /**
	 * Image URL
	 *
	 * @var string
	 */
	private $image_url;
    
        /**
	 * Image align class
	 *
	 * @var string
	 */
	private $image_class;

        /**
         * Initialize the class and set hint parameters
         * 
         * @param type $phrase  Phrase to tweet
         * @param array $atts Shortcode attributes
         * @param type $shortcode   Shortcode name
         */
        public function __construct( $phrase, $atts, $shortcode ) {

                parent::__construct( $phrase, false );
                
                $params = shortcode_atts(array(
                        'url' => '',
                        'inject' => ''
                ), $atts, $shortcode);
                $this->params = $this->prepare_image_params( $params );

        }
   
        /**
         * Prepare image html for page and feed
         * Refer to the params used in 'view/image-view.php'
         * 
         * @return string Image html
         */
        public function display() {
                    
                $twitter_url = $this->parse_image_link();
                if (! $this->validate_url($twitter_url)) {
                    return '<p style="color: red;">[tweet_dis_img]Wrong image[/tweet_dis_img]</p>';
                }

                $this->get_link_sections($twitter_url);
                $tweet_link = $this->make_tweet_link();
                
                $comment = "<!--'Made with TweetDis plugin for Wordpress'-->";
                
                //if rss request
                if (is_feed()) {
                    $layout = $comment.'<img src="'. $this->image_url .'"/>
                        <br><a href="' . $tweet_link . '" target="_blank">[tweet this image]</a><br>';
                }
                else {
                    $image_template_settings = $this->settings->get_image_settings();
                    $image_template_name = $this->settings->get_default_image();
                    $image_url = $this->image_url;
                    $image_class = $this->image_class;

                    ob_start();
                    echo $comment;
                    include 'view/image-view.php';
                    $layout = ob_get_clean();
                }
                return $this->remove_eol_and_spaces($layout);
            
        }
        
        /**
         * Prepare image html for template selected in settings
         * Refer to the params used in 'view/image-view.php'
         * 
         * @param array $image_template_name Image template to show
         * @return string Image html
         */
        public function display_custom($image_template_name) {

                $image_url = $this->phrase;
                $image_class = 'aligncenter';
                
                $image_template_settings = $this->settings->get_image_settings($image_template_name);
                $settings_page = true;

                ob_start();
                include 'view/image-view.php';
                $layout = ob_get_clean();
                return $this->remove_eol_and_spaces($layout);
            
        }
        
        /**
         * Get tweet link sections: 'phrase', 'hidden'
         * 
         * @param string $twitter_url Image url in twitter 
         */
        private function get_link_sections($twitter_url) {
                
                $space_after = false;
                
                //Add reference to twitter account
                $tweet_settings = $this->settings->get_tweet_settings();
                if ( $tweet_settings['twitter'] !== '') {
                        
                        $tweet_reference = $this->make_tweet_reference( $tweet_settings );
                        $space_after = ($tweet_reference['link_section'] === 'reference_after')? $space_after : true;
                        if ( !$this->add_to_link( $tweet_reference['reference'], $tweet_reference['link_section'], $space_after ) ) {
                            return false;
                        }
                        $space_after = !$space_after;
                }
                
                //Add url
                $this->add_to_link( $this->tweet_url(), 'url', $space_after );
            
                //Add image text
                $settings = $this->settings->get_image_settings();
                if ( $settings['image_txt'] !== 'blank' ) {
                        
                        if ( $settings['image_txt'] === 'image_alt' ) {
                            $image_txt = $this->parse_image_alt();
                        }
                        else {
                            $image_txt = get_the_title();
                        }
                        
                        $image_txt = $this->shorten_text($image_txt);
                        if ( !$this->add_to_link( $image_txt, 'image_txt' ) ) {
                            return;
                        }
                }
                
                //Add hidden text
                if ( $this->params['hidden'] !== '' ) {
                        $tweet_hidden = $this->shorten_text($this->params['hidden']);
                        if ( !$this->add_to_link( $tweet_hidden, 'hidden' ) ) {
                            return;
                        }
                }

                //Add phrase
                if ($this->tweet_length > 10) {
                        $phrase = html_entity_decode($twitter_url);
                        $this->add_phrase($phrase);
                }
                    
        }

        /**
         * Parse image tag
         * 
         * @return string Twitter URL for image
         */
        private function parse_image_link() {
            
                $img_tag = array();
                preg_match('/<img(.*)src(.*)=(.*)"(.*)"/U', $this->phrase, $img_tag);
                if (strlen($img_tag[4])===0) {
                    return false;
                }
                $this->image_url = $img_tag[4];
                
                $img_class = array();
                preg_match('/<img(.*)class(.*)=(.*)"(.*)"/U', $this->phrase, $img_class);
                if(strpos($img_class[4], 'alignnone') !== false) {$this->image_class = 'alignnone';}
                if(strpos($img_class[4], 'alignleft') !== false) {$this->image_class = 'alignleft';}
                if(strpos($img_class[4], 'aligncenter') !== false) {$this->image_class = 'aligncenter';}
                if(strpos($img_class[4], 'alignright') !== false) {$this->image_class = 'alignright';}
                
                
                if (function_exists('get_home_path')) {
                    $image_path = str_replace(home_url( '/' ), get_home_path().'/', $this->image_url);
                }
                else {
                    $image_path = str_replace(home_url( '/' ), $this->get_home_path().'/', $this->image_url);
                }
                
                $twitter_url = $this->settings->get_twitter_image_url($image_path);       
                
                if ( $twitter_url !== null ) {
                    return $twitter_url;
                }
                else {
                    return $this->send_image_to_twitter($image_path, $this->image_url);
                }
     
        } 
        
        /**
         * Parse image alt attribute
         * 
         * @return string Alt attribute value
         */
        private function parse_image_alt() {
                
                $alt = array();
                preg_match('/<img(.*)alt(.*)=(.*)"(.*)"/U', $this->phrase, $alt);
                return $alt[4];
                
        }
        
        /**
         * Send image to twitter and return url
         * 
         * @param string $image_path
         * @param string $image_url
         * @return string Twitter URL
         */
        private function send_image_to_twitter($image_path, $image_url) {
            
                require_once(dirname( __FILE__ ) . '/twitteroauth/tmhOAuth.php');
                require_once(dirname( __FILE__ ) . '/twitteroauth/tmhUtilities.php');

                $tmhOAuth = new tmhOAuth(array(
                    'consumer_key' => 'cCtH2n2q8xre2Phr0rqI3uBEG',
                    'consumer_secret' => 'kdRPeWLlVmHp9P4r96ObRczBcgaZ1HRpkZxpGxlD7gsXIAfRYp',
                    'user_token' => '3109821135-ntmRhn5LWmt33sKD2rm9Zgv7i4O2dNsIqSdJn5O',
                    'user_secret' => 'AHbqh9AGQhFy2V31DzbjN4cFAtEWQCqcc5cBIixoSek4M'
                ));
                
                $image_name  = basename($image_path);
                
                if(class_exists('CurlFile')) {
                    
                    $response = $tmhOAuth->request('POST', 
                        $tmhOAuth->url('1.1/statuses/update_with_media'),
                        array(
                            'media[]'  => new CURLFile($image_path, 'image/jpeg', $image_name),
                            'status'  => 'Tweetdis ' . home_url( '/' )
                        ), 
                        true, // use auth
                        true  // multipart
                    );
                    
                }
                else {
                    
                    $response = $tmhOAuth->request('POST', 
                        $tmhOAuth->url('1.1/statuses/update_with_media'),
                        array(
                            'media[]'  => "@{$image_path};type=image/jpeg;filename={$image_name}",
                            'status'  => 'Tweetdis ' . home_url( '/' )
                        ), 
                        true, // use auth
                        true  // multipart
                    );
                            
                }
                                      
                $result_img = json_decode($tmhOAuth->response['response']);
                if ($response != 200) {
                    return $image_url;
                }
                else {
                    $twitter_url = $result_img->entities->media[0]->url;
                    $this->settings->set_twitter_image_url($image_path, $twitter_url);
                    return $twitter_url;
                }
        }  
        
        /**
         * Prepare image parameters 
         * 
         * @param array $params Shortcode parameters
         * @return array
         */
        private function prepare_image_params($params) {
            
                $params['hidden'] = $params['inject'];
                unset($params['inject']);
                
                return $params;
        }
        
        /**
         * get_home_path() function if not included for public side
         * 
         * @return string
         */
        private function get_home_path() {
 
                $home = get_option( 'home' );
                $siteurl = get_option( 'siteurl' );

                if ( $home != '' && $home != $siteurl ) {

                    $wp_path_rel_to_home = str_replace($home, '', $siteurl); /* $siteurl - $home */

                    $pos = strpos($_SERVER["SCRIPT_FILENAME"], $wp_path_rel_to_home);

                    $home_path = substr($_SERVER["SCRIPT_FILENAME"], 0, $pos);

                    $home_path = trailingslashit( $home_path );

                } else {

                    $home_path = ABSPATH;

                }
                return $home_path;

        }

}