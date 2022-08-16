<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

// sortby save
if(isset($_GET['sortby'])) {
	update_option( 'iwar_sortby', $_GET['sortby'] );
	$sortby = $_GET['sortby'];
} else {
	$sortby = get_option( 'iwar_sortby' );
	if(empty($sortby)) $sortby = 'datecreation';
}

switch ($sortby) {
	case 'datelasttriggered':
		$args['orderby'] = 'meta_value_num';
		$args['order'] = 'DESC';
		break;
	case 'numtriggeredall':
		$args['orderby'] = 'comment_count';
		$args['order'] = 'DESC';
		break;
	case 'alphabetical':
		$args['orderby'] = 'title';
		$args['order'] = 'ASC';
		break;


}

$automation_recipes =  iw_get_recipes('IW_UserConsent_Trigger');

wp_enqueue_script('jquery-ui-autocomplete');
wp_enqueue_script('jquery-ui-datepicker');
wp_enqueue_script('jquery-ui-core');
wp_enqueue_script('jquery-ui-dialog');
wp_enqueue_style('jquery-style', 'https://ajax.googleapis.com/ajax/libs/jqueryui/1.8.2/themes/smoothness/jquery-ui.css');
wp_enqueue_style( 'iw_sweetalert', INFUSEDWOO_PRO_URL . "assets/sweetalert/sweetalert.css" );
wp_enqueue_script( 'iw_sweetalert', INFUSEDWOO_PRO_URL . "assets/sweetalert/sweetalert.min.js", array('jquery'));
wp_enqueue_script( 'iwar_chartjs', INFUSEDWOO_PRO_URL . "admin-menu/assets/Chart.min.js", array('iw_sweetalert'));
wp_enqueue_script( 'iw_automation_recipe', INFUSEDWOO_PRO_URL . "3.0/automation-recipes/automation_recipes.js", array('iw_sweetalert','iwar_chartjs','jquery-ui-datepicker','jquery-ui-autocomplete','jquery-ui-dialog'),'3.11');

do_action('adm_automation_recipe_before');

?>

<?php if(!isset($_GET['edit_recipe'])) { ?>
<h1>Consent Manager</h1>
<p>In this page, you can manage your consent topics. Consent topics are data processing choices you want to provide to your customers. GDPR requires that consent topics must be clear and concise, and must be explicitly provided by the user. <a href="https://ico.org.uk/for-organisations/guide-to-the-general-data-protection-regulation-gdpr/lawful-basis-for-processing/consent/" target="_blank">See guidelines here.</a></p>
<?php } else if($_GET['edit_recipe'] == 'new') { ?>
<a class="iw-top-control" href="?page=infusedwoo-menu-2&submenu=gdpr_consent">
<i class="fa fa-long-arrow-left"></i>&nbsp; Back to Consent Topics</a>
<h1>New Consent Topic</h1>

<?php } else if($_GET['edit_recipe'] > 0) { ?>
<a class="iw-top-control" href="?page=infusedwoo-menu-2&submenu=gdpr_consent">
<i class="fa fa-long-arrow-left"></i>&nbsp; Back to Consent Topics</a>
<h1>Edit Consent Topic</h1>
<?php } ?>

<hr>




