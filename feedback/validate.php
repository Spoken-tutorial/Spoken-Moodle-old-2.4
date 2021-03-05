<?php
  require_once('inc.config.php');
  $row = '';
  //$query = "select workshop_code, foss_category, pref_language from workshop_requests where workshop_code='".$_POST['workshop_code']."'";
  $query = "select ac.institution_name, wr.workshop_code, wr.foss_category, wr.pref_language from workshop_requests wr, academic_center ac where wr.workshop_code='".$_POST['workshop_code']."' and wr.academic_code=ac.academic_code";
  $result = mysql_query($query) or die('unable to select values');

  $row = mysql_fetch_object($result);
	$userexist = '';
  if(isset($_POST['user_id'])){
  $query = "select user_id from workshop_feedback where workshop_code='".$_POST['workshop_code']."' and user_id='".$_POST['user_id']."'";
  $result = mysql_query($query) or die('unable to select values');
  $userexist = mysql_fetch_array($result);
  }
  if($userexist){
          echo 'exit';
          exit;
  }else{
          echo json_encode($row);
          exit;
  }

?>
