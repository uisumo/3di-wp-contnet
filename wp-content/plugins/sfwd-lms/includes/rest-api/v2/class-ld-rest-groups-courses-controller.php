<?php
/**
 * LearnDash V2 REST API Groups Courses Controller.
 *
 * @package LearnDash
 * @subpackage REST_API
 * @since 3.3.0
 */

/*
 * This Controller class is used to GET/UPDATE/DELETE the association
 * between the LearnDash Groups (groups) and Courses (sfwd-courses)
 * custom post types.
 *
 * This class extends the LD_REST_Posts_Controller_V2 class.
 *
 * @since 3.3.0
 */
if ( ( ! class_exists( 'LD_REST_Groups_Courses_Controller_V2' ) ) && ( class_exists( 'LD_REST_Posts_Controller_V2' ) ) ) {
	/**
	 * Class REST API Courses Post Controller.
	 */
	// phpcs:ignore WordPress.NamingConventions.PrefixAllGlobals.NonPrefixedClassFound
	class LD_REST_Groups_Courses_Controller_V2 extends LD_REST_Posts_Controller_V2 {

		/**
		 * Public constructor for class
		 */
		public function __construct( $post_type = '' ) {
			if ( empty( $post_type ) ) {
				$post_type = learndash_get_post_type_slug( 'course' );
			}
			$this->post_type = $post_type;
			$this->metaboxes = array();

			parent::__construct( $this->post_type );

			/**
			 * Set the rest_base after the parent __constructor
			 * as it will set these var with WP specific details.
			 */
			$this->rest_base     = $this->get_rest_base( 'groups' );
			$this->rest_sub_base = $this->get_rest_base( 'groups-courses' );
		}

		/**
		 * Registers the routes for the objects of the controller.
		 *
		 * @since 3.3.0
		 *
		 * @see register_rest_route()
		 */
		public function register_routes() {
			$schema = $this->get_item_schema();

			$get_item_args = array(
				'context' => $this->get_context_param( array( 'default' => 'view' ) ),
			);
			if ( isset( $schema['properties']['password'] ) ) {
				$get_item_args['password'] = array(
					'description' => esc_html__( 'The password for the post if it is password protected.', 'learndash' ),
					'type'        => 'string',
				);
			}

			register_rest_route(
				$this->namespace,
				'/' . $this->rest_base . '/(?P<id>[\d]+)/' . $this->rest_sub_base,
				array(
					'args'   => array(
						'id' => array(
							'description' => esc_html__( 'Group ID', 'learndash' ),
							'required'    => true,
							'type'        => 'integer',
						),
					),
					array(
						'methods'             => WP_REST_Server::READABLE,
						'callback'            => array( $this, 'get_groups_courses' ),
						'permission_callback' => array( $this, 'get_groups_courses_permissions_check' ),
						'args'                => $this->get_collection_params(),
					),
					array(
						'methods'             => WP_REST_Server::EDITABLE,
						'callback'            => array( $this, 'update_groups_courses' ),
						'permission_callback' => array( $this, 'update_groups_courses_permissions_check' ),
						'args'                => array(
							'course_ids' => array(
								'description' => sprintf(
									// translators: placeholder: Course.
									esc_html_x(
										'%s IDs to add to Group.',
										'placeholder: Course',
										'learndash'
									),
									LearnDash_Custom_Label::get_label( 'course' )
								),
								'required'    => true,
								'type'        => 'array',
								'items'       => array(
									'type' => 'integer',
								),
							),
						),
					),
					array(
						'methods'             => WP_REST_Server::DELETABLE,
						'callback'            => array( $this, 'delete_groups_courses' ),
						'permission_callback' => array( $this, 'delete_groups_courses_permissions_check' ),
						'args'                => array(
							'course_ids' => array(
								'description' => sprintf(
									// translators: placeholder: Course.
									esc_html_x(
										'%s IDs to remove from Group.',
										'placeholder: Course',
										'learndash'
									),
									LearnDash_Custom_Label::get_label( 'course' )
								),
								'required'    => true,
								'type'        => 'array',
								'items'       => array(
									'type' => 'integer',
								),
							),
						),
					),
					'schema' => array( $this, 'get_public_item_schema' ),
				)
			);
		}

		/**
		 * Gets public schema.
		 *
		 * @since 3.3.0
		 *
		 * @return array
		 */
		public function get_public_item_schema() {

			$schema = parent::get_public_item_schema();

			$schema['title']  = 'group-courses';
			$schema['parent'] = 'groups';

			return $schema;
		}

		/**
		 * Checks permission to get group courses.
		 *
		 * @since 3.3.0
		 *
		 * @param WP_REST_Request $request Full details about the request.
		 *
		 * @return true|WP_Error True if the request has access to update the item, WP_Error object otherwise.
		 */
		public function get_groups_courses_permissions_check( $request ) {
			if ( learndash_is_admin_user() ) {
				return true;
			}
		}

		/**
		 * Checks permission to update group courses.
		 *
		 * @since 3.3.0
		 *
		 * @param WP_REST_Request $request Full details about the request.
		 *
		 * @return true|WP_Error True if the request has access to update the item, WP_Error object otherwise.
		 */
		public function update_groups_courses_permissions_check( $request ) {
			if ( learndash_is_admin_user() ) {
				return true;
			}
		}

		/**
		 * Checks permission to update delete courses.
		 *
		 * @since 3.3.0
		 *
		 * @param WP_REST_Request $request Full details about the request.
		 *
		 * @return true|WP_Error True if the request has access to update the item, WP_Error object otherwise.
		 */
		public function delete_groups_courses_permissions_check( $request ) {
			if ( learndash_is_admin_user() ) {
				return true;
			}
		}

		/**
		 * GET group courses.
		 *
		 * @since 3.3.0
		 *
		 * @param WP_REST_Request $request Full details about the request.
		 *
		 * @return WP_REST_Response|WP_Error Response object on success, or WP_Error object on failure.
		 */
		public function get_groups_courses( $request ) {
			return parent::get_items( $request );
		}

		/**
		 * Updates a group courses.
		 *
		 * @since 3.3.0
		 *
		 * @param WP_REST_Request $request Full details about the request.
		 *
		 * @return WP_REST_Response|WP_Error Response object on success, or WP_Error object on failure.
		 */
		public function update_groups_courses( $request ) {
			$group_id = $request['id'];
			if ( empty( $group_id ) ) {
				return new WP_Error( 'rest_post_invalid_id', esc_html__( 'Invalid group ID.', 'learndash' ) . ' ' . __CLASS__, array( 'status' => 404 ) );
			}

			$course_ids = $request['course_ids'];
			if ( ( ! is_array( $course_ids ) ) || ( empty( $course_ids ) ) ) {
				return new WP_Error(
					'rest_post_invalid_id',
					sprintf(
						// translators: placeholder: Course.
						esc_html_x(
							'Missing %s ID',
							'placeholder: Course',
							'learndash'
						),
						LearnDash_Custom_Label::get_label( 'course' )
					) . ' ' . __CLASS__,
					array( 'status' => 404 )
				);
			} else {
				$course_ids = array_map( 'intval', $course_ids );
			}

			foreach ( $course_ids as $course_id ) {
				ld_update_course_group_access( $course_id, $group_id, false );
			}

			$data = array();

			// Create the response object.
			$response = rest_ensure_response( $data );

			// Add a custom status code.
			$response->set_status( 200 );

			return $response;
		}

		/**
		 * Delete a group courses.
		 *
		 * @since 3.3.0
		 *
		 * @param WP_REST_Request $request Full details about the request.
		 *
		 * @return WP_REST_Response|WP_Error Response object on success, or WP_Error object on failure.
		 */
		public function delete_groups_courses( $request ) {
			$group_id = $request['id'];
			if ( empty( $group_id ) ) {
				return new WP_Error( 'rest_post_invalid_id', esc_html__( 'Invalid group ID.', 'learndash' ), array( 'status' => 404 ) );
			}

			$course_ids = $request['course_ids'];
			if ( ( ! is_array( $course_ids ) ) || ( empty( $course_ids ) ) ) {
				return new WP_Error(
					'rest_post_invalid_id',
					sprintf(
						// translators: placeholder: Course.
						esc_html_x(
							'Missing %s ID.',
							'placeholder: Course',
							'learndash'
						),
						LearnDash_Custom_Label::get_label( 'course' )
					),
					array( 'status' => 404 )
				);
			} else {
				$course_ids = array_map( 'intval', $course_ids );
			}

			foreach ( $course_ids as $course_id ) {
				ld_update_course_group_access( $course_id, $group_id, true );
			}

			$data = array();

			// Create the response object.
			$response = rest_ensure_response( $data );

			// Add a custom status code.
			$response->set_status( 200 );

			return $response;
		}

		/**
		 * Filter Groups Courses query args.
		 *
		 * @since 3.3.0
		 *
		 * @param array           $query_args Key value array of query var to query value.
		 * @param WP_REST_Request $request    The request used.
		 *
		 * @return array Key value array of query var to query value.
		 */
		public function rest_query_filter( $query_args, $request ) {
			$query_args = parent::rest_query_filter( $query_args, $request );

			$route_url    = $request->get_route();
			$ld_route_url = '/' . $this->namespace . '/' . $this->rest_base . '/' . absint( $request['id'] ) . '/' . $this->rest_sub_base;
			if ( ( ! empty( $route_url ) ) && ( $ld_route_url === $route_url ) ) {

				$group_id = $request['id'];
				if ( empty( $group_id ) ) {
					return new WP_Error( 'rest_post_invalid_id', esc_html__( 'Invalid Group ID.', 'learndash' ), array( 'status' => 404 ) );
				}

				if ( is_user_logged_in() ) {
					$current_user_id = get_current_user_id();
				} else {
					$current_user_id = 0;
				}

				$query_args['post__in'] = array( 0 );
				if ( ! empty( $current_user_id ) ) {
					$course_ids = learndash_group_enrolled_courses( $group_id, true );
					if ( ! empty( $course_ids ) ) {
						$query_args['post__in'] = $course_ids;
					}
				}
			}

			return $query_args;
		}

		// End of functions.
	}
}
