
var Main = { 
    template: document.getElementById("payplan-show").innerHTML,
    created: function() {
        this.get_payplans();
    },
    methods: {
        get_payplans: function() {
          var vm = this;
          this.loading = true;
          jQuery.getJSON(iw_admin_ajax,{action:'iw_get_payplans'}, function(data) {
            if(data.success) {
                vm.payplans = data.payplans; 
                vm.loading = false;
            }
          });
          
        },
        activate_payplan: function(ind, id) {
            this.payplans[ind].status = 'enabled';
            jQuery.get(iw_admin_ajax, {action: 'iw_activate_payplan', id: id});
        },
        deactivate_payplan: function(ind, id) {
            this.payplans[ind].status = 'disabled';
            jQuery.get(iw_admin_ajax, {action: 'iw_disable_payplan', id: id});
        },
        clone_payplan: function(ind,id) {
            this.payplans[ind].cloning = true;
            this.loading = true;
            var vm = this;

            jQuery.get(iw_admin_ajax, {action: 'iw_clone_payplan', id: id}, function(data) {
                vm.get_payplans();
            });
        },
        delete_payplan: function(ind, id) {
            var thiscomp = this;


            swal({   
                title: "Confirm deletion",   
                text: "Please confirm if you want to delete this payplan",   
                type: "warning",   
                showCancelButton: true,   
                confirmButtonColor: "#DD6B55",   
                confirmButtonText: "Yes, delete",   
                closeOnConfirm: false 
                }, 
                function() { 
                    jQuery.get(iw_admin_ajax, {action: 'iw_delete_payplan', id: id}, function(data) {

                    });
                    thiscomp.payplans.splice(ind,1); 
                    swal.close(); 
            });
        },
        reorder: function() {
            var ordering = {};
            for(var i=0; i < this.payplans.length; i++) {
                ordering[this.payplans[i].id] = i + 1;
            }

            jQuery.get(iw_admin_ajax, {action: 'iw_reorder_payplans', order: ordering});
        }
    },
    data: function() {
        return {
            payplans: [],
            loading: false,
            search: ''
        }
    }
}

var Condition = { 
    template: document.getElementById("condition-block").innerHTML,
    props: ['conditionSet','withOr','value'],
    created: function() {
    },
    methods: {
        changed_condition: function() {
            this.form_html = (this.value.form_html && this.value.condition == this.condition) ? 
                            this.value.form_html : 
                            this.conditionSet[this.condition].html; 

            this.value.form_html = this.form_html;
            this.value.condition = this.condition;
        },
        formchange: function(e=false) {
            console.log($target);
            var $target = e ? e.currentTarget : (this.$refs.form ? this.$refs.form : false);
            if(!$target) return false;

            var cond_config = jQuery($target).serializeArray();
            var config_data = {};

            for(var j = 0; j < cond_config.length; j++) {
                var config_name = cond_config[j].name;
                if(config_name.indexOf("[]") !== -1) {
                    config_name = config_name.replace('[]','');
                    if(!config_data[config_name]) {
                        config_data[config_name] = [];
                    }                   
                    config_data[config_name].push(cond_config[j].value);
                } else {
                    config_data[config_name] = cond_config[j].value;
                }
            }

            this.data.config = config_data;
            this.data.form_html = $target.innerHTML;
            this.$emit('input',this.data);
            this.$emit('change');
        }
    },
    data: function() {
        return {
            condition: this.value.condition ? this.value.condition : '',
            form_html: this.value.form_html ? this.value.form_html : '',
            data: this.value
        };
    },
    updated: function() {
        this.$nextTick(function() {
            if(this.$refs.form) {
                jQuery(this.$refs.form).change();
            }
        });
    }
}

