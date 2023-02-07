jQuery(function($){
var hash=window.location.hash;
learndashFocusModeSidebarAutoScroll();
initLoginModal();
if('#login'==hash){
openLoginModal();
}
if('undefined'!==typeof ldGetUrlVars().login){
var loginStatus=ldGetUrlVars().login;
if('failed'==loginStatus){
openLoginModal();
}}
if('undefined'!==typeof ldGetUrlVars()['ld-topic-page']){
var topicPage=ldGetUrlVars()['ld-topic-page'];
var topicIds=topicPage.split('-');
var topicId=Object.values(topicIds)[0];
var lesson=$('#ld-expand-' + topicId);
var button=$(lesson).find('.ld-expand-button');
ld_expand_element(button);
$('html, body').animate({
scrollTop:($(lesson).offset().top),
}, 500);
}
$('body').on('click', 'a[href="#login"]', function(e){
e.preventDefault();
openLoginModal();
});
$('body').on('click', '.ld-modal-closer', function(e){
e.preventDefault();
closeLoginModal();
});
$('body').on('click', '#ld-comments-post-button', function(e){
$(this).addClass('ld-open');
$('#ld-comments-form').removeClass('ld-collapsed');
$('textarea#comment').focus();
});
/*
$('body').on('click', function(e){
if($('.learndash-wrapper').hasClass('ld-modal-open')){
if(! $(e.target).parents('.ld-modal').length&&(! $(e.target).is('a'))){
closeLoginModal();
}}
});
*/
$(document).on('keyup', function(e){
if(27===e.keyCode){
closeLoginModal();
}});
$('.learndash-wrapper').on('click', 'a.user_statistic', learndash_ld30_show_user_statistic);
focusMobileCheck();
$('body').on('click', '.ld-focus-sidebar-trigger', function(e){
if($('.ld-focus').hasClass('ld-focus-sidebar-collapsed')){
openFocusSidebar();
}else{
closeFocusSidebar();
}});
$('body').on('click', '.ld-mobile-nav a', function(e){
e.preventDefault();
if($('.ld-focus').hasClass('ld-focus-sidebar-collapsed')){
openFocusSidebar();
}else{
closeFocusSidebar();
}});
$('.ld-js-register-account').on('click', function(e){
e.preventDefault();
$('.ld-login-modal-register .ld-modal-text').slideUp('slow');
$('.ld-login-modal-register .ld-alert').slideUp('slow');
$(this).slideUp('slow', function(){
$('#ld-user-register').slideDown('slow');
});
});
if(''==$('.registration-login-link').attr('href')){
$('.registration-login-link').on('click', function(e){
e.preventDefault();
$('#learndash_registerform, .registration-login').hide();
$('.registration-login-form, .show-register-form, .show-password-reset-link').show();
});
$('.show-register-form').on('click', function(e){
e.preventDefault();
$('.registration-login-form, .show-register-form, .show-password-reset-link').hide();
$('#learndash_registerform, .registration-login').show();
})
}
var windowWidth=$(window).width();
$(window).on('orientationchange', function(){
windowWidth=$(window).width();
});
$(window).on('resize', function(){
if($(this).width()!==windowWidth&&1024 >=$(this).width()){
setTimeout(function(){
focusMobileResizeCheck();
}, 50);
}});
if($('.ld-course-status-content').length){
var tallest=0;
$('.ld-course-status-content').each(function(){
if($(this).height() > tallest){
tallest=$(this).height();
}});
$('.ld-course-status-content').height(tallest);
}
function focusMobileCheck(){
if(1024 > $(window).width()){
closeFocusSidebarPageLoad();
}}
function focusMobileResizeCheck(){
if(1024 > $(window).width()&&! $('.ld-focus').hasClass('ld-focus-sidebar-collapsed')){
closeFocusSidebar();
}else if(1024 <=$(window).width()&&$('.ld-focus').hasClass('ld-focus-sidebar-filtered')){
closeFocusSidebar();
}else if(1024 <=$(window).width() &&
! $('.ld-focus').hasClass('ld-focus-sidebar-filtered') &&
$('.ld-focus').hasClass('ld-focus-sidebar-collapsed')){
openFocusSidebar();
}}
function focusMobileHandleOrientationChange(e){
if(e.matches){
if(1024 <=$(window).width() &&
! $('.ld-focus').hasClass('ld-focus-sidebar-filtered') &&
$('.ld-focus').hasClass('ld-focus-sidebar-collapsed')){
openFocusSidebar();
}}
}
window.matchMedia('(orientation: landscape)').addListener(focusMobileHandleOrientationChange);
function closeFocusSidebarPageLoad(){
$('.ld-focus').addClass('ld-focus-sidebar-collapsed');
$('.ld-focus').removeClass('ld-focus-initial-transition');
$('.ld-mobile-nav').removeClass('expanded');
positionTooltips();
}
function closeFocusSidebar(){
$('.ld-focus').addClass('ld-focus-sidebar-collapsed');
$('.ld-mobile-nav').removeClass('expanded');
if($('.ld-focus-sidebar-trigger .ld-icon').hasClass('ld-icon-arrow-left')){
$('.ld-focus-sidebar-trigger .ld-icon').removeClass('ld-icon-arrow-left');
$('.ld-focus-sidebar-trigger .ld-icon').addClass('ld-icon-arrow-right');
}else if($('.ld-focus-sidebar-trigger .ld-icon').hasClass('ld-icon-arrow-right')){
$('.ld-focus-sidebar-trigger .ld-icon').removeClass('ld-icon-arrow-right');
$('.ld-focus-sidebar-trigger .ld-icon').addClass('ld-icon-arrow-left');
}
positionTooltips();
}
function openFocusSidebar(){
$('.ld-focus').removeClass('ld-focus-sidebar-collapsed');
$('.ld-mobile-nav').addClass('expanded');
if($('.ld-focus-sidebar-trigger .ld-icon').hasClass('ld-icon-arrow-left')){
$('.ld-focus-sidebar-trigger .ld-icon').removeClass('ld-icon-arrow-left');
$('.ld-focus-sidebar-trigger .ld-icon').addClass('ld-icon-arrow-right');
}else if($('.ld-focus-sidebar-trigger .ld-icon').hasClass('ld-icon-arrow-right')){
$('.ld-focus-sidebar-trigger .ld-icon').removeClass('ld-icon-arrow-right');
$('.ld-focus-sidebar-trigger .ld-icon').addClass('ld-icon-arrow-left');
}
positionTooltips();
}
$('.ld-file-input').each(function(){
var $input=$(this),
$label=$input.next('label'),
labelVal=$label.html();
$input.on('change', function(e){
var fileName='';
if(this.files&&1 < this.files.length){
fileName=(this.getAttribute('data-multiple-caption')||'').replace('{count}', this.files.length);
}else if(e.target.value){
fileName=e.target.value.split('\\').pop();
}
if(fileName){
$label.find('span').html(fileName);
$label.addClass('ld-file-selected');
$('#uploadfile_btn').attr('disabled', false);
}else{
$label.html(labelVal);
$label.removeClass('ld-file-selected');
$('#uploadfile_btn').attr('disabled', true);
}});
$('#uploadfile_form').on('submit', function(){
$label.removeClass('ld-file-selected');
$('#uploadfile_btn').attr('disabled', true);
});
$input
.on('focus', function(){
$input.addClass('has-focus');
})
.on('blur', function(){
$input.removeClass('has-focus');
});
});
$('body').on('click', '.ld-expand-button', function(e){
e.preventDefault();
ld_expand_element($(this));
positionTooltips();
});
$('body').on('click', '.ld-search-prompt', function(e){
e.preventDefault();
$('#course_name_field').focus();
ld_expand_element($(this));
});
function ld_expand_button_state(state, elm){
var $expandText=($(elm)[0].hasAttribute('data-ld-expand-text')) ? $(elm).attr('data-ld-expand-text'):'Expand';
var $collapseText=($(elm)[0].hasAttribute('data-ld-collapse-text')) ? $(elm).attr('data-ld-collapse-text'):'Collapse';
if('collapse'==state){
$(elm).removeClass('ld-expanded');
if('false'!==$collapseText){
$(elm).find('.ld-text').text($expandText);
}}else{
$(elm).addClass('ld-expanded');
if('false'!==$collapseText){
$(elm).find('.ld-text').text($collapseText);
}}
}
function ld_expand_element(elm, collapse){
if(collapse===undefined){
collapse=false;
}
var elmParentWrapper=elm.parents('.ld-focus-sidebar');
if(( 'undefined'===typeof elmParentWrapper)||(! elmParentWrapper.length)){
var elmParentWrapper=elm.parents('.learndash-wrapper');
}
if(( 'undefined'===typeof elmParentWrapper)||(! elmParentWrapper.length)){
return;
}
var $expanded=$(elm).hasClass('ld-expanded');
if($(elm)[0]&&$(elm)[0].hasAttribute('data-ld-expands')){
var $expands=$(elm).attr('data-ld-expands');
if(( 'undefined'===typeof $expands)||(! $expands.length)){
return;
}
var $expandElm=$(elmParentWrapper).find('[data-ld-expand-id="'+ $expands+'"]');
if(( 'undefined'===typeof $expandElm)||(! $expandElm.length)){
return;
}
var $expandsChild=$($expandElm).find('.ld-item-list-item-expanded');
if($expandsChild.length){
$expandElm=$expandsChild;
}
var totalHeight=0;
$expandElm.find('> *').each(function(){
totalHeight +=$(this).outerHeight();
});
$expandElm.attr('data-height', '' +(totalHeight + 50) + '');
if($(elmParentWrapper).find('[data-ld-expand-id="'+ $expands+'"]')[0].hasAttribute('data-ld-expand-list')){
var $container=$(elmParentWrapper).find('[data-ld-expand-id="'+ $expands+'"]');
var innerButtons=$container.find('.ld-expand-button');
if($expanded){
ld_expand_button_state('collapse', elm);
innerButtons.each(function(){
ld_expand_element($(this), true);
});
}else{
ld_expand_button_state('expand', elm);
innerButtons.each(function(){
ld_expand_element($(this));
});
}}else if($(elmParentWrapper).find('[data-ld-expand-id="'+ $expands+'"]').length){
if($expanded||true==collapse){
ld_expand_singular_item(elm, $(elmParentWrapper).find('[data-ld-expand-id="'+ $expands+'"]'), $expandElm);
}else{
ld_collapse_singular_item(elm, $(elmParentWrapper).find('[data-ld-expand-id="'+ $expands+'"]'), $expandElm);
}}else{
console.log('LearnDash: No expandable content was found');
}
positionTooltips();
}}
function ld_expand_singular_item(elm, $containerElm, $expandElm){
$containerElm.removeClass('ld-expanded');
ld_expand_button_state('collapse', elm);
$expandElm.css({
'max-height': 0,
});
}
function ld_collapse_singular_item(elm, $containerElm, $expandElm){
$containerElm.addClass('ld-expanded');
ld_expand_button_state('expand', elm);
$expandElm.css({
'max-height': $expandElm.data('height'),
});
}
$('body').on('click', '.ld-closer', function(e){
ld_expand_element($('.ld-search-prompt'), true);
});
$('body').on('click', '.ld-tabs-navigation .ld-tab', function(){
var $tab=$('#' + $(this).attr('data-ld-tab'));
if($tab.length){
$('.ld-tabs-navigation .ld-tab.ld-active').removeClass('ld-active');
$('.ld-tabs-navigation .ld-tab').removeAttr('aria-selected');
$(this).addClass('ld-active');
$(this).attr('aria-selected', 'true');
$('.ld-tabs-content .ld-tab-content.ld-visible').removeClass('ld-visible');
$tab.addClass('ld-visible');
}
positionTooltips();
});
var $tooltips=$('*[data-ld-tooltip]');
initTooltips();
function initTooltips(){
if($('#learndash-tooltips').length){
$('#learndash-tooltips').remove();
$tooltips=$('*[data-ld-tooltip]');
}
if($tooltips.length){
$('body').prepend('<div id="learndash-tooltips"></div>');
var $ctr=1;
$tooltips.each(function(){
var anchor=$(this);
if(anchor.hasClass('ld-item-list-item')){
anchor=anchor.find('.ld-item-title');
}
if(( "undefined"!==typeof anchor)&&($(anchor).hasClass('ld-status-waiting'))){
$(anchor).on('click', function(e){
e.preventDefault();
return false;
});
var parent_anchor=$(anchor).parents('a');
if("undefined"!==typeof parent_anchor){
$(parent_anchor).on('click', function(e){
e.preventDefault();
return false;
});
}}
var elementOffsets={
top: anchor.offset().top,
left: anchor.offset().left +(anchor.outerWidth() / 2),
};
var $content=$(this).attr('data-ld-tooltip');
var $rel_id=Math.floor(( Math.random() * 99999));
var $tooltip='<span id="ld-tooltip-' + $rel_id + '" class="ld-tooltip">' + $content + '</span>';
$(this).attr('data-ld-tooltip-id', $rel_id);
$('#learndash-tooltips').append($tooltip);
$ctr++;
var $tooltip=$('#ld-tooltip-' + $rel_id);
$(this).on('mouseenter', function(){
$tooltip.addClass('ld-visible');
}).on('mouseleave', function(){
$tooltip.removeClass('ld-visible');
});
});
$(window).on('resize', function(){
positionTooltips();
});
$(window).add('.ld-focus-sidebar-wrapper').on('scroll', function(){
$('.ld-visible.ld-tooltip').removeClass('ld-visible');
positionTooltips();
});
positionTooltips();
}}
function initLoginModal(){
var modal_wrapper=$('.learndash-wrapper-login-modal');
if(( 'undefined'!==typeof modal_wrapper)&&(modal_wrapper.length)){
$(modal_wrapper).prependTo('body');
}}
function openLoginModal(){
var modal_wrapper=$('.learndash-wrapper-login-modal');
if(( 'undefined'!==typeof modal_wrapper)&&(modal_wrapper.length)){
$(modal_wrapper).addClass('ld-modal-open');
$(modal_wrapper).removeClass('ld-modal-closed');
$('html, body').animate({
scrollTop: $('.ld-modal', modal_wrapper).offset().top,
}, 50);
}}
function closeLoginModal(){
var modal_wrapper=$('.learndash-wrapper-login-modal');
if(( 'undefined'!==typeof modal_wrapper)&&(modal_wrapper.length)){
$(modal_wrapper).removeClass('ld-modal-open');
$(modal_wrapper).addClass('ld-modal-closed');
}}
function positionTooltips(){
if('undefined'!==typeof $tooltips){
setTimeout(function(){
$tooltips.each(function(){
var anchor=$(this);
var $rel_id=anchor.attr('data-ld-tooltip-id');
$tooltip=$('#ld-tooltip-' + $rel_id);
if(anchor.hasClass('ld-item-list-item')){
anchor=anchor.find('.ld-status-icon');
}
var parent_focus=jQuery(anchor).parents('.ld-focus-sidebar');
var left_post=anchor.offset().left +(anchor.outerWidth() + 10);
if(parent_focus.length){
left_post=anchor.offset().left +(anchor.outerWidth() - 18);
}
var focusModeMainContentHeight=$('.ld-focus-main').height();
var focusModeCurrentTooltipHeight=anchor.offset().top + -3;
if(! focusModeMainContentHeight){
var anchorTop=anchor.offset().top + -3;
var anchorLeft=anchor.offset().left;
}else{
anchorTop=focusModeCurrentTooltipHeight < focusModeMainContentHeight ? focusModeCurrentTooltipHeight:focusModeMainContentHeight;
anchorLeft=left_post;
}
$tooltip.css({
top: anchorTop,
left: anchorLeft, //anchor.offset().left + (anchor.outerWidth() +10),
'margin-left': 0,
'margin-right': 0,
}).removeClass('ld-shifted-left ld-shifted-right');
if($tooltip.offset().left <=0){
$tooltip.css({ 'margin-left': Math.abs($tooltip.offset().left) }).addClass('ld-shifted-left');
}
var $tooltipRight=$(window).width() -($tooltip.offset().left + $tooltip.outerWidth());
if(0 >=$tooltipRight&&360 < $(window).width()){
$tooltip.css({ 'margin-right': Math.abs($tooltipRight) }).addClass('ld-shifted-right');
}});
}, 500);
}}
$('body').on('click', '#ld-profile .ld-reset-button', function(e){
e.preventDefault();
$('#ld-profile #course_name_field').val('');
var searchVars={
shortcode_instance: $('#ld-profile').data('shortcode_instance'),
};
searchVars['ld-profile-search']=$(this).parents('.ld-item-search-wrapper').find('#course_name_field').val();
searchVars['ld-profile-search-nonce']=$(this).parents('.ld-item-search-wrapper').find('form.ld-item-search-fields').data('nonce');
$('#ld-profile #ld-main-course-list').addClass('ld-loading');
$.ajax({
type: 'GET',
url: ldVars.ajaxurl + '?action=ld30_ajax_profile_search',
data: searchVars,
success: function(response){
if('undefined'!==typeof response.data.markup){
$('#ld-profile').html(response.data.markup);
ld_expand_element('#ld-profile .ld-search-prompt', false);
}},
});
});
$('body').on('submit', '.ld-item-search-fields', function(e){
e.preventDefault();
var searchVars={
shortcode_instance: $('#ld-profile').data('shortcode_instance'),
};
searchVars['ld-profile-search']=$(this).parents('.ld-item-search-wrapper').find('#course_name_field').val();
searchVars['ld-profile-search-nonce']=$(this).parents('.ld-item-search-wrapper').find('form.ld-item-search-fields').data('nonce');
$('#ld-profile #ld-main-course-list').addClass('ld-loading');
$.ajax({
type: 'GET',
url: ldVars.ajaxurl + '?action=ld30_ajax_profile_search',
data: searchVars,
success: function(response){
if('undefined'!==typeof response.data.markup){
$('#ld-profile').html(response.data.markup);
ld_expand_element('#ld-profile .ld-search-prompt', false);
}},
});
});
$('body').on('click', '.ld-pagination a', function(e){
e.preventDefault();
var linkVars={};
var parentVars={};
$(this).attr('href').replace(/[?&]+([^=&]+)=([^&]*)/gi, function(m, key, value){
linkVars[key]=value;
});
linkVars.pager_nonce=$(this).parents('.ld-pagination').data('pager-nonce');
linkVars.pager_results=$(this).parents('.ld-pagination').data('pager-results');
linkVars.context=$(this).data('context');
console.log('linkVars[%o]', linkVars);
parentVars.currentTarget=e.currentTarget;
if('profile'!=linkVars.context){
linkVars.lesson_id=$(this).data('lesson_id');
linkVars.course_id=$(this).data('course_id');
if($('.ld-course-nav-' + linkVars.course_id).length){
linkVars.widget_instance=$('.ld-course-nav-' + linkVars.course_id).data('widget_instance');
}}
if('course_topics'==linkVars.context){
$('#ld-topic-list-' + linkVars.lesson_id).addClass('ld-loading');
$('#ld-nav-content-list-' + linkVars.lesson_id).addClass('ld-loading');
}
if('course_content_shortcode'==linkVars.context){
parentVars.parent_container=$(parentVars.currentTarget).closest('.ld-course-content-' + linkVars.course_id);
if(( 'undefined'!==typeof parentVars.parent_container)&&(parentVars.parent_container.length)){
$(parentVars.parent_container).addClass('ld-loading');
linkVars.shortcode_instance=$(parentVars.parent_container).data('shortcode_instance');
}else{
$('.ld-course-content-' + linkVars.course_id).addClass('ld-loading');
linkVars.shortcode_instance=$('.ld-course-content-' + linkVars.course_id).data('shortcode_instance');
}}else if('course_lessons'==linkVars.context){
var parent_container;
if(( 'undefined'===typeof parentVars.parent_container)||(! parentVars.parent_container.length)){
parent_container=$(parentVars.currentTarget).parents('.ld-lesson-navigation');
if(( 'undefined'!==typeof parent_container)&&(parent_container.length)){
parentVars.context_sub='course_navigation_widget';
parentVars.parent_container=$(parentVars.currentTarget).parents('#ld-lesson-list-' + linkVars.course_id);
}}
if(( 'undefined'===typeof parentVars.parent_container)||(! parentVars.parent_container.length)){
parent_container=$(parentVars.currentTarget).parents('.ld-focus-sidebar-wrapper');
if(( 'undefined'!==typeof parent_container)&&(parent_container.length)){
parentVars.context_sub='focus_mode_sidebar';
parentVars.parent_container=$(parentVars.currentTarget).parents('#ld-lesson-list-' + linkVars.course_id);
}}
if(( 'undefined'===typeof parentVars.parent_container)||(! parentVars.parent_container.length)){
parentVars.parent_container=$(parentVars.currentTarget).closest('#ld-item-list-' + linkVars.course_id, '#ld-lesson-list-' + linkVars.course_id);
}
if(( 'undefined'!==typeof parentVars.parent_container)&&(parentVars.parent_container.length)){
$(parentVars.parent_container).addClass('ld-loading');
}else{
$('#ld-item-list-' + linkVars.course_id).addClass('ld-loading');
$('#ld-lesson-list-' + linkVars.course_id).addClass('ld-loading');
}}
if('profile'==linkVars.context){
$('#ld-profile #ld-main-course-list').addClass('ld-loading');
linkVars.shortcode_instance=$('#ld-profile').data('shortcode_instance');
}
if('profile_quizzes'==linkVars.context){
$('#ld-course-list-item-' + linkVars.pager_results.quiz_course_id + ' .ld-item-contents').addClass('ld-loading');
}
if('course_info_courses'==linkVars.context){
$('.ld-user-status').addClass('ld-loading');
linkVars.shortcode_instance=$('.ld-user-status').data('shortcode-atts');
}
if('group_courses'==linkVars.context){
linkVars.group_id=$(this).data('group_id');
if('undefined'!==typeof linkVars.group_id){
parent_container=$(parentVars.currentTarget).parents('.ld-group-courses-' + linkVars.group_id);
if(( 'undefined'!==typeof parent_container)&&(parent_container.length)){
$(parent_container).addClass('ld-loading');
parentVars.parent_container=parent_container;
}}
}
$.ajax({
type: 'GET',
url: ldVars.ajaxurl + '?action=ld30_ajax_pager',
data: linkVars,
success: function(response){
if('course_topics'==linkVars.context){
if($('#ld-topic-list-' + linkVars.lesson_id).length){
if('undefined'!==typeof response.data.topics){
$('#ld-topic-list-' + linkVars.lesson_id).html(response.data.topics);
}
if('undefined'!==typeof response.data.pager){
$('#ld-expand-' + linkVars.lesson_id).find('.ld-table-list-footer').html(response.data.pager);
}
learndashSetMaxHeight($('.ld-lesson-item-' + linkVars.lesson_id).find('.ld-item-list-item-expanded'));
$('#ld-topic-list-' + linkVars.lesson_id).removeClass('ld-loading');
}
if($('#ld-nav-content-list-' + linkVars.lesson_id).length){
if('undefined'!==typeof response.data.nav_topics){
$('#ld-nav-content-list-' + linkVars.lesson_id).find('.ld-table-list-items').html(response.data.topics);
}
if('undefined'!==typeof response.data.pager){
$('#ld-nav-content-list-' + linkVars.lesson_id).find('.ld-table-list-footer').html(response.data.pager);
}
$('#ld-nav-content-list-' + linkVars.lesson_id).removeClass('ld-loading');
}}
if('course_content_shortcode'==linkVars.context){
if('undefined'!==typeof response.data.markup){
if(( 'undefined'!==typeof parentVars.parent_container)&&(parentVars.parent_container.length)){
$(parentVars.parent_container).replaceWith(response.data.markup);
}else{
$('#learndash_post_' + linkVars.course_id).replaceWith(response.data.markup);
}}
}else if('course_lessons'==linkVars.context){
if(( 'undefined'!==typeof parentVars.parent_container)&&(parentVars.parent_container.length)){
if('course_navigation_widget'==parentVars.context_sub){
if('undefined'!==typeof response.data.nav_lessons){
$(parentVars.parent_container).html(response.data.nav_lessons).removeClass('ld-loading');
}}else if('focus_mode_sidebar'==parentVars.context_sub){
if('undefined'!==typeof response.data.nav_lessons){
$(parentVars.parent_container).html(response.data.nav_lessons).removeClass('ld-loading');
}}else if('undefined'!==typeof response.data.lessons){
$(parentVars.parent_container).html(response.data.lessons).removeClass('ld-loading');
}}else{
if($('#ld-item-list-' + linkVars.course_id).length){
if('undefined'!==typeof response.data.lessons){
$('#ld-item-list-' + linkVars.course_id).html(response.data.lessons).removeClass('ld-loading');
}}
if($('#ld-lesson-list-' + linkVars.course_id).length){
if('undefined'!==typeof response.data.nav_lessons){
$('#ld-lesson-list-' + linkVars.course_id).html(response.data.nav_lessons).removeClass('ld-loading');
}}
}}
if('group_courses'==linkVars.context){
if(( 'undefined'!==typeof parentVars.parent_container)&&(parentVars.parent_container.length)){
if('undefined'!==typeof response.data.markup){
$(parentVars.parent_container).html(response.data.markup).removeClass('ld-loading');
}}
}
if('profile'==linkVars.context){
if('undefined'!==typeof response.data.markup){
$('#ld-profile').html(response.data.markup);
}}
if('profile_quizzes'==linkVars.context){
if('undefined'!==typeof response.data.markup){
$('#ld-course-list-item-' + linkVars.pager_results.quiz_course_id + ' .ld-item-list-item-expanded .ld-item-contents').replaceWith(response.data.markup);
$('#ld-course-list-item-' + linkVars.pager_results.quiz_course_id).get(0).scrollIntoView({ behavior: 'smooth' });
}}
if('course_info_courses'==linkVars.context){
if('undefined'!==typeof response.data.markup){
$('.ld-user-status').replaceWith(response.data.markup);
}}
$('body').trigger('ld_has_paginated');
initTooltips();
},
});
});
if($('#learndash_timer').length){
var timer_el=jQuery('#learndash_timer');
var timer_seconds=timer_el.attr('data-timer-seconds');
var timer_button_el=jQuery(timer_el.attr('data-button'));
var cookie_key=timer_el.attr('data-cookie-key');
if('undefined'!==typeof cookie_key){
var cookie_name='learndash_timer_cookie_' + cookie_key;
}else{
var cookie_name='learndash_timer_cookie';
}
cookie_timer_seconds=jQuery.cookie(cookie_name);
if('undefined'!==typeof cookie_timer_seconds){
timer_seconds=parseInt(cookie_timer_seconds);
}
if(0==timer_seconds){
$(timer_el).hide();
}
$(timer_button_el).on('learndash-time-finished', function(){
$(timer_el).hide();
});
}
$(document).on('learndash_video_disable_assets', function(event, status){
if('undefined'===typeof learndash_video_data){
return false;
}
if('BEFORE'==learndash_video_data.videos_shown){
if(true==status){
$('.ld-lesson-topic-list').hide();
$('.ld-lesson-navigation').find('#ld-nav-content-list-' + ldVars.postID).addClass('user_has_no_access');
$('.ld-quiz-list').hide();
}else{
$('.ld-lesson-topic-list').slideDown();
$('.ld-quiz-list').slideDown();
$('.ld-lesson-navigation').find('#ld-nav-content-list-' + ldVars.postID).removeClass('user_has_no_access');
}}
});
$('.learndash-wrapper').on('click', '.wpProQuiz_questionListItem input[type="radio"]', function(e){
$(this).parents('.wpProQuiz_questionList').find('label').removeClass('is-selected');
$(this).parents('label').addClass('is-selected');
});
$('.learndash-wrapper').on('click', '.wpProQuiz_questionListItem input[type="checkbox"]', function(e){
if(jQuery(e.currentTarget).is(':checked')){
$(this).parents('label').addClass('is-selected');
}else{
$(this).parents('label').removeClass('is-selected');
}});
function learndash_ld30_show_user_statistic(e){
e.preventDefault();
var refId=jQuery(this).data('ref-id');
var quizId=jQuery(this).data('quiz-id');
var userId=jQuery(this).data('user-id');
var statistic_nonce=jQuery(this).data('statistic-nonce');
var post_data={
action: 'wp_pro_quiz_admin_ajax_statistic_load_user',
func: 'statisticLoadUser',
data: {
quizId: quizId,
userId: userId,
refId: refId,
statistic_nonce: statistic_nonce,
avg: 0,
},
};
jQuery('#wpProQuiz_user_overlay, #wpProQuiz_loadUserData').show();
var content=jQuery('#wpProQuiz_user_content').hide();
jQuery.ajax({
type: 'POST',
url: ldVars.ajaxurl,
dataType: 'json',
cache: false,
data: post_data,
error: function(jqXHR, textStatus, errorThrown){
},
success: function(reply_data){
if('undefined'!==typeof reply_data.html){
content.html(reply_data.html);
jQuery('#wpProQuiz_user_content').show();
jQuery('body').trigger('learndash-statistics-contentchanged');
jQuery('#wpProQuiz_loadUserData').hide();
content.find('.statistic_data').on('click', function(){
jQuery(this).parents('tr').next().toggle('fast');
return false;
});
}},
});
jQuery('#wpProQuiz_overlay_close').on('click', function(){
jQuery('#wpProQuiz_user_overlay').hide();
});
}
function learndashSetMaxHeight(elm){
var totalHeight=0;
elm.find('> *').each(function(){
totalHeight +=$(this).outerHeight();
});
elm.attr('data-height', '' +(totalHeight + 50) + '');
elm.css({
'max-height': totalHeight + 50,
});
}
function learndashFocusModeSidebarAutoScroll(){
if(jQuery('.learndash-wrapper .ld-focus').length){
var sidebar_wrapper=jQuery('.learndash-wrapper .ld-focus .ld-focus-sidebar-wrapper');
var sidebar_curent_topic=jQuery('.learndash-wrapper .ld-focus .ld-focus-sidebar-wrapper .ld-is-current-item');
if(( 'undefined'!==typeof sidebar_curent_topic)&&(sidebar_curent_topic.length)){
var sidebar_scrollTo=sidebar_curent_topic;
}else{
var sidebar_curent_lesson=jQuery('.learndash-wrapper .ld-focus .ld-focus-sidebar-wrapper .ld-is-current-lesson');
if(( 'undefined'!==typeof sidebar_curent_lesson)&&(sidebar_curent_lesson.length)){
var sidebar_scrollTo=sidebar_curent_lesson;
}}
if(( 'undefined'!==typeof sidebar_scrollTo)&&(sidebar_scrollTo.length)){
var offset_top=0;
if(jQuery('.learndash-wrapper .ld-focus .ld-focus-header').length){
var logo_height=jQuery('.learndash-wrapper .ld-focus .ld-focus-header').height();
offset_top +=logo_height;
}
if(jQuery('.learndash-wrapper .ld-focus .ld-focus-sidebar .ld-course-navigation-heading').length){
var heading_height=jQuery('.learndash-wrapper .ld-focus .ld-focus-sidebar .ld-course-navigation-heading').height();
offset_top +=heading_height;
}
if(jQuery('.learndash-wrapper .ld-focus .ld-focus-sidebar .ld-focus-sidebar-wrapper').length){
var container_height=jQuery('.learndash-wrapper .ld-focus .ld-focus-sidebar .ld-focus-sidebar-wrapper').height();
offset_top +=container_height;
}
var current_item_height=jQuery(sidebar_scrollTo).height();
offset_top -=current_item_height;
sidebar_wrapper.animate({
scrollTop: sidebar_scrollTo.offset().top - offset_top,
}, 1000);
}}
}
function update_payment_forms(data){
$('#total-row').attr('data-total', data.total.value)
$('form[name="buynow"] input[name="amount"]').val(data.total.value);
$('form.learndash-stripe-checkout input[name="stripe_price"]').val(data.total.stripe_value);
const stripe_course_id=$('.learndash-stripe-checkout input[name="stripe_course_id"]').val();
if(stripe_course_id){
LD_Cookies.remove('ld_stripe_session_id_' + stripe_course_id);
LD_Cookies.remove('ld_stripe_connect_session_id_' + stripe_course_id);
}
if(typeof ld_init_stripe_legacy==="function"){
ld_init_stripe_legacy();
}}
$('.btn-join').on('click', function(e){
const total=parseFloat($('#total-row').attr('data-total'));
if(0===total){
$.ajax({
type: 'POST',
url: ldVars.ajaxurl,
dataType: 'json',
cache: false,
data: {
action: 'learndash_enroll_with_zero_price',
nonce: $('#apply-coupon-form').data('nonce'),
post_id: $('#apply-coupon-form').data('post-id'),
},
success: function(response){
if(response.success){
window.location.replace(response.data.redirect_url);
}else{
alert(response.data.message);
}},
});
e.preventDefault();
return false;
}});
$('#apply-coupon-form').on('submit', function(e){
e.preventDefault();
$.ajax({
type: 'POST',
url: ldVars.ajaxurl,
dataType: 'json',
cache: false,
data: {
action: 'learndash_apply_coupon',
nonce: $(this).data('nonce'),
coupon_code: $(this).find('#coupon-field').val(),
post_id: $(this).data('post-id'),
},
success: function(response){
$('#coupon-alerts .coupon-alert').hide();
let $alert=$('#coupon-alerts').find(response.success ? '.coupon-alert-success':'.coupon-alert-warning'
);
let $coupon_row=$('#coupon-row');
if(response.success){
$coupon_row.find('.purchase-label > span').html(response.data.coupon_code);
$coupon_row.find('.purchase-value span').html(response.data.discount);
$coupon_row.css('display', 'flex').hide().fadeIn();
$('#total-row .purchase-value').html(response.data.total.formatted);
$('#totals').show();
update_payment_forms(response.data);
}
$alert.find('.ld-alert-messages').html(response.data.message);
$alert.fadeIn();
},
});
});
$('#remove-coupon-form').on('submit', function(e){
e.preventDefault();
$.ajax({
type: 'POST',
url: ldVars.ajaxurl,
dataType: 'json',
cache: false,
data: {
action: 'learndash_remove_coupon',
nonce: $(this).data('nonce'),
post_id: $(this).data('post-id'),
},
success: function(response){
$('#coupon-alerts .coupon-alert').hide();
let $alert=$('#coupon-alerts').find(response.success ? '.coupon-alert-success':'.coupon-alert-warning'
);
if(response.success){
$('#coupon-row').hide();
$('#coupon-field').val('');
$('#price-row .purchase-value').html(response.data.total.formatted);
$('#subtotal-row .purchase-value').html(response.data.total.formatted);
$('#total-row .purchase-value').html(response.data.total.formatted);
$('#totals').hide();
update_payment_forms(response.data);
}
$alert.find('.ld-alert-messages').html(response.data.message);
$alert.fadeIn();
},
});
});
});
function ldGetUrlVars(){
var vars={};
var parts=window.location.href.replace(/[?&]+([^=&]+)=([^&]*)/gi, function(m, key, value){
vars[key]=value;
});
return vars;
};
!function(t){"use strict";"function"==typeof define&&define.amd?define(["jquery"],t):t(jQuery)}(function(x){"use strict";var t,e,i,n,W,C,o,s,r,l,a,h,u;function E(t,e,i){return[parseFloat(t[0])*(a.test(t[0])?e/100:1),parseFloat(t[1])*(a.test(t[1])?i/100:1)]}function L(t,e){return parseInt(x.css(t,e),10)||0}function N(t){return null!=t&&t===t.window}x.ui=x.ui||{},x.ui.version="1.13.2",
x.extend(x.expr.pseudos,{data:x.expr.createPseudo?x.expr.createPseudo(function(e){return function(t){return!!x.data(t,e)}}):function(t,e,i){return!!x.data(t,i[3])}}),
x.fn.extend({disableSelection:(t="onselectstart"in document.createElement("div")?"selectstart":"mousedown",function(){return this.on(t+".ui-disableSelection",function(t){t.preventDefault()})}),enableSelection:function(){return this.off(".ui-disableSelection")}}),
x.ui.focusable=function(t,e){var i,n,o,s=t.nodeName.toLowerCase();return"area"===s?(o=(i=t.parentNode).name,!(!t.href||!o||"map"!==i.nodeName.toLowerCase())&&(0<(i=x("img[usemap='#"+o+"']")).length&&i.is(":visible"))):(/^(input|select|textarea|button|object)$/.test(s)?(n=!t.disabled)&&(o=x(t).closest("fieldset")[0])&&(n=!o.disabled):n="a"===s&&t.href||e,n&&x(t).is(":visible")&&function(t){var e=t.css("visibility");for(;"inherit"===e;)t=t.parent(),e=t.css("visibility");return"visible"===e}(x(t)))},x.extend(x.expr.pseudos,{focusable:function(t){return x.ui.focusable(t,null!=x.attr(t,"tabindex"))}}),x.fn._form=function(){return"string"==typeof this[0].form?this.closest("form"):x(this[0].form)},
x.ui.formResetMixin={_formResetHandler:function(){var e=x(this);setTimeout(function(){var t=e.data("ui-form-reset-instances");x.each(t,function(){this.refresh()})})},_bindFormResetHandler:function(){var t;this.form=this.element._form(),this.form.length&&((t=this.form.data("ui-form-reset-instances")||[]).length||this.form.on("reset.ui-form-reset",this._formResetHandler),t.push(this),this.form.data("ui-form-reset-instances",t))},_unbindFormResetHandler:function(){var t;this.form.length&&((t=this.form.data("ui-form-reset-instances")).splice(x.inArray(this,t),1),t.length?this.form.data("ui-form-reset-instances",t):this.form.removeData("ui-form-reset-instances").off("reset.ui-form-reset"))}},x.ui.ie=!!/msie [\w.]+/.exec(navigator.userAgent.toLowerCase()),
x.expr.pseudos||(x.expr.pseudos=x.expr[":"]),x.uniqueSort||(x.uniqueSort=x.unique),x.escapeSelector||(e=/([\0-\x1f\x7f]|^-?\d)|^-$|[^\x80-\uFFFF\w-]/g,i=function(t,e){return e?"\0"===t?"�":t.slice(0,-1)+"\\"+t.charCodeAt(t.length-1).toString(16)+" ":"\\"+t},x.escapeSelector=function(t){return(t+"").replace(e,i)}),x.fn.even&&x.fn.odd||x.fn.extend({even:function(){return this.filter(function(t){return t%2==0})},odd:function(){return this.filter(function(t){return t%2==1})}}),
x.ui.keyCode={BACKSPACE:8,COMMA:188,DELETE:46,DOWN:40,END:35,ENTER:13,ESCAPE:27,HOME:36,LEFT:37,PAGE_DOWN:34,PAGE_UP:33,PERIOD:190,RIGHT:39,SPACE:32,TAB:9,UP:38},
x.fn.labels=function(){var t,e,i;return this.length?this[0].labels&&this[0].labels.length?this.pushStack(this[0].labels):(e=this.eq(0).parents("label"),(t=this.attr("id"))&&(i=(i=this.eq(0).parents().last()).add((i.length?i:this).siblings()),t="label[for='"+x.escapeSelector(t)+"']",e=e.add(i.find(t).addBack(t))),this.pushStack(e)):this.pushStack([])},x.ui.plugin={add:function(t,e,i){var n,o=x.ui[t].prototype;for(n in i)o.plugins[n]=o.plugins[n]||[],o.plugins[n].push([e,i[n]])},call:function(t,e,i,n){var o,s=t.plugins[e];if(s&&(n||t.element[0].parentNode&&11!==t.element[0].parentNode.nodeType))for(o=0;o<s.length;o++)t.options[s[o][0]]&&s[o][1].apply(t.element,i)}},
W=Math.max,C=Math.abs,o=/left|center|right/,s=/top|center|bottom/,r=/[\+\-]\d+(\.[\d]+)?%?/,l=/^\w+/,a=/%$/,h=x.fn.position,x.position={scrollbarWidth:function(){var t,e,i;return void 0!==n?n:(i=(e=x("<div style='display:block;position:absolute;width:200px;height:200px;overflow:hidden;'><div style='height:300px;width:auto;'></div></div>")).children()[0],x("body").append(e),t=i.offsetWidth,e.css("overflow","scroll"),t===(i=i.offsetWidth)&&(i=e[0].clientWidth),e.remove(),n=t-i)},getScrollInfo:function(t){var e=t.isWindow||t.isDocument?"":t.element.css("overflow-x"),i=t.isWindow||t.isDocument?"":t.element.css("overflow-y"),e="scroll"===e||"auto"===e&&t.width<t.element[0].scrollWidth;return{width:"scroll"===i||"auto"===i&&t.height<t.element[0].scrollHeight?x.position.scrollbarWidth():0,height:e?x.position.scrollbarWidth():0}},getWithinInfo:function(t){var e=x(t||window),i=N(e[0]),n=!!e[0]&&9===e[0].nodeType;return{element:e,isWindow:i,isDocument:n,offset:!i&&!n?x(t).offset():{left:0,top:0},scrollLeft:e.scrollLeft(),scrollTop:e.scrollTop(),width:e.outerWidth(),height:e.outerHeight()}}},x.fn.position=function(f){var c,d,p,g,m,v,y,w,b,_,t,e;return f&&f.of?(v="string"==typeof(f=x.extend({},f)).of?x(document).find(f.of):x(f.of),y=x.position.getWithinInfo(f.within),w=x.position.getScrollInfo(y),b=(f.collision||"flip").split(" "),_={},e=9===(e=(t=v)[0]).nodeType?{width:t.width(),height:t.height(),offset:{top:0,left:0}}:N(e)?{width:t.width(),height:t.height(),offset:{top:t.scrollTop(),left:t.scrollLeft()}}:e.preventDefault?{width:0,height:0,offset:{top:e.pageY,left:e.pageX}}:{width:t.outerWidth(),height:t.outerHeight(),offset:t.offset()},v[0].preventDefault&&(f.at="left top"),d=e.width,p=e.height,m=x.extend({},g=e.offset),x.each(["my","at"],function(){var t,e,i=(f[this]||"").split(" ");(i=1===i.length?o.test(i[0])?i.concat(["center"]):s.test(i[0])?["center"].concat(i):["center","center"]:i)[0]=o.test(i[0])?i[0]:"center",i[1]=s.test(i[1])?i[1]:"center",t=r.exec(i[0]),e=r.exec(i[1]),_[this]=[t?t[0]:0,e?e[0]:0],f[this]=[l.exec(i[0])[0],l.exec(i[1])[0]]}),1===b.length&&(b[1]=b[0]),"right"===f.at[0]?m.left+=d:"center"===f.at[0]&&(m.left+=d/2),"bottom"===f.at[1]?m.top+=p:"center"===f.at[1]&&(m.top+=p/2),c=E(_.at,d,p),m.left+=c[0],m.top+=c[1],this.each(function(){var i,t,r=x(this),l=r.outerWidth(),a=r.outerHeight(),e=L(this,"marginLeft"),n=L(this,"marginTop"),o=l+e+L(this,"marginRight")+w.width,s=a+n+L(this,"marginBottom")+w.height,h=x.extend({},m),u=E(_.my,r.outerWidth(),r.outerHeight());"right"===f.my[0]?h.left-=l:"center"===f.my[0]&&(h.left-=l/2),"bottom"===f.my[1]?h.top-=a:"center"===f.my[1]&&(h.top-=a/2),h.left+=u[0],h.top+=u[1],i={marginLeft:e,marginTop:n},x.each(["left","top"],function(t,e){x.ui.position[b[t]]&&x.ui.position[b[t]][e](h,{targetWidth:d,targetHeight:p,elemWidth:l,elemHeight:a,collisionPosition:i,collisionWidth:o,collisionHeight:s,offset:[c[0]+u[0],c[1]+u[1]],my:f.my,at:f.at,within:y,elem:r})}),f.using&&(t=function(t){var e=g.left-h.left,i=e+d-l,n=g.top-h.top,o=n+p-a,s={target:{element:v,left:g.left,top:g.top,width:d,height:p},element:{element:r,left:h.left,top:h.top,width:l,height:a},horizontal:i<0?"left":0<e?"right":"center",vertical:o<0?"top":0<n?"bottom":"middle"};d<l&&C(e+i)<d&&(s.horizontal="center"),p<a&&C(n+o)<p&&(s.vertical="middle"),W(C(e),C(i))>W(C(n),C(o))?s.important="horizontal":s.important="vertical",f.using.call(this,t,s)}),r.offset(x.extend(h,{using:t}))})):h.apply(this,arguments)},x.ui.position={fit:{left:function(t,e){var i,n=e.within,o=n.isWindow?n.scrollLeft:n.offset.left,n=n.width,s=t.left-e.collisionPosition.marginLeft,r=o-s,l=s+e.collisionWidth-n-o;e.collisionWidth>n?0<r&&l<=0?(i=t.left+r+e.collisionWidth-n-o,t.left+=r-i):t.left=!(0<l&&r<=0)&&l<r?o+n-e.collisionWidth:o:0<r?t.left+=r:0<l?t.left-=l:t.left=W(t.left-s,t.left)},top:function(t,e){var i,n=e.within,n=n.isWindow?n.scrollTop:n.offset.top,o=e.within.height,s=t.top-e.collisionPosition.marginTop,r=n-s,l=s+e.collisionHeight-o-n;e.collisionHeight>o?0<r&&l<=0?(i=t.top+r+e.collisionHeight-o-n,t.top+=r-i):t.top=!(0<l&&r<=0)&&l<r?n+o-e.collisionHeight:n:0<r?t.top+=r:0<l?t.top-=l:t.top=W(t.top-s,t.top)}},flip:{left:function(t,e){var i=e.within,n=i.offset.left+i.scrollLeft,o=i.width,i=i.isWindow?i.scrollLeft:i.offset.left,s=t.left-e.collisionPosition.marginLeft,r=s-i,s=s+e.collisionWidth-o-i,l="left"===e.my[0]?-e.elemWidth:"right"===e.my[0]?e.elemWidth:0,a="left"===e.at[0]?e.targetWidth:"right"===e.at[0]?-e.targetWidth:0,h=-2*e.offset[0];r<0?((o=t.left+l+a+h+e.collisionWidth-o-n)<0||o<C(r))&&(t.left+=l+a+h):0<s&&(0<(n=t.left-e.collisionPosition.marginLeft+l+a+h-i)||C(n)<s)&&(t.left+=l+a+h)},top:function(t,e){var i=e.within,n=i.offset.top+i.scrollTop,o=i.height,i=i.isWindow?i.scrollTop:i.offset.top,s=t.top-e.collisionPosition.marginTop,r=s-i,s=s+e.collisionHeight-o-i,l="top"===e.my[1]?-e.elemHeight:"bottom"===e.my[1]?e.elemHeight:0,a="top"===e.at[1]?e.targetHeight:"bottom"===e.at[1]?-e.targetHeight:0,h=-2*e.offset[1];r<0?((o=t.top+l+a+h+e.collisionHeight-o-n)<0||o<C(r))&&(t.top+=l+a+h):0<s&&(0<(n=t.top-e.collisionPosition.marginTop+l+a+h-i)||C(n)<s)&&(t.top+=l+a+h)}},flipfit:{left:function(){x.ui.position.flip.left.apply(this,arguments),x.ui.position.fit.left.apply(this,arguments)},top:function(){x.ui.position.flip.top.apply(this,arguments),x.ui.position.fit.top.apply(this,arguments)}}},x.ui.safeActiveElement=function(e){var i;try{i=e.activeElement}catch(t){i=e.body}return i=(i=i||e.body).nodeName?i:e.body},x.ui.safeBlur=function(t){t&&"body"!==t.nodeName.toLowerCase()&&x(t).trigger("blur")},
x.fn.scrollParent=function(t){var e=this.css("position"),i="absolute"===e,n=t?/(auto|scroll|hidden)/:/(auto|scroll)/,t=this.parents().filter(function(){var t=x(this);return(!i||"static"!==t.css("position"))&&n.test(t.css("overflow")+t.css("overflow-y")+t.css("overflow-x"))}).eq(0);return"fixed"!==e&&t.length?t:x(this[0].ownerDocument||document)},
x.extend(x.expr.pseudos,{tabbable:function(t){var e=x.attr(t,"tabindex"),i=null!=e;return(!i||0<=e)&&x.ui.focusable(t,i)}}),
x.fn.extend({uniqueId:(u=0,function(){return this.each(function(){this.id||(this.id="ui-id-"+ ++u)})}),removeUniqueId:function(){return this.each(function(){/^ui-id-\d+$/.test(this.id)&&x(this).removeAttr("id")})}});
var f,c=0,d=Array.prototype.hasOwnProperty,p=Array.prototype.slice;x.cleanData=(f=x.cleanData,function(t){for(var e,i,n=0;null!=(i=t[n]);n++)(e=x._data(i,"events"))&&e.remove&&x(i).triggerHandler("remove");f(t)}),x.widget=function(t,i,e){var n,o,s,r={},l=t.split(".")[0],a=l+"-"+(t=t.split(".")[1]);return e||(e=i,i=x.Widget),Array.isArray(e)&&(e=x.extend.apply(null,[{}].concat(e))),x.expr.pseudos[a.toLowerCase()]=function(t){return!!x.data(t,a)},x[l]=x[l]||{},n=x[l][t],o=x[l][t]=function(t,e){if(!this||!this._createWidget)return new o(t,e);arguments.length&&this._createWidget(t,e)},x.extend(o,n,{version:e.version,_proto:x.extend({},e),_childConstructors:[]}),(s=new i).options=x.widget.extend({},s.options),x.each(e,function(e,n){function o(){return i.prototype[e].apply(this,arguments)}function s(t){return i.prototype[e].apply(this,t)}r[e]="function"!=typeof n?n:function(){var t,e=this._super,i=this._superApply;return this._super=o,this._superApply=s,t=n.apply(this,arguments),this._super=e,this._superApply=i,t}}),o.prototype=x.widget.extend(s,{widgetEventPrefix:n&&s.widgetEventPrefix||t},r,{constructor:o,namespace:l,widgetName:t,widgetFullName:a}),n?(x.each(n._childConstructors,function(t,e){var i=e.prototype;x.widget(i.namespace+"."+i.widgetName,o,e._proto)}),delete n._childConstructors):i._childConstructors.push(o),x.widget.bridge(t,o),o},x.widget.extend=function(t){for(var e,i,n=p.call(arguments,1),o=0,s=n.length;o<s;o++)for(e in n[o])i=n[o][e],d.call(n[o],e)&&void 0!==i&&(x.isPlainObject(i)?t[e]=x.isPlainObject(t[e])?x.widget.extend({},t[e],i):x.widget.extend({},i):t[e]=i);return t},x.widget.bridge=function(s,e){var r=e.prototype.widgetFullName||s;x.fn[s]=function(i){var t="string"==typeof i,n=p.call(arguments,1),o=this;return t?this.length||"instance"!==i?this.each(function(){var t,e=x.data(this,r);return"instance"===i?(o=e,!1):e?"function"!=typeof e[i]||"_"===i.charAt(0)?x.error("no such method '"+i+"' for "+s+" widget instance"):(t=e[i].apply(e,n))!==e&&void 0!==t?(o=t&&t.jquery?o.pushStack(t.get()):t,!1):void 0:x.error("cannot call methods on "+s+" prior to initialization; attempted to call method '"+i+"'")}):o=void 0:(n.length&&(i=x.widget.extend.apply(null,[i].concat(n))),this.each(function(){var t=x.data(this,r);t?(t.option(i||{}),t._init&&t._init()):x.data(this,r,new e(i,this))})),o}},x.Widget=function(){},x.Widget._childConstructors=[],x.Widget.prototype={widgetName:"widget",widgetEventPrefix:"",defaultElement:"<div>",options:{classes:{},disabled:!1,create:null},_createWidget:function(t,e){e=x(e||this.defaultElement||this)[0],this.element=x(e),this.uuid=c++,this.eventNamespace="."+this.widgetName+this.uuid,this.bindings=x(),this.hoverable=x(),this.focusable=x(),this.classesElementLookup={},e!==this&&(x.data(e,this.widgetFullName,this),this._on(!0,this.element,{remove:function(t){t.target===e&&this.destroy()}}),this.document=x(e.style?e.ownerDocument:e.document||e),this.window=x(this.document[0].defaultView||this.document[0].parentWindow)),this.options=x.widget.extend({},this.options,this._getCreateOptions(),t),this._create(),this.options.disabled&&this._setOptionDisabled(this.options.disabled),this._trigger("create",null,this._getCreateEventData()),this._init()},_getCreateOptions:function(){return{}},_getCreateEventData:x.noop,_create:x.noop,_init:x.noop,destroy:function(){var i=this;this._destroy(),x.each(this.classesElementLookup,function(t,e){i._removeClass(e,t)}),this.element.off(this.eventNamespace).removeData(this.widgetFullName),this.widget().off(this.eventNamespace).removeAttr("aria-disabled"),this.bindings.off(this.eventNamespace)},_destroy:x.noop,widget:function(){return this.element},option:function(t,e){var i,n,o,s=t;if(0===arguments.length)return x.widget.extend({},this.options);if("string"==typeof t)if(s={},t=(i=t.split(".")).shift(),i.length){for(n=s[t]=x.widget.extend({},this.options[t]),o=0;o<i.length-1;o++)n[i[o]]=n[i[o]]||{},n=n[i[o]];if(t=i.pop(),1===arguments.length)return void 0===n[t]?null:n[t];n[t]=e}else{if(1===arguments.length)return void 0===this.options[t]?null:this.options[t];s[t]=e}return this._setOptions(s),this},_setOptions:function(t){for(var e in t)this._setOption(e,t[e]);return this},_setOption:function(t,e){return"classes"===t&&this._setOptionClasses(e),this.options[t]=e,"disabled"===t&&this._setOptionDisabled(e),this},_setOptionClasses:function(t){var e,i,n;for(e in t)n=this.classesElementLookup[e],t[e]!==this.options.classes[e]&&n&&n.length&&(i=x(n.get()),this._removeClass(n,e),i.addClass(this._classes({element:i,keys:e,classes:t,add:!0})))},_setOptionDisabled:function(t){this._toggleClass(this.widget(),this.widgetFullName+"-disabled",null,!!t),t&&(this._removeClass(this.hoverable,null,"ui-state-hover"),this._removeClass(this.focusable,null,"ui-state-focus"))},enable:function(){return this._setOptions({disabled:!1})},disable:function(){return this._setOptions({disabled:!0})},_classes:function(o){var s=[],r=this;function t(t,e){for(var i,n=0;n<t.length;n++)i=r.classesElementLookup[t[n]]||x(),i=o.add?(function(){var i=[];o.element.each(function(t,e){x.map(r.classesElementLookup,function(t){return t}).some(function(t){return t.is(e)})||i.push(e)}),r._on(x(i),{remove:"_untrackClassesElement"})}(),x(x.uniqueSort(i.get().concat(o.element.get())))):x(i.not(o.element).get()),r.classesElementLookup[t[n]]=i,s.push(t[n]),e&&o.classes[t[n]]&&s.push(o.classes[t[n]])}return(o=x.extend({element:this.element,classes:this.options.classes||{}},o)).keys&&t(o.keys.match(/\S+/g)||[],!0),o.extra&&t(o.extra.match(/\S+/g)||[]),s.join(" ")},_untrackClassesElement:function(i){var n=this;x.each(n.classesElementLookup,function(t,e){-1!==x.inArray(i.target,e)&&(n.classesElementLookup[t]=x(e.not(i.target).get()))}),this._off(x(i.target))},_removeClass:function(t,e,i){return this._toggleClass(t,e,i,!1)},_addClass:function(t,e,i){return this._toggleClass(t,e,i,!0)},_toggleClass:function(t,e,i,n){var o="string"==typeof t||null===t,e={extra:o?e:i,keys:o?t:e,element:o?this.element:t,add:n="boolean"==typeof n?n:i};return e.element.toggleClass(this._classes(e),n),this},_on:function(o,s,t){var r,l=this;"boolean"!=typeof o&&(t=s,s=o,o=!1),t?(s=r=x(s),this.bindings=this.bindings.add(s)):(t=s,s=this.element,r=this.widget()),x.each(t,function(t,e){function i(){if(o||!0!==l.options.disabled&&!x(this).hasClass("ui-state-disabled"))return("string"==typeof e?l[e]:e).apply(l,arguments)}"string"!=typeof e&&(i.guid=e.guid=e.guid||i.guid||x.guid++);var t=t.match(/^([\w:-]*)\s*(.*)$/),n=t[1]+l.eventNamespace,t=t[2];t?r.on(n,t,i):s.on(n,i)})},_off:function(t,e){e=(e||"").split(" ").join(this.eventNamespace+" ")+this.eventNamespace,t.off(e),this.bindings=x(this.bindings.not(t).get()),this.focusable=x(this.focusable.not(t).get()),this.hoverable=x(this.hoverable.not(t).get())},_delay:function(t,e){var i=this;return setTimeout(function(){return("string"==typeof t?i[t]:t).apply(i,arguments)},e||0)},_hoverable:function(t){this.hoverable=this.hoverable.add(t),this._on(t,{mouseenter:function(t){this._addClass(x(t.currentTarget),null,"ui-state-hover")},mouseleave:function(t){this._removeClass(x(t.currentTarget),null,"ui-state-hover")}})},_focusable:function(t){this.focusable=this.focusable.add(t),this._on(t,{focusin:function(t){this._addClass(x(t.currentTarget),null,"ui-state-focus")},focusout:function(t){this._removeClass(x(t.currentTarget),null,"ui-state-focus")}})},_trigger:function(t,e,i){var n,o,s=this.options[t];if(i=i||{},(e=x.Event(e)).type=(t===this.widgetEventPrefix?t:this.widgetEventPrefix+t).toLowerCase(),e.target=this.element[0],o=e.originalEvent)for(n in o)n in e||(e[n]=o[n]);return this.element.trigger(e,i),!("function"==typeof s&&!1===s.apply(this.element[0],[e].concat(i))||e.isDefaultPrevented())}},x.each({show:"fadeIn",hide:"fadeOut"},function(s,r){x.Widget.prototype["_"+s]=function(e,t,i){var n,o=(t="string"==typeof t?{effect:t}:t)?!0!==t&&"number"!=typeof t&&t.effect||r:s;"number"==typeof(t=t||{})?t={duration:t}:!0===t&&(t={}),n=!x.isEmptyObject(t),t.complete=i,t.delay&&e.delay(t.delay),n&&x.effects&&x.effects.effect[o]?e[s](t):o!==s&&e[o]?e[o](t.duration,t.easing,i):e.queue(function(t){x(this)[s](),i&&i.call(e[0]),t()})}})});