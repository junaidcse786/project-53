<?php 

$BATCH_BELOW_EXE_AVG=65;
	$sql = "select * from ".$db_suffix."teach_settings where ts_lang_level = '".$_SESSION["user_level"] ."' AND ts_org_name='".$_SESSION["user_org_name"]."' AND ts_config_name='BATCH_BELOW_EXE_AVG'";				
	$query = mysqli_query($db, $sql);
	//$has_a_NO_EXE_LIMIT=mysqli_num_rows($query);	
	if(mysqli_num_rows($query) > 0)
	{
		$content     = mysqli_fetch_object($query);
		$BATCH_BELOW_EXE_AVG = $content->ts_config_value;
	}
	else
	
		mysqli_query($db, "INSERT INTO ".$db_suffix."teach_settings SET ts_config_value='$BATCH_BELOW_EXE_AVG', ts_config_name='BATCH_BELOW_EXE_AVG', ts_lang_level = '".$_SESSION["user_level"] ."', ts_org_name='".$_SESSION["user_org_name"]."'");
		
		
	$STUDENT_BELOW_LAST_3_AVG=65;
	$sql = "select * from ".$db_suffix."teach_settings where ts_lang_level = '".$_SESSION["user_level"] ."' AND ts_org_name='".$_SESSION["user_org_name"]."' AND ts_config_name='STUDENT_BELOW_LAST_3_AVG'";				
	$query = mysqli_query($db, $sql);
	//$has_a_NO_EXE_LIMIT=mysqli_num_rows($query);	
	if(mysqli_num_rows($query) > 0)
	{
		$content     = mysqli_fetch_object($query);
		$STUDENT_BELOW_LAST_3_AVG = $content->ts_config_value;
	}
	else
	
		mysqli_query($db, "INSERT INTO ".$db_suffix."teach_settings SET ts_config_value='$STUDENT_BELOW_LAST_3_AVG', ts_config_name='STUDENT_BELOW_LAST_3_AVG', ts_lang_level = '".$_SESSION["user_level"] ."', ts_org_name='".$_SESSION["user_org_name"]."'");	
	
	
	
	$STUDENT_BELOW_ALL_EXE_AVG=65;
	$sql = "select * from ".$db_suffix."teach_settings where ts_lang_level = '".$_SESSION["user_level"] ."' AND ts_org_name='".$_SESSION["user_org_name"]."' AND ts_config_name='STUDENT_BELOW_ALL_EXE_AVG'";				
	$query = mysqli_query($db, $sql);
	//$has_a_NO_EXE_LIMIT=mysqli_num_rows($query);	
	if(mysqli_num_rows($query) > 0)
	{
		$content     = mysqli_fetch_object($query);
		$STUDENT_BELOW_ALL_EXE_AVG = $content->ts_config_value;
	}
	else
	
		mysqli_query($db, "INSERT INTO ".$db_suffix."teach_settings SET ts_config_value='$STUDENT_BELOW_ALL_EXE_AVG', ts_config_name='STUDENT_BELOW_ALL_EXE_AVG', ts_lang_level = '".$_SESSION["user_level"] ."', ts_org_name='".$_SESSION["user_org_name"]."'");
		

$batch_below_exe_avg=$BATCH_BELOW_EXE_AVG;

$student_below_last_3_avg=$STUDENT_BELOW_LAST_3_AVG;

$student_below_all_exe_avg=$STUDENT_BELOW_ALL_EXE_AVG;


$alert_message=""; $alert_box_show="hide"; $alert_type="success";

$students_string=STUDS_TO_LOOK_FOR_TEACHER; $students=array();
	
$sql = "SELECT user_id, user_first_name, user_last_name from ".$db_suffix."user u where u.user_id IN (".STUDS_TO_LOOK_FOR_TEACHER.")";				
$query = mysqli_query($db, $sql);

while($row = mysqli_fetch_object($query)){
	
	//array_push($students, $row->user_id);
	
	$students[$row->user_id]=array(
		
		"user_first_name" => $row->user_first_name,
		
		"user_last_name" => $row->user_last_name,
	
	);
	
}
	

$mandate_exe_id=array(); $mandate_exe_id_string="";

$sql = "select me.exercise_id, e.exercise_title from ".$db_suffix."mandat_exe me

LEFT JOIN ".$db_suffix."exercise e ON me.exercise_id=e.exercise_id WHERE me.lang_level = '".$_SESSION["user_level"] ."' AND me.org_name='".$_SESSION["user_org_name"]."' AND me.me_status='1'";
				
$query = mysqli_query($db, $sql);

$has_mandate=mysqli_num_rows($query);

while($content=mysqli_fetch_object($query))

