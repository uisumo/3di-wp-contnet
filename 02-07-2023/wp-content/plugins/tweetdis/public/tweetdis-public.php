<?php

/**
 * The public-facing functionality of the plugin.
 *
 * @package    tweetdis
 * @subpackage tweetdis/includes
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet.
 *
 */
class Tweetdis_Public {

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
	 * Initialize the class and set its properties.
	 *
	 * @param      string    $plugin_name       The name of the plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version = $version;

	}

	/**
	 * Register the stylesheet for the public-facing side of the site
	 */
	public function register_style() {

		wp_register_style( $this->plugin_name . '-public', plugin_dir_url( __FILE__ ) . 'tweetdis-public.min.css', array(), $this->version );
                
	}
        
        /**
	 * Enqueue public stylesheet
	 */
	public function enqueue_style() {

                wp_enqueue_style( $this->plugin_name . '-public');
                
	}
        
        /**
         * Handle shortcode actions
         * 
         * @param type $atts
         * @param string $text
         * @param string $shortcode
         * @return string HTML
         */
        public function do_shortcodes ($atts, $text = "", $shortcode = "") {

                $entity = null;

                switch ($shortcode) {
                    case 'tweet_dis':
                        $entity = new Tweetdis_Hint( $text, $atts, $shortcode );
                        break;
                    case 'tweet_box':
                        $entity = new Tweetdis_Box( $text, $atts, $shortcode );
                        break;
                    case 'tweet_dis_img':
                        $entity = new Tweetdis_Image( $text, $atts, $shortcode );
                        break;
                    default: 
                        return;
                }
                
                $this->enqueue_style();
                return $entity->display();

        }

}
