<?php
add_action( 'show_user_profile', 'wdm_group_courses_fields' );
add_action( 'edit_user_profile', 'wdm_group_courses_fields' );

function wdm_group_courses_fields( $user ) {
	$ld_groups = learndash_get_users_group_ids($user->ID);
	if(!empty($ld_groups)){
		wp_nonce_field( "wdm_group_courses", "wdm_group_courses" );
		$flag = true;
		$wdm_group_ids = array();
		foreach ($ld_groups as $g_id) {
			$user_meta = get_user_meta($user->ID,"wdm_group_".$g_id,true);
				if($flag){
					$flag = false;
?>
					<h3><?php _e("Course access through groups:","wdm-ld-custom");?></h3>
					<table class="form-table">
<?php
				}
?>
				<tr>
					<th><?php echo get_the_title($g_id);?></th>
					<td>
						<?php
							$group_courses = learndash_group_enrolled_courses($g_id);
							if(!empty($group_courses)){
								$wdm_group_ids[] = $g_id;
								foreach ($group_courses as $c_id) {
						?>
								<input id="checkBox" type="checkbox" name="wdm_group_course[<?php echo $g_id;?>][]" value="<?php echo $c_id;?>" <?php if(in_array($c_id,$user_meta) || $user_meta == ''){echo 'checked';}?>><?php echo get_the_title($c_id);?><br>
						<?php
								}
							}
							else{
								_e("No courses found.","wdm-ld-custom");
							}
						?>
					</td>
				</tr>
			<?php
			}
		?>
		<input type="hidden" name="wdm_group_ids" value="<?php echo implode(",", $wdm_group_ids)?>">
	</table>
<?php
	}
}

add_action( 'personal_options_update', 'wdm_save_group_courses_fields' );
add_action( 'edit_user_profile_update', 'wdm_save_group_courses_fields' );

function wdm_save_group_courses_fields( $user_id ) {
	if ( !current_user_can( 'edit_user' ) )
		return false;

	if( isset( $_POST['wdm_group_courses'] ) && wp_verify_nonce( $_POST['wdm_group_courses'], 'wdm_group_courses' ) ){
		$user_groups = (array)json_decode( stripslashes( $_POST['learndash_user_groups'][$user_id] ) );
		if(isset($_POST["wdm_group_ids"])){
			$groups = explode(",", $_POST["wdm_group_ids"]);
    		foreach ($groups as $group) {
    			if(in_array($group, $user_groups)){
					update_user_meta($user_id, "wdm_group_".$group, array());
				}
				else{
					delete_user_meta( $user_id, "wdm_group_".$group );
				}
			}
    	}
		clean_user_cache( $user_id );
    	wp_cache_delete( $user_id, 'user_meta' );
    	if(isset($_POST["wdm_group_course"])){
			foreach ($_POST["wdm_group_course"] as $key => $value) {
				if(in_array($key, $user_groups)){
					update_user_meta($user_id, "wdm_group_".$key, $value);
				}
			}
		}
	}
}