{	
	//array_push($mandate_exe_id, $content->exercise_id);
	
	$mandate_exe_id[$content->exercise_id]=array(
		
		"exercise_title" => $content->exercise_title,
	
	);	
	
	$mandate_exe_id_string.=$content->exercise_id.',';		
}

$mandate_exe_id_string=substr($mandate_exe_id_string,0,-1);	

if($has_mandate<=0){
	
	$alert_box_show="show";
	$alert_type="danger";
	$alert_message="Noch kein Aufgabenpaket gemacht";

}
else{

	$below_exe_avg_exe_id=array();
	
	$sql = "SELECT e.exercise_id, e.exercise_title, AVG(h.percentage) AS EXE_AVG, COUNT(DISTINCT h.user_id) AS DAMN_COUNT FROM ".$db_suffix."history h
			Left Join ".$db_suffix."exercise e on e.exercise_id=h.exercise_id WHERE h.exercise_id IN (".$mandate_exe_id_string.") AND h.user_id IN (".$students_string.") GROUP BY h.exercise_id HAVING EXE_AVG<$batch_below_exe_avg AND DAMN_COUNT/".count($students).">=0.5 ORDER BY EXE_AVG ASC";
	$news_query = mysqli_query($db,$sql);
	
	$i=0;
	while($row=mysqli_fetch_object($news_query)){
	
		$below_exe_avg_exe_id[$i]["exercise_id"]=$row->exercise_id;
		
		$below_exe_avg_exe_id[$i]["exercise_title"]=$row->exercise_title;
		
		$below_exe_avg_exe_id[$i]["EXE_AVG"]=round($row->EXE_AVG, 2);
		
		$i++;
	}

}

?>

<!-----PAGE LEVEL CSS BEGIN--->

<!-----PAGE LEVEL CSS END--->

<h3 class="page-title"><?php
			
				echo '<strong>'.$_SESSION["user_level"].' </strong> <small>'.$_SESSION["user_org_name"].'</small>';		
			
			
			?></h3>

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
                                          
