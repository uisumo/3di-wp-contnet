<?php

/**
 * Enable using Gravity Forms merge tags in the `[gv_math]` shortcode.
 *
 * Replaces the values of the merge tags with values before the numbers are run through the calculator.
 *
 * Example:
 *
 * Entry #123 has a field named "Number" with the ID "5" and a value of 4:
 * - Before: [gv_math scope="entry" id="123"] {Number:5} + 2 [/gv_math]
 * - After: [gv_math scope="entry" id="123"] 4 + 2 [/gv_math]
 *
 */
class GravityView_Math_GravityForms {

	/**
	 * Regex to match any Gravity Forms Merge Tags
	 * @since 1.0
	 */
	const MERGE_TAG_REGEX = '/{[^{]*?:(\d+(\.\d+)?|[a-z_]+)(:(.*?))?}/mi';

	/**
	 * @since 1.0
	 * @var array {
	 * @type string $scope         If not defined, return original formula for basic math. If defined, choices are `form`, `view`, `visible`, `entry`
	 * @type string $id            Form, View or Entry ID
	 * @type string $default_value If a value is not valid use the default value. Pass true or 1 to enable, or skip to skip the invalid value. (Default: skip)
	 * @type bool   $debug         Show or hide error messages. Pass true or 1 to enable. (Default: false)
	 * @type string $decimals      The number of decimals to display. If undefined, displays the number of decimals returned by the math result.
	 * }
	 */
	private static $default_atts = array(
		'scope'         => '',
		'id'            => '',
		'default_value' => '',
		'filter'        => '',
		'debug'         => false,
		'decimals'      => null,
	);
	/**
	 * @since 1.0
	 * @var array
	 */
	private static $scopes = array(
		'form',
		'view',
		'visible',
		'entry',
	);
	/**
	 * @var GravityView_Math_Report
	 */
	public $reporter;

	function __construct() {

		$this->reporter = GravityView_Math_Report::get_instance();

		add_filter( 'gravityview/math/shortcode/before', array( $this, 'shortcode' ), 10, 4 );
	}

	/**
	 * @since 1.0
	 *
	 * @param string $formula
	 * @param array  $atts
	 * @param string $content
	 * @param string $shortcode
	 *
	 * @return mixed|string
	 */
	public function shortcode( $formula = '', $atts = array(), $content = '', $shortcode = 'gv_math' ) {

		$is_ajax = defined( 'DOING_AJAX' ) && DOING_AJAX;

		if ( is_admin() && ! $is_ajax ) {
			return '';

		}

		do_action( 'gravityview_math_log_notice',
			sprintf(
				'%s: %s',
				esc_html__( 'Formula before parsing', 'gravityview-math' ),
				$formula
			),
			$atts
		);

		$atts = shortcode_atts( self::$default_atts, $atts, $shortcode );

		// If the scope isn't defined or supported by this class, just return the original formula.
		if ( empty( $atts['scope'] ) || ! in_array( $atts['scope'], self::$scopes ) ) {

			return $formula;

		} elseif ( 'visible' !== $atts['scope'] && 'entry' !== $atts['scope'] && empty( $atts['id'] ) ) {

			$formula = '';

			$data = array(
				'atts' => $atts,
				'code' => 'ID_not_set'
			);

			do_action( 'gravityview_math_log_error', esc_html__( 'No ID provided', 'gravityview-math' ), $data );

			unset( $data );

			return $formula;
		}

		$formula = $this->replace_merge_tags( $formula, $atts );

		switch ( $atts['scope'] ) {
			case 'entry':
				$formula = $this->get_formula_for_entry( $formula, $atts );
				break;
			default:
				$formula = $this->get_formula_bulk( $formula, $atts );
		}

		// Remove all merge tags that remain.
		// They cause errors for the math engine if left in.
		$formula = preg_replace( self::MERGE_TAG_REGEX, '', $formula );

		do_action( 'gravityview_math_log_notice',
			sprintf(
				'%s: %s',
				esc_html__( 'Formula after parsing', 'gravityview-math' ),
				$formula
			)
		);

		return $formula;
	}

