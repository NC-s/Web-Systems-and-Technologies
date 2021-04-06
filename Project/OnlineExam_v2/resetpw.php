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
			<div class="col-md-3" style="margin-top:50px;">
			<div class="card">
        		<div class="card-header"><h4>Reset Password</h4></div>
        		<div class="card-body">
        			   <span id="message"></span>
                <form method="post" id="reset_password_form">

				  <div class="form-group">
                    <label>Login ID</label>
                    <input type="text" name="user_login_id" id="user_login_id" placeholder="Enter Current Login ID" class="form-control" data-parsley-checkloginid data-parsley-checkloginid-message='Login ID already Exists' />
                  </div>
				  
                  <div class="form-group">
                    <label>Password</label>
                    <input type="password" name="user_password" id="user_password" placeholder="Enter New Password" class="form-control" />
                  </div>
                  <div class="form-group">
                    <label>Confirm Password</label>
                    <input type="password" name="confirm_user_password" id="confirm_user_password" placeholder="Confirm New Password" class="form-control" />
                  </div>
                  <div class="form-group" align="center">
                    <input type="hidden" name='page' value='reset_password' />
                    <input type="hidden" name="action" value="reset_password" />
                    <input type="submit" name="user_register" id="user_register" class="btn btn-info" value="Reset" />
                  </div>
                </form>
          			<div>
						<small class="form-text text-secondary text-center"><a href="login.php">Back To Login</a>
          			</div>
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
	
$(document).ready(function(){

  
  window.ParsleyValidator.addValidator('checkloginid', {
    validateString: function(value){
      return $.ajax({
        url:'user_ajax_action.php',
        method:'post',
        data:{page:'reset_password', action:'check_loginid', loginid:value},
        dataType:"json",
        async: false,
        success:function(data)
        {
          return true;
        }
      });
    }
  });
  
  
  $('#reset_password_form').parsley();

  $('#reset_password_form').on('submit', function(event){
    event.preventDefault();
	
	$('#user_login_id').attr('required', 'required');

    $('#user_password').attr('required', 'required');

    $('#confirm_user_password').attr('required', 'required');

    $('#confirm_user_password').attr('data-parsley-equalto', '#user_password');

    if($('#reset_password_form').parsley().validate())
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
			$('#message').html('<div class="alert alert-success">Reset Success!</div>');
            $('#reset_password_form')[0].reset();
            $('#reset_password_form').parsley().reset();
          }

          $('#user_register').attr('disabled', false);

          $('#user_register').val('Reset');
        }
      })
    }

  });
	
});

</script>