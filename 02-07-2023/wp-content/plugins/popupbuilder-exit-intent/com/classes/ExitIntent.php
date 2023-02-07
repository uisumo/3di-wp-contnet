<?php
namespace sgpbex;
use \SgpbPopupExtensionRegister;
use \SGPBExitIntentConfig;

class ExitIntent
{
	private static $instance = null;
	private $actions;

	private function __construct()
	{
		$this->init();
	}

	private function __clone()
	{

	}

	public static function getInstance()
	{
		if(!isset(self::$instance)) {
			self::$instance = new ExitIntent();
		}

		return self::$instance;
	}

	public function init()
	{
		$this->includeFiles();
		add_action('init', array($this, 'wpInit'), 1);
		$this->registerHooks();
	}

	public function includeFiles()
	{
		require_once(SGPB_EXIT_INTENT_HELPERS.'DefaultOptionsData.php');
		require_once(SGPB_EXIT_INTENT_CLASSES_PATH.'Actions.php');
	}

	public function wpInit()
	{
		SGPBExitIntentConfig::addDefine('SG_VERSION_POPUP_EXIT_INTENT', '2.7');
		$this->actions = new Actions();
	}

	private function registerHooks()
	{
		register_activation_hook(SGPB_EXIT_INTENT_FILE_NAME, array($this, 'activate'));
		register_deactivation_hook(SGPB_EXIT_INTENT_FILE_NAME, array($this, 'deactivate'));
	}

	public function activate()
	{
		if (!defined('SG_POPUP_EXTENSION_PATH')) {
			$message = __('To enable Popup Builder Exit Intent extension you need to activate Popup Builder plugin', SGPB_EXIT_INTENT_TEXT_DOMAIN).'.';
			echo $message;
			wp_die();
		}
		require_once(SG_POPUP_EXTENSION_PATH.'SgpbPopupExtensionRegister.php');
		$pluginName = SGPB_EXIT_INTENT_FILE_NAME;
		$classPath = SGPB_EXIT_INTENT_DYNAMIC_CLASS_PATH.SGPB_EXIT_INTENT_EXTENSION_FILE_NAME;
		$className = SGPB_EXIT_INTENT_EXTENSION_CLASS_NAME;

		$options = array(
			'licence' => array(
				'key' => SGPB_EXIT_INTENT_KEY,
				'storeURL' => SGPB_EXIT_INTENT_STORE_URL,
				'file' => SGPB_EXIT_INTENT_FILE_NAME,
				'itemId' => SGPB_EXIT_INTENT_ITEM_ID,
				'itemName' => __('Popup Builder Exit intent', SG_POPUP_TEXT_DOMAIN),
				'autor' => SGPB_EXIT_INTENT_AUTHOR,
				'boxLabel' => __('Popup Builder Exit Intent License', SG_POPUP_TEXT_DOMAIN)
			)
		);

		SgpbPopupExtensionRegister::register($pluginName, $classPath, $className, $options);
	}

	public function deactivate()
	{
		if (!file_exists(SG_POPUP_EXTENSION_PATH.'SgpbPopupExtensionRegister.php')) {
			return false;
		}
		require_once(SG_POPUP_EXTENSION_PATH.'SgpbPopupExtensionRegister.php');
		$pluginName = SGPB_EXIT_INTENT_FILE_NAME;
		// remove exit intent extension from registered extensions
		SgpbPopupExtensionRegister::remove($pluginName);

		return true;
	}
}

ExitIntent::getInstance();