	/**
	 * @since 1.0
	 *
	 * @param $formula
	 * @param $atts
	 *
	 * @return string
	 */
	function get_formula_for_entry( $formula, $atts ) {

		$entry = $this->get_entry( $atts );

		$form = isset( $entry['form_id'] ) ? GFAPI::get_form( $entry['form_id'] ) : null;

		if ( ! $form ) {
			return $formula;
		}

		$matches = $this->match_merge_tags( $formula );

		foreach ( $matches as $match ) {

			$value = '';
			$match = array_pad( $match, 5, null );

			list( $merge_tag, $input_id, $_empty, $modifier_tag_with_sep, $modifier_tag ) = $match;

			$field = GFFormsModel::get_field( $form, floor( $input_id ) );

			$debug_data = array(
				'input_id' => $input_id,
				'lead'     => $entry,
				'atts'     => $atts,
				'field'    => $field,
			);

			if ( ! GFCommon::is_valid_for_calcuation( $field ) ) {

				$debug_data['code'] = 'invalid_field';

				do_action( 'gravityview_math_log_error', esc_html__( 'Field not valid for calculation', 'gravityview-math' ), $debug_data );

				unset( $debug_data );

				$formula = '';

				continue;
			}

			/**
			 * If the field value is empty check for a default value attribute.
			 * If no default value is set then let Gravity Forms Handle it.
			 * If the default value is 'skip' then move on to the next field.
			 */
			if ( ! isset( $entry[ $input_id ] ) || '' === $entry[ $input_id ] ) {

				$debug_data['code'] = 'empty_entry';

				do_action( 'gravityview_math_log_warning', esc_html__( 'A field in the calculation did not contain a value', 'gravityview-math' ), $debug_data );

				if ( 'skip' === $atts['default_value'] ) {
					$formula = '';
					continue;
				} elseif ( '' !== $atts['default_value'] ) {
					$value = floatval( $atts['default_value'] );
				}

			} else {
				$value = GFCommon::get_calculation_value( $input_id, $form, $entry );
			}

			$value = apply_filters( 'gform_merge_tag_value_pre_calculation', $value, $input_id, rgar( $match, 4 ), $field, $form, $entry );

			$formula = str_replace( $merge_tag, $value, $formula );
		}

		unset( $debug_data );

		return $formula;
	}

	/**
	 * Fetch an entry array from attribute IDs, if set, otherwise, the current entry in GravityView
	 *
	 * @param array $atts
	 *
	 * @return array|mixed
	 */
	function get_entry( $atts ) {

		$entry = array();

		if ( ! empty( $atts['id'] ) ) {
			$entry = GFAPI::get_entry( $atts['id'] );
		} else if ( class_exists( 'GravityView_View' ) ) {
			$entry = GravityView_View::getInstance()->getCurrentEntry();
		}

		return $entry;
	}

	/**
	 * Process extra Math merge tags in formula
	 *
	 * @since 2.0
	 *
	 * @param $formula Formula statement
	 * @param $atts    Shortcode attributes
	 *
	 * @return string
	 */
	public function replace_merge_tags( $formula, $atts = array() ) {

		$formula = $this->process_entry_count_merge_tag( $formula, $atts );

		return $formula;
	}

	/**
	 * Process {entry_count} merge tag
	 *
	 * @since 2.0
	 *
	 * @param $formula Formula statement
	 * @param $atts    Shortcode attributes
	 *
	 * @return string
	 */
	public function process_entry_count_merge_tag( $formula, $atts = array() ) {

		if ( empty( $atts['scope'] ) ) {
			return $formula;
		}

		if ( ! preg_match( '/{entry_count(:visible|:view|:form)?}/ism', $formula ) ) {
			return $formula;
		}

		if ( in_array( $atts['scope'], array( 'view', 'form' ), true ) && empty( $atts['id'] ) ) {
			do_action( 'gravityview_math_log_error', esc_html__( 'No ID provided', 'gravityview-math' ), array( 'atts' => $atts ) );

			return $formula;
		}

		$scope           = $atts['scope'];
		$view_entries    = 0;
		$visible_entries = 0;
		$default_entries = 0;
		$form_entries    = 0;
		$form_id         = ( 'form' === $scope ) ? $atts['id'] : null;

		if ( 'visible' === $scope && class_exists( 'GravityView_View' ) ) {
			$view_entries    = GravityView_View::getInstance()->getTotalEntries();
			$visible_entries = count( GravityView_View::getInstance()->getEntries() );
			$default_entries = $visible_entries;
			$form_id         = GravityView_View::getInstance()->getFormId();
		} elseif ( 'view' === $scope && class_exists( 'GravityView_View' ) ) {

			$view = \GV\View::by_id( $atts['id'] );

			if ( $view ) {

				$view_entries    = $view->get_entries()->total();
				$visible_entries = count( GravityView_View::getInstance()->getEntries() );

				$default_entries = $view_entries;

				// TODO: Support joins
				$form_id = $view->form->ID;
			}
		}

		if ( 'form' === $scope || false !== strpos( $formula, '{entry_count:form}' ) ) {

			$form_entries = GFAPI::count_entries( (array) $form_id, array( 'status' => 'active' ) );

			if ( 'form' === $scope ) {
				$default_entries = $form_entries;
			}
		}

		$formula = str_replace( '{entry_count:visible}', $visible_entries, $formula );
		$formula = str_replace( '{entry_count:view}', $view_entries, $formula );
		$formula = str_replace( '{entry_count:form}', $form_entries, $formula );
		$formula = str_replace( '{entry_count}', $default_entries, $formula );

		return $formula;
	}

