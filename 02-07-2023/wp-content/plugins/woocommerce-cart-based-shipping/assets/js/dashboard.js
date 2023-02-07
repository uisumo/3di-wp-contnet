// Add functionality to Cart Based Shipping Method settings form
jQuery(document).ready(function($) {

    //Check if page belongs to Cart Based Shipping
    var cartSettingsDiv = jQuery( '#woocommerce_cart_based_rate_enabled' );

    if( cartSettingsDiv.length ) {

        var settings_table = jQuery( '#becbs_subtotal_based table' );
        var cartPluginID = settings_table.attr( 'cart-shipping-id' );
        var currencySymbol = settings_table.attr( 'currency-symbol' );

        function becbs_change_table_display() {
            jQuery( '#becbs_subtotal_based' ).css( 'display','none');
            jQuery( '#becbs_quantity_based' ).css( 'display','none');
            jQuery( '#becbs_weight_based' ).css( 'display','none');

            var e = jQuery("#woocommerce_" + cartPluginID + "_method");
            var method_sel = e.val();
            if(method_sel=='subtotal' ) jQuery( '#becbs_subtotal_based' ).css( 'display','table-row');
            if(method_sel=='itemcount' ) jQuery( '#becbs_quantity_based' ).css( 'display','table-row');
            if(method_sel=='weighttotal' ) jQuery( '#becbs_weight_based' ).css( 'display','table-row');
        }

        // Load default frame
        jQuery(window).load(function() {
            becbs_change_table_display();

            return false;
        });

        // Event Handler for Change of Shipping Method
        jQuery( '#woocommerce_' + cartPluginID + '_method' ).change(function(){
            becbs_change_table_display();

            return false;
        });

        jQuery( '#becbs_subtotal_based' ).on( 'click', 'a.add', function(){

        var size = jQuery( '#becbs_subtotal_based tbody .cart_rate' ).size();

        jQuery( '<tr class="cart_rate">\
            <td class="check-column"><input type="checkbox" name="select" /></td>\
                    <td>' + currencySymbol + ' <input type="text" name="' + cartPluginID + '_sub_min[' + size + ']" placeholder="0.00" size="4" class="wc_input_price" /></td>\
                    <td><select name="' + cartPluginID + '_sub_shiptype[' + size + ']" class="shiptype"><option>' + currencySymbol + '</option><option>%</option></select>\
                    <input type="text" name="' + cartPluginID + '_sub_cost[' + size + ']" placeholder="0.00" size="4" class="wc_input_price" /></td>\
                    <td></td>\
            </tr>' ).appendTo( '#becbs_subtotal_based table tbody' );

        return false;
        });

        jQuery( '#becbs_quantity_based' ).on( 'click', 'a.add', function(){

            var size = jQuery( '#becbs_quantity_based tbody .cart_rate' ).size();

            jQuery( '<tr class="cart_rate">\
                <td class="check-column"><input type="checkbox" name="select" /></td>\
                        <td><input type="number" name="' + cartPluginID + '_count_min[' + size + ']" placeholder="0" size="4" class="wc_input_decimal" /></td>\
                        <td><select name="' + cartPluginID + '_count_shiptype[' + size + ']" class="shiptype"><option>' + currencySymbol + '</option><option>%</option></select>\
                        <input type="text" name="' + cartPluginID + '_count_cost[' + size + ']" placeholder="0.00" size="4" class="wc_input_price" /></td>\
                        <td></td>\
                </tr>' ).appendTo( '#becbs_quantity_based table tbody' );

            return false;
        });

        jQuery( '#becbs_weight_based' ).on( 'click', 'a.add', function(){

            var size = jQuery( '#becbs_weight_based tbody .cart_rate' ).size();

            jQuery( '<tr class="cart_rate">\
                <td class="check-column"><input type="checkbox" name="select" /></td>\
                        <td><input type="text" name="' + cartPluginID + '_weight_min[' + size + ']" placeholder="0" size="4" /></td>\
                        <td><select name="' + cartPluginID + '_weight_shiptype[' + size + ']" class="shiptype"><option>' + currencySymbol + '</option><option>%</option></select>\
                        <input type="text" name="' + cartPluginID + '_weight_cost[' + size + ']" placeholder="0.00" size="4" class="wc_input_price" /></td>\
                        <td></td>\
                </tr>' ).appendTo( '#becbs_weight_based table tbody' );

            return false;
        });

    }

});
