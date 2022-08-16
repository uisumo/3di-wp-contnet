<?php
class SGPBExitIntentConfig
{
	public static function addDefine($name, $value)
	{
		if(!defined($name)) {
			define($name, $value);
		}
	}

	public static function init()
	{
		self::addDefine('SGPB_EXIT_INTENT_PATH', WP_PLUGIN_DIR.'/'.SGPB_EXIT_INTENT_FOLDER_NAME.'/');
		self::addDefine('SGPB_EXIT_INTENT_DYNAMIC_CLASS_PATH', SGPB_EXIT_INTENT_FOLDER_NAME.'/com/classes/');
		self::addDefine('SGPB_EXIT_INTENT_COM_PATH', SGPB_EXIT_INTENT_PATH.'com/');
		self::addDefine('SGPB_EXIT_INTENT_PUBLIC_PATH', SGPB_EXIT_INTENT_PATH.'public/');
		self::addDefine('SGPB_EXIT_INTENT_CLASSES_PATH', SGPB_EXIT_INTENT_COM_PATH.'classes/');
		self::addDefine('SGPB_EXIT_INTENT_EXTENSION_FILE_NAME', 'ExitIntentExtension.php');
		self::addDefine('SGPB_EXIT_INTENT_EXTENSION_CLASS_NAME', 'SGPBExitIntentExtension');
		self::addDefine('SGPB_EXIT_INTENT_HELPERS', SGPB_EXIT_INTENT_COM_PATH.'helpers/');
		self::addDefine('SGPB_EXIT_INTENT_PUBLIC_URL', plugins_url().'/'.SGPB_EXIT_INTENT_FOLDER_NAME.'/public/');
		self::addDefine('SG_POPUP_TEXT_DOMAIN', 'popupBuilder');
		self::addDefine('SGPB_EXIT_INTENT_URL', plugins_url().'/'.SGPB_EXIT_INTENT_FOLDER_NAME.'/');
		self::addDefine('SGPB_EXIT_INTENT_JAVASCRIPT_URL', SGPB_EXIT_INTENT_PUBLIC_URL.'javascript/');
		self::addDefine('SGPB_EXIT_INTENT_TEXT_DOMAIN', 'popupBuilderExitIntent');
		self::addDefine('SGPB_EXIT_INTENT_PLUGIN_MAIN_FILE', 'PopupBuilderExitIntent.php');
		self::addDefine('SGPB_EXIT_INTENT_ACTION_KEY', 'exitIntent');

		self::addDefine('SGPB_EXIT_INTENT_STORE_URL', 'https://popup-builder.com/');
		self::addDefine('SGPB_EXIT_INTENT_ITEM_ID', 9348);
		self::addDefine('SGPB_EXIT_INTENT_AUTHOR', 'Sygnoos');
		self::addDefine('SGPB_EXIT_INTENT_KEY', 'POPUP_EXIT_INTENT');
	}
}

SGPBExitIntentConfig::init();
