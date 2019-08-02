<?php 
	
$alert_message=""; $alert_box_show="hide"; $alert_type="success";
	
$err_easy="has-error";

$r_title = "";
$r_desc = "";
$r_send_email = 0;
$r_remind_time_1 = date("Y-m-d");
$r_remind_time_2 = date("H:i");
$parent=array();
$parent[]="all_studs";

$err=0;

$messages = array(
					'r_title' => array('status' => '', 'msg' => ''),
					'r_desc' => array('status' => '', 'msg' => ''),
					'r_remind_time_1' => array('status' => '', 'msg' => ''),
					'r_remind_time_2' => array('status' => '', 'msg' => ''),
					'parent' => array('status' => '', 'msg' => ''),
				);

if(isset($_POST['Submit']))
{	
	extract($_POST);
	
	if(empty($r_title))
	{
		$messages["r_title"]["status"]=$err_easy;
		$messages["r_title"]["msg"]="Dieses Feld muss ausgefüllt werden";
		$err++;		
	}
	
	if(count($parent)<=0)
	{
		$messages["parent"]["status"]=$err_easy;
		$messages["parent"]["msg"]="Ein Benutzer muss ausgewählt werden.";;
		$err++;		
	}
	
	if(empty($r_desc))
	{
		$messages["r_desc"]["status"]=$err_easy;
		$messages["r_desc"]["msg"]="Dieses Feld muss ausgefüllt werden";
		$err++;		
	}
	
	if(empty($r_remind_time_1))
	{
		$messages["r_remind_time_1"]["status"]=$err_easy;
		$messages["r_remind_time_1"]["msg"]="Dieses Feld muss ausgefüllt werden";
		$err++;		
	}
	
	if(empty($r_remind_time_2))
	{
		$messages["r_remind_time_2"]["status"]=$err_easy;
		$messages["r_remind_time_2"]["msg"]="Dieses Feld muss ausgefüllt werden";
		$err++;		
	}
	
	
	if($err == 0)
	{
		$r_remind_time=$r_remind_time_1.' '.$r_remind_time_2;
		
		$r_recipients='';
		
		if(in_array("all_studs", $parent)){
			
			foreach($studs_to_look_for_array_teacher as $value)
			
				$r_recipients.=$value.',';
		
		}
		
		else{			
		
			foreach($parent as $value)				
				
				$r_recipients.=$value.',';			
		}
		
		$r_recipients=substr($r_recipients,0,-1);	
			
		
		
		$sql = "INSERT INTO ".$db_suffix."reminder SET r_title='$r_title', r_desc='$r_desc', r_remind_time='$r_remind_time', r_send_mail='$r_send_email', r_recipients='$r_recipients', user_id='".$_SESSION["user_id"]."'";
		if(mysqli_query($db,$sql))
		{		
			$alert_message="Info erfolgreich aktualisiert";		
			$alert_box_show="show";
			$alert_type="success";
			
			$r_title = "";
			$r_desc = "";
			$r_send_email = 0;
			$r_remind_time_1 = date("Y-m-d");
			$r_remind_time_2 = "23:59:00";
			$parent=array();	
			
		}else{
			$alert_box_show="show";
			$alert_type="danger";
			$alert_message="Database encountered some error while inserting.";
		}
	}
	else
	{
		$alert_box_show="show";
		$alert_type="danger";
		$alert_message="Bitte korrigieren sie folgenden Fehler";
		
	}
}

if(!isset($_POST["Submit"]) && isset($_GET["s_factor"]))
{
	$alert_message="Info erfolgreich aktualisiert";		
	$alert_box_show="show";
	$alert_type="success";
}


?>

<!-----PAGE LEVEL CSS BEGIN--->


<link rel="stylesheet" type="text/css" href="<?php echo SITE_URL_ADMIN; ?>assets/global/plugins/bootstrap-timepicker/css/bootstrap-timepicker.min.css"/>

<link rel="stylesheet" type="text/css" href="<?php echo SITE_URL_ADMIN; ?>assets/global/plugins/bootstrap-datepicker/css/datepicker3.css"/>

<link rel="stylesheet" type="text/css" href="<?php echo SITE_URL_ADMIN; ?>assets/global/plugins/select2/select2.css" />

