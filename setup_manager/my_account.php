<?php 

require_once("function.php");

$alert_message=""; $alert_box_show="hide"; $alert_type="success";
	
$err_easy="has-error";


$user_id = $_SESSION["user_id"];

$sql = "select * from ".$db_suffix."user where user_id = '$user_id' limit 1";				
$query = mysqli_query($db, $sql);

if(mysqli_num_rows($query) > 0)
{
	$usr = mysqli_fetch_object($query);
	$email = $usr->user_email;
	
	$role_id= $usr->role_id;
	$user_email= $usr->user_email;
	$user_name= $usr->user_name;
	$user_first_name= $usr->user_first_name;
	$user_last_name= $usr->user_last_name;
	$user_password_md5_old= $usr->user_password;
	$user_password= "";
	$cpassword= "";
	$alt_password= "";
	$user_status= $usr->user_status;
	$user_description= $usr->user_description;
	$image_old_name=$usr->user_photo;
	$image_name=$image_old_name;
}


$err=0;

$messages = array(
				  'user_email' => array('status' => '', 'msg' => ''),
				  'user_password' => array('status' => '', 'msg' => ''),
				  'alt_password' => array('status' => '', 'msg' => ''),
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
		$messages["user_email"]["msg"]="Required field";;
		$err++;		
	}
	else if(!isEmail($user_email)){
		$messages["user_email"]["status"]=$err_easy;
		$messages["user_email"]["msg"]="Invalid email address";;
		$err++;
	
	}
	else
	{
		$dd = mysqli_query($db, "select user_id from ".$db_suffix."user where user_email='$user_email' AND user_id!='$user_id'");

		if(mysqli_num_rows($dd)>0){
		
			$messages["user_email"]["status"]=$err_easy;
			$messages["user_email"]["msg"]="Emal already taken";;
			$err++;		
		}
	}
	
	if(empty($user_name))
	{
		$messages["user_name"]["status"]=$err_easy;
		$messages["user_name"]["msg"]="Required field";;
		$err++;		
	}
	else
	{
		$dd = mysqli_query($db, "select user_id from ".$db_suffix."user where user_name='$user_name' AND user_id!='$user_id'");

		if(mysqli_num_rows($dd)>0){
		
			$messages["user_name"]["status"]=$err_easy;
			$messages["user_name"]["msg"]="Username already taken";;
			$err++;		
		}
	}
	
	if(empty($user_first_name))
	{
		$messages["user_first_name"]["status"]=$err_easy;
		$messages["user_first_name"]["msg"]="Required field";;
		$err++;		
	}
	
	if(empty($user_last_name)){
		$messages["user_last_name"]["status"]=$err_easy;
		$messages["user_last_name"]["msg"]="Required field";;
		$err++;		
	}
	
	if(!empty($alt_password)){
	    
	    $dd = mysqli_query($db, "select user_id from ".$db_suffix."user where (user_password='".md5($alt_password)."' OR user_password='$alt_password') AND user_id='$user_id'");

		if(mysqli_num_rows($dd)>0){
		
			if($user_password!=$cpassword){
        		$messages["user_password"]["status"]=$err_easy;
        		$messages["cpassword"]["status"]=$err_easy;
        		$messages["cpassword"]["msg"]="Passwords do not match";
        		$err++;		
        	}
        	else
        	    $user_password_md5_old = md5($user_password);
		}
	    else{
	        $messages["alt_password"]["status"]=$err_easy;
    		$messages["alt_password"]["msg"]="Old password is incorrect";;
    		$err++;	
	    }
	}

	if($err == 0){
		
		if($_FILES["user_photo"]["name"]!=''){
			$image_dir = "../data/user/";
			$image_name = date('ymdgis').$_FILES['user_photo']['name'];
		}
		else
			
			$image_name=$image_old_name;
		
		if(!get_magic_quotes_gpc())
		{
			$user_description = addslashes($user_description);
		}
		
		$sql_user = "UPDATE ".$db_suffix."user SET 
		
									role_id = '$role_id',
		
		                           	user_first_name = '$user_first_name',
									
									user_last_name = '$user_last_name',
									
									user_name = '$user_name',

									user_email = '$user_email',

									user_password = '$user_password_md5_old',
									
									user_photo  ='$image_name',		

									user_description ='$user_description', 
									
									user_status = '$user_status'
									
									WHERE user_id = $user_id";

		if(mysqli_query($db,$sql_user))
		{										
			if($_FILES["user_photo"]["name"]!='')
			
				{
					move_uploaded_file($_FILES['user_photo']['tmp_name'], $image_dir.$image_name);
												 
					if(is_file($image_dir.$image_old_name))
					
						unlink($image_dir.$image_old_name);
				}
			$alert_box_show="show";
			$alert_type="success";
			$alert_message="Info saved successfullu";
				
		}else{
			$alert_box_show="show";
			$alert_type="danger";
			$alert_message="Database encountered some error while updating.";
		}
	}
	else
	{
		$alert_box_show="show";
		$alert_type="danger";
		$alert_message="Please correct the errors";
		
	}
}

