var $j = jQuery.noConflict();

$j(document).ready(function () {


    /* Get settings */
    
    function tweetdis_tab_request() {
        
        var tab = $j('.tweetdis_tabs input[type="radio"]:checked').attr('id');
        
        var request = {
            action: 'tweetdis_get_preview',
            tabs: tab
        };
        
        $j.ajax({
            type: 'POST',
            url: Td_Ajax.ajaxurl,
            data: request,
            success: function (msg) {
                $j('#tweetdis_preview').html(msg);
            }
        });
    }
    
    tweetdis_tab_request();

    $j('.tweetdis_tabs input[type="radio"]').click(function() {
        tweetdis_tab_request();
    });
   
});