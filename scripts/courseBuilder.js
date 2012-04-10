function validateCourse() {
	var validated = true;
	
	if($('#courseName').html == null) {
		$('#helpBox').html("Please give the course a name.");
		validated = false;
	}
		
	if(validated) {
		toggleAjaxLoader(1);
	
		var url = "coursebuilder.php";
		$.ajax({url: url, dataType: 'html', 
			data: {
				courseName:$('#courseName').val(),
				courseLocation:$('#courseLocation').val(),
				courseDescription:$('#courseDescription').val()},
			type:'post',
			success: function(data) {
				$('#coursesDisplay').html(data);
				toggleAjaxLoader(0);				
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
		toggleAjaxLoader(1);
	
		var url = "courseAdd.php";
		$.ajax({url: url, dataType: 'html', 
			data: {
				courseID:$('#courseID').val()
			},
			
			type:'post',
			
			success: function(data) {
				$('#coursesDisplay').html(data);
				toggleAjaxLoader(0);
			}
		});
	}
}

function okDelete(courseID) {
	var confirmed = confirm("Are you sure you want to delete this course?");
	
	if(confirmed) {
		toggleAjaxLoader(1);
	
		var url = "courseBuilder.php";
		$.ajax({url: url, dataType: 'html', 
			data: {
				courseID:courseID
			},
			
			type:'post',
			
			success: function(data) {
				$('#coursesDisplay').html(data);
				toggleAjaxLoader(0);
			}
		});
	}
}

function okDisenroll(courseID) {
	var confirmed = confirm("You are disenrolling from the course.");

	if(confirmed) {
		toggleAjaxLoader(1);
	
		var url = "courseAdd.php";
		$.ajax({url: url, dataType: 'html', 
			data: {
				courseID:courseID,
				action:'disenroll'
			},
			
			type:'post',
			
			success: function(data) {
				$('#coursesDisplay').html(data);
				toggleAjaxLoader(0);
			}
		});
	}
}

function okCancelEnroll(courseID) {
	var confirmed = confirm("You are cancelling request.");

	if(confirmed) {
		toggleAjaxLoader(1);
	
		var url = "courseAdd.php";
		$.ajax({url: url, dataType: 'html', 
			data: {
				courseID:courseID,
				action:'cancel'
			},
			
			type:'post',
			
			success: function(data) {
				$('#coursesDisplay').html(data);
				toggleAjaxLoader(0);
			}
		});
	}
}

function permitEnroll(studentID, courseID) {
	toggleAjaxLoader(1);

	var url = "coursebuilder.php";
	$.ajax({url: url, dataType: 'html', 
		data: {
			courseID:courseID,
			permittedStudent:studentID,
		},
		
		type:'post',
		
		success: function(data) {
			$('#enrollMenu').html(data);
			toggleAjaxLoader(0);
		}
	});
}

function denyEnroll(studentID, courseID) {
	toggleAjaxLoader(1);

	var url = "coursebuilder.php";
	$.ajax({url: url, dataType: 'html', 
		data: {
			courseID:courseID,
			deniedStudent:studentID,
		},
		
		type:'post',
		
		success: function(data) {
			$('#enrollMenu').html(data);
			toggleAjaxLoader(0);
		}
	});
}

function disenrollStudent(studentID, courseID) {
	var confirmed = confirm("You are disenrolling from the course.");

	if(confirmed) {
		toggleAjaxLoader(1);
	
		var url = "coursebuilder.php";
		$.ajax({url: url, dataType: 'html', 
			data: {
				courseID:courseID,
				disenrolledStudent:studentID
			},
			
			type:'post',
			
			success: function(data) {
				$('#enrollMenu').html(data);
				toggleAjaxLoader(0);
			}
		});
	}
}