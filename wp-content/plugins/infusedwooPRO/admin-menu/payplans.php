<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

wp_enqueue_script('jquery-ui-autocomplete');
wp_enqueue_script('jquery-ui-datepicker');
wp_enqueue_script('jquery-ui-core');
wp_enqueue_script('jquery-ui-dialog');
wp_enqueue_style('jquery-style', 'https://ajax.googleapis.com/ajax/libs/jqueryui/1.8.2/themes/smoothness/jquery-ui.css');
wp_enqueue_style( 'iw_sweetalert', INFUSEDWOO_PRO_URL . "assets/sweetalert/sweetalert.css" );
wp_enqueue_script( 'iw_sweetalert', INFUSEDWOO_PRO_URL . "assets/sweetalert/sweetalert.min.js", array('jquery'));
wp_enqueue_script( 'iwar_chartjs', INFUSEDWOO_PRO_URL . "admin-menu/assets/Chart.min.js", array('iw_sweetalert'));
wp_enqueue_script( 'iw_automation_recipe', INFUSEDWOO_PRO_URL . "3.0/automation-recipes/automation_recipes.js", array('iw_sweetalert','iwar_chartjs','jquery-ui-datepicker','jquery-ui-autocomplete','jquery-ui-dialog'),'2.0');

$gateways = WC()->payment_gateways->get_available_payment_gateways();
$pgenabled = false;

if($gateways) foreach($gateways as $gateway) {
	if($gateway->id == 'infusionsoft_cc') {
		$pgenabled = $gateway->enabled == 'yes';
	}
}

?>

<style type="text/css">
    .drag {cursor: grabbing}
    .iw-plusor {
        background: #5f6994;
        color: white;
        font-size: 9pt;
        padding: 5px;
        width: 45px;
        text-align: center;
        display: block;
        margin: auto;
        border-radius: 5px 5px 5px 5px;
        -moz-border-radius: 5px 5px 5px 5px;
        -webkit-border-radius: 5px 5px 5px 5px;
        box-shadow: 0px 8px 15px rgba(0, 0, 0, 0.1);
        cursor: pointer;
    }
    .condition-group .autome-condition {
        margin: 0;
    }
    .router-link-active {
        text-decoration: none;
    }
    .autome-or-connect {
        background-color: #bbb;
        font-size: 9pt;
        height: 17px;
        display: block;
        color: white;
        /* padding: 0px 7px; */
        border-radius: 5px;
        margin-bottom: -17px;
        position: relative;
        width: 30px;
        text-align: center;
        top: -10px;
        left: 195px;
    }

    .autome-and-connect {
        position: relative;
        left: 190px;
    }

    .iw-add-condition-wrap .iw-add-condition {
        background: #5f6994;
        color: white;
        font-size: 9pt;
        padding: 5px;
        width: 45px;
        text-align: center;
        display: block;
        margin: auto;
        border-radius: 5px 5px 5px 5px;
        -moz-border-radius: 5px 5px 5px 5px;
        -webkit-border-radius: 5px 5px 5px 5px;
        box-shadow: 0px 8px 15px rgba(0, 0, 0, 0.1);
        cursor: pointer;

    }

    .iw-add-condition-wrap .autome-line {
        margin: auto;
        display: block;
        height: 15px;
        width: 1px;
        border-left: 1px solid  #bbb;
        position: relative;
        left: 5px;


    }

    .autome-and-connect .autome-line {
        height: 15px;
        width: 1px;
        border-left: 1px solid  #bbb;
        position: relative;
        left: 20px;

    }

    .autome-and-connect .and {
        background-color: #bbb;
        font-size: 9pt;
        height: 17px;
        display: block;
        color: white;
        /* padding: 0px 7px; */
        border-radius: 5px;
        position: relative;
        width: 40px;
        text-align: center;
    }

    .iw-plusor-wrap {
        background-color: #eee; padding: 5px 0px 8px;
        opacity: 0.8;
    }

    .condition-group .iw-plusor-wrap {
        display: none;
    }

    .condition-group:hover .iw-plusor-wrap {
        display: block;
    }
</style>

