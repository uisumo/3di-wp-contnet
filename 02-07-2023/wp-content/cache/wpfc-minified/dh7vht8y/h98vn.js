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