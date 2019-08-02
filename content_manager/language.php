<?php 
	
$sql = "SELECT * FROM ".$db_suffix."lang ORDER BY lang_id ASC";
$news_query = mysqli_query($db,$sql);

?>

<!-----PAGE LEVEL CSS BEGIN--->

<link rel="stylesheet" type="text/css" href="<?php echo SITE_URL_ADMIN; ?>assets/global/plugins/select2/select2.css" />

<link rel="stylesheet" href="<?php echo SITE_URL_ADMIN; ?>assets/global/plugins/datatables/plugins/bootstrap/dataTables.bootstrap.css" />


<!-----PAGE LEVEL CSS END--->


                                        <!-- BEGIN PAGE TITLE & BREADCRUMB-->
                                        <h3 class="page-title">
                                                <?php echo $menus["$mKey"]["$pKey"]; ?> <small>The list of languages already created for vocabulary</small>
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
            
            <div class="portlet box grey-cascade">
						<div class="portlet-title">
							<div class="caption">
								<i class="fa fa-edit"></i>Languages
							</div>
						</div>
						<div class="portlet-body">
							<div class="table-toolbar">
								<div class="row">
									<div class="col-md-12">
										<div class="btn-group pull-right">
											<a href="<?php echo SITE_URL_ADMIN.'?mKey='.$mKey.'&pKey=addlanguage'; ?>"><button id="sample_editable_1_new" class="btn green">
											<i class="fa fa-plus"></i> Add New language 
											</button></a>
										</div>
									</div>
								</div>
							</div>
							<table class="table table-striped table-hover table-bordered" id="sample_editable_1">
							<thead>
							<tr>
								<th>
									 Language Title
								</th>
                                <th>
									 Status
								</th>
								<th>
									 Actions
								</th>
							</tr>
							</thead>
							<tbody>
							
                             <?php 
		   		 while($row = mysqli_fetch_object($news_query))
			    {
				   
		   ?>
                            
							<tr>
								<td>
									 <?php echo $row->lang_title;?>
								</td>
                                
                                <td>
							  <?php if($row->lang_status)
							  
											echo '<span class="label label-md label-success">Active</span>'; 
									else 
											echo '<span class="label label-md label-danger">InActive</span>';
									?>
                              </td>
								
                                <td>
									<a href="<?php echo '?mKey='.$mKey.'&pKey=editlanguage&id='.$row->lang_id;?>" class="btn default btn-xs purple"><i class="fa fa-edit"></i> Edit</a>
                              
                              <a data-href="<?php echo SITE_URL_ADMIN; ?>content_manager/delete_language.php?id=<?php echo $row->lang_id;?>" data-toggle="modal" href="#" data-target="#confirmation" class="btn default btn-xs red delete"><i class="fa fa-trash"></i> Delete</a>
								</td>
							</tr>
				<?php } ?>
                
                			</tbody>
							</table>
						</div>
					</div>
					
            </div>
         </div>
         
         
         
<!-----MODALS FOR THIS PAGE START ---->


<div class="modal fade" id="confirmation">
            <div class="modal-dialog">
               <div class="modal-content">
                  <div class="modal-header">
                     <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                     <h4 class="modal-title">Delete Confirmation</h4>
                  </div>
                  <div class="modal-body">
                        <span class="danger"><strong>Warning !</strong> Are you sure you want to delete this item?</span>         			</div>
                  <div class="modal-footer">
                     <button id="delete_button" type="button" class="btn red">Delete</button>
                     <button type="button" class="btn default" data-dismiss="modal">Close</button>
                  </div>
               </div>
               <!-- /.modal-content -->
            </div>
            <!-- /.modal-dialog -->
         </div>
         
         <div class="modal fade" id="confirmation_all">
            <div class="modal-dialog">
               <div class="modal-content">
                  <div class="modal-header">
                     <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                     <h4 class="modal-title">Delete Confirmation</h4>
                  </div>
                  <div class="modal-body">
                        <span class="danger"><strong>Warning !</strong> Are you sure you want to delete these items?</span>         			</div>
                  <div class="modal-footer">
                     <button id="delete_button" type="button" class="btn red">Delete</button>
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
   
   <script src="<?php echo SITE_URL_ADMIN; ?>assets/admin/pages/scripts/table-managed.js"></script>
   
    <script>
                jQuery(document).ready(function() {    
                    TableManaged.init();				   	   
                });
				
				$('#confirmation').on('show.bs.modal', function(e) {
					 
					 var target=$(e.relatedTarget).data('href');
					 
					$(this).find('#delete_button').on('click', function(e) { 
					 
					 	$.ajax({
								   type: "POST",
								   url:  target,
								   success: function(data){		
										window.location.reload(true);
								   },
								   error : function(data){
									    window.location.reload(true);
								   }			   		
						   });
					 
					});
		        });
				
				$('#confirmation_all').on('show.bs.modal', function(e) {
					 
					 $(this).find('#delete_button').on('click', function(e) { 
					 
					 $('input:checkbox[class=checkboxes]:checked').each(function(){
						 
						 var target='content_manager/delete_language.php?id='+$(this).val();
						 	
						$.ajax({
								   type: "POST",
								   url:  target,								   		   		
						      });
					 })
					 
					 	window.location.reload(true);
						
					});
		        });
	</script>	
    
    <!-----PAGE LEVEL SCRIPTS END--->    
        
        <!-- END JAVASCRIPTS -->
</body>
<!-- END BODY -->
</html>