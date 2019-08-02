<?php 

function generatePassword($length) {
    $chars = 'ABCDEFGHJKMNPQRSTUVWXYZ123456789';
    $count = mb_strlen($chars);

    for ($i = 0, $result = ''; $i < $length; $i++) {
        $index = rand(0, $count - 1);
        $result .= mb_substr($chars, $index, 1);
    }

    return $result;
}


$id = isset($_REQUEST['id']) ? $_REQUEST['id']: 0;
$sql = "select * from ".$db_suffix."codes where codes_id = $id limit 1";				
$query = mysqli_query($db, $sql);

if(mysqli_num_rows($query) > 0)
{
	$content     = mysqli_fetch_object($query);
	
	$codes_title       = $content->codes_title;
	$codes_value    = $content->codes_value;
	$codes_org_name = $content->codes_org_name;
	$codes_start_date  = $content->codes_start_date;
	$codes_end_date    = $content->codes_end_date;
	$codes_quantity    = $content->codes_quantity;
	$codes_quantity_old    = $content->codes_quantity;
	$codes_status      = $content->codes_status;
	$codes_stud      = $content->codes_stud;
	$voc_set_level      = $content->codes_level;
}
	
$alert_message=""; $alert_box_show="hide"; $alert_type="success";
	
$err_easy="has-error";

$err=0;

$messages = array(
					'codes_title' => array('status' => '', 'msg' => ''),
					'codes_value' => array('status' => '', 'msg' => ''),
					'voc_set_level' => array('status' => '', 'msg' => ''),
					'codes_org_name' => array('status' => '', 'msg' => ''),
					'codes_start_date' => array('status' => '', 'msg' => ''),
					'codes_end_date' => array('status' => '', 'msg' => ''),
					'codes_quantity' => array('status' => '', 'msg' => ''),
					'codes_status' => array('status' => '', 'msg' => ''),
				);