?>

<!-----PAGE LEVEL CSS BEGIN--->

   <link rel="stylesheet" type="text/css" href="<?php echo SITE_URL_ADMIN; ?>assets/global/plugins/bootstrap-fileinput/bootstrap-fileinput.css" />

<!-----PAGE LEVEL CSS END--->


                                        <!-- BEGIN PAGE TITLE & BREADCRUMB-->
                                        <h3 class="page-title">
                                                Profil info <!--<small>Here information about your profile can be updated</small>-->
                                        </h3>
                                        <div class="page-bar">         
                                        <ul class="page-breadcrumb">
                                                <li>
                                                        <i class="fa fa-home"></i>
                                                        <a href="<?php echo SITE_URL_ADMIN; ?>">Home</a>
                                                        <i class="fa fa-angle-right"></i>
                                                </li>
                                                <li>
                                                        <a  href="#">My profile</a>
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
                     <div class="caption"><i class="fa fa-reorder"></i> Fields marked with <strong>*</strong> can not be left empty</div>
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
                              		<label class="control-label col-md-3" for="user_first_name">First name <span class="required">*</span></label>
                              		<div class="col-md-4">
                                 		<input type="text" placeholder="" class="form-control" name="user_first_name" value="<?php echo $user_first_name;?>"/>
                                 		<span for="user_first_name" class="help-block"><?php echo $messages["user_first_name"]["msg"] ?></span>
                              		</div>
                           	  </div>
                              
                              <div class="form-group <?php echo $messages["user_last_name"]["status"] ?>">
                              		<label class="control-label col-md-3" for="user_last_name">Last name <span class="required">*</span></label>
                              		<div class="col-md-4">
                                 		<input type="text" placeholder="" class="form-control" name="user_last_name" value="<?php echo $user_last_name;?>"/>
                                 		<span for="user_last_name" class="help-block"><?php echo $messages["user_last_name"]["msg"] ?></span>
                              		</div>
                           	  </div>
                              
                              <div class="form-group <?php echo $messages["user_email"]["status"] ?>">
                              		<label class="control-label col-md-3" for="user_email">Email <span class="required">*</span></label>
                              		<div class="col-md-4">
                                 		<input type="text" placeholder="" class="form-control" name="user_email" value="<?php echo $user_email;?>"/>
                                 		<span for="user_email" class="help-block"><?php echo $messages["user_email"]["msg"] ?></span>
                              		</div>
                           	  </div>
                              
                              <!--<div class="form-group">
                              		<label class="control-label col-md-3" for="user_description">User Description</label>
                              		<div class="col-md-4">
                                 		<textarea rows="4" class="form-control" name="user_description"><?php echo $user_description; ?></textarea>
                                 		<span for="user_description" class="help-block"></span>
                              		</div>
                           	  </div>-->
                              
                              <?php if($image_name!='' && is_file("data/user/".$image_name))
							  
							  { ?>
                              
                              
                              <div class="form-group">
										<label class="control-label col-md-3">Current profile picture</label>
										<div class="col-md-9">
											<div class="fileinput fileinput-new" data-provides="fileinput">
												<div class="fileinput-new thumbnail">
													<img width="50" height="50" src="<?php echo SITE_URL.'data/user/'.$image_name; ?>" alt=""/>
												</div>
											</div>
										</div>
							</div>
                              
                              <?php } ?>
                              
                              <div class="form-group ">
										<label class="control-label col-md-3">New profile picture</label>
										<div class="col-md-9">
											<div class="fileinput fileinput-new" data-provides="fileinput">
												<div class="fileinput-preview thumbnail" data-trigger="fileinput" style="width: 200px; height: 150px;">
												</div>
												<div>
													<span class="btn default btn-file">
													<span class="fileinput-new">
													Choose picture </span>
													<span class="fileinput-exists">
													Change </span>
													<input type="file" name="user_photo">
													</span>
													<a href="#" class="btn red fileinput-exists" data-dismiss="fileinput">
													Delete </a>
												</div>
											</div>
											<div class="clearfix margin-top-10">
												<span class="label label-danger">
												Note!</span> Size 29 X 29 Pixel.
											</div>
										</div>
									</div>
                                
                               
                             <h3 class="form-section">Login Info</h3> 
                             
                              <div class="form-group <?php echo $messages["user_name"]["status"] ?>">
                              		<label class="control-label col-md-3" for="user_name">Username <span class="required">*</span></label>
                              		<div class="col-md-4">
                                 		<input type="text" placeholder="" class="form-control" name="user_name" value="<?php echo $user_name;?>"/>
                                 		<span for="user_name" class="help-block"><?php echo $messages["user_name"]["msg"] ?></span>
                              		</div>
                           	  </div>
                           	  
                           	  <div class="form-group <?php echo $messages["alt_password"]["status"] ?>">
                              		<label class="control-label col-md-3" for="alt_password">Old Password <span class="required">*</span></label>
                              		<div class="col-md-4">
                                 		<input type="password" placeholder="" class="form-control test1" name="alt_password" value="<?php echo $alt_password;?>"/>
                                 		<span for="alt_password" class="help-block"><?php echo $messages["alt_password"]["msg"] ?></span>
                                 		<span for="alt_password" class="help-block">Provide old password first to change the password<br></span>
                              		</div>
                           	  </div>
                              
                              <div class="form-group <?php echo $messages["user_password"]["status"] ?>">
                              		<label class="control-label col-md-3" for="user_password">New Password <span class="required">*</span></label>
                              		<div class="col-md-4">
                                 		<input type="password" placeholder="" class="form-control test1" name="user_password" value="<?php echo $user_password;?>"/>
                                 		<span for="user_password" class="help-block"><?php echo $messages["user_password"]["msg"] ?></span>
                              		</div>
                                    <div class="col-md-4 hide">
                                        <label><input class="form-control" id="test2" type="checkbox" />Password anzeigen</label>                                
                                    </div>
                           	  </div>
                              
                              <div class="form-group <?php echo $messages["cpassword"]["status"] ?>">
                              		<label class="control-label col-md-3" for="cpassword">Confirm new Password<span class="required">*</span></label>
                              		<div class="col-md-4">
                                 		<input type="password" placeholder="" class="form-control test1" name="cpassword" value="<?php echo $cpassword;?>"/>
                                 		<span for="cpassword" class="help-block"><?php echo $messages["cpassword"]["msg"] ?></span>
                              		</div>
                           	  </div>
                             
                            <div class="form-actions fluid">
                               <div class="col-md-offset-3 col-md-9">
                                  <button type="submit" name="Submit" class="btn green">Submit</button>
                                  <button type="reset" class="btn default">Reset</button>                              
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
       
       <script>
	   
			(function ($) {
				$.toggleShowPassword = function (options) {
					var settings = $.extend({
						field: "#password",
						control: "#toggle_show_password",
					}, options);
			
					var control = $(settings.control);
					var field = $(settings.field)
			
					control.bind('click', function () {
						if (control.is(':checked')) {
							field.attr('type', 'text');
						} else {
							field.attr('type', 'password');
						}
					})
				};
			}(jQuery));
			
			//Here how to call above plugin from everywhere in your application document body
			$.toggleShowPassword({
				field: '.test1',
				control: '#test2'
			});
		
		</script>
       
        
        <!-----PAGE LEVEL SCRIPTS END--->
 
 
        
        <!-- END JAVASCRIPTS -->
</body>
<!-- END BODY -->
</html>
