<?php
	//var_dump($_POST);
	
	require_once("../config.php");
	$link = mysql_connect($CFG->dbhost, $CFG->dbuser , $CFG->dbpass) or die('no connect');
	if (! $link)
		die(mysql_error());
	mysql_select_db($CFG->dbname , $link) or die("Select Error: ".mysql_error());
	
	$query = "select username from mdl_user where username='".$_POST['username']."'";
	
	$result = mysql_query($query) or die('unable to select values');
	$row = mysql_fetch_array($result);
    echo json_encode($row);

	exit;
?>