<?php if(!$pgenabled) { ?>
    <div style="color:red; margin: 20px 0; padding: 20px; border: 1px dashed #999;">Note: Payplans requires Infusionsoft Payment Gateway.
        Please enable Infusionsoft Payment Gateway first to use this feature of InfusedWoo. 

        <br><br><br>
        <center>
        <a href="<?php echo admin_url('admin.php?page=wc-settings&tab=checkout&section=infusionsoft_cc');?>">
        <div class="big-button">Configure Infusionsoft Gateway
        </div>
        </a>
        </center>
        <br>
    </div>
<?php } ?>

<div class="iw-admin-payplan">
    <router-view></router-view>
</div>

<script src="https://cdn.jsdelivr.net/npm/vue/dist/vue.js"></script>
<script src="//unpkg.com/vue-router@3.5.3/dist/vue-router.js"></script>
<script src="//cdn.jsdelivr.net/npm/sortablejs@1.7.0/Sortable.min.js"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/Vue.Draggable/2.17.0/vuedraggable.min.js"></script>


<script id="payplan-show" type="text/html">
    <div>
        <h1>Payplans</h1>
        <hr>
        
        <center v-if="!loading && payplans.length == 0">
            <br><br><br>
            <img src="https://s3.amazonaws.com/infusedaddons/screenshots/InfusedWooNinja_meditate.png" style="max-height: 200px;" />
            <br><br>
            <h3>
            No Payplans set up. Create one by clicking the button below.</h3>

            <router-link :to="{name: 'new'}">
                <div class="blue-button" style="">Create New Payplan</div>
            </router-link>
            </h3><br><br>
        </center>
        <div v-if="loading">
            <div class="progress">
                <div class="indeterminate"></div>
            </div>
        </div>

        <div class="autome-controls" v-if="payplans.length > 0">
				Search <input type="text" id="search_recipes" v-model="search" placeholder="Search Payplans..." />
			<router-link :to="{name: 'new'}">
				<div class="blue-button" style="float: right;">Create New Payplan</div><br>
			</router-link>
		</div>

        <draggable v-model="payplans"  @end="reorder" :options="{handle:'.drag'}">
        <div v-for="(payplan,i) in payplans" :key="i" class="iw-recipe-item" v-bind:class="{'iwar-recipe-disabled': payplan.status == 'disabled'}" v-if="!search || (search && payplan.name.toLowerCase().indexOf(search.toLowerCase()) >= 0)">
            <div class="recipe-item-top">
                <a href="#" class="drag" title="Drag to move up / down"><i style="float:right; font-size: 13pt;"  class="fa fa-ellipsis-v"></i></a>
                <div class="recipe-title">{{payplan.name}}</div>
            </div>
            <div class="recipe-item-controls">
                <router-link :to="{name: 'edit', params: { id: payplan.id }}"><div class="recipe-control"><i class="fa fa-pencil"></i> Edit</div></router-link>
                <div v-on:click="deactivate_payplan(i, payplan.id)" class="recipe-control" v-if="payplan.status == 'enabled'"><i class="fa fa-power-off"></i> Deactivate</div>
                <div v-on:click="activate_payplan(i, payplan.id)" class="recipe-control" v-if="payplan.status == 'disabled'"><i class="fa fa-power-off"></i> Activate</div>
                <div v-if="!payplan.cloning" v-on:click="clone_payplan(i,payplan.id)" class="recipe-control"><i class="fa fa-clone"></i> Clone</div>
                <span v-if="payplan.cloning"><i>Cloning ...</i></span>
                <div v-on:click="delete_payplan(i, payplan.id)" class="recipe-control" style="float: right; background-color: #de5f60;"><i class="fa fa-trash"></i> Delete</div>
            </div>
        </div>
        </draggable>
    </div>
