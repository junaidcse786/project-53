<?php 
	
$sql = "SELECT * FROM ".$db_suffix."reminder WHERE user_id='".$_SESSION["user_id"]."' ORDER BY r_remind_time DESC";
$news_query = mysqli_query($db,$sql);

?>

<!-----PAGE LEVEL CSS BEGIN--->

<link rel="stylesheet" type="text/css" href="<?php echo SITE_URL_ADMIN; ?>assets/global/plugins/select2/select2.css" />

<link rel="stylesheet" href="<?php echo SITE_URL_ADMIN; ?>assets/global/plugins/datatables/plugins/bootstrap/dataTables.bootstrap.css" />


<!-----PAGE LEVEL CSS END--->


                                        <!-- BEGIN PAGE TITLE & BREADCRUMB-->
                                        <h3 class="page-title">
                                                <?php echo $menus["$mKey"]["$pKey"]; ?>
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
                     <div class="caption"><i class="fa fa-table"></i>Erinnerungsmail</div>
                     <div class="actions">
                        <a href="<?php echo SITE_URL_ADMIN.'?mKey='.$mKey.'&pKey=add_reminder'; ?>" class="btn blue"><i class="fa fa-plus"></i> <?php echo $menus[$mKey]["add_reminder"]; ?></a>                  	
                        <div class="btn-group">
                           <a class="btn green" href="#" data-toggle="dropdown">
                           <i class="fa fa-cogs"></i> Aktionen
                           <i class="fa fa-angle-down"></i>
                           </a>
                           <ul class="dropdown-menu pull-right">
                              <li><a href="#" data-toggle="modal" data-target="#confirmation_all"><i class="fa fa-trash"></i> Löschen</a></li>                              
                           </ul>
                        </div>                        
                     </div>
                  </div>
                  <div class="portlet-body">
                     <table class="table table-striped table-bordered table-hover" id="sample_2">
                        <thead>
                           <tr>
                              <th class="table-checkbox"><input type="checkbox" class="group-checkable" data-set="#sample_2 .checkboxes" /></th>
                              <th>Titel</th>
                              <th >Datum und Zeit</th>
                              <th >E-Mail schicken?</th> 
                              <th >Verschickt?</th>                              
                           </tr>
                        </thead>
                        <tbody>
                        
                        <?php 
		   		 while($row = mysqli_fetch_object($news_query))
			    {
				   
		   ?>
           
                           <tr class="odd gradeX">
                              <td><input type="checkbox" class="checkboxes" value="<?php echo $row->r_id;?>" /></td>
                              <td><a href="<?php echo '?mKey='.$mKey.'&pKey=edit_reminder&id='.$row->r_id;?>"><?php echo $row->r_title;?></a></td>
                              
                              <td><?php echo $row->r_remind_time;?></td>
                              
                              <td>
							  <?php if($row->r_send_mail)
							  
											echo '<span class="label label-md label-success">Ja</span>'; 
									else 
											echo '<span class="label label-md label-danger">Nein</span>';
									?>
                              </td>
                              <td>
							  <?php if($row->r_seen)
							  
											echo '<span class="label label-md label-success">Ja</span>'; 
									else 
											echo '<span class="label label-md label-danger">Nein</span>';
									?>
                              </td>
                              <!--<td>
                              
                              <a href="<?php echo '?mKey='.$mKey.'&pKey=editcontent&id='.$row->content_id;?>" class="btn default btn-xs purple"><i class="fa fa-edit"></i> Edit</a>
                              
                              <a data-href="<?php echo SITE_URL_ADMIN; ?>content_manager/delete_content.php?id=<?php echo $row->content_id;?>" data-toggle="modal" href="#" data-target="#confirmation" class="btn default btn-xs red delete"><i class="fa fa-trash"></i> Delete</a>
                              </td>  -->                             
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
                     <h4 class="modal-title">Bestätigung</h4>
                  </div>
                  <div class="modal-body">
                        <span class="font-red-thunderbird"><strong>Hinweis !</strong></span> Möchten sie diese Artikel wirklich löschen?         			</div>
                  <div class="modal-footer">
                     <button id="delete_button" type="button" class="btn red-thunderbird">Ja</button>
                     <button type="button" class="btn default" data-dismiss="modal">Schließen</button>
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
				
				$('#confirmation_all').on('show.bs.modal', function(e) {
					 
					 $(this).find('#delete_button').on('click', function(e) { 
					 
					 var id='';
					 
					 $('input:checkbox[class=checkboxes]:checked').each(function(){
						 
						id=id+$(this).val()+',';
					 })
					 
						$.ajax({
							   type: "POST",
							   url:  '<?php echo SITE_URL_ADMIN.'reminder_manager/delete_reminder.php' ; ?>',
							   dataType: "text",
							   data: {id: id},
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