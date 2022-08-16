<?php
$instance = vgse_wc_coupons();
// Auto enable WC coupons when they install our coupons sheet
update_option('woocommerce_enable_coupons', 'yes');
?>
<p><?php _e('Thank you for installing our plugin.', $instance->textname); ?></p>

<?php
$steps = array();
if (!function_exists('WC')) {
	$steps['install_dependencies_wc'] = '<p>' . sprintf(__('Install the plugin: WooCommerce. <a href="%s" target="_blank" class="button install-plugin-trigger">Click here</a>. This is a WooCommerce extension.', $instance->textname), esc_url($this->get_plugin_install_url('woocommerce'))) . '</p>';
} else {
	$steps['open_editor'] = '<p>' . sprintf(__('You can open the Coupons Bulk Editor Now:  <a href="%s" class="button">Click here</a>', $instance->textname), esc_url(VGSE()->helpers->get_editor_url('shop_coupon'))) . '</p>';
}

include VGSE_DIR . '/views/free-extensions-for-welcome.php';
$steps['free_extensions'] = $free_extensions_html;

$steps = apply_filters('vg_sheet_editor/users/welcome_steps', $steps);

if (!empty($steps)) {
	echo '<ol class="steps">';
	foreach ($steps as $key => $step_content) {
		if (empty($step_content)) {
			continue;
		}
		?>
		<li><?php echo wp_kses_post($step_content); ?></li>		
		<?php
	}

	echo '</ol>';
}	