	/**
	 *
	 * @since 1.0
	 *
	 * @param $content
	 *
	 * @return array
	 */
	private function match_merge_tags( $content ) {

		preg_match_all( self::MERGE_TAG_REGEX, $content, $matches, PREG_SET_ORDER );

		return (array) $matches;
	}

	/**
	 * @since 1.0
	 *
	 * @param $formula
	 * @param $atts
	 *
	 * @return mixed
	 */
	function get_formula_bulk( $formula, $atts ) {

		$matches = $this->match_merge_tags( $formula );

		foreach ( $matches as $match ) {

			$match = array_pad( $match, 5, null );

			/**
			 * @var string      $merge_tag             Full matched merge tag (Example: `{Number:5:avg}`)
			 * @var string      $input_id              The ID of the input (Example: `5`)
			 * @var string      $_empty                This is empty. Do not use.
			 * @var string      $modifier_tag_with_sep Number modifier with separator (Example: `:avg`)
			 * @var string|null $modifier_tag          Modifier that says what calculation you want to perform on the number (Example: `avg`)
			 */
			list( $merge_tag, $input_id, $_empty, $modifier_tag_with_sep, $modifier_tag ) = $match;

			$method_name = "get_aggregate_data_{$atts['scope']}";

			/**
			 * Get an array of values based on the scope.
			 *
			 * @var array|false $result If invalid, is false. Otherwise, array with max, min, avg, count, sum values for the field ID based on the scope.
			 */
			$result = $this->$method_name( $atts, $input_id, $modifier_tag );

			if ( $result ) {
				if ( 'skip' == $atts['default_value'] || 'form' !== $atts['scope'] ) {
					switch ( $modifier_tag ) {
						case 'max':
						case 'min':
						case 'avg':
						case 'count':
							$value = $result[ $modifier_tag ];
							break;
						case 'sum':
						default:
							$value = $result['sum'];
					}
				} else {
					switch ( $modifier_tag ) {
						case 'max':
							$value = max( $result['max'], $atts['default_value'] );
							break;
						case 'min':
							$value = min( $result['max'], $atts['default_value'] );
							break;
						case 'avg':
							$value = $result['count'] > 0 ? ( $result['sum'] + ( count( explode( ',', $result['all_ids'] ) ) - count( explode( ',', $result['filtered_ids'] ) ) ) * $atts['default_value'] ) / $result['count'] : 0; // Prevent division by 0
							break;
						case 'count':
							$value = $result[ $modifier_tag ];
							break;
						case 'sum':
						default:
							$value = $result['sum'] + ( count( explode( ',', $result['all_ids'] ) ) - count( explode( ',', $result['filtered_ids'] ) ) ) * $atts['default_value'];
					}
				}
				if ( isset( $result['debug'] ) && ! empty( $result['debug'] ) ) {

					$data = array(
						'input_id' => $input_id,
						'lead'     => $result['debug'],
						'atts'     => $atts,
						'code'     => 'empty_form_field'
					);

					do_action( 'gravityview_math_log_warning', esc_html__( 'A field in the calculation did not contain a value', 'gravityview-math' ), $data );

					unset( $data );

				}

				$formula = str_replace( $merge_tag, $value, $formula );
			}
		}

		return $formula;
	}

