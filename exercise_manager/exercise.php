<?php 

	
$sql = "SELECT * FROM ".$db_suffix."exercise e
		Left Join ".$db_suffix."user u on u.user_id=e.user_id ORDER BY exercise_id DESC";
$news_query = mysqli_query($db,$sql);

?>

<!-----PAGE LEVEL CSS BEGIN--->

<link rel="stylesheet" type="text/css" href="<?php echo SITE_URL_ADMIN; ?>assets/global/plugins/select2/select2.css" />

<link rel="stylesheet" href="<?php echo SITE_URL_ADMIN; ?>assets/global/plugins/datatables/plugins/bootstrap/dataTables.bootstrap.css" />


<!-----PAGE LEVEL CSS END--->


                                        <!-- BEGIN PAGE TITLE & BREADCRUMB-->
                                        <h3 class="page-title">
                                                <?php echo $menus["$mKey"]["$pKey"]; ?> <small>The list of exercises already created</small>
                                        </h3>
                               <div class="page-bar">         
                                        <ul class="page-breadcrumb">
                                                <li>
                                                        <i class="fa fa-home"></i>
                                                        <a href="<?php echo SITE_URL_ADMIN; ?>">Home</a>
                                                        <i class="fa fa-angle-right"></i>
                                                </li>
                                                <li>
                                                        <i class="<?php echo $active_module_icon; ?>"></i>
                                                        <a href="#"><?php echo $active_module_name; ?></a>
                                                        <i class="fa fa-angle-right"></i>
                                                </li>
                                                <li>
                                                        <a href="<?php echo SITE_URL_ADMIN.'?mKey='.$mKey.'&pKey='.$pKey; ?>"><?php echo $menus["$mKey"]["$pKey"]; ?></a>
                                                </li>
                                        </ul>
                                        <!-- END PAGE TITLE & BREADCRUMB-->
                                </div>
                     
                        <!-- END PAGE HEADER-->
                        <!-- BEGIN PAGE CONTENT-->
                                              
                        <div class="row">
            <div class="col-md-12">
            
            
           
               <!-- BEGIN EXAMPLE TABLE PORTLET-->
               
               <div class="portlet box grey-cascade">
                  <div class="portlet-title">
                     <div class="caption"><i class="fa fa-table"></i>Exercises</div>
                     <div class="actions">
                        <a href="<?php echo SITE_URL_ADMIN.'?mKey='.$mKey.'&pKey=addexercise'; ?>" class="btn blue"><i class="fa fa-plus"></i> Add new Exercise</a>
                        <div class="btn-group">
                           <a class="btn green" href="#" data-toggle="dropdown">
                           <i class="fa fa-cogs"></i> Actions
                           <i class="fa fa-angle-down"></i>
                           </a>
                           <ul class="dropdown-menu pull-right">
                              <li><a href="#" data-toggle="modal" data-target="#confirmation_all"><i class="fa fa-trash"></i> Delete</a></li>
                              <li><a href="#" data-toggle="modal" data-status="1" data-target="#confirmation_status"><i class="fa fa-flag"></i> Change status to Active</a></li>
                              <li><a href="#" data-toggle="modal" data-status="0" data-target="#confirmation_status"><i class="fa fa-flag-o"></i> Change status to InActive</a></li>
                           </ul>
                        </div>
                     </div>
                  </div>
                  <div class="portlet-body">
                     <table class="table table-striped table-bordered table-hover" id="exercise_list_table">
                        <thead>
                           <tr>
                              <th class="table-checkbox"><input type="checkbox" class="group-checkable" data-set="#exercise_list_table .checkboxes" /></th>
                              <th>Title</th>
                              <th></th>
                              <th width="1%">No.Q</th>
                              <th >Type</th>
                              <th >Topic</th>
							  <th >Pull</th>
                              <th >Difficulty</th> 
                              <th >Level</th> 
                              <th >Status</th> 
                              <th >Preview</th> 
                              <!--<th ></th>     -->                     
                           </tr>
                        </thead>
                        <tbody>
                        
                        <?php 
		   		 while($row = mysqli_fetch_object($news_query))
			    {
				   
		   ?>
           
                           <tr class="odd gradeX">
                              <td><input type="checkbox" class="checkboxes" value="<?php echo $row->exercise_id;?>" /></td>
                              <td><a href="<?php echo '?mKey='.$mKey.'&pKey=editexercise&id='.$row->exercise_id;?>"><?php echo $row->exercise_title;?></a></td>
                              
                              <td><?php
							  $num_of_vocabs=mysqli_num_rows(mysqli_query($db,"SELECT question_id FROM ".$db_suffix."question WHERE exercise_id ='$row->exercise_id'"));							  
							  ?>                              
                              <a href="<?php echo '?mKey='.$mKey.'&pKey=questionlist&id='.$row->exercise_id.'&title='.urlencode($row->exercise_title);?>" class="btn default btn-xs green-stripe">Questions </a></td>
                              
                              <td><span class="badge badge-warning"><?php echo $num_of_vocabs; ?></span></td>
                              
                              <td><?php echo $row->exercise_type;?></td>
							  
							  <td><?php echo $row->exercise_topic;?></td>
                              
                              <td><?php echo $row->exercise_pull;?></td>
                              
                              <td><?php echo $row->exercise_difficulty;?></td>
                              
                              <td><?php echo $row->exercise_level;?></td>
                              
                              <td>
							  <?php if($row->exercise_status)
							  
											echo '<span class="label label-md label-success">Active</span>'; 
									else 
											echo '<span class="label label-md label-danger">InActive</span>';
									?>
                              </td>
                              
                              <td><?php 
							  
							  /*if($row->role_id!='8')
							  
							  	echo '<a href="'.SITE_URL_ADMIN.'?mKey=member&pKey=editmember&id='.$row->user_id.'" class="btn default btn-xs yellow-gold">'.$row->user_first_name.' '.$row->user_last_name.'</a>'; 
								
							  else
							  
							  	echo '<a class="btn default btn-xs green-seagreen">Administrator</a>';	*/
								echo '<a target="_blank" href="'.SITE_URL.'exercise-trial/'.$row->exercise_id.'/'.urlencode($row->exercise_title).'" class="btn default btn-xs yellow-gold">Preview</a>'; 
							  
							  ?></td>
                              
                              <!--<td>
                              
                              <a href="<?php echo '?mKey='.$mKey.'&pKey=editexercise&id='.$row->exercise_id;?>" class="btn default btn-xs purple"><i class="fa fa-edit"></i> Edit</a>
                              
                              <a data-href="<?php echo SITE_URL_ADMIN; ?>exercise_manager/delete_exercise.php?id=<?php echo $row->exercise_id;?>" data-toggle="modal" href="#" data-target="#confirmation" class="btn default btn-xs red delete"><i class="fa fa-trash"></i> Delete</a>
                              </td>   -->                            
                           </tr>
                           
          <?php } ?>       
                        </tbody>
                     </table>
                  
                  </div>
               </div>
               <!-- END EXAMPLE TABLE PORTLET-->
            </div>
         </div>
         
         
         
