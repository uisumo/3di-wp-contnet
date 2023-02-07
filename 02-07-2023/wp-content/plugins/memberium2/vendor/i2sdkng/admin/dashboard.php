<?php
if ( !defined( 'ABSPATH' ) ) {
	die();
}


function i2sdk_admin_menu() {
	if ( ! current_user_can( 'manage_options' ) ) {
		wp_die( __( 'You do not have sufficient permissions to access this page.' ) );
	}

	global $i2sdk, $wpdb;
	$user_id            = get_current_user_id();
	$connection_failure = '';

	if ( $_SERVER['REQUEST_METHOD'] == 'POST' ) {

		if ( ! wp_verify_nonce( $_POST['i2sdk_admin_api_nonce'], plugin_basename( __FILE__ ) ) ) {
			wp_die( 'nonce error' );
			return;
		}

				if( ! empty($_POST['is_disconnect_oauth']) && $_POST['is_disconnect_oauth'] == 'Disconnect OAuth' ){
			$admin = !empty($_POST['is_disconnect_admin']) ? $_POST['is_disconnect_admin'] : false;
			if( $admin ){
				$i2sdk->accessToken()->log['service'] = 'oauth_token';
				$i2sdk->accessToken()->log['caller']  = '$_POST';
				$i2sdk->accessToken()->disconnect($admin);
			}
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
				$original_appname  = $i2sdk->getConfigurationOption( 'app_name' );
				$api_key_connected = false;
				$oauth_connected   = false;
				$oauth_enabled     = (boolean) $i2sdk->getConfigurationOption( 'oauth_enabled' );
				$api_key           = isset($_POST['i2sdk_api_key']) ? trim( $_POST['i2sdk_api_key'] ) : '';
				$appname 		   = isset($_POST['i2sdk_app_name']) ? strtolower( trim( $_POST['i2sdk_app_name'] ) ) : $original_appname;

				if ( ! empty( $appname ) ){

										if( ! empty( $api_key ) ){
						$i2sdk->isdk->configureConnection( $appname, $api_key );
						$api_key_connected = $i2sdk->isdk->verify_Connection();
					}
					else{
						$api_key_connected = $original_api_key;
					}
										if( $oauth_enabled ){
						$access_token = $i2sdk->getConfigurationOption('access_token');
						if( $access_token ){
														if( $appname !== $original_appname ){
								$i2sdk->accessToken()->disconnect( $user_id );
							}
							else{
								$i2sdk->rest()->set_token($access_token);
								$i2sdk->rest()->set_appname($appname);
								$oauth_connected = $i2sdk->rest()->verify_connection();
							}
						}
					}

				}
								else{
					if( !empty($original_appname) ){
						if( $oauth_enabled && $i2sdk->accessToken()->get_token_object() ){
							$i2sdk->accessToken()->disconnect( $user_id );
						}
					}
				}

								$valid_connection = $oauth_connected || $api_key_connected;
				$i2sdk->setConfigurationOption( 'server_verified', ( $valid_connection ? 1 : 0 ) );

				if( $valid_connection ){
					$connection_failure = '';
					if ( $original_appname !== $appname ) {
						$i2sdk->setConfigurationOption( 'app_name', $appname );
					}
					if ( $api_key_connected && $api_key !== $original_api_key ) {
						$i2sdk->setConfigurationOption( 'api_key', $api_key );
					}
				}
				else{
					if( ! empty($api_key) ){
						$connection_failure = $i2sdk->isdk->get_ErrorMessage();
					}

					if( $oauth_enabled && is_wp_error($oauth_connected) ) {
						$oauth_connection_failure = $oauth_connected->get_error_message();
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
					$i2sdk->setConfigurationOption( 'infusionsoft_analytics', ( in_array( (int) $_POST['i2sdk_infusionsoft_analytics'], [0, 1] )  ? (int) $_POST['i2sdk_infusionsoft_analytics'] : 0 ) );
				}

				if ( isset( $_POST['i2sdk_api_log'] ) ) {
					$i2sdk->setConfigurationOption( 'api_log', ( in_array( (int) $_POST['i2sdk_api_log'], [0, 1] )  ? (int) $_POST['i2sdk_api_log'] : 0 ) );
				}
			}
		}
	}

	if ($_SERVER['REQUEST_METHOD'] == 'POST') {

		$valid_connection = $i2sdk->isdk->verify_Connection();
		$i2sdk->setConfigurationOption( 'server_verified', ( $valid_connection ? 1 : 0 ) );
		$connection_failure = $i2sdk->isdk->get_ErrorMessage();

		if ($valid_connection && class_exists('m4is_o5aoir')) {
			m4is_o5aoir::m4is_qlzwa4(false);
		}
	}

		$show_library_settings = true;
	$show_api_settings     = true;
	$memberium_installed   = false;
	$server_verified       = (boolean) $i2sdk->getConfigurationOption( 'server_verified' );
	$token_object          = $i2sdk->accessToken()->get_token_object();

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
	<h1>Keap Connection for Memberium</h1>
	<div style="width:800px;">
		<form method="POST" action="" autocomplete="off">

			<?php wp_nonce_field( plugin_basename( __FILE__ ), 'i2sdk_admin_api_nonce' ); ?>

			<h2>Keap <?php _e( 'API Settings' ); ?></h2>
			<table class="widefat" style="white-space:nowrap;">
				<tr>
					<td style="width:250px;">Keap API Connection Version:</td>
					<td><?php echo $i2sdk->getVersion() ?></td>
				</tr>
				<tr>
					<td style="width:250px;">OAuth Connection:</td>
					<td>
				<?php if ( $token_object ) { ?>
					<input type="submit" name="is_disconnect_oauth" value="Disconnect OAuth" class="button-primary" style="background-color:red;"/>
					<input type="hidden" name="is_disconnect_admin" value="<?php echo $user_id; ?>" />
				<?php } else { ?>
					<a href="<?php echo $i2sdk->accessToken()->get_connect_url(); ?>" class="button-primary" style="background-color:green;">Authorize OAuth</a>
				<?php } ?>
					</td>
				</tr>
				<?php if ( $token_object && true ) { ?>
				<tr>
					<td style="width:250px;">Token Expiration:</td>
					<td>
						<ul>
							<li>
								End of Life <?php echo wp_date( 'F j, Y @ g:i:s a', $token_object->endOfLife ); ?>
							</li>
							<li>
								<input type="submit" name="is_set_oauth_expiration" value="Test Token Refresh" class="button-primary" style="" />
							</li>
						</ul>
					</td>
				</tr>
				<?php } ?>
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
			jQuery("input[name=is_set_oauth_expiration]").click(function(e){
				if( jQuery(this).hasClass('memb_submitted') ){
					e.preventDefault();
					return false;
				}
				else{
					jQuery(this).addClass('memb_submitted')
					e.target.form.submit();
				}
			});
			</script>

			<?php
			if ( $show_library_settings ) {
			?>
			<h2>Keap Connection Optional API Settings</h2>
			<table class="widefat" style="white-space:nowrap;">
				<tr>
					<td><label for="">HTTP POST Auth Keys:</label></td>
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
				<a href="https://help.keap.com/help/api-key" target="_blank"><?php _e( 'Click here for help activating your Keap / Infusionsoft API Key' ); ?></a>
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
