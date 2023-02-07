<?php

/**
 * Tweetdis Entity
 *
 * @package    tweetdis
 * @subpackage tweetdis/includes
 *
 * Base class for plugin entities
 *
 */

abstract class Tweetdis_Entity
{
        /**
	 * Tweet length
	 *
	 * @var integer Max tweet length
	 */
	protected $tweet_length;
        
        /**
         * Tweet link segments
         * 
         * @var array
         */
        protected $link;
        
         /**
         * Shortcode attributes
         * 
         * @var array 
         */
        protected $params;
        
        /**
         * Tweet intent url
         * 
         * @var string
         */
        protected $tweet_intent;
        
        /**
         * Plugin settings
         * 
         * @var Tweetdis_Settings  instance of this singleton class
         */
        protected $settings;
        
        /**
         * Remote requests functionality
         * 
         * @var Tweetdis_Connect  instance of this singleton class
         */
        protected $connect;
        
        /**
         * Phrase to tweet
         * 
         * @var string 
         */
        protected $phrase;
        
        /**
         * Is multibute module enabled
         * 
         * @var boolean
         */
        protected $mb_enabled;


        /**
         * Initialize the class
         * 
         * @param string $phrase Phrase to tweet
         * @param bool $clean If phrase should be cleaned
         */
	protected function __construct( $phrase, $clean = true) {
            
                $this->tweet_length = 280 - 24;
                $this->tweet_intent = 'https://twitter.com/intent/tweet?text=';
                $this->settings = Tweetdis_Settings::get_instance();
                $this->connect = Tweetdis_Connect::get_instance();

                if ($clean) {
                    $this->phrase = strip_tags(html_entity_decode($phrase, ENT_QUOTES, 'UTF-8'));
                }
                else {
                    $this->phrase = $phrase;
                }

                $this->link = array (
                    'reference_before' => '',
                    'image_txt' => '',
                    'phrase' => '',
                    'author' => '',
                    'hidden' => '',
                    'url' => '',
                    'reference_after' => '',
                    'custom' => ''
                );
                $this->mb_enabled = function_exists( 'mb_internal_encoding' );
                
        }
        
        /**
         * Display Tweetdis_Entity
         */
        abstract public function display();
        
        /**
         * Compose tweet link
         * 
         * @return string
         */
        protected function make_tweet_link() {

                $tweet_link = $this->link['reference_before'] . $this->link['image_txt'] . $this->link['phrase'] . 
                    $this->link['author'] . $this->link['hidden'] . $this->link['custom'] .
                    $this->link['url'] . $this->link['reference_after'];

                $recommend_to_follow = $this->settings->get_tweet_settings('follow');
                if ( $recommend_to_follow !== '') {
                    $tweet_link .= '&related=' . $recommend_to_follow;
                }

                $tweet_link = $this->tweet_intent . $tweet_link;

                return $tweet_link;
        }
                
        /**
         * Get tweet link sections: 'reference_before'/ 'reference_after', 'custom'
         * 
         * @return bool  true If enought space left for next sections
         */
        protected function get_first_link_sections()
        {
                //Custom tweet
                if ( isset($this->params['custom']) && $this->params['custom'] !== '') {
                        $tweet_custom = $this->shorten_text( $this->params['custom'] );
                        $this->add_to_link( $tweet_custom, 'custom');
                        //Add url
                        $this->add_to_link( $this->tweet_url(), 'url', false );
                        return false;
                }
                    
                $space_after = false;
                
                //Add reference to twitter account
                $tweet_settings = $this->settings->get_tweet_settings();
                if ( $tweet_settings['twitter'] !== '') {
                        $tweet_reference = $this->make_tweet_reference( $tweet_settings );
                        $space_after = ($tweet_reference['link_section'] === 'reference_after')? $space_after : true;
                        $this->add_to_link( $tweet_reference['reference'], $tweet_reference['link_section'], $space_after );
                        $space_after = !$space_after;
                }
                
                //Add url
                $this->add_to_link( $this->tweet_url(), 'url', $space_after );
                
                return true;
        }
        
        /**
         * Adds phrase to link
         * 
         * @param string $phrase
         */
        protected function add_phrase($phrase) {
                
                $phrase = ($this->mb_enabled)? mb_convert_encoding($phrase, 'UTF-8') : $phrase;
                $phrase = $this->shorten_text($phrase);
                $this->add_to_link( $phrase, 'phrase' );
            
        }
        
