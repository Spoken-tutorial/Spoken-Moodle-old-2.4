<?php
	require_once('inc.config.php');
	$query = "select institution_name, city from academic_center where academic_code='".$_POST['academic_code']."'";
	$result = mysql_query($query, $con) or die('unable to select values');
	
	$row = mysql_fetch_array($result);
	echo json_encode($row);
	exit;
?>
