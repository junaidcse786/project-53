<?php 

$mRole = isset($_REQUEST["mRole"])?$_REQUEST["mRole"]:"";

$config_role_sql = "SELECT role_id, role_title FROM ".$db_suffix."role WHERE role_id != 8"; 

$config_role_query = mysqli_query($db,$config_role_sql);

$config_role_pages = array();

$config_role_menu = array();

$parent_editmember = '';

while($config_role_row = mysqli_fetch_object($config_role_query))

{

	$parent_editmember .= '"editmember"=>"memberlist-'.$config_role_row->role_id.'",';	

	$config_role_pages["memberlist-".$config_role_row->role_id] = "member_manager/member.php";

	$config_role_menu["memberlist-".$config_role_row->role_id] =  $config_role_row->role_title." List";

}

$config_role_pages["addmember"] = "member_manager/add_member.php";

$config_role_pages["editmember"] = "member_manager/edit_member.php";


$dashboard_pages = array(

		"8" => "dashboard_manager/dashboard_super_admin.php", 
		
		"15" => "dashboard_manager/dashboard_teacher.php",
		
		);


$pages = array(

		//common pages START		
		"myaccount"  => "setup_manager/my_account.php",
						
		"inbox"  => "message_manager/inbox.php",
		
		"drafts"  => "message_manager/drafts.php",
			
		"sent"  => "message_manager/sent.php",

		"viewmessage"  => "message_manager/view_message.php",

		"sendmessage"  => "message_manager/send_message.php",
		//common pages END
		
		"myfiles" => array(

			"files" 	=> "setup_manager/myfiles.php",	
		),

		"gallery"     => array

						(
							"gallerylist"  => "gallery_manager/gallery.php",

							"addgallery"  => "gallery_manager/add_gallery.php",

							"editgallery"  => "gallery_manager/edit_gallery.php"

						),
						
						
		"regcode"     => array

						(
							"regcodelist"  => "reg_code_manager/regcode.php",
							
							"addregcode"  => "reg_code_manager/add_regcode.php",

							"editregcode"  => "reg_code_manager/edit_regcode.php"

						),	
						
		
		"member"        => $config_role_pages,

		

		"setup"        => array

		                (

						"logo" 	=> "content_manager/logo.php",
						
						"addconfig"  => "setup_manager/addconfiguration.php",

                        "configuration"  => "setup_manager/configurationlist.php",

                        "updateconfig"  => "setup_manager/editconfig.php",

						"addmodule"  => "setup_manager/add_module.php",

                        "module"  => "setup_manager/module_list.php",

                        "updatemodule"  => "setup_manager/edit_module.php",

						"addrollmodule"  => "setup_manager/add_role_module.php",

                        "rollmodule"  => "setup_manager/role_module_list.php",

                        "updaterolemodule"  => "setup_manager/edit_role_module.php",
						
						),
		);

	

		

$menus = array(

		"member"        =>$config_role_menu,

		"gallery" 	  => array

						(
							"gallerylist"  => "Files List",

							"addgallery" =>  "Upload File"
		                ),	
						
		"regcode" 	  => array

						(
							"regcodelist"  => "Task list",

							"addregcode" =>  "Create new task"
		                ),
							
		"setup" 	  => array    

						(
						   "logo" => "Logo Manager",  

						   "configuration"  => "Configuration",

						   "module"=>"Module" ,

						   "rollmodule" =>"User Roles",

						   "addrollmodule" =>"Add User Role"  

						)	

		);

?>