<?php if(!isset($_GET['edit_recipe'])) { ?>

	<?php if(!is_array($automation_recipes) || count($automation_recipes) == 0) { ?>
	<center>
		<br>
	<h3>
	You currently don't have consent topics.</h3>
	<a href="?page=infusedwoo-menu-2&submenu=gdpr_consent&edit_recipe=new"><div class="blue-button" style=""> Add Consent Topic</div></a> 
	<a href="https://ico.org.uk/for-organisations/guide-to-the-general-data-protection-regulation-gdpr/lawful-basis-for-processing/consent/" target="_blank"><div class="purple-button" style="">Guidelines</div></a>
	</h3><br><br>
	

	</center>

	<?php } else { ?>
		<div class="autome-controls">
				Search <input type="text" id="search_recipes" placeholder="Search Consent Topics..." />
			<a href="?page=infusedwoo-menu-2&submenu=gdpr_consent&edit_recipe=new">
				<div class="blue-button" style="float: right;">Add Consent Topic</div><br>
			</a>
			<label>Sort by</label> <select class="browser-default" name="sortby" id="sortbyconsent" autocomplete="off">
				<option value="datecreation" <?php echo $sortby == 'datecreation' ? 'selected': ''; ?>>Date of Creation</option>
				<option value="datelasttriggered" <?php echo $sortby == 'datelasttriggered' ? 'selected': ''; ?>>Date Last Triggered</option>
				<option value="numtriggeredall" <?php echo $sortby == 'numtriggeredall' ? 'selected': ''; ?>>Number of times triggered all-time</option>
				<option value="alphabetical" <?php echo $sortby == 'alphabetical' ? 'selected': ''; ?>>Alphabetical</option>
			</select> 

		</div>
		<?php 
		$success_notice = get_transient( 'iwar_main_notice_success' );
		if($success_notice !== false) { 
			?>
			<div class="iwar-success-notice"><?php echo $success_notice; ?></div>
		<?php 
			delete_transient(  'iwar_main_notice_success' );
		} ?>
		<center class="iw_search_empty" style="display:none"><i>No consent topics found from search keyword.</i></center>
		<?php
		foreach($automation_recipes as $recipe) { 
			$new_recipe = new IW_Automation_Recipe($recipe->ID);
			$triggers = wp_count_comments($recipe->ID);
			$total_triggers = (int) $triggers->all;
			$last_triggered_timestamp = get_post_meta( $recipe->ID, 'iwar_last_triggered', true );
			$stat_disabled = get_post_meta( $recipe->ID, 'disable_stats', true );
			if(!empty($last_triggered_timestamp)) {
				if(date('Y-m-d', $last_triggered_timestamp) == date('Y-m-d')) {
					$day = 'Today';
				} else if(date('Y', $last_triggered_timestamp) == date('Y')) {
					$day = date('M-d',$last_triggered_timestamp);
				} else {
					$day = date('Y-M-d',$last_triggered_timestamp);
				}
				$last_triggered_string = 'Last Triggered: ' . $day . ' ' . date('h:i A', $last_triggered_timestamp);
			} else {
				$last_triggered_string = '';
			}

			$comments_query = new WP_Comment_Query;
			$args = array(
					'post_id' => $recipe->ID,
					'date_query' => array(
						'year'    => date( 'Y' ),
						'month'   => date( 'm' ),
						'day'	  => date( 'd' ),
					),
					'count' => 1
				);
			$triggered_today = (int) $comments_query->query( $args );

			$recipe_html = '<div class="iw-recipe-item iw-recipe-id-'.$recipe->ID . (!$new_recipe->enabled ? ' iwar-recipe-disabled' : '') . '" recipe-id="'.$recipe->ID.'">';
			$recipe_html .= '<div class="recipe-item-top">';
			if(!$stat_disabled) {
				$recipe_html .= '<div class="recipe-stats"><span class="iw-recipe-stat-today" title="# Triggered Today">'.$triggered_today.'</span><span  title="# Triggered All Time" class="iw-recipe-stat-all">'.$total_triggers.'</span></div>';
			}
			$recipe_html .= '<div class="recipe-title">'. get_the_title( $recipe->ID ) . '</div>';
			$recipe_html .= '</div>';
			$recipe_html .= '<div class="recipe-item-controls">';
			$recipe_html .= '<div class="recipe-last-triggered">'.$last_triggered_string.'</div>';
			$recipe_html .= '<a href="?page=infusedwoo-menu-2&submenu=gdpr_consent&edit_recipe='.$recipe->ID.'"><div class="recipe-control"><i class="fa fa-pencil"></i> Edit</div></a>';
			
			if($new_recipe->enabled) {
				$recipe_html .= '<a href="?page=infusedwoo-menu-2&submenu=gdpr_consent&deactivate_consent_topic='.$recipe->ID.'">';
				$recipe_html .= '<div class="recipe-control"><i class="fa fa-power-off"></i> Deactivate</div>';
				$recipe_html .= '</a>';
			} else {
				$recipe_html .= '<a href="?page=infusedwoo-menu-2&submenu=gdpr_consent&activate_consent_topic='.$recipe->ID.'">';
				$recipe_html .= '<div class="recipe-control"><i class="fa fa-power-off"></i> Activate</div>';
				$recipe_html .= '</a>';
			}
			$recipe_html .= '<div class="recipe-control cont-more"><i class="fa fa-caret-down"></i> More Actions </div>';
			$recipe_html .= '<ul class="recipe-control-more">';
			if(!$stat_disabled) {
				$recipe_html .= '<li class="show-stats-button"><i class="fa fa-line-chart"></i>Show Stats</li>';
				$recipe_html .= '<li class="hide-stats-button" style="display:none;"><i class="fa fa-line-chart"></i>Hide Stats</li>';
			}
			$recipe_html .= '<li class="manually-trigger"><i class="fa fa-share"></i>Manually Add a User</li>';
			$recipe_html .= '<li class="manually-revoke"><i class="fa fa-ban"></i>Revoke a user\'s consent</li>';
			$recipe_html .= '<a class="iwar-delete-recipe" href="?page=infusedwoo-menu-2&submenu=automation_recipes&delete_consent_topic='.$recipe->ID.'"><li><i class="fa fa-trash-o"></i>Delete</li></ul></a>';


			$recipe_html .= '</div>';
			$recipe_html .= '<div class="recipe-stat-contain">';
			$recipe_html .= '<span class="recipe-stat-control">Date Range &nbsp;<select class="browser-default iwar-stat-date-range">';
			$recipe_html .= '<option value="today">Today</option>';
			$recipe_html .= '<option value="week">This Week</option>';
			$recipe_html .= '<option value="month">This Month</option>';
			$recipe_html .= '<option value="custom">Custom</option>';
			$recipe_html .= '</select>';
			$recipe_html .= '<a class="iwar-clear-stats" href="?page=infusedwoo-menu-2&submenu=automation_recipes&clear_stats_recipe='.$recipe->ID.'"><input type="button"  value="Clear Stats" style="float:right; cursor: pointer;" /></a>';

			$recipe_html .= '&nbsp;&nbsp;<span class="custom-date"><input type="text" class="iwar-stat-start" value="'.date("m/d/Y", time()).'" /> &mdash; ';
			$recipe_html .= '<input type="text" class="iwar-stat-end" value="'.date("m/d/Y", time()).'" />&nbsp;&nbsp;<input type="button" class="iwar-update-stats" value="Update Stats" /></span>';

			$recipe_html .= '</span><center><div class="chartld">Fetching Stats...</div><div class="recipe-cv"><canvas class="recipe-stat-chart" width="500" height="200"></canvas></div></center>';
			$recipe_html .= '</div>';
			$recipe_html .= '</div>';

			
			echo $recipe_html;
		?>
		
	<?php } } ?>


<?php } else if(isset($_GET['edit_recipe'])) { 
	$recipe_id = $_GET['edit_recipe']; 
	$existing_recipe = false;
	$stat_disabled = false;
	$consent_settings = array();
	$show_checkout = false;
	$show_reg = false;
	$show_eu = false;

	if($recipe_id != 'new') {
		$settings = iwar_get_recipe_settings($recipe_id);
		$stat_disabled = get_post_meta( $recipe_id, 'disable_stats', true );
		if(!empty($settings['trigger'])) $existing_recipe = true;

		$consent_settings = get_post_meta( $recipe_id, 'consent_settings', true );

		$show_checkout = $consent_settings['show_checkout'];
		$show_reg = $consent_settings['show_reg'];
		$show_eu = $consent_settings['show_eu'];
	}
	?>

	<?php 
		$success_notice = get_transient( 'iwar_edit_notice_success' );
		if($success_notice !== false) { 
			?>
			<div class="iwar-success-notice"><?php echo $success_notice; ?></div>
		<?php 
			delete_transient(  'iwar_edit_notice_success' );
		} ?>
		<br>
	<span class="step-head">Consent Checkbox</span> <span class="step-edit select-trigger-edit" style="display: none;">[<u>Edit</u>]</span><br>
	<input type="hidden" name="recipe_id" value="<?php echo $recipe_id; ?>" />
	<div class="big-row">

			<input type="hidden" name="iwar-trigger" value="IW_UserConsent_Trigger" />
			<div class="trigger-set">

			<?php
				global $trig_main_class_iwar;
				$trigger_classes = $trig_main_class_iwar->get_available_triggers();
			?>
		</div><br>
		 Consent Subject &nbsp;&nbsp;<input placeholder="Data Subject, e.g. Product Updates ..." type="text" name="recipe-title" value="<?php echo isset($settings['title']) ? $settings['title'] : "";  ?>" style="width: 300px;" /><br>
		 
		 <br>
		 <table>
		 	<tr>
		 		<td valign="top">Checkbox Label</td>
		 		<td>&nbsp;<textarea name="consent-label" class="blue-border" placeholder="e.g. Yes, I would like to receive updates about the product ... "><?php echo isset($consent_settings['label']) ? $consent_settings['label'] : "";  ?></textarea></td>
		 	</tr>
		 </table>
		 <br>
		 <label style="width: 100%">
		 <input type="checkbox" name="consent-show-checkout" <?php echo $show_checkout ? 'checked' : ''?>/> 
		 	<span>Show checkbox in Woocommerce Checkout Page</span><br><br></label>
		 <label  style="width: 100%">
		 <input type="checkbox" name="consent-show-reg" <?php echo $show_reg ? 'checked' : ''?>/> 
		 	<span>Show checkbox in Woocommerce Registration Page</span><br><br>
		</label>
		<label  style="width: 100%">
		 <input type="checkbox" name="consent-show-eu" <?php echo $show_eu ? 'checked' : ''?>/>
			 <span> Only show if user is in EU Region</span><br><br>
		</label>

		
	</div><br>

	<span class="step-head">Infusionsoft Tag</span><br><br>
	<div class="big-row">
			Select an Infusionsoft Tag to be tied to this consent topic. If the user subscribes to this topic, the tag will be applied, and if they unsubscribe, it will be removed.
		<br><br>

		<?php 
			$tagselect = isset($consent_settings['tag']) && is_array($consent_settings['tag']) ? $consent_settings['tag'] : '';
			$html = '<div single class="consent-tied-tag">';
			$html .= '<input type="text" name="tag" class="iwar-dynasearch" data-src="infusion_tags" placeholder="Start typing search tag..." style="width: 80%;' . ($tagselect ? "display:none" : '') . '" />';
			$html .= '<div class="tag-contain dynasearch-contain">';
			
			if(!empty($tagselect)) {
				$label = isset($tagselect['label']) ? $tagselect['label'] : 'Tag ID # ' . $tagselect['value'];
				$html .= '<span class="tag-item">';
				$html .= $label;
				$html .= '<input type="hidden" name="tag-label[]" value="'.$label.'" />';
				$html .= '<input type="hidden" name="tag-val[]" value="'.$tagselect['value'].'" />';
				$html .= '<i class="fa fa-times-circle"></i>';
				$html .= '</span>';
				
			}

			$html .= '</div></div>';
			echo $html;
		?>
	</div><br>

	<div class="iw-ar-proceed">
	<span class="step-head">Display Conditions</span><br><br>

	<div class="big-row">
			Add extra conditions on when to display the consent checkbox to the user. It is best to show the consent
			checkbox if you think your users will be interested. For example, you can show the consent checkbox based on the products present in their shopping cart.
			<br>
			<div class="iwar-conditions">
				<?php 
					if(isset($settings['config']['conditions'])) {
						$conditions = $settings['config']['conditions'];
						$selected_conditions = array();
						$available_conditions = iwar_get_available_conditions($settings['trigger']);

						foreach($conditions as $condition) {
							?>
								<div class="autome-condition"><div class="autome-remove"><i class="fa fa-times"></i></div><select class="browser-default iwar_condition" name="iwar_condition[]" autocomplete="off">
									<?php foreach($available_conditions as $k => $cond) if(!in_array($k, $selected_conditions) || $cond['allow_multiple']) { ?>
										<option value="<?php echo $k ?>" <?php echo $k == $condition['condition'] ? 'selected="selected"' : ''; ?>><?php echo $cond['title']; ?></option>
									<?php } ?>
								</select>

								<form class="iwar-cond-disphtml-area">
								<?php 
									$this_cond = new $condition['condition'];
									$config = isset($condition['config']) ? $condition['config'] : array();
									echo $this_cond->display_html($config, $existing_recipe ? $settings['trigger'] : '');
								?>
							</form>
							</div>
							<?php
							$selected_conditions[] = $condition['condition'];
						}
					}
				?>
			</div>
			<div class="iwar-loading-conditions"><img src="<?php echo INFUSEDWOO_PRO_URL . "images/ajax.gif" ?>" /></div>
			<div class="blue-button iwar-add-condition" style="display:none"><i class="fa fa-plus"></i> Add Condition</div>
	</div>
	<br>
	 <span class="step-head">Actions</span><br><br>

	<div class="big-row">
			These actions will run and applied to the contact when the user gave his/her consent.
			<br>
			<div class="iwar-actions">
				<?php
				if(isset($settings['config']['actions'])) {
						$actions = $settings['config']['actions'];
						$available_actions = iwar_get_available_actions($settings['trigger']);

						foreach($actions as $action) { ?>
						<div class="autome-action"><div class="autome-remove"><i class="fa fa-times"></i></div><select class="browser-default iwar_action" name="iwar_action[]" autocomplete="off">
							<?php foreach($available_actions as $k => $act) { ?>
										<option value="<?php echo $k ?>" <?php echo $k == $action['action'] ? 'selected="selected"' : ''; ?>><?php echo $act['title']; ?></option>
									<?php } ?>
						</select>
						<form class="iwar-act-disphtml-area">
								<?php 
									$this_act = new $action['action'];
									$action_config = isset($action['config']) ? $action['config'] : array();
									$override_email = isset($action_config['_override_email']) ? $action_config['_override_email'] : '';

									echo $this_act->display_html($action_config, $existing_recipe ? $settings['trigger'] : '');
									echo '<div style="text-align: right;"><i class="fa fa-cog triggering-advanced" aria-hidden="true" title="Toggle advanced options"></i></div>';
									echo '<div class="iwar-action-override"><hr>Custom Email to Trigger&nbsp;&nbsp;<input type="text" name="_override_email" value="'.$override_email.'" class="iwar-mergeable" style="width: 210px;">';
									echo '<i class="fa fa-compress merge-button merge-overlap" aria-hidden="true" title="Insert Merge Field"></i></div>';
								?>
							</form>
						</div>
						<?php } ?>

				<?php } ?>

			</div>
			<br>
			<div class="iwar-loading-actions"><img src="<?php echo INFUSEDWOO_PRO_URL . "images/ajax.gif" ?>" /></div>
			<div class="purple-button iwar-add-action" style="display:none"><i class="fa fa-plus"></i> Add Action</div>
	</div>
	<br>
	
	<div style="margin-top: 18px;">
	<label style="width: 100%">
	<input type="checkbox" name="disable_stats" <?php echo $stat_disabled ? 'checked' : ''?>><span>Disable Stats</span>
	</label>
	</div> 
	<br>
	<?php 
		$trigger = isset($settings['trigger']) ? new $settings['trigger'] : "";

		if(!empty($trigger) && method_exists($trigger, 'admin_public_note')) {
			$add_note = $trigger->admin_public_note($recipe_id, $settings['config']);
		} else {
			$add_note = "";
		}

		if(!empty($add_note)) { 
	?>
		<div class="iwar-public-note" id="iwar-public-note">
			<?php echo $add_note; ?>
		</div>
	<?php } ?>
	<hr>
	<center>
	<div class="green-button big-button iwar-save-recipe">Save Recipe</div>
	<div class="iwar-saving-recipe" style="display:none;"><img src="<?php echo INFUSEDWOO_PRO_URL . "images/ajax.gif" ?>" /></div><br><br>
	</center>


	</div>
<?php } ?>


