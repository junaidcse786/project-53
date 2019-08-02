<!-----PAGE LEVEL CSS BEGIN--->

<link rel="stylesheet" type="text/css" href="<?php echo SITE_URL_ADMIN; ?>assets/global/plugins/select2/select2.css" />

<link rel="stylesheet" href="<?php echo SITE_URL_ADMIN; ?>assets/global/plugins/datatables/plugins/bootstrap/dataTables.bootstrap.css" />


<!-----PAGE LEVEL CSS END--->

<h3 class="page-title">Schüler, die diese &Uuml;bung (noch nicht) gemacht haben <small><strong><?php echo $_REQUEST["title"]; ?></strong></small></h3>

<div class="page-bar">         
    <ul class="page-breadcrumb">
            <li>
                    <i class="fa fa-home"></i>
                    <a href="<?php echo SITE_URL_ADMIN; ?>">Home</a>
                    <i class="fa fa-angle-right"></i>
            </li>
            
            <li>
                   <?php echo '<strong>'.$_SESSION["user_level"].'  </strong> <small>'.$_SESSION["user_org_name"].'</small>'; ?>  
            </li>
    </ul>
    <!-- END PAGE TITLE & BREADCRUMB-->
</div>                                             
                        <div class="row">
            <div class="col-md-12">
            
           	 <!-- BEGIN EXAMPLE TABLE PORTLET-->
               
               <div class="portlet box grey-cascade">
                  <div class="portlet-title">
                     <div class="caption"><i class="fa fa-table"></i>Schüler, die diese &Uuml;bung gemacht haben</div>
				  </div>
                  <div class="portlet-body">
                     <table class="table table-striped table-bordered table-hover" id="sample_2">
                        <thead>
                           <tr>
                              <th class="table-checkbox"><input type="checkbox" class="group-checkable" data-set="#sample_2 .checkboxes" /></th>
                              <th>Schüler</th>                                                 
							 <!-- <th>Best Score</th>-->
                              <th>Ø - Ergebnis</th>
                              <th>Letzter Versuch</th>
                              <th>Versuche</th>
                              <th></th>
                           </tr>
                        </thead>
                        <tbody>
                       
                        <?php 
					$those_who_have_done_it="";
					$sql = "SELECT * FROM ".$db_suffix."history h
							Left Join ".$db_suffix."user u on u.user_id=h.user_id where h.exercise_id='".$_REQUEST["exercise_id"]."' AND u.user_id IN (".STUDS_TO_LOOK_FOR_TEACHER.") GROUP BY h.user_id";
					$query = mysqli_query($db, $sql);
					
					while($row=mysqli_fetch_object($query))

					{
						$those_who_have_done_it.=$row->user_id.",";
						
				?>
						<tr class="odd gradeX">
                           
							<td><input type="checkbox" class="checkboxes" value="" /></td>
							  
                            <td><?php echo '<a href="'.SITE_URL_ADMIN.'?mKey=teachers&pKey=performance&id='.$row->user_id.'">'.$row->user_first_name." ".$row->user_last_name.'</a>'; ?></td>
							
							<?php 
							
							 $sql_inside="SELECT AVG(percentage) AS AVG_SCORE, MAX(percentage) AS BEST_SCORE, date_taken AS LAST_TIME FROM ".$db_suffix."history where user_id='$row->user_id' AND exercise_id='$row->exercise_id' ORDER BY date_taken DESC";
				   
						   $query_inside = mysqli_query($db, $sql_inside);
		
							if(mysqli_num_rows($query_inside) > 0)
							{
								$content     = mysqli_fetch_object($query_inside);
														
								$AVG_SCORE       = round($content->AVG_SCORE, 2).'%';
								$BEST_SCORE    = round($content->BEST_SCORE,2).'%';
								//$LAST_TIME  = date('d-m-Y',strtotime($content->LAST_TIME));
							}
							
							
							
							$sql_inside="SELECT date_taken AS LAST_TIME FROM ".$db_suffix."history where user_id='$row->user_id' AND exercise_id='$row->exercise_id' ORDER BY date_taken DESC LIMIT 1";
				   
						   $query_inside = mysqli_query($db, $sql_inside);
		
							if(mysqli_num_rows($query_inside) > 0)
							{
								$content     = mysqli_fetch_object($query_inside);														
								$LAST_TIME  = date('d-m-Y',strtotime($content->LAST_TIME));
							}
														
							?>
                            
							<!--<td><?php echo $BEST_SCORE;?></td>-->
                            
                            <td><?php echo $AVG_SCORE;?></td>
                            
                            <td><?php echo ($LAST_TIME==date('d-m-Y'))? 'Heute' : $LAST_TIME;?></td>
                              
                            <td><?php 
							   
							   $has_done=mysqli_num_rows(mysqli_query($db,"SELECT exercise_id FROM ".$db_suffix."history where exercise_id='$row->exercise_id' AND user_id='$row->user_id'"));
								  
							  if($has_done>=0 && $has_done<10)
							   
									$game_over='0'.$has_done;
									
							  else

									$game_over=$has_done;
							   
							  echo '<span class="badge badge-info">'.$game_over.'</span>';
							   
							   if($has_done>1)
							   
							   		 echo ' <a href="'.SITE_URL_ADMIN.'?mKey=teachers&pKey=charts&exercise_id='.$row->exercise_id.'&user_id='.$row->user_id.'" class="btn default btn-xs yellow-gold">Diagramm</a>';
							   
							   ?></td>
                               
                               <td><a href="<?php echo '?mKey=sendmessage&parent='.$row->user_id;?>" class="btn default btn-xs green"><i class="fa fa-envelope-square"></i> Nachricht senden</a></td>
                           
					   </tr>
                           
				<?php } $those_who_have_done_it.="0"; ?>       
                        </tbody>
                     </table>
                  
                  </div>
               </div>
               <!-- END EXAMPLE TABLE PORTLET-->
            </div>
         </div>
         
         
         <div class="row">
            <div class="col-md-12">
            
           	 <!-- BEGIN EXAMPLE TABLE PORTLET-->
               
               <div class="portlet box red-thunderbird">
                  <div class="portlet-title">
                     <div class="caption"><i class="fa fa-table"></i>Schüler, die diese &Uuml;bung noch nicht gemacht haben</div>
				  </div>
                  <div class="portlet-body">
                     <table class="table table-striped table-bordered table-hover" id="sample_3">
                        <thead>
                           <tr>
                              <th class="table-checkbox"><input type="checkbox" class="group-checkable" data-set="#sample_3 .checkboxes1" /></th>
                              <th>Schüler</th>                                                 
							  <th></th>
                           </tr>
                        </thead>
                        <tbody>
                       
                        <?php 
		   		
					$sql = "SELECT u.user_id, u.user_first_name, u.user_last_name FROM ".$db_suffix."user u where u.user_id NOT IN (".$those_who_have_done_it.") AND u.user_id IN (".STUDS_TO_LOOK_FOR_TEACHER.")";
					$query = mysqli_query($db, $sql);
					
					while($row=mysqli_fetch_object($query))

					{
						
				?>
						<tr class="odd gradeX">
                           
							<td><input type="checkbox" class="checkboxes1" value="" /></td>
							  
                            <td><?php echo '<a href="'.SITE_URL_ADMIN.'?mKey=teachers&pKey=performance&id='.$row->user_id.'">'.$row->user_first_name." ".$row->user_last_name.'</a>'; ?></td>
							
							<td><?php 
                                  
                                  //echo '<a href="'.SITE_URL_ADMIN.'?mKey=teachers&pKey=performance&id='.$row->user_id.'" class="btn default btn-xs yellow-gold">View Performance</a>'; 
                                  
                                  ?>
                                  
                                  <a href="<?php echo '?mKey=sendmessage&parent='.$row->user_id;?>" class="btn default btn-xs green"><i class="fa fa-envelope-square"></i> Nachricht senden</a></td>
                           
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
   
   <script src="<?php echo SITE_URL_ADMIN; ?>assets/admin/pages/scripts/table-managed.js"></script>
   
    <script>
                jQuery(document).ready(function() {    
                    TableManaged.init();				   	   
                });
				
	</script>	
    
    <!-----PAGE LEVEL SCRIPTS END--->    
        
        <!-- END JAVASCRIPTS -->
</body>
<!-- END BODY -->
</html>