<?php 
/**
 *  Box View 
 * 
 *  @param bool $settings_page If image is requested by plugin settings page
 *  @param array $box_preset_settings Box preset settings from plugin options
 *  @param array $params Box parameters from shortcode tweetdis_box
 *  @param string $phrase Phrase to tweet
 *  @param string $tweet_link Link for tweet intent
 */

if (!isset($settings_page)) {
    $settings_page = false;
}
?>

<?php if ( strpos($params['design'], '_at') ) :?>

        <div <?= $params['width'] ?> class="tweetdis_box <?= $params['float'] ?> <?= ($box_preset_settings['margin_vertical'] == 'doubled')? 'double_margin':'' ?>">
            <a class="tweetdis_box_link tweetdis_<?= $params['design'] ?> tweetdis_color_<?= $box_preset_settings['color_number'] + 1 ?>" href="#" <?php if (!$settings_page): ?>onclick="window.open('<?=  $tweet_link ?>', '_blank', 'width=500,height=500'); return false;"<?php endif; ?>>
                <div class="tweetdis_clearfix">
                    <div class="tweetdis_img">
                        <img src="<?= $params['author_pic'] ?>" alt="pic">
                    </div>
                    <p class = "tweetdis_font_<?= $box_preset_settings['font_size'] ?>">
                        <span class="tweetdis_wrapper"><?= $phrase ?>
                            <i><?= ($params['design'] === 'box_16_at')? '- ' . $params['author']:'' ?></i>
                        </span>
                        <span class="tweetdis_clearfix">
                            <span class="tweetdis_author"><?= $params['author'] ?></span>
                            <span class="tweetdis_click_to_tweet">
                                <i></i><?= $box_preset_settings['callforaction'] ?>
                            </span>
                        </span>
                    </p>
                </div>
            </a>
        </div>

<?php else :?>

        <div <?= $params['width'] ?> class="tweetdis_box <?= $params['float'] ?> <?= ($box_preset_settings['margin_vertical'] == 'doubled')? 'double_margin':'' ?>">
            <a class="tweetdis_box_link tweetdis_<?= $params['design'] ?> tweetdis_color_<?= $box_preset_settings['color_number'] + 1 ?>" href="#" <?php if (!$settings_page): ?>onclick="window.open('<?=  $tweet_link ?>', '_blank', 'width=500,height=500'); return false;"<?php endif; ?>>
                <p class = "tweetdis_font_<?= $box_preset_settings['font_size'] ?>"><?= $phrase ?></p>
                <span class="tweetdis_clearfix">
                    <span class="tweetdis_click_to_tweet">
                        <i></i><?= $box_preset_settings['callforaction'] ?>
                    </span>
                </span>
            </a>
        </div>

<?php endif; ?>