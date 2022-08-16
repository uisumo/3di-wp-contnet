<?php

/* Creates license activation menu. */
add_action('admin_menu', 'tmmp_license_menu');
function tmmp_license_menu() {
	add_submenu_page( 'edit.php?post_type=tmm', 'PRO License', 'PRO License', 'manage_options', TMMP_PLUGIN_LICENSE_PAGE, 'tmmp_license_page' );
}

/* Renders license activation page. */
function tmmp_license_page() {

	if ( isset( $_GET['sl_activation'] ) && ! empty( $_GET['message'] ) ) {
		switch( $_GET['sl_activation'] ) {
			case 'false':
				$message = urldecode( $_GET['message'] );
				break;

			case 'true':
			default:
				break;
		}
	}

	/* Gets current license. */
	$license = get_option( 'tmmp_license_key' ); ?>

	<div class="wrap">
		
		<div class="license-box" style="border-radius:5px; max-width:800px; margin-top:30px; background:white; padding: 30px; display:block; text-align:center;">
			<form method="post" action="options.php">

				<?php settings_fields('tmmp_license'); ?>

				<h1><?php _e('Team Members PRO'); ?></h1>
				<h2 style="color:#aaa; margin-top:5px; margin-bottom:30px;"><?php _e('License activation'); ?></h2>

				<?php
	
				/* Checks the current license. */
				$license_check = array();
				$license_check = tmmp_check_license();
				/* Assign results. */
				$is_valid = $license_check[0];
				$status = $license_check[1];
	
				/* License is valid. */
				if( $is_valid == 'valid' ) { ?>

					<img style="width:100%; max-width:565px;" src="<?php echo esc_url( plugins_url( 'inc/img/activated.png', dirname(__FILE__) ) ) ?>"/>
				<!-- License is not valid. -->
				<?php } else { ?>

					<img style="width:100%; max-width:565px;" src="<?php echo esc_url( plugins_url( 'inc/img/deactivated.png', dirname(__FILE__) ) ) ?>"/>

				<?php } ?>
				<br/><br/>
				
				<!-- License key field. -->
				<input <?php if( $is_valid == 'valid' ) { echo 'disabled'; } ?> style="text-align:center;" id="tmmp_license_key" name="tmmp_license_key" type="text" class="regular-text" placeholder="Enter your license key here" value="<?php echo $license; ?>" />
				
				<!-- Shows message if tried to activate. -->
				<?php if (isset($message)) { echo '<div style="clear:both;"></div><p style="display: inline-block;background: whitesmoke;padding: 10px 18px; border-radius:4px; margin-bottom: 0;font-size: 16px;">'.$message. '</p>'; } ?>
				
				<!-- Show license status. -->
				<?php echo '<p>' .$status. '</p>' ?>
				
				<!-- If license isn't valid, show button to retry activation. -->
				<?php if( $is_valid != 'valid' ) {
					wp_nonce_field( 'tmmp_nonce', 'tmmp_nonce' ); ?>
					<input type="submit" class="button-secondary" name="tmmp_license_activate" value="<?php _e('Activate License'); ?>"/>
				<?php } ?>

			</form>

		</div>

		
		<!-- More information. -->
		<div class="license-box" style="border-radius:5px; max-width:800px; margin-top:30px; background:white; padding: 30px; display:block;">

					<h1 style="text-align:center; margin-bottom:25px;">More information</h1>

					<h2>Why should I activate my license?</h2>
					<p style="font-size:15px; color:#555;">
						An active license allows you to always stay up to date whenever there are <strong>new releases</strong> for your plugin(s) and gives you access to <strong>priority support</strong> (faster answers, extended support). This helps to prevent any future issue related to incompatibilities with new WordPress releases or theme/plugin conflicts. We frequently update our products to make sure they are error-free and future-proof.
					</p>

					<h2 style="margin-top:30px;">What happens when my license expires?</h2>
					<p style="font-size:15px; color:#555;">
						Nothing to worry about, your plugin will <strong>still fully works</strong> as it should, all the <strong>PRO features will still be functional</strong>. You simply will <strong>not</strong> receive updates and benefit from priority support anymore.
					</p>

					<h2 style="margin-top:30px;">Where is my license key?</h2>
					<p style="font-size:15px; color:#555;">
						Your license key can be found in the <strong>purchase receipt</strong> that was sent to you when you purchased your item(s).
					</p>

					<h2 style="margin-top:30px;">I have a question</h2>
					<p style="font-size:15px; color:#555;">
						If you need more help, please <a href="https://wpdarko.com/support/submit-a-request/" title="Submit a support request">submit a request</a> in our help center.
					</p>

		</div>

		
	<?php
}


