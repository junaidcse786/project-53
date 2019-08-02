<?php 

$id=$_REQUEST["id"];

/*$sql = "SELECT question_id, question_wrong_hits_user FROM ".$db_suffix."question where exercise_id='$id'";
$query = mysqli_query($db, $sql);

while($row=mysqli_fetch_object($query))
{
	$wrong_users       = $row->question_wrong_hits_user;

	if($wrong_users!=''){
		$words = explode(" ", $wrong_users);
		$result = array_combine($words, array_fill(0, count($words), 0));
		
		foreach($words as $word) {
			$result[$word]++;
		}
		
		
		foreach($result as $word => $count) {
							
			$sql1 = "SELECT user_id FROM ".$db_suffix."user where user_id='$word'  ";
			$query1 = mysqli_query($db, $sql1);
			
			if(mysqli_num_rows($query1) <= 0)
			
				$wrong_users=str_replace($word, '', $wrong_users);
			
		}
		
		$wrong_users=trim($wrong_users);
		
		if($wrong_users!='')
		
			$num_faults=count(explode(" ", $wrong_users));
			
		else
		
			$num_faults=0;	
		
		mysqli_query($db, "UPDATE ".$db_suffix."question SET question_wrong_hits_user='$wrong_users' where question_id='$row->question_id' ");
		
		mysqli_query($db, "UPDATE ".$db_suffix."question SET question_wrong_hits='$num_faults' where question_id='$row->question_id' ");
	}
}*/

$users_under_control_teacher=$studs_to_look_for_array_teacher;

$sql = "select * from ".$db_suffix."question q
		Left Join ".$db_suffix."exercise e on e.exercise_id=q.exercise_id WHERE q.exercise_id = '$id' ORDER BY length(q.question_wrong_hits_user) DESC";				
$query = mysqli_query($db, $sql);

?>

<!-----PAGE LEVEL CSS BEGIN--->

<link rel="stylesheet" type="text/css" href="<?php echo SITE_URL_ADMIN; ?>assets/global/plugins/select2/select2.css" />

<link rel="stylesheet" href="<?php echo SITE_URL_ADMIN; ?>assets/global/plugins/datatables/plugins/bootstrap/dataTables.bootstrap.css" />


<!-----PAGE LEVEL CSS END--->


                        <!-- BEGIN PAGE TITLE & BREADCRUMB-->
                        
                        <h3 class="page-title">
                                                Fragen im Aufgabenpool<small> <strong><?php echo $_REQUEST["title"];  ?></strong></small>
                                        </h3>
                                        
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
                                        
                               
                        <!-- END PAGE HEADER-->
                        <!-- BEGIN PAGE CONTENT-->
                                              
                        <div class="row">
            <div class="col-md-12">
            
               <!-- BEGIN EXAMPLE TABLE PORTLET-->
               
               <div class="portlet box grey-cascade">
                  <div class="portlet-title">
                     <div class="caption"><i class="fa fa-table"></i>Fragen</div>
                     <div class="actions">                     
                       <?php 
							  
							  	echo ' <a target="_blank" href="'.SITE_URL.'exercise-trial/'.$_REQUEST["id"].'/'. $_REQUEST["title"].'" class="btn default blue-ebonyclay"><i class="fa fa-video-camera"></i> &Uuml;bung anzeigen</a>'; 
								
								echo ' <a href="'.SITE_URL_ADMIN.'teacher_things/stats_update.php?exe_id='.$id.'" class="btn default gold"><i class="fa fa-refresh"></i> Stat. aktualisieren</a>'; 
								
								
							  
						?>
						
                     </div>
                  </div>
                  <div class="portlet-body">
                     <table class="table table-striped table-bordered table-hover" id="sample_2">
                        <thead>
                           <tr>
                           	  <th class="table-checkbox"><input type="checkbox" class="group-checkable" data-set="#sample_2 .checkboxes" /></th>
                              <th>Fragen</th>
                              <th >Fehler (Anzahl)</th>
                              <th >Aufrufe (Anzahl)</th>
                              <th >Fehler %</th>
							  <th ></th>
                              <th ></th>
                           </tr>
                        </thead>
                        <tbody>
                        
                        <?php 
		   		 while($row = mysqli_fetch_object($query))
			    {
				   
		   				?>
           
                           <tr class="odd gradeX">
                           
                           	  <td><input type="checkbox" class="checkboxes" /></td>                              
                              <td><?php echo substr(strip_tags($row->question_desc),0,30);?></td>
                              
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
                              
                              <td><?php 
							  
							  	echo '<a target="_blank" href="'.SITE_URL.'exercise-trial/'.$row->exercise_id.'/'.$row->exercise_title.'/'.$row->question_id.'" class="btn default btn-xs yellow-gold">Preview</a>'; 
							  
							  ?></td>
                              
                              <td> <?php 
							  
							  $tag_actual_users=0;
							  
							  foreach($users_under_control_teacher as $redeemed_value){	
									
									if(preg_match('/\b('.$redeemed_value.')\b/', $row->question_wrong_hits_user)){
										 $tag_actual_users=1; break;
									}
							  }
							  	
							  
							  if($wrong_hits_in_user_final>0 && $tag_actual_users==1) { ?>  <a href="<?php echo SITE_URL_ADMIN.'?mKey=teachers&pKey=users&id='.$row->question_id; ?>" class="btn default btn-xs red-stripe">Fehler gemacht von </a> <?php } ?></td>
                              
                                                            
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
				
	</script>	
    
    <!-----PAGE LEVEL SCRIPTS END--->    
        
        <!-- END JAVASCRIPTS -->
</body>
<!-- END BODY -->
</html>