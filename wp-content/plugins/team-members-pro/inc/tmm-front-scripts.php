<?php

/* Enqueues front scripts. */
add_action( 'wp_enqueue_scripts', 'add_tmmp_scripts', 99 );
function add_tmmp_scripts() {

  /* Front end CSS. */
  wp_enqueue_style( 'tmmp', plugins_url('css/tmm_style.css', __FILE__));
  /* Front end JS. */
  wp_enqueue_script( 'tmmp', plugins_url('js/tmm.min.js', __FILE__), array( 'jquery' ));

}

?>