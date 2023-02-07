<?php
/*
Plugin Name: WooCommerce Cart Based Shipping
Plugin URI: http://bolderelements.net/plugins/cart-based-shipping-woocommerce/
Description: WooCommerce custom plugin used to calculate shipping price based on items in the shopping cart
Author: Bolder Elements
Author URI: http://www.bolderelements.net/
Version: 3.1
*/
// Exit if accessed directly
if( !defined( 'ABSPATH' ) ) exit;

add_action( 'plugins_loaded', 'woocommerce_cart_based_shipping_init', 230);
function woocommerce_cart_based_shipping_init() {

	// Current version
	if ( ! defined( 'BE_WooCartShipping_VERSION' ) ) define( 'BE_WooCartShipping_VERSION', '3.0' );

	//Add upgrader script
	include_once( plugin_dir_path( __FILE__ ) . 'inc/github.php' );

	/**
	 * Check if WooCommerce is active
	 */
	if ( class_exists( 'WooCommerce' ) ) {
		
		if (!class_exists( 'WC_Shipping_Method' )) return;

		if ( class_exists( 'BE_Cart_Based_Shipping' ) ) return;

		// setup internationalization support
		load_plugin_textdomain( 'be-cart-based', false, dirname( plugin_basename( __FILE__ ) ) . '/languages' );

		if( WOOCOMMERCE_VERSION >= 2.1 && !isset( $woocommerce ) ) 
			$woocommerce = WC();

		//Add included files
		include_once( plugin_dir_path( __FILE__ ) . 'inc/class-exporter.php' );
		include_once( plugin_dir_path( __FILE__ ) . 'deprecated/woocommerce-cart-based-shipping.php' );

		class BE_Cart_Based_Shipping extends WC_Shipping_Method {

			private $exporterClass;

			/**
			 * __construct function.
			 *
			 * @access public
			 * @return void
			 */
			function __construct( $instance_id = 0 ) {
	        	$this->id 						= 'cart_based_rate';
				$this->instance_id 				= absint( $instance_id );
		 		$this->method_title 			= __( 'Cart Based', 'be-cart-based' );
				$this->method_description 		= __( 'Cart based rates let you define a standard rate to be assigned based on the total price of the customer\'s cart.', 'be-cart-based' );;
				$this->supports 				= array( 'shipping-zones', 'instance-settings' );

    			if( isset( $_POST['be_cartship_import_instance_id'] ) )
    				$this->instance_id = (int) sanitize_text_field( $_POST['be_cartship_import_instance_id'] );

				$this->cart_rate_sub_option 	= 'woocommerce_cart_rates_subtotal-' . $this->instance_id;
				$this->cart_rate_count_option 	= 'woocommerce_cart_rates_itemcount-' . $this->instance_id;
				$this->cart_rate_weight_option 	= 'woocommerce_cart_rates_weighttotal-' . $this->instance_id;
				$this->class_exclusions_options = 'woocommerce_cart_rates_exclusions-' . $this->instance_id;

				//add_action( 'woocommerce_update_options_shipping_' . $this->id, array( &$this, 'process_cart_rates' ) );
				// Add javascript for settings page
				add_action( 'admin_enqueue_scripts', array( $this, 'register_admin_scripts' ) );

				// Load the settings.
				$this->init_settings();

				//Setup export/import settings
				$this->save_names = array(
					'cart_rate_sub_option'		=> $this->cart_rate_sub_option,
					'cart_rate_count_option'	=> $this->cart_rate_count_option,
					'cart_rate_weight_option'	=> $this->cart_rate_weight_option,
					'class_exclusions_options'	=> $this->class_exclusions_options,
					);
				$this->exporterClass = new BEExport_WooCartShipping( $this );

				$this->init();
			}


			/**
			* init function.
			* initialize variables to be used
			*
			* @access public
			* @return void
			*/
			function init() {

				// Load the form fields.
				$this->instance_form_fields = include( plugin_dir_path( __FILE__ ) . 'inc/instance-settings.php' );

				// Define user set variables
				$this->enabled 			= $this->get_option( 'enabled' );
				$this->title 			= $this->get_option( 'title' );
				$this->availability 	= $this->get_option( 'availability' );
				$this->countries 		= $this->get_option( 'countries' );
				$this->fee 				= $this->get_option( 'fee' );
				$this->method 			= $this->get_option( 'method' );
				$this->includetax 		= $this->get_option( 'includetax' );
				$this->include_coupons 	= $this->get_option( 'include_coupons' );
				$this->minprice 		= $this->get_option( 'minprice' );
				$this->maxprice 		= $this->get_option( 'maxprice' );
				$this->minship 			= $this->get_option( 'minship' );
				$this->maxship 			= $this->get_option( 'maxship' );

				if( class_exists( 'WC_Bundles' ) )
					$this->bundlesqty = $this->get_option( 'bundlesqty' );

				// Load Cart rates
				$this->get_cart_rates();

				// Load Excluded Classes
				$this->get_class_exclusions();
			}


			/**
			 * calculate_shipping function.
			 *
			 * @access public
			 * @param array $package (default: array())
			 * @return void
			 */
			function calculate_shipping( $package = array() ) {
				global $woocommerce;

				$cart_subtotal = ( $this->includetax == 'yes' ) ? 0 : $this->calculate_subtotal( $package['contents'] );

				$this->rates = array();
				$excludedClasses = array();
				$SHIP_ITEM = TRUE;

				// get excluded shipping classes
				foreach( $this->class_exclusions as $key => $value) {
					if( $value[ 'excluded' ] == 'on' )
						$excludedClasses[$value[ 'term_id' ]] = $value;
				}

		    	// Find prices for products in the cart, sum to get subtotal
		    	if ( sizeof( $package[ 'contents' ] ) > 0 ) {
					foreach( $package[ 'contents' ] as $item_id => $values ) {
						if( $values[ 'data' ]->needs_shipping()) {
							$item_class_id = $values[ 'data' ]->get_shipping_class_id();

							if(array_key_exists( $item_class_id, $excludedClasses) ) {
								if( $this->includetax == 'no' ) {
									$cart_subtotal -= ( $values[ 'data' ]->get_price() * $values[ 'quantity' ]);
								}
							}elseif( $this->includetax == 'yes' ) {
								$cart_subtotal += $values[ 'data' ]->get_price_including_tax() * $values[ 'quantity' ];
							}
						}
		    		}
		    	}

				// Coupon Settings Adjustment
				if( $this->include_coupons == 'yes' ) :

					if( $this->includetax == 'yes' )
						$cart_subtotal -= WC()->cart->discount_cart + array_sum( WC()->cart->coupon_discount_tax_amounts );

					else
						$cart_subtotal -= WC()->cart->discount_cart;

				endif;

		    	$cart_subtotal = apply_filters( 'wcml_raw_price_amount', $cart_subtotal );

				if( $this->method == 'subtotal' ) {
					$shipping_options = $this->cart_rates_subtotal;

					// For each cart scenario, check if subtotal is less than minimum total
					foreach( $shipping_options as $option ) {
						if( ( $this->minship != '' && $cart_subtotal < apply_filters( 'wcml_raw_price_amount', $this->minship ) ) || ( $this->maxship != '' && $cart_subtotal > apply_filters( 'wcml_raw_price_amount', $this->maxship ) ) ) {
							$SHIP_ITEM = false;
						} else {
							if( $cart_subtotal >= apply_filters( 'wcml_raw_price_amount', $option[ 'min' ] ) )  {
								if( $option[ 'shiptype' ] == '%' ) {
									$shipping_total = $cart_subtotal * ( $option[ 'cost' ] / 100);
								} else {
									$shipping_total = $option[ 'cost' ];
								}
							}
						}
					}
				} else if( $this->method == 'itemcount' ) {
					$shipping_options = $this->cart_rates_itemcount;

					$cart_item_count = 0;
			    	// Find prices for products in the cart, sum to get subtotal
			    	if ( sizeof( $package[ 'contents' ] ) > 0 ) {
						foreach( $package[ 'contents' ] as $item_id => $values ) {
							if( $values[ 'data' ]->needs_shipping()) {
								$item_class_id = $values[ 'data' ]->get_shipping_class_id();
								if(!array_key_exists( $item_class_id, $excludedClasses))
									// Check for Woo Bundled Products
									if( $values[ 'data' ]->is_type( 'bundle' ) && isset( $this->bundlesqty ) && $this->bundlesqty == 'yes' )
										$cart_item_count += array_sum( $values[ 'data' ]->get_bundled_item_quantities() ) * $values[ 'quantity' ];
									else $cart_item_count += $values[ 'quantity' ];
				    		}
				    	}
			    	}

					// For each cart scenario, check if item count is more than minimum items
					foreach( $shipping_options as $option ) {
						if( ( $this->minship != '' && $cart_item_count < $this->minship ) || ( $this->maxship != '' && $cart_item_count > $this->maxship ) ) {
							$SHIP_ITEM = false;
						} else {
							if( $cart_item_count >= $option[ 'min' ] ) {
								if( $option[ 'shiptype' ] == '%' ) {
									$shipping_total = $cart_subtotal * ( $option[ 'cost' ] / 100);
								} else {
									$shipping_total = $option[ 'cost' ];
								}
							}
						}
					}
				} elseif( $this->method == 'weighttotal' ) {
					$shipping_options = $this->cart_rates_weighttotal;

			    	// Find weight for all products in the cart
					$cart_weight_total = 0;
			    	if ( sizeof( $package[ 'contents' ] ) > 0 ) {
						foreach( $package[ 'contents' ] as $item_id => $values ) {
							if( $values[ 'data' ]->needs_shipping()) {
								$item_class_id = $values[ 'data' ]->get_shipping_class_id();
								if(!array_key_exists( $item_class_id, $excludedClasses))
									$cart_weight_total += $values[ 'data' ]->weight * $values[ 'quantity' ];
			    			}
			    		}
			    	}

					// For each cart scenario, check if weight is more than specified minimum
					foreach( $shipping_options as $option ) {
						if( ( $this->minship != '' && $cart_weight_total < $this->minship ) || ( $this->maxship != '' && $cart_weight_total > $this->maxship ) ) {
							$SHIP_ITEM = false;
						} else {
							if( $cart_weight_total >= $option[ 'min' ] ) {
								if( $option[ 'shiptype' ] == '%' ) {
									$shipping_total = $cart_subtotal * ( $option[ 'cost' ] / 100);
								} else {
									$shipping_total = $option[ 'cost' ];
								}
							}
						}
					}
				}
				if( $SHIP_ITEM) {
					if( $this->fee != 0) {
						if(strstr( $this->fee, '%' )) {
							$shipping_total += $cart_subtotal * ((float) $this->fee / 100);
						} else {
							$shipping_total += (float) $this->fee;
						}
					}

					// Apply Min / Max rules
					if( !empty( $this->minprice ) && isset( $shipping_total ) && $shipping_total < $this->minprice )
						$shipping_total = $this->minprice;
					
					if( !empty( $this->maxprice ) && isset( $shipping_total ) && $shipping_total > $this->maxprice )
						$shipping_total = $this->maxprice;

					$rate = array(
						'id'    => $this->id . $this->instance_id,
						'label' => $this->title,
						'cost' 	=> ( isset( $shipping_total ) ) ? $shipping_total : 0,
						);

					// Register the rate
					$this->add_rate( $rate );
				}
			}


			/**
			 * Settings output for subtotal table
			 *
			 * @access public
			 * @return void
			 */
			public function generate_table_subtotal_html( $key, $data ) {
				global $woocommerce;

				$field_key = $this->get_field_key( $key );
				$cur_symbol = get_woocommerce_currency_symbol();
				$defaults  = array(
					'title'             => '',
					'type'              => 'table_subtotal',
					'custom_attributes' => array(),
				);
				$data = wp_parse_args( $data, $defaults );
				ob_start();
?>
		<tr id="becbs_subtotal_based" valign="top">
			<th scope="row" class="titledesc">
				<label for="<?php echo esc_attr( $field_key ); ?>"><?php echo wp_kses_post( $data['title'] ); ?></label>
			</th>
			<td class="forminp">
		    	<table cart-shipping-id="<?php echo $this->id; ?>" currency-symbol="<?php echo $cur_symbol; ?>" class="shippingrows widefat">
		    		<thead>
		    			<tr>
		    				<th class="check-column"><input type="checkbox"></th>
		    				<th class="shipping_class"><?php _e( 'Orders Equal to and Above', 'be-cart-based' ); ?></th>
			            	<th><?php _e( 'Shipping Cost', 'be-cart-based' ); ?></th>
			            	<th>&nbsp;</th>
		    			</tr>
		    		</thead>
		    		<tfoot>
		    			<tr>
		    				<th colspan="2"><a href="#" class="add button"><?php _e( 'Add Cart Rate', 'be-cart-based' ); ?></a></th>
		    				<th colspan="2" style="text-align:right;padding-right:10px;"><a href="#" class="remove button"><?php _e( 'Delete selected rates', 'be-cart-based' ); ?></a></th>
		    			</tr>
		    		</tfoot>
		    		<tbody class="cart_rates">
<?php
	        	$i = -1;
	        	if ( $this->cart_rates_subtotal ) {
	        		foreach( $this->cart_rates_subtotal as $class => $rate ) {
	            		$i++;
						$selType = "<select name=\"". $this->id ."_sub_shiptype[" . $i . "]\" class=\"shiptype\">
							<option>".$cur_symbol."</option>
							<option";
							if( $rate[ 'shiptype' ] == "%") $selType .= " selected=\"selected\"";
							$selType .= ">%</option></select>";

	            		echo '<tr class="cart_rate">
	            		    <th class="check-column"><input type="checkbox" name="select" /></td>
	            		    <td>' . $cur_symbol . ' <input type="text" value="' . $rate[ 'min' ] . '" name="'. $this->id .'_sub_min[' . $i . ']" placeholder="'.__( '0.00', 'be-cart-based' ).'" size="4" class="wc_input_price" /></td>
		                    <td>' . $selType . ' <input type="text" value="' . $rate[ 'cost' ] . '" name="'. $this->id .'_sub_cost[' . $i . ']" placeholder="'.__( '0.00', 'be-cart-based' ).'" size="4" class="wc_input_price" /></td>
		                    <td></td>
	                    </tr>';
	        		}
	        	}
?>
		        	</tbody>
		    	</table>
		    </td>
		</tr>
<?php
				return ob_get_clean();
			}


			/**
			 * Settings output for quantity table
			 *
			 * @access public
			 * @return void
			 */
			public function generate_table_quantity_html( $key, $data ) {
				global $woocommerce;

				$field_key = $this->get_field_key( $key );
				$cur_symbol = get_woocommerce_currency_symbol();
				$defaults  = array(
					'title'             => '',
					'type'              => 'table_quantity',
					'custom_attributes' => array(),
				);
				$data = wp_parse_args( $data, $defaults );
				ob_start();
?>
		<tr id="becbs_quantity_based" valign="top">
			<th scope="row" class="titledesc">
				<label for="<?php echo esc_attr( $field_key ); ?>"><?php echo wp_kses_post( $data['title'] ); ?></label>
			</th>
			<td class="forminp">
		    	<table cart-shipping-id="<?php echo $this->id; ?>" currency-symbol="<?php echo $cur_symbol; ?>" class="shippingrows widefat">
            		<thead>
            			<tr>
            				<th class="check-column"><input type="checkbox"></th>
            				<th class="shipping_class"><?php _e( 'Number of Items Equal to and Above', 'be-cart-based' ); ?></th>
        	            	<th><?php _e( 'Shipping Cost', 'be-cart-based' ); ?></th>
        	            	<th>&nbsp;</th>
            			</tr>
            		</thead>
            		<tfoot>
            			<tr>
            				<th colspan="2"><a href="#" class="add button"><?php _e( 'Add Cart Rate', 'be-cart-based' ); ?></a></th>
            				<th colspan="2" style="text-align:right;padding-right:10px;"><a href="#" class="remove button"><?php _e( 'Delete selected rates', 'be-cart-based' ); ?></a></th>
            			</tr>
            		</tfoot>
            		<tbody class="cart_rates">
                	<?php
                	$i = -1;
                	if ( $this->cart_rates_itemcount ) {
                		foreach( $this->cart_rates_itemcount as $class => $rate ) {
	                		$i++;
							$selType = "<select name=\"". $this->id ."_count_shiptype[" . $i . "]\" class=\"shiptype\">
								<option>".$cur_symbol."</option>
								<option";
								if( $rate[ 'shiptype' ] == "%") $selType .= " selected=\"selected\"";
								$selType .= ">%</option></select>";

	                		echo '<tr class="cart_rate">
	                		    <th class="check-column"><input type="checkbox" name="select" /></td>
	                		    <td><input type="number" value="' . $rate[ 'min' ] . '" name="'. $this->id .'_count_min[' . $i . ']" placeholder="'.__( '0', 'be-cart-based' ).'" size="4" /></td>
			                    <td>' . $selType . ' <input type="text" value="' . $rate[ 'cost' ] . '" name="'. $this->id .'_count_cost[' . $i . ']" placeholder="'.__( '0.00', 'be-cart-based' ).'" size="4" class="wc_input_price" /></td>
			                    <td></td>
		                    </tr>';
                		}
                	}
                	?>
                	</tbody>
		    	</table>
		    </td>
		</tr>
<?php
				return ob_get_clean();
			}


			/**
			 * Settings output for weight table
			 *
			 * @access public
			 * @return void
			 */
			public function generate_table_weight_html( $key, $data ) {
				global $woocommerce;

				$field_key = $this->get_field_key( $key );
				$cur_symbol = get_woocommerce_currency_symbol();
				$defaults  = array(
					'title'             => '',
					'type'              => 'table_weight',
					'custom_attributes' => array(),
				);
				$data = wp_parse_args( $data, $defaults );
				ob_start();
?>
		<tr id="becbs_weight_based" valign="top">
			<th scope="row" class="titledesc">
				<label for="<?php echo esc_attr( $field_key ); ?>"><?php echo wp_kses_post( $data['title'] ); ?></label>
			</th>
			<td class="forminp">
		    	<table cart-shipping-id="<?php echo $this->id; ?>" currency-symbol="<?php echo $cur_symbol; ?>" class="shippingrows widefat">
            		<thead>
            			<tr>
            				<th class="check-column"><input type="checkbox"></th>
            				<th class="shipping_class"><?php _e( 'Total Weight Equal to and Above', 'be-cart-based' ); ?></th>
        	            	<th><?php _e( 'Shipping Cost', 'be-cart-based' ); ?></th>
        	            	<th>&nbsp;</th>
            			</tr>
            		</thead>
            		<tfoot>
            			<tr>
            				<th colspan="2"><a href="#" class="add button"><?php _e( 'Add Cart Rate', 'be-cart-based' ); ?></a></th>
            				<th colspan="2" style="text-align:right;padding-right:10px;"><a href="#" class="remove button"><?php _e( 'Delete selected rates', 'be-cart-based' ); ?></a></th>
            			</tr>
            		</tfoot>
            		<tbody class="cart_rates">
                	<?php
                	$i = -1;
                	if ( $this->cart_rates_weighttotal ) {
                		foreach( $this->cart_rates_weighttotal as $class => $rate ) {
	                		$i++;
							$selType = "<select name=\"". $this->id ."_weight_shiptype[" . $i . "]\" class=\"shiptype\">
								<option>".$cur_symbol."</option>
								<option";
								if( $rate[ 'shiptype' ] == "%") $selType .= " selected=\"selected\"";
								$selType .= ">%</option></select>";

	                		echo '<tr class="cart_rate">
	                		    <th class="check-column"><input type="checkbox" name="select" /></td>
	                		    <td><input type="text" value="' . $rate[ 'min' ] . '" name="'. $this->id .'_weight_min[' . $i . ']" placeholder="'.__( '0', 'be-cart-based' ).'" size="4" class="wc_input_decimal" /></td>
			                    <td>' . $selType . ' <input type="text" value="' . $rate[ 'cost' ] . '" name="'. $this->id .'_weight_cost[' . $i . ']" placeholder="'.__( '0.00', 'be-cart-based' ).'" size="4" class="wc_input_price" /></td>
			                    <td></td>
		                    </tr>';
                		}
                	}
                	?>
                	</tbody>
		    	</table>
		    </td>
		</tr>
<?php
				return ob_get_clean();
			}


			/**
			 * Settings output for shipping class exclusions
			 *
			 * @access public
			 * @return void
			 */
			public function generate_class_exclusions_html( $key, $data ) {
				global $woocommerce;

				$field_key = $this->get_field_key( $key );
				$cur_symbol = get_woocommerce_currency_symbol();
				$defaults  = array(
					'title'             => '',
					'type'              => 'table_weight',
					'custom_attributes' => array(),
				);
				$data = wp_parse_args( $data, $defaults );
				ob_start();
?>
		<tr id="becbs_class_exclusions" valign="top">
			<th scope="row" class="titledesc">
				<label for="<?php echo esc_attr( $field_key ); ?>"><?php echo wp_kses_post( $data['title'] ); ?></label>
			</th>
			<td class="forminp">
		    	<table cart-shipping-id="<?php echo $this->id; ?>" currency-symbol="<?php echo $cur_symbol; ?>" class="shippingrows widefat">
            		<thead>
            			<tr>
        	            	<th class="shipping_class"><?php _e( 'Shipping Class', 'be-cart-based' ); ?></th>
        	            	<th><?php _e( 'Exclude', 'be-cart-based' ); ?> <a class="tips" data-tip="If shipping is free for items with this class, check the box to exclude these cart items">[?]</a></th>
            			</tr>
            		</thead>
            		<tfoot>
            			<tr>
            				<th colspan="2"></th>
            			</tr>
            		</tfoot>
            		<tbody class="class_exclusions">
<?php
            	$class_exclusions_array = array();
				$shippingClasses = $woocommerce->shipping->get_shipping_classes();
                //$class_exclusions = (!is_array( $this->class_exclusions_options)) ? array() : $this->class_exclusions_options;
            	if(count( $shippingClasses) > 0) {
                	foreach( $shippingClasses as $key => $val) {
                		$class_exclusions_array[$val->term_id] = array("term_id" => $val->term_id, "name" => $val->name, "exclude" => '0' );
                	}
                }
            	if(count( $this->class_exclusions) > 0) {
                	foreach( $this->class_exclusions as $key => $val) {
                		if( !array_key_exists( $val[ 'term_id' ], $class_exclusions_array ) ) unset( $this->class_exclusions[ $val[ 'term_id' ] ] );
                	}
                }
            	$class_exclusions_array =  $this->class_exclusions + $class_exclusions_array;

				// Sort Array by Priority
				if(count( $class_exclusions_array) > 0) {
					foreach( $class_exclusions_array as $key => $row) {
						$term = get_term_by( 'id', $row['term_id'], 'product_shipping_class' );
						if( $term )
    						$name[$key]  = $term->name;
					}
					array_multisort( $name, SORT_ASC, $class_exclusions_array);
				}

            	$i = -1;
            	if(count( $class_exclusions_array) > 0) {
            		foreach( $class_exclusions_array as $id => $arr ) {
            			$i++;
            			$term = get_term_by( 'id', $arr[ 'term_id' ], 'product_shipping_class', ARRAY_A );

						if( $term ) :

	            			$checked = ( isset( $arr[ 'excluded' ] ) && $arr[ 'excluded' ] == 'on' ) ? ' checked="checked"' : '';
	                		echo '<tr class="shipping_class">
	                			<input type="hidden" name="'. $this->id .'_scpid[' . $i . ']" value="' . $arr[ 'term_id' ] . '" />
	                			<input type="hidden" name="'. $this->id .'_scp[' . $i . ']" value="' . $id . '" />
	                			<td>'.$term[ 'name' ].'</td>
	                		    <td><input type="checkbox" ' . $checked . '" name="'. $this->id .'_excluded[' . $i . ']" size="5" /></td></tr>';
	                	endif;
            		}
            	} else echo '<tr><td colspan="2">You have no shipping classes available</td></tr>'
?>
                	</tbody>
		    	</table>
		    </td>
		</tr>
<?php
				return ob_get_clean();
			}


			/**
			 * Admin Panel Options
			 * - Options for the cart based portion
			 *
			 * @since 1.0.0
			 * @access public
			 * @return void
			 */
			public function admin_options() {
				global $woocommerce;

				// Submit button custom entered so needs to be hidden
				$GLOBALS['hide_save_button'] = true;

				// Generate the HTML For the settings form.
				echo $this->get_admin_options_html();
?>
		<p class="submit">
			<input name="save" class="button-primary woocommerce-save-button" type="submit" value="<?php esc_attr_e( 'Save changes', 'woocommerce' ); ?>" />
			<?php wp_nonce_field( 'woocommerce-settings' ); ?>
		</p>
    </form>

	<script type="text/javascript">
    // Remove row
    jQuery( '#becbs_subtotal_based, #becbs_quantity_based, #becbs_weight_based' ).on( 'click', 'a.remove', function(){
        var answer = confirm("<?php _e( 'Delete the selected rates?', 'be-cart-based' ); ?>")
        if (answer) {
            jQuery(this).closest('.shippingrows').find( 'tbody tr th.check-column input:checked' ).each(function(i, el){
                jQuery(el).closest( 'tr' ).remove();
            });
        }
        return false;
    });
	</script>

	<h3><?php _e( 'Export / Import Settings', 'be-cart-based' ); ?></h3>
<?php
				$this->exporterClass->print_exporter_settings();

			} // End admin_options()


			/**
			 * Process settings for subtotal table
			 *
			 * @access public
			 * @return void
			 */
			public function validate_table_subtotal_field( $key, $data ) {
				// Exit processing if importing from backup file
        		if( isset( $_POST[ 'be_cartship_import_save_names' ] ) ) return;

				// sanitize input
				$cart_rate_min = $cart_rate_shiptype = $cart_rate_cost = array();
				if ( isset( $_POST[ $this->id . '_sub_min' ] ) )  $cart_rate_min = array_map( 'wc_clean', $_POST[ $this->id . '_sub_min' ] );
				if ( isset( $_POST[ $this->id . '_sub_shiptype' ] ) )   $cart_rate_shiptype = array_map( 'wc_clean', $_POST[ $this->id . '_sub_shiptype' ] );
				if ( isset( $_POST[ $this->id . '_sub_cost' ] ) )   $cart_rate_cost = array_map( 'wc_clean', $_POST[ $this->id . '_sub_cost' ] );

				// Save and reload variable
				$cart_rates = $this->process_cart_rates( $cart_rate_min, $cart_rate_shiptype, $cart_rate_cost );
				update_option( $this->cart_rate_sub_option, $cart_rates );
				$this->get_cart_rates();
			}


			/**
			 * Process settings for subtotal table
			 *
			 * @access public
			 * @return void
			 */
			public function validate_table_quantity_field( $key, $data ) {
				// Exit processing if importing from backup file
        		if( isset( $_POST[ 'be_cartship_import_save_names' ] ) ) return;

				// sanitize input
				$cart_rate_min = $cart_rate_shiptype = $cart_rate_cost = array();
				if ( isset( $_POST[ $this->id . '_count_min' ] ) )  $cart_rate_min = array_map( 'wc_clean', $_POST[ $this->id . '_count_min' ] );
				if ( isset( $_POST[ $this->id . '_count_shiptype' ] ) )   $cart_rate_shiptype = array_map( 'wc_clean', $_POST[ $this->id . '_count_shiptype' ] );
				if ( isset( $_POST[ $this->id . '_count_cost' ] ) )   $cart_rate_cost = array_map( 'wc_clean', $_POST[ $this->id . '_count_cost' ] );

				// Save and reload variable
				$cart_rates = $this->process_cart_rates( $cart_rate_min, $cart_rate_shiptype, $cart_rate_cost );
				update_option( $this->cart_rate_count_option, $cart_rates );
				$this->get_cart_rates();
			}


			/**
			 * Process settings for subtotal table
			 *
			 * @access public
			 * @return void
			 */
			public function validate_table_weight_field( $key, $data ) {
				// Exit processing if importing from backup file
        		if( isset( $_POST[ 'be_cartship_import_save_names' ] ) ) return;

				// sanitize input
				$cart_rate_min = $cart_rate_shiptype = $cart_rate_cost = array();
				if ( isset( $_POST[ $this->id . '_weight_min' ] ) )  $cart_rate_min = array_map( 'wc_clean', $_POST[ $this->id . '_weight_min' ] );
				if ( isset( $_POST[ $this->id . '_weight_shiptype' ] ) )   $cart_rate_shiptype = array_map( 'wc_clean', $_POST[ $this->id . '_weight_shiptype' ] );
				if ( isset( $_POST[ $this->id . '_weight_cost' ] ) )   $cart_rate_cost = array_map( 'wc_clean', $_POST[ $this->id . '_weight_cost' ] );

				// Save and reload variable
				$cart_rates = $this->process_cart_rates( $cart_rate_min, $cart_rate_shiptype, $cart_rate_cost );
				update_option( $this->cart_rate_weight_option, $cart_rates );
				$this->get_cart_rates();
			}


			/**
			 * Process settings for subtotal table
			 *
			 * @access public
			 * @return void
			 */
			public function validate_class_exclusions_field( $key, $data ) {
				// Exit processing if importing from backup file
        		if( isset( $_POST[ 'be_cartship_import_save_names' ] ) ) return;

				// sanitize input
				$cart_rates_scpid = $cart_rates_scp = $cart_rates_excluded = $class_exclusions = array();
				if ( isset( $_POST[ $this->id . '_scpid' ] ) )   $cart_rates_scpid = array_map( 'wc_clean', $_POST[ $this->id . '_scpid' ] );
				if ( isset( $_POST[ $this->id . '_scp' ] ) )   $cart_rates_scp = array_map( 'wc_clean', $_POST[ $this->id . '_scp' ] );
				if ( isset( $_POST[ $this->id . '_excluded' ] ) )   $cart_rates_excluded = array_map( 'wc_clean', $_POST[ $this->id . '_excluded' ] );

				// Get max key
				$values = $cart_rates_scp;
				ksort( $values );
				$value = end( $values );
				$key = key( $values );

				for ( $i = 0; $i <= $key; $i++ ) {

					if( isset( $cart_rates_scp[$i] ) ) {

						// Add exclusions to class exclusions array
						$class_exclusions[$cart_rates_scpid[$i]] = array(
							"term_id" => $cart_rates_scpid[$i],
							'excluded' => ( isset( $cart_rates_excluded[$i] ) ) ? $cart_rates_excluded[$i] : false,
						);
					}
				}

				// Save and reload variable
				update_option( $this->class_exclusions_options, $class_exclusions );
				$this->get_class_exclusions();
			}


			/**
			 * process_cart_rates function.
			 *
			 * @access public
			 * @return void
			 */
			function process_cart_rates( $cart_rate_min, $cart_rate_shiptype, $cart_rate_cost ) {
				$cart_rates = array();

				// Get max key
				$values = $cart_rate_min;
				if( count( $values ) ) {
					ksort( $values );
					$value = end( $values );
					$key = key( $values );
				} else $key = -1;

				for ( $i = 0; $i <= $key; $i++ ) {
					if( isset( $cart_rate_min[ $i ] ) && isset( $cart_rate_cost[ $i ] ) ) {

						$cart_rate_cost[$i] = wc_format_decimal( $cart_rate_cost[ $i ] );
						$cart_rate_min[$i] = wc_format_decimal( $cart_rate_min[ $i ] );

						// Add to cart rates array
						$cart_rates[$i] = array(
						    'min' => $cart_rate_min[ $i ],
						    'cost'  => $cart_rate_cost[ $i ],
						    'shiptype' => ( isset( $cart_rate_shiptype[ $i ] ) ) ? $cart_rate_shiptype[ $i ] : get_woocommerce_currency_symbol(),
						);
					}
				}

				return $this->m_array_sort( $cart_rates, 'min' );
			}


			/**
			 * m_array_sort function.
			 * sorts a multi-dimensional array by secondary value
			 *
			 * @access public
			 * @return array
			 */
			function m_array_sort( $array, $key) {
			    if (is_array( $array) && count( $array) > 0) {
				        if (!empty( $key)) {
			            $mapping = array();
			            foreach( $array as $k => $v) {
			                $sort_key = $v[$key];
			                $mapping[$k] = $sort_key;
			            }
			            asort( $mapping);
			            $sorted = array();
			            foreach( $mapping as $k => $v) {
			                $sorted[] = $array[$k];
			            }
			            return $sorted;
			        }
			    }
			    return $array;
			}

	 
			/**
			 * Calculate package subtotal
			 *
			 * @param array $package The package array/object being shipped
			 * @return float
			 */
			function calculate_subtotal( $items ) {
				$subtotal = 0;

				foreach( $items as $item )
					if( $item['data']->needs_shipping() )
						if( $item['line_subtotal'] > 0 )
							$subtotal += $item['line_subtotal'];
						else
							$subtotal += $item['data']->price * $values[ 'quantity' ];

				return $subtotal;
			}


			/**
			 * get_cart_rates function.
			 *
			 * @access public
			 * @return void
			 */
			function get_cart_rates() {
				$this->cart_rates_subtotal = array_filter( (array) get_option( $this->cart_rate_sub_option ) );
				$this->cart_rates_itemcount = array_filter( (array) get_option( $this->cart_rate_count_option ) );
				$this->cart_rates_weighttotal = array_filter( (array) get_option( $this->cart_rate_weight_option ) );
			}


			/**
			 * get_class_exclusions function.
			 *
			 * @access public
			 * @return void
			 */
			function get_class_exclusions() {
				$this->class_exclusions = array_filter( (array) get_option( $this->class_exclusions_options ) );
			}


		    /**
		     * is_available function.
		     *
		     * @param array $package
		     * @return bool
		     */
		    public function is_available( $package ) {
		    	if ( $this->enabled == "no" )
		    		return false;

		    	$settings_countries = ( !empty( $this->countries ) ) ? $this->countries : array();

				// Country availability
				switch ( $this->availability ) {
					case 'specific' :
					case 'including' :
						$ship_to_countries = array_intersect( $settings_countries, array_keys( WC()->countries->get_shipping_countries() ) );
					break;
					case 'excluding' :
						$ship_to_countries = array_diff( array_keys( WC()->countries->get_shipping_countries() ), $settings_countries );
					break;
					default :
						$ship_to_countries = array_keys( WC()->countries->get_shipping_countries() );
					break;
				}

				if ( ! in_array( $package[ 'destination' ][ 'country' ], $ship_to_countries ) )
					return false;

				return apply_filters( 'woocommerce_shipping_' . $this->id . '_is_available', true, $package );
		    }


		    /**
		     * Register Scripts/Styles for Dashboard
		     *
		     * @param string $hook_suffix
		     * @return void
		     */
			function register_admin_scripts( $hook_suffix ) {
				wp_enqueue_script( 'be_cart_shipping_dashboard_js', plugins_url( 'assets/js/dashboard.js', __FILE__ ), array( 'jquery' ), '1.0', true );
			}

		} // End WC_Cart_Based_Shipping Class


		/**
		 * add_cart_rate_method function.
		 *
		 * @package		WooCommerce/Classes/Shipping
		 * @access public
		 * @param array $methods
		 * @return array
		 */
		function add_cart_rate_method( $methods ) {
			$methods[ 'cart_based_rate' ] = 'BE_Cart_Based_Shipping';
			$methods[ 'cart-based-depricated' ] = 'depricated_WC_Cart_Based_Shipping';
			return $methods;
		}
		add_filter( 'woocommerce_shipping_methods', 'add_cart_rate_method' );

	}

}

