<?php
	if ( ! defined( 'ABSPATH' ) ) {
		exit; // Exit if accessed directly
	}

	wp_enqueue_style( 'iw_sweetalert', INFUSEDWOO_PRO_URL . "assets/sweetalert/sweetalert.css" );
	wp_enqueue_script( 'iw_sweetalert', INFUSEDWOO_PRO_URL . "assets/sweetalert/sweetalert.min.js", array('jquery'));

	global $iwpro,$iwpro_updater;

	$lic_validity = $iwpro_updater->validateLicense();

	if(strpos($lic_validity, 'for_activation') !== false) {
		$res = $iwpro_updater->activate_site();
		if($res == 'ok') $lic_validity = 'valid';
	}

?>

<h1>Updating InfusedWoo</h1>
<hr>

<?php if(!empty($iwpro->lic_key)) { 
		$lic_covered = str_repeat('*', strlen($iwpro->lic_key) - 4) . substr($iwpro->lic_key, -4);
	?>
<div class="lickeyact">
You are using license key ending in <b><?php echo $lic_covered; ?><b> for this site.<br>
<a href="#">Click here if you want to change the license key for this site. </a>
</div>
<?php } else { ?>
To enable updates, paste your InfusedWoo License key below. The license key was sent to you via e-mail right after you purchased InfusedWoo.
<?php } ?>
<div class="enter-license" style="<?php echo !empty($iwpro->lic_key) ? 'display:none' : '' ;?>">
	<br><br>

	<div class="big-row">
		<form method="POST">
				<label>License Key</label>
				<input name="upd-lic-key" type="password" value="" style="width: 210px;" />
				<input type="submit" class="next-button" style="position: relative; top: 2px; left: 3px;" value="Save"></input>
			
		</form>
	<br>
	If for some reasons, you cannot locate your license key anymore, simply <a href="http://infusedaddons.com/support" target="_blank">contact us</a> and we'll find your license key.<br>
	</div>
</div>
<br>
<h3>Check for available updates</h3>

