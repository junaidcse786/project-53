<?php 
require_once('../config/dbconnect.php');


if(isset($_SESSION["admin_panel"]) && isset($_REQUEST['exe_id'])){

	$id=$_REQUEST["exe_id"];

	$sql = "SELECT question_id, question_hits_user, question_wrong_hits_user FROM ".$db_suffix."question where exercise_id='$id' ";
	$query = mysqli_query($db, $sql);
	
	while($row = mysqli_fetch_object($query)){
	
		$wrong_users       = $row->question_wrong_hits_user;
		$act_users       = $row->question_hits_user;	
		
		$wrong_users_corr='';
		$act_users_corr='';

		$words = explode(" ", $wrong_users);		

		foreach($words as $word) {
							
			$sql = "SELECT user_id FROM ".$db_suffix."user where user_id='$word' ";
			$query1 = mysqli_query($db, $sql);
			
			if(mysqli_num_rows($query1)>0)
					
				$wrong_users_corr.=$word.' ';
		}

		$wrong_users_corr=substr($wrong_users_corr,0,-1);
		
		
		$words = explode(" ", $act_users);		

		foreach($words as $word) {
							
			$sql = "SELECT user_id FROM ".$db_suffix."user where user_id='$word' ";
			$query1 = mysqli_query($db, $sql);
			
			if(mysqli_num_rows($query1)>0)
					
				$act_users_corr.=$word.' ';
		}

		$act_users_corr=substr($act_users_corr,0,-1);
		


		mysqli_query($db, "UPDATE ".$db_suffix."question SET question_wrong_hits_user='$wrong_users_corr', question_hits_user='$act_users_corr' where question_id='$row->question_id' ");
	}
}
echo '<script>history.go(-1);</script>';
?>