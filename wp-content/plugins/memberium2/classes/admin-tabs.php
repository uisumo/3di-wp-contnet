<?php
/**
 * Copyright (C) 2018-2020 David Bullock
 * Web Power and Light, LLC
 * https://webpowerandlight.com
 * support@webpowerandlight.com
 *
 */

 if (!defined('ABSPATH') ) { die(); } final class wplscex94 { private $tabs; private $headers; private $default; private $current_tab; function __construct() { $this->tabs = array(); $this->headers = array(); $this->default = ''; $this->current_tab = ''; } function wplisxv($vwplg1n5d = '', $vwplaco6 = '', $vwplxmw46 = '', $vwpljuiz = '', $vwplvlvtug = '') { $this->tabs[$vwplxmw46] = array( 'icon' => $vwplg1n5d, 'label' => $vwplaco6, 'slug' => strtolower(trim($vwplxmw46) ), 'method' => $vwpljuiz, 'post' => $vwplvlvtug, ); if (count($this->tabs) == 1) { $this->wplxs6j($vwplxmw46); } } function wplpfjz($vwpln5qyc) { $this->tabs = $vwpln5qyc; } function wplzp73j_() { return $this->tabs; } function wpla9w_($vwplj8ls = '') { $this->headers[] = $vwplj8ls; } function wplxs6j($vwplxmw46 = '') { $slug = strtolower(trim($vwplxmw46) ); if (array_key_exists($vwplxmw46, $this->tabs) ) { $this->default = $vwplxmw46; return true; } return false; } function wplp8n39f() { if (empty($this->tabs) ) { return; } $vwpl_qd2 = $this->wplgdvl7(); if ($this->tabs[$vwpl_qd2]['post']) { $this->wpl_o0lq6($this->tabs[$vwpl_qd2]['post']); } wpljwbf2::wplyb40j1(); echo '<div class="wrap about-wrap memberium">'; foreach($this->headers as $vwplr3gz9h) { echo $this->wpl_o0lq6($vwplr3gz9h); } echo '</div>'; echo '<div class="wrap">';  echo '<h4 class="nav-tab-wrapper">'; foreach ($this->tabs as $vwplxmw46 => $vwplesora) { $vwpl_7gr2b = 'nav-tab'; $vwpl_7gr2b .= ($vwplesora['slug'] == $vwpl_qd2) ? ' nav-tab-active' : ''; if ($vwplesora['slug'] == $vwpl_qd2) { echo "<span class='{$vwpl_7gr2b}'><i class='{$vwplesora['icon']}'></i> {$vwplesora['label']}</span>"; } else { echo "<a class='{$vwpl_7gr2b}' href='?page={$_GET['page']}&tab={$vwplesora['slug']}'><i class='{$vwplesora['icon']}'></i> {$vwplesora['label']}</a>"; } } echo '</h4>'; echo '<div class="tabcontent" style="margin-top:10px;">'; echo $this->wpl_o0lq6($this->tabs[$vwpl_qd2]['method']); echo '</div>'; } function wplgdvl7() { $this->current_tab = isset($_GET['tab']) ? strtolower($_GET['tab']) : $this->default; if (! array_key_exists($this->current_tab, $this->tabs) ) { $this->current_tab = $this->default; } return $this->current_tab; }  private function wpl_o0lq6($vwplj8ls = false) { if (! empty($vwplj8ls) ) { if (is_array($vwplj8ls) ) { if (method_exists($vwplj8ls[0], $vwplj8ls[1]) ) { return call_user_func_array($vwplj8ls, array() ); } else { echo '<p><span style="font-weight:bold;color:red;">Error:  </span>  ', $vwplj8ls[0], '->', $vwplj8ls[1], ' not found</p>'; } } elseif (is_string($vwplj8ls) ) { if (function_exists($vwplj8ls) ) { return call_user_func($vwplj8ls); } elseif (file_exists($vwplj8ls) ) { include_once($vwplj8ls); } else { echo $vwplj8ls; } } } } }
