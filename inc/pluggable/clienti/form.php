<?php
if ( ! defined( 'ABSPATH' ) ) exit;
/**
 * Displays the grid in customer form activity tab
 * @return void
 */
function WPsCRM_JS_display_grid_customer_scheduler($delete_nonce){
	ob_start();?>
$("#grid").kendoGrid({
			noRecords: {
					template: "<h4 style=\"text-align:center;padding:5%\"><?php _e('No activity for this customer','WPsmartcrm')?></h4>"
			},
			dataSource: _datasource,
            dataBound: loadCellsAttributes,
            filterable: true,
            sortable: true,
            pageable: true,
            groupable: {
                messages: {
                    empty: "<?php _e('Drag columns headers and drop it here to group by that column','WPsmartcrm') ?>"
                }
            },
        	columns: [{
        		field: "id_agenda", title: "ID", filterable: false, hidden: true },
				{ field: "fk_utenti_ins", title: "Ins",hidden:true },
				{ field: "tipo", title: "<?php _e('Type','WPsmartcrm')?>", width: 160 },
				{ field: "oggetto", title: "<?php _e('Subject','WPsmartcrm')?>", width: 240 },
				{ field: "annotazioni", title: "<?php _e('Description','WPsmartcrm')?>", groupable: false },
				{ field: "data_scadenza", title: "<?php _e('Exp. date','WPsmartcrm')?>",template: '#= kendo.toString(kendo.parseDate(data_scadenza, "yyyy-MM-dd HH:mm:ss"), "' + $format + '") #' },
        { command: [
          {
              name:"<?php _e('Open','WPsmartcrm')?>",
            click: function (e) {
              e.preventDefault();
              var position = $(e.target).offset();
              var tr = $(e.target).closest("tr"); // get the current table row (tr)
              var _row = this.dataItem(tr);
              $.ajax({
                  url: ajaxurl,
                  data: {
                  	'action': 'WPsCRM_view_activity_modal',
                      'id': _row.id
                  },
                  success: function (result) {
                      $('#dialog-view').show().html(result)
                      $('.modal_inner').animate({
                          'top': position.top - 320 + 'px',
                      }, 1000);
                  },
                  error: function (errorThrown) {
                      console.log(errorThrown);
                  }
              })

            },
			className: "btn btn-inverse _flat"
          },
          {
            name:"<?php _e('Delete','WPsmartcrm')?>",
            click: function (e) {
             if (!confirm("<?php _e('Confirm delete','WPsmartcrm') ?>?"))
                  return false;

            e.preventDefault();
              var tr = $(e.target).closest("tr"); // get the current table row (tr)
              var _row = this.dataItem(tr);
                //location.href="?page=smart-crm&p=scheduler/view.php&ID="+data.id;
              $.ajax({
                  url: ajaxurl,
                  data: {
                  	'action': 'WPsCRM_delete_activity',
                  	'id': _row.id,
                  	'security':'<?php echo $delete_nonce; ?>'
                  },
                  success: function (result) {
	                 var newDatasource = new kendo.data.DataSource({
                        transport: {
                            read: function (options) {
                                jQuery.ajax({
                                    url: ajaxurl,
                                    data: {
                                    	'action': 'WPsCRM_get_client_scheduler',
                                        id_cliente: '<?php if(isset($ID)) echo $ID?>'
                                    },
                                    success: function (result) {
                                        //console.log(result);
                                        jQuery("#grid").data("kendoGrid").dataSource.data(result.scheduler);

                                    },
                                    error: function (errorThrown) {
                                        console.log(errorThrown);
                                    }
                                })
                            }
                        },
                        schema: {
                            model: {
                                id: "id_agenda",
                                fields: {
                                    tipo: { editable: false },
                                    oggetto: { editable: false },
                                    annotazioni: { editable: false },
                                    data_scadenza: { type: "date", editable: false },
                                }
                            }
                        },
                        pageSize: 50,
                    });
                    setTimeout(function () {
                        $('.modal_loader').fadeOut('fast');
                    }, 300);
                    setTimeout(function () {
                        $('._modal').fadeOut('fast');
                    }, 500);

                    var grid = $('#grid').data("kendoGrid");
                    setTimeout(function () {
                        grid.setDataSource(newDatasource);
                        grid.dataSource.read();
                    }, 600);

                    setTimeout(function () { grid.refresh() }, 700);

	              },
                  error: function (errorThrown) {
                      console.log(errorThrown);
                  }
              })

            }
			, className: "btn btn-danger _flat"
          },

        ]
        }, { field: "esito", hidden: true }
		, { field: "status", title: "<?php _e('Status','WPsmartcrm')?>", width: 100 , "filterable":false}
        , { field: "class", hidden: true }
        ],
        height: 500,
        editable: "popup",
        autoSync: true,
        pageable: {
            pageSize: 10,
            refresh: true
        }
      });
<?php
	echo ob_get_clean();
	return;
}
add_action('WPsCRM_grid_customer_scheduler','WPsCRM_JS_display_grid_customer_scheduler',9,1);

