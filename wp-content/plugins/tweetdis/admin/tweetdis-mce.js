(function() {
    tinymce.PluginManager.add('tweetdis', function (editor, url) {
        
        editor.addButton('tweetdis', {
            title: 'Tweet',
            image: url + '/../assets/images/icon.png',
            onclick: function() {
                
                    $j = jQuery.noConflict();
                
                    $j('body').append(
                        '<div class="tweetdis_modal_fade"></div>'
                        + '<div class="tweetdis_modal">'
                        + '<div class="tweetdis_modal_header">TweetDis</div>'
                
                        + '<div class="tweetdis_modal_content">'
                
                        /* Entity select */
                        + '<div class="tweetdis_modal_group">'
                        + '<label for="entity_select">Add:</label>'
                        + '<select id="entity_select">'
                        + '<option selected value="tweet_box">Box</option>'
                        + '<option value="tweet_dis">Hint</option>'
                        + '<option value="tweet_dis_img">Image</option>'
                        + '</select>'
                        + '</div>'
                
                        /* Box select */
                        + '<div class="tweetdis_modal_group box_select">'
                        + '<label for="box_select">Design:</label>'
                        + '<select id="box_select">'
                        + '<option selected value="default">Default template</option>'
                        + '<option value="box_01">Template 1</option>'
                        + '<option value="box_02">Template 2</option>'
                        + '<option value="box_03">Template 3</option>'
                        + '<option value="box_04">Template 4</option>'
                        + '<option value="box_05">Template 5</option>'
                        + '<option value="box_06">Template 6</option>'
                        + '<option value="box_07">Template 7</option>'
                        + '<option value="box_08">Template 8</option>'
                        + '<option value="box_09">Template 9</option>'
                        + '<option value="box_10">Template 10</option>'
                        + '<option value="box_11">Template 11</option>'
                        + '<option value="box_12_at">Authority Template 1</option>'
                        + '<option value="box_13_at">Authority Template 2</option>'
                        + '<option value="box_14_at">Authority Template 3</option>'
                        + '<option value="box_15_at">Authority Template 4</option>'
                        + '<option value="box_16_at">Authority Template 5</option>'
                        + '</select>'
                        + '</div>'
                
                        /* Authority templates options */
                        + '<div class="tweetdis_modal_group authority_template_options">'
                        + '<label for="at_author">Author Name:</label>'
                        + '<input type="text" id="at_author"/>'
                        + '<label for="at_pic_url" class="at_pic_url">Picture URL:</label>'
                        + '<input type="text" id="at_pic_url" class="at_pic_url"/>'
                        + '<label class="tweetdis_modal_link at_pic_url">Show media library</label>'
                        + '</div>'
                
                        /* Float select */
                        + '<div class="tweetdis_modal_group float_select">'
                        + '<label for="float_select">Float:</label>'
                        + '<select id="float_select">'
                        + '<option selected value="none">None</option>'
                        + '<option value="left">Left</option>'
                        + '<option value="right">Right</option>'
                        + '</select>'
                        + '</div>'
                
                        /* Width select */
                        + '<div class="tweetdis_modal_group width_select">'
                        + '<label for="width_select">Width:</label>'
                        + '<select id="width_select">'
                        + '<option selected value="40%">40%</option>'
                        + '<option value="50%">50%</option>'
                        + '<option value="60%">60%</option>'
                        + '</select>'
                        + '</div>'
                
                        /* URL select */
                        + '<div class="tweetdis_modal_group">'
                        + '<label for="url_select">URL to tweet:</label>'
                        + '<select id="url_select">'
                        + '<option selected value="default">This Article</option>'
                        + '<option value="custom">Custom URL</option>'
                        + '</select>'
                        + '</div>'
                
                        + '<div class="tweetdis_modal_group url_input">'
                        + '<label for="url_input">Specify the URL:</label>'
                        + '<input type="text" id="url_input" />'
                        + '</div>'
                
                        /* Hidden text select */
                        + '<div class="tweetdis_modal_group">'
                        + '<label for="hidden_text_select">Inject hidden text:</label>'
                        + '<select id="hidden_text_select">'
                        + '<option selected value="0">No</option>'
                        + '<option value="1">Yes</option>'
                        + '</select>'
                        + '</div>'
                
                        + '<div class="tweetdis_modal_group hidden_text_textarea">'
                        + '<label>Text to inject:</label>'
                        + '<textarea id="hidden_text_textarea" rows="3" cols="21">'
                        + '</textarea>'
                        + '</div>'
                
                        /* Custom text select */
                        + '<div class="tweetdis_modal_group custom_text_select">'
                        + '<label for="custom_text_select">Custom tweet text:</label>'
                        + '<select id="custom_text_select">'
                        + '<option selected value="0">No</option>'
                        + '<option value="1">Yes</option>'
                        + '</select>'
                        + '</div>'
                
                        + '<div class="tweetdis_modal_group custom_text_textarea">'
                        + '<label>Custom tweet:</label>'
                        + '<textarea id="custom_text_textarea" rows="3" cols="21">'
                        + '</textarea>'
                        + '</div>'
                        
                        /* End content */
                        + '</div>'
                
                        + '<div class="tweetdis_modal_footer">'
                        + '<a class="tweetdis_modal_cancel">Cancel</a>'
                        + '<a class="tweetdis_modal_confirm">OK</a>'
                        + '</div>'
                        
                        /* End modal */
                        + '</div>');


                    var modal = $j('.tweetdis_modal'),
                        modal_fade = $j('.tweetdis_modal_fade');

                    /*
                     * Margin between form elements 15px
                     */
                    function open_if_hidden(selector) {
                        
                            var element = modal.find(selector);
                        
                            if (element.is(':hidden')) {
                                element.show();
                                modal.height(modal.height() + element.height() + 15);
                            }
                    }
                    
                    function close_if_visible(selector) {
                             
                            var element = modal.find(selector);
                            
                            if (element.is(':visible')) {
                                modal.height(modal.height() - element.height() - 15);
                                element.hide();
                            }
                    }
                    
                    function toggle_at_options(design) {
                            
                            if (design.indexOf('_at') > -1) {
                                open_if_hidden('.authority_template_options');
                                
                                if (design === 'box_16_at') {
                                    close_if_visible('.at_pic_url');      
                                }
                                else {
                                    open_if_hidden('.at_pic_url'); 
                                }
                            }
                            else {
                                close_if_visible('.authority_template_options');
                            }  
                    }
                    
                    function toggle_width(float) {
                            
                            if (float !== 'none') {
                                open_if_hidden('.width_select');
                            }
                            else {
                                close_if_visible('.width_select');
                            }  
                    }
                    
                    function toggle_custom_text_textarea(custom) {
                        
                            if (custom != '0') {
                                open_if_hidden('.custom_text_textarea');
                            }
                            else {
                                close_if_visible('.custom_text_textarea');
                            }
                        
                    }
                    
                    function get_value_if_visible(element, param_name) {
                            
                            if (element.is(':visible') && element.val() != '') {
                                return ' ' + param_name + "=\"" + element.val() + "\"";
                            }
                            return '';
                    }
                    
                    function close_modal() {
                            modal.remove();
                            modal_fade.remove();
                    }
                    
                    
                    /* Tweetdis entity select */
                    modal.find('#entity_select').on('change', function() {
                       
                            if ($j(this).val() === 'tweet_dis') {

                                close_if_visible('.box_select');        
                                close_if_visible('.authority_template_options');
                                close_if_visible('.float_select');
                                close_if_visible('.width_select');                            
                                open_if_hidden('.custom_text_select');
                                
                                toggle_custom_text_textarea(modal.find('#custom_text_select').val());

                            }

                            else if ($j(this).val() === 'tweet_dis_img') {

                                close_if_visible('.box_select');        
                                close_if_visible('.authority_template_options');
                                close_if_visible('.float_select');
                                close_if_visible('.width_select');
                                close_if_visible('.custom_text_select');
                                close_if_visible('.custom_text_textarea');

                            }

                            else if ($j(this).val() === 'tweet_box') {

                                open_if_hidden('.box_select');
                                open_if_hidden('.float_select');
                                open_if_hidden('.custom_text_select');
                                
                                toggle_at_options(modal.find('#box_select').val());
                                toggle_width(modal.find('#float_select').val());
                                toggle_custom_text_textarea(modal.find('#custom_text_select').val());

                            }
                        
                    });
                    
                    
                    /* Box design select */
                    modal.find('#box_select').on('change', function() {
                            toggle_at_options($j(this).val());
                    });
                    
                    /* Float select */
                    modal.find('#float_select').on('change', function() {
                            toggle_width($j(this).val());
                    });
                    
                    /* URL select */
                    modal.find('#url_select').on('change', function() {
                            
                            if ($j(this).val() !== 'default') {
                                open_if_hidden('.url_input');
                            }
                            else {
                                close_if_visible('.url_input');
                            }
                    });
                    
                    /* Hidden text select */
                    modal.find('#hidden_text_select').on('change', function() {
                            
                            if ($j(this).val() != '0') {
                                open_if_hidden('.hidden_text_textarea');
                            }
                            else {
                                close_if_visible('.hidden_text_textarea');
                            }
                    });
                             
                    /* Custom text select */
                    modal.find('#custom_text_select').on('change', function() {      
                            toggle_custom_text_textarea($j(this).val());
                    });
                    
                    
                    
                    //Open WP media upload
                    modal.find('.tweetdis_modal_link').on('click', function (event) {

                            event.preventDefault();
                            var frame;
                            var image_url;

                            // If the media frame already exists, reopen it.
                            if (frame) {
                                frame.open();
                                return;
                            }

                            // Create a new media frame
                            frame = window.wp.media({
                                title: 'Select Image for Authority Template',
                                button: {
                                    text: 'Use This Image'
                                },
                                multiple: false
                            });

                            frame.open();

                            frame.on( 'select', function() {
                                // Get media attachment details from the frame state
                                var attachment = frame.state().get('selection').first().toJSON();
                                // Send the attachment URL to our custom image input field.
                                image_url = attachment.url;
                                frame.close();

                                if (typeof (image_url) !== 'undefined') {
                                      modal.find('#at_pic_url').val(image_url);
                                };
                            });
                    });
                    
                    
                    modal.find('.tweetdis_modal_confirm').on('click', function() {
                            
                            var shortcode = {
                                entity: modal.find('#entity_select').val(),
                                design: get_value_if_visible( modal.find('#box_select'), 'design' ),
                                author: get_value_if_visible( modal.find('#at_author'), 'author' ),
                                author_pic: get_value_if_visible( modal.find('#at_pic_url'), 'pic_url' ),
                                float: get_value_if_visible( modal.find('#float_select'), 'float' ),
                                width: get_value_if_visible( modal.find('#width_select'), 'width' ),
                                url: get_value_if_visible( modal.find('#url_input'), 'url' ),
                                hidden: get_value_if_visible( modal.find('#hidden_text_textarea'), 'inject' ),
                                custom: get_value_if_visible( modal.find('#custom_text_textarea'), 'excerpt' )
                            }
                            
                            editor.selection.setContent('[' + shortcode.entity + shortcode.design + shortcode.url +
                                    shortcode.float + shortcode.width + shortcode.author + shortcode.author_pic +
                                    shortcode.hidden + shortcode.custom + ']' + editor.selection.getContent() + '[/' + shortcode.entity + ']');
                                
                            close_modal();
                        
                    });
                                                                          
                                   
                    modal.find('.tweetdis_modal_cancel').on('click', function () {
                            close_modal();
                    });
                 
	    }
        })
    });
    
})();