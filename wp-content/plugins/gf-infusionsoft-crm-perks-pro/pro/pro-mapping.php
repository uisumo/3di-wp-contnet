<?php 
// Exit if accessed directly
if( !defined( 'ABSPATH' ) ) exit;
 if(in_array($module,array('Contact','Company'))){
?>
<div class="vx_div vx_refresh_panel">    
      <div class="vx_head ">
<div class="crm_head_div"> <?php echo sprintf(__('%s. Assign Tag',  'gravity-forms-infusionsoft-crm' ),++$panel_count); ?></div>
<div class="crm_btn_div"><i class="fa crm_toggle_btn fa-minus" title="<?php esc_html_e('Expand / Collapse','gravity-forms-infusionsoft-crm') ?>"></i></div>
<div class="crm_clear"></div> 
  </div>                 
    <div class="vx_group ">
   <div class="vx_row"> 
   <div class="vx_col1"> 
  <label><?php esc_html_e('Assign Tag ', 'gravity-forms-infusionsoft-crm'); gform_tooltip('vx_tag_check');?></label>
  </div>
  <div class="vx_col2">
  <input type="checkbox" style="margin-top: 0px;" id="crm_tag" class="crm_toggle_check <?php if(empty($tags)){echo 'vx_refresh_btn';} ?>" name="meta[tag_check]" value="1" <?php echo !empty($meta['tag_check']) ? "checked='checked'" : ""?> autocomplete="off"/>
    <label for="crm_tag"><?php esc_html_e("Enable", 'gravity-forms-infusionsoft-crm'); ?></label>
  </div>
<div class="clear"></div>
</div>
    <div id="crm_tag_div" style="<?php echo empty($meta['tag_check']) ? "display:none" : ""?>">
  <div class="vx_row">
  <div class="vx_col1">
  <label><?php esc_html_e('Tags List ','gravity-forms-infusionsoft-crm'); gform_tooltip('vx_tags'); ?></label>
  </div>
  <div class="vx_col2">
  <button class="button vx_refresh_data" data-id="refresh_tags" type="button" autocomplete="off" style="vertical-align: baseline;">
  <span class="reg_ok"><i class="fa fa-refresh"></i> <?php esc_html_e('Refresh Data','gravity-forms-infusionsoft-crm') ?></span>
  <span class="reg_proc"><i class="fa fa-refresh fa-spin"></i> <?php esc_html_e('Refreshing...','gravity-forms-infusionsoft-crm') ?></span>
  </button>
  </div> 
   <div class="clear"></div>
  </div> 

  <div class="vx_row">
   <div class="vx_col1">
  <label for="crm_sel_tag"><?php esc_html_e('Select Tag ','gravity-forms-infusionsoft-crm'); gform_tooltip('vx_sel_tag'); ?></label>
</div> 

<div class="vx_col2 vx_tags">
<?php
$tags=array(array(array('field'=>'','op'=>'is','value'=>'')) );
if(!empty($meta['tags'])){ $tags=$meta['tags']; }
  $sno=0; 
  foreach($tags as $filter_k=>$filter_v){
  $sno++;
  $tags_db=!empty($meta['tag_ids'][$filter_k]) ? $meta['tag_ids'][$filter_k] : array();
  ?>
  <div class="vx_filter_or" data-id="<?php echo $filter_k ?>" data-filter="tags">
  
   <select class="crm_sel2 vx_tags_sel" name="meta[tag_ids][<?php echo $filter_k ?>][]" multiple="multiple" style="width: 100%;" autocomplete="off">
  <?php echo $this->gen_select($tags_list,$tags_db); ?>
  </select>

  <div class="vx_filter_div">
  <div style="padding-bottom: 10px;">  <b><?php esc_html_e('Apply tags if ','gravity-forms-infusionsoft-crm') ?></b> </div>
  <?php 
  if(is_array($filter_v)){
  $sno_i=0;
  foreach($filter_v as $s_k=>$s_v){ $s_k=esc_attr($s_k);   
  $sno_i++;
  ?>
  <div class="vx_filter_and">
  <?php if($sno_i>1){ ?>
  <div class="vx_filter_label">
  <?php esc_html_e('AND','gravity-forms-infusionsoft-crm') ?>
  </div>
  <?php } ?>
  <div class="vx_filter_field vx_filter_field1">
  <select id="crm_optin_field" name="meta[tags][<?php echo $filter_k ?>][<?php echo $s_k ?>][field]" class='optin_select_filter'>
  <?php 
  echo $this->gf_fields_options($form_id,$this->post('field',$s_v));
                ?>
  </select>
  </div>
  <div class="vx_filter_field vx_filter_field2">
  <select name="meta[tags][<?php echo $filter_k ?>][<?php echo $s_k ?>][op]" >
  <option></option>
  <?php
                 foreach($vx_op as $k=>$v){
  $sel="";
  if($this->post('op',$s_v) == $k)
  $sel='selected="selected"';
                   echo "<option value='".esc_attr($k)."' $sel >".esc_html($v)."</option>";
               } 
              ?>
  </select>
  </div>
  <div class="vx_filter_field vx_filter_field3">
  <input type="text" class="vxc_filter_text" placeholder="<?php esc_html_e('Value','gravity-forms-infusionsoft-crm') ?>" value="<?php $t_val=$this->post('value',$s_v); echo esc_attr($t_val);  ?>" name="meta[tags][<?php echo $filter_k ?>][<?php echo $s_k ?>][value]">
  </div>
  <?php if( $sno_i>1){ ?>
  <div class="vx_filter_field vx_filter_field4"><i class="vx_icons-h vx_trash_and vxc_tips fa fa-trash-o" data-tip="Delete"></i></div>
  <?php } ?>
  <div style="clear: both;"></div>
  </div>
  <?php
  } }
                     ?>
  <div class="vx_btn_div">
  <button class="button button-default button-small vx_add_and" title="<?php esc_html_e('Add AND Filter','gravity-forms-infusionsoft-crm'); ?>"><i class="vx_icons-s vx_trash_and fa fa-hand-o-right"></i>
  <?php esc_html_e('Add AND Filter','gravity-forms-infusionsoft-crm') ?>
  </button>
  <?php if($sno>1){ ?>
  <a href="#" class="vx_trash_or">
  <?php esc_html_e('Trash','gravity-forms-infusionsoft-crm') ?>
  </a>
  <?php } ?>
  </div>
  </div>
  </div>
<?php } ?>
  
    <div class="vx_btn_div">
  <button class="button button-default vx_add_or" id="vx_add_tag" data-filter="tags" title="<?php esc_html_e('Add New Tag','gravity-forms-infusionsoft-crm'); ?>"><i class="vx_icons vx_trash_and fa fa-check"></i>
  <?php esc_html_e('Add New Tag','gravity-forms-infusionsoft-crm') ?>
  </button>
  </div>
   </div>

   <div class="clear"></div>
   </div>
 

<script type="text/javascript">
jQuery(document).ready(function(){
jQuery('.vx_tags_sel').select2({ placeholder: '<?php esc_html_e('Select Tags','gravity-forms-infusionsoft-crm') ?>'});
})
</script>
</div>
  

</div>
</div>
 
<style type="text/css">
.vx_tags .vx_filter_div{
    margin-top: 10px;
}
.vx_tags .vx_filter_or:not(:first-child){
    margin-top: 20px;
    padding-top: 20px;
    border-top: 2px dashed #ddd;
}
</style>
<?php
 }
?>