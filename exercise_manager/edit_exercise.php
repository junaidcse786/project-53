<?php

function clean_string($string){	
	$string=  str_ireplace("'",  "&apos;", $string);
	$string=  str_ireplace("\\", "&bsol;", $string);
	$string=  str_ireplace('"',  "&quot;", $string);
	return $string;
}

$id = isset($_REQUEST['id']) ? $_REQUEST['id']: 0;
$sql = "select * from ".$db_suffix."exercise where exercise_id = $id limit 1";				
$query = mysqli_query($db, $sql);

if(mysqli_num_rows($query) > 0)
{
	$content     = mysqli_fetch_object($query);
	
	
	$exercise_title       =  $content->exercise_title;	
	$exercise_desc    = $content->exercise_desc;
	$exercise_topic    = $content->exercise_topic;
	$exercise_duration = $content->exercise_duration;
	$exercise_type  = $content->exercise_type;
	$exercise_difficulty    = $content->exercise_difficulty;
	$exercise_level    = $content->exercise_level;
	$exercise_status      = $content->exercise_status;
	$exercise_old_status      = $content->exercise_status;
	$exercise_pull      = $content->exercise_pull;
	$image_name      = $content->exercise_file;
	$image_old      = $content->exercise_file;
	$exercise_req_percentage      = $content->exercise_req_percentage;
}

	
$alert_message=""; $alert_box_show="hide"; $alert_type="success";
	
$err_easy="has-error";

$err=0;

$messages = array(
					'exercise_title' => array('status' => '', 'msg' => ''),
					'exercise_pull' => array('status' => '', 'msg' => ''),
					'exercise_desc' => array('status' => '', 'msg' => ''),
					'exercise_topic' => array('status' => '', 'msg' => ''),
					'exercise_req_percentage' => array('status' => '', 'msg' => ''),
					'exercise_duration' => array('status' => '', 'msg' => ''),
					'exercise_type' => array('status' => '', 'msg' => ''),
					'exercise_difficulty' => array('status' => '', 'msg' => ''),
					'exercise_level' => array('status' => '', 'msg' => ''),
					'exercise_status' => array('status' => '', 'msg' => ''),
				);