/**
 * Displays the grid for contacts in customer form
 * @return void
 */
function WPsCRM_JS_grid_customer_contacts(){
	ob_start();?>
           $("#grid_contacts").kendoGrid({
                dataSource: _contacts,
				noRecords: {
				template: "<h4 style=\"text-align:center;padding:5%\"><?php _e('No Contacts to show','WPsmartcrm')?></h4>"
    			},
                height: 550,
                groupable: {
                messages: {
                    empty: "<?php _e('Drag columns headers and drop it here to group by that column','WPsmartcrm') ?>"
					}
				},
                sortable: true,
                serverPaging: true,
                pageable:
                    {
                        pageSizes: [20, 50, 100],
                        messages:
                            {
                                display: "<?php _e('Showing','WPsmartcrm') ?> {0}-{1}  <?php _e('of','WPsmartcrm') ?> {2} <?php _e('total','WPsmartcrm') ?>",
                                of: "<?php _e('of','WPsmartcrm') ?> {0}",
                                itemsPerPage: "<?php _e('Posts per page','WPsmartcrm') ?>",
                                first: "<?php _e('First page','WPsmartcrm') ?>",
                                last: "<?php _e('Last page','WPsmartcrm') ?>",
                                next: "<?php _e('Next','WPsmartcrm') ?>",
                                previous: "<?php _e('Prev.','WPsmartcrm') ?>",
                                refresh: "<?php _e('Reload','WPsmartcrm') ?>",
                                morePages: "<?php _e('More','WPsmartcrm') ?>"
                            },
                    },
                filterable:
		{
        messages:
            {
                info: "<?php _e('Filter by','WPsmartcrm') ?> "
            },
        extra: false,
        operators:
            {
                string:
                    {
                        contains: "<?php _e('Contains','WPsmartcrm') ?> ",
                        startswith: "<?php _e('Starts with','WPsmartcrm') ?>",
                        eq: "<?php _e('Equal','WPsmartcrm') ?>",
                        neq: "<?php _e('Not equal','WPsmartcrm') ?>"
                    }
            }
    },
    toolbar: [{ name: "create", text: "<?php _e('Add new contact','WPsmartcrm') ?>" }],  
    columns: [
      {
        field: "id",
        title: "<?php _e('ID','WPsmartcrm') ?>"
      },
      {
        field: "nome",
        title: "<?php _e('Name','WPsmartcrm') ?>"
      },
      {
        field: "cognome",
        title: "<?php _e('Last Name','WPsmartcrm') ?>"
      },
      {
        field: "email",
        title: "<?php _e('Email','WPsmartcrm') ?>"
      },
      {
        field: "telefono",
        title: "<?php _e('Telephone','WPsmartcrm') ?>"
      },
      {
        field: "qualifica",
        title: "<?php _e('Qualification','WPsmartcrm') ?>"
      },
        { command: [
			{
				name:"edit",
				text: {edit:"<?php _e('Edit','WPsmartcrm') ?>", update:"<?php _e('Update','WPsmartcrm') ?>", cancel:"<?php _e('Cancel','WPsmartcrm') ?>"}
			}, 
			{
				name:"destroy",
				text:"<?php _e('Delete','WPsmartcrm') ?>"
			}
			], title: "&nbsp;", width: "250px" }],
            editable: {
				confirmation: "<?php _e('Confirm delete','WPsmartcrm') ?>?",
				mode: "inline"
			},
    });
<?php
	echo ob_get_clean();
	return;
}
add_action('WPsCRM_grid_customer_contacts','WPsCRM_JS_grid_customer_contacts',9);

/**
 * display a tooltip for help in menu buttons
 * @return void
 */
function WPsCRM_JS_menu_tooltip(){
	ob_start();?>
    $("._tooltip").kendoTooltip({
    		//autoHide: false,
    		animation: {
				close: {
					duration: 1000,
				}
			},
			position:"top",
    		content: "<h4><?php _e('BUTTONS LEGEND','WPsmartcrm')?>:</h4>\n\
			<ul>\n\
				<li class=\"no-link\">\n\
					<span class=\"btn btn-info _flat\"><i class=\"glyphicon glyphicon-tag\"></i>= <?php _e('NEW TODO','WPsmartcrm')?></span>\n\
					<span class=\"btn btn_appuntamento_1 _flat\"><i class=\"glyphicon glyphicon-pushpin\"></i>= <?php _e('NEW APPOINTMENT','WPsmartcrm')?></span>\n\
					<span class=\"btn btn-primary _flat\"><i class=\"glyphicon glyphicon-option-horizontal\"></i>= <?php _e('NEW ACTIVITY','WPsmartcrm')?></span>\n\
				</li>\n\
			</ul>"
    	})
<?php
	echo ob_get_clean();
	return;
}
add_action('WPsCRM_menu_tooltip','WPsCRM_JS_menu_tooltip',9);
