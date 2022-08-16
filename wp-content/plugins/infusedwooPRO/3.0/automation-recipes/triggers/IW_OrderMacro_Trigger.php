<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directlys
}

class IW_OrderMacro_Trigger extends IW_Automation_Trigger {
	public $is_advanced = true;
	public $merge_handlers = array(
			'MacroInfo' => array('Order Macro Info', 'merge_handler')
		);

	public $install_conditions = array(
			'IW_MergeValueCheck_Condition',
			'IW_OrderHasCoupon_Condition',
			'IW_OrderHasCustomFee_Condition',
			'IW_OrderNoShipping_Condition',
			'IW_OrderRequiresShipping_Condition',
			'IW_PaymentGateway_Condition',
			'IW_ProductinOrder_Condition',
			'IW_TagsInContact_Condition',
			'IW_TodaysDate_Condition'
		);

	public $install_actions = array(
			'IW_ChargeCCinOrder_Action',
			'IW_GenerateWooCoupon_Action',
			'IW_HttpPost_Action',
			'IW_InfApply_ActionSet',
			'IW_InfApplyTag_Action',
			'IW_InfEmail_Action',
			'IW_InfRemoveTag_Action',
			'IW_InfTriggerCpn_Action',
			'IW_InfUpdateContact_Action',
			'IW_InfUpdateOrder_Action',
			'IW_OptinEmail_Action',
			'IW_WCEmail_Action',
			'IW_WooUpdateOrder_Action',
			'IW_WpUserUpdate_Action'
		);
	
	function trigger_when() {
		add_action('infusedwoo_order_macro_run', array($this,'trigger'), 10, 2);
		add_filter('woocommerce_admin_order_actions_end', array($this, 'add_order_action_icon'), 10, 2 );
		add_action( 'wp_ajax_iwar_order_macro', array($this,'order_macro_trig'), 10, 2 );
		add_action('admin_notices', array($this, 'order_macro_process_notice'));
		add_action( 'woocommerce_order_actions',  array($this, 'add_order_action') );
		add_filter( 'woocommerce_admin_order_preview_actions', array($this, 'add_admin_order_action'),10,2 );
		add_action( 'woocommerce_order_actions_end', array($this, 'add_order_action_end'), 10, 1 );

		add_action('admin_head',array($this, 'admin_head'));
		add_action('admin_footer',array($this, 'admin_footer'));
		add_action('admin_footer',array($this, 'add_order_3_0_end'));
		
	}

	function custom_condition($recipe_id,$configs) {
		return $recipe_id == $this->pass_vars[1];
	}

	public function get_desc() {
		return 'when order macro is run by admin. Creates new order macro.';
	}


	function get_title() {
		return 'Order Macro Trigger';
	}
	function get_icon() {
		return '<i class="fa fa-bolt" style="position:relative; left: 6px;"></i>';
	}

	function get_contact_email() {
		$order_id = $this->pass_vars[0];
		$current_user = wp_get_current_user();

		$this->admin_user = $current_user;

		$this->log_details = "Woo Order ID # " . $order_id;
		$this->log_details .= ". User: " . $current_user->user_login;

		$wc_order = new WC_Order( $order_id );
		
		if(method_exists($wc_order, 'get_billing_email')) {
			return $wc_order->get_billing_email();
		} else {
			return $wc_order->billing_email;
		}
	}

	function get_log_details() {
		return $this->log_details;
	}

	function merge_fields() {
		return array('MacroInfo' => array(
			'admin_uname' => 'LoggedIn Admin Username',
			'admin_email' => 'LoggedIn Admin Email',
			'admin_userid' => 'LoggedIn Admin UserID'

		));
	}

	function merge_handler($key) {

		if(isset($this->admin_user)) {
			if($key == 'admin_uname') return $this->admin_user->user_login;
			else if($key == 'admin_email') return $this->admin_user->user_email;
			else if($key == 'admin_userid') return $this->admin_user->ID;
		}
	}

