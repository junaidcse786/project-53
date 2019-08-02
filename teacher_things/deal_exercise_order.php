<?php 
require_once('../config/dbconnect.php');

if(isset($_SESSION["admin_panel"]) && $_SESSION["role_id"]==15 && isset($_POST['long_text'])){
	
	$msg='Operation unsuccessful';

	$id=substr($_POST['long_text'], 0, -1);
	
	foreach(explode('=', $id) as $first_part){
		
		$value=explode(',', $first_part);
		
		$percentage=$value[1];
		
		$trial_times=$value[2];
		
		
		if(!is_numeric($trial_times) || $trial_times<1 || $trial_times>10)
			
			$trial_times=1;
		
		if(!is_numeric($percentage) || $percentage<1 || $percentage>100)
		
			$percentage=65;	
			
		
		mysqli_query($db, "UPDATE ".$db_suffix."mandat_exe SET percentage='$percentage', trial_times='$trial_times', exe_order='".$value[3]."' WHERE exercise_id='".$value[0]."' AND lang_level = '".$_SESSION["user_level"] ."' AND org_name='".$_SESSION["user_org_name"]."'");
	}
}
?>