<?php

/**
 * Store all plugin settings
 *
 * @package    tweetdis
 * @subpackage tweetdis/includes
 *
 * Keep all plugin settings and update them when user makes customizations
 *
 */
class Tweetdis_Settings {

        /**
         * The class instance
         * 
         * @var Tweetdis_Setting $instance
         */
        private static $instance;
        
        /**
         * Plugin db table name
         * 
         * @var string
         */
        private $plugin_table;

        /**
         * Hint settings
         * 
         * @var array $hint_settings 
         */
        private $hint_settings;
        
        /**
         * Box presets settings
         * 
         * @var array $box_settings 
         */
        private $box_settings;
        
        /**
         * Box preset names
         * 
         * @var array
         */
        private $box_presets;
        
        /**
         * Default box preset name
         * 
         * @var string
         */
        private $default_box;
        
        /**
         * Image template settings
         * 
         * @var array $image_settings 
         */
        private $image_settings;
        
        /**
         * Image templates names
         * 
         * @var array
         */
        private $image_presets;
        
        /**
         * Selected image template name
         * 
         * @var string
         */
        private $default_image;

        
         /**
         * Tweet author
         * 
         * @var array 'author' 'author_pic'
         */
        private $tweet_author;
        
        /**
         * Tweet settings
         * 
         * @var array $tweet_settings
         */
        private $tweet_settings;
        
        /**
         * Url of images folder
         * 
         * @var string
         */
        private $images_url;
        
        /**
         * Demo phrase for admin
         * 
         * @var array 'box', 'hint', 'image'
         */
        private $demo;