<!-----MODALS FOR THIS PAGE START ---->


		<div class="modal fade" id="confirmation_all">
            <div class="modal-dialog">
               <div class="modal-content">
                  <div class="modal-header">
                     <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                     <h4 class="modal-title">Delete Confirmation</h4>
                  </div>
                  <div class="modal-body">
                        <span class="font-red-thunderbird"><strong>Warning !</strong></span> Are you sure you want to delete this(these) <span class="item_number font-red"></span> record(s)?         			</div>
                  <div class="modal-footer">
                     <button id="delete_button" type="button" class="btn red-thunderbird">Delete</button>
                     <button type="button" class="btn default" data-dismiss="modal">Close</button>
                  </div>
               </div>
               <!-- /.modal-content -->
            </div>
            <!-- /.modal-dialog -->
         </div>
         
         
         <div class="modal fade" id="confirmation_status">
            <div class="modal-dialog">
               <div class="modal-content">
                  <div class="modal-header">
                     <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                     <h4 class="modal-title">Status Change Confirmation</h4>
                  </div>
                  <div class="modal-body">
                        <span class="font-red-thunderbird"><strong>Warning !</strong></span> Are you sure you want to change the status of this(these) record(s)?         			</div>
                  <div class="modal-footer">
                     <button id="delete_button" type="button" class="btn red-thunderbird">Change</button>
                     <button type="button" class="btn default" data-dismiss="modal">Close</button>
                  </div>
               </div>
               <!-- /.modal-content -->
            </div>
            <!-- /.modal-dialog -->
         </div>
                        <!-- /.modal -->

