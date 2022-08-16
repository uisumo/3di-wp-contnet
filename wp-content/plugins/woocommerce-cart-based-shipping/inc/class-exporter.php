<?php
/*
 * Import / Export Cart Based Shipping Settings
 */

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) exit;

class BEExport_WooCartShipping {

    private $redirect_url;
    private $settings;
 
    /**
     * Initialize a new instance of the Exporter
     */
    function __construct( $cartBasedClass ) {

        $this->redirect_url = admin_url( 'admin.php?page=wc-settings&tab=shipping&section=wc_cart_based_shipping' );

        $this->cartBasedClass = $cartBasedClass;

        $this->settings = $cartBasedClass->settings;

        $this->cart_rate_sub_option = $cartBasedClass->cart_rate_sub_option;
        $this->cart_rate_count_option = $cartBasedClass->cart_rate_count_option;
        $this->cart_rate_weight_option = $cartBasedClass->cart_rate_weight_option;
        $this->class_exclusions_options = $cartBasedClass->class_exclusions_options;

        if( isset( $_POST[ 'be-export-cartbased' ] ) ) $this->process_settings_export();
        if( isset( $_POST[ 'be-import-cartbased' ] ) ) {
            $this->process_settings_import();
            unset( $_POST[ 'be-import-cartbased' ] );
        }

    }


    /**
     * Print Exporter Settings
     *
     * @param $transient
     * @return void
     */
    function print_exporter_settings ( $disable_importer = false ) {
?>
    <div id="cart-based-export-settings" class="metabox-holder" style="clear:both; display: block; margin: 0; padding: 0;">
        <div id="cart-based-export-settings" class="postbox" style="width: 49%; float: left;">
            <h3><span><?php _e( 'Export Settings' ); ?></span></h3>
            <div class="inside">
                <form method="post">
                    <p><?php _e( 'Generate backup file to save your settings for this shipping method.', 'be-cart-based' ); ?></p>
                    <p>&nbsp;</p>
                    <p>
                        <input type="hidden" name="be_cartship_export_save_names" value="<?php echo  base64_encode( serialize( $this->cartBasedClass->save_names ) ); ?>" />
                        <input type="hidden" name="be_cartship_export_settings_fields_id" value="<?php echo $this->cartBasedClass->plugin_id . $this->cartBasedClass->id; ?>" />
                        <?php wp_nonce_field( 'be_cartship_export_nonce', 'be_cartship_export_nonce' ); ?>
                        <?php submit_button( __( 'Export' ), 'secondary', 'be-export-cartbased', false ); ?>
                    </p>
                </form>
            </div><!-- .inside -->
        </div><!-- .postbox -->

        <?php if( ! $disable_importer ) : ?>

        <div id="cart-based-import-settings" class="postbox" style="width: 49%; float: right;">
            <h3><span><?php _e( 'Import Settings' ); ?></span></h3>
            <div class="inside">
                <form method="post" enctype="multipart/form-data">
                    <?php wp_nonce_field( 'woocommerce-settings' ); ?>
                    <p><?php _e( 'Import settings for this method from your saved backup file.', 'be-cart-based' ); ?></p>
                    <p>&nbsp;</p>
                    <p>
                        <input type="hidden" name="save" value="true" />
                        <input type="hidden" name="be_cartship_import_save_names" value="<?php echo base64_encode( serialize( $this->cartBasedClass->save_names ) ); ?>" />
                        <input type="hidden" name="be_cartship_import_settings_fields_id" value="<?php echo $this->cartBasedClass->plugin_id . $this->cartBasedClass->id; ?>" />
                        <input type="file" name="import_file"/>
                        <?php submit_button( __( 'Import' ), 'secondary', 'be-import-cartbased', false ); ?>
                    </p>
                </form>
            </div><!-- .inside -->
        </div><!-- .postbox -->

        <?php endif; ?>

    </div><!-- .metabox-holder -->
<?php
    }


    /**
     * Generate JSON code on export
     */
    function process_settings_export() {
        if( ! current_user_can( 'manage_options' ) )
            return;

        $settings = $this->process_settings();

        ignore_user_abort( true );

        nocache_headers();
        header( 'Content-Type: application/json; charset=utf-8' );
        header( 'Content-Disposition: attachment; filename=be-cartbased-settings.' . date( 'm-d-Y' ) . '.json' );
        header( "Expires: 0" );

        echo json_encode( $settings );
        exit;
    }


