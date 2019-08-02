<?php 

if($_SESSION["role_id"]=='15')
{
	
	$QUESTION_CASE=1;
	$sql = "select * from ".$db_suffix."teach_settings where ts_lang_level = '".$_SESSION["user_level"] ."' AND ts_org_name='".$_SESSION["user_org_name"]."' AND ts_config_name='QUESTION_CASE'";				
	$query = mysqli_query($db, $sql);
	$has_a_QUESTION_CASE=mysqli_num_rows($query);	
	if(mysqli_num_rows($query) > 0)
	{
		$content     = mysqli_fetch_object($query);
		$QUESTION_CASE = $content->ts_config_value;
	}		
	
	if(isset($_POST["Submit"]) && $_POST["Submit"]=='Mandatory List'){
	
		extract($_POST);
		
		if($has_a_QUESTION_CASE>0)
			
			mysqli_query($db, "UPDATE ".$db_suffix."teach_settings SET ts_config_value='$QUESTION_CASE' where ts_lang_level = '".$_SESSION["user_level"] ."' AND ts_org_name='".$_SESSION["user_org_name"]."' AND ts_config_name='QUESTION_CASE'");
		
		else
			
			mysqli_query($db, "INSERT INTO ".$db_suffix."teach_settings SET ts_config_value='$QUESTION_CASE', ts_config_name='QUESTION_CASE', ts_lang_level = '".$_SESSION["user_level"] ."', ts_org_name='".$_SESSION["user_org_name"]."'");
				
		
		if($trial_times!='' && (!is_numeric($trial_times) || $trial_times<1 || $trial_times>10))
			
			$trial_times=1;
		
		if($percentage!='' && (!is_numeric($percentage) || $percentage<1 || $percentage>100))
		
			$percentage=65;	
		
		if($percentage!='')
		
			mysqli_query($db, "UPDATE ".$db_suffix."mandat_exe SET percentage='$percentage' WHERE lang_level = '".$_SESSION["user_level"] ."' AND org_name='".$_SESSION["user_org_name"]."' AND me_status='1'");
		
		if($trial_times!='')
		
			mysqli_query($db, "UPDATE ".$db_suffix."mandat_exe SET trial_times='$trial_times' WHERE lang_level = '".$_SESSION["user_level"] ."' AND org_name='".$_SESSION["user_org_name"]."' AND me_status='1'");
		
	}	
}

?>


<!-----PAGE LEVEL CSS BEGIN--->

<link rel="stylesheet" type="text/css" href="<?php echo SITE_URL_ADMIN; ?>assets/global/plugins/select2/select2.css" />

<link rel="stylesheet" href="<?php echo SITE_URL_ADMIN; ?>assets/global/plugins/datatables/plugins/bootstrap/dataTables.bootstrap.css" />


