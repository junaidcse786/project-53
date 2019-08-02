<?php 

/*$NO_EXE_LIMIT=3;
$sql = "select * from ".$db_suffix."teach_settings where ts_lang_level = '".$_SESSION["user_level"] ."' AND ts_org_name='".$_SESSION["user_org_name"]."' AND ts_config_name='NO_EXE_LIMIT'";				
$query = mysqli_query($db, $sql);
$has_a_NO_EXE_LIMIT=mysqli_num_rows($query);	
if(mysqli_num_rows($query) > 0)
{
	$content     = mysqli_fetch_object($query);
	$NO_EXE_LIMIT = $content->ts_config_value;
}
else

	mysqli_query($db, "INSERT INTO ".$db_suffix."teach_settings SET ts_config_value='$NO_EXE_LIMIT', ts_config_name='NO_EXE_LIMIT', ts_lang_level = '".$_SESSION["user_level"] ."', ts_org_name='".$_SESSION["user_org_name"]."'");


$NO_EXE_LIMIT_RIGHT_AFTER_SIGNUP=5;
$sql = "select * from ".$db_suffix."teach_settings where ts_lang_level = '".$_SESSION["user_level"] ."' AND ts_org_name='".$_SESSION["user_org_name"]."' AND ts_config_name='NO_EXE_LIMIT_RIGHT_AFTER_SIGNUP'";				
$query = mysqli_query($db, $sql);
$has_a_NO_EXE_LIMIT=mysqli_num_rows($query);	
if(mysqli_num_rows($query) > 0)
{
	$content     = mysqli_fetch_object($query);
	$NO_EXE_LIMIT_RIGHT_AFTER_SIGNUP = $content->ts_config_value;
}
else

	mysqli_query($db, "INSERT INTO ".$db_suffix."teach_settings SET ts_config_value='$NO_EXE_LIMIT_RIGHT_AFTER_SIGNUP', ts_config_name='NO_EXE_LIMIT_RIGHT_AFTER_SIGNUP', ts_lang_level = '".$_SESSION["user_level"] ."', ts_org_name='".$_SESSION["user_org_name"]."'");
	
	
define('NO_EXE_LIMIT_RIGHT_AFTER_SIGNUP', $NO_EXE_LIMIT_RIGHT_AFTER_SIGNUP);	

define('NO_EXE_LIMIT', $NO_EXE_LIMIT);*/	


