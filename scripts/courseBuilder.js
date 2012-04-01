function validateCourse() {
	var validated = true;
	
	if($('#courseName').html == null) {
		$('#helpBox').html("Please give the course a name.");
		validated = false;
	}
		
	if(validated) {
		var url = "coursebuilder.php";
		$.ajax({url: url, dataType: 'html', 
			data: {
				courseName:$('#courseName').val(),
				courseLocation:$('#courseLocation').val(),
				courseDescription:$('#courseDescription').val()},
			type:'post',
			success: function(data) {
				$('#helpBox').html(data);
			}
		});
	}
}

function validateEnrollment() {
	var validated = true;
	
	if($('#courseID').html == null) {
		$('#helpBox').html("Please enter a course ID.");
		validated = false;
	}
		
	if(validated) {
		var url = "courseAdd.php";
		$.ajax({url: url, dataType: 'html', 
			data: {
				courseName:$('#courseID').val()
			},
			
			type:'post',
			
			success: function(data) {
				$('#helpBox').html(data);
			}
		});
	}
}