<!-----PAGE LEVEL CSS END--->


                        <!-- BEGIN PAGE TITLE & BREADCRUMB-->
                        
                        <h3 class="page-title">
                                                &Uuml;bungen im Aufgabenpaket<small> Erweiterte Aufgabeneinstellungen</small>
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
                            <div class="portlet box yellow-saffron">
                                
                                <div class="portlet-title">
                                 <div class="caption"><i class="fa fa-reorder"></i>Einstellungen des Aufgabenpaket</div>
                              </div>
                              
                                <div class="portlet-body form">
                                 <div class="form-body">
                                 <form action="<?php echo str_replace('&s_factor=1', '', $_SERVER['REQUEST_URI']);?>" class="form-horizontal" method="POST" enctype="multipart/form-data">
                                <div class="row">         
                                
                                <div class="col-md-4">
                                    <div class="form-group">
                                         <label for="percentage" class="control-label col-md-4">Prozent</label>
                                         <div class="col-md-8">
                                             <input type="text" class="form-control input-small" name="percentage"/>
                                             <span for="percentage" class="help-block">Zu erzielendes Mindestergebnis</span> 
                                         </div>
                                    </div>
                                </div> 
                                
                                <div class="col-md-4">
                                    <div class="form-group">
                                         <label for="trial_times" class="control-label col-md-4">Wiederholungen</label>
                                         <div class="col-md-8">
                                             <input type="text" class="form-control input-small" name="trial_times"/> 
                                             <span for="trial_times" class="help-block">Wie oft sollen die Schüler die &Uuml;bungen bestehen?</span> 
                                         </div>
                                    </div>
                                </div>  
                                
                                <div class="col-md-4">
                                    <div class="form-group">
                                      <label class="control-label col-md-4">Groß- und Kleinschreibung</label>
                                      <div class="col-md-8">
                                         <select class="form-control input-medium" name="QUESTION_CASE">
                                            <option <?php if($QUESTION_CASE==1) echo 'selected="selected"'; ?> value="1">Punkte abziehen</option>
                                            <option <?php if($QUESTION_CASE==0) echo 'selected="selected"'; ?> value="0">Keine Punkte abziehen</option>
                                         </select>
                                         <span class="help-block">Punktabzug bei richtiger Antwort aber fehlerhafter Groß-/Kleinschreibung?</span>
                                      </div>
                                    </div> 
                                </div>
                                </div>
                                
                                <div class="form-actions">
                                	<div class="row">
                                    	<div class="col-md-6">
                                        	<div class="row">
                                                <div class="col-md-offset-10 col-md-9">                                          
                                              <button type="submit" name="Submit" value="Mandatory List" class="btn green submit">Aktualisieren</button>
                                           </div>
                                           		</div>
                                        </div>
                                        <div class="col-md-6">
                                        </div>
                                    </div>                                		
                                </div>
                                 </form>
                                 </div>
                               </div>
                            </div>
                            </div>
                        
            	<div class="col-md-12">
                    <div class="portlet box green-seagreen">
                      <div class="portlet-title">
                         <div class="caption"><i class="fa fa-table"></i>&Uuml;bungen</div>
                         <div class="actions">
                         <?php  echo '<button class="btn blue-chambray save_btn" &nbsp;><i class="fa fa-save"></i> Speichern</button>'; ?>
                         </div>
                      </div>
                      <div class="portlet-body">
                         <table class="table table-striped table-bordered table-hover" id="sample_2">
                            <thead>
                               <tr>
                               <th class="table-checkbox"><input type="checkbox" class="group-checkable" data-set="#sample_2 .checkboxes" /></th>
                                  <th>&Uuml;bung <br /> <small>Klicken Sie auf eine &Uuml;bung, <br />um zur Vorschau zu gelangen</small><br /></th>
                                  <th >Prozent<br /><small>Zu erzielendes<br /> Mindestergebnis</small></th>
                                  <th >Wiederholungen<br /><small>Wie oft sollen die Schüler<br /> die &Uuml;bungen bestehen?</small></th>
                                  <th >Reihenfolge<br /><small>Reihenfolge, in der<br /> die Schüler die Aufgaben sehen</small></th>
                                  <!--<th ></th>-->
                               </tr>
                            </thead>
                            <tbody>
                            
                            <?php 
							
					$sql_parent_menu="SELECT * FROM ".$db_suffix."mandat_exe me
					LEFT JOIN ".$db_suffix."exercise e ON e.exercise_id=me.exercise_id where e.exercise_status='1' AND me.lang_level = '".$_SESSION["user_level"] ."' AND me.me_status='1' AND me.org_name='".$_SESSION["user_org_name"]."' ORDER BY me.exe_order ASC";	
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
               
                               <tr class="odd gradeX damn">
                               	
                                  <td><input type="checkbox" class="checkboxes" value="<?php echo $row->exercise_id;?>" /></td>                                	
                                  <td><?php echo '<a target="_blank" href="'.SITE_URL.'exercise-trial/'.$row->exercise_id.'/'.$row->exercise_title; ?>"><?php echo $row->exercise_title.'</a> '.$span_NEW; 
								  
								  ?></td>
                                    
                                  
                                  <td><input class="form-control input-small" name="prozent" value="<?php echo $row->percentage ?>" /></td>
                                  
                                  <td><input class="form-control input-small" name="wd" value="<?php echo $row->trial_times ?>" /></td>
                                  
                                  <td><input class="form-control input-small" name="order" value="<?php echo $row->exe_order ?>" /></td>
                                  
                                  <!--<td><?php 
                                  
                                  /*if($row->role_id!='8')
                                  
                                    echo '<a href="'.SITE_URL_ADMIN.'?mKey=member&pKey=editmember&id='.$row->user_id.'" class="btn default btn-xs yellow-gold">'.$row->user_first_name.' '.$row->user_last_name.'</a>'; 
                                    
                                  else
                                  
                                    echo '<a class="btn default btn-xs green-seagreen">Administrator</a>';	*/
                                    echo '<button class="btn btn-xs green save_btn" &nbsp;><i class="fa fa-save"></i> Speichern</button>'; 
									
									//echo '<a target="_blank" href="'.SITE_URL.'exercise-trial/'.$row->exercise_id.'/'.$row->exercise_title.'" class="btn default btn-xs yellow-gold">Preview</a>'; 
                                  
                                  ?></td>-->
                                  
                               </tr>
                               
              <?php } ?>       
                            </tbody>
                         </table>
                      
                      </div>
                   </div>
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
				
				$('.save_btn').on('click', function(e) {
					
					 var long_text="";
					 
					 $('.damn').each(function(){						 
						
						long_text+=$(this).find($('input:checkbox[class=checkboxes]')).val()+","+$(this).find($('input:text[name=prozent]')).val()+","+$(this).find($('input:text[name=wd]')).val()+","+$(this).find($('input:text[name=order]')).val()+"=";											
						
					 })
					 
					 $.ajax({
						   type: "POST",
						   url:  '<?php echo SITE_URL_ADMIN.'teacher_things/deal_exercise_order.php' ; ?>',
						   dataType: "text",
						   data: {long_text: long_text},
						   success: function(data){		
								
								alert("Info erfolgreich aktualisiert.");
								
								window.location.reload(true);
						   }								   		   		
					});
				});	
				
				/*$('.submit').on('click', function(e) {
					
					 alert("Info erfolgreich aktualisiert.");
				});*/			
				
	</script>
    
    	
    
    <!-----PAGE LEVEL SCRIPTS END--->    
        
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