var PUM,PUM_Accessibility,PUM_Analytics,pm_cookie,pm_cookie_json,pm_remove_cookie;!function(i){"use strict";void 0===i.fn.on&&(i.fn.on=function(e,o,t){return this.delegate(o,e,t)}),void 0===i.fn.off&&(i.fn.off=function(e,o,t){return this.undelegate(o,e,t)}),void 0===i.fn.bindFirst&&(i.fn.bindFirst=function(e,o){var t=i(this);t.unbind(e,o),t.bind(e,o),(t=(o=i._data(t[0]).events)[e]).unshift(t.pop()),o[e]=t}),void 0===i.fn.outerHtml&&(i.fn.outerHtml=function(){var e=i(this).clone();return i("<div/>").append(e).html()}),void 0===i.fn.isInViewport&&(i.fn.isInViewport=function(){var e=i(this).offset().top,o=e+i(this).outerHeight(),t=i(window).scrollTop(),n=t+i(window).height();return t<o&&e<n}),void 0===Date.now&&(Date.now=function(){return(new Date).getTime()})}(jQuery),function(a,r,s){"use strict";function n(e,o){function t(e,o,t){return o?e[o.slice(0,t?-1:o.length)]:e}return o.split(".").reduce(function(e,o){return o?o.split("[").reduce(t,e):e},e)}window.pum_vars=window.pum_vars||{default_theme:"0",home_url:"/",version:1.7,pm_dir_url:"",ajaxurl:"",restapi:!1,analytics_api:!1,rest_nonce:null,debug_mode:!1,disable_tracking:!0,message_position:"top",core_sub_forms_enabled:!0,popups:{}},window.pum_popups=window.pum_popups||{},window.pum_vars.popups=window.pum_popups,PUM={get:new function(){function e(e,o,t){"boolean"==typeof o&&(t=o,o=!1);var n=o?o.selector+" "+e:e;return s!==i[n]&&!t||(i[n]=o?o.find(e):jQuery(e)),i[n]}var i={};return e.elementCache=i,e},getPopup:function(e){var o;return o=e,(e=isNaN(o)||parseInt(Number(o))!==parseInt(o)||isNaN(parseInt(o,10))?"current"===e?PUM.get(".pum-overlay.pum-active:eq(0)",!0):"open"===e?PUM.get(".pum-overlay.pum-active",!0):"closed"===e?PUM.get(".pum-overlay:not(.pum-active)",!0):e instanceof jQuery?e:a(e):PUM.get("#pum-"+e)).hasClass("pum-overlay")?e:e.hasClass("popmake")||e.parents(".pum-overlay").length?e.parents(".pum-overlay"):a()},open:function(e,o){PUM.getPopup(e).popmake("open",o)},close:function(e,o){PUM.getPopup(e).popmake("close",o)},preventOpen:function(e){PUM.getPopup(e).addClass("preventOpen")},getSettings:function(e){return PUM.getPopup(e).popmake("getSettings")},getSetting:function(e,o,t){o=n(PUM.getSettings(e),o);return void 0!==o?o:t!==s?t:null},checkConditions:function(e){return PUM.getPopup(e).popmake("checkConditions")},getCookie:function(e){return a.pm_cookie(e)},getJSONCookie:function(e){return a.pm_cookie_json(e)},setCookie:function(e,o){PUM.getPopup(e).popmake("setCookie",jQuery.extend({name:"pum-"+PUM.getSetting(e,"id"),expires:"+30 days"},o))},clearCookie:function(e,o){a.pm_remove_cookie(e),"function"==typeof o&&o()},clearCookies:function(e,o){var t,n=PUM.getPopup(e).popmake("getSettings").cookies;if(n!==s&&n.length)for(t=0;n.length>t;t+=1)a.pm_remove_cookie(n[t].settings.name);"function"==typeof o&&o()},getClickTriggerSelector:function(e,o){var t=PUM.getPopup(e),e=PUM.getSettings(e),e=[".popmake-"+e.id,".popmake-"+decodeURIComponent(e.slug),'a[href$="#popmake-'+e.id+'"]'];return o.extra_selectors&&""!==o.extra_selectors&&e.push(o.extra_selectors),(e=pum.hooks.applyFilters("pum.trigger.click_open.selectors",e,o,t)).join(", ")},disableClickTriggers:function(e,o){if(e!==s)if(o!==s){var t=PUM.getClickTriggerSelector(e,o);a(t).removeClass("pum-trigger"),a(r).off("click.pumTrigger click.popmakeOpen",t)}else{var n=PUM.getSetting(e,"triggers",[]);if(n.length)for(var i=0;n.length>i;i++)-1!==pum.hooks.applyFilters("pum.disableClickTriggers.clickTriggerTypes",["click_open"]).indexOf(n[i].type)&&(t=PUM.getClickTriggerSelector(e,n[i].settings),a(t).removeClass("pum-trigger"),a(r).off("click.pumTrigger click.popmakeOpen",t))}},actions:{stopIframeVideosPlaying:function(){var e=PUM.getPopup(this),o=e.popmake("getContainer");e.hasClass("pum-has-videos")||(o.find("iframe").filter('[src*="youtube"],[src*="vimeo"]').each(function(){var e=a(this),o=e.attr("src"),t=o.replace("autoplay=1","1=1");t!==o&&(o=t),e.prop("src",o)}),o.find("video").each(function(){this.pause()}))}}},a.fn.popmake=function(e){return a.fn.popmake.methods[e]?(a(r).trigger("pumMethodCall",arguments),a.fn.popmake.methods[e].apply(this,Array.prototype.slice.call(arguments,1))):"object"!=typeof e&&e?void(window.console&&console.warn("Method "+e+" does not exist on $.fn.popmake")):a.fn.popmake.methods.init.apply(this,arguments)},a.fn.popmake.methods={init:function(){return this.each(function(){var e,o=PUM.getPopup(this),t=o.popmake("getSettings");return t.theme_id<=0&&(t.theme_id=pum_vars.default_theme),t.disable_reposition!==s&&t.disable_reposition||a(window).on("resize",function(){(o.hasClass("pum-active")||o.find(".popmake.active").length)&&a.fn.popmake.utilities.throttle(setTimeout(function(){o.popmake("reposition")},25),500,!1)}),o.find(".pum-container").data("popmake",t),o.data("popmake",t).trigger("pumInit"),t.open_sound&&"none"!==t.open_sound&&((e="custom"!==t.open_sound?new Audio(pum_vars.pm_dir_url+"/assets/sounds/"+t.open_sound):new Audio(t.custom_sound)).addEventListener("canplaythrough",function(){o.data("popAudio",e)}),e.addEventListener("error",function(){console.warn("Error occurred when trying to load Popup opening sound.")}),e.load()),this})},getOverlay:function(){return PUM.getPopup(this)},getContainer:function(){return PUM.getPopup(this).find(".pum-container")},getTitle:function(){return PUM.getPopup(this).find(".pum-title")||null},getContent:function(){return PUM.getPopup(this).find(".pum-content")||null},getClose:function(){return PUM.getPopup(this).find(".pum-content + .pum-close")||null},getSettings:function(){var e=PUM.getPopup(this);return a.extend(!0,{},a.fn.popmake.defaults,e.data("popmake")||{},"object"==typeof pum_popups&&void 0!==pum_popups[e.attr("id")]?pum_popups[e.attr("id")]:{})},state:function(e){var o=PUM.getPopup(this);if(s!==e)switch(e){case"isOpen":return o.hasClass("pum-open")||o.popmake("getContainer").hasClass("active");case"isClosed":return!o.hasClass("pum-open")&&!o.popmake("getContainer").hasClass("active")}},open:function(e){var o=PUM.getPopup(this),t=o.popmake("getContainer"),n=o.popmake("getClose"),i=o.popmake("getSettings"),r=a("html");return o.trigger("pumBeforeOpen"),o.hasClass("preventOpen")||t.hasClass("preventOpen")?(console.log("prevented"),o.removeClass("preventOpen").removeClass("pum-active").trigger("pumOpenPrevented")):(i.stackable||o.popmake("close_all"),o.addClass("pum-active"),0<i.close_button_delay&&n.fadeOut(0),r.addClass("pum-open"),i.overlay_disabled?r.addClass("pum-open-overlay-disabled"):r.addClass("pum-open-overlay"),i.position_fixed?r.addClass("pum-open-fixed"):r.addClass("pum-open-scrollable"),o.popmake("setup_close").popmake("reposition").popmake("animate",i.animation_type,function(){0<i.close_button_delay&&setTimeout(function(){n.fadeIn()},i.close_button_delay),o.trigger("pumAfterOpen"),a(window).trigger("resize"),a.fn.popmake.last_open_popup=o,e!==s&&e()}),void 0!==o.data("popAudio")&&o.data("popAudio").play().catch(function(e){console.warn("Sound was not able to play when popup opened. Reason: "+e)})),this},setup_close:function(){var t=PUM.getPopup(this),e=t.popmake("getClose"),n=t.popmake("getSettings");return(e=e.add(a(".popmake-close, .pum-close",t).not(e))).off("click.pum").on("click.pum",function(e){var o=a(this);o.hasClass("pum-do-default")||o.data("do-default")!==s&&o.data("do-default")||e.preventDefault(),a.fn.popmake.last_close_trigger="Close Button",t.popmake("close")}),(n.close_on_esc_press||n.close_on_f4_press)&&a(window).off("keyup.popmake").on("keyup.popmake",function(e){27===e.keyCode&&n.close_on_esc_press&&(a.fn.popmake.last_close_trigger="ESC Key",t.popmake("close")),115===e.keyCode&&n.close_on_f4_press&&(a.fn.popmake.last_close_trigger="F4 Key",t.popmake("close"))}),n.close_on_overlay_click&&(t.on("pumAfterOpen",function(){a(r).on("click.pumCloseOverlay",function(e){a(e.target).closest(".pum-container").length||(a.fn.popmake.last_close_trigger="Overlay Click",t.popmake("close"))})}),t.on("pumAfterClose",function(){a(r).off("click.pumCloseOverlay")})),n.close_on_form_submission&&PUM.hooks.addAction("pum.integration.form.success",function(e,o){o.popup&&o.popup[0]===t[0]&&setTimeout(function(){a.fn.popmake.last_close_trigger="Form Submission",t.popmake("close")},n.close_on_form_submission_delay||0)}),t.trigger("pumSetupClose"),this},close:function(n){return this.each(function(){var e=PUM.getPopup(this),o=e.popmake("getContainer"),t=(t=e.popmake("getClose")).add(a(".popmake-close, .pum-close",e).not(t));return e.trigger("pumBeforeClose"),e.hasClass("preventClose")||o.hasClass("preventClose")?e.removeClass("preventClose").trigger("pumClosePrevented"):o.fadeOut("fast",function(){e.is(":visible")&&e.fadeOut("fast"),a(window).off("keyup.popmake"),e.off("click.popmake"),t.off("click.popmake"),1===a(".pum-active").length&&a("html").removeClass("pum-open").removeClass("pum-open-scrollable").removeClass("pum-open-overlay").removeClass("pum-open-overlay-disabled").removeClass("pum-open-fixed"),e.removeClass("pum-active").trigger("pumAfterClose"),n!==s&&n()}),this})},close_all:function(){return a(".pum-active").popmake("close"),this},reposition:function(e){var o=PUM.getPopup(this).trigger("pumBeforeReposition"),t=o.popmake("getContainer"),n=o.popmake("getSettings"),i=n.location,r={my:"",at:"",of:window,collision:"none",using:"function"==typeof e?e:a.fn.popmake.callbacks.reposition_using},e={overlay:null,container:null},s=null;try{s=a(a.fn.popmake.last_open_trigger)}catch(e){s=a()}return n.position_from_trigger&&s.length?(r.of=s,0<=i.indexOf("left")&&(r.my+=" right",r.at+=" left"+(0!==n.position_left?"-"+n.position_left:"")),0<=i.indexOf("right")&&(r.my+=" left",r.at+=" right"+(0!==n.position_right?"+"+n.position_right:"")),0<=i.indexOf("center")&&(r.my="center"===i?"center":r.my+" center",r.at="center"===i?"center":r.at+" center"),0<=i.indexOf("top")&&(r.my+=" bottom",r.at+=" top"+(0!==n.position_top?"-"+n.position_top:"")),0<=i.indexOf("bottom")&&(r.my+=" top",r.at+=" bottom"+(0!==n.position_bottom?"+"+n.position_bottom:""))):(0<=i.indexOf("left")&&(r.my+=" left"+(0!==n.position_left?"+"+n.position_left:""),r.at+=" left"),0<=i.indexOf("right")&&(r.my+=" right"+(0!==n.position_right?"-"+n.position_right:""),r.at+=" right"),0<=i.indexOf("center")&&(r.my="center"===i?"center":r.my+" center",r.at="center"===i?"center":r.at+" center"),0<=i.indexOf("top")&&(r.my+=" top"+(0!==n.position_top?"+"+(a("body").hasClass("admin-bar")?parseInt(n.position_top,10)+32:n.position_top):""),r.at+=" top"),0<=i.indexOf("bottom")&&(r.my+=" bottom"+(0!==n.position_bottom?"-"+n.position_bottom:""),r.at+=" bottom")),r.my=a.trim(r.my),r.at=a.trim(r.at),o.is(":hidden")&&(e.overlay=o.css("opacity"),o.css({opacity:0}).show(0)),t.is(":hidden")&&(e.container=t.css("opacity"),t.css({opacity:0}).show(0)),n.position_fixed&&t.addClass("fixed"),"custom"===n.size?t.css({width:n.custom_width,height:n.custom_height_auto?"auto":n.custom_height}):"auto"!==n.size&&t.addClass("responsive").css({minWidth:""!==n.responsive_min_width?n.responsive_min_width:"auto",maxWidth:""!==n.responsive_max_width?n.responsive_max_width:"auto"}),o.trigger("pumAfterReposition"),t.addClass("custom-position").position(r).trigger("popmakeAfterReposition"),"center"===i&&t[0].offsetTop<0&&t.css({top:a("body").hasClass("admin-bar")?42:10}),e.overlay&&o.css({opacity:e.overlay}).hide(0),e.container&&t.css({opacity:e.container}).hide(0),this},animation_origin:function(e){var o=PUM.getPopup(this).popmake("getContainer"),t={my:"",at:""};switch(e){case"top":t={my:"left+"+o.offset().left+" bottom-100",at:"left top"};break;case"bottom":t={my:"left+"+o.offset().left+" top+100",at:"left bottom"};break;case"left":t={my:"right top+"+o.offset().top,at:"left top"};break;case"right":t={my:"left top+"+o.offset().top,at:"right top"};break;default:0<=e.indexOf("left")&&(t={my:t.my+" right",at:t.at+" left"}),0<=e.indexOf("right")&&(t={my:t.my+" left",at:t.at+" right"}),0<=e.indexOf("center")&&(t={my:t.my+" center",at:t.at+" center"}),0<=e.indexOf("top")&&(t={my:t.my+" bottom-100",at:t.at+" top"}),(t=0<=e.indexOf("bottom")?{my:t.my+" top+100",at:t.at+" bottom"}:t).my=a.trim(t.my),t.at=a.trim(t.at)}return t.of=window,t.collision="none",t}}}(jQuery,document),function(e){"use strict";e.fn.popmake.version=1.8,e.fn.popmake.last_open_popup=null,window.ajaxurl=window.pum_vars.ajaxurl,window.PUM.init=function(){console.log("init popups ✔"),e(void 0).trigger("pumBeforeInit"),e(".pum").popmake(),e(void 0).trigger("pumInitialized"),"object"==typeof pum_vars.form_success&&(pum_vars.form_success=e.extend({popup_id:null,settings:{}}),PUM.forms.success(pum_vars.form_success.popup_id,pum_vars.form_success.settings)),PUM.integrations.init()},e(function(){var e=PUM.hooks.applyFilters("pum.initHandler",PUM.init),o=PUM.hooks.applyFilters("pum.initPromises",[]);Promise.all(o).then(e)}),e(".pum").on("pumInit",function(){var e=PUM.getPopup(this),o=PUM.getSetting(e,"id"),e=e.find("form");e.length&&e.append('<input type="hidden" name="pum_form_popup_id" value="'+o+'" />')}).on("pumAfterClose",window.PUM.actions.stopIframeVideosPlaying)}(jQuery),function(i,t){"use strict";var n,r,s,a="a[href], area[href], input:not([disabled]), select:not([disabled]), textarea:not([disabled]), button:not([disabled]), iframe, object, embed, *[tabindex], *[contenteditable]",e=".pum:not(.pum-accessibility-disabled)";PUM_Accessibility={forceFocus:function(e){s&&s.length&&!s[0].contains(e.target)&&(e.stopPropagation(),PUM_Accessibility.setFocusToFirstItem())},trapTabKey:function(e){var o,t,n;9===e.keyCode&&(o=s.find(".pum-container *").filter(a).filter(":visible"),n=i(":focus"),t=o.length,n=o.index(n),e.shiftKey?0===n&&(o.get(t-1).focus(),e.preventDefault()):n===t-1&&(o.get(0).focus(),e.preventDefault()))},setFocusToFirstItem:function(){s.find(".pum-container *").filter(a).filter(":visible").first().focus()},initiateFocusLock:function(){var e=PUM.getPopup(this),o=i(":focus");e.has(o).length||(r=o),s=e.on("keydown.pum_accessibility",PUM_Accessibility.trapTabKey).attr("aria-hidden","false"),(n=i('body > *:not([aria-hidden="true"])').filter(":visible").not(s)).attr("aria-hidden","true"),i(t).one("focusin.pum_accessibility",PUM_Accessibility.forceFocus),PUM_Accessibility.setFocusToFirstItem()}},i(t).on("pumInit",e,function(){PUM.getPopup(this).find("[tabindex]").each(function(){var e=i(this);e.data("tabindex",e.attr("tabindex")).prop("tabindex","0")})}).on("pumBeforeOpen",e,function(){}).on("pumAfterOpen",e,PUM_Accessibility.initiateFocusLock).on("pumBeforeClose",e,function(){}).on("pumAfterClose",e,function(){PUM.getPopup(this).off("keydown.pum_accessibility").attr("aria-hidden","true"),n&&(n.attr("aria-hidden","false"),n=null),void 0!==r&&r.length&&r.focus(),s=null,i(t).off("focusin.pum_accessibility")}).on("pumSetupClose",e,function(){}).on("pumOpenPrevented",e,function(){}).on("pumClosePrevented",e,function(){}).on("pumBeforeReposition",e,function(){})}(jQuery,document),function(i){"use strict";i.fn.popmake.last_open_trigger=null,i.fn.popmake.last_close_trigger=null,i.fn.popmake.conversion_trigger=null;var r=!(void 0===pum_vars.analytics_api||!pum_vars.analytics_api);PUM_Analytics={beacon:function(e,o){var t=new Image,n=r?pum_vars.analytics_api:pum_vars.ajaxurl,o={route:pum.hooks.applyFilters("pum.analyticsBeaconRoute","/"+pum_vars.analytics_route+"/"),data:pum.hooks.applyFilters("pum.AnalyticsBeaconData",i.extend(!0,{event:"open",pid:null,_cache:+new Date},e)),callback:"function"==typeof o?o:function(){}};r?n+=o.route:o.data.action="pum_analytics",n&&(i(t).on("error success load done",o.callback),t.src=n+"?"+i.param(o.data))}},void 0!==pum_vars.disable_tracking&&pum_vars.disable_tracking||void 0!==pum_vars.disable_core_tracking&&pum_vars.disable_core_tracking||(i(document).on("pumAfterOpen.core_analytics",".pum",function(){var e=PUM.getPopup(this),e={pid:parseInt(e.popmake("getSettings").id,10)||null};0<e.pid&&!i("body").hasClass("single-popup")&&PUM_Analytics.beacon(e)}),i(function(){PUM.hooks.addAction("pum.integration.form.success",function(e,o){!1!==o.ajax&&(0===o.popup.length||0<(o={pid:parseInt(o.popup.popmake("getSettings").id,10)||null,event:"conversion"}).pid&&!i("body").hasClass("single-popup")&&PUM_Analytics.beacon(o))})}))}(jQuery),function(n,r){"use strict";function s(e){var o=e.popmake("getContainer"),t={display:"",opacity:""};e.css(t),o.css(t)}function a(e){return e.overlay_disabled?0:e.animation_speed/2}function p(e){return e.overlay_disabled?parseInt(e.animation_speed):e.animation_speed/2}n.fn.popmake.methods.animate_overlay=function(e,o,t){return PUM.getPopup(this).popmake("getSettings").overlay_disabled?n.fn.popmake.overlay_animations.none.apply(this,[o,t]):n.fn.popmake.overlay_animations[e]?n.fn.popmake.overlay_animations[e].apply(this,[o,t]):(window.console&&console.warn("Animation style "+e+" does not exist."),this)},n.fn.popmake.methods.animate=function(e){return n.fn.popmake.animations[e]?n.fn.popmake.animations[e].apply(this,Array.prototype.slice.call(arguments,1)):(window.console&&console.warn("Animation style "+e+" does not exist."),this)},n.fn.popmake.animations={none:function(e){var o=PUM.getPopup(this);return o.popmake("getContainer").css({opacity:1,display:"block"}),o.popmake("animate_overlay","none",0,function(){e!==r&&e()}),this},slide:function(o){var e=PUM.getPopup(this),t=e.popmake("getContainer"),n=e.popmake("getSettings"),i=e.popmake("animation_origin",n.animation_origin);return s(e),t.position(i),e.popmake("animate_overlay","fade",a(n),function(){t.popmake("reposition",function(e){t.animate(e,p(n),"swing",function(){o!==r&&o()})})}),this},fade:function(e){var o=PUM.getPopup(this),t=o.popmake("getContainer"),n=o.popmake("getSettings");return s(o),o.css({opacity:0,display:"block"}),t.css({opacity:0,display:"block"}),o.popmake("animate_overlay","fade",a(n),function(){t.animate({opacity:1},p(n),"swing",function(){e!==r&&e()})}),this},fadeAndSlide:function(o){var e=PUM.getPopup(this),t=e.popmake("getContainer"),n=e.popmake("getSettings"),i=e.popmake("animation_origin",n.animation_origin);return s(e),e.css({display:"block",opacity:0}),t.css({display:"block",opacity:0}),t.position(i),e.popmake("animate_overlay","fade",a(n),function(){t.popmake("reposition",function(e){e.opacity=1,t.animate(e,p(n),"swing",function(){o!==r&&o()})})}),this},grow:function(e){return n.fn.popmake.animations.fade.apply(this,arguments)},growAndSlide:function(e){return n.fn.popmake.animations.fadeAndSlide.apply(this,arguments)}},n.fn.popmake.overlay_animations={none:function(e,o){PUM.getPopup(this).css({opacity:1,display:"block"}),"function"==typeof o&&o()},fade:function(e,o){PUM.getPopup(this).css({opacity:0,display:"block"}).animate({opacity:1},e,"swing",o)},slide:function(e,o){PUM.getPopup(this).slideDown(e,o)}}}(jQuery,void document),function(e,o){"use strict";e(o).on("pumInit",".pum",function(){e(this).popmake("getContainer").trigger("popmakeInit")}).on("pumBeforeOpen",".pum",function(){e(this).popmake("getContainer").addClass("active").trigger("popmakeBeforeOpen")}).on("pumAfterOpen",".pum",function(){e(this).popmake("getContainer").trigger("popmakeAfterOpen")}).on("pumBeforeClose",".pum",function(){e(this).popmake("getContainer").trigger("popmakeBeforeClose")}).on("pumAfterClose",".pum",function(){e(this).popmake("getContainer").removeClass("active").trigger("popmakeAfterClose")}).on("pumSetupClose",".pum",function(){e(this).popmake("getContainer").trigger("popmakeSetupClose")}).on("pumOpenPrevented",".pum",function(){e(this).popmake("getContainer").removeClass("preventOpen").removeClass("active")}).on("pumClosePrevented",".pum",function(){e(this).popmake("getContainer").removeClass("preventClose")}).on("pumBeforeReposition",".pum",function(){e(this).popmake("getContainer").trigger("popmakeBeforeReposition")})}(jQuery,document),function(o){"use strict";o.fn.popmake.callbacks={reposition_using:function(e){o(this).css(e)}}}(jQuery,document),function(p){"use strict";function u(){return e=void 0===e?"undefined"!=typeof MobileDetect?new MobileDetect(window.navigator.userAgent):{phone:function(){return!1},tablet:function(){return!1}}:e}var e;p.extend(p.fn.popmake.methods,{checkConditions:function(){var e,o,t,n,i,r=PUM.getPopup(this),s=r.popmake("getSettings"),a=!0;if(s.disable_on_mobile&&u().phone())return!1;if(s.disable_on_tablet&&u().tablet())return!1;if(s.conditions.length)for(o=0;s.conditions.length>o;o++){for(n=s.conditions[o],e=!1,t=0;n.length>t;t++)if("boolean"!=typeof n[t]){if((!(i=p.extend({},{not_operand:!1},n[t])).not_operand&&r.popmake("checkCondition",i)||i.not_operand&&!r.popmake("checkCondition",i))&&(e=!0),p(this).trigger("pumCheckingCondition",[e,i]),e)break}else if(n[t]){e=!0;break}e||(a=!1)}return a},checkCondition:function(e){var o=e.target||null;e.settings;return o?p.fn.popmake.conditions[o]?p.fn.popmake.conditions[o].apply(this,[e]):window.console?(console.warn("Condition "+o+" does not exist."),!0):void 0:(console.warn("Condition type not set."),!1)}}),p.fn.popmake.conditions=p.fn.popmake.conditions||{}}(jQuery,document),function(c){"use strict";function d(e,o,t){var n,i=new Date;if("undefined"!=typeof document){if(1<arguments.length){switch(typeof(t=c.extend({path:pum_vars.home_url},d.defaults,t)).expires){case"number":i.setMilliseconds(i.getMilliseconds()+864e5*t.expires),t.expires=i;break;case"string":i.setTime(1e3*c.fn.popmake.utilities.strtotime("+"+t.expires)),t.expires=i}try{n=JSON.stringify(o),/^[\{\[]/.test(n)&&(o=n)}catch(e){}return o=f.write?f.write(o,e):encodeURIComponent(String(o)).replace(/%(23|24|26|2B|3A|3C|3E|3D|2F|3F|40|5B|5D|5E|60|7B|7D|7C)/g,decodeURIComponent),e=(e=(e=encodeURIComponent(String(e))).replace(/%(23|24|26|2B|5E|60|7C)/g,decodeURIComponent)).replace(/[\(\)]/g,escape),document.cookie=[e,"=",o,t.expires?"; expires="+t.expires.toUTCString():"",t.path?"; path="+t.path:"",t.domain?"; domain="+t.domain:"",t.secure?"; secure":""].join("")}e||(n={});for(var r=document.cookie?document.cookie.split("; "):[],s=/(%[0-9A-Z]{2})+/g,a=0;a<r.length;a++){var p=r[a].split("=");'"'===(l=p.slice(1).join("=")).charAt(0)&&(l=l.slice(1,-1));try{var u=p[0].replace(s,decodeURIComponent),l=f.read?f.read(l,u):f(l,u)||l.replace(s,decodeURIComponent);if(this.json)try{l=JSON.parse(l)}catch(e){}if(e===u){n=l;break}e||(n[u]=l)}catch(e){}}return n}}var f;c.extend(c.fn.popmake,{cookie:(void 0===f&&(f=function(){}),(d.set=d).get=function(e){return d.call(d,e)},d.getJSON=function(){return d.apply({json:!0},[].slice.call(arguments))},d.defaults={},d.remove=function(e,o){d(e,"",c.extend({},o,{expires:-1,path:""})),d(e,"",c.extend({},o,{expires:-1}))},d.process=function(e,o,t,n){return d.apply(d,3<arguments.length&&"object"!=typeof t&&void 0!==o?[e,o,{expires:t,path:n}]:[].slice.call(arguments,[0,2]))},d.withConverter=c.fn.popmake.cookie,d)}),pm_cookie=c.pm_cookie=c.fn.popmake.cookie.process,pm_cookie_json=c.pm_cookie_json=c.fn.popmake.cookie.getJSON,pm_remove_cookie=c.pm_remove_cookie=c.fn.popmake.cookie.remove}(jQuery),function(i,e,n){"use strict";function r(e){i.pm_cookie(e.name,!0,e.session?null:e.time,e.path?pum_vars.home_url||"/":null),pum.hooks.doAction("popmake.setCookie",e)}i.extend(i.fn.popmake.methods,{addCookie:function(e){return pum.hooks.doAction("popmake.addCookie",arguments),i.fn.popmake.cookies[e]?i.fn.popmake.cookies[e].apply(this,Array.prototype.slice.call(arguments,1)):(window.console&&console.warn("Cookie type "+e+" does not exist."),this)},setCookie:r,checkCookies:function(e){var o,t=!1;if(e.cookie_name===n||null===e.cookie_name||""===e.cookie_name)return!1;switch(typeof e.cookie_name){case"object":case"array":for(o=0;e.cookie_name.length>o;o+=1)i.pm_cookie(e.cookie_name[o])!==n&&(t=!0);break;case"string":i.pm_cookie(e.cookie_name)!==n&&(t=!0)}return pum.hooks.doAction("popmake.checkCookies",e,t),t}}),i.fn.popmake.cookies=i.fn.popmake.cookies||{},i.extend(i.fn.popmake.cookies,{on_popup_open:function(e){var o=PUM.getPopup(this);o.on("pumAfterOpen",function(){o.popmake("setCookie",e)})},on_popup_close:function(e){var o=PUM.getPopup(this);o.on("pumBeforeClose",function(){o.popmake("setCookie",e)})},form_submission:function(t){var n=PUM.getPopup(this);t=i.extend({form:"",formInstanceId:"",only_in_popup:!1},t),PUM.hooks.addAction("pum.integration.form.success",function(e,o){t.form.length&&PUM.integrations.checkFormKeyMatches(t.form,t.formInstanceId,o)&&(t.only_in_popup&&o.popup.length&&o.popup.is(n)||!t.only_in_popup)&&n.popmake("setCookie",t)})},manual:function(e){var o=PUM.getPopup(this);o.on("pumSetCookie",function(){o.popmake("setCookie",e)})},form_success:function(e){var o=PUM.getPopup(this);o.on("pumFormSuccess",function(){o.popmake("setCookie",e)})},pum_sub_form_success:function(e){var o=PUM.getPopup(this);o.find("form.pum-sub-form").on("success",function(){o.popmake("setCookie",e)})},pum_sub_form_already_subscribed:function(e){var o=PUM.getPopup(this);o.find("form.pum-sub-form").on("success",function(){o.popmake("setCookie",e)})},ninja_form_success:function(e){return i.fn.popmake.cookies.form_success.apply(this,arguments)},cf7_form_success:function(e){return i.fn.popmake.cookies.form_success.apply(this,arguments)},gforms_form_success:function(e){return i.fn.popmake.cookies.form_success.apply(this,arguments)}}),i(e).on("pumInit",".pum",function(){var e,o,t=PUM.getPopup(this),n=t.popmake("getSettings").cookies||[];if(n.length)for(o=0;o<n.length;o+=1)e=n[o],t.popmake("addCookie",e.event,e.settings)}),i(function(){var e=i(".pum-cookie");e.each(function(){var o=i(this),t=e.index(o),n=o.data("cookie-args");!o.data("only-onscreen")||o.isInViewport()&&o.is(":visible")?r(n):i(window).on("scroll.pum-cookie-"+t,i.fn.popmake.utilities.throttle(function(e){o.isInViewport()&&o.is(":visible")&&(r(n),i(window).off("scroll.pum-cookie-"+t))},100))})})}(jQuery,document);var pum_debug,pum_debug_mode=!1;!function(s,e){var a,o,p;e=window.pum_vars||{debug_mode:!1},(pum_debug_mode=!(pum_debug_mode=void 0!==e.debug_mode&&e.debug_mode)&&-1!==window.location.href.indexOf("pum_debug")?!0:pum_debug_mode)&&(o=a=!1,p=window.pum_debug_vars||{debug_mode_enabled:"Popup Maker: Debug Mode Enabled",debug_started_at:"Debug started at:",debug_more_info:"For more information on how to use this information visit https://docs.wppopupmaker.com/?utm_medium=js-debug-info&utm_campaign=contextual-help&utm_source=browser-console&utm_content=more-info",global_info:"Global Information",localized_vars:"Localized variables",popups_initializing:"Popups Initializing",popups_initialized:"Popups Initialized",single_popup_label:"Popup: #",theme_id:"Theme ID: ",label_method_call:"Method Call:",label_method_args:"Method Arguments:",label_popup_settings:"Settings",label_triggers:"Triggers",label_cookies:"Cookies",label_delay:"Delay:",label_conditions:"Conditions",label_cookie:"Cookie:",label_settings:"Settings:",label_selector:"Selector:",label_mobile_disabled:"Mobile Disabled:",label_tablet_disabled:"Tablet Disabled:",label_event:"Event: %s",triggers:[],cookies:[]},pum_debug={odump:function(e){return s.extend({},e)},logo:function(){console.log(" -------------------------------------------------------------\n|  ____                           __  __       _              |\n| |  _ \\ ___  _ __  _   _ _ __   |  \\/  | __ _| | _____ _ __  |\n| | |_) / _ \\| '_ \\| | | | '_ \\  | |\\/| |/ _` | |/ / _ \\ '__| |\n| |  __/ (_) | |_) | |_| | |_) | | |  | | (_| |   <  __/ |    |\n| |_|   \\___/| .__/ \\__,_| .__/  |_|  |_|\\__,_|_|\\_\\___|_|    |\n|            |_|         |_|                                  |\n -------------------------------------------------------------")},initialize:function(){a=!0,pum_debug.logo(),console.debug(p.debug_mode_enabled),console.log(p.debug_started_at,new Date),console.info(p.debug_more_info),pum_debug.divider(p.global_info),console.groupCollapsed(p.localized_vars),console.log("pum_vars:",pum_debug.odump(e)),s(document).trigger("pum_debug_initialize_localized_vars"),console.groupEnd(),s(document).trigger("pum_debug_initialize")},popup_event_header:function(e){e=e.popmake("getSettings");o!==e.id&&(o=e.id,pum_debug.divider(p.single_popup_label+e.id+" - "+e.slug))},divider:function(e){try{var o,t=0,n=" "+new Array(63).join("-")+" ",i=e;"string"==typeof e?(o=62-(i=62<e.length?i.substring(0,62):i).length,(t={left:Math.floor(o/2),right:Math.floor(o/2)}).left+t.right===o-1&&t.right++,t.left=new Array(t.left+1).join(" "),t.right=new Array(t.right+1).join(" "),console.log(n+"\n|"+t.left+i+t.right+"|\n"+n)):console.log(n)}catch(e){console.error("Got a '"+e+"' when printing out the heading divider to the console.")}},click_trigger:function(e,o){var t=e.popmake("getSettings"),t=[".popmake-"+t.id,".popmake-"+decodeURIComponent(t.slug),'a[href$="#popmake-'+t.id+'"]'];o.extra_selectors&&""!==o.extra_selectors&&t.push(o.extra_selectors),t=(t=pum.hooks.applyFilters("pum.trigger.click_open.selectors",t,o,e)).join(", "),console.log(p.label_selector,t)},trigger:function(e,o){if("string"==typeof p.triggers[o.type]){switch(console.groupCollapsed(p.triggers[o.type]),o.type){case"auto_open":console.log(p.label_delay,o.settings.delay),console.log(p.label_cookie,o.settings.cookie_name);break;case"click_open":pum_debug.click_trigger(e,o.settings),console.log(p.label_cookie,o.settings.cookie_name)}s(document).trigger("pum_debug_render_trigger",e,o),console.groupEnd()}},cookie:function(e,o){if("string"==typeof p.cookies[o.event]){switch(console.groupCollapsed(p.cookies[o.event]),o.event){case"on_popup_open":case"on_popup_close":case"manual":case"ninja_form_success":console.log(p.label_cookie,pum_debug.odump(o.settings))}s(document).trigger("pum_debug_render_trigger",e,o),console.groupEnd()}}},s(document).on("pumInit",".pum",function(){var e=PUM.getPopup(s(this)),o=e.popmake("getSettings"),t=o.triggers||[],n=o.cookies||[],i=o.conditions||[],r=0;if(a||(pum_debug.initialize(),pum_debug.divider(p.popups_initializing)),console.groupCollapsed(p.single_popup_label+o.id+" - "+o.slug),console.log(p.theme_id,o.theme_id),t.length){for(console.groupCollapsed(p.label_triggers),r=0;r<t.length;r++)pum_debug.trigger(e,t[r]);console.groupEnd()}if(n.length){for(console.groupCollapsed(p.label_cookies),r=0;r<n.length;r+=1)pum_debug.cookie(e,n[r]);console.groupEnd()}i.length&&(console.groupCollapsed(p.label_conditions),console.log(i),console.groupEnd()),console.groupCollapsed(p.label_popup_settings),console.log(p.label_mobile_disabled,!1!==o.disable_on_mobile),console.log(p.label_tablet_disabled,!1!==o.disable_on_tablet),console.log(p.label_display_settings,pum_debug.odump(o)),e.trigger("pum_debug_popup_settings"),console.groupEnd(),console.groupEnd()}).on("pumBeforeOpen",".pum",function(){var e=PUM.getPopup(s(this)),o=s.fn.popmake.last_open_trigger;pum_debug.popup_event_header(e),console.groupCollapsed(p.label_event.replace("%s","pumBeforeOpen"));try{o=(o=s(s.fn.popmake.last_open_trigger)).length?o:s.fn.popmake.last_open_trigger.toString()}catch(e){o=""}finally{console.log(p.label_triggers,[o])}console.groupEnd()}).on("pumOpenPrevented",".pum",function(){var e=PUM.getPopup(s(this));pum_debug.popup_event_header(e),console.groupCollapsed(p.label_event.replace("%s","pumOpenPrevented")),console.groupEnd()}).on("pumAfterOpen",".pum",function(){var e=PUM.getPopup(s(this));pum_debug.popup_event_header(e),console.groupCollapsed(p.label_event.replace("%s","pumAfterOpen")),console.groupEnd()}).on("pumSetupClose",".pum",function(){var e=PUM.getPopup(s(this));pum_debug.popup_event_header(e),console.groupCollapsed(p.label_event.replace("%s","pumSetupClose")),console.groupEnd()}).on("pumClosePrevented",".pum",function(){var e=PUM.getPopup(s(this));pum_debug.popup_event_header(e),console.groupCollapsed(p.label_event.replace("%s","pumClosePrevented")),console.groupEnd()}).on("pumBeforeClose",".pum",function(){var e=PUM.getPopup(s(this));pum_debug.popup_event_header(e),console.groupCollapsed(p.label_event.replace("%s","pumBeforeClose")),console.groupEnd()}).on("pumAfterClose",".pum",function(){var e=PUM.getPopup(s(this));pum_debug.popup_event_header(e),console.groupCollapsed(p.label_event.replace("%s","pumAfterClose")),console.groupEnd()}).on("pumBeforeReposition",".pum",function(){var e=PUM.getPopup(s(this));pum_debug.popup_event_header(e),console.groupCollapsed(p.label_event.replace("%s","pumBeforeReposition")),console.groupEnd()}).on("pumAfterReposition",".pum",function(){var e=PUM.getPopup(s(this));pum_debug.popup_event_header(e),console.groupCollapsed(p.label_event.replace("%s","pumAfterReposition")),console.groupEnd()}).on("pumCheckingCondition",".pum",function(e,o,t){var n=PUM.getPopup(s(this));pum_debug.popup_event_header(n),console.groupCollapsed(p.label_event.replace("%s","pumCheckingCondition")),console.log((t.not_operand?"(!) ":"")+t.target+": "+o,t),console.groupEnd()}))}(jQuery),function(e){"use strict";e.fn.popmake.defaults={id:null,slug:"",theme_id:null,cookies:[],triggers:[],conditions:[],mobile_disabled:null,tablet_disabled:null,custom_height_auto:!1,scrollable_content:!1,position_from_trigger:!1,position_fixed:!1,overlay_disabled:!1,stackable:!1,disable_reposition:!1,close_on_overlay_click:!1,close_on_form_submission:!1,close_on_form_submission_delay:0,close_on_esc_press:!1,close_on_f4_press:!1,disable_on_mobile:!1,disable_on_tablet:!1,size:"medium",responsive_min_width:"0%",responsive_max_width:"100%",custom_width:"640px",custom_height:"380px",animation_type:"fade",animation_speed:"350",animation_origin:"center top",location:"center top",position_top:"100",position_bottom:"0",position_left:"0",position_right:"0",zindex:"1999999999",close_button_delay:"0",meta:{display:{stackable:!1,overlay_disabled:!1,size:"medium",responsive_max_width:"100",responsive_max_width_unit:"%",responsive_min_width:"0",responsive_min_width_unit:"%",custom_width:"640",custom_width_unit:"px",custom_height:"380",custom_height_unit:"px",custom_height_auto:!1,location:"center top",position_top:100,position_left:0,position_bottom:0,position_right:0,position_fixed:!1,animation_type:"fade",animation_speed:350,animation_origin:"center top",scrollable_content:!1,disable_reposition:!1,position_from_trigger:!1,overlay_zindex:!1,zindex:"1999999999"},close:{overlay_click:!1,esc_press:!1,f4_press:!1,text:"",button_delay:0},click_open:[]},container:{active_class:"active",attr:{class:"popmake"}},title:{attr:{class:"popmake-title"}},content:{attr:{class:"popmake-content"}},close:{close_speed:0,attr:{class:"popmake-close"}},overlay:{attr:{id:"popmake-overlay",class:"popmake-overlay"}}}}(jQuery,document),function(r){"use strict";var i={openpopup:!1,openpopup_id:0,closepopup:!1,closedelay:0,redirect_enabled:!1,redirect:"",cookie:!1};window.PUM=window.PUM||{},window.PUM.forms=window.PUM.forms||{},r.extend(window.PUM.forms,{form:{validation:{errors:[]},responseHandler:function(e,o){var t=o.data;o.success?window.PUM.forms.form.success(e,t):window.PUM.forms.form.errors(e,t)},display_errors:function(e,o){window.PUM.forms.messages.add(e,o||this.validation.errors,"error")},beforeAjax:function(e){var o=e.find('[type="submit"]'),t=o.find(".pum-form__loader");window.PUM.forms.messages.clear_all(e),t.length||(t=r('<span class="pum-form__loader"></span>'),""!==o.attr("value")?t.insertAfter(o):o.append(t)),o.prop("disabled",!0),t.show(),e.addClass("pum-form--loading").removeClass("pum-form--errors")},afterAjax:function(e){var o=e.find('[type="submit"]'),t=o.find(".pum-form__loader");o.prop("disabled",!1),t.hide(),e.removeClass("pum-form--loading")},success:function(e,o){void 0!==o.message&&""!==o.message&&window.PUM.forms.messages.add(e,[{message:o.message}]),e.trigger("success",[o]),!e.data("noredirect")&&void 0!==e.data("redirect_enabled")&&o.redirect&&(""!==o.redirect?window.location=o.redirect:window.location.reload(!0))},errors:function(e,o){void 0!==o.errors&&o.errors.length&&(console.log(o.errors),window.PUM.forms.form.display_errors(e,o.errors),window.PUM.forms.messages.scroll_to_first(e),e.addClass("pum-form--errors").trigger("errors",[o]))},submit:function(e){var o=r(this),t=o.pumSerializeObject();e.preventDefault(),e.stopPropagation(),window.PUM.forms.form.beforeAjax(o),r.ajax({type:"POST",dataType:"json",url:pum_vars.ajaxurl,data:{action:"pum_form",values:t}}).always(function(){window.PUM.forms.form.afterAjax(o)}).done(function(e){window.PUM.forms.form.responseHandler(o,e)}).error(function(e,o,t){console.log("Error: type of "+o+" with message of "+t)})}},messages:{add:function(e,o,t){var n=e.find(".pum-form__messages"),i=0;if(t=t||"success",o=o||[],!n.length)switch(n=r('<div class="pum-form__messages">').hide(),pum_vars.message_position){case"bottom":e.append(n.addClass("pum-form__messages--bottom"));break;case"top":e.prepend(n.addClass("pum-form__messages--top"))}if(0<=["bottom","top"].indexOf(pum_vars.message_position))for(;o.length>i;i++)this.add_message(n,o[i].message,t);else for(;o.length>i;i++)void 0!==o[i].field?this.add_field_error(e,o[i]):this.add_message(n,o[i].message,t);n.is(":hidden")&&r(".pum-form__message",n).length&&n.slideDown()},add_message:function(e,o,t){o=r('<p class="pum-form__message">').html(o);t=t||"success",o.addClass("pum-form__message--"+t),e.append(o),e.is(":visible")&&o.hide().slideDown()},add_field_error:function(e,o){e=r('[name="'+o.field+'"]',e).parents(".pum-form__field").addClass("pum-form__field--error");this.add_message(e,o.message,"error")},clear_all:function(e,o){var t=e.find(".pum-form__messages"),n=t.find(".pum-form__message"),e=e.find(".pum-form__field.pum-form__field--error");o=o||!1,t.length&&n.slideUp("fast",function(){r(this).remove(),o&&t.hide()}),e.length&&e.removeClass("pum-form__field--error").find("p.pum-form__message").remove()},scroll_to_first:function(e){window.PUM.utilities.scrollTo(r(".pum-form__field.pum-form__field--error",e).eq(0))}},success:function(e,o){var t,n;(o=r.extend({},i,o))&&(t=PUM.getPopup(e),e={},n=function(){o.openpopup&&PUM.getPopup(o.openpopup_id).length?PUM.open(o.openpopup_id):o.redirect_enabled&&(""!==o.redirect?window.location=o.redirect:window.location.reload(!0))},t.length&&(t.trigger("pumFormSuccess"),o.cookie&&(e=r.extend({name:"pum-"+PUM.getSetting(t,"id"),expires:"+1 year"},"object"==typeof o.cookie?o.cookie:{}),PUM.setCookie(t,e))),t.length&&o.closepopup?setTimeout(function(){t.popmake("close",n)},1e3*parseInt(o.closedelay)):n())}})}(jQuery),function(e){"use strict";e.pum=e.pum||{},e.pum.hooks=e.pum.hooks||new function(){var t=Array.prototype.slice,i={removeFilter:function(e,o){"string"==typeof e&&n("filters",e,o);return i},applyFilters:function(){var e=t.call(arguments),o=e.shift();return"string"!=typeof o?i:s("filters",o,e)},addFilter:function(e,o,t,n){"string"==typeof e&&"function"==typeof o&&(t=parseInt(t||10,10),r("filters",e,o,t,n));return i},removeAction:function(e,o){"string"==typeof e&&n("actions",e,o);return i},doAction:function(){var e=t.call(arguments),o=e.shift();"string"==typeof o&&s("actions",o,e);return i},addAction:function(e,o,t,n){"string"==typeof e&&"function"==typeof o&&(t=parseInt(t||10,10),r("actions",e,o,t,n));return i}},a={actions:{},filters:{}};function n(e,o,t,n){var i,r,s;if(a[e][o])if(t)if(i=a[e][o],n)for(s=i.length;s--;)(r=i[s]).callback===t&&r.context===n&&i.splice(s,1);else for(s=i.length;s--;)i[s].callback===t&&i.splice(s,1);else a[e][o]=[]}function r(e,o,t,n,i){n={callback:t,priority:n,context:i},i=(i=a[e][o])?(i.push(n),function(e){for(var o,t,n,i=1,r=e.length;i<r;i++){for(o=e[i],t=i;(n=e[t-1])&&n.priority>o.priority;)e[t]=e[t-1],--t;e[t]=o}return e}(i)):[n];a[e][o]=i}function s(e,o,t){var n,i,r=a[e][o];if(!r)return"filters"===e&&t[0];if(i=r.length,"filters"===e)for(n=0;n<i;n++)t[0]=r[n].callback.apply(r[n].context,t);else for(n=0;n<i;n++)r[n].callback.apply(r[n].context,t);return"filters"!==e||t[0]}return i},e.PUM=e.PUM||{},e.PUM.hooks=e.pum.hooks}(window),function(t){"use strict";function n(e){return e}window.PUM=window.PUM||{},window.PUM.integrations=window.PUM.integrations||{},t.extend(window.PUM.integrations,{init:function(){var e;void 0!==pum_vars.form_submission&&((e=pum_vars.form_submission).ajax=!1,e.popup=0<e.popupId?PUM.getPopup(e.popupId):null,PUM.integrations.formSubmission(null,e))},formSubmission:function(e,o){(o=t.extend({popup:PUM.getPopup(e),formProvider:null,formId:null,formInstanceId:null,formKey:null,ajax:!0,tracked:!1},o)).formKey=o.formKey||[o.formProvider,o.formId,o.formInstanceId].filter(n).join("_"),o.popup&&o.popup.length&&(o.popupId=PUM.getSetting(o.popup,"id")),window.PUM.hooks.doAction("pum.integration.form.success",e,o)},checkFormKeyMatches:function(e,o,t){o=""===o&&o;var n=-1!==["any"===e,"pumsubform"===e&&"pumsubform"===t.formProvider,e===t.formProvider+"_any",!o&&new RegExp("^"+e+"(_[d]*)?").test(t.formKey),!!o&&e+"_"+o===t.formKey].indexOf(!0);return window.PUM.hooks.applyFilters("pum.integration.checkFormKeyMatches",n,{formIdentifier:e,formInstanceId:o,submittedFormArgs:t})}})}(window.jQuery),function(s){"use strict";pum_vars&&void 0!==pum_vars.core_sub_forms_enabled&&!pum_vars.core_sub_forms_enabled||(window.PUM=window.PUM||{},window.PUM.newsletter=window.PUM.newsletter||{},s.extend(window.PUM.newsletter,{form:s.extend({},window.PUM.forms.form,{submit:function(e){var o=s(this),t=o.pumSerializeObject();e.preventDefault(),e.stopPropagation(),window.PUM.newsletter.form.beforeAjax(o),s.ajax({type:"POST",dataType:"json",url:pum_vars.ajaxurl,data:{action:"pum_sub_form",values:t}}).always(function(){window.PUM.newsletter.form.afterAjax(o)}).done(function(e){window.PUM.newsletter.form.responseHandler(o,e)}).error(function(e,o,t){console.log("Error: type of "+o+" with message of "+t)})}})}),s(document).on("submit","form.pum-sub-form",window.PUM.newsletter.form.submit).on("success","form.pum-sub-form",function(e,o){var t=s(e.target),n=t.data("settings")||{},i=t.pumSerializeObject(),r=PUM.getPopup(t),e=PUM.getSetting(r,"id"),r=s("form.pum-sub-form",r).index(t)+1;window.PUM.integrations.formSubmission(t,{formProvider:"pumsubform",formId:e,formInstanceId:r,extras:{data:o,values:i,settings:n}}),t.trigger("pumNewsletterSuccess",[o]).addClass("pum-newsletter-success"),t[0].reset(),window.pum.hooks.doAction("pum-sub-form.success",o,t),"string"==typeof n.redirect&&""!==n.redirect&&(n.redirect=atob(n.redirect)),window.PUM.forms.success(t,n)}).on("error","form.pum-sub-form",function(e,o){e=s(e.target);e.trigger("pumNewsletterError",[o]),window.pum.hooks.doAction("pum-sub-form.errors",o,e)}))}(jQuery),function(r,o){"use strict";r.extend(r.fn.popmake.methods,{addTrigger:function(e){return r.fn.popmake.triggers[e]?r.fn.popmake.triggers[e].apply(this,Array.prototype.slice.call(arguments,1)):(window.console&&console.warn("Trigger type "+e+" does not exist."),this)}}),r.fn.popmake.triggers={auto_open:function(e){var o=PUM.getPopup(this);setTimeout(function(){o.popmake("state","isOpen")||!o.popmake("checkCookies",e)&&o.popmake("checkConditions")&&(r.fn.popmake.last_open_trigger="Auto Open - Delay: "+e.delay,o.popmake("open"))},e.delay)},click_open:function(n){var i=PUM.getPopup(this),e=i.popmake("getSettings"),e=[".popmake-"+e.id,".popmake-"+decodeURIComponent(e.slug),'a[href$="#popmake-'+e.id+'"]'];n.extra_selectors&&""!==n.extra_selectors&&e.push(n.extra_selectors),e=(e=pum.hooks.applyFilters("pum.trigger.click_open.selectors",e,n,i)).join(", "),r(e).addClass("pum-trigger").css({cursor:"pointer"}),r(o).on("click.pumTrigger",e,function(e){var o=r(this),t=n.do_default||!1;0<i.has(o).length||i.popmake("state","isOpen")||!i.popmake("checkCookies",n)&&i.popmake("checkConditions")&&(o.data("do-default")?t=o.data("do-default"):(o.hasClass("do-default")||o.hasClass("popmake-do-default")||o.hasClass("pum-do-default"))&&(t=!0),e.ctrlKey||pum.hooks.applyFilters("pum.trigger.click_open.do_default",t,i,o)||(e.preventDefault(),e.stopPropagation()),r.fn.popmake.last_open_trigger=o,i.popmake("open"))})},form_submission:function(t){var n=PUM.getPopup(this);t=r.extend({form:"",formInstanceId:"",delay:0},t);PUM.hooks.addAction("pum.integration.form.success",function(e,o){t.form.length&&PUM.integrations.checkFormKeyMatches(t.form,t.formInstanceId,o)&&setTimeout(function(){n.popmake("state","isOpen")||!n.popmake("checkCookies",t)&&n.popmake("checkConditions")&&(r.fn.popmake.last_open_trigger="Form Submission",n.popmake("open"))},t.delay)})},admin_debug:function(){PUM.getPopup(this).popmake("open")}},r(o).on("pumInit",".pum",function(){var e,o,t=PUM.getPopup(this),n=t.popmake("getSettings").triggers||[];if(n.length)for(o=0;o<n.length;o+=1)e=n[o],t.popmake("addTrigger",e.type,e.settings)})}(jQuery,document),function(a){"use strict";var n="color,date,datetime,datetime-local,email,hidden,month,number,password,range,search,tel,text,time,url,week".split(","),i="select,textarea".split(","),r=/\[([^\]]*)\]/g;Array.prototype.indexOf||(Array.prototype.indexOf=function(e){if(null==this)throw new TypeError;var o=Object(this),t=o.length>>>0;if(0==t)return-1;var n=0;if(0<arguments.length&&((n=Number(arguments[1]))!=n?n=0:0!==n&&n!==1/0&&n!==-1/0&&(n=(0<n||-1)*Math.floor(Math.abs(n)))),t<=n)return-1;for(var i=0<=n?n:Math.max(t-Math.abs(n),0);i<t;i++)if(i in o&&o[i]===e)return i;return-1}),a.fn.popmake.utilities={scrollTo:function(e,o){var t=a(e)||a();t.length&&a("html, body").animate({scrollTop:t.offset().top-100},1e3,"swing",function(){var e=t.find(':input:not([type="button"]):not([type="hidden"]):not(button)').eq(0);e.hasClass("wp-editor-area")?tinyMCE.execCommand ("mceFocus",!1,e.attr("id")):e.focus(),"function"==typeof o&&o()})},inArray:function(e,o){return!!~o.indexOf(e)},convert_hex:function(e,o){return e=e.replace("#",""),"rgba("+parseInt(e.substring(0,2),16)+","+parseInt(e.substring(2,4),16)+","+parseInt(e.substring(4,6),16)+","+o/100+")"},debounce:function(t,n){var i;return function(){var e=this,o=arguments;window.clearTimeout(i),i=window.setTimeout(function(){t.apply(e,o)},n)}},throttle:function(e,o){function t(){n=!1}var n=!1;return function(){n||(e.apply(this,arguments),window.setTimeout(t,o),n=!0)}},getXPath:function(e){var t,n,i,r,s=[];return a.each(a(e).parents(),function(e,o){return r=a(o),t=r.attr("id")||"",n=r.attr("class")||"",i=r.get(0).tagName.toLowerCase(),r=r.parent().children(i).index(r),"body"!==i&&(0<n.length&&(n=(n=n.split(" "))[0]),void s.push(i+(0<t.length?"#"+t:0<n.length?"."+n.split(" ").join("."):":eq("+r+")")))}),s.reverse().join(" > ")},strtotime:function(e,o){var t,n,i,r,s,a,p,u,l;if(!e)return!1;if((n=(e=e.replace(/^\s+|\s+$/g,"").replace(/\s{2,}/g," ").replace(/[\t\r\n]/g,"").toLowerCase()).match(/^(\d{1,4})([\-\.\/\:])(\d{1,2})([\-\.\/\:])(\d{1,4})(?:\s(\d{1,2}):(\d{2})?:?(\d{2})?)?(?:\s([A-Z]+)?)?$/))&&n[2]===n[4])if(1901<n[1])switch(n[2]){case"-":return 12<n[3]||31<n[5]?!1:new Date(n[1],parseInt(n[3],10)-1,n[5],n[6]||0,n[7]||0,n[8]||0,n[9]||0)/1e3;case".":return!1;case"/":return 12<n[3]||31<n[5]?!1:new Date(n[1],parseInt(n[3],10)-1,n[5],n[6]||0,n[7]||0,n[8]||0,n[9]||0)/1e3}else if(1901<n[5])switch(n[2]){case"-":case".":return 12<n[3]||31<n[1]?!1:new Date(n[5],parseInt(n[3],10)-1,n[1],n[6]||0,n[7]||0,n[8]||0,n[9]||0)/1e3;case"/":return 12<n[1]||31<n[3]?!1:new Date(n[5],parseInt(n[1],10)-1,n[3],n[6]||0,n[7]||0,n[8]||0,n[9]||0)/1e3}else switch(n[2]){case"-":return 12<n[3]||31<n[5]||n[1]<70&&38<n[1]?!1:(r=0<=n[1]&&n[1]<=38?+n[1]+2e3:n[1],new Date(r,parseInt(n[3],10)-1,n[5],n[6]||0,n[7]||0,n[8]||0,n[9]||0)/1e3);case".":return 70<=n[5]?!(12<n[3]||31<n[1])&&new Date(n[5],parseInt(n[3],10)-1,n[1],n[6]||0,n[7]||0,n[8]||0,n[9]||0)/1e3:n[5]<60&&!n[6]&&(!(23<n[1]||59<n[3])&&(i=new Date,new Date(i.getFullYear(),i.getMonth(),i.getDate(),n[1]||0,n[3]||0,n[5]||0,n[9]||0)/1e3));case"/":return 12<n[1]||31<n[3]||n[5]<70&&38<n[5]?!1:(r=0<=n[5]&&n[5]<=38?+n[5]+2e3:n[5],new Date(r,parseInt(n[1],10)-1,n[3],n[6]||0,n[7]||0,n[8]||0,n[9]||0)/1e3);case":":return 23<n[1]||59<n[3]||59<n[5]?!1:(i=new Date,new Date(i.getFullYear(),i.getMonth(),i.getDate(),n[1]||0,n[3]||0,n[5]||0)/1e3)}if("now"===e)return null===o||isNaN(o)?(new Date).getTime()/1e3||0:o||0;if(t=Date.parse(e),!isNaN(t))return t/1e3||0;function c(e){var o=e.split(" "),t=o[0],n=o[1].substring(0,3),i=/\d+/.test(t),e=("last"===t?-1:1)*("ago"===o[2]?-1:1);if(i&&(e*=parseInt(t,10)),p.hasOwnProperty(n)&&!o[1].match(/^mon(day|\.)?$/i))return s["set"+p[n]](s["get"+p[n]]()+e);if("wee"===n)return s.setDate(s.getDate()+7*e);if("next"===t||"last"===t)t=t,e=e,void 0!==(n=a[n=n])&&(0===(n=n-s.getDay())?n=7*e:0<n&&"last"===t?n-=7:n<0&&"next"===t&&(n+=7),s.setDate(s.getDate()+n));else if(!i)return;return 1}if(s=o?new Date(1e3*o):new Date,a={sun:0,mon:1,tue:2,wed:3,thu:4,fri:5,sat:6},p={yea:"FullYear",mon:"Month",day:"Date",hou:"Hours",min:"Minutes",sec:"Seconds"},o="(years?|months?|weeks?|days?|hours?|minutes?|min|seconds?|sec|sunday|sun\\.?|monday|mon\\.?|tuesday|tue\\.?|wednesday|wed\\.?|thursday|thu\\.?|friday|fri\\.?|saturday|sat\\.?)",!(n=e.match(new RegExp("([+-]?\\d+\\s(years?|months?|weeks?|days?|hours?|minutes?|min|seconds?|sec|sunday|sun\\.?|monday|mon\\.?|tuesday|tue\\.?|wednesday|wed\\.?|thursday|thu\\.?|friday|fri\\.?|saturday|sat\\.?)|(last|next)\\s(years?|months?|weeks?|days?|hours?|minutes?|min|seconds?|sec|sunday|sun\\.?|monday|mon\\.?|tuesday|tue\\.?|wednesday|wed\\.?|thursday|thu\\.?|friday|fri\\.?|saturday|sat\\.?))(\\sago)?","gi"))))return!1;for(l=0,u=n.length;l<u;l+=1)if(!c(n[l]))return!1;return s.getTime()/1e3},serializeObject:function(e){a.extend({},e);var o={},t=a.extend(!0,{include:[],exclude:[],includeByClass:""},e);return this.find(":input").each(function(){var e;!this.name||this.disabled||window.PUM.utilities.inArray(this.name,t.exclude)||t.include.length&&!window.PUM.utilities.inArray(this.name,t.include)||-1===this.className.indexOf(t.includeByClass)||(e=this.name.replace(r,"[$1").split("["))[0]&&(this.checked||window.PUM.utilities.inArray(this.type,n)||window.PUM.utilities.inArray(this.nodeName.toLowerCase(),i))&&("checkbox"===this.type&&e.push(""),function e(o,t,n){var i=t[0];1<t.length?(o[i]||(o[i]=t[1]?{}:[]),e(o[i],t.slice(1),n)):o[i=i||o.length]=n}(o,e,a(this).val()))}),o}},a.fn.popmake.utilies=a.fn.popmake.utilities,window.PUM=window.PUM||{},window.PUM.utilities=window.PUM.utilities||{},window.PUM.utilities=a.extend(window.PUM.utilities,a.fn.popmake.utilities)}(jQuery,document),function(e){function o(n,o){var t={},i={};function r(e,o,t){return e[o]=t,e}function s(e,o){var t,n=e.match(p.key);try{o=JSON.parse(o)}catch(e){}for(;void 0!==(t=n.pop());)p.push.test(t)?o=r([],function(e){void 0===i[e]&&(i[e]=0);return i[e]++}(e.replace(/\[\]$/,"")),o):p.fixed.test(t)?o=r([],t,o):p.named.test(t)&&(o=r({},t,o));return o}function e(){return t}this.addPair=function(e){return p.validate.test(e.name)&&(e=s(e.name,"checkbox"===a('[name="'+(e=e).name+'"]',o).attr("type")&&"1"===e.value||e.value),t=n.extend(!0,t,e)),this},this.addPairs=function(e){if(!n.isArray(e))throw new Error("formSerializer.addPairs expects an Array");for(var o=0,t=e.length;o<t;o++)this.addPair(e[o]);return this},this.serialize=e,this.serializeJSON=function(){return JSON.stringify(t)}}var t,a,p;a=(t=e).jQuery||e.Zepto||e.ender||e.$,o.patterns=p={validate:/^[a-z_][a-z0-9_]*(?:\[(?:\d*|[a-z0-9_]+)\])*$/i,key:/[a-z0-9_]+|(?=\[\])/gi,push:/^$/,fixed:/^\d+$/,named:/^[a-z0-9_]+$/i},o.serializeObject=function(){var e=(this.is("form")?this:this.find(":input")).serializeArray();return new o(a,this).addPairs(e).serialize()},o.serializeJSON=function(){var e=(this.is("form")?this:this.find(":input")).serializeArray();return new o(a,this).addPairs(e).serializeJSON()},void 0!==a.fn&&(a.fn.pumSerializeObject=o.serializeObject,a.fn.pumSerializeJSON=o.serializeJSON),t.FormSerializer=o}(this),function(t){var n={};function i(e){if(n[e])return n[e].exports;var o=n[e]={i:e,l:!1,exports:{}};return t[e].call(o.exports,o,o.exports,i),o.l=!0,o.exports}i.m=t,i.c=n,i.d=function(e,o,t){i.o(e,o)||Object.defineProperty(e,o,{enumerable:!0,get:t})},i.r=function(e){"undefined"!=typeof Symbol&&Symbol.toStringTag&&Object.defineProperty(e,Symbol.toStringTag,{value:"Module"}),Object.defineProperty(e,"__esModule",{value:!0})},i.t=function(o,e){if(1&e&&(o=i(o)),8&e)return o;if(4&e&&"object"==typeof o&&o&&o.__esModule)return o;var t=Object.create(null);if(i.r(t),Object.defineProperty(t,"default",{enumerable:!0,value:o}),2&e&&"string"!=typeof o)for(var n in o)i.d(t,n,function(e){return o[e]}.bind(null,n));return t},i.n=function(e){var o=e&&e.__esModule?function(){return e.default}:function(){return e};return i.d(o,"a",o),o},i.o=function(e,o){return Object.prototype.hasOwnProperty.call(e,o)},i.p="",i(i.s="./assets/js/src/integration/calderaforms.js")}({"./assets/js/src/integration/calderaforms.js":function(e,o,t){"use strict";t.r(o);var n,o=t("./node_modules/@babel/runtime/helpers/slicedToArray.js"),i=t.n(o);(0,window.jQuery)(document).on("cf.ajax.request",function(e,o){return n=o.$form}).on("cf.submission",function(e,o){var t;"complete"!==o.data.status&&"success"!==o.data.status||(t=n.attr("id").split("_"),t=(o=i()(t,2))[0],o=void 0===(o=o[1])?null:o,window.PUM.integrations.formSubmission(n,{formProvider:"calderaforms",formId:t,formInstanceId:o,extras:{state:window.cfstate.hasOwnProperty(t)?window.cfstate[t]:null}}))})},"./node_modules/@babel/runtime/helpers/arrayLikeToArray.js":function(e,o){e.exports=function(e,o){(null==o||o>e.length)&&(o=e.length);for(var t=0,n=new Array(o);t<o;t++)n[t]=e[t];return n}},"./node_modules/@babel/runtime/helpers/arrayWithHoles.js":function(e,o){e.exports=function(e){if(Array.isArray(e))return e}},"./node_modules/@babel/runtime/helpers/iterableToArrayLimit.js":function(e,o){e.exports=function(e,o){if("undefined"!=typeof Symbol&&Symbol.iterator in Object(e)){var t=[],n=!0,i=!1,r=void 0;try{for(var s,a=e[Symbol.iterator]();!(n=(s=a.next()).done)&&(t.push(s.value),!o||t.length!==o);n=!0);}catch(e){i=!0,r=e}finally{try{n||null==a.return||a.return()}finally{if(i)throw r}}return t}}},"./node_modules/@babel/runtime/helpers/nonIterableRest.js":function(e,o){e.exports=function(){throw new TypeError("Invalid attempt to destructure non-iterable instance.\nIn order to be iterable, non-array objects must have a [Symbol.iterator]() method.")}},"./node_modules/@babel/runtime/helpers/slicedToArray.js":function(e,o,t){var n=t("./node_modules/@babel/runtime/helpers/arrayWithHoles.js"),i=t("./node_modules/@babel/runtime/helpers/iterableToArrayLimit.js"),r=t("./node_modules/@babel/runtime/helpers/unsupportedIterableToArray.js"),s=t("./node_modules/@babel/runtime/helpers/nonIterableRest.js");e.exports=function(e,o){return n(e)||i(e,o)||r(e,o)||s()}},"./node_modules/@babel/runtime/helpers/unsupportedIterableToArray.js":function(e,o,t){var n=t("./node_modules/@babel/runtime/helpers/arrayLikeToArray.js");e.exports=function(e,o){if(e){if("string"==typeof e)return n(e,o);var t=Object.prototype.toString.call(e).slice(8,-1);return"Map"===(t="Object"===t&&e.constructor?e.constructor.name:t)||"Set"===t?Array.from(e):"Arguments"===t||/^(?:Ui|I)nt(?:8|16|32)(?:Clamped)?Array$/.test(t)?n(e,o):void 0}}}}),function(t){var n={};function i(e){if(n[e])return n[e].exports;var o=n[e]={i:e,l:!1,exports:{}};return t[e].call(o.exports,o,o.exports,i),o.l=!0,o.exports}i.m=t,i.c=n,i.d=function(e,o,t){i.o(e,o)||Object.defineProperty(e,o,{enumerable:!0,get:t})},i.r=function(e){"undefined"!=typeof Symbol&&Symbol.toStringTag&&Object.defineProperty(e,Symbol.toStringTag,{value:"Module"}),Object.defineProperty(e,"__esModule",{value:!0})},i.t=function(o,e){if(1&e&&(o=i(o)),8&e)return o;if(4&e&&"object"==typeof o&&o&&o.__esModule)return o;var t=Object.create(null);if(i.r(t),Object.defineProperty(t,"default",{enumerable:!0,value:o}),2&e&&"string"!=typeof o)for(var n in o)i.d(t,n,function(e){return o[e]}.bind(null,n));return t},i.n=function(e){var o=e&&e.__esModule?function(){return e.default}:function(){return e};return i.d(o,"a",o),o},i.o=function(e,o){return Object.prototype.hasOwnProperty.call(e,o)},i.p="",i(i.s="./assets/js/src/integration/contactform7.js")}({"./assets/js/src/integration/contactform7.js":function(e,o,t){"use strict";t.r(o);var o=t("./node_modules/@babel/runtime/helpers/typeof.js"),i=t.n(o),r=window.jQuery;r(document).on("wpcf7mailsent",function(e,o){var t=e.detail.contactFormId,n=r(e.target),e=(e.detail.id||e.detail.unitTag).split("-").pop().replace("o","");window.PUM.integrations.formSubmission(n,{formProvider:"contactform7",formId:t,formInstanceId:e,extras:{details:o}});o=n.find("input.wpcf7-pum"),o=!!o.length&&JSON.parse(o.val());"object"===i()(o)&&void 0!==o.closedelay&&3<=o.closedelay.toString().length&&(o.closedelay=o.closedelay/1e3),window.PUM.forms.success(n,o)})},"./node_modules/@babel/runtime/helpers/typeof.js":function(o,e){function t(e){return"function"==typeof Symbol&&"symbol"==typeof Symbol.iterator?o.exports=t=function(e){return typeof e}:o.exports=t=function(e){return e&&"function"==typeof Symbol&&e.constructor===Symbol&&e!==Symbol.prototype?"symbol":typeof e},t(e)}o.exports=t}}),function(t){var n={};function i(e){if(n[e])return n[e].exports;var o=n[e]={i:e,l:!1,exports:{}};return t[e].call(o.exports,o,o.exports,i),o.l=!0,o.exports}i.m=t,i.c=n,i.d=function(e,o,t){i.o(e,o)||Object.defineProperty(e,o,{enumerable:!0,get:t})},i.r=function(e){"undefined"!=typeof Symbol&&Symbol.toStringTag&&Object.defineProperty(e,Symbol.toStringTag,{value:"Module"}),Object.defineProperty(e,"__esModule",{value:!0})},i.t=function(o,e){if(1&e&&(o=i(o)),8&e)return o;if(4&e&&"object"==typeof o&&o&&o.__esModule)return o;var t=Object.create(null);if(i.r(t),Object.defineProperty(t,"default",{enumerable:!0,value:o}),2&e&&"string"!=typeof o)for(var n in o)i.d(t,n,function(e){return o[e]}.bind(null,n));return t},i.n=function(e){var o=e&&e.__esModule?function(){return e.default}:function(){return e};return i.d(o,"a",o),o},i.o=function(e,o){return Object.prototype.hasOwnProperty.call(e,o)},i.p="",i(i.s="./assets/js/src/integration/formidableforms.js")}({"./assets/js/src/integration/formidableforms.js":function(e,o){var r=window.jQuery;r(document).on("frmFormComplete",function(e,o,t){var n=r(o),i=n.find('input[name="form_id"]').val(),o=PUM.getPopup(n.find('input[name="pum_form_popup_id"]').val());window.PUM.integrations.formSubmission(n,{popup:o,formProvider:"formidableforms",formId:i,extras:{response:t}})})}}),function(t){var n={};function i(e){if(n[e])return n[e].exports;var o=n[e]={i:e,l:!1,exports:{}};return t[e].call(o.exports,o,o.exports,i),o.l=!0,o.exports}i.m=t,i.c=n,i.d=function(e,o,t){i.o(e,o)||Object.defineProperty(e,o,{enumerable:!0,get:t})},i.r=function(e){"undefined"!=typeof Symbol&&Symbol.toStringTag&&Object.defineProperty(e,Symbol.toStringTag,{value:"Module"}),Object.defineProperty(e,"__esModule",{value:!0})},i.t=function(o,e){if(1&e&&(o=i(o)),8&e)return o;if(4&e&&"object"==typeof o&&o&&o.__esModule)return o;var t=Object.create(null);if(i.r(t),Object.defineProperty(t,"default",{enumerable:!0,value:o}),2&e&&"string"!=typeof o)for(var n in o)i.d(t,n,function(e){return o[e]}.bind(null,n));return t},i.n=function(e){var o=e&&e.__esModule?function(){return e.default}:function(){return e};return i.d(o,"a",o),o},i.o=function(e,o){return Object.prototype.hasOwnProperty.call(e,o)},i.p="",i(i.s="./assets/js/src/integration/gravityforms.js")}({"./assets/js/src/integration/gravityforms.js":function(e,o,t){"use strict";t.r(o);var o=t("./node_modules/@babel/runtime/helpers/typeof.js"),n=t.n(o),i=window.jQuery,r={};i(document).on("gform_confirmation_loaded",function(e,o){var t=i("#gform_confirmation_wrapper_"+o+",#gforms_confirmation_message_"+o)[0];window.PUM.integrations.formSubmission(t,{formProvider:"gravityforms",formId:o}),window.PUM.forms.success(t,r[o]||{})}),i(function(){i(".gform_wrapper > form").each(function(){var e=i(this),o=e.attr("id").replace("gform_",""),e=e.find("input.gforms-pum"),e=!!e.length&&JSON.parse(e.val());e&&"object"===n()(e)&&("object"===n()(e)&&void 0!==e.closedelay&&3<=e.closedelay.toString().length&&(e.closedelay=e.closedelay/1e3),r[o]=e)})})},"./node_modules/@babel/runtime/helpers/typeof.js":function(o,e){function t(e){return"function"==typeof Symbol&&"symbol"==typeof Symbol.iterator?o.exports=t=function(e){return typeof e}:o.exports=t=function(e){return e&&"function"==typeof Symbol&&e.constructor===Symbol&&e!==Symbol.prototype?"symbol":typeof e},t(e)}o.exports=t}}),function(t){var n={};function i(e){if(n[e])return n[e].exports;var o=n[e]={i:e,l:!1,exports:{}};return t[e].call(o.exports,o,o.exports,i),o.l=!0,o.exports}i.m=t,i.c=n,i.d=function(e,o,t){i.o(e,o)||Object.defineProperty(e,o,{enumerable:!0,get:t})},i.r=function(e){"undefined"!=typeof Symbol&&Symbol.toStringTag&&Object.defineProperty(e,Symbol.toStringTag,{value:"Module"}),Object.defineProperty(e,"__esModule",{value:!0})},i.t=function(o,e){if(1&e&&(o=i(o)),8&e)return o;if(4&e&&"object"==typeof o&&o&&o.__esModule)return o;var t=Object.create(null);if(i.r(t),Object.defineProperty(t,"default",{enumerable:!0,value:o}),2&e&&"string"!=typeof o)for(var n in o)i.d(t,n,function(e){return o[e]}.bind(null,n));return t},i.n=function(e){var o=e&&e.__esModule?function(){return e.default}:function(){return e};return i.d(o,"a",o),o},i.o=function(e,o){return Object.prototype.hasOwnProperty.call(e,o)},i.p="",i(i.s="./assets/js/src/integration/mc4wp.js")}({"./assets/js/src/integration/mc4wp.js":function(e,o){var r=window.jQuery;r(function(){"undefined"!=typeof mc4wp&&mc4wp.forms.on("success",function(e,o){var t=r(e.element),n=e.id,i=r(".mc4wp-form-"+e.id).index(t)+1;window.PUM.integrations.formSubmission(t,{formProvider:"mc4wp",formId:n,formInstanceId:i,extras:{form:e,data:o}})})})}}),function(t){var n={};function i(e){if(n[e])return n[e].exports;var o=n[e]={i:e,l:!1,exports:{}};return t[e].call(o.exports,o,o.exports,i),o.l=!0,o.exports}i.m=t,i.c=n,i.d=function(e,o,t){i.o(e,o)||Object.defineProperty(e,o,{enumerable:!0,get:t})},i.r=function(e){"undefined"!=typeof Symbol&&Symbol.toStringTag&&Object.defineProperty(e,Symbol.toStringTag,{value:"Module"}),Object.defineProperty(e,"__esModule",{value:!0})},i.t=function(o,e){if(1&e&&(o=i(o)),8&e)return o;if(4&e&&"object"==typeof o&&o&&o.__esModule)return o;var t=Object.create(null);if(i.r(t),Object.defineProperty(t,"default",{enumerable:!0,value:o}),2&e&&"string"!=typeof o)for(var n in o)i.d(t,n,function(e){return o[e]}.bind(null,n));return t},i.n=function(e){var o=e&&e.__esModule?function(){return e.default}:function(){return e};return i.d(o,"a",o),o},i.o=function(e,o){return Object.prototype.hasOwnProperty.call(e,o)},i.p="",i(i.s="./assets/js/src/integration/ninjaforms.js")}({"./assets/js/src/integration/ninjaforms.js":function(e,o,t){"use strict";t.r(o);var o=t("./node_modules/@babel/runtime/helpers/slicedToArray.js"),a=t.n(o),p=window.jQuery,n=!1;p(function(){"undefined"!=typeof Marionette&&"undefined"!=typeof nfRadio&&!1===n&&new(n=Marionette.Object.extend({initialize:function(){this.listenTo(nfRadio.channel("forms"),"submit:response",this.popupMaker)},popupMaker:function(e,o,t,n){var i=p("#nf-form-"+n+"-cont"),r=n.split("_"),s=a()(r,2),n=s[0],r=s[1],s=void 0===r?null:r,r={};e.errors&&e.errors.length||(window.PUM.integrations.formSubmission(i,{formProvider:"ninjaforms",formId:n,formInstanceId:s,extras:{response:e}}),e.data&&e.data.actions&&(r.openpopup=void 0!==e.data.actions.openpopup,r.openpopup_id=r.openpopup?parseInt(e.data.actions.openpopup):0,r.closepopup=void 0!==e.data.actions.closepopup,r.closedelay=r.closepopup?parseInt(e.data.actions.closepopup):0,r.closepopup&&e.data.actions.closedelay&&(r.closedelay=parseInt(e.data.actions.closedelay))),window.PUM.forms.success(i,r))}}))})},"./node_modules/@babel/runtime/helpers/arrayLikeToArray.js":function(e,o){e.exports=function(e,o){(null==o||o>e.length)&&(o=e.length);for(var t=0,n=new Array(o);t<o;t++)n[t]=e[t];return n}},"./node_modules/@babel/runtime/helpers/arrayWithHoles.js":function(e,o){e.exports=function(e){if(Array.isArray(e))return e}},"./node_modules/@babel/runtime/helpers/iterableToArrayLimit.js":function(e,o){e.exports=function(e,o){if("undefined"!=typeof Symbol&&Symbol.iterator in Object(e)){var t=[],n=!0,i=!1,r=void 0;try{for(var s,a=e[Symbol.iterator]();!(n=(s=a.next()).done)&&(t.push(s.value),!o||t.length!==o);n=!0);}catch(e){i=!0,r=e}finally{try{n||null==a.return||a.return()}finally{if(i)throw r}}return t}}},"./node_modules/@babel/runtime/helpers/nonIterableRest.js":function(e,o){e.exports=function(){throw new TypeError("Invalid attempt to destructure non-iterable instance.\nIn order to be iterable, non-array objects must have a [Symbol.iterator]() method.")}},"./node_modules/@babel/runtime/helpers/slicedToArray.js":function(e,o,t){var n=t("./node_modules/@babel/runtime/helpers/arrayWithHoles.js"),i=t("./node_modules/@babel/runtime/helpers/iterableToArrayLimit.js"),r=t("./node_modules/@babel/runtime/helpers/unsupportedIterableToArray.js"),s=t("./node_modules/@babel/runtime/helpers/nonIterableRest.js");e.exports=function(e,o){return n(e)||i(e,o)||r(e,o)||s()}},"./node_modules/@babel/runtime/helpers/unsupportedIterableToArray.js":function(e,o,t){var n=t("./node_modules/@babel/runtime/helpers/arrayLikeToArray.js");e.exports=function(e,o){if(e){if("string"==typeof e)return n(e,o);var t=Object.prototype.toString.call(e).slice(8,-1);return"Map"===(t="Object"===t&&e.constructor?e.constructor.name:t)||"Set"===t?Array.from(e):"Arguments"===t||/^(?:Ui|I)nt(?:8|16|32)(?:Clamped)?Array$/.test(t)?n(e,o):void 0}}}}),function(t){var n={};function i(e){if(n[e])return n[e].exports;var o=n[e]={i:e,l:!1,exports:{}};return t[e].call(o.exports,o,o.exports,i),o.l=!0,o.exports}i.m=t,i.c=n,i.d=function(e,o,t){i.o(e,o)||Object.defineProperty(e,o,{enumerable:!0,get:t})},i.r=function(e){"undefined"!=typeof Symbol&&Symbol.toStringTag&&Object.defineProperty(e,Symbol.toStringTag,{value:"Module"}),Object.defineProperty(e,"__esModule",{value:!0})},i.t=function(o,e){if(1&e&&(o=i(o)),8&e)return o;if(4&e&&"object"==typeof o&&o&&o.__esModule)return o;var t=Object.create(null);if(i.r(t),Object.defineProperty(t,"default",{enumerable:!0,value:o}),2&e&&"string"!=typeof o)for(var n in o)i.d(t,n,function(e){return o[e]}.bind(null,n));return t},i.n=function(e){var o=e&&e.__esModule?function(){return e.default}:function(){return e};return i.d(o,"a",o),o},i.o=function(e,o){return Object.prototype.hasOwnProperty.call(e,o)},i.p="",i(i.s="./assets/js/src/integration/wpforms.js")}({"./assets/js/src/integration/wpforms.js":function(e,o){var r=window.jQuery;r(document).on("wpformsAjaxSubmitSuccess",".wpforms-ajax-form",function(e,o){var t=r(this),n=t.data("formid"),i=r("form#"+t.attr("id")).index(t)+1;window.PUM.integrations.formSubmission(t,{formProvider:"wpforms",formId:n,formInstanceId:i})})}}),function(e){("object"!=typeof exports||"undefined"==typeof module)&&"function"==typeof define&&define.amd?define(e):e()}(function(){"use strict";function e(o){var t=this.constructor;return this.then(function(e){return t.resolve(o()).then(function(){return e})},function(e){return t.resolve(o()).then(function(){return t.reject(e)})})}var o=setTimeout;function p(e){return Boolean(e&&void 0!==e.length)}function n(){}function r(e){if(!(this instanceof r))throw new TypeError("Promises must be constructed via new");if("function"!=typeof e)throw new TypeError("not a function");this._state=0,this._handled=!1,this._value=void 0,this._deferreds=[],c(e,this)}function i(t,n){for(;3===t._state;)t=t._value;0!==t._state?(t._handled=!0,r._immediateFn(function(){var e,o=1===t._state?n.onFulfilled:n.onRejected;if(null!==o){try{e=o(t._value)}catch(e){return void a(n.promise,e)}s(n.promise,e)}else(1===t._state?s:a)(n.promise,t._value)})):t._deferreds.push(n)}function s(o,e){try{if(e===o)throw new TypeError("A promise cannot be resolved with itself.");if(e&&("object"==typeof e||"function"==typeof e)){var t=e.then;if(e instanceof r)return o._state=3,o._value=e,void u(o);if("function"==typeof t)return void c((n=t,i=e,function(){n.apply(i,arguments)}),o)}o._state=1,o._value=e,u(o)}catch(e){a(o,e)}var n,i}function a(e,o){e._state=2,e._value=o,u(e)}function u(e){2===e._state&&0===e._deferreds.length&&r._immediateFn(function(){e._handled||r._unhandledRejectionFn(e._value)});for(var o=0,t=e._deferreds.length;o<t;o++)i(e,e._deferreds[o]);e._deferreds=null}function l(e,o,t){this.onFulfilled="function"==typeof e?e:null,this.onRejected="function"==typeof o?o:null,this.promise=t}function c(e,o){var t=!1;try{e(function(e){t||(t=!0,s(o,e))},function(e){t||(t=!0,a(o,e))})}catch(e){if(t)return;t=!0,a(o,e)}}r.prototype.catch=function(e){return this.then(null,e)},r.prototype.then=function(e,o){var t=new this.constructor(n);return i(this,new l(e,o,t)),t},r.prototype.finally=e,r.all=function(o){return new r(function(i,r){if(!p(o))return r(new TypeError("Promise.all accepts an array"));var s=Array.prototype.slice.call(o);if(0===s.length)return i([]);var a=s.length;for(var e=0;e<s.length;e++)!function o(t,e){try{if(e&&("object"==typeof e||"function"==typeof e)){var n=e.then;if("function"==typeof n)return void n.call(e,function(e){o(t,e)},r)}s[t]=e,0==--a&&i(s)}catch(e){r(e)}}(e,s[e])})},r.resolve=function(o){return o&&"object"==typeof o&&o.constructor===r?o:new r(function(e){e(o)})},r.reject=function(t){return new r(function(e,o){o(t)})},r.race=function(i){return new r(function(e,o){if(!p(i))return o(new TypeError("Promise.race accepts an array"));for(var t=0,n=i.length;t<n;t++)r.resolve(i[t]).then(e,o)})},r._immediateFn="function"==typeof setImmediate?function(e){setImmediate(e)}:function(e){o(e,0)},r._unhandledRejectionFn=function(e){"undefined"!=typeof console&&console&&console.warn("Possible Unhandled Promise Rejection:",e)};var t=function(){if("undefined"!=typeof self)return self;if("undefined"!=typeof window)return window;if("undefined"!=typeof global)return global;throw new Error("unable to locate global object")}();"Promise"in t?t.Promise.prototype.finally||(t.Promise.prototype.finally=e):t.Promise=r});
!function(){"use strict";var e={d:function(t,n){for(var o in n)e.o(n,o)&&!e.o(t,o)&&Object.defineProperty(t,o,{enumerable:!0,get:n[o]})},o:function(e,t){return Object.prototype.hasOwnProperty.call(e,t)}},t={};function n(e){"undefined"!=typeof document&&("complete"!==document.readyState&&"interactive"!==document.readyState?document.addEventListener("DOMContentLoaded",e):e())}e.d(t,{default:function(){return n}}),(window.wp=window.wp||{}).domReady=t.default}();
!function(){"use strict";var t={n:function(e){var n=e&&e.__esModule?function(){return e.default}:function(){return e};return t.d(n,{a:n}),n},d:function(e,n){for(var i in n)t.o(n,i)&&!t.o(e,i)&&Object.defineProperty(e,i,{enumerable:!0,get:n[i]})},o:function(t,e){return Object.prototype.hasOwnProperty.call(t,e)},r:function(t){"undefined"!=typeof Symbol&&Symbol.toStringTag&&Object.defineProperty(t,Symbol.toStringTag,{value:"Module"}),Object.defineProperty(t,"__esModule",{value:!0})}},e={};t.r(e),t.d(e,{setup:function(){return d},speak:function(){return p}});var n=window.wp.domReady,i=t.n(n),o=window.wp.i18n;function r(){let t=arguments.length>0&&void 0!==arguments[0]?arguments[0]:"polite";const e=document.createElement("div");e.id=`a11y-speak-${t}`,e.className="a11y-speak-region",e.setAttribute("style","position: absolute;margin: -1px;padding: 0;height: 1px;width: 1px;overflow: hidden;clip: rect(1px, 1px, 1px, 1px);-webkit-clip-path: inset(50%);clip-path: inset(50%);border: 0;word-wrap: normal !important;"),e.setAttribute("aria-live",t),e.setAttribute("aria-relevant","additions text"),e.setAttribute("aria-atomic","true");const{body:n}=document;return n&&n.appendChild(e),e}let a="";function d(){const t=document.getElementById("a11y-speak-intro-text"),e=document.getElementById("a11y-speak-assertive"),n=document.getElementById("a11y-speak-polite");null===t&&function(){const t=document.createElement("p");t.id="a11y-speak-intro-text",t.className="a11y-speak-intro-text",t.textContent=(0,o.__)("Notifications"),t.setAttribute("style","position: absolute;margin: -1px;padding: 0;height: 1px;width: 1px;overflow: hidden;clip: rect(1px, 1px, 1px, 1px);-webkit-clip-path: inset(50%);clip-path: inset(50%);border: 0;word-wrap: normal !important;"),t.setAttribute("hidden","hidden");const{body:e}=document;e&&e.appendChild(t)}(),null===e&&r("assertive"),null===n&&r("polite")}function p(t,e){!function(){const t=document.getElementsByClassName("a11y-speak-region"),e=document.getElementById("a11y-speak-intro-text");for(let e=0;e<t.length;e++)t[e].textContent="";e&&e.setAttribute("hidden","hidden")}(),t=function(t){return t=t.replace(/<[^<>]+>/g," "),a===t&&(t+=" "),a=t,t}(t);const n=document.getElementById("a11y-speak-intro-text"),i=document.getElementById("a11y-speak-assertive"),o=document.getElementById("a11y-speak-polite");i&&"assertive"===e?i.textContent=t:o&&(o.textContent=t),n&&n.removeAttribute("hidden")}i()(d),(window.wp=window.wp||{}).a11y=e}();
(function (global, factory){
typeof exports==='object'&&typeof module!=='undefined' ? module.exports=factory() :
typeof define==='function'&&define.amd ? define(factory) :
(global=global||self, (global.Vimeo=global.Vimeo||{}, global.Vimeo.Player=factory()));
}(this, (function (){ 'use strict';
function _classCallCheck(instance, Constructor){
if(!(instance instanceof Constructor)){
throw new TypeError("Cannot call a class as a function");
}}
function _defineProperties(target, props){
for (var i=0; i < props.length; i++){
var descriptor=props[i];
descriptor.enumerable=descriptor.enumerable||false;
descriptor.configurable=true;
if("value" in descriptor) descriptor.writable=true;
Object.defineProperty(target, descriptor.key, descriptor);
}}
function _createClass(Constructor, protoProps, staticProps){
if(protoProps) _defineProperties(Constructor.prototype, protoProps);
if(staticProps) _defineProperties(Constructor, staticProps);
return Constructor;
}
var isNode=typeof global!=='undefined'&&{}.toString.call(global)==='[object global]';
function getMethodName(prop, type){
if(prop.indexOf(type.toLowerCase())===0){
return prop;
}
return "".concat(type.toLowerCase()).concat(prop.substr(0, 1).toUpperCase()).concat(prop.substr(1));
}
function isDomElement(element){
return Boolean(element&&element.nodeType===1&&'nodeName' in element&&element.ownerDocument&&element.ownerDocument.defaultView);
}
function isInteger(value){
return !isNaN(parseFloat(value))&&isFinite(value)&&Math.floor(value)==value;
}
function isVimeoUrl(url){
return /^(https?:)?\/\/((player|www)\.)?vimeo\.com(?=$|\/)/.test(url);
}
function getVimeoUrl(){
var oEmbedParameters=arguments.length > 0&&arguments[0]!==undefined ? arguments[0]:{};
var id=oEmbedParameters.id;
var url=oEmbedParameters.url;
var idOrUrl=id||url;
if(!idOrUrl){
throw new Error('An id or url must be passed, either in an options object or as a data-vimeo-id or data-vimeo-url attribute.');
}
if(isInteger(idOrUrl)){
return "https://vimeo.com/".concat(idOrUrl);
}
if(isVimeoUrl(idOrUrl)){
return idOrUrl.replace('http:', 'https:');
}
if(id){
throw new TypeError("\u201C".concat(id, "\u201D is not a valid video id."));
}
throw new TypeError("\u201C".concat(idOrUrl, "\u201D is not a vimeo.com url."));
}
var arrayIndexOfSupport=typeof Array.prototype.indexOf!=='undefined';
var postMessageSupport=typeof window!=='undefined'&&typeof window.postMessage!=='undefined';
if(!isNode&&(!arrayIndexOfSupport||!postMessageSupport)){
throw new Error('Sorry, the Vimeo Player API is not available in this browser.');
}
var commonjsGlobal=typeof globalThis!=='undefined' ? globalThis:typeof window!=='undefined' ? window:typeof global!=='undefined' ? global:typeof self!=='undefined' ? self:{};
function createCommonjsModule(fn, module){
return module={ exports: {}}, fn(module, module.exports), module.exports;
}
(function (self){
if(self.WeakMap){
return;
}
var hasOwnProperty=Object.prototype.hasOwnProperty;
var defineProperty=function (object, name, value){
if(Object.defineProperty){
Object.defineProperty(object, name, {
configurable: true,
writable: true,
value: value
});
}else{
object[name]=value;
}};
self.WeakMap=function (){
function WeakMap(){
if(this===void 0){
throw new TypeError("Constructor WeakMap requires 'new'");
}
defineProperty(this, '_id', genId('_WeakMap'));
if(arguments.length > 0){
throw new TypeError('WeakMap iterable is not supported');
}}
defineProperty(WeakMap.prototype, 'delete', function (key){
checkInstance(this, 'delete');
if(!isObject(key)){
return false;
}
var entry=key[this._id];
if(entry&&entry[0]===key){
delete key[this._id];
return true;
}
return false;
});
defineProperty(WeakMap.prototype, 'get', function (key){
checkInstance(this, 'get');
if(!isObject(key)){
return void 0;
}
var entry=key[this._id];
if(entry&&entry[0]===key){
return entry[1];
}
return void 0;
});
defineProperty(WeakMap.prototype, 'has', function (key){
checkInstance(this, 'has');
if(!isObject(key)){
return false;
}
var entry=key[this._id];
if(entry&&entry[0]===key){
return true;
}
return false;
});
defineProperty(WeakMap.prototype, 'set', function (key, value){
checkInstance(this, 'set');
if(!isObject(key)){
throw new TypeError('Invalid value used as weak map key');
}
var entry=key[this._id];
if(entry&&entry[0]===key){
entry[1]=value;
return this;
}
defineProperty(key, this._id, [key, value]);
return this;
});
function checkInstance(x, methodName){
if(!isObject(x)||!hasOwnProperty.call(x, '_id')){
throw new TypeError(methodName + ' method called on incompatible receiver ' + typeof x);
}}
function genId(prefix){
return prefix + '_' + rand () + '.' + rand ();
}
function rand (){
return Math.random().toString().substring(2);
}
defineProperty(WeakMap, '_polyfill', true);
return WeakMap;
}();
function isObject(x){
return Object(x)===x;
}})(typeof self!=='undefined' ? self:typeof window!=='undefined' ? window:typeof commonjsGlobal!=='undefined' ? commonjsGlobal:commonjsGlobal);
var npo_src=createCommonjsModule(function (module){
(function UMD(name, context, definition){
context[name]=context[name]||definition();
if(module.exports){
module.exports=context[name];
}})("Promise", typeof commonjsGlobal!="undefined" ? commonjsGlobal:commonjsGlobal, function DEF(){
var builtInProp,
cycle,
scheduling_queue,
ToString=Object.prototype.toString,
timer=typeof setImmediate!="undefined" ? function timer(fn){
return setImmediate(fn);
}:setTimeout;
try {
Object.defineProperty({}, "x", {});
builtInProp=function builtInProp(obj, name, val, config){
return Object.defineProperty(obj, name, {
value: val,
writable: true,
configurable: config!==false
});
};} catch (err){
builtInProp=function builtInProp(obj, name, val){
obj[name]=val;
return obj;
};}
scheduling_queue=function Queue(){
var first, last, item;
function Item(fn, self){
this.fn=fn;
this.self=self;
this.next=void 0;
}
return {
add: function add(fn, self){
item=new Item(fn, self);
if(last){
last.next=item;
}else{
first=item;
}
last=item;
item=void 0;
},
drain: function drain(){
var f=first;
first=last=cycle=void 0;
while (f){
f.fn.call(f.self);
f=f.next;
}}
};}();
function schedule(fn, self){
scheduling_queue.add(fn, self);
if(!cycle){
cycle=timer(scheduling_queue.drain);
}}
function isThenable(o){
var _then,
o_type=typeof o;
if(o!=null&&(o_type=="object"||o_type=="function")){
_then=o.then;
}
return typeof _then=="function" ? _then:false;
}
function notify(){
for (var i=0; i < this.chain.length; i++){
notifyIsolated(this, this.state===1 ? this.chain[i].success:this.chain[i].failure, this.chain[i]);
}
this.chain.length=0;
}
function notifyIsolated(self, cb, chain){
var ret, _then;
try {
if(cb===false){
chain.reject(self.msg);
}else{
if(cb===true){
ret=self.msg;
}else{
ret=cb.call(void 0, self.msg);
}
if(ret===chain.promise){
chain.reject(TypeError("Promise-chain cycle"));
}else if(_then=isThenable(ret)){
_then.call(ret, chain.resolve, chain.reject);
}else{
chain.resolve(ret);
}}
} catch (err){
chain.reject(err);
}}
function resolve(msg){
var _then,
self=this;
if(self.triggered){
return;
}
self.triggered=true;
if(self.def){
self=self.def;
}
try {
if(_then=isThenable(msg)){
schedule(function (){
var def_wrapper=new MakeDefWrapper(self);
try {
_then.call(msg, function $resolve$(){
resolve.apply(def_wrapper, arguments);
}, function $reject$(){
reject.apply(def_wrapper, arguments);
});
} catch (err){
reject.call(def_wrapper, err);
}});
}else{
self.msg=msg;
self.state=1;
if(self.chain.length > 0){
schedule(notify, self);
}}
} catch (err){
reject.call(new MakeDefWrapper(self), err);
}}
function reject(msg){
var self=this;
if(self.triggered){
return;
}
self.triggered=true;
if(self.def){
self=self.def;
}
self.msg=msg;
self.state=2;
if(self.chain.length > 0){
schedule(notify, self);
}}
function iteratePromises(Constructor, arr, resolver, rejecter){
for (var idx=0; idx < arr.length; idx++){
(function IIFE(idx){
Constructor.resolve(arr[idx]).then(function $resolver$(msg){
resolver(idx, msg);
}, rejecter);
})(idx);
}}
function MakeDefWrapper(self){
this.def=self;
this.triggered=false;
}
function MakeDef(self){
this.promise=self;
this.state=0;
this.triggered=false;
this.chain=[];
this.msg=void 0;
}
function Promise(executor){
if(typeof executor!="function"){
throw TypeError("Not a function");
}
if(this.__NPO__!==0){
throw TypeError("Not a promise");
}
this.__NPO__=1;
var def=new MakeDef(this);
this["then"]=function then(success, failure){
var o={
success: typeof success=="function" ? success:true,
failure: typeof failure=="function" ? failure:false
};
o.promise=new this.constructor(function extractChain(resolve, reject){
if(typeof resolve!="function"||typeof reject!="function"){
throw TypeError("Not a function");
}
o.resolve=resolve;
o.reject=reject;
});
def.chain.push(o);
if(def.state!==0){
schedule(notify, def);
}
return o.promise;
};
this["catch"]=function $catch$(failure){
return this.then(void 0, failure);
};
try {
executor.call(void 0, function publicResolve(msg){
resolve.call(def, msg);
}, function publicReject(msg){
reject.call(def, msg);
});
} catch (err){
reject.call(def, err);
}}
var PromisePrototype=builtInProp({}, "constructor", Promise,
false);
Promise.prototype=PromisePrototype;
builtInProp(PromisePrototype, "__NPO__", 0,
false);
builtInProp(Promise, "resolve", function Promise$resolve(msg){
var Constructor=this;
if(msg&&typeof msg=="object"&&msg.__NPO__===1){
return msg;
}
return new Constructor(function executor(resolve, reject){
if(typeof resolve!="function"||typeof reject!="function"){
throw TypeError("Not a function");
}
resolve(msg);
});
});
builtInProp(Promise, "reject", function Promise$reject(msg){
return new this(function executor(resolve, reject){
if(typeof resolve!="function"||typeof reject!="function"){
throw TypeError("Not a function");
}
reject(msg);
});
});
builtInProp(Promise, "all", function Promise$all(arr){
var Constructor=this;
if(ToString.call(arr)!="[object Array]"){
return Constructor.reject(TypeError("Not an array"));
}
if(arr.length===0){
return Constructor.resolve([]);
}
return new Constructor(function executor(resolve, reject){
if(typeof resolve!="function"||typeof reject!="function"){
throw TypeError("Not a function");
}
var len=arr.length,
msgs=Array(len),
count=0;
iteratePromises(Constructor, arr, function resolver(idx, msg){
msgs[idx]=msg;
if(++count===len){
resolve(msgs);
}}, reject);
});
});
builtInProp(Promise, "race", function Promise$race(arr){
var Constructor=this;
if(ToString.call(arr)!="[object Array]"){
return Constructor.reject(TypeError("Not an array"));
}
return new Constructor(function executor(resolve, reject){
if(typeof resolve!="function"||typeof reject!="function"){
throw TypeError("Not a function");
}
iteratePromises(Constructor, arr, function resolver(idx, msg){
resolve(msg);
}, reject);
});
});
return Promise;
});
});
var callbackMap=new WeakMap();
/**
* Store a callback for a method or event for a player.
*
* @param {Player} player The player object.
* @param {string} name The method or event name.
* @param {(function(this:Player, *): void|{resolve: function, reject: function})} callback
*        The callback to call or an object with resolve and reject functions for a promise.
* @return {void}
*/
function storeCallback(player, name, callback){
var playerCallbacks=callbackMap.get(player.element)||{};
if(!(name in playerCallbacks)){
playerCallbacks[name]=[];
}
playerCallbacks[name].push(callback);
callbackMap.set(player.element, playerCallbacks);
}
function getCallbacks(player, name){
var playerCallbacks=callbackMap.get(player.element)||{};
return playerCallbacks[name]||[];
}
function removeCallback(player, name, callback){
var playerCallbacks=callbackMap.get(player.element)||{};
if(!playerCallbacks[name]){
return true;
}
if(!callback){
playerCallbacks[name]=[];
callbackMap.set(player.element, playerCallbacks);
return true;
}
var index=playerCallbacks[name].indexOf(callback);
if(index!==-1){
playerCallbacks[name].splice(index, 1);
}
callbackMap.set(player.element, playerCallbacks);
return playerCallbacks[name]&&playerCallbacks[name].length===0;
}
function shiftCallbacks(player, name){
var playerCallbacks=getCallbacks(player, name);
if(playerCallbacks.length < 1){
return false;
}
var callback=playerCallbacks.shift();
removeCallback(player, name, callback);
return callback;
}
function swapCallbacks(oldElement, newElement){
var playerCallbacks=callbackMap.get(oldElement);
callbackMap.set(newElement, playerCallbacks);
callbackMap.delete(oldElement);
}
var oEmbedParameters=['autopause', 'autoplay', 'background', 'byline', 'color', 'controls', 'dnt', 'height', 'id', 'loop', 'maxheight', 'maxwidth', 'muted', 'playsinline', 'portrait', 'responsive', 'speed', 'texttrack', 'title', 'transparent', 'url', 'width'];
function getOEmbedParameters(element){
var defaults=arguments.length > 1&&arguments[1]!==undefined ? arguments[1]:{};
return oEmbedParameters.reduce(function (params, param){
var value=element.getAttribute("data-vimeo-".concat(param));
if(value||value===''){
params[param]=value==='' ? 1:value;
}
return params;
}, defaults);
}
function createEmbed(_ref, element){
var html=_ref.html;
if(!element){
throw new TypeError('An element must be provided');
}
if(element.getAttribute('data-vimeo-initialized')!==null){
return element.querySelector('iframe');
}
var div=document.createElement('div');
div.innerHTML=html;
element.appendChild(div.firstChild);
element.setAttribute('data-vimeo-initialized', 'true');
return element.querySelector('iframe');
}
function getOEmbedData(videoUrl){
var params=arguments.length > 1&&arguments[1]!==undefined ? arguments[1]:{};
var element=arguments.length > 2 ? arguments[2]:undefined;
return new Promise(function (resolve, reject){
if(!isVimeoUrl(videoUrl)){
throw new TypeError("\u201C".concat(videoUrl, "\u201D is not a vimeo.com url."));
}
var url="https://vimeo.com/api/oembed.json?url=".concat(encodeURIComponent(videoUrl));
for (var param in params){
if(params.hasOwnProperty(param)){
url +="&".concat(param, "=").concat(encodeURIComponent(params[param]));
}}
var xhr='XDomainRequest' in window ? new XDomainRequest():new XMLHttpRequest();
xhr.open('GET', url, true);
xhr.onload=function (){
if(xhr.status===404){
reject(new Error("\u201C".concat(videoUrl, "\u201D was not found.")));
return;
}
if(xhr.status===403){
reject(new Error("\u201C".concat(videoUrl, "\u201D is not embeddable.")));
return;
}
try {
var json=JSON.parse(xhr.responseText);
if(json.domain_status_code===403){
createEmbed(json, element);
reject(new Error("\u201C".concat(videoUrl, "\u201D is not embeddable.")));
return;
}
resolve(json);
} catch (error){
reject(error);
}};
xhr.onerror=function (){
var status=xhr.status ? " (".concat(xhr.status, ")"):'';
reject(new Error("There was an error fetching the embed code from Vimeo".concat(status, ".")));
};
xhr.send();
});
}
function initializeEmbeds(){
var parent=arguments.length > 0&&arguments[0]!==undefined ? arguments[0]:document;
var elements=[].slice.call(parent.querySelectorAll('[data-vimeo-id], [data-vimeo-url]'));
var handleError=function handleError(error){
if('console' in window&&console.error){
console.error("There was an error creating an embed: ".concat(error));
}};
elements.forEach(function (element){
try {
if(element.getAttribute('data-vimeo-defer')!==null){
return;
}
var params=getOEmbedParameters(element);
var url=getVimeoUrl(params);
getOEmbedData(url, params, element).then(function (data){
return createEmbed(data, element);
}).catch(handleError);
} catch (error){
handleError(error);
}});
}
function resizeEmbeds(){
var parent=arguments.length > 0&&arguments[0]!==undefined ? arguments[0]:document;
if(window.VimeoPlayerResizeEmbeds_){
return;
}
window.VimeoPlayerResizeEmbeds_=true;
var onMessage=function onMessage(event){
if(!isVimeoUrl(event.origin)){
return;
} // 'spacechange' is fired only on embeds with cards
if(!event.data||event.data.event!=='spacechange'){
return;
}
var iframes=parent.querySelectorAll('iframe');
for (var i=0; i < iframes.length; i++){
if(iframes[i].contentWindow!==event.source){
continue;
}
var space=iframes[i].parentElement;
space.style.paddingBottom="".concat(event.data.data[0].bottom, "px");
break;
}};
window.addEventListener('message', onMessage);
}
function parseMessageData(data){
if(typeof data==='string'){
try {
data=JSON.parse(data);
} catch (error){
console.warn(error);
return {};}}
return data;
}
function postMessage(player, method, params){
if(!player.element.contentWindow||!player.element.contentWindow.postMessage){
return;
}
var message={
method: method
};
if(params!==undefined){
message.value=params;
}
var ieVersion=parseFloat(navigator.userAgent.toLowerCase().replace(/^.*msie (\d+).*$/, '$1'));
if(ieVersion >=8&&ieVersion < 10){
message=JSON.stringify(message);
}
player.element.contentWindow.postMessage(message, player.origin);
}
function processData(player, data){
data=parseMessageData(data);
var callbacks=[];
var param;
if(data.event){
if(data.event==='error'){
var promises=getCallbacks(player, data.data.method);
promises.forEach(function (promise){
var error=new Error(data.data.message);
error.name=data.data.name;
promise.reject(error);
removeCallback(player, data.data.method, promise);
});
}
callbacks=getCallbacks(player, "event:".concat(data.event));
param=data.data;
}else if(data.method){
var callback=shiftCallbacks(player, data.method);
if(callback){
callbacks.push(callback);
param=data.value;
}}
callbacks.forEach(function (callback){
try {
if(typeof callback==='function'){
callback.call(player, param);
return;
}
callback.resolve(param);
} catch (e){
}});
}
function initializeScreenfull(){
var fn=function (){
var val;
var fnMap=[['requestFullscreen', 'exitFullscreen', 'fullscreenElement', 'fullscreenEnabled', 'fullscreenchange', 'fullscreenerror'],
['webkitRequestFullscreen', 'webkitExitFullscreen', 'webkitFullscreenElement', 'webkitFullscreenEnabled', 'webkitfullscreenchange', 'webkitfullscreenerror'],
['webkitRequestFullScreen', 'webkitCancelFullScreen', 'webkitCurrentFullScreenElement', 'webkitCancelFullScreen', 'webkitfullscreenchange', 'webkitfullscreenerror'], ['mozRequestFullScreen', 'mozCancelFullScreen', 'mozFullScreenElement', 'mozFullScreenEnabled', 'mozfullscreenchange', 'mozfullscreenerror'], ['msRequestFullscreen', 'msExitFullscreen', 'msFullscreenElement', 'msFullscreenEnabled', 'MSFullscreenChange', 'MSFullscreenError']];
var i=0;
var l=fnMap.length;
var ret={};
for (; i < l; i++){
val=fnMap[i];
if(val&&val[1] in document){
for (i=0; i < val.length; i++){
ret[fnMap[0][i]]=val[i];
}
return ret;
}}
return false;
}();
var eventNameMap={
fullscreenchange: fn.fullscreenchange,
fullscreenerror: fn.fullscreenerror
};
var screenfull={
request: function request(element){
return new Promise(function (resolve, reject){
var onFullScreenEntered=function onFullScreenEntered(){
screenfull.off('fullscreenchange', onFullScreenEntered);
resolve();
};
screenfull.on('fullscreenchange', onFullScreenEntered);
element=element||document.documentElement;
var returnPromise=element[fn.requestFullscreen]();
if(returnPromise instanceof Promise){
returnPromise.then(onFullScreenEntered).catch(reject);
}});
},
exit: function exit(){
return new Promise(function (resolve, reject){
if(!screenfull.isFullscreen){
resolve();
return;
}
var onFullScreenExit=function onFullScreenExit(){
screenfull.off('fullscreenchange', onFullScreenExit);
resolve();
};
screenfull.on('fullscreenchange', onFullScreenExit);
var returnPromise=document[fn.exitFullscreen]();
if(returnPromise instanceof Promise){
returnPromise.then(onFullScreenExit).catch(reject);
}});
},
on: function on(event, callback){
var eventName=eventNameMap[event];
if(eventName){
document.addEventListener(eventName, callback);
}},
off: function off(event, callback){
var eventName=eventNameMap[event];
if(eventName){
document.removeEventListener(eventName, callback);
}}
};
Object.defineProperties(screenfull, {
isFullscreen: {
get: function get(){
return Boolean(document[fn.fullscreenElement]);
}},
element: {
enumerable: true,
get: function get(){
return document[fn.fullscreenElement];
}},
isEnabled: {
enumerable: true,
get: function get(){
return Boolean(document[fn.fullscreenEnabled]);
}}
});
return screenfull;
}
var playerMap=new WeakMap();
var readyMap=new WeakMap();
var screenfull={};
var Player =
function (){
function Player(element){
var _this=this;
var options=arguments.length > 1&&arguments[1]!==undefined ? arguments[1]:{};
_classCallCheck(this, Player);
if(window.jQuery&&element instanceof jQuery){
if(element.length > 1&&window.console&&console.warn){
console.warn('A jQuery object with multiple elements was passed, using the first element.');
}
element=element[0];
}
if(typeof document!=='undefined'&&typeof element==='string'){
element=document.getElementById(element);
}
if(!isDomElement(element)){
throw new TypeError('You must pass either a valid element or a valid id.');
}
if(element.nodeName!=='IFRAME'){
var iframe=element.querySelector('iframe');
if(iframe){
element=iframe;
}}
if(element.nodeName==='IFRAME'&&!isVimeoUrl(element.getAttribute('src')||'')){
throw new Error('The player element passed isn’t a Vimeo embed.');
}
if(playerMap.has(element)){
return playerMap.get(element);
}
this._window=element.ownerDocument.defaultView;
this.element=element;
this.origin='*';
var readyPromise=new npo_src(function (resolve, reject){
_this._onMessage=function (event){
if(!isVimeoUrl(event.origin)||_this.element.contentWindow!==event.source){
return;
}
if(_this.origin==='*'){
_this.origin=event.origin;
}
var data=parseMessageData(event.data);
var isError=data&&data.event==='error';
var isReadyError=isError&&data.data&&data.data.method==='ready';
if(isReadyError){
var error=new Error(data.data.message);
error.name=data.data.name;
reject(error);
return;
}
var isReadyEvent=data&&data.event==='ready';
var isPingResponse=data&&data.method==='ping';
if(isReadyEvent||isPingResponse){
_this.element.setAttribute('data-ready', 'true');
resolve();
return;
}
processData(_this, data);
};
_this._window.addEventListener('message', _this._onMessage);
if(_this.element.nodeName!=='IFRAME'){
var params=getOEmbedParameters(element, options);
var url=getVimeoUrl(params);
getOEmbedData(url, params, element).then(function (data){
var iframe=createEmbed(data, element);
_this.element=iframe;
_this._originalElement=element;
swapCallbacks(element, iframe);
playerMap.set(_this.element, _this);
return data;
}).catch(reject);
}});
readyMap.set(this, readyPromise);
playerMap.set(this.element, this);
if(this.element.nodeName==='IFRAME'){
postMessage(this, 'ping');
}
if(screenfull.isEnabled){
var exitFullscreen=function exitFullscreen(){
return screenfull.exit();
};
screenfull.on('fullscreenchange', function (){
if(screenfull.isFullscreen){
storeCallback(_this, 'event:exitFullscreen', exitFullscreen);
}else{
removeCallback(_this, 'event:exitFullscreen', exitFullscreen);
}
_this.ready().then(function (){
postMessage(_this, 'fullscreenchange', screenfull.isFullscreen);
});
});
}
return this;
}
_createClass(Player, [{
key: "callMethod",
value: function callMethod(name){
var _this2=this;
var args=arguments.length > 1&&arguments[1]!==undefined ? arguments[1]:{};
return new npo_src(function (resolve, reject){
return _this2.ready().then(function (){
storeCallback(_this2, name, {
resolve: resolve,
reject: reject
});
postMessage(_this2, name, args);
}).catch(reject);
});
}
}, {
key: "get",
value: function get(name){
var _this3=this;
return new npo_src(function (resolve, reject){
name=getMethodName(name, 'get');
return _this3.ready().then(function (){
storeCallback(_this3, name, {
resolve: resolve,
reject: reject
});
postMessage(_this3, name);
}).catch(reject);
});
}
}, {
key: "set",
value: function set(name, value){
var _this4=this;
return new npo_src(function (resolve, reject){
name=getMethodName(name, 'set');
if(value===undefined||value===null){
throw new TypeError('There must be a value to set.');
}
return _this4.ready().then(function (){
storeCallback(_this4, name, {
resolve: resolve,
reject: reject
});
postMessage(_this4, name, value);
}).catch(reject);
});
}
/**
* Add an event listener for the specified event. Will call the
* callback with a single parameter, `data`, that contains the data for
* that event.
*
* @param {string} eventName The name of the event.
* @param {function(*)} callback The function to call when the event fires.
* @return {void}
*/
}, {
key: "on",
value: function on(eventName, callback){
if(!eventName){
throw new TypeError('You must pass an event name.');
}
if(!callback){
throw new TypeError('You must pass a callback function.');
}
if(typeof callback!=='function'){
throw new TypeError('The callback must be a function.');
}
var callbacks=getCallbacks(this, "event:".concat(eventName));
if(callbacks.length===0){
this.callMethod('addEventListener', eventName).catch(function (){
});
}
storeCallback(this, "event:".concat(eventName), callback);
}
}, {
key: "off",
value: function off(eventName, callback){
if(!eventName){
throw new TypeError('You must pass an event name.');
}
if(callback&&typeof callback!=='function'){
throw new TypeError('The callback must be a function.');
}
var lastCallback=removeCallback(this, "event:".concat(eventName), callback);
if(lastCallback){
this.callMethod('removeEventListener', eventName).catch(function (e){
});
}}
}, {
key: "loadVideo",
value: function loadVideo(options){
return this.callMethod('loadVideo', options);
}
}, {
key: "ready",
value: function ready(){
var readyPromise=readyMap.get(this)||new npo_src(function (resolve, reject){
reject(new Error('Unknown player. Probably unloaded.'));
});
return npo_src.resolve(readyPromise);
}
}, {
key: "addCuePoint",
value: function addCuePoint(time){
var data=arguments.length > 1&&arguments[1]!==undefined ? arguments[1]:{};
return this.callMethod('addCuePoint', {
time: time,
data: data
});
}
}, {
key: "removeCuePoint",
value: function removeCuePoint(id){
return this.callMethod('removeCuePoint', id);
}
}, {
key: "enableTextTrack",
value: function enableTextTrack(language, kind){
if(!language){
throw new TypeError('You must pass a language.');
}
return this.callMethod('enableTextTrack', {
language: language,
kind: kind
});
}
}, {
key: "disableTextTrack",
value: function disableTextTrack(){
return this.callMethod('disableTextTrack');
}
}, {
key: "pause",
value: function pause(){
return this.callMethod('pause');
}
}, {
key: "play",
value: function play(){
return this.callMethod('play');
}
}, {
key: "requestFullscreen",
value: function requestFullscreen(){
if(screenfull.isEnabled){
return screenfull.request(this.element);
}
return this.callMethod('requestFullscreen');
}
}, {
key: "exitFullscreen",
value: function exitFullscreen(){
if(screenfull.isEnabled){
return screenfull.exit();
}
return this.callMethod('exitFullscreen');
}
}, {
key: "getFullscreen",
value: function getFullscreen(){
if(screenfull.isEnabled){
return npo_src.resolve(screenfull.isFullscreen);
}
return this.get('fullscreen');
}
}, {
key: "unload",
value: function unload(){
return this.callMethod('unload');
}
}, {
key: "destroy",
value: function destroy(){
var _this5=this;
return new npo_src(function (resolve){
readyMap.delete(_this5);
playerMap.delete(_this5.element);
if(_this5._originalElement){
playerMap.delete(_this5._originalElement);
_this5._originalElement.removeAttribute('data-vimeo-initialized');
}
if(_this5.element&&_this5.element.nodeName==='IFRAME'&&_this5.element.parentNode){
_this5.element.parentNode.removeChild(_this5.element);
}
_this5._window.removeEventListener('message', _this5._onMessage);
resolve();
});
}
}, {
key: "getAutopause",
value: function getAutopause(){
return this.get('autopause');
}
}, {
key: "setAutopause",
value: function setAutopause(autopause){
return this.set('autopause', autopause);
}
}, {
key: "getBuffered",
value: function getBuffered(){
return this.get('buffered');
}
}, {
key: "getChapters",
value: function getChapters(){
return this.get('chapters');
}
}, {
key: "getCurrentChapter",
value: function getCurrentChapter(){
return this.get('currentChapter');
}
}, {
key: "getColor",
value: function getColor(){
return this.get('color');
}
}, {
key: "setColor",
value: function setColor(color){
return this.set('color', color);
}
}, {
key: "getCuePoints",
value: function getCuePoints(){
return this.get('cuePoints');
}
}, {
key: "getCurrentTime",
value: function getCurrentTime(){
return this.get('currentTime');
}
}, {
key: "setCurrentTime",
value: function setCurrentTime(currentTime){
return this.set('currentTime', currentTime);
}
}, {
key: "getDuration",
value: function getDuration(){
return this.get('duration');
}
}, {
key: "getEnded",
value: function getEnded(){
return this.get('ended');
}
}, {
key: "getLoop",
value: function getLoop(){
return this.get('loop');
}
}, {
key: "setLoop",
value: function setLoop(loop){
return this.set('loop', loop);
}
}, {
key: "setMuted",
value: function setMuted(muted){
return this.set('muted', muted);
}
}, {
key: "getMuted",
value: function getMuted(){
return this.get('muted');
}
}, {
key: "getPaused",
value: function getPaused(){
return this.get('paused');
}
}, {
key: "getPlaybackRate",
value: function getPlaybackRate(){
return this.get('playbackRate');
}
}, {
key: "setPlaybackRate",
value: function setPlaybackRate(playbackRate){
return this.set('playbackRate', playbackRate);
}
}, {
key: "getPlayed",
value: function getPlayed(){
return this.get('played');
}
}, {
key: "getSeekable",
value: function getSeekable(){
return this.get('seekable');
}
}, {
key: "getSeeking",
value: function getSeeking(){
return this.get('seeking');
}
}, {
key: "getTextTracks",
value: function getTextTracks(){
return this.get('textTracks');
}
}, {
key: "getVideoEmbedCode",
value: function getVideoEmbedCode(){
return this.get('videoEmbedCode');
}
}, {
key: "getVideoId",
value: function getVideoId(){
return this.get('videoId');
}
}, {
key: "getVideoTitle",
value: function getVideoTitle(){
return this.get('videoTitle');
}
}, {
key: "getVideoWidth",
value: function getVideoWidth(){
return this.get('videoWidth');
}
}, {
key: "getVideoHeight",
value: function getVideoHeight(){
return this.get('videoHeight');
}
}, {
key: "getVideoUrl",
value: function getVideoUrl(){
return this.get('videoUrl');
}
}, {
key: "getVolume",
value: function getVolume(){
return this.get('volume');
}
}, {
key: "setVolume",
value: function setVolume(volume){
return this.set('volume', volume);
}}]);
return Player;
}();
if(!isNode){
screenfull=initializeScreenfull();
initializeEmbeds();
resizeEmbeds();
}
return Player;
})));
!function(e){var t=!0;e.flexslider=function(a,n){var i=e(a);void 0===n.rtl&&"rtl"==e("html").attr("dir")&&(n.rtl=!0),i.vars=e.extend({},e.flexslider.defaults,n);var s,r=i.vars.namespace,o=window.navigator&&window.navigator.msPointerEnabled&&window.MSGesture,l=("ontouchstart"in window||o||window.DocumentTouch&&document instanceof DocumentTouch)&&i.vars.touch,d="click touchend MSPointerUp",c="",u="vertical"===i.vars.direction,v=i.vars.reverse,p=i.vars.itemWidth>0,m="fade"===i.vars.animation,f=""!==i.vars.asNavFor,h={};e.data(a,"flexslider",i),h={init:function(){i.animating=!1,i.currentSlide=parseInt(i.vars.startAt?i.vars.startAt:0,10),isNaN(i.currentSlide)&&(i.currentSlide=0),i.animatingTo=i.currentSlide,i.atEnd=0===i.currentSlide||i.currentSlide===i.last,i.containerSelector=i.vars.selector.substr(0,i.vars.selector.search(" ")),i.slides=e(i.vars.selector,i),i.container=e(i.containerSelector,i),i.count=i.slides.length,i.syncExists=e(i.vars.sync).length>0,"slide"===i.vars.animation&&(i.vars.animation="swing"),i.prop=u?"top":i.vars.rtl?"marginRight":"marginLeft",i.args={},i.manualPause=!1,i.stopped=!1,i.started=!1,i.startTimeout=null,i.transitions=!i.vars.video&&!m&&i.vars.useCSS&&function(){var e=document.createElement("div"),t=["perspectiveProperty","WebkitPerspective","MozPerspective","OPerspective","msPerspective"];for(var a in t)if(void 0!==e.style[t[a]])return i.pfx=t[a].replace("Perspective","").toLowerCase(),i.prop="-"+i.pfx+"-transform",!0;return!1}(),i.isFirefox=navigator.userAgent.toLowerCase().indexOf("firefox")>-1,i.ensureAnimationEnd="",""!==i.vars.controlsContainer&&(i.controlsContainer=e(i.vars.controlsContainer).length>0&&e(i.vars.controlsContainer)),""!==i.vars.manualControls&&(i.manualControls=e(i.vars.manualControls).length>0&&e(i.vars.manualControls)),""!==i.vars.customDirectionNav&&(i.customDirectionNav=2===e(i.vars.customDirectionNav).length&&e(i.vars.customDirectionNav)),i.vars.randomize&&(i.slides.sort((function(){return Math.round(Math.random())-.5})),i.container.empty().append(i.slides)),i.doMath(),i.setup("init"),i.vars.controlNav&&h.controlNav.setup(),i.vars.directionNav&&h.directionNav.setup(),i.vars.keyboard&&(1===e(i.containerSelector).length||i.vars.multipleKeyboard)&&e(document).bind("keyup",(function(e){var t=e.keyCode;if(!i.animating&&(39===t||37===t)){var a=i.vars.rtl?37===t?i.getTarget("next"):39===t&&i.getTarget("prev"):39===t?i.getTarget("next"):37===t&&i.getTarget("prev");i.flexAnimate(a,i.vars.pauseOnAction)}})),i.vars.mousewheel&&i.bind("mousewheel",(function(e,t,a,n){e.preventDefault();var s=t<0?i.getTarget("next"):i.getTarget("prev");i.flexAnimate(s,i.vars.pauseOnAction)})),i.vars.pausePlay&&h.pausePlay.setup(),i.vars.slideshow&&i.vars.pauseInvisible&&h.pauseInvisible.init(),i.vars.slideshow&&(i.vars.pauseOnHover&&i.hover((function(){i.manualPlay||i.manualPause||i.pause()}),(function(){i.manualPause||i.manualPlay||i.stopped||i.play()})),i.vars.pauseInvisible&&h.pauseInvisible.isHidden()||(i.vars.initDelay>0?i.startTimeout=setTimeout(i.play,i.vars.initDelay):i.play())),f&&h.asNav.setup(),l&&i.vars.touch&&h.touch(),(!m||m&&i.vars.smoothHeight)&&e(window).on("resize orientationchange focus",h.resize),i.find("img").attr("draggable","false"),setTimeout((function(){i.vars.start(i)}),200)},asNav:{setup:function(){i.asNav=!0,i.animatingTo=Math.floor(i.currentSlide/i.move),i.currentItem=i.currentSlide,i.slides.removeClass(r+"active-slide").eq(i.currentItem).addClass(r+"active-slide"),o?(a._slider=i,i.slides.each((function(){var t=this;t._gesture=new MSGesture,t._gesture.target=t,t.addEventListener("MSPointerDown",(function(e){e.preventDefault(),e.currentTarget._gesture&&e.currentTarget._gesture.addPointer(e.pointerId)}),{passive:!0}),t.addEventListener("MSGestureTap",(function(t){t.preventDefault();var a=e(this),n=a.index();e(i.vars.asNavFor).data("flexslider").animating||a.hasClass("active")||(i.direction=i.currentItem<n?"next":"prev",i.flexAnimate(n,i.vars.pauseOnAction,!1,!0,!0))}),{passive:!0})}))):i.slides.on(d,(function(t){t.preventDefault();var a=e(this),n=a.index();(i.vars.rtl?-1*(a.offset().right-e(i).scrollLeft()):a.offset().left-e(i).scrollLeft())<=0&&a.hasClass(r+"active-slide")?i.flexAnimate(i.getTarget("prev"),!0):e(i.vars.asNavFor).data("flexslider").animating||a.hasClass(r+"active-slide")||(i.direction=i.currentItem<n?"next":"prev",i.flexAnimate(n,i.vars.pauseOnAction,!1,!0,!0))}))}},controlNav:{setup:function(){i.manualControls?h.controlNav.setupManual():h.controlNav.setupPaging()},setupPaging:function(){var t,a,n="thumbnails"===i.vars.controlNav?"control-thumbs":"control-paging",s=1;if(i.controlNavScaffold=e('<ol class="'+r+"control-nav "+r+n+'"></ol>'),i.pagingCount>1)for(var o=0;o<i.pagingCount;o++){void 0===(a=i.slides.eq(o)).attr("data-thumb-alt")&&a.attr("data-thumb-alt","");var l=""!==a.attr("data-thumb-alt")?l=' alt="'+a.attr("data-thumb-alt")+'"':"";if(t="thumbnails"===i.vars.controlNav?'<img src="'+a.attr("data-thumb")+'"'+l+"/>":'<a href="#">'+s+"</a>","thumbnails"===i.vars.controlNav&&!0===i.vars.thumbCaptions){var u=a.attr("data-thumbcaption");""!==u&&void 0!==u&&(t+='<span class="'+r+'caption">'+u+"</span>")}i.controlNavScaffold.append("<li>"+t+"</li>"),s++}i.controlsContainer?e(i.controlsContainer).append(i.controlNavScaffold):i.append(i.controlNavScaffold),h.controlNav.set(),h.controlNav.active(),i.controlNavScaffold.delegate("a, img",d,(function(t){if(t.preventDefault(),""===c||c===t.type){var a=e(this),n=i.controlNav.index(a);a.hasClass(r+"active")||(i.direction=n>i.currentSlide?"next":"prev",i.flexAnimate(n,i.vars.pauseOnAction))}""===c&&(c=t.type),h.setToClearWatchedEvent()}))},setupManual:function(){i.controlNav=i.manualControls,h.controlNav.active(),i.controlNav.bind(d,(function(t){if(t.preventDefault(),""===c||c===t.type){var a=e(this),n=i.controlNav.index(a);a.hasClass(r+"active")||(n>i.currentSlide?i.direction="next":i.direction="prev",i.flexAnimate(n,i.vars.pauseOnAction))}""===c&&(c=t.type),h.setToClearWatchedEvent()}))},set:function(){var t="thumbnails"===i.vars.controlNav?"img":"a";i.controlNav=e("."+r+"control-nav li "+t,i.controlsContainer?i.controlsContainer:i)},active:function(){i.controlNav.removeClass(r+"active").eq(i.animatingTo).addClass(r+"active")},update:function(t,a){i.pagingCount>1&&"add"===t?i.controlNavScaffold.append(e('<li><a href="#"></a></li>')):1===i.pagingCount?i.controlNavScaffold.find("li").remove():i.controlNav.eq(a).closest("li").remove(),i.controlNavScaffold.find("li").each((function(t,a){e(a).find("a").text(t+1)})),h.controlNav.set(),i.pagingCount>1&&i.pagingCount!==i.controlNav.length?i.update(a,t):h.controlNav.active()}},directionNav:{setup:function(){var t=e('<ul class="'+r+'direction-nav"><li class="'+r+'nav-prev"><a class="'+r+'prev" href="#">'+i.vars.prevText+'</a></li><li class="'+r+'nav-next"><a class="'+r+'next" href="#">'+i.vars.nextText+"</a></li></ul>");i.customDirectionNav?i.directionNav=i.customDirectionNav:i.controlsContainer?(e(i.controlsContainer).append(t),i.directionNav=e("."+r+"direction-nav li a",i.controlsContainer)):(i.append(t),i.directionNav=e("."+r+"direction-nav li a",i)),h.directionNav.update(),i.directionNav.bind(d,(function(t){var a;t.preventDefault(),""!==c&&c!==t.type||(a=e(this).hasClass(r+"next")?i.getTarget("next"):i.getTarget("prev"),i.flexAnimate(a,i.vars.pauseOnAction)),""===c&&(c=t.type),h.setToClearWatchedEvent()}))},update:function(){var e=r+"disabled";1===i.pagingCount?i.directionNav.addClass(e).attr("tabindex","-1"):i.vars.animationLoop?i.directionNav.removeClass(e).removeAttr("tabindex"):0===i.animatingTo?i.directionNav.removeClass(e).filter("."+r+"prev").addClass(e).attr("tabindex","-1"):i.animatingTo===i.last?i.directionNav.removeClass(e).filter("."+r+"next").addClass(e).attr("tabindex","-1"):i.directionNav.removeClass(e).removeAttr("tabindex")}},pausePlay:{setup:function(){var t=e('<div aria-live="polite" class="'+r+'pauseplay"><a href="#"></a></div>');i.controlsContainer?(i.controlsContainer.append(t),i.pausePlay=e("."+r+"pauseplay a",i.controlsContainer)):(i.append(t),i.pausePlay=e("."+r+"pauseplay a",i)),h.pausePlay.update(i.vars.slideshow?r+"pause":r+"play"),i.pausePlay.bind(d,(function(t){t.preventDefault(),""!==c&&c!==t.type||(e(this).hasClass(r+"pause")?(i.manualPause=!0,i.manualPlay=!1,i.pause()):(i.manualPause=!1,i.manualPlay=!0,i.play())),""===c&&(c=t.type),h.setToClearWatchedEvent()}))},update:function(e){"play"===e?i.pausePlay.removeClass(r+"pause").addClass(r+"play").html(i.vars.playText):i.pausePlay.removeClass(r+"play").addClass(r+"pause").html(i.vars.pauseText)}},touch:function(){var e,t,n,s,r,l,d,c,f,h=!1,g=0,S=0,x=0;if(o){a.style.msTouchAction="none",a._gesture=new MSGesture,a._gesture.target=a,a.addEventListener("MSPointerDown",(function(e){e.stopPropagation(),i.animating?e.preventDefault():(i.pause(),a._gesture.addPointer(e.pointerId),x=0,s=u?i.h:i.w,l=Number(new Date),n=p&&v&&i.animatingTo===i.last?0:p&&v?i.limit-(i.itemW+i.vars.itemMargin)*i.move*i.animatingTo:p&&i.currentSlide===i.last?i.limit:p?(i.itemW+i.vars.itemMargin)*i.move*i.currentSlide:v?(i.last-i.currentSlide+i.cloneOffset)*s:(i.currentSlide+i.cloneOffset)*s)}),{passive:!0}),a._slider=i,a.addEventListener("MSGestureChange",(function(e){e.stopPropagation();var t=e.target._slider;if(!t)return;var i=-e.translationX,o=-e.translationY;if(x+=u?o:i,r=(t.vars.rtl?-1:1)*x,h=u?Math.abs(x)<Math.abs(-i):Math.abs(x)<Math.abs(-o),e.detail===e.MSGESTURE_FLAG_INERTIA)return void setImmediate((function(){a._gesture.stop()}));(!h||Number(new Date)-l>500)&&(e.preventDefault(),!m&&t.transitions&&(t.vars.animationLoop||(r=x/(0===t.currentSlide&&x<0||t.currentSlide===t.last&&x>0?Math.abs(x)/s+2:1)),t.setProps(n+r,"setTouch")))}),{passive:!0}),a.addEventListener("MSGestureEnd",(function(a){a.stopPropagation();var i=a.target._slider;if(!i)return;if(i.animatingTo===i.currentSlide&&!h&&null!==r){var o=v?-r:r,d=o>0?i.getTarget("next"):i.getTarget("prev");i.canAdvance(d)&&(Number(new Date)-l<550&&Math.abs(o)>50||Math.abs(o)>s/2)?i.flexAnimate(d,i.vars.pauseOnAction):m||i.flexAnimate(i.currentSlide,i.vars.pauseOnAction,!0)}r&&h?i.vars.slideshow&&i.play():r?!i.vars.pauseOnAction&&i.play()||(i.vars.slideshow=!1):i.vars.slideshow&&!i.vars.pauseOnAction&&i.play()||(i.vars.slideshow=!1);e=null,t=null,r=null,n=null,x=0}),{passive:!0})}else d=function(r){i.animating?r.preventDefault():(window.navigator.msPointerEnabled||1===r.touches.length)&&(i.pause(),s=u?i.h:i.w,l=Number(new Date),g=r.touches[0].pageX,S=r.touches[0].pageY,n=p&&v&&i.animatingTo===i.last?0:p&&v?i.limit-(i.itemW+i.vars.itemMargin)*i.move*i.animatingTo:p&&i.currentSlide===i.last?i.limit:p?(i.itemW+i.vars.itemMargin)*i.move*i.currentSlide:v?(i.last-i.currentSlide+i.cloneOffset)*s:(i.currentSlide+i.cloneOffset)*s,e=u?S:g,t=u?g:S,a.addEventListener("touchmove",c,{passive:!0}),a.addEventListener("touchend",f,{passive:!0}))},c=function(a){g=a.touches[0].pageX,S=a.touches[0].pageY,r=u?e-S:(i.vars.rtl?-1:1)*(e-g);(!(h=u?Math.abs(r)<Math.abs(g-t):Math.abs(r)<Math.abs(S-t))||Number(new Date)-l>500)&&(a.preventDefault(),!m&&i.transitions&&(i.vars.animationLoop||(r/=0===i.currentSlide&&r<0||i.currentSlide===i.last&&r>0?Math.abs(r)/s+2:1),i.setProps(n+r,"setTouch")))},f=function(o){if(a.removeEventListener("touchmove",c,!1),i.animatingTo===i.currentSlide&&!h&&null!==r){var d=v?-r:r,u=d>0?i.getTarget("next"):i.getTarget("prev");i.canAdvance(u)&&(Number(new Date)-l<550&&Math.abs(d)>50||Math.abs(d)>s/2)?i.flexAnimate(u,i.vars.pauseOnAction):m||i.flexAnimate(i.currentSlide,i.vars.pauseOnAction,!0)}a.removeEventListener("touchend",f,!1),r&&h?i.vars.slideshow&&i.play():r?!i.vars.pauseOnAction&&i.play()||(i.vars.slideshow=!1):i.vars.slideshow&&!i.vars.pauseOnAction&&i.play()||(i.vars.slideshow=!1),e=null,t=null,r=null,n=null},a.addEventListener("touchstart",d,{passive:!0})},resize:function(){!i.animating&&i.is(":visible")&&(p||i.doMath(),m?h.smoothHeight():p?(i.slides.width(i.computedW),i.update(i.pagingCount),i.setProps()):u?(i.viewport.height(i.h),i.setProps(i.h,"setTotal")):(i.vars.smoothHeight&&h.smoothHeight(),i.newSlides.width(i.computedW),i.setProps(i.computedW,"setTotal")))},smoothHeight:function(e){if(!u||m){var t=m?i:i.viewport;e?t.animate({height:i.slides.eq(i.animatingTo).innerHeight()},e):t.innerHeight(i.slides.eq(i.animatingTo).innerHeight())}},sync:function(t){var a=e(i.vars.sync).data("flexslider"),n=i.animatingTo;switch(t){case"animate":a.flexAnimate(n,i.vars.pauseOnAction,!1,!0);break;case"play":a.playing||a.asNav||a.play();break;case"pause":a.pause()}},uniqueID:function(t){return t.filter("[id]").add(t.find("[id]")).each((function(){var t=e(this);t.attr("id",t.attr("id")+"_clone")})),t},pauseInvisible:{visProp:null,init:function(){var e=h.pauseInvisible.getHiddenProp();if(e){var t=e.replace(/[H|h]idden/,"")+"visibilitychange";document.addEventListener(t,(function(){h.pauseInvisible.isHidden()?i.startTimeout?clearTimeout(i.startTimeout):i.pause():i.started?i.play():i.vars.initDelay>0?setTimeout(i.play,i.vars.initDelay):i.play()}))}},isHidden:function(){var e=h.pauseInvisible.getHiddenProp();return!!e&&document[e]},getHiddenProp:function(){var e=["webkit","moz","ms","o"];if("hidden"in document)return"hidden";for(var t=0;t<e.length;t++)if(e[t]+"Hidden"in document)return e[t]+"Hidden";return null}},setToClearWatchedEvent:function(){clearTimeout(s),s=setTimeout((function(){c=""}),3e3)}},i.flexAnimate=function(t,a,n,s,o){if(i.vars.animationLoop||t===i.currentSlide||(i.direction=t>i.currentSlide?"next":"prev"),f&&1===i.pagingCount&&(i.direction=i.currentItem<t?"next":"prev"),!i.animating&&(i.canAdvance(t,o)||n)&&i.is(":visible")){if(f&&s){var d=e(i.vars.asNavFor).data("flexslider");if(i.atEnd=0===t||t===i.count-1,d.flexAnimate(t,!0,!1,!0,o),i.direction=i.currentItem<t?"next":"prev",d.direction=i.direction,Math.ceil((t+1)/i.visible)-1===i.currentSlide||0===t)return i.currentItem=t,i.slides.removeClass(r+"active-slide").eq(t).addClass(r+"active-slide"),i.slides.attr("aria-hidden","true").eq(t).removeAttr("aria-hidden"),!1;i.currentItem=t,i.slides.removeClass(r+"active-slide").eq(t).addClass(r+"active-slide"),i.slides.attr("aria-hidden","true").eq(t).removeAttr("aria-hidden"),t=Math.floor(t/i.visible)}if(i.animating=!0,i.animatingTo=t,a&&i.pause(),i.vars.before(i),i.syncExists&&!o&&h.sync("animate"),i.vars.controlNav&&h.controlNav.active(),p||(i.slides.removeClass(r+"active-slide").eq(t).addClass(r+"active-slide"),i.slides.attr("aria-hidden","true").eq(t).removeAttr("aria-hidden")),i.atEnd=0===t||t===i.last,i.vars.directionNav&&h.directionNav.update(),t===i.last&&(i.vars.end(i),i.vars.animationLoop||i.pause()),m)l?(i.slides.eq(i.currentSlide).css({opacity:0,zIndex:1}),i.slides.eq(t).css({opacity:1,zIndex:2}),i.wrapup(x)):(i.slides.eq(i.currentSlide).css({zIndex:1}).animate({opacity:0},i.vars.animationSpeed,i.vars.easing),i.slides.eq(t).css({zIndex:2}).animate({opacity:1},i.vars.animationSpeed,i.vars.easing,i.wrapup));else{var c,g,S,x=u?i.slides.filter(":first").height():i.computedW;p?(c=i.vars.itemMargin,g=(S=(i.itemW+c)*i.move*i.animatingTo)>i.limit&&1!==i.visible?i.limit:S):g=0===i.currentSlide&&t===i.count-1&&i.vars.animationLoop&&"next"!==i.direction?v?(i.count+i.cloneOffset)*x:0:i.currentSlide===i.last&&0===t&&i.vars.animationLoop&&"prev"!==i.direction?v?0:(i.count+1)*x:v?(i.count-1-t+i.cloneOffset)*x:(t+i.cloneOffset)*x,i.setProps(g,"",i.vars.animationSpeed),i.transitions?(i.vars.animationLoop&&i.atEnd||(i.animating=!1,i.currentSlide=i.animatingTo),i.container.unbind("webkitTransitionEnd transitionend"),i.container.bind("webkitTransitionEnd transitionend",(function(){clearTimeout(i.ensureAnimationEnd),i.wrapup(x)})),clearTimeout(i.ensureAnimationEnd),i.ensureAnimationEnd=setTimeout((function(){i.wrapup(x)}),i.vars.animationSpeed+100)):i.container.animate(i.args,i.vars.animationSpeed,i.vars.easing,(function(){i.wrapup(x)}))}i.vars.smoothHeight&&h.smoothHeight(i.vars.animationSpeed)}},i.wrapup=function(e){m||p||(0===i.currentSlide&&i.animatingTo===i.last&&i.vars.animationLoop?i.setProps(e,"jumpEnd"):i.currentSlide===i.last&&0===i.animatingTo&&i.vars.animationLoop&&i.setProps(e,"jumpStart")),i.animating=!1,i.currentSlide=i.animatingTo,i.vars.after(i)},i.animateSlides=function(){!i.animating&&t&&i.flexAnimate(i.getTarget("next"))},i.pause=function(){clearInterval(i.animatedSlides),i.animatedSlides=null,i.playing=!1,i.vars.pausePlay&&h.pausePlay.update("play"),i.syncExists&&h.sync("pause")},i.play=function(){i.playing&&clearInterval(i.animatedSlides),i.animatedSlides=i.animatedSlides||setInterval(i.animateSlides,i.vars.slideshowSpeed),i.started=i.playing=!0,i.vars.pausePlay&&h.pausePlay.update("pause"),i.syncExists&&h.sync("play")},i.stop=function(){i.pause(),i.stopped=!0},i.canAdvance=function(e,t){var a=f?i.pagingCount-1:i.last;return!!t||(!(!f||i.currentItem!==i.count-1||0!==e||"prev"!==i.direction)||(!f||0!==i.currentItem||e!==i.pagingCount-1||"next"===i.direction)&&(!(e===i.currentSlide&&!f)&&(!!i.vars.animationLoop||(!i.atEnd||0!==i.currentSlide||e!==a||"next"===i.direction)&&(!i.atEnd||i.currentSlide!==a||0!==e||"next"!==i.direction))))},i.getTarget=function(e){return i.direction=e,"next"===e?i.currentSlide===i.last?0:i.currentSlide+1:0===i.currentSlide?i.last:i.currentSlide-1},i.setProps=function(e,t,a){var n,s=(n=e||(i.itemW+i.vars.itemMargin)*i.move*i.animatingTo,function(){if(p)return"setTouch"===t?e:v&&i.animatingTo===i.last?0:v?i.limit-(i.itemW+i.vars.itemMargin)*i.move*i.animatingTo:i.animatingTo===i.last?i.limit:n;switch(t){case"setTotal":return v?(i.count-1-i.currentSlide+i.cloneOffset)*e:(i.currentSlide+i.cloneOffset)*e;case"setTouch":default:return e;case"jumpEnd":return v?e:i.count*e;case"jumpStart":return v?i.count*e:e}}()*(i.vars.rtl?1:-1)+"px");i.transitions&&(s=i.isFirefox?u?"translate3d(0,"+s+",0)":"translate3d("+parseInt(s)+"px,0,0)":u?"translate3d(0,"+s+",0)":"translate3d("+(i.vars.rtl?-1:1)*parseInt(s)+"px,0,0)",a=void 0!==a?a/1e3+"s":"0s",i.container.css("-"+i.pfx+"-transition-duration",a),i.container.css("transition-duration",a)),i.args[i.prop]=s,(i.transitions||void 0===a)&&i.container.css(i.args),i.container.css("transform",s)},i.setup=function(t){var a,n;m?(i.vars.rtl?i.slides.css({width:"100%",float:"right",marginLeft:"-100%",position:"relative"}):i.slides.css({width:"100%",float:"left",marginRight:"-100%",position:"relative"}),"init"===t&&(l?i.slides.css({opacity:0,display:"block",webkitTransition:"opacity "+i.vars.animationSpeed/1e3+"s ease",zIndex:1}).eq(i.currentSlide).css({opacity:1,zIndex:2}):0==i.vars.fadeFirstSlide?i.slides.css({opacity:0,display:"block",zIndex:1}).eq(i.currentSlide).css({zIndex:2}).css({opacity:1}):i.slides.css({opacity:0,display:"block",zIndex:1}).eq(i.currentSlide).css({zIndex:2}).animate({opacity:1},i.vars.animationSpeed,i.vars.easing)),i.vars.smoothHeight&&h.smoothHeight()):("init"===t&&(i.viewport=e('<div class="'+r+'viewport"></div>').css({overflow:"hidden",position:"relative"}).appendTo(i).append(i.container),i.cloneCount=0,i.cloneOffset=0,v&&(n=e.makeArray(i.slides).reverse(),i.slides=e(n),i.container.empty().append(i.slides))),i.vars.animationLoop&&!p&&(i.doMath(),i.slides.css({width:i.computedW,marginRight:i.computedM,float:"left",display:"block"}),i.cloneCount=2,i.cloneOffset=1,"init"!==t&&i.container.find(".clone").remove(),i.container.append(h.uniqueID(i.slides.first().clone().addClass("clone")).attr("aria-hidden","true")).prepend(h.uniqueID(i.slides.last().clone().addClass("clone")).attr("aria-hidden","true"))),i.newSlides=e(i.vars.selector,i),a=v?i.count-1-i.currentSlide+i.cloneOffset:i.currentSlide+i.cloneOffset,u&&!p?(i.container.height(200*(i.count+i.cloneCount)+"%").css("position","absolute").width("100%"),setTimeout((function(){i.newSlides.css({display:"block"}),i.doMath(),i.viewport.height(i.h),i.setProps(a*i.h,"init")}),"init"===t?100:0)):(i.container.width(200*(i.count+i.cloneCount)+"%"),i.setProps(a*i.computedW,"init"),setTimeout((function(){i.doMath(),i.vars.rtl&&i.isFirefox?i.newSlides.css({width:i.computedW,marginRight:i.computedM,float:"right",display:"block"}):i.newSlides.css({width:i.computedW,marginRight:i.computedM,float:"left",display:"block"}),i.vars.smoothHeight&&h.smoothHeight()}),"init"===t?100:0)));p||(i.slides.removeClass(r+"active-slide").eq(i.currentSlide).addClass(r+"active-slide"),i.slides.attr("aria-hidden","true").eq(i.currentSlide).removeAttr("aria-hidden")),i.vars.init(i),i.doMath()},i.doMath=function(){var e=i.slides.first(),t=i.vars.itemMargin,a=i.vars.minItems,n=i.vars.maxItems;i.w=void 0===i.viewport?i.width():i.viewport.width(),i.isFirefox&&(i.w=i.width()),i.h=e.height(),i.boxPadding=e.outerWidth()-e.width(),p?(i.itemT=i.vars.itemWidth+t,i.itemM=t,i.minW=a?a*i.itemT:i.w,i.maxW=n?n*i.itemT-t:i.w,i.itemW=i.minW>i.w?(i.w-t*(a-1))/a:i.maxW<i.w?(i.w-t*(n-1))/n:i.vars.itemWidth>i.w?i.w:i.vars.itemWidth,i.itemWPlusMargin=i.itemW+i.itemM,i.visible=Math.floor(i.w/i.itemWPlusMargin),i.visible=i.visible>0?i.visible:1,i.move=i.vars.move>0&&i.vars.move<i.visible?i.vars.move:i.visible,i.pagingCount=Math.ceil((i.count-i.visible)/i.move+1),i.last=i.pagingCount-1,i.limit=1===i.pagingCount?0:i.vars.itemWidth>i.w?i.itemW*(i.count-1)+t*(i.count-1):(i.itemW+t)*i.count-i.w-t):(i.itemW=i.w,i.itemM=t,i.pagingCount=i.count,i.last=i.count-1),i.computedW=i.itemW-i.boxPadding,i.computedM=i.itemM},i.update=function(e,t){i.doMath(),p||(e<i.currentSlide?i.currentSlide+=1:e<=i.currentSlide&&0!==e&&(i.currentSlide-=1),i.animatingTo=i.currentSlide),i.vars.controlNav&&!i.manualControls&&("add"===t&&!p||i.pagingCount>i.controlNav.length?h.controlNav.update("add"):("remove"===t&&!p||i.pagingCount<i.controlNav.length)&&(p&&i.currentSlide>i.last&&(i.currentSlide-=1,i.animatingTo-=1),h.controlNav.update("remove",i.last))),i.vars.directionNav&&h.directionNav.update()},i.addSlide=function(t,a){var n=e(t);i.count+=1,i.last=i.count-1,u&&v?void 0!==a?i.slides.eq(i.count-a).after(n):i.container.prepend(n):void 0!==a?i.slides.eq(a).before(n):i.container.append(n),i.update(a,"add"),i.slides=e(i.vars.selector+":not(.clone)",i),i.setup(),i.vars.added(i)},i.removeSlide=function(t){var a=isNaN(t)?i.slides.index(e(t)):t;i.count-=1,i.last=i.count-1,isNaN(t)?e(t,i.slides).remove():u&&v?i.slides.eq(i.last).remove():i.slides.eq(t).remove(),i.doMath(),i.update(a,"remove"),i.slides=e(i.vars.selector+":not(.clone)",i),i.setup(),i.vars.removed(i)},h.init()},e(window).blur((function(e){t=!1})).focus((function(e){t=!0})),e.flexslider.defaults={namespace:"flex-",selector:".slides > li",animation:"fade",easing:"swing",direction:"horizontal",reverse:!1,animationLoop:!0,smoothHeight:!1,startAt:0,slideshow:!0,slideshowSpeed:7e3,animationSpeed:600,initDelay:0,randomize:!1,fadeFirstSlide:!0,thumbCaptions:!1,pauseOnAction:!0,pauseOnHover:!1,pauseInvisible:!0,useCSS:!0,touch:!0,video:!1,controlNav:!0,directionNav:!0,prevText:"Previous",nextText:"Next",keyboard:!0,multipleKeyboard:!1,mousewheel:!1,pausePlay:!1,pauseText:"Pause",playText:"Play",controlsContainer:"",manualControls:"",customDirectionNav:"",sync:"",asNavFor:"",itemWidth:0,itemMargin:0,minItems:1,maxItems:0,move:0,allowOneSlide:!0,isFirefox:!1,start:function(){},before:function(){},after:function(){},end:function(){},added:function(){},removed:function(){},init:function(){},rtl:!1},e.fn.flexslider=function(t){if(void 0===t&&(t={}),"object"==typeof t)return this.each((function(){var a=e(this),n=t.selector?t.selector:".slides > li",i=a.find(n);1===i.length&&!1===t.allowOneSlide||0===i.length?(i.fadeIn(400),t.start&&t.start(a)):void 0===a.data("flexslider")&&new e.flexslider(this,t)}));var a=e(this).data("flexslider");switch(t){case"play":a.play();break;case"pause":a.pause();break;case"stop":a.stop();break;case"next":a.flexAnimate(a.getTarget("next"),!0);break;case"prev":case"previous":a.flexAnimate(a.getTarget("prev"),!0);break;default:"number"==typeof t&&a.flexAnimate(t,!0)}}}(jQuery);