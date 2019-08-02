<?php 

$id=$_REQUEST["id"];

$title=$_REQUEST["title"];

if($_REQUEST["for"]=='0')

	$for='Teachers';
	
else

	$for='Students';	
	
$sql = "SELECT * FROM ".$db_suffix."indiv_codes ic
		Left Join ".$db_suffix."user u ON u.user_id=ic.user_id where ic.codes_id='$id'ORDER BY ic_id DESC";
$news_query = mysqli_query($db,$sql);

?>

<!-----PAGE LEVEL CSS BEGIN--->

<link rel="stylesheet" type="text/css" href="<?php echo SITE_URL_ADMIN; ?>assets/global/plugins/select2/select2.css" />

<link rel="stylesheet" href="<?php echo SITE_URL_ADMIN; ?>assets/global/plugins/datatables/plugins/bootstrap/dataTables.bootstrap.css" />


<!-----PAGE LEVEL CSS END--->

<h3 class="page-title">
                                                Code for <?php echo $for; ?> <small><?php echo $title; ?></small>
                                        </h3>

                                              
                        <div class="row">
            <div class="col-md-12">
            
           
               <!-- BEGIN EXAMPLE TABLE PORTLET-->
               
               <div class="portlet box grey-cascade">
                  <div class="portlet-title">
                     <div class="caption"><i class="fa fa-table"></i>Codes</div>
                     <!--<div class="tools">
                     </div>-->
                  </div>
                  <div class="portlet-body">
                     <table class="table table-striped table-bordered table-hover" id="codes_page_table">
                        <thead>
                           <tr>
                              <th width="50%">Name</th>
                              <th width="50%" >Code</th>
                           </tr>
                        </thead>
                        <tbody>
                        
                        <?php 
		   		 while($row = mysqli_fetch_object($news_query))
			    {
				   
		   ?>
           
                           <tr>
                           
							<td><?php echo $row->user_first_name.' '.$row->user_last_name;?></td>
							  
                            <td><?php echo $row->codes_value;?></td>
                           
						   </tr>
                           
          <?php } ?>       
                        </tbody>
                     </table>
                  
                  </div>
               </div>
               <!-- END EXAMPLE TABLE PORTLET-->
            </div>
         </div>
         


<!-----------------------Here goes the rest of the page --------------------------------------------->

