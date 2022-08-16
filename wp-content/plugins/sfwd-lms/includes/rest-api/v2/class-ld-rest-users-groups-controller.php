<?php
/**
 * LearnDash V2 REST API Users Courses Controller.
 *
 * @package LearnDash
 * @subpackage REST_API
 * @since 3.3.0
 */

/**
 * This Controller class is used to GET/UPDATE/DELETE the association
 * between a User and the enrolled Groups (groups).
 *
 * This class extends the LD_REST_Posts_Controller_V2 class.
 *
 * @package LearnDash
 * @subpackage REST
 */
if ( ( ! class_exists( 'LD_REST_Users_Groups_Controller_V2' ) ) && ( class_exists( 'LD_REST_Posts_Controller_V2' ) ) ) {
	/**
	 * Class REST API Courses Post Controller.
	 */
	// phpcs:ignore WordPress.NamingConventions.PrefixAllGlobals.NonPrefixedClassFound
	class LD_REST_Users_Groups_Controller_V2 extends LD_REST_Posts_Controller_V2 {

		/**
		 * Public constructor for class
		 */
		public function __construct() {
			$this->post_type  = learndash_get_post_type_slug( 'group' );
			$this->taxonomies = array();

			parent::__construct( $this->post_type );

			/**
			 * Set the rest_base after the parent __constructor
			 * as it will set these var with WP specific details.
			 */
			$this->rest_base     = $this->get_rest_base( 'users' );
			$this->rest_sub_base = $this->get_rest_base( 'users-groups' );
		}

		/**
		 * Registers the routes for the objects of the controller.
		 *
		 * @since 3.3.0
		 *
		 * @see register_rest_route()
		 */
		public function register_routes() {

			$collection_params = $this->get_collection_params();
			$schema            = $this->get_item_schema();

			$get_item_args = array(
				'context' => $this->get_context_param( array( 'default' => 'view' ) ),
			);

			register_rest_route(
				$this->namespace,
				'/' . $this->rest_base . '/(?P<id>[\d]+)/' . $this->rest_sub_base,
				array(
					'args'   => array(
						'id' => array(
							'description' => esc_html__( 'User ID', 'learndash' ),
							'required'    => true,
							'type'        => 'integer',
						),
					),
					array(
						'methods'             => WP_REST_Server::READABLE,
						'callback'            => array( $this, 'get_user_groups' ),
						'permission_callback' => array( $this, 'get_user_groups_permissions_check' ),
						'args'                => $this->get_collection_params(),
					),
					array(
						'methods'             => WP_REST_Server::EDITABLE,
						'callback'            => array( $this, 'update_user_groups' ),
						'permission_callback' => array( $this, 'update_user_groups_permissions_check' ),
						'args'                => array(
							'group_ids' => array(
								'description' => esc_html__( 'Group IDs to add to User.', 'learndash' ),
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
						'callback'            => array( $this, 'delete_user_groups' ),
						'permission_callback' => array( $this, 'delete_user_groups_permissions_check' ),
						'args'                => array(
							'group_ids' => array(
								'description' => esc_html__( 'Group IDs to remove from User.', 'learndash' ),
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

			$schema['title']  = 'user-groups';
			$schema['parent'] = '';

			return $schema;
		}

		/**
		 * Permissions check for getting user groups.
		 *
		 * @since 3.3.0
		 *
		 * @param WP_REST_Request $request Full details about the request.
		 *
		 * @return true|WP_Error True if the request has read access, otherwise WP_Error object.
		 */
		public function get_user_groups_permissions_check( $request ) {
			if ( learndash_is_admin_user() ) {
				return true;
			} elseif ( get_current_user_id() == $request['id'] ) {
				return true;
			}
		}

		/**
		 * Permissions check for updating user groups.
		 *
		 * @since 3.3.0
		 *
		 * @param WP_REST_Request $request Full details about the request.
		 *
		 * @return true|WP_Error True if the request has read access, otherwise WP_Error object.
		 */
		public function update_user_groups_permissions_check( $request ) {
			if ( learndash_is_admin_user() ) {
				return true;
			} elseif ( get_current_user_id() == $request['id'] ) {
				return true;
			}
		}

		/**
		 * Permissions check for deleting user groups.
		 *
		 * @since 3.3.0
		 *
		 * @param WP_REST_Request $request Full details about the request.
		 *
		 * @return true|WP_Error True if the request has read access, otherwise WP_Error object.
		 */
		public function delete_user_groups_permissions_check( $request ) {
			if ( learndash_is_admin_user() ) {
				return true;
			} elseif ( get_current_user_id() == $request['id'] ) {
				return true;
			}
		}

		/**
		 * Get a user groups.
		 *
		 * @since 3.3.0
		 *
		 * @param WP_REST_Request $request Full details about the request.
		 *
		 * @return WP_REST_Response|WP_Error Response object on success, or WP_Error object on failure.
		 */
		public function get_user_groups( $request ) {
			return $this->get_items( $request );
		}

		/**
		 * Update a user groups.
		 *
		 * @since 3.3.0
		 *
		 * @param WP_REST_Request $request Full details about the request.
		 *
		 * @return WP_REST_Response|WP_Error Response object on success, or WP_Error object on failure.
		 */
		public function update_user_groups( $request ) {
			$user_id = $request['id'];
			if ( empty( $user_id ) ) {
				return new WP_Error( 'rest_post_invalid_id', esc_html__( 'Invalid User ID.', 'learndash' ) . ' ' . __CLASS__, array( 'status' => 404 ) );
			}

			$group_ids = $request['group_ids'];
			if ( ( ! is_array( $group_ids ) ) || ( empty( $group_ids ) ) ) {
				return new WP_Error( 'rest_post_invalid_id', esc_html__( 'Missing Group IDs.', 'learndash' ) . ' ' . __CLASS__, array( 'status' => 404 ) );
			} else {
				$group_ids = array_map( 'intval', $group_ids );
			}

			foreach ( $group_ids as $group_id ) {
				ld_update_group_access( $user_id, $group_id, false );
			}

			$data = array();

			// Create the response object
			$response = rest_ensure_response( $data );

			// Add a custom status code
			$response->set_status( 200 );

			return $response;
		}

		/**
		 * Delete a user groups.
		 *
		 * @since 3.3.0
		 *
		 * @param WP_REST_Request $request Full details about the request.
		 *
		 * @return WP_REST_Response|WP_Error Response object on success, or WP_Error object on failure.
		 */
		public function delete_user_groups( $request ) {
			$user_id = $request['id'];
			if ( empty( $user_id ) ) {
				return new WP_Error( 'rest_post_invalid_id', esc_html__( 'Invalid User ID.', 'learndash' ) . ' ' . __CLASS__, array( 'status' => 404 ) );
			}

			$group_ids = $request['group_ids'];
			if ( ( ! is_array( $group_ids ) ) || ( empty( $group_ids ) ) ) {
				return new WP_Error( 'rest_post_invalid_id', esc_html__( 'Missing Group IDs.', 'learndash' ) . ' ' . __CLASS__, array( 'status' => 404 ) );
			} else {
				$group_ids = array_map( 'intval', $group_ids );
			}

			foreach ( $group_ids as $group_id ) {
				ld_update_group_access( $user_id, $group_id, true );
			}

			$data = array();

			// Create the response object
			$response = rest_ensure_response( $data );

			// Add a custom status code
			$response->set_status( 200 );

			return $response;
		}

		/**
		 * Filter Users Groups query args.
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

				$user_id = $request['id'];
				if ( empty( $user_id ) ) {
					return new WP_Error( 'rest_user_invalid_id', esc_html__( 'Invalid User ID.', 'learndash' ), array( 'status' => 404 ) );
				}

				if ( is_user_logged_in() ) {
					$current_user_id = get_current_user_id();
				} else {
					$current_user_id = 0;
				}

				$query_args['post__in'] = array( 0 );
				if ( ! empty( $current_user_id ) ) {
					$group_ids = learndash_get_users_group_ids( $user_id );
					if ( ! empty( $group_ids ) ) {
						$query_args['post__in'] = $group_ids;
					}
				}
			}

			return $query_args;
		}
	}
}
