<?php
/*
Plugin Name: LearnDash Mark Complete / AutoComplete Shortcodes
Plugin URI: http://learning-templates.com
Description: To add the Mark Complete shortcode anywhere you wish, simply insert <code>[MarkComplete]</code> into your content wherever you want. This Mark Complete Shortcode creates a button that you can place anywhere in your LearnDash course, lesson, topic or quiz. When a user clicks the button, it will update the LearnDash system marking it as completed for the current user. When the user revisits the content, it will have a button to "Jump to Next Lesson". If a Topic and/or Quiz are in the lesosn, clicking Mark Complete mark the contnet complete and jump into the topic and/or quiz. When the topic and/or quiz are completed, the user will mark the lesosn complete. To add the Auto Complete shortcode anywhere you wish, simply insert <code>[AutoComplete]</code> into your content wherever you want. This shortcode works in any lesson.
Version: 3.0.0
Author: Dennis Hall
Author URI: http://learning-templates.com
License: Copyright 2016 Learning Templates, All Rights Reserved
*/

function ld_MarkCompleteButton() {
	global $post;
	//for debugin notes, 0 = off ,1 = on 
	$show_notes = 0;
	
	//next jump page link 
	//echo learndash_get_next_lesson_redirect(get_the_ID());
	$next = learndash_next_post_link( '', true, $post );
	if($show_notes){echo 'Jumpt to nex page link:'.$next;}
	
	//hide button if topic is alreadycomplete by user 
	if(learndash_is_topic_complete(get_current_user_id(),get_the_ID())){
		?>
		<h4 style='color:#fc31a7;'>This topic is complete</h4><style>#learndash_mark_complete_button_costom { display:none;}</style>
		<?php 
		//echo "I am completed already";
	}else{
		//"I am else";
	}
	 ?>
	 <style>.green{color:green} .red{color:red}</style>
	 <?php 
	//set new mark button 
	$new_mark_btn = 0;
	$new_mark_lnk = '#';
	// check if post is lesson /only run on lesson
	if($post->post_type == 'sfwd-lessons'){
		if($show_notes){
			echo "lession id: ".$post->ID;
			echo "<br/>";
		}
		$course_progress = get_user_meta( get_current_user_id(), '_sfwd-course_progress', true );
		$q_progress = get_user_meta( get_current_user_id(), '_sfwd-quizzes', true );
		$args = array(
			'post_type' => array( 'sfwd-quiz', 'sfwd-topic'),
			'meta_key'=> 'lesson_id',
			'meta_value'=> $post->ID
		);
		$matched = new WP_Query( $args );

		//get post ids
		if($show_notes){
			echo "<pre>";
			echo "course and quiz arrays:<br/>";
			// print_r($post);
			// print_r($matched);
			print_r($course_progress);
			print_r($q_progress);
			echo "</pre>";
		}
		while ( $matched->have_posts() ){
			$matched->the_post();
			if($show_notes){
				echo '<li> title: ' . get_the_title() . '</li>';
				echo '<li> id: ' . get_the_ID() . '</li>';
			}

			//check for quiz type complete or not 
			if(get_post_type()=='sfwd-quiz'){
				if($show_notes){
					echo " there is a quiz here <br/>";
				}
				$q_matched	= 0;
				$q_progress = get_user_meta( get_current_user_id(), '_sfwd-quizzes', true );
				if(is_array($q_progress)){
					//check in every quiz 
					foreach($q_progress as $q){
						if(!in_array(get_the_ID(),$q)){
							if($show_notes){
								echo get_the_ID()."<span class='red'>this quiz is not done 1 </span><br/>";
							}
							$new_mark_btn	=	1;
							}else{
								// echo get_the_ID()."<span class='green'>this quiz is  done 1</span><br/>";
								//match for id of quiz 
								if($q['quiz']==get_the_ID()){
									if($show_notes){
										echo get_the_ID()."<span class='green'>this quiz is  done 2</span><br/>";
									}
									$new_mark_btn	=	0;
									//set quiz match to 1 so Mark button will not show
									$q_matched	= 1;
								}
							}
						}
					}else{
						$new_mark_btn	=	1; 
						if($show_notes){
						echo get_the_ID()."<span class='red'>this quiz is not done 3</span><br/>"; 
					}
				}
				//link update 
				$new_mark_lnk = get_post_meta(get_the_ID(),'activity_id',true);
				// new link not need if quiz completed 
				if($q_matched){
					$new_mark_btn	=	0;
				}
			}
			//check for topic complete or not 
			if(get_post_type()=='sfwd-topic'){
				if($show_notes){
					echo " ther is a topics here<br/>";
				}
				$course_progress = get_user_meta( get_current_user_id(), '_sfwd-course_progress', true );
				$curnt_course_id = get_post_meta(get_the_ID(),'course_id',true);
				$curnt_lesson_id = get_post_meta(get_the_ID(),'lesson_id',true);
				$curnt_topic_id = get_the_ID();

				//check in every topic 
				// echo $course_progress[$curnt_course_id]['topics'][$curnt_lesson_id][$curnt_topic_id];
				// if(!in_array($curnt_topic_id,$course_progress[$curnt_course_id]['topics'][$curnt_lesson_id])){
				if(!$course_progress[$curnt_course_id]['topics'][$curnt_lesson_id][$curnt_topic_id]){
					if($show_notes){
						echo "<span class='red'>this topic is not done</span><br/>";
					}
					$new_mark_btn	=	1;
					//link update 
					$new_mark_lnk = get_post_meta(get_the_ID(),'activity_id',true);
				}else{
					if($show_notes){
					echo "<span class='green'>this topic is  done</span><br/>";
				}
			}
		}
	}

	//reset post data so other loop work properly
	wp_reset_postdata(); 

	//show new button if needed 
	if($new_mark_btn == 1){
		$lbl	=  LearnDash_Custom_Label::get_label( 'button_mark_complete' );
		if($show_notes){
			echo "New link: ".$new_mark_lnk;
		}
		?>
		<div> 
			<form id='sfwd-mark-complete-custom' method='post' action=''>
				<input name='mark_comp' type='submit' value='<?php echo $lbl;?> ' id='learndash_mark_complete_button_costom_65' />
			</form>
		</div>
		<script>
			jQuery( document ).ready(function() {
				jQuery('#learndash_mark_complete_button_costom_65').click(function(e){
					e.preventDefault();
					console.log("clicked");
					window.location="<?php echo $new_mark_lnk; ?>";
				});
				console.log("<?php echo $new_mark_lnk; ?>");
			});
		</script>
		<?php 

		//stop further parsing
		return;
	}else{
		//jump to next lesson 
		if($show_notes){
			echo "New link: ".$new_mark_lnk;
		}
		//show only if current lesson topic or quiz is not complete 
		$t_c	=	learndash_is_topic_complete(get_current_user_id(),get_the_ID());
		$l_c	=	learndash_is_lesson_complete(get_current_user_id(),get_the_ID());
		$q_c	=	learndash_is_quiz_complete(get_current_user_id(),get_the_ID());
		if($t_c || $l_c || $q_c){
			?>
			<div> 
				<form id='sfwd-mark-complete-custom' method='post' action=''>
					<input name='mark_comp' type='submit' value='Jump to Next Lesson ' id='learndash_mark_complete_button_costom_65' />
				</form>
			</div>
			<script>
				jQuery( document ).ready(function() {
					jQuery('#learndash_mark_complete_button_costom_65').click(function(e){
						e.preventDefault();
						console.log("clicked");
						window.location="<?php echo $next; ?>";
					});
					console.log("<?php echo $next; ?>");
				});
			</script>
			<?php 
		}//close if current completed or not 
	}
}
if( ! learndash_is_lesson_complete(null,get_the_ID()) ){
	$return = "<div>
	<script>
		jQuery( document ).ready(function() {
			if(jQuery('form#sfwd-mark-complete').length) {
				jQuery('#sfwd-mark-complete').hide();
			}
		});
	</script>
		<form id='sfwd-mark-complete-custom' method='post' action=''>
			<input type='hidden' value='" . $post->ID . "'name='post'/>
			<input type='hidden' value='". wp_create_nonce( 'sfwd_mark_complete_'. get_current_user_id() .'_'. $post->ID ) ."' name='sfwd_mark_complete'/>
			<input name='mark_comp' type='submit' value='" . LearnDash_Custom_Label::get_label( 'button_mark_complete' ) . "' id='learndash_mark_complete_button_costom' ". $button_disabled ."/>
		</form>
	</div>";
}else{
	$return = "<h4 style='color:#fc31a7;'>This lesson is complete</h4><style>#learndash_uploaded_assignments {display:none;}</style>";
}
return $return ;
if( ! learndash_is_topic_complete(null,get_the_ID()) ){
	$return = "<div>
	<script>
		jQuery( document ).ready(function() {
			if(jQuery('form#sfwd-mark-complete').length) {
				jQuery('#sfwd-mark-complete').hide();
			}
		});
	</script>
		<form id='sfwd-mark-complete-custom' method='post' action=''>
			<input type='hidden' value='" . $post->ID . "'name='post'/>
			<input type='hidden' value='". wp_create_nonce( 'sfwd_mark_complete_'. get_current_user_id() .'_'. $post->ID ) ."' name='sfwd_mark_complete'/>
			<input name='mark_comp' type='submit' value='" . LearnDash_Custom_Label::get_label( 'button_mark_complete' ) . "' id='learndash_mark_complete_button_costom' ". $button_disabled ."/>
		</form>
		</div>";
	}else{
		$return = "<h4 style='color:#fc31a7;'>This topic is complete</h4><style>#learndash_uploaded_assignments {display:none;}</style>";
	}
return $return ;
}

add_shortcode('MarkComplete', 'ld_MarkCompleteButton');

function lesson_auto_markcomplete() {
	global $post;
	if( ! learndash_is_lesson_complete(null,$post->ID) ){
		learndash_process_mark_complete(get_current_user_id(),$post->ID );
	}
	if( ! learndash_is_topic_complete(null,$post->ID) ){
		learndash_process_mark_complete(get_current_user_id(),$post->ID );
	}
}

add_shortcode('AutoComplete', 'lesson_auto_markcomplete');
?>