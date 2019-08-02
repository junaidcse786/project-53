<!-----PAGE LEVEL CSS BEGIN--->

<link href="<?php echo SITE_URL_ADMIN; ?>assets/admin/pages/css/profile.css" rel="stylesheet" type="text/css"/>


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
            <div class="col-md-12">
            
           	 <!-- BEGIN EXAMPLE TABLE PORTLET-->
               
               <div class="portlet light">
                    <div class="portlet-title">
                        <div class="caption">
                            <i class="fa fa-star font-green-sharp"></i>
                            <span class="caption-subject font-green-sharp bold">Rangliste der Schüler</span>
                        </div>
                        <!--<div class="tools">
                            <a href="javascript:;" class="collapse">
                            </a>
                            <a href="#portlet-config" data-toggle="modal" class="config">
                            </a>
                        </div>-->
                    </div>
                    <div class="portlet-body">
                        <div class="row number-stats margin-bottom-20">
                        	<div class="col-md-5 col-sm-5 col-xs-5">
                                <div class="stat-left">
                                    <div class="stat-number">
                                        <div class="title">
                                             Schüler insgesamt
                                        </div>
                                        <div class="number">
                                             <?php 
                                             echo count($studs_to_look_for_array_teacher);
                                             ?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-2 col-sm-2 col-xs-2">
                                <div class="stat-right">
                                    <div class="stat-number">
                                        <div class="title">
                                             Aktive Schüler
                                        </div>
                                        <div class="number">
                                             <?php 
                                             echo mysqli_num_rows(mysqli_query($db,"SELECT user_id from ".$db_suffix."user u where user_status='1' AND u.user_id IN (".STUDS_TO_LOOK_FOR_TEACHER.")"));
                                             ?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3 col-sm-3 col-xs-3">
                                <div class="stat-right">
                                    <div class="stat-number">
                                        <div class="title">
                                             &Uuml;bung(en) im Aufgabenpaket
                                        </div>
                                        <div class="number">
                                             <?php
											 
								$sql = "select exercise_id from ".$db_suffix."mandat_exe where lang_level = '".$_SESSION["user_level"] ."' AND org_name='".$_SESSION["user_org_name"]."' AND me_status='1'";				
								$query = mysqli_query($db, $sql);
								$has_mandate=mysqli_num_rows($query);
								
								echo $has_mandate;
                                             ?>
                                        </div>
                                    </div>
                                </div>
                            </div>                            
                        </div>
                        <div class="tabbable-custom ">
                            <ul class="nav nav-tabs ">
                                <li class="active">
                                    <a href="#Lernzeit" data-toggle="tab">
                                    Lernzeit </a>
                                </li>
                                <li>
                                    <a href="#avg_Lernzeit_Tag" data-toggle="tab">
                                    Ø &Uuml;bungen/Tag </a>
                                </li>
                                <?php if($has_mandate>0) {?>
                                <li>
                                    <a href="#aufgabenpaket" data-toggle="tab">
                                    Aufgabenpaket </a>
                                </li>
                                <?php } ?>
                            </ul>
                            <div class="tab-content">
                                <div class="tab-pane active" id="Lernzeit">
                                    <div class="table-scrollable table-scrollable-borderless">
								<table class="table table-hover table-light">
								<thead>
								<tr>
									<th width="5%"></th>
                                    <th colspan="2" width="29%">
										 Schüler
									</th>
									<th width="17%">
										 Lernzeit
									</th>
									<th width="17%">
										 Ø Lernzeit/Tag
									</th>
									<th width="17%">
										 Onlinezeit
									</th>
									<th width="15%">
										 Paketstatus
									</th>
									
								</tr>
								</thead>
                                
								<?php 
								
								$ranking_name=array(); $ranking_profil_bild=array();
								$ranking_sort_array = array();
								
								$i=1;
								
								$exam_date=date('Y-m-d');
								$sql = "select * from ".$db_suffix."exam_date where lang_level = '".$_SESSION["user_level"] ."' AND org_name='".$_SESSION["user_org_name"]."'";				
								$query = mysqli_query($db, $sql);
								$has_a_date=mysqli_num_rows($query);	
								if(mysqli_num_rows($query) > 0)
								{
									$content     = mysqli_fetch_object($query);
									$exam_date = $content->exam_date;
								}
								
								
								$sql = "SELECT u.user_id, u.user_login_time, u.user_first_name, u.user_last_name, u.user_photo, SUM(h.time_taken) AS exe_time, SUM(h.time_taken)/DATEDIFF(CURDATE(), DATE(u.user_validity_start)) AS AVG_LERNZEIT_PRO_TAG FROM ".$db_suffix."history h
		Left Join ".$db_suffix."user u ON h.user_id=u.user_id where h.user_id IN (".STUDS_TO_LOOK_FOR_TEACHER.") GROUP BY h.user_id ORDER BY exe_time DESC";
								$news_query = mysqli_query($db,$sql);
								
								while($row = mysqli_fetch_object($news_query))
                    			
								{
									
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
										
									
								  $time_taken=$row->exe_time;
								  
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

								
								   $time_taken=$row->AVG_LERNZEIT_PRO_TAG;
								  
								   $duration_AVG_LERNZEIT_PRO_TAG='';
								  
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
																			  
										$duration_AVG_LERNZEIT_PRO_TAG.=$hours.' : ';
										
									else
									
										$duration_AVG_LERNZEIT_PRO_TAG.=' 00 : ';	
									
									if($minutes!=0)
									
										$duration_AVG_LERNZEIT_PRO_TAG.=$minutes.' : ';
										
									else
									
										$duration_AVG_LERNZEIT_PRO_TAG.=' 00 : ';	
									
									if($seconds!=0)
									
										$duration_AVG_LERNZEIT_PRO_TAG.=$seconds;
										
									else
									
										$duration_AVG_LERNZEIT_PRO_TAG.='00';
										
								
									
									$packet_String='';
									
									if($has_mandate>0){
										
										$ranking_name[$row->user_id] = $row->user_first_name." ".$row->user_last_name;
										
										if($row->user_photo!='')	
									
											$ranking_profil_bild[$row->user_id]=SITE_URL.'data/user/'.$row->user_photo;
											
										else
										
											$ranking_profil_bild[$row->user_id]=SITE_URL_ADMIN.'assets/admin/layout/img/avatar.png';
											
										
										$sql = "select h.exercise_id, me.trial_times from ".$db_suffix."history h, ".$db_suffix."mandat_exe me where me.lang_level='".$_SESSION["user_level"]."' AND me.me_status='1' AND me.org_name='".$_SESSION["user_org_name"]."' AND  me.exercise_id=h.exercise_id AND h.user_id='".$row->user_id."' AND h.percentage>=me.percentage GROUP BY h.exercise_id HAVING COUNT(h.exercise_id) >=me.trial_times";
										
										$query = mysqli_query($db, $sql);
										$has_made=mysqli_num_rows($query);
										
										$ranking_sort_array[$row->user_id]=$has_made;
										
										if($has_made!=$has_mandate){
											
											if($has_made>=0 && $has_made<=9)
											
												$has_made='0'.$has_made;
												
											if($has_mandate>=0 && $has_mandate<=9)
											
												$has_mandate='0'.$has_mandate;
										
											$packet_String = '<span class="badge badge-danger">'.$has_made.' / '.$has_mandate.'</span>';
										}
											
										else{
											
																						
											$sql_pcd = "select DATE(completion_time) AS ct from ".$db_suffix."package_completion_date where user_id = '$row->user_id'";				
											$query_pcd = mysqli_query($db, $sql_pcd);
											$content_pcd     = mysqli_fetch_object($query_pcd);
											;
										
											//$packet_String = '<span class="badge badge-success">Abgeschlossen => '.$content_pcd->ct.'</span> <i class="fa fa-thumbs-o-up"></i> ';
											
											$packet_String = '<span class="badge badge-success">Abgeschlossen</span>';
											
											$completion_date[$row->user_id]=$content_pcd->ct;	
												
										}	
									
										
										
									}
									else
									
										$packet_String =  '<span class="badge badge-warning">Noch kein Paket</span>';
										
									if($row->user_photo!='')	
									
										$ranking_photo_src=SITE_URL.'data/user/'.$row->user_photo;
										
									else
									
										$ranking_photo_src=SITE_URL_ADMIN.'assets/admin/layout/img/avatar.png';									
										
								?>
                                
                                
								<tr>
                                	<td class="">
										 <strong><?php echo $i.'.'; $i++; ?></strong>
									</td>
                                    
									<td class="fit" colspan="2"><a href="<?php echo SITE_URL_ADMIN.'?mKey=teachers&pKey=performance&id='.$row->user_id;?>">
										<img class="user-pic" src="<?php echo $ranking_photo_src; ?>">
									
										<span class="bold theme-font"><?php echo $row->user_first_name." ".$row->user_last_name; ?></span></a>
									</td>
									<td>
										 <span class="bold theme-font"><?php echo $duration_exe; ?></span>
									</td>
									<td>
										 <span class="bold theme-font"><?php echo $duration_AVG_LERNZEIT_PRO_TAG; ?></span>
									</td>
									<td>
										 <span class="bold theme-font"><?php echo $duration_login; ?></span>
									</td>
									<td>
										 <?php echo $packet_String; ?>
									</td>									
								</tr>
                                
                                <?php } ?>
                                
								</table>
							</div>

                                </div>
                                
                                <?php if($has_mandate>0) {?>
                                
                                <div class="tab-pane" id="aufgabenpaket">
                                    <div class="table-scrollable table-scrollable-borderless">
								<table class="table table-hover table-light">
								<thead>
								<tr>
									<th width="5%"></th>
                                    <th colspan="2" width="55%">
										 Schüler
									</th>
									<th width="40%">
										 Abgeschlossene &Uuml;bungen
									</th>
								</tr>
								</thead>
                                
								<?php
								
								$i=1;
								
								arsort($ranking_sort_array);
								
								foreach($ranking_sort_array as $key => $value)
                    			
								{
									$completed_or_not='';
									
									if($value==$has_mandate)
									
										$value='<span class="badge badge-success">Aufgabenpaket abgeschlossen</span> '.$completion_date[$key].' <i class="fa fa-thumbs-o-up"></i> ';
										
									else
									
										$value.=' &Uuml;bung(en)';	
										
								?>
                                
                                
								<tr>
                                	<td class="">
										 <strong><?php echo $i.'.'; $i++; ?></strong>
									</td>
                                    
									<td class="fit" colspan="2"><a href="<?php echo SITE_URL_ADMIN.'?mKey=teachers&pKey=performance&id='.$key;?>">
										<img class="user-pic" src="<?php echo $ranking_profil_bild[$key]; ?>">
									
										<span class="bold theme-font"><?php echo $ranking_name[$key]; ?></span>
									</a></td>
									<td>
										 <span class="bold theme-font"><?php echo $value." ".$completed_or_not; ?></span>
									</td>
								</tr>
                                
                                <?php } ?>
                                
								</table>
							</div>
                                </div>
                                <?php } ?>
                                
                                <div class="tab-pane" id="avg_Lernzeit_Tag">
                                    <div class="table-scrollable table-scrollable-borderless">
								<table class="table table-hover table-light">
								<thead>
								<tr>
									<th width="5%"></th>
                                    <th colspan="2" width="35%">
										 Schüler
									</th>
									<th width="20%">
										 Ø &Uuml;bungen/Tag
									</th>
									<th width="20%">
										 Gemachte &Uuml;bung(en) insgesamt
									</th>  
                                    <th width="20%">
										 Verschiedene &Uuml;bung(en)
									</th>                                  
								</tr>
								</thead>
                                
								<?php 
								
								$i=1;
								
								$sql = "SELECT u.user_id, u.user_login_time, u.user_first_name, u.user_last_name, u.user_photo, (SELECT COUNT(DISTINCT exercise_id) FROM ".$db_suffix."history WHERE user_id=h.user_id) AS TOTAL_UBUNG_DISTINCT, (SELECT COUNT(exercise_id) FROM ".$db_suffix."history WHERE user_id=h.user_id) AS TOTAL_UBUNG, COUNT(h.exercise_id)/(DATEDIFF(CURDATE(), DATE(u.user_validity_start))+1) AS AVG_EXE_PER_DAY FROM ".$db_suffix."history h
		Left Join ".$db_suffix."user u ON h.user_id=u.user_id where h.user_id IN (".STUDS_TO_LOOK_FOR_TEACHER.") GROUP BY h.user_id ORDER BY AVG_EXE_PER_DAY DESC";
								$news_query = mysqli_query($db,$sql);
								
								while($row = mysqli_fetch_object($news_query))
                    			
								{
									
								  $AVG_EXE_PER_DAY= round($row->AVG_EXE_PER_DAY);
								  
								  $TOTAL_UBUNG_DISTINCT= round($row->TOTAL_UBUNG_DISTINCT);
								  
								  $TOTAL_UBUNG= round($row->TOTAL_UBUNG);
								  
								  
								    if($row->user_photo!='')	
									
										$ranking_photo_src=SITE_URL.'data/user/'.$row->user_photo;
										
									else
									
										$ranking_photo_src=SITE_URL_ADMIN.'assets/admin/layout/img/avatar.png';									
										
								?>
                                
                                
								<tr>
                                	<td class="">
										 <strong><?php echo $i.'.'; $i++; ?></strong>
									</td>
                                    
									<td class="fit" colspan="2"><a href="<?php echo SITE_URL_ADMIN.'?mKey=teachers&pKey=performance&id='.$row->user_id;?>">
										<img class="user-pic" src="<?php echo $ranking_photo_src; ?>">
									
										<span class="bold theme-font"><?php echo $row->user_first_name." ".$row->user_last_name; ?></span>
									</a></td>
									<td>
										 <span class="bold theme-font"><?php echo $AVG_EXE_PER_DAY; ?> &Uuml;bung(en)</span>
									</td>
                                    <td>
										 <span class="bold theme-font"><?php echo $TOTAL_UBUNG; ?> &Uuml;bung(en)</span>
									</td>
                                    <td>
										 <span class="bold theme-font"><?php echo $TOTAL_UBUNG_DISTINCT; ?> &Uuml;bung(en)</span>
									</td>
								</tr>
                                
                                <?php } ?>
                                
								</table>
							</div>
                                </div>
                                
                            </div>
                        </div>                                        
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
      	
    
    <!-----PAGE LEVEL SCRIPTS END--->    
        
        <!-- END JAVASCRIPTS -->
</body>
<!-- END BODY -->
</html>