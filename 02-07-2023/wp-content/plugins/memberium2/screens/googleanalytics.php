<?php
/**
 * Copyright (c) 2012-2022 David J Bullock
 * Web Power and Light, LLC
 * https://webpowerandlight.com
 * support@webpowerandlight.com
 */

 class_exists( 'm4is_emz57o' ) || die(); current_user_can( 'manage_options' ) || wp_die( __( 'You do not have sufficient permissions to access this page.' ) ); global $wpdb; $m4is_a8enl = 5; $m4is_bd92x = memberium_app()->get_i2sdk_options(); $m4is_b5mu9n = (array) memberium_app()->m4is_mmdrl('ga_customvars'); $m4is_p74mg = [ '' => '[Select the Variable]', '!system.membership_level' => 'Membership Level', '!system.membership_name' => 'Membership Name', ]; $m4is_kbu63_ = m4is_f84s3h::m4is_cm6nr('Contact', TRUE ); $m4is_ay7a = ['']; foreach ($m4is_kbu63_ as $m4is_celntz => $m4is_tenvhx ) { $m4is_p74mg['!contact.' . strtolower($m4is_tenvhx ) ] = 'Contact ' . $m4is_tenvhx; } $m4is_kbu63_ = m4is_f84s3h::m4is_cm6nr('Affiliate', TRUE); foreach ($m4is_kbu63_ as $m4is_celntz => $m4is_tenvhx ) { $m4is_p74mg['!affiliate.' . strtolower($m4is_tenvhx ) ] = 'Affiliate ' . $m4is_tenvhx; } if ($_SERVER['REQUEST_METHOD'] == 'POST' ) {  if (isset($_POST['add-variable'] ) ) { $m4is_b5mu9n[$_POST['slot_id']] = [ 'name' => $_POST['slot_name'], 'variable' => $_POST['slot_variable'], 'label' => $m4is_p74mg[$_POST['slot_variable']], ]; m4is__95_::m4is_hbfrj('Custom Variable Added' ); }  if (!empty($_POST['delete'] ) ) { foreach ($_POST['delete'] as $m4is_ap3_ => $m4is_rhfd ) { if ($m4is_rhfd == 'on' ) { unset($m4is_b5mu9n[$m4is_ap3_] ); m4is__95_::m4is_hbfrj('Custom Variable Deleted' ); } } }  memberium_app()->m4is_oqwxk($m4is_b5mu9n, 'ga_customvars'); } $m4is_pnms = []; for ($i = 1; $i <= $m4is_a8enl; $i++ ) { if (!isset($m4is_b5mu9n[$i] ) ) { $m4is_pnms[] = $i; } } m4is__95_::m4is_r6_jy(); ?>
<div class="wrap">
	<h1>Memberium Google Analytics Settings</h1>
	<?php
 if (count($m4is_b5mu9n ) > $m4is_a8enl ) { echo '<tr><td colspan="6">', _e('All custom variable slots are assigned.' ), '</td></tr>'; } else { $m4is_ekl7p = ''; foreach ($m4is_p74mg as $m4is_rhfd => $m4is_a4jlfw ) { $m4is_ekl7p.= '<option value="' . $m4is_rhfd . '">' . $m4is_a4jlfw . '</option>'; } $m4is_hb_6tg = ''; foreach ($m4is_pnms as $m4is_a4jlfw ) { $m4is_hb_6tg.= '<option value="' . $m4is_a4jlfw . '">' . $m4is_a4jlfw . '</option>'; } ?>
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
						<td><select name="slot_id" required="required"><?php echo $m4is_hb_6tg; ?></select></td>
						<td><select name="slot_variable" required="required"><?php echo $m4is_ekl7p; ?></select></td>
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
 if (count($m4is_b5mu9n ) == 0 ) { echo '<td colspan="99">You have no custom variables defined.</td>'; } else { foreach ( (array)$m4is_b5mu9n as $m4is_u5dnxi => $m4is_yphjy ) { echo '<tr>'; echo '<td>'; echo $m4is_yphjy['name']; echo '</td>'; echo '<td>'; echo $m4is_u5dnxi; echo '</td>'; echo '<td>'; echo $m4is_yphjy['label']; echo '</td>'; echo '<td>'; echo '<input type="checkbox" name="delete[' . $m4is_u5dnxi . ']">'; echo '</td>'; echo '</tr>'; } } ?>
			</table>
			&nbsp;<br />
			<input type="submit" name="delete-variables" value="Delete Custom Variables" class="button-secondary" />
		</form>
	</div>
</div>
<hr />
