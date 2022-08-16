<?php
 if (!defined('ABSPATH' ) ) { die(); } if (!current_user_can('manage_options' ) ) { wp_die(__('You do not have sufficient permissions to access this page.' ) ); } global $wpdb, $i2sdk; $vwpls_y1wo = 5; $vwplfqgl3j = get_option('i2sdk' ); $this->settings = wplz8bid::wplvf1d(); $vwplrh7i = (array)$this->settings['ga_customvars']; $vwplag6f = array('' => '[Select the Variable]', '!system.membership_level' => 'Membership Level', '!system.membership_name' => 'Membership Name', ); $vwplmu62n = wpllbej::wplntnyv('Contact', TRUE ); $vwplrbh71u = array('' ); foreach ($vwplmu62n as $vwplq_baoi => $vwpl_s6l ) { $vwplag6f['!contact.' . strtolower($vwpl_s6l ) ] = 'Contact ' . $vwpl_s6l; } $vwplmu62n = wpllbej::wplntnyv('Affiliate', TRUE); foreach ($vwplmu62n as $vwplq_baoi => $vwpl_s6l ) { $vwplag6f['!affiliate.' . strtolower($vwpl_s6l ) ] = 'Affiliate ' . $vwpl_s6l; } if ($_SERVER['REQUEST_METHOD'] == 'POST' ) {  if (isset($_POST['add-variable'] ) ) { $vwplrh7i[$_POST['slot_id']] = array('name' => $_POST['slot_name'], 'variable' => $_POST['slot_variable'], 'label' => $vwplag6f[$_POST['slot_variable']], ); wpljwbf2::wplc1on7('Custom Variable Added' ); }  if (!empty($_POST['delete'] ) ) { foreach ($_POST['delete'] as $vwply17edn => $vwplph268z ) { if ($vwplph268z == 'on' ) { unset($vwplrh7i[$vwply17edn] ); wpljwbf2::wplc1on7('Custom Variable Deleted' ); } } }  $this->settings['ga_customvars'] = $vwplrh7i; update_option('memberium', $this->settings ); } $vwplprod0h = array( ); for ($i = 1; $i <= $vwpls_y1wo; $i++ ) { if (!isset($vwplrh7i[$i] ) ) { $vwplprod0h[] = $i; } } wpljwbf2::wplyb40j1(); ?>
<div class="wrap">
	<h1>Memberium Google Analytics Settings</h1>
	<?php
 if (count($vwplrh7i ) > $vwpls_y1wo ) { echo '<tr><td colspan="6">', _e('All custom variable slots are assigned.' ), '</td></tr>'; } else { $vwpllzt8p = ''; foreach ($vwplag6f as $vwplph268z => $vwplaco6 ) { $vwpllzt8p.= '<option value="' . $vwplph268z . '">' . $vwplaco6 . '</option>'; } $vwplwnuca = ''; foreach ($vwplprod0h as $vwplaco6 ) { $vwplwnuca.= '<option value="' . $vwplaco6 . '">' . $vwplaco6 . '</option>'; } ?>
		<h3>Add New Custom Variable</h3>
		<div style="width:800px;">
			<form method="POST" action="">
				<table class="widefat">
					<tr>
						<th>Custom Variable Label</th>
						<th>Order</th>
						<th>Value</th>
					</tr>
					<tr>
						<td><input name="slot_name" type="text" size="25" required="required" placeholder="Your name for this variable"/></td>
						<td><select name="slot_id" required="required"><?php echo $vwplwnuca; ?></select></td>
						<td><select name="slot_variable" required="required"><?php echo $vwpllzt8p; ?></select></td>
					</tr>
				</table>
				&nbsp;<br />
				<input type="submit" name="add-variable" value="Add Custom Variable" class="button-primary" />
				<hr />
			</form>
		</div>
		<?php
 } ?>
	<h3>Current Custom Variables</h3>
	<div style="width:800px;">
		<form method="POST" action="">
			<hr />
			<table class="widefat" style="white-space:nowrap;">
				<tr>
					<th>Custom Variable Label</th>
					<th>Order</th>
					<th>Value</th>
					<th>Delete?</th>
				</tr>
				<?php
 if (count($vwplrh7i ) == 0 ) { echo '<td colspan="99">You have no custom variables defined.</td>'; } else { foreach ( (array)$vwplrh7i as $vwplsew_ => $vwplcrqu ) { echo '<tr>'; echo '<td>'; echo $vwplcrqu['name']; echo '</td>'; echo '<td>'; echo $vwplsew_; echo '</td>'; echo '<td>'; echo $vwplcrqu['label']; echo '</td>'; echo '<td>'; echo '<input type="checkbox" name="delete[' . $vwplsew_ . ']">'; echo '</td>'; echo '</tr>'; } } ?>
			</table>
			&nbsp;<br />
			<input type="submit" name="delete-variables" value="Delete Custom Variables" class="button-secondary" />
		</form>
	</div>
</div>
<hr />
