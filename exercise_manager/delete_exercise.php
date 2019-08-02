<?php 
require_once('../config/dbconnect.php');

if(isset($_SESSION["admin_panel"]) && isset($_POST['id'])){

	$msg='Delete operation unsuccessful';
	
	$id = isset($_POST['id'])? $_POST['id']: '0,';
	
	$id.='0';
	
	if(mysqli_query($db,"DELETE FROM ".$db_suffix."exercise WHERE exercise_id IN (".$id.")")){
		
		mysqli_query($db,"DELETE FROM ".$db_suffix."question WHERE exercise_id IN (".$id.")");
		mysqli_query($db,"DELETE FROM ".$db_suffix."history WHERE exercise_id IN (".$id.")");
		mysqli_query($db,"DELETE FROM ".$db_suffix."mandat_exe WHERE exercise_id IN (".$id.")");
		$msg = "Deleted successfully";		
	}
	
	echo $msg;
}
?>