	/**
	 * Get aggregate data for a form from a basic SQL query
	 *
	 * @since 1.0
	 * @since 2.0 Added $modifier_tag parameter
	 *
	 * @param array       $atts
	 * @param int|double  $field_id
	 * @param string|null $modifier_tag
	 *
	 * @return bool|mixed
	 */
	function get_aggregate_data_form( $atts = array(), $field_id = 0, $modifier_tag = null ) {
		global $wpdb;

		$form_id = (int) $atts['id'];

		$value = $this->get_cache( $form_id, $field_id, $atts['filter'] );

		if ( ! $value ) {

			/** GF >= 2.3 */
			if ( version_compare( GFFormsModel::get_database_version(), '2.3-dev-1', '>=' ) ) {
				/** @define "$entry_meta_table" "wp_gf_entry_meta" */
				$entry_meta_table_name = GFFormsModel::get_entry_meta_table_name();
				/** @define "$entry_table" "wp_gf_entry" */
				$entry_table = GFFormsModel::get_entry_table_name();

				if ( $atts['filter'] ) {
					$query = new GF_Query( $form_id );

					// GF_Query limits entry queries to 20 by default; remove that limit
					$query->limit( 0 );

					$filtered_gf_query_parts   = $this->parse_filter_to_gf_query_parts( $atts['filter'], array( 'filter_status' => 'active' ), $form_id );
					$unfiltered_gf_query_parts = $this->parse_filter_to_gf_query_parts( '', array( 'filter_status' => 'active' ) );

					$query->where( $unfiltered_gf_query_parts['conditions'] );
					$query_unfiltered_ids = $query->get_ids();

					$query->where( $filtered_gf_query_parts['conditions'] );
					if ( ! is_null( $filtered_gf_query_parts['limit'] ) ) {
						$query->limit( $filtered_gf_query_parts['limit'] );
					}
					$query_filtered_ids = array_merge( array( 0 ), $query->get_ids() );

					$sql = "SELECT %s AS all_ids, %s AS filtered_ids, SUM(value) AS sum, AVG(value) AS avg, MAX(value) AS max, MIN(value) AS min, COUNT(value) AS count FROM";
					$sql = $wpdb->prepare( $sql, implode( ',', $query_unfiltered_ids ), implode( ',', $query_filtered_ids ) );

					$column = new GF_Query_Column( $field_id, $form_id );

					if ( $column->is_entry_column() ) {
						$subquery = "SELECT CAST(t1.$field_id AS DECIMAL( 65, 30 )) AS value FROM $entry_table t1 WHERE t1.id IN ";
					} else {
						$subquery = $wpdb->prepare( "SELECT CAST(m1.meta_value AS DECIMAL( 65, 30 )) AS value FROM $entry_meta_table_name m1 WHERE m1.meta_key = %s AND m1.entry_id IN ", $field_id );
					}
					$subquery .= '(' . implode( ',', $query_filtered_ids ) . ')';

					$sql = "$sql ($subquery) t";
				} else {
					$sql = <<<SQL
					SELECT

					  GROUP_CONCAT(DISTINCT details.`entry_id` ORDER BY details.`entry_id` ASC SEPARATOR ',') AS all_ids,
					  GROUP_CONCAT(DISTINCT CASE WHEN details.`meta_key` = %s THEN details.`entry_id` ELSE NULL END ORDER BY details.`entry_id` ASC SEPARATOR ',') AS filtered_ids,

					  SUM(CASE WHEN details.`meta_key` = %s THEN CAST( details.`meta_value` AS DECIMAL( 65, 30 ) ) ELSE 0 END) AS sum,
					  AVG(CASE WHEN details.`meta_key` = %s THEN CAST( details.`meta_value` AS DECIMAL( 65, 30 ) ) ELSE NULL END) AS avg,
					  MAX(CASE WHEN details.`meta_key` = %s THEN CAST( details.`meta_value` AS DECIMAL( 65, 30 ) ) ELSE NULL END) AS max,
					  MIN(CASE WHEN details.`meta_key` = %s THEN CAST( details.`meta_value` AS DECIMAL( 65, 30 ) ) ELSE NULL END) AS min,
					  SUM(CASE WHEN details.`meta_key` = %s THEN 1 ELSE 0 END) AS count

					FROM
					  `$entry_meta_table_name` details
					  LEFT JOIN
					  `$entry_table` entry ON details.entry_id = entry.id
					WHERE
					  entry.`status` = %s AND
					  details.`form_id` = %d
SQL;
					$sql = $wpdb->prepare( $sql, $field_id, $field_id, $field_id, $field_id, $field_id, $field_id, 'active', $form_id );
				}

				/** GF < 2.3 */
			} else {
				/** @define "$lead_detail_table" "wp_rg_lead_detail" */
				$lead_detail_table_name = RGFormsModel::get_lead_details_table_name();
				/** @define "$lead_table" "wp_rg_lead" */
				$lead_table = RGFormsModel::get_lead_table_name();

				$field_number_min = (double) $field_id - 0.0001;
				$field_number_max = (double) $field_id + 0.0001;

				$sql = <<<SQL
				SELECT
				  GROUP_CONCAT(DISTINCT details.`lead_id`
							   ORDER BY details.`lead_id` ASC
							   SEPARATOR ',') AS all_ids,
				  GROUP_CONCAT( DISTINCT
								CASE
								WHEN details.`field_number` BETWEEN %f AND %f THEN details.`lead_id`
								ELSE NULL
								END
								ORDER BY details.`lead_id` ASC
								SEPARATOR ',') AS filtered_ids,
				  SUM( CASE
					   WHEN details.`field_number` BETWEEN %f AND %f THEN CAST( details.`value` AS DECIMAL( 65, 30 ) )
					   ELSE 0
					   END ) AS sum,
				  AVG( CASE
					   WHEN details.`field_number` BETWEEN %f AND %f THEN CAST( details.`value` AS DECIMAL( 65, 30 ) )
					   ELSE NULL
					   END ) AS avg,
				  MAX( CASE
					   WHEN details.`field_number` BETWEEN %f AND %f THEN CAST( details.`value` AS DECIMAL( 65, 30 ) )
					   ELSE NULL
					   END ) AS max,
				  MIN( CASE
					   WHEN details.`field_number` BETWEEN %f AND %f THEN CAST( details.`value` AS DECIMAL( 65, 30 ) )
					   ELSE NULL
					   END ) AS min,
				  SUM( CASE
					   WHEN details.`field_number` BETWEEN %f AND %f THEN 1
					   ELSE 0
					   END ) AS count
				FROM
				  `$lead_detail_table_name` details
				  LEFT JOIN
				  `$lead_table` lead ON details.lead_id = lead.id
				WHERE
				  lead.`status` = %s AND
				  details.`form_id` = %d
SQL;
				$sql = $wpdb->prepare( $sql, $field_number_min, $field_number_max, $field_number_min, $field_number_max, $field_number_min, $field_number_max, $field_number_min, $field_number_max, $field_number_min, $field_number_max, $field_number_min, $field_number_max, 'active', $form_id );
			}

			$results = $wpdb->get_results( $sql, ARRAY_A );
			$results = $results[0];

			foreach ( [ 'sum', 'avg', 'max', 'min' ] as $operation ) {
				$results[ $operation ] = GravityView_Math_Shortcode::format_number( (float) $results[ $operation ], $atts['decimals'] );
			}

			//Store skipped entries for WP_Error
			$filtered_id_cnt = count( explode( ',', $results['filtered_ids'] ) );
			$all_ids_cnt     = count( explode( ',', $results['all_ids'] ) );

			//determine if there are skipped results
			if ( $filtered_id_cnt !== $all_ids_cnt ) {

				$all_ids         = explode( ',', $results['all_ids'] );
				$filtered_ids    = explode( ',', $results['filtered_ids'] );
				$skipped_entries = array_diff( $all_ids, $filtered_ids );

				if ( count( $skipped_entries ) > 0 && isset( $atts['debug'] ) && true == $atts['debug'] ) {
					$results['debug'] = $skipped_entries;
					$results['debug'] = array_values( $results['debug'] );
				}
			}

			$value = $results;

			$this->set_cache( $form_id, $field_id, $atts['filter'], $value );
		}

		return $value;
	}