</script>
<script id="payplan-edit" type="text/html">
    <div>
    <div v-if="loading">
        <div class="progress">
            <div class="indeterminate"></div>
        </div>
    </div>
    <div v-if="!loading">
    <br>
    <router-link to="/">
        <span class="dashicons dashicons-arrow-left-alt2" style="font-size: 17pt; margin-top: -2px;"></span> 
        <u>Go Back to List of Payplans</u>
    </router-link>
    <br><br>
    <hr>
    <br>
    <span class="step-head">
        {{!payplan.name ? 'New Payplan' : payplan.name}}
    </span> <span class="step-edit select-trigger-edit" style="display: none;">[<u>Edit</u>]</span><br>
        <div class="big-row">

                <input type="hidden" name="iwar-trigger" value="IW_UserConsent_Trigger" />
                <div class="trigger-set">
            </div><br>
            
             
            
            <br>
            <table>
                <tr>
                     <td style="padding-right: 30px;  min-width: 150px;">Payplan Name</td>
                     <td><input v-model="payplan.name" placeholder="e.g. 3 Monthly Payments" type="text" name="name" style="width: 200px;" /></td>
                </tr>
                


                <tr>
                     <td style="padding-right: 30px;  min-width: 150px;">Number of Payments</td>
                     <td><input v-model="payplan.numpayments" placeholder="1" type="number" name="numpayments" style="width: 50px;" /></td>
                </tr>
                <tr>
                    <td>Days Between Payments</td>
                    <td><input v-model="payplan.daysbetweenpayments" placeholder="30" name="daysbetweenpayments" type="text" style="width: 50px;" /></td>
                </tr>

                <tr>
                    <td valign="top">Finance Charge</td>
                    <td><input placeholder="30" v-model="payplan.financecharge" type="text" name="financecharge" style="width: 150px;" />
                        <br><small>E.g. 10% if percentage of subtotal, or enter 10 if in fixed <?php echo get_woocommerce_currency() ?></small>
                    </td>
                </tr>
                <tr v-if="">
                    <td valign="top">Sign-up Fee</td>
                    <td><input placeholder="0" v-model="payplan.signupfee" type="text" name="singupfee" style="width: 150px;" />
                        
                    </td>
                </tr>
                <tr>
                    <td>Number of Trial Days</td>
                    <td><input v-model="payplan.trialdays" placeholder="0" name="trialdays" type="text" name="recipe-title" style="width: 50px;" /></td>
                </tr>
               
                
                
                <tr v-if="!advanced">
                    <td  valign="top">Advanced Options</td>
                    <td><a style="cursor:pointer;" v-on:click="advanced = 1">(Click to Expand)</a>
                    </td>
                </tr>
                <tr v-if="advanced">
                     <td valign="top" style="padding-right: 30px; padding-top: 3px;  min-width: 150px;">Payplan Display Title</td>
                     <td><input v-model="payplan.display_custom" type="text" name="name" style="width: 200px;" />
                        <br><small>Leave empty to display default: "<span v-html="payplan.display"></span>"</small>
                     </td>
                </tr>

                <tr v-if="advanced">
                    <td>Days between recharge attempts</td>
                    <td><input placeholder="2" v-model="payplan.daysbetweenrecharge" type="number" name="daysbetweenrecharge" style="width: 50px;" /></td>
                    </td>
                </tr>
                <tr v-if="advanced">
                    <td>Max Retries</td>
                    <td><input placeholder="3" v-model="payplan.maxretries" type="number" name="maxretries" style="width: 50px;" /></td>
                    </td>
                </tr>
                <tr><td colspan=2>&nbsp;</td></tr>
                <tr v-if="advanced">
                    <td valign="top">Merchant Gateway ID</td>
                    <td><input placeholder="" v-model="payplan.gatewayid" type="number" name="gatewayid" style="width: 50px;" />
                    <br><small>Leave this empty if you want to use the same merchant gateway set up in Infusionsoft Payment Gateway</small>
                    </td>
                </tr>

                
                <tr v-if="available_conds">
                    <td valign="top"><b>Conditions</b></td>
                    <td v-if="!cond_show">
                        <a style="cursor:pointer;" v-on:click="cond_show=1" >(Click to Expand)</a>
                        <br><small>Only show this payplan when certain conditions are met </small>
                    </td>
                </tr>
                <tr v-if="available_conds && cond_show" ><td colspan=2>
                    <div class="conditions">
                        <div class="condition-group" v-for="(condgroup,i) in payplan.conditions" 
                            :key="'condgroup-' + condgroup.grp_id">
                            <div class="autome-and-connect" v-if="i > 0">
                                <div class="autome-line"></div>
                                <div class="and">AND</div>
                                <div class="autome-line"></div>
                            </div>
                            <IWCondition 
                                v-for="(cond,k) in condgroup.content" 
                                v-model="payplan.conditions[i].content[k]" 
                                :condition-set="available_conds" 
                                :with-or="k < (condgroup.content.length - 1) ? 1 : 0"
                                v-on:add-condition="add_condition(i)"
                                v-on:deleted="delete_condition(i,k)"
                                :key="'cond-'+cond.id"
                                :ref="'condition-'+cond.id"
                                />

                        </div>
                    </div>
                     <div class="iw-add-condition-wrap" v-if="payplan.conditions && payplan.conditions.length > 0 " @click="add_condition()">
                        <div class="autome-line"></div>
                        <div class="iw-add-condition">+ AND</div>
                    </div>
                    <div class="blue-button iwar-add-condition" v-if="!payplan.conditions || payplan.conditions.length < 1" @click="add_condition()">
                        <i class="fa fa-plus"></i> Add Condition
                    </div>
                    <br><br>
                    </td>
                </tr>

                <tr>
                    <td valign="top"><b>Simulate Payplan</b></td>
                    <td>
                        
                            <input type="number" v-model="simultotal" @change="simulate" style="width: 130px;" placeholder="Order Total" />
                        <br><small v-if="!simultotal">Enter a sample order total to simulate the payments</small>
                        <small v-if="simultotal" v-html="simulresult"></small>
                    </td>
                </tr>
                

                <tr>

                    <td colspan="2">
                        <hr>
                        <br>
                        <div class="ui-toggle" :key="payplan.status == 'enabled' ? 'payplan-enabled' : 'payplan-switch'"
                            @click="payplan.status = payplan.status == 'enabled' ? 'disabled' : 'enabled' "
                            v-bind:class="{'checked': payplan.status == 'enabled'}" 
                            name="ia_saveOrders">
                            <div class="slider"></div>
                            <div class="check"><i class="fa fa-check"></i></div>
                            <div class="ex"><i class="fa fa-times"></i></div>
                        </div>
    
                        <span style="margin-left: 10px;">Enable Payplan</span>
                        <br><br><br>
                        <center>
                         <div  v-if="!saving" class="green-button big-button iwar-save-payplan" @click="save_payplan" >
                             Save Payplan
                        </div>
                        </center>
                    </td>
                </tr>
                
            </table>


           
        </div>


    </div>
    </div>
