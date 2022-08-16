<?php
/**
 * Copyright (c) 2018-2020 David J Bullock
 * Web Power and Light
 */

 if ( !defined( 'ABSPATH' ) ) { die(); } final class wplfle_d { static public function log($file = '', $function = '', $line = 0, $description = '', $data = NULL) { if ( is_admin() ) {  } if ( isset( $_GET['doing_wp_cron'] ) ) { return; } global $user; $session_id = $_SERVER['REMOTE_ADDR'] . '::' . isset( $_SERVER['REQUEST_TIME_FLOAT'] ) ? $_SERVER['REQUEST_TIME_FLOAT'] : $_SERVER['REQUEST_TIME']; $output = $session_id . ' :: ' . microtime( true ); $output .= ' :: ' . ( function_exists( 'get_current_user_id' ) ? get_current_user_id() : 0 ); if ( function_exists( 'current_filter' ) ) { $output .= ' :: ' . current_filter(); } $output .= ' :: '; $output .= basename( $file ) . ' -> ' . $function . ' -> ' . $line . " :: "; if ( isset( $data ) ) { $output .= $description . ' = '; if ( is_array( $data ) || is_object( $data ) ) { $output .= print_r( $data, true ); } elseif ( is_bool( $data ) ) { $output .= $data ? 'True' : 'False'; } else { $output .= $data; } } else { $output .= $description; } $output .= "\n"; if ( WPAL_BLOCKS_DEBUGLOG == 'error_log:' ) { error_log( $output ); } elseif ( WPAL_BLOCKS_DEBUGLOG > '' ) { file_put_contents( WPAL_BLOCKS_DEBUGLOG, $output, FILE_APPEND ); } else { echo nl2br( $output ); } } }
