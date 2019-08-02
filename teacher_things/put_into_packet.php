<?php 
require_once('../config/dbconnect.php');

if(isset($_SESSION["admin_panel"]) && $_SESSION["role_id"]==15 && isset($_POST['id']) && isset($_POST['status'])){
	
	$msg='Operation unsuccessful';

	$id = isset($_POST['id'])?$_POST['id']: ',';
	
	$id=substr($id,0,-1);
	
	$status = isset($_POST['status'])?$_POST['status']: '';	
	
	
	if($status==1){
	
		$insert_sql="INSERT INTO ".$db_suffix."mandat_exe (exercise_id, lang_level, org_name,  percentage, trial_times, exe_order, me_status) VALUES ";
		
		$insert_sql_actual='';
		
		$ids_to_switch_on='';
	
		$percentage=65;
		
		$trial_times=1;	
		
		
		$sql = "select MAX(exe_order) AS MAX from ".$db_suffix."mandat_exe where lang_level = '".$_SESSION["user_level"] ."' AND org_name='".$_SESSION["user_org_name"]."'";				
		
		$query = mysqli_query($db, $sql);
		
		$content=mysqli_fetch_object($query);
		
		$exe_order = $content->MAX + 1;
		
		
		$mandate_exe_id=array(); 
		$sql = "select exercise_id from ".$db_suffix."mandat_exe where lang_level = '".$_SESSION["user_level"] ."' AND org_name='".$_SESSION["user_org_name"]."'";				
		$query = mysqli_query($db, $sql);
		
		while($content=mysqli_fetch_object($query))	
			
			array_push($mandate_exe_id, $content->exercise_id);		
	
		foreach(explode(',', $id) as $id_value){
		
			if(!in_array($id_value, $mandate_exe_id))
			
				$insert_sql_actual.="('$id_value', '".$_SESSION["user_level"] ."', '".$_SESSION["user_org_name"]."', '$percentage', '$trial_times', '$exe_order', '1'),";
				
			else

				$ids_to_switch_on.=	$id_value.",";	
		}
		
		if($ids_to_switch_on!=''){
		
			$ids_to_switch_on=substr($ids_to_switch_on,0,-1);
		
			mysqli_query($db, "UPDATE ".$db_suffix."mandat_exe SET me_status='1' WHERE exercise_id IN (".$ids_to_switch_on.") AND  lang_level = '".$_SESSION["user_level"] ."' AND org_name='".$_SESSION["user_org_name"]."'");
		}
		
		if($insert_sql_actual!=''){
		
			$insert_sql_actual=substr($insert_sql_actual,0,-1);
			
			mysqli_query($db, $insert_sql.$insert_sql_actual);		
		}		
	}
	
	else if($status==0){
	
		$update_sql_0="UPDATE ".$db_suffix."mandat_exe SET me_status='0' WHERE exercise_id IN (".$id.") AND  lang_level = '".$_SESSION["user_level"] ."' AND org_name='".$_SESSION["user_org_name"]."'";
		mysqli_query($db, $update_sql_0);	
	}		
	
	else if($status==2){
	
		$delete_sql="DELETE FROM ".$db_suffix."mandat_exe where lang_level = '".$_SESSION["user_level"] ."' AND org_name='".$_SESSION["user_org_name"]."' AND exercise_id IN (".$id.")";
		mysqli_query($db, $delete_sql);	
	}
}
?>