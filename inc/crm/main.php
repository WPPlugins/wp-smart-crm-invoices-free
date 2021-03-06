<?php if ( ! defined( 'ABSPATH' ) ) exit;
is_multisite() ? $filter=get_blog_option(get_current_blog_id(), 'active_plugins' ) : $filter=get_option('active_plugins' );
if ( in_array( 'wp-smart-crm-advanced/wp-smart-crm-advanced.php', apply_filters( 'active_plugins', $filter) ) ) {
		$p="dashboard-scheduler.php";
	}
	else{
		$p="dashboard.php";
	}
?>
<div class="wrap">

<h1 style="text-align:center">WP Smart CRM & INVOICES<?php if(! isset($_GET['p'])){ ?><?php } ?></h1>
		<?php include("c_menu.php")?>
	<?php
    if(isset($_GET['p']))
		$p=$_GET['p'];

    include(plugin_dir_path(__FILE__ ))."$p";
    echo '<small style="text-align:center;top:30px;position:relative">Developed by SoftradeWEB snc <a href="https://softrade.it">https://softrade.it</a> [WP italian coders]. ' . __('Like this Plugin? A good Review is very much appreciated!','WPsmartcrm').'<a href="https://wordpress.org/support/plugin/wp-smart-crm-invoices-free/reviews/?filter=5" target="_blank"><span class="dashicons dashicons-star-filled" style="font-size:1em;margin-right:-6px;margin-top:4px"></span><span class="dashicons dashicons-star-filled" style="font-size:1em;margin-right:-6px;margin-top:4px"></span><span class="dashicons dashicons-star-filled" style="font-size:1em;margin-right:-6px;margin-top:4px"></span><span class="dashicons dashicons-star-filled" style="font-size:1em;margin-right:-6px;margin-top:4px"></span><span class="dashicons dashicons-star-filled" style="font-size:1em;margin-right:-6px;margin-top:4px"></span></a>  </small>';
	?>
	<div id="mouse_loader" style="display:none;position:absolute;width:30px;height:30px;border:1px solid #ccc;background:#fff url('<?php echo WPsCRM_URL?>css/img/ajax-loader.gif');background-position:center center;border-radius:4px;background-repeat:no-repeat;z-index:10004"></div>
	<div id="dialog_interessi"></div>
	<?php do_action('WPsCRM_css');?>
</div>

<!--CUSTOM POPUP EDITOR TEMPLATE-->
<script type="text/x-kendo-template" id="customEditor" style="width:940px">
    <div class="col-md-12">
        <label class="col-md-1" for="Title"><?php _e('Title','WPsmartcrm') ?></label>
        <div data-container-for="title" class="col-md-3">
            <input class="k-textbox" data-bind="value:title" name="Title" type="text" required="required" />
        </div>
		<label class="col-md-1">Cliente</label>
		#var id_cliente; console.log(id_cliente)#
		
        <div data-container-for="customers" class="col-md-3">
            <select id="customers" name="customers"
                    data-bind="value:id_cliente"
                    data-source="customersDatasource"
                    data-text-field="ragione_sociale"
                    data-value-field="ID_clienti"
                    data-role="dropdownlist" 
                    data-option-label="Select"
				    required="required"
					#if(id_cliente!=undefined){# readonly #}#/>
        </div>
    </div>
    <div class="k-edit-label">
        <label for="Start"><?php _e('Start','WPsmartcrm') ?></label>
    </div>
    <div data-container-for="start" class="k-edit-field">
        <input name="start" required="required" style="z-index: inherit;" type="datetime"
               data-bind="value:start,invisible:isAllDay"
               data-format="M/d/yyyy h:mm tt"
               data-role="datetimepicker" />

        <input name="start" required="required" type="date" style="z-index: inherit;"
               data-bind="value:start,visible:isAllDay"
               data-format="M/d/yyyy"
               data-role="datepicker" />

        <span data-bind="text: startTimezone"></span>
        <span data-for="start" class="k-invalid-msg"></span>
    </div>

    <div class="k-edit-label">
        <label for="End"><?php _e('End','WPsmartcrm') ?></label>
    </div>
    <div data-container-for="end" class="k-edit-field">

        <input name="end" required="required" style="z-index: inherit;" type="datetime"
               data-bind="value:end,invisible:isAllDay"
               data-format="M/d/yyyy h:mm tt"
               data-role="datetimepicker" />

        <input name="end" required="required" type="date" style="z-index: inherit;"
               data-bind="value:end,visible:isAllDay"
               data-format="M/d/yyyy"
               data-role="datepicker" />

        <span data-bind="text: endTimezone"></span>
        <span data-for="end" class="k-invalid-msg"></span>
    </div>

    <div class="k-edit-label">
        <label for="description"><?php _e('Description','WPsmartcrm') ?></label>
    </div>
    <div data-container-for="description" class="k-edit-field">
        <textarea class="k-textbox" cols="20" data-bind="value:description" data-role="editor" id="description" name="description" rows="2"></textarea>
    </div>

    <div class="k-edit-label">
        <label for="status"><?php _e('Status','WPsmartcrm') ?></label>
    </div>
    <div data-container-for="status" class="k-edit-field">
        <label style="float:left;width:30%"><?php _e('To be done','WPsmartcrm') ?><input type="radio" name="status" value="1" data-bind="checked:status" />
        </label>
        <label style="float:left;width:30%"><?php _e('Done','WPsmartcrm') ?><input type="radio" name="status" value="2" data-bind="checked:status" />
        </label>
        <label style="float:left;width:30%"><?php _e('Canceled','WPsmartcrm') ?><input type="radio" name="status" value="3" data-bind="checked:status" />
        </label>
    </div>

    <div class="k-edit-label">
        <label for="esito"><?php _e('Result','WPsmartcrm') ?></label>
    </div>
    <div data-container-for="esito" class="k-edit-field">
        <textarea class="k-textbox" cols="20" data-bind="value:esito" id="esito" name="esito" rows="2"></textarea>
    </div>

