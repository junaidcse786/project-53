<?php 
require_once('../config/dbconnect.php');

if(isset($_SESSION["admin_panel"]) && isset($_POST['id'])){
	
	$msg='Delete operation unsuccessful';
	
	$id = isset($_POST['id'])? $_POST['id']: '0,';
	
	$id.='0';	
		
	if(mysqli_query($db,"DELETE FROM ".$db_suffix."content WHERE content_id IN (".$id.")"))
	
		$msg = "Delete successfully";
		
	
	echo $msg;
}
?>