<div class="tweetdis_settings_wrap tweetdis_clearfix">
    

    <div class="tweetdis_left">
        
            <h3>Preview:</h3>
            <div class="box_preview tweet">
                
                <div class="box_example">
                    
                    <div class="tweetdis_clearfix">
                        <div class="tweetdis_left">
                            <img src="<?= Tweetdis_Settings::get_instance()->get_images_url() ?>timface.jpeg" alt="author"/>
                            <p><strong>Tim Soulo</strong></p>
                            <span>@timsoulo</span>
                        </div>

                        <div class="tweetdis_right">
                            <img src="<?= Tweetdis_Settings::get_instance()->get_images_url() ?>tweet_btns.png" alt="btns"/>
                        </div>
                    </div>
                    
                    <p id="box_example_text">
                        <i class="preposition_before"></i><span>TweetDis is an awesome plugin for Wordpress, that makes any phrase "tweetable".</span>
                        <a href="#" target="_blank"></a><i class="preposition_after"></i>
                    </p>
                    
                    <img src="<?= Tweetdis_Settings::get_instance()->get_images_url() ?>tweet_links.png" alt="links"/>
                    
                </div>
                
            </div>
        
    </div>
    
    
    <div class="tweetdis_left form_settings">
        
            <h3>Settings:</h3>

            <div class="tweetdis_form_row tweetdis_clearfix">
                <label for="preposition">Preposition:</label>
                
                <div class="input_wrap">
                    <input type="radio" name="preposition" value="RT">
                    <label>RT</label>
                    <input type="radio" name="preposition" value="by">
                    <label>by</label>
                    <input type="radio" name="preposition" value="via">
                    <label>via</label>                 
                     <input type="radio" name="preposition" value="none">
                    <label>none</label>                   
                </div>
            </div>

            <div class="tweetdis_form_row tweetdis_clearfix">
                <label for="twitter">Default twitter account:</label>
                <input type="text" id="twitter" value="<?= $settings['twitter'] ?>"/>
            </div>
            
            <div class="tweetdis_form_row tweetdis_clearfix">
                <label for="follow">Recommend to follow:</label>
                <input type="text" id="follow" value="<?= $settings['follow'] ?>"/>
            </div>
            
            <div class="tweetdis_form_row tweetdis_clearfix">
                <label for="shortener">Default Url Shortener:</label>
                
                <div class="input_wrap">
                    <input type="radio" name="shortener" value="bitly">
                    <label>Bit.ly</label>
                    <input type="radio" name="shortener" value="tinyurl">
                    <label>Tiny URL</label>
                    <input type="radio" name="shortener" value="raw">
                    <label>Raw URL</label>                              
                </div>
            </div>
            
            <div class="tweetdis_form_row tweetdis_clearfix bitly">
                <input type="text" id="bitly_login" value="<?= $settings['bitly_account'] ?>" placeholder="login"/>
                <input type="password" id="bitly_password" value="" placeholder="password"/>
                <p id="bitly_status"></p>
                <button id="bitly_connect" class="tweetdis_button">Login</button>
            </div>
        
            <div class="tweetdis_form_row tweetdis_clearfix reduced_margin tweetdis_text_right">
                <button id="save_settings" class="tweetdis_button">Save All Changes</button>
                <p class="input_comment saved"></p>
            </div>
        
    </div>

</div>
<!-- tweetdis_settings_wrap -->

<script type="text/javascript" data-cfasync="false">
    var $j = jQuery.noConflict();
    
    
    /* Get preview */
    
    function toggle_inputs() {
        $j('input[value="' + request.preposition +'"]').attr('checked', 'true');
        $j('input[value="' + request.shortener +'"]').attr('checked', 'true');
        var bitly = $j('.bitly');
        
        if (request.shortener === 'bitly') {
            bitly.show();
            check_bitly_status();
        }
        else {
            bitly.hide();
        }
    }
    
    function check_bitly_status() {
        var bitly = $j('.bitly');
        
        if (request.bitly_token !== '') {
            bitly.find('input').hide();
            bitly.find('p').text('Bit.ly account in use: ' + request.bitly_account);
            $j('#bitly_connect').text('Logout');
        }
        else {
            bitly.find('input').show();
            bitly.find('p').text('');
            $j('#bitly_connect').text('Login');
        }
        
    }
    
    function show_preposition() {
        
        $tweet = $j('#box_example_text');
        $tweet.find('i').html('');
        
        if (request.twitter.length > 0) {
            
            switch (request.preposition) {

                case 'RT': $tweet.find('.preposition_before').html(request.preposition + ' <span>@'+ request.twitter +'</span> ');
                    break;
                case 'none': $tweet.find('.preposition_after').html(' <span>@' + request.twitter + '</span>');
                    break;
                default:   $tweet.find('.preposition_after').html(' ' + request.preposition +' <span>@' + request.twitter + '</span>');
                    break;
            }
            
        }
    }
    
    function show_link() {
        
        var link = '';
        
        switch (request.shortener) {
            
            case 'bitly': link = "http://bit.ly/1RzspcB";
                break;
            case 'tinyurl': link = "http://tinyurl.com/hwu3lyt";
                break;
            default: link = "http://www.tweetdis.com";
                break;
        }
        
        $j('#box_example_text a').html(link).attr('href', link);
    }
    
    
    var request = {
        action: 'tweetdis_save_settings',
        tabs: 'tweet',
        twitter: '<?= $settings['twitter'] ?>',
        follow: '<?= $settings['follow'] ?>',
        preposition: '<?= $settings['preposition'] ?>',
        shortener: '<?= $settings['shortener'] ?>',
        bitly_token: '<?= $settings['bitly_token'] ?>',
        bitly_account: '<?= $settings['bitly_account'] ?>'
    };
    
    toggle_inputs();
    show_preposition();
    show_link();
    
    $j('input[name="preposition"]').on('change', function() {
        request.preposition = $j('input[name="preposition"]:checked').val();
        show_preposition();
    });
    
    $j('input[name="shortener"]').on('change', function() {
        request.shortener = $j('input[name="shortener"]:checked').val();
        toggle_inputs();
        show_link();
    });
    
    $j('#twitter').on('input', function() {
        request.twitter = $j(this).val();
        show_preposition();
    });
    
    $j('#bitly_connect').on('click', function() {
        
        if ($j(this).text() === "Login") {
        
            var bitly_request = {
                action: 'tweetdis_bitly_token',
                bitly_login: $j('#bitly_login').val(),
                bitly_password: $j('#bitly_password').val()
            };

            $j.ajax({
                type: 'POST',
                url: Td_Ajax.ajaxurl,
                data: bitly_request,
                success: function (msg) {
                    var reply = JSON.parse(msg);
                    if (reply.error) {
                        request.bitly_account = '';
                        request.bitly_token = '';
                        $j('.bitly p').text(reply.error);
                    }
                    if (reply.success) {
                        request.bitly_account = bitly_request.bitly_login;
                        request.bitly_token = reply.success;
                        check_bitly_status();
                    }
                }
            });
            
        }
        else {
            request.bitly_token = '';
            check_bitly_status();
        }
    });
    
    $j('#save_settings').on('click', function() {

        request.follow = $j('#follow').val(); 

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