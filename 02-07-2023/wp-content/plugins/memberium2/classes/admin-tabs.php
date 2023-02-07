<?php
/**
 * Copyright (C) 2018-2022 David Bullock
 * Web Power and Light, LLC
 * https://webpowerandlight.com
 * support@webpowerandlight.com
 *
 */

 class_exists('m4is_emz57o') || die(); final 
class m4is_mxg2 { private $tabs = []; private $headers = []; private $default = ''; private $current_tab = ''; 
function __construct() { $this->tabs = []; $this->headers = []; $this->default = ''; $this->current_tab = ''; }  
function m4is_vr1up(string $m4is_l0waz = '', string $m4is_a4jlfw = '', string $m4is_t_qmg = '', $m4is_ut6vn = '', string $m4is_eia3uo = '') { $this->tabs[$m4is_t_qmg] = [ 'icon' => $m4is_l0waz, 'label' => $m4is_a4jlfw, 'slug' => strtolower(trim($m4is_t_qmg) ), 'method' => $m4is_ut6vn, 'post' => $m4is_eia3uo, ]; if (count($this->tabs) == 1) { $this->m4is_tjdr($m4is_t_qmg); } }  
function m4is_ngco(array $m4is_m_fnw0) { $this->tabs = $m4is_m_fnw0; } 
function m4is_gneaiv() : array { return $this->tabs; } 
function m4is_mneuy0(string $m4is_pjws4v = '') { $this->headers[] = $m4is_pjws4v; } 
function m4is_tjdr(string $m4is_t_qmg = '') : bool { $slug = strtolower(trim($m4is_t_qmg) ); if (array_key_exists($m4is_t_qmg, $this->tabs) ) { $this->default = $m4is_t_qmg; return true; } return false; } 
function m4is_rtwq() { if (empty($this->tabs) ) { return; } $m4is_shny = $this->m4is_j_qc4(); if ($this->tabs[$m4is_shny]['post']) { $this->m4is_z4uopf($this->tabs[$m4is_shny]['post']); } m4is__95_::m4is_r6_jy(); echo '<div class="wrap about-wrap memberium">'; foreach($this->headers as $m4is_afrae) { echo $this->m4is_z4uopf($m4is_afrae); } echo '</div>'; echo '<div class="wrap">';  echo '<h4 class="nav-tab-wrapper">'; foreach ($this->tabs as $m4is_t_qmg => $m4is_obgvz) { $m4is_mn_xj = 'nav-tab'; $m4is_mn_xj .= ($m4is_obgvz['slug'] == $m4is_shny) ? ' nav-tab-active' : ''; if ($m4is_obgvz['slug'] == $m4is_shny) { echo "<span class='{$m4is_mn_xj}'><i class='{$m4is_obgvz['icon']}'></i> {$m4is_obgvz['label']}</span>"; } else { echo "<a class='{$m4is_mn_xj}' href='?page={$_GET['page']}&tab={$m4is_obgvz['slug']}'><i class='{$m4is_obgvz['icon']}'></i> {$m4is_obgvz['label']}</a>"; } } echo '</h4>'; echo '<div class="memberium_tabcontent" style="margin-top:10px;">'; echo $this->m4is_z4uopf($this->tabs[$m4is_shny]['method']); echo '</div>'; } 
function m4is_j_qc4() : string { $this->current_tab = isset($_GET['tab']) ? strtolower($_GET['tab']) : $this->default; if (! array_key_exists($this->current_tab, $this->tabs) ) { $this->current_tab = $this->default; } return $this->current_tab; }  private 
function m4is_z4uopf($m4is_pjws4v = false) { if (! empty($m4is_pjws4v) ) { if (is_array($m4is_pjws4v) ) { if (method_exists($m4is_pjws4v[0], $m4is_pjws4v[1]) ) { return call_user_func_array($m4is_pjws4v, [] ); } else { echo '<p><span style="font-weight:bold;color:red;">Error:  </span>  ', $m4is_pjws4v[0], '->', $m4is_pjws4v[1], ' not found</p>'; } } elseif (is_string($m4is_pjws4v) ) { if (function_exists($m4is_pjws4v) ) { return call_user_func($m4is_pjws4v); } elseif (file_exists($m4is_pjws4v) ) { require_once $m4is_pjws4v; } else { echo $m4is_pjws4v; } } } } }
