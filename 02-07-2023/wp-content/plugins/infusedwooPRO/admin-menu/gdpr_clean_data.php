<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}



if($_POST) {
	global $wpdb;

	$wpdb->query( "DELETE FROM $wpdb->comments WHERE `comment_author` LIKE 'InfusedWoo' AND `comment_content` LIKE '%@%'");
	$wpdb->query( "DELETE FROM {$wpdb->prefix}ia_savedcarts WHERE `email` LIKE '%@%'");

}

wp_enqueue_style( 'iw_sweetalert', INFUSEDWOO_PRO_URL . "assets/sweetalert/sweetalert.css" );
wp_enqueue_script( 'iw_sweetalert', INFUSEDWOO_PRO_URL . "assets/sweetalert/sweetalert.min.js", array('jquery'));
// search comment data:
$count = iw_count_old_identifiable_records();
?>

<h1>GDPR Data Cleanup</h1>
<hr>

<p>InfusedWoo versions below 3.9 stores email information and other identifiable information in Automation Recipe Stats and also in Abandoned Saved Carts. To be fully compliant with EU's GDPR, it is advised to clean-up (delete) these data. These kinds of information are not essential type of data as it is made only for tracking purposes. To clarify, versions 3.9 and above will still continue to gather such information but without identifiable data such as email address.</p>

<h3>Data Cleanup</h3>

<?php if($count) { ?>
<p>Click below to proceed with the data clean-up (version below 3.9 of InfusedWoo). If you still need these data, please take some time to record or backup necessary information before doing the clean-up.</p>
<form method="POST" class="cleanandata">
	<p style="color:red !important">Found <?php echo $count; ?> records containing identifiable data.</p>
	<input type="hidden" name="delanalytic" />
	<input type="submit" class="button remiad" value="Remove Identifiable Analytics Data" />
</form>
<?php } else { ?>

<p style="color:green !important">Nothing to clean. No records found with identifiable data.</p>
<?php } ?>

<script type="text/javascript">
	jQuery('.remiad').click(function() {
		swal({
		  title: "Are you sure?",
		  text: "This process will remove all identifiable data stored by InfusedWoo in the past",
		  type: "warning",
		  showCancelButton: true,
		  confirmButtonColor: "#DD6B55",
		  confirmButtonText: "Yes, please proceed",
		  closeOnConfirm: false,
		  html: false
		}, function(){
		  jQuery('.cleanandata').submit();
		});

		return false;
	});

</script>

