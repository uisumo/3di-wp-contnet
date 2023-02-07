<?php

/**
 * The admin-specific functionality of the plugin.
 *
 * @package    tweetdis
 * @subpackage tweetdis/admin
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 */
class Tweetdis_Admin {

	/**
	 * The ID of this plugin.
	 *
	 * @var      string    $plugin_name    The ID of this plugin.
	 */
	private $plugin_name;

	/**
	 * The version of this plugin.
	 *
	 * @var      string    $version    The current version of this plugin.
	 */
	private $version;
        
        /**
         * Plugin settings
         * 
         * @var Tweetdis_Settings 
         */
        private $settings;
        
        /**
         * Plugin connector
         *
         * @var Tweetdis_Connector 
         */
        private $connector;

        /**
	 * Initialize the class and set its properties.
	 *
	 * @param      string    $plugin_name       The name of this plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version = $version;
                $this->settings = Tweetdis_Settings::get_instance();
                $this->connector = Tweetdis_Connect::get_instance();

	}

        /**
	 * Register stylesheets and scripts for the admin area
	 */
	public function register_styles_and_scripts() {

		wp_register_style( $this->plugin_name . '-admin', plugin_dir_url( __FILE__ ) . 'tweetdis-admin.min.css', array(), $this->version );
                wp_register_style($this->plugin_name . '-modal', plugin_dir_url( __FILE__ ) . 'tweetdis-mce.min.css', array(), $this->version );

                wp_register_script($this->plugin_name . '-admin', plugin_dir_url( __FILE__ ) . 'tweetdis-admin.min.js', array('jquery'), $this->version, true);

	}
        
        
	/**
	 * Enqueue the stylesheet for the admin area
	 */
	public function enqueue_style() {

		wp_enqueue_style( $this->plugin_name . '-admin' );

	}
        
        /**
         * Enqueue the stylesheet for modal in tiny mce editor
         */
        public function enqueue_tinymce_style() {

                // Get current screen and determine if we are using the editor
                $screen = get_current_screen();

                if ( $screen->id == 'page' || $screen->base == 'post' ) {
                    wp_enqueue_style($this->plugin_name . '-modal');
                }
        }
        
	/**
	 * Enqueue JavaScript for the admin area
	 */
	public function enqueue_scripts() {
            
                wp_enqueue_media();
                wp_localize_script( $this->plugin_name . '-admin', 'Td_Ajax', array('ajaxurl' => admin_url('admin-ajax.php') ) );
                wp_enqueue_script( $this->plugin_name . '-admin' );

	}
        
        /**
         * Add plugin menu
         */
        public function add_menu() {
            
                add_menu_page('Tweet Dis', 'Tweet Dis', 'edit_pages', $this->plugin_name . '-menu', array($this, 'show_settings'), $this->settings->get_images_url() . 'icon.png');

                add_submenu_page($this->plugin_name . '-menu', 'Tweet Dis Settings', 'Settings', 'manage_options', $this->plugin_name . '-menu');
                add_submenu_page($this->plugin_name . '-menu', 'Tweet Dis Affiliates', 'Affiliates', 'manage_options', $this->plugin_name . '-affiliates', array($this, 'show_affiliates'));

        }
        
        /**
         * Add tweetdis button with its functions to tiny mce editor
         */
        public function add_tweetdis_mce_button() {
                
                // check user permissions
                if ( !current_user_can( 'edit_posts' ) && !current_user_can( 'edit_pages' ) ) {
                    return;
                }

                // check if WYSIWYG is enabled
                if ( true == get_user_option('rich_editing') ) {

                    add_filter( 'mce_external_plugins', array($this, 'add_tweetdis_tinymce_plugin') );
                    add_filter( 'mce_buttons', array($this, 'register_tweetdis_mce_button') );

                }
            
        }
        
        /**
         * Add plugin to tiny mce plugins
         * 
         * @param array $plugin_array
         * @return array
         */
        public function add_tweetdis_tinymce_plugin($plugin_array) {

                $plugin_array['tweetdis'] = plugin_dir_url(__FILE__) . 'tweetdis-mce.min.js';
                return $plugin_array;
            
        }
        
