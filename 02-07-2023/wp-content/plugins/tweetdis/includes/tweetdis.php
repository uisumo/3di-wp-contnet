<?php

/**
 * The file that defines the core plugin class
 *
 * A class definition that includes attributes and functions used across both the
 * public-facing side of the site and the admin area.
 *
 * @package    tweetdis
 * @subpackage tweetdis/includes
 */

/**
 * The core plugin class.
 *
 * This is used to define internationalization, admin-specific hooks, and
 * public-facing site hooks.
 *
 * Also maintains the unique identifier of this plugin as well as the current
 * version of the plugin.
 *
 */
class Tweetdis {

	/**
	 * The loader that's responsible for maintaining and registering all hooks that power
	 * the plugin.
	 *
	 * @var      Tweetdis_Loader    $loader    Maintains and registers all hooks for the plugin.
	 */
	protected $loader;

	/**
	 * The unique identifier of this plugin.
	 *
	 * @var      string    $plugin_name    The string used to uniquely identify this plugin.
	 */
	protected $plugin_name;
        
        /**
         * Plugin Slug (plugin_directory/plugin_file.php)
	 *
	 * @var      string    $plugin_slug    Plugin Slug
	 */
	protected $plugin_slug;

	/**
	 * The current version of the plugin.
	 *
	 * @var      string    $version    The current version of the plugin.
	 */
	protected $version;
        
        /**
	 * Plugin update path
	 *
	 * @var      string    $update_path    Path for updates.
	 */
	protected $update_path;

	/**
	 * Define the core functionality of the plugin.
	 *
	 * Set the plugin name and the plugin version that can be used throughout the plugin.
	 * Load the dependencies, define the locale, and set the hooks for the admin area and
	 * the public-facing side of the site.
	 *
	 */
	public function __construct($plugin_slug, $version) {

		$this->plugin_name = 'tweetdis';
		$this->version = $version;
                $this->update_path = 'http://tweetdis.com/update.php';
                $this->plugin_slug = $plugin_slug;

		$this->load_dependencies();
                $this->check_for_updates();
		//$this->set_locale();
		$this->define_admin_hooks();
		$this->define_public_hooks();

	}

	/**
	 * Load the required dependencies for this plugin
	 *
	 * - Tweetdis_Loader. Orchestrates the hooks of the plugin.
	 * - Tweetdis_i18n. Defines internationalization functionality.
         * - Tweetdis_Updater. Updates the plugin.
         * - Tweetdis_Settings. Manages plugin settings.
         * - Tweetdis_Connect. Makes remote requests.
         * - Tweetdis_Entity. Base class for plugin entities
         * - Tweetdis_Hint. Manages hint creation.
         * - Tweetdis_Box. Manages box creation.
         * - Tweetdis_Image. Manages image creation.
	 * - Tweetdis_Admin. Defines all hooks for the admin area.
	 * - Tweetdis_Public. Defines all hooks for the public side of the site.
	 *
	 * Create an instance of the loader which will be used to register the hooks
	 * with WordPress.
	 *
	 */
	private function load_dependencies() {

		/**
		 * The class responsible for orchestrating the actions and filters of the
		 * core plugin.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/tweetdis-loader.php';

		/**
		 * The class responsible for defining internationalization functionality
		 * of the plugin.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/tweetdis-i18n.php';
                
                /**
                 * The class that updates the plugin
                 */
                require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/tweetdis-updater.php';
                
                /**
                 * The class that manages plugin settings
                 */
                require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/tweetdis-settings.php';
                
                /**
                 * The class that makes remote requests
                 */
                require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/tweetdis-connect.php';

                /**
                 * The base class for twitter entities
                 */
                require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/tweetdis-entity.php';
                
                /**
                 * The class that manages tweetable hints
                 */
                require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/entities/tweetdis-hint.php';
                
                /**
                 * The class that manages tweetable boxes
                 */
                require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/entities/tweetdis-box.php';
               
                /**
                 * The class that manages tweetable images
                 */
                require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/entities/tweetdis-image.php';

		/**
		 * The class responsible for defining all actions that occur in the admin area.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'admin/tweetdis-admin.php';

		/**
		 * The class responsible for defining all actions that occur in the public-facing
		 * side of the site.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'public/tweetdis-public.php';

		$this->loader = new Tweetdis_Loader();

	}
        
        /**
         * Instantiate the class that looks for updates
         */
        private function check_for_updates() {
            new Tweetdis_Updater($this->version, $this->update_path, $this->plugin_slug);
        }

        /**
	 * Define the locale for this plugin for internationalization.
	 *
	 * Uses the Tweetdis_i18n class in order to set the domain and to register the hook
	 * with WordPress.
	 *
	 */
	private function set_locale() {

		$plugin_i18n = new Tweetdis_i18n();
		$plugin_i18n->set_domain( $this->get_plugin_name() );

		$this->loader->add_action( 'plugins_loaded', $plugin_i18n, 'load_plugin_textdomain' );

	}

	/**
	 * Register all of the hooks related to the admin area functionality
	 * of the plugin.
	 *
	 */
	private function define_admin_hooks() {
            
		$plugin_admin = new Tweetdis_Admin( $this->get_plugin_name(), $this->get_version() );

                $this->loader->add_action( 'init', $plugin_admin, 'add_tweetdis_mce_button' );
                $this->loader->add_action( 'admin_menu', $plugin_admin, 'add_menu' );
            
		$this->loader->add_action( 'admin_enqueue_scripts', $plugin_admin, 'register_styles_and_scripts' );
                $this->loader->add_action( 'admin_print_styles', $plugin_admin, 'enqueue_tinymce_style' );
                
                $this->loader->add_action( 'wp_ajax_tweetdis_get_preview', $plugin_admin, 'get_preview' );
                $this->loader->add_action( 'wp_ajax_tweetdis_save_settings', $plugin_admin, 'save_settings' );
                $this->loader->add_action( 'wp_ajax_tweetdis_bitly_token', $plugin_admin, 'set_bitly_token' );
	}

	/**
	 * Register all of the hooks related to the public-facing functionality
	 * of the plugin.
	 *
	 */
	private function define_public_hooks() {

		$plugin_public = new Tweetdis_Public( $this->get_plugin_name(), $this->get_version() );

		$this->loader->add_action( 'wp_enqueue_scripts', $plugin_public, 'register_style' );
                
                $this->loader->add_shortcode('tweet_dis', $plugin_public, 'do_shortcodes');
                $this->loader->add_shortcode('tweet_box', $plugin_public, 'do_shortcodes');
                $this->loader->add_shortcode('tweet_dis_img', $plugin_public, 'do_shortcodes');

	}

	/**
	 * Run the loader to execute all of the hooks with WordPress.
	 *
	 */
	public function run() {
		$this->loader->run();
	}

	/**
	 * The name of the plugin used to uniquely identify it within the context of
	 * WordPress and to define internationalization functionality.
	 *
	 * @return    string    The name of the plugin.
	 */
	public function get_plugin_name() {
		return $this->plugin_name;
	}

	/**
	 * Retrieve the version number of the plugin.
	 *
	 * @return    string    The version number of the plugin.
	 */
	public function get_version() {
		return $this->version;
	}

}