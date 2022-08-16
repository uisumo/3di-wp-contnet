<?php

namespace uncanny_pro_toolkit;

use LearnDash_Certificate_Builder\Component\PDF;

if ( ! defined( 'WPINC' ) ) {
	die;
}

/**
 * Class CertificateBuilder
 * @package uncanny_pro_toolkit
 */
class CertificateBuilder {

	/**
	 * path
	 *
	 * @var string
	 */
	public $path;

	/**
	 * Entity that we are processing. Course or Quiz.
	 *
	 * @var string
	 */
	public $entity;

	/**
	 * Arguments for the certificate.
	 *
	 * @var array
	 */
	public $args;

	/**
	 * Parameters of the quiz.
	 *
	 * @var array
	 */
	public $parameters;

	/**
	 * __construct
	 *
	 * @return void
	 */
	public function __construct() {
	}

	/**
	 * Checks if the certificate was created with the builder
	 *
	 * @param mixed $post_id
	 *
	 * @return bool
	 */
	public function created_with_builder( $post_id ) {
		return absint( get_post_meta( $post_id, 'ld_certificate_builder_on', true ) ) === 1 ? true : false;
	}

	/**
	 * CHecks if the builder plugin is active
	 *
	 * @return bool
	 */
	public function builder_active() {
		return class_exists( 'LearnDash_Certificate_Builder\Controller\Certificate_Builder' );
	}

	/**
	 * Handles PDF generation for email notifications
	 *
	 * @param array  $args
	 * @param string $entity - course or quiz
	 *
	 * @return string|array path to the file created
	 */
	public function generate_pdf( $args, $entity ) {

		$this->args       = $args;
		$this->parameters = $args['parameters'];
		$this->entity     = $entity;
		$this->path       = $args['save_path'] . $args['file_name'] . '.pdf';

		if ( $this->builder_active() ) {

			if ( 0 === get_current_user_id() ) {
				wp_set_current_user( $this->parameters['userID'] );
			}

			$entity_id = $this->get_post_id( $entity );

			$cert_id = intval( $args['certificate_post'] );

			$certificate_post = get_post( $cert_id );

			// Swap the data for some LD functions
			$this->filters( 'add' );

			$blocks = parse_blocks( $certificate_post->post_content );

			$blocks = $this->add_entity_ids( $blocks, $entity, $entity_id );

			$LD_PDF = new PDF();

			$LD_PDF->serve( $blocks, $cert_id, $entity_id );

			// Clean up the filters
			$this->filters( 'remove' );

			return $this->path;
		}

		return array(
			'error' => esc_html__( 'The certificate could not be attached because the Certificate Builder is not active. Please contact the site administrator.', 'uncanny-pro-toolkit' ),
		);
	}

	/**
	 * Return Quiz or Course ID, depending on what was requested.
	 *
	 * @param mixed $entity
	 *
	 * @return void
	 */
	public function get_post_id( $entity ) {

		switch ( $entity ) {
			case 'course':
				$post_id = $this->args['parameters']['course-id'];
				break;
			case 'quiz':
				$post_id = $this->args['quiz_id'];
				break;
			default:
				$post_id = 0;
				break;
		}

		return $post_id;
	}

	/**
	 * Add/Remove filters.
	 *
	 * @param string $add
	 *
	 * @return void
	 */
	public function filters( $add ) {
		if ( 'add' === $add ) {

			add_filter( 'learndash_shortcode_atts', array( $this, 'inject_shortcode_atts' ), 1, 2 );

			if ( 'quiz' === $this->entity ) {
				// Mock the current quiz results in the next user meta query.
				add_filter( 'get_user_metadata', array( $this, 'inject_quiz_results' ), 1, 5 );
			}

			// Swap the path and destintation in the next PDF generation.
			add_filter( 'learndash_certificate_builder_pdf_name', array( $this, 'file_path' ), 1, 3 );
			add_filter( 'learndash_certificate_builder_pdf_output_mode', array( $this, 'destination' ), 1, 3 );

			return;
		}

		// Else, remove all the filters.
		if ( 'quiz' === $this->entity ) {
			remove_filter( 'get_user_metadata', array( $this, 'inject_quiz_results' ), 1 );
		}

		remove_filter( 'learndash_shortcode_atts', array( $this, 'inject_shortcode_atts' ), 1 );
		remove_filter( 'learndash_certificate_builder_pdf_name', array( $this, 'file_path' ), 1 );
		remove_filter( 'learndash_certificate_builder_pdf_output_mode', array( $this, 'destination' ), 1 );

	}

