<?php 

function clean_string($string){	
	$string=  str_ireplace("'",  "&apos;", $string);
	$string=  str_ireplace("\\", "&bsol;", $string);
	$string=  str_ireplace('"',  "&quot;", $string);
	return $string;
}
	
$alert_message=""; $alert_box_show="hide"; $alert_type="success";
	
$err_easy="has-error";

$exercise_title = "";
$exercise_req = array();
$exercise_desc = "";
$exercise_duration = "0:00:00";
$exercise_type = "Grammatik";
$exercise_topic = "";
$exercise_difficulty = "einfach";
$exercise_level = "";
$exercise_status = 0;
$exercise_pull=10;
$exercise_req_percentage=65;

$err=0;

$messages = array(
					'exercise_title' => array('status' => '', 'msg' => ''),
					'exercise_desc' => array('status' => '', 'msg' => ''),
					'exercise_duration' => array('status' => '', 'msg' => ''),
					'exercise_type' => array('status' => '', 'msg' => ''),
					'exercise_topic' => array('status' => '', 'msg' => ''),
					'exercise_difficulty' => array('status' => '', 'msg' => ''),
					'exercise_req_percentage' => array('status' => '', 'msg' => ''),
					'exercise_level' => array('status' => '', 'msg' => ''),
					'exercise_status' => array('status' => '', 'msg' => ''),
					'exercise_pull' => array('status' => '', 'msg' => ''),
				);