<!-----PAGE LEVEL CSS END--->



                                        <!-- BEGIN PAGE TITLE & BREADCRUMB-->
                                        <h3 class="page-title">
                                                <?php echo $menus["$mKey"]["$pKey"]; ?> <!--<small>Here New contents can be created</small>-->
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
                        
                        
   <!--------------------------BEGIN PAGE CONTENT------------------------->
                                              
                        <div class="row">
            <div class="col-md-12">
            <!-- BEGIN EXAMPLE TABLE PORTLET-->
               <div class="portlet box grey-cascade">
                  <div class="portlet-title">
                     <div class="caption"><i class="fa fa-reorder"></i>Felder mit einem Sternchen müssen ausgefüllt werden <strong>*</strong></div>
                  </div>
                  <div class="portlet-body form">
                  
                      <div class="form-body">
                      
                          <div class="alert alert-<?php echo $alert_type; ?> <?php echo $alert_box_show; ?>">
                            <button type="button" class="close" data-dismiss="alert" aria-hidden="true"></button>
                            <?php echo $alert_message; ?>
                          </div>
                          
                                <form action="<?php echo str_replace('&s_factor=1', '', $_SERVER['REQUEST_URI']);?>" class="form-horizontal" method="post" enctype="multipart/form-data">
                               
                                                                   
                              <div class="form-group <?php echo $messages["parent"]["status"] ?>">
                                 <label for="parent" class="control-label col-md-3">Senden an <span class="required">*</span></label>
                                 <div class="col-md-8">
                                    <select class="form-control select2me"  data-placeholder="Nutzer auswählen" multiple="multiple" tabindex="0" name="parent[]">
                                      
									<?php
                                                                           
                                    $users_in_options='';$selected='';
                                               
                                    if($_SESSION["role_id"]==15){
                                       
                                        $selected='';
                                        
                                        if(in_array("all_studs", $parent))
                                        
                                            $selected='selected';
                                    
                                        $users_in_options.='<optgroup label="Alle Studenten"><option '.$selected.' value="all_studs">Alle Studenten meines Kurs</option></optgroup>';
                                        
                                        $users_in_options.='<optgroup label="Studenten">';
                                        
                                        $sql_parent_menu = "SELECT * FROM ".$db_suffix."user where user_id IN (".STUDS_TO_LOOK_FOR_TEACHER.")";	
                                        
                                        $parent_query = mysqli_query($db, $sql_parent_menu);
                                        
                                        while($parent_obj = mysqli_fetch_object($parent_query)){
                                        
                                            $selected='';
                                            
                                            if(in_array($parent_obj->user_id, $parent))
                                            
                                                $selected='selected';
                                                
                                            $users_in_options.='<option '.$selected.'  value="'.$parent_obj->user_id.'">'.$parent_obj->user_first_name.' '.$parent_obj->user_last_name.'</option>';
                                        
                                        }
                                        
                                        $users_in_options.='</optgroup>';
                                        
                                        
                                    }	
                                                                       
                                    echo $users_in_options;
                                                                            
                                    ?>                                     
                                    </select>
                                    <span for="parent" class="help-block"><?php echo $messages["parent"]["msg"] ?></span>
                                 </div>
                              </div>
                              
                              <div class="form-group <?php echo $messages["r_title"]["status"] ?>">
                              		<label class="control-label col-md-3" for="r_title">Titel <span class="required">*</span></label>
                              		<div class="col-md-4">
                                 		<input type="text" placeholder="" class="form-control" name="r_title" value="<?php echo $r_title;?>"/>
                                 		<span for="r_title" class="help-block"><?php echo $messages["r_title"]["msg"] ?></span>
                              		</div>
                           	  </div>
                              
                              <div class="form-body <?php echo $messages["r_desc"]["status"] ?>">
									<div class="form-group">
										<label class="control-label col-md-3">Verwendunszweck <span class="required">*</span></label>
										<div class="col-md-9">
											<textarea class="ckeditor form-control" name="r_desc" rows="6"><?php echo str_replace('\\','',$r_desc); ?></textarea>
                                            <span for="r_desc" class="help-block"><?php echo $messages["r_desc"]["msg"] ?></span>
										</div>
									</div>
							 </div>
                             
                             <div class="form-group <?php echo $messages["r_remind_time_1"]["status"] ?>">
                                <label class="control-label col-md-3">Datum <span class="required">*</span></label>
                                <div class="col-md-4">
                                    <div class="input-group input-medium date date-picker" data-date-format="yyyy-mm-dd" data-date-start-date="+0d">
                                        <input name="r_remind_time_1" type="text" class="form-control" value="<?php echo $r_remind_time_1; ?>" readonly>
                                        <span class="input-group-btn">
                                        <button class="btn default" type="button"><i class="fa fa-calendar"></i></button>
                                        </span>
                                    </div>
                                    <!-- /input-group -->
                                    <span class="help-block">
                                    <?php echo $messages["r_remind_time_1"]["msg"] ?></span>
                                </div>
                            </div>
                             
                             <div class="form-group <?php echo $messages["r_remind_time_2"]["status"] ?>">
                              		<label class="control-label col-md-3" for="r_remind_time_2">Uhr <span class="required">*</span></label>
                              		<div class="col-md-3">
                                    <div class="input-group">
                                 		<input type="text" placeholder="" class="form-control  timepicker timepicker-24 timepicker-seconds input-medium" name="r_remind_time_2" value="<?php echo $r_remind_time_2;?>"/>
                                        <span class="input-group-btn">
												<button class="btn default" type="button"><i class="fa fa-clock-o"></i></button>
										</span>
                                    </div>
                                 		<span for="r_remind_time_2" class="help-block"><strong>HH:MM:SS</strong><br/><?php echo $messages["r_remind_time_2"]["msg"] ?></span>
                              		</div>
                           	  </div>
                             
                             <div class="form-group last">
                                  <label for="r_send_email" class="control-label col-md-3">E-Mail schicken?</label>
                                  <div class="col-md-8">
                                     <select class="form-control input-small" name="r_send_email">
                                        <option <?php if($r_send_email==1) echo 'selected="selected"'; ?> value="1">Ja</option>
                                        <option <?php if($r_send_email==0) echo 'selected="selected"'; ?> value="0">Nein</option>
                                     </select>
                                     <span class="help-block">Systemnachrichten werden immer verschickt. Das Versenden von E-Mails ist optional.</span>
                                  </div>
                              </div>
                            
                            <div class="form-actions fluid">                            
                               <div class="col-md-offset-3 col-md-9">
                                  <button type="submit" name="Submit" class="btn green">Bestätigen</button>
                                  <button type="reset" class="btn default">Zürücksetzen</button>                              
                               </div>
                        	</div>
                            
                            </form>
                      
                      </div>
                      
                  </div>
               </div>
               <!-- END EXAMPLE TABLE PORTLET-->
            </div>
         </div>
         
         
         <!--------------------------END PAGE CONTENT------------------------->
         
         
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
       
