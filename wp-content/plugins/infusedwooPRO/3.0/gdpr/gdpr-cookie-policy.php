<?php  if(!defined('ABSPATH')){exit;}$title=apply_filters('infusedwoo_gdpr_cookie_title','My Cookie Preferences');$utc_intro=get_option('infusedwoo_utc_msg','There were updates to our [link]Terms and Conditions[/link]. Please read and agree to our new terms and conditions.');$$utc_intro=get_option('infusedwoo_tc_msg','I have read and agree to the [link]Terms of Service[/link]');$utc_intro=apply_filters('infusedwoo_tc_msg',$utc_intro);$tc_date=get_option('infusedwoo_tc_date');$intro=get_option('infusedwoo_tc_msg','I have read and agree to the [link]Terms of Service[/link]');$intro=apply_filters('infusedwoo_tc_msg',$intro);$cookie_essential=get_option('infusedwoo_cookie_essential','These cookies are required for the site to perform its core functionalities. This includes cookies allowing you to securely log-in and log-out and make an order through our online shop.');$cookie_functional=get_option('infusedwoo_cookie_functional');$cookie_marketing=get_option('infusedwoo_cookie_marketing');$cookie_level=isset($_COOKIE['iw_cookie_consent'])?$_COOKIE['iw_cookie_consent']:''; ?><!DOCTYPE html><html style="background-color: #eff0f1"> <head> <meta charset="utf-8"> <meta name="viewport" content="width=device-width, initial-scale=1"> <title><?php echo $title; ?></title> <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.4/jquery.min.js"></script> <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bulma/0.7.1/css/bulma.min.css"> <link rel="stylesheet" href="<?php echo INFUSEDWOO_PRO_URL.'/assets/bulma-slider.min.css'; ?>"> <script defer src="https://use.fontawesome.com/releases/v5.0.7/js/all.js"></script> <style type="text/css"> .iwtc-enhanced { position: relative; min-height: 29px; margin-bottom: 8px; margin-top: 8px; } .iwtc-enhanced label.checker { background-color: #fff; border: 1px solid #ccc; border-radius: 50%; cursor: pointer; height: 28px; left: 0; position: absolute; top: 0; width: 28px; margin: 0; } .iwtc-enhanced label.checker:after { border: 2px solid #fff; border-top: none; border-right: none; content: ""; height: 6px; left: 7px; opacity: 0; position: absolute; top: 8px; transform: rotate(-45deg); width: 12px; } .iwtc-enhanced input[type="checkbox"] { visibility: hidden; position: absolute; bottom: 0; left: 0; } .iwtc-enhanced input[type="checkbox"]:checked + label.checker { background-color: #66bb6a; border-color: #66bb6a; } .iwtc-enhanced input[type="checkbox"]:checked + label.checker:after { opacity: 1; } .iwtc-enhanced .label { display: block; margin: 0 0 0 40px; font-size: 14pt; } .cookie-policy { margin-left: 40px; } </style> </head> <body > <section class="section"> <div class="container"> <div class="card" style="width: 700px; margin:auto;"> <header class="card-header"> <p class="card-header-title"> <?php echo $title; ?> </p> </header> <div class="card-content"> <div class="content"> <div class="iwtc iwtc-enhanced"><input type="checkbox" name="iw_cookie_essential" id="iw_cookie_essential" checked disabled /><label class="checker" for="iw_cookie_essential"></label> <label class="label"> Essential Cookies (Required) </label></div> <div class="cookie-policy"> <?php echo $cookie_essential; ?> </div> <br> <?php if(!empty($cookie_functional)){ ?> <div class="iwtc iwtc-enhanced"><input type="checkbox" name="iw_cookie_functional" id="iw_cookie_functional" <?php echo in_array($cookie_level,array('functional','marketing'))?'checked':'' ?> /><label class="checker" for="iw_cookie_functional"></label> <label class="label"> Functional Cookies (Recommended) </label></div> <div class="cookie-policy"> <?php echo $cookie_functional; ?> </div> <br> <?php } ?> <?php if(!empty($cookie_marketing)){ ?> <div class="cookie-block state-blocked"> <div class="iwtc iwtc-enhanced"><input type="checkbox" name="iw_cookie_marketing" id="iw_cookie_marketing" <?php echo in_array($cookie_level,array('marketing'))?'checked':'' ?> /><label class="checker" for="iw_cookie_marketing"></label> <label class="label"> Marketing Cookies </label></div> <div class="cookie-policy"> <?php echo $cookie_marketing; ?> </div> </div> <?php } ?> <div class="notification is-success" style="margin-top: 25px; display:none;"> Successfully Saved Settings </div> </div> <div>  </div> </div> </div> </div> </section> <script type="text/javascript"> jQuery('#iw_cookie_marketing').change(function() { if(jQuery(this).is(':checked')) { jQuery('#iw_cookie_functional').prop('checked', true); } }); jQuery('#iw_cookie_functional').change(function() { if(!jQuery(this).is(':checked')) { jQuery('#iw_cookie_marketing').prop('checked', false); } }); jQuery('input').change(function() { save_pref(); }); function save_pref() { setTimeout(function() { var cookie_level = 'essential'; if(jQuery('#iw_cookie_marketing').is(':checked')) { cookie_level = 'marketing'; } else if(jQuery('#iw_cookie_functional').is(':checked')) { cookie_level = 'functional'; } setCookie('iw_cookie_consent',cookie_level,365); jQuery('.notification').show(); }, 0); } function setCookie(cname, cvalue, exdays) { var d = new Date(); d.setTime(d.getTime() + (exdays*24*60*60*1000)); var expires = "expires="+ d.toUTCString(); document.cookie = cname + "=" + cvalue + ";" + expires + ";path=/;domain=" + <?php echo json_encode($_SERVER['HTTP_HOST']); ?>;	} </script> </body></html>