if(isset($_POST['Submit']))
{	
	extract($_POST);
	
	if(empty($exercise_type))
	{
		$messages["exercise_type"]["status"]=$err_easy;
		$messages["exercise_type"]["msg"]="Type is Required";;
		$err++;		
	}
	
	if(empty($exercise_difficulty))
	{
		$messages["exercise_difficulty"]["status"]=$err_easy;
		$messages["exercise_difficulty"]["msg"]="Difficulty level is Required";;
		$err++;		
	}
	
	if(empty($exercise_title))
	{
		$messages["exercise_title"]["status"]=$err_easy;
		$messages["exercise_title"]["msg"]="Title is Required";;
		$err++;		
	}
	
	if(empty($exercise_topic))
	{
		$messages["exercise_topic"]["status"]=$err_easy;
		$messages["exercise_topic"]["msg"]="Topic is Required";;
		$err++;		
	}
	
	if(empty($exercise_level))
	{
		$messages["exercise_level"]["status"]=$err_easy;
		$messages["exercise_level"]["msg"]="Level is Required";
		$err++;		
	}
	
	if(count($exercise_req)>0 && empty($exercise_req_percentage))
	{
		$messages["exercise_req_percentage"]["status"]=$err_easy;
		$messages["exercise_req_percentage"]["msg"]="Minimum percentage is Required";;
		$err++;		
	}
	
	if(!is_numeric($exercise_req_percentage) && !empty($exercise_req_percentage))
	{
		$messages["exercise_req_percentage"]["status"]=$err_easy;
		$messages["exercise_req_percentage"]["msg"]="Invalid percentage";;
		$err++;		
	}
	
	if(!is_numeric($exercise_pull) || empty($exercise_pull) || $exercise_pull<=0)
	{
		$messages["exercise_pull"]["status"]=$err_easy;
		$messages["exercise_pull"]["msg"]="A quantity is Required";;
		$err++;		
	}
	
	if(($exercise_type=='Listening' || $exercise_type=='Dictation') && $_FILES["gallery_file"]["name"]=='')
	{
		$messages["exercise_type"]["status"]=$err_easy;
		$messages["exercise_type"]["msg"]="Audio File is Required for Listening Exercises";;
		$err++;		
	}
	
	if(empty($exercise_duration) || $exercise_duration=='0:00:00')
	{
		$messages["exercise_duration"]["status"]=$err_easy;
		$messages["exercise_duration"]["msg"]="Duration is Required";;
		$err++;		
	}	
	
	if($err == 0)
	{
		
		$exercise_title=clean_string($exercise_title);
		
		$image_dir = "../data/FILES/";
		
		if($_FILES['gallery_file']['name'] != '')
			
			$image_name=date('ymdgis').$_FILES['gallery_file']['name'];
		
		else
		
			$image_name='';	
			
		
		$sql = "INSERT INTO ".$db_suffix."exercise SET exercise_title='$exercise_title', exercise_desc='$exercise_desc', exercise_duration='$exercise_duration', exercise_type='$exercise_type', exercise_difficulty='$exercise_difficulty', exercise_level='$exercise_level', exercise_req_percentage='$exercise_req_percentage', user_id=".$_SESSION['user_id'].",  exercise_status='$exercise_status', exercise_file='$image_name', exercise_pull='$exercise_pull', exercise_topic='$exercise_topic'";
		
		if(mysqli_query($db,$sql))
		{		
			$exercise_id=mysqli_insert_id($db);
			
			$alert_message="Data inserted successfully";		
			$alert_box_show="show";
			$alert_type="success";
			
			foreach($exercise_req as $value)
			
				mysqli_query($db,"INSERT INTO ".$db_suffix."exe_req SET exercise_id='$exercise_id', req_id='$value'");
			
			move_uploaded_file($_FILES['gallery_file']['tmp_name'], $image_dir.$image_name);
			
			if(isset($save_data) && $save_data ==0){
				$exercise_title = "";
				$exercise_desc = "";
				$exercise_duration = "0:00:00";
				$exercise_type = "Grammar";
				$exercise_difficulty = "einfach";
				$exercise_level = "";
				$exercise_status = 0;
				$exercise_pull=10;
				$exercise_topic='';
				$exercise_req_percentage=65;
				$exercise_req = array();
			}
			
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
		$alert_message="Please correct these errors.";
		
	}
}

if(!isset($_POST["Submit"]) && isset($_GET["s_factor"]))
{
	$alert_message="Data inserted successfully";		
	$alert_box_show="show";
	$alert_type="success";
}
?>

<!-----PAGE LEVEL CSS BEGIN--->

<link rel="stylesheet" type="text/css" href="<?php echo SITE_URL_ADMIN; ?>assets/global/plugins/bootstrap-timepicker/css/bootstrap-timepicker.min.css"/>

<link rel="stylesheet" type="text/css" href="<?php echo SITE_URL_ADMIN; ?>assets/global/plugins/select2/select2.css" />

<!-----PAGE LEVEL CSS END--->



                                        <!-- BEGIN PAGE TITLE & BREADCRUMB-->
                                        <h3 class="page-title">
                                                <?php echo $menus["$mKey"]["$pKey"]; ?> <small>Here New exercises can be added to the system</small>
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
                     <div class="caption"><i class="fa fa-reorder"></i>You have to fill the fields marked with <strong>*</strong></div>
                  </div>
                  <div class="portlet-body form">
                  
                      <div class="form-body">
                      
                          <div class="alert alert-<?php echo $alert_type; ?> <?php echo $alert_box_show; ?>">
                            <button type="button" class="close" data-dismiss="alert" aria-hidden="true"></button>
                            <?php echo $alert_message; ?>
                          </div>
                          
                         		<form action="<?php echo str_replace('&s_factor=1', '', $_SERVER['REQUEST_URI']);?>" class="form-horizontal" method="post" enctype="multipart/form-data">
                               
                               
                              <div class="form-group <?php echo $messages["exercise_title"]["status"] ?>">
                              		<label class="control-label col-md-3" for="exercise_title">Aufgabentitel <span class="required">*</span></label>
                              		<div class="col-md-4">
                                 		<input type="text" placeholder="" class="form-control" name="exercise_title" value="<?php echo $exercise_title;?>"/>
                                 		<span for="exercise_title" class="help-block"><?php echo $messages["exercise_title"]["msg"] ?></span>
                              		</div>
                           	  </div>
                              
                              <div class="form-group <?php echo $messages["exercise_desc"]["status"] ?>">
                              		<label class="control-label col-md-3" for="exercise_desc">Description <span class="required">*</span></label>
                              		<div class="col-md-9">
                                 		<textarea class="form-control ckeditor" rows="6" name="exercise_desc"><?php echo $exercise_desc;?></textarea>
                                 		<span for="exercise_desc" class="help-block"><?php echo $messages["exercise_desc"]["msg"] ?></span>
                              		</div>
                              </div>
                              
                              <div class="form-group  <?php echo $messages["exercise_topic"]["status"] ?>">
                                  <label for="exercise_topic" class="control-label col-md-3">Subkategorie <span class="required">*</span></label>
                                  <div class="col-md-8">
                                  	
                                    <input type="text" placeholder="" class="form-control" name="exercise_topic" value="<?php echo $exercise_topic;?>"/> 
                                    
                                    <span for="exercise_topic" class="help-block"><?php echo $messages["exercise_topic"]["msg"] ?></span>
                                  
                                  <?php  
							  
							$sql_parent_menu = "SELECT DISTINCT exercise_topic FROM ".$db_suffix."exercise where exercise_topic!=''";	
							$parent_query = mysqli_query($db, $sql_parent_menu);
							
							if(mysqli_num_rows($parent_query)>0)
							
							{								
							  
							  ?>
                              <br />
                                  
                                     <select class="form-control input-medium select2me"  data-placeholder="Choose a topic" tabindex="0" id="exercise_type1" name="exercise_type1">
                                     <option value=""> </option>
									 
									 <?php 
									 $indiv_topic_name_arr=array();
									 while($parent_obj = mysqli_fetch_object($parent_query)){
									 
										if(count(explode(",", $parent_obj->exercise_topic))>1){
											
											foreach(explode(",", $parent_obj->exercise_topic) as $topic_item){														
												if(trim($topic_item)!="")
															
													array_push($indiv_topic_name_arr,trim($topic_item));
											}
										}
										else
											array_push($indiv_topic_name_arr,$parent_obj->exercise_topic);
									 
									 }
									 
									 $indiv_topic_name_arr=array_unique($indiv_topic_name_arr);
												
									 foreach($indiv_topic_name_arr as $topic_name)
										
										echo '<option value="'.$topic_name.'">'.$topic_name.'</option>';
									
										
                                      ?>
                                        
                                     </select>
                                     <span for="exercise_topic" class="help-block">Choose from existing topic<br/>You can assign more than one topic to an exercise by combining them with a comma</span>
                                     
                                <?php } ?>     
                                  </div>
                              </div>
                              
                              <div class="form-group">
                                 <label for="exercise_req[]" class="control-label col-md-3">Prerequisite Exercise</label>
                                 <div class="col-md-4">
                                    <select class="form-control select2me game_id"  data-placeholder="Choose Exercise(s)" tabindex="0" name="exercise_req[]" multiple="multiple">
                                                                              
                                       <?php
									   $sql_parent_menu = "SELECT exercise_id, exercise_title FROM ".$db_suffix."exercise";	
										$parent_query = mysqli_query($db, $sql_parent_menu);
										while($parent_obj = mysqli_fetch_object($parent_query))
										{	
											if(in_array($parent_obj->exercise_id, $exercise_req))
											
												echo '<option selected="selected" value="'.$parent_obj->exercise_id.'">'.$parent_obj->exercise_title.'</option>';
											
											else
												
												echo '<option value="'.$parent_obj->exercise_id.'">'.$parent_obj->exercise_title.'</option>';
									
										}
                                        ?>
                                       
                                       
                                    </select>
                                 </div>
                              </div>
                              <?php if(count($exercise_req)>0) $god_damned_req='show'; else $god_damned_req='hide'; ?>
                              <div class="erp form-group <?php echo $messages["exercise_req_percentage"]["status"]; echo ' '.$god_damned_req;?>">
                              		<label class="control-label col-md-3" for="exercise_req_percentage">Required Percentage <span class="required">*</span></label>
                              		<div class="col-md-4">
                                 		<input type="text" placeholder="" class="form-control input-small" name="exercise_req_percentage" value="<?php echo $exercise_req_percentage;?>"/>
                                 		<span for="exercise_req_percentage" class="help-block"><?php echo $messages["exercise_req_percentage"]["msg"] ?></span>
                              		</div>
                           	  </div>
                              
                              <div class="form-group <?php echo $messages["exercise_duration"]["status"] ?>">
                              		<label class="control-label col-md-3" for="exercise_duration">Duration <span class="required">*</span></label>
                              		<div class="col-md-3">
                                    <div class="input-group">
                                 		<input type="text" placeholder="" class="form-control  timepicker timepicker-24 timepicker-seconds input-medium" name="exercise_duration" value="<?php echo $exercise_duration;?>"/>
                                        <span class="input-group-btn">
												<button class="btn default" type="button"><i class="fa fa-clock-o"></i></button>
										</span>
                                    </div>
                                 		<span for="exercise_duration" class="help-block"><strong>HH:MM:SS</strong><br/><?php echo $messages["exercise_duration"]["msg"] ?></span>
                              		</div>
                           	  </div>
                              
                              <div class="form-group  <?php echo $messages["exercise_level"]["status"] ?>">
                                  <label for="exercise_level" class="control-label col-md-3">Language level <span class="required">*</span></label>
                                  
                                  <div class="col-md-4">
                                  
                                  <input type="text" placeholder="" class="form-control input-small" name="exercise_level" value="<?php echo $exercise_level;?>"/> 
                                    
                                    <span for="exercise_level" class="help-block"><?php echo $messages["exercise_level"]["msg"] ?></span>
                                    <br />
                                     <select class="form-control input-small select2me"  data-placeholder="Choose a level" tabindex="0" id="exercise_level_select" name="exercise_level_select">
                                     <option></option>
									 
									 <?php 
									 
									 $sql_parent_menu = "SELECT DISTINCT exercise_level FROM ".$db_suffix."exercise where exercise_level!=''";	
									$parent_query = mysqli_query($db, $sql_parent_menu);
									 
									 while($parent_obj = mysqli_fetch_object($parent_query))
										
										echo '<option value="'.$parent_obj->exercise_level.'">'.$parent_obj->exercise_level.'</option>';
									
										
                                      ?>
                                        
                                     </select>
                                     <span for="exercise_level" class="help-block">Choose from existing levels</span>
                                  </div>
                              </div>
                              
                              <div class="form-group  <?php echo $messages["exercise_type"]["status"] ?>">
                                  <label for="exercise_type" class="control-label col-md-3">&Uuml;bung <span class="required">*</span></label>
                                  
                                  <div class="col-md-4">
                                  
                                  <input type="text" placeholder="" class="form-control input-small" name="exercise_type" value="<?php echo $exercise_type;?>"/> 
                                    
                                    <span for="exercise_type" class="help-block"><?php echo $messages["exercise_type"]["msg"] ?></span>
                                    <br />
                                     <select class="form-control input-small select2me"  data-placeholder="Choose a type" tabindex="0" id="exercise_type_select" name="exercise_type_select">
                                     <option></option>
									 
									 <?php 
									 
									 $sql_parent_menu = "SELECT DISTINCT exercise_type FROM ".$db_suffix."exercise where exercise_type!=''";	
									$parent_query = mysqli_query($db, $sql_parent_menu);
									 
									 while($parent_obj = mysqli_fetch_object($parent_query))
										
										echo '<option value="'.$parent_obj->exercise_type.'">'.$parent_obj->exercise_type.'</option>';
									
										
                                      ?>
                                        
                                     </select>
                                     <span for="exercise_type" class="help-block">Choose from existing type</span>
                                  </div>
                              </div>
                              
                              
                              <div class="form-group <?php echo $messages["exercise_pull"]["status"] ?>">
                                <label class="control-label col-md-3" for="exercise_pull">Number of questions to pull <span class="required">*</span></label>
                                
                                <div class="col-md-5">
                                	<input type="text" class="form-control input-small" name="exercise_pull" value="<?php echo $exercise_pull;?>">                                 
                                    <span for="exercise_pull" class="help-block">How many questions will be pulled from the pool each time<br /><?php echo $messages["exercise_pull"]["msg"] ?></span>
                                </div>
                            </div>
                              
                              
                              <div class="form-group">
                                  <label for="gallery_file" class="control-label col-md-3">Add File</label>
                                  <div class="col-md-4">
                                     <input type="file" name="gallery_file">
                                     <span for="gallery_file" class="help-block">Add File if necessary ; especially for Listening Exercises</span>
                                  </div>
                              </div>
                              
                              <div class="form-group  <?php echo $messages["exercise_difficulty"]["status"] ?>">
                                  <label for="exercise_difficulty" class="control-label col-md-3">Exercise Difficulty <span class="required">*</span></label>
                                  <div class="col-md-4">
                                  
                                  <input type="text" placeholder="" class="form-control input-small" name="exercise_difficulty" value="<?php echo $exercise_difficulty;?>"/> 
                                    
                                    <span for="exercise_difficulty" class="help-block"><?php echo $messages["exercise_difficulty"]["msg"] ?></span>
                                    <br />
                                     <select class="form-control input-small select2me"  data-placeholder="Choose difficulty" tabindex="0" id="exercise_difficulty_select" name="exercise_difficulty_select">
                                     <option></option>
									 
									 <?php 
									 
									 $sql_parent_menu = "SELECT DISTINCT exercise_difficulty FROM ".$db_suffix."exercise where exercise_difficulty!=''";	
									$parent_query = mysqli_query($db, $sql_parent_menu);
									 
									 while($parent_obj = mysqli_fetch_object($parent_query))
										
										echo '<option value="'.$parent_obj->exercise_difficulty.'">'.$parent_obj->exercise_difficulty.'</option>';
									
										
                                      ?>
                                        
                                     </select>
                                     <span for="exercise_difficulty" class="help-block">Choose from existing difficulty</span>
                                  </div>
                              </div> 
                              
                              <div class="form-group">
                                    <label  class="control-label col-md-3">Keep Last Saved Data?</label>
                                    <div class="radio-list col-md-4">
                                        <label class="radio-inline">
                                        <input type="radio" name="save_data" value="1"> Yes </label>
                                        <label class="radio-inline">
                                        <input type="radio" name="save_data" checked value="0"> No </label>			
                                        
                                    </div>
                                </div>                          
                            
                              
                              <div class="form-group last">
                                  <label for="exercise_status" class="control-label col-md-3">Status</label>
                                  <div class="col-md-2">
                                     <select class="form-control" name="exercise_status">
                                        <option <?php if($exercise_status==1) echo 'selected="selected"'; ?> value="1">Active</option>
                                        <option <?php if($exercise_status==0) echo 'selected="selected"'; ?> value="0">InActive</option>
                                     </select>
                                  </div>
                              </div>
                            
                            <div class="form-actions fluid">
                               <div class="col-md-offset-3 col-md-9">
                                  <button type="submit" name="Submit" class="btn green">Submit</button>
                                  <button type="reset" class="btn default">Cancel</button>                              
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

<script type="text/javascript" src="<?php echo SITE_URL_ADMIN; ?>assets/global/plugins/select2/select2.min.js"></script>

<script type="text/javascript" src="<?php echo SITE_URL_ADMIN; ?>assets/global/plugins/ckeditor/ckeditor.js"></script>

<script src="<?php echo SITE_URL_ADMIN; ?>assets/admin/pages/scripts/components-pickers.js"></script>

		
        
        <script>
        jQuery(document).ready(function() {       
			   ComponentsPickers.init();              
			});   
		
        $( "#exercise_type1" ).change(function() {
			
			var damn="";
			
			if($('input[name="exercise_topic"]').val()=="")
			
				damn=$('input[name="exercise_topic"]').val();
				
			else
			
				damn=$('input[name="exercise_topic"]').val()+", ";
				
			$('input[name="exercise_topic"]').val(damn+$(this).val());
        });
        
        $( "#exercise_type_select" ).change(function() {
            $('input[name="exercise_type"]').val($(this).val());
        });
        
        $( "#exercise_level_select" ).change(function() {
            $('input[name="exercise_level"]').val($(this).val());
        });
        
        $( "#exercise_difficulty_select" ).change(function() {
            $('input[name="exercise_difficulty"]').val($(this).val());
        });
        
       $(".game_id").change(function() {
       		var id=0;
       		$('.game_id :selected').each(function(){
             id++;
            });
        	
            if(id==0)
            {
            	$(".erp").removeClass('show'); 
                $(".erp").addClass('hide');
            }
            else
            {
            	$(".erp").removeClass('hide');
            	$(".erp").addClass('show');           
            }
        });
        
        </script>
       
      
       
       <!-----PAGE LEVEL SCRIPTS END--->
 
 
        
        <!-- END JAVASCRIPTS -->
</body>
<!-- END BODY -->
</html>

<?php 
if($alert_type=='success' && isset($_POST["Submit"]) && $save_data==0)
{
	//usleep(3000000);
	echo '<script>window.location="'.$_SERVER['REQUEST_URI'].'";</script>';
}
?>