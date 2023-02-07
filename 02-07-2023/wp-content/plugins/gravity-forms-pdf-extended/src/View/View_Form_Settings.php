<?php

namespace GFPDF\View;

use GFPDF\Helper\Helper_Abstract_View;

/**
 * @package     Gravity PDF
 * @copyright   Copyright (c) 2023, Blue Liquid Designs
 * @license     http://opensource.org/licenses/gpl-2.0.php GNU Public License
 */

/* Exit if accessed directly */
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * View_Form_Settings
 *
 * @since 4.0
 */
class View_Form_Settings extends Helper_Abstract_View {

	/**
	 * Set the view's name
	 *
	 * @var string
	 *
	 * @since 4.0
	 */
	protected $view_type = 'FormSettings';

	public function add_edit( $vars ) {

		$markup = new View_GravityForm_Settings_Markup();

		$sections = [
			[
				'id'               => 'gfpdf_form_settings_general',
				'width'            => 'full',
				'title'            => __( 'General', 'gravity-forms-pdf-extended' ),
				'desc'             => '',
				'callback'         => static function() use ( $markup ) {
					$markup->output_settings_fields( 'gfpdf_settings_form_settings', $markup::ENABLE_PANEL_TITLE );
				},
				'collapsible'      => true,
				'collapsible-open' => true,
			],

			[
				'id'               => 'gfpdf_form_settings_appearance',
				'width'            => 'full',
				'title'            => __( 'Appearance', 'gravity-forms-pdf-extended' ),
				'desc'             => '',
				'callback'         => static function() use ( $markup ) {
					$markup->output_settings_fields( 'gfpdf_settings_form_settings_appearance', $markup::ENABLE_PANEL_TITLE );
				},
				'collapsible'      => true,
				'collapsible-open' => true,
			],

			[
				'id'               => 'gfpdf_form_settings_template',
				'width'            => 'full',
				'title'            => __( 'Template', 'gravity-forms-pdf-extended' ),
				'desc'             => '',
				'callback'         => static function() use ( $markup ) {
					$markup->output_settings_fields( 'gfpdf_settings_form_settings_custom_appearance', $markup::ENABLE_PANEL_TITLE );
				},
				'collapsible'      => true,
				'collapsible-open' => true,
			],

			[
				'id'               => 'gfpdf_form_settings_advanced',
				'width'            => 'full',
				'title'            => __( 'Advanced', 'gravity-forms-pdf-extended' ),
				'desc'             => '',
				'callback'         => static function() use ( $markup ) {
					$markup->output_settings_fields( 'gfpdf_settings_form_settings_advanced', $markup::ENABLE_PANEL_TITLE );
				},
				'collapsible'      => true,
				'collapsible-open' => true,
			],
		];

		$vars = array_merge(
			$vars,
			[
				'callback' => static function() use ( $markup, $sections ) {
					$markup->do_settings_sections( $sections, true );
				},
			]
		);

		$this->load( 'add_edit', $vars );
	}
}
