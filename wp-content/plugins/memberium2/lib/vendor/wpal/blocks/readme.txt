//Know Issues

1) Elementor - New page blocks not getting settings until after save and refresh
The action 'elementor/element/after_section_end' is not being called.
Think we need to add a check for AJAX and be sure to load the admin file.

2) Gutenberg - If you have no Tags (Keys) the JS has issues that need to be resolved because it's trying to loop through them
ES6 functions do not like that and causing errors in Gutenberg editor


/**
 * Available Filters
*/

/**
 * Control Config
 * @param array $controls 	Settings Config Array
 * @return array
*/
add_filter( 'wpal/blocks/{$builder_slug}/control/config/', 'gutenberg_control_config' 10, 1 );


/**
 * Omitted Blocks
 * @param array Block Slugs Identifiers for each specific block in builder
 * @return array
*/
add_filter( 'wpal/blocks/{$builder_slug}/settings/omitted_blocks', 'gutenberg_ommited_blocks' 10, 1 );

/**
 * Elementor Container Widgets
 * @param string $shortcode 	The Shortcode being added
 * @param array $settings		The Elementor defined settings
 * @return string $shortcode
*/
add_filter( 'wpal/blocks/elementor/editor/container_slugs', 'elementor_shortcode_render' 10, 2 );

/**
 * Elementor Widget Args
 * @param array $controls 		Current Control Settings
 * @param string $name			Control Name
 * @param object $widget 		The current widget object
 * @param string $widget_id		The current widget id
 * @param array $args			The current widget settings
 * @return array $controls
*/
add_filter( 'wpal/blocks/elementor/editor/control/args', 'elementor_control_args' 10, 5 );

/**
 * Elementor Shortcode Widget Render
 * @param string $shortcode 	The Shortcode being added
 * @param array $settings		The Elementor defined settings
 * @return string $shortcode
*/
add_filter( 'wpal/blocks/elementor/widget/shortcode/render', 'elementor_shortcode_render' 10, 2 );



/**
 * Beaver Builder Module Args
 * @param array $control 		Current Control Settings
 * @param string $name			Control Name
 * @param string $type			Control Type
 * @param string $slug 			The current module slug
 * @return array $control
*/
add_filter( 'wpal/blocks/beaver_builder/editor/control/args', 'beaver_builder_control_args' 10, 4 );
