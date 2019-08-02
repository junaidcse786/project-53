<?php 

$id=$_REQUEST["id"];

$alert_message=""; $alert_box_show="hide"; $alert_type="success";
	
$err_easy="has-error";

$err=0;

$messages = array(
					'voc_title' => array('status' => '', 'msg' => ''),
					'voc_status' => array('status' => '', 'msg' => ''),
					'voc_set_id' => array('status' => '', 'msg' => ''),
				);

if(isset($_POST['Submit']))
{	
	extract($_POST);
	
	if(empty($voc_title))
	{
		$messages["voc_title"]["status"]=$err_easy;
		$messages["voc_title"]["msg"]="Word is Required";;
		$err++;		
	}
	
	if(count($voc_set_id)<=0)
	{
		$messages["voc_set_id"]["status"]=$err_easy;
		$messages["voc_set_id"]["msg"]="Please select a set";;
		$err++;		
	}
	
	if($err == 0)
	{
		$today = date('y-m-d');
	
		$sql = "UPDATE ".$db_suffix."voc SET voc_title='$voc_title' where voc_id='$id'";
		
		if(mysqli_query($db,$sql))
		{		
			
			mysqli_query($db,"DELETE FROM ".$db_suffix."voc_relation where voc_id='$id'");	
			
			foreach($voc_set_id as $value)
			
				mysqli_query($db,"INSERT INTO ".$db_suffix."voc_relation VALUES ('','$value','$id')");	
			
			$sql_parent_menu = "SELECT * FROM ".$db_suffix."lang";	
			$parent_query = mysqli_query($db, $sql_parent_menu);
			while($row = mysqli_fetch_object($parent_query))
			
				if($_POST[strtolower($row->lang_title)]!='')
				{			
					if(mysqli_num_rows(mysqli_query($db,"SELECT content FROM ".$db_suffix.strtolower($row->lang_title)." WHERE content='voc-".$id."'"))>0)
					
						mysqli_query($db,"UPDATE ".$db_suffix.strtolower($row->lang_title)." SET value='".$_POST[strtolower($row->lang_title)]."' where content='voc-".$id."'");	
						
					else
					
						mysqli_query($db,"INSERT INTO ".$db_suffix.strtolower($row->lang_title)." VALUES ('','voc-".$id."','".$_POST[strtolower($row->lang_title)]."')");	
				}
				else
				{
					if(mysqli_num_rows(mysqli_query($db,"SELECT content FROM ".$db_suffix.strtolower($row->lang_title)." WHERE content='voc-".$id."'"))>0)
					
						mysqli_query($db,"DELETE FROM ".$db_suffix.strtolower($row->lang_title)." WHERE content='voc-".$id."'");			
				}	
			
			
			$alert_message="Data updated successfully";		
			$alert_box_show="show";
			$alert_type="success";
			
			$voc_title = "";
			$voc_status = 1;
			$voc_set_id=array();		
			
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


$sql = "select voc_title from ".$db_suffix."voc where voc_id = $id limit 1";				
$query = mysqli_query($db, $sql);

if(mysqli_num_rows($query) > 0)
{
	$content     = mysqli_fetch_object($query);
	$voc_title       = $content->voc_title;
}

$voc_set_id=array(); $i=0;

$sql = "select voc_set_id from ".$db_suffix."voc_relation where voc_id = $id";				
$query = mysqli_query($db, $sql);

while($row=mysqli_fetch_object($query))
{
	$voc_set_id[$i] = $row->voc_set_id;
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


<link rel="stylesheet" type="text/css" href="<?php echo SITE_URL_ADMIN; ?>assets/global/plugins/select2/select2.css" />


<!-----PAGE LEVEL CSS END--->



                                        <!-- BEGIN PAGE TITLE & BREADCRUMB-->
                                        <h3 class="page-title">
                                                Update Vocabulary <small>Here existing Vocabularies can be updated</small>
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
                                                        <a href="<?php echo SITE_URL_ADMIN.'?mKey='.$mKey.'&pKey=voclist1';?>"><?php echo $menus["$mKey"]["voclist1"]; ?></a>
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
                               
                               <div class="form-group <?php echo $messages["voc_set_id"]["status"] ?>">
                                 <label for="voc_set_id" class="control-label col-md-3">Vocabulary Set <span class="required">*</span></label>
                                 <div class="col-md-4">
                                    <select class="form-control select2me"  data-placeholder="Choose  vocabulary sets" tabindex="0" multiple="multiple" name="voc_set_id[]">
                                       
									   <?php
									   $sql_parent_menu = "SELECT voc_set_id, voc_set_title FROM ".$db_suffix."voc_set";	
										$parent_query = mysqli_query($db, $sql_parent_menu);
										while($parent_obj = mysqli_fetch_object($parent_query))
										{	
											if(in_array($parent_obj->voc_set_id, $voc_set_id))
																						
												echo '<option selected="selected" value="'.$parent_obj->voc_set_id.'">'.$parent_obj->voc_set_title.'</option>';
											
											else
												
												echo '<option value="'.$parent_obj->voc_set_id.'">'.$parent_obj->voc_set_title.'</option>';
									
										}
                                        ?>
                                       
                                    </select>
                                    <span for="voc_set_id" class="help-block">Multiple Sets can be chosen</span><span for="voc_set_id" class="help-block"><?php echo $messages["voc_set_id"]["msg"] ?></span>
                                 </div>
                              </div>
                               
                               
                               <div class="form-group <?php echo $messages["voc_title"]["status"] ?>">
                              		<label class="control-label col-md-3" for="voc_title">Vocabulary Word <span class="required">*</span></label>
                              		<div class="col-md-4">
                                 		<textarea class="form-control" rows="3" name="voc_title"><?php echo $voc_title;?></textarea>
                                 		<span for="voc_title" class="help-block"><?php echo $messages["voc_title"]["msg"] ?></span>
                              		</div>
                           	  </div>
                              
                              <?php 
							  
							  
							  	$language = "SELECT * FROM ".$db_suffix."lang";	
								$language_query = mysqli_query($db, $language);
								while($row = mysqli_fetch_object($language_query))
								{
									
									$content_value='';
									$language1 = "SELECT value FROM ".$db_suffix.strtolower($row->lang_title)." where content='voc-".$id."' LIMIT 1";	
									$language_query1 = mysqli_query($db, $language1);
									if(mysqli_num_rows($language_query1) > 0)
									{
										$content     = mysqli_fetch_object($language_query1);
										$content_value       = $content->value;
									}
							  
							  echo '<div class="form-group">
                              		<label class="control-label col-md-3">Translation in '.$row->lang_title.'</label>
                              		<div class="col-md-9">
									<textarea class="ckeditor form-control" name="'.strtolower($row->lang_title).'" rows="6">'.$content_value.'</textarea>
									</div>
								  </div>';
							  
							  
								}
								
							  ?>
                              
                              
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
       
       <script type="text/javascript" src="<?php echo SITE_URL_ADMIN; ?>assets/global/plugins/select2/select2.min.js"></script>
       
       <script type="text/javascript" src="<?php echo SITE_URL_ADMIN; ?>assets/global/plugins/ckeditor/ckeditor.js"></script>
       
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