<!-- END PAGE CONTENT-->
                </div>
                <!-- END PAGE -->    
        </div>


        <!-- END CONTAINER -->
        
        <!-- BEGIN FOOTER -->
        
        <?php require_once('footer.php'); ?>
        
        <!-- END FOOTER -->
      
        <!-- BEGIN CORE PLUGINS --> 
          
        
		<?php require_once('scripts.php'); ?>
        
        
        <!-- END CORE PLUGINS -->
        
       <!-----PAGE LEVEL SCRIPTS BEGIN--->
       
       <script type="text/javascript" src="<?php echo SITE_URL_ADMIN; ?>assets/global/plugins/select2/select2.min.js"></script>
        
   <script type="text/javascript" src="<?php echo SITE_URL_ADMIN; ?>assets/global/plugins/datatables/media/js/jquery.dataTables.min.js"></script>
   
   <script type="text/javascript" src="<?php echo SITE_URL_ADMIN; ?>assets/global/plugins/datatables/plugins/bootstrap/dataTables.bootstrap.js"></script>
   
   <script type="text/javascript" src="<?php echo SITE_URL_ADMIN; ?>assets/global/plugins/datatables/extensions/TableTools/js/dataTables.tableTools.min.js"></script>
   
   <script>
                var table1 = $('#codes_page_table');

				/* Table tools samples: https://www.datatables.net/release-datatables/extras/TableTools/ */
		
				/* Set tabletools buttons and button container */
		
				$.extend(true, $.fn.DataTable.TableTools.classes, {
					"container": "btn-group tabletools-dropdown-on-portlet",
					"buttons": {
						"normal": "btn btn-sm default",
						"disabled": "btn btn-sm default disabled"
					},
					"collection": {
						"container": "DTTT_dropdown dropdown-menu tabletools-dropdown-menu"
					}
				});
		
				var oTable = table1.dataTable({
		
					// Internationalisation. For more info refer to http://datatables.net/manual/i18n
					"language": {
					
					"sEmptyTable":      "Keine Daten in der Tabelle vorhanden",
					"sInfo":            "_START_ bis _END_ von _TOTAL_ Einträgen",
					"sInfoEmpty":       "0 bis 0 von 0 Einträgen",
					"sInfoFiltered":    "(gefiltert von _MAX_ Einträgen)",
					"sInfoPostFix":     "",
					"sInfoThousands":   ".",
					"sLengthMenu":      "_MENU_ Einträge anzeigen",
					"sLoadingRecords":  "Wird geladen...",
					"sProcessing":      "Bitte warten...",
					"sSearch":          "Suchen",
					"sZeroRecords":     "Keine Einträge vorhanden.",
					"oPaginate": {
						"sFirst":       "Erste",
						"sPrevious":    "Zurück",
						"sNext":        "Nächste",
						"sLast":        "Letzte"
					},
					"oAria": {
						"sSortAscending":  ": aktivieren, um Spalte aufsteigend zu sortieren",
						"sSortDescending": ": aktivieren, um Spalte absteigend zu sortieren"
						}
					},
					
					"bStateSave": true,
							
					// Or you can use remote translation file
					//"language": {
					//   url: '//cdn.datatables.net/plug-ins/3cfcc339e89/i18n/Portuguese.json'
					//},
		
					"order": [
						[0, 'asc']
					],
					
					"lengthMenu": [
						[5, 10, 15, 20, -1],
						[5, 10, 15, 20, "Alle"] // change per page values here
					],
					// set the initial value
					"pageLength": -1,
		
					"dom": "<'row' <'col-md-12'T>><'row'<'col-md-6 col-sm-12'l><'col-md-6 col-sm-12'f>r><'table-scrollable't><'row'<'col-md-5 col-sm-12'i><'col-md-7 col-sm-12'p>>", // horizobtal scrollable datatable
		
					// Uncomment below line("dom" parameter) to fix the dropdown overflow issue in the datatable cells. The default datatable layout
					// setup uses scrollable div(table-scrollable) with overflow:auto to enable vertical scroll(see: assets/global/plugins/datatables/plugins/bootstrap/dataTables.bootstrap.js). 
					// So when dropdowns used the scrollable div should be removed. 
					//"dom": "<'row' <'col-md-12'T>><'row'<'col-md-6 col-sm-12'l><'col-md-6 col-sm-12'f>r>t<'row'<'col-md-5 col-sm-12'i><'col-md-7 col-sm-12'p>>",
		
					"tableTools": {
						"sSwfPath": "<?php echo SITE_URL_ADMIN; ?>assets/global/plugins/datatables/extensions/TableTools/swf/copy_csv_xls_pdf.swf",
						"aButtons": [{
							"sExtends": "pdf",
							"sButtonText": "PDF"
						}, {
							"sExtends": "csv",
							"sButtonText": "CSV"
						}, {
							"sExtends": "xls",
							"sButtonText": "Excel"
						}, {
							"sExtends": "print",
							"sButtonText": "Print",
							"sInfo": 'Please press "CTRL+P" to print or "ESC" to quit',
							"sMessage": "Generated by DataTables"
						}, {
							"sExtends": "copy",
							"sButtonText": "Copy"
						}]
					}
				});
		
				var tableWrapper = $('#codes_page_table_wrapper'); // datatable creates the table wrapper by adding with id {your_table_jd}_wrapper
		
				tableWrapper.find('.dataTables_length select').select2();
				
				table1.on('click', '.edit', function (e) {
					e.preventDefault();
		
					/* Get the row as a parent of the link that was clicked on */
					var nRow = $(this).parents('tr')[0];
		
					if (nEditing !== null && nEditing != nRow) {
						/* Currently editing - but not this row - restore the old before continuing to edit mode */
						restoreRow(oTable, nEditing);
						editRow(oTable, nRow);
						nEditing = nRow;
					} else if (nEditing == nRow && this.innerHTML == "Save") {
						/* Editing this row and want to save it */
						saveRow(oTable, nEditing);
						nEditing = null;
						alert("Updated! Do not forget to do some ajax to sync with backend :)");
					} else {
						/* No edit in progress - let's start one */
						editRow(oTable, nRow);
						nEditing = nRow;
					}
				});
				
	</script>	
    
    <!-----PAGE LEVEL SCRIPTS END--->    
        
        <!-- END JAVASCRIPTS -->
</body>
<!-- END BODY -->
</html>