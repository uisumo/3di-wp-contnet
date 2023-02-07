<?php

/*
 * Template Name: Focus Gravity
 * Version: 2.0.3
 * Description: Focus Gravity providing a classic layout which epitomises Gravity Forms Print Preview. It's the familiar layout you've come to love. Through the Template tab you can control the PDF header and footer, change the background color or image, and show or hide the form title, page names, HTML fields and the Section Break descriptions.
 * Author: Gravity PDF
 * Author URI: https://gravitypdf.com
 * Group: Core
 * License: GPLv2
 * Required PDF Version: 4.0-alpha
 * Tags: Header, Footer, Background, Optional HTML Fields, Optional Page Fields, Combined Row, Alternate Colors
 */

/* Prevent direct access to the template */
if ( ! class_exists( 'GFForms' ) ) {
	return;
}

/**
 * All Gravity PDF templates have access to the following variables:
 *
 * @var array  $form      The current Gravity Form array
 * @var array  $entry     The raw entry data
 * @var array  $form_data The processed entry data stored in an array
 * @var array  $settings  The current PDF configuration
 * @var array  $fields    An array of Gravity Form fields which can be accessed with their ID number
 * @var array  $config    The initialised template config class – eg. /config/zadani.php
 * @var object $gfpdf     The main Gravity PDF object containing all our helper classes
 * @var array  $args      Contains an array of all variables - the ones being described right now - passed to the template
 */

/*
 * Load up our template-specific appearance settings
 */
$misc = GPDFAPI::get_misc_class();

$accent_colour             = $settings['focusgravity_accent_colour'] ?? '#e3e3e3';
$accent_contrast_colour    = $misc->get_contrast( $accent_colour );
$secondary_colour          = $settings['focusgravity_secondary_colour'] ?? '#eaf2fa';
$secondary_contrast_colour = $misc->get_contrast( $secondary_colour );

$label_format = $settings['focusgravity_label_format'] ?? 'combined_label';

?>

<!-- Include styles needed for the PDF -->
<style>

	/* Handle Gravity Forms CSS Ready Classes */
	.row-separator {
		clear: both;
		padding: 1.25mm 0;
	}

	/* Handle GF2.5+ Columns */
	.grid {
		float: <?php echo ( $settings['rtl'] ?? 'No' ) ? 'right' : 'left'; ?>;
	}

	.grid .inner-container {
		width: 95%;
	}

	.grid-3 {
		width: 24.5%;
	}

	.grid-4 {
		width: 33%;
	}

	.grid-5 {
		width: 41%;
	}

	.grid-6 {
		width: 49.5%;
	}

	.grid-7 {
		width: 58%;
	}

	.grid-8 {
		width: 66%;
	}

	.grid-9 {
		width: 74.5%
	}

	.grid-10 {
		width: 83%;
	}

	.grid-11 {
		width: 91%;
	}

	.grid-12,
	.grid-12 .inner-container {
		width: 100%;
	}

	/* Handle Legacy Columns */
	.gf_left_half,
	.gf_left_third, .gf_middle_third,
	.gf_first_quarter, .gf_second_quarter, .gf_third_quarter,
	.gf_list_2col li, .gf_list_3col li, .gf_list_4col li, .gf_list_5col li {
		float: left;
	}

	.gf_right_half,
	.gf_right_third,
	.gf_fourth_quarter {
		float: right;
	}

	.gf_left_half, .gf_right_half,
	.gf_list_2col li {
		width: 49%;
	}

	.gf_left_third, .gf_middle_third, .gf_right_third,
	.gf_list_3col li {
		width: 32.3%;
	}

	.gf_first_quarter, .gf_second_quarter, .gf_third_quarter, .gf_fourth_quarter {
		width: 24%;
	}

	.gf_list_4col li {
		width: 24%;
	}

	.gf_list_5col li {
		width: 19%;
	}

	.gf_left_half, .gf_right_half {
		padding-right: 1%;
	}

	.gf_left_third, .gf_middle_third, .gf_right_third {
		padding-right: 1.505%;
	}

	.gf_first_quarter, .gf_second_quarter, .gf_third_quarter, .gf_fourth_quarter {
		padding-right: 1.333%;
	}

	.gf_right_half, .gf_right_third, .gf_fourth_quarter {
		padding-right: 0;
	}

	/* Don't double float the list items if already floated (mPDF does not support this ) */
	.gf_left_half li, .gf_right_half li,
	.gf_left_third li, .gf_middle_third li, .gf_right_third li {
		width: 100% !important;
		float: none !important;
	}

	/*
	 * Headings
	 */
	h3 {
		margin: 1.5mm 0 0.5mm;
		padding: 0;
	}

	/*
	 * Quiz Style Support
	 */
	.gquiz-field {
		color: #666;
	}

	.gquiz-correct-choice {
		font-weight: bold;
		color: black;
	}

	.gf-quiz-img {
		padding-left: 5px !important;
		vertical-align: middle;
	}

	/*
	 * Survey Style Support
	 */
	.gsurvey-likert-choice-label {
		padding: 4px;
	}

	.gsurvey-likert-choice, .gsurvey-likert-choice-label {
		text-align: center;
	}

	/*
	 * Terms of Service (Gravity Perks) Support
	 */
	.terms-of-service-agreement {
		padding-top: 2px;
		font-weight: bold;
	}

	.terms-of-service-tick {
		font-size: 150%;
	}

	/*
	 * List Support
	 */
	ul, ol {
		margin: 0;
		padding-left: 1mm;
		padding-right: 1mm;
	}

	li {
		margin: 0;
		padding: 0;
		list-style-position: inside;
	}

	/*
	 * Header / Footer
	 */
	.alignleft {
		float: left;
	}

	.alignright {
		float: right;
	}

	.aligncenter {
		text-align: center;
	}

	p.alignleft {
		text-align: left;
		float: none;
	}

	p.alignright {
		text-align: right;
		float: none;
	}

	/*
	 * Independant Template Styles
	 */
	#container {
		border-radius: 5px;
		border: 1px solid #000;
		border-color: <?php echo esc_html( $accent_colour ); ?>;
	}

	#form_title {
		border-top-left-radius: 3px;
		border-top-right-radius: 3px;
	}

	h3 {
		background: <?php echo esc_html( $accent_colour ); ?>;
		color: <?php echo esc_html( $accent_contrast_colour ); ?>;
		margin: 0;
	}

	.gfpdf-page {
		border-top: 1px solid #FFF;
	}

	.gfpdf-field .label {
		font-weight: bold;
		border-bottom: 1px solid #000;
		border-bottom-color: <?php echo esc_html( $accent_colour ); ?>;
		background: <?php echo esc_html( $secondary_colour ); ?>;
		color: <?php echo esc_html( $secondary_contrast_colour ); ?>;
	}

	.value, .gfpdf-section-description, .gfpdf-field .label, h3, .gfpdf-html .value {
		padding: 7px 6px 7px 10px;
	}

	.gfpdf-html {
		border-top: 5px solid #000;
		border-top-color: <?php echo esc_html( $secondary_colour ); ?>;
	}

	table.gfield_list th {
		background: <?php echo esc_html( $accent_colour ); ?>;
		color: <?php echo esc_html( $accent_contrast_colour ); ?>;
	}

	table.entry-products th, table.entry-products td.emptycell {
		background: none;
	}

	<?php if ( $label_format === 'combined_label' ): ?>
	.gfpdf-field .label {
		background: none;
		border: none;
		padding-bottom: 0;
	}

	.value {
		padding-top: 0;
	}

	.even {
		background: <?php echo esc_html( $secondary_colour ); ?>;
	}

	<?php else : ?>
	.gfpdf-html .value {
		border-top: 1px solid #000;
		border-top-color: <?php echo esc_html( $accent_colour ); ?>;
	}

	<?php endif; ?>

