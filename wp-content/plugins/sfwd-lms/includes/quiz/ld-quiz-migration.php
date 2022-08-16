<?php
/**
 * Migration functions to move from post meta to WP Pro Quiz
 * and other helper functions
 *
 * @since 2.1.0
 *
 * @package LearnDash\Quiz
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Migrates the LearnDash quiz.
 *
 * Fires on `admin_init` hook.
 *
 * @global wpdb $wpdb WordPress database abstraction object.
 *
 * @since 2.1.0
 */
function learndash_quiz_migration() {
	$learndash_adv_quiz_migration_completed = ( ! empty( $_GET['learndash_adv_quiz_migration'] ) ) ? 0 : get_option( 'learndash_adv_quiz_migration_completed' );

	if ( empty( $learndash_adv_quiz_migration_completed ) ) {
		learndash_create_quiz_for_all_adv_quiz();
		update_option( 'learndash_adv_quiz_migration_completed', 1 );
	}

	$learndash_quiz_migration_completed = ( ! empty( $_GET['force_learndash_quiz_migration'] ) ) ? 0 : get_option( 'learndash_quiz_migration_completed' );

	if ( $learndash_quiz_migration_completed ) {
		return;
	}

	if ( ! empty( $_GET['migrate_quiz_id'] ) ) {
		$posts = array( get_post( $_GET['migrate_quiz_id'] ) );
	} else {
		$posts = get_posts(
			array(
				'post_type'      => 'sfwd-quiz',
				'post_status'    => 'any',
				'posts_per_page' => -1,
			)
		);
	}

	set_time_limit( 300 );

	global $wpdb;

	foreach ( $posts as $post ) {
		$quizdata = get_post_meta( $post->ID, '_quizdata', true );

		if ( ! empty( $_GET['force_learndash_quiz_migration'] ) && ( empty( $quizdata['workingJson'] ) || 'false' == $quizdata['workingJson'] ) ) {
			$quizdata = get_post_meta( $post->ID, '_quizdata_migrated', true );
		}

		if ( empty( $quizdata['workingJson'] ) || 'false' == $quizdata['workingJson'] ) {
			continue;
		}

		$simple_quiz_data = json_decode( $quizdata['workingJson'] );

		$learndash_quiz_migration = new LearnDash_Quiz_Migration();
		$xml                      = $learndash_quiz_migration->get_xml( $simple_quiz_data );

		if ( ! empty( $xml ) ) {
			$import = new WpProQuiz_Helper_ImportXml();
			$import->setString( $xml );
			$get_import_data = $import->getImportData();
			$pro_quiz_id     = $import->saveImportSingle();
			learndash_update_setting( $post, 'quiz_pro', $pro_quiz_id );
		}

		$wpdb->query( $wpdb->prepare( "UPDATE $wpdb->postmeta SET meta_key = '_quizdata_migrated' WHERE meta_key = '_quizdata' AND post_id = '%d' LIMIT 1", $post->ID ) );

	}

	update_option( 'learndash_quiz_migration_completed', 1 );
}

add_action( 'admin_init', 'learndash_quiz_migration' );

/**
 * Creates a quiz post for each advanced quiz.
 *
 * @since 2.1.0
 */
function learndash_create_quiz_for_all_adv_quiz() {
	$quiz_mapper = new WpProQuiz_Model_QuizMapper();
	$quizzes     = $quiz_mapper->fetchAll();

	foreach ( $quizzes as $key => $quiz ) {
		$quiz_id = $quiz->getId();
		//error_log('quizId['. $quizId .']');

		if ( empty( $quiz_id ) ) {
			continue;
		}

		$post_id = learndash_get_quiz_id_by_pro_quiz_id( $quiz_id );
		//error_log('post_id['. $post_id .']');
		//die();

		if ( empty( $post_id ) ) {
			$post_id = learndash_create_quiz_for_adv_quiz( $quiz_id );
		} else {
			learndash_migrate_content_from_pro_quiz_to_custom_post_type( $quiz, $post_id );
		}
	}
}

/**
 * Migrates the content from a pro quiz object to the quiz custom post type.
 *
 * @global wpdb $wpdb WordPress database abstraction object.
 *
 * @param WpProQuiz_Model_Quiz $quiz    Pro Quiz to be migrated.
 * @param int                  $post_id Post ID.
 */