/* Tries to activate the license. */
function tmmp_activate_license() {

	// Listens for our activate button to be clicked
	if( isset( $_POST['tmmp_license_activate'] ) ) {

		// Runs a quick security check
	 	if( ! check_admin_referer( 'tmmp_nonce', 'tmmp_nonce' ) )
			return; 

		$license_key = trim($_POST['tmmp_license_key']);
		
		// data to send in our API request
		$api_params = array(
			'edd_action' => 'activate_license',
			'license'    => $license_key,
			'item_id' => TMMP_ITEM_ID, // the name of our product in EDD
			'url'        => home_url()
		);

		// Call WP Darko.
		$response = wp_remote_post( TMMP_STORE_URL, array( 'timeout' => 15, 'sslverify' => false, 'body' => $api_params ) );

		// Makes sure the response came back okay
		if ( is_wp_error( $response ) || 200 !== wp_remote_retrieve_response_code( $response ) ) {

			if ( is_wp_error( $response ) ) {
				$message = $response->get_error_message();
			} else {
				$message = __( 'An error occurred, please try again.' );
			}

		} else {

			$license_data = json_decode( wp_remote_retrieve_body( $response ) );

			if ( false === $license_data->success ) {

				switch( $license_data->error ) {

					case 'expired' :

						$message = sprintf(
							__( 'This license key expired on %s.' ),
							date_i18n( get_option( 'date_format' ), strtotime( $license_data->expires, current_time( 'timestamp' ) ) )
						);
						break;

					case 'disabled' :
					case 'revoked' :

						$message = __( 'Your license key has been disabled.' );
						break;

					case 'missing' :

						$message = __( 'Your license key is invalid.' );
						break;

					case 'invalid' :
					case 'site_inactive' :

						$message = __( 'Your license is not active for this URL.' );
						break;

					case 'item_name_mismatch' :

						$message = __( 'This appears to be an invalid license key for this product' );
						break;

					case 'no_activations_left':

						$message = __( 'Your license key has reached its activation limit.' );
						break;

					default :

						$message = __( 'An error occurred, please try again.' );
						break;
				}

			} else {
				update_option( 'tmmp_license_key', $license_key );
			}

		}

		// Check if anything passed on a message constituting a failure
		if ( ! empty( $message ) ) {
			$base_url = admin_url( 'edit.php?post_type=tmm&page=' . TMMP_PLUGIN_LICENSE_PAGE );
			$redirect = add_query_arg( array( 'sl_activation' => 'false', 'message' => urlencode( $message ) ), $base_url );

			wp_redirect( $redirect );
			exit();
		}
		
		wp_redirect( admin_url( 'edit.php?post_type=tmm&page=' . TMMP_PLUGIN_LICENSE_PAGE) );
		exit();
	}
}
add_action('admin_init', 'tmmp_activate_license');


/* Checks license key. */
function tmmp_check_license() {

	global $wp_version;

	$license = trim( get_option( 'tmmp_license_key' ) );

	$api_params = array(
		'edd_action' => 'check_license',
		'license' => $license,
		'item_id' => TMMP_ITEM_ID,
		'url'       => home_url()
	);

	// Call WP Darko.
	$response = wp_remote_post( TMMP_STORE_URL, array( 'timeout' => 15, 'sslverify' => false, 'body' => $api_params ) );

	if ( is_wp_error( $response ) )
		return 'Error';

	/* Decodes response. */
	$license_data = json_decode( wp_remote_retrieve_body( $response ) );
	
	/* Gets current date. */
	$current_date = date( 'Y-m-d H:i:s', current_time( 'timestamp', 0 ) );

	/* Test if expired. */
	if (isset($license_data->expires) && $current_date > $license_data->expires) {
		$expired = true;
	} else {
		$expired = false;
	}

	/* License is valid.. */
	if( $license_data && $license_data->license == 'valid' ) {
		return ['valid', 'Current status: <strong style="color: #628134;">Your license is valid.</strong>'];
	/* License is expired. */
	} else if ($expired) {
		return ['invalid', 'Current status: <strong style="color: #de3c7a;">Your license is expired</strong>.'];
	/* License is invalid. */
	} else {
		return ['invalid', '<strong style="color: #777777;">Please enter a valid license.</strong>'];
	}
	
}