</style>

<!-- Output our HTML markup -->
<?php

/*
 * Load our core-specific styles from our PDF settings which will be passed to the PDF template $config array
 */
$show_form_title      = ( $settings['show_form_title'] ?? '' ) === 'Yes';
$show_page_names      = ( $settings['show_page_names'] ?? '' ) === 'Yes';
$show_html            = ( $settings['show_html'] ?? '' ) === 'Yes';
$show_section_content = ( $settings['show_section_content'] ?? '' ) === 'Yes';
$enable_conditional   = ( $settings['enable_conditional'] ?? '' ) === 'Yes';
$show_empty           = ( $settings['show_empty'] ?? '' ) === 'Yes';

/**
 * Set up our configuration array to control what is and is not shown in the generated PDF
 *
 * @var array
 */
$html_config = [
	'settings' => $settings,
	'meta'     => [
		'echo'                     => true, /* whether to output the HTML or return it */
		'exclude'                  => true, /* whether we should exclude fields with a CSS value of 'exclude'. Default to true */
		'empty'                    => $show_empty, /* whether to show empty fields or not. Default is false */
		'conditional'              => $enable_conditional, /* whether we should skip fields hidden with conditional logic. Default to true. */
		'show_title'               => $show_form_title, /* whether we should show the form title. Default to true */
		'section_content'          => $show_section_content, /* whether we should include a section breaks content. Default to false */
		'page_names'               => $show_page_names, /* whether we should show the form's page names. Default to false */
		'html_field'               => $show_html, /* whether we should show the form's html fields. Default to false */
		'individual_products'      => false, /* Whether to show individual fields in the entry. Default to false - they are grouped together at the end of the form */
		'enable_css_ready_classes' => true, /* Whether to enable or disable Gravity Forms CSS Ready Class support in your PDF */
	],
];

/*
 * Generate our HTML markup
 *
 * You can access Gravity PDFs common functions and classes through our API wrapper class "GPDFAPI"
 */
$pdf = GPDFAPI::get_pdf_class();
$pdf->process_html_structure( $entry, GPDFAPI::get_pdf_class( 'model' ), $html_config );