<!--Rules-->

	<div class="col-md-12 _ruleRow">
        <div class="col-md-2">
            <label for="rulestep"><?php _e('Days in advance','WPsmartcrm') ?>:</label>
        </div>
        <div data-container-for="rulestep" class="col-md-1">
            <select class="form-control _m ruleActions k-dropdown _flat" id="ruleStep" name="ruleStep" data-bind="value:rulestep">
                <option value=""><?php _e( 'Select', 'WPsmartcrm' ); ?></option><?php for($k=0;$k<61;$k++){echo '<option value="'.$k.'">'.$k.'</option>'.PHP_EOL; } ?>
            </select>
        </div>
        <div data-container-for="remind_to_customer" class="col-md-3">
            <label style="float:left;"><?php _e('Send mail to customer','WPsmartcrm') ?><input type="checkbox" name="remindToCustomer" id="remindToCustomer" data-bind="checked:remind_to_customer" />
            </label>
        </div>
        <div data-container-for="mail_to_recipients" class="col-md-4">
            <label style="float:left;"><?php _e('Send mail to selected Accounts','WPsmartcrm') ?><input type="checkbox" name="mailToRecipients" id="mailToRecipients" data-bind="checked:mail_to_recipients" />
            </label>
        </div>
	</div>

	<div class="col-md-12">
        <div class="k-edit-label">
            <label for="users"><?php _e('Notify to users','WPsmartcrm') ?>:</label>
        </div>
        <div data-container-for="users" class="k-edit-field">
            <select id="users" name="users"
                    data-bind="value:users"
                    data-source="agentsDatasource"
                    data-text-field="display_name"
                    data-value-field="ID"
                    data-option-label="Select"
                    data-role="multiselect" />
        </div>
        <div data-container-for="user_dashboard" class="k-edit-field">
            <label style="float:left"><?php _e('Publish on Account dashboard','WPsmartcrm') ?><input type="checkbox" name="userDashboard" id="userDashboard" data-bind="checked:user_dashboard" />
            </label>
        </div>
	</div>
    
	<div class="col-md-12">
        <div class="k-edit-label">
            <label for="group"><?php _e('Notify to groups','WPsmartcrm') ?></label>
        </div>
        <div data-container-for="group" class="k-edit-field">
            <select id="group" name="group"
                    data-bind="value:group"
                    data-source="groupsDatasource"
                    data-text-field="name"
                    data-value-field="role"
                    data-option-label="Select"
                    data-role="multiselect" />
        </div>
        <div data-container-for="group_dashboard" class="k-edit-field">
            <label style="float:left;"><?php _e('Publish on group dashboard','WPsmartcrm') ?><input type="checkbox" name="groupDashboard" id="groupDashboard" data-bind="checked:group_dashboard" />
            </label>
        </div>
	</div>


</script>
<!--/CUSTOM POPUP EDITOR TEMPLATE-->
