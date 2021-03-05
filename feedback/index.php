<?php
require_once ("../config.php");
//to add common layout
$PAGE->set_title('Feedback Form');
$site = get_site();
$loginsite = 'Feedback Form';
$PAGE->set_heading($site->fullname);
$PAGE->navbar->add($loginsite);
require_login();
echo $OUTPUT -> header();
?>
	<script src="jquery-latest.js"></script>
	<script type="text/javascript" src="jquery.validate.js"></script>
	<script>
		$(document).ready(function(){
  			webroot = "http://"+location.hostname+"/feedback/";
			$('#workshop_code').change(function(){
				var val = $(this).val();
				var this_data = $(this);
				var userid = $('#userid').val();
				if(val){
					if(val !='swayam'){
						$('.institution').attr('readonly', true);
						$('.foss').attr('readonly', true);
					     $.ajax({
					  	type: 'POST',
					  	url : webroot+"validate.php",
					  	data: {'workshop_code': val, 'user_id': userid },
					  	success: function(data){
					  	    if(data !='exit'){
						  		output=JSON.parse(data);
						  		if(output){
						  		     this_data.next().remove();
						  		     $('.errorcustom').remove();
									 $('#foss').val(output.foss_category);
									 $('#institution').val(output.institution_name);
									 $('#lang_mother').val(output.pref_language);
									 $('#mother_lang').html(output.pref_language);
						  		}else{
						  			if(!this_data.next().next().is('label')){
						  				this_data.parent().append('<br><label for="tes" generated="true" class=" error errorcustom" style="">Please, enter valied Workshop code.</label>');
						  				$('#foss').val();
						  			}
						  			this_data.focus();
						  		}
						  	}else{
						  		if(!this_data.next().next().is('label')){
						  				this_data.parent().append('<br><label for="tes" generated="true" class=" error errorcustom" style="">Feedback Already exits for this workshop.</label>');
						  				$('#foss').val();
						  			}
						  			this_data.focus();
						  	}
					  	}
					  });
					}else{
						$('.foss').attr('readonly', false).val('');
						$('.institution').attr('readonly', false).val('');
					}
				}else{
				  this_data.focus();
				}
			});
			
			$("#feedbackfrm").validate();

		});
	</script>
	<?php if($_POST):
		echo "<pre>";
		// print_r($_POST);
		// exit;
		$weakness_duration = 0;
		if(isset($_POST['weakness_duration']))
			$weakness_duration = 1;
		$weakness_understand = 0;
		if(isset($_POST['weakness_understand']))
			$weakness_understand = 1;
		$weakness_narration = 0;
		if(isset($_POST['weakness_narration']))
			$weakness_narration = 1;
		
		require_once('inc.config.php');
		// Fetching organiser name and invigilator name using workshop-code.
		//$query = "SELECT wd.name_of_invigilator, wr.organiser_id, org.organiser_name FROM workshop_details wd, workshop_requests wr, organiser org WHERE wd.workshop_code =  '".$_POST['workshop_code']."' AND wr.workshop_code =  '".$_POST['workshop_code']."' AND org.username = wr.organiser_id";

		$query = "select * from workshop_details where workshop_code='".$_POST['workshop_code']."'";
		$result = mysql_query($query);
		if(!$row=mysql_fetch_array($result)){
			echo "<center><h2>Your feedback is not accepted.<br> Because we are not yet received the workshop details from your organiser. <br>For more details, please contact your organiser.</h2></center><br>";
			echo $OUTPUT->footer();
			exit;
		}

		/*$query = "SELECT wr.department, ac.institution_name, wd.name_of_invigilator, wr.organiser_id, org.organiser_name FROM workshop_details wd, workshop_requests wr, organiser org, academic_center ac WHERE wd.workshop_code ='".$_POST['workshop_code']."' AND wr.workshop_code ='".$_POST['workshop_code']."' AND org.organiser_id = wr.organiser_id AND wr.academic_code=ac.academic_code";
		$result = mysql_query($query);
		$row = mysql_fetch_array($result);
		
		mysql_select_db("OTC");
		// Updating organiser and invigilator names to mdl_user table.
		$query = "update mdl_user set institution='".mysql_real_escape_string($row['institution_name'])."', department='".mysql_real_escape_string($row['department'])."', organizer='".$row['name_of_invigilator']."', invigilator='".$row['organiser_name']."' where id=".$_POST['user_id'];
		//print_r($query);
                //echo exit;
		if(!mysql_query($query)){
			echo "<center><h2>Something went wrong, Please try again 1.</h2></center><br>";
			echo $OUTPUT->footer();
			exit;
		}*/
		
		mysql_select_db("workshop_info");
		$query = "INSERT INTO `workshop_info`.`workshop_feedback` (`id`, `user_id`, `workshop_code`, `rate_workshop`, `content`, `logical_arrangement`, `clarity`, `understandable`, `included_examples`, `instruction_sheet`, `assignments`, `pace_tutorial`, `useful_thing`, `weakness_duration`, `weakness_narration`, `weakness_understand`, `other_weakness`, `workshop_language`, `info_received`, `if_yes`, `comfortable_learning`, `working_computers`, `audio_quality`, `video_quality`, `orgn_wkshop`, `facil_learning`, `motiv_learning`, `time_mgmt`, `soft_klg`, `prov_expn`, `ans_cln`, `help_lern`, `exec_effly`, `ws_improved`, `recomm_wkshop`, `reason_why`, general_comment) VALUES (NULL, '".$_POST['user_id']."', '".$_POST['workshop_code']."', '".$_POST['rate_workshop']."', '".$_POST['content']."', '".$_POST['logical_arrangement']."', '".$_POST['clarity']."', '".$_POST['understandable']."', '".$_POST['included_examples']."', '".$_POST['instruction_sheet']."', '".$_POST['assignments']."', '".$_POST['pace_tutorial']."', '".mysql_real_escape_string($_POST['useful_thing'])."', '".$weakness_duration."', '".$weakness_narration."', '".$weakness_understand."', '".mysql_real_escape_string($_POST['other_weakness'])."', '".$_POST['workshop_language']."', '".$_POST['info_received']."', '".mysql_real_escape_string($_POST['if_yes'])."', '".$_POST['comfortable_learning']."', '".$_POST['working_computers']."', '".$_POST['audio_quality']."', '".$_POST['video_quality']."', '".$_POST['orgn_wkshop']."', '".$_POST['facil_learning']."', '".$_POST['motiv_learning']."', '".$_POST['time_mgmt']."', '".$_POST['soft_klg']."', '".$_POST['prov_expn']."', '".$_POST['ans_cln']."', '".$_POST['help_lern']."', '".$_POST['exec_effly']."', '".mysql_real_escape_string($_POST['ws_improved'])."', '".$_POST['recomm_wkshop']."', '".mysql_real_escape_string($_POST['reason_why'])."','".mysql_real_escape_string($_POST['general_comment'])."')";
		 //print_r($query);
		 //echo exit;
		if(mysql_query($query)){
			echo "<center><h2>Thank you for your valuable feedback.</h2></center><br>";
		}else{
			echo "<center><h2>Something went wrong, Please try again.</h2></center><br>";
			echo $OUTPUT->footer();
			exit;
		}

	?>
	<?php else: 
		echo $OUTPUT->heading('Feedback Please');
	?>
	
	<form method="POST" name="feedbackfrm" id="feedbackfrm" class="feedbackfrm">
		<table cellpadding="7" align="center">
			<tr>
				<td>Workshop Code</td>
				<td>
					<input type="hidden" value="<?php echo $USER->id; ?>" name="user_id" id="userid">
					<input type="text" name="workshop_code" id="workshop_code" class="required workshop_code" />
				</td>
			</tr>
			<tr>
				<td>Software on which workshop was taken</td>
				<td><input type="text" name="foss" id="foss" class="required foss" readonly="readonly" /></td>
			</tr>
			<tr>
				<td>Institution Name</td>
				<td><input type="text" name="institution" id="institution" class="required institution" readonly="readonly" /></td>
			</tr>
			<tr>
				<td colspan="2">Please rate this workshop on the following items:</td>
			</tr>
			<tr>
				<td colspan="2">
					<table align="center" border="1" width="100%" cellpadding="2">
						<tr>
							<th></th>
							<th>Very Bad</th>
							<th>Bad</th>
							<th>Fair</th>
							<th>Good</th>
							<th>Very Good</th>
						</tr>
						<tr>
							<td>Content</td>
							<td align="center">
								<input type="radio" class="content required " value="1" name="content" id="content">
							</td>
							<td align="center">
								<input type="radio" class="content required" value="2" name="content" id="content">
							</td>
							<td align="center">
								<input type="radio" class="content required" value="3" name="content" id="content">
							</td>
							<td align="center">
								<input type="radio" class="content required" value="4" name="content" id="content">
							</td>
							<td align="center">
								<input type="radio" class="content required" value="5" name="content" id="content">
							</td>
						</tr>
						<tr>
							<td>Sequence of tutorials</td>
							<td align="center">
								<input type="radio" class="logical_arrangement required required " value="1" name="logical_arrangement" id="logical_arrangement">
							</td>
							<td align="center">
								<input type="radio" class="logical_arrangement" value="2" name="logical_arrangement" id="logical_arrangement">
							</td>
							<td align="center">
								<input type="radio" class="logical_arrangement" value="3" name="logical_arrangement" id="logical_arrangement">
							</td>
							<td align="center">
								<input type="radio" class="logical_arrangement" value="4" name="logical_arrangement" id="logical_arrangement">
							</td>
							<td align="center">
								<input type="radio" class="logical_arrangement" value="5" name="logical_arrangement" id="logical_arrangement">
							</td>
						</tr>
						<tr>
							<td>Clarity of explanation</td>
							<td align="center">
								<input type="radio" class="clarity required " value="1" name="clarity" id="clarity">
							</td>
							<td align="center">
								<input type="radio" class="clarity" value="2" name="clarity" id="clarity">
							</td>
							<td align="center">
								<input type="radio" class="clarity" value="3" name="clarity" id="clarity">
							</td>
							<td align="center">
								<input type="radio" class="clarity" value="4" name="clarity" id="clarity">
							</td>
							<td align="center">
								<input type="radio" class="clarity" value="5" name="clarity" id="clarity">
							</td>
						</tr>
						 <tr>
                                                        <td style="vertical-align:top;">Interesting</td>
                                                        <td align="center">
                                                                <input type="radio" class="understandable required " value="1" name="understandable" id="understandable"> <p>(not at all)</p>
                                                        </td>
                                                        <td align="center">
                                                                <input type="radio" class="understandable" value="2" name="understandable" id="understandable"><p>(slightly)</p>
                                                        </td>
                                                        <td align="center">
                                                                <input type="radio" class="understandable" value="3" name="understandable" id="understandable"><p>(moderately)</p>
                                                        </td>
                                                        <td align="center">
                                                                <input type="radio" class="understandable" value="4" name="understandable" id="understandable"><p>(very)</p>
                                                        </td>
                                                        <td align="center">
                                                                <input type="radio" class="understandable" value="5" name="understandable" id="understandable"><p>(extremely)</p>
                                                        </td>
                                                </tr>

						<tr>
							<td>Use of appropriate examples</td>
							<td align="center">
								<input type="radio" class="included_examples required " value="1" name="included_examples" id="included_examples">
							</td>
							<td align="center">
								<input type="radio" class="included_examples" value="2" name="included_examples" id="included_examples">
							</td>
							<td align="center">
								<input type="radio" class="included_examples" value="3" name="included_examples" id="included_examples">
							</td>
							<td align="center">
								<input type="radio" class="included_examples" value="4" name="included_examples" id="included_examples">
							</td>
							<td align="center">
								<input type="radio" class="included_examples" value="5" name="included_examples" id="included_examples">
							</td>
						</tr>
						<tr>
							<td>Instruction Sheet</td>
							<td align="center">
								<input type="radio" class="instruction_sheet required " value="1" name="instruction_sheet" id="instruction_sheet">
							</td>
							<td align="center">
								<input type="radio" class="instruction_sheet" value="2" name="instruction_sheet" id="instruction_sheet">
							</td>
							<td align="center">
								<input type="radio" class="instruction_sheet" value="3" name="instruction_sheet" id="instruction_sheet">
							</td>
							<td align="center">
								<input type="radio" class="instruction_sheet" value="4" name="instruction_sheet" id="instruction_sheet">
							</td>
							<td align="center">
								<input type="radio" class="instruction_sheet" value="5" name="instruction_sheet" id="instruction_sheet">
							</td>
						</tr>
						<tr>
							<td>Assignments</td>
							<td align="center">
								<input type="radio" class="assignments required " value="1" name="assignments" id="assignments">
							</td>
							<td align="center">
								<input type="radio" class="assignments" value="2" name="assignments" id="assignments">
							</td>
							<td align="center">
								<input type="radio" class="assignments" value="3" name="assignments" id="assignments">
							</td>
							<td align="center">
								<input type="radio" class="assignments" value="4" name="assignments" id="assignments">
							</td>
							<td align="center">
								<input type="radio" class="assignments" value="5" name="assignments" id="assignments">
							</td>
						</tr>
						<!--<tr>
							<td>Pace of the tutorial</td>
							<td align="center">
								<input type="radio" class="pace_tutorial required " value="1" name="pace_tutorial" id="pace_tutorial">
							</td>
							<td align="center">
								<input type="radio" class="pace_tutorial" value="2" name="pace_tutorial" id="pace_tutorial">
							</td>
							<td align="center">
								<input type="radio" class="pace_tutorial" value="3" name="pace_tutorial" id="pace_tutorial">
							</td>
							<td align="center">
								<input type="radio" class="pace_tutorial" value="4" name="pace_tutorial" id="pace_tutorial">
							</td>
							<td align="center">
								<input type="radio" class="pace_tutorial" value="5" name="pace_tutorial" id="pace_tutorial">
							</td>
						</tr> -->
					</table>
				</td>
			</tr>
			<tr>
				<td>Pace of the tutorial</td>
			</tr>
			<tr>
				<td colspan=2>
					<table width="100%" border="1" align="center">
						<tr>
                                                        <th>Slow</th>
                                                        <th>Appropriate</th>
                                                        <th>Fast</th>
                                                </tr>

						<tr>
							 <td align="center">
                                                                <input type="radio" class="pace_tutorial required " value="1" name="pace_tutorial" id="pace_tutorial">
                                                        </td>
                                                        <td align="center">
                                                                <input type="radio" class="pace_tutorial" value="2" name="pace_tutorial" id="pace_tutorial">
                                                        </td>
                                                        <td align="center">
                                                                <input type="radio" class="pace_tutorial" value="3" name="pace_tutorial" id="pace_tutorial">
                                                        </td>

						</tr>
					</table>
				</td>
			</tr>
			<tr>
				<td colspan="2">How would you rate this workshop overall?</td>
			</tr>
			<tr>
				<td colspan="2">
					<table align="center" border="1" width="100%">
						<tr>
							<th>Very Bad</th>
							<th>Bad</th>
							<th>Satisfactory</th>
							<th>Good</th>
							<th>Excellent</th>
						</tr>
						<tr>
							<td align="center">
								<input type="radio" class="rate_workshop required " value="1" name="rate_workshop" id="very_Bad" label=false>
							</td>
							<td align="center">
								<input type="radio" class="rate_workshop required" value="2" name="rate_workshop" id="Bad">
							</td>
							<td align="center">
								<input type="radio" class="rate_workshop required" value="3" name="rate_workshop" id="satisfactory">
							</td>
							<td align="center">
								<input type="radio" class="rate_workshop required" value="4" name="rate_workshop" id="good">
							</td>
							<td align="center">
								<input type="radio" class="rate_workshop required" value="5" name="rate_workshop" id="excellent">
							</td>
						</tr>
					</table>
				</td>
			</tr>
			<tr>
				<td colspan="2">What was the most useful thing you learnt  in this workshop?</td>
			</tr>
			<tr>
				<td colspan="2" align="left">
					<textarea name="useful_thing" id="useful_thing" class="required useful_thing" cols="80" rows="3"></textarea>
				</td>
			</tr>
			<tr>
				<td colspan="2">What were the weaknesses of this workshop?</td>
			</tr>
			<tr>
				<td>
					<table align="center" border="1" width="100%">
						<tr>
							<td><input type="checkbox" class="weakness_duration" value="1" name="weakness_duration" id="weakness_duration" label=false></td>
							<td>Duration of the workshop is less</td>
						</tr>
						<tr>
							<td><input type="checkbox" class="weakness_narration" value="1" name="weakness_narration" id="weakness_narration" label=false></td>
							<td>Pace of the narration in the tutorials was very fast</td>
						</tr>
						<tr>
							<td><input type="checkbox" class="weakness_understand" value="1" name="weakness_understand" id="weakness_understand" label=false></td>
							<td>Had to listen more than two times to understand the commands</td>
						</tr>
					</table>
				</td>
		  </tr>
		  <tr>
		  	<td>Any other weakness</td>
		  </tr>
			<tr>
				<td colspan="2" align="left">
					<textarea name="other_weakness" id="other_weakness" class="other_weakness" cols="80" rows="3"></textarea>
				</td>
			</tr>
