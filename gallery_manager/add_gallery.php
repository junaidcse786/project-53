<?php 
	
$alert_message=""; $alert_box_show="hide"; $alert_type="success";
	
$err_easy="has-error";

$gallery_title = "";

$user_id = $_GET["user_id"];

$sql = "select * from ".$db_suffix."user where user_id = '$user_id' limit 1";				
$query = mysqli_query($db, $sql);

if(mysqli_num_rows($query) > 0){
        $usr = mysqli_fetch_object($query);
        $user_folder = $usr->user_first_name.'-'.$usr->user_last_name.'-'.$usr->user_id;
        $user_full_name = $usr->user_first_name.'-'.$usr->user_last_name;

        if (!file_exists("data/FILES/".$user_folder))
                mkdir("data/FILES/".$user_folder, 0755);
}

$err=0;

$messages = array(
					'gallery_title' => array('status' => '', 'msg' => ''),
					'gallery_file' => array('status' => '', 'msg' => ''),
				);

if(isset($_POST['Submit']))
{	
	//$gallery_title = isset($_POST['gallery_title']) ? $_POST['gallery_title'] : '';
	
//	if(empty($gallery_title))
//	{
//		$messages["gallery_title"]["status"]=$err_easy;
//		$messages["gallery_title"]["msg"]="Title is Required";;
//		$err++;		
//	}
    
    
	if(count($_FILES["gallery_file"]["tmp_name"])<1)
	{
		$messages["gallery_file"]["status"]=$err_easy;
		$messages["gallery_file"]["msg"]="File is Required";
		$err++;		
	}
        
        if($err == 0)
	{
		$image_dir = "data/FILES/".$user_folder."/";
                
                for($i=0; $i<count($_FILES['gallery_file']['name']); $i++) {
                
		if($_FILES['gallery_file']['name'][$i] != '')
			{
				$type=$_FILES['gallery_file']['type'][$i];
				$size=$_FILES['gallery_file']['size'][$i];
				$image_name=date('ymdgis').$_FILES['gallery_file']['name'][$i];
			}
                $sql = "INSERT INTO ".$db_suffix."gallery SET gallery_title='$image_name', gallery_file='$image_name', gallery_type='$type', gallery_size='$size', user_id='".$user_id."'";
		mysqli_query($db,$sql);
                
                move_uploaded_file($_FILES['gallery_file']['tmp_name'][$i], $image_dir.$image_name);
                
                }
                
		if(1)
		{		
			$alert_message="Data inserted successfully";		
			$alert_box_show="show";
			$alert_type="success";
			
			$gallery_title = "";
			
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

<!-----PAGE LEVEL CSS END--->



                                        <!-- BEGIN PAGE TITLE & BREADCRUMB-->
                                        <h3 class="page-title">
                                                <?php echo $menus["$mKey"]["$pKey"]; ?> <small>Here New files can be uploaded e.g. images/videos</small>
                                        </h3>
                                        <div class="page-bar">         
                                        <ul class="page-breadcrumb">
                                                <li>
                                                        <i class="fa fa-home"></i>
                                                        <a href="<?php echo SITE_URL_ADMIN; ?>">Home</a>
                                                        <i class="fa fa-angle-right"></i>
                                                </li>
                                                <li>
                                                        <i class="fa fa-table"></i>
                                                        <a href="<?php echo SITE_URL_ADMIN.'?mKey=gallery&pKey=gallerylist&user_id='.$user_id; ?>">File manager <b>(<?php echo $user_full_name ?>)</b></a>
                                                        <i class="fa fa-angle-right"></i>
                                                </li>
                                                <li>
                                                        <a href="<?php echo SITE_URL_ADMIN.'?mKey=gallery&pKey=addgallery&user_id='.$user_id; ?>">Upload file</a>
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
                               
                               
                                                         
                              <div class="form-group <?php echo $messages["gallery_title"]["status"] ?> hide">
                              		<label class="control-label col-md-3" for="gallery_title">File Title <span class="required">*</span></label>
                              		<div class="col-md-4">
                                 		<input type="text" placeholder="" class="form-control" name="gallery_title" value="<?php echo $gallery_title;?>"/>
                                 		<span for="gallery_title" class="help-block"><?php echo $messages["gallery_title"]["msg"] ?></span>
                              		</div>
                           	  </div>
                              
                              <div class="form-group <?php echo $messages["gallery_file"]["status"] ?>">
										<label class="control-label col-md-3">File Upload <span class="required">*</span></label>
										<div class="col-md-9">
											<div class="fileinput fileinput-new" data-provides="fileinput">
												<div class="fileinput-preview thumbnail" data-trigger="fileinput" style="width: 200px; height: 150px;">
												</div>
												<div>
													<span class="btn default btn-file">
													<span class="fileinput-new">
													Select file </span>
													<span class="fileinput-exists">
													Change </span>
                                                                                                            <input type="file" name="gallery_file[]" multiple="multiple">
                                                    </span>
													<a href="#" class="btn red fileinput-exists" data-dismiss="fileinput">
													Remove </a>
												</div>
                                                <span for="gallery_file" class="help-block"><?php echo $messages["gallery_file"]["msg"] ?></span>
											</div>
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
       
        <!-----PAGE LEVEL SCRIPTS END--->
 
 
        
        <!-- END JAVASCRIPTS -->
</body>
<!-- END BODY -->
</html>

<?php 
if($alert_type=='success' && isset($_POST["Submit"]))
{
	//usleep(3000000);
	// echo '<script>window.location="'.$_SERVER['REQUEST_URI'].'&s_factor=1";</script>';
}
?>