if(isset($_POST['Submit']))
{	
	extract($_POST);
	
	if(empty($voc_set_level))
	{
		$messages["voc_set_level"]["status"]=$err_easy;
		$messages["voc_set_level"]["msg"]="Batch name / level is required";
		$err++;		
	}
	
	if(empty($codes_title))
	{
		$messages["codes_title"]["status"]=$err_easy;
		$messages["codes_title"]["msg"]="Title is Required";;
		$err++;		
	}
	
	if(!empty($codes_value))
	{
		$dd = mysqli_query($db, "select codes_id from ".$db_suffix."codes where codes_value='$codes_value' AND codes_id!='$id'");
		if(mysqli_num_rows($dd)>0){
			$messages["codes_value"]["status"]=$err_easy;
			$messages["codes_value"]["msg"]="Code already exists";;
			$err++;		
		}
	}
	
	if(empty($codes_org_name))
	{
		$messages["codes_org_name"]["status"]=$err_easy;
		$messages["codes_org_name"]["msg"]="Organisation Name is Required";;
		$err++;		
	}
	
	if(empty($codes_start_date))
	{
		$messages["codes_start_date"]["status"]=$err_easy;
		$messages["codes_start_date"]["msg"]="Start Date is Required";;
		$err++;		
	}
	
	if(empty($codes_end_date))
	{
		$messages["codes_end_date"]["status"]=$err_easy;
		$messages["codes_end_date"]["msg"]="End Date is Required";;
		$err++;		
	}
	
	if(empty($codes_quantity))
	{
		$messages["codes_quantity"]["status"]=$err_easy;
		$messages["codes_quantity"]["msg"]="Quantity is Required";;
		$err++;		
	}
	
	if($err == 0)
	{
		$sql = "UPDATE ".$db_suffix."codes SET codes_title='$codes_title', codes_value='$codes_value', codes_org_name='$codes_org_name', codes_start_date='$codes_start_date', codes_end_date='$codes_end_date', codes_quantity='$codes_quantity', codes_status='$codes_status', codes_stud='$codes_stud', codes_level='$voc_set_level' WHERE codes_id='$id'";
		
		if(mysqli_query($db,$sql))
		{		
			if($codes_quantity_old!=$codes_quantity){
				
				$codes_quantity1=$codes_quantity;
				
				mysqli_query($db, "DELETE FROM ".$db_suffix."indiv_codes where codes_id='$id'");	
				
				while($codes_quantity1>0)
				{
					while(1){
					
						$random_code=generatePassword(15);
						
						$dd = mysqli_query($db, "select ic_id from ".$db_suffix."indiv_codes where codes_value='$random_code'");
						
						if(mysqli_num_rows($dd)<=0)
							break;
						else
							continue;
					}
					
					mysqli_query($db, "INSERT INTO ".$db_suffix."indiv_codes SET codes_id='$id', codes_value='$random_code'");	
					
					$codes_quantity1--;			
				}
			}
			
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

<link rel="stylesheet" type="text/css" href="<?php echo SITE_URL_ADMIN; ?>assets/global/plugins/bootstrap-datepicker/css/datepicker3.css"/>

<!-----PAGE LEVEL CSS END--->



                                        <!-- BEGIN PAGE TITLE & BREADCRUMB-->
                                        <h3 class="page-title">
                                                Reg. Code Manager <small>Here existing codes can be updated</small>
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
                                                        <a href="<?php echo SITE_URL_ADMIN.'?mKey=regcode&pKey=regcodelist'; ?>">Reg. Codes List</a>
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
                               
                               
                              <div class="form-group <?php echo $messages["codes_title"]["status"] ?>">
                              		<label class="control-label col-md-3" for="codes_title">Title <span class="required">*</span></label>
                              		<div class="col-md-4">
                                 		<input type="text" placeholder="" class="form-control" name="codes_title" value="<?php echo $codes_title;?>"/>
                                 		<span for="codes_title" class="help-block">Provide a title for the code<br /><?php echo $messages["codes_title"]["msg"] ?></span>
                              		</div>
                           	  </div>
                              
                              <div class="form-group <?php echo $messages["codes_org_name"]["status"] ?>">
                              		<label class="control-label col-md-3" for="codes_org_name">For which organisation/school? <span class="required">*</span></label>
                              		<div class="col-md-4">
                                 		<input type="text" placeholder="" class="form-control" name="codes_org_name" value="<?php echo $codes_org_name;?>"/>
                                 		<span for="codes_org_name" class="help-block">Make sure the school name of the students and their corresponding teachers are exactly the same and also the level.<br /><?php echo $messages["codes_org_name"]["msg"] ?></span>
                              		</div>
                           	  </div>
                              
                              <div class="form-group <?php echo $messages["voc_set_level"]["status"] ?>">
                                  <label for="voc_set_level" class="control-label col-md-3">  Batch Name / Level</label>
                                  <div class="col-md-4">
                                 		<input type="text" placeholder="e.g. A1/ Gruppe 1 - A1" class="form-control" name="voc_set_level" value="<?php echo $voc_set_level;?>"/>
                                 		<span for="voc_set_level" class="help-block"><?php echo $messages["voc_set_level"]["msg"] ?></span>
                              		</div>
                              </div>
                              
                              <!--<div class="form-group <?php echo $messages["codes_value"]["status"] ?>">
                              		<label class="control-label col-md-3" for="codes_value">Code <span class="required">*</span></label>
                              		<div class="col-md-4">
                                 		<input type="text" class="form-control" name="codes_value" value="<?php echo $codes_value;?>"/>
                                 		<span for="codes_value" class="help-block">Change the code yourself [at least 15 characters long]<br /><?php echo $messages["codes_value"]["msg"] ?></span>
                              		</div>
                              </div>-->
                              
                              <div class="form-group <?php echo $messages["codes_start_date"]["status"] ?>">
                                <label class="control-label col-md-3">Start Date <span class="required">*</span></label>
                                <div class="col-md-4">
                                    <div class="input-group input-medium date date-picker" data-date-format="yyyy-mm-dd" data-date-start-date="+0d">
                                        <input name="codes_start_date" type="text" class="form-control" value="<?php echo $codes_start_date; ?>" readonly>
                                        <span class="input-group-btn">
                                        <button class="btn default" type="button"><i class="fa fa-calendar"></i></button>
                                        </span>
                                    </div>
                                    <!-- /input-group -->
                                    <span class="help-block">
                                    Date when the code is valid from<br /><?php echo $messages["codes_start_date"]["msg"] ?></span>
                                </div>
                            </div>
                            
                            <div class="form-group <?php echo $messages["codes_end_date"]["status"] ?>">
                                <label class="control-label col-md-3">End Date <span class="required">*</span></label>
                                <div class="col-md-4">
                                    <div class="input-group input-medium date date-picker" data-date-format="yyyy-mm-dd" data-date-start-date="+0d">
                                        <input name="codes_end_date" type="text" class="form-control" value="<?php echo $codes_end_date; ?>" readonly>
                                        <span class="input-group-btn">
                                        <button class="btn default" type="button"><i class="fa fa-calendar"></i></button>
                                        </span>
                                    </div>
                                    <!-- /input-group -->
                                    <span class="help-block">
                                    Date till the code is valid<br /><?php echo $messages["codes_end_date"]["msg"] ?></span>
                                </div>
                            </div>                           
                            
                              
                              <div class="form-group <?php echo $messages["codes_quantity"]["status"] ?>">
                              		<label class="control-label col-md-3" for="codes_quantity">Quantity <span class="required">*</span></label>
                              		<div class="col-md-4">
                                 		<input type="text" placeholder="" class="form-control" name="codes_quantity" value="<?php echo $codes_quantity;?>"/>
                                 		<span for="codes_quantity" class="help-block">How many codes for the students<br /><?php echo $messages["codes_quantity"]["msg"] ?></span>
                              		</div>
                           	  </div>
                              
                              <div class="form-group last">
                                  <label for="codes_status" class="control-label col-md-3">For</label>
                                  <div class="col-md-2">
                                     <select class="form-control" name="codes_stud">
                                        <option <?php if($codes_stud==1) echo 'selected="selected"'; ?> value="1">Students</option>
                                        <option <?php if($codes_stud==0) echo 'selected="selected"'; ?> value="0">Teachers</option>
                                     </select>
                                  </div>
                              </div>
                              
                              <div class="form-group last">
                                  <label for="codes_status" class="control-label col-md-3">Status</label>
                                  <div class="col-md-2">
                                     <select class="form-control" name="codes_status">
                                        <option <?php if($codes_status==1) echo 'selected="selected"'; ?> value="1">Active</option>
                                        <option <?php if($codes_status==0) echo 'selected="selected"'; ?> value="0">InActive</option>
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