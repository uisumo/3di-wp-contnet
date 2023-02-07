<?php
if (defined('SGPB_EXIT_INTENT_CLASSES_PATH')) {
	return false;
}
require_once(dirname(__FILE__).'/com/config/config.php');

class SGPBExitIntentUninstall
{
	public static function uninstall()
	{
		$registeredPlugins = get_option('SG_POPUP_BUILDER_REGISTERED_PLUGINS');

		if (empty($registeredPlugins)) {
			return false;
		}

		$baseName = plugin_basename(__FILE__);
		$baseNames = explode('/', $baseName);

		if (empty($baseNames)) {
			return false;
		}
		$folderName = $baseNames[0];
		$pluginKey = $folderName.'/'.SGPB_EXIT_INTENT_PLUGIN_MAIN_FILE;

		$registeredPlugins = json_decode($registeredPlugins, true);

		// if this plugin exist in the registered list, we remove it
		if (!empty($registeredPlugins[$pluginKey])) {
			unset($registeredPlugins[$pluginKey]);
		}
		if (!empty($registeredPlugins)) {
			$registeredPlugins = json_encode($registeredPlugins);
		}

		update_site_option('SG_POPUP_BUILDER_REGISTERED_PLUGINS', $registeredPlugins);

		return true;
	}
}

SGPBExitIntentUninstall::uninstall();
