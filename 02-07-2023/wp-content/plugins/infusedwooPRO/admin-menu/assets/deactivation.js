 jQuery('#iw-deactivation').dialog({
    title: 'InfusedWoo Deactivation',
    dialogClass: 'wp-dialog',
    autoOpen: false,
    draggable: false,
    width: 600,
    modal: true,
    resizable: false,
    closeOnEscape : true,
    position: {
      my: "center",
      at: "center",
      of: window
    },
    create: function(){
      jQuery('.ui-dialog-titlebar-close').addClass('ui-button');
    },
    open: function(){
      jQuery('.ui-widget-overlay').bind('click',function(){
        jQuery('#log-dialog').dialog('close');
      })
    }
  });

 jQuery('[data-slug="infusedwoo-pro"] .deactivate > a').click(function(e) {
    e.preventDefault();    
    jQuery('.iw-deactivation-2').hide();
    jQuery('.iw-deactivation-1').show();
    jQuery('#iw-deactivation').dialog('open');
    jQuery('[name="iw-deactivation-url"]').val(jQuery(this).attr('href'));
 });

 jQuery('.iw-deactivate').click(function() {
    var selection = jQuery('[name=iwdeactivate]:checked').val();

    if(selection == 'temporary') {
      location.href = jQuery('[name="iw-deactivation-url"]').val();
    } else {
      jQuery('.iw-deactivation-1').hide();
      jQuery('.iw-deactivation-2').show();
    }
 });

 jQuery('.iw-delete').click(function() {
    if(jQuery('[name=iw-confirm-delete]').val().toLowerCase() == 'delete' ) {
      jQuery(this).removeClass('iw-delete');
      jQuery(this).removeClass('button-primary');
      jQuery(this).text('Please wait...');

      jQuery.post(ajaxurl + '?action=iw-deletion',{}, function() {
        location.href = jQuery('[name="iw-deactivation-url"]').val();
      });
    } else {
      jQuery('.iw-deacerror').show();
    }
 });