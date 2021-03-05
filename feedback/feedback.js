$(document).ready(function() {
		webroot = "http://onlinetest.spoken-tutorial.org/feedback/";
		$('#academic_code').blur(function() {
			var val = $(this).val();
			var this_data = $(this);
			$.ajax({
				type : 'POST',
				url : webroot + "institution.php",
				data : {
					'academic_code' : val
				},
				success : function(data) {
					output = JSON.parse(data);
					console.log(output);
					if (output) {
						this_data.next().remove();
						$('.errorcustom').remove();
						$('#cinstitutionname').val(output.institution_name);
						$('#ccity').val(output.city);
					} else {
						if (!this_data.next().next().is('label')) {
							this_data.parent().append('<br><label for="tes" generated="true" class=" error errorcustom" style="">Academic code not found.</label>');
						}
						$('#cinstitutionname').val('');
						$('#ccity').val('');
						this_data.focus();
					}
				}
			});
		});

		$('#cusername').blur(function() {
			var val = $(this).val();
			var this_data = $(this);
			$.ajax({
				type : 'POST',
				url : webroot + "validate_username.php",
				data : {
					'username' : val
				},
				success : function(data) {
					output = JSON.parse(data);
					console.log(output);
					if (output) {
						if (!this_data.next().next().is('label')) {
							this_data.parent().append('<br><label for="tes" generated="true" class=" error errorcustom" style="">User name already exists.</label>');
						}
						this_data.focus();
					} else {
						this_data.next().remove();
						$('.errorcustom').remove();
					}
				}
			});
		});
		$("#commentForm").validate();

	});
