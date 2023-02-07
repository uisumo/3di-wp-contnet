<?php 
/**
 *  Image View 
 * 
 *  @param bool $settings_page If image is requested by plugin settings page
 *  @param string $image_url Image src
 *  @param string $image_class WP page alignment class
 *  @param array $image_template_name Image template name
 *  @param array $image_template_settings Image template settings
 *  @param string $tweet_link Link for tweet intent
 * 
 */

if (!isset($settings_page)) {
    $settings_page = false;
}
?>
    
<?php if( $image_template_name === 'template_1' || $image_template_name === 'template_2' ): ?>
    
        <div class="tweetdis_clearfix <?= $image_class ?>">
            <figure class="tweetdis_image tweetdis_image_<?= $image_template_name ?> tweetdis_hover_<?= $image_template_settings['hover_action'] ?>">
                    <div class="tweetdis_img_container"><img src="<?= $image_url ?>"/></div>
                    <div class="tweetdis_click_to_tweet twitter_standard <?= ($image_template_settings['button_size'] === 'large')? 'twitter_large':'' ?> position_<?=  $image_template_settings['position'] ?>">  
                        <a class="tweetdis_image_link" href="#" <?php if (!$settings_page): ?>onclick="window.open('<?=  $tweet_link ?>', '_blank', 'width=500,height=500'); return false;"<?php endif; ?>>
                            <i></i><span class="tweetdis_action"><?= $image_template_settings['callforaction'] ?></span>
                        </a>
                    </div>
            </figure>
        </div>
        
<?php elseif ( $image_template_name === 'template_3' || $image_template_name === 'template_4' ): ?>

        <div class="tweetdis_clearfix <?= $image_class ?>">
            <figure class="tweetdis_image tweetdis_image_<?= $image_template_name ?> tweetdis_hover_<?= $image_template_settings['hover_action'] ?>">
                    <div class="tweetdis_img_container"><img src="<?= $image_url ?>"/></div>
                    <div class="tweetdis_click_to_tweet twitter_standard <?= ($image_template_settings['button_size'] === 'large')? 'twitter_large':'' ?> position_<?=  $image_template_settings['position'] ?> tweetdis_clearfix">
                        <a class="tweetdis_image_link" href="#" <?php if (!$settings_page): ?>onclick="window.open('<?=  $tweet_link ?>', '_blank', 'width=500,height=500'); return false;"<?php endif; ?>>
                            <i></i><span>Tweet</span>
                        </a>
                        <span class="tweetdis_action"><?= $image_template_settings['callforaction'] ?></span>
                    </div>
            </figure>
        </div>
         
<?php elseif ( $image_template_name === 'template_5' || $image_template_name === 'template_6' ): ?> 
         
        <div class="tweetdis_clearfix <?= $image_class ?>">
            <figure class="tweetdis_image tweetdis_image_<?= $image_template_name ?> tweetdis_hover_<?= $image_template_settings['hover_action'] ?>">
                    <div class="tweetdis_img_container"><img src="<?= $image_url ?>"/></div>
                    <div class="tweetdis_click_to_tweet position_<?=  $image_template_settings['position'] ?> tweetdis_clearfix">  
                        <a class="tweetdis_image_link" href="#" <?php if (!$settings_page): ?>onclick="window.open('<?=  $tweet_link ?>', '_blank', 'width=500,height=500'); return false;<?php endif; ?>">
                            <i></i><span class="tweetdis_action"><?= $image_template_settings['callforaction'] ?></span>
                        </a>
                    </div>
            </figure>
        </div>
        
<?php endif; ?>