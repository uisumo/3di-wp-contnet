

/* This section of the code registers a new block, sets an icon and a category, and indicates what type of fields it'll include. */
function grassblade_blocks() {
"use strict";

const { registerBlockType } = wp.blocks;

const {
    RichText,
    AlignmentToolbar,
    BlockControls,
    BlockDescription,
    ToggleControl
} = wp.editor;

const {
  InspectorControls
} = wp.blockEditor;

const {
  serverSideRender: ServerSideRender
} = wp;

var el = wp.element.createElement;

registerBlockType('grassblade/xapi-content', {
  title: gb_block_data.xapi_content_title,
  icon: 'welcome-learn-more',
  category: 'grassblade-blocks',
  description: gb_block_data.xapi_content_desc,
  attributes: {
    check_completion: {type: 'string'},
    content_id : {type: 'string'},
    className : {type: 'string'}
  },

/* This configures how the content field will work, and sets up the necessary elements */

  edit: function(props) {

    function changeContent(event) {
      props.setAttributes({content_id: event.target.value})

      var completion = jQuery("#grassblade_xpi_content").find(':selected').attr('data-completion-tracking');
      if (completion == 'true') {
        props.setAttributes({check_completion: gb_block_data.tracking_enable})
      } else {
        props.setAttributes({check_completion: gb_block_data.tracking_disable})
      }
    } // end of changeContent function

      var postSelections = [];

      postSelections.push(el("option", { key: "none", value: "" , hidden : true }, gb_block_data.Select_Content));
      jQuery.each(gb_block_data.post_content, function( key, value ) {
        postSelections.push(el("option", { key: value.id, value: value.id , "data-completion-tracking" : value.completion_tracking}, value.post_title));
      });

      const controls = [
        el(
          InspectorControls,
          { key:"grassblade/xapi-content/ic" },
          el(
            "div",
            { style: {padding: "15px" }},
            el(
              "hr",
              null
            ),
            el("span", {style:{fontWeight: 600, width: '100%'}}, gb_block_data.Add_to_Page + ":  ",
            el("a", {href: gb_block_data.admin_url+'post-new.php?post_type=gb_xapi_content'}, gb_block_data.Add_New)),
            el("br"),
            el("br"),
            el("select", { key:"grassblade_xpi_content", value: props.attributes.content_id, onChange: changeContent, style:{width:'100%'}, id: "grassblade_xpi_content"}, postSelections),
            el("a", {href: gb_block_data.admin_url+'post.php?action=edit&message=1&post='+props.attributes.content_id},(props.attributes.content_id)? gb_block_data.Edit: props.attributes.content_id),
            el("br"),
            el("br"),
            el("a", {href: gb_block_data.admin_url+'post.php?action=edit&message=1&post='+props.attributes.content_id},props.attributes.check_completion),
            el("div", {id:"gb_meta_box_extra_message", style:{display:((gb_block_data.extra_message.length == 0 || typeof props.attributes.check_completion == "string" && props.attributes.check_completion.search("Disabled") > 0)? "none":"block")}}, gb_block_data.extra_message),
          ),
        ),
      ];
    return [
              controls,
              el(ServerSideRender, {
                  block: "grassblade/xapi-content",
                  key: "grassblade/xapi-content",
                  attributes: props.attributes
              } )
            ];

  },
  save: function(props) {
    return null;
  }
})

registerBlockType('grassblade/leaderboard', {
  title: gb_block_data.leaderboard_title,
  icon: 'universal-access-alt',
  category: 'grassblade-blocks',
  description: gb_block_data.leaderboard_desc,
  attributes: {
      content_id : {type: 'string'},
      role : {type: 'string', default: "all"},
      score : {type: 'string'},
      limit : {type: 'string', default: 20},
      className : {type: 'string'}
  },

/* This configures how the content field will work, and sets up the necessary elements */

  edit: function(props) {

    var role = props.attributes.role;

      function changeContent(event) {

        props.setAttributes({content_id: event.target.value})

      } // end of changeContent function

      function changeRole(event) {

        var roles = jQuery(event.target).parent().children("input:checkbox:checked").map(function() {
            return this.value;
        }).get().join(",");
        props.setAttributes({ role: roles });

      } // end of changeRole function

      function changeScore(event) {

        props.setAttributes({score: event.target.value})

      } // end of changeScore function

      function setLimit(event) {

        props.setAttributes({limit: event.target.value})

      } // end of setLimit function

      var postSelections = [];

      postSelections.push(el("option", { key: "none", value: "" , hidden : true }, gb_block_data.Select_Content));
      jQuery.each(gb_block_data.post_content, function( key, value ) {
          postSelections.push(el("option", {key: value.id, value: value.id }, value.post_title));
      });

      var roleSelections = [];

      roleSelections.push(el("input", { onChange: changeRole,  type: "checkbox", value: "all"}),el("label", null, gb_block_data.All_Role),el("br"));
      jQuery.each(gb_block_data.roles, function( key, value ) {
        var roles = props.attributes.role.split(",");
        var checked = roles.indexOf(key) < 0? "":"checked";
        roleSelections.push(el("input", { onChange: changeRole, type: "checkbox", value: key, checked: checked}),el("label", null, value.name),el("br"));
      });

      var scoreSelections = [];
      scoreSelections.push(el("option", { key: "score", value: "score" }, gb_block_data.Score));
      scoreSelections.push(el("option", { key: "percentage", value: "percentage" }, gb_block_data.Percentage));

      const controls = [
        el(
          InspectorControls,
          { key: "grassblade/leaderboard/ic" },
          el(
            "div",
            { style: {padding: "15px" }},
            el(
              "hr",
              null
            ),
            el("span", {style:{fontWeight: 600, width: '100%'}},gb_block_data.Content+":"),
            el("select", { value: props.attributes.content_id, onChange: changeContent, style:{width:'100%'}}, postSelections),
            el("br"),
            el("br"),
            el("span", {style:{fontWeight: 600, width: '100%'}},gb_block_data.Role+":"),
            el("br"),
            el("span", {style:{width: '100%'}}, "("+gb_block_data.Role_Desc+")"),
            el("br"),
            el("div", null, roleSelections),
            el("br"),
            el("span", {style:{fontWeight: 600, width: '100%'}},gb_block_data.Score_Type+":"),
            el("select", {value: props.attributes.score, onChange: changeScore , style:{width:'100%'}}, scoreSelections),
            el("br"),
            el("br"),
            el("span", {style:{fontWeight: 600, width: '100%'}},gb_block_data.Limit+":"),
            el("input", {onChange: setLimit, style:{width:'100%'}, type: "text", value : props.attributes.limit }),
          ),
        ),
      ];

      return [
              controls,
              el(ServerSideRender, {
                  block: "grassblade/leaderboard",
                  key: "grassblade/leaderboard",
                  attributes: props.attributes
              } )
            ];

  },
  save: function(props) {
    return null;
  }
})


registerBlockType('grassblade/userscore', {
  title: gb_block_data.userscore_title,
  icon: 'businessman',
  category: 'grassblade-blocks',
  description: gb_block_data.userscore_desc,
  attributes: {
      content_id : {type: 'string' , default: ""},
      show : {type: 'string', default: 'total_score'},
      add : {type: 'string' , default: ""},
      label : {type: 'string', default: gb_block_data.User_Score},
      className : {type: 'string'}
  },

/* This configures how the content field will work, and sets up the necessary elements */

  edit: function(props) {

      function changeContent(event) {

        props.setAttributes({content_id: event.target.value})

      } // end of changeContent function

      function changeShow(event) {

        props.setAttributes({show: event.target.value})

      } // end of changeShow function

      function changeAdd(event) {

        props.setAttributes({add: event.target.value})

      } // end of changeAdd function

      function setLabel(event) {

        props.setAttributes({label: event.target.value})

      } // end of setLabel function

      var postSelections = [];

      postSelections.push(el("option", {key: "all", value: "" }, gb_block_data.All_Content));
      jQuery.each(gb_block_data.post_content, function( key, value ) {
          postSelections.push(el("option", {key: value.id, value: value.id }, value.post_title));
      });

      var scoreSelections = [];

      scoreSelections.push(el("option", { key: "total_score", value: "total_score" }, gb_block_data.Total_Score));
      scoreSelections.push(el("option", { key: "average_percentage", value: "average_percentage" }, gb_block_data.Average_Percentage));

      var addSelections = [];
      addSelections.push(el("option", { key: "none", value: "" }, gb_block_data.No_Selection));
      addSelections.push(el("option", { key: "badgeos_points", value: "badgeos_points" }, gb_block_data.Badgeos_Points));

      const controls = [
        el(
          InspectorControls,
          { key: "grassblade/userscore/ic" },
          el(
            "div",
            { style: {padding: "15px" }},
            el(
              "hr",
              null
            ),
            el("span", {style:{fontWeight: 600, width: '100%'}}, gb_block_data.Label+":"),
            el("input", { key:"label", onChange: setLabel, type: "text", style:{width:'100%'}, value : props.attributes.label }),
            el("br"),
            el("br"),
            el("span", {style:{fontWeight: 600, width: '100%'}},gb_block_data.xAPI_Content+":"),
            el("select", { key: "xapi_contents", value: props.attributes.content_id, onChange: changeContent, style:{width:'100%'}}, postSelections),
            el("br"),
            el("br"),
            el("span", {style:{fontWeight: 600, width: '100%'}},gb_block_data.Score+":"),
            el("select", { key: "show", value: props.attributes.show, onChange: changeShow, style:{width:'100%'}}, scoreSelections),
            el("br"),
            el("br"),
            el("span", {style:{fontWeight: 600, width: '100%'}},gb_block_data.Add+":"),
            el("select", { key: "add",value: props.attributes.add, onChange: changeAdd, style:{width:'100%'}}, addSelections),

            el("br"),
            el("br"),
            el("label", null , el("b", null, gb_block_data.add_shortcode_desc+":")),
            el("br"),
            el("textarea", { key:"shortcode", rows: "2",cols: "30", readOnly: true, value: " [grassblade_user_score " + ((props.attributes.content_id == "")? "":(" content_id=" + props.attributes.content_id)) + ((props.attributes.show == "")? "":(" show='" + props.attributes.show + "'")) + ((props.attributes.add == "")? "":(" add='" + props.attributes.add + "'" )) + "]"}),
          ),
        ),
      ];
      return [
              controls,
              el(ServerSideRender, {
                  block: "grassblade/userscore",
                  key: "grassblade/userscore",
                  attributes: props.attributes
              } )
            ];

  },
  save: function(props) {
    return null;
  }
}) // end registerBlockType('grassblade/leaderboard' ...


} // end grassblade_blocks();
grassblade_blocks();
