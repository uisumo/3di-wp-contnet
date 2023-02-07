<?php
$colspan = ( current_user_can($caps) && $display_mine != 'yes' ? '5' : '3' ); ?>
<div id="ldnt-shortcode">

    <div class="ldnt-note-filters">
        <form action="" method="get">
            <input name="search" placeholder="<?php esc_html_e( 'Search for notes...', 'sfwd-lms' ); ?>" type="text" data-list=".notes-listing" class="nt-live-search">
            <div class="ldnt-select-wrap">
                <select id="ldnt-posts-per-page" name="posts_per_page">
                    <?php if( isset($_GET['posts_per_page']) ):
                        $label = $_GET['posts_per_page'] == '-1' ? esc_html( 'All', 'sfwd-lms' ) : $_GET['posts_per_page']; ?>
                        <option value="<?php echo esc_attr($_GET['posts_per_page']); ?>"><?php echo esc_html($label) ?></option>
                        <option value="" disabled>---</option>
                    <?php endif; ?>
                    <option value="25">25</option>
                    <option value="50">50</option>
                    <option value="100">100</option>
                    <option value="-1"><?php esc_html_e( 'All', 'sfwd-lms' ); ?></option>
                </select>
            </div>
            <script>
                jQuery(document).ready(function($) {
                    $('#ldnt-posts-per-page').change(function() {
                        $(this).parent().submit();
                    });
                });
            </script>
        </form>
    </div>

    <form action="" method="get">
        <table class="notes-listing">
            <thead>
                <tr>
                    <th>&nbsp;</th>
                    <th><?php esc_html_e('Notes','sfwd-lms'); ?></th>
                    <?php if( current_user_can($caps) && $display_mine ): ?>
                        <th><?php esc_html_e( 'User', 'sfwd-lms' ); ?></th>
                    <?php endif; ?>
                    <th><?php esc_html_e( 'Date', 'sfwd-lms' ); ?></th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                <?php if( $query->have_posts() ):

                    $cuser = wp_get_current_user();

                    while ( $query->have_posts() ) : $query->the_post();

                        global $post;

                        $original_page_id = get_post_meta( get_the_ID(), 'nt-note-current-lessson-id', true );

                        $title = ldnt_get_note_title( $post->ID, $original_page_id ); ?>

                        <tr>
                            <td><input type="checkbox" name="lds-bulk-action-item[<?php the_ID(); ?>]" value="<?php the_ID(); ?>"></td>
                            <td id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
                                <p><strong><a href="<?php the_permalink(); ?>" <?php echo $new_window; ?>><?php echo esc_html($title); ?></a></strong></p>
                                <p class="nt-location"><?php esc_html_e( 'Location:', 'sfwd-lms' ); ?> <?php echo nt_course_breadcrumbs( get_post_meta( $post->ID, '_nt-course-array', true ) ); ?></p>
                            </td>
                            <?php
                            if( current_user_can($caps) && $display_mine != 'yes' ): ?>
                                <td><small><?php the_author_meta( 'display_name', $post->post_author ); ?></small></td>
                            <?php endif; ?>
                            <td><small><?php echo esc_html( get_the_date(get_option('date_format')) ); ?></small></td>
                            <td style="text-align: right; width: 125px">
                                <a href="#" class="learndash-notes-print-shortcode" data-note="<?php the_ID(); ?>"><i class="nticon-print"></i></a>
                                <a href="<?php the_permalink(); ?><?php echo $download_sep; ?>nt_download_doc=true" target="_new"><i class="nticon-file-word"></i></a>
                                <?php if( $post->post_author == $cuser->ID || current_user_can('delete_others_nt_notes') ): ?>
                                    <a href="#" class="learndash-notes-delete-note" data-note="<?php the_ID(); ?>"><i class="nticon-trash"></i></a>
                                <?php endif; ?>
                            </td>
                        </tr>
                    <?php endwhile;
                else: ?>
                    <tr>
                        <td colspan="5"><p class="ldnt-alert"><?php esc_html_e( 'No notes found', 'sfwd-lms' ); ?></p></td>
                    </tr>
                <?php endif; ?>
            </tbody>
            <tfoot>
                <tr>
                    <td colspan="5">
                        <input type="submit" name="lds-bulk-download" class="lds-bulk-download" value="<?php esc_attr_e( 'Download Selected', 'sfwd-lms' ); ?>" type="submit">
                        <?php if ($query->max_num_pages > 1): // check if the max number of pages is greater than 1  ?>
                            <nav class="ldnt-note-nav">
                                <ul>
                                    <li><?php echo get_next_posts_link( '&laquo; Older Notes', $query->max_num_pages ); // display older posts link ?></li>
                                    <li><?php echo get_previous_posts_link( 'Newer Notes &raquo;' ); // display newer posts link ?></li>
                                </ul>
                            </nav>
                        <?php endif; ?>
                    </td>
                </tr>
            </tfoot>
        </table>
        <?php wp_reset_postdata(); ?>
    </form>
</div>
