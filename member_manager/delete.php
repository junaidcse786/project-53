<?php 
require_once('../config/dbconnect.php');

if(isset($_SESSION["admin_panel"]) && isset($_POST['id'])){

	$msg='Delete operation unsuccessful';
	
	$id = isset($_POST['id'])? $_POST['id']: '0,';
	
	$id.='0';
	
	$product_img1=array();
	
	$image_dir1 = "../data/user/";
	
	$sql = "select user_photo from ".$db_suffix."user where user_id IN (".$id.")";				
	$query = mysqli_query($db, $sql);
	while($row=mysqli_fetch_object($query))
		
		array_push($product_img1, $row->user_photo);
	
	if(mysqli_query($db,"DELETE FROM ".$db_suffix."user WHERE user_id IN (".$id.")")){
	
		foreach($product_img1 as $value)
	
			unlink($image_dir1.$value);
	}
}
?>