	/**
	 * Get aggregate data array for visible View entries
	 *
	 * @since 2.0 Added $modifier_tag parameter
	 *
	 * @param array       $atts
	 * @param int         $field_id
	 * @param string|null $modifier_tag
	 *
	 * @return array|bool
	 */
	function get_aggregate_data_visible( $atts = [], $field_id = 0, $modifier_tag = null ) {
		$entries = GravityView_View::getInstance()->getEntries();
		$form_id = GravityView_View::getInstance()->getFormId();

		/**
		 * @filter `gravityview/math/entries/visible` Modify visible entries
		 *
		 * @since  2.0
		 *
		 * @param array $entries
		 * @param array $atts
		 */
		$entries = apply_filters( 'gravityview/math/entries/visible', $entries, $atts );

		if ( empty( $entries ) ) {
			$view_id = GravityView_View::getInstance()->getViewId();

			if ( empty( $view_id ) ) {
				$data = [
					'atts' => $atts,
					'code' => 'no_view_found'
				];

				do_action( 'gravityview_math_log_warning', esc_html__( 'No View was found', 'gravityview-math' ), $data );

				unset( $data );
			} else {
				$data = [
					'atts'      => $atts,
					'code'      => 'no_entries_found',
					'view_link' => admin_url( sprintf( 'post.php?post=%d&action=edit', $view_id ) ),
				];

				do_action( 'gravityview_math_log_warning', esc_html__( 'The following View does not currently contain any entries', 'gravityview-math' ), $data );

				unset( $data );
			}

			return false;
		}

		$filters = $this->parse_filter_to_array( $atts['filter'] );
		if ( ! empty( $filters ) ) {
			foreach ( $entries as $index => $entry ) {
				if ( ! $this->entry_matches_filter_conditions( $entry, $filters ) ) {
					unset( $entries[ $index ] );
				}
			}
		}

		if ( empty( $entries ) ) {
			$data = [
				'atts' => $atts,
				'code' => 'no_entries_found',
			];

			do_action( 'gravityview_math_log_warning', esc_html__( 'None of the visible entries passed the filter condition', 'gravityview-math' ), $data );

			return false;
		}

		return $this->get_aggregate_data_entries( $entries, $atts, $field_id, $form_id, $modifier_tag );
	}

