<?php
if ( ! defined( 'ABSPATH' ) ) exit;
$active=$_SERVER['QUERY_STRING'];
$active = $active !="" ? explode('&',$active): null;
$menu = count($active) > 1  ? $active[1] : "";
$options=get_option('CRM_general_settings');
?>
<div id="mainMenu">


<ul class="nav nav-pills">
    <li role="presentation" <?php echo ( $active[0]=="page=smart-crm" && count($active) ==0 || $active[0]=="page=smart-crm" && strstr($menu,"view")) ? "class=\"active\"" :null  ?>>
            <a href="<?php echo admin_url('admin.php?page=smart-crm')?>"><i class="glyphicon glyphicon-home"></i> <?php _e('Dashboard','WPsmartcrm') ?></a>
	</li>
    <li role="presentation" <?php echo strstr($menu,"clienti") ? "class=\"active\"" :null  ?>>
        <a href="<?php echo admin_url('admin.php?page=smart-crm&p=clienti/list.php')?>"><i class="glyphicon glyphicon-user"></i> <?php _e('Customers','WPsmartcrm') ?></a>
        <ul>
            <li role="presentation" <?php echo strstr($menu,"clienti") ? "class=\"active\"" :null  ?>>
                <a href="<?php echo admin_url('admin.php?page=smart-crm&p=clienti/list.php')?>">
                    <i class="glyphicon glyphicon-align-justify"></i>
                    <?php _e('LIST','WPsmartcrm')?>&raquo;
                </a>
            </li>
            <li role="presentation" <?php echo strstr($menu,"documenti") ? "class=\"active\"" :null  ?>>
                <a href="<?php echo admin_url('admin.php?page=smart-crm&p=clienti/form.php')?>">
                    <i class="glyphicon  glyphicon-user"></i>
                    <?php _e('NEW CUSTOMER','WPsmartcrm')?>&raquo;
                </a>
            </li>
                
        </ul>
		
	</li>
<?php if(isset($options['services']) &&$options['services'] ==1){?>
    <li role="presentation" <?php echo strstr($menu,"articoli") ? "class=\"active\"" :null  ?>>
        <a href="<?php echo admin_url('admin.php?page=smart-crm&p=articoli/list.php')?>"><i class="glyphicon glyphicon-star-empty"></i> <?php _e('Services','WPsmartcrm') ?></a>
	</li>
<?php } ?>
    <li role="presentation" <?php echo strstr($menu,"scheduler") ? "class=\"active\"" :null  ?>>
        <a href="<?php echo admin_url('admin.php?page=smart-crm&p=scheduler/list.php')?>">
            <i class="glyphicon  glyphicon-time"></i> <?php _e('Scheduler','WPsmartcrm') ?>
		</a>
        <ul>
            <li role="presentation" <?php echo strstr($menu,"scheduler") ? "class=\"active\"" :null  ?>>
                <a href="<?php echo admin_url('admin.php?page=smart-crm&p=scheduler/list.php')?>">
                    <i class="glyphicon glyphicon-align-justify"></i>
                    <?php _e('LIST','WPsmartcrm')?>&raquo;
                </a>
            </li>
            <li role="presentation" <?php echo strstr($menu,"scheduler") ? "class=\"active\"" :null  ?>>
                <a href="<?php echo admin_url('admin.php?page=smart-crm&p=scheduler/form.php&tipo_agenda=1')?>">
                    <i class="glyphicon  glyphicon-tag"></i>
                    <?php _e('NEW TODO','WPsmartcrm')?>&raquo;
                </a>
            </li>
            <li role="presentation" <?php echo strstr($menu,"scheduler") ? "class=\"active\"" :null  ?>>
                <a href="<?php echo admin_url('admin.php?page=smart-crm&p=scheduler/form.php&tipo_agenda=2')?>">
                    <i class="glyphicon  glyphicon-pushpin"></i>
                    <?php _e('NEW APPOINTMENT','WPsmartcrm') ?>&raquo;
                </a>
            </li>
        </ul>
	</li>
	<?php
	$current_user = wp_get_current_user();
    ?>
    <li role="presentation" <?php echo strstr($menu,"documenti") ? "class=\"active\"" :null  ?>>
        <a href="<?php echo admin_url('admin.php?page=smart-crm&p=documenti/list.php')?>"><i class="glyphicon glyphicon-th-list"></i> <?php _e('Documents','WPsmartcrm') ?></a>
		<ul>
			<li role="presentation" <?php echo strstr($menu,"documenti") ? "class=\"active\"" :null  ?>>
				<a href="<?php echo admin_url('admin.php?page=smart-crm&p=documenti/list.php')?>">
					<i class="glyphicon glyphicon-align-justify"></i>
					<?php _e('LIST','WPsmartcrm')?>&raquo;
				</a>
			</li>
			<li role="presentation" <?php echo strstr($menu,"documenti") ? "class=\"active\"" :null  ?>>
				<a href="<?php echo admin_url('admin.php?page=smart-crm&p=documenti/form_invoice.php')?>">
					<i class="glyphicon  glyphicon-fire"></i>
				<?php _e('NEW INVOICE','WPsmartcrm')?>&raquo;
			</a>
		</li>
		<li role="presentation" <?php echo strstr($menu,"documenti") ? "class=\"active\"" :null  ?>>
				<a href="<?php echo admin_url('admin.php?page=smart-crm&p=documenti/form_quotation.php')?>">
					<i class="glyphicon  glyphicon-send"></i>
				<?php _e('NEW QUOTATION','WPsmartcrm') ?>&raquo;
				</a>
		</li>
			<?php do_action('WPsCRM_add_submenu_documents',$menu)?>
		</ul>
	</li>
<?php
	if(current_user_can('manage_options') ){
?>
    <li role="presentation"  <?php if(strstr($menu,"settings")) {?> class="active" <?php } ?>><a href="#" onclick="return false;"><i class="glyphicon  glyphicon-wrench"></i> <?php _e('Utilities','WPsmartcrm') ?></a>
        <ul>
            <li role="presentation" <?php if(strstr($menu,"settings")) {?> class="active" <?php } ?>><a href="<?php echo admin_url('admin.php?page=smartcrm_settings&tab=CRM_documents_settings')?>"><i class="glyphicon glyphicon-cog"></i> <?php _e('SETTINGS','WPsmartcrm') ?>&raquo;</a></li>
			<li role="presentation" ><a href="<?php echo admin_url('admin.php?page=smart-crm&p=register_invoices/form.php')?>"><i class="glyphicon glyphicon-transfer"></i> <?php _e('REGISTER INVOICES','WPsmartcrm') ?>&raquo;</a></li>
			<li role="presentation" ><a href="<?php echo admin_url('admin.php?page=smart-crm&p=import/form.php')?>"><i class="glyphicon glyphicon-import"></i> <?php _e('IMPORT CUSTOMERS','WPsmartcrm') ?>&raquo;</a></li>
			<?php do_action('WPsCRM_add_options_in_menu')?>
	    </ul>

    </li>
    <li role="presentation" <?php if(strstr($active[0],"subscription")) {?> class="active" <?php } ?>>
        <a href="<?php echo admin_url('admin.php?page=smartcrm_subscription-rules')?>">
            <i class="glyphicon glyphicon-bell"></i>
            <?php _e('Subscription/Notification rules','WPsmartcrm') ?>
        </a>
    </li>
	<?php } ?>
    <?php do_action('add_menu_items_b') //add custom menu otems through file functions.php of your theme using hook 'add_menu_items'?>
</ul>

</div>
       