        /**
	 * Initialize only instance of this class
         * 
         * @global $wpdb
	 */
	private function __construct() {
            
                global $wpdb;
                $this->plugin_table = $wpdb->prefix . "tweetdis_list_img";
            
                $this->hint_settings = get_option('tweetdis_hint');
                $this->box_settings = get_option('tweetdis_box');
                $this->box_presets = array();
                $this->default_box = '';
                
                $this->image_settings = get_option('tweetdis_image');
                $this->image_presets = array();
                $this->default_image = '';
                
                $this->tweet_author = get_option('tweetdis_tweet_author');
                $this->tweet_settings = get_option('tweetdis_tweet_settings');
                
                $this->images_url = plugin_dir_url( dirname( __FILE__ ) ) . 'assets/images/';
                
                $this->demo = array (
                    'box' => 'The little vessel continued to beat its way seaward, and the ironclads receded slowly towards the coast',
                    'hint' => 'an example of any article on your blog. So this is kinda the paragraph of usual text in your article and what you see below is the "tweet box" created by TweetDis plugin.',
                    'image' => $this->images_url.'preview_box.png'
                );
            
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
         * @return Tweetdis_Settings $instance
         */
        public static function get_instance() {
            
                if (null == self::$instance) {
                    self::$instance = new Tweetdis_Settings();
                }

                return self::$instance;
                
        }

        /**
         * Get hint settings
         * 
         * @return array
         */
        public function get_hint_settings() {
                return $this->hint_settings;
        }
        
        /**
         * Get box settings
         * 
         * @param string $preset Preset name 
         * @return array Preset settings
         */
        public function get_box_settings( $preset ) {
                return $this->box_settings[$preset];
        }
                
        /**
         * Get box presets names
         * 
         * @return array
         */
        public function get_box_presets() {
            
                if (count($this->box_presets) === 0) {
                    $presets = $this->get_presets_and_default($this->box_settings);
                    $this->box_presets = $presets['presets'];
                    $this->default_box = $presets['default'];
                }
            
                return $this->box_presets;
        }
        
        /**
         * Get default box preset
         * 
         * @return string
         */
        public function get_default_box() {
            
                if ($this->default_box === '') {
                    $presets = $this->get_presets_and_default($this->box_settings);
                    $this->box_presets = $presets['presets'];
                    $this->default_box = $presets['default'];
                }
            
                return $this->default_box;
        }
                
        /**
         * Get tweet author
         * 
         * @param string $key Key of tweet author settings array.  Keys: 'author', 'author_pic'
         * @return array
         */
        public function get_tweet_author( $key = '' ) {
                if ( $key !== '' ) {
                    return $this->tweet_author[$key];
                }
            
                return $this->tweet_author;
        }
        
        /**
         * Get selected image template settings
         * 
         * @param string $preset Template name 
         * @return array Template settings
         */
        public function get_image_settings( $preset = '' ) {
            
                if ($preset == '') {
                    return $this->image_settings[$this->get_default_image()];
                }
                return $this->image_settings[$preset];
        }
        
        /**
         * Get image templates names
         * 
         * @return array
         */
        public function get_image_presets() {
            
                if (count($this->image_presets) === 0) {
                    $templates = $this->get_presets_and_default($this->image_settings, 'template_1');
                    $this->image_presets = $templates['presets'];
                    $this->default_image = $templates['default'];
                }
            
                return $this->image_presets;
        }
        
        /**
         * Get selected image template
         * 
         * @return string
         */
        public function get_default_image() {

                if ($this->default_image === '') {
                    $templates = $this->get_presets_and_default($this->image_settings, 'template_1');
                    $this->image_presets = $templates['presets'];
                    $this->default_image = $templates['default'];
                }
                
                return $this->default_image;
        }
        
        /**
         * Get tweet settings
         * 
         * @param string $key Key of tweet settings array.   Keys: 'twitter', 'follow', 'preposition', 'shortener'
         * @return array
         */
        public function get_tweet_settings( $key = '' ) {
            
                if ( $key !== '' ) {
                    return $this->tweet_settings[$key];
                }
            
                return $this->tweet_settings;
        }
        
        /**
         * Get demo phrase
         * 
         * @param string $type Type of entity to generate
         * @return string Demo phrase
         */
        public function get_demo( $type ) {
                return $this->demo[$type];
        }
           
        /**
         * Get images url
         * 
         * @return string
         */
        public function get_images_url() {
                return $this->images_url;
        }
        
        /**
         * Prepare box settings for save
         * 
         * @return boolean If saved successfully
         */
        public function save_box_settings() {
            
                if (isset ($_POST['design']) ) {

                    $preset = $_POST['design'];

                    $settings = $this->box_settings[$preset];
                    $settings['callforaction'] = isset($_POST['callforaction'])? strip_tags( stripslashes($_POST['callforaction']) ) : $settings['callforaction'];
                    $settings['font_size'] = isset($_POST['font_size'])? $_POST['font_size'] : $settings['font_size'];
                    $settings['color_number'] = isset($_POST['color_number'])? intval($_POST['color_number']) : $settings['color_number'];
                    $settings['margin_vertical'] = isset($_POST['margin_vertical'])? $_POST['margin_vertical'] : $settings['margin_vertical'];
                    $settings['default'] = isset($_POST['default'])? ($_POST['default'] === 'true')? true:false  : $settings['default'];

                    if (stripos($preset, '_at') ) {
                        $author['author'] = isset($_POST['author'])? strip_tags( stripslashes($_POST['author']) ) : $this->tweet_author['author'];
                        $author['author_pic'] = isset($_POST['author_pic'])? strip_tags( stripslashes($_POST['author_pic']) ) : $this->tweet_author['author_pic'];
                        $this->save_author_settings_to_db($author);
                    }

                    $this->save_box_settings_to_db($preset, $settings);

                    return true;
                }

                return false; 
        }
        
        /**
         * Prepare hint settings for save
         * 
         * @return boolean If saved successfully
         */
        public function save_hint_settings() {
            
                if (isset ($_POST['style']) ) {

                    $settings = $this->hint_settings;
                    $settings['style'] = isset($_POST['style'])? $_POST['style'] : $settings['style'];
                    $settings['color'] = isset($_POST['color'])? intval($_POST['color']) : $settings['color'];

                    $this->save_hint_settings_to_db($settings);

                    return true;
                }

                return false; 
        }
        
        /**
         * Prepare image settings for save
         * 
         * @return boolean If saved successfully
         */
        public function save_image_settings() {
            
                if (isset ($_POST['design']) ) {

                    $template = $_POST['design'];

                    $settings = $this->image_settings[$template];
                    $settings['callforaction'] = isset($_POST['callforaction'])? strip_tags( stripslashes($_POST['callforaction']) ) : $settings['callforaction'];
                    $settings['hover_action'] = isset($_POST['hover_action'])? $_POST['hover_action'] : $settings['hover_action'];
                    $settings['image_txt'] = isset($_POST['image_txt'])? $_POST['image_txt'] : $settings['image_txt'];
                    $settings['position'] = isset($_POST['position'])? $_POST['position'] : $settings['position'];
                    $settings['button_size'] = isset($_POST['button_size'])? $_POST['button_size'] : $settings['button_size'];

                    $this->save_image_settings_to_db($template, $settings);

                    return true;
                }

                return false; 
        }
        
        /**
         * Prepare tweet settings for save
         * 
         * @return boolean If saved successfully
         */
        public function save_tweet_settings() {
                
                $settings = $this->tweet_settings;
                $settings['twitter'] = isset($_POST['twitter'])? strip_tags( stripslashes($_POST['twitter']) ) : $settings['twitter'];
                $settings['follow'] = isset($_POST['follow'])? strip_tags( stripslashes($_POST['follow']) ) : $settings['follow'];
                $settings['preposition'] = isset($_POST['preposition'])? $_POST['preposition'] : $settings['preposition'];
                $settings['shortener'] = isset($_POST['shortener'])? $_POST['shortener'] : $settings['shortener'];
                $settings['bitly_token'] = isset($_POST['bitly_token'])? strip_tags( stripslashes($_POST['bitly_token']) ) : $settings['bitly_token'];
                
                $this->save_tweet_settings_to_db($settings);

                return true;
        }
        
        /**
         * Update bitly token value
         * 
         * @param string $token Bit ly shortener token
         */
        public function update_bitly_token($token, $login) {
            
                $this->tweet_settings['bitly_token'] = $token;
                $this->tweet_settings['bitly_account'] = $login;
                $this->save_tweet_settings_to_db($this->tweet_settings);
            
        }
        
        /**
         * Get twitter link for image
         * 
         * @global $wpdb
         * @param string $image_path Image path in filesystem
         * @return mixed Twitter URL or null
         */
        public function get_twitter_image_url($image_path) {
                global $wpdb;
                return $wpdb->get_var("SELECT tweet_src FROM `".$this->plugin_table."` WHERE img_src = '".$image_path."'");
        }
        
        /**
         * Save twitter link for image
         * 
         * @global $wpdb
         * @param string $image_path
         * @param string $twitter_url
         */
        public function set_twitter_image_url($image_path, $twitter_url) {
                global $wpdb;
                $wpdb->insert (
                    $this->plugin_table,
                    array(
                        'img_src' => $image_path,
                        'tweet_src' => $twitter_url
                    ),
                    array(
                        '%s',
                        '%s'
                    )
                );
        }
        
        /**
         * Get/set plugin status
         * 
         * @return boolean
         */
        public function check_status($status_params = '') {
            
                if ($status_params === '') {
                    $status = get_option('tweetdis_rinfo');
                    $status = json_decode($status, true);
                    return $status['activated'];
                }
                
                $this->update_status($status_params);
                return $this->check_status();
            
        }

        /**
         * Get presets names and default preset
         * 
         * @return array 'presets', 'default'
         */
        private function get_presets_and_default($settings, $default = 'box_01') {
            
                $presets = array (
                    'presets' => array(),
                    'default' => $default
                );
                foreach ($settings as $key => $value) {

                    $presets['presets'][] = $key;
                    
                    if ($value['default'] === true) {
                        $presets['default'] = $key;
                    }
                    
                }
                return $presets;
                
        }
        
        /**
         * Change default tweet box
         * 
         * @param string $preset New default box preset
         */
        private function change_default_box($preset) {

                $this->box_settings[$this->get_default_box()]['default'] = false;
                $this->default_box = $preset;

        }
        
        /**
         * Change selected image template
         * 
         * @param string $template New default image template
         */
        private function change_default_image($template) {

                $this->image_settings[$this->get_default_image()]['default'] = false;
                $this->image_settings[$template]['default'] = true;
                $this->default_image = $template;

        }
        
        /**
         * Save box settings
         * 
         * @param string $preset Preset to update
         * @param array $settings Settings to save
         */
        private function save_box_settings_to_db($preset, $settings) {

                $this->box_settings[$preset] = $settings;
                
                if ( $settings['default'] === true && $this->get_default_box() !== $preset ) {
                    $this->change_default_box($preset);
                }

                update_option('tweetdis_box', $this->box_settings);
        }
            
        /**
         * Save author data
         * 
         * @param array $author Author data to save
         */
        private function save_author_settings_to_db($author) {
            
                $this->tweet_author = $author;
                update_option('tweetdis_tweet_author', $this->tweet_author);
            
        }
        
        /**
         * Save hint settings
         * 
         * @param array $settings Settings to save
         */
        private function save_hint_settings_to_db($settings) {
            
                $this->hint_settings = $settings;
                update_option('tweetdis_hint', $this->hint_settings);
        }
        
        /**
         * Save image settings
         * 
         * @param string $template Template to update
         * @param array $settings Settings to save
         */
        private function save_image_settings_to_db($template, $settings) {

                $this->image_settings[$template] = $settings;
                
                if ( $this->get_default_image() !== $template ) {
                    $this->change_default_image($template);
                }

                update_option('tweetdis_image', $this->image_settings);
        }
        
        /**
         * Save tweet settings
         * 
         * @param array $settings Settings to save
         */
        private function save_tweet_settings_to_db($settings) {
            
                $this->tweet_settings = $settings;
                update_option('tweetdis_tweet_settings', $this->tweet_settings);
            
        }
        
        /**
         * Set plugin status
         * 
         * @param array Status parameters
         */
        private function update_status($status_params) {
            
                update_option('tweetdis_rinfo', $status_params);
            
        }
        
}