var Payplan = { 
    template: document.getElementById("payplan-edit").innerHTML,
    created: function() {
        this.get_payplan(this.$route.params.id)
    },
    methods: {
        get_payplan: function(id) {
            if(!id) {
                this.payplan = {
                    status: 'disabled', 
                    name: '',
                    daysbetweenpayments: '30',
                    financecharge: '0',
                    daysuntilcharge: '0',
                    daysbetweenrecharge: '2',
                    maxretries: '3',
                    conditions: [],
                    display: ''
                };
            } else {
                this.loading = true;
                var vm = this;
                jQuery.getJSON(iw_admin_ajax, {action: 'iw_get_payplan',id: id}, function(data) {
                    vm.payplan = data;
                    if(!data.conditions) vm.payplan.conditions = [];
                    vm.cond_grp = vm.payplan.conditions.length;
                    
                    var cond_id = 0;
                    for(var g; g < vm.payplan.conditions.length; g++) {
                        cond_id += vm.payplan.conditions[g].length;
                    }
                    vm.cond_id = cond_id;
                    vm.loading = false;
                });
            }
            


            // get_available_conditions
            var $holdthis = this;
            jQuery.getJSON(iw_admin_ajax, {action: 'payplan_conditions'}, function(data) {
                $holdthis.available_conds = data;
            });
        },
        add_condition: function(group=false) {
            if(group === false) {
                this.cond_grp = this.cond_grp + 1;
                this.cond_id = this.cond_id + 1;
                this.payplan.conditions.push( {
                    grp_id: this.cond_grp,
                    content: [{
                        id: this.cond_id,
                        condition: '',
                        form_html: '',
                        config: {}
                    }]
                } );
            } else {
                this.cond_id = this.cond_id + 1;
                this.payplan.conditions[group].content.push(
                    {
                        id: this.cond_id,
                        condition: '',
                        form_html: '',
                        config: {}
                    }
                );
            }
            
        },
        delete_condition: function(i,k) {
            this.$delete(this.payplan.conditions[i].content,k);
            if(this.payplan.conditions[i].content.length == 0) {
                this.$delete(this.payplan.conditions,i);
            }
        },
        save_payplan: function() {

            if(!this.payplan.name) {
                swal('Missing Info','Please enter payplan name.', 'warning');
                return false;
            }

            if(!this.payplan.numpayments) {
                swal('Missing Info','Please enter number of payments.', 'warning');
                return false;
            }

            // refresh condition values
            for(k in this.$refs) {
                if(this.$refs[k][0] && k.startsWith('condition-')) {
                    this.$refs[k][0].formchange();
                }
            }
            var vm = this;
            this.saving = true;

            jQuery.post(iw_admin_ajax + '?action=iw_save_payplan', this.payplan, function(data) {
                if(data.id) {
                    vm.payplan.id = data.id;
                    router.push('/');
                } else if(data.errors) {
                    error_msg = data.errors.join("\n");
                    swal('Error Saving Recipe', error_msg, 'error');
                } else {    

                }

                vm.saving = false;
            }, 'json');


        },
        simulate: function() {
            var vm = this;
            this.simulresult = 'Calculating...';
            var tosend = this.payplan;
            tosend.total = this.simultotal;
            jQuery.post(iw_admin_ajax+'?action=iw_simulate_payplan', tosend, function(data) {
                vm.simulresult = data.calculation;
            },'json');
        }
    },
    data: function() {
        return {
            payplan: {
                conditions: []
            },
            cond_id: 0,
            cond_grp: 0,
            advanced: false,
            available_conds: false,
            saving: false,
            loading: false,
            cond_show: false,
            simultotal: '',
            simulresult: ''
        }
    },
    updated: function() {
        if(this.payplan.daysbetweenpayments && this.payplan.numpayments) {
            var vm = this;
            jQuery.post(iw_admin_ajax+'?action=iw_simulate_payplan', this.payplan, function(data) {
                vm.payplan.display = data.display;
            },'json');
            
        }
    }
}


const routes = [
  { path: '/', component: Main },
  { path: '/new', component: Payplan, name: 'new' },
  { path: '/edit/:id', component: Payplan, name: 'edit' }
]

var router = new VueRouter({
  routes: routes
})

Vue.component('IWCondition', Condition);

var iw_payplan_app = new Vue({
  router
}).$mount('.iw-admin-payplan');

jQuery("body").on("change",".wptype-sel",function() {
    jQuery(this).parent().children(".iwar-minisection").hide();
    if(jQuery(this).val() == "specific") {
        jQuery(this).parent().children(".minisection-wooproducts").show();
    } else if(jQuery(this).val() == "category") {
        jQuery(this).parent().children(".minisection-categ").show();
    } else {
        jQuery(this).parent().children(".minisection-type").show();
    }
});