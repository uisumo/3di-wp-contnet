<?php
/**
 * Plugin Name: LearnDash LMS
 * Plugin URI: http://www.learndash.com
 * Description: LearnDash LMS Plugin - Turn your WordPress site into a learning management system.
 * Version: 3.3.0.3
 * Author: LearnDash
 * Author URI: http://www.learndash.com
 * Text Domain: learndash
 * Doman Path: /languages/
 *
 * @since 2.1.0
 *
 * @package LearnDash
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * LearnDash Version Constant
 */
define( 'LEARNDASH_VERSION', '3.3.0.3' );
define( 'LEARNDASH_SETTINGS_DB_VERSION', '2.5' );
define( 'LEARNDASH_SETTINGS_TRIGGER_UPGRADE_VERSION', '2.5' );
define( 'LEARNDASH_LMS_TEXT_DOMAIN', 'learndash' );

/**
 * Define minimum versions for PHP and MySQL
 *
 * @since 3.3.0.2
 */
define( 'LEARNDASH_MIN_PHP_VERSION', '7.3' );
define( 'LEARNDASH_MIN_MYSQL_VERSION', '5.6' );

if ( ! defined( 'LEARNDASH_LMS_PLUGIN_DIR' ) ) {
	define( 'LEARNDASH_LMS_PLUGIN_DIR', trailingslashit( str_replace( '\\', '/', WP_PLUGIN_DIR ) . '/' . basename( dirname( __FILE__ ) ) ) );
}
if ( ! defined( 'LEARNDASH_LMS_PLUGIN_URL' ) ) {
	$learndash_plugin_url = trailingslashit( WP_PLUGIN_URL . '/' . basename( dirname( __FILE__ ) ) );
	$learndash_plugin_url = str_replace( array( 'https://', 'http://' ), array( '//', '//' ), $learndash_plugin_url );
	define( 'LEARNDASH_LMS_PLUGIN_URL', $learndash_plugin_url );
}

if ( ! defined( 'LEARNDASH_LMS_LIBRARY_DIR' ) ) {
	define( 'LEARNDASH_LMS_LIBRARY_DIR', trailingslashit( LEARNDASH_LMS_PLUGIN_DIR ) . 'includes/lib' );
}

if ( ! defined( 'LEARNDASH_LMS_LIBRARY_URL' ) ) {
	define( 'LEARNDASH_LMS_LIBRARY_URL', trailingslashit( LEARNDASH_LMS_PLUGIN_URL ) . 'includes/lib' );
}

if ( ! defined( 'LEARNDASH_LMS_PLUGIN_KEY' ) ) {
	$learndash_plugin_dir = LEARNDASH_LMS_PLUGIN_DIR;
	$learndash_plugin_dir = basename( $learndash_plugin_dir ) . '/' . basename( __FILE__ );
	define( 'LEARNDASH_LMS_PLUGIN_KEY', $learndash_plugin_dir );
}

if ( ! defined( 'LEARNDASH_TRANSIENTS_DISABLED' ) ) {
	define( 'LEARNDASH_TRANSIENTS_DISABLED', false );
}

if ( ! defined( 'LEARNDASH_DEBUG' ) ) {
	define( 'LEARNDASH_DEBUG', false );
}

// If the WordPress 'SCRIPT_DEBUG' is set then we also set our 'LEARNDASH_SCRIPT_DEBUG' so we are serving non-minified scripts.
if ( ! defined( 'LEARNDASH_SCRIPT_DEBUG' ) ) {
	if ( ( defined( 'SCRIPT_DEBUG' ) ) && ( SCRIPT_DEBUG === true ) ) {
		define( 'LEARNDASH_SCRIPT_DEBUG', true );
	} else {
		define( 'LEARNDASH_SCRIPT_DEBUG', false );
	}
}

if ( ! defined( 'LEARNDASH_BUILDER_DEBUG' ) ) {
	define( 'LEARNDASH_BUILDER_DEBUG', false );
}

