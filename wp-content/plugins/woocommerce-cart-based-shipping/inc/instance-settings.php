<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Settings for cart based shipping.
 */
$settings = array(
		'enabled' => array(
			'title' 		=> __( 'Enable/Disable', 'be-cart-based' ),
			'type' 			=> 'checkbox',
			'label' 		=> __( 'Enable this shipping method', 'be-cart-based' ),
			'default' 		=> 'no',
			),
	'title' => array(
			'title' 		=> __( 'Method Title', 'be-cart-based' ),
			'type' 			=> 'text',
			'description' 	=> __( 'This controls the title which the user sees during checkout.', 'be-cart-based' ),
			'default' 		=> __( 'Cart Based', 'be-cart-based' ),
			),
	'availability' => array(
			'title' 		=> __( 'Method availability', 'be-cart-based' ),
			'type' 			=> 'select',
			'default' 		=> 'all',
			'class'			=> 'availability',
			'options' 		=> array(
				'all' 			=> __( 'All allowed countries', 'be-cart-based' ),
				'specific' 		=> __( 'Specific countries', 'be-cart-based' ),
				'excluding' 	=> __( 'Countries excluding', 'be-cart-based' ),
				),
			),
	'countries' => array(
			'title' 		=> __( 'Specific Countries', 'be-cart-based' ),
			'type' 			=> 'multiselect',
			'class' 		=> 'chosen_select',
			'css' 			=> 'width: 450px;',
			'default' 		=> '',
			'options' 		=> WC()->countries->countries,
			),
	'fee' => array(
			'title' 		=> __( 'Handling Fee', 'be-cart-based' ),
			'type' 			=> 'text',
			'description'	=> __( 'Fee excluding tax. Enter an amount, e.g. 2.50, or a percentage, e.g. 5%. Leave blank to disable.', 'be-cart-based' ),
			'default'		=> '',
			'desc_tip'      => true,
			'placeholder'	=> '0.00'
			),
	'method' => array(
			'title' 		=> __( 'Calculation Method', 'be-cart-based' ),
			'type' 			=> 'select',
			'default' 		=> 'subtotal',
			'options' 		=> array(
				'subtotal' 		=> __( 'Cart Subtotal Price ', 'be-cart-based' ),
				'itemcount' 	=> __( 'Number of Items ', 'be-cart-based' ),
				'weighttotal' 	=> __( 'Total Weight ', 'be-cart-based' ),
				)
			),
	'includetax' => array(
			'title' 		=> __( 'Include Tax', 'be-cart-based' ),
			'type' 			=> 'checkbox',
			'description' 	=> __( 'Calculate shipping based on prices AFTER tax', 'be-cart-based' ),
			'default' 		=> 'no',
			),
	'include_coupons' => array(
			'title' 		=> __( 'Include Coupons', 'be-table-ship' ),
			'type' 			=> 'checkbox',
			'label' 		=> __( 'Subtotal is calculated based on cart value AFTER coupons', 'be-table-ship' ),
			'default' 		=> 'no',
			),
	'minprice' => array(
			'title' 		=> __( 'Minimum Shipping Price', 'be-cart-based' ),
			'type' 			=> 'text',
			'description' 	=> __( 'The minimum shipping price a customer pays', 'be-cart-based' ),
			'default' 		=> '',
			'class'			=> 'wc_input_price',
			),
	'maxprice' => array(
			'title' 		=> __( 'Maximum Shipping Price', 'be-cart-based' ),
			'type' 			=> 'text',
			'description' 	=> __( 'The amount the shipping price will not exceed', 'be-cart-based' ),
			'default' 		=> '',
			'class'			=> 'wc_input_price',
			),
	'minship' => array(
			'title' 		=> __( 'Minimum to Ship', 'be-cart-based' ),
			'type' 			=> 'text',
			'description' 	=> __( 'The minimum cart subtotal, item count, or weight that can be shipped (all orders below this will be denied)', 'be-cart-based' ),
			'default' 		=> '',
			'class'			=> 'wc_input_price',
			),
	'maxship' => array(
			'title' 		=> __( 'Maximum to Ship', 'be-cart-based' ),
			'type' 			=> 'text',
			'description' 	=> __( 'The maximum cart subtotal, item count, or weight that can be shipped (all orders above this will be denied)', 'be-cart-based' ),
			'default' 		=> '',
			'class'			=> 'wc_input_price',
			)
	);

if( class_exists( 'WC_Bundles' ) )
	$settings[ 'bundlesqty' ] = array(
		'title' 		=> __( 'True Bundle Quantities', 'be-cart-based' ),
		'type' 			=> 'checkbox',
		'default' 		=> 'no',
		'description' 	=> __( 'When checked, quantities for bundled items will equal the number of items in bundle', 'be-cart-based' ),
		);

$settings[ 'table_subtotal' ] = array(
	'title' 		=> __( 'Subtotal Based Rates', 'be-cart-based' ),
	'type' 			=> 'table_subtotal',
	'default' 		=> array(),
	'description' 	=> '',
	);

$settings[ 'table_quantity' ] = array(
	'title' 		=> __( 'Quantity Based Rates', 'be-cart-based' ),
	'type' 			=> 'table_quantity',
	'default' 		=> array(),
	'description' 	=> '',
	);

$settings[ 'table_weight' ] = array(
	'title' 		=> __( 'Weight Based Rates', 'be-cart-based' ),
	'type' 			=> 'table_weight',
	'default' 		=> array(),
	'description' 	=> '',
	);

$settings[ 'class_exclusions' ] = array(
	'title' 		=> __( 'Shipping Class Exclusions', 'be-cart-based' ),
	'type' 			=> 'class_exclusions',
	'default' 		=> array(),
	'description' 	=> '',
	);

return $settings;

?>