function learndash_migrate_content_from_pro_quiz_to_custom_post_type( $quiz, $post_id ) {
	$quiz_desc = $quiz->getText();

	if ( ! empty( $quiz_desc ) && 'AAZZAAZZ' != $quiz_desc && ! empty( $post_id ) ) {
		$quiz_post                   = get_post( $post_id );
		$update_post['ID']           = $post_id;
		$update_post['post_content'] = $quiz_post->post_content . '<br>' . $quiz_desc;
		wp_update_post( $update_post );
		global $wpdb;
		$wpdb->query( $wpdb->prepare( 'UPDATE ' . LDLMS_DB::get_table_name( 'quiz_master' ) . " SET text = 'AAZZAAZZ' WHERE id = '%d'", $quiz->getId() ) );
	}
}

/**
 * Creates a sfwd-quiz post for the given pro quiz ID.
 *
 * @param int $quiz_id Pro quiz ID.
 *
 * @return int|void Quiz Post ID.
 */
function learndash_create_quiz_for_adv_quiz( $quiz_id ) {
	$quiz_mapper = new WpProQuiz_Model_QuizMapper();
	$quizzes     = $quiz_mapper->fetchAll();
	$quiz        = $quiz_mapper->fetch( $quiz_id );
	$quiz_id     = $quiz->getId();

	if ( empty( $quiz_id ) ) {
		return;
	}

	global $wpdb;
	$user_id = get_current_user_id();

	$quiz_post_id = wp_insert_post(
		array(
			'post_title'  => $quiz->getName(),
			'post_type'   => 'sfwd-quiz',
			'post_status' => 'publish',
			'post_author' => $user_id,
		)
	);

	if ( ! empty( $quiz_post_id ) ) {
		learndash_update_setting( $quiz_post_id, 'quiz_pro', $quiz->getId() );
	}

	return $quiz_post_id;
}

/**
 * Object that handles LearnDash Quiz Migrations
 */
class LearnDash_Quiz_Migration {

	/**
	 * Retrieves an XML representation of a simple quiz object
	 *
	 * @since 2.1.0
	 *
	 * @param  object $simple_quiz_data
	 * @return String                   XML representation of the simple quiz object
	 */
	public function get_xml( $simple_quiz_data ) {
		$title      = $simple_quiz_data->info->name;
		$maincopy   = $simple_quiz_data->info->main;
		$resultcopy = $simple_quiz_data->info->results;
		$questions  = $simple_quiz_data->questions;

		if ( empty( $title ) || empty( $questions ) || ! is_array( $questions ) ) {
			return '';
		}

		$questions_xml = '';
		$qno           = 1;

		foreach ( $questions as $question ) {
			$question_text = $question->q;
			$correct       = $question->correct;
			$incorrect     = $question->incorrect;
			$answers       = $question->a;

			if ( empty( $answers ) || ! is_array( $answers ) ) {
				return '';
			}

			$answers_xml   = '';
			$correct_count = 0;

			foreach ( $answers as $answer ) {
				$answer_text = $answer->option;
				$is_correct  = ! empty( $answer->correct ) ? 'true' : 'false';

				if ( ! empty( $answer->correct ) ) {
					$correct_count++;
				}

				$answers_xml .= $this->answer( $answer_text, $is_correct );
			}

			$type           = ( $correct_count > 1 ) ? 'multiple' : 'single';
			$questions_xml .= $this->question( $qno++, $question_text, $correct, $incorrect, $answers_xml, $type );
		}

		return $this->template( $title, $maincopy, $resultcopy, $questions_xml );
	}