        /**
         * Shorten the text to match tweet max length
         * 
         * @param string $text  Text to be shortened
         * @return string   Shortened text
         */
        protected function shorten_text($text) {

                if ( $this->mb_enabled && (mb_strlen($text, 'UTF-8') > $this->tweet_length - 1) ) {
                    
                    $text = mb_substr($text, 0, $this->tweet_length-3, 'UTF-8');

                    $lastSpace = mb_strrpos($text, ' ', 'UTF-8');
                    if (false !== $lastSpace) {
                        $text = mb_substr($text, 0 , $lastSpace, 'UTF-8');
                    }

                    $text .= (mb_substr($text, -1, null, 'UTF-8') == '.') ? '..' : '...';
                }
                else if ( !$this->mb_enabled && (strlen($text) > $this->tweet_length - 1) ) {
                    
                    $text = substr($text, 0, $this->tweet_length-3);

                    $lastSpace = strrpos($text, ' ');
                    if (false !== $lastSpace) {
                        $text = substr($text, 0 , $lastSpace);
                    }

                    $text .= (substr($text, -1, null) == '.') ? '..' : '...';
                }
                
                
                return $text;

        }
        
        /**
         * Add value to link section and recalculate length
         * 
         * @param string $add  Text to add
         * @param string $part  Name of the link section to add
         * @param boolean $space_after Add space after section
         * @return bool     true if it is possible to add more text
         */
        protected function add_to_link($add, $part, $space_after = true) {
            
                if ($space_after) {
                    $add .= ' ';
                }

                if ($part !== 'url') {
                    $this->tweet_length -= ($this->mb_enabled)?  mb_strlen($add, 'UTF-8') : strlen($add);
                }
                
                $this->link[$part] = rawurlencode( html_entity_decode($add) );

                if ($this->tweet_length <= 3) {
                    return false;
                }
                
                return true;
               
        }
        
        /**
         * Add twitter account reference
         * 
         * @param array $tweet_settings  Tweet settings array
         * @return array ('link_section', 'reference')
         */
        protected function make_tweet_reference ( $tweet_settings ) {
            
                $tweet_reference = array(
                    'link_section' => 'reference_after', 
                    'reference' => ''
                );
            
                switch ($tweet_settings['preposition']) {
                    case 'none':
                        break;
                    case 'RT': $tweet_reference['link_section'] = 'reference_before';
                    default: $tweet_reference['reference'] = $tweet_settings['preposition']. ' ';
                        break;
                }

                $tweet_reference['reference'] .= '@'.$tweet_settings['twitter'];
                        
                return $tweet_reference;
            
        }
        
        /**
         * Get tweet url
         * 
         * @return string
         */
        protected function tweet_url () {
            
                $url = $this->validate_url($this->params['url']);
          
                if ( !$url ) {
                    $url = get_permalink();
                    return $this->shorten_url($url);
                }

                return $url;
            
        }
        
        /**
         * Validate url
         * 
         * @return bool     true if provided url is valid
         */
        protected function validate_url ($url) {
            
                if ( $parts = parse_url( $url ) ) {
                    if ( !isset($parts["scheme"]) )
                    {
                        $url = 'http://' . $url;
                    }
                }

                return filter_var( $url, FILTER_VALIDATE_URL);
                
        }
        
        /**
         * Shorten url if shortener is activated
         * 
         * @param string $url URL to shorten
         * @return string Shortened URL
         */
        protected function shorten_url($url) {
            
                $shortener = $this->settings->get_tweet_settings('shortener');

                if ($shortener === 'tinyurl') {
                    return $this->connect->get_tiny_url($url);
                }
                else if ($shortener == 'bitly' && ($bitly_url = $this->connect->get_bitly_url($url)) ) {
                    return $bitly_url;
                }

                return $url;
        }
        
        /**
         * Remove line breaks and extra whitespaces
         * 
         * @param string $html Tweetdis output html
         * @return string
         */
        protected function remove_eol_and_spaces($html) {
        
                $html = str_replace("\n", '', $html);
                $html = str_replace("\r", '', $html);
                return preg_replace('/\s{2,}/', ' ', $html);
            
        }
    
}