<?php

/**
 * The HTML mark-up to display our core PDF page
 *
 * @package     Gravity PDF
 * @copyright   Copyright (c) 2023, Blue Liquid Designs
 * @license     http://opensource.org/licenses/gpl-2.0.php GNU Public License
 * @since       4.0
 */

/* Exit if accessed directly */
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * @var $form    array
 * @var $classes string
 * @var $page    string
 */

?>

<div class="row-separator">
	<h3 class="gfpdf-page gfpdf-field <?php echo esc_attr( $classes ); ?>">
		<?php echo esc_html( $form['pagination']['pages'][ $page ] ); ?>
	</h3>
</div>
