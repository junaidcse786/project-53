<?php 

$id=$_REQUEST["id"];

$sql = "SELECT * FROM ".$db_suffix."question q
		Left Join ".$db_suffix."exercise e on e.exercise_id=q.exercise_id
		Left Join ".$db_suffix."user u on u.user_id=q.user_id where q.exercise_id='$id' ORDER BY q.question_id DESC";
$news_query = mysqli_query($db,$sql);

?>

<!-----PAGE LEVEL CSS BEGIN--->

<link rel="stylesheet" type="text/css" href="<?php echo SITE_URL_ADMIN; ?>assets/global/plugins/select2/select2.css" />

<link rel="stylesheet" href="<?php echo SITE_URL_ADMIN; ?>assets/global/plugins/datatables/plugins/bootstrap/dataTables.bootstrap.css" />


<!-----PAGE LEVEL CSS END--->


                                        <!-- BEGIN PAGE TITLE & BREADCRUMB-->
                                        <h3 class="page-title">
                                                Question Manager <small>The list of questions already created in this exercise set [<?php echo $_REQUEST["title"]; ?>]</small>
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
                                                        <a href="<?php echo SITE_URL_ADMIN.'?mKey='.$mKey.'&pKey=exerciselist';?>"><?php echo $menus["$mKey"]["exerciselist"]; ?></a>
                                                <i class="fa fa-angle-right"></i>
                                                </li>
                                                <li>
                                                        <a href="#">Questions in SET [<?php echo $_REQUEST["title"]; ?>]</a>
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
                     <div class="caption"><i class="fa fa-table"></i>Questions</div>
                     <div class="actions">
                        <a href="<?php echo SITE_URL_ADMIN.'?mKey='.$mKey.'&pKey=addquestion'.'&exercise_id='.$id.'&title='.$_REQUEST["title"]; ?>" class="btn blue"><i class="fa fa-plus"></i> Add new question to this exercise set</a> <?php 
							  
							  	echo ' <a target="_blank" href="'.SITE_URL.'exercise-trial/'.$id.'/'. urlencode($_REQUEST["title"]).'" class="btn default blue-ebonyclay"><i class="fa fa-video-camera"></i> Preview Exercise</a>'; 
							  
							  ?>
                        <div class="btn-group">
                           <a class="btn green" href="#" data-toggle="dropdown">
                           <i class="fa fa-cogs"></i> Actions
                           <i class="fa fa-angle-down"></i>
                           </a>
                           <ul class="dropdown-menu pull-right">
                              <li><a href="#" data-toggle="modal" data-target="#confirmation_all"><i class="fa fa-trash"></i> Delete</a></li>
							  <li><a href="<?php echo SITE_URL_ADMIN.'exercise_manager/stats_update.php?exe_id='.$id; ?>"><i class="fa fa-refresh"></i> Update stats.</a></li>
                              <!--<li><a href="#" data-toggle="modal" data-status="1" data-target="#confirmation_status"><i class="fa fa-flag"></i> Change status to Active</a></li>
                              <li><a href="#" data-toggle="modal" data-status="0" data-target="#confirmation_status"><i class="fa fa-flag-o"></i> Change status to InActive</a></li>-->
                           </ul>
                        </div>
                     </div>
                  </div>
                  <div class="portlet-body">
                     <table class="table table-striped table-bordered table-hover" id="question_list_table">
                        <thead>
                           <tr>
                              <th class="table-checkbox"><input type="checkbox" class="group-checkable" data-set="#question_list_table .checkboxes" /></th>
                              <th>Question</th>
                              <th >Fault (times)</th>
                              <th >Used (times)</th>
                              <th >Fault %</th>
			      <th >Points</th>
                              <th >Group</th> 
                              <th >Diff.</th>
                              <th >Type</th> 
                              <th ></th>
                              <!--<th ></th>-->                           
                           </tr>
                        </thead>
                        <tbody>
                        
                        <?php 
		   		 while($row = mysqli_fetch_object($news_query))
			    {
				   
		   ?>
           
                           <tr class="odd gradeX">
                              <td><input type="checkbox" class="checkboxes" value="<?php echo $row->question_id;?>" /></td>
                              <td><a href="<?php echo '?mKey='.$mKey.'&pKey=editquestion&id='.$row->question_id;?>"><?php echo substr(strip_tags($row->question_desc),0,30);?></a></td>
                              
                              <td><?php 
							  
							  if($row->question_wrong_hits_user!="")
							   
								   $wrong_hits_in_user_final = substr_count($row->question_wrong_hits_user, " ")+1;
								  
							  else
							   
							   	   $wrong_hits_in_user_final=0;
							  	
							  echo '<span class="badge badge-info">'.$wrong_hits_in_user_final.'</span>';
							  ?></td>
                              
                              <td><?php 						  	
                                                        if($row->question_hits_user!="")
							   
								   $question_hits = substr_count($row->question_hits_user, " ")+1;
								  
							  else
							   
							   	   $question_hits=0;
                              
							  echo '<span class="badge badge-info">'.$question_hits.'</span>';
							  
							  ?></td>
                              
                              <td><?php 
							  
							  $class='info';
							  
							  if($question_hits>0)
							  							  
							  	$fehler_prozent = round((($wrong_hits_in_user_final*100)/$question_hits), 2);
							  
							  else
							  
							  	$fehler_prozent=0;
							  
							  if($fehler_prozent >=50)
							
								 $class='danger';
							  						  	
							  	
							  echo '<span class="badge badge-'.$class.'">'.$fehler_prozent.'%</span>';
							  
							  ?></td>
							  
							  <td><?php echo $row->question_marks;?></td>
                              
                              <td><?php echo $row->question_pick;?></td>
                              
                              <td><?php echo $row->question_group;?></td>
                              
                              <td><?php echo $row->question_type;?></td>
                              
                              <!--<td><?php 
							  
							  if($row->role_id!='8')
							  
							  	echo '<a href="'.SITE_URL_ADMIN.'?mKey=member&pKey=editmember&id='.$row->user_id.'" class="btn default btn-xs yellow-gold">'.$row->user_first_name.' '.$row->user_last_name.'</a>'; 
								
							  else
							  
							  	echo '<a class="btn default btn-xs green-seagreen">Administrator</a>';	
								
							  ?></td>-->
                              
                              <td><?php 
							  
							  	echo '<a target="_blank" href="'.SITE_URL.'exercise-trial/'.$row->exercise_id.'/'.urlencode($row->exercise_title).'/'.$row->question_id.'" class="btn default btn-xs yellow-gold">Preview</a>'; 
							  
							  ?></td>
                              
                              <!--<td>
                              
                              <a href="<?php echo '?mKey='.$mKey.'&pKey=editquestion&id='.$row->question_id;?>" class="btn default btn-xs purple"><i class="fa fa-edit"></i> Edit</a>
                              
                              <a data-href="<?php echo SITE_URL_ADMIN; ?>exercise_manager/delete_question.php?id=<?php echo $row->question_id;?>" data-toggle="modal" href="#" data-target="#confirmation" class="btn default btn-xs red delete"><i class="fa fa-trash"></i> Delete</a>
                              </td> -->                              
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
         
         
         <!--<div class="modal fade" id="confirmation_status">
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
            </div>            
         </div>-->
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
					 
					 $('input:checkbox[class=checkboxes]:checked').each(function(){
						 
						num_item++;
					 })
					 
					 $('.item_number').html('<b>'+num_item+'</b>');
					 
					 $(this).find('#delete_button').on('click', function(e) { 
					 
					 var id='';
					 
					 $('input:checkbox[class=checkboxes]:checked').each(function(){
						 
						id=id+$(this).val()+',';
					 })
					 
						$.ajax({
							   type: "POST",
							   url:  '<?php echo SITE_URL_ADMIN.'exercise_manager/delete_question.php' ; ?>',
							   dataType: "text",
							   data: {id: id},
							   success: function(data){		
									window.location.reload(true);
							   }								   		   		
						  });
					});
				});
				
				/*$('#confirmation_status').on('show.bs.modal', function(e) {
					
					 var status=$(e.relatedTarget).data('status');
					 
					 $(this).find('#delete_button').on('click', function(e) { 
					 
					 var id='';
					 
					 var table_name='question';
					 
					 var column_name='question_status';
					 
					 var column_id='question_id';
					 
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
				});*/
				
				
				 var table = $('#question_list_table');

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
		
					// Uncomment below line("dom" parameter) to fix the dropdown overflow issue in the datatable cells. The default datatable layout
					// setup uses scrollable div(table-scrollable) with overflow:auto to enable vertical scroll(see: assets/global/plugins/datatables/plugins/bootstrap/dataTables.bootstrap.js). 
					// So when dropdowns used the scrollable div should be removed. 
					//"dom": "<'row'<'col-md-6 col-sm-12'l><'col-md-6 col-sm-12'f>r>t<'row'<'col-md-5 col-sm-12'i><'col-md-7 col-sm-12'p>>",
		
					"bStateSave": true, // save datatable state(pagination, sort, etc) in cookie.
		
					"lengthMenu": [
						[5, 15, 20, -1],
						[5, 15, 20, "Alle"] // change per page values here
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
		
				var tableWrapper = jQuery('#question_list_table_wrapper');
		
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
				
				/*$('#question_list_table tr').click(function(event) {
					if (event.target.type !== 'checkbox') {
						$('.checkboxes', this).trigger('click');
					}
				});*/
		
				tableWrapper.find('.dataTables_length select').select2();
				
	</script>	
    
    <!-----PAGE LEVEL SCRIPTS END--->    
        
        <!-- END JAVASCRIPTS -->
</body>
<!-- END BODY -->
</html>