<?php

// Exit early if the rest api is not enabled
$wpse_options = get_option(VGSE()->options_key);
if (empty($wpse_options['be_enable_rest_api'])) {
	return;
}
// If the wp rest api is not available, exit
if (!class_exists('WP_REST_Controller')) {
	return;
}

if (!class_exists('WPSE_REST_API')) {

	class WPSE_REST_API extends WP_REST_Controller {

		function _validate_string($param, $request, $key) {
			return is_string($param) && !empty($param);
		}

		function _validate_int($param, $request, $key) {
			return intval($param) && !empty($param);
		}

		function get_route_namespace() {
			$version = '1';
			$namespace = 'sheet-editor/v' . $version;
			return $namespace;
		}

		/**
		 * Register the routes for the objects of the controller.
		 */
		public function register_routes() {
			$namespace = $this->get_route_namespace();
			register_rest_route($namespace, '/settings', array(
				array(
					'methods' => WP_REST_Server::READABLE,
					'callback' => array($this, 'get_settings'),
					'permission_callback' => array($this, 'get_general_settings_permissions_check'),
				),
			));
			register_rest_route($namespace, '/sheet/settings', array(
				array(
					'methods' => WP_REST_Server::READABLE,
					'callback' => array($this, 'get_sheet_settings'),
					'permission_callback' => array($this, 'get_items_permissions_check'),
					'args' => array(
						'sheet_key' => array(
							'sanitize_callback' => 'sanitize_text_field',
							'validate_callback' => array($this, '_validate_string')
						),
					),
				),
			));
			register_rest_route($namespace, '/sheet/generate-quick-access', array(
				array(
					'methods' => WP_REST_Server::READABLE,
					'callback' => array($this, 'generate_quick_access_link'),
					'permission_callback' => array($this, 'get_items_permissions_check'),
					'args' => array(
						'sheet_key' => array(
							'sanitize_callback' => 'sanitize_text_field',
							'validate_callback' => array($this, '_validate_string')
						),
					),
				),
			));
			register_rest_route($namespace, '/sheet/quick-access', array(
				array(
					'methods' => WP_REST_Server::READABLE,
					'callback' => array($this, 'get_quick_access_settings'),
					'args' => array(
						'session_id' => array(
							'validate_callback' => array($this, '_validate_int'),
							'required' => true
						),
					),
				),
			));
			register_rest_route($namespace, '/sheet/rows', array(
				array(
					'methods' => WP_REST_Server::READABLE,
					'callback' => array($this, 'get_sheet_rows'),
					'permission_callback' => array($this, 'get_items_permissions_check'),
					'args' => array(
						'sheet_key' => array(
							'type' => 'string',
							'sanitize_callback' => 'sanitize_text_field',
							'validate_callback' => array($this, '_validate_string'),
							'required' => true
						),
						'custom_enabled_columns' => array(
							'sanitize_callback' => 'sanitize_text_field',
							'type' => 'string',
							'required' => false
						),
						'sheet_filters' => array(
							'sanitize_callback' => 'sanitize_text_field',
							'type' => 'string',
							'required' => false
						),
						'sheet_export_id' => array(
							'sanitize_callback' => 'sanitize_text_field',
							'validate_callback' => array($this, '_validate_string'),
							'required' => true
						),
						'sheet_export_page' => array(
							'validate_callback' => array($this, '_validate_int'),
							'required' => true
						),
					),
				),
				array(
					'methods' => WP_REST_Server::CREATABLE,
					'callback' => array($this, 'update_sheet_rows'),
					'permission_callback' => array($this, 'update_items_permissions_check'),
					'args' => array(
						'sheet_key' => array(
							'type' => 'string',
							'sanitize_callback' => 'sanitize_text_field',
							'validate_callback' => array($this, '_validate_string'),
							'required' => true
						),
						'sheet_import_page' => array(
							'validate_callback' => array($this, '_validate_int'),
							'required' => true
						),
						'sheet_total_rows' => array(
							'validate_callback' => array($this, '_validate_int'),
							'required' => true
						),
						'sheet_wp_columns' => array(
							'sanitize_callback' => 'sanitize_text_field',
							'type' => 'string',
							'required' => true
						),
						'sheet_source_column' => array(
							'sanitize_callback' => 'sanitize_text_field',
							'type' => 'string',
							'required' => true
						),
						'sheet_existing_check_wp_field' => array(
							'sanitize_callback' => 'sanitize_text_field',
							'type' => 'string',
							'required' => false
						),
						'sheet_writing_type' => array(
							'sanitize_callback' => 'sanitize_text_field',
							'type' => 'string',
							'required' => true,
							'enum' => array('both', 'all_new', 'only_new', 'only_update'),
						),
					),
				),
			));
		}

		function update_sheet_rows($request) {
			$settings = array();
			$settings['post_type'] = $request->get_param('sheet_key');
			$settings['page'] = $request->get_param('sheet_import_page');
			$settings['per_page'] = $request->get_param('sheet_import_per_page');
			$settings['sheet_editor_column'] = explode(',', $request->get_param('sheet_wp_columns'));
			$settings['source_column'] = explode(',', $request->get_param('sheet_source_column'));
			$settings['writing_type'] = $request->get_param('sheet_writing_type');
			$settings['import_type'] = 'json';
			$settings['total_rows'] = $request->get_param('sheet_total_rows');
			$settings['existing_check_wp_field'] = explode(',', $request->get_param('sheet_existing_check_wp_field'));
			$settings['vgse_plain_mode'] = 'yes';
			$settings['vgse_import'] = 'yes';
			$settings['data'] = VGSE()->helpers->safe_html($request->get_param('sheet_data'));

			$out = WPSE_CSV_API_Obj()->import_data($settings);

			if (is_wp_error($out)) {
				return new WP_Error('wpse', $out->get_error_message(), array('status' => 400));
			}

			return $out;
		}

		function get_sheet_rows($request) {
			$settings = $request->get_params();

			$settings['wpse_source'] = 'load_rows';
			$settings['vgse_plain_mode'] = 'yes';
			$settings['vgse_csv_export'] = 'yes';
			$settings['post_type'] = $request->get_param('sheet_key');
			$settings['filters'] = $request->get_param('sheet_filters');

			// Required by the advanced filters module
			if (!empty($settings['filters'])) {
				$original_filters = ( isset($_REQUEST['filters'])) ? $_REQUEST['filters'] : '';
				$_REQUEST['filters'] = $settings['filters'];
			}

			if (empty($settings['custom_enabled_columns'])) {
				$request->set_param('custom_enabled_columns', implode(',', array_keys(vgse_universal_sheet()->get_export_options($settings['post_type']))));
			}
			$_REQUEST['custom_enabled_columns'] = $request->get_param('custom_enabled_columns');
			$settings['custom_enabled_columns'] = $request->get_param('custom_enabled_columns');

			$settings['export_key'] = $request->get_param('sheet_export_id');
			$settings['paged'] = $request->get_param('sheet_export_page');

			$rows = VGSE()->helpers->get_rows($settings);

			if (!empty($settings['filters'])) {
				$_REQUEST['filters'] = $original_filters;
			}
			if (is_wp_error($rows)) {
				return new WP_Error('wpse', $rows->get_error_message(), array('status' => 400));
			}

			$rows['rows'] = array_values($rows['rows']);
			return $rows;
		}

		/**
		 * Get sheet settings
		 * @param WP_REST_Request $request Full data about the request.
		 * @return WP_Error|WP_REST_Response
		 */
		function get_sheet_settings($request) {
			$editor = VGSE()->helpers->get_provider_editor($request['sheet_key']);
			$out = $editor->get_editor_settings($request['sheet_key']);

			$out['export_columns'] = vgse_universal_sheet()->get_export_options($request['sheet_key']);
			$out['import_columns'] = vgse_universal_sheet()->get_import_options($request['sheet_key']);

			$unnecessary_keys = array('colWidths', 'colHeaders', 'columnsUnformat', 'columnsFormat', 'final_spreadsheet_columns_settings', 'export_keys_mapping');
			foreach ($unnecessary_keys as $key_to_remove) {
				if (isset($out[$key_to_remove])) {
					unset($out[$key_to_remove]);
				}
			}
			return $out;
		}

		function _generate_token($user_id) {
			// @todo
			return null;
		}

		function get_quick_access_settings($request) {
			$transient_key = 'vgse_quick_access' . $request['session_id'];
			$data = get_transient($transient_key);

			if (empty($data)) {
				return new WP_Error(
						'wpse', __('The quick access link has expired or it does not exist'), array(
					'status' => 403,
						)
				);
			}

			delete_transient($transient_key);
			return $data;
		}

		function generate_quick_access_link($request) {
			VGSE()->current_provider = VGSE()->helpers->get_data_provider($request['sheet_key']);
			$spreadsheet_columns = VGSE()->helpers->get_provider_columns($request['sheet_key']);

			$data = array(
				'sheet_key' => $request['sheet_key'],
				'user_session' => $this->_generate_token(get_current_user_id()),
				'custom_enabled_columns' => array_unique(array_values(wp_list_pluck($spreadsheet_columns, 'export_key'))),
			);
			$data = WP_Sheet_Editor_Filters::get_instance()->include_previous_session_filters($data, $request['sheet_key']);
			$data['sheet_filters'] = $data['last_session_filters'];
			unset($data['last_session_filters']);

			$session_id = crc32($request['sheet_key'] . get_current_user_id());
			$transient_key = 'vgse_quick_access' . $session_id;
			set_transient($transient_key, $data, DAY_IN_SECONDS);

			$out = array(
				'session_id' => $session_id,
				'quick_access_url' => rest_url($this->get_route_namespace() . '/sheet/quick-access?session_id=' . $session_id)
			);
			return $out;
		}

		/**
		 * Get sheet settings
		 * @param WP_REST_Request $request Full data about the request.
		 * @return WP_Error|WP_REST_Response
		 */
		function get_settings($request) {

			$enabled_post_types = VGSE()->helpers->get_enabled_post_types();
			$user = get_userdata(get_current_user_id());
			$out = array(
				'sheets' => VGSE()->helpers->get_prepared_post_types(),
				'active_sheets' => $enabled_post_types,
				'rest_base' => rest_url(),
				'current_user_id' => get_current_user_id(),
				'current_user_email' => $user->user_email,
				'current_user_first_name' => $user->first_name,
				'current_user_last_name' => $user->last_name,
				'current_user_role' => current($user->roles),
				'woocommerce_product_post_type_key' => apply_filters('vg_sheet_editor/woocommerce/product_post_type_key', 'product'),
			);

			return $out;
		}

		/**
		 * Get a collection of items
		 *
		 * @param WP_REST_Request $request Full data about the request.
		 * @return WP_Error|WP_REST_Response
		 */
		public function get_items($request) {
			return new WP_REST_Response($data, 200);
		}

		/**
		 * Check if a given request has access to get items
		 *
		 * @param WP_REST_Request $request Full data about the request.
		 * @return WP_Error|bool
		 */
		public function get_general_settings_permissions_check($request) {
			return is_user_logged_in() && current_user_can('edit_posts');
		}

		public function get_items_permissions_check($request) {
			return is_user_logged_in() && VGSE()->helpers->user_can_view_post_type($request['sheet_key']);
		}

		public function update_items_permissions_check($request) {
			return is_user_logged_in() && VGSE()->helpers->user_can_edit_post_type($request['sheet_key']);
		}

		function register_hooks() {
			add_filter('vg_sheet_editor/allowed_on_frontend', array($this, 'allow_core_on_frontend'));
		}

		function allow_core_on_frontend($allow) {
			global $wp;
			if (strpos(home_url($wp->request), rest_url()) !== false) {
				$allow = true;
			}
			return $allow;
		}

	}

}

if (!function_exists('wpse_init_rest_api')) {
	$GLOBALS['wpse_rest_api'] = new WPSE_REST_API();

	//Load this only for REST API requests
	add_action('rest_api_init', 'wpse_init_rest_api');

	function wpse_init_rest_api() {

		if (!WP_Sheet_Editor_Helpers::get_instance()->is_rest_request()) {
			return;
		}
		$GLOBALS['wpse_rest_api']->register_hooks();

		// Init WPSE core
		vgse_init();

		$GLOBALS['wpse_rest_api']->register_routes();

		return $GLOBALS['wpse_rest_api'];
	}

}