<script type="text/javascript" src="<?php echo SITE_URL_ADMIN; ?>assets/global/plugins/bootstrap-timepicker/js/bootstrap-timepicker.min.js"></script>

<script type="text/javascript" src="<?php echo SITE_URL_ADMIN; ?>assets/global/plugins/ckeditor/ckeditor.js"></script>

<script type="text/javascript" src="<?php echo SITE_URL_ADMIN; ?>assets/global/plugins/bootstrap-datepicker/js/bootstrap-datepicker.js"></script>

<script src="<?php echo SITE_URL_ADMIN; ?>assets/admin/pages/scripts/components-pickers.js"></script>

<script type="text/javascript" src="<?php echo SITE_URL_ADMIN; ?>assets/global/plugins/select2/select2.min.js"></script>
       
       <script>
	   
	    jQuery(document).ready(function() {       
			   ComponentsPickers.init();               
		});  
	   
	   </script>
       
       <!-----PAGE LEVEL SCRIPTS END--->
 
 
        
        <!-- END JAVASCRIPTS -->
</body>
<!-- END BODY -->
</html>

<?php 
if($alert_type=='success' && isset($_POST["Submit"]))
{
	//usleep(3000000);
	echo '<script>window.location="'.$_SERVER['REQUEST_URI'].'&s_factor=1";</script>';
}
?>