<?php 
 // $Id: viewimage.php,v 1.00 2010/01/08 11:11:34 moodler Exp $
 //modified code from user/view.php for showing only profile image.  By nck0909
 //  Display profile IMAGE for a particular user
	
    require_once("config.php");
    $id      = optional_param('id',     0,      PARAM_INT);   // user id
   	if($id){
   		$user = $DB->get_record('user', array('id'=>$id));
		echo "<style>\n.ifimg { width:52px; height:52px;}\n.ifimg img { width:50px; height:50px;}\nbody {width:55px; height:55px; overflow:hidden;}\n</style>\n<div class='ifimg'>";
    		return print_user_picture($user->id, 0, $user->picture, true, false, false);
		echo "</div>";
   	}
?>