        /**
         * Add button to tiny mce buttons
         * 
         * @param array $buttons
         * @return array
         */
        public function register_tweetdis_mce_button($buttons) {
            
                array_push($buttons, 'tweetdis');
                return $buttons;
            
        }
        
        /**
         * Show settings page
         */
        public function show_settings() {
            
                $this->enqueue_style();
                $this->enqueue_scripts();
                include_once 'view/page-settings.php';
            
        }
        
        /**
         * Show affiliates page
         */
        public function show_affiliates() {
            
                $this->enqueue_style();
                include_once 'view/page-affiliates.php';
            
        }
        
        /**
         * Get preview for settings tabs
         */
        public function get_preview() {

                if (!isset($_POST['tabs'])) {
                    die();
                }
            
                if ($_POST['tabs'] === 'hint') {

                    $settings = $this->settings->get_hint_settings();
                    include_once 'view/hint-tab.php';

                }
                else if ($_POST['tabs'] === 'image') {

                    $settings = $this->get_image_preview_settings();
                    include_once 'view/image-tab.php';

                }
                else if ($_POST['tabs'] === 'tweet') {

                    $settings = $this->settings->get_tweet_settings();
                    include_once 'view/tweet-tab.php';

                }
                else {

                    $settings = $this->get_box_preview_settings();
                    $params = $this->get_box_preview_params();
                    include_once 'view/box-tab.php';

                }

                die();
        }
        
        /**
         *  Save settings
         */
        public function save_settings() {
            
                if ( !isset($_POST['tabs']) ) {
                    echo 'Error, please try again';
                    die();
                }

                $result = false;

                if ($_POST['tabs'] === 'box') {
                    $result = $this->settings->save_box_settings();
                }
                else if ($_POST['tabs'] === 'hint') {
                    $result = $this->settings->save_hint_settings();
                }
                else if ($_POST['tabs'] === 'image') {
                    $result = $this->settings->save_image_settings();
                }
                else if ($_POST['tabs'] === 'tweet') {
                    $result = $this->settings->save_tweet_settings();
                }


                if ($result) {
                    echo 'Saved';
                }
                else {
                    echo 'Error, please try again';
                }

                die();
        }
        
        /**
         * Set Bit.ly token
         */
        public function set_bitly_token() {
            
                if (isset($_POST['bitly_login']) && isset ($_POST['bitly_password'])) {

                    $login = strip_tags(stripslashes($_POST['bitly_login']));
                    $password = strip_tags(stripslashes($_POST['bitly_password']));
                    echo Tweetdis_Connect::get_instance()->get_bitly_token($login, $password);

                }
                else {            
                    echo json_encode( array('error'=>'Please enter your Bit Ly credentials and try again') );
                }
                die();

        }
        
        /**
         * Get box preset settings for preview
         * 
         * @return array Array of box preset settings
         */
        private function get_box_preview_settings() {

                $design = ( isset($_POST['design']) )? $_POST['design'] : $this->settings->get_default_box();
                $settings = $this->settings->get_box_settings($design);

                return $settings;
            
        }
        
        /**
         * Get box preview parameters 'design', 'author', 'author_pic'
         * 
         * @return type
         */
        private function get_box_preview_params() {
            
                $params['design'] = isset($_POST['design'])? $_POST['design']: $this->settings->get_default_box();
                $params['author'] = isset($_POST['author'])? strip_tags ( stripslashes($_POST['author']) ) : $this->settings->get_tweet_author('author');
                $params['author_pic'] = isset($_POST['author_pic'])? strip_tags ( stripslashes($_POST['author_pic']) ) : $this->settings->get_tweet_author('author_pic');

                return $params;
            
        }
        
        /**
         * Get image template settings for preview
         * 
         * @return array Array of image template settings
         */
        private function get_image_preview_settings() {

                $design = ( isset($_POST['design']) )? $_POST['design'] : $this->settings->get_default_image();
                $settings = $this->settings->get_image_settings($design);
                $settings['design'] = $design;
                
                return $settings;
            
        }
    
}