if(isset($_POST['Submit']))
{	
	if(!count($_POST["exercise_req"])>0)
	
		$exercise_req=array();
		
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
	
	if(empty($exercise_pull) || $exercise_pull=='0')
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
			
		
		$sql = "UPDATE ".$db_suffix."exercise SET exercise_title='$exercise_title', exercise_desc='$exercise_desc', exercise_duration='$exercise_duration', exercise_type='$exercise_type', exercise_difficulty='$exercise_difficulty', exercise_level='$exercise_level', exercise_req_percentage='$exercise_req_percentage', exercise_status='$exercise_status', exercise_file='$image_name', exercise_pull='$exercise_pull', exercise_topic='$exercise_topic' where exercise_id='$id'";
		
		if(mysqli_query($db,$sql))
		{		
			if($exercise_status==1 && $exercise_old_status==0)
			
				mysqli_query($db,"UPDATE ".$db_suffix."exercise SET exercise_created_time=NOW() where exercise_id='$id'");			
			
			$alert_message="Data updated successfully";		
			$alert_box_show="show";
			$alert_type="success";
			
				
			if(count($exercise_req)>0)
			{
				mysqli_query($db,"DELETE FROM ".$db_suffix."exe_req where exercise_id='$id'");
				
				foreach($exercise_req as $value)
		
					mysqli_query($db,"INSERT INTO ".$db_suffix."exe_req SET exercise_id='$id', req_id='$value'");
			}
			else
			
				mysqli_query($db,"DELETE FROM ".$db_suffix."exe_req where exercise_id='$id'");
		
			
		
		move_uploaded_file($_FILES['gallery_file']['tmp_name'], $image_dir.$image_name);
			
			if(is_file($image_dir.$image_old))
					
					unlink($image_dir.$image_old);
			
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

$exercise_req=array();$i=0;
$sql = "select * from ".$db_suffix."exe_req where exercise_id = $id";				
$query = mysqli_query($db, $sql);
while($row=mysqli_fetch_object($query))
{
	$exercise_req[$i] = $row->req_id;
	$i++;
}

if(!isset($_POST["Submit"]) && isset($_GET["s_factor"]))
{
	$alert_message="Data updated successfully";		
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
                                                Exercise Manager <small>Here existing exercises can be altered</small>
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
                                                        <a href="<?php echo SITE_URL_ADMIN.'?mKey=exercise&pKey=exerciselist'; ?>">Exercise List</a>
														<i class="fa fa-angle-right"></i>
                                                </li>
												<li>
                                                        <a  href="#">Update Content ID: <?php echo $id; ?></a>
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
                     <div class="actions">
					 <?php 
					 
					 	echo '<a target="_blank" href="'.SITE_URL_ADMIN.'?mKey='.$mKey.'&pKey=questionlist&id='.$id.'&title='.$exercise_title.'" class="btn default green-seagreen"><i class="fa fa-book"></i> Questions List </a> '; 
						
						echo '<a target="_blank" href="'.SITE_URL.'exercise-trial/'.$id.'/'.$exercise_title.'" class="btn default blue-ebonyclay"><i class="fa fa-video-camera"></i> Preview Exercise </a>'; 
							  
					?>
                     </div>
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
                                  <div class="col-md-4">
                                  	
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
                                    <select class="game_id form-control select2me"  data-placeholder="Choose Exercise(s)" tabindex="0" name="exercise_req[]" multiple="multiple">
                                                                              
                                       <?php
									   $sql_parent_menu = "SELECT exercise_id, exercise_title FROM ".$db_suffix."exercise where exercise_id!='$id'";	
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
                              
                              
                              <div class="form-group <?php echo $messages["exercise_pull"]["status"] ?>"">
                                <label class="control-label col-md-3" for="exercise_pull">Number of questions to pull <span class="required">*</span></label>
                                
                                <div class="col-md-5">
                                    <div id="spinner1">
                                        <div class="input-group input-small">
                                            <input type="text" class="spinner-input form-control" maxlength="3" name="exercise_pull" value="<?php echo $exercise_pull;?>">
                                            <div class="spinner-buttons input-group-btn btn-group-vertical">
                                                <button type="button" class="btn spinner-up btn-xs blue">
                                                <i class="fa fa-angle-up"></i>
                                                </button>
                                                <button type="button" class="btn spinner-down btn-xs blue">
                                                <i class="fa fa-angle-down"></i>
                                                </button>
                                            </div>
                                        </div>
                                    </div>
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

<script type="text/javascript" src="<?php echo SITE_URL_ADMIN; ?>assets/global/plugins/fuelux/js/spinner.min.js"></script>

<script src="<?php echo SITE_URL_ADMIN; ?>assets/global/plugins/bootstrap-maxlength/bootstrap-maxlength.min.js" type="text/javascript"></script>

<script src="<?php echo SITE_URL_ADMIN; ?>assets/global/plugins/bootstrap-touchspin/bootstrap.touchspin.js" type="text/javascript"></script>

<script src="<?php echo SITE_URL_ADMIN; ?>assets/global/plugins/typeahead/handlebars.min.js" type="text/javascript"></script>

<script src="<?php echo SITE_URL_ADMIN; ?>assets/global/plugins/typeahead/typeahead.bundle.min.js" type="text/javascript"></script>

<script type="text/javascript" src="<?php echo SITE_URL_ADMIN; ?>assets/global/plugins/ckeditor/ckeditor.js"></script>

<script src="<?php echo SITE_URL_ADMIN; ?>assets/admin/pages/scripts/components-form-tools.js"></script>

<script src="<?php echo SITE_URL_ADMIN; ?>assets/admin/pages/scripts/components-pickers.js"></script>

		
        
        <script>
        jQuery(document).ready(function() {       
			   ComponentsPickers.init();
               ComponentsFormTools.init();
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
if($alert_type=='success' && isset($_POST["Submit"]))
{
	//usleep(3000000);
	echo '<script>window.location="'.$_SERVER['REQUEST_URI'].'&s_factor=1";</script>';
}
?>