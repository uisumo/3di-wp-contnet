( function( blocks, i18n, element, InspectorControls, ServerSideRender ) {
  var el = element.createElement;
  var __ = i18n.__;

  var blockStyle = {
    backgroundColor: '#900',
    color: '#fff',
    padding: '20px',
  };

  blocks.registerBlockType( 'grassblade/user-report', {
    title: __("User Report", "grassblade"),
    icon: 'id-alt',
    description: __("You can add User Report for xAPI courses.", "grassblade"),
    category: 'grassblade-blocks',
    attributes: {
      bg_color : {type: 'string', default: '#83BA39'},
      filter : {type: 'string', default: 'attempted'},
      className : {type: 'string'}
    },
    edit: function(props) {
        const Default_Filter_Options = {
                                  "all"      : __("All", "grassblade"),
                                  "attempted": __("Attempted", "grassblade"),
                                  "passed"   : __("Passed", "grassblade"),
                                  "failed"   : __("Failed", "grassblade"),
                                  "completed": __("Completed", "grassblade"),
                                  "in_progress": __("In Progress", "grassblade"),
                                };
        function setBG_color(value) {

          props.setAttributes({bg_color: value.hex})

        } // end of setBG_color function

        function setDefault_Filter(event) {
          props.setAttributes({filter: event.target.value});
        } // end of setDefault_Filter function

        function getShortcode() {
          var filter = (typeof props.attributes.filter == "string")?  (' filter="' + props.attributes.filter + '" '): "";
          return "[gb_user_report bg_color=" + props.attributes.bg_color + filter + "]";
        }
        var defaultFilterOptions = [];

        Object.keys( Default_Filter_Options ).forEach(function(option_key) {
          var selected = (props.attributes.filter == option_key) ? "selected":"";
          defaultFilterOptions.push(el("option", { key:option_key, value: option_key, selected: selected }, Default_Filter_Options[option_key]));
        });

        const controls = [
          el(
            InspectorControls,
            {key: "grassblade-user-report-controls"},
            el(
              "div",
              {class:"gb_xapi_block_settings"},
              el(
                "hr",
                null
              ),
              el("span", {style:{fontWeight: 600, width: '100%'}},__("Background Color", "grassblade")+":"),
              el("br"),
              el("br"),
              el(wp.components.ColorPicker, { key:"colorPicker", color: props.attributes.bg_color, onChangeComplete: setBG_color }),
              el("br"),
              el("span", {style:{fontWeight: 600, width: '100%'}},__("Default Filter", "grassblade")+":"),
              el("select", {onChange: setDefault_Filter, style:{width:'100%'}}, defaultFilterOptions),
              el("br"),
              el("br"),
              el("label", null , el("b", null, __("Alternatively, you can use this shortcode", "grassblade")+":")),
              el("br"),
              el("textarea", {rows: "3",cols: "30",value: getShortcode()}),
            ),
          ),
        ];

        return [
                controls,
                el(ServerSideRender, {
                    block: "grassblade/user-report",
                    key: "grassblade/user-report",
                    attributes: props.attributes
                } )
              ];

    },
    save: function() {
      return null;
    },
  } );
} )( window.wp.blocks, window.wp.i18n, window.wp.element, wp.blockEditor.InspectorControls, window.wp.serverSideRender );