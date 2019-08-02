<?php 
require_once('../config/dbconnect.php');

if(isset($_SESSION["admin_panel"]) && isset($_POST['id'])){

	$id = isset($_POST['id'])?$_POST['id']: 0;
		
	if(mysqli_query($db,"UPDATE ".$db_suffix."user SET user_status=1 WHERE user_id =".$id)){
	
		$msg = "Reactivation successfull";
		
		$sql = "select * from ".$db_suffix."user where user_id = '$id' limit 1";				
		$query = mysqli_query($db, $sql);		
		if(mysqli_num_rows($query) > 0)
		{
			$usr = mysqli_fetch_object($query);
			$user_email= $usr->user_email;
			$user_first_name= $usr->user_first_name;
			$user_last_name= $usr->user_last_name;			
		}		
		
		$to = $user_email;		
        $subject = "Konto Aktivierung auf ".SITE_NAME;
		
		$message="<p>Sehr geehrte ".$user_first_name." ".$user_last_name." <br /><br />
		
		Ihr Konto wurde reaktiviert. Jetzt können Sie sich auf dem System anmelden.<br /><br />
		
		Viel Spaß!<br /><br /><br />
		
		Viele Grüße<br />
		
		".SITE_NAME." TEAM
		
		</p>";
		
		 $header = "From: ".SITE_NAME." <".SITE_EMAIL."> \r\n";
		 $header .= "MIME-Version: 1.0\r\n";
		 $header .= "Content-type: text/html; charset=UTF-8\r\n";
		 
		 $retval = mail ($to,$subject,$message,$header);
		
			
		
	}
		
	else
	
		$msg = "Reactivation failed";
		
	echo $msg;
}
?>