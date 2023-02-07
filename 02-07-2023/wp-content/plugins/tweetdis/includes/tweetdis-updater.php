<?php
/**
 * Plugin updater
 *
 * @package    tweetdis
 * @subpackage tweetdis/includes
 *
 * This class looks for updates and installs them
 *
 */
class Tweetdis_Updater {
    
    /**
     * The plugin current version
     * @var string
     */
    public $current_version;
 
    /**
     * The plugin remote update path
     * @var string
     */
    public $update_path;
 
    /**
     * Plugin Slug (plugin_directory/plugin_file.php)
     * @var string
     */
    public $plugin_slug;
 
    /**
     * Plugin name (plugin_file)
     * @var string
     */
    public $slug;
    
    /**
     * Plugin key
     * 
     * @var string 
     */
    private $key;
 
    /**
     * Initialize a new instance of the WordPress Auto-Update class
     * @param string $current_version
     * @param string $update_path
     * @param string $plugin_slug
     */
    function __construct($current_version, $update_path, $plugin_slug) {
        
            // Set the class public variables
            $this->current_version = $current_version;
            $this->update_path = $update_path;
            $this->plugin_slug = $plugin_slug;
            list ($t1, $t2) = explode('/', $plugin_slug);
            $this->slug = str_replace('.php', '', $t2);

            // Define the alternative API for updating checking
            add_filter('pre_set_site_transient_update_plugins', array(&$this, 'check_update'));

            // Define the alternative response for information checking
            add_filter('plugins_api', array(&$this, 'check_info'), 10, 3);
            
            $status = json_decode(get_option('tweetdis_rinfo'), true);
            $this->key = $status['code'];
            
    }
 
    /**
     * Add our self-hosted autoupdate plugin to the filter transient
     *
     * @param $transient
     * @return object $transient
     */
    public function check_update($transient) {
        
            if (empty($transient->checked)) {
                return $transient;
            }

            // Get the remote version
            $remote_version = $this->getRemote_version();

            // If a newer version is available, add the update
            if (version_compare($this->current_version, $remote_version, '<')) {
                $obj = new stdClass();
                $obj->slug = $this->slug;
                $obj->new_version = $remote_version;
                $obj->url = $this->update_path;
                $obj->package = $this->update_path;
                $transient->response[$this->plugin_slug] = $obj;
            }
            
            return $transient;
    }
 
    /**
     * Add our self-hosted description to the filter
     *
     * @param boolean $false
     * @param array $action
     * @param object $arg
     * @return bool|object
     */
    public function check_info($false, $action, $arg) {
        
            if ( isset($arg->slug) && $arg->slug === $this->slug) {
                $information = $this->getRemote_information();
                return $information;
            }
            return $false;
    }
 
    /**
     * Return the remote version
     * 
     * @return string $remote_version
     */
    public function getRemote_version()
    {
        $request = wp_remote_post($this->update_path, array('body' => array('action' => 'version', 'key' => $this->key)));
        if (!is_wp_error($request) || wp_remote_retrieve_response_code($request) === 200) {
            return $this->analyze_response($request['body']);
        }
        return false;
    }
 
    /**
     * Get information about the remote version
     * 
     * @return bool|object
     */
    public function getRemote_information()
    {
        $request = wp_remote_post($this->update_path, array('body' => array('action' => 'info', 'key' => $this->key)));
        if (!is_wp_error($request) || wp_remote_retrieve_response_code($request) === 200) {
            return $this->analyze_response($request['body'], true);
        }
        return false;
    }
 
    /**
     * Return the status of the plugin licensing
     * 
     * @return boolean $remote_license
     */
    public function getRemote_license()
    {
        $request = wp_remote_post($this->update_path, array('body' => array('action' => 'license', 'key' => $this->key)));
        if (!is_wp_error($request) || wp_remote_retrieve_response_code($request) === 200) {
            return $this->analyze_response($request['body']);
        }
        return false;
    }
    
    /**
     * Analyze server response
     * 
     * @param string $response_body
     * @param bool $unserialize
     * @return boolean|string
     */
    private function analyze_response($response_body, $unserialize = false) {
        if ($response_body === '') {
            $status = update_option('tweetdis_rinfo', json_encode(array('code' => '', 'domain' => get_site_url(), 'activated' => false)) );
            return false;
        }
        
        if ($unserialize) {
            return unserialize($response_body);
        }
        
        return $response_body;
    }
}