	/**
	 * Get aggregate data array for all View entries
	 *
	 * @since 1.0
	 * @since 2.0 Added $modifier_tag parameter
	 *
	 * @param array             $atts
	 * @param int|double|string $field_id
	 * @param string|null       $modifier_tag
	 *
	 * @return array|false Array with 'sum', 'max', 'min', 'avg', 'count' keys. False if no View was found.
	 */
	function get_aggregate_data_view( $atts = [], $field_id = 0, $modifier_tag = null ) {
		$view = \GV\View::by_id( $atts['id'] );

		if ( ! $view ) {
			$data = [
				'atts' => $atts,
				'code' => 'no_view_found'
			];

			do_action( 'gravityview_math_log_error', esc_html__( 'No View was found', 'gravityview-math' ), $data );

			return false;
		}

		$form_id  = $view->form->ID;
		$form_ids = [ $form_id ];

		$value = $this->get_cache( $form_ids, $field_id, $atts['filter'] );

		// Cache was hit; return early.
		if ( $value ) {
			return $value;
		}

		if ( $atts['filter'] && gravityview()->plugin->supports( 'gfquery' ) ) {
			/**
			 * Further restrict the query by the filters supplied.
			 */
			add_action( 'gravityview/view/query', $callback = function ( &$query, $view ) use ( $atts ) {
				$gf_query_parts = $this->parse_filter_to_gf_query_parts( $atts['filter'] );

				if ( $gf_query_parts['conditions'] instanceof GF_Query_Condition ) {
					$parts = $query->_introspect();
					$query->where( GF_Query_Condition::_and( $parts['where'], $gf_query_parts['conditions'] ) );
				}

				if ( isset( $gf_query_parts['limit'] ) ) {
					$query->limit( (int) $gf_query_parts['limit'] );
				}
			}, 10, 2 );

			$entries = $view->get_entries();

			remove_action( 'gravityview/view/query', $callback );
		} else {
			$request = new WP_REST_Request();
			$request->set_param( 'limit', 0 );
			$request->set_param( 'page', 1 );
			$gv_request = new \GV\REST\Request( $request );

			$entries = $view->get_entries( $gv_request );

			unset( $gv_request, $request );
		}

		if ( ! $entries->count() ) {
			$data = [
				'atts'      => $atts,
				'code'      => 'no_entries_found',
				'view_link' => admin_url( sprintf( 'post.php?post=%d&action=edit', $view->ID ) ),
			];

			do_action( 'gravityview_math_log_warning', esc_html__( 'The following View does not currently contain any entries', 'gravityview-math' ), $data );

			return false;
		}

		$value = $this->get_aggregate_data_entries( $entries->all(), $atts, $field_id, $form_id, $modifier_tag );

		$this->set_cache( $form_ids, $field_id, $atts['filter'], $value );

		return $value;
	}

