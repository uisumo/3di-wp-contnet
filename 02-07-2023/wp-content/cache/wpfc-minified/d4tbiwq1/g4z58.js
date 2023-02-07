var __gf_timeout_handle;function gf_apply_rules(e,t,i){jQuery(document).trigger("gform_pre_conditional_logic",[e,t,i]);for(var a=0;a<t.length;a++)gf_apply_field_rule(e,t[a],i,function(){a>=t.length-1&&(jQuery(document).trigger("gform_post_conditional_logic",[e,t,i]),window.gformCalculateTotalPrice&&window.gformCalculateTotalPrice(e))})}function gf_check_field_rule(e,t,i,a){var r,t=gf_get_field_logic(e,t);return t?"hide"!=(r=gf_get_field_action(e,t.section))?gf_get_field_action(e,t.field):r:"show"}function gf_get_field_logic(e,t){var i=rgars(window,"gf_form_conditional_logic/"+e);if(i){e=rgars(i,"logic/"+t);if(e)return e;var a=rgar(i,"dependents");if(a)for(var r in a)if(-1!==a[r].indexOf(t))return rgars(i,"logic/"+r)}return!1}function gf_apply_field_rule(e,t,i,a){gf_do_field_action(e,gf_check_field_rule(e,t,i,a),t,i,a);a=window.gf_form_conditional_logic[e].logic[t];a.nextButton&&gf_do_next_button_action(e,gf_get_field_action(e,a.nextButton),t,i)}function gf_get_field_action(e,t){if(!t)return"show";for(var i=0,a=0;a<t.rules.length;a++)gf_is_match(e,gform.applyFilters("gform_rule_pre_evaluation",jQuery.extend({},t.rules[a]),e,t))&&i++;return"all"==t.logicType&&i==t.rules.length||"any"==t.logicType&&0<i?t.actionType:"show"==t.actionType?"hide":"show"}function gf_is_match(e,t){var i=jQuery,a=t.fieldId,r=gformExtractFieldId(a),a=gformExtractInputIndex(a),a=i(!1!==a?"#input_{0}_{1}_{2}".format(e,r,a):'input[id="input_{0}_{1}"], input[id^="input_{0}_{1}_"], input[id^="choice_{0}_{1}_"], select#input_{0}_{1}, textarea#input_{0}_{1}'.format(e,r)),i=-1!==i.inArray(a.attr("type"),["checkbox","radio"])?gf_is_match_checkable(a,t,e,r):gf_is_match_default(a.eq(0),t,e,r);return gform.applyFilters("gform_is_value_match",i,e,t)}function gf_is_match_checkable(e,r,n,o){var _;return""===r.value?"is"===r.operator?gf_is_checkable_empty(e):!gf_is_checkable_empty(e):(_=!1,e.each(function(){var e=jQuery(this),t=gf_get_value(e.val()),i=-1!==jQuery.inArray(r.operator,["<",">"]),a=-1!==jQuery.inArray(r.operator,["contains","starts_with","ends_with"]);if(t==r.value||i||a)return e.is(":checked")?"gf_other_choice"==t&&(t=jQuery("#input_{0}_{1}_other".format(n,o)).val()):t="",gf_matches_operation(t,r.value,r.operator)?!(_=!0):void 0}),_)}function gf_is_checkable_empty(e){var t=!0;return e.each(function(){jQuery(this).is(":checked")&&(t=!1)}),t}function gf_is_match_default(e,t,i,a){for(var e=e.val(),r=e instanceof Array?e:[e],n=0,o=Math.max(r.length,1),_=0;_<o;_++){var l=!r[_]||0<=r[_].indexOf("|"),d=gf_get_value(r[_]),s=gf_get_field_number_format(t.fieldId,i,"value"),l=(s&&!l&&(d=gf_format_number(d,s)),t.value);gf_matches_operation(d,l,t.operator)&&n++}return"isnot"==t.operator?n==o:0<n}function gf_format_number(e,t){return decimalSeparator=".","currency"==t?decimalSeparator=gformGetDecimalSeparator("currency"):"decimal_comma"==t?decimalSeparator=",":"decimal_dot"==t&&(decimalSeparator="."),e=gformCleanNumber(e,"","",decimalSeparator),number=(e=e||0).toString()}function gf_try_convert_float(e){var t="decimal_dot";return gformIsNumeric(e,t)?gformCleanNumber(e,"","","."):e}function gf_matches_operation(e,t,i){switch(e=e?e.toLowerCase():"",t=t?t.toLowerCase():"",i){case"is":return e==t;case"isnot":return e!=t;case">":return e=gf_try_convert_float(e),t=gf_try_convert_float(t),!(!gformIsNumber(e)||!gformIsNumber(t))&&t<e;case"<":return e=gf_try_convert_float(e),t=gf_try_convert_float(t),!(!gformIsNumber(e)||!gformIsNumber(t))&&e<t;case"contains":return 0<=e.indexOf(t);case"starts_with":return 0==e.indexOf(t);case"ends_with":var a=e.length-t.length;return a<0?!1:t==e.substring(a)}return!1}function gf_get_value(e){return e?(e=e.split("|"))[0]:""}function gf_do_field_action(e,t,i,a,r){for(var n=window.gf_form_conditional_logic[e],o=n.dependents[i],_=0;_<o.length;_++){var l=0==i?"#gform_submit_button_"+e:"#field_"+e+"_"+o[_],d=n.defaults[o[_]],s=(do_callback=_+1==o.length?r:null,gform.applyFilters("gform_abort_conditional_logic_do_action",!1,t,l,n.animation,d,a,e,do_callback));s||gf_do_action(t,l,n.animation,d,a,do_callback,e),gform.doAction("gform_post_conditional_logic_field_action",e,t,l,d,a)}}function gf_do_next_button_action(e,t,i,a){var r=window.gf_form_conditional_logic[e],i="#gform_next_button_"+e+"_"+i;gform.applyFilters("gform_abort_conditional_logic_do_action",!1,t,i,r.animation,null,a,e,null)||gf_do_action(t,i,r.animation,null,a,null,e)}function gf_do_action(e,t,i,a,r,n,o){var _=jQuery(t);_.data("gf-disabled-assessed")||(_.find(":input:disabled").addClass("gf-default-disabled"),_.data("gf-disabled-assessed",!0)),"show"==e?(_.find("select").each(function(){var e=jQuery(this);e.attr("tabindex",e.data("tabindex"))}),i&&!r?0<_.length?(_.find(":input:hidden:not(.gf-default-disabled)").removeAttr("disabled"),(_.is('input[type="submit"]')||_.hasClass("gform_next_button"))&&(_.removeAttr("disabled").css("display",""),"1"==gf_legacy.is_legacy&&_.removeClass("screen-reader-text")),_.slideDown(n)):n&&n():(""!=(e=_.data("gf_display"))&&"none"!=e||(e="1"===gf_legacy.is_legacy?"list-item":"block"),_.find(":input:hidden:not(.gf-default-disabled)").removeAttr("disabled"),_.is('input[type="submit"]')||_.hasClass("gform_next_button")?(_.removeAttr("disabled").css("display",""),"1"==gf_legacy.is_legacy&&_.removeClass("screen-reader-text")):_.css("display",e),n&&n())):(0<(e=_.children().first()).length&&gform.applyFilters("gform_reset_pre_conditional_logic_field_action",!0,o,t,a,r)&&!gformIsHidden(e)&&gf_reset_to_default(t,a),_.find("select").each(function(){var e=jQuery(this);e.data("tabindex",e.attr("tabindex")).removeAttr("tabindex")}),_.data("gf_display")||_.data("gf_display",_.css("display")),i&&!r?_.is('input[type="submit"]')||_.hasClass("gform_next_button")?(_.attr("disabled","disabled").hide(),"1"===gf_legacy.is_legacy&&_.addClass("screen-reader-text")):0<_.length&&_.is(":visible")?_.slideUp(n):n&&n():(_.is('input[type="submit"]')||_.hasClass("gform_next_button")?(_.attr("disabled","disabled").hide(),"1"===gf_legacy.is_legacy&&_.addClass("screen-reader-text")):_.css("display","none"),_.find(":input:hidden:not(.gf-default-disabled)").attr("disabled","disabled"),n&&n()))}function gf_reset_to_default(e,a){var t=jQuery(e).find(".gfield_date_month input, .gfield_date_day input, .gfield_date_year input, .gfield_date_dropdown_month select, .gfield_date_dropdown_day select, .gfield_date_dropdown_year select");if(0<t.length)t.each(function(){var e,t=jQuery(this);val=a?(e="d",t.parents().hasClass("gfield_date_month")||t.parents().hasClass("gfield_date_dropdown_month")?e="m":(t.parents().hasClass("gfield_date_year")||t.parents().hasClass("gfield_date_dropdown_year"))&&(e="y"),a[e]):"","SELECT"==t.prop("tagName")&&""!=val&&(val=parseInt(val,10)),t.val()!=val?t.val(val).trigger("change"):t.val(val)});else{var i=jQuery(e).find('select, input[type="text"]:not([id*="_shim"]), input[type="number"], input[type="hidden"], input[type="email"], input[type="tel"], input[type="url"], textarea'),r=0;if(a&&0<i.parents(".ginput_list").length&&i.length<a.length)for(;i.length<a.length;)gformAddListItem(i.eq(0),0),i=jQuery(e).find('select, input[type="text"]:not([id*="_shim"]), input[type="number"], textarea');i.each(function(){var e,t="",i=jQuery(this);i.is('[type="hidden"]')&&!gf_is_hidden_pricing_input(i)||("gf_other_choice"==i.prev("input").attr("value")?t=i.attr("value"):jQuery.isArray(a)&&!i.is("select[multiple]")?t=a[r]:jQuery.isPlainObject(a)?(!(t=a[i.attr("name")])&&i.attr("id")&&(e=i.attr("id").split("_").slice(2).join("."),t=a[e]),!t&&i.attr("name")&&(e=i.attr("name").split("_")[1],t=a[e])):a&&(t=a),i.is("select:not([multiple])")&&!t&&(t=i.find("option").not(":disabled").eq(0).val()),i.val()!=t?(i.val(t).trigger("change"),i.is("select")&&i.next().hasClass("chosen-container")&&i.trigger("chosen:updated"),gf_is_hidden_pricing_input(i)&&(e=gf_get_ids_by_html_id(i.parents(".gfield").attr("id")),jQuery("#input_"+e[0]+"_"+e[1]).text(gformFormatMoney(i.val())),i.val(gformFormatMoney(i.val())))):i.val(t),r++)}),jQuery(e).find('input[type="radio"], input[type="checkbox"]:not(".copy_values_activated")').each(function(){var e=!!jQuery(this).is(":checked"),t=!!a&&-1<jQuery.inArray(jQuery(this).attr("id"),a);e!=t&&("checkbox"==jQuery(this).attr("type")?jQuery(this).trigger("click"):jQuery(this).prop("checked",t).change())})}}function gf_is_hidden_pricing_input(e){return!(!e.attr("id")||0!==e.attr("id").indexOf("ginput_base_price"))||"hidden"===e.attr("type")&&e.parents(".gfield_shipping").length}gform.addAction("gform_input_change",function(e,t,i){!window.gf_form_conditional_logic||(i=rgars(gf_form_conditional_logic,[t,"fields",gformExtractFieldId(i)].join("/")))&&gf_apply_rules(t,i)},10);
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
!function(e){"use strict";"function"==typeof define&&define.amd?define(["jquery","./core"],e):e(jQuery)}(function(o){"use strict";var n=!1;return o(document).on("mouseup",function(){n=!1}),o.widget("ui.mouse",{version:"1.13.2",options:{cancel:"input, textarea, button, select, option",distance:1,delay:0},_mouseInit:function(){var t=this;this.element.on("mousedown."+this.widgetName,function(e){return t._mouseDown(e)}).on("click."+this.widgetName,function(e){if(!0===o.data(e.target,t.widgetName+".preventClickEvent"))return o.removeData(e.target,t.widgetName+".preventClickEvent"),e.stopImmediatePropagation(),!1}),this.started=!1},_mouseDestroy:function(){this.element.off("."+this.widgetName),this._mouseMoveDelegate&&this.document.off("mousemove."+this.widgetName,this._mouseMoveDelegate).off("mouseup."+this.widgetName,this._mouseUpDelegate)},_mouseDown:function(e){var t,s,i;if(!n)return this._mouseMoved=!1,this._mouseStarted&&this._mouseUp(e),s=1===(this._mouseDownEvent=e).which,i=!("string"!=typeof(t=this).options.cancel||!e.target.nodeName)&&o(e.target).closest(this.options.cancel).length,s&&!i&&this._mouseCapture(e)&&(this.mouseDelayMet=!this.options.delay,this.mouseDelayMet||(this._mouseDelayTimer=setTimeout(function(){t.mouseDelayMet=!0},this.options.delay)),this._mouseDistanceMet(e)&&this._mouseDelayMet(e)&&(this._mouseStarted=!1!==this._mouseStart(e),!this._mouseStarted)?e.preventDefault():(!0===o.data(e.target,this.widgetName+".preventClickEvent")&&o.removeData(e.target,this.widgetName+".preventClickEvent"),this._mouseMoveDelegate=function(e){return t._mouseMove(e)},this._mouseUpDelegate=function(e){return t._mouseUp(e)},this.document.on("mousemove."+this.widgetName,this._mouseMoveDelegate).on("mouseup."+this.widgetName,this._mouseUpDelegate),e.preventDefault(),n=!0)),!0},_mouseMove:function(e){if(this._mouseMoved){if(o.ui.ie&&(!document.documentMode||document.documentMode<9)&&!e.button)return this._mouseUp(e);if(!e.which)if(e.originalEvent.altKey||e.originalEvent.ctrlKey||e.originalEvent.metaKey||e.originalEvent.shiftKey)this.ignoreMissingWhich=!0;else if(!this.ignoreMissingWhich)return this._mouseUp(e)}return(e.which||e.button)&&(this._mouseMoved=!0),this._mouseStarted?(this._mouseDrag(e),e.preventDefault()):(this._mouseDistanceMet(e)&&this._mouseDelayMet(e)&&(this._mouseStarted=!1!==this._mouseStart(this._mouseDownEvent,e),this._mouseStarted?this._mouseDrag(e):this._mouseUp(e)),!this._mouseStarted)},_mouseUp:function(e){this.document.off("mousemove."+this.widgetName,this._mouseMoveDelegate).off("mouseup."+this.widgetName,this._mouseUpDelegate),this._mouseStarted&&(this._mouseStarted=!1,e.target===this._mouseDownEvent.target&&o.data(e.target,this.widgetName+".preventClickEvent",!0),this._mouseStop(e)),this._mouseDelayTimer&&(clearTimeout(this._mouseDelayTimer),delete this._mouseDelayTimer),this.ignoreMissingWhich=!1,n=!1,e.preventDefault()},_mouseDistanceMet:function(e){return Math.max(Math.abs(this._mouseDownEvent.pageX-e.pageX),Math.abs(this._mouseDownEvent.pageY-e.pageY))>=this.options.distance},_mouseDelayMet:function(){return this.mouseDelayMet},_mouseStart:function(){},_mouseDrag:function(){},_mouseStop:function(){},_mouseCapture:function(){return!0}})});
!function(t){"use strict";"function"==typeof define&&define.amd?define(["jquery","./mouse","./core"],t):t(jQuery)}(function(u){"use strict";return u.widget("ui.sortable",u.ui.mouse,{version:"1.13.2",widgetEventPrefix:"sort",ready:!1,options:{appendTo:"parent",axis:!1,connectWith:!1,containment:!1,cursor:"auto",cursorAt:!1,dropOnEmpty:!0,forcePlaceholderSize:!1,forceHelperSize:!1,grid:!1,handle:!1,helper:"original",items:"> *",opacity:!1,placeholder:!1,revert:!1,scroll:!0,scrollSensitivity:20,scrollSpeed:20,scope:"default",tolerance:"intersect",zIndex:1e3,activate:null,beforeStop:null,change:null,deactivate:null,out:null,over:null,receive:null,remove:null,sort:null,start:null,stop:null,update:null},_isOverAxis:function(t,e,i){return e<=t&&t<e+i},_isFloating:function(t){return/left|right/.test(t.css("float"))||/inline|table-cell/.test(t.css("display"))},_create:function(){this.containerCache={},this._addClass("ui-sortable"),this.refresh(),this.offset=this.element.offset(),this._mouseInit(),this._setHandleClassName(),this.ready=!0},_setOption:function(t,e){this._super(t,e),"handle"===t&&this._setHandleClassName()},_setHandleClassName:function(){var t=this;this._removeClass(this.element.find(".ui-sortable-handle"),"ui-sortable-handle"),u.each(this.items,function(){t._addClass(this.instance.options.handle?this.item.find(this.instance.options.handle):this.item,"ui-sortable-handle")})},_destroy:function(){this._mouseDestroy();for(var t=this.items.length-1;0<=t;t--)this.items[t].item.removeData(this.widgetName+"-item");return this},_mouseCapture:function(t,e){var i=null,s=!1,o=this;return!this.reverting&&(!this.options.disabled&&"static"!==this.options.type&&(this._refreshItems(t),u(t.target).parents().each(function(){if(u.data(this,o.widgetName+"-item")===o)return i=u(this),!1}),!!(i=u.data(t.target,o.widgetName+"-item")===o?u(t.target):i)&&(!(this.options.handle&&!e&&(u(this.options.handle,i).find("*").addBack().each(function(){this===t.target&&(s=!0)}),!s))&&(this.currentItem=i,this._removeCurrentsFromItems(),!0))))},_mouseStart:function(t,e,i){var s,o,r=this.options;if((this.currentContainer=this).refreshPositions(),this.appendTo=u("parent"!==r.appendTo?r.appendTo:this.currentItem.parent()),this.helper=this._createHelper(t),this._cacheHelperProportions(),this._cacheMargins(),this.offset=this.currentItem.offset(),this.offset={top:this.offset.top-this.margins.top,left:this.offset.left-this.margins.left},u.extend(this.offset,{click:{left:t.pageX-this.offset.left,top:t.pageY-this.offset.top},relative:this._getRelativeOffset()}),this.helper.css("position","absolute"),this.cssPosition=this.helper.css("position"),r.cursorAt&&this._adjustOffsetFromHelper(r.cursorAt),this.domPosition={prev:this.currentItem.prev()[0],parent:this.currentItem.parent()[0]},this.helper[0]!==this.currentItem[0]&&this.currentItem.hide(),this._createPlaceholder(),this.scrollParent=this.placeholder.scrollParent(),u.extend(this.offset,{parent:this._getParentOffset()}),r.containment&&this._setContainment(),r.cursor&&"auto"!==r.cursor&&(o=this.document.find("body"),this.storedCursor=o.css("cursor"),o.css("cursor",r.cursor),this.storedStylesheet=u("<style>*{ cursor: "+r.cursor+" !important; }</style>").appendTo(o)),r.zIndex&&(this.helper.css("zIndex")&&(this._storedZIndex=this.helper.css("zIndex")),this.helper.css("zIndex",r.zIndex)),r.opacity&&(this.helper.css("opacity")&&(this._storedOpacity=this.helper.css("opacity")),this.helper.css("opacity",r.opacity)),this.scrollParent[0]!==this.document[0]&&"HTML"!==this.scrollParent[0].tagName&&(this.overflowOffset=this.scrollParent.offset()),this._trigger("start",t,this._uiHash()),this._preserveHelperProportions||this._cacheHelperProportions(),!i)for(s=this.containers.length-1;0<=s;s--)this.containers[s]._trigger("activate",t,this._uiHash(this));return u.ui.ddmanager&&(u.ui.ddmanager.current=this),u.ui.ddmanager&&!r.dropBehaviour&&u.ui.ddmanager.prepareOffsets(this,t),this.dragging=!0,this._addClass(this.helper,"ui-sortable-helper"),this.helper.parent().is(this.appendTo)||(this.helper.detach().appendTo(this.appendTo),this.offset.parent=this._getParentOffset()),this.position=this.originalPosition=this._generatePosition(t),this.originalPageX=t.pageX,this.originalPageY=t.pageY,this.lastPositionAbs=this.positionAbs=this._convertPositionTo("absolute"),this._mouseDrag(t),!0},_scroll:function(t){var e=this.options,i=!1;return this.scrollParent[0]!==this.document[0]&&"HTML"!==this.scrollParent[0].tagName?(this.overflowOffset.top+this.scrollParent[0].offsetHeight-t.pageY<e.scrollSensitivity?this.scrollParent[0].scrollTop=i=this.scrollParent[0].scrollTop+e.scrollSpeed:t.pageY-this.overflowOffset.top<e.scrollSensitivity&&(this.scrollParent[0].scrollTop=i=this.scrollParent[0].scrollTop-e.scrollSpeed),this.overflowOffset.left+this.scrollParent[0].offsetWidth-t.pageX<e.scrollSensitivity?this.scrollParent[0].scrollLeft=i=this.scrollParent[0].scrollLeft+e.scrollSpeed:t.pageX-this.overflowOffset.left<e.scrollSensitivity&&(this.scrollParent[0].scrollLeft=i=this.scrollParent[0].scrollLeft-e.scrollSpeed)):(t.pageY-this.document.scrollTop()<e.scrollSensitivity?i=this.document.scrollTop(this.document.scrollTop()-e.scrollSpeed):this.window.height()-(t.pageY-this.document.scrollTop())<e.scrollSensitivity&&(i=this.document.scrollTop(this.document.scrollTop()+e.scrollSpeed)),t.pageX-this.document.scrollLeft()<e.scrollSensitivity?i=this.document.scrollLeft(this.document.scrollLeft()-e.scrollSpeed):this.window.width()-(t.pageX-this.document.scrollLeft())<e.scrollSensitivity&&(i=this.document.scrollLeft(this.document.scrollLeft()+e.scrollSpeed))),i},_mouseDrag:function(t){var e,i,s,o,r=this.options;for(this.position=this._generatePosition(t),this.positionAbs=this._convertPositionTo("absolute"),this.options.axis&&"y"===this.options.axis||(this.helper[0].style.left=this.position.left+"px"),this.options.axis&&"x"===this.options.axis||(this.helper[0].style.top=this.position.top+"px"),r.scroll&&!1!==this._scroll(t)&&(this._refreshItemPositions(!0),u.ui.ddmanager&&!r.dropBehaviour&&u.ui.ddmanager.prepareOffsets(this,t)),this.dragDirection={vertical:this._getDragVerticalDirection(),horizontal:this._getDragHorizontalDirection()},e=this.items.length-1;0<=e;e--)if(s=(i=this.items[e]).item[0],(o=this._intersectsWithPointer(i))&&i.instance===this.currentContainer&&!(s===this.currentItem[0]||this.placeholder[1===o?"next":"prev"]()[0]===s||u.contains(this.placeholder[0],s)||"semi-dynamic"===this.options.type&&u.contains(this.element[0],s))){if(this.direction=1===o?"down":"up","pointer"!==this.options.tolerance&&!this._intersectsWithSides(i))break;this._rearrange(t,i),this._trigger("change",t,this._uiHash());break}return this._contactContainers(t),u.ui.ddmanager&&u.ui.ddmanager.drag(this,t),this._trigger("sort",t,this._uiHash()),this.lastPositionAbs=this.positionAbs,!1},_mouseStop:function(t,e){var i,s,o,r;if(t)return u.ui.ddmanager&&!this.options.dropBehaviour&&u.ui.ddmanager.drop(this,t),this.options.revert?(s=(i=this).placeholder.offset(),r={},(o=this.options.axis)&&"x"!==o||(r.left=s.left-this.offset.parent.left-this.margins.left+(this.offsetParent[0]===this.document[0].body?0:this.offsetParent[0].scrollLeft)),o&&"y"!==o||(r.top=s.top-this.offset.parent.top-this.margins.top+(this.offsetParent[0]===this.document[0].body?0:this.offsetParent[0].scrollTop)),this.reverting=!0,u(this.helper).animate(r,parseInt(this.options.revert,10)||500,function(){i._clear(t)})):this._clear(t,e),!1},cancel:function(){if(this.dragging){this._mouseUp(new u.Event("mouseup",{target:null})),"original"===this.options.helper?(this.currentItem.css(this._storedCSS),this._removeClass(this.currentItem,"ui-sortable-helper")):this.currentItem.show();for(var t=this.containers.length-1;0<=t;t--)this.containers[t]._trigger("deactivate",null,this._uiHash(this)),this.containers[t].containerCache.over&&(this.containers[t]._trigger("out",null,this._uiHash(this)),this.containers[t].containerCache.over=0)}return this.placeholder&&(this.placeholder[0].parentNode&&this.placeholder[0].parentNode.removeChild(this.placeholder[0]),"original"!==this.options.helper&&this.helper&&this.helper[0].parentNode&&this.helper.remove(),u.extend(this,{helper:null,dragging:!1,reverting:!1,_noFinalSort:null}),this.domPosition.prev?u(this.domPosition.prev).after(this.currentItem):u(this.domPosition.parent).prepend(this.currentItem)),this},serialize:function(e){var t=this._getItemsAsjQuery(e&&e.connected),i=[];return e=e||{},u(t).each(function(){var t=(u(e.item||this).attr(e.attribute||"id")||"").match(e.expression||/(.+)[\-=_](.+)/);t&&i.push((e.key||t[1]+"[]")+"="+(e.key&&e.expression?t[1]:t[2]))}),!i.length&&e.key&&i.push(e.key+"="),i.join("&")},toArray:function(t){var e=this._getItemsAsjQuery(t&&t.connected),i=[];return t=t||{},e.each(function(){i.push(u(t.item||this).attr(t.attribute||"id")||"")}),i},_intersectsWith:function(t){var e=this.positionAbs.left,i=e+this.helperProportions.width,s=this.positionAbs.top,o=s+this.helperProportions.height,r=t.left,n=r+t.width,h=t.top,a=h+t.height,l=this.offset.click.top,c=this.offset.click.left,l="x"===this.options.axis||h<s+l&&s+l<a,c="y"===this.options.axis||r<e+c&&e+c<n;return"pointer"===this.options.tolerance||this.options.forcePointerForContainers||"pointer"!==this.options.tolerance&&this.helperProportions[this.floating?"width":"height"]>t[this.floating?"width":"height"]?l&&c:r<e+this.helperProportions.width/2&&i-this.helperProportions.width/2<n&&h<s+this.helperProportions.height/2&&o-this.helperProportions.height/2<a},_intersectsWithPointer:function(t){var e="x"===this.options.axis||this._isOverAxis(this.positionAbs.top+this.offset.click.top,t.top,t.height),t="y"===this.options.axis||this._isOverAxis(this.positionAbs.left+this.offset.click.left,t.left,t.width);return!(!e||!t)&&(e=this.dragDirection.vertical,t=this.dragDirection.horizontal,this.floating?"right"===t||"down"===e?2:1:e&&("down"===e?2:1))},_intersectsWithSides:function(t){var e=this._isOverAxis(this.positionAbs.top+this.offset.click.top,t.top+t.height/2,t.height),t=this._isOverAxis(this.positionAbs.left+this.offset.click.left,t.left+t.width/2,t.width),i=this.dragDirection.vertical,s=this.dragDirection.horizontal;return this.floating&&s?"right"===s&&t||"left"===s&&!t:i&&("down"===i&&e||"up"===i&&!e)},_getDragVerticalDirection:function(){var t=this.positionAbs.top-this.lastPositionAbs.top;return 0!=t&&(0<t?"down":"up")},_getDragHorizontalDirection:function(){var t=this.positionAbs.left-this.lastPositionAbs.left;return 0!=t&&(0<t?"right":"left")},refresh:function(t){return this._refreshItems(t),this._setHandleClassName(),this.refreshPositions(),this},_connectWith:function(){var t=this.options;return t.connectWith.constructor===String?[t.connectWith]:t.connectWith},_getItemsAsjQuery:function(t){var e,i,s,o,r=[],n=[],h=this._connectWith();if(h&&t)for(e=h.length-1;0<=e;e--)for(i=(s=u(h[e],this.document[0])).length-1;0<=i;i--)(o=u.data(s[i],this.widgetFullName))&&o!==this&&!o.options.disabled&&n.push(["function"==typeof o.options.items?o.options.items.call(o.element):u(o.options.items,o.element).not(".ui-sortable-helper").not(".ui-sortable-placeholder"),o]);function a(){r.push(this)}for(n.push(["function"==typeof this.options.items?this.options.items.call(this.element,null,{options:this.options,item:this.currentItem}):u(this.options.items,this.element).not(".ui-sortable-helper").not(".ui-sortable-placeholder"),this]),e=n.length-1;0<=e;e--)n[e][0].each(a);return u(r)},_removeCurrentsFromItems:function(){var i=this.currentItem.find(":data("+this.widgetName+"-item)");this.items=u.grep(this.items,function(t){for(var e=0;e<i.length;e++)if(i[e]===t.item[0])return!1;return!0})},_refreshItems:function(t){this.items=[],this.containers=[this];var e,i,s,o,r,n,h,a,l=this.items,c=[["function"==typeof this.options.items?this.options.items.call(this.element[0],t,{item:this.currentItem}):u(this.options.items,this.element),this]],p=this._connectWith();if(p&&this.ready)for(e=p.length-1;0<=e;e--)for(i=(s=u(p[e],this.document[0])).length-1;0<=i;i--)(o=u.data(s[i],this.widgetFullName))&&o!==this&&!o.options.disabled&&(c.push(["function"==typeof o.options.items?o.options.items.call(o.element[0],t,{item:this.currentItem}):u(o.options.items,o.element),o]),this.containers.push(o));for(e=c.length-1;0<=e;e--)for(r=c[e][1],a=(n=c[e][i=0]).length;i<a;i++)(h=u(n[i])).data(this.widgetName+"-item",r),l.push({item:h,instance:r,width:0,height:0,left:0,top:0})},_refreshItemPositions:function(t){for(var e,i,s=this.items.length-1;0<=s;s--)e=this.items[s],this.currentContainer&&e.instance!==this.currentContainer&&e.item[0]!==this.currentItem[0]||(i=this.options.toleranceElement?u(this.options.toleranceElement,e.item):e.item,t||(e.width=i.outerWidth(),e.height=i.outerHeight()),i=i.offset(),e.left=i.left,e.top=i.top)},refreshPositions:function(t){var e,i;if(this.floating=!!this.items.length&&("x"===this.options.axis||this._isFloating(this.items[0].item)),this.offsetParent&&this.helper&&(this.offset.parent=this._getParentOffset()),this._refreshItemPositions(t),this.options.custom&&this.options.custom.refreshContainers)this.options.custom.refreshContainers.call(this);else for(e=this.containers.length-1;0<=e;e--)i=this.containers[e].element.offset(),this.containers[e].containerCache.left=i.left,this.containers[e].containerCache.top=i.top,this.containers[e].containerCache.width=this.containers[e].element.outerWidth(),this.containers[e].containerCache.height=this.containers[e].element.outerHeight();return this},_createPlaceholder:function(i){var s,o,r=(i=i||this).options;r.placeholder&&r.placeholder.constructor!==String||(s=r.placeholder,o=i.currentItem[0].nodeName.toLowerCase(),r.placeholder={element:function(){var t=u("<"+o+">",i.document[0]);return i._addClass(t,"ui-sortable-placeholder",s||i.currentItem[0].className)._removeClass(t,"ui-sortable-helper"),"tbody"===o?i._createTrPlaceholder(i.currentItem.find("tr").eq(0),u("<tr>",i.document[0]).appendTo(t)):"tr"===o?i._createTrPlaceholder(i.currentItem,t):"img"===o&&t.attr("src",i.currentItem.attr("src")),s||t.css("visibility","hidden"),t},update:function(t,e){s&&!r.forcePlaceholderSize||(e.height()&&(!r.forcePlaceholderSize||"tbody"!==o&&"tr"!==o)||e.height(i.currentItem.innerHeight()-parseInt(i.currentItem.css("paddingTop")||0,10)-parseInt(i.currentItem.css("paddingBottom")||0,10)),e.width()||e.width(i.currentItem.innerWidth()-parseInt(i.currentItem.css("paddingLeft")||0,10)-parseInt(i.currentItem.css("paddingRight")||0,10)))}}),i.placeholder=u(r.placeholder.element.call(i.element,i.currentItem)),i.currentItem.after(i.placeholder),r.placeholder.update(i,i.placeholder)},_createTrPlaceholder:function(t,e){var i=this;t.children().each(function(){u("<td>&#160;</td>",i.document[0]).attr("colspan",u(this).attr("colspan")||1).appendTo(e)})},_contactContainers:function(t){for(var e,i,s,o,r,n,h,a,l,c=null,p=null,f=this.containers.length-1;0<=f;f--)u.contains(this.currentItem[0],this.containers[f].element[0])||(this._intersectsWith(this.containers[f].containerCache)?c&&u.contains(this.containers[f].element[0],c.element[0])||(c=this.containers[f],p=f):this.containers[f].containerCache.over&&(this.containers[f]._trigger("out",t,this._uiHash(this)),this.containers[f].containerCache.over=0));if(c)if(1===this.containers.length)this.containers[p].containerCache.over||(this.containers[p]._trigger("over",t,this._uiHash(this)),this.containers[p].containerCache.over=1);else{for(i=1e4,s=null,o=(a=c.floating||this._isFloating(this.currentItem))?"left":"top",r=a?"width":"height",l=a?"pageX":"pageY",e=this.items.length-1;0<=e;e--)u.contains(this.containers[p].element[0],this.items[e].item[0])&&this.items[e].item[0]!==this.currentItem[0]&&(n=this.items[e].item.offset()[o],h=!1,t[l]-n>this.items[e][r]/2&&(h=!0),Math.abs(t[l]-n)<i&&(i=Math.abs(t[l]-n),s=this.items[e],this.direction=h?"up":"down"));(s||this.options.dropOnEmpty)&&(this.currentContainer===this.containers[p]?this.currentContainer.containerCache.over||(this.containers[p]._trigger("over",t,this._uiHash()),this.currentContainer.containerCache.over=1):(s?this._rearrange(t,s,null,!0):this._rearrange(t,null,this.containers[p].element,!0),this._trigger("change",t,this._uiHash()),this.containers[p]._trigger("change",t,this._uiHash(this)),this.currentContainer=this.containers[p],this.options.placeholder.update(this.currentContainer,this.placeholder),this.scrollParent=this.placeholder.scrollParent(),this.scrollParent[0]!==this.document[0]&&"HTML"!==this.scrollParent[0].tagName&&(this.overflowOffset=this.scrollParent.offset()),this.containers[p]._trigger("over",t,this._uiHash(this)),this.containers[p].containerCache.over=1))}},_createHelper:function(t){var e=this.options,t="function"==typeof e.helper?u(e.helper.apply(this.element[0],[t,this.currentItem])):"clone"===e.helper?this.currentItem.clone():this.currentItem;return t.parents("body").length||this.appendTo[0].appendChild(t[0]),t[0]===this.currentItem[0]&&(this._storedCSS={width:this.currentItem[0].style.width,height:this.currentItem[0].style.height,position:this.currentItem.css("position"),top:this.currentItem.css("top"),left:this.currentItem.css("left")}),t[0].style.width&&!e.forceHelperSize||t.width(this.currentItem.width()),t[0].style.height&&!e.forceHelperSize||t.height(this.currentItem.height()),t},_adjustOffsetFromHelper:function(t){"string"==typeof t&&(t=t.split(" ")),"left"in(t=Array.isArray(t)?{left:+t[0],top:+t[1]||0}:t)&&(this.offset.click.left=t.left+this.margins.left),"right"in t&&(this.offset.click.left=this.helperProportions.width-t.right+this.margins.left),"top"in t&&(this.offset.click.top=t.top+this.margins.top),"bottom"in t&&(this.offset.click.top=this.helperProportions.height-t.bottom+this.margins.top)},_getParentOffset:function(){this.offsetParent=this.helper.offsetParent();var t=this.offsetParent.offset();return"absolute"===this.cssPosition&&this.scrollParent[0]!==this.document[0]&&u.contains(this.scrollParent[0],this.offsetParent[0])&&(t.left+=this.scrollParent.scrollLeft(),t.top+=this.scrollParent.scrollTop()),{top:(t=this.offsetParent[0]===this.document[0].body||this.offsetParent[0].tagName&&"html"===this.offsetParent[0].tagName.toLowerCase()&&u.ui.ie?{top:0,left:0}:t).top+(parseInt(this.offsetParent.css("borderTopWidth"),10)||0),left:t.left+(parseInt(this.offsetParent.css("borderLeftWidth"),10)||0)}},_getRelativeOffset:function(){var t;return"relative"===this.cssPosition?{top:(t=this.currentItem.position()).top-(parseInt(this.helper.css("top"),10)||0)+this.scrollParent.scrollTop(),left:t.left-(parseInt(this.helper.css("left"),10)||0)+this.scrollParent.scrollLeft()}:{top:0,left:0}},_cacheMargins:function(){this.margins={left:parseInt(this.currentItem.css("marginLeft"),10)||0,top:parseInt(this.currentItem.css("marginTop"),10)||0}},_cacheHelperProportions:function(){this.helperProportions={width:this.helper.outerWidth(),height:this.helper.outerHeight()}},_setContainment:function(){var t,e,i=this.options;"parent"===i.containment&&(i.containment=this.helper[0].parentNode),"document"!==i.containment&&"window"!==i.containment||(this.containment=[0-this.offset.relative.left-this.offset.parent.left,0-this.offset.relative.top-this.offset.parent.top,"document"===i.containment?this.document.width():this.window.width()-this.helperProportions.width-this.margins.left,("document"===i.containment?this.document.height()||document.body.parentNode.scrollHeight:this.window.height()||this.document[0].body.parentNode.scrollHeight)-this.helperProportions.height-this.margins.top]),/^(document|window|parent)$/.test(i.containment)||(t=u(i.containment)[0],i=u(i.containment).offset(),e="hidden"!==u(t).css("overflow"),this.containment=[i.left+(parseInt(u(t).css("borderLeftWidth"),10)||0)+(parseInt(u(t).css("paddingLeft"),10)||0)-this.margins.left,i.top+(parseInt(u(t).css("borderTopWidth"),10)||0)+(parseInt(u(t).css("paddingTop"),10)||0)-this.margins.top,i.left+(e?Math.max(t.scrollWidth,t.offsetWidth):t.offsetWidth)-(parseInt(u(t).css("borderLeftWidth"),10)||0)-(parseInt(u(t).css("paddingRight"),10)||0)-this.helperProportions.width-this.margins.left,i.top+(e?Math.max(t.scrollHeight,t.offsetHeight):t.offsetHeight)-(parseInt(u(t).css("borderTopWidth"),10)||0)-(parseInt(u(t).css("paddingBottom"),10)||0)-this.helperProportions.height-this.margins.top])},_convertPositionTo:function(t,e){e=e||this.position;var t="absolute"===t?1:-1,i="absolute"!==this.cssPosition||this.scrollParent[0]!==this.document[0]&&u.contains(this.scrollParent[0],this.offsetParent[0])?this.scrollParent:this.offsetParent,s=/(html|body)/i.test(i[0].tagName);return{top:e.top+this.offset.relative.top*t+this.offset.parent.top*t-("fixed"===this.cssPosition?-this.scrollParent.scrollTop():s?0:i.scrollTop())*t,left:e.left+this.offset.relative.left*t+this.offset.parent.left*t-("fixed"===this.cssPosition?-this.scrollParent.scrollLeft():s?0:i.scrollLeft())*t}},_generatePosition:function(t){var e=this.options,i=t.pageX,s=t.pageY,o="absolute"!==this.cssPosition||this.scrollParent[0]!==this.document[0]&&u.contains(this.scrollParent[0],this.offsetParent[0])?this.scrollParent:this.offsetParent,r=/(html|body)/i.test(o[0].tagName);return"relative"!==this.cssPosition||this.scrollParent[0]!==this.document[0]&&this.scrollParent[0]!==this.offsetParent[0]||(this.offset.relative=this._getRelativeOffset()),this.originalPosition&&(this.containment&&(t.pageX-this.offset.click.left<this.containment[0]&&(i=this.containment[0]+this.offset.click.left),t.pageY-this.offset.click.top<this.containment[1]&&(s=this.containment[1]+this.offset.click.top),t.pageX-this.offset.click.left>this.containment[2]&&(i=this.containment[2]+this.offset.click.left),t.pageY-this.offset.click.top>this.containment[3]&&(s=this.containment[3]+this.offset.click.top)),e.grid&&(t=this.originalPageY+Math.round((s-this.originalPageY)/e.grid[1])*e.grid[1],s=!this.containment||t-this.offset.click.top>=this.containment[1]&&t-this.offset.click.top<=this.containment[3]?t:t-this.offset.click.top>=this.containment[1]?t-e.grid[1]:t+e.grid[1],t=this.originalPageX+Math.round((i-this.originalPageX)/e.grid[0])*e.grid[0],i=!this.containment||t-this.offset.click.left>=this.containment[0]&&t-this.offset.click.left<=this.containment[2]?t:t-this.offset.click.left>=this.containment[0]?t-e.grid[0]:t+e.grid[0])),{top:s-this.offset.click.top-this.offset.relative.top-this.offset.parent.top+("fixed"===this.cssPosition?-this.scrollParent.scrollTop():r?0:o.scrollTop()),left:i-this.offset.click.left-this.offset.relative.left-this.offset.parent.left+("fixed"===this.cssPosition?-this.scrollParent.scrollLeft():r?0:o.scrollLeft())}},_rearrange:function(t,e,i,s){i?i[0].appendChild(this.placeholder[0]):e.item[0].parentNode.insertBefore(this.placeholder[0],"down"===this.direction?e.item[0]:e.item[0].nextSibling),this.counter=this.counter?++this.counter:1;var o=this.counter;this._delay(function(){o===this.counter&&this.refreshPositions(!s)})},_clear:function(t,e){this.reverting=!1;var i,s=[];if(!this._noFinalSort&&this.currentItem.parent().length&&this.placeholder.before(this.currentItem),this._noFinalSort=null,this.helper[0]===this.currentItem[0]){for(i in this._storedCSS)"auto"!==this._storedCSS[i]&&"static"!==this._storedCSS[i]||(this._storedCSS[i]="");this.currentItem.css(this._storedCSS),this._removeClass(this.currentItem,"ui-sortable-helper")}else this.currentItem.show();function o(e,i,s){return function(t){s._trigger(e,t,i._uiHash(i))}}for(this.fromOutside&&!e&&s.push(function(t){this._trigger("receive",t,this._uiHash(this.fromOutside))}),!this.fromOutside&&this.domPosition.prev===this.currentItem.prev().not(".ui-sortable-helper")[0]&&this.domPosition.parent===this.currentItem.parent()[0]||e||s.push(function(t){this._trigger("update",t,this._uiHash())}),this===this.currentContainer||e||(s.push(function(t){this._trigger("remove",t,this._uiHash())}),s.push(function(e){return function(t){e._trigger("receive",t,this._uiHash(this))}}.call(this,this.currentContainer)),s.push(function(e){return function(t){e._trigger("update",t,this._uiHash(this))}}.call(this,this.currentContainer))),i=this.containers.length-1;0<=i;i--)e||s.push(o("deactivate",this,this.containers[i])),this.containers[i].containerCache.over&&(s.push(o("out",this,this.containers[i])),this.containers[i].containerCache.over=0);if(this.storedCursor&&(this.document.find("body").css("cursor",this.storedCursor),this.storedStylesheet.remove()),this._storedOpacity&&this.helper.css("opacity",this._storedOpacity),this._storedZIndex&&this.helper.css("zIndex","auto"===this._storedZIndex?"":this._storedZIndex),this.dragging=!1,e||this._trigger("beforeStop",t,this._uiHash()),this.placeholder[0].parentNode.removeChild(this.placeholder[0]),this.cancelHelperRemoval||(this.helper[0]!==this.currentItem[0]&&this.helper.remove(),this.helper=null),!e){for(i=0;i<s.length;i++)s[i].call(this,t);this._trigger("stop",t,this._uiHash())}return this.fromOutside=!1,!this.cancelHelperRemoval},_trigger:function(){!1===u.Widget.prototype._trigger.apply(this,arguments)&&this.cancel()},_uiHash:function(t){var e=t||this;return{helper:e.helper,placeholder:e.placeholder||u([]),position:e.position,originalPosition:e.originalPosition,offset:e.positionAbs,item:e.currentItem,sender:t?t.element:null}}})});
function gsurveySetUpLikertFields(){0<jQuery("table.gsurvey-likert").length&&(jQuery("table.gsurvey-likert").find('td.gsurvey-likert-choice, input[type="radio"]').click(function(e){var r=jQuery(this),i=r.is("td.gsurvey-likert-choice")?r.find("input"):r;if(i.is(":disabled"))return!1;i.prop("checked",!0),i.closest("tr").find(".gsurvey-likert-selected").removeClass("gsurvey-likert-selected"),i.parent().addClass("gsurvey-likert-selected"),i.focus().change()}),jQuery("table.gsurvey-likert td").hover(function(e){if(jQuery(e.target).is("td.gsurvey-likert-choice-label")||jQuery(this).find("input").is(":disabled"))return!1;jQuery(this).addClass("gsurvey-likert-hover")},function(e){if(jQuery(e.target).is("td.gsurvey-likert-choice-label")||jQuery(this).find("input").is(":disabled"))return!1;jQuery(this).removeClass("gsurvey-likert-hover")}),jQuery('table.gsurvey-likert input[type="radio"]').focus(function(){jQuery(this).parent().addClass("gsurvey-likert-focus")}).blur(function(){jQuery(this).parent().removeClass("gsurvey-likert-focus")}))}function gsurveyRankUpdateRank(e){var r=[];jQuery(e).find("li").each(function(){r.push(this.id)}),gsurveyRankings[e.id]=r,jQuery(e).parent().find("#"+e.id+"-hidden").val(gsurveyRankings[e.id])}function gsurveyRankMoveChoice(e,r,i){var t=jQuery(e).attr("id"),s=gsurveyRankings[t][r];gsurveyRankings[t].splice(r,1),gsurveyRankings[t].splice(i,0,s),gsurveyRankUpdateRank(e)}function gsurveySetUpRankSortable(){var e=jQuery(".gsurvey-rank");0<e.length&&(e.sortable({axis:"y",cursor:"move",update:function(e,r){gsurveyRankMoveChoice(this,r.item.data("index"),r.item.index())}}),gsurveyRankings={},jQuery(".gsurvey-rank").each(function(){gsurveyRankUpdateRank(this)}))}function init_fields(){gsurveySetUpRankSortable(),gsurveySetUpLikertFields()}jQuery(document).on("gform_post_render",function(){init_fields()}),jQuery(function(e){e("#gform_update_button").length&&init_fields()});
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
;(function($){$(document).ready(function(){$('body').on('click','.tmm_more_info',function(){$(this).find(".tmm_comp_text").slideToggle(100)});function tmm_equalize(){$('.tmm_textblock').css({'padding-bottom':'10px'});$('.tmm_scblock').each(function(i,val){if($(this).html().length>0){$(this).closest('.tmm_textblock').css({'padding-bottom':'65px'})}});$('.tmm_container').each(function(){if($(this).hasClass('tmm-equalizer')){var current_container=$(this);var members=[];var tabletCount=0;var tabletArray=[];var memberOne;var memberOneHeight;var memberTwo;var memberTwoHeight;current_container.find('.tmm_member').each(function(){tabletCount++;var current_member=$(this);current_member.css({'min-height':0});members.push(current_member.outerHeight());if(tabletCount==1){memberOne=current_member;memberOneHeight=memberOne.outerHeight()}else if(tabletCount==2){tabletCount=0;memberTwo=current_member;memberTwoHeight=memberTwo.outerHeight();if(memberOneHeight>=memberTwoHeight){tabletArray.push({memberOne:memberOne,memberTwo:memberTwo,height:memberOneHeight})}else{tabletArray.push({memberOne:memberOne,memberTwo:memberTwo,height:memberTwoHeight})}}});if(parseInt($(window).width())>1026){biggestMember=Math.max.apply(Math,members);current_container.find('.tmm_member').css('min-height',biggestMember)}else if(parseInt($(window).width())>640){$.each(tabletArray,function(index,value){$(value.memberOne).css('min-height',value.height);$(value.memberTwo).css('min-height',value.height)})}else{current_container.find('.tmm_member').css('min-height','auto')}}})}
function debounce(func,wait,immediate){var timeout;return function(){var context=this,args=arguments;var later=function(){timeout=null;if(!immediate)func.apply(context,args)};var callNow=immediate&&!timeout;clearTimeout(timeout);timeout=setTimeout(later,wait);if(callNow)func.apply(context,args)}};tmm_equalize();$(window).on("load",function(){tmm_equalize()});$(window).resize(debounce(function(){tmm_equalize()},100))})})(jQuery);