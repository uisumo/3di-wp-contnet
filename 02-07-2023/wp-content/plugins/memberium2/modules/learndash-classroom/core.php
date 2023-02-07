<?php
/**
 * Copyright (c) 2012-2020 David J Bullock
 * Web Power and Light
 */

 class_exists('m4is_emz57o') || die(); final 
class m4is_d2ia5 { public 
function m4is_zi_r9j() { return [ '_memberium_lms_groupcourse_autoenroll', ]; } 
function m4is_jt93(int $m4is_q4c_xa, int $m4is_xe9a) { $m4is_aicfp = memberium_app()->m4is_r231y($m4is_q4c_xa); if ($m4is_aicfp) { $m4is_ceyf7 = learndash_group_enrolled_courses($m4is_xe9a); $m4is_m9p1te = []; foreach($m4is_ceyf7 as $m4is_u6ixo) { $m4is_du5f6 = array_filter(explode(',', get_post_meta($m4is_xe9a, '_memberium_lms_groupcourse_autoenroll', true) ) ); $m4is_m9p1te = array_merge($m4is_m9p1te, $m4is_du5f6); } if (! empty($m4is_m9p1te)) { $m4is_m9p1te = array_unique($m4is_m9p1te); $m4is_aicfp = memberium_app()->m4is_r231y($m4is_q4c_xa); if ($m4is_aicfp) { memberium_app()->elf_add_remove_crm_tags($m4is_m9p1te, $m4is_aicfp); } } } } 
function m4is_cewr(int $m4is_q4c_xa, int $m4is_xe9a) { $m4is_aicfp = memberium_app()->m4is_r231y($m4is_q4c_xa); if ($m4is_aicfp) { $m4is_ceyf7 = learndash_group_enrolled_courses($m4is_xe9a); $m4is_m9p1te = []; foreach($m4is_ceyf7 as $m4is_u6ixo) { $m4is_du5f6 = array_filter(explode(',', get_post_meta($m4is_xe9a, '_memberium_lms_groupcourse_autoenroll', true) ) ); $m4is_m9p1te = array_merge($m4is_m9p1te, $m4is_du5f6); } if (! empty($m4is_m9p1te)) { $m4is_m9p1te = array_unique($m4is_m9p1te); foreach($m4is_m9p1te as $m4is_ap3_ => $m4is_w9feq2) { $m4is_m9p1te[$m4is_ap3_] = (int) "-{$m4is_w9feq2}"; } $m4is_m9p1te = implode(',', $m4is_znf9); memberium_app()->elf_add_remove_crm_tags($m4is_m9p1te, $m4is_aicfp); } } } private 
function m4is_ap508() { add_action('ld_removed_group_access', [$this, 'm4is_cewr'], 10, 2); add_action('ld_added_group_access', [$this, 'm4is_jt93'], 10, 2);  } private 
function __construct() { $this->m4is_ap508(); if (is_admin() && require_once(__DIR__ . '/admin.php') ) { m4is_d91gz::m4is_a6x52r(); } } static 
function m4is_a6x52r() : self { static $m4is_jprj8 = false; return $m4is_jprj8 ? $m4is_jprj8 : $m4is_jprj8 = new self; } }