	/**
	 * Get aggregate data array for specific entries
	 *
	 * @since 2.0
	 * @since 2.0.2 Added $form_id parameter
	 *
	 * @param array[array|\GV\GF_Entry]           $entries
	 * @param array             $atts
	 * @param int|double|string $field_id
	 * @param int|double|string $form_id
	 * @param string|null       $modifier_tag
	 *
	 * @return array Array with 'sum', 'max', 'min', 'avg', 'count' keys
	 */
	function get_aggregate_data_entries( $entries = [], $atts = [], $field_id = 0, $form_id = 0, $modifier_tag = null ) {
		$field_id = (string) $field_id;
		$field    = GFFormsModel::get_field( $form_id, $field_id );

		$all_values = $non_empty_values = [];

		foreach ( $entries as $entry ) {
			if ( $entry instanceof \GV\GF_Entry ) {
				$entry = $entry->as_entry();
			}

			$value = isset( $entry[ $field_id ] ) ? $entry[ $field_id ] : '';
			if ( 'count' !== $modifier_tag ) {
				// Strip non-numeric characters so that the value could be used for calculation
				$transformed_value = preg_replace( '/[^\\d.,-]/', '', $value );

				// Number field values are saved with with '.' as a decimal point regardless of the locale; stripping thousands may strip decimal point if locale's thousands separator = '.'
				if ( 'number' !== $field->type ) {
					$transformed_value = (float) GravityView_Math_Shortcode::strip_thousands_sep( $transformed_value );
				}

				/**
				 * @filter `gravityview/math/aggregate_data/modify_field_value` Modify field value
				 *
				 * @since  2.0
				 *
				 * @param string            $transformed_value Transformed field value
				 * @param string            $orginal_value     Original field value
				 * @param int|double|string $field_id          Field ID
				 * @param array             $entry             Entry data
				 * @param string|null       $modifier_tag      Calculation type (e.g., sum, avg, etc.)
				 */
				$value = apply_filters( 'gravityview/math/aggregate_data/modify_field_value', $transformed_value, $value, $field_id, $entry, $modifier_tag );
			}

			$all_values[] = $value;

			if ( '' !== $value ) {
				$non_empty_values[] = $value;
			} else {
				$data = [
					'input_id' => $field_id,
					'lead'     => $entry,
					'atts'     => $atts,
					'code'     => 'empty_visible_field'
				];

				do_action( 'gravityview_math_log_warning', esc_html__( 'A field in the calculation did not contain a value', 'gravityview-math' ), $data );

				unset( $data );

				if ( is_numeric( $atts['default_value'] ) ) {
					$all_values   = array_slice( $all_values, - 1 );
					$all_values[] = $non_empty_values[] = (float) $atts['default_value'];
				}
			}
		}

		$result = [
			'sum'   => array_sum( $all_values ),
			'max'   => ( count( $non_empty_values ) > 0 ? max( $non_empty_values ) : 0 ),
			'min'   => ( count( $non_empty_values ) > 0 ? min( $non_empty_values ) : 0 ),
			'avg'   => ( count( $non_empty_values ) > 0 ? array_sum( $all_values ) / count( $non_empty_values ) : 0 ),
			'count' => count( $all_values ),
		];

		foreach ( $result as &$value ) {
			$value = GravityView_Math_Shortcode::format_number( (float) $value, $atts['decimals'] );
		}

		unset( $all_values, $non_empty_values );

		return $result;
	}

	/**
	 * Get a cached value from the database
	 *
	 * This allows us to not regenerate queries we've already performed
	 *
	 * @param        $form_id
	 * @param int    $field_id
	 * @param string $filter
	 *
	 * @return bool|mixed
	 */
	function get_cache( $form_id, $field_id = 0, $filter = '' ) {
		$filter = substr( md5( $filter ), 0, 8 );
		if ( class_exists( 'GravityView_Cache' ) ) {
			$Cache = new GravityView_Cache( $form_id, array(
				'field_id' => $field_id,
				'filters'  => $filter,
			) );
			$value = $Cache->get();
		} else {
			$value = wp_cache_get( $this->get_cache_key( $form_id, $field_id, $filter ) );
		}

		return $value;
	}

	/**
	 * @since 1.0
	 *
	 * @param int    $form_id
	 * @param int    $field_id
	 * @param string $filter
	 *
	 * @return string
	 */
	function get_cache_key( $form_id, $field_id = 0, $filter = '' ) {

		$key = sprintf( 'gv_math_%d_%d', $form_id, $field_id );

		if ( $filter ) {
			$key .= "_{$filter}";
		}

		return $key;
	}

	/**
	 * Store fetched value in cache for
	 *
	 * @since 1.0
	 *
	 * @param        $form_id
	 * @param int    $field_id
	 * @param string $filter
	 * @param        $value
	 * @param null   $expire
	 *
	 * @return bool
	 */
	function set_cache( $form_id, $field_id = 0, $filter = '', $value, $expire = null ) {

		$filter = substr( md5( $filter ), 0, 8 );

		if ( class_exists( 'GravityView_Cache' ) ) {
			$Cache = new GravityView_Cache( $form_id, array(
				'field_id' => $field_id,
				'filters'  => $filter,
			) );
			$valid = $Cache->set( $value );
		} else {
			$valid = wp_cache_set( $this->get_cache_key( $form_id, $field_id, $filter ), $value, $expire );
		}

		return $valid;
	}

