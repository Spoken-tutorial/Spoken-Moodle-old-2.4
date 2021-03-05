<html>
<head><title>Auto Check</title></head>
<body>
<?php
 // $a ="hello";
 // echo $a;
require_once("config.php");
//require_login();
$PAGE->set_title('Auto-Check');
$site=get_site();
$loginsite='Auto-Check';
$PAGE->set_heading($site->fullname);
$PAGE->navbar->add($loginsite);
echo $OUTPUT -> header();
if(isset($_POST['user']) && isset($_POST['pass']) && (($_POST['user'] == 'vishnu' && $_POST['pass'] == 'ee2433259b0fe399b40e81d2c98a38b6') || ($_POST['user'] == 'prathamesh' && md5($_POST['pass']) == 'c9d395060893aef7b9fbe2a896fe9204') || ($_POST['user'] == 'sanmugam' && md5($_POST['pass']) == 'bf7bab2c16091b3d991c2ad455e84a8d'))){
?>

<form id="test" name="test" method="POST" action="output.php">
	<div style="padding-left: 30px;">
		<div style="float: right; width: 400px; color: #DA5013;"><?php echo 'Logged in as '.$_POST['user'].'&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; <a href="autocheck.php">Logout</a><br />'; ?></div>
		<br />
		<input type="radio" name="quiz" value="c">C</input><br />
		<input type="radio" name="quiz" value="cpp">C++</input><br />
		<input type="radio" name="quiz" value="advancecpp">Advance cpp</input><br />
		<input type="radio" name="quiz" value="java">Java</input><br /><br />
		<input type="button" name="select" value="Grade now" onclick="validate()"></input>
	</div>
</form>

<script>
function validate()
{
 // alert("confirm");

 var checked = getSelectedRadio(document.forms.test.elements.quiz);
 if(checked)
 {
   // alert("proper");
   (document.forms.test).submit();
 }
 else
{
  alert("Please select the quiz");
}
 
}

function getSelectedRadio(radio_name)
{
  for(var i = 0; i < radio_name.length ; i++ )
  {
     if(radio_name[i].checked)
     {
          return radio_name[i];
     }
  }
 return undefined;
}
</script>
<?php
}else{
?>
<form method="POST" action="autocheck.php">
	<table border="0" cellpadding="5" cellspacing="5">
		<tr>
			<td>Username</td>
			<td><input type="text" name="user" /></td>
		</tr>
		<tr>
                        <td>Password</td>
                        <td><input type="password" name="pass" /></td>
                </tr>
		<tr>
                        <td></td>
                        <td><input type="submit" value="Submit" /></td>
                </tr>
	</table>
</form>
<?php
}
echo $OUTPUT -> footer();
?>
</body>
</html>
