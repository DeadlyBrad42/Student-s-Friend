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
				$('#coursesDisplay').html(data);
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
				courseID:$('#courseID').val()
			},
			
			type:'post',
			
			success: function(data) {
				$('#coursesDisplay').html(data);
			}
		});
	}
}

function okDelete(courseID) {
	var confirmed = confirm("Are you sure you want to delete this course?");
	
	if(confirmed) {
		var url = "courseBuilder.php";
		$.ajax({url: url, dataType: 'html', 
			data: {
				courseID:courseID
			},
			
			type:'post',
			
			success: function(data) {
				$('#coursesDisplay').html(data);
			}
		});
	}
}

function okDisenroll(courseID) {
	var confirmed = confirm("You are disenrolling from the course.");

	if(confirmed) {
		var url = "courseAdd.php";
		$.ajax({url: url, dataType: 'html', 
			data: {
				courseID:courseID,
				action:'disenroll'
			},
			
			type:'post',
			
			success: function(data) {
				$('#coursesDisplay').html(data);
			}
		});
	}
}

function okCancelEnroll(courseID) {
	var confirmed = confirm("You are cancelling request.");

	if(confirmed) {
		var url = "courseAdd.php";
		$.ajax({url: url, dataType: 'html', 
			data: {
				courseID:courseID,
				action:'cancel'
			},
			
			type:'post',
			
			success: function(data) {
				$('#coursesDisplay').html(data);
			}
		});
	}
}

function permitEnroll(studentID, courseID) {
	var url = "coursebuilder.php";
	$.ajax({url: url, dataType: 'html', 
		data: {
			courseID:courseID,
			permittedStudent:studentID,
		},
		
		type:'post',
		
		success: function(data) {
			$('#enrollMenu').html(data);
		}
	});
}

function denyEnroll(studentID, courseID) {
	var url = "coursebuilder.php";
	$.ajax({url: url, dataType: 'html', 
		data: {
			courseID:courseID,
			deniedStudent:studentID,
		},
		
		type:'post',
		
		success: function(data) {
			$('#enrollMenu').html(data);
		}
	});
}

function disenrollStudent(studentID, courseID) {
	var confirmed = confirm("You are disenrolling from the course.");

	if(confirmed) {
		var url = "coursebuilder.php";
		$.ajax({url: url, dataType: 'html', 
			data: {
				courseID:courseID,
				disenrolledStudent:studentID
			},
			
			type:'post',
			
			success: function(data) {
				$('#enrollMenu').html(data);
			}
		});
	}
}