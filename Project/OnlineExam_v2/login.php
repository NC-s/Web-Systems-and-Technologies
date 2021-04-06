<?php

//login.php

include('master/Examination.php');

$exam = new Examination;

$exam->user_session_public();

include('header.php');

if (isset ($_COOKIE["user_login_id"])){
	setcookie("user_login_id",$_COOKIE['user_login_id'],time()-(3600));
}

?>
  <div class="container">

      <div class="row">
        <div class="col-md-3">

        </div>
        <div class="col-md-6" style="margin-top:100px;">
        
            <div class="card">
              <div class="card-header">User Login</div>
              <div class="card-body">
                <form method="post" id="user_login_form">
                  <div class="form-group">
                    <label>Login ID</label>
                      <input type="text" name="user_login_id" id="user_login_id" placeholder="Enter Login ID" class="form-control" />
                    </div>
                  <div class="form-group">
                    <label>Password</label>
                    <input type="password" name="user_password" id="user_password" placeholder="Enter Password" class="form-control" />
                  </div>
                  <div class="form-group" align="center">
                    <input type="hidden" name="page" value="login" />
                    <input type="hidden" name="action" value="login" />
                    <input type="submit" name="user_login" id="user_login" class="btn btn-info" value="Login" />
                  </div>
                </form>
				<div>
				  <small class="form-text text-secondary text-center">Forget Password? <a href="resetpw.php">Reset Password</a>
                </div>
                <div>
				  <small class="form-text text-secondary text-center">Don't Have An Account? <a href="register.php">Student/Teacher Register</a>
				</div>
				<div align="center">
				  <small class="form-text text-secondary text-center">Want To Grade The Exam? <a href="master/index.php">Teacher Evaluates System</a>
                </div>
              </div>
            </div>
        </div>
        <div class="col-md-3">

        </div>
      </div>
  </div>

</body>
</html>

<script>

$(document).ready(function(){

  $('#user_login_form').parsley();

  $('#user_login_form').on('submit', function(event){
    event.preventDefault();

    $('#user_login_id').attr('required', 'required');

    $('#user_password').attr('required', 'required');

    if($('#user_login_form').parsley().validate())
    {
      $.ajax({
        url:"user_ajax_action.php",
        method:"POST",
        data:$(this).serialize(),
        dataType:"json",
        beforeSend:function()
        {
          $('#user_login').attr('disabled', 'disabled');
          $('#user_login').val('please wait...');
        },
        success:function(data)
        {
          if(data.success)
          {
            location.href='index.php';
			<?php
			setcookie("user_login_id",$_POST['user_login_id'],time()+(60*60*24));
			?>
          }
          else
          {
            $('#message').html('<div class="alert alert-danger">'+data.error+'</div>');
          }

          $('#user_login').attr('disabled', false);

          $('#user_login').val('Login');
        }
      })
    }

  });

});

</script>