<div class="row">
<div class="portlet box red">
    <div class="portlet-title">
        <div class="caption">
            <i class="fa fa-database"></i>
            Rotes Brett
        </div>        
    </div>
    <div class="portlet-body">
    
    	<?php if($has_mandate>0) {?>
        
        <div class="alert alert-danger">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true"></button>
            
            Klicke Sie auf <strong>Übungen</strong>, um die Übungen zu sehen, bei denen der Kursdurchschnitt unter <?php echo '<b>'.$batch_below_exe_avg.'%</b>.' ?> liegt.  <br />
            
            Klicken Sie auf <strong>Letzte 3 Durchgänge</strong>, um diejenigen Schüler zu sehen, bei denen der Durchschnitt der letzten drei Durchgänge einer Übung unter <?php echo '<b>'.$student_below_last_3_avg.'%</b>.' ?> liegt. <br />
            
            Klicken Sie auf <strong>Alle Durchgänge</strong>, um diejenigen Schüler zu sehen, die bei mindestens einer Übung einen Gesamtdurchschnitt von unter <?php echo '<b>'.$student_below_all_exe_avg.'%</b>.' ?> haben.
            
        </div>
        <?php } ?>
    	<div class="alert alert-<?php echo $alert_type; ?> <?php echo $alert_box_show; ?>">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true"></button>
            <?php echo $alert_message; ?>
        </div>  
        
        <?php if($has_mandate>0) { ?>      
        
        <div class="tabbable-custom ">
            <ul class="nav nav-tabs ">
                <li class="active">
                    <a href="#ubungen" data-toggle="tab">
                    &Uuml;bunge(n) </a>
                </li>
                <li>
                    <a href="#students_last_3" data-toggle="tab">
                    Letzte 3 Durchgänge</a>
                </li>
                <li>
                    <a href="#students_avg" data-toggle="tab">
                    Alle Durchgänge </a>
                </li>
            </ul>
            <div class="tab-content">
                <div class="tab-pane active" id="ubungen">
                    <div class="table-scrollable">                    	
                        <table class="table table-hover">
                        <thead>
                        <tr>
                            <th width="10%">
                                 #
                            </th>
                            <th width="50%">
                                 &Uuml;bung
                            </th>
                            <th width="40%">
                                 Ø - Ergebnis
                            </th>
                        </tr>
                        </thead>
                        <tbody>
                        
                        <?php 
							$i=1;
							foreach($below_exe_avg_exe_id as $value){
							
								echo '<tr>								
											<td>'.$i.'</td>
											
											<td><a href="'.SITE_URL_ADMIN.'?mKey=teachers&pKey=questions&id='.$value["exercise_id"].'&title='.$value["exercise_title"].'">'.$value["exercise_title"].'</a></td>
											
											<td>'.$value["EXE_AVG"].'%</td>								
								
									  </tr>';
									  
								$i++;	  
							
							}
						
						?>
                        
                        </tbody>
                        </table>
                    </div>
                </div>
                <div class="tab-pane" id="students_last_3">
                    <div class="table-scrollable">
                        <table class="table table-hover">
                        <thead>
                        <tr>
                            <th>
                                 #
                            </th>
                            <th>
                                 Schüler
                            </th>
                            <th>
                                 &Uuml;bung & Ø - Ergebnis
                            </th>
                        </tr>
                        </thead>
                        <tbody>
                        
                        <?php 
						$i=1;
						foreach($students as $key => $value){
							
							$exe_with_probs='';
							
							foreach($mandate_exe_id as $key1 => $value1){
								
								$sql = "SELECT AVG(pam.percentage) AS AVG_PER, COUNT(exercise_id) AS GOO  FROM (SELECT percentage, exercise_id FROM ".$db_suffix."history WHERE user_id = '$key' AND exercise_id='$key1' ORDER BY DATE_TAKEN DESC LIMIT 3) pam GROUP BY pam.exercise_id HAVING GOO>=3 AND AVG_PER < $student_below_last_3_avg";
								
								$news_query = mysqli_query($db,$sql);
								
								if(mysqli_num_rows($news_query)>0){			
								
									$row=mysqli_fetch_object($news_query);				
									
									$dummy_exe_percentage=round($row->AVG_PER,2);
									
									$exe_with_probs.='<a href="'.SITE_URL_ADMIN.'?mKey=teachers&pKey=questions&id='.$key1.'&title='.$value1["exercise_title"].'">'.$value1["exercise_title"].' (<b>'.$dummy_exe_percentage.'%</b>)</a><br /><br />';		
									
								}
							}
							//$exe_with_probs=substr($exe_with_probs, 0, -6);
							if($exe_with_probs!=''){
							
								echo '<tr>
								
											<td>'.$i.'</td>
											
											<td><a href="'.SITE_URL_ADMIN.'?mKey=teachers&pKey=performance&id='.$key.'&user_first_name='.$value["user_first_name"].'&user_last_name='.$value["user_last_name"].'">'.$value["user_first_name"].' '.$value["user_last_name"].'</a></td>
											
											<td>'.$exe_with_probs.'</td>
								
										
									  </tr>';
									  
								$i++;	  
							}
						}
						
						
						
						?>
                        
                        
                        </tbody>
                        </table>
                    </div>
                </div>
                <div class="tab-pane" id="students_avg">
                    <div class="table-scrollable">
                        <table class="table table-hover">
                        <tr>
                            <th>
                                 #
                            </th>
                            <th>
                                 Schüler
                            </th>
                            <th>
                                 &Uuml;bung & Ø - Ergebnis
                            </th>
                        </tr>
                        </thead>
                        <tbody>
                        
                        <?php 
						$i=1;
						foreach($students as $key => $value){
							
							$exe_with_probs='';
							
							foreach($mandate_exe_id as $key1 => $value1){
								
								$sql = "SELECT AVG(percentage) AS AVG_PER, COUNT(exercise_id) AS GOO FROM ".$db_suffix."history WHERE user_id = '$key' AND exercise_id='$key1' GROUP BY exercise_id HAVING GOO>=3 AND AVG_PER < $student_below_all_exe_avg ";
								
								$news_query = mysqli_query($db,$sql);
								
								if(mysqli_num_rows($news_query)>0){			
								
									$row=mysqli_fetch_object($news_query);				
									
									$dummy_exe_percentage=round($row->AVG_PER,2);
									
									$exe_with_probs.='<a href="'.SITE_URL_ADMIN.'?mKey=teachers&pKey=questions&id='.$key1.'&title='.$value1["exercise_title"].'">'.$value1["exercise_title"].' (<b>'.$dummy_exe_percentage.'%</b>)</a><br /><br />';		
									
								}
							}
							//$exe_with_probs=substr($exe_with_probs, 0, -6);
							if($exe_with_probs!=''){
							
								echo '<tr>
								
											<td>'.$i.'</td>
											
											<td><a href="'.SITE_URL_ADMIN.'?mKey=teachers&pKey=performance&id='.$key.'&user_first_name='.$value["user_first_name"].'&user_last_name='.$value["user_last_name"].'">'.$value["user_first_name"].' '.$value["user_last_name"].'</a></td>
											
											<td>'.$exe_with_probs.'</td>
								
										
									  </tr>';
									  
								$i++;	  
							}
						}
						
						
						
						?>
                        
                        </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>	
        
        <?php } ?>
        						
    </div>
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
      	
    
    <!-----PAGE LEVEL SCRIPTS END--->    
        
        <!-- END JAVASCRIPTS -->
</body>
<!-- END BODY -->
</html>