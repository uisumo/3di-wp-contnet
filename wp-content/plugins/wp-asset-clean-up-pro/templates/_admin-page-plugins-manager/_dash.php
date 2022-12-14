<?php
if (! isset($data)) {
	exit;
}
?>
<div class="wpacu-wrap" id="wpacu-plugins-load-manager-wrap">
	<form method="post" action="" class="wpacu-settings-form">
		<?php
		$pluginsRows = array();

		foreach ($data['active_plugins'] as $pluginData) {
			$pluginPath = $pluginData['path'];
			list($pluginDir) = explode('/', $pluginPath);

			// [wpacu_pro]
			$pluginStatus = isset($data['rules'][$pluginPath]['status']) ? $data['rules'][$pluginPath]['status'] : array(); // array() from v1.1.8.3

			if (! is_array($pluginStatus)) {
				$pluginStatus = array($pluginStatus); // from v1.1.8.3
			}
			// [/wpacu_pro]

			ob_start();
			?>
			<tr>
				<td class="wpacu_plugin_icon" width="40">
					<?php if(isset($data['plugins_icons'][$pluginDir])) { ?>
						<img width="40" height="40" alt="" src="<?php echo esc_attr($data['plugins_icons'][$pluginDir]); ?>" />
					<?php } else { ?>
						<div><span class="dashicons dashicons-admin-plugins"></span></div>
					<?php } ?>
				</td>
				<td class="wpacu_plugin_details" id="wpacu-dash-manage-<?php echo esc_attr($pluginData['path']); ?>">
					<span class="wpacu_plugin_title"><?php echo esc_html($pluginData['title']); ?></span>
                    <span class="wpacu_plugin_path">&nbsp;<small><?php echo esc_html($pluginData['path']); ?></small></span>

					<?php
					if ($pluginData['network_activated']) {
						echo '&nbsp;<span title="Network Activated" class="dashicons dashicons-admin-multisite wpacu-tooltip"></span>';
					}
					?>

                    <div class="wpacu-clearfix"></div>

					<div class="wrap_plugin_unload_rules_options" data-wpacu-plugin-path="<?php echo esc_attr($pluginPath); ?>">
						<!-- [Start] Unload Rules -->
						<?php
						$isUnloadSiteWide = in_array('unload_site_wide', $pluginStatus);
						?>
						<div class="wpacu_plugin_rules_wrap">
							<ul class="wpacu_plugin_rules">
								<li>
									<label for="wpacu_global_unload_plugin_<?php echo esc_attr($pluginPath); ?>"
										<?php if ($isUnloadSiteWide) { echo 'class="wpacu_plugin_unload_rule_input_checked"'; } ?>>
										<input data-wpacu-plugin-path="<?php echo esc_attr($pluginPath); ?>"
										       class="wpacu_plugin_unload_site_wide wpacu_plugin_unload_rule_input"
										       id="wpacu_global_unload_plugin_<?php echo esc_attr($pluginPath); ?>"
										       type="checkbox"
										       name="wpacu_plugins[<?php echo esc_attr($pluginPath); ?>][status][]"
											<?php if ($isUnloadSiteWide) { echo 'checked="checked"'; } ?>
											   value="unload_site_wide" />
										Unload on all admin pages <small>&amp; add exceptions</small></label>
								</li>
							</ul>
						</div>

						<?php
						$isUnloadViaRegEx = in_array('unload_via_regex', $pluginStatus);
						?>
						<div class="wpacu_plugin_rules_wrap">
							<ul class="wpacu_plugin_rules">
								<li>
									<label for="wpacu_unload_it_regex_option_<?php echo esc_attr($pluginPath); ?>"
										<?php if ($isUnloadViaRegEx) { echo 'class="wpacu_plugin_unload_rule_input_checked"'; } ?>
										   style="margin-right: 0;">
										<input data-wpacu-plugin-path="<?php echo esc_attr($pluginPath); ?>"
										       id="wpacu_unload_it_regex_option_<?php echo esc_attr($pluginPath); ?>"
										       class="wpacu_plugin_unload_regex_option wpacu_plugin_unload_rule_input"
										       type="checkbox"
											<?php if ($isUnloadViaRegEx) { echo 'checked="checked"'; } ?>
											   name="wpacu_plugins[<?php echo esc_attr($pluginPath); ?>][status][]"
											   value="unload_via_regex">&nbsp;<span>Unload it for admin URLs with request URI matching the RegEx(es):</span></label>
									<a class="help_link unload_it_regex"
									   target="_blank"
									   href="https://assetcleanup.com/docs/?p=372#wpacu-unload-plugins-via-regex"><span style="color: #74777b;" class="dashicons dashicons-editor-help"></span></a>
									<div data-wpacu-plugin-path="<?php echo esc_attr($pluginPath); ?>"
									     class="wpacu_plugin_unload_regex_input_wrap <?php if (! $isUnloadViaRegEx) { ?>wpacu_hide<?php } ?>">
                                        <textarea class="wpacu_regex_rule_textarea"
                                                  data-wpacu-adapt-height="1"
                                                  name="wpacu_plugins[<?php echo esc_attr($pluginPath); ?>][unload_via_regex][value]"><?php if (isset($data['rules'][$pluginPath]['unload_via_regex']['value']) && $data['rules'][$pluginPath]['unload_via_regex']['value']) {
		                                        echo esc_textarea($data['rules'][$pluginPath]['unload_via_regex']['value']); } ?></textarea>
										<p><small><span style="font-weight: 500;">Note:</span> Multiple RegEx rules can be added as long as they are one per line.</small></p>
									</div>
								</li>
							</ul>
						</div>
						<div class="wpacu-clearfix"></div>
					</div>
					<!-- [End] Unload Rules -->

					<!-- [Start] Make exceptions: Load Rules -->
					<?php
					$isLoadViaRegExEnabled = isset($data['rules'][$pluginPath]['load_via_regex']['enable']) && $data['rules'][$pluginPath]['load_via_regex']['enable'];
					?>
                    <div class="wpacu-clearfix"></div>
					<div data-wpacu-plugin-path="<?php echo esc_attr($pluginPath); ?>"
					     class="wrap_plugin_load_exception_options <?php if ( ! ( $isUnloadSiteWide || $isUnloadViaRegEx) ) { ?>wpacu_hide<?php } ?>">
						<div class="wpacu_plugin_rules_wrap">
							<ul class="wpacu_plugin_rules wpacu_exception_options_area">
								<li>
									<label for="wpacu_load_it_regex_option_plugin_<?php echo esc_attr($pluginPath); ?>" style="margin-right: 0;">
										<input data-wpacu-plugin-path="<?php echo esc_attr($pluginPath); ?>"
										       id="wpacu_load_it_regex_option_plugin_<?php echo esc_attr($pluginPath); ?>"
										       class="wpacu_plugin_load_exception_regex"
										       type="checkbox"
											<?php if ($isLoadViaRegExEnabled) { echo 'checked="checked"'; } ?>
											   name="wpacu_plugins[<?php echo esc_attr($pluginPath); ?>][load_via_regex][enable]"
											   value="1" />&nbsp;<span>Make an exception and always load it if the admin URL (its URI) is matched by a RegEx(es):</span>
									</label>&nbsp;<a style="color: #74777b;" class="help_link" target="_blank" href="https://assetcleanup.com/docs/?p=372#wpacu-unload-plugins-via-regex"><span class="dashicons dashicons-editor-help"></span></a>&nbsp;
									<div class="wpacu_load_regex_input_wrap <?php if (! $isLoadViaRegExEnabled) { echo 'wpacu_hide'; } ?>"
									     data-wpacu-plugin-path="<?php echo esc_attr($pluginPath); ?>">
                                        <textarea class="wpacu_regex_rule_textarea"
                                                  data-wpacu-adapt-height="1"
                                                  name="wpacu_plugins[<?php echo esc_attr($pluginPath); ?>][load_via_regex][value]"><?php if (isset($data['rules'][$pluginPath]['load_via_regex']['value']) && $data['rules'][$pluginPath]['load_via_regex']['value']) { echo esc_textarea($data['rules'][$pluginPath]['load_via_regex']['value']); } ?></textarea>
										<p><small><span style="font-weight: 500;">Note:</span> Multiple RegEx rules can be added as long as they are one per line.</small></p>
									</div>
								</li>
							</ul>
						</div>
					</div>
					<div class="wpacu-clearfix"></div>
					<!-- [End] Make exceptions: Load Rules -->
				</td>
			</tr>
			<?php
			$trOutput = ob_get_clean();

			if (empty($pluginStatus)) {
				$pluginsRows['always_loaded'][] = $trOutput;
			} else {
				$pluginsRows['has_unload_rules'][] = $trOutput;
			}
		}

		if (isset($pluginsRows['has_unload_rules']) && ! empty($pluginsRows['has_unload_rules'])) {
			$totalWithUnloadRulesPlugins = count($pluginsRows['has_unload_rules']);
			?>
			<h3><span style="color: #c00;" class="dashicons dashicons-admin-plugins"></span> <span style="color: #c00;"><?php echo (int)$totalWithUnloadRulesPlugins; ?></span> plugin<?php echo ($totalWithUnloadRulesPlugins > 1) ? 's' : ''; ?> with active unload rules</h3>
			<table class="wp-list-table wpacu-list-table widefat plugins striped">
				<?php
				foreach ( $pluginsRows['has_unload_rules'] as $pluginRowOutput ) {
					echo \WpAssetCleanUp\Misc::stripIrrelevantHtmlTags($pluginRowOutput) . "\n";
				}
				?>
			</table>
			<?php
		}

		if (isset($pluginsRows['always_loaded']) && ! empty($pluginsRows['always_loaded'])) {
			if (isset($pluginsRows['has_unload_rules']) && count($pluginsRows['has_unload_rules']) > 0) {
				?>
				<div style="margin-top: 35px;"></div>
				<?php
			}

			$totalAlwaysLoadedPlugins = count($pluginsRows['always_loaded']);
			?>

			<h3><span style="color: green;" class="dashicons dashicons-admin-plugins"></span> <span style="color: green;"><?php echo (int)$totalAlwaysLoadedPlugins; ?></span> plugin<?php echo ($totalAlwaysLoadedPlugins > 1) ? 's' : ''; ?> with no active unload rules (loaded by default)</h3>
			<table class="wp-list-table wpacu-list-table widefat plugins striped">
				<?php
				foreach ( $pluginsRows['always_loaded'] as $pluginRowOutput ) {
					echo \WpAssetCleanUp\Misc::stripIrrelevantHtmlTags($pluginRowOutput) . "\n";
				}
				?>
			</table>
			<?php
		}
		?>
		<div id="wpacu-update-button-area" style="margin-left: 0;">
			<?php
			wp_nonce_field('wpacu_plugin_manager_update', 'wpacu_plugin_manager_nonce');
			submit_button('Apply changes within /wp-admin/');
			?>
			<div id="wpacu-updating-settings" style="margin-left: 278px; top: 28px;">
				<img src="<?php echo esc_url(admin_url('images/spinner.gif')); ?>" align="top" width="20" height="20" alt="" />
			</div>
			<input type="hidden" name="wpacu_plugins_manager_submit" value="1" />
		</div>
	</form>
</div>