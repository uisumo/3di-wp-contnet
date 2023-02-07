<?php
if (! isset($activePlugins, $activePluginsToUnload)) {
	exit;
}

$pluginsRulesDbListJson = get_option('wpassetcleanup_global_data');

if ($pluginsRulesDbListJson) {
	$pluginsRulesDbList = @json_decode( $pluginsRulesDbListJson, true );

	// Are there any valid load exceptions / unload RegExes? Fill $activePluginsToUnload
	if ( isset( $pluginsRulesDbList[ 'plugins_dash' ] ) && ! empty( $pluginsRulesDbList[ 'plugins_dash' ] ) ) {
		$pluginsRules = $pluginsRulesDbList[ 'plugins_dash' ];

		// We want to make sure the RegEx rules will be working fine if certain characters (e.g. Thai ones) are used
		$requestUriAsItIs = rawurldecode($_SERVER['REQUEST_URI']);

		// Unload site-wide
		foreach ($pluginsRules as $pluginPath => $pluginRule) {
			if (! in_array($pluginPath, $activePlugins)) {
				// Only relevant if the plugin is active
				// Otherwise it's unloaded (inactive) anyway
				continue;
			}

			// 'status' refers to the Unload Status (any option that was chosen)
			if (isset($pluginRule['status']) && ! empty($pluginRule['status'])) {
				if ( ! is_array($pluginRule['status']) ) {
					$pluginRule['status'] = array($pluginRule['status']); // from v1.1.8.3
				}

				// Are there any load exceptions?
				$isLoadExceptionRegExMatch = isset($pluginRule['load_via_regex']['enable'], $pluginRule['load_via_regex']['value'])
				                        && $pluginRule['load_via_regex']['enable'] && wpacuPregMatchInput($pluginRule['load_via_regex']['value'], $requestUriAsItIs);

				if ( $isLoadExceptionRegExMatch ) {
					continue; // Skip to the next plugin as this one has a load exception matching the condition
				}

				if ( in_array('unload_site_wide', $pluginRule['status']) ) {
					$activePluginsToUnload[] = $pluginPath; // Add it to the unload list
				} elseif ( in_array('unload_via_regex', $pluginRule['status']) ) {
					$isUnloadRegExMatch = isset($pluginRule['unload_via_regex']['value']) && wpacuPregMatchInput($pluginRule['unload_via_regex']['value'], $requestUriAsItIs);
					if ($isUnloadRegExMatch) {
						$activePluginsToUnload[] = $pluginPath; // Add it to the unload list
					}
				}
			}
		}
	}
}

// [START - Make exception and load the plugin for debugging purposes]
if (isset($_GET['wpacu_load_plugins']) && $_GET['wpacu_load_plugins']) {
	require WPACU_MU_FILTER_PLUGIN_DIR.'/_common/_plugin-load-exceptions-via-query-string.php';
}
// [END - Make exception and load the plugin for debugging purposes]