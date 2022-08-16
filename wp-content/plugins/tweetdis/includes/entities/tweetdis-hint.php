<?php

/**
 * Tweetdis Hint
 *
 * @package    tweetdis
 * @subpackage tweetdis/includes/entities
 *
 * Hint properties and functions
 *
 */

class Tweetdis_Hint extends Tweetdis_Entity
{       
        /**
         * Initialize the class and set hint parameters
         * 
         * @param type $phrase  Phrase to tweet
         * @param array $atts Shortcode attributes
         * @param type $shortcode   Shortcode name
         */
        public function __construct( $phrase, $atts, $shortcode ) {
 
                parent::__construct( $phrase );
                
                $params = shortcode_atts(array(
                        'url' => '',
                        'inject' => '',
                        'excerpt' => ''
                ), $atts, $shortcode);
                $this->params = $this->prepare_hint_params($params);
                
        }
   
        /**
         * Prepare hint html for page and feed
         * 
         * @return string
         */
        public function display($settings_page = false) {
                     
                $onclick = '';
                if (!$settings_page) {
                    $this->get_link_sections();
                    $tweet_link = $this->make_tweet_link();
                    $onclick = 'onclick="window.open(\'' . $tweet_link . '\', \'_blank\', \'width=500,height=500\'); return false;"';
                }
                
                $hint_settings = $this->settings->get_hint_settings();
                $comment = "<!--'Made with TweetDis plugin for Wordpress'-->";
                
                //if rss request
                if (is_feed()) {
                    $layout = $comment . '<a href="' . $tweet_link . '" target="_blank">' . $this->phrase . '</a>';
                }
                else {
                $layout = $comment. 
                        '<span class="tweetdis_hint">'
                            . '<a href="#" ' . $onclick . ' class="type_' . $hint_settings['style'] . ' color_' . $hint_settings['color'] . '">'
                                    . '<span class="tweetdis_hint_content">' . $this->phrase . '</span><span class="tweetdis_hint_icon"></span>
                            </a>
                        </span>';
                }
                return $this->remove_eol_and_spaces($layout);
            
        }
        
        /**
         * Get tweet link sections: 'reference_before', 'phrase',
         *  'hidden', 'reference_after', 'custom'
         */
        private function get_link_sections() {

                if ( $this->get_first_link_sections() ) {
                
                    //Add hidden text
                    if ( $this->params['hidden'] !== '' ) {
                            $tweet_hidden = $this->shorten_text($this->params['hidden']);
                            if ( !$this->add_to_link( $tweet_hidden, 'hidden' ) ) {
                                return;
                            }
                    }

                    //Add phrase
                    if ($this->tweet_length > 10) {
                            $phrase = html_entity_decode($this->phrase);
                            $this->add_phrase($phrase);
                    }
                    
                }
        }
        
        /**
         * Prepare hint parameters 
         * 
         * @param array $params Shortcode parameters
         * @return array
         */
        private function prepare_hint_params($params) {
            
                $params['hidden'] = $params['inject'];
                unset($params['inject']);
                $params['custom'] = $params['excerpt'];
                unset($params['excerpt']);
                
                return $params;
        }

}