/**
 * Controls the method used to updte the builder step.
 *
 * If defined 'true' will use the wp_update_post() method
 * else will use the default wpdb::update() and clean_post_cache().
 *
 * @since 3.2.3
 */
if ( ! defined( 'LEARNDASH_BUILDER_STEPS_UPDATE_POST' ) ) {
	define( 'LEARNDASH_BUILDER_STEPS_UPDATE_POST', false );
}

if ( ! defined( 'LEARNDASH_SCRIPT_VERSION_TOKEN' ) ) {
	if ( defined( 'LEARNDASH_SCRIPT_DEBUG' ) && ( LEARNDASH_SCRIPT_DEBUG === true ) ) {
		define( 'LEARNDASH_SCRIPT_VERSION_TOKEN', LEARNDASH_VERSION . '-' . time() );

	} else {
		define( 'LEARNDASH_SCRIPT_VERSION_TOKEN', LEARNDASH_VERSION );
	}
}

/**
 * The priority when LearnDash hooks into the WordPress filter
 * 'the_content' for the main course posts.
 * @since 3.1.4
 */
if ( ! defined( 'LEARNDASH_FILTER_PRIORITY_THE_CONTENT' ) ) {
	define( 'LEARNDASH_FILTER_PRIORITY_THE_CONTENT', 30 );
}

/**
 * Added to support REST API.
 * @since 2.5.8.
 */
if ( ! defined( 'LEARNDASH_REST_API_ENABLED' ) ) {
	define( 'LEARNDASH_REST_API_ENABLED', true );
}

/**
 * Block access to default WordPress CPT routes.
 * @since 3.2.0
 */
if ( ! defined( 'LEARNDASH_BLOCK_WORDPRESS_CPT_ROUTES' ) ) {
	define( 'LEARNDASH_BLOCK_WORDPRESS_CPT_ROUTES', true );
}

/**
 * Added to support Lesson/Topic Video Progression
 * @since 2.4.5.
 */
if ( ! defined( 'LEARNDASH_LESSON_VIDEO' ) ) {
	define( 'LEARNDASH_LESSON_VIDEO', true );
}

/**
 * Added to support Course Builder
 * @since 2.5.0.
 */
if ( ! defined( 'LEARNDASH_COURSE_BUILDER' ) ) {
	define( 'LEARNDASH_COURSE_BUILDER', true );
}

/**
 * Added to support Quiz Builder
 * @since 2.6.0.
 */
if ( ! defined( 'LEARNDASH_QUIZ_BUILDER' ) ) {
	define( 'LEARNDASH_QUIZ_BUILDER', true );
}

/**
 * Added to support Gutenberg Editor
 * @since 2.5.8.
 */
if ( ! defined( 'LEARNDASH_GUTENBERG' ) ) {
	define( 'LEARNDASH_GUTENBERG', true );
}

/**
 * Added to support Translations via GlotPress
 * @since 2.5.1.1.
 */
if ( ! defined( 'LEARNDASH_TRANSLATIONS' ) ) {
	define( 'LEARNDASH_TRANSLATIONS', true );
}

if ( ! defined( 'LEARNDASH_HTTP_REMOTE_GET_TIMEOUT' ) ) {
	define( 'LEARNDASH_HTTP_REMOTE_GET_TIMEOUT', 15 );
}

/**
 * The timeout (seconds) for the POST request.
 */
if ( ! defined( 'LEARNDASH_HTTP_REMOTE_POST_TIMEOUT' ) ) {
	define( 'LEARNDASH_HTTP_REMOTE_POST_TIMEOUT', 15 );
}
/**
 * The timeout (seconds) for BitBucket Readme download_url() request.
 *
 * @since 3.1.8
 */
if ( ! defined( 'LEARNDASH_HTTP_BITBUCKET_README_DOWNLOAD_TIMEOUT' ) ) {
	define( 'LEARNDASH_HTTP_BITBUCKET_README_DOWNLOAD_TIMEOUT', 15 );
}

