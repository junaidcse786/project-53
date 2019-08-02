<?php 

if($_SESSION["role_id"]=='15')
{
	
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
			
	
	$NO_EXE_LIMIT=3;
	$sql = "select * from ".$db_suffix."teach_settings where ts_lang_level = '".$_SESSION["user_level"] ."' AND ts_org_name='".$_SESSION["user_org_name"]."' AND ts_config_name='NO_EXE_LIMIT'";				
	$query = mysqli_query($db, $sql);
	//$has_a_NO_EXE_LIMIT=mysqli_num_rows($query);	
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
	//$has_a_NO_EXE_LIMIT=mysqli_num_rows($query);	
	if(mysqli_num_rows($query) > 0)
	{
		$content     = mysqli_fetch_object($query);
		$NO_EXE_LIMIT_RIGHT_AFTER_SIGNUP = $content->ts_config_value;
	}
	else
	
		mysqli_query($db, "INSERT INTO ".$db_suffix."teach_settings SET ts_config_value='$NO_EXE_LIMIT_RIGHT_AFTER_SIGNUP', ts_config_name='NO_EXE_LIMIT_RIGHT_AFTER_SIGNUP', ts_lang_level = '".$_SESSION["user_level"] ."', ts_org_name='".$_SESSION["user_org_name"]."'");
	
	
	$QUESTION_CASE=1;
	$sql = "select * from ".$db_suffix."teach_settings where ts_lang_level = '".$_SESSION["user_level"] ."' AND ts_org_name='".$_SESSION["user_org_name"]."' AND ts_config_name='QUESTION_CASE'";				
	$query = mysqli_query($db, $sql);
	$has_a_QUESTION_CASE=mysqli_num_rows($query);	
	if(mysqli_num_rows($query) > 0)
	{
		$content     = mysqli_fetch_object($query);
		$QUESTION_CASE = $content->ts_config_value;
	}		
	
	
	$exam_date='';
	$sql = "select * from ".$db_suffix."exam_date where lang_level = '".$_SESSION["user_level"] ."' AND org_name='".$_SESSION["user_org_name"]."'";				
	$query = mysqli_query($db, $sql);
	$has_a_date=mysqli_num_rows($query);	
	if(mysqli_num_rows($query) > 0)
	{
		$content     = mysqli_fetch_object($query);
		$exam_date = $content->exam_date;
	}	
	
	
	if(isset($_POST["Submit"]) && $_POST["Submit"]=='studs_account'){
	
		extract($_POST);
		
		if(!is_numeric($NO_EXE_LIMIT) || $NO_EXE_LIMIT<1)
		
			$NO_EXE_LIMIT=3;
			
		if(!is_numeric($NO_EXE_LIMIT_RIGHT_AFTER_SIGNUP)  && $NO_EXE_LIMIT_RIGHT_AFTER_SIGNUP<1)
		
			$NO_EXE_LIMIT_RIGHT_AFTER_SIGNUP=5;	
		
		mysqli_query($db, "UPDATE ".$db_suffix."teach_settings SET ts_config_value='$NO_EXE_LIMIT' WHERE ts_config_name='NO_EXE_LIMIT' AND ts_lang_level = '".$_SESSION["user_level"] ."' AND ts_org_name='".$_SESSION["user_org_name"]."'");
		
		mysqli_query($db, "UPDATE ".$db_suffix."teach_settings SET ts_config_value='$NO_EXE_LIMIT_RIGHT_AFTER_SIGNUP' WHERE ts_config_name='NO_EXE_LIMIT_RIGHT_AFTER_SIGNUP' AND ts_lang_level = '".$_SESSION["user_level"] ."' AND ts_org_name='".$_SESSION["user_org_name"]."'");
			
	}
	
	if(isset($_POST["Submit"]) && $_POST["Submit"]=='anschlagbrett'){
	
		extract($_POST);
		
		if(!is_numeric($BATCH_BELOW_EXE_AVG) || (is_numeric($BATCH_BELOW_EXE_AVG) &&$BATCH_BELOW_EXE_AVG<1) || (is_numeric($BATCH_BELOW_EXE_AVG) &&$BATCH_BELOW_EXE_AVG>100))
		
			$BATCH_BELOW_EXE_AVG=65;
			
		if(!is_numeric($STUDENT_BELOW_LAST_3_AVG) || (is_numeric($STUDENT_BELOW_LAST_3_AVG) &&$STUDENT_BELOW_LAST_3_AVG<1) || (is_numeric($STUDENT_BELOW_LAST_3_AVG) &&$STUDENT_BELOW_LAST_3_AVG>100))
		
			$STUDENT_BELOW_LAST_3_AVG=65;
			
		if(!is_numeric($STUDENT_BELOW_ALL_EXE_AVG) || (is_numeric($STUDENT_BELOW_ALL_EXE_AVG) &&$STUDENT_BELOW_ALL_EXE_AVG<1) || (is_numeric($STUDENT_BELOW_ALL_EXE_AVG) &&$STUDENT_BELOW_ALL_EXE_AVG>100))
		
			$STUDENT_BELOW_ALL_EXE_AVG=65;		
			
		
		mysqli_query($db, "UPDATE ".$db_suffix."teach_settings SET ts_config_value='$BATCH_BELOW_EXE_AVG' WHERE ts_config_name='BATCH_BELOW_EXE_AVG' AND ts_lang_level = '".$_SESSION["user_level"] ."' AND ts_org_name='".$_SESSION["user_org_name"]."'");
		
		mysqli_query($db, "UPDATE ".$db_suffix."teach_settings SET ts_config_value='$STUDENT_BELOW_LAST_3_AVG' WHERE ts_config_name='STUDENT_BELOW_LAST_3_AVG' AND ts_lang_level = '".$_SESSION["user_level"] ."' AND ts_org_name='".$_SESSION["user_org_name"]."'");
		
		mysqli_query($db, "UPDATE ".$db_suffix."teach_settings SET ts_config_value='$STUDENT_BELOW_ALL_EXE_AVG' WHERE ts_config_name='STUDENT_BELOW_ALL_EXE_AVG' AND ts_lang_level = '".$_SESSION["user_level"] ."' AND ts_org_name='".$_SESSION["user_org_name"]."'");
			
	}
	
	
	if(isset($_POST["Submit"]) && $_POST["Submit"]=='Exam Date'){
	
		extract($_POST);
		
		if($has_a_date>0)
			
			mysqli_query($db, "UPDATE ".$db_suffix."exam_date SET exam_date='$exam_date' where lang_level = '".$_SESSION["user_level"] ."' AND org_name='".$_SESSION["user_org_name"]."'");
		
		else
			mysqli_query($db, "INSERT INTO ".$db_suffix."exam_date SET exam_date='$exam_date', lang_level = '".$_SESSION["user_level"] ."', org_name='".$_SESSION["user_org_name"]."'");
			
	}
}