	function add_order_action_icon($order) {
		if(!function_exists('iw_get_recipes')) return false;

		$available_macros = iw_get_recipes('IW_OrderMacro_Trigger', true);

		if(count($available_macros) > 0) {
			$action = array(
						'url' => '#TB_inline?width=300&height=350&inlineId=iwar_macro_box',
						'name' => '',
						'action' => 'iwar_macro thickbox macro-for-' . $order->id,
						'title' => 'Trigger an Order Macro',
						'order-id' => $order->ID
					);

			printf( '<a class="button tips %s" href="%s" data-tip="%s", title="%s", order="%s">%s</a>', esc_attr( $action['action'] ), esc_url( $action['url'] ), esc_attr( $action['name'] ), esc_attr( $action['title'] ),esc_attr( $action['order-id'] ), esc_attr( $action['name'] ) );
		}
		
	}

	function add_order_action($actions) {
		global $theorder;
		if(!function_exists('iw_get_recipes')) return false;
		$available_macros = iw_get_recipes('IW_OrderMacro_Trigger', true);

		if(count($available_macros) > 0) {
			$actions['iwar_run_macro'] =  __( 'Run InfusedWoo Order Macro ...', 'infusedwoo' );
		}

		return $actions;
	}

	function add_admin_order_action($actions, $order) {
		if(!function_exists('iw_get_recipes')) return false;
		$available_macros = iw_get_recipes('IW_OrderMacro_Trigger', true);

		if(count($available_macros) > 0) {
			$actions['run_iw_macro'] = array(
				'url' => '#' . $order->get_id(),
				'action' => 'run_iw_macro',
				'name' => 'Run Macro',
				'title' => 'Run InfusedWoo Macro'
			);
		}

		return $actions;
	}

	function add_order_action_end($order_id) {
		?>
		<a style="display: none;" href="#TB_inline?width=300&height=350&inlineId=iwar_macro_box" title="Trigger an Order Macro" class="iwar_macro iwar_macro_order thickbox macro-for-<?php echo $order_id; ?>" order="<?php echo $order_id; ?>">Run InfusedWoo Macro</a>
		<?php
	}

	function add_order_3_0_end() {
		?>
		<a style="display: none;" href="#TB_inline?width=300&height=350&inlineId=iwar_macro_box" title="Trigger an Order Macro" class="iwar_macro iwar_macro_3 thickbox">Run InfusedWoo Macro</a>
		<?php
	}


	function order_macro_trig() {
		$order = wc_get_order($_GET['order_id']);
		$order->add_order_note(__('Ran Macro (InfusedWoo Recipe) #' . $_GET['recipe_id'],'infusedwoo'));
		do_action( 'infusedwoo_order_macro_run', $_GET['order_id'], $_GET['recipe_id']);

		$run = array(
				'status' => 'success',
				'macro' => get_the_title( $_GET['recipe_id'] ),
				'order' => $_GET['order_id']
			);
		set_transient( 'iwar_order_macro_status', $run,  300 );
		wp_safe_redirect( wp_get_referer() ? wp_get_referer() : admin_url( 'edit.php?post_type=shop_order' ) );
		exit();
	}

	function order_macro_process_notice() {
		$check_notice = get_transient( 'iwar_order_macro_status' );

		if(isset($check_notice['status']) && $check_notice['status'] == 'success') { ?>
			<div class="notice notice-success is-dismissible">
		        <p><?php _e( 'Order Macro "'.$check_notice['macro'].'" Successfully Ran on Order # ' . $check_notice['order'], 'woocommerce' ); ?></p>
		    </div>
			<?php 
			delete_transient( 'iwar_order_macro_status' );
		}


	}