if($_SESSION["role_id"]=='15')
{
	/*$students_under='0,';
	
	$sql = "SELECT user_id from ".$db_suffix."user u where u.user_level = '".$_SESSION["user_level"] ."' AND u.role_id='16' AND user_status='1' AND u.user_org_name='".$_SESSION["user_org_name"]."'";				
	$query = mysqli_query($db, $sql);
	
	while($row = mysqli_fetch_object($query))
		
		$students_under.=$row->user_id.',';
		
	$students_under=substr($students_under,0,-1);
	
	$students_to_exclude='0,';
	
	$sql = "SELECT distinct user_id from ".$db_suffix."history h where user_id IN (".$students_under.") AND CAST(h.date_taken as DATE) BETWEEN (CURDATE() - INTERVAL ".(NO_EXE_LIMIT+1)." DAY) AND (CURDATE() + INTERVAL 1 DAY)";				
	$query = mysqli_query($db, $sql);
	
	while($row = mysqli_fetch_object($query))
		
		$students_to_exclude.=$row->user_id.',';
		
	$students_to_exclude=substr($students_to_exclude,0,-1);
		
	
	$sql = "SELECT user_id, user_email, user_first_name, user_last_name from ".$db_suffix."user u where u.user_id IN (".$students_under.") AND u.user_id NOT IN (".$students_to_exclude.") AND DATE(user_creation_date) < (NOW() - INTERVAL ".NO_EXE_LIMIT_RIGHT_AFTER_SIGNUP." DAY) AND user_exe_status='0' AND role_id='16'";				
	$query = mysqli_query($db, $sql);
	
	while($row = mysqli_fetch_object($query)){
	
		mysqli_query($db, "UPDATE ".$db_suffix."user SET user_status='0',user_exe_status='1'  where user_id = '$row->user_id'");
		
		$to = $row->user_email;
        $subject = "Konto Deaktivierung auf ".SITE_NAME;
		
		$message="<p>Sehr geehrte ".$row->user_first_name." ".$row->user_last_name." <br /><br />
		
		Ihr Konto wurde deaktiviert, weil Sie ".NO_EXE_LIMIT." Tag(e) lang keine Übungen gemacht haben. Bitte kontaktieren Sie Ihren Lehrer, damit er Ihr Konto reaktiviert.<br /><br />
		
		<br />
		
		Viele Grüße<br />
		
		".SITE_NAME." TEAM
		
		</p>";
		
		 $header = "From: ".SITE_NAME." <".SITE_EMAIL."> \r\n";
		 $header .= "MIME-Version: 1.0\r\n";
		 $header .= "Content-type: text/html; charset=UTF-8\r\n";
		 
		 $retval = mail ($to,$subject,$message,$header);	
	
	}*/
	
	
	$exam_date='';
	$sql = "select * from ".$db_suffix."exam_date where lang_level = '".$_SESSION["user_level"] ."' AND org_name='".$_SESSION["user_org_name"]."'";				
	$query = mysqli_query($db, $sql);
	$has_a_date=mysqli_num_rows($query);	
	if(mysqli_num_rows($query) > 0)
	{
		$content     = mysqli_fetch_object($query);
		$exam_date = $content->exam_date;
	}	
	
	
	$mandate_exe_id=array(); 
	$sql = "select exercise_id from ".$db_suffix."mandat_exe where lang_level = '".$_SESSION["user_level"] ."' AND org_name='".$_SESSION["user_org_name"]."' AND me_status='1'";				
	$query = mysqli_query($db, $sql);
	$has_mandate=mysqli_num_rows($query);	
	
	while($content=mysqli_fetch_object($query))	
		
		array_push($mandate_exe_id, $content->exercise_id);	
		
		
	$mandate_exe_id_inactive=array();
	$sql = "select exercise_id from ".$db_suffix."mandat_exe where lang_level = '".$_SESSION["user_level"] ."' AND org_name='".$_SESSION["user_org_name"]."' AND me_status='0'";				
	$query = mysqli_query($db, $sql);
	while($content=mysqli_fetch_object($query))	
		
		array_push($mandate_exe_id_inactive, $content->exercise_id);		
		
		
}

?>

<link rel="stylesheet" type="text/css" href="<?php echo SITE_URL_ADMIN; ?>assets/global/plugins/select2/select2.css" />

<link rel="stylesheet" href="<?php echo SITE_URL_ADMIN; ?>assets/global/plugins/datatables/plugins/bootstrap/dataTables.bootstrap.css" />

