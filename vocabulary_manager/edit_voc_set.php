<?php 

$id = isset($_REQUEST['id']) ? $_REQUEST['id']: 0;
$sql = "select * from ".$db_suffix."voc_set where voc_set_id = $id limit 1";				
$query = mysqli_query($db, $sql);

if(mysqli_num_rows($query) > 0)
{
	$content     = mysqli_fetch_object($query);
	$voc_set_title       = $content->voc_set_title;
	$voc_set_desc   = $content->voc_set_desc;
	$voc_set_level   = $content->voc_set_level;
	$voc_set_status   = $content->voc_set_status;	
} 

	
$alert_message=""; $alert_box_show="hide"; $alert_type="success";
	
$err_easy="has-error";

$err=0;

$messages = array(
					'voc_set_title' => array('status' => '', 'msg' => ''),
					'voc_set_status' => array('status' => '', 'msg' => ''),
				);

if(isset($_POST['Submit']))
{	
	extract($_POST);
	
	if(empty($voc_set_title))
	{
		$messages["voc_set_title"]["status"]=$err_easy;
		$messages["voc_set_title"]["msg"]="Title is Required";;
		$err++;		
	}
	else
	{
		
	}
	
	if($err == 0)
	{
		$today = date('y-m-d');
		
		$sql = "UPDATE ".$db_suffix."voc_set SET voc_set_title = '$voc_set_title', voc_set_desc = '$voc_set_desc', voc_set_level='$voc_set_level', voc_set_status = '$voc_set_status' WHERE voc_set_id = ".$id;
	
		if(mysqli_query($db,$sql))
		{		
			$alert_message="Data updated successfully";		
			$alert_box_show="show";
			$alert_type="success";
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


<!-----PAGE LEVEL CSS END--->



                                        <!-- BEGIN PAGE TITLE & BREADCRUMB-->
                                        <h3 class="page-title">
                                                Vocabulary Set Manager <small>Here existing Vocabulary sets or groups can be updated</small>
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
                                                        <a href="<?php echo SITE_URL_ADMIN.'?mKey=voc&pKey=vocsetlist'; ?>">Vocabulary Set List</a>
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
                  </div>
                  <div class="portlet-body form">
                  
                      <div class="form-body">
                      
                          <div class="alert alert-<?php echo $alert_type; ?> <?php echo $alert_box_show; ?>">
                            <button type="button" class="close" data-dismiss="alert" aria-hidden="true"></button>
                            <?php echo $alert_message; ?>
                          </div>
                          
                               <form action="<?php echo str_replace('&s_factor=1', '', $_SERVER['REQUEST_URI']);?>" class="form-horizontal" method="post" enctype="multipart/form-data">
                               
                               
                               <div class="form-group <?php echo $messages["voc_set_title"]["status"] ?>">
                              		<label class="control-label col-md-3" for="voc_set_title">Set Title <span class="required">*</span></label>
                              		<div class="col-md-4">
                                 		<input type="text" placeholder="" class="form-control" name="voc_set_title" value="<?php echo $voc_set_title;?>"/>
                                 		<span for="voc_set_title" class="help-block"><?php echo $messages["voc_set_title"]["msg"] ?></span>
                              		</div>
                           	  </div>
                              
                              <div class="form-group">
										<label class="control-label col-md-3">Description</label>
										<div class="col-md-4">
											<textarea class="form-control" name="voc_set_desc" rows="3"><?php echo str_replace('\\','',$voc_set_desc); ?></textarea>
										</div>
							  </div>
                              
                              <div class="form-group">
                                  <label for="voc_set_level" class="control-label col-md-3">Language Level</label>
                                  <div class="col-md-2">
                                     <select class="form-control" name="voc_set_level">
                                     <option <?php if($voc_set_level=='') echo 'selected="selected"'; ?> value="">None</option>
                                        <option <?php if($voc_set_level=='A1') echo 'selected="selected"'; ?> value="A1">A1</option>
                                        <option <?php if($voc_set_level=='A2') echo 'selected="selected"'; ?> value="A2">A2</option>
                                        <option <?php if($voc_set_level=='B1') echo 'selected="selected"'; ?> value="B1">B1</option>
                                        <option <?php if($voc_set_level=='B2') echo 'selected="selected"'; ?> value="B2">B2</option>
                                        <option <?php if($voc_set_level=='C1') echo 'selected="selected"'; ?> value="C1">C1</option>
                                        <option <?php if($voc_set_level=='C2') echo 'selected="selected"'; ?> value="C2">C2</option>
                                        
                                        
                                     </select>
                                  </div>
                              </div>
							 
                             
                             <div class="form-group last">
                                  <label for="published" class="control-label col-md-3">Status</label>
                                  <div class="col-md-2">
                                     <select class="form-control" name="voc_set_status">
                                        <option <?php if($voc_set_status==1) echo 'selected="selected"'; ?> value="1">Active</option>
                                        <option <?php if($voc_set_status==0) echo 'selected="selected"'; ?> value="0">InActive</option>
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