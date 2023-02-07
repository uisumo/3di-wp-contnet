<div class="tweetdis_settings_wrap tweetdis_clearfix">
    
    
    <div class="tweetdis_left">
        
            <h3>Preview:</h3>
            <div class="box_preview">
                
                <?php
                    $hint = new Tweetdis_Hint(Tweetdis_Settings::get_instance()->get_demo('hint'), array(), 'tweet_dis');
                ?>
                
                <p>Don't read this text. It is here just to represent <?= $hint->display(true) ?>
                </p>
            </div>
        
    </div>
    
    
    <div class="tweetdis_left form_settings">
        
            <h3>Settings:</h3>

            <div class="tweetdis_form_row tweetdis_clearfix">
                <label for="hint_design">Type:</label>

                <span id="hint_design" class="tweetdis_select_template">
                    <div class="select">
                        <select>

                            <?php
                                $hint_types = array('background', 'underline', 'highlight');
                                for ($i=0; $i < count($hint_types); $i++) {

                                    $selected = ( $settings['style'] === $hint_types[$i] )? ' selected':'';
                                    echo '<option value=' . $hint_types[$i].$selected . '>' . ucfirst($hint_types[$i]) . '</option>';

                                }

                            ?>

                        </select>
                    </div>
                </span>

            </div>

            <div class="tweetdis_form_row tweetdis_clearfix colors">
                <label for="color">Color:</label>
                <div id="color">

                    <?php

                        for ($i = 1; $i <= 3; $i++) {
                            $selected = ($i === $settings['color'])? ' selected':'';
                            echo '<span class="color_select color_' . $i . ' ' .  $selected . '" data-color="' . $i . '"></span>';
                        }

                    ?>

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
        <img src="<?= Tweetdis_Settings::get_instance()->get_images_url() ?>box_screen.png" alt="tweet box"/>
    </div>
    
    <div class="tweetdis_left">
        <h3>Add Tweet Box in "Text editor":</h3>
        <p>Wrap any piece of text with this shortcode.</p>
        <p class="tweetdis_shortcode"><span>[tweet_dis]</span> your text goes here <span>[/tweet_dis]</span></p>
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
    
    function toggle_colors() {
        
        if (request.style === 'background') {
            $j('.colors').css('visibility', 'visible');
        }
        else {
            $j('.colors').css('visibility', 'hidden');
        }
    }
    
    var request = {
        action: 'tweetdis_save_settings',
        tabs: 'hint',
        style: $j('#hint_design option:selected').attr('value'),
        color: '<?= $settings['color'] ?>',
    };
    
    toggle_colors();
    
    $j('#hint_design .options li').on('click', function() {
        $j('.tweetdis_hint a').removeClass('type_' + request.style);
        request.style = $j(this).attr('data-value');
        toggle_colors();
        $j('.tweetdis_hint a').addClass('type_' + request.style);
    });
    
    $j('#color .color_select').on('click', function() {
        $j('#color .color_select').removeClass('selected');
        $j('.tweetdis_hint > a').removeClass('color_' + request.color);
        request.color = $j(this).attr('data-color');
        $j(this).addClass('selected');
        $j('.tweetdis_hint > a').addClass('color_' + request.color);
    });
    
    $j('#save_settings').on('click', function() {
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
    });
</script>