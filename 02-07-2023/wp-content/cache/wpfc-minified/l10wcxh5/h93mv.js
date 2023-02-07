;(function (factory){
var registeredInModuleLoader=false;
if(typeof define==='function'&&define.amd){
define(factory);
registeredInModuleLoader=true;
}
if(typeof exports==='object'){
module.exports=factory();
registeredInModuleLoader=true;
}
if(!registeredInModuleLoader){
var OldCookies=window.Cookies;
var api=window.Cookies=factory();
api.noConflict=function (){
window.Cookies=OldCookies;
return api;
};}}(function (){
function extend (){
var i=0;
var result={};
for (; i < arguments.length; i++){
var attributes=arguments[ i ];
for (var key in attributes){
result[key]=attributes[key];
}}
return result;
}
function init (converter){
function api (key, value, attributes){
var result;
if(typeof document==='undefined'){
return;
}
if(arguments.length > 1){
attributes=extend({
path: '/'
}, api.defaults, attributes);
if(typeof attributes.expires==='number'){
var expires=new Date();
expires.setMilliseconds(expires.getMilliseconds() + attributes.expires * 864e+5);
attributes.expires=expires;
}
try {
result=JSON.stringify(value);
if(/^[\{\[]/.test(result)){
value=result;
}} catch (e){}
if(!converter.write){
value=encodeURIComponent(String(value))
.replace(/%(23|24|26|2B|3A|3C|3E|3D|2F|3F|40|5B|5D|5E|60|7B|7D|7C)/g, decodeURIComponent);
}else{
value=converter.write(value, key);
}
key=encodeURIComponent(String(key));
key=key.replace(/%(23|24|26|2B|5E|60|7C)/g, decodeURIComponent);
key=key.replace(/[\(\)]/g, escape);
return (document.cookie=[
key, '=', value,
attributes.expires ? '; expires=' + attributes.expires.toUTCString():'',
attributes.path ? '; path=' + attributes.path:'',
attributes.domain ? '; domain=' + attributes.domain:'',
attributes.SameSite ? '; SameSite=' + attributes.SameSite:'',
attributes.secure ? '; secure':''
].join(''));
}
if(!key){
result={};}
var cookies=document.cookie ? document.cookie.split('; '):[];
var rdecode=/(%[0-9A-Z]{2})+/g;
var i=0;
for (; i < cookies.length; i++){
var parts=cookies[i].split('=');
var cookie=parts.slice(1).join('=');
if(cookie.charAt(0)==='"'){
cookie=cookie.slice(1, -1);
}
try {
var name=parts[0].replace(rdecode, decodeURIComponent);
cookie=converter.read ?
converter.read(cookie, name):converter(cookie, name) ||
cookie.replace(rdecode, decodeURIComponent);
if(this.json){
try {
cookie=JSON.parse(cookie);
} catch (e){}}
if(key===name){
result=cookie;
break;
}
if(!key){
result[name]=cookie;
}} catch (e){}}
return result;
}
api.set=api;
api.get=function (key){
return api.call(api, key);
};
api.getJSON=function (){
return api.apply({
json: true
}, [].slice.call(arguments));
};
api.defaults={};
api.remove=function (key, attributes){
api(key, '', extend(attributes, {
expires: -1
}));
};
api.withConverter=init;
return api;
}
return init(function (){});
}));
(function(){
var supportsPassive=false;
try {
var opts=Object.defineProperty({}, 'passive', {
get:function(){
supportsPassive=true;
}});
window.addEventListener('testPassive', null, opts);
window.removeEventListener('testPassive', null, opts);
} catch(e){}
function init(){
var input_begin='';
var keydowns={};
var lastKeyup=null;
var lastKeydown=null;
var keypresses=[];
var modifierKeys=[];
var correctionKeys=[];
var lastMouseup=null;
var lastMousedown=null;
var mouseclicks=[];
var mousemoveTimer=null;
var lastMousemoveX=null;
var lastMousemoveY=null;
var mousemoveStart=null;
var mousemoves=[];
var touchmoveCountTimer=null;
var touchmoveCount=0;
var lastTouchEnd=null;
var lastTouchStart=null;
var touchEvents=[];
var scrollCountTimer=null;
var scrollCount=0;
var correctionKeyCodes=[ 'Backspace', 'Delete', 'ArrowUp', 'ArrowDown', 'ArrowLeft', 'ArrowRight', 'Home', 'End', 'PageUp', 'PageDown' ];
var modifierKeyCodes=[ 'Shift', 'CapsLock' ];
var forms=document.querySelectorAll('form[method=post]');
for(var i=0; i < forms.length; i++){
var form=forms[i];
var formAction=form.getAttribute('action');
if(formAction){
if(formAction.indexOf('http://')==0||formAction.indexOf('https://')==0){
if(formAction.indexOf('http://' + window.location.hostname + '/')!=0&&formAction.indexOf('https://' + window.location.hostname + '/')!=0){
continue;
}}
}
form.addEventListener('submit', function (){
var ak_bkp=prepare_timestamp_array_for_request(keypresses);
var ak_bmc=prepare_timestamp_array_for_request(mouseclicks);
var ak_bte=prepare_timestamp_array_for_request(touchEvents);
var ak_bmm=prepare_timestamp_array_for_request(mousemoves);
var input_fields={
'ak_bib': input_begin,
'ak_bfs': Date.now(),
'ak_bkpc': keypresses.length,
'ak_bkp': ak_bkp,
'ak_bmc': ak_bmc,
'ak_bmcc': mouseclicks.length,
'ak_bmk': modifierKeys.join(';'),
'ak_bck': correctionKeys.join(';'),
'ak_bmmc': mousemoves.length,
'ak_btmc': touchmoveCount,
'ak_bsc': scrollCount,
'ak_bte': ak_bte,
'ak_btec':touchEvents.length,
'ak_bmm':ak_bmm
};
for(var field_name in input_fields){
var field=document.createElement('input');
field.setAttribute('type', 'hidden');
field.setAttribute('name', field_name);
field.setAttribute('value', input_fields[ field_name ]);
this.appendChild(field);
}}, supportsPassive ? { passive: true }:false);
form.addEventListener('keydown', function(e){
if(e.key in keydowns){
return;
}
var keydownTime=(new Date()).getTime();
keydowns[ e.key ]=[ keydownTime ];
if(! input_begin){
input_begin=keydownTime;
}
var lastKeyEvent=Math.max(lastKeydown, lastKeyup);
if(lastKeyEvent){
keydowns[ e.key ].push(keydownTime - lastKeyEvent);
}
lastKeydown=keydownTime;
}, supportsPassive ? { passive: true }:false);
form.addEventListener('keyup', function(e){
if(!(e.key in keydowns)){
return;
}
var keyupTime=(new Date()).getTime();
if('TEXTAREA'===e.target.nodeName||'INPUT'===e.target.nodeName){
if(-1!==modifierKeyCodes.indexOf(e.key)){
modifierKeys.push(keypresses.length - 1);
}else if(-1!==correctionKeyCodes.indexOf(e.key)){
correctionKeys.push(keypresses.length - 1);
}else{
var keydownTime=keydowns[ e.key ][0];
var keypress=[];
keypress.push(keyupTime - keydownTime);
if(keydowns[ e.key ].length > 1){
keypress.push(keydowns[ e.key ][1]);
}
keypresses.push(keypress);
}}
delete keydowns[ e.key ];
lastKeyup=keyupTime;
}, supportsPassive ? { passive: true }:false);
form.addEventListener("focusin", function(e){
lastKeydown=null;
lastKeyup=null;
keydowns={};}, supportsPassive ? { passive: true }:false);
form.addEventListener("focusout", function(e){
lastKeydown=null;
lastKeyup=null;
keydowns={};}, supportsPassive ? { passive: true }:false);
}
document.addEventListener('mousedown', function(e){
lastMousedown=(new Date()).getTime();
}, supportsPassive ? { passive: true }:false);
document.addEventListener('mouseup', function(e){
if(! lastMousedown){
return;
}
var now=(new Date()).getTime();
var mouseclick=[];
mouseclick.push(now - lastMousedown);
if(lastMouseup){
mouseclick.push(lastMousedown - lastMouseup);
}
mouseclicks.push(mouseclick);
lastMouseup=now;
lastKeydown=null;
lastKeyup=null;
keydowns={};}, supportsPassive ? { passive: true }:false);
document.addEventListener('mousemove', function(e){
if(mousemoveTimer){
clearTimeout(mousemoveTimer);
mousemoveTimer=null;
}else{
mousemoveStart=(new Date()).getTime();
lastMousemoveX=e.offsetX;
lastMousemoveY=e.offsetY;
}
mousemoveTimer=setTimeout(function(theEvent, originalMousemoveStart){
var now=(new Date()).getTime() - 500;
var mousemove=[];
mousemove.push(now - originalMousemoveStart);
mousemove.push(Math.round(Math.sqrt(Math.pow(theEvent.offsetX - lastMousemoveX, 2) +
Math.pow(theEvent.offsetY - lastMousemoveY, 2)
)
)
);
if(mousemove[1] > 0){
mousemoves.push(mousemove);
}
mousemoveStart=null;
mousemoveTimer=null;
}, 500, e, mousemoveStart);
}, supportsPassive ? { passive: true }:false);
document.addEventListener('touchmove', function(e){
if(touchmoveCountTimer){
clearTimeout(touchmoveCountTimer);
}
touchmoveCountTimer=setTimeout(function (){
touchmoveCount++;
}, 500);
}, supportsPassive ? { passive: true }:false);
document.addEventListener('touchstart', function(e){
lastTouchStart=(new Date()).getTime();
}, supportsPassive ? { passive: true }:false);
document.addEventListener('touchend', function(e){
if(! lastTouchStart){
return;
}
var now=(new Date()).getTime();
var touchEvent=[];
touchEvent.push(now - lastTouchStart);
if(lastTouchEnd){
touchEvent.push(lastTouchStart - lastTouchEnd);
}
touchEvents.push(touchEvent);
lastTouchEnd=now;
lastKeydown=null;
lastKeyup=null;
keydowns={};}, supportsPassive ? { passive: true }:false);
document.addEventListener('scroll', function(e){
if(scrollCountTimer){
clearTimeout(scrollCountTimer);
}
scrollCountTimer=setTimeout(function (){
scrollCount++;
}, 500);
}, supportsPassive ? { passive: true }:false);
}
function prepare_timestamp_array_for_request(a, limit){
if(! limit){
limit=100;
}
var rv='';
if(a.length > 0){
var random_starting_point=Math.max(0, Math.floor(Math.random() * a.length - limit));
for(var i=0; i < limit&&i < a.length; i++){
rv +=a[ random_starting_point + i ][0];
if(a[ random_starting_point + i ].length >=2){
rv +="," + a[ random_starting_point + i ][1];
}
rv +=";";
}}
return rv;
}
if(document.readyState!=='loading'){
init();
}else{
document.addEventListener('DOMContentLoaded', init);
}})();