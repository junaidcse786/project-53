<?php 
	
$alert_message=""; $alert_box_show="hide"; $alert_type="success";
	
$err_easy="has-error";

$title = "";
$subtitle = "";
$content_topic = "";
$description = "";
$meta_title = "";
$meta_key = "";
$meta_desc = "";
$order = "";
$parent = "";
$published = 1;
$grammar = 1;

$err=0;

$messages = array(
					'title' => array('status' => '', 'msg' => ''),
					'subtitle' => array('status' => '', 'msg' => ''),
					'content_topic' => array('status' => '', 'msg' => ''),
					'description' => array('status' => '', 'msg' => ''),
					'meta_title' => array('status' => '', 'msg' => ''),
					'meta_key' => array('status' => '', 'msg' => ''),
					'meta_desc' => array('status' => '', 'msg' => ''),
					'parent' => array('status' => '', 'msg' => ''),
					'subparent' => array('status' => '', 'msg' => ''),				  				 
					'published' => array('status' => '', 'msg' => ''),
					'order' => array('status' => '', 'msg' => '')
				);

if(isset($_POST['Submit']))
{	
	extract($_POST);
	
	if(empty($title))
	{
		$messages["title"]["status"]=$err_easy;
		$messages["title"]["msg"]="Title is Required";;
		$err++;		
	}
	
	if(empty($description))
	{
		$messages["description"]["status"]=$err_easy;
		$messages["description"]["msg"]="Description is Required";;
		$err++;		
	}
	
	if(!empty($order) && !is_numeric($order))
	{
		$messages["order"]["status"]=$err_easy;
		$messages["order"]["msg"]="Only Numeric values are allowed";;
		$err++;		
	}
	
	if($grammar=='1' && $content_topic=='')
	{
		$messages["content_topic"]["status"]=$err_easy;
		$messages["content_topic"]["msg"]="Grammar Topic is required";;
		$err++;		
	}
	
	
	if($err == 0)
	{
		$today = date('y-m-d');
	
		$sql = "INSERT INTO ".$db_suffix."content VALUES ('','$title','$subtitle','$description','$meta_title','$meta_key','$meta_desc','$grammar','$published','$parent','$order','$today', '$content_topic')";
		if(mysqli_query($db,$sql))
		{		
			$alert_message="Data inserted successfully";		
			$alert_box_show="show";
			$alert_type="success";
			
			$title = "";
			$subtitle = "";
			$description = "";
			$meta_title = "";
			$meta_key = "";
			$meta_desc = "";
			$order = "";
			$parent = "";
			$published = 1;	
			$content_topic = "";	
			
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
                                                <?php echo $menus["$mKey"]["$pKey"]; ?> <small>Here New contents can be created</small>
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
                          
                          <h3 class="form-section">SEO Info</h3>
                               
                               <form action="<?php echo str_replace('&s_factor=1', '', $_SERVER['REQUEST_URI']);?>" class="form-horizontal" method="post" enctype="multipart/form-data">
                               
                               
                                <div class="form-group">
                              		<label class="control-label col-md-3">Meta title</label>
                              		<div class="col-md-4">
                                 		<input type="text" placeholder="Used for SEO" class="form-control" name="meta_title" value="<?php echo $meta_title;?>"/>                                        
                                 	</div>
                           	  </div>
                              
                              <div class="form-group">
                              		<label class="control-label col-md-3">Meta Keywords</label>
                              		<div class="col-md-4">
                                 		<input type="text" placeholder="Used for SEO" class="form-control" name="meta_key" value="<?php echo $meta_key;?>"/>                                        
                                 	</div>
                           	  </div>
                              
                              <div class="form-group">
                              		<label class="control-label col-md-3">Meta Description</label>
                              		<div class="col-md-4">
                                 		<input type="text" placeholder="Used for SEO" class="form-control" name="meta_desc" value="<?php echo $meta_desc;?>"/>
                                    </div>
                           	  </div>
                               
                             <h3 class="form-section">Content Info</h3> 
                             
                             
                             
                              <div class="form-group">
                                 <label for="parent" class="control-label col-md-3">Parent Content</label>
                                 <div class="col-md-4">
                                    <select class="form-control select2me"  data-placeholder="Choose a Category" tabindex="0" name="parent">
                                       <option value="0">Select One</option>
                                                                              
                                       <?php
									   $sql_parent_menu = "SELECT content_id, content_title FROM ".$db_suffix."content where content_published='1'";	
										$parent_query = mysqli_query($db, $sql_parent_menu);
										while($parent_obj = mysqli_fetch_object($parent_query))
										{	
											if($parent_obj->content_id == $parent)
											
												echo '<option selected="selected" value="'.$parent_obj->content_id.'">'.$parent_obj->content_title.'</option>';
											
											else
												
												echo '<option value="'.$parent_obj->content_id.'">'.$parent_obj->content_title.'</option>';
									
										}
                                        ?>
                                       
                                       
                                    </select>
                                 </div>
                              </div>                                      
                             
                                                         
                               <div class="form-group <?php echo $messages["title"]["status"] ?>">
                              		<label class="control-label col-md-3" for="title">Content Title <span class="required">*</span></label>
                              		<div class="col-md-4">
                                 		<input type="text" placeholder="" class="form-control" name="title" value="<?php echo $title;?>"/>
                                 		<span for="title" class="help-block"><?php echo $messages["title"]["msg"] ?></span>
                              		</div>
                           	  </div>
                              
                              <div class="form-group">
                              		<label class="control-label col-md-3" for="subtitle">Content Subtitle</label>
                              		<div class="col-md-4">
                                 		<input type="text" placeholder="" class="form-control" name="subtitle" value="<?php echo $subtitle;?>"/>
                                 		<span for="subtitle" class="help-block"><?php echo $messages["subtitle"]["msg"] ?></span>
                              		</div>
                           	  </div>
                              
                              <div class="form-group <?php echo $messages["order"]["status"] ?>">
                              		<label class="control-label col-md-3" for="order">Order</label>
                              		<div class="col-md-4">
                                 		<input type="text" placeholder="" class="form-control" name="order" value="<?php echo $order;?>"/>
                                 		<span for="subtitle" class="help-block"><?php echo $messages["order"]["msg"] ?></span>
                              		</div>
                           	  </div>
                              
                              <div class="form-body <?php echo $messages["description"]["status"] ?>">
									<div class="form-group">
										<label class="control-label col-md-3">Description</label>
										<div class="col-md-9">
											<textarea class="ckeditor form-control" name="description" rows="6"><?php echo str_replace('\\','',$description); ?></textarea>
                                            <span for="description" class="help-block"><?php echo $messages["description"]["msg"] ?></span>
										</div>
									</div>
							 </div>
                             
                             <div id="content_topic" class="form-group  <?php echo $messages["content_topic"]["status"] ?>">
                                  <label for="content_topic" class="control-label col-md-3">Topic of this grammar content <span class="required">*</span></label>
                                  <div class="col-md-4">
                                  	
                                    <input type="text" placeholder="" class="form-control" name="content_topic" value="<?php echo $content_topic;?>"/> 
                                    
                                    <span for="content_topic" class="help-block"><?php echo $messages["content_topic"]["msg"] ?></span>
                                  
                                  <?php  
							  
							$sql_parent_menu = "SELECT DISTINCT content_topic FROM ".$db_suffix."content where content_topic!=''";	
							$parent_query = mysqli_query($db, $sql_parent_menu);
							
							if(mysqli_num_rows($parent_query)>0)
							
							{								
							  
							  ?>
                              <br />
                                  
                                     <select id="exercise_type1" class="form-control input-medium select2me" name="exercise_type1">
                                     <option></option>
									 
									 <?php 
									 
									 while($parent_obj = mysqli_fetch_object($parent_query))
										
										echo '<option value="'.$parent_obj->content_topic.'">'.$parent_obj->content_topic.'</option>';
									
										
                                      ?>
                                        
                                     </select>
                                     <span for="exercise_topic" class="help-block">Choose from existing topic</span>
                                     
                                <?php } ?>     
                                  </div>
                              </div>
                             
                             <div class="form-group">
                                  <label for="grammar" class="control-label col-md-3">Grammar Page</label>
                                  <div class="col-md-2">
                                     <select class="form-control" name="grammar">
                                        <option <?php if($grammar==1) echo 'selected="selected"'; ?> value="1">Yes</option>
                                        <option <?php if($grammar==0) echo 'selected="selected"'; ?> value="0">No</option>
                                     </select>
                                  </div>
                              </div>
                         	
                              <div class="form-group last">
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
       
       <script type="text/javascript" src="<?php echo SITE_URL_ADMIN; ?>assets/global/plugins/select2/select2.min.js"></script>
       
       <script type="text/javascript" src="<?php echo SITE_URL_ADMIN; ?>assets/global/plugins/ckeditor/ckeditor.js"></script>
       
       <script>
	   
	    $( "#exercise_type1" ).change(function() {
            $('input[name="content_topic"]').val($(this).val());
        });
		
		$( 'select[name="grammar"]' ).change(function() {
           
		   if($(this).val()=='1')
		   
		   		$( '#content_topic' ).show();
				
			else
			
				$( '#content_topic' ).hide();	
		   	
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