/**
 * Set the number of consecutive errors before update attemps abort
 *
 * @since 3.1.8
 */
if ( defined( 'LEARNDASH_REPO_ERROR_THRESHOLD_COUNT' ) ) {
	define( 'LEARNDASH_REPO_ERROR_THRESHOLD_COUNT', 3 );
}

/**
 * Set the time (seconds) after abort before restarting tries.
 *
 * @since 3.1.8
 */
if ( defined( 'LEARNDASH_REPO_ERROR_THRESHOLD_TIME' ) ) {
	define( 'LEARNDASH_REPO_ERROR_THRESHOLD_TIME', 2 * 60 * 60 );
}

if ( ! defined( 'LEARNDASH_LMS_DEFAULT_QUESTION_POINTS' ) ) {
	define( 'LEARNDASH_LMS_DEFAULT_QUESTION_POINTS', 1 );
}

if ( ! defined( 'LEARNDASH_LMS_DEFAULT_ANSWER_POINTS' ) ) {
	define( 'LEARNDASH_LMS_DEFAULT_ANSWER_POINTS', 0 );
}

// Define the number of items to lazy load per AJAX request.
if ( ! defined( 'LEARNDASH_LMS_DEFAULT_LAZY_LOAD_PER_PAGE' ) ) {
	define( 'LEARNDASH_LMS_DEFAULT_LAZY_LOAD_PER_PAGE', 5000 );
}

// Define the number of items for Data Upgrade batch.
if ( ! defined( 'LEARNDASH_LMS_DEFAULT_DATA_UPGRADE_BATCH_SIZE' ) ) {
	define( 'LEARNDASH_LMS_DEFAULT_DATA_UPGRADE_BATCH_SIZE', 1000 );
}

// Define the default number of items per page.
if ( ! defined( 'LEARNDASH_LMS_DEFAULT_WIDGET_PER_PAGE' ) ) {
	define( 'LEARNDASH_LMS_DEFAULT_WIDGET_PER_PAGE', 20 );
}

if ( ! defined( 'LEARNDASH_LMS_DEFAULT_CB_INSERT_CHUNK_SIZE' ) ) {
	define( 'LEARNDASH_LMS_DEFAULT_CB_INSERT_CHUNK_SIZE', 10 );
}

// Define what administrator cabability to check.
if ( ! defined( 'LEARNDASH_ADMIN_CAPABILITY_CHECK' ) ) {
	define( 'LEARNDASH_ADMIN_CAPABILITY_CHECK', 'manage_options' );
}

if ( ! defined( 'LEARNDASH_GROUP_LEADER_CAPABILITY_CHECK' ) ) {
	define( 'LEARNDASH_GROUP_LEADER_CAPABILITY_CHECK', 'group_leader' );
}

if ( ! defined( 'LEARNDASH_DEFAULT_THEME' ) ) {
	define( 'LEARNDASH_DEFAULT_THEME', 'ld30' );
}

if ( ! defined( 'LEARNDASH_LEGACY_THEME' ) ) {
	define( 'LEARNDASH_LEGACY_THEME', 'legacy' );
}

if ( ! defined( 'LEARNDASH_DEFAULT_COURSE_PRICE_TYPE' ) ) {
	define( 'LEARNDASH_DEFAULT_COURSE_PRICE_TYPE', 'open' );
}
if ( ! defined( 'LEARNDASH_DEFAULT_COURSE_ORDER' ) ) {
	define( 'LEARNDASH_DEFAULT_COURSE_ORDER', 'ASC' );
}
if ( ! defined( 'LEARNDASH_DEFAULT_COURSE_ORDERBY' ) ) {
	define( 'LEARNDASH_DEFAULT_COURSE_ORDERBY', 'date' );
}

