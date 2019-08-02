<?php 
	
$alert_message=""; $alert_box_show="hide"; $alert_type="success";
	
$err_easy="has-error";

$title = "";
$published = 1;

$err=0;

$messages = array(
					'title' => array('status' => '', 'msg' => ''),
				);

if(isset($_POST['Submit']))
{	
	$title = isset($_POST['title']) ? $_POST['title'] : '';
	$published = isset($_POST['published']) ? $_POST['published'] : '';
	
	if(empty($title))
	{
		$messages["title"]["status"]=$err_easy;
		$messages["title"]["msg"]="Title is Required";;
		$err++;		
	}
	
	if($err == 0)
	{
		$today = date('y-m-d');
	
		$sql = "INSERT INTO ".$db_suffix."lang VALUES ('','$title','$published')";
		if(mysqli_query($db,$sql))
		{		
			$alert_message="Data inserted successfully";		
			$alert_box_show="show";
			$alert_type="success";
			
			$sql = "CREATE TABLE ".$db_suffix.strtolower($title)."( ".
				   "id INT(255) NOT NULL AUTO_INCREMENT, ".
				   "content LONGTEXT NOT NULL, ".
				   "value LONGTEXT NOT NULL, ".
				   "PRIMARY KEY ( id )); ";
			mysqli_query($db,$sql);	   
			
			$title = "";
			$published = 1;	

			
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

<!-----PAGE LEVEL CSS END--->



                                        <!-- BEGIN PAGE TITLE & BREADCRUMB-->
                                        <h3 class="page-title">
                                                Add Vocabulary Language <small>Here New Languages for vocabulary can be created</small>
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
                                                        <a href="<?php echo SITE_URL_ADMIN.'?mKey='.$mKey.'&pKey='.$pKey; ?>">Add Language</a>
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
                          
                               <form action="<?php echo str_replace('&s_factor=1', '', $_SERVER['REQUEST_URI']);?>" class="form-horizontal" method="post" enctype="multipart/form-data" onsubmit="return postForm()">
                          
                               <div class="form-group <?php echo $messages["title"]["status"] ?>">
                              		<label class="control-label col-md-3" for="title">Language Title <span class="required">*</span></label>
                              		<div class="col-md-4">
                                 		<input type="text" placeholder="" class="form-control" name="title" value="<?php echo $title;?>"/>
                                 		<span for="title" class="help-block"><?php echo $messages["title"]["msg"] ?></span>
                              		</div>
                           	  </div>
                              
                              <div class="form-group">
                                  <label for="published" class="control-label col-md-3">Status</label>
                                  <div class="col-md-2">
                                     <select class="form-control" name="published">
                                        <option <?php if($published==1) echo 'selected="selected"'; ?> value="1">Active</option>
                                        <option <?php if($published==0) echo 'selected="selected"'; ?> value="0">InActive</option>
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