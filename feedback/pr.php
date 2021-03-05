<?php
	require_once("../config.php");
	$username = $_POST['username'];
	$password = md5($_POST['password']);

	//$rid=$_POST['idnumber1']."-".$_POST[idnumber2]."-".$_POST[idnumber3];
	$rid = $username;
	$fname=$_POST['first_name'];
	$lname=$_POST['last_name'];
	$passwd=$password;
	$email=$_POST['email'];
	$instu=mysql_escape_string($_POST['institution_name']);
	$acode=$_POST['academic_code'];
	$org='';
	$inv='';
	$dept=$_POST['department'];
	$city=$_POST['city'];
	$addr = $_POST['permenent_address'];
	$gender = $_POST['gender'];
	$age_range = $_POST['age_range'];
	$cntry='in';
	$link = mysql_connect($CFG->dbhost, $CFG->dbuser , $CFG->dbpass) or die('no connect');
	if (! $link)
		die(mysql_error());
	mysql_select_db($CFG->dbname , $link) or die("Select Error: ".mysql_error());
	$query = "INSERT INTO OTC.mdl_user (id, auth, confirmed, policyagreed, deleted, suspended, mnethostid, username, password, idnumber, firstname, lastname, gender, age_range, email, emailstop, icq, skype, yahoo, aim, msn, phone1, phone2, institution, academic_code, department, address, city, country, lang, theme, timezone, firstaccess, lastaccess, lastlogin, currentlogin, lastip, secret, picture, url, description, descriptionformat, mailformat, maildigest, maildisplay, htmleditor, autosubscribe, trackforums, timecreated, timemodified, trustbitmask, imagealt, organizer,invigilator) 
	VALUES (NULL, 'manual', '1', '0', '0', '0', '1', '$rid' , '$passwd', '$rid', '$fname', '$lname', '$gender', '$age_range', '$email', '0', '', '', '', '', '', '', '', '$instu', '$acode', '$dept', '$addr', '$city', '$cntry', 'en', '', '99', '0', '0', '0', '0', '', '', '0', '', NULL, '0', '1', '0', '2', '1', '1', '0', '0', '0', '0', NULL, '$org','$inv');
	";
	//var_dump($query);
	if(mysql_query($query)){
		header('Location:'.$CFG->wwwroot.'/');
	} else{
		echo 'Sorry, this username already exists. Please choose another username.';
	}
?>