if ( ! defined( 'LEARNDASH_DEFAULT_GROUP_PRICE_TYPE' ) ) {
	define( 'LEARNDASH_DEFAULT_GROUP_PRICE_TYPE', 'closed' );
}
if ( ! defined( 'LEARNDASH_DEFAULT_GROUP_ORDER' ) ) {
	define( 'LEARNDASH_DEFAULT_GROUP_ORDER', 'ASC' );
}
if ( ! defined( 'LEARNDASH_DEFAULT_GROUP_ORDERBY' ) ) {
	define( 'LEARNDASH_DEFAULT_GROUP_ORDERBY', 'date' );
}

if ( ! defined( 'LEARNDASH_QUIZ_RESULT_MESSAGE_MAX' ) ) {
	define( 'LEARNDASH_QUIZ_RESULT_MESSAGE_MAX', 15 );
}

if ( ! defined( 'LEARNDASH_ADMIN_POPUP_STYLE' ) ) {
	define( 'LEARNDASH_ADMIN_POPUP_STYLE', 'jQuery-dialog' );
}

/**
 * Use the WP function wp_safe_redirect.
 *
 * @since 3.4.0
 */
if ( ! defined( 'LEARNDASH_USE_WP_SAFE_REDIRECT' ) ) {
	define( 'LEARNDASH_USE_WP_SAFE_REDIRECT', true );
}


if ( ! defined( 'LEARNDASH_DISABLE_TEMPLATE_CONTENT_OUTSIDE_LOOP' ) ) {
	define( 'LEARNDASH_DISABLE_TEMPLATE_CONTENT_OUTSIDE_LOOP', true );
}

/**
 * Use the User's registration for the Group enrollment time if newer
 * then the course enrollment. Default true.
 */
if ( ! defined( 'LEARNDASH_GROUP_ENROLLED_COURSE_FROM_USER_REGISTRATION' ) ) {
	define( 'LEARNDASH_GROUP_ENROLLED_COURSE_FROM_USER_REGISTRATION', true );
}


/**
 * Load the Select2 JS library.
 */
if ( ! defined( 'LEARNDASH_SELECT2_LIB' ) ) {
	define( 'LEARNDASH_SELECT2_LIB', true );
}

/**
 * Load selector data via AJAX for Select2.
 *
 * The LEARNDASH_SELECT2_LIB define must be true.
 *
 * @since 3.2.3
 */
if ( ! defined( 'LEARNDASH_SELECT2_LIB_AJAX_FETCH' ) ) {
	define( 'LEARNDASH_SELECT2_LIB_AJAX_FETCH', true );
}

/**
 * Enable legacy Post Type Setttings Metaboxes
 */
if ( ! defined( 'LEARNDASH_SETTINGS_METABOXES_LEGACY' ) ) {
	define( 'LEARNDASH_SETTINGS_METABOXES_LEGACY', true );
}

if ( ! defined( 'LEARNDASH_SETTINGS_METABOXES_LEGACY_QUIZ' ) ) {
	define( 'LEARNDASH_SETTINGS_METABOXES_LEGACY_QUIZ', false );
}

/**
 * Show new Settings Header Panel
 * default is true.
 */
if ( ! defined( 'LEARNDASH_SETTINGS_HEADER_PANEL' ) ) {
	define( 'LEARNDASH_SETTINGS_HEADER_PANEL', true );
}

/**
 * Show Mark Incomplete button.
 * default is false.
 * @since 3.1.4
 */
if ( ! defined( 'LEARNDASH_SHOW_MARK_INCOMPLETE' ) ) {
	define( 'LEARNDASH_SHOW_MARK_INCOMPLETE', false );
}

/**
 * Will filter search on front-end.
 * @since 3.17
 */
if ( ! defined( 'LEARNDASH_FILTER_SEARCH' ) ) {
	define( 'LEARNDASH_FILTER_SEARCH', true );
}

/**
 * LearnDash Database utility class.
 */
if ( ! defined( 'LEARNDASH_LMS_DATABASE_PREFIX_SUB' ) ) {
	define( 'LEARNDASH_LMS_DATABASE_PREFIX_SUB', 'learndash_' );
}
if ( ! defined( 'LEARNDASH_PROQUIZ_DATABASE_PREFIX_SUB_DEFAULT' ) ) {
	define( 'LEARNDASH_PROQUIZ_DATABASE_PREFIX_SUB_DEFAULT', 'wp_' );
}

