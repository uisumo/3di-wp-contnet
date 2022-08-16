<div class="tweetdis_settings_wrap tweetdis_clearfix">
    
    
    <div class="tweetdis_left">
        
            <h3>Preview:</h3>
            <div class="box_preview">
                <p>Don't read this text. It is here just to represent an example of 
                    any article on your blog. So this is kinda the paragraph of usual
                    text in your article and what you see below is the "tweet box" created by TweetDis plugin.
                </p>

                <?php
      
                    $box = new Tweetdis_Box(Tweetdis_Settings::get_instance()->get_demo('box'), $params, 'tweet_box');
                    echo $box->display_custom($settings);
                ?>
                
            </div>
        
    </div>
    
    
    <div class="tweetdis_left form_settings">
        
            <h3>Settings:</h3>

            <div class="tweetdis_form_row tweetdis_clearfix">
                <label for="box_design">Design template:</label>

                <span id="box_design" class="tweetdis_select_template">
                    <div class="select">
                        <select>

                            <?php

                                $designs = Tweetdis_Settings::get_instance()->get_box_presets();
                                $template_number = 1;
                                $first_at = false;
                                for ($i=0; $i < count($designs); $i++) {

                                    if ( !$first_at && stripos($designs[$i], '_at') ) {
                                        $first_at = true;
                                        $template_number = 1;
                                    }
                                    $template = ( stripos($designs[$i], '_at') ) ? 'Authority Template ' . $template_number : 'Template ' . $template_number;
                                    $template_number++;                            
                                    
                                    $selected = ( $params['design'] === $designs[$i] )? ' selected':'';
                                    echo '<option value=' . $designs[$i].$selected . '>' . $template . '</option>';

                                }

                            ?>

                        </select>
                    </div>
                </span>

            </div>

            <?php if ($params['design'] !== 'box_15_at') : ?>
            <div class="tweetdis_form_row tweetdis_clearfix">
                <label for="action">Call to action:</label>

                <div class="input_wrap">
                    <input type="text" id="action" value="<?= $settings['callforaction'] ?>"/>
                    <p class="input_comment">We recommend you to use short phrases</p>
                </div>

            </div>
            <?php endif; ?>

            <?php if (count ($settings['colors'])  > 0) : ?>  
            <div class="tweetdis_form_row tweetdis_clearfix">
                <label for="color">Color:</label>
                <div id="color">

                    <?php
                        $i = 0;
                        foreach ($settings['colors'] as $value) {
                            $selected = ($i === $settings['color_number'])? ' selected':'';
                            echo '<span class="color_select' . $selected . '" style="background-color:' . $value . '" data-color="' . $i . '"></span>';
                            $i++;
                        }

                    ?>

                </div>
            </div>
            <?php endif; ?>

            
            <div class="tweetdis_form_row tweetdis_clearfix">
                <label for="margin">Vertical margin:</label>

                <span id="margin" class="tweetdis_select_template">
                    <div class="select">
                        <select>

                            <?php

                                $margins = array('default', 'doubled');
                                for ($i=0; $i<count($margins); $i++) {

                                    $selected = ($margins[$i] === $settings['margin_vertical'])? ' selected':'';
                                    echo '<option value=' . $margins[$i].$selected . '>' . ucfirst($margins[$i]) . '</option>';

                                }

                            ?>
                        </select>
                    </div>
                </span>
            </div>

            <?php if ( !stripos($params['design'], '_at') ) : ?>  
            <div class="tweetdis_form_row tweetdis_clearfix font">
                <label for="font">Font size:</label>

                <span id="font" class="tweetdis_select_template">
                    <div class="select">
                        <select>

                            <?php

                                $fonts = array('original', 'bigger', 'smaller');
                                for ($i=0; $i<count($fonts); $i++) {

                                    $selected = ($fonts[$i] === $settings['font_size'])? ' selected':'';
                                    echo '<option value=' . $fonts[$i].$selected . '>' . ucfirst($fonts[$i]) . '</option>';

                                }

                            ?>
                        </select>
                    </div>
                </span>
            </div>
            <?php endif; ?>
            
            <?php if ( stripos($params['design'], '_at') ) : ?>  
            <div class="tweetdis_form_row tweetdis_clearfix">
                <label for="author">Author:</label>
                <input type="text" id="author" value="<?= $params['author'] ?>"/>
            </div>
            <?php endif; ?>
                 
            <?php if ( stripos($params['design'], '_at') && $params['design'] !== 'box_16_at' ) : ?>  
            <div class="tweetdis_form_row tweetdis_clearfix reduced_margin">
                <label for="author_pic">Picture:</label>

                <div class="input_wrap">
                    <input type="text" id="author_pic" value="<?= $params['author_pic'] ?>"/>
                    <button id='tweetdis_picbutton' class='tweetdis_button'>Change author's picture</button>
                </div>           

            </div>
            <?php endif; ?>

            <div class="tweetdis_form_row tweetdis_clearfix reduced_margin">
                <input type="checkbox" id="default" <?= ($settings['default'])? 'checked':'' ?>/>
                <label for="default">Make this template default</label>
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
        <img src="<?= Tweetdis_Settings::get_instance()->get_images_url() ?>box_screen.png" alt="tweet box"/>
    </div>
    
    <div class="tweetdis_left">
        <h3>Add Tweet Box in "Text editor":</h3>
        <p>Wrap any piece of text with this shortcode.</p>
        <p class="tweetdis_shortcode"><span>[tweet_box]</span> your text goes here <span>[/tweet_box]</span></p>
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
    
    function tweetdis_box_request(request) {
        $j.ajax({
            type: 'POST',
            url: Td_Ajax.ajaxurl,
            data: request,
            success: function (msg) {
                $j('#tweetdis_preview').html(msg);
            }
        });
    }
    
    function change_pic_url() {
        request.author_pic = $j('#author_pic').val();
        $j('.tweetdis_box img').attr('src', request.author_pic);
    }
    
    var request = {
        action: 'tweetdis_get_preview',
        tabs: 'box',
        design: $j('#box_design option:selected').attr('value'),
        callforaction: '<?= $settings['callforaction'] ?>',
        font_size: '<?= $settings['font_size'] ?>',
        color_number: '<?= $settings['color_number'] ?>',
        margin_vertical: '<?= $settings['margin_vertical'] ?>',
        author: '<?= $params['author'] ?>',
        author_pic: '<?= $params['author_pic'] ?>',
        default: '<?= $settings['default'] ?>'
    };
    
    
    $j('#box_design .options li').on('click', function() {
        request.design = $j(this).attr('data-value');
        tweetdis_box_request(request);
    });
    
    $j('#action').on('input', function() {
       request.callforaction = $j(this).val();
       $j('.tweetdis_box .tweetdis_click_to_tweet').html('<i></i>' + request.callforaction);
    });
    
    $j('#color .color_select').on('click', function() {
        $j('#color .color_select').removeClass('selected');
        $j('.tweetdis_box_link').removeClass('tweetdis_color_' + (+request.color_number + 1));
        request.color_number = $j(this).attr('data-color');
        $j(this).addClass('selected');
        $j('.tweetdis_box_link').addClass('tweetdis_color_' + (+request.color_number + 1));
    });
    
    $j('#margin .options li').on('click', function() {
        request.margin_vertical = $j(this).attr('data-value');
        if ( request.margin_vertical === 'default' && $j('.tweetdis_box').hasClass('double_margin') ) {
            $j('.tweetdis_box').removeClass('double_margin')
        }
        
        if ( request.margin_vertical === 'doubled' && !($j('.tweetdis_box').hasClass('double_margin')) ) {
            $j('.tweetdis_box').addClass('double_margin')
        }
    });
    
    $j('#font .options li').on('click', function() {
        $j('.tweetdis_box p').removeClass('tweetdis_font_' + request.font_size);
        request.font_size = $j(this).attr('data-value');
        $j('.tweetdis_box p').addClass('tweetdis_font_' + request.font_size);
    });
    
    $j('#author').on('input', function() {
       request.author = $j(this).val();
       $j('.tweetdis_box .tweetdis_author').text(request.author);
    });
    
    $j('#author_pic').on('input', function() {
        change_pic_url();
    });
    
    $j('#tweetdis_picbutton').on('click', function(e) {
        e.preventDefault();

        // Create a new media frame
        var frame = window.wp.media({
            title: 'Select Default Image for Authority Template',
            button: {
                text: 'Use This Image'
            },
            multiple: false
        });

        frame.open();
        
        // When an image is selected in the media frame
        frame.on( 'select', function() {
            // Get media attachment details from the frame state
            var attachment = frame.state().get('selection').first().toJSON();
            // Send the attachment URL to image url input field.
            var image_url = attachment.url;
            frame.close();
            if (typeof (image_url)!=='undefined') {
                
                $j('#author_pic').val(image_url);
                change_pic_url();
                
            };
        });
    });
    
    $j('#save_settings').on('click', function() {
        
        request.action = 'tweetdis_save_settings';

        if ($j('#default').prop('checked') === true) {
             request.default = true;
        }

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