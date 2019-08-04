<?php 
require_once('../config/dbconnect.php');

if(isset($_SESSION["admin_panel"]) && isset($_POST['id'])){

	$msg = "Error";

	$id = isset($_POST['id'])? $_POST['id']: '0,';
	$status = isset($_POST['status'])? $_POST['status']: 0;
	$table_name = isset($_POST['table_name'])? $_POST['table_name']: 'state';
	$column_name = isset($_POST['column_name'])? $_POST['column_name']: 'state_status';
	$column_id = isset($_POST['column_id'])? $_POST['column_id']: 'state_id';
	
	$added_condition='';
	
	if($status=='started')
		$added_condition = ", task_start_date=NOW(), task_end_date='0000-00-00 00:00:00'";

	else if($status=='complete')
		$added_condition = ", task_end_date=NOW()";

	else
		$added_condition = ", task_end_date='0000-00-00 00:00:00', task_start_date='0000-00-00 00:00:00'";
	
	$id.='0';
	echo $sql="UPDATE ".$db_suffix.$table_name." SET ".$column_name."='$status' $added_condition WHERE ".$column_id." IN (".$id.")";	
	
	if(mysqli_query($db,$sql))
			
		$msg = "Status changed successfully";
	
	echo $msg;
}
?>