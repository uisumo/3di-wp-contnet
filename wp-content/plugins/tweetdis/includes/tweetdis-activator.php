<?php

/**
 * Fired during plugin activation
 *
 * @package    tweetdis
 * @subpackage tweetdis/includes
 *
 * This class defines all code necessary to run during the plugin's activation.
 * 
 */
class Tweetdis_Activator {
    
        /**
         * Main activation function 
         */
        public static function activate() {
            
                self::check_options();
                self::check_tables();

                if (get_option('tweetdis_version_upgrade')) {
                        self::delete_options();
                        self::drop_tables();
                }
                
        }

        /**
         * Check if all plugin options exist
         */
        private static function check_options() {

                if (!get_option('tweetdis_hint')) {
                    add_option('tweetdis_hint', array(
                            'style' => 'background',
                            'color' => 1
                    ));
                }

                if (!get_option('tweetdis_box')) {
                    $box_styles = self::set_box_styles();
                    add_option('tweetdis_box', $box_styles);
                }
                
                if (!get_option('tweetdis_image')) {
                    $image_styles = self::set_image_styles();
                    add_option('tweetdis_image', $image_styles);
                }
                
                if (!get_option('tweetdis_tweet_author')) {
                    add_option('tweetdis_tweet_author', array(
                            'author' => 'Tim Soulo',
                            'author_pic' => plugin_dir_url( dirname( __FILE__ ) ) . 'assets/images/timface.jpeg'
                    ));
                }

                if (!get_option('tweetdis_tweet_settings')) {
                    add_option('tweetdis_tweet_settings', array(
                        'twitter' => '',
                        'follow' => '',
                        'preposition' => 'none',
                        'shortener' => 'raw',
                        'bitly_account' => '',
                        'bitly_token' => false                  
                    ));
                }
            
        }
        
        /**
         * Set initial box presets
         * 
         * @return array Preset settings
         */
        private static function set_box_styles() {
                
                $styles = array();
                
                $default_callforaction = 'Click to tweet';
                $color_settings = array (
                        array('#e5e5e5', '#eff1e5', '#9cccec'),
                        array('#ffffff', '#eff1e5', '#f7f7f7'),
                        array('#f7f7f7', '#e9e0d6', '#efefef'),
                        array('#aed4ee', '#fcc4af', '#fde7ac'),
                        array('#4ac5e6', '#c3d7df', '#e2d893')
                );
                
                for ($i = 1; $i < 17; $i++) {
                    
                    $box_number = ($i<10)? '0'.$i : $i;
                    $is_authority = ($i>11)? '_at' : '';
                    $key = 'box_' . $box_number . $is_authority;
          
                    $default = ($i === 1)? true:false;
                    $colors = array();
                    if ($i < 6) {
                        $colors = $color_settings[$i-1];
                    }
                    $value = self::get_box_settings_array($default_callforaction, $colors, 0, $default);
                    
                    $styles[$key] = $value; 
                }

                return $styles;
                
        }
        
        /**
         * Get box preset settings array
         * 
         * @param string $callforaction Tweet action text
         * @param array $colors Box color settings
         * @param int $color_number Default color setting number
         * @param bool $default Is this box preset default
         * @return array Settings
         */
        private static function get_box_settings_array( $callforaction, $colors, $color_number, $default ) {
            
                return array(
                    'callforaction' => $callforaction, 
                    'font_size' => 'original',
                    'colors' => $colors, 
                    'color_number' => $color_number, 
                    'margin_vertical' => 'default', 
                    'default' => $default
                );
            
        }
        
        /**
         * Set initial image presets
         * 
         * @return array Preset settings
         */
        private static function set_image_styles() {
                
                $styles = array();
                
                $default_callforaction = 'Tweet';
                
                for ($i = 1; $i < 7; $i++) {
                    
                        $key = 'template_' . $i;

                        if ($i !== 1) {
                            $position = 'left';
                            $default = false;
                        }
                        else {
                            $position = 'center';
                            $default = true;
                        }

                        $value = self::get_image_settings_array($default_callforaction, $position, $default);
                        $styles[$key] = $value; 
                        
                }

                return $styles;
        }
        
        /**
         * Get image preset settings array
         * 
         * @param string $callforaction Tweet action text
         * @param string $position Button position
         * @param bool $default Is this box preset default
         * @return array Settings
         */
        private static function get_image_settings_array( $callforaction, $position, $default ) {
            
                return array(
                    'hover_action' => 'original',
                    'image_txt' => 'blank',
                    'position' => $position,
                    'button_size' => 'original',
                    'callforaction' => $callforaction,  
                    'default' => $default
                );
            
        }
        
        /**
         * Create plugin table if not exists
         * 
         * @global $wpdb
         */
        private static function check_tables() {
            
                global $wpdb;
                $table_list_images = $wpdb->prefix . "tweetdis_list_img";

                $sql = "CREATE TABLE IF NOT EXISTS `" . $table_list_images ."` (
                  `id` int(11) NOT NULL AUTO_INCREMENT,
                  `img_src` varchar(500) NOT NULL,
                  `tweet_src` varchar(100) NOT NULL,
                  PRIMARY KEY (`id`)
                  ) DEFAULT CHARSET=utf8;";

                require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
                dbDelta($sql);
            
        }
        
        /**
         * Drops deprecated tables
         * 
         * @global $wpdb $wpdb
         */
        private static function drop_tables() {
            
                global $wpdb;
                $tables = array('tweetdis_seting_tabs', 'tweetdis', 'tweetdis_setings', 'tweetdis_setings_img', 'tweetdis_setting_tabs');
                foreach ($tables as $table) {
                        $table = $wpdb->prefix . $table;
                        $wpdb->query( "DROP TABLE IF EXISTS `" . $table ."`" );
                }
            
        }
        
        /**
         * Removes deprecated options
         */
        private static function delete_options() {
            
                delete_option('tweetdis_version_upgrade');
                delete_option('tweetdis_author');
                delete_option('tweetdis_pic_url');
            
        }

}