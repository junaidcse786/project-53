<?php    

if(isset($_GET["assignee_id"]) && !empty($_GET["assignee_id"])){
   $assignee_id = $_GET["assignee_id"];

   $sql = "select * from ".$db_suffix."user where user_id = '$assignee_id' limit 1";				
   $query = mysqli_query($db, $sql);

   if(mysqli_num_rows($query) > 0){
         $usr = mysqli_fetch_object($query);
         $assignee_full_name = $usr->user_first_name.' '.$usr->user_last_name;
   }

   $sql = "SELECT t.*, u.user_id, u.user_first_name, u.user_last_name FROM ".$db_suffix."task t LEFT JOIN ".$db_suffix."user u ON t.user_id = u.user_id WHERE t.user_id='$assignee_id'";
}
else
   $sql = "SELECT t.*, u.user_id, u.user_first_name, u.user_last_name FROM ".$db_suffix."task t LEFT JOIN ".$db_suffix."user u ON t.user_id = u.user_id ORDER BY t.task_id DESC";

   $user_query = mysqli_query($db,$sql);

?>

<!-----PAGE LEVEL CSS BEGIN--->

<link rel="stylesheet" type="text/css" href="<?php echo SITE_URL_ADMIN; ?>assets/global/plugins/select2/select2.css" />

<link rel="stylesheet" href="<?php echo SITE_URL_ADMIN; ?>assets/global/plugins/datatables/plugins/bootstrap/dataTables.bootstrap.css" />


<!-----PAGE LEVEL CSS END--->


<!-- BEGIN PAGE TITLE & BREADCRUMB-->
                                        <h3 class="page-title">
										Tasks list <small>Tasks created so far for employees <?php if(!empty($assignee_id)) echo "<b>".$assignee_full_name."</b>"; ?></small>
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
                     <div class="caption"><i class="fa fa-table"></i>Tasks <?php if(!empty($assignee_id)) echo "for <b>".$assignee_full_name."</b>"; ?></div>
                     <div class="actions">
                        <a href="<?php echo '?mKey='.$mKey.'&pKey=addregcode';?>" class="btn blue"><i class="fa fa-plus"></i> Create new task</a>
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
                     <table class="table table-striped table-bordered table-hover" id="sample_2">
                        <thead>
                           <tr>
                              <th class="table-checkbox"><input type="checkbox" class="group-checkable" data-set="#sample_2 .checkboxes" /></th>
                              <th>Title</th>
                              <!-- <th>Description</th> -->
                              <th>Assigned to</th>
                              <th>Deadline</th>
                              <th>State</th>
                              <th>Started</th>
                              <th>Completed</th>
                              <th>Created</th>
                              <th>Status</th>                            
                           </tr>
                        </thead>
                        <tbody>
                        
                        <?php 
		   		 while($row = mysqli_fetch_object($user_query))
			    {
				   
		   ?>
           
                           <tr class="odd gradeX">
                              <td><input type="checkbox" class="checkboxes" value="<?php echo $row->task_id;?>" /></td>
                              <td><a href="<?php echo '?mKey='.$mKey.'&pKey=editregcode&id='.$row->task_id;?>"><?php echo $row->task_title; ?></a></td>
                              
                              <!-- <td><?php echo substr(strip_tags($row->task_desc),0,30);?></td> -->

                              <td><?php 
                              
                              if(!empty($assignee_id)) echo $assignee_full_name;
                              
                              else if(empty($assignee_id) && !empty($row->user_first_name)) echo '<a href="'.$_SERVER['REQUEST_URI'].'&assignee_id='.$row->user_id.'">'.$row->user_first_name.' '.$row->user_last_name.'</a>';?></td>

                              <td><?php echo $row->task_deadline; ?></td>

                              <td><?php 
                              
                              $badge = ($row->task_state == 'not_started' ? 'danger' : ($row->task_state == 'started' ? 'warning' : 'success'));

                              echo '<span class="label label-md label-'.$badge.'">'.$row->task_state.'</span>'; 
                              
                              ?></td>

                              <td><?php echo $row->task_start_date; ?></td>
                              
                              <td><?php echo $row->task_end_date; ?></td>

                              <td><?php echo $row->task_created_time; ?></td>

                              <td>
                                 <?php if($row->task_status==1)
                                 
                                          echo '<span class="label label-md label-success">Active</span>'; 
                                          else if($row->task_status==0)
                                    
                                          echo '<span class="label label-md label-warning">InActive</span>';									
                                    ?>
                              </td>

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
                        <span class="font-red-thunderbird"><strong>Warning !</strong></span> Are you sure you want to delete this(these)  <span class="item_number font-red"></span> record(s)?         			</div>
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
   
   <script src="<?php echo SITE_URL_ADMIN; ?>assets/admin/pages/scripts/table-managed.js"></script>
   
    <script>
                jQuery(document).ready(function() {    
                    TableManaged.init();				   	   
                });
				
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
							   url:  '<?php echo SITE_URL_ADMIN.'reg_code_manager/delete_regcode.php' ; ?>',
							   dataType: "text",
							   data: {id: id},
							   success: function(data){		
									window.location.reload(true);
							   }								   		   		
						  });
					});
				});
				
				$('#confirmation_status').on('show.bs.modal', function(e) {
					
					 var status=$(e.relatedTarget).data('status');
					 
					 $(this).find('#delete_button').on('click', function(e) { 
					 
					 var id='';
					 
					 var table_name='task';
					 
					 var column_name='task_status';
					 
					 var column_id='task_id';
					 
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
	</script>	
    
    <!-----PAGE LEVEL SCRIPTS END--->    
        
        <!-- END JAVASCRIPTS -->
</body>
<!-- END BODY -->
</html>