</script>
<script id="condition-block" type="text/html">
    <div>
        <div class="autome-condition" style="border-bottom: 1px solid #ddd;">
            <div class="autome-remove"><i class="fa fa-times" @click="$emit('deleted')"></i></div>
            <div style="padding: 20px 10px;">
                <select v-model="condition" class="browser-default" v-on:change="changed_condition" style="width: 100%">
                    <option value="">Select a condition ...</option>
                    <option v-for="(cond,key) in conditionSet" :value="key">{{cond.title}}</option>
                </select>
                <form v-if="form_html" ref="form" v-on:change="formchange" v-html="form_html" style="margin-top: 10px;">
                </form>
            </div>
        </div>
        <div class="autome-or-connect" v-if="withOr">OR</div>
         <div class="iw-plusor-wrap" v-if="!withOr && condition" @click="$emit('add-condition')">
            <div class="iw-plusor">+ OR</div>
        </div>
    </div>
</script>
<script>
    var iw_admin_ajax = '<?php echo admin_url('admin-ajax.php') ?>';
</script>
<script src="<?php echo INFUSEDWOO_PRO_URL . '3.0/payplans/admin.js' ?>?ver=<?php echo filemtime(INFUSEDWOO_PRO_DIR . '3.0/payplans/admin.js') ?>"></script>




<div id="merge_dialog" class="iw-jq-modal iw-tag-dialog-modal" title="Insert Merge Field">
    <form>
    <table>
        <tr>
          <td><label for="name">Merge Type</label></td>
          <td class="merge-type-contain"><i>Loading...</i></td>
       
        </tr>
        <tr>
          <td><label for="email">Merge Field</label></td>
          <td class="merge-field-contain"><i>Loading...</i></td>
         </tr>
         <tr>
            <td colspan="2"><a href="#" class="adv-mrg" style="font-size: 10pt;">Advanced Options</a></td>
         </tr>
         <tr class="iwar-adv-merge" display: none;>
            <td colspan="2">
                <hr>
                <label for="email">Fallback</label><br>
                <input type="text" value="" class="merge-fallback" placeholder="Enter default value..." style="margin-top: 5px;"/>
                <br><span class="lil-info">This is the default value that will be returned in the event that the merge field value is empty</span>
            </td>
         </tr>
     </table>
    </form>
