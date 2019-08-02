<?php 

$id=$_REQUEST["id"];

$sql = "SELECT question_wrong_hits_user FROM ".$db_suffix."question where question_id='$id' ";
$query = mysqli_query($db, $sql);

if(mysqli_num_rows($query) > 0)
{
	$content     = mysqli_fetch_object($query);
	$wrong_users       = $content->question_wrong_hits_user;
}

$words = explode(" ", $wrong_users);
$result = array_combine($words, array_fill(0, count($words), 0));

foreach($words as $word) {
    $result[$word]++;
}
arsort($result);

$wrong_users_sql='';

foreach($result as $word => $count) {
					
	$sql = "SELECT user_id FROM ".$db_suffix."user where user_id='$word' ";
	$query1 = mysqli_query($db, $sql);
	
	if(mysqli_num_rows($query1) <= 0)
			
		$wrong_users=str_replace($word, '', $wrong_users);		
	else
					
		$wrong_users_sql.=$word.', ';
}

$wrong_users_sql=substr($wrong_users_sql,0,-2);

$wrong_users=trim($wrong_users);
		
/*if($wrong_users!='')

	$num_faults=count(explode(" ", $wrong_users));
	
else

	$num_faults=0;
	
mysqli_query($db, "UPDATE ".$db_suffix."question SET question_wrong_hits='$num_faults' where question_id='$id' ");*/		

mysqli_query($db, "UPDATE ".$db_suffix."question SET question_wrong_hits_user='$wrong_users' where question_id='$id' ");




?>

<!-----PAGE LEVEL CSS BEGIN--->

<link rel="stylesheet" type="text/css" href="<?php echo SITE_URL_ADMIN; ?>assets/global/plugins/select2/select2.css" />

<link rel="stylesheet" href="<?php echo SITE_URL_ADMIN; ?>assets/global/plugins/datatables/plugins/bootstrap/dataTables.bootstrap.css" />


<!-----PAGE LEVEL CSS END--->

<h3 class="page-title">Schüler, die diese Frage falsch beantwortet haben.</h3>

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
                     <div class="caption"><i class="fa fa-table"></i>Nutzer</div>
				  </div>
                  <div class="portlet-body">
                     <table class="table table-striped table-bordered table-hover" id="sample_2">
                        <thead>
                           <tr>
                              <th class="table-checkbox"><input type="checkbox" class="group-checkable" data-set="#sample_2 .checkboxes" /></th>
                              <th>Schüler</th>                                                 
							  <th>Fehler (Anzahl)</th>
							  <th></th>
                           </tr>
                        </thead>
                        <tbody>
                       
                        <?php 
		   		
					if($wrong_users_sql=='')
					
						{ $wrong_users_sql='0'; echo '<div class="alert alert-success alert-dismissable">
                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true"></button>
                        <strong>Information !</strong> None of the students from your batch has made any mistake on this question.
                     </div> '; }
					
					$sql = "SELECT * FROM ".$db_suffix."user where user_id IN (".$wrong_users_sql.") AND user_org_name='".$_SESSION["user_org_name"]."' AND user_level='".$_SESSION["user_level"]."'";
					$query = mysqli_query($db, $sql);
					
					while($row=mysqli_fetch_object($query))

					{
						$user_name  = $row->user_first_name.' '.$row->user_last_name;
						
				?>
						<tr class="odd gradeX">
                           
							<td><input type="checkbox" class="checkboxes" value="" /></td>
							  
                            <td><?php echo $user_name;?></td>
							
							<td><?php echo $result[$row->user_id]; ?></td>
							
							<td><a href="<?php echo '?mKey=sendmessage&parent='.$word;?>" class="btn default btn-xs green"><i class="fa fa-envelope-square"></i> Nachricht senden</a></td>
                           
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