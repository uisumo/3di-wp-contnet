<?php
/*
 * The file is included from /templates/meta-box-loaded-assets/_asset-script-single-row.php
*/

if (! isset($data)) {
	exit; // no direct access
}

$isGroupUnloaded        = $data['row']['is_group_unloaded'];
// [wpacu_pro]
$isMarkedForPostTypeViaTaxUnload = isset($data['handle_unload_via_tax']['styles'][$data['row']['obj']->handle ]['enable'], $data['handle_unload_via_tax']['styles'][$data['row']['obj']->handle]['values'])
    && $data['handle_unload_via_tax']['styles'][$data['row']['obj']->handle ]['enable'] && ! empty($data['handle_unload_via_tax']['styles'][$data['row']['obj']->handle]['values']);
$isMarkedForRegExUnload = isset($data['handle_unload_regex']['styles'][ $data['row']['obj']->handle ]['enable']) ? $data['handle_unload_regex']['styles'][ $data['row']['obj']->handle ]['enable'] : false;
// [/wpacu_pro]
$anyUnloadRuleSet       = ($isGroupUnloaded || $isMarkedForRegExUnload || $isMarkedForPostTypeViaTaxUnload || $data['row']['checked']);
?>
<div class="wpacu_exception_options_area_load_exception <?php if (! $anyUnloadRuleSet) { echo 'wpacu_hide'; } ?>">
	<div data-style-handle="<?php echo htmlentities(esc_attr($data['row']['obj']->handle), ENT_QUOTES); ?>"
	     class="wpacu_exception_options_area_wrap">
        <fieldset>
            <legend>Make an exception from any unload rule &amp; <strong>always load it</strong>:</legend>

		<ul class="wpacu_area_two wpacu_asset_options wpacu_exception_options_area">
			<li id="wpacu_load_it_option_style_<?php echo htmlentities(esc_attr($data['row']['obj']->handle), ENT_QUOTES); ?>">
				<label><input data-handle="<?php echo htmlentities(esc_attr($data['row']['obj']->handle), ENT_QUOTES); ?>"
				              id="wpacu_style_load_it_<?php echo htmlentities(esc_attr($data['row']['obj']->handle), ENT_QUOTES); ?>"
				              class="wpacu_load_it_option_one wpacu_style wpacu_load_exception"
				              type="checkbox"
						<?php if ($data['row']['is_load_exception_per_page']) { ?> checked="checked" <?php } ?>
						      name="wpacu_styles_load_it[]"
						      value="<?php echo htmlentities(esc_attr($data['row']['obj']->handle), ENT_QUOTES); ?>"/>
                    <span>On this page</span></label>
			</li>

			<?php
			if ($data['bulk_unloaded_type'] === 'post_type') {
				// Only show it on edit post/page/custom post type
				switch ($data['post_type']) {
					case 'product':
						$loadBulkText = __('On all WooCommerce "Product" pages', 'wp-asset-clean-up');
						break;
					case 'download':
						$loadBulkText = __('On all Easy Digital Downloads "Download" pages', 'wp-asset-clean-up');
						break;
					default:
						$loadBulkText = sprintf(__('On All Pages of "<strong>%s</strong>" post type', 'wp-asset-clean-up'), $data['post_type']);
				}
				?>
                <li id="wpacu_load_it_post_type_option_style_<?php echo htmlentities(esc_attr($data['row']['obj']->handle), ENT_QUOTES); ?>">
                    <label><input data-handle="<?php echo htmlentities(esc_attr($data['row']['obj']->handle), ENT_QUOTES); ?>"
                                  id="wpacu_style_load_it_post_type_<?php echo htmlentities(esc_attr($data['row']['obj']->handle), ENT_QUOTES); ?>"
                                  class="wpacu_load_it_option_post_type wpacu_style wpacu_load_exception"
                                  type="checkbox"
							<?php if ($data['row']['is_load_exception_post_type']) { ?> checked="checked" <?php } ?>
                                  name="<?php echo WPACU_FORM_ASSETS_POST_KEY; ?>[styles][<?php echo htmlentities(esc_attr($data['row']['obj']->handle), ENT_QUOTES); ?>][load_it_post_type]"
                                  value="1"/>
                        <span><?php echo wp_kses($loadBulkText, array('strong' => array())); ?></span></label>
                </li>
				<?php
                // [wpacu_pro]
				if ($data['post_type'] && $data['post_type'] !== 'attachment' && ! empty($data['post_type_has_tax_assoc'])) {
					include dirname(__DIR__).'/_common/_style-load-exceptions-taxonomy.php';
				}
				// [/wpacu_pro]
			}

			// [wpacu_pro]
			$handleLoadRegex = (isset($data['handle_load_regex']['styles'][$data['row']['obj']->handle]) && $data['handle_load_regex']['styles'][$data['row']['obj']->handle])
				? $data['handle_load_regex']['styles'][$data['row']['obj']->handle]
				: false;

			$handleLoadRegex['enable'] = isset($handleLoadRegex['enable']) && $handleLoadRegex['enable'];
			$handleLoadRegex['value']  = (isset($handleLoadRegex['value']) && $handleLoadRegex['value']) ? $handleLoadRegex['value'] : '';

			$isLoadRegExEnabledWithValue = $handleLoadRegex['enable'] && $handleLoadRegex['value'];
			?>
			<li>
				<label for="wpacu_load_it_regex_option_style_<?php echo htmlentities(esc_attr($data['row']['obj']->handle), ENT_QUOTES); ?>">
					<input data-handle="<?php echo htmlentities(esc_attr($data['row']['obj']->handle), ENT_QUOTES); ?>"
					       id="wpacu_load_it_regex_option_style_<?php echo htmlentities(esc_attr($data['row']['obj']->handle), ENT_QUOTES); ?>"
					       class="wpacu_load_it_option_two wpacu_style wpacu_load_exception"
					       type="checkbox"
					       name="wpacu_handle_load_regex[styles][<?php echo htmlentities(esc_attr($data['row']['obj']->handle), ENT_QUOTES); ?>][enable]"
						<?php if ($isLoadRegExEnabledWithValue) { ?> checked="checked" <?php } ?>
						   value="1" />&nbsp;<span>If the URL (its URI) is matched by a RegEx(es):</span></label> <a style="text-decoration: none; color: inherit; vertical-align: middle;" target="_blank" href="https://assetcleanup.com/docs/?p=21#wpacu-method-2"><span class="dashicons dashicons-editor-help"></span></a>
				<div class="wpacu_load_regex_input_wrap <?php if ( ! $isLoadRegExEnabledWithValue ) { echo 'wpacu_hide'; } ?>">
                    <div class="wpacu_regex_rule_area">
                        <textarea <?php if (! $isLoadRegExEnabledWithValue) { echo 'disabled="disabled"'; } ?>
                            class="wpacu_regex_rule_textarea"
                            data-handle="<?php echo htmlentities(esc_attr($data['row']['obj']->handle), ENT_QUOTES); ?>"
                            data-handle-for="style"
                            data-wpacu-adapt-height="1"
                            name="wpacu_handle_load_regex[styles][<?php echo htmlentities(esc_attr($data['row']['obj']->handle), ENT_QUOTES); ?>][value]"><?php echo esc_attr($handleLoadRegex['value']); ?></textarea>
                        <p style="margin-top: 0 !important;"><small><span style="font-weight: 500;">Note:</span> Multiple RegEx rules can be added as long as they are one per line.</small></p>
                    </div>
				</div>
			</li>
			<?php
			// [/wpacu_pro]
			$isLoadItLoggedIn = in_array($data['row']['obj']->handle, $data['handle_load_logged_in']['styles']);
			?>
			<li id="wpacu_load_it_user_logged_in_option_style_<?php echo htmlentities(esc_attr($data['row']['obj']->handle), ENT_QUOTES); ?>">
				<label>
                    <input data-handle="<?php echo htmlentities(esc_attr($data['row']['obj']->handle), ENT_QUOTES); ?>"
				              id="wpacu_load_it_user_logged_in_option_style_<?php echo htmlentities(esc_attr($data['row']['obj']->handle), ENT_QUOTES); ?>"
				              class="wpacu_load_it_option_three wpacu_style wpacu_load_exception"
				              type="checkbox"
						<?php if ($isLoadItLoggedIn) { ?> checked="checked" <?php } ?>
						      name="wpacu_load_it_logged_in[styles][<?php echo htmlentities(esc_attr($data['row']['obj']->handle), ENT_QUOTES); ?>]"
						      value="1"/>
                    <span>If the user is logged-in</span></label>
			</li>
		</ul>
		<div class="wpacu-clearfix"></div>
        </fieldset>
	</div>
</div>