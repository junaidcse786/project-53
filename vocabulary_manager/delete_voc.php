<?php 
require_once('../config/dbconnect.php');

$msg='Delete operation unsuccessful';

$id = isset($_POST['id'])? $_POST['id']: '0,';

$id.='0';

foreach(explode(',', $id) as $id_value){
	
		if($id_value=='0')
		
			continue;
	
	if(mysqli_query($db,"DELETE FROM ".$db_suffix."voc_relation WHERE voc_id=".$id_value))
	{
		$sql_parent_menu = "SELECT * FROM ".$db_suffix."lang";	
		$parent_query = mysqli_query($db, $sql_parent_menu);
		while($row = mysqli_fetch_object($parent_query))
		
			mysqli_query($db,"DELETE FROM ".$db_suffix.strtolower($row->lang_title)." WHERE content='voc-".$id_value."'");	
		
		mysqli_query($db,"DELETE FROM ".$db_suffix."voc WHERE voc_id =".$id_value);
		
		$msg = "Delete successfully";
	}
}
echo $msg;
?>