/**
 * Controls if we should perform update and license checkes.
 *
 * @since 3.1.8
 */
if ( ! defined( 'LEARNDASH_UPDATES_ENABLED' ) ) {
	define( 'LEARNDASH_UPDATES_ENABLED', true );
}

/**
 * Added to support Add-on Update logic
 * @since 2.5.5.
 */
if ( ! defined( 'LEARNDASH_ADDONS_UPDATER' ) ) {
	if ( true === LEARNDASH_UPDATES_ENABLED ) {
		define( 'LEARNDASH_ADDONS_UPDATER', true );
	} else {
		define( 'LEARNDASH_ADDONS_UPDATER', false );
	}
}

if ( ( true === LEARNDASH_ADDONS_UPDATER ) && ( true === LEARNDASH_UPDATES_ENABLED ) ) {
	require_once dirname( __FILE__ ) . '/includes/class-ld-addons-updater.php';
} else {
	/**
	 * Added a dummy class if/when auto_update is disabled.
	 * To prevent fatal errors.
	 */
	if ( ! class_exists( 'LearnDash_Addon_Updater' ) ) {
		class LearnDash_Addon_Updater {
			protected static $instance = null;

			public static function get_instance() {
				if ( ! isset( static::$instance ) ) {
					static::$instance = new static();
				}

				return static::$instance;
			}

			public function __call( $name, $arguments ) {
				return;
			}
		}
	}
}

require_once dirname( __FILE__ ) . '/includes/class-ldlms-db.php';

/**
 * LearnDash Post Types utility class.
 */
require_once dirname( __FILE__ ) . '/includes/class-ldlms-post-types.php';

/**
 * LearnDash Transients utility class.
 */
require_once dirname( __FILE__ ) . '/includes/class-ldlms-transients.php';


/**
 * The module base class; handles settings, options, menus, metaboxes, etc.
 */
require_once dirname( __FILE__ ) . '/includes/class-ld-semper-fi-module.php';

/**
 * SFWD_LMS
 */
require_once dirname( __FILE__ ) . '/includes/class-ld-lms.php';

/**
 * Register CPT's and Taxonomies
 */
require_once dirname( __FILE__ ) . '/includes/class-ld-cpt.php';

/**
 * Search
 */
if ( ( defined( 'LEARNDASH_FILTER_SEARCH' ) ) && ( LEARNDASH_FILTER_SEARCH === true ) ) {
	require_once dirname( __FILE__ ) . '/includes/class-ld-search.php';
}

/**
 * Register CPT's and Taxonomies
 */
require_once dirname( __FILE__ ) . '/includes/class-ld-cpt-instance.php';

/**
 * LearnDash Menus and Tabs logic
 */
require_once LEARNDASH_LMS_PLUGIN_DIR . 'includes/admin/class-learndash-admin-menus-tabs.php';

/**
 * Widget loader.
 */
require_once dirname( __FILE__ ) . '/includes/widgets/widgets-loader.php';

/**
 * Course functions
 */
require_once dirname( __FILE__ ) . '/includes/course/ld-course-functions.php';

/**
 * Course navigation
 */
require_once dirname( __FILE__ ) . '/includes/course/ld-course-navigation.php';

/**
 * Course progress functions
 */
require_once dirname( __FILE__ ) . '/includes/course/ld-course-progress.php';

/**
 * Course info and navigation widgets
 */
require_once dirname( __FILE__ ) . '/includes/course/ld-course-info-widget.php';

/**
 * Course metaboxes.
 */
require_once dirname( __FILE__ ) . '/includes/course/ld-course-metaboxes.php';

/**
 * Quiz metaboxes.
 */
require_once dirname( __FILE__ ) . '/includes/quiz/ld-quiz-metaboxes.php';

/**
 * Quiz and Question functions
 */
require_once dirname( __FILE__ ) . '/includes/quiz/ld-quiz-functions.php';

