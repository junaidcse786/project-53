<?php 
require_once('../config/dbconnect.php');

if(isset($_SESSION["admin_panel"]) && isset($_POST['id'])){

	$msg='Delete operation unsuccessful';
	
	$id = isset($_POST['id'])? $_POST['id']: '0,';
	
	$id.='0';
	
	foreach(explode(',', $id) as $id_value){
		
			if($id_value=='0')
			
				continue;
		
		$sql = "select gallery_file from ".$db_suffix."gallery where gallery_id = $id_value limit 1";				
		$query = mysqli_query($db, $sql);
		$banner_image = "";
		$image_dir = "../../data/FILES/";
		
		if(mysqli_num_rows($query) > 0)
		{
			$product = mysqli_fetch_object($query);
			$banner_image = $product->gallery_file;
		}
		
		if(mysqli_query($db,"DELETE FROM ".$db_suffix."gallery WHERE gallery_id =".$id_value))
		{
			unlink($image_dir.$banner_image);
			
			$msg = "Deleted successfully";
		}
	
	}
	echo $msg;
}
?>