<?php do_action('adm_automation_recipe_after'); ?>
<div id="tinymce_dialog" class="iw-jq-modal iw-tag-dialog-modal" title="Edit Content">
	<form>
	<div style="float:left; position: relative; top: 4px; z-index: 9999"><a href="#" style="font-size: 11pt;" class="merger_link">Insert Merge Field</a></div>
	<?php wp_editor('','iwar_tinymce', array(
			'wpautop' => true, 
		    'media_buttons' => false, 
		    'textarea_name' => 'iwar_tinymce', 
		    'editor_height' => 300, 
		    'tabindex' => '',
		    'editor_css' => '', 
		    'editor_class' => '', 
		    'teeny' => false, 
		    'dfw' => false, 
		    'tinymce' => true,
		    'quicktags' => true
		)); ?>
	</form>
</div>
<script>
	jQuery(document).ready(function() {
		tinymce_dialog = jQuery("#tinymce_dialog").dialog({
		  autoOpen: false,
	      height: 550,
	      width: 800,
	      modal: true,
	      buttons: {
	      	Cancel: function() {
	          tinymce_dialog.dialog( "close" );
	        },
	        "Save Content": function() {
	        	if(tinymce_caller) {
	        		if(tinyMCE.activeEditor) {
	        			var content = tinyMCE.activeEditor.getContent();
	        		} else {
	        			var content = jQuery('textarea#iwar_tinymce').val();
	        		}
	        		tinymce_caller.children('input[type=hidden]').val(content);
	        		tinymce_dialog.dialog( "close" );

	        	}
	        },
	        
	      },
	      close: function() {
	      	if(tinyMCE.activeEditor) {
	        	tinyMCE.activeEditor.setContent('');
	        }
			jQuery('textarea#iwar_tinymce').val( '' );
			
	      }
	    });

	    jQuery('body').on('click', ".tincymce_expand", function() {
	    	tinymce_caller = jQuery(this).parent();
	    	var content = tinymce_caller.children('input[type=hidden]').val();

	    	tinymce_dialog.dialog('open');
	    	if(tinyMCE.activeEditor) {
	    		tinyMCE.activeEditor.setContent(content);
	    	}
	    	jQuery('textarea#iwar_tinymce').val(content); 
	    	return false;
	    });
	});

</script>


<div id="merge_dialog" class="iw-jq-modal iw-tag-dialog-modal" title="Insert Merge Field">
	<form>
	<table>
		<tr>
	      <td><label for="name">Merge Type</label></td>
	      <td class="merge-type-contain"><i>Loading...</i></td>
	   
	    </tr>
	    <tr>
	      <td><label for="email">Merge Field</label></td>
	      <td class="merge-field-contain"><i>Loading...</i></td>
	     </tr>
	     <tr>
	     	<td colspan="2"><a href="#" class="adv-mrg" style="font-size: 10pt;">Advanced Options</a></td>
	     </tr>
	     <tr class="iwar-adv-merge" display: none;>
	     	<td colspan="2">
	     		<hr>
	     		<label for="email">Fallback</label><br>
				<input type="text" value="" class="merge-fallback" placeholder="Enter default value..." style="margin-top: 5px;"/>
	      		<br><span class="lil-info">This is the default value that will be returned in the event that the merge field value is empty</span>
	      	</td>
	     </tr>
	 </table>
	</form>
</div>

