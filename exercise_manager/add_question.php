<?php 
	
$alert_message=""; $alert_box_show="hide"; $alert_type="success";
	
$err_easy="has-error";

$exercise_id = isset($_REQUEST["exercise_id"]) ? $_REQUEST["exercise_id"] : '';	
$exercise_title = isset($_REQUEST["title"]) ? $_REQUEST["title"] : '';
$new_question_id = isset($_REQUEST["shutter"]) ? $_REQUEST["shutter"] : '';

$question_desc = "";
$question_title = "";
$question_group = "einfach";
$question_pick = "";
$question_type = "";
$question_marks=1;
$question_case=1;
$question_answer="";
$option="";

$err=0;

$messages = array(
					'question_desc' => array('status' => '', 'msg' => ''),
					'question_title' => array('status' => '', 'msg' => ''),
					'question_group' => array('status' => '', 'msg' => ''),
					'question_pick' => array('status' => '', 'msg' => ''),
					'question_type' => array('status' => '', 'msg' => ''),
					'question_answer' => array('status' => '', 'msg' => ''),
					'option' => array('status' => '', 'msg' => ''),
					'exercise_id' => array('status' => '', 'msg' => ''),
					'question_marks' => array('status' => '', 'msg' => ''),
				);

if(isset($_POST['Submit']))
{	
	extract($_POST);
	
	if(empty($exercise_id))
	{
		$messages["exercise_id"]["status"]=$err_easy;
		$messages["exercise_id"]["msg"]="This field is Required";;
		$err++;		
	}
	
	if(empty($question_group))
	{
		$messages["question_group"]["status"]=$err_easy;
		$messages["question_group"]["msg"]="Difficulty is Required";;
		$err++;		
	}
	
	/*if(empty($question_pick))
	{
		$messages["question_pick"]["status"]=$err_easy;
		$messages["question_pick"]["msg"]="Group is Required";;
		$err++;		
	}*/
	
	if(empty($question_marks) || $question_marks=='0' || !is_numeric($question_marks))
	{
		$messages["question_marks"]["status"]=$err_easy;
		$messages["question_marks"]["msg"]="Invalid Marks/points";;
		$err++;		
	}
	else
	{
		if($question_type!='Text')
		
			$question_marks=count(explode('+', $question_answer));
			
		else
		
			$question_marks=count(explode('.', $question_answer))-1;
	}
	
	if(empty($question_desc))
	{
		$messages["question_desc"]["status"]=$err_easy;
		$messages["question_desc"]["msg"]="This field is Required";;
		$err++;		
	}
	else
	{
		/*$question_desc=str_replace('autocomplete="off" class="form-control input-sm" name="question" ', '', $question_desc);
		
		$question_desc=str_replace('<input type="', '<input autocomplete="off" class="form-control input-sm" name="question" type="', $question_desc);
		
		$question_desc=str_replace('<input maxlength="', '<input autocomplete="off" class="form-control input-sm" name="question" maxlength="', $question_desc);
		
		$question_desc=str_replace('<input size="', '<input autocomplete="off" class="form-control input-sm" name="question" size="', $question_desc);
		
		$question_desc=str_replace('<select', '<select class="form-control input-sm" name="question" ', $question_desc);*/
		
		$question_desc=str_replace('autocomplete="off"', '', $question_desc);
		
		//$question_desc=str_replace('class="form-control input-sm"', '', $question_desc);

		$question_desc=str_replace('name="question"', '', $question_desc);

		$question_desc=str_replace('<input', '<input name="question" ', $question_desc);	

		$question_desc=str_replace('<select', '<select name="question" ', $question_desc);
		
		if (strpos($question_desc, 'class="form-control input-sm') === false) 
			
			$question_desc=str_replace('name="question"', ' name="question" autocomplete="off" class="form-control input-sm"', $question_desc);
	    
		else 
		
			$question_desc=str_replace('name="question"', ' name="question" autocomplete="off" ', $question_desc);
		
		
		$question_desc=str_replace('<textarea', '<textarea class="form-control" name="question" ', $question_desc);
		
	}
	
	if(empty($question_answer))
	{
		$messages["question_answer"]["status"]=$err_easy;
		$messages["question_answer"]["msg"]="This field is Required";;
		$err++;		
	}
	else
	{
		if($question_type=='Text')
		
			$estimated_marks=count(explode('.', strip_tags($question_desc)))-1;
		
		else
		
			$estimated_marks=get_answer($question_desc);	
		
		if($estimated_marks != $question_marks)
		{
			$messages["question_answer"]["status"]=$err_easy;
			
			if($question_type!='Text')
			
				$messages["question_answer"]["msg"]="Number of answers do not match with fields. Please check again.";
				
			else
			
				$messages["question_answer"]["msg"]="Number of sentences in the Answer do not match with the one of sentences in the Question.";
					
			$err++;		
		}
	}
	
	/*if(empty($option) && ($question_type=='MCQ' || $question_type=='Dropdown'))
	{
		$messages["option"]["status"]=$err_easy;
		$messages["option"]["msg"]="This field is Required if the question type is MCQ or Dropdown";;
		$err++;		
	}*/
	
	
	
	if($err == 0)
	{
		
		if(empty($question_pick)){
			
			while(1){
				
				$question_pick="";
				
				$question_pick=mt_rand(1, 1000);
				$dd = mysqli_query($db, "select question_id from ".$db_suffix."question where exercise_id='$exercise_id' AND question_pick='$question_pick'");

				if(mysqli_num_rows($dd)<=0)
				
					break;					
			}
		}		
		
		$sql = "INSERT INTO ".$db_suffix."question SET question_pick='$question_pick', question_title='$question_title', question_desc='$question_desc', question_type='$question_type', question_answer='$question_answer', exercise_id='$exercise_id', question_marks='$question_marks', user_id='".$_SESSION['user_id']."', question_case='$question_case', question_group='$question_group', question_status='1'";
		
		if(mysqli_query($db,$sql))
		{		
			$new_question_id=mysqli_insert_id($db);
			
			$alert_message="Data inserted successfully";		
			$alert_box_show="show";
			$alert_type="success";
			
			$question_pick = "";
			
			if(isset($save_data) && $save_data ==0){
				$exercise_id = isset($_REQUEST["exercise_id"]) ? $_REQUEST["exercise_id"] : '';	
				$question_desc = "";
				$question_type = "";
				$question_marks=1;
				$question_group = "einfach";
				$question_answer="";
				$question_case=1;
				$option="";
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

<link rel="stylesheet" type="text/css" href="<?php echo SITE_URL_ADMIN; ?>assets/global/plugins/select2/select2.css" />

<!-----PAGE LEVEL CSS END--->



                                        <!-- BEGIN PAGE TITLE & BREADCRUMB-->
                                        <h3 class="page-title">
                                                <?php echo $menus["$mKey"]["$pKey"]; ?> <small>Here New questions can be added to the existing exercise</small>
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
                                                <?php if(isset($_REQUEST["exercise_id"])) { ?>
                                                <li>
                                                        <a href="<?php echo SITE_URL_ADMIN.'?mKey='.$mKey.'&pKey=questionlist&id='.$exercise_id.'&title='.$exercise_title; ?>">Questions List in <?php echo $exercise_title; ?></a></a>
                                                        <i class="fa fa-angle-right"></i>
                                                </li>
                                                
                                                <?php } ?>
                                                
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
                     <div class="actions"><?php 
							
						if($new_question_id!=''){
							  
							  	echo ' <a target="_blank" href="'.SITE_URL_ADMIN.'?mKey=exercise&pKey=editquestion&id='.$new_question_id.'" class="btn default blue-ebonyclay"><i class="fa fa-edit"></i> Edit Last Question</a>';
								
								
						}
							  
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
                               
                               
                              <div class="form-group <?php echo $messages["question_desc"]["status"] ?>">
                              		<label class="control-label col-md-3" for="question_desc">State the question <span class="required">*</span></label>
                              		<div class="col-md-9">
                                 		<textarea id="editor1" class="form-control ckeditor" rows="6" name="question_desc"><?php echo htmlspecialchars($question_desc); ?></textarea>
                                 		<span for="question_desc" class="help-block"><?php echo $messages["question_desc"]["msg"] ?></span>
                              		</div>
                              </div>
                              
                              <div class="form-group <?php echo $messages["exercise_id"]["status"] ?>">
                                 <label for="exercise_id" class="control-label col-md-3">Corresponding Exercise <span class="required">*</span></label>
                                 <div class="col-md-4">
                                    <select class="form-control select2me"  data-placeholder="Choose an Exercise" tabindex="0" name="exercise_id">
                                       <option value="0">Select One</option>
                                                                              
                                       <?php
									   $sql_parent_menu = "SELECT exercise_id, exercise_title FROM ".$db_suffix."exercise";	
										$parent_query = mysqli_query($db, $sql_parent_menu);
										while($parent_obj = mysqli_fetch_object($parent_query))
										{	
											if($parent_obj->exercise_id == $exercise_id)
											
												echo '<option selected="selected" value="'.$parent_obj->exercise_id.'">'.$parent_obj->exercise_title.'</option>';
											
											else
												
												echo '<option value="'.$parent_obj->exercise_id.'">'.$parent_obj->exercise_title.'</option>';
									
										}
                                        ?>
                                       
                                       
                                    </select>
                                    <span for="exercise_id" class="help-block"><?php echo $messages["exercise_id"]["msg"] ?></span>
                                 </div>
                              </div>
                              
                              <div class="form-group  <?php echo $messages["question_type"]["status"] ?>">
                                  <label for="question_type" class="control-label col-md-3">Type of Question <span class="required">*</span></label>
                                  <div class="col-md-4">
                                     <select class="form-control input-small" name="question_type">
                                     
                                     <option <?php if($question_type=='MCQ') echo 'selected="selected"'; ?> value="MCQ">MCQ</option>
                                        <option <?php if($question_type=='Fill in the gap') echo 'selected="selected"'; ?> value="Fill in the gap">Fill in the gap</option>
                                        
                                         <option <?php if($question_type=='Dropdown') echo 'selected="selected"'; ?> value="Dropdown">Dropdown</option>
                                         
                                         <option <?php if($question_type=='Text') echo 'selected="selected"'; ?> value="Text">Text</option>
                                         
                                         <option <?php if($question_type=='Combo') echo 'selected="selected"'; ?> value="Combo">Combo</option>
                                        
                                     </select>
                                     <span for="question_type" class="help-block"><?php echo $messages["question_type"]["msg"] ?></span>
                                  </div>
                              </div>
                              
                              <div class="form-group <?php echo $messages["question_marks"]["status"] ?>">
                              		<label class="control-label col-md-3" for="question_marks">Marks or Points for this question <span class="required">*</span></label>
                              		<div class="col-md-4">
                                 		<input type="text" placeholder="" class="form-control input-medium" name="question_marks" value="<?php echo $question_marks;?>"/>
                                 		<span for="question_marks" class="help-block"><?php echo $messages["question_marks"]["msg"] ?></span>
                              		</div>
                           	  </div>
                              
                              <!--<div class="form-group  <?php echo $messages["option"]["status"] ?>">
                              		<label class="control-label col-md-3" for="option">Options for Question</label>
                              		<div class="col-md-6">
                                 		<textarea rows="6" class="form-control" name="option"><?php echo $option; ?></textarea>
                                 		<span for="option" class="help-block"><?php echo $messages["option"]["msg"] ?></span>
                              		</div>
                           	  </div>-->
                              
                              <div class="form-group  <?php echo $messages["question_answer"]["status"] ?>">
                              		<label class="control-label col-md-3" for="question_answer">Correct Answer <span class="required">*</span></label>
                              		<div class="col-md-9">
                                 		<textarea rows="6" class="form-control question_desc" name="question_answer"><?php echo $question_answer; ?></textarea>
                                 		<span for="question_answer" class="help-block"><span class="label label-danger">NOTE!</span> Use + (addition operator) to seperate answers (White space tolerable). For 2 or more correct answers, use = (equal sign) (Also White space tolerable). In case of a <strong>Text type</strong> question, just enter the text exactly how you want it (including punctuations).<br /><br /><strong><?php echo $messages["question_answer"]["msg"] ?></strong></span>
                              		</div>
                           	  </div>
                              
                              <div class="form-group <?php echo $messages["question_title"]["status"] ?>">
                              		<label class="control-label col-md-3" for="question_desc">Explain the answer (if needed)</label>
                              		<div class="col-md-9">
                                 		<textarea id="editor1" class="form-control ckeditor" rows="6" name="question_title"><?php echo $question_title;?></textarea>
                                 		<span for="question_desc" class="help-block"><?php echo $messages["question_title"]["msg"] ?></span>
                              		</div>
                              </div>
                              
                              <div class="form-group  <?php echo $messages["question_group"]["status"] ?>">
                                  <label for="question_group" class="control-label col-md-3">Difficulty <span class="required">*</span></label>
                                  
                                  <div class="col-md-4">
                                  
                                  <input type="text" placeholder="" class="form-control input-small" name="question_group" value="<?php echo $question_group;?>"/> 
                                    
                                    <span for="question_group" class="help-block"><?php echo $messages["question_group"]["msg"] ?></span>
                                    <br />
                                     <select class="form-control input-small select2me"  data-placeholder="Choose a difficulty" tabindex="0" id="question_group_select" name="question_group_select">
                                     <option></option>
									 
									 <?php 
									 
									 $sql_parent_menu = "SELECT DISTINCT question_group FROM ".$db_suffix."question where question_group!=''";	
									$parent_query = mysqli_query($db, $sql_parent_menu);
									 
									 while($parent_obj = mysqli_fetch_object($parent_query))
										
										echo '<option value="'.$parent_obj->question_group.'">'.$parent_obj->question_group.'</option>';
									
										
                                      ?>
                                        
                                     </select>
                                     <span for="question_group" class="help-block">Choose from existing difficulty level</span>
                                  </div>
                              </div>
                              
                              <div class="form-group  <?php echo $messages["question_pick"]["status"] ?>">
                                  <label for="question_pick" class="control-label col-md-3">Group <span class="required">*</span></label>
                                  
                                  <div class="col-md-9">
                                  
                                  <input type="text" placeholder="" class="form-control input-large" name="question_pick" value="<?php echo $question_pick;?>"/> 
                                    
                                    <span for="question_pick" class="help-block"><span class="label label-danger">NOTE!</span> Only one question will be picked from each group<br /><?php echo $messages["question_pick"]["msg"] ?></span>
                                    <br />
                                     <select class="form-control input-large select2me"  data-placeholder="Choose a group" tabindex="0" id="question_pick_select" name="question_pick_select">
                                     <option></option>
									 
									 <?php 
									 
									 if(isset($exercise_id)){
									 $sql_parent_menu = "SELECT DISTINCT question_pick FROM ".$db_suffix."question where question_pick!='' AND exercise_id='$exercise_id'";	
									$parent_query = mysqli_query($db, $sql_parent_menu);
									 
									 while($parent_obj = mysqli_fetch_object($parent_query))
										
										echo '<option value="'.$parent_obj->question_pick.'">'.$parent_obj->question_pick.'</option>';
									 }									
										
                                     ?>
                                        
                                     </select>
                                     <span for="question_pick" class="help-block">Choose from existing group</span>
                                  </div>
                              </div>
                              
                              <div class="form-group">
                                  <label for="question_case" class="control-label col-md-3">Case Sensitive?</label>
                                  <div class="col-md-4">
                                     <select class="form-control input-small" name="question_case">
                                        <option <?php if($question_case==1) echo 'selected="selected"'; ?> value="1">Yes</option>
                                        <option <?php if($question_case==0) echo 'selected="selected"'; ?> value="0">No</option>
                                     </select>
                                     <span for="question_case" class="help-block">If the capital/small letters of the answer matter or not?</span>
                                  </div>
                              </div>
                              
                              <div class="form-group">
                                    <label  class="control-label col-md-3">Keep Last Saved Data?</label>
                                    <div class="radio-list col-md-4">
                                        <label class="radio-inline">
                                        <input type="radio" name="save_data" checked value="1"> Yes </label>
                                        <label class="radio-inline">
                                        <input type="radio" name="save_data" value="0"> No </label>			
                                        
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

<script type="text/javascript" src="<?php echo SITE_URL_ADMIN; ?>assets/global/plugins/ckeditor/ckeditor.js"></script>
 
<script>

$( "#question_group_select" ).change(function() {
	$('input[name="question_group"]').val($(this).val());
});

$( "#question_pick_select" ).change(function() {
	$('input[name="question_pick"]').val($(this).val());
});

$('select[name="exercise_id"]').change(function() {
			
	var exercise_id=$(this).val();            
	$('select[name="question_pick_select"]').empty();
	$('select[name="question_pick_select"]').append('<option selected="selected" value=""> </option>');
	
	$.ajax({
		   type: "POST",
		   url:  '<?php echo SITE_URL_ADMIN.'exercise_manager/change_group_AJAX.php?id=' ?>'+exercise_id,
		   success: function(data){		
				$('select[name="question_pick_select"]').append(data);
				$('select[name="question_pick_select"]').select2();
		   },
		   error : function(data){
				alert("PHP file not found");
		   }			   		
   });
   
	$('select[name="question_pick_select"]').select2();
});

</script> 
       
       <!-----PAGE LEVEL SCRIPTS END--->
 
 
        
        <!-- END JAVASCRIPTS -->
</body>
<!-- END BODY -->
</html>

<?php

function get_answer($string){

	$damn=explode(' ', $string);
	
	$all_index=array(); $kall=0;
	
	
	$type='type="text"'; $tf_index=array(); $ktf=0;
	
	for($i=0;$i<count($damn);$i++)
	{
		if($damn[$i]==$type)
		
			{ $tf_index[$ktf]=$i;	$ktf++; $all_index[$kall]=$i;	$kall++;}
	}
	
	$type='<textarea'; $ta_index=array(); $kta=0;
	
	for($i=0;$i<count($damn);$i++)
	{
		if(stripos($damn[$i],$type))	
		
			{ $ta_index[$kta]=$i;	$kta++; $all_index[$kall]=$i;	$kall++;}
	}
	
	
	$type='type="radio"'; $rf_index=array(); $krf=0;
	
	for($i=0;$i<count($damn);$i++)
	{
		if($damn[$i]==$type)
		
			{ $rf_index[$krf]=$i;	$krf++; $all_index[$kall]=$i;	$kall++;}
	}
	
	
	$type='<select'; $s_index=array(); $ks=0;
	
	for($i=0;$i<count($damn);$i++)
	{
		if(strpos($damn[$i],$type)!== false)
		
			{ $s_index[$ks]=$i;	$ks++; $all_index[$kall]=$i;	$kall++;}
	}
	
	$field_array=array(); $ff=0;
	
	foreach($all_index as $value)
	{
		if(in_array($value, $tf_index))
			
			$field_array[$ff]="text";
			
		if(in_array($value, $rf_index))
			
			$field_array[$ff]="radio";	
			
		if(in_array($value, $s_index))
			
			$field_array[$ff]="select";	
			
		if(in_array($value, $ta_index))
			
			$field_array[$ff]="textarea";	
		
		$ff++;		
	}
	
	$futter=0; $field_array[$ff]="tt";
	
	for($i=1;$i<count($field_array);$i++)
	{
		$dummy_data=$field_array[$i-1];
		
		if(($dummy_data=='radio') && $dummy_data!=$field_array[$i])
			
				$futter++;
			
		else if($dummy_data=='text')
			
				$futter++;
		
		else if($dummy_data=='select')
			
				$futter++;
				
		else if($dummy_data=='textarea')
			
				$futter++;		
				
		$dummy_data=$field_array[$i];		
	}
	
	return $futter;
}

 
if($alert_type=='success' && isset($_POST["Submit"]) && $save_data==0)
{
	//usleep(3000000);
	echo '<script>window.location="'.$_SERVER['REQUEST_URI'].'&shutter='.$new_question_id.'";</script>';
}

?>