<?php
	if(!isset($iwpro->lic_key) || empty($iwpro->lic_key)) {
		?>
		Please enter your license key first to check updates.
		<?php
	} else {
		$update_info = wp_remote_post(INFUSEDWOO_PRO_UPDATER, array('body' => array('action' => 'info')));

		if (!is_wp_error($update_info) || wp_remote_retrieve_response_code($update_info) === 200) { 
			$update_info = unserialize($update_info['body']);
			set_transient( 'infusedwoo_remote_ver', $update_info->new_version );
			
			if(version_compare(INFUSEDWOO_PRO_VER, $update_info->new_version, '<')) {
				// check license key.
				$sh = isset($_SERVER['HTTP_HOST']) ? $_SERVER['HTTP_HOST'] : $_SERVER['SERVER_NAME'];


				?>
					<center><b>There is an update available (Version <?php echo $update_info->new_version; ?>)</b>
						<br><br>
						<?php if($lic_validity == 'valid') { ?>
							<a href="#" class="attempt_update">
								<div class="big-button ">Update Now to <?php echo $update_info->new_version; ?></div>
							</a>
							<br><br>
							<div class="iw-alert alert-green" style="width: 70%; margin-left: 10px;">
								<?php 
								$current_ver_maj = explode(".", INFUSEDWOO_PRO_VER);
								$current_ver_maj = $current_ver_maj[0];
								$remote_ver_maj = explode(".", $update_info->new_version);
								$remote_ver_maj = $remote_ver_maj[0];

								if($remote_ver_maj > $current_ver_maj) {
									echo "<b>InfusedWoo " . $update_info->new_version . " is a major update version. Please ensure all themes and other plugins are updated to their latest versions to avoid compatibility conflicts.</b><br><br>";
								}
								?>
								If you have trouble updating the plugin, you may also update <a href="https://infusedaddons.com/redir.php?to=ftpupdate" target="_blank">InfusedWoo manually using FTP.</a>
							</div>
							
						<?php } else { ?>
							<div class="big-button-grayed">Update Now to <?php echo $update_info->new_version; ?></div>
							<br><br>
							<div class="iw-alert alert-red" style="width: 70%; margin-left: 10px;">Cannot update. 
								<?php 
									if($lic_validity == 'invalid') {
										echo "License Key is not valid.";
									} else if($lic_validity == 'exceed') {
										echo "License Key reached its license limit (domain count exceeded).";
									} else if($lic_validity == 'blocked') {
										echo "This site is not allowed to use the provided license key.";
									} else if($lic_validity == 'conflict') {
										echo "Duplicate site activation(s) detected. Please disable the other site to continue using InfusedWoo in this site. Or contact support if this is a mistake.";
									} else if($lic_validity == 'expired') {
										echo "License key has already expired. To update, renew your license <a href=\"https://infusedaddons.com/portal\" target=\"_blank\">in the customer portal</a>. Renew your license within 30 days after license expiration to get 50% discount.";
									} else {
										echo "Cannot check License Key Validity.";
									}
								?>
							</div>
						<?php } ?>
					</center>
					<br><br>
					<div class="big-row">
						<div class="changelogs">
					<b><u>Release Log for <?php echo $update_info->new_version; ?>:</u></b>

					<?php echo $update_info->sections['changelog']; ?>
					</div>
				<?php
			} else {
 					if($lic_validity == 'valid') { ?>
							<center><b><i>You are currently using the latest version of InfusedWoo (<?php echo INFUSEDWOO_PRO_VER; ?>). </i></b></center>
						<?php } else { ?>
							
							<center>
							<div class="iw-alert alert-red" style="width: 70%; margin-left: 10px;">Cannot check for updates. 
								<?php 
									if($lic_validity == 'invalid') {
										echo "License Key is not valid.";
									} else if($lic_validity == 'exceed') {
										echo "License Key reached its license limit (domain count exceeded).";
									} else if($lic_validity == 'blocked') {
										echo "This site is not allowed to use the provided license key.";
									}  else if($lic_validity == 'conflict') {
										echo "Duplicate site activation(s) detected. Please disable the other site to continue using InfusedWoo in this site. Or contact support if this is a mistake.";
									} else if($lic_validity == 'expired') {
										echo "License key has already expired. To update, renew your license <a href=\"https://infusedaddons.com/portal\" target=\"_blank\">in the customer portal</a>. Renew your license within 30 days after license expiration to get 50% discount.";
									} else {
										echo "Cannot check License Key Validity.";
									}
								?>
							</div>
							</center>
						<?php }


				?>
					
				<?php
			}
		} else {
			?>
			Sorry... The system was not able to check for updates, the InfusedAddons download server might be currently down at this moment. Please try again.

			<br><br>
			If you still cannot check updates after 24 hours, please <a href="http://infusedaddons.com/support" target="_blank">contact support</a>.
			<?php
		}

	}

	$admin_recheck_url = is_multisite() ? network_admin_url('update-core.php?force-check=1') : network_admin_url('update-core.php?force-check=1');
	$admin_update_url = is_multisite() ? network_admin_url('update.php?action=upgrade-plugin&plugin=infusedwooPRO/infusedwooPRO.php') : admin_url('update.php?action=upgrade-plugin&plugin=infusedwooPRO/infusedwooPRO.php');
?>

<script type="text/javascript">
	var update_attempted = false;

	jQuery('.lickeyact a').click(function() {
		jQuery('.lickeyact').hide();
		jQuery('.enter-license').show();
	});

	jQuery('.attempt_update').click(function() {
		if(update_attempted) return false;
		update_attempted = true;

		jQuery('.attempt_update').html('Updating ...');
		jQuery.get('<?php echo $admin_recheck_url; ?>',{},function() {
			location.href = "<?php echo html_entity_decode(wp_nonce_url($admin_update_url, 'upgrade-plugin_infusedwooPRO/infusedwooPRO.php')); ?>";
		});
	});

	jQuery('.enter-license form').submit(function(e) {
		e.preventDefault();

		var lic = jQuery('[name="upd-lic-key"]').val();

		if(!lic) {
			swal("Missing License Key", "Please enter an active license key." , "warning");
			return true;
		}

		swal({
		  title: "Validating License..",
		  text: "Please wait while we connect you to our licensing servers...",
		  showCancelButton: false,
		  closeOnConfirm: false,
		  showConfirmButton: false,
		  showLoaderOnConfirm: true
		});

		jQuery.post(ajaxurl + '?action=iw_activate_lic', 
			{'lic': lic },
			function(data) {
				if(data == "ok") {
					swal({
					  title: "License Activated",
					  text: "Successfully activated license. Please allow the page to reload...",
					  showCancelButton: false,
					  type: 'success',
					  closeOnConfirm: false,
					  showConfirmButton: false,
					  showLoaderOnConfirm: true
					});

					location.reload();
				} else {
						swal({
						  title: "Activation Failed",
						  text: data,
						  type: 'error',
						  html: true

						});
				}
			}
		);
	});
</script>