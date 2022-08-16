<div class="tweetdis_settings_wrap tweetdis_clearfix">
    
    
    <div class="tweetdis_left">
        
            <h3>Preview:</h3>
            <div class="box_preview">
                <p>Don't read this text. It is here just to represent an example of 
                    any article on your blog. So this is kinda the paragraph of usual
                    text in your article and what you see below is the "tweet box" created by TweetDis plugin.
                </p>

                <?php
                    $image = new Tweetdis_Image(Tweetdis_Settings::get_instance()->get_demo('image'), array(), 'tweet_dis_image');
                    echo $image->display_custom($settings['design']);
                ?>
            </div>
        
    </div>
    
    
    <div class="tweetdis_left form_settings">
        
            <h3>Settings:</h3>

            <div class="tweetdis_form_row tweetdis_clearfix">
                <label for="image_design">Design template:</label>

                <span id="image_design" class="tweetdis_select_template">
                    <div class="select">
                        <select>

                            <?php

                                $designs = Tweetdis_Settings::get_instance()->get_image_presets();
                                for ($i=0; $i < count($designs); $i++) {

                                    $template = 'Template ' . ($i+1);
                                    $selected = ( $settings['design'] === $designs[$i] )? ' selected':'';
                                    echo '<option value=' . $designs[$i].$selected . '>' . $template . '</option>';

                                }

                            ?>

                        </select>
                    </div>
                </span>
            </div>
            
            
            <div class="tweetdis_form_row tweetdis_clearfix">
                <label for="image_txt">Text:</label>

                <span id="image_txt" class="tweetdis_select_template">
                    <div class="select">
                        <select>

                            <?php

                                $image_txt = array('blank', 'post_title', 'image_alt');
                                for ($i=0; $i<count($image_txt); $i++) {

                                    $selected = ($image_txt[$i] === $settings['image_txt'])? ' selected':'';
                                    echo '<option value=' . $image_txt[$i].$selected . '>' . ucfirst( str_replace('_', ' ', $image_txt[$i]) ) . '</option>';

                                }

                            ?>

                        </select>
                    </div>
                </span>
            </div>
            
            
            <?php if ( $settings['design'] !== 'template_5' && $settings['design'] !== 'template_6' ) : ?>
            <div class="tweetdis_form_row tweetdis_clearfix">
                <label for="button_size">Button Size:</label>

                <span id="button_size" class="tweetdis_select_template">
                    <div class="select">
                        <select>

                            <?php

                                $button_size = array('original', 'large');
                                for ($i=0; $i<count($button_size); $i++) {

                                    $selected = ($button_size[$i] === $settings['button_size'])? ' selected':'';
                                    echo '<option value=' . $button_size[$i].$selected . '>' . ucfirst($button_size[$i]) . '</option>';

                                }

                            ?>

                        </select>
                    </div>
                </span>
            </div>
            <?php endif; ?>
            

            <div class="tweetdis_form_row tweetdis_clearfix">
                <label for="position">Position:</label>

                <span id="position" class="tweetdis_select_template">
                    <div class="select">
                        <select>

                            <?php

                                $position = array();
                                
                                if( $settings['design'] === 'template_1' ) {
                                    array_push($position, 'center', 'bottom_right', 'top_right');
                                }
                                else {
                                    array_push($position, 'left', 'right');
                                    
                                    if ( $settings['design'] !== 'template_3' && $settings['design'] !== 'template_4' ) {
                                        array_push($position, 'center');
                                    }                                
                                }

                                for ($i=0; $i<count($position); $i++) {

                                    $selected = ($position[$i] === $settings['position'])? ' selected':'';
                                    echo '<option value=' . $position[$i].$selected . '>' . ucfirst( str_replace('_', ' ', $position[$i]) ) . '</option>';

                                }

                            ?>

                        </select>
                    </div>
                </span>
            </div>
            
            
            <div class="tweetdis_form_row tweetdis_clearfix">
                <label for="hover_action">Hover action:</label>

                <span id="hover_action" class="tweetdis_select_template">
                    <div class="select">
                        <select>

                            <?php

                                $hover_action = array('no_hover_action', 'light', 'dark', 'pattern');
                                if( $settings['design'] === 'template_1' ) {
                                    array_push($hover_action, 'zoom');
                                }
                                
                                for ($i=0; $i<count($hover_action); $i++) {

                                    $selected = ($hover_action[$i] === $settings['hover_action'])? ' selected':'';
                                    echo '<option value=' . $hover_action[$i].$selected . '>' . ucfirst( str_replace('_', ' ', $hover_action[$i]) ) . '</option>';

                                }

                            ?>

                        </select>
                    </div>
                </span>
            </div>

            <div class="tweetdis_form_row tweetdis_clearfix">
                <label for="action">Call to action:</label>

                <div class="input_wrap">
                    <input type="text" id="action" value="<?= $settings['callforaction'] ?>"/>
                    <p class="input_comment">We recommend you to use short phrases</p>
                </div>

            </div>
            

            <div class="tweetdis_form_row tweetdis_clearfix reduced_margin tweetdis_text_right">
                <button id="save_settings" class="tweetdis_button">Save All Changes</button>
                <p class="input_comment saved"></p>
            </div>
        
    </div>
    
