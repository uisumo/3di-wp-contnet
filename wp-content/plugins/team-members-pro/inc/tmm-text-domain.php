<?php 

/* Loads plugin's text domain. */
add_action( 'plugins_loaded', 'tmmp_load_plugin_textdomain' );
function tmmp_load_plugin_textdomain() {
  load_plugin_textdomain( TMMP_TXTDM, FALSE, TMMP_PATH . 'lang/' );
}

?>