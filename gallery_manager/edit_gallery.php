<?php 

$id = isset($_REQUEST['id']) ? $_REQUEST['id']: 0;
$sql = "select * from ".$db_suffix."gallery where gallery_id = $id limit 1";				
$query = mysqli_query($db, $sql);

if(mysqli_num_rows($query) > 0)
{
	$content     = mysqli_fetch_object($query);
	$gallery_title = $content->gallery_title;
	$old_file_name = $content->gallery_file;
	$image_name    = $content->gallery_file;
	$size = $content->gallery_size;
	$type = $content->gallery_type;
	$user_id = $content->user_id;
}

$sql = "select * from ".$db_suffix."user where user_id = '$user_id' limit 1";				
$query = mysqli_query($db, $sql);

if(mysqli_num_rows($query) > 0){
        $usr = mysqli_fetch_object($query);
		$user_folder = $usr->user_first_name.'-'.$usr->user_last_name.'-'.$usr->user_id;
		$user_full_name = $usr->user_first_name.'-'.$usr->user_last_name;

        if (!file_exists("data/FILES/".$user_folder))
                mkdir("data/FILES/".$user_folder, 0700);
}

	
$alert_message=""; $alert_box_show="hide"; $alert_type="success";
	
$err_easy="has-error";

$err=0;

$messages = array(
					'gallery_title' => array('status' => '', 'msg' => ''),
					'gallery_file' => array('status' => '', 'msg' => ''),
				);

if(isset($_POST['Submit']))
{	
	$gallery_title = isset($_POST['gallery_title']) ? $_POST['gallery_title'] : '';
	
	if(empty($gallery_title))
	{
		$messages["gallery_title"]["status"]=$err_easy;
		$messages["gallery_title"]["msg"]="Title is Required";;
		$err++;		
	}
//	if(empty($_FILES["gallery_file"]["name"]))
//	{
//		$messages["gallery_file"]["status"]=$err_easy;
//		$messages["gallery_file"]["msg"]="File is Required";;
//		$err++;		
//	}
	
	if($err == 0)
	{
		$image_dir = "data/FILES/".$user_folder."/";

		if($_FILES['gallery_file']['name'] != '')
			{
				$type=$_FILES['gallery_file']['type'];
				$size=$_FILES['gallery_file']['size'];
				$image_name=date('ymdgis').$_FILES['gallery_file']['name'];
			}
		
		$sql = "UPDATE ".$db_suffix."gallery SET gallery_title='$gallery_title', gallery_file='$image_name', gallery_type='$type', gallery_size='$size' where gallery_id='$id'";
		
		if(mysqli_query($db,$sql))
		{		
			if($_FILES['gallery_file']['name'] != '')
			{	
				if(is_file($image_dir.$old_file_name))
						unlink($image_dir.$old_file_name);
						
				move_uploaded_file($_FILES['gallery_file']['tmp_name'], $image_dir.$image_name);
			}
			$alert_message="Data updated successfully";		
			$alert_box_show="show";
			$alert_type="success";
			
			//$gallery_title = "";
			
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
	$alert_message="Data updated successfully";		
	$alert_box_show="show";
	$alert_type="success";
}
?>

<!-----PAGE LEVEL CSS BEGIN--->

<link rel="stylesheet" type="text/css" href="<?php echo SITE_URL_ADMIN; ?>assets/global/plugins/bootstrap-fileinput/bootstrap-fileinput.css" />

<!-----PAGE LEVEL CSS END--->



                                        <!-- BEGIN PAGE TITLE & BREADCRUMB-->
                                        <h3 class="page-title">
                                                Update Files <small>Here already uploaded files can be altered or updated</small>
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
                               
                               
                                                         
                               <div class="form-group <?php echo $messages["gallery_title"]["status"] ?>">
                              		<label class="control-label col-md-3" for="gallery_title">File Title <span class="required">*</span></label>
                              		<div class="col-md-4">
                                 		<input type="text" placeholder="" class="form-control" name="gallery_title" value="<?php echo $gallery_title;?>"/>
                                 		<span for="gallery_title" class="help-block"><?php echo $messages["gallery_title"]["msg"] ?></span>
                              		</div>
                           	  </div>
                              
                              <div class="form-group">
                                    <label class="col-md-3 control-label">Permalink</label>
                                    <div class="col-md-4">
                                        <span class="form-control-static"><a target="_blank" href="<?php echo SITE_URL.'data/FILES/'.$user_folder.'/'.$image_name; ?>"><?php echo SITE_URL.'data/FILES/'.$user_folder.'/'.$image_name; ?></a></span>
                                    </div>
                              </div>
                              
                              <div class="form-group">
                                    <label class="col-md-3 control-label">Size</label>
                                    <div class="col-md-4">
                                        <span class="form-control-static"><?php echo sprintf ("%.2f", $size/1024/1024).' MegaBytes'; ?></span>
                                    </div>
                              </div>
                              
                              <?php if(strpos($type,'image')!== false) { ?>
                              
                              <div class="form-group">
										<label class="control-label col-md-3">File Preview</label>
										<div class="col-md-9">
											<div class="fileinput fileinput-new" data-provides="fileinput">
												<div class="fileinput-new thumbnail" style="width: 200px; ">
													<a target="_blank" href="<?php echo SITE_URL.'data/FILES/'.$user_folder.'/'.$image_name; ?>"><img src="<?php echo SITE_URL.'data/FILES/'.$user_folder.'/'.$image_name; ?>" alt=""/></a>
												</div>
											</div>
										</div>
							</div>
                            
                            <?php } ?>
                              
                              <div class="form-group <?php echo $messages["gallery_file"]["status"] ?>">
										<label class="control-label col-md-3">Change File</label>
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
													<input type="file" name="gallery_file">
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
	echo '<script>window.location="'.$_SERVER['REQUEST_URI'].'&s_factor=1";</script>';
}
?>