/**
 * Modify links on plugin listing page (Left)
 *
 * @access public
 * @return void
 */
function be_cart_shipping_wc_action_links( $links ) {
	return array_merge(
		array(
			'settings' => '<a href="' . get_admin_url() . 'admin.php?page=wc-settings&tab=shipping&section=wc_cart_based_shipping">' . __( 'Settings', 'be-cart-based' ) . '</a>',
			'register' => '<a href="' . get_admin_url() . 'admin.php?page=be-manage-plugins">' . __( 'Registration', 'be-cart-based' ) . '</a>',
		),
		$links
	);
}
add_filter( 'plugin_action_links_' . plugin_basename( __FILE__ ), 'be_cart_shipping_wc_action_links' );

function be_cart_shipping_wc_network_action_links( $links ) {
	return array_merge(
		array(
			'register' => '<a href="' . get_admin_url() . 'admin.php?page=be-manage-plugins">' . __( 'Registration', 'be-cart-based' ) . '</a>',
		),
		$links
	);
}
add_filter( 'network_admin_plugin_action_links_' . plugin_basename( __FILE__ ), 'be_cart_shipping_wc_network_action_links' );


/**
 * Modify links on plugin listing page (Right)
 *
 * @access public
 * @return array
 */
function be_cart_shipping_wc_plugin_meta( $links, $file ) {
	if ( $file == plugin_basename( __FILE__ ) ) {

		// Check if plugin already has a 'View details' link
		$index = 'details';
		foreach( $links as $key => $value )
			if( strstr( $value, 'View details' ) )
				$index = $key;
			
		$row_meta = array(
			$index    => '<a href="' . network_admin_url( 'plugin-install.php?tab=plugin-information&plugin=woocommerce-cart-based-shipping&TB_iframe=true&width=600&height=550' ) . '" class="thickbox">' . __( 'View details', 'be-cart-based' ) . '</a>',
			'docs'    => '<a href="http://bolderelements.net/docs/woocommerce-cart-based-shipping/">' . __( 'Docs', 'be-cart-based' ) . '</a>',
			'support' => '<a href="http://bolderelements.net/support/" target="_blank">' . __( 'Support', 'be-cart-based' ) . '</a>'
		);
		return array_merge( $links, $row_meta );
	}
	return (array) $links;
}
add_filter( 'plugin_row_meta', 'be_cart_shipping_wc_plugin_meta', 10, 2 );

?>