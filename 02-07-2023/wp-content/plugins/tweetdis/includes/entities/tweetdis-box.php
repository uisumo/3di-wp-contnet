<?php

/**
 * Tweetdis Box
 *
 * @package    tweetdis
 * @subpackage tweetdis/includes/entities
 *
 * Box properties and functions
 *
 */

class Tweetdis_Box extends Tweetdis_Entity
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
                        'excerpt' => '',
                        'float' => 'none',
                        'width' => '',
                        'design' => 'default',
                        'author' => $this->settings->get_tweet_author('author'),
                        'pic_url' => $this->settings->get_tweet_author('author_pic')
                ), $atts, $shortcode);
                $this->params = $this->prepare_box_params( $params );
           
        }
   
        /**
         * Prepare box html for page and feed
         * Refer to the params used in 'view/box-view.php'
         * 
         * @return string Box html
         */
        public function display() {
                     
                $this->get_link_sections();
                $tweet_link = $this->make_tweet_link();

                $box_preset_settings = $this->settings->get_box_settings($this->params['design']);
                $comment = "<!--'Made with TweetDis plugin for Wordpress'-->";
                
                //if rss request
                if (is_feed()) {
                    $layout = $comment . '<div style="margin: 20px 0; background:#e8f6fb;">
                                <p style="padding: 5% 5% 4% 5%; font-size: 24px; line-height: 30px; font-family: Open Sans, sans-serif; color: #7898a3;">'.$this->phrase.'</p>
                                <p style="padding: 20px 10px; border-top: 1px solid #dadada; background: #f5f5f5; text-align: right;">
                                    <a href="' . $tweet_link . '" target="_blank" style="text-decoration: none;">                        
                                        <span style="color: #fff; font-family: Open Sans, sans-serif; font-size: 15px; font-weight: 500; padding: 9px 17px; border-radius: 5px; background-color: #00b9e6;">
                                            <i></i>'.$box_preset_settings['callforaction'].
                                        '</span>
                                    </a>
                                </p>
                            </div>';
                }
                else {
                
                    $params = $this->params;
                    $phrase = $this->phrase;

                    ob_start();
                    echo $comment;
                    include 'view/box-view.php';
                    $layout = ob_get_clean();
                    
                }
                
                return $this->remove_eol_and_spaces($layout);
        }
        
        /**
         * Prepare box html with custom settings
         * Refer to the params used in 'view/box-view.php'
         * 
         * @param array $box_preset_settings Custom box preset settings
         * @param array $params 'design', 'author', 'author_pic' Shortcode params to override
         * @return string Box html
         */
        public function display_custom($box_preset_settings) {
                
                $params = $this->params;
                $phrase = $this->phrase;
                $settings_page = true;
                
                ob_start();
                include 'view/box-view.php';
                $layout = ob_get_clean();
                return $this->remove_eol_and_spaces($layout);
        }

        /**
         * Get tweet link sections: 'reference_before', 'phrase', 'author',
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

                    //Add author
                    if ( strpos( $this->params['design'], '_at') ) {
                            $author = $this->shorten_text($this->params['author']);
                            if ( !$this->add_to_link( '/' . $author, 'author' ) ) {
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
         * Prepare box parameters 
         * 
         * @param array $params Shortcode parameters
         * @return array
         */
        private function prepare_box_params($params) {
            
                if ($params['design'] === 'default') {
                    $params['design'] = $this->settings->get_default_box();
                }
                if ($params['float'] !== '') {
                    $params['float'] = 'tweetdis_' . $params['float'];
                }
                if ($params['width'] !== '') {
                    $params['width'] = 'style="width:' . $params['width'] . '"';
                }
                $params['author_pic'] = $params['pic_url'];
                unset($params['pic_url']);
                $params['hidden'] = $params['inject'];
                unset($params['inject']);
                $params['custom'] = $params['excerpt'];
                unset($params['excerpt']);
                
                return $params;
        }

}