<?php 
require_once('../config/dbconnect.php');

function deleteDirectory($dir) {
    if (!file_exists($dir)) {
        return true;
    }

    if (!is_dir($dir)) {
        return unlink($dir);
    }

    foreach (scandir($dir) as $item) {
        if ($item == '.' || $item == '..') {
            continue;
        }

        if (!deleteDirectory($dir . DIRECTORY_SEPARATOR . $item)) {
            return false;
        }

    }

    return rmdir($dir);
}

if(isset($_SESSION["admin_panel"]) && isset($_POST['id'])){

	$msg='Delete operation unsuccessful';
	
	$id = isset($_POST['id'])? $_POST['id']: '0,';
	
	$id.='0';
	
	$product_img1=array();

	$personal_folders = array();
	
	$image_dir1 = "../data/user/";

	$personal_dir = "../data/FILES/";
	
	$sql = "select user_photo, user_first_name, user_last_name, user_id from ".$db_suffix."user where user_id IN (".$id.")";				
	$query = mysqli_query($db, $sql);

	while($row=mysqli_fetch_object($query)){
		
		array_push($product_img1, $row->user_photo);

		array_push($personal_folders, $row->user_first_name.'-'.$row->user_last_name.'-'.$row->user_id);
	}
	
	if(mysqli_query($db,"DELETE FROM ".$db_suffix."user WHERE user_id IN (".$id.")")){

		mysqli_query($db,"DELETE FROM ".$db_suffix."gallery WHERE user_id IN (".$id.")");

		foreach($personal_folders as $value)
	
			deleteDirectory($personal_dir.$value);
	
		foreach($product_img1 as $value)
	
			unlink($image_dir1.$value);
	}
}
?>