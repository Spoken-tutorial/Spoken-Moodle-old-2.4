<?php
ini_set('max_execution_time', 1000);
if(!isset($_POST["quiz"]) || $_POST == ""){
        echo "test";
        header('Location: autocheck.php');
        exit;
}
require_once("config.php");
// require_login();
$PAGE->set_title('Auto-Check');
$site=get_site();
$loginsite='Auto-Check';
$PAGE->set_heading($site->fullname);
$PAGE->navbar->add($loginsite);
echo $OUTPUT -> header();

 $option = $_REQUEST["quiz"];
 $quizno = null;
 if($option=="c")
{
  //$quizno="18";
  $quizno="28";
}
else if($option=="cpp")
{
 //$quizno="22";
 $quizno="29";
}
else if($option=="java")
{
 //$quizno="20";
 $quizno="30";
}
else if($option=="advancecpp")
{
     //$quizno="20";i
      $quizno="24";
}

echo '<b>'.$option.': </b>';
 $output = "";
 $read_console=null;
 $ret=999;
 
 $run= "java Autocheck ".$quizno." ".$option;
 echo $run;
// try
// {
 	exec("cd /home/javauser/testing_v2/; ".$run,$read_console,$ret);
	echo "Manual grading is complete";
  //}catch(Exception $e){echo $e;}
//echo $read_console[0]."</br>".$ret;
for($i=0;$i<=count($read_console);$i++)
{
echo $read_console[$i]."</br>";
}
echo $OUTPUT -> footer();
?>
