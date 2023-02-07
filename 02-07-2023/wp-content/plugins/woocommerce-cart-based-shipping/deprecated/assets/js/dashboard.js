// Add functionality to Bolder Compare Products settings form
jQuery(document).ready(function($) {

    //Check if page belongs to Cart Based Shipping
    var cartSettingsDiv = jQuery( '#be-cart-shipping-settings' );

    if( cartSettingsDiv.length ) {

        var cartPluginID = cartSettingsDiv.attr( 'cart-shipping-id' );
        var currencySymbol = cartSettingsDiv.attr( 'currency-symbol' );

        // Load default frame
        jQuery(window).load(function() {

            var e = document.getElementById("woocommerce_" + cartPluginID + "_method");
            var method_sel = e.options[e.selectedIndex].value;
            if(method_sel=='subtotal' ) document.getElementById( 'row_subtotal_based' ).style.display='table-row';
            if(method_sel=='itemcount' ) document.getElementById( 'row_itemcount_based' ).style.display='table-row';
            if(method_sel=='weighttotal' ) document.getElementById( 'row_weighttotal_based' ).style.display='table-row';

            return false;
        });

        // Event Handler for Change of Shipping Method
        jQuery( '#woocommerce_' + cartPluginID + '_method' ).change(function(){

            document.getElementById( 'row_subtotal_based' ).style.display='none';
            document.getElementById( 'row_itemcount_based' ).style.display='none';
            document.getElementById( 'row_weighttotal_based' ).style.display='none';

            var e = document.getElementById("woocommerce_" + cartPluginID + "_method");
            var method_sel = e.options[e.selectedIndex].value;
            if(method_sel=='subtotal' ) document.getElementById( 'row_subtotal_based' ).style.display='table-row';
            if(method_sel=='itemcount' ) document.getElementById( 'row_itemcount_based' ).style.display='table-row';
            if(method_sel=='weighttotal' ) document.getElementById( 'row_weighttotal_based' ).style.display='table-row';

            return false;
        });

        jQuery( '#' + cartPluginID + '_cart_rates_subtotal a.add' ).live( 'click', function(){

        var size = jQuery( '#' + cartPluginID + '_cart_rates_subtotal tbody .cart_rate' ).size();

        jQuery( '<tr class="cart_rate">\
            <td class="check-column"><input type="checkbox" name="select" /></td>\
                    <td>' + currencySymbol + ' <input type="text" name="' + cartPluginID + '_sub_min[' + size + ']" placeholder="0.00" size="4" /></td>\
                    <td><select name="' + cartPluginID + '_shiptype[' + size + ']" class="shiptype"><option>' + currencySymbol + '</option><option>%</option></select>\
                    <input type="text" name="' + cartPluginID + '_sub_cost[' + size + ']" placeholder="0.00" size="4" /></td>\
                    <td></td>\
            </tr>' ).appendTo( '#' + cartPluginID + '_cart_rates_subtotal table tbody' );

        return false;
        });

        jQuery( '#' + cartPluginID + '_cart_rates_itemcount a.add' ).live( 'click', function(){

            var size = jQuery( '#' + cartPluginID + '_cart_rates_itemcount tbody .cart_rate' ).size();

            jQuery( '<tr class="cart_rate">\
                <td class="check-column"><input type="checkbox" name="select" /></td>\
                        <td><input type="text" name="' + cartPluginID + '_count_min[' + size + ']" placeholder="0" size="4" /></td>\
                        <td><select name="' + cartPluginID + '_shiptype[' + size + ']" class="shiptype"><option>' + currencySymbol + '</option><option>%</option></select>\
                        <input type="text" name="' + cartPluginID + '_count_cost[' + size + ']" placeholder="0.00" size="4" /></td>\
                        <td></td>\
                </tr>' ).appendTo( '#' + cartPluginID + '_cart_rates_itemcount table tbody' );

            return false;
        });

        jQuery( '#' + cartPluginID + '_cart_rates_weighttotal a.add' ).live( 'click', function(){

            var size = jQuery( '#' + cartPluginID + '_cart_rates_weighttotal tbody .cart_rate' ).size();

            jQuery( '<tr class="cart_rate">\
                <td class="check-column"><input type="checkbox" name="select" /></td>\
                        <td><input type="text" name="' + cartPluginID + '_weight_min[' + size + ']" placeholder="0" size="4" /></td>\
                        <td><select name="' + cartPluginID + '_shiptype[' + size + ']" class="shiptype"><option>' + currencySymbol + '</option><option>%</option></select>\
                        <input type="text" name="' + cartPluginID + '_weight_cost[' + size + ']" placeholder="0.00" size="4" /></td>\
                        <td></td>\
                </tr>' ).appendTo( '#' + cartPluginID + '_cart_rates_weighttotal table tbody' );

            return false;
        });

    }

});
