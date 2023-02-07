( function( blocks, i18n, element, ServerSideRender ) {
  var el = element.createElement;
  var __ = i18n.__;

  var blockStyle = {
    backgroundColor: '#900',
    color: '#fff',
    padding: '20px',
  };

  blocks.registerBlockType( 'grassblade/admin-reports', {
    title: __('Admin Reports', 'grassblade'),
    icon: 'id-alt',
    description: __("Show frontend reports to admins and group leaders.", "grassblade"),
    category: 'grassblade-blocks',
//    example: {},
    edit: function(props) {
      return el(ServerSideRender, {
                  block: "grassblade/admin-reports",
                  key: "grassblade/admin-reports",
                  attributes: {}
              } );
    },
    save: function(props) {
      return null;
    },
  } );
} )( window.wp.blocks, window.wp.i18n, window.wp.element, window.wp.serverSideRender );