!function(a){"use strict";var d={init:function(){a(document.body).on("keyup change","form.register #reg_password, form.checkout #account_password, form.edit-account #password_1, form.lost_reset_password #password_1",this.strengthMeter),a("form.checkout #createaccount").trigger("change")},strengthMeter:function(){var s=a("form.register, form.checkout, form.edit-account, form.lost_reset_password"),r=a('button[type="submit"]',s),e=a("#reg_password, #account_password, #password_1",s),t=e.val(),o=!s.is("form.checkout");d.includeMeter(s,e),s=d.checkPasswordStrength(s,e),wc_password_strength_meter_params.stop_checkout&&(o=!0),0<t.length&&s<wc_password_strength_meter_params.min_password_strength&&-1!==s&&o?r.attr("disabled","disabled").addClass("disabled"):r.prop("disabled",!1).removeClass("disabled")},includeMeter:function(s,r){s=s.find(".woocommerce-password-strength");""===r.val()?(s.hide(),a(document.body).trigger("wc-password-strength-hide")):0===s.length?(r.after('<div class="woocommerce-password-strength" aria-live="polite"></div>'),a(document.body).trigger("wc-password-strength-added")):(s.show(),a(document.body).trigger("wc-password-strength-show"))},checkPasswordStrength:function(s,r){var e=s.find(".woocommerce-password-strength"),s=s.find(".woocommerce-password-hint"),t='<small class="woocommerce-password-hint">'+wc_password_strength_meter_params.i18n_password_hint+"</small>",r=wp.passwordStrength.meter(r.val(),wp.passwordStrength.userInputDisallowedList()),o="";if(e.removeClass("short bad good strong"),s.remove(),!e.is(":hidden"))switch(r<wc_password_strength_meter_params.min_password_strength&&(o=" - "+wc_password_strength_meter_params.i18n_password_error),r){case 0:e.addClass("short").html(pwsL10n["short"]+o),e.after(t);break;case 1:case 2:e.addClass("bad").html(pwsL10n.bad+o),e.after(t);break;case 3:e.addClass("good").html(pwsL10n.good+o);break;case 4:e.addClass("strong").html(pwsL10n.strong+o);break;case 5:e.addClass("short").html(pwsL10n.mismatch)}return r}};d.init()}(jQuery);
jQuery(document).ready(function($){
$(document.body).on('keyup change', 'form.register #reg_password, form.checkout #account_password, form.edit-account #password_1, form.lost_reset_password #password_1', function(){
$(this).closest('form').find('button:submit').attr('disabled', false).removeClass('disabled');
$('.woocommerce-password-strength, .woocommerce-password-hint').hide();
});
});
if(window.NodeList&&!NodeList.prototype.forEach){
NodeList.prototype.forEach=Array.prototype.forEach;
}
(function (){
if(typeof window.CustomEvent==="function") return false;
function CustomEvent(event, params){
params=params||{ bubbles: false, cancelable: false, detail: null };
var evt=document.createEvent('CustomEvent');
evt.initCustomEvent(event, params.bubbles, params.cancelable, params.detail);
return evt;
}
window.CustomEvent=CustomEvent;
})();
(function ($){
var popup=document.querySelector('.wp-video-popup-wrapper');
var speed=200;
function init(){
if(!popup) return;
setupOpenActions();
setupVideoHeight();
setupCloseActions();
}
function setupOpenActions(){
setupOpenTriggers('.wp-video-popup');
setupOpenTriggers('.ryv-popup');
}
function setupOpenTriggers(triggerSelector){
var triggers=document.querySelectorAll(triggerSelector);
if(!triggers) return;
triggers.forEach(function (trigger){
trigger.addEventListener('click', function (e){
e.preventDefault();
openPopup();
});
});
}
function setupCloseActions(){
popup.addEventListener('click', function (e){
if(e.target==this||e.target.classList.contains('wp-video-popup-close')) closePopup();
});
document.addEventListener('keyup', function (e){
if(e.key!=='Escape'&&e.key!=='Esc'&&e.keyCode!==27) return;
if($(popup).is(':visible')) closePopup();
});
}
function setupVideoHeight(){
window.addEventListener('resize', function (){
var video=document.querySelector('.wp-video-popup-video.is-resizable');
if(video) $(video).height($(video).width() * 0.5625);
});
}
function openPopup(){
var video=popup.querySelector('.wp-video-popup-video');
document.body.insertBefore(popup, document.body.firstChild);
$(popup).css({ display: 'flex' }).stop().animate({
opacity: 1
}, speed);
$(video).stop().fadeIn(speed);
video.src=video.dataset.wpVideoPopupUrl;
window.dispatchEvent(new Event('resize'));
}
function closePopup(){
var video=popup.querySelector('.wp-video-popup-video');
$(popup).stop().animate({
opacity: 0
}, speed, function (){
$(popup).css({ display: 'none' });
});
$(video).stop().fadeOut(speed, function (){
video.src='';
});
}
init();
})(jQuery);
function learndash_scroll_to_parent(e){if(""!=e&&jQuery(e).length){var r=jQuery(e).offset().top;r<jQuery(window).scrollTop()&&jQuery("html,body").animate({scrollTop:r},750)}}jQuery((function(){if(jQuery(".ld_course_info .ld_course_info_mycourses_list .ld-course-registered-pager-container a").length){jQuery(".ld_course_info .ld_course_info_mycourses_list").on("click",".ld-course-registered-pager-container a",(function(e){e.preventDefault();var r=jQuery(e.currentTarget).parents(".learndash-pager");if(jQuery(r).addClass("ld-loading"),void 0===r)return;var a=jQuery(r).data("nonce"),n=jQuery(e.currentTarget).data("paged"),t=jQuery(e.currentTarget).parents(".ld_course_info");if(void 0===t)return;var o=jQuery(t).data("shortcode-atts");if(void 0===t)return;var d={action:"ld_course_registered_pager",nonce:a,paged:n,shortcode_atts:o};jQuery.ajax({type:"POST",url:sfwd_data.ajaxurl,dataType:"json",cache:!1,data:d,error:function(e,r,a){},success:function(e){void 0!==e&&(void 0!==e.content&&(jQuery(".ld_course_info_mycourses_list .ld-courseregistered-content-container",t).html(e.content),jQuery(r).removeClass("ld-loading")),void 0!==e.pager&&(jQuery(".ld_course_info_mycourses_list .ld-course-registered-pager-container",t).html(e.pager),jQuery(r).removeClass("ld-loading"),learndash_scroll_to_parent(jQuery(".ld_course_info_mycourses_list",t)),jQuery(window).trigger("learndash_pager_content_changed",{parent_div:t})))}})}))}})),jQuery((function(){if(jQuery(".ld_course_info .course_progress_details .ld-course-progress-pager-container a").length){jQuery(".ld_course_info .course_progress_details").on("click",".ld-course-progress-pager-container a",(function(e){e.preventDefault();var r=jQuery(e.currentTarget).parents(".learndash-pager");if(jQuery(r).addClass("ld-loading"),void 0===r)return;var a=jQuery(r).data("nonce"),n=jQuery(e.currentTarget).data("paged"),t=jQuery(e.currentTarget).parents(".ld_course_info");if(void 0===t)return;var o=jQuery(t).data("shortcode-atts");if(void 0===t)return;var d={action:"ld_course_progress_pager",nonce:a,paged:n,shortcode_atts:o};jQuery.ajax({type:"POST",url:sfwd_data.ajaxurl,dataType:"json",cache:!1,data:d,error:function(e,r,a){},success:function(e){void 0!==e&&(void 0!==e.content&&(jQuery(".course_progress_details .ld-course-progress-content-container",t).html(e.content),jQuery(r).removeClass("ld-loading")),void 0!==e.pager&&(jQuery(".course_progress_details .ld-course-progress-pager-container",t).html(e.pager),jQuery(r).removeClass("ld-loading"),learndash_scroll_to_parent(jQuery(".course_progress_details",t)),jQuery(window).trigger("learndash_pager_content_changed",{parent_div:t})))}})}))}})),jQuery((function(){if(jQuery(".ld_course_info .ld-quiz-progress-pager-container a").length){jQuery(".ld_course_info .quiz_progress_details").on("click",".ld-quiz-progress-pager-container a",(function(e){e.preventDefault();var r=jQuery(e.currentTarget).parents(".learndash-pager");if(jQuery(r).addClass("ld-loading"),void 0===r)return;var a=jQuery(r).data("nonce"),n=jQuery(e.currentTarget).data("paged"),t=jQuery(e.currentTarget).parents(".ld_course_info");if(void 0===t)return;var o=jQuery(t).data("shortcode-atts");if(void 0===t)return;var d={action:"ld_quiz_progress_pager",nonce:a,paged:n,shortcode_atts:o};jQuery.ajax({type:"POST",url:sfwd_data.ajaxurl,dataType:"json",cache:!1,data:d,error:function(e,r,a){},success:function(e){void 0!==e&&(void 0!==e.content&&jQuery("#quiz_progress_details .ld-quiz-progress-content-container",t).html(e.content),void 0!==e.pager&&(jQuery("#quiz_progress_details .ld-quiz-progress-pager-container",t).html(e.pager),learndash_scroll_to_parent(jQuery("#quiz_progress_details",t)),jQuery(window).trigger("learndash_pager_content_changed",{parent_div:t})))}})}))}})),jQuery((function(){if(jQuery(".ld-course-list-content .learndash-pager-course_list a").length){jQuery(".ld-course-list-content").on("click",".learndash-pager-course_list a",(function(e){e.preventDefault();var r=jQuery(e.currentTarget).parents(".learndash-pager");if(jQuery(r).addClass("ld-loading"),void 0===r)return;var a=jQuery(r).data("nonce"),n=jQuery(e.currentTarget).parents(".ld-course-list-content");if(void 0===n)return;var t=jQuery(n).data("shortcode-atts");if(void 0===t)return;var o=jQuery(e.currentTarget).data("paged"),d={action:"ld_course_list_shortcode_pager",nonce:a,paged:o,shortcode_atts:t};jQuery.ajax({type:"POST",url:sfwd_data.ajaxurl,dataType:"json",cache:!1,data:d,error:function(e,r,a){},success:function(e){void 0!==e&&void 0!==e.content&&(jQuery(n).html(e.content),jQuery(r).removeClass("ld-loading"),learndash_scroll_to_parent(n),jQuery(window).trigger("learndash_pager_content_changed",{parent_div:n}))}})}))}})),jQuery((function(){if(jQuery(".widget_ldcoursenavigation .learndash-pager-course_navigation_widget a").length){jQuery(".widget_ldcoursenavigation").on("click",".learndash-pager-course_navigation_widget a",(function(e){e.preventDefault();var r=jQuery(e.currentTarget).parents(".learndash-pager");if(void 0===r)return;var a=jQuery(r).data("nonce"),n=jQuery(e.currentTarget).parents(".course_navigation");if(void 0===n)return;var t=jQuery(n).data("widget_instance");if(void 0===t)return;var o=jQuery(e.currentTarget).data("paged"),d={action:"ld_course_navigation_pager",nonce:a,paged:o,widget_data:t};jQuery.ajax({type:"POST",url:sfwd_data.ajaxurl,dataType:"json",cache:!1,data:d,error:function(e,r,a){},success:function(e){void 0!==e&&void 0!==e.content&&e.content.length&&(jQuery(n).html(e.content),learndash_scroll_to_parent(n),jQuery(window).trigger("learndash_pager_content_changed",{parent_div:n}))}})}))}})),jQuery((function(){if(jQuery("#learndash_course_navigation_admin_meta .course_navigation .learndash-pager a").length){jQuery("#learndash_course_navigation_admin_meta").on("click",".course_navigation .learndash-pager a",(function(e){e.preventDefault();var r=jQuery(e.currentTarget).parents(".learndash-pager");if(void 0===r)return;var a=jQuery(r).data("nonce"),n=jQuery(e.currentTarget).parents(".course_navigation");if(void 0===n)return;var t=jQuery(n).data("widget_instance");if(void 0===t)return;var o=jQuery(e.currentTarget).data("paged"),d={action:"ld_course_navigation_admin_pager",nonce:a,paged:o,widget_data:t};jQuery.ajax({type:"POST",url:sfwd_data.ajaxurl,dataType:"json",cache:!1,data:d,error:function(e,r,a){},success:function(e){void 0!==e&&void 0!==e.content&&e.content.length&&(jQuery(n).html(e.content),learndash_scroll_to_parent(n),jQuery(window).trigger("learndash_pager_content_changed",{parent_div:n}))}})}))}})),jQuery((function(){if(jQuery("#learndash_admin_quiz_navigation .quiz_navigation .learndash-pager a").length){jQuery("#learndash_admin_quiz_navigation").on("click",".quiz_navigation .learndash-pager a",(function(e){e.preventDefault();var r=jQuery(e.currentTarget).parents(".learndash-pager");if(void 0===r)return;var a=jQuery(r).data("nonce"),n=jQuery(e.currentTarget).parents(".quiz_navigation");if(void 0===n)return;var t=jQuery(n).data("widget_instance");if(void 0===t)return;var o=jQuery(e.currentTarget).data("paged"),d={action:"ld_quiz_navigation_admin_pager",nonce:a,paged:o,widget_data:t};jQuery.ajax({type:"POST",url:sfwd_data.ajaxurl,dataType:"json",cache:!1,data:d,error:function(e,r,a){},success:function(e){void 0!==e&&void 0!==e.content&&e.content.length&&(jQuery(n).html(e.content),learndash_scroll_to_parent(n),jQuery(window).trigger("learndash_pager_content_changed",{parent_div:n}))}})}))}}));