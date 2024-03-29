/*!/wp-content/plugins/uncanny-toolkit-pro/src/assets/legacy/frontend/js/idle-timer.js*/
/*! Idle Timer - v1.1.0 - 2016-03-21
 * https://github.com/thorst/jquery-idletimer
 * Copyright (c) 2016 Paul Irish; Licensed MIT */
(function($){$.idleTimer=function(firstParam,elem){var opts;if(typeof firstParam==="object"){opts=firstParam;firstParam=null}else if(typeof firstParam==="number"){opts={timeout:firstParam};firstParam=null}
elem=elem||document;opts=$.extend({idle:!1,timeout:30000,events:"mousemove keydown wheel DOMMouseScroll mousewheel mousedown touchstart touchmove MSPointerDown MSPointerMove"},opts);var jqElem=$(elem),obj=jqElem.data("idleTimerObj")||{},toggleIdleState=function(e){var obj=$.data(elem,"idleTimerObj")||{};obj.idle=!obj.idle;obj.olddate=+new Date();var event=$.Event((obj.idle?"idle":"active")+".idleTimer");$(elem).trigger(event,[elem,$.extend({},obj),e])},handleEvent=function(e){var obj=$.data(elem,"idleTimerObj")||{};if(typeof window.ultpTimerDebug!=='undefined'&&window.ultpTimerDebug){console.log('%cDetected activity: '+e.type,'background: #f09925; color: #000; padding: 2px 5px;')}
if(e.type==="storage"&&e.originalEvent.key!==obj.timerSyncId){return}
if(obj.remaining!=null){return}
if(e.type==="mousemove"){if(e.pageX===obj.pageX&&e.pageY===obj.pageY){return}
if(typeof e.pageX==="undefined"&&typeof e.pageY==="undefined"){return}
var elapsed=(+new Date())-obj.olddate;if(elapsed<200){return}}
clearTimeout(obj.tId);if(obj.idle){toggleIdleState(e)}
obj.lastActive=+new Date();obj.pageX=e.pageX;obj.pageY=e.pageY;if(e.type!=="storage"&&obj.timerSyncId){if(typeof(localStorage)!=="undefined"){localStorage.setItem(obj.timerSyncId,obj.lastActive)}}
obj.tId=setTimeout(toggleIdleState,obj.timeout)},reset=function(){var obj=$.data(elem,"idleTimerObj")||{};obj.idle=obj.idleBackup;obj.olddate=+new Date();obj.lastActive=obj.olddate;obj.remaining=null;clearTimeout(obj.tId);if(!obj.idle){obj.tId=setTimeout(toggleIdleState,obj.timeout)}},pause=function(){var obj=$.data(elem,"idleTimerObj")||{};if(obj.remaining!=null){return}
obj.remaining=obj.timeout-((+new Date())-obj.olddate);clearTimeout(obj.tId)},resume=function(){var obj=$.data(elem,"idleTimerObj")||{};if(obj.remaining==null){return}
if(!obj.idle){obj.tId=setTimeout(toggleIdleState,obj.remaining)}
obj.remaining=null},destroy=function(){var obj=$.data(elem,"idleTimerObj")||{};clearTimeout(obj.tId);jqElem.removeData("idleTimerObj");jqElem.off("._idleTimer")},remainingtime=function(){var obj=$.data(elem,"idleTimerObj")||{};if(obj.idle){return 0}
if(obj.remaining!=null){return obj.remaining}
var remaining=obj.timeout-((+new Date())-obj.lastActive);if(remaining<0){remaining=0}
return remaining};if(firstParam===null&&typeof obj.idle!=="undefined"){reset();return jqElem}else if(firstParam===null){}else if(firstParam!==null&&typeof obj.idle==="undefined"){return!1}else if(firstParam==="destroy"){destroy();return jqElem}else if(firstParam==="pause"){pause();return jqElem}else if(firstParam==="resume"){resume();return jqElem}else if(firstParam==="reset"){reset();return jqElem}else if(firstParam==="getRemainingTime"){return remainingtime()}else if(firstParam==="getElapsedTime"){return(+new Date())-obj.olddate}else if(firstParam==="getLastActiveTime"){return obj.lastActive}else if(firstParam==="isIdle"){return obj.idle}
jqElem.on($.trim((opts.events+" ").split(" ").join("._idleTimer ")),function(e){handleEvent(e)});if(opts.timerSyncId){$(window).bind("storage",handleEvent)}
obj=$.extend({},{olddate:+new Date(),lastActive:+new Date(),idle:opts.idle,idleBackup:opts.idle,timeout:opts.timeout,remaining:null,timerSyncId:opts.timerSyncId,tId:null,pageX:null,pageY:null});if(!obj.idle){obj.tId=setTimeout(toggleIdleState,obj.timeout)}
$.data(elem,"idleTimerObj",obj);return jqElem};$.fn.idleTimer=function(firstParam){if(this[0]){return $.idleTimer(firstParam,this[0])}
return this}})(jQuery)
;