?>

<link rel="stylesheet" type="text/css" href="<?php echo SITE_URL_ADMIN; ?>assets/global/plugins/bootstrap-datepicker/css/datepicker3.css"/>

<link rel="stylesheet" type="text/css" href="<?php echo SITE_URL_ADMIN; ?>assets/global/plugins/select2/select2.css" />

<!-- BEGIN PAGE header-->

			<h3 class="page-title">
			<?php
			
				echo '<strong>'.$_SESSION["user_level"].' </strong> <small>'.$_SESSION["user_org_name"].'</small>';		
			
			
			?>
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
			</div>
<!-- END PAGE HEADER-->

			<!-- BEGIN PAGE CONTENT-->
            
            <!-- FOR TEACHER-->
            
            <div class="row">
            	<div class="col-md-8">
                <div class="portlet box red">
                	
                    <div class="portlet-title">
                     <div class="caption"><i class="fa fa-reorder"></i>Rotes Brett - Einstellungen</div>
                  </div>
                  
                	<div class="portlet-body form">
					 <div class="form-body">
                     <form action="<?php echo str_replace('&s_factor=1', '', $_SERVER['REQUEST_URI']);?>" class="form-horizontal" method="POST" enctype="multipart/form-data">
                     
                     <div class="form-group">
                         <label class="control-label col-md-3">Prozent</label>
                         <div class="col-md-9">
                             <input type="text" placeholder="" class="form-control input-small" name="BATCH_BELOW_EXE_AVG" value="<?php echo $BATCH_BELOW_EXE_AVG;?>"/>
                             <span class="help-block">Benachrichtigen, wenn der Kursdurchschnitt bei einer Übung  unter dem eingegebenen Wert liegt.</span> 
                         </div>
                    </div>
                    
                    <div class="form-group">
                         <label class="control-label col-md-3">Prozent</label>
                         <div class="col-md-9">
                             <input type="text" placeholder="" class="form-control input-small" name="STUDENT_BELOW_LAST_3_AVG" value="<?php echo $STUDENT_BELOW_LAST_3_AVG;?>"/>
                             <span class="help-block">Benachrichtigen, wenn bei einem Schüler der Durchschnitt der letzten 3 Durchgänge einer Übung unter dem eingegebenen Wert liegt. </span> 
                         </div>
                    </div>  
                    
                    <div class="form-group">
                         <label class="control-label col-md-3">Prozent</label>
                         <div class="col-md-9">
                             <input type="text" placeholder="" class="form-control input-small" name="STUDENT_BELOW_ALL_EXE_AVG" value="<?php echo $STUDENT_BELOW_ALL_EXE_AVG;?>"/>
                             <span class="help-block">Benachrichtigen, wenn bei einem Schüler der Gesamtdurchschnitt einer Übung unter dem eingegebenen Wert liegt.<br /><br /><br />
