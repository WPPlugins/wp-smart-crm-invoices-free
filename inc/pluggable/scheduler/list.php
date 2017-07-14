<?php

/**
 * Sets the datasource used in scheduler grid
 */
function WPsCRM_JS_schedulerList_datasource(){
	ob_start();
?>
    var dataSource = new kendo.data.DataSource(
			{
				transport: {
					read: function (options) {
						$.ajax({
							url: ajaxurl,
							data: {
								action: 'WPsCRM_get_scheduler',
								self_client:1
							},
							success: function (result) {
								options.success(result);
								//$("#grid").data("kendoGrid").dataSource.data(result.scheduler);

							},
							error: function (errorThrown) {
								console.log(errorThrown);
							}
						})
					}
				},
				group: { field: "tipo_agenda", dir: "asc" },
				schema: {
					data: function (response) {
						return response.scheduler
					},total: function (response) {
						return response.scheduler.length;
					},
					model: {
						id: "id_agenda",
						fields: {
							tipo_agenda: { editable: false },
							cliente: { editable: false },
							oggetto: { editable: false },
							annotazioni: { editable: false },
							esito: { editable: false },
							data_scadenza: {
								type: "date", editable: false,
								filterable: {
									cell: {
										template: '#= kendo.toString(kendo.parseDate(datao, "yyyy-MM-dd"), "' + $format + '") #'
									}
								}
							},
							destinatari: { editable: false },
						}
					}
				},
				pageSize: 50,
			}
		)

<?php
	echo ob_get_clean();
	return;
}
add_action('WPsCRM_scheduler_datasource','WPsCRM_JS_schedulerList_datasource',9);

/**
 *display scheduler list  grid
 **/
function WPsCRM_JS_display_schedulerGrid($delete_nonce){
	ob_start();
?>

    var grid = $("#grid").kendoGrid({
    	toolbar: kendo.template($("#gridHeader").html()),
    	dataSource: dataSource,
		noRecords: {
			template: "<h4 style=\"text-align:center;padding:5%\"><?php _e('No ACTIVITIES to show; you can add new todo or new appointments, please be sure to have some customers available or create a new customer from the main menu','WPsmartcrm')?></h4>"
		},
        groupable: {
            messages: {
                empty: "<?php _e('Drag columns headers and drop it here to group by that column','WPsmartcrm') ?>"
            }
        },
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
    	sortable: true,
		filterable:true,
        serverPaging: true,
        dataBound: loadCellsAttributes,
        columns: [{ field: "id_agenda", title: "ID", hidden: true },
				  { field: "fk_utenti_ins", title: "Ins", hidden: true },
				  { field: "tipo_agenda", title: "<?php _e('Type','WPsmartcrm') ?>", width: 150 },
				  { field: "cliente", title: "<?php _e('Customer','WPsmartcrm') ?>" },
				  { field: "oggetto", title: "<?php _e('Object','WPsmartcrm') ?>" },
				  { field: "data_scadenza", title: "<?php _e('Expiration','WPsmartcrm') ?>", template: '#= kendo.toString(kendo.parseDate(data_scadenza, "yyyy-MM-dd HH:mm:ss"), "' + $format + '") #' ,
				  	filterable: {
				  		ui: function (element) {
				  			element.kendoDateTimePicker({
				  				format: $format
				  			});
				  		}
				  	}
				  },
				  { field: "destinatari", title: "<?php _e('Recipients','WPsmartcrm')?>" },
				{ command: [

				{
                name: "<?php _e('Open','WPsmartcrm') ?>",
                click: function (e) {
                    e.preventDefault();
                    var tr = $(e.target).closest("tr"); // get the current table row (tr)
                    var _row = this.dataItem(tr);
                    $.ajax({
                        url: ajaxurl,
                        data: {
                        	'action': 'WPsCRM_view_activity_modal',
                            'id': _row.id
                        },
                        success: function (result) {
                            //console.log(result);
                            $('#dialog-view').show().html(result)
                            //$("#grid").data("kendoGrid").dataSource.data(result.scheduler);

                        },
                        error: function (errorThrown) {
                            console.log(errorThrown);
                        }
                    })

                },
                className: "btn btn-inverse _flat"
            },
			  {
			 name: "<?php _e('Delete','WPsmartcrm') ?>",
			 click: function (e) {
			  if (!confirm("<?php _e('Confirm delete','WPsmartcrm') ?>?"))
				  return false;
				e.preventDefault();
				var tr = $(e.target).closest("tr");
				var data = this.dataItem(tr);
				location.href="<?php echo admin_url('admin.php?page=smart-crm&p=scheduler/delete.php&ID=')?>"+data.id +"ref=scheduler&security=<?php echo $delete_nonce?>";

			 },
			className: "btn btn-danger _flat"
			}
        ], width: 200
        }, { field: "esito", hidden: true }
		, { field: "status", title: "<?php _e('Status','WPsmartcrm')?>", width: 100, "filterable":false }
        , { field: "class", hidden: true }

        ],
        height: 500,
        editable:"popup"
      });


<?php
	echo ob_get_clean();
	return;
}
add_action('WPsCRM_schedulerGrid','WPsCRM_JS_display_schedulerGrid',9,1);