</div>

<div id="tag_dialog" class="iw-jq-modal iw-tag-dialog-modal" title="Add New Infusionsoft Tag">
            <form>
            <table>
                <tr>
                  <td><label for="name">Tag Name</label></td>
                  <td><input type="text" name="tag_name" id="name" placeholder="Enter Tag Name..."></td>
               
                </tr>
                <tr>
                  <td><label for="email">Tag Category</label></td>
                  <td>
                    <select name="tag_category_id" class="browser-default">
                        <option value="0">(No Category)</option>
                        <?php if($iwpro->ia_app_connect()) { 
                                $tag_cats = $iwpro->app->dsFind('ContactGroupCategory', 1000,0, 'Id', '%', array('Id','CategoryName'));

                                foreach($tag_cats as $cat) {
                                    echo '<option value="'.$cat['Id'].'">'.$cat['CategoryName'].'</option>';
                                }
                            ?>

                        <?php } ?>
                        <option value="new">(Add New Category)</option>

                    </select>
                    <input type="text" name="tag_category" id="category" style="display:none" placeholder="Type to Search Category"></td>
                 </tr>
             </table>
            </form>
        </div>
        <script>
            jQuery(document).ready(function() {
                tag_dialog = jQuery("#tag_dialog").dialog({
                  autoOpen: false,
                  height: 220,
                  width: 430,
                  modal: true,
                  buttons: {
                    Cancel: function() {
                      tag_dialog.dialog( "close" );
                    },
                    "Add Tag": proc_infusion_add_tag,
                    
                  },
                  close: function() {
                    jQuery("#tag_dialog form")[0].reset();
                    jQuery('[name=tag_category]').hide();
                    jQuery('[name=tag_category_id]').show();

                  }
                });
            });

            jQuery("[name=tag_category_id]").change(function() {
                if(jQuery(this).val() == 'new') {
                    jQuery(this).hide();
                    jQuery('[name=tag_category]').show();
                }
            });

            infusion_add_new_tag = function(item, $el) {
                last_tag_dialog_el = $el;
                last_tag_dialog_itm = item;
                jQuery("#tag_dialog [name=tag_name]").val(item.value);
                tag_dialog.dialog('open');
            };

            proc_infusion_add_tag = function() {
                var tag_name = jQuery("#tag_dialog [name=tag_name]").val();
                var cat_id = jQuery("#tag_dialog [name=tag_category_id]").val();
                var cat_name = jQuery("#tag_dialog [name=tag_category]").val();
                iwar['infusion_tags_cache'] = {}; 

                if(tag_name == "") {
                    jQuery("#tag_dialog [name=tag_name]").addClass('ui-state-error');
                } else {
                    swal({title: "Adding tag...",   text: "Please wait while we add the new tag", showConfirmButton: false });
                    jQuery.post(ajaxurl+"?action=iwar_add_new_tag", {tag_name: tag_name, tag_category_id: cat_id, tag_category: cat_name}, function(data) {
                        if(data.id) {
                                var search_name = last_tag_dialog_el.attr('name');
                                var append_new = '<span class="'+search_name+'-item">';
                                append_new += data.name;
                                append_new += '<input type="hidden" name="'+search_name+'-val[]" value="'+data.id+'" />';
                                append_new += '<input type="hidden" name="'+search_name+'-label[]" value="'+data.name+'" />';
                                append_new += '<i class="fa fa-times-circle"></i>';
                                append_new += '</span>';
                                swal.close();
                                last_tag_dialog_el.parent().find("."+search_name+"-contain").append(append_new)
                        } else {
                             swal("Error", "There was an error when adding tag. Please try again later or add tag manually inside infusionsoft.", "error");
                        }
                    }, 'json');
                    tag_dialog.dialog( "close" );
                }
            }
        </script>

















