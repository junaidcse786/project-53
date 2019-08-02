<?php 
require_once('../config/dbconnect.php');

if($_SESSION["role_id"]==8 && isset($_SESSION["admin_panel"]) && isset($_REQUEST['id'])){
	
	$id = isset($_REQUEST['id'])?$_REQUEST['id']:0;
	
	$sql = "select lang_title from ".$db_suffix."lang where lang_id = $id limit 1";				
	$query = mysqli_query($db, $sql);
	
	if(mysqli_num_rows($query) > 0)
	{
		$product = mysqli_fetch_object($query);
		$table_name = strtolower($product->lang_title);
	}
	
	echo $sql1="DROP TABLE ".$db_suffix.$table_name;
	if(mysqli_query($db, $sql1))
	{
		mysqli_query($db,"DELETE FROM ".$db_suffix."lang WHERE lang_id =".$id);
		$msg = "succeeded to delete";
		
	}else{
		$msg = "Failed to delete";
	}
	echo $msg;
}
?>