<tr>
				<td colspan="2">In which language did you watch the tutorials?</td>
			</tr>
			<tr>
				<td colspan="2">
					<table align="center" border="1" width="100%">
						<tr>
							<th id="mother_lang">Regional</th>
							<th>English</th>
							<th>Hindi</th>
						</tr>
						<tr>
							<td align="center">
								<input type="radio" class="workshop_language required " value="Regional" name="workshop_language" id="lang_mother">
							</td>
							<td align="center">
								<input type="radio" class="workshop_language required" value="English" name="workshop_language" id="lang_english">
							</td>
							<td align="center">
								<input type="radio" class="workshop_language required" value="Hindi" name="workshop_language" id="lang_hindi">
							</td>
						</tr>
					</table>
				</td>
			</tr>
			<tr>
				<td colspan="2">To what extent do you think you can apply the information you received today to your work/study?</td>
			</tr>
			<tr>
				<td colspan="2">
					<table align="center" border="1" width="100%">
						<tr>
							<th>Not at all</th>
							<th>A little bit</th>
							<th>Somewhat</th>
							<th>Quite a bit</th>
							<th>A lot</th>
						</tr>
						<tr>
							<td align="center">
								<input type="radio" class="info_received required " value="1" name="info_received" id="info_received">
							</td>
							<td align="center">
								<input type="radio" class="info_received" value="2" name="info_received" id="info_received">
							</td>
							<td align="center">
								<input type="radio" class="info_received" value="3" name="info_received" id="info_received">
							</td>
							<td align="center">
								<input type="radio" class="info_received" value="4" name="info_received" id="info_received">
							</td>
							<td align="center">
								<input type="radio" class="info_received" value="5" name="info_received" id="info_received">
							</td>
						</tr>
					</table>
				</td>
			</tr>
			<tr>
				<td colspan="2">If so, how do you plan to use the information?</td>
			</tr>
			<tr>
				<td colspan="2" align="left">
					<textarea name="if_yes" id="if_yes" class="required if_yes" cols="80" rows="3"></textarea>
				</td>
			</tr>
			<tr>
				<td colspan="2">How would you rate the workshop on the following?</td>
			</tr>
			<tr>
				<td colspan="2">
					<table align="center" border="1" cellpadding="2" width="100%">
						<tr>
							<th></th>
							<th>Very Low</th>
							<th>Below average</th>
							<th>Average</th>
							<th>Above average</th>
							<th>Very high</th>
						</tr>
						<tr>
							<td>Setup for learning</td>
							<td align="center">
								<input type="radio" class="comfortable_learning required " value="1" name="comfortable_learning" id="comfortable_learning">
							</td>
							<td align="center">
								<input type="radio" class="comfortable_learning" value="2" name="comfortable_learning" id="comfortable_learning">
							</td>
							<td align="center">
								<input type="radio" class="comfortable_learning" value="3" name="comfortable_learning" id="comfortable_learning">
							</td>
							<td align="center">
								<input type="radio" class="comfortable_learning" value="4" name="comfortable_learning" id="comfortable_learning">
							</td>
							<td align="center">
								<input type="radio" class="comfortable_learning" value="5" name="comfortable_learning" id="comfortable_learning">
							</td>
						</tr>
						<tr>
							<td>Computers in the lab</td>
							<td align="center">
								<input type="radio" class="working_computers required " value="1" name="working_computers" id="working_computers">
							</td>
							<td align="center">
								<input type="radio" class="working_computers" value="2" name="working_computers" id="working_computers">
							</td>
							<td align="center">
								<input type="radio" class="working_computers" value="3" name="working_computers" id="working_computers">
							</td>
							<td align="center">
								<input type="radio" class="working_computers" value="4" name="working_computers" id="working_computers">
							</td>
							<td align="center">
								<input type="radio" class="working_computers" value="5" name="working_computers" id="working_computers">
							</td>
						</tr>
						<tr>
							<td>Audio quality</td>
							<td align="center">
								<input type="radio" class="audio_quality required " value="1" name="audio_quality" id="audio_quality">
							</td>
							<td align="center">
								<input type="radio" class="audio_quality" value="2" name="audio_quality" id="audio_quality">
							</td>
							<td align="center">
								<input type="radio" class="audio_quality" value="3" name="audio_quality" id="audio_quality">
							</td>
							<td align="center">
								<input type="radio" class="audio_quality" value="4" name="audio_quality" id="audio_quality">
							</td>
							<td align="center">
								<input type="radio" class="audio_quality" value="5" name="audio_quality" id="audio_quality">
							</td>
						</tr>
						<tr>
							<td>Video quality</td>
							<td align="center">
								<input type="radio" class="video_quality required " value="1" name="video_quality" id="video_quality">
							</td>
							<td align="center">
								<input type="radio" class="video_quality" value="2" name="video_quality" id="video_quality">
							</td>
							<td align="center">
								<input type="radio" class="video_quality" value="3" name="video_quality" id="video_quality">
							</td>
							<td align="center">
								<input type="radio" class="video_quality" value="4" name="video_quality" id="video_quality">
							</td>
							<td align="center">
								<input type="radio" class="video_quality" value="5" name="video_quality" id="video_quality">
							</td>
						</tr>
					</table>
				</td>
			</tr>
			<tr>
				<td colspan="2">How would you rate the Workshop Organiser from your college, in terms of the following:</td>
			</tr>
			<tr>
				<td colspan="2">
					<table align="center" border="1" width="100%" cellpadding="2">
						<tr>
							<th></th>
							<th>Very Bad</th>
							<th>Bad</th>
							<th>Fair</th>
							<th>Good</th>
							<th>Very Good</th>
						</tr>
						<tr>
							<td>Organisation of the workshop</td>
							<td align="center">
								<input type="radio" class="orgn_wkshop required " value="1" name="orgn_wkshop" id="orgn_wkshop">
							</td>
							<td align="center">
								<input type="radio" class="orgn_wkshop" value="2" name="orgn_wkshop" id="orgn_wkshop">
							</td>
							<td align="center">
								<input type="radio" class="orgn_wkshop" value="3" name="orgn_wkshop" id="orgn_wkshop">
							</td>
							<td align="center">
								<input type="radio" class="orgn_wkshop" value="4" name="orgn_wkshop" id="orgn_wkshop">
							</td>
							<td align="center">
								<input type="radio" class="orgn_wkshop" value="5" name="orgn_wkshop" id="orgn_wkshop">
							</td>
						</tr>
						<tr>
							<td>Ability to facilitate learning</td>
							<td align="center">
								<input type="radio" class="facil_learning required " value="1" name="facil_learning" id="facil_learning">
							</td>
							<td align="center">
								<input type="radio" class="facil_learning" value="2" name="facil_learning" id="facil_learning">
							</td>
							<td align="center">
								<input type="radio" class="facil_learning" value="3" name="facil_learning" id="facil_learning">
							</td>
							<td align="center">
								<input type="radio" class="facil_learning" value="4" name="facil_learning" id="facil_learning">
							</td>
							<td align="center">
								<input type="radio" class="facil_learning" value="5" name="facil_learning" id="facil_learning">
							</td>
						</tr>
						<tr>
							<td>Ability to motivate the learners</td>
							<td align="center">
								<input type="radio" class="motiv_learning required " value="1" name="motiv_learning" id="motiv_learning">
							</td>
							<td align="center">
								<input type="radio" class="motiv_learning" value="2" name="motiv_learning" id="motiv_learning">
							</td>
							<td align="center">
								<input type="radio" class="motiv_learning" value="3" name="motiv_learning" id="motiv_learning">
							</td>
							<td align="center">
								<input type="radio" class="motiv_learning" value="4" name="motiv_learning" id="motiv_learning">
							</td>
							<td align="center">
								<input type="radio" class="motiv_learning" value="5" name="motiv_learning" id="motiv_learning">
							</td>
						</tr>
						<tr>
							<td>Time management</td>
							<td align="center">
								<input type="radio" class="time_mgmt required " value="1" name="time_mgmt" id="time_mgmt">
							</td>
							<td align="center">
								<input type="radio" class="time_mgmt" value="2" name="time_mgmt" id="time_mgmt">
							</td>
							<td align="center">
								<input type="radio" class="time_mgmt" value="3" name="time_mgmt" id="time_mgmt">
							</td>
							<td align="center">
								<input type="radio" class="time_mgmt" value="4" name="time_mgmt" id="time_mgmt">
							</td>
							<td align="center">
								<input type="radio" class="time_mgmt" value="5" name="time_mgmt" id="time_mgmt">
							</td>
						</tr>
					</table>
				</td>
			</tr>
			<tr>
				<td colspan="2">How would you rate the IITB Resource person, in terms of the following?</td>
			</tr>
			<tr>
				<td colspan="2">
					<table align="center" border="1" width="100%" cellpadding="2">
						<tr>
							<th></th>
							<th>Strongly Disagree</th>
							<th>Disagree</th>
							<th>Neutral</th>
							<th>Agree</th>
							<th>Strongly Agree</th>
						</tr>
						<tr>
							<td>Sufficient knowledge about the software</td>
							<td align="center">
								<input type="radio" class="soft_klg required " value="1" name="soft_klg" id="soft_klg">
							</td>
							<td align="center">
								<input type="radio" class="soft_klg" value="2" name="soft_klg" id="soft_klg">
							</td>
							<td align="center">
								<input type="radio" class="soft_klg" value="3" name="soft_klg" id="soft_klg">
							</td>
							<td align="center">
								<input type="radio" class="soft_klg" value="4" name="soft_klg" id="soft_klg">
							</td>
							<td align="center">
								<input type="radio" class="soft_klg" value="5" name="soft_klg" id="soft_klg">
							</td>
						</tr>
						<tr>
							<td>Provided clear explanations</td>
							<td align="center">
								<input type="radio" class="prov_expn required " value="1" name="prov_expn" id="prov_expn">
							</td>
							<td align="center">
								<input type="radio" class="prov_expn" value="2" name="prov_expn" id="prov_expn">
							</td>
							<td align="center">
								<input type="radio" class="prov_expn" value="3" name="prov_expn" id="prov_expn">
							</td>
							<td align="center">
								<input type="radio" class="prov_expn" value="4" name="prov_expn" id="prov_expn">
							</td>
							<td align="center">
								<input type="radio" class="prov_expn" value="5" name="prov_expn" id="prov_expn">
							</td>
						</tr>
						<tr>
							<td>Answered questions clearly</td>
							<td align="center">
								<input type="radio" class="ans_cln required " value="1" name="ans_cln" id="ans_cln">
							</td>
							<td align="center">
								<input type="radio" class="ans_cln" value="2" name="ans_cln" id="ans_cln">
							</td>
							<td align="center">
								<input type="radio" class="ans_cln" value="3" name="ans_cln" id="ans_cln">
							</td>
							<td align="center">
								<input type="radio" class="ans_cln" value="4" name="ans_cln" id="ans_cln">
							</td>
							<td align="center">
								<input type="radio" class="ans_cln" value="5" name="ans_cln" id="ans_cln">
							</td>
						</tr>
						<tr>
							<td>Was interested in helping me learn</td>
							<td align="center">
								<input type="radio" class="help_lern required " value="1" name="help_lern" id="help_lern">
							</td>
							<td align="center">
								<input type="radio" class="help_lern" value="2" name="help_lern" id="help_lern">
							</td>
							<td align="center">
								<input type="radio" class="help_lern" value="3" name="help_lern" id="help_lern">
							</td>
							<td align="center">
								<input type="radio" class="help_lern" value="4" name="help_lern" id="help_lern">
							</td>
							<td align="center">
								<input type="radio" class="help_lern" value="5" name="help_lern" id="help_lern">
							</td>
						</tr>
						<tr>
							<td>Executed the workshop efficiently</td>
							<td align="center">
								<input type="radio" class="exec_effly required " value="1" name="exec_effly" id="exec_effly">
							</td>
							<td align="center">
								<input type="radio" class="exec_effly" value="2" name="exec_effly" id="exec_effly">
							</td>
							<td align="center">
								<input type="radio" class="exec_effly" value="3" name="exec_effly" id="exec_effly">
							</td>
							<td align="center">
								<input type="radio" class="exec_effly" value="4" name="exec_effly" id="exec_effly">
							</td>
							<td align="center">
								<input type="radio" class="exec_effly" value="5" name="exec_effly" id="exec_effly">
							</td>
						</tr>
					</table>
				</td>
			</tr>
			<tr>
				<td colspan="2">How can the workshop be improved ?</td>
			</tr>
			<tr>
				<td colspan="2" align="left">
					<textarea name="ws_improved" id="ws_improved" class="required ws_improved" cols="80" rows="3"></textarea>
				</td>
			</tr>
			<tr>
				<td colspan="2">Would you recommend this workshop, Spoken Tutorial Project and its activities to others?</td>
			</tr>
			<tr>
				<td colspan="2">
					<table align="center" border="1" width="100%">
						<tr>
							<th>Not at all</th>
							<th>Maybe</th>
							<th>Likely</th>
							<th>Quite likely</th>
							<th>Definitely</th>
						</tr>
						<tr>
							<td align="center">
								<input type="radio" class="recomm_wkshop required " value="1" name="recomm_wkshop" id="recomm_wkshop">
							</td>
							<td align="center">
								<input type="radio" class="recomm_wkshop" value="2" name="recomm_wkshop" id="recomm_wkshop">
							</td>
							<td align="center">
								<input type="radio" class="recomm_wkshop" value="3" name="recomm_wkshop" id="recomm_wkshop">
							</td>
							<td align="center">
								<input type="radio" class="recomm_wkshop" value="4" name="recomm_wkshop" id="recomm_wkshop">
							</td>
							<td align="center">
								<input type="radio" class="recomm_wkshop" value="5" name="recomm_wkshop" id="recomm_wkshop">
							</td>
						</tr>
					</table>
				</td>
			</tr>
			<tr>
				<td colspan="">Reason why?</td>
			</tr>
			<tr>
				<td colspan="2">
					<textarea name="reason_why" id="reason_why" class="required reason_why" rows="3" cols="80"></textarea>
				</td>
			</tr>
			 <tr>
                                <td colspan="">Any other comments?</td>
                        </tr>
                        <tr>
                                <td colspan="2">
                                        <textarea name="general_comment" id="general_comment" class="general_comment" rows="3" cols="80"></textarea>
                                </td>
                        </tr>

			<tr>
				<td colspan="2" align="center">
					<input type="submit" value="Submit" />
				</td>
			</tr>
		</table>
	</form>
	<hr />
	<?php
		endif;
		echo $OUTPUT->footer();
	?>