	/**
	 * Uses the input string variables to fill an XML template.
	 *
	 * @since 2.1.0
	 *
	 * @param  string $title         XML text
	 * @param  string $maincopy      XML text
	 * @param  string $resultcopy    XML text
	 * @param  string $questions_xml XML text
	 * @return string                XML string
	 */
	public function template( $title, $maincopy, $resultcopy, $questions_xml ) {

		if ( empty( $maincopy ) ) {
			$maincopy = 'AAZZAAZZ';
		}

		return '<?xml version="1.0" encoding="UTF-8"?>
					<wpProQuiz>
						<header version="0.28" exportVersion="1" />
						<data>
							<quiz>
								<title titleHidden="false"><![CDATA[' . $title . ']]></title>
								<text><![CDATA[' . $maincopy . ']]></text>
								<resultText gradeEnabled="false"><![CDATA[' . $resultcopy . ']]></resultText>
								<btnRestartQuizHidden>false</btnRestartQuizHidden>
								<btnViewQuestionHidden>false</btnViewQuestionHidden>
								<questionRandom>false</questionRandom>
								<answerRandom>false</answerRandom>
								<timeLimit>0</timeLimit>
								<showPoints>false</showPoints>
								<statistic activated="false" ipLock="1440" />
								<quizRunOnce type="1" cookie="false" time="0">false</quizRunOnce>
								<numberedAnswer>false</numberedAnswer>
								<hideAnswerMessageBox>false</hideAnswerMessageBox>
								<disabledAnswerMark>false</disabledAnswerMark>
								<showMaxQuestion showMaxQuestionValue="1" showMaxQuestionPercent="false">false</showMaxQuestion>
								<toplist activated="false">
									<toplistDataAddPermissions>1</toplistDataAddPermissions>
									<toplistDataSort>1</toplistDataSort>
									<toplistDataAddMultiple>false</toplistDataAddMultiple>
									<toplistDataAddBlock>1</toplistDataAddBlock>
									<toplistDataShowLimit>1</toplistDataShowLimit>
									<toplistDataShowIn>0</toplistDataShowIn>
									<toplistDataCaptcha>false</toplistDataCaptcha>
									<toplistDataAddAutomatic>false</toplistDataAddAutomatic>
								</toplist>
								<showAverageResult>false</showAverageResult>
								<prerequisite>false</prerequisite>
								<showReviewQuestion>false</showReviewQuestion>
								<quizSummaryHide>false</quizSummaryHide>
								<skipQuestionDisabled>false</skipQuestionDisabled>
								<emailNotification>0</emailNotification>
								<userEmailNotification>false</userEmailNotification>
								<showCategoryScore>false</showCategoryScore>
								<hideResultCorrectQuestion>false</hideResultCorrectQuestion>
								<hideResultQuizTime>false</hideResultQuizTime>
								<hideResultPoints>false</hideResultPoints>
								<autostart>false</autostart>
								<forcingQuestionSolve>false</forcingQuestionSolve>
								<hideQuestionPositionOverview>false</hideQuestionPositionOverview>
								<hideQuestionNumbering>false</hideQuestionNumbering>
								<sortCategories>false</sortCategories>
								<showCategory>false</showCategory>
								<quizModus questionsPerPage="0">0</quizModus>
								<startOnlyRegisteredUser>false</startOnlyRegisteredUser>
								<forms activated="false" position="0" />
								<questions>
									' . $questions_xml . '
								</questions>
							</quiz>
						</data>
					</wpProQuiz>';
	}

	/**
	 * Returns the XML representation of the question based off of the input string variables
	 *
	 * @since 2.1.0
	 *
	 * @param  string $qno
	 * @param  string $question_text
	 * @param  string $correct
	 * @param  string $incorrect
	 * @param  string $answers_xml
	 * @param  string $type
	 * @return string XML string
	 */
	public function question( $qno, $question_text, $correct, $incorrect, $answers_xml, $type = 'single' ) {
		return '<question answerType="' . $type . '">
					<title><![CDATA[Question: ' . $qno . ']]></title>
					<points>1</points>
					<questionText><![CDATA[' . $question_text . ']]></questionText>
					<correctMsg><![CDATA[' . $correct . ']]></correctMsg>
					<incorrectMsg><![CDATA[' . $incorrect . ']]></incorrectMsg>
					<tipMsg enabled="false" />
					<category />
					<correctSameText>false</correctSameText>
					<showPointsInBox>false</showPointsInBox>
					<answerPointsActivated>false</answerPointsActivated>
					<answerPointsDiffModusActivated>false</answerPointsDiffModusActivated>
					<disableCorrect>false</disableCorrect>
					<answers>
						' . $answers_xml . '
					</answers>
				</question>';
	}

	/**
	 * Returns the XML representation of an answer based off of the input string variables
	 *
	 * @since 2.1.0
	 *
	 * @param  String $answer_text
	 * @param  String $is_correct
	 * @return String XML string
	 */
	public function answer( $answer_text, $is_correct ) {
		return '<answer points="1" correct="' . $is_correct . '">
			<answerText html="false"><![CDATA[' . $answer_text . ']]></answerText>
			<stortText html="false" />
		</answer>';
	}
}
