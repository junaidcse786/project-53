<?php 

require_once("function.php");

$alert_message=""; $alert_box_show="hide"; $alert_type="success";
	
$err_easy="has-error";

$role_id=isset($_REQUEST["roll_id"])? $_REQUEST["roll_id"] : 0;
$user_email="";
$user_name="";
$user_first_name="";
$user_last_name="";
$user_password="";
$cpassword="";
$image_name='';
$user_status=1;

$user_date_of_birth="";
$user_birth_place="";
$user_phn_no="";
$user_address="";
$user_position="";
$user_department="";
$user_branch="";
$user_passport_no="";
$user_passport_exp_date="";
$user_civil_id_no="";
$user_civil_id_expiry_date="";
$user_ikma_no="";
$user_ikma_expiry_date="";
$user_vacation_total="";
$user_vacation_taken="";

$err=0;

$messages = array(
				  'user_email' => array('status' => '', 'msg' => ''),
				  'user_password' => array('status' => '', 'msg' => ''),
				  'cpassword' => array('status' => '', 'msg' => ''),
				  'user_name' => array('status' => '', 'msg' => ''),
				  'user_first_name' => array('status' => '', 'msg' => ''),
				  'user_last_name' => array('status' => '', 'msg' => '')				  
				);


if(isset($_POST['Submit'])){	

	extract($_POST);
	
	if(empty($user_email))
	{
		$messages["user_email"]["status"]=$err_easy;
		$messages["user_email"]["msg"]="Email is Required";;
		$err++;		
	}
	else if(!isEmail($user_email)){
		$messages["user_email"]["status"]=$err_easy;
		$messages["user_email"]["msg"]="Invalid Email Address";;
		$err++;
	
	}
	else
	{
		$dd = mysqli_query($db, "select user_id from ".$db_suffix."user where user_email='$user_email'");

		if(mysqli_num_rows($dd)>0){
		
			$messages["user_email"]["status"]=$err_easy;
			$messages["user_email"]["msg"]="Email already exists";;
			$err++;		
		}
	}
	
	if(empty($user_name))
	{
		$messages["user_name"]["status"]=$err_easy;
		$messages["user_name"]["msg"]="User Name is Required";;
		$err++;		
	}
	else
	{
		$dd = mysqli_query($db, "select user_id from ".$db_suffix."user where user_name='$user_name'");

		if(mysqli_num_rows($dd)>0){
		
			$messages["user_name"]["status"]=$err_easy;
			$messages["user_name"]["msg"]="User Name already exists";;
			$err++;		
		}
	}
	
	if(empty($user_first_name))
	{
		$messages["user_first_name"]["status"]=$err_easy;
		$messages["user_first_name"]["msg"]="First Name is Required";;
		$err++;		
	}
	
	if(empty($user_last_name)){
		$messages["user_last_name"]["status"]=$err_easy;
		$messages["user_last_name"]["msg"]="Last Name is Required";;
		$err++;		
	}
	if($user_password!=$cpassword || empty($user_password)){
		$messages["user_password"]["status"]=$err_easy;
		$messages["cpassword"]["status"]=$err_easy;
		$messages["cpassword"]["msg"]="Passwords do not match";;
		$err++;		
	}
	
	if($err == 0){
		
		if($_FILES["user_photo"]["name"]!=''){
			$image_dir = "data/user/";
			$image_name = date('ymdgis').$_FILES['user_photo']['name'];
		}
		
		if(!get_magic_quotes_gpc())
		{
			$user_address = addslashes($user_address);
		}
		
		$sql_user = "INSERT INTO ".$db_suffix."user SET 
		
									role_id = '$role_id',
		
		                           	user_first_name = '$user_first_name',
									
									user_last_name = '$user_last_name',
									
									user_name = '$user_name',

									user_email = '$user_email',

									user_password = '".md5($user_password)."',
									
									user_photo  ='$image_name',	
									
									user_date_of_birth  ='$user_date_of_birth',	
									
									user_birth_place  ='$user_birth_place',	
									
									user_phn_no  ='$user_phn_no',	
									
									user_address  ='$user_address',	
									
									user_position  ='$user_position',	
									
									user_department  ='$user_department',	
									
									user_branch  ='$user_branch',	
									
									user_passport_no  ='$user_passport_no',	
									
									user_passport_exp_date  ='$user_passport_exp_date',	
									
									user_civil_id_no  ='$user_civil_id_no',	
									
									user_civil_id_expiry_date  ='$user_civil_id_expiry_date',	
									
									user_ikma_no  ='$user_ikma_no',	
									
									user_ikma_expiry_date  ='$user_ikma_expiry_date',	
									
									user_vacation_total  ='$user_vacation_total',	
									
									user_vacation_taken  ='$user_vacation_taken',	
																		
									user_status = '$user_status'";
		
		if(mysqli_query($db,$sql_user))
		{										
			if($_FILES["user_photo"]["name"]!='')
			
				move_uploaded_file($_FILES['user_photo']['tmp_name'], $image_dir.$image_name);
												 
			$user_email="";
			$user_name="";
			$user_first_name="";
			$user_last_name="";
			$user_password="";
			$cpassword="";
			$user_address='';
			$image_name='';
			
			$user_date_of_birth="";
			$user_birth_place="";
			$user_phn_no="";
			$user_address="";
			$user_position="";
			$user_department="";
			$user_branch="";
			$user_passport_no="";
			$user_passport_exp_date="";
			$user_civil_id_no="";
			$user_civil_id_expiry_date="";
			$user_ikma_no="";
			$user_ikma_expiry_date="";
			$user_vacation_total="";
			$user_vacation_taken="";
												 
			$alert_box_show="show";
			$alert_type="success";
			$alert_message="Data inserted successfully";
				
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

   <link rel="stylesheet" type="text/css" href="<?php echo SITE_URL_ADMIN; ?>assets/global/plugins/bootstrap-fileinput/bootstrap-fileinput.css" />
   
   <link rel="stylesheet" type="text/css" href="<?php echo SITE_URL_ADMIN; ?>assets/global/plugins/bootstrap-datepicker/css/datepicker3.css"/>

<!-----PAGE LEVEL CSS END--->



                                        <!-- BEGIN PAGE TITLE & BREADCRUMB-->
                                        <h3 class="page-title">
                                                Add a new member <small>Here New users can be created</small>
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
                                                        <a href="<?php echo SITE_URL_ADMIN.'?mKey='.$mKey.'&pKey='.$pKey; ?>">Add Member</a>
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
                      
                               
                               <h3 class="form-section">Personal Info</h3>
                               
                               <form action="<?php echo str_replace('&s_factor=1', '', $_SERVER['REQUEST_URI']);?>" class="form-horizontal" method="post" enctype="multipart/form-data">
                               
                               <div class="form-group <?php echo $messages["user_first_name"]["status"] ?>">
                              		<label class="control-label col-md-3" for="user_first_name">First Name <span class="required">*</span></label>
                              		<div class="col-md-4">
                                 		<input type="text" placeholder="" class="form-control" name="user_first_name" value="<?php echo $user_first_name;?>"/>
                                 		<span for="user_first_name" class="help-block"><?php echo $messages["user_first_name"]["msg"] ?></span>
                              		</div>
                           	  </div>
                              
                              <div class="form-group <?php echo $messages["user_last_name"]["status"] ?>">
                              		<label class="control-label col-md-3" for="user_last_name">Last Name <span class="required">*</span></label>
                              		<div class="col-md-4">
                                 		<input type="text" placeholder="" class="form-control" name="user_last_name" value="<?php echo $user_last_name;?>"/>
                                 		<span for="user_last_name" class="help-block"><?php echo $messages["user_last_name"]["msg"] ?></span>
                              		</div>
                           	  </div>

							<div class="form-group">
                                <label class="control-label col-md-3">Date of birth</label>
                                <div class="col-md-4">
                                    <div class="input-group input-medium date date-picker" data-date-format="yyyy-mm-dd">
                                        <input name="user_date_of_birth" type="text" class="form-control" value="<?php echo $user_date_of_birth; ?>" placeholder="YYYY-MM-DD">
                                        <span class="input-group-btn">
                                        	<button class="btn default" type="button"><i class="fa fa-calendar"></i></button>
                                        </span>
                                    </div>
                                </div>
                            </div>
                              
                              <div class="form-group">
                              		<label class="control-label col-md-3" for="user_birth_place">Place of birth</label>
                              		<div class="col-md-4">
                                 		<input type="text" class="form-control" name="user_birth_place" value="<?php echo $user_birth_place;?>"/>
                              		</div>
                           	  </div>

								 <div class="form-group">
                              		<label class="control-label col-md-3" for="user_phn_no">Phone number</label>
                              		<div class="col-md-4">
                                 		<input type="text" class="form-control" name="user_phn_no" value="<?php echo $user_phn_no;?>"/>
                              		</div>
                           	  </div>
                              
                              <div class="form-group">
                              		<label class="control-label col-md-3" for="user_address">User address</label>
                              		<div class="col-md-4">
                                 		<textarea rows="4" class="form-control" name="user_address"><?php echo $user_address; ?></textarea>
                                 		<span for="user_address" class="help-block"></span>
                              		</div>
                           	  </div>

								 <div class="form-group">
                              		<label class="control-label col-md-3" for="user_position">User position</label>
                              		<div class="col-md-4">
                                 		<input type="text" class="form-control" name="user_position" value="<?php echo $user_position;?>"/>
                              		</div>
                           	  </div>

								 <div class="form-group">
                              		<label class="control-label col-md-3" for="user_department">Department</label>
                              		<div class="col-md-4">
                                 		<input type="text" class="form-control" name="user_department" value="<?php echo $user_department;?>"/>
                              		</div>
                           	  </div>

							  <div class="form-group">
                              		<label class="control-label col-md-3" for="user_branch">Branch</label>
                              		<div class="col-md-4">
                                 		<input type="text" class="form-control" name="user_branch" value="<?php echo $user_branch;?>"/>
                              		</div>
                           	  </div>

								 <div class="form-group">
                              		<label class="control-label col-md-3" for="user_passport_no">Passport number</label>
                              		<div class="col-md-4">
                                 		<input type="text" class="form-control" name="user_passport_no" value="<?php echo $user_passport_no;?>"/>
                              		</div>
                           	  </div>

								 <div class="form-group">
                                <label class="control-label col-md-3">Passport expiry date</label>
                                <div class="col-md-4">
                                    <div class="input-group input-medium date date-picker" data-date-format="yyyy-mm-dd">
                                        <input name="user_passport_exp_date" type="text" class="form-control" value="<?php echo $user_passport_exp_date; ?>" placeholder="YYYY-MM-DD">
                                        <span class="input-group-btn">
                                        	<button class="btn default" type="button"><i class="fa fa-calendar"></i></button>
                                        </span>
                                    </div>
                                </div>
                            </div>

								 <div class="form-group">
                              		<label class="control-label col-md-3" for="user_civil_id_no">Civil ID number</label>
                              		<div class="col-md-4">
                                 		<input type="text" class="form-control" name="user_civil_id_no" value="<?php echo $user_civil_id_no;?>"/>
                              		</div>
                           	  </div>

								 <div class="form-group">
                                <label class="control-label col-md-3">Civil ID expiry date</label>
                                <div class="col-md-4">
                                    <div class="input-group input-medium date date-picker" data-date-format="yyyy-mm-dd">
                                        <input name="user_civil_id_expiry_date" type="text" class="form-control" value="<?php echo $user_civil_id_expiry_date; ?>" placeholder="YYYY-MM-DD">
                                        <span class="input-group-btn">
                                        	<button class="btn default" type="button"><i class="fa fa-calendar"></i></button>
                                        </span>
                                    </div>
                                </div>
                            </div>

								 <div class="form-group">
                              		<label class="control-label col-md-3" for="user_ikma_no">Ikma number</label>
                              		<div class="col-md-4">
                                 		<input type="text" class="form-control" name="user_ikma_no" value="<?php echo $user_ikma_no;?>"/>
                              		</div>
                           	  </div>

								 <div class="form-group">
                                <label class="control-label col-md-3">Ikma expiry date</label>
                                <div class="col-md-4">
                                    <div class="input-group input-medium date date-picker" data-date-format="yyyy-mm-dd">
                                        <input name="user_ikma_expiry_date" type="text" class="form-control" value="<?php echo $user_ikma_expiry_date; ?>" placeholder="YYYY-MM-DD">
                                        <span class="input-group-btn">
                                        	<button class="btn default" type="button"><i class="fa fa-calendar"></i></button>
                                        </span>
                                    </div>
                                </div>
                            </div>

								 <div class="form-group">
                              		<label class="control-label col-md-3" for="user_vacation_total">Allowed vacation days</label>
                              		<div class="col-md-4">
                                 		<input type="text" class="form-control" name="user_vacation_total" value="<?php echo $user_vacation_total;?>"/>
                              		</div>
                           	  </div>

								 <div class="form-group">
                              		<label class="control-label col-md-3" for="user_vacation_taken">Spent vacation days</label>
                              		<div class="col-md-4">
                                 		<input type="text" class="form-control" name="user_vacation_taken" value="<?php echo $user_vacation_taken;?>"/>
                              		</div>
                           	  </div>
                              
                              <div class="form-group ">
										<label class="control-label col-md-3">Avatar</label>
										<div class="col-md-9">
											<div class="fileinput fileinput-new" data-provides="fileinput">
												<div class="fileinput-preview thumbnail" data-trigger="fileinput" style="width: 200px; height: 150px;">
												</div>
												<div>
													<span class="btn default btn-file">
													<span class="fileinput-new">
													Select image </span>
													<span class="fileinput-exists">
													Change </span>
													<input type="file" name="user_photo">
													</span>
													<a href="#" class="btn red fileinput-exists" data-dismiss="fileinput">
													Remove </a>
												</div>
											</div>
											<div class="clearfix margin-top-10">
												<span class="label label-danger">
												NOTE!</span> Dimensions must be 29 X 29 pixels.
											</div>
										</div>
									</div>
                                
                               
                             <h3 class="form-section">Login Info</h3> 
                             
                             <div class="form-group hide">
                                  <label for="role_id" class="control-label col-md-3">User Role</label>
                                  <div class="col-md-3">
                                     <select class="form-control" name="role_id">
                                        
                                        <?php
									   $sql_parent_menu = "SELECT role_id, role_title FROM ".$db_suffix."role where role_status='1' and role_id!='8'";	
										$parent_query = mysqli_query($db, $sql_parent_menu);
										while($parent_obj = mysqli_fetch_object($parent_query))
										{	
											if($parent_obj->role_id == $role_id)
											
												echo '<option selected="selected" value="'.$parent_obj->role_id.'">'.$parent_obj->role_title.'</option>';
											
											else
												
												echo '<option value="'.$parent_obj->role_id.'">'.$parent_obj->role_title.'</option>';
									
										}
                                        ?>
                                        
                                     </select>
                                  </div>
                              </div>

							  <div class="form-group <?php echo $messages["user_email"]["status"] ?>">
                              		<label class="control-label col-md-3" for="user_email">User Email <span class="required">*</span></label>
                              		<div class="col-md-4">
                                 		<input type="text" placeholder="" class="form-control" name="user_email" value="<?php echo $user_email;?>"/>
                                 		<span for="user_email" class="help-block"><?php echo $messages["user_email"]["msg"] ?></span>
                              		</div>
                           	  </div>                            
                             
                              <div class="form-group <?php echo $messages["user_name"]["status"] ?>">
                              		<label class="control-label col-md-3" for="user_name">User Name <span class="required">*</span></label>
                              		<div class="col-md-4">
                                 		<input type="text" placeholder="" class="form-control" name="user_name" value="<?php echo $user_name;?>"/>
                                 		<span for="user_name" class="help-block"><?php echo $messages["user_name"]["msg"] ?></span>
                              		</div>
                           	  </div>
                              
                              <div class="form-group <?php echo $messages["user_password"]["status"] ?>">
                              		<label class="control-label col-md-3" for="user_password">Password <span class="required">*</span></label>
                              		<div class="col-md-4">
                                 		<input type="password" placeholder="" class="form-control" name="user_password" value="<?php echo $user_password;?>"/>
                                 		<span for="user_password" class="help-block"><?php echo $messages["user_password"]["msg"] ?></span>
                              		</div>
                           	  </div>
                              
                              <div class="form-group <?php echo $messages["cpassword"]["status"] ?>">
                              		<label class="control-label col-md-3" for="cpassword">Confirm Password <span class="required">*</span></label>
                              		<div class="col-md-4">
                                 		<input type="password" placeholder="" class="form-control" name="cpassword" value="<?php echo $cpassword;?>"/>
                                 		<span for="cpassword" class="help-block"><?php echo $messages["cpassword"]["msg"] ?></span>
                              		</div>
                           	  </div> 

                              <div class="form-group">
                                  <label for="user_status" class="control-label col-md-3">Status</label>
                                  <div class="col-md-2">
                                     <select class="form-control" name="user_status">
                                        <option <?php if($user_status==1) echo 'selected="selected"'; ?> value="1">Active</option>
                                        <option <?php if($user_status==0) echo 'selected="selected"'; ?> value="0">InActive</option>
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
       
       <script type="text/javascript" src="<?php echo SITE_URL_ADMIN; ?>assets/global/plugins/bootstrap-fileinput/bootstrap-fileinput.js"></script>
       
       <script type="text/javascript" src="<?php echo SITE_URL_ADMIN; ?>assets/global/plugins/bootstrap-datepicker/js/bootstrap-datepicker.js"></script>
		<script src="<?php echo SITE_URL_ADMIN; ?>assets/admin/pages/scripts/components-pickers.js"></script>
        
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