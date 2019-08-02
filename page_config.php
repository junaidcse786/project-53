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
		

		"general" => array(

						"language" 	=> "content_manager/language.php",
						
						"editlanguage" 	=> "content_manager/edit_language.php",
						
						"addlanguage" 	=> "content_manager/add_language.php",
					),
										
		"teachers" => array(

						"performance" 	=> "teacher_things/performance.php",
						
						"questions" 	=> "teacher_things/questions.php",
						
						"users" 	=> "teacher_things/users.php",	
						
						"charts" 	=> "teacher_things/chart.php",
						
						"pack_users" 	=> "teacher_things/pack_users.php",	
						
						"rangliste" 	=> "teacher_things/rangliste.php",
						
						"settings" 	=> "teacher_things/settings.php",
						
						"notice_board" 	=> "teacher_things/notice_board.php",	
						
						"settings_adv" 	=> "teacher_things/settings_adv.php",						
						
					),
								
		"content"     => array

						(
							"contentlist"  => "content_manager/content.php",
							
							"grammarcontentlist"  => "content_manager/grammar_pages.php",

							"addcontent"  => "content_manager/add_content.php",

							"editcontent"  => "content_manager/edit_content.php"

						),
						
		"gallery"     => array

						(
							"gallerylist"  => "gallery_manager/gallery.php",

							"addgallery"  => "gallery_manager/add_gallery.php",

							"editgallery"  => "gallery_manager/edit_gallery.php"

						),
						
						
		"reminder"     => array

						(
							"add_reminder"  => "reminder_manager/add_reminder.php",

							"edit_reminder"  => "reminder_manager/edit_reminder.php",

							"reminder"  => "reminder_manager/reminder.php"

						),	
									
						
		"regcode"     => array

						(
							"regcodelist"  => "reg_code_manager/regcode.php",
							
							"codeslist"  => "reg_code_manager/codes_list.php",

							"addregcode"  => "reg_code_manager/add_regcode.php",

							"editregcode"  => "reg_code_manager/edit_regcode.php"

						),	
						
		"hangman"     => array

						(
							"hangman_topic"  => "hangman_files/hangman_topic.php",
							
							"add_topic"  => "hangman_files/add_topic.php",

							"edit_topic"  => "hangman_files/edit_topic.php",
							
						),				
						
					
		"exercise"     => array

						(
							"exerciselist"  => "exercise_manager/exercise.php",

							"addexercise"  => "exercise_manager/add_exercise.php",

							"editexercise"  => "exercise_manager/edit_exercise.php",
							
							"questionlist"  => "exercise_manager/question.php",

							"addquestion"  => "exercise_manager/add_question.php",

							"editquestion"  => "exercise_manager/edit_question.php",						
							

						),
											
		"voc"     => array

						(

							"vocsetlist"  => "vocabulary_manager/voc_set.php",
							
							"addvocset"  => "vocabulary_manager/add_voc_set.php",
							
							"editvocset"  => "vocabulary_manager/edit_voc_set.php",

							"voclist"  => "vocabulary_manager/voc.php",
							
							"voclist1"  => "vocabulary_manager/voc1.php",
							
							"addvoc"  => "vocabulary_manager/add_voc.php",

							"editvoc"  => "vocabulary_manager/edit_voc.php"

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

		"general" => array(

						"language" => "Vocabulary language",

					),

						

		"member"        =>$config_role_menu,

		
		"content" 	  => array

						(
							"contentlist"  => "Content List",
							
							"grammarcontentlist"  => "Grammar Page List",

							"addcontent" =>  "Add Content"
		                ),
						
		"gallery" 	  => array

						(
							"gallerylist"  => "Files List",

							"addgallery" =>  "Upload File"
		                ),	
						
		"reminder" 	  => array

						(
							"reminder"  => "Erinnerungsmail",

							"add_reminder" =>  "Neue Erinnerungsmail erstellen"
		                ),					
						
		"regcode" 	  => array

						(
							"regcodelist"  => "Reg. Codes List",

							"addregcode" =>  "Add Reg. Code"
		                ),
							
		"exercise" 	  => array

						(
							"exerciselist"  => "Exercise List",

							"addexercise" =>  "Add Exercise",
							
							"addquestion" =>  "Add Question"
		                ),	
						
		"teachers" 	  => array

						(
							"settings_adv"  => "Aufgabenpaket",
							
							"settings"  => "Einstellungen",
							
							"rangliste"  => "Rangliste",
							
							"notice_board"  => "Rotes Brett",
							
		                ),														
						
		"voc" 	  => array

						(
							"vocsetlist"  => "Vocabulary Sets",
							
							"addvocset"  => "New Vocabulary Set",
							
							"voclist1"  => "Vocabulary Finder",
							
							"addvoc" =>  "Add Vocabulary"
		                ),
						
		"hangman" 	  => array

						(
							"hangman_topic"  => "Topic List",
							
							"add_topic"  => "Add Topic",
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