	public function mock_quizinfo() {
		return array(
			'quiz'         => $this->parameters['quiz-id'],
			'score'        => $this->parameters['points'],
			'count'        => $this->parameters['points'],
			'pass'         => 'Yes',
			'pro_quizid'   => $this->parameters['quiz-id'],
			'course'       => $this->parameters['course-id'],
			'points'       => $this->parameters['points'],
			'total_points' => $this->parameters['correctQuestions'],
			'percentage'   => $this->parameters['result'],
			'timespent'    => $this->parameters['timespent'],
			'completed'    => $this->args['completion_time'],
			'time'         => time(),
		);
	}

	/**
	 * Inject current quiz results when the database is queried for them.
	 *
	 * @param string $value
	 * @param string $object_id
	 * @param string $meta_key
	 * @param string $single
	 * @param string $meta_type
	 *
	 * @return mixed
	 */
	public function inject_quiz_results( $value, $object_id, $meta_key, $single, $meta_type ) {

		if ( $meta_type === 'user' &&
		     $object_id === $this->parameters['userID'] &&
		     $meta_key === '_sfwd-quizzes'
		) {
			$value   = array();
			$value[] = array( $this->mock_quizinfo() );

		}

		return $value;
	}

	/**
	 * Inject missing shortcode attributes.
	 *
	 * @param array $shortcode_atts
	 * @param string $shortcode_slug
	 *
	 * @return array
	 */
	public function inject_shortcode_atts( $shortcode_atts, $shortcode_slug ) {

		if ( 'quizinfo' === $shortcode_slug ) {
			$shortcode_atts['quiz'] = $this->parameters['quiz-id'];
		}

		if ( 'courseinfo' === $shortcode_slug ) {
			$shortcode_atts['course_id'] = $this->parameters['course-id'];
		}

		return $shortcode_atts;
	}

	/**
	 * Returns file_path for mPDF
	 *
	 * @param string $path
	 * @param string $cert_id
	 * @param string $course_id
	 *
	 * @return string
	 */
	public function file_path( $path, $cert_id, $course_id ) {
		return $this->path;
	}

	/**
	 * Returns F as the destination for mPDF
	 *
	 * @param string $destination
	 * @param string $cert_id
	 * @param string $course_id
	 *
	 * @return string
	 */
	public function destination( $destination, $cert_id, $course_id ) {
		return 'F';
	}
	
	/**
	 * add_entity_id
	 *
	 * @param  array $blocks
	 * @param  string $entity - quiz or course?
	 * @param  int $entity_id quiz or course id
	 * @return array $blocks
	 */
	public function add_entity_ids( $blocks, $entity, $entity_id  ) {

		foreach ( $blocks as &$block ) {
			$block = $this->add_in_inner_blocks( $block, $entity, $entity_id );
		}

		return $blocks;
		
	}
	
	/**
	 * add_in_inner_blocks
	 *
	 * @param  array $block
	 * @param  string $entity - quiz or course?
	 * @param  int $entity_id quiz or course id
	 * @return array $block
	 */
	public function add_in_inner_blocks( $block, $entity, $entity_id ) {

		if ( empty( $block['innerBlocks'] ) ) {
			return $block;
		}

		foreach ( $block['innerBlocks'] as &$inner_block ) {
			
			$inner_block = $this->add_in_inner_blocks( $inner_block, $entity, $entity_id );

			if ( 'learndash/ld-quizinfo' === $inner_block['blockName'] ) {
				$inner_block['attrs']['quiz_id'] = "$entity_id";
			} 

		}
		
		return $block;

	}

}