	function admin_head() {
		if(isset($_GET['post'])) {
			if( get_post_type ($_GET['post']) != 'shop_order') return false;
		} else if(!isset($_GET['post_type']) || $_GET['post_type'] != 'shop_order') return false;

		wp_enqueue_script( 'ia_searchable', (INFUSEDWOO_PRO_URL . 'assets/chosen/chosen.jquery.min.js'), array('jquery') );
		wp_enqueue_script( 'ia_admin_scripts', (INFUSEDWOO_PRO_URL . 'assets/admin_scripts.js')); 

		?>

		<?php add_thickbox(); ?>
		<style type="text/css">
			.iwar_macro {
				display: inline-block;
				height: 27px !important;
				width: 27px !important;
				background-image: url('<?php echo INFUSEDWOO_PRO_URL . "images/infusedwoo_menu_icon.png"; ?>') !important;
				background-size: 18px 18px !important;
				background-repeat: no-repeat !important;
				background-position: 4px 4px !important;
			}

			.iwar_macro_p .select2-container {
				width: 340px !important;
				max-width: 100% !important;
			}

		</style>
		<?php
	}

	function admin_footer() {
		if(isset($_GET['post'])) {
			if( get_post_type ($_GET['post']) != 'shop_order') return false;
		} else if(!isset($_GET['post_type']) || $_GET['post_type'] != 'shop_order') return false;

		if(!function_exists('iw_get_recipes')) return false;
		
		?>
		<script type="text/javascript">
			jQuery(document).ready(function() {
				jQuery('body').on('click',".iwar_macro",function(e) {
					e.preventDefault();
				    var TB_WIDTH = jQuery(window).width() > 400 ? 400 : jQuery(window).width(),
				        TB_HEIGHT = 150; // set the new width and height dimensions here..

				    jQuery('.iwar_macro_p .button' ).attr('run-on', jQuery(this).attr('order'));
				    jQuery('.iwar_macro_p .button' ).html('Run Macro on Order #' + jQuery(this).attr('order'));
				    setTimeout(function() {
				    	 jQuery("#TB_window").css({
					        marginLeft: '-' + parseInt((TB_WIDTH / 2), 10) + 'px',
					        width: TB_WIDTH + 'px',
					        height: TB_HEIGHT + 'px',
					        marginTop: '-' + parseInt((TB_HEIGHT / 2), 10) + 'px'
					    });
				    },0);

				    jQuery('.iwar_macro_p .button').click(function(e) {
				    	e.preventDefault();
				    	var order_id = jQuery(this).attr('run-on');
				    	var recipe_id = jQuery(this).parent().children('.macro_id').val();
				    	location.href = '<?php echo admin_url("admin-ajax.php?action=iwar_order_macro"); ?>' + '&order_id='+order_id + '&recipe_id=' + recipe_id;
				    });


				});

				jQuery('body').on('click','.wc-action-button-run_iw_macro',function(e) {
					e.preventDefault();
					var order_id = jQuery(this).attr('href').split('#').pop();
					jQuery('.iwar_macro_3').attr('order',order_id);
					jQuery('.iwar_macro_3').click();
				    jQuery('[name=wc_order_action]').val('');
				});


				jQuery('[name=wc_order_action]').change(function() {
			    	if(jQuery(this).val() == 'iwar_run_macro') {
				    	jQuery('.iwar_macro_order').click();
				    	jQuery('[name=wc_order_action]').val('');
				    }
			    });

			});
		</script>

		<div id="iwar_macro_box" style="display:none;">
			<p class="iwar_macro_p">
				<select class="iw-select2 macro_id" >
		        <?php
		        	$available_macros = iw_get_recipes('IW_OrderMacro_Trigger', true);
		        	foreach($available_macros as $macro) {
		        		echo '<option value="'.$macro->ID.'">'.get_the_title($macro->ID).'</option>';
		        	}
		        	// NEXT BUILD A SEARCHABLE COMBO, (checkbox controlled. it will put divider for search result)
		        ?>
		   		</select><br><br>
		   		<span type="button" class="button" run-on="" style="text-align: right">Run Macro</span>
		    </p>
		</div>
		<script type="text/javascript" src="<?php echo INFUSEDWOO_PRO_URL . "admin-menu/assets/paneledits3.js"; ?>"></script>
		<?php
	}
}

iw_add_trigger_class('IW_OrderMacro_Trigger');
