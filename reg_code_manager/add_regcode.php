<?php 
	
$alert_message=""; $alert_box_show="hide"; $alert_type="success";
	
$err_easy="has-error";

$task_title = "";
$task_deadline = "";
$task_desc = "";
$user_id="";
$task_status = 1;

$err=0;

$messages = array(
					'task_title' => array('status' => '', 'msg' => ''),
					'task_deadline' => array('status' => '', 'msg' => ''),
					'task_desc' => array('status' => '', 'msg' => ''),
					'task_status' => array('status' => '', 'msg' => ''),
				);

if(isset($_POST['Submit']))
{	
	extract($_POST);
	
	if(empty($task_title))
	{
		$messages["task_title"]["status"]=$err_easy;
		$messages["task_title"]["msg"]="Task Title is Required";;
		$err++;		
	}	
	
	if($err == 0)
	{
        $sql = "INSERT INTO ".$db_suffix."task SET

                                                task_title='$task_title', 
                                                
                                                task_deadline='$task_deadline', 
                                                
                                                task_desc='$task_desc',

                                                user_id = '$user_id',
                                                
                                                task_status='$task_status'";         
		
		if(mysqli_query($db,$sql))
		{		
			$codes_id=mysqli_insert_id($db);
			
			$alert_message="Data inserted successfully";		
			$alert_box_show="show";
			$alert_type="success";
			
			$task_title = "";
            $task_deadline = "";
            $task_desc = "";
            $user_id="";
            $task_status = 1;	
			
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

<link rel="stylesheet" type="text/css" href="<?php echo SITE_URL_ADMIN; ?>assets/global/plugins/bootstrap-datepicker/css/datepicker3.css"/>

<!-----PAGE LEVEL CSS END--->



                                        <!-- BEGIN PAGE TITLE & BREADCRUMB-->
                                        <h3 class="page-title">
                                                <?php echo $menus["$mKey"]["$pKey"]; ?> <small>Here tasks can be created for the emlpoyees</small>
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
                               
                               
                              <div class="form-group <?php echo $messages["task_title"]["status"] ?>">
                              		<label class="control-label col-md-3" for="task_title">Title <span class="required">*</span></label>
                              		<div class="col-md-4">
                                 		<input type="text" placeholder="" class="form-control" name="task_title" value="<?php echo $task_title;?>"/>
                                 		<span for="task_title" class="help-block">Provide a title for the task<br /><?php echo $messages["task_title"]["msg"] ?></span>
                              		</div>
                           	  </div>
                              
                                 <div class="form-group <?php echo $messages["task_desc"]["status"] ?>">
                              		<label class="control-label col-md-3" for="task_desc">Explain the task</label>
                              		<div class="col-md-9">
                                 		<textarea class="form-control ckeditor" rows="6" name="task_desc"><?php echo htmlspecialchars($task_desc); ?></textarea>
                                 		<span for="task_desc" class="help-block"><?php echo $messages["task_desc"]["msg"] ?></span>
                              		</div>
                              </div>
                              
                              <div class="form-group <?php echo $messages["task_deadline"]["status"] ?>">
                                <label class="control-label col-md-3">Task deadline</label>
                                <div class="col-md-4">
                                    <div class="input-group input-medium date date-picker" data-date-format="yyyy-mm-dd" data-date-start-date="+0d">
                                        <input name="task_deadline" type="text" class="form-control" value="<?php echo $task_deadline; ?>" readonly>
                                        <span class="input-group-btn">
                                        <button class="btn default" type="button"><i class="fa fa-calendar"></i></button>
                                        </span>
                                    </div>
                                    <!-- /input-group -->
                                    <span class="help-block">
                                    <?php echo $messages["task_deadline"]["msg"] ?></span>
                                </div>
                            </div>  
                              
                            <div class="form-group">
                                  <label for="user_id" class="control-label col-md-3">Assign task to: </label>
                                  <div class="col-md-3">
                                     <select class="form-control" name="user_id">
                                        <option value=""></option>
                                        
                                        <?php
									   $sql_parent_menu = "SELECT user_id, user_first_name, user_last_name FROM ".$db_suffix."user where user_status='1' AND role_id='".EMP_ROLE_ID."'";	
										$parent_query = mysqli_query($db, $sql_parent_menu);
										while($parent_obj = mysqli_fetch_object($parent_query))
										{	
											if($parent_obj->user_id == $user_id)
											
												echo '<option selected="selected" value="'.$parent_obj->user_id.'">'.$parent_obj->user_first_name.' '.$parent_obj->user_last_name.'</option>';
											
											else
												
                                                echo '<option value="'.$parent_obj->user_id.'">'.$parent_obj->user_first_name.' '.$parent_obj->user_last_name.'</option>';
									
										}
                                        ?>
                                        
                                     </select>
                                  </div>
                              </div>
                              
                              <div class="form-group last">
                                  <label for="task_status" class="control-label col-md-3">Status</label>
                                  <div class="col-md-2">
                                     <select class="form-control" name="task_status">
                                        <option <?php if($task_status==1) echo 'selected="selected"'; ?> value="1">Active</option>
                                        <option <?php if($task_status==0) echo 'selected="selected"'; ?> value="0">InActive</option>
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
       
       	<script type="text/javascript" src="<?php echo SITE_URL_ADMIN; ?>assets/global/plugins/bootstrap-datepicker/js/bootstrap-datepicker.js"></script>
		<script src="<?php echo SITE_URL_ADMIN; ?>assets/admin/pages/scripts/components-pickers.js"></script>
        <script type="text/javascript" src="<?php echo SITE_URL_ADMIN; ?>assets/global/plugins/ckeditor/ckeditor.js"></script>

        
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