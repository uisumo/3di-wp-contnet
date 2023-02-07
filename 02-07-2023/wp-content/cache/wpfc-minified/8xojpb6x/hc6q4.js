var __gf_timeout_handle;function gf_apply_rules(e,t,i){jQuery(document).trigger("gform_pre_conditional_logic",[e,t,i]);for(var a=0;a<t.length;a++)gf_apply_field_rule(e,t[a],i,function(){a>=t.length-1&&(jQuery(document).trigger("gform_post_conditional_logic",[e,t,i]),window.gformCalculateTotalPrice&&window.gformCalculateTotalPrice(e))})}function gf_check_field_rule(e,t,i,a){var r,t=gf_get_field_logic(e,t);return t?"hide"!=(r=gf_get_field_action(e,t.section))?gf_get_field_action(e,t.field):r:"show"}function gf_get_field_logic(e,t){var i=rgars(window,"gf_form_conditional_logic/"+e);if(i){e=rgars(i,"logic/"+t);if(e)return e;var a=rgar(i,"dependents");if(a)for(var r in a)if(-1!==a[r].indexOf(t))return rgars(i,"logic/"+r)}return!1}function gf_apply_field_rule(e,t,i,a){gf_do_field_action(e,gf_check_field_rule(e,t,i,a),t,i,a);a=window.gf_form_conditional_logic[e].logic[t];a.nextButton&&gf_do_next_button_action(e,gf_get_field_action(e,a.nextButton),t,i)}function gf_get_field_action(e,t){if(!t)return"show";for(var i=0,a=0;a<t.rules.length;a++)gf_is_match(e,gform.applyFilters("gform_rule_pre_evaluation",jQuery.extend({},t.rules[a]),e,t))&&i++;return"all"==t.logicType&&i==t.rules.length||"any"==t.logicType&&0<i?t.actionType:"show"==t.actionType?"hide":"show"}function gf_is_match(e,t){var i=jQuery,a=t.fieldId,r=gformExtractFieldId(a),a=gformExtractInputIndex(a),a=i(!1!==a?"#input_{0}_{1}_{2}".format(e,r,a):'input[id="input_{0}_{1}"], input[id^="input_{0}_{1}_"], input[id^="choice_{0}_{1}_"], select#input_{0}_{1}, textarea#input_{0}_{1}'.format(e,r)),i=-1!==i.inArray(a.attr("type"),["checkbox","radio"])?gf_is_match_checkable(a,t,e,r):gf_is_match_default(a.eq(0),t,e,r);return gform.applyFilters("gform_is_value_match",i,e,t)}function gf_is_match_checkable(e,r,n,o){var _;return""===r.value?"is"===r.operator?gf_is_checkable_empty(e):!gf_is_checkable_empty(e):(_=!1,e.each(function(){var e=jQuery(this),t=gf_get_value(e.val()),i=-1!==jQuery.inArray(r.operator,["<",">"]),a=-1!==jQuery.inArray(r.operator,["contains","starts_with","ends_with"]);if(t==r.value||i||a)return e.is(":checked")?"gf_other_choice"==t&&(t=jQuery("#input_{0}_{1}_other".format(n,o)).val()):t="",gf_matches_operation(t,r.value,r.operator)?!(_=!0):void 0}),_)}function gf_is_checkable_empty(e){var t=!0;return e.each(function(){jQuery(this).is(":checked")&&(t=!1)}),t}function gf_is_match_default(e,t,i,a){for(var e=e.val(),r=e instanceof Array?e:[e],n=0,o=Math.max(r.length,1),_=0;_<o;_++){var l=!r[_]||0<=r[_].indexOf("|"),d=gf_get_value(r[_]),s=gf_get_field_number_format(t.fieldId,i,"value"),l=(s&&!l&&(d=gf_format_number(d,s)),t.value);gf_matches_operation(d,l,t.operator)&&n++}return"isnot"==t.operator?n==o:0<n}function gf_format_number(e,t){return decimalSeparator=".","currency"==t?decimalSeparator=gformGetDecimalSeparator("currency"):"decimal_comma"==t?decimalSeparator=",":"decimal_dot"==t&&(decimalSeparator="."),e=gformCleanNumber(e,"","",decimalSeparator),number=(e=e||0).toString()}function gf_try_convert_float(e){var t="decimal_dot";return gformIsNumeric(e,t)?gformCleanNumber(e,"","","."):e}function gf_matches_operation(e,t,i){switch(e=e?e.toLowerCase():"",t=t?t.toLowerCase():"",i){case"is":return e==t;case"isnot":return e!=t;case">":return e=gf_try_convert_float(e),t=gf_try_convert_float(t),!(!gformIsNumber(e)||!gformIsNumber(t))&&t<e;case"<":return e=gf_try_convert_float(e),t=gf_try_convert_float(t),!(!gformIsNumber(e)||!gformIsNumber(t))&&e<t;case"contains":return 0<=e.indexOf(t);case"starts_with":return 0==e.indexOf(t);case"ends_with":var a=e.length-t.length;return a<0?!1:t==e.substring(a)}return!1}function gf_get_value(e){return e?(e=e.split("|"))[0]:""}function gf_do_field_action(e,t,i,a,r){for(var n=window.gf_form_conditional_logic[e],o=n.dependents[i],_=0;_<o.length;_++){var l=0==i?"#gform_submit_button_"+e:"#field_"+e+"_"+o[_],d=n.defaults[o[_]],s=(do_callback=_+1==o.length?r:null,gform.applyFilters("gform_abort_conditional_logic_do_action",!1,t,l,n.animation,d,a,e,do_callback));s||gf_do_action(t,l,n.animation,d,a,do_callback,e),gform.doAction("gform_post_conditional_logic_field_action",e,t,l,d,a)}}function gf_do_next_button_action(e,t,i,a){var r=window.gf_form_conditional_logic[e],i="#gform_next_button_"+e+"_"+i;gform.applyFilters("gform_abort_conditional_logic_do_action",!1,t,i,r.animation,null,a,e,null)||gf_do_action(t,i,r.animation,null,a,null,e)}function gf_do_action(e,t,i,a,r,n,o){var _=jQuery(t);_.data("gf-disabled-assessed")||(_.find(":input:disabled").addClass("gf-default-disabled"),_.data("gf-disabled-assessed",!0)),"show"==e?(_.find("select").each(function(){var e=jQuery(this);e.attr("tabindex",e.data("tabindex"))}),i&&!r?0<_.length?(_.find(":input:hidden:not(.gf-default-disabled)").removeAttr("disabled"),(_.is('input[type="submit"]')||_.hasClass("gform_next_button"))&&(_.removeAttr("disabled").css("display",""),"1"==gf_legacy.is_legacy&&_.removeClass("screen-reader-text")),_.slideDown(n)):n&&n():(""!=(e=_.data("gf_display"))&&"none"!=e||(e="1"===gf_legacy.is_legacy?"list-item":"block"),_.find(":input:hidden:not(.gf-default-disabled)").removeAttr("disabled"),_.is('input[type="submit"]')||_.hasClass("gform_next_button")?(_.removeAttr("disabled").css("display",""),"1"==gf_legacy.is_legacy&&_.removeClass("screen-reader-text")):_.css("display",e),n&&n())):(0<(e=_.children().first()).length&&gform.applyFilters("gform_reset_pre_conditional_logic_field_action",!0,o,t,a,r)&&!gformIsHidden(e)&&gf_reset_to_default(t,a),_.find("select").each(function(){var e=jQuery(this);e.data("tabindex",e.attr("tabindex")).removeAttr("tabindex")}),_.data("gf_display")||_.data("gf_display",_.css("display")),i&&!r?_.is('input[type="submit"]')||_.hasClass("gform_next_button")?(_.attr("disabled","disabled").hide(),"1"===gf_legacy.is_legacy&&_.addClass("screen-reader-text")):0<_.length&&_.is(":visible")?_.slideUp(n):n&&n():(_.is('input[type="submit"]')||_.hasClass("gform_next_button")?(_.attr("disabled","disabled").hide(),"1"===gf_legacy.is_legacy&&_.addClass("screen-reader-text")):_.css("display","none"),_.find(":input:hidden:not(.gf-default-disabled)").attr("disabled","disabled"),n&&n()))}function gf_reset_to_default(e,a){var t=jQuery(e).find(".gfield_date_month input, .gfield_date_day input, .gfield_date_year input, .gfield_date_dropdown_month select, .gfield_date_dropdown_day select, .gfield_date_dropdown_year select");if(0<t.length)t.each(function(){var e,t=jQuery(this);val=a?(e="d",t.parents().hasClass("gfield_date_month")||t.parents().hasClass("gfield_date_dropdown_month")?e="m":(t.parents().hasClass("gfield_date_year")||t.parents().hasClass("gfield_date_dropdown_year"))&&(e="y"),a[e]):"","SELECT"==t.prop("tagName")&&""!=val&&(val=parseInt(val,10)),t.val()!=val?t.val(val).trigger("change"):t.val(val)});else{var i=jQuery(e).find('select, input[type="text"]:not([id*="_shim"]), input[type="number"], input[type="hidden"], input[type="email"], input[type="tel"], input[type="url"], textarea'),r=0;if(a&&0<i.parents(".ginput_list").length&&i.length<a.length)for(;i.length<a.length;)gformAddListItem(i.eq(0),0),i=jQuery(e).find('select, input[type="text"]:not([id*="_shim"]), input[type="number"], textarea');i.each(function(){var e,t="",i=jQuery(this);i.is('[type="hidden"]')&&!gf_is_hidden_pricing_input(i)||("gf_other_choice"==i.prev("input").attr("value")?t=i.attr("value"):jQuery.isArray(a)&&!i.is("select[multiple]")?t=a[r]:jQuery.isPlainObject(a)?(!(t=a[i.attr("name")])&&i.attr("id")&&(e=i.attr("id").split("_").slice(2).join("."),t=a[e]),!t&&i.attr("name")&&(e=i.attr("name").split("_")[1],t=a[e])):a&&(t=a),i.is("select:not([multiple])")&&!t&&(t=i.find("option").not(":disabled").eq(0).val()),i.val()!=t?(i.val(t).trigger("change"),i.is("select")&&i.next().hasClass("chosen-container")&&i.trigger("chosen:updated"),gf_is_hidden_pricing_input(i)&&(e=gf_get_ids_by_html_id(i.parents(".gfield").attr("id")),jQuery("#input_"+e[0]+"_"+e[1]).text(gformFormatMoney(i.val())),i.val(gformFormatMoney(i.val())))):i.val(t),r++)}),jQuery(e).find('input[type="radio"], input[type="checkbox"]:not(".copy_values_activated")').each(function(){var e=!!jQuery(this).is(":checked"),t=!!a&&-1<jQuery.inArray(jQuery(this).attr("id"),a);e!=t&&("checkbox"==jQuery(this).attr("type")?jQuery(this).trigger("click"):jQuery(this).prop("checked",t).change())})}}function gf_is_hidden_pricing_input(e){return!(!e.attr("id")||0!==e.attr("id").indexOf("ginput_base_price"))||"hidden"===e.attr("type")&&e.parents(".gfield_shipping").length}gform.addAction("gform_input_change",function(e,t,i){!window.gf_form_conditional_logic||(i=rgars(gf_form_conditional_logic,[t,"fields",gformExtractFieldId(i)].join("/")))&&gf_apply_rules(t,i)},10);
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
(function ($){
window.gwCopyObj=function (args){
var self=this;
for (prop in args){
if(args.hasOwnProperty(prop)){
self[prop]=args[prop];
}}
self.init=function (){
gform.addFilter('gpcc_copied_value', function(value, $targetElem, field){
if($('#input_{0}_{1}'.format(self.formId, field.source)).hasClass('ginput_total')){
var numberFormat=gf_get_field_number_format(field.source, self.formId);
if(! numberFormat){
numberFormat=gf_get_field_number_format(field.target, self.formId);
}
var decimalSeparator=gformGetDecimalSeparator(numberFormat);
value=gformCleanNumber(value, '', '', decimalSeparator);
}
return value;
});
var $formWrapper=$('#gform_wrapper_{0}'.format(self.formId));
$formWrapper.off('click.gpcopycat');
$formWrapper.on('click.gpcopycat',
'.gwcopy input[type="checkbox"]',
function (){
if($(this).is(':checked')){
self.copyValues(this);
}else{
self.clearValues(this);
}}
);
$formWrapper.off('change.gpcopycat');
$formWrapper.on('change.gpcopycat',
'.gwcopy input:not(:checkbox), .gwcopy textarea, .gwcopy select',
function (){
self.copyValues(this);
}
);
$formWrapper.find('.gwcopy').find('input, textarea, select, button').each(function (){
if(! $(this).is(':checkbox, :radio')&&! $(this).parents('.gfield_chainedselect').length){
self.copyValues(this, self.overwriteOnInit);
}else if($(this).is(':checked')){
self.copyValues(this, self.overwriteOnInit);
}
if($(this).is('button')){
if(! $(this)[0].id.includes('_select_all')){
return;
}
var selectText=$(this).attr('data-label-select');
var deselectText=$(this).attr('data-label-deselect');
$(this)[0].onclick=null;
$(this).on('click', function(){
var buttonText=$(this).text();
$(this).siblings().each(function(i, value){
if(buttonText==selectText){
if(! $(value).find('input').prop('checked')){
$(value).find('input').click();
}}else{
if($(value).find('input').prop('checked')){
$(value).find('input').click();
}}
});
if(buttonText==selectText){
$(this).text(deselectText);
}else{
$(this).text(selectText);
}});
}}
);
gform.addAction('gform_list_post_item_delete',
function ($container){
if($container.parents('.gwcopy').length > 0){
self.clearValues($container);
self.copyValues($container);
}}
);
var triggerIds=[];
gform.addAction('gform_input_change', function(){
triggerIds=[];
}, 15);
gform.addAction('gform_post_conditional_logic_field_action', function(formId, action, targetId, defaultValues, isInit){
if(action==='hide'){
return;
}
var fieldId=gf_get_input_id_by_html_id(targetId);
var fieldSettings=self.getFieldSettings(fieldId);
if(! fieldSettings){
return;
}
for(var i=0; i < fieldSettings.length; i++){
if($.inArray(fieldSettings[i].trigger, triggerIds)!==-1){
continue;
}
triggerIds.push(fieldSettings[i].trigger);
var $trigger=$('#field_{0}_{1}'.format(formId, fieldSettings[i].trigger)).find('input, textarea, select');
var shouldOverwrite = ! isInit;
if($trigger.is(':checkbox')){
if($trigger.filter(':checked').length){
self.copyValues($trigger[0], shouldOverwrite);
}else{
}}else{
self.copyValues($trigger[0], shouldOverwrite);
}}
});
$formWrapper.data('GPCopyCat', self);
};
self.getFieldSettings=function(fieldId){
if(typeof self.fields[ fieldId ]!=='undefined'){
return self.fields[ fieldId ];
}else if(self.getSourceFieldIdByTarget(fieldId, true)!==false){
return self.getSourceFieldIdByTarget(fieldId, true);
}else if(self.getSourceField(fieldId, true)!==false){
return self.getSourceField(fieldId, true);
}
return [];
};
self.copyValues=function (elem, isOverwrite, forceEmptyCopy){
var fieldId=gf_get_input_id_by_html_id($(elem).parents('.gfield').attr('id')),
fields=self.getFieldSettings(fieldId);
isOverwrite=typeof isOverwrite!=='undefined' ? isOverwrite:self.overwrite;
forceEmptyCopy=typeof forceEmptyCopy!=='undefined' ? forceEmptyCopy:isOverwrite;
for (var i=0, max=fields.length; i < max; i++){
var field=fields[i],
sourceFieldId=field['source'],
targetFieldId=field['target'],
sourceGroup=self.getFieldGroup(field, 'source'),
targetGroup=self.getFieldGroup(field, 'target'),
isListToList=self.isListField(sourceGroup)&&self.isListField(targetGroup),
sourceValues=self.getGroupValues(sourceGroup,
'source',
{
sort: ! isListToList&&self.isListField(targetGroup) ? self.getGroupValues(targetGroup, 'target', {
isListToList: isListToList,
sourceInputId: targetFieldId
}):false,
isListToList: isListToList,
sourceInputId: sourceFieldId,
targetInputId: targetFieldId
}
);
var customCopy=window.gform.applyFilters('gpcc_custom_copy', false, elem.id, sourceGroup, targetGroup, field.source);
if(customCopy){
continue;
}
if(sourceGroup.parents('.gfield_chainedselect').length){
sourceGroup.each(function (index, el){
if(elem.id===el.id){
var target=targetGroup.get(index);
target.value=elem.value;
$(target).trigger('change');
}});
continue;
}
if(self.isListField(targetGroup)){
var targetRowCount=targetGroup.parents('.ginput_list').find('.gfield_list_group').length,
sourceRowCount=self.isListField(sourceGroup) ? sourceGroup.parents('.ginput_list').find('.gfield_list_group').length:sourceGroup.length,
rowsRequired=Math.floor((sourceRowCount - targetRowCount)),
maxRows=self.getMaxRowCount(targetGroup);
if(rowsRequired < 0&&targetRowCount > 1){
targetGroup.each(function (){
var _sourceValues=getObjectValues(sourceValues);
if($.inArray($(this).val(), _sourceValues)===-1&&$(this).parents('.gfield_list').find('.gfield_list_group').length > 1){
gformDeleteListItem($(this), maxRows);
}}
);
}else if(rowsRequired > 0){
for (var j=0; j < rowsRequired; j++){
if(maxRows > 0&&targetRowCount + j + 1 > maxRows){
break;
}
gformAddListItem(targetGroup[targetGroup.length - 1], self.getMaxRowCount(targetGroup));
}}
targetGroup=self.getFieldGroup(field, 'target');
}
targetValues=[];
if(! isInputSpecific(targetFieldId)&&targetGroup.is(':checkbox')&&isOverwrite){
targetGroup.prop('checked', false);
}
targetGroup.each(function (i){
var $targetElem=$(this),
isCheckable=$targetElem.is(':checkbox, :radio'),
index=isListToList ? self.getListInputIndex($targetElem):i,
hasSourceValue=isCheckable||sourceValues[index]||($.isArray(sourceValues) &&sourceValues.join(' ')),
hasValue=false,
value=null;
targetValues[i]=$targetElem.val();
if(isCheckable){
hasValue=targetGroup.is(':checked');
}else{
hasValue=$targetElem.val();
}
if(! isOverwrite&&hasValue){
return true;
}
if(! hasSourceValue&&! forceEmptyCopy){
return true;
}
if(self.isListField(targetGroup)){
if(isInputSpecific(targetFieldId)){
value=sourceValues[i];
}else{
value=sourceValues[index];
}
value=gform.applyFilters('gppc_copied_value', value, $targetElem, field);
value=gform.applyFilters('gpcc_copied_value', value, $targetElem, field);
$targetElem.val(value);
}else if(isCheckable){
if($.inArray($targetElem.val(), gform.applyFilters('gpcc_copied_value', sourceValues, $targetElem, field))!=-1){
$targetElem.prop('checked', true);
$targetElem.trigger('change');
if($targetElem.parents('.gfield_price').length){
gformCalculateTotalPrice(self.formId);
}}
}else if(targetGroup.length > 1){
value=gform.applyFilters('gppc_copied_value', sourceValues[index], $targetElem, field);
value=gform.applyFilters('gpcc_copied_value', value, $targetElem, field);
$targetElem.val(value);
}else{
sourceValues=sourceValues.filter(function (item, pos){
return item!='';
}
);
value=gform.applyFilters('gppc_copied_value', self.cleanValueByInputType(sourceValues.join(' '), $targetElem.attr('type')), $targetElem, field, sourceValues);
value=gform.applyFilters('gpcc_copied_value', value, $targetElem, field, sourceValues);
if($targetElem.parents('.gfield_price:not(.gfield_quantity)').length > 0&&$targetElem.is('select, input[type="radio"], input[type="checkbox"]')&&value.indexOf('|')===-1){
$targetElem.val($targetElem.find('option[value^="' + value + '|"]').attr('value'));
}else{
if($targetElem.is('select')&&$targetElem.find('option[value="' + value + '"]').length===0){
value=$targetElem.find('option:first').val();
}
$targetElem.val(value);
if(window.tinyMCE){
var tiny=tinyMCE.get($targetElem.attr('id'));
if(tiny){
tiny.setContent(value);
}}
}}
if(value){
$targetElem.addClass('gpcc-populated-input').parents('.gfield').addClass('gpcc-populated');
}else{
$targetElem.removeClass('gpcc-populated-input').parents('.gfield').removeClass('gpcc-populated');
}}
);
if(targetGroup.is(':checkbox, :radio')){
if(! isOverwrite){
targetGroup.filter(':checked');
}
targetGroup.keypress();
}else{
targetGroup.each(function(i){
if(targetValues[ i ]!=$(this).val()){
$(this)
.change()
.trigger('chosen:updated');
}});
}
targetGroup.trigger('copy.gpcopycat');
}};
self.clearValues=function (elem){
var fieldId=$(elem).parents('.gfield').attr('id').replace('field_' + self.formId + '_', '');
var fields=self.getFieldSettings(fieldId);
for (var i=0; i < fields.length; i++){
var field=fields[i],
sourceValues=[],
targetGroup=self.getFieldGroup(field, 'target'),
sourceGroup=self.getFieldGroup(field, 'source'),
isListtoList=self.isListField(targetGroup)&&self.isListField(sourceGroup);
var customClear=window.gform.applyFilters('gpcc_custom_clear', false, elem.id, sourceGroup, targetGroup, field.source);
if(customClear){
continue;
}
if(isListtoList){
continue;
}
if(parseInt(field.source)==fieldId&&$(elem).is(':checkbox')){
if(self.overwrite){
targetGroup.prop('checked', false);
}
self.copyValues(elem, true, true);
continue;
}
sourceGroup.each(function (i){
sourceValues[i]=$(this).val();
}
);
targetGroup.each(function (i){
var $targetElem=$(this),
fieldValue=$targetElem.val(),
isCheckable=$targetElem.is(':checkbox, :radio'),
isCheckbox=$targetElem.is(':checkbox');
var sourceValue=sourceValues[i];
if(targetGroup.length==1){
sourceValues=sourceValues.filter(function (item, pos){
return item!='';
}
);
sourceValue=sourceValues.join(' ');
}
sourceValue=self.cleanValueByInputType(sourceValue);
sourceValue=gform.applyFilters('gppc_copied_value', sourceValue, $targetElem, field);
sourceValue=gform.applyFilters('gpcc_copied_value', sourceValue, $targetElem, field);
if(isCheckbox&&$targetElem.is(':checked')){
$targetElem.prop('checked', $.inArray(fieldValue, sourceValues)!==-1).change();
}else if(isCheckable&&$targetElem.is(':checked')){
$targetElem.prop('checked', false).change();
}else if(fieldValue!==''&&fieldValue==sourceValue){
$targetElem.val('').change();
}
$targetElem.removeClass('gpcc-populated-input').parents('.gfield').removeClass('gpcc-populated');
}
)
if(self.isListField(targetGroup)){
var maxRows=self.getMaxRowCount(targetGroup);
targetGroup.parents('.ginput_list').find('.gfield_list_group:not(:first)').each(function (){
if($(this).find('.gfield_list_cell input[value!=""]').length===0){
gformDeleteListItem($(this).find('input').eq(0), maxRows);
}}
);
}}
};
self.cleanValueByInputType=function (value, inputType){
if(inputType=='number'){
value=gformToNumber(value);
}
return value;
};
self.getFieldGroup=function (field, groupType){
var rawFieldId=field[groupType],
fieldId=parseInt(rawFieldId),
formId=field[groupType + 'FormId'],
$field=$('#field_' + formId + '_' + fieldId),
group=$field.find('input[name^="input"]:not(:button), select[name^="input"], textarea[name^="input"]'),
isListField=self.isListField(group);
if(isListField){
group=group.filter('[name="input_{0}[]"]'.format(fieldId));
}
if(isInputSpecific(rawFieldId)&&! isListField){
var inputId=rawFieldId.split('.')[1],
filteredGroup=group.filter('[id^="input_' + formId + '_' + fieldId + '_' + inputId + '"], input[name="input_' + rawFieldId + '"]');
if(filteredGroup.length <=0){
group=group.filter('#input_' + formId + '_' + rawFieldId);
}else{
group=filteredGroup;
}}else if(isInputSpecific(rawFieldId)&&isListField){
group=group.filter(function (){
var currentListInputIndex=self.getListInputIndex($(this)),
targetListInputIndex=self.getListInputIndex(rawFieldId, currentListInputIndex);
return currentListInputIndex==targetListInputIndex;
}
);
}
if(groupType=='source'&&group.length > 1&&$(group[0]).closest('.ginput_container_password').length){
group=group.filter('#input_' + formId + '_' + rawFieldId);
}
if(groupType=='source'&&group.is('input:radio, input:checkbox')){
group=group.filter(':checked');
}
return gform.applyFilters('gpcc_field_group', group, field, groupType, $field);
};
self.getGroupValues=function (group, type, args){
if(typeof args=='undefined'){
args={};}
args=parseArgs(
args,
{
sort: false,
isListToList: false,
sourceInputId: false,
targetInputId: false
}
);
var values=[];
group.each(function (i){
var index=i;
if(args.isListToList&&! isInputSpecific(args.targetInputId)){
index=self.getListInputIndex($(this));
}
values[index]=$(this).val();
}
);
if(args.sort!==false){
var sort=args.sort.filter(function (item, pos){
return args.sort.indexOf(item)==pos&&item!='';
}
);
var sorted=[];
for (var i=0; i < sort.length; i++){
var index=values.indexOf(sort[i]);
if(index!==-1){
sorted.push(values[index]);
values.splice(index, 1);
}}
values=sorted.concat(values);
}
return values;
};
self.isListField=function (group){
if(group.data('isListField')!==undefined){
return group.data('isListField');
}
var isListField=group.parents('.ginput_list').length > 0;
group.data('isListField', isListField);
return isListField;
};
self.getSourceFieldIdByTarget=function(targetFieldId, returnSettings){
for(var i in self.fields){
if(! self.fields.hasOwnProperty(i)){
continue;
}
var fieldSettings=self.fields[ i ];
for(var j=0; j < fieldSettings.length; j++){
var setting=fieldSettings[ j ];
if(parseInt(setting.target)===parseInt(targetFieldId)){
return returnSettings ? fieldSettings:setting.source;
}}
}
return false;
}
self.getSourceField=function(sourceFieldId, returnSettings){
for(var i in self.fields){
if(! self.fields.hasOwnProperty(i)){
continue;
}
var fieldSettings=self.fields[ i ];
for(var j=0; j < fieldSettings.length; j++){
var setting=fieldSettings[ j ];
if(parseInt(setting.source)===parseInt(sourceFieldId)){
return returnSettings ? fieldSettings:setting.source;
}}
}
return false;
}
self.getListInputIndex=function ($input, currentInputIndex, returnObject){
if(typeof currentInputIndex=='undefined'){
returnObject=false;
}else if(typeof currentInputIndex=='boolean'){
returnObject=currentInputIndex;
currentInputIndex=false;
}else if(typeof returnObject=='undefined'){
returnObject=false;
}
if(typeof $input=='object'){
var fieldId=$input.attr('name').match(/(\d+)/)[0],
$group=$input.parents('.gfield_list_group'),
$inputs=$group.find('[name="input_{0}[]"]'.format(fieldId)),
$groups=$input.parents('.gfield_list_container').find('.gfield_list_group'),
column=$inputs.index($input) + 1,
row=$groups.index($group) + 1;
}else{
var inputId=$input,
bits=inputId.split('.'),
byts=currentInputIndex ? currentInputIndex.split('.'):[1, 1],
column=bits[1],
row=bits[2] ? bits[2]:byts[1];
}
var inputIndex=column + '.' + row;
return returnObject ? {index:inputIndex, column:column, row:row}:inputIndex;
};
self.getMaxRowCount=function (targetGroup){
var classes=targetGroup.parents('.gfield').attr('class').split(' ');
for (var i=0; i < classes.length; i++){
if(classes[i].indexOf('gp-field-maxrows')!==-1){
return parseInt(classes[i].split('-')[3]);
}}
return 0;
};
function isInputSpecific(inputId){
return parseInt(inputId)!=inputId;
}
function parseArgs(args, defaults){
for (key in defaults){
if(defaults.hasOwnProperty(key)&&typeof args[key]=='undefined'){
args[key]=defaults[key];
}}
return args;
}
function getObjectValues(obj){
if(! (obj instanceof Object)){
return obj;
}
var values=[];
for (var prop in obj){
if(obj.hasOwnProperty(prop)){
values.push(obj[prop]);
}}
return values;
}
self.init();
};})(jQuery);
;(function($){$(document).ready(function(){$('body').on('click','.tmm_more_info',function(){$(this).find(".tmm_comp_text").slideToggle(100)});function tmm_equalize(){$('.tmm_textblock').css({'padding-bottom':'10px'});$('.tmm_scblock').each(function(i,val){if($(this).html().length>0){$(this).closest('.tmm_textblock').css({'padding-bottom':'65px'})}});$('.tmm_container').each(function(){if($(this).hasClass('tmm-equalizer')){var current_container=$(this);var members=[];var tabletCount=0;var tabletArray=[];var memberOne;var memberOneHeight;var memberTwo;var memberTwoHeight;current_container.find('.tmm_member').each(function(){tabletCount++;var current_member=$(this);current_member.css({'min-height':0});members.push(current_member.outerHeight());if(tabletCount==1){memberOne=current_member;memberOneHeight=memberOne.outerHeight()}else if(tabletCount==2){tabletCount=0;memberTwo=current_member;memberTwoHeight=memberTwo.outerHeight();if(memberOneHeight>=memberTwoHeight){tabletArray.push({memberOne:memberOne,memberTwo:memberTwo,height:memberOneHeight})}else{tabletArray.push({memberOne:memberOne,memberTwo:memberTwo,height:memberTwoHeight})}}});if(parseInt($(window).width())>1026){biggestMember=Math.max.apply(Math,members);current_container.find('.tmm_member').css('min-height',biggestMember)}else if(parseInt($(window).width())>640){$.each(tabletArray,function(index,value){$(value.memberOne).css('min-height',value.height);$(value.memberTwo).css('min-height',value.height)})}else{current_container.find('.tmm_member').css('min-height','auto')}}})}
function debounce(func,wait,immediate){var timeout;return function(){var context=this,args=arguments;var later=function(){timeout=null;if(!immediate)func.apply(context,args)};var callNow=immediate&&!timeout;clearTimeout(timeout);timeout=setTimeout(later,wait);if(callNow)func.apply(context,args)}};tmm_equalize();$(window).on("load",function(){tmm_equalize()});$(window).resize(debounce(function(){tmm_equalize()},100))})})(jQuery);