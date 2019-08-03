<link rel="stylesheet" type="text/css" href="<?php echo SITE_URL_ADMIN; ?>assets/global/plugins/select2/select2.css" />

<link rel="stylesheet" href="<?php echo SITE_URL_ADMIN; ?>assets/global/plugins/datatables/plugins/bootstrap/dataTables.bootstrap.css" />

<link rel="stylesheet" type="text/css" href="<?php echo SITE_URL_ADMIN; ?>assets/global/plugins/bootstrap-datepicker/css/datepicker3.css"/>

<!-- BEGIN PAGE header-->

			<h3 class="page-title">
			<?php
			
				echo 'Dashboard <small>System Stats</small>';	
			
			
			?>
            </h3>
            <div class="page-bar">
				<ul class="page-breadcrumb">
					<li>
						<i class="fa fa-home"></i>
						<a href="<?php echo SITE_URL_ADMIN; ?>">Home</a>
					</li>
				</ul>
			</div>
<!-- END PAGE HEADER-->

			<!-- BEGIN PAGE CONTENT-->
            
            <!-- FOR ADMIN -->
            
            <div class="row">
            	<div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
					<div class="dashboard-stat purple-plum">
						<div class="visual">
							<i class="fa fa-globe"></i>
						</div>
						<div class="details">
							<div class="number" style="font-weight: bold">
								 <?php 
								 
								$sql_parent_menu="SELECT user_id FROM ".$db_suffix."user where role_id='".EMP_ROLE_ID."'";	
								$parent_query = mysqli_query($db, $sql_parent_menu);
								
								$num=mysqli_num_rows($parent_query);
								
								echo $num; 
								 ?>
							</div>
							<div class="desc">
								 Employee(s)
							</div>
						</div>
					</div>
				</div>
				<div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
					<div class="dashboard-stat red-intense">
						<div class="visual">
							<i class="fa fa-bar-chart-o"></i>
						</div>
						<div class="details">
							<div class="number" style="font-weight: bold">
								 <?php 
								 
								$sql="SELECT user_id FROM ".$db_suffix."user where user_status='1' AND role_id='".EMP_ROLE_ID."'";				
								$query = mysqli_query($db, $sql);
								
								$num=mysqli_num_rows($query);
								
								echo $num; 
								 ?>
							</div>
							<div class="desc">
								<b>Active</b> employee(s)
							</div>
						</div>
					</div>
				</div>
				<div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
					<div class="dashboard-stat yellow-gold">
						<div class="visual">
							<i class="fa fa-shopping-cart"></i>
						</div>
						<div class="details">
							<div class="number" style="font-weight: bold">
								 <?php 
								 
								$sql = "select task_id from ".$db_suffix."task where task_state='not_started'";				
								$query = mysqli_query($db, $sql);
								
								$num=mysqli_num_rows($query);
								
								echo $num; 
								 ?>
							</div>
							<div class="desc">
								 Tasks to <b>complete</b> 
							</div>
						</div>
					</div>
				</div>
                <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
					<div class="dashboard-stat green-seagreen">
						<div class="visual">
							<i class="fa fa-comments"></i>
						</div>
						<div class="details">
							<div class="number" style="font-weight: bold">
								 <?php 
								 
								$sql = "select task_id from ".$db_suffix."task where task_state='started'";					
								$query = mysqli_query($db, $sql);
								
								$num=mysqli_num_rows($query);
								
								echo $num; 
								 ?>
							</div>
							<div class="desc">
								 Tasks in <b>progress</b> 
							</div>
						</div>
					</div>
				</div>
				
                <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
					<div class="dashboard-stat blue">
						<div class="visual">
							<i class="fa fa-globe"></i>
						</div>
						<div class="details">
							<div class="number" style="font-weight: bold">
								<?php 
								 
								$sql = "select task_id from ".$db_suffix."task where task_state='complete'";		
								$parent_query = mysqli_query($db, $sql);
								
								$num=mysqli_num_rows($parent_query);
								
								echo $num; 
								 ?>
							</div>
							<div class="desc">
								 Tasks <b>completed</b> 
							</div>
						</div>
					</div>
				</div>
                <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12 hide">
					<div class="dashboard-stat red-intense">
						<div class="visual">
							<i class="fa fa-bar-chart-o"></i>
						</div>
						<div class="details">
							<div class="number" style="font-weight: bold">
								 <?php 
								 
								/* $sql = "select user_id from ".$db_suffix."user where role_id='16' AND user_charge='1'";				
								$query = mysqli_query($db, $sql);
								
								$num=mysqli_num_rows($query);
								
								echo $num;  */
								 ?>
							</div>
							<div class="desc">
								 Total Learners (chargeable)
							</div>
						</div>
					</div>
				</div>
			</div>                     
          
			<!--FOR ADMIN END -->            
            <!-- END PAGE CONTENT -->
            
	</div>
</div>    

<!-- END PAGE CONTAINER -->

        
        <!-- BEGIN FOOTER -->
        
        <?php require_once('footer.php'); ?>
        
        <!-- END FOOTER -->
        
        <div class="modal fade" id="confirmation">
            <div class="modal-dialog">
               <div class="modal-content">
                  <div class="modal-header">
                     <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                     <h4 class="modal-title">Confirmation</h4>
                  </div>
                  <div class="modal-body">
                        <span class="danger"><strong>Warning !</strong> Are you sure you want to perform this action?</span>         			</div>
                  <div class="modal-footer">
                     <button id="delete_button" type="button" class="btn red">Do it</button>
                     <button type="button" class="btn default" data-dismiss="modal">Close</button>
                  </div>
               </div>
               <!-- /.modal-content -->
            </div>
            <!-- /.modal-dialog -->
         </div>
        
        
        
      
        <!-- BEGIN CORE PLUGINS --> 
          
        
		<?php require_once('scripts.php'); ?>
        
        
       <!-----page level scripts start--->
       
   <script type="text/javascript" src="<?php echo SITE_URL_ADMIN; ?>assets/global/plugins/select2/select2.min.js"></script>
        
   <script type="text/javascript" src="<?php echo SITE_URL_ADMIN; ?>assets/global/plugins/datatables/media/js/jquery.dataTables.min.js"></script>
   
   <script type="text/javascript" src="<?php echo SITE_URL_ADMIN; ?>assets/global/plugins/datatables/plugins/bootstrap/dataTables.bootstrap.js"></script>
   
   <script src="<?php echo SITE_URL_ADMIN; ?>assets/admin/pages/scripts/table-managed.js"></script>
   
   <script type="text/javascript" src="<?php echo SITE_URL_ADMIN; ?>assets/global/plugins/datatables/extensions/TableTools/js/dataTables.tableTools.min.js"></script>
   
    <script>
                /* jQuery(document).ready(function() {    
                    TableManaged.init();							   	   
                }); */
				
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
				
	</script>	
   
       
   
    	<!-----page level scripts end--->
        
        <!-- END JAVASCRIPTS -->
</body>
<!-- END BODY -->
</html>      