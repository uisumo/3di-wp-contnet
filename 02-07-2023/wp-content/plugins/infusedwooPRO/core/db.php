<?php  if(!defined('ABSPATH')){exit;}global $iw4_db_version;$iw4_db_version="1.0";function iw4_db_install(){require_once(ABSPATH.'wp-admin/includes/upgrade.php');global $wpdb;global $iw4_db_version;$installed_ver=get_option("iw4_db_version");if($installed_ver !=$iw4_db_version){$iw4_recipes=$wpdb->prefix."iw4_recipes";$sql_recipes="CREATE TABLE $iw4_recipes (
		  id mediumint(9) NOT NULL AUTO_INCREMENT PRIMARY KEY,
          created datetime DEFAULT '0000-00-00 00:00:00' NOT NULL,
		  updated datetime DEFAULT '0000-00-00 00:00:00' NOT NULL,
		  `status` VARCHAR(40) DEFAULT '' NOT NULL
		);";dbDelta($sql_recipes);$iw4_triggers=$wpdb->prefix."iw4_triggers";$sql_triggers="CREATE TABLE $iw4_triggers (
		  id mediumint(9) NOT NULL AUTO_INCREMENT PRIMARY KEY,
          recipe_id mediumint(9),
          `trigger` VARCHAR(50) DEFAULT '' NOT NULL,
          `condition` longtext NOT NULL,
          `action` longtext NOT NULL,
		  last_triggered datetime DEFAULT '0000-00-00 00:00:00' NOT NULL
		);";dbDelta($sql_triggers);$iw4_recipe_logs=$wpdb->prefix."iw4_recipe_logs";$sql_recipe_logs="CREATE TABLE $iw4_recipe_logs (
		  id mediumint(9) NOT NULL AUTO_INCREMENT PRIMARY KEY,
          recipe_id mediumint(9),
          `type` VARCHAR(100) DEFAULT '' NOT NULL,
          `info` longtext NOT NULL,
		  date_added datetime DEFAULT '0000-00-00 00:00:00' NOT NULL
		);";dbDelta($sql_recipe_logs);$iw4_run_items=$wpdb->prefix."iw4_run_items";$sql_run_items="CREATE TABLE $iw4_run_items (
		  id mediumint(9) NOT NULL AUTO_INCREMENT PRIMARY KEY,
          recipe_id mediumint(9),
          run_id VARCHAR(100) DEFAULT '' NOT NULL,
          trigger_id mediumint(9),
          stage VARCHAR(100) DEFAULT '' NOT NULL,
		  date_triggered datetime DEFAULT '0000-00-00 00:00:00' NOT NULL,
          next_trigger_date datetime DEFAULT '0000-00-00 00:00:00' NOT NULL
		);";dbDelta($sql_run_items);update_option("iw4_db_version",$iw4_db_version,false);}}iw4_db_install();