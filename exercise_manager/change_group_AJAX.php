<?php 

require_once('../config/dbconnect.php');

$options='';

$id = isset($_POST['id'])?$_POST['id']: 0;
$id = isset($_REQUEST['id'])?$_REQUEST['id']: $id;

$sql_parent_menu = "SELECT DISTINCT question_pick FROM ".$db_suffix."question where question_pick!='' AND exercise_id='$id'";
$parent_query = mysqli_query($db, $sql_parent_menu);
while($parent_obj = mysqli_fetch_object($parent_query))

	$options.= '<option value="'.$parent_obj->question_pick.'">'.$parent_obj->question_pick.'</option>';
	
echo $options;
?>