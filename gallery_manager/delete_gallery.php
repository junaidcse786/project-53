<?php 
require_once('../config/dbconnect.php');

if(isset($_SESSION["admin_panel"]) && isset($_POST['id'])){

	$msg='Delete operation unsuccessful';
	
	$id = isset($_POST['id'])? $_POST['id']: '0,';
	
	$id.='0';
	
	foreach(explode(',', $id) as $id_value){
		
			if($id_value=='0')
			
				continue;
		
		$sql = "select gallery_file, user_id from ".$db_suffix."gallery where gallery_id = $id_value limit 1";				
		$query = mysqli_query($db, $sql);
		$banner_image = "";		
		
		if(mysqli_num_rows($query) > 0)
		{
			$product = mysqli_fetch_object($query);
			$banner_image = $product->gallery_file;
			$user_id = $product->user_id;

			$sql11 = "select * from ".$db_suffix."user where user_id = '".$user_id."' limit 1";				
			$query11 = mysqli_query($db, $sql11);

			if(mysqli_num_rows($query11) > 0){
					$usr = mysqli_fetch_object($query11);
					$user_folder = $usr->user_first_name.'-'.$usr->user_last_name.'-'.$usr->user_id;
			}

			$image_dir = "../data/FILES/".$user_folder."/";
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