Geben Sie eine Zahl ein und klicken Sie danach auf "Aktualisieren"</span> 
                         </div>
                    </div>                           
                    
                    <div class="form-actions">
                       <div class="col-md-offset-4">
                          <button type="submit" name="Submit" value="anschlagbrett" class="btn green submit">Aktualisieren</button>
                              
                       </div>
                    </div>
                     
                     </form>
                     </div>
                   </div>
				</div>
                </div>
                
            	<div class="col-md-4">
					<div class="portlet box blue-chambray">                	
                    <div class="portlet-title">
                     <div class="caption"><i class="fa fa-reorder"></i>Datum der Abschlussprüfung</div>
                  </div>
                  
                	<div class="portlet-body form">
					 <div class="form-body">
                     <form action="<?php echo str_replace('&s_factor=1', '', $_SERVER['REQUEST_URI']);?>" class="form-horizontal" method="POST" enctype="multipart/form-data">
                     
                     <div class="form-group">
                     	<div class="col-md-12">
                            <div class="input-group input-small date date-picker" data-date-format="yyyy-mm-dd" data-date-start-date="+0d">
                                <input name="exam_date" type="text" class="form-control" value="<?php echo $exam_date ?>" readonly>
                                <span class="input-group-btn">
                                <button class="btn default" type="button"><i class="fa fa-calendar"></i></button>
                                </span>
                            </div>
                             
                            <span class="help-block">
                            Klicken Sie auf den Kalender, wählen Sie ein Datum und klicken Sie danach auf "Aktualisieren"
                            </span>
                        </div>
                                            </div>
                    
                    <div class="form-actions">
                       <div class="col-md-offset-4">
                          <button type="submit" name="Submit" value="Exam Date" class="btn green submit">Aktualisieren</button>
                              
                       </div>
                    </div>
                     
                     </form>
                     </div>
                   </div>
				</div>
                </div>
                
                <div class="col-md-4">
                <div class="portlet box purple-plum">                	
                    <div class="portlet-title">
                     <div class="caption"><i class="fa fa-reorder"></i>Automatische Kontodeaktivierung</div>
                  </div>
                  
                	<div class="portlet-body form">
					 <div class="form-body">
                     <form action="<?php echo str_replace('&s_factor=1', '', $_SERVER['REQUEST_URI']);?>" class="form-horizontal" method="POST" enctype="multipart/form-data">
                     
                            
                    <div class="form-group">
                         <label for="percentage" class="control-label col-md-3">Tag(e)</label>
                         <div class="col-md-9">
                             <input type="text" placeholder="" class="form-control input-small" name="NO_EXE_LIMIT" value="<?php echo $NO_EXE_LIMIT;?>"/>
                             <span for="NO_EXE_LIMIT" class="help-block">Deaktivierung nach X Tagen ohne Übung<br /><br />
Geben Sie eine Zahl ein und klicken Sie danach auf "Aktualisieren"</span> 
                         </div>
                    </div> 
                    
                    <!--<div class="form-group">
                         <label for="percentage" class="control-label col-md-3">Tag(e)</label>
                         <div class="col-md-9">
                             <input type="text" placeholder="" class="form-control input-small" name="NO_EXE_LIMIT_RIGHT_AFTER_SIGNUP" value="<?php echo $NO_EXE_LIMIT_RIGHT_AFTER_SIGNUP;?>"/>
                             <span for="NO_EXE_LIMIT_RIGHT_AFTER_SIGNUP" class="help-block">Days limit with no exercise (before 1st exercise)</span> 
                         </div>
                    </div>-->
                    
                    <div class="form-actions">
                       <div class="col-md-offset-4">
                          <button type="submit" name="Submit" value="studs_account" class="btn green submit">Aktualisieren</button>
                              
                       </div>
                    </div>
                     
                     </form>
                     </div>
                   </div>
				</div>
                </div>
                
			</div>
            
            <!-- FOR TEACHER END-->            
                     
            <!-- END PAGE CONTENT -->
            
	</div>
</div>    

<!-- END PAGE CONTAINER -->

        
        <!-- BEGIN FOOTER -->
        
        <?php require_once('footer.php'); ?>
        
        <!-- END FOOTER -->
        
        
        <!-- BEGIN CORE PLUGINS --> 
          
        
		<?php require_once('scripts.php'); ?>
        
        
       <!-----page level scripts start--->
       
   <script type="text/javascript" src="<?php echo SITE_URL_ADMIN; ?>assets/global/plugins/select2/select2.min.js"></script>
        
   <script type="text/javascript" src="<?php echo SITE_URL_ADMIN; ?>assets/global/plugins/bootstrap-datepicker/js/bootstrap-datepicker.js"></script>
   
   <script src="<?php echo SITE_URL_ADMIN; ?>assets/admin/pages/scripts/components-pickers.js"></script>
   
   <script>
			jQuery(document).ready(function() {    
				ComponentsPickers.init();
				
				/*$('.submit').on('click', function(e) {
					
					 alert("Info erfolgreich aktualisiert.");
				});	*/			   	   
			});
			
			
								
	</script>	
   
       
   
    	<!-----page level scripts end--->
        
        <!-- END JAVASCRIPTS -->
</body>
<!-- END BODY -->
</html> 

<?php 
if(isset($_POST["Submit"]))
{
	//usleep(3000000);
	echo '<script>window.location="'.$_SERVER['REQUEST_URI'].'&s_factor=1";</script>';
}
?>     