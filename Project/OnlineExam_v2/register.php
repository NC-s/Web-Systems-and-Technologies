<?php

//register.php

include('master/Examination.php');

$exam = new Examination;

$exam->user_session_public();

include('header.php');

?>

	<div class="containter">
		<div class="d-flex justify-content-center">
			<br /><br />
			<div class="card" style="margin-top:50px;margin-bottom: 100px;">
        		<div class="card-header"><h4>User Registration</h4></div>
        		<div class="card-body">
        			   <span id="message"></span>
                <form method="post" id="user_register_form">
				
				  <div class="form-group">
                    <label>Select Role</label>
                    <select name="user_role" id="user_role" class="form-control" onchange="checkRole(this.value)">
					  <option value="">---Select---</option>
                      <option value="Student">Student</option>
                      <option value="Teacher">Teacher</option>
					</select> 
				  </div>
				  <div class="form-group">
                    <label>Enter Login ID</label>
                    <input type="text" name="user_login_id" id="user_login_id" class="form-control" data-parsley-checkloginid data-parsley-checkloginid-message='Login ID already Exists' />
                  </div>
				  
                  <div class="form-group">
                    <label>Enter Password</label>
                    <input type="password" name="user_password" id="user_password" class="form-control" />
                  </div>
                  <div class="form-group">
                    <label>Enter Confirm Password</label>
                    <input type="password" name="confirm_user_password" id="confirm_user_password" class="form-control" />
                  </div>
                  <div class="form-group">
                    <label>Enter Nick Name</label>
                    <input type="text" name="user_name" id="user_name" class="form-control" /> 
                  </div>
				  <div class="form-group">
                    <label>Enter Email Address</label>
                    <input type="text" name="user_email_address" id="user_email_address" class="form-control" data-parsley-checkemail data-parsley-checkemail-message='Email Address already Exists' />
                  </div>
				  
				  <div class="form-group">
                    <label>Select Profile Image</label>
                    <input type="file" name="user_image" id="user_image" />
                  </div>
                  <div class="form-group">
				  
                  <label>Select Gender</label>
                    <select name="user_gender" id="user_gender" class="form-control">
					  <option value="">---Select---</option>
                      <option value="Male">Male</option>
                      <option value="Female">Female</option>
                  </select> 
                  </div>
                  <div class="form-group">
                    <label>Select Birthday</label>
                    <input type="date" name="user_birthday" id="user_birthday" class="form-control">
                  </div>
				  
                  <div class="form-group">
                    <label>Enter Course Number</label>
                    <input type="text" name="user_course_no" id="user_course_no" class="form-control" /> 
                  </div>
                  <br />
                  <div class="form-group" align="center">
                    <input type="hidden" name='page' value='register' />
                    <input type="hidden" name="action" value="register" />
                    <input type="submit" name="user_register" id="user_register" class="btn btn-info" value="Register" />
                  </div>
                </form>
          			<div align="center">
          				<small class="form-text text-secondary text-center"><a href="login.php">Back To Login</a>
          			</div>
        		</div>
      		</div>
      		<br /><br />
      		<br /><br />
		</div>
	</div>

</body>

</html>

<script>
function checkRole(user_role){
		if (user_role != "Teacher" && user_role != "Student"){
			document.getElementById("user_gender").disabled = true;
			document.getElementById("user_birthday").disabled = true;
			document.getElementById("user_course_no").disabled = true;
			
			document.getElementById("RoleErr").innerHTML = "<font color='red'>Please select a valid role. E.g. Teacher/Student</font>";
			document.getElementById("user_role").classList.add("invalid");
			return false;
		}else{
			
			if (user_role == "Student"){
			document.getElementById("user_gender").disabled = false;
			document.getElementById("user_birthday").disabled = false;
			document.getElementById("user_course_no").disabled = true;
			
			document.getElementById("RoleErr").innerHTML = "";
			document.getElementById("user_role").classList.remove("invalid");
			return true;
			}
		}
			if (user_role == "Teacher"){
			document.getElementById("user_gender").disabled = true;
			document.getElementById("user_birthday").disabled = true;
			document.getElementById("user_course_no").disabled = false;
			
			document.getElementById("RoleErr").innerHTML = "";
			document.getElementById("user_role").classList.remove("invalid");
			return true;
			}
		
	}
	
$(document).ready(function(){

  document.getElementById("user_gender").disabled = true;
  document.getElementById("user_birthday").disabled = true;
  document.getElementById("user_course_no").disabled = true;

  window.ParsleyValidator.addValidator('checkemail', {
    validateString: function(value){
      return $.ajax({
        url:'user_ajax_action.php',
        method:'post',
        data:{page:'register', action:'check_email', email:value},
        dataType:"json",
        async: false,
        success:function(data)
        {
          return true;
        }
      });
    }
  });
  
  window.ParsleyValidator.addValidator('checkloginid', {
    validateString: function(value){
      return $.ajax({
        url:'user_ajax_action.php',
        method:'post',
        data:{page:'register', action:'check_loginid', loginid:value},
        dataType:"json",
        async: false,
        success:function(data)
        {
          return true;
        }
      });
    }
  });
  
  
  $('#user_register_form').parsley();

  $('#user_register_form').on('submit', function(event){
    event.preventDefault();
	
	$('#user_login_id').attr('required', 'required');

    $('#user_password').attr('required', 'required');

    $('#confirm_user_password').attr('required', 'required');

    $('#confirm_user_password').attr('data-parsley-equalto', '#user_password');

    $('#user_name').attr('required', 'required');

    $('#user_name').attr('data-parsley-pattern', '^[a-zA-Z ]+$');
	
	$('#user_email_address').attr('required', 'required');

    $('#user_email_address').attr('data-parsley-type', 'email');

    $('#user_image').attr('required', 'required');

    $('#user_image').attr('accept', 'image/*');

	
	if(($('#user_role'))=='Student')
	{
	$('#user_gender').attr('required', 'required');
	$('#user_birthday').attr('required', 'required');
	$('#user_course_no').attr('required', 'required');
	}
	
	//Teacher
    //$('#user_course_no').attr('required', 'required');

    $('#user_course_no').attr('data-parsley-pattern', '^[A-Za-z0-9_]+$');

    if($('#user_register_form').parsley().validate())
    {
      $.ajax({
        url:'user_ajax_action.php',
        method:"POST",
        data:new FormData(this),
        dataType:"json",
        contentType:false,
        cache:false,
        processData:false,
        beforeSend:function()
        {
          $('#user_register').attr('disabled', 'disabled');
          $('#user_register').val('please wait...');
        },
        success:function(data)
        {
          if(data.success)
          {
			$('#message').html('<div class="alert alert-success">Register Success!</div>');
            $('#user_register_form')[0].reset();
            $('#user_register_form').parsley().reset();
          }

          $('#user_register').attr('disabled', false);

          $('#user_register').val('Register');
        }
      })
    }

  });
	
});

</script>