</div>
<!-- tweetdis_settings_wrap -->

<div class="tweetdis_settings_wrap tweetdis_clearfix">

    <div class="tweetdis_left">
        <h3>Add Tweet Box in "Visual editor":</h3>
        <img src="<?= Tweetdis_Settings::get_instance()->get_images_url() ?>img_screen.png" alt="tweet box"/>
    </div>
    
    <div class="tweetdis_left">
        <h3>Add Tweet Box in "Text editor":</h3>
        <p>Wrap any piece of text with this shortcode.</p>
        <p class="tweetdis_shortcode"><span>[tweet_dis_img]</span>&lt;img src="http://tweetdis.com/img.png" alt="TD"&gt;<span>[/tweet_dis_img]</span></p>
    </div>
    
</div>
<!-- tweetdis_settings_wrap -->

<script type="text/javascript" data-cfasync="false">
    var $j = jQuery.noConflict();
    
    
    /* Styled select */
    
    $j('.tweetdis_select_template').each(function () {
        var lists = '';
        $j(this).children('.select').each(function () {
                lists = '';
                var options = $j(this).find('select option');
                var selectText = $j(this).find('select option:selected').text();

                options.each(function(){
                        lists += '<li data-value='+$j(this).val()+'>'+$j(this).text()+'</li>';
                });
                $j(this).after('<ul class="options">'+lists+'</ul>').after("<div class='styled_select'>"+selectText+"</div>");
        });						
    });
    
    $j('.tweetdis_select_template').click(function (e) {
            e.stopPropagation();
            $j(this).find('.options').show();
    });

    $j(document).click(function () {
            $j('.options').hide();
    });

    $j('ul.options li').click(function (e) {
            e.stopPropagation();
            var list_text = $j(this).text();
            $j(this).parent().hide();
            $j(this).parent().parent().find('.styled_select').text(list_text);
    });
    
    
    /* Get preview */
    
    function tweetdis_image_request(request) {
        $j.ajax({
            type: 'POST',
            url: Td_Ajax.ajaxurl,
            data: request,
            success: function (msg) {
                $j('#tweetdis_preview').html(msg);
            }
        });
    }
    
    var request = {
        action: 'tweetdis_get_preview',
        tabs: 'image',
        design: $j('#image_design option:selected').attr('value'),
        callforaction: '<?= $settings['callforaction'] ?>',
        hover_action: '<?= $settings['hover_action'] ?>',
        image_txt: '<?= $settings['image_txt'] ?>',
        button_size: '<?= $settings['button_size'] ?>',
        position: '<?= $settings['position'] ?>',
    };
    
    var click_to_tweet = $j('.tweetdis_click_to_tweet');
    
    $j('#image_design .options li').on('click', function() {
        request.design = $j(this).attr('data-value');
        tweetdis_image_request(request);
    });
    
    $j('#image_txt .options li').on('click', function() {
        request.image_txt = $j(this).attr('data-value');
    });
    
    $j('#button_size .options li').on('click', function() {
        request.button_size = $j(this).attr('data-value');
        if ( request.button_size === 'original' && click_to_tweet.hasClass('twitter_large') ) {
            click_to_tweet.removeClass('twitter_large');
        }
        else if ( request.button_size === 'large' && !click_to_tweet.hasClass('twitter_large') ) {
            click_to_tweet.addClass('twitter_large');
        }
    });
    
    $j('#position .options li').on('click', function() {
        click_to_tweet.removeClass('position_' + request.position);
        request.position = $j(this).attr('data-value');
        click_to_tweet.addClass('position_' + request.position);        
    });
    
    $j('#hover_action .options li').on('click', function() {
        $j('.tweetdis_image').removeClass('tweetdis_hover_' + request.hover_action);
        request.hover_action = $j(this).attr('data-value');
        $j('.tweetdis_image').addClass('tweetdis_hover_' + request.hover_action);       
    });
    
    
    $j('#action').on('input', function() {
       request.callforaction = $j(this).val();
       $j('.tweetdis_action').html(request.callforaction);
    });
    
    $j('#save_settings').on('click', function() {
        
        request.action = 'tweetdis_save_settings';

        $j.ajax({
            type: 'POST',
            url: Td_Ajax.ajaxurl,
            data: request,
            success: function (msg) {
                $placeholder = $j('#save_settings').next('.input_comment');
                $placeholder.html(msg);
                setTimeout (function() {
                    $placeholder.html('');
                }, 3000);
            }
        });
        
        request.action = 'tweetdis_get_preview';
    });
</script>