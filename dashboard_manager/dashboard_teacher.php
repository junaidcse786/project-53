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
            	<div class="col-lg-3 col-md-3 col-sm-6 col-xs-12 hide">
					<div class="dashboard-stat purple-plum">
						<div class="visual">
							<i class="fa fa-globe"></i>
						</div>
						<div class="details">
							<div class="number" style="font-weight: bold">
								 <?php 
								 
								$sql_parent_menu="SELECT user_vacation_total FROM ".$db_suffix."user where user_id='".$_SESSION["user_id"]."'";	
								$parent_query = mysqli_query($db, $sql_parent_menu);
								
								$usr = mysqli_fetch_object($parent_query);
								$num = $usr->user_vacation_total;
								
								echo $num; 
								 ?>
							</div>
							<div class="desc">
								 Vacation day(s) <b>allowed</b> 
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
								 
								$sql="SELECT user_vacation_taken FROM ".$db_suffix."user where user_id='".$_SESSION["user_id"]."'";					
								$query = mysqli_query($db, $sql);
								
								$usr = mysqli_fetch_object($query);
								$num = $usr->user_vacation_taken;
								
								echo $num;
								 ?>
							</div>
							<div class="desc">
								Vacation days <b>taken</b> 
							</div>
						</div>
					</div>
				</div>
				<div class="col-lg-4 col-md-4 col-sm-6 col-xs-12">
					<div class="dashboard-stat yellow-gold">
						<div class="visual">
							<i class="fa fa-shopping-cart"></i>
						</div>
						<div class="details">
							<div class="number" style="font-weight: bold">
								 <?php 
								 
								 $sql = "select task_id from ".$db_suffix."task where task_state='not_started' AND user_id='".$_SESSION["user_id"]."'";					
								 $query = mysqli_query($db, $sql);
								 
								 $num=mysqli_num_rows($query);
								 
								 echo $num; 
								 ?>
							</div>
							<div class="desc">
								Tasks in <b>line</b> 
							</div>
						</div>
					</div>
				</div>
                <div class="col-lg-4 col-md-4 col-sm-6 col-xs-12">
					<div class="dashboard-stat green-seagreen">
						<div class="visual">
							<i class="fa fa-comments"></i>
						</div>
						<div class="details">
							<div class="number" style="font-weight: bold">
								 <?php 
								 
								$sql = "select task_id from ".$db_suffix."task where task_state='started' AND user_id='".$_SESSION["user_id"]."'";					
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
				
                <div class="col-lg-4 col-md-4 col-sm-6 col-xs-12">
					<div class="dashboard-stat blue">
						<div class="visual">
							<i class="fa fa-globe"></i>
						</div>
						<div class="details">
							<div class="number" style="font-weight: bold">
								<?php 
								 
								$sql = "select task_id from ".$db_suffix."task where task_state='complete' AND user_id='".$_SESSION["user_id"]."'";		
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
			<div class="row">
				<?php
				
				$sql = "SELECT * FROM ".$db_suffix."task WHERE task_status='1' AND task_state!='complete' AND user_id = '".$_SESSION["user_id"]."'";
				$user_query = mysqli_query($db,$sql);

				while($row = mysqli_fetch_object($user_query)):
				
				?>
				<div class="col-md-4">
					<div class="portlet box <?php echo ($row->task_state=='not_started')? 'yellow' : 'green'; ?>">
						<div class="portlet-title">
							<div class="caption">
								<i class="fa fa-tasks"></i>
								<span class="caption-subject">Task</span>
							</div>
							<div class="actions">
								<div class="btn-group">
									<a class="btn red btn-outline btn-circle btn-sm" href="#" data-toggle="modal" data-taskid="<?php echo $row->task_id; ?>" data-status="<?php echo ($row->task_state=='not_started')? "started" : "complete" ?>" data-target="#confirmation_status">
										<i class="fa fa-arrow-right"></i> <?php echo ($row->task_state=='not_started')? "Start task" : "Mark task as complete" ?>
									</a>
								</div>
							</div>
						</div>
						<div class="portlet-body">
							<div class="alert alert-<?php echo ($row->task_state=='not_started')? 'warning' : 'success'; ?>">
                                <?php echo $row->task_title; ?> 
							</div>							
							<?php echo $row->task_desc; ?>
						</div>
					</div>
				</div>
				<?php endwhile; ?>
			</div>                    
          
			<!--FOR ADMIN END -->            
            <!-- END PAGE CONTENT -->
            
	</div>
</div>    

<!-- END PAGE CONTAINER -->

        
        <!-- BEGIN FOOTER -->
        
        <?php require_once('footer.php'); ?>
        
        <!-- END FOOTER -->
        
		<div class="modal fade" id="confirmation_status">
            <div class="modal-dialog">
               <div class="modal-content">
                  <div class="modal-header">
                     <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                     <h4 class="modal-title">Status Change Confirmation</h4>
                  </div>
                  <div class="modal-body">
                        <span class="font-red-thunderbird"><strong>Warning !</strong></span> Are you sure you want to change the status of this task?
				  </div>
                  <div class="modal-footer">
                     <button id="delete_button" type="button" class="btn red-thunderbird">Change</button>
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

   <script>	

		$('#confirmation_status').on('show.bs.modal', function(e) {
			
			var status=$(e.relatedTarget).data('status');

			var id=$(e.relatedTarget).data('taskid')+',';
			
			$(this).find('#delete_button').on('click', function(e) {
			
				var table_name='task';
				
				var column_name='task_state';
				
				var column_id='task_id';			
			
				$.ajax({
					type: "POST",
					url:  '<?php echo SITE_URL_ADMIN.'reg_code_manager/change_status.php' ; ?>',
					dataType: "text",
					data: {id: id, status: status, table_name:table_name, column_name:column_name, column_id:column_id},
					success: function(data){		
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