<?php if ( ! defined( 'ABSPATH' ) ) exit; ?>
		<div id="manual_completions_learndash" class="manual_completions_learndash">
			<h2>
				<img style="margin-right: 10px;" src="<?php echo esc_url(plugin_dir_url(__FILE__)."img/icon_30x30.png"); ?>"/>
				Manual Completions for LearnDash
			</h2>
			<hr>
			<table>
				<tr id="upload_csv">
					<td style="min-width: 100px">File</td>
					<td>
						<?php 
						if(!empty($upload_error)) {
							?>
							<div style="color: red">
								<?php echo $upload_error; ?>
							</div>
							<?php 
						}
						?>
						<form  method="post" enctype="multipart/form-data"><input type="file" name="completions_file">
						<input type="submit" name="manual_completions_learndash" value="Upload">
						</form>
						<div>
							<?php _e("Upload a CSV file (expected columns: user_id, course_id, lesson_id, topic_id, quiz_id) or select the options from below. ", "manual_completions_learndash"); ?>
							<br><br>
						</div>
					</td>
				</tr>
				<tr id="course">
					<td style="min-width: 100px"><?php _e("Course", "manual_completions_learndash"); ?></td>
					<td style="min-width: 400px"> 
						<select id="course_id" name="course_id" onchange="manual_completions_learndash_course_selected(this)">
							<option value=""><?php _e("-- SELECT --", "manual_completions_learndash"); ?></option>
							<?php foreach ($courses as $key => $course): ?>
								<option value="<?php echo $course->ID; ?>"><?php echo $course->post_title; ?></option>
							<?php endforeach ?>
						</select>
					</td>
				</tr>
				<tr id="lesson" style="display: none;" onchange="manual_completions_learndash_lesson_selected(this)">
					<td>Lesson</td>
					<td> 
						<select id="lesson_id" name="lesson_id">
							<option value=""><?php _e("-- SELECT --", "manual_completions_learndash"); ?></option>
							<option value="all"><?php _e("-- Entire Course --", "manual_completions_learndash"); ?></option>
						</select>
					</td>
				</tr>
				<tr id="topic" style="display: none;" onchange="manual_completions_learndash_topic_selected(this)">
					<td>Topic</td>
					<td> 
						<select id="topic_id" name="topic_id">
							<option value=""><?php _e("-- SELECT --", "manual_completions_learndash"); ?></option>
							<option value="all"><?php _e("-- Entire Lesson --", "manual_completions_learndash"); ?></option>
						</select>
					</td>
				</tr>
				<tr id="quiz" style="display: none;">
					<td>Quiz</td>
					<td> 
						<select id="quiz_id" name="quiz_id" onchange="manual_completions_learndash_quiz_selected(this)">
							<option value=""><?php _e("-- SELECT --", "manual_completions_learndash"); ?></option>
						</select>
					</td>
				</tr>
				<tr id="users" style="display: none;">
					<td>Users</td>
					<td> 
						<select id="user_ids" name="user_ids" multiple="multiple" onchange="manual_completions_learndash_users_selected(this)">
							<?php foreach ($users as $user) { ?>
								<option value="<?php echo $user->ID; ?>"><?php echo $user->ID.". ".$user->display_name; ?></option>
							<?php } ?>
						</select>
						<?php _e("(Select Users, or, enter comma separated or space separated user_id. You can even copy/paste from CSV. Hit SPACE BAR after pasting.)", "manual_completions_learndash"); ?>
					</td>
					<br>
					<td><button onclick="manual_completions_learndash_get_enrolled_users()" class="button"><?php _e("Get All Enrolled Users", "manual-completions-learndash"); ?></button></td>
				</tr>
			</table>
		</div>
		<div id="manual_completions_learndash_table" class="manual_completions_learndash">
			<div class="button-secondary" id="process_completions" onclick="manual_completions_learndash_mark_complete()"><?php _e("Process Selected Completions", "manual_completions_learndash"); ?> <span class="count"></span></div>
			<div class="button-secondary" id="check_completions" onclick="manual_completions_learndash_check_completion()"><?php _e("Check Completion Status", "manual_completions_learndash"); ?> <span class="count"></span></div>
			<br>
			<div class="force_completion">
				<input id="force_completion" type="checkbox"> <?php _e("Force Completion (Ignore xAPI Content Completion Status)", "manual_completions_learndash"); ?>
			</div>

			<table class="grassblade_table" style="width: 100%">
				<tr class="header">
					<th><input type="checkbox" id="select_all"></th>
					<th><?php _e("S.No", "manual_completions_learndash"); ?></th>
					<th><?php _e("User", "manual_completions_learndash"); ?></th>
					<th><?php _e("Course", "manual_completions_learndash"); ?></th>
					<th><?php _e("Lesson", "manual_completions_learndash"); ?></th>
					<th><?php _e("Topic", "manual_completions_learndash"); ?></th>
					<th><?php _e("Quiz", "manual_completions_learndash"); ?></th>
					<th><?php _e("Actions", "manual_completions_learndash"); ?></th>
					<th><?php _e("Status", "manual_completions_learndash"); ?></th>
				</tr>
			</table>
		</div>