<!-----MODALS FOR THIS PAGE END ---->
  




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
   
   <script>
                $('#confirmation_all').on('show.bs.modal', function(e) {
					 
					 var num_item=0;
					 var id='';
					 
					 $('input:checkbox[class=checkboxes]:checked').each(function(){
						 
						num_item++;
						id=id+$(this).val()+',';
					 })
					 
					 $('.item_number').html('<b>'+num_item+'</b>');
					 
					 $(this).find('#delete_button').live('click', function(e) { 
					 
					 	$.ajax({
							   type: "POST",
							   url:  '<?php echo SITE_URL_ADMIN.'exercise_manager/delete_exercise.php' ; ?>',
							   dataType: "text",
							   data: {id: id},
							   success: function(data){		
									window.location.reload(true);
							   }								   		   		
						  });
					});
				});
				
				$('#confirmation_status').on('show.bs.modal', function(e) {
					
					 var column_id='exercise_id';
					 
					 var status=$(e.relatedTarget).data('status');
					 
					 $(this).find('#delete_button').live('click', function(e) { 
					 
					 var id='';
					 
					 var table_name='exercise';
					 
					 var column_name='exercise_status';
					 
					 var column_id='exercise_id';
					 
					 $('input:checkbox[class=checkboxes]:checked').each(function(){
						 
						id=id+$(this).val()+',';
					 })
					 
						$.ajax({
							   type: "POST",
							   url:  '<?php echo SITE_URL_ADMIN.'content_manager/change_status.php' ; ?>',
							   dataType: "text",
							   data: {id: id, status: status, table_name:table_name, column_name:column_name, column_id:column_id},
							   success: function(data){		
									window.location.reload(true);
							   }								   		   		
						  });
					});
				});
				
				
				 var table = $('#exercise_list_table');

				table.dataTable({
		
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
		
					"lengthMenu": [
						[5, 15, 20, -1],
						[5, 15, 20, "Alle"] 
					],
					// set the initial value
					"pageLength": -1,
					
					"columnDefs": [{  // set default column settings
						'orderable': false,
						'targets': [0]
					}, {
						"searchable": false,
						"targets": [0]
					}],
					"order": [
						
					] // set first column as a default sort by asc
				});
		
				var tableWrapper = jQuery('#exercise_list_table_wrapper');
		
				table.find('.group-checkable').change(function () {
					var set = jQuery(this).attr("data-set");
					var checked = jQuery(this).is(":checked");
					jQuery(set).each(function () {
						if (checked) {
							$(this).attr("checked", true);
						} else {
							$(this).attr("checked", false);
						}
					});
					jQuery.uniform.update(set);
				});
				
				tableWrapper.find('.dataTables_length select').select2();
				
	</script>	
    
    <!-----PAGE LEVEL SCRIPTS END--->    
        
        <!-- END JAVASCRIPTS -->
</body>
<!-- END BODY -->
</html>