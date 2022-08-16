var el = wp.element.createElement,
	registerBlockType = wp.blocks.registerBlockType,
	ServerSideRender = wp.components.ServerSideRender,
	TextControl = wp.components.TextControl,
	SelectControl = wp.components.SelectControl,
	InspectorControls = wp.editor.InspectorControls,
	Localize = wp.i18n.__,
	ewdUpcpBlocks = ewd_upcp_blocks,
	existingCatalogs = ewdUpcpBlocks.catalogOptions;

registerBlockType( 'ultimate-product-catalogue/ewd-upcp-display-catalog-block', {
	title: Localize( 'Display Product Catalog', 'ultimate-product-catalogue' ),
	icon: 'feedback',
	category: 'ewd-upcp-blocks',
	attributes: {
		id: { type: 'string' },
		sidebar: { type: 'string' },
		starting_layout: { type: 'string' },
		excluded_layouts: { type: 'string' },
	},

	edit: function( props ) {
		var returnString = [];
		returnString.push(
			el( InspectorControls, {},
				el( SelectControl, {
					label: Localize( 'Which Catalog?', 'ultimate-product-catalogue' ),
					value: props.attributes.id,
					options: existingCatalogs,
					onChange: ( value ) => { props.setAttributes( { id: value } ); },
				} ),
				el( SelectControl, {
					label: Localize( 'Sidebar', 'ultimate-product-catalogue' ),
					value: props.attributes.sidebar,
					options: [ {value: 'Yes', label: 'Yes'}, {value: 'No', label: 'No'} ],
					onChange: ( value ) => { props.setAttributes( { sidebar: value } ); },
				} ),
				el( SelectControl, {
					label: Localize( 'Starting Layout', 'ultimate-product-catalogue' ),
					value: props.attributes.starting_layout,
					options: [ {value: 'Thumbnail', label: 'Thumbnail'}, {value: 'Detail', label: 'Detail'}, {value: 'List', label: 'List'} ],
					onChange: ( value ) => { props.setAttributes( { starting_layout: value } ); },
				} ),
				el( TextControl, {
					label: Localize( 'Excluded Layouts (e.g. "List" or "Thumbnail,List")', 'ultimate-product-catalogue' ),
					value: props.attributes.excluded_layouts,
					onChange: ( value ) => { props.setAttributes( { excluded_layouts: value } ); },
				} )
			),
		);
		returnString.push( el( ServerSideRender, { 
			block: 'ultimate-product-catalogue/ewd-upcp-display-catalog-block',
			attributes: props.attributes
		} ) );
		return returnString;
	},

	save: function() {
		return null;
	},
} );


