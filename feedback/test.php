<?php
	require_once("../config.php") ; //this assumes your php file is in a subdirectory of your moodle

	require_login(); //Won't do any good to 'get' a username 'til sombody's logged in.
	echo $OUTPUT->header();
	echo $OUTPUT->heading('Test Course');

	print "<p>$USER->username</p>"; //this gets the username (login)
	print "<p>$USER->firstname $USER->lastname</p>"; //This gets the first and last.

	echo $OUTPUT->footer();

?> 