    /**
     * Process JSON code on import
     */
    function process_settings_import() {

        if( ! current_user_can( 'manage_options' ) )
            return;

        // check that a file has been submitted
        $import_file = $_FILES['import_file']['tmp_name'];
        if( empty( $import_file ) )
            return __( 'Please upload a file to import' );

        // check that a JSON file has been uploaded
        $file_name = explode( '.', $_FILES['import_file']['name'] );
        $extension = end( $file_name );
        if( $extension != 'json' )
            return __( 'Please upload a valid .json file' );

        // Retrieve the settings from the file and convert the json object to an array.
        $settings = (array) json_decode( file_get_contents( $import_file ), true );

        $this->restore_settings( $settings );

        return "success";
        //wp_safe_redirect( $this->redirect_url . '&import=success' ); exit;

    }


    /**
     * Combine settings into single array
     *
     * @return array
     */
    function process_settings() {
        // retrieve settings from DB
        $settings = array();

        $save_names = unserialize( base64_decode( $_POST['be_cartship_export_save_names'] ) );
        $save_names = array_map( 'sanitize_text_field', $save_names );        
        $settings_fields_id = sanitize_text_field( $_POST['be_cartship_export_settings_fields_id'] );
        $settings[ 'cart_rate_shipping' ] = get_option( $settings_fields_id . '_settings' );

        if( $save_names['cart_rate_sub_option'] != '' )
            $settings[ 'cart_rate_sub_option' ] = get_option( $save_names['cart_rate_sub_option'] );

        if( $save_names['cart_rate_count_option'] != '' )
            $settings[ 'cart_rate_count_option' ] = get_option( $save_names['cart_rate_count_option'] );

        if( $save_names['cart_rate_weight_option'] != '' )
            $settings[ 'cart_rate_weight_option' ] = get_option( $save_names['cart_rate_weight_option'] );

        if( $save_names['class_exclusions_options'] != '' )
            $settings[ 'class_exclusions_options' ] = get_option( $save_names['class_exclusions_options'] );

        return $settings;
    }


    /**
     * Combine settings into single array
     *
     * @return array
     */
    function restore_settings( $settings ) {
        $cartBasedClass = $this->cartBasedClass;

        $save_names = unserialize( base64_decode( $_POST['be_cartship_import_save_names'] ) );
        $save_names = array_map( 'sanitize_text_field', $save_names );
        $settings_fields_id = sanitize_text_field( $_POST['be_cartship_import_settings_fields_id'] );

        // setup data as POST variables for processing
        foreach( $settings[ 'cart_rate_shipping' ] as $key => $value )
            if( $value == 'yes' )
                $_POST[ $settings_fields_id . '_' . $key ] = 1;
            else
                $_POST[ $settings_fields_id . '_' . $key ] = $value;

        // check which process have been backed up
        if( $settings[ 'cart_rate_sub_option' ] && $save_names['cart_rate_sub_option'] != '' ) {
            // cleanup imported values
            array_walk_recursive( $settings[ 'cart_rate_sub_option' ], array( $this, 'clean_nested_array' ) );
            update_option( $save_names['cart_rate_sub_option'], $settings[ 'cart_rate_sub_option' ] );
        }

        if( $settings[ 'cart_rate_count_option' ] && $save_names['cart_rate_count_option'] != '' ) {
            // cleanup imported values
            array_walk_recursive( $settings[ 'cart_rate_count_option' ], array( $this, 'clean_nested_array' ) );
            update_option( $save_names['cart_rate_count_option'], $settings[ 'cart_rate_count_option' ] );
        }

        if( $settings[ 'cart_rate_weight_option' ] && $save_names['cart_rate_weight_option'] != '' ) {
            // cleanup imported values
            array_walk_recursive( $settings[ 'cart_rate_weight_option' ], array( $this, 'clean_nested_array' ) );
            update_option( $save_names['cart_rate_weight_option'], $settings[ 'cart_rate_weight_option' ] );
        }

        if( $settings[ 'class_exclusions_options' ] && $save_names['class_exclusions_options'] != '' ) {
            // cleanup imported values
            array_walk_recursive( $settings[ 'class_exclusions_options' ], array( $this, 'clean_nested_array' ) );
            update_option( $save_names['class_exclusions_options'], $settings[ 'class_exclusions_options' ] );
        }

    }


    /**
     * Combine settings into single array
     *
     * @return array
     */
    function clean_nested_array( &$item, $key ) {
        if( is_array( $item ) )
            $item = array_map('woocommerce_clean',$item);
        else
            $item = woocommerce_clean( $item );
    }

}

?>