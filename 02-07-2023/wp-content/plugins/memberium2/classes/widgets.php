<?php
/**
 * Copyright (c) 2012-2022 David J Bullock
 * Web Power and Light
 */

 class_exists('m4is_emz57o') || die();   final 
class m4is_kn2s extends WP_Widget { 
function __construct() { parent::__construct( 'foo_widget',  __('Memberium Login', 'memberium'),  ['description' => __('Memberium Login Widget', 'memberium')]  ); }   
function widget($m4is_w5ky4q, $m4is_jprj8) { echo $m4is_w5ky4q['before_widget']; if (! empty($m4is_jprj8['title']) ) {  } echo '<h3 class="widget-title">', __('Login', 'memberium'), '</h3>'; echo do_shortcode('[memb_loginform]'); echo $m4is_w5ky4q['after_widget']; }  
function form($m4is_jprj8) { $title = ! empty($m4is_jprj8['title']) ? $m4is_jprj8['title'] : __('New title', 'text_domain'); ?>
		<p>
			<label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Hide When Logged In:'); ?></label>
			<input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo esc_attr($title); ?>">
		</p>
		<p>
			<label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Title:'); ?></label>
			<input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo esc_attr($title); ?>">
		</p>
		<?php
 }  
function update($m4is_ojm2g, $m4is_kx1n74) { $m4is_jprj8 = []; $m4is_jprj8['title'] = (! empty($m4is_ojm2g['title']) ) ? strip_tags($m4is_ojm2g['title']) : ''; return $m4is_jprj8; } }
