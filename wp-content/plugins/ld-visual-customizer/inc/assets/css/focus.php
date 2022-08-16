<?php

$focus_mode_width = get_option( 'lds_focus_content_width' );
if( $focus_mode_width && $focus_mode_width !== 'default' ): ?>
    .learndash-wrapper .ld-focus .ld-focus-main .ld-focus-content {
        max-width: <?php echo $focus_mode_width; ?>;
    }
<?php
endif;