<!-- BEGIN PAGE header-->

			<h3 class="page-title">
			<?php
			
				echo 'Dashboard | <strong>'.$_SESSION["user_level"].' </strong> <small>'.$_SESSION["user_org_name"].'</small>';		
			
			
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
            
            <!-- FOR TEACHER-->
            
            <?php if($_SESSION["role_id"]=='15') { ?>
			
			
			<div class="row">
            	<div class="col-md-12">
                    <div class="portlet box grey-cascade">
                      <div class="portlet-title">
                         <div class="caption"><i class="fa fa-table"></i>Registrierte Schüler
                         
                         <a href="<?php echo SITE_URL_ADMIN.'?mKey=teachers&pKey=notice_board'; ?>" class="btn btn-xs red"><i class="fa fa-warning"></i> Rotes Brett</a></div>
                         <!--<div class="actions">
                            <a href="<?php echo SITE_URL_ADMIN.'zdompdf_all.php'; ?>" class="btn purple-studio"><i class="fa fa-download"></i> PDF File(s)</a>
                         </div>-->
                      </div>
                      <div class="portlet-body">
                         <table class="table table-striped table-bordered table-hover" id="dashboard_teacher_sample_10">
                            <thead>
                               <tr>
                               	  <th>Schüler</th>
                                  <th >Status</th>
                                  <th >E-Mail</th>
                                  <th >Lernzeit</th>
                                  <th >Ø Lernzeit/Tag</th> 
                                  <th >Onlinezeit</th>
								  <th >Paketstatus</th>
                                  <th >Letzte &Uuml;bung</th>
                                  <!--<th width="25%">&nbsp;</th>--> 
                               </tr>
                            </thead>
                            <tbody>
                            
                            <?php 
							
					$sql_parent_menu="SELECT * FROM ".$db_suffix."user where user_id IN (".STUDS_TO_LOOK_FOR_TEACHER.")";	
					$parent_query = mysqli_query($db, $sql_parent_menu);		
							
                     while($row = mysqli_fetch_object($parent_query))
                    {
                       
               ?>
               
                               <tr>
                               
                               	   <td><?php echo '<a href="'.SITE_URL_ADMIN.'?mKey=teachers&pKey=performance&id='.$row->user_id.'&user_first_name='.$row->user_first_name.'&user_last_name='.$row->user_last_name.'">'.$row->user_first_name." ".$row->user_last_name.'</a>'; ?></td>
                                  
                                   <td><?php 
								   
								   if($row->user_status==0 && $row->user_exe_status==1)
								   
								   		echo '<label class="label bg-red">Inaktiv</label> <a data-href="'.$row->user_id.'" data-toggle="modal" href="#" data-target="#confirmation" class="btn default btn-xs green-jungle">Aktivieren</a>';
										
									else
									
										echo '<label class="label bg-green">Aktiv</label>';	
								   
								   
								   ?></td>
                                  
                                  <td><?php echo $row->user_email; ?></td>
                                  
                                  <td><?php
								  
								  $exe_time_Sql="SELECT SUM(time_taken) AS total_time FROM ".$db_suffix."history where user_id='$row->user_id'";
								  $exe_time_Sql_query=mysqli_query($db,$exe_time_Sql);
								  $exe_time_Sql_query_num=mysqli_num_rows($exe_time_Sql_query);
								  if($exe_time_Sql_query_num>0){
								  	
									$exe_req=mysqli_fetch_object($exe_time_Sql_query);
									$time_taken=$exe_req->total_time;
									//$time_taken_usable_for_a_day=$exe_req->total_time;							  
								  }
								  else
								  	$time_taken=0;
									
								  $time_taken_usable_for_a_day=$time_taken;
								  
								  $duration_exe='';
								  
								  $hours = floor($time_taken / 3600);
									$minutes = floor(($time_taken / 60) % 60);
									$seconds = $time_taken % 60;
									
									if($hours>0 && $hours<10)
							
										$hours='0'.$hours;
										
									if($minutes>0 && $minutes<10)
									
										$minutes='0'.$minutes;
										
									if($seconds>0 && $seconds<10)
									
										$seconds='0'.$seconds;
									
									
									if($hours!=0)
																			  
										$duration_exe.=$hours.' : ';
										
									else
									
										$duration_exe.=' 00 : ';	
									
									if($minutes!=0)
									
										$duration_exe.=$minutes.' : ';
										
									else
									
										$duration_exe.=' 00 : ';	
									
									if($seconds!=0)
									
										$duration_exe.=$seconds;
										
									else
									
										$duration_exe.='00';	
										
									
								  echo ($duration_exe=='')? '00 : 00 : 00' : $duration_exe;
								  								  
								  
								  ?></td>
                                  
                                  <td><?php
								  
								  /*$today_date_time_str=strtotime(date("Y-m-d"));
								  
								  $exam_date_time_str=strtotime(date('Y-m-d', $exam_date));
								  
								  if($today_date_time_str<$exam_date_time_str)
								  
								  	$date_to_compare=date("Y-m-d");
									
								  else
								  
								  	$date_to_compare= $exam_date;	*/
								  
								  
								  $exe_time_Sql="SELECT DATEDIFF(CURDATE(), DATE(user_validity_start)) AS days_to_count FROM ".$db_suffix."user where user_id='$row->user_id'";
								  $exe_time_Sql_query=mysqli_query($db,$exe_time_Sql);
								  if($exe_time_Sql_query_num>0){
								  	
									$exe_req=mysqli_fetch_object($exe_time_Sql_query);
									$days_to_count=$exe_req->days_to_count;
									
									//$days_to_count+=1;
										
									//$time_taken_usable_for_a_day=$exe_req->total_time;							  
								  }
								  
								  if($days_to_count<=0)
								  
									$days_to_count=1;
								  
								  $time_taken=round($time_taken_usable_for_a_day/$days_to_count);
								  
								  $duration_lernzeit_pro_tag='';
								  
								  $hours = floor($time_taken / 3600);
									$minutes = floor(($time_taken / 60) % 60);
									$seconds = $time_taken % 60;
									
									if($hours>0 && $hours<10)
							
										$hours='0'.$hours;
										
									if($minutes>0 && $minutes<10)
									
										$minutes='0'.$minutes;
										
									if($seconds>0 && $seconds<10)
									
										$seconds='0'.$seconds;
									
									
									if($hours!=0)
																			  
										$duration_lernzeit_pro_tag.=$hours.' : ';
										
									else
									
										$duration_lernzeit_pro_tag.=' 00 : ';	
									
									if($minutes!=0)
									
										$duration_lernzeit_pro_tag.=$minutes.' : ';
										
									else
									
										$duration_lernzeit_pro_tag.=' 00 : ';	
									
									if($seconds!=0)
									
										$duration_lernzeit_pro_tag.=$seconds;
										
									else
									
										$duration_lernzeit_pro_tag.='00';	
										
									
								  echo ($duration_lernzeit_pro_tag=='')? '00 : 00 : 00' : $duration_lernzeit_pro_tag;
								  								  
								  
								  ?>
                                  </td>
								  
								  <td><?php
								  
								  	$duration_login='';
									$init=$row->user_login_time;
								   
								    $hours = floor($init / 3600);
									$minutes = floor(($init / 60) % 60);
									$seconds = $init % 60;
									
									if($hours>0 && $hours<10)
							
										$hours='0'.$hours;
										
									if($minutes>0 && $minutes<10)
									
										$minutes='0'.$minutes;
										
									if($seconds>0 && $seconds<10)
									
										$seconds='0'.$seconds;
									
									
									if($hours!=0)
																			  
										$duration_login.=$hours.' : ';
										
									else
									
										$duration_login.=' 00 : ';	
									
									if($minutes!=0)
									
										$duration_login.=$minutes.' : ';
										
									else
									
										$duration_login.=' 00 : ';	
									
									if($seconds!=0)
									
										$duration_login.=$seconds;
										
									else
									
										$duration_login.='00';	
								  
								  	echo ($duration_login=='')? '00 : 00 : 00' : $duration_login;
								  
								  ?></td>
                                  
                                  <td><?php 
								   
								  	$sql = "select exercise_id from ".$db_suffix."mandat_exe where lang_level = '".$_SESSION["user_level"] ."' AND org_name='".$_SESSION["user_org_name"]."' AND me_status='1'";				
									$query = mysqli_query($db, $sql);
									$has_mandate=mysqli_num_rows($query);
									
									if($has_mandate>0){
									
										$sql = "select h.exercise_id, me.trial_times from ".$db_suffix."history h, ".$db_suffix."mandat_exe me where me.lang_level='".$_SESSION["user_level"]."' AND me.me_status='1' AND me.org_name='".$_SESSION["user_org_name"]."' AND  me.exercise_id=h.exercise_id AND h.user_id='".$row->user_id."' AND h.percentage>=me.percentage GROUP BY h.exercise_id HAVING COUNT(h.exercise_id) >=me.trial_times";				
										$query = mysqli_query($db, $sql);
										$has_made=mysqli_num_rows($query);
										
										if($has_mandate!=$has_made){
											
											if($has_made>=0 && $has_made<=9)
											
												$has_made='0'.$has_made;
												
											if($has_mandate>=0 && $has_mandate<=9)
											
												$has_mandate='0'.$has_mandate;	
										
											echo '<span class="badge badge-danger">'.$has_made.' / '.$has_mandate.'</span>';
											
											
										}
											
										else{
											
											 $sql_pcd = "select DATE(completion_time) AS ct from ".$db_suffix."package_completion_date where user_id = '$row->user_id'";				
											$query_pcd = mysqli_query($db, $sql_pcd);
											$content_pcd     = mysqli_fetch_object($query_pcd);
											;
										
											echo '<span class="badge badge-success">Abgeschlossen => '.$content_pcd->ct.'</span>';		
												
										}
									}
									else
									
										echo '<span class="badge badge-warning">Noch kein Paket</span>';
								   
								   ?></td>
                                   
                                   <td><?php
                                   
                                   $sql = "select date_taken from ".$db_suffix."history where user_id = '$row->user_id' ORDER BY date_taken DESC limit 1";				
									$query = mysqli_query($db, $sql);
									
									if(mysqli_num_rows($query) > 0)
									{
										$content     = mysqli_fetch_object($query);
										
										 if(date('d-m-Y')==date('d-m-Y', strtotime($content->date_taken)))
											  
												echo 'Heute '.date('H:i', strtotime($content->date_taken));
												
											else
											
												echo date('d-m-Y H:i', strtotime($content->date_taken));
										
										
									}
									else
										echo '<span class="badge badge-danger">N/A</span>';
                                   
                                   ?></td>
                                   
                                  
                                  <!--<td><?php 
                                  
                                  echo '<a href="'.SITE_URL_ADMIN.'?mKey=teachers&pKey=performance&id='.$row->user_id.'" class="btn default btn-xs yellow-gold">View Performance</a>'; 
                                  
                                  ?>
                                  
                                  <a href="<?php echo '?mKey=sendmessage&parent='.$row->user_id;?>" class="btn default btn-xs green"><i class="fa fa-envelope-square"></i> Send Message</a>
                                  
                                  </td>-->
                                  
                               </tr>
                               
              <?php } ?>       
                            </tbody>
                         </table>
                      
                      </div>
                   </div>
               </div>    
            </div>
            
            
            <div class="row">
            	<div class="col-md-12">
                    <div class="portlet box grey-gallery">
                      <div class="portlet-title">
                         <div class="caption"><i class="fa fa-table"></i>&Uuml;bungen online</div>
                         <div class="actions">                            
                            <div class="btn-group">
                               <a class="btn green" href="#" data-toggle="dropdown">
                               <i class="fa fa-cogs"></i> Optionen
                               <i class="fa fa-angle-down"></i>
                               </a>
                               <ul class="dropdown-menu pull-right">
                                  <li><a href="#" data-toggle="modal" data-status="1" data-target="#confirmation_status"><i class="fa fa-plus-square"></i> Ins Aufgabenpaket übernehmen</a></li>
								  <li><a href="#" data-toggle="modal" data-status="2" data-target="#confirmation_status"><i class="fa fa-trash"></i> Aus dem Aufgabenpaket entfernen</a></li>
                                  <li><a href="#" data-toggle="modal" data-status="0" data-target="#confirmation_status"><i class="fa fa-flag-o"></i> Für kurz deaktivieren</a></li>
								  <li><a href="#" data-toggle="modal" data-status="1" data-target="#confirmation_status"><i class="fa fa-flag"></i> Reaktivieren</a></li>
								  
                               </ul>
                            </div>
                         </div>
                      </div>
                      <div class="portlet-body">
                         <table class="table table-striped table-bordered table-hover" id="sample_2">
                            <thead>
                               <tr>
                               <th class="table-checkbox"><input type="checkbox" class="group-checkable" data-set="#sample_2 .checkboxes" /></th>
                                  <th>&Uuml;bung <br /> <small>Klicken Sie auf eine &Uuml;bung, um zu den einzelnen Fragen zu gelangen.</small></th>
                                  <!--<th></th>-->
                                  <th >Im Paket?<br />&nbsp;</th>
                                  <th >Typ<br />&nbsp;</th>
                                  <th >Kategorie<br />&nbsp;</th>
                                  <th >Stufe<br />&nbsp;</th> 
                                  <th >Niveau<br />&nbsp;</th> 
                                  <!--<th >Dauer</th>    -->
                                  <th >Preview<br />&nbsp;</th>
                               </tr>
                            </thead>
                            <tbody>
                            
                            <?php 
							
					$sql_parent_menu="SELECT * FROM ".$db_suffix."exercise where exercise_status='1' ORDER BY exercise_created_time DESC";	
					$parent_query = mysqli_query($db, $sql_parent_menu);		
							
                     while($row = mysqli_fetch_object($parent_query))
                    {
						
						$sql = "select exercise_id from ".$db_suffix."exercise where exercise_id='$row->exercise_id' AND DATE(exercise_created_time) > (NOW() - INTERVAL ".NEW_EXE_VIEW." DAY)";				
						$query = mysqli_query($db, $sql);
						$has_new_exe=mysqli_num_rows($query);
						
						if($has_new_exe>0)
						
							$span_NEW='<span class="badge badge-danger">NEU</span>';
						else{
												
							$sql = "select q.question_id from ".$db_suffix."question q
							LEFT JOIN ".$db_suffix."exercise e ON e.exercise_id=q.exercise_id where e.exercise_id='$row->exercise_id' AND DATE(q.question_creation_time) > (NOW() - INTERVAL ".NEW_EXE_VIEW." DAY) LIMIT 1";				
							$query = mysqli_query($db, $sql);
							$has_new_quest=mysqli_num_rows($query);
							
							if($has_new_quest>0)
							
								$span_NEW='<span class="badge badge-danger">AKTUALISIERT</span>';
							else{
							
								$span_NEW='';
							}
						}
                       
               ?>
               
                               <tr class="odd gradeX">
                               	
                                	<td><input type="checkbox" class="checkboxes" value="<?php echo $row->exercise_id;?>" /></td>                                	
                                  <td><?php echo '<a href="'.SITE_URL_ADMIN.'?mKey=teachers&pKey=questions&id='.$row->exercise_id.'&title='.$row->exercise_title; ?>"><?php echo $row->exercise_title.'</a> '.$span_NEW; ?></td>
                                    
                                  <!--<td><a href="<?php echo SITE_URL_ADMIN.'?mKey=teachers&pKey=questions&id='.$row->exercise_id.'&title='.$row->exercise_title; ?>" class="btn default btn-xs red-stripe">Zu den Fragen </a></td>-->
                                  
                                  <td><?php 
								  
								  if(in_array($row->exercise_id, $mandate_exe_id)){
								  
								  	$sql = "select distinct h.user_id, me.trial_times from ".$db_suffix."history h, ".$db_suffix."mandat_exe me where me.lang_level='".$_SESSION["user_level"]."' AND me.org_name='".$_SESSION["user_org_name"]."' AND me.me_status='1' AND  me.exercise_id=h.exercise_id AND me.exercise_id = '$row->exercise_id' AND h.user_id IN (".STUDS_TO_LOOK_FOR_TEACHER.") AND h.percentage>=me.percentage GROUP BY h.user_id HAVING COUNT(h.exercise_id) >=me.trial_times";
									
									$query = mysqli_query($db, $sql);
								
									$has_users_passed=mysqli_num_rows($query);
									
									
									$sql = "select user_id from ".$db_suffix."history where exercise_id = $row->exercise_id AND user_id IN (".STUDS_TO_LOOK_FOR_TEACHER.") GROUP BY user_id";				
									
									$query = mysqli_query($db, $sql);
								
									$has_users=mysqli_num_rows($query);
									
									
									$has_studs=count($studs_to_look_for_array_teacher);
									
									if($has_users_passed==$has_studs)
									
										echo ' <label class="label bg-green">Abgeschlossen</label>';
										
									else{
										
										echo ' <label class="label label-success">Ja</label>';	
									
										if($has_users)
										
											echo ' <a class="btn default btn-xs blue-hoki" href="'.SITE_URL_ADMIN.'?mKey=teachers&pKey=pack_users&exercise_id='.$row->exercise_id.'&title='.$row->exercise_title.'">Nutzer zeigen</a>';
									}
								  
								  }
									
								  else if(in_array($row->exercise_id, $mandate_exe_id_inactive))
								  
										echo ' <label class="label bg-purple">Ja (Inaktiv)</label>';	
								  
								  else

										echo ' <label class="label bg-red">Nein</label>';
									
									
								  ?></td> 
                                  
                                  <td><?php echo $row->exercise_type;?></td>
                                  
                                  <td><?php echo $row->exercise_topic;?></td>
                                  
                                  <td><?php echo $row->exercise_difficulty;?></td>
                                  
                                  <td><?php echo $row->exercise_level;?></td>
                                  
                                  <!--<td><?php 
								   
								  sscanf($row->exercise_duration, "%d:%d:%d", $hours, $minutes, $seconds);
								  $exercise_duration= $hours * 3600 + $minutes * 60 + $seconds;
								  
								  $duration='';
								  
								  if($hours>0 && $hours<10)
							
									$hours='0'.$hours;
									
									if($minutes>0 && $minutes<10)
									
										$minutes='0'.$minutes;
										
									if($seconds>0 && $seconds<10)
									
										$seconds='0'.$seconds;

									if($hours!=0)
																			  
										$duration.=$hours.' : ';
										
									else
									
										$duration.=' 00 : ';	
									
									if($minutes!=0)
									
										$duration.=$minutes.' : ';
										
									else
									
										$duration.=' 00 : ';		
									
									if($seconds!=0)
									
										$duration.=$seconds;
										
									else
									
										$duration.='00';		
								  
								  echo $duration;							   
								   
								   
								   ?></td>-->
                                  
                                  <td><?php 
                                  
                                  /*if($row->role_id!='8')
                                  
                                    echo '<a href="'.SITE_URL_ADMIN.'?mKey=member&pKey=editmember&id='.$row->user_id.'" class="btn default btn-xs yellow-gold">'.$row->user_first_name.' '.$row->user_last_name.'</a>'; 
                                    
                                  else
                                  
                                    echo '<a class="btn default btn-xs green-seagreen">Administrator</a>';	*/
                                    echo '<a target="_blank" href="'.SITE_URL.'exercise-trial/'.$row->exercise_id.'/'.$row->exercise_title.'" class="btn default btn-xs yellow-gold">Preview</a>'; 
                                  
                                  ?></td>
                                  
                               </tr>
                               
              <?php } ?>       
                            </tbody>
                         </table>
                      
                      </div>
                   </div>
               </div>
            </div>
            
            <?php } ?>
            <!-- FOR TEACHER END-->            
                     
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
                     <h4 class="modal-title">Bestätigung</h4>
                  </div>
                  <div class="modal-body">
                        <span class="danger"><strong>Hinweis !</strong> Möchten Sie dieses Konto wirklich aktivieren?</span>         			</div>
                  <div class="modal-footer">
                     <button id="delete_button" type="button" class="btn red">Aktivieren</button>
                     <button type="button" class="btn default" data-dismiss="modal">Schließen</button>
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
                     <h4 class="modal-title">Bestätigung</h4>
                  </div>
                  <div class="modal-body">
                        <span class="danger"><strong>Hinweis !</strong> Möchten Sie wirklich, um diese Aktion durchzuführen?</span>         			</div>
                  <div class="modal-footer">
                     <button id="delete_button" type="button" class="btn green">Bestätigen</button>
                     <button type="button" class="btn default" data-dismiss="modal">Schließen</button>
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
                jQuery(document).ready(function() {    
                    TableManaged.init();
					//ComponentsPickers.init();				   	   
                });
				
				$('#confirmation').on('show.bs.modal', function(e) {
					 
					var id=$(e.relatedTarget).data('href');
					 
					$(this).find('#delete_button').on('click', function(e) { 
					 
					 	$.ajax({
								   type: "POST",
								   url:  '<?php echo SITE_URL_ADMIN.'teacher_things/activate_user.php' ; ?>',
								   dataType: "text",
							   	   data: {id: id},
								   success: function(data){		
										window.location.reload(true);
								   },
								   error : function(data){
									    window.location.reload(true);
								   }			   		
						   });
					 
					});
		        });
				
				$('#confirmation_status').on('show.bs.modal', function(e) {
					 
					var status=$(e.relatedTarget).data('status');
					
					var id='';
					 
					$(this).find('#delete_button').on('click', function(e) { 
					
						$('input:checkbox[class=checkboxes]:checked').each(function(){
							 
							id=id+$(this).val()+',';
						 })					
					 
					 	$.ajax({
								   type: "POST",
								   url:  '<?php echo SITE_URL_ADMIN.'teacher_things/put_into_packet.php' ; ?>',
								   dataType: "text",
							   	   data: {id: id, status: status},
								   success: function(data){		
										window.location.reload(true);
								   },
								   error : function(data){
									    window.location.reload(true);
								   }			   		
						   });
					 
					});
		        });
				
				
				var table1 = $('#dashboard_teacher_sample_10');

				/* Table tools samples: https://www.datatables.net/release-datatables/extras/TableTools/ */
		
				/* Set tabletools buttons and button container */
		
				$.extend(true, $.fn.DataTable.TableTools.classes, {
					"container": "btn-group tabletools-dropdown-on-portlet",
					"buttons": {
						"normal": "btn btn-sm default",
						"disabled": "btn btn-sm default disabled"
					},
					"collection": {
						"container": "DTTT_dropdown dropdown-menu tabletools-dropdown-menu"
					}
				});
		
				var oTable = table1.dataTable({
		
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
					
					"bStateSave": true,
							
					// Or you can use remote translation file
					//"language": {
					//   url: '//cdn.datatables.net/plug-ins/3cfcc339e89/i18n/Portuguese.json'
					//},
		
					"order": [
						[0, 'asc']
					],
					
					"lengthMenu": [
						[5, 10, 15, 20, -1],
						[5, 10, 15, 20, "Alle"] // change per page values here
					],
					// set the initial value
					"pageLength": -1,
		
					"dom": "<'row' <'col-md-12'T>><'row'<'col-md-6 col-sm-12'l><'col-md-6 col-sm-12'f>r><'table-scrollable't><'row'<'col-md-5 col-sm-12'i><'col-md-7 col-sm-12'p>>", // horizobtal scrollable datatable
		
					// Uncomment below line("dom" parameter) to fix the dropdown overflow issue in the datatable cells. The default datatable layout
					// setup uses scrollable div(table-scrollable) with overflow:auto to enable vertical scroll(see: assets/global/plugins/datatables/plugins/bootstrap/dataTables.bootstrap.js). 
					// So when dropdowns used the scrollable div should be removed. 
					//"dom": "<'row' <'col-md-12'T>><'row'<'col-md-6 col-sm-12'l><'col-md-6 col-sm-12'f>r>t<'row'<'col-md-5 col-sm-12'i><'col-md-7 col-sm-12'p>>",
		
					"tableTools": {
						"sSwfPath": "<?php echo SITE_URL_ADMIN; ?>assets/global/plugins/datatables/extensions/TableTools/swf/copy_csv_xls_pdf.swf",
						"aButtons": [{
							"sExtends": "pdf",
							"sButtonText": "PDF"
						}, {
							"sExtends": "csv",
							"sButtonText": "CSV"
						}, {
							"sExtends": "xls",
							"sButtonText": "Excel"
						}, {
							"sExtends": "print",
							"sButtonText": "Print",
							"sInfo": 'Please press "CTRL+P" to print or "ESC" to quit',
							"sMessage": "Generated by DataTables"
						}, {
							"sExtends": "copy",
							"sButtonText": "Copy"
						}]
					}
				});
		
				var tableWrapper = $('#dashboard_teacher_sample_10_wrapper'); // datatable creates the table wrapper by adding with id {your_table_jd}_wrapper
		
				tableWrapper.find('.dataTables_length select').select2();
				
	</script>	
   
       
   
    	<!-----page level scripts end--->
        
        <!-- END JAVASCRIPTS -->
</body>
<!-- END BODY -->
</html>      