/**
 * Implements WP Pro Quiz
 */
require_once dirname( __FILE__ ) . '/includes/quiz/ld-quiz-pro.php';

/**
 * Quiz migration functions
 */
require_once dirname( __FILE__ ) . '/includes/quiz/ld-quiz-migration.php';

/**
 * Quiz essay question functions
 */
require_once dirname( __FILE__ ) . '/includes/quiz/ld-quiz-essays.php';

/**
 * Load scripts & styles
 */
require_once dirname( __FILE__ ) . '/includes/ld-scripts.php';

/**
 * Customizations to wp editor for LearnDash
 */
require_once dirname( __FILE__ ) . '/includes/ld-wp-editor.php';

/**
 * Handles assignment uploads and includes helper functions for assignments
 */
require_once dirname( __FILE__ ) . '/includes/ld-assignment-uploads.php';

/**
 * Group functions
 */
require_once dirname( __FILE__ ) . '/includes/ld-groups.php';

/**
 * Group Membership functions
 */
require_once dirname( __FILE__ ) . '/includes/group/ld-groups-membership.php';

/**
 * User functions
 */
require_once dirname( __FILE__ ) . '/includes/ld-users.php';

/**
 * Certificate functions
 */
require_once dirname( __FILE__ ) . '/includes/ld-certificates.php';

/**
 * Misc functions
 */
require_once dirname( __FILE__ ) . '/includes/ld-misc-functions.php';

/**
 * WP-admin functions
 */
require_once dirname( __FILE__ ) . '/includes/admin/ld-admin.php';

/**
 * Course Builder Helpers.
 */
require_once dirname( __FILE__ ) . '/includes/admin/ld-course-builder-helpers.php';

/**
 * Quiz Builder Helpers.
 */
require_once dirname( __FILE__ ) . '/includes/admin/ld-quiz-builder-helpers.php';

/**
 * Gutenberg Customization.
 */
require_once dirname( __FILE__ ) . '/includes/admin/ld-gutenberg.php';

/**
 * LearnDash Settings Page Base
 */
require_once dirname( __FILE__ ) . '/includes/settings/settings-loader.php';

/**
 * LearnDash Shortcodes Base
 */
require_once dirname( __FILE__ ) . '/includes/shortcodes/shortcodes-loader.php';

/**
 * Custom label
 */
require_once dirname( __FILE__ ) . '/includes/class-ld-custom-label.php';

/**
 * Binary Selector
 */
require_once dirname( __FILE__ ) . '/includes/admin/class-learndash-admin-binary-selector.php';

/**
 * Data/System Upgrades
 */
require_once dirname( __FILE__ ) . '/includes/admin/class-learndash-admin-data-upgrades.php';

/**
 * Reports
 */
require_once dirname( __FILE__ ) . '/includes/admin/class-learndash-admin-settings-data-reports.php';

/**
 * Reports Functions
 */
require_once dirname( __FILE__ ) . '/includes/ld-reports.php';

/**
 * Permalinks
 */
require_once dirname( __FILE__ ) . '/includes/class-ld-permalinks.php';

/**
 * GDPR
 */
require_once dirname( __FILE__ ) . '/includes/class-ld-gdpr.php';

/**
 * Core Updater
 */
require_once dirname( __FILE__ ) . '/includes/ld-autoupdate.php';

/**
 * Addon Updater API
 */
/**
 * Controls if we should perform update and license checkes.
 *
 * @since 3.2.0
 */
if ( ! defined( 'LEARNDASH_UPDATES_ENABLED' ) ) {
	define( 'LEARNDASH_UPDATES_ENABLED', true );
}

