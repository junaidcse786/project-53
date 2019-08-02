<?php 
require_once('../config/dbconnect.php');

$msg='Delete operation unsuccessful';

$id = isset($_POST['id'])? $_POST['id']: '0,';

$id.='0';

foreach(explode(',', $id) as $id_value){
	
		if($id_value=='0')
		
			continue;

	$sql_parent_menu = "SELECT voc_id FROM ".$db_suffix."voc_relation where voc_set_id=".$id_value;	
	$parent_query = mysqli_query($db, $sql_parent_menu);
	
	$i=0; $voc_id="";
	while($row = mysqli_fetch_object($parent_query))
	{
		if($i>0)
		
			$voc_id.=", ";
			
		$voc_id.="'voc-".$row->voc_id."'";
		$i++;
	}
	
	
	if(mysqli_query($db,"DELETE FROM ".$db_suffix."voc WHERE voc_id IN (SELECT voc_id from ".$db_suffix."voc_relation where voc_set_id=".$id_value.")"))
	{	
		
		$sql_parent_menu = "SELECT * FROM ".$db_suffix."lang";	
		$parent_query = mysqli_query($db, $sql_parent_menu);
		while($row = mysqli_fetch_object($parent_query))
		
			mysqli_query($db,"DELETE FROM ".$db_suffix.strtolower($row->lang_title)." WHERE content IN (".$voc_id.")");	
		
		mysqli_query($db,"DELETE FROM ".$db_suffix."voc_relation WHERE voc_set_id =".$id_value);
		
		mysqli_query($db,"DELETE FROM ".$db_suffix."voc_set WHERE voc_set_id =".$id_value);
		
		$msg = "Deleted successfully";
	}
}

?>