	/**
	 * Converts a filter query string to GF_Query conditions
	 * and limits.
	 *
	 * @param string $filter   The filter string.
	 * @param array  $defaults An array of default filters to apply if not given.
	 * @param int    $form_id  The form ID.
	 *
	 * @return array With the following keys:
	 *                   GF_Query_Condition $conditions
	 *                   int                $limit
	 */
	private function parse_filter_to_gf_query_parts( $filter, $defaults = array(), $form_id = 0 ) {

		$return = array(
			'conditions' => null,
			'limit'      => 0,
		);

		if ( ! class_exists( '\GF_Query_Condition' ) ) {
			return $return;
		}

		parse_str( $filter, $results );

		$results = wp_parse_args( $results, $defaults );

		if ( isset( $results['limit'] ) ) {
			$return['limit'] = $results['limit'];
			unset( $results['limit'] );
		}

		$conditions = array();
		$opmap      = array(
			'isnot'       => GF_Query_Condition::NEQ,
			'contains'    => GF_Query_Condition::CONTAINS,
			'notcontains' => GF_Query_Condition::NCONTAINS,
			'lt'          => GF_Query_Condition::LT,
			'gt'          => GF_Query_Condition::GT,
		);

		if ( $form_id ) {
			$form = GFAPI::get_form( $form_id );
		}

		foreach ( $results as $filter => $value ) {
			if ( strpos( $filter, 'filter_' ) === 0 ) {
				list( , $key ) = explode( '_', $filter, 2 );

				$keyparts = explode( ':', $key, 2 );
				switch ( count( $keyparts ) ) {
					case 1:
						$form_id  = 0;
						$field_id = reset( $keyparts );
						break;
					case 2:
						list( $form_id, $field_id ) = $keypart;
						break;
					default:
						continue 2;
				}

				if ( preg_match( '/\d+_\d+/', $field_id ) ) {
					$field_id = str_replace( '_', '.', $field_id );
				}

				$op = rgar( $results, "op_{$key}", 'is' );

				if ( ! empty( $form ) ) {
					$value = GFCommon::replace_variables( $value, $form, array() );
				}

				if ( in_array( $key, array( 'date_created', 'date_updated', 'payment_date' ), true ) ) {
					$value = date( 'Y-m-d H:i:s', strtotime( $value ) );
				}

				$conditions[] = new \GF_Query_Condition(
					new GF_Query_Column( $field_id, $form_id ),
					rgar( $opmap, $op, GF_Query_Condition::EQ ),
					new GF_Query_Literal( $value )
				);
			}
		}

		if ( $conditions ) {
			$return['conditions'] = call_user_func_array( '\GF_Query_Condition::_and', $conditions );
		}

		return $return;
	}

	/**
	 * Convert a filter query string to an array of individual filters and operators
	 *
	 * @param string $filter The filter string
	 *
	 * @return array[]
	 */
	private function parse_filter_to_array( $filter ) {
		$result = array();
		parse_str( $filter, $filters );

		foreach ( $filters as $filter => $value ) {
			if ( 0 === strpos( $filter, 'filter_' ) ) {
				list( , $key ) = explode( '_', $filter, 2 );

				$op = rgar( $filters, "op_{$key}", 'is' );

				if ( in_array( $key, array( 'date_created', 'date_updated', 'payment_date' ), true ) ) {
					$value = date( 'Y-m-d H:i:s', strtotime( $value ) );
				}

				if ( preg_match( '/\d+_\d+/', $key ) ) {
					$key = str_replace( '_', '.', $key );
				}

				$result[ $key ] = array(
					'value' => $value,
					'op'    => $op,
				);
			}
		}

		return $result;
	}

	/**
	 * Check if entry matches filter conditions
	 *
	 * @param array $entry  Entry
	 * @param array $filter Filters
	 *
	 * @return bool
	 */
	private function entry_matches_filter_conditions( $entry = array(), $filters = array() ) {
		foreach ( $filters as $field => $filter ) {
			if ( ! isset( $entry[ $field ] ) ) {
				return false;
			}

			if ( ! GFFormsModel::matches_operation( $entry[ $field ], $filter['value'], $filter['op'] ) ) {
				return false;
			}
		}

		return true;
	}
}

new GravityView_Math_GravityForms;