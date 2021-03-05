<?php
	$foss_categories = array();
	$foss_categories['C Test'] = "C";
	$foss_categories['C++ Test'] = "C-Plus-Plus";
	//$foss_categories['C-and-C-Plus-Plus'] = "C-and-C-Plus-Plus";
	$foss_categories['Java Test'] = "Java";
	$foss_categories['LaTeX Test'] = "LaTeX";
	$foss_categories['Linux Test'] = "Linux";
	$foss_categories['OpenFOAM Test'] = "OpenFOAM";
	$foss_categories['PHP-MySQL Test'] = "PHP-and-MySQL";
	$foss_categories['Python Test'] = "Python";
	$foss_categories['Scilab Test'] = "Scilab";
	$foss_categories['CheckList'] = "CheckList";
	$foss_categories['testing-c'] = "testing-c";
	$foss_categories['C Test 13 Jan'] = "C";
	$username = 'otc_st_user';
	$password = 'Dgonl*pq2os19';
	$host = 'localhost';
	$database = 'workshop_info';

	# mysql connection
	$con = mysql_connect( $host, $username, $password) or die ('unable to connect mysql');
	mysql_select_db($database, $con) or die ('Unable to select Database');
?>
