<?php
/**
 * Copyright (c) 2012-2020 David J Bullock
 * Web Power and Light
 */

 class_exists('m4is_emz57o') || die(); final 
class m4is_d91gz { 
function m4is_jbq9($m4is_pgsbl) { $m4is__xysg = $m4is_pgsbl->ID; $m4is_galwv0 = memberium_app()->elf_get_post_metas($m4is_pgsbl->ID, m4is_d2ia5::m4is_a6x52r()->m4is_zi_r9j(), ''); $m4is_mcisn = memberium_app()->m4is_ee0h('array');  wp_nonce_field('save_post', "memberium_learndash_classroom_nonce_{$m4is_pgsbl->ID}"); m4is__95_::m4is_e7f6( 'Classroom Auto-Enroll Tag<br>', '_memberium_lms_groupcourse_autoenroll[]', $m4is_galwv0['_memberium_lms_groupcourse_autoenroll'], 'multitaglist', [ 'help_id' => 0, 'multiple' => false, 'naked' => true, 'style' => 'width:100%;max-width:100%;', ] ); m4is_zvyj::m4is_a6x52r()->elf_generate_json_select_lists(); } 
function m4is_jb6urx($m4is__xysg = 0, $m4is_mpmkz = null, $m4is_g68c = false) { if (! m4is_zvyj::m4is_a6x52r()->m4is_kbi2($m4is__xysg, "memberium_learndash_classroom_nonce_{$m4is__xysg}", 'save_post') ) { return; } memberium_app()->elf_save_post_metas($m4is__xysg, m4is_d2ia5::m4is_a6x52r()->m4is_zi_r9j()); } 
function m4is_qchb() { $m4is_dmesa = m4is_zvyj::m4is_a6x52r()->m4is_w5zj(); if (in_array($m4is_dmesa, ['sfwd-courses']) ) { add_meta_box('memberium-learndash-classroom-actions', 'Classrooms for Memberium', [$this, 'm4is_jbq9'], $m4is_dmesa, 'side'); } add_action('save_post_sfwd-courses', [$this, 'm4is_jb6urx']); } 
function m4is_ap508() { add_action('admin_init', [$this, 'm4is_qchb']); } private 
function __construct() { $this->m4is_ap508(); } static 
function m4is_a6x52r() : self { static $m4is_jprj8 = false; return $m4is_jprj8 ? $m4is_jprj8 : $m4is_jprj8 = new self; } }
