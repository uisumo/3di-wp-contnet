<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}
?>


<h1>Automation Recipes</h1> 
<hr>
<div id="vueapp">
	<router-view></router-view>
</div>
<script>
	window.webpack_public_path = '<?php echo INFUSEDWOO_CDN_URL; ?>';
</script>
<script src="<?php echo INFUSEDWOO_CDN_URL . "chunks/vendors~automationAdmin.bundle.js?ver=" . INFUSEDWOO_CDN_VER; ?>"></script>
<script src="<?php echo INFUSEDWOO_CDN_URL . "automationAdmin.js?ver=" . INFUSEDWOO_CDN_VER; ?>"></script>