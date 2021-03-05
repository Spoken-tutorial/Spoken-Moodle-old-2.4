<?php
require_once ("../config.php");
//to add common layout
$PAGE->set_title('Registration Form');
$site = get_site();
$loginsite = 'Registration Form';
$PAGE->set_heading($site->fullname);
$PAGE->navbar->add($loginsite);
echo $OUTPUT -> header();
echo $OUTPUT -> heading('Registration Form');
?>
<script src="jquery-latest.js"></script>
<script type="text/javascript" src="jquery.validate.js"></script>
<script type="text/javascript" src="feedback.js"></script>
<form class="cmxform" id="commentForm" method="post" action="pr.php">
	<table align="center" border="0" cellpadding="7">
		<tr>
			<td><label for="cacademiccode">Academic Code</label><em>*</em></td>
			<td>
			<input id="academic_code" name="academic_code" size="25" class="required academic_code" />
			</td>
		</tr>
		<tr>
			<td><label for="cfirstname">First Name</label><em>*</em></td>
			<td>
			<input id="cfirstname" name="first_name" size="25"  class="required" />
		</tr>
		<tr>
			<td><label for="clastname">Last Name</label><em>*</em></td>
			<td>
			<input id="clastname" name="last_name" size="25"  class="required" />
		</tr>
		<tr>
			<td><label for="clastname">Gender</label><em>*</em></td>
			<td>
				<input type="radio" " id="gender_male" name="gender" size="25" value="Male"  class="required gender" checked="checked" /> Male &nbsp;&nbsp;
				<input type="radio" " id="gender_female" name="gender" size="25" value="Female"  class="required gender" /> Female
			</td>
		</tr>
		<tr>
			<td><label for="cage_range">Age Range</label><em>*</em></td>
			<td>
				<select id="cage_range" name="age_range" class="required age_range">
					<option value>-- select --</option>
					<option value="12-14">12-14 yrs</option>
					<option value="15-17">15-17 yrs</option>
					<option value="18-20">18 yrs & above</option>
				</select>
			</td>
		</tr>
		<tr>
			<td><label for="cusername">User Name</label><em>*</em></td>
			<td><input id="cusername" name="username" size="25"  class="required" /></td>
		</tr>
		<tr>
			<td><label for="cpassword">Password</label><em>*</em></td>
			<td><input type="password" id="cpassword" name="password" size="25"  class="required" /></td>
		</tr>
		<tr>
			<td><label for="cpermanentaddress">Permanent Address</label><em>*</em></td>
			<td><textarea id="cpermanentaddress" name="permenent_address" cols="25"  class="required permanemt_address" value="" /></textarea></td>
		</tr>
		<tr>
			<td><label for="cinstitutionname">Institution Name</label><em>*</em></td>
			<td><input id="cinstitutionname" name="institution_name" size="25"  class="required institution_name" readonly="readonly" value="" /></input></td>
		</tr>
		<tr>
			<td><label for="ccity">City</label><em>*</em></td>
			<td><input id="ccity" name="city" size="25"  class="required city" readonly="readonly" value="" /></input></td>
		</tr>
		<tr style='display:none'>
			<td><label for="cdepartment"></label><em>*</em></td>
			<td><input id="cdepartment" name="department" size="25"  class="required department" value="School" type='hidden' /></input></td>
		</tr>
		<tr>
			<td><label for="cemail">Email</label></td>
			<td><input id="email" name="email" size="25"  class="email"></input></td>
		</tr>
		<tr>
			<td colspan="2" align="center"><input class="submit" type="submit" value="Submit"/></td>
		</tr>
	</table>
</form>
<?php
	echo $OUTPUT -> footer();
?>
