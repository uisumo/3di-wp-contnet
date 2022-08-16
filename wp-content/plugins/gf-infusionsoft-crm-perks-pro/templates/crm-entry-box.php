<?php
if ( ! defined( 'ABSPATH' ) ) {
     exit;
 }                                            
 ?><style type="text/css">
.vx_msg_div a{
    color: #fff;
}
.vx_msg_div a:hover{
    color: #eee;
    text-decoration: none;
}
</style>
<div class="postbox">
<h3 style="border-bottom: 1px solid #ddd;"><?php esc_html_e("Infusionsoft", 'gravity-forms-infusionsoft-crm') ?></h3>
<div class="inside">

<?php

               $comments=false; 
  if( is_array($log) && count($log)>0){
      $comments=true;
      $log=$this->verify_log($log); 
$msg=!empty($log['meta']) ? $log['meta'] : $log['desc'];
if(!empty($log['status'])  && !empty($log['crm_id']) ){
    $msg.=' '.$log['a_link'];
}
$st=empty($log['status']) ? '0' : $log['status'];
$icons=array('0'=>array('color'=>'#DC513B','icon'=>'fa-warning'),'4'=>array('color'=>'#3897C3','icon'=>'fa-filter'),
'2'=>array('color'=>'#d5962c','icon'=>'fa-edit'),'5'=>array('color'=>'#DC513B','icon'=>'fa-times'));

$bg='#83B131'; $icon='fa-check';
if(isset($icons[$st])){
  $bg=$icons[$st]['color'];  
  $icon=$icons[$st]['icon'];  
}
echo '<p style="background: '.$bg.'; padding: 10px; color: #fff " class="vx_msg_div"><i class="fa '.$icon.'"></i> '.wp_kses_post($msg).'</p>';
  }
  if(isset($_GET['vx_debug'])){
  ?>
  <input type="hidden" name="vx_debug" value="<?php echo esc_attr($this->post('vx_debug')) ?>">
  <?php
  }
  ?>
  <p>
  <button class="button" type="submit" name="<?php echo $this->id ?>_send" value="yes" title="<?php esc_html_e("Send to Infusionsoft",'gravity-forms-infusionsoft-crm')?>"><?php esc_html_e("Send to Infusionsoft",'gravity-forms-infusionsoft-crm')?></button>
  <?php
      if($comments ){
  ?>
    <a class="button button-secondary" title="<?php esc_html_e('Go to Logs','gravity-forms-infusionsoft-crm') ?>" href="<?php echo esc_url($log_url) ?>"><?php esc_html_e('Go to Logs','gravity-forms-infusionsoft-crm') ?></a>
  <?php
      }
  ?>
  </p>
  
 </div>
</div>