if ( ( true === LEARNDASH_ADDONS_UPDATER ) && ( true === LEARNDASH_UPDATES_ENABLED ) ) {
	require_once dirname( __FILE__ ) . '/includes/class-ld-addons-updater.php';
} else {
	/**
	 * Added a dummy class if/when auto_update is disabled.
	 * To prevent fatal errors.
	 */
	if ( ! class_exists( 'LearnDash_Addon_Updater' ) ) {
		class LearnDash_Addon_Updater {
			protected static $instance = null;

			public static function get_instance() {
				if ( ! isset( static::$instance ) ) {
					static::$instance = new static();
				}

				return static::$instance;
			}

			public function __call( $name, $arguments ) {
				return;
			}
		}
	}
}

/**
 * Translations
 */
if ( ( defined( 'LEARNDASH_TRANSLATIONS' ) ) && ( LEARNDASH_TRANSLATIONS === true ) ) {
	require_once dirname( __FILE__ ) . '/includes/class-ld-translations.php';

	if ( ! defined( 'LEARNDASH_TRANSLATIONS_URL_BASE' ) ) {
		define( 'LEARNDASH_TRANSLATIONS_URL_BASE', 'https://translations.learndash.com' );
	}
	if ( ! defined( 'LEARNDASH_TRANSLATIONS_URL_CACHE' ) ) {
		define( 'LEARNDASH_TRANSLATIONS_URL_CACHE', DAY_IN_SECONDS );
	}
}

/**
 * Registers Shortcodes.
 */
require_once dirname( __FILE__ ) . '/includes/settings/class-ld-shortcodes-tinymce.php';

/**
 * Add Support for Themes.
 */
require_once LEARNDASH_LMS_PLUGIN_DIR . 'themes/themes-loader.php';

/**
 * Add Support for the LD LMS Post Factory.
 */
require_once LEARNDASH_LMS_PLUGIN_DIR . 'includes/classes/class-ldlms-factory-post.php';

/**
 * Registers REST API Hooks.
 */
require_once dirname( __FILE__ ) . '/includes/rest-api/class-ld-rest-api.php';

/**
 * Load our Import/Export Utilities
 */
require_once dirname( __FILE__ ) . '/includes/import/import-loader.php';

/**
 * Support for Video Progression
 */
if ( ( defined( 'LEARNDASH_LESSON_VIDEO' ) ) && ( LEARNDASH_LESSON_VIDEO === true ) ) {
	require_once dirname( __FILE__ ) . '/includes/course/ld-course-video.php';
}

/**
 * Support for Course and/or Quiz Builder
 */
require_once dirname( __FILE__ ) . '/includes/admin/class-learndash-admin-builder.php';

/**
 * Support for Gutenberg Editor
 */
if ( ( defined( 'LEARNDASH_GUTENBERG' ) ) && ( LEARNDASH_GUTENBERG === true ) ) {
	require_once dirname( __FILE__ ) . '/includes/gutenberg/index.php';
}

/**
 * LearnDash Deprecated Functions/Classes
 */
require_once dirname( __FILE__ ) . '/includes/deprecated/deprecated-functions.php';


/**
 * Globals that hold CPT's and Pages to be set up
 */
global $learndash_taxonomies, $learndash_pages, $learndash_question_types;

$learndash_taxonomies = array(
	'ld_course_category',
	'ld_course_tag',
	'ld_lesson_category',
	'ld_lesson_tag',
	'ld_topic_category',
	'ld_topic_tag',
	'ld_quiz_category',
	'ld_quiz_tag',
	'ld_question_category',
	'ld_question_tag',
	'ld_group_category',
	'ld_group_tag',
);

$learndash_pages = array(
	'group_admin_page',
	'learndash-lms-reports',
);

// This is a global variable which is set in any of the shortcode handler functions.
// The purpose is to let the plugin know when and if the any of the shortcodes were used.
global $learndash_shortcode_used;
$learndash_shortcode_used = false;

global $learndash_shortcode_atts;
$learndash_shortcode_atts = array();

/**
 * Metaboxes registered for settings pages etc.
 */
global $learndash_metaboxes;
$learndash_metaboxes = array();

global $learndash_assets_loaded;
$learndash_assets_loaded            = array();
$learndash_assets_loaded['styles']  = array();
$learndash_assets_loaded['scripts'] = array();

