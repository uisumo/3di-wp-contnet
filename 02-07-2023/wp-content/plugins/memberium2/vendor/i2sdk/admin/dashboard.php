<?php
defined('ABSPATH') || die();

if (! empty($_POST['install_memberium']) ) {

		ignore_user_abort();

			file_put_contents( ABSPATH . '.maintenance', '<?php $upgrading = time();' );

		$update_file = download_url( 'https://memberium.com/download', 300 );

		if ( file_exists( $update_file ) ) {
		require_once ABSPATH .'/wp-admin/includes/file.php';
		WP_Filesystem();

		if ( ! function_exists( 'disk_free_space' ) ) {
			add_filter( 'wp_doing_cron', '__return_false', 10, 1 );
		}

		unzip_file( $update_file, WP_PLUGIN_DIR );
		remove_filter( 'wp_doing_cron', '__return_false', 10 );
		unlink( $update_file );
	}

	unlink( ABSPATH . '.maintenance' );
	activate_plugin( 'memberium2/memberium2.php', 'index.php?page=memberium-welcome-screen', false, false );
}



function i2sdk_admin_databasecheck() {
	$tables_exist = $i2sdk->checkTableExists( i2sdk_class::DB_API_LOG ) ;
}


function i2sdk_admin_menu() {
	if ( ! current_user_can( 'manage_options' ) ) {
		wp_die( __( 'You do not have sufficient permissions to access this page.' ) );
	}

	global $i2sdk, $wpdb;

	if ( $_SERVER['REQUEST_METHOD'] == 'POST' ) {

		if ( ! wp_verify_nonce( $_POST['i2sdk_admin_api_nonce'], plugin_basename( __FILE__ ) ) ) {
			wp_die( 'nonce error' );
			return;
		}

		if ( ! empty( $_POST['save'] ) ) {
			if ( $_POST['save'] == 'Sync Custom Fields' ) {
				$i2sdk->syncCustomFields();
			}
			elseif ( $_POST['save'] == 'Purge API Log' ) {
				$i2sdk->purgeAPILog();
			}
			elseif ( $_POST['save'] == 'Save API Configuration' ) {

				$original_api_key  = $i2sdk->getConfigurationOption( 'api_key' );
				$original_app_name = $i2sdk->getConfigurationOption( 'app_name' );

				$_POST['i2sdk_api_key']  = trim( $_POST['i2sdk_api_key'] );
				$_POST['i2sdk_app_name'] = isset($_POST['i2sdk_app_name']) ? strtolower( trim( $_POST['i2sdk_app_name'] ) ) : '';

				if ( ! empty( $_POST['i2sdk_app_name'] ) && ! empty( $_POST['i2sdk_api_key'] ) ) {
					$i2sdk->isdk->configureConnection( $_POST['i2sdk_app_name'], $_POST['i2sdk_api_key'] );

					$valid_connection = $i2sdk->isdk->verify_Connection();
					$i2sdk->setConfigurationOption( 'server_verified', ( $valid_connection ? 1 : 0 ) );

					if ( ! $valid_connection ) {
						$connection_failure = $i2sdk->isdk->get_ErrorMessage();
					}
					else {
						$connection_failure = '';
						$i2sdk->setConfigurationOption( 'app_name', strtolower( trim( $_POST['i2sdk_app_name'] ) ) );
						$i2sdk->setConfigurationOption( 'api_key', trim( $_POST['i2sdk_api_key'] ) );
						$i2sdk->syncCustomFields();
					}
				}

												$tracking_code = $i2sdk->isdk->getWebTrackingScript();
				$i2sdk->setConfigurationOption( 'tracking_code', $i2sdk->isdk->getWebTrackingScript() );

				if ( ! empty( $_POST['i2sdk_http_post_key'] ) ) {
					$post_keys = explode( ',', $_POST['i2sdk_http_post_key'] );
					foreach( $post_keys as &$post_key ) {
						$post_key = trim( $post_key );
					}
					$_POST['i2sdk_http_post_key'] = implode( ',', $post_keys );
					$i2sdk->setConfigurationOption( 'http_post_key', $_POST['i2sdk_http_post_key'] );
				}

				if ( isset( $_POST['i2sdk_retry_count'] ) ) {
					$i2sdk->setConfigurationOption( 'retry_count', (int) ( $_POST['i2sdk_retry_count'] > 0 ) ? (int) $_POST['i2sdk_retry_count'] : 3 );
				}

				if ( isset( $_POST['i2sdk_error_email'] ) ) {
					$i2sdk->setConfigurationOption( 'error_email', strtolower( trim( $_POST['i2sdk_error_email'] ) ) );
				}

				if ( isset( $_POST['i2sdk_email_notification'] ) ) {
					$i2sdk->setConfigurationOption( 'email_notification', ( in_array( (int) $_POST['i2sdk_email_notification'], [0, 1] )  ? (int) $_POST['i2sdk_email_notification'] : 0 ) );
				}

				if ( isset( $_POST['i2sdk_infusionsoft_analytics'] ) ) {
					$i2sdk->setConfigurationOption( 'infusionsoft_analytics', ( in_array( (int) $_POST['i2sdk_infusionsoft_analytics'], array( 0, 1 ) )  ? (int) $_POST['i2sdk_infusionsoft_analytics'] : 0 ) );
				}

				if ( isset( $_POST['i2sdk_api_log'] ) ) {
					$i2sdk->setConfigurationOption( 'api_log', ( in_array( (int) $_POST['i2sdk_api_log'], array( 0, 1 ) )  ? (int) $_POST['i2sdk_api_log'] : 0 ) );
				}
			}
		}
	}
	
	$valid_connection = $i2sdk->isdk->verify_Connection();
	$i2sdk->setConfigurationOption( 'server_verified', ( $valid_connection ? 1 : 0 ) );
	$connection_failure = $i2sdk->isdk->get_ErrorMessage();

	if ($valid_connection && class_exists('m4is_o5aoir')) {
		m4is_o5aoir::m4is_qlzwa4(true);
	}

		$show_library_settings = true;
	$show_api_settings     = true;
	$memberium_installed   = false;
	$server_verified       = (boolean) $i2sdk->getConfigurationOption( 'server_verified' );

	if ( defined( 'HIDE_I2SDK_API' ) && HIDE_I2SDK_API == true ) {
		$show_api_settings = false;
	}
	if ( $i2sdk->getConfigurationOption( 'app_name' ) == '' || $i2sdk->getConfigurationOption( 'api_key' ) == '' ) {
		$show_api_settings = true;
	}
	if ( ! $i2sdk->getConfigurationOption( 'server_verified' ) ) {
		$show_library_settings = false;
	}
	if ( ! $i2sdk->getConfigurationOption( 'server_verified' ) ) {
		$show_api_settings = true;
	}
	if ( file_exists( WP_PLUGIN_DIR . '/memberium2/' ) ) {
		$memberium_installed = true;
	}

	?>
	<div class="wrap">
	<h1>i<sup>2</sup>SDK <?php echo __( 'Enhanced Keap / WordPress Integration for Memberium' ); ?></h1>
	<div style="width:800px;">
		<form method="POST" action="" autocomplete="off">

			<?php wp_nonce_field( plugin_basename( __FILE__ ), 'i2sdk_admin_api_nonce' ); ?>

			<h2>Keap <?php _e( 'API Settings' ); ?></h2>
			<table class="widefat" style="white-space:nowrap;">
				<tr>
					<td style="width:250px;">i<sup>2</sup>SDK <?php _e( 'Version' ); ?>:</td>
					<td><?php echo $i2sdk->getVersion() ?></td>
				</tr>
				<?php
				if ( $show_api_settings ) {	
					$disabled_input = $i2sdk->getConfigurationOption('app_name') && $server_verified ? ' disabled="disabled" ' : '';
					?>
					<tr>
						<td style="width:250px;"><?php _e('Keap App Name'); ?>:</td>
						<td>
							https://<input id=i2sdk_app_name autocomplete=off type=text maxlength=32 size=20 name=i2sdk_app_name <?php echo $disabled_input; ?> value="<?php echo $i2sdk->getConfigurationOption('app_name') ?>" style="text-align:right;" />.infusionsoft.com/<br />
							<strong style="color:#8B0000">Once connected, you cannot change this app without causing data loss.</strong><br />
						</td>
						
					</tr>
					<tr>
						<td><label for=""><?php _e( 'Keap Encrypted key' ); ?>:</label></td>
						<td><input id="i2sdk_api_key" maxlength="255" autocomplete="off" name="i2sdk_api_key" size="40" type="text" value="<?php echo $i2sdk->getConfigurationOption( 'api_key' ) ?>" ></td>
					</tr>
					<?php
				}
				?>
				<tr>
					<td><label for=""><?php _e( 'Current API status' ); ?>:</label></td>
					<td><?php echo ( $i2sdk->getConfigurationOption( 'server_verified' ) == 1 ) ? '<b style="color:green;">' . __( 'Verified' ) . '</b>' : '<b style="color:red;">' . $connection_failure . '</b>'; ?></td>
				</tr>
			</table>
			<script>
			jQuery("input[name=i2sdk_api_key]").attr('type', 'password');
			jQuery("input[name=i2sdk_api_key]").hover(
				function() {
					jQuery(this).attr('type', 'text');
				}, function() {
					jQuery(this).attr('type', 'password');
				}
			);
			</script>



			<?php
			if ( $server_verified && ( ! $memberium_installed ) && wp_is_writable( WP_PLUGIN_DIR ) ) {
			?>
			<h2>Keap <?php _e( 'Install Plugins' ); ?></h2>
			<table class="widefat" style="white-space:nowrap;">
				<tr>
					<td style="width:250px;">Install Memberium:</td>
					<td>
						<input type="submit" name="install_memberium" value="Install Memberium" class="button-primary" />
					</td>
				</tr>
			</table>
			<?php
			}
			?>


			<?php
			if ( $show_library_settings ) {
			?>
			<h2>i<sup>2</sup>SDK <?php _e( 'Optional API Settings' ); ?></h2>
			<table class="widefat" style="white-space:nowrap;">
				<tr>
					<td><label for=""><?php _e( 'HTTP Send POST Auth Keys' ); ?> (<?php _e( 'REQUIRED for HTTP POST' ); ?>):</label></td>
					<td><input maxlength="40" name="i2sdk_http_post_key" size="40" type="text" value="<?php echo $i2sdk->getConfigurationOption( 'http_post_key' ) ?>" ></td>
				</tr>
				<?php
				if ( $i2sdk->getConfigurationOption( 'tracking_code' ) > '' ) {
					?>
					<tr>
						<td><label for=""><?php _e( 'Keap Web Analytics' ); ?>:</label></td>
						<td>
							<select name="i2sdk_infusionsoft_analytics">
								<option value="0" <?php echo ( $i2sdk->getConfigurationOption( 'infusionsoft_analytics' ) == 0 ) ? 'selected="selected"' : '' ?>>Off</option>
								<option value="1" <?php echo ( $i2sdk->getConfigurationOption( 'infusionsoft_analytics' ) == 1 ) ? 'selected="selected"' : '' ?>>On</option>
							</select>
						</td>
					</tr>
					<?php
				}
				?>
				<tr>
					<td style="width:250px;"><label for=""><?php _e( 'API Log' ); ?>:</label></td>
					<td>
						<select name="i2sdk_api_log">
							<option value="0" <?php echo ( $i2sdk->getConfigurationOption( 'api_log' ) == 0 ) ? 'selected="selected"' : ''; ?>>Off</option>
							<option value="1" <?php echo ( $i2sdk->getConfigurationOption( 'api_log' ) == 1 ) ? 'selected="selected"' : ''; ?>>On</option>
						</select>
					</td>
				</tr>
				<tr>
					<td style="width:250px;"><label for="i2sdk_email_notification"><?php _e( 'Email Error Notifications' ); ?>:</label></td>
					<td>
						<select name="i2sdk_email_notification">
							<option value="0" <?php echo ( $i2sdk->getConfigurationOption( 'email_notification' ) == 0 ) ? 'selected="selected"' : ''; ?>>Off</option>
							<option value="1" <?php echo ( $i2sdk->getConfigurationOption( 'email_notification' ) == 1 ) ? 'selected="selected"' : ''; ?>>On</option>
						</select>
					</td>
				</tr>
				<tr>
					<td style="width:250px;"><label for=""><?php _e( 'Notification Email Address' ); ?>:</label></td>
					<td><input maxlength="40" name="i2sdk_error_email" size="40" type="email" value="<?php echo $i2sdk->getConfigurationOption( 'error_email' ) ?>" placeholder="<?php echo get_option( 'admin_email' ); ?>" ></td>
				</tr>
				<tr>
					<td><label for=""><?php _e( 'Transaction Retry Count' ); ?>:</label></td>
					<td><input maxlength="1" min="0" max="9" name="i2sdk_retry_count" size="4" type="number" value="<?php echo (int) $i2sdk->getConfigurationOption( 'retry_count' ) ?>" ></td>
				</tr>
			</table>
			<?php
			}
			?>
			<p>
				<a href="https://help.keap.com/help/api-key" target="_blank"><?php _e( 'Click here for help activating your Keap API Key' ); ?></a>
			</p>
			<p>
				<input type="submit" name="save" value="Save API Configuration" class="button-primary" />
			</p>
		</form>

		<hr />
		<style>
		form {
			margin-bottom: 10px;
		}
		</style>
		<form method="POST" action="" autocomplete="off">
			<?php wp_nonce_field( plugin_basename( __FILE__ ), 'i2sdk_admin_api_nonce' ); ?>
			<!-- input type="submit" name="save" value="Backup Configuration" class="button" / -->
			<?php
			if ( $show_library_settings ) {
			?>
			<input type="submit" name="save" value="Sync Custom Fields" class="button" />
			<input type="submit" name="save" value="Purge API Log" class="button" />
			<?php
			}
			?>
		</form>
		<!-- form method="POST" action="" enctype="multipart/form-data">
			<?php wp_nonce_field( plugin_basename( __FILE__ ), 'i2sdk_admin_api_nonce' ); ?>
			<input type="file" name="backupfile" class="button" />
			<input type="submit" name="save" value="Restore Backup" class="button" />
		</form -->

		<hr />


	</div>
	<?php
		echo '</div>';
	echo 'Copyright &copy; 2012-' . date( 'Y' ) . ' David Bullock / Web, Power and Light';
}
