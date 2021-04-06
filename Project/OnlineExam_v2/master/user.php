<?php

//user.php

include('header.php');

?>
<br />
<div class="card">
	<div class="card-header">
		<div class="row">
			<div class="col-md-9">
				<h3 class="panel-title">User List</h3>
			</div>
			<div class="col-md-3" align="right">
				<button type="button" id="add_button" class="btn btn-info btn-sm">Add</button>
			</div>
		</div>
	</div>
	<div class="card-body">
		<span id="message_operation"></span>
		<div class="table-responsive">
			<table class="table table-bordered table-striped table-hover" id="user_data_table">
				<thead>
					<tr>
						<th>Profile Image</th>
						<th>Role</th>
						<th>Login ID</th>
						<th>Nick Name</th>
						<th>Email Address</th>
						<th>Gender</th>
						<th>Birthday</th>
						<th>Course No.</th>
						<th>Action</th>
					</tr>
				</thead>
			</table>
		</div>
	</div>
</div>

<div class="modal" id="detailModal">
  	<div class="modal-dialog">
    	<div class="modal-content">

      		<!-- Modal Header -->
      		<div class="modal-header">
        		<h4 class="modal-title">User Details</h4>
        		<button type="button" class="close" data-dismiss="modal">&times;</button>
      		</div>

      		<!-- Modal body -->
      		<div class="modal-body" id="user_details">
        		
      		</div>

      		<!-- Modal footer -->
      		<div class="modal-footer">
        		<button type="button" class="btn btn-danger btn-sm" data-dismiss="modal">Close</button>
      		</div>
    	</div>
  	</div>
</div>

<div class="modal" id="deleteModal">
  	<div class="modal-dialog">
    	<div class="modal-content">

      		<!-- Modal Header -->
      		<div class="modal-header">
        		<h4 class="modal-title">Delete Confirmation</h4>
        		<button type="button" class="close" data-dismiss="modal">&times;</button>
      		</div>

      		<!-- Modal body -->
      		<div class="modal-body">
        		<h3 align="center">Are you sure you want to remove this?</h3>
      		</div>

      		<!-- Modal footer -->
      		<div class="modal-footer">
      			<button type="button" name="ok_button" id="ok_button" class="btn btn-primary btn-sm">OK</button>
        		<button type="button" class="btn btn-danger btn-sm" data-dismiss="modal">Close</button>
      		</div>
    	</div>
  	</div>
</div>

<div class="modal" id="formModal">
  	<div class="modal-dialog modal-lg">
    	<form method="post" id="user_form">
      		<div class="modal-content">
      			<!-- Modal Header -->
        		<div class="modal-header">
          			<h4 class="modal-title" id="modal_title"></h4>
          			<button type="button" class="close" data-dismiss="modal">&times;</button>
        		</div>

        		<!-- Modal body -->
        		<div class="modal-body" id="user_add">
          			<div class="form-group">
            
              			<label>Select Role <span class="text-danger">*</span></label>
						<select name="user_role" id="user_role" class="form-control" onchange="checkRole(this.value)">
							<option value="">---Select---</option>
							<option value="Student">Student</option>
							<option value="Teacher">Teacher</option>
						</select>
           
          			</div>
          			<div class="form-group">
            			<div class="row">
              				<label class="col-md-4 text-right">Enter Login ID <span class="text-danger">*</span></label>
	              			<div class="col-md-8">
	                			<input type="text" name="user_login_id" id="user_login_id" class="form-control" />
	                		</div>
            			</div>
          			</div>
          			<div class="form-group">
            			<div class="row">
              				<label class="col-md-4 text-right">Enter Password <span class="text-danger">*</span></label>
	              			<div class="col-md-8">
								<input type="password" name="user_password" id="user_password" class="form-control" />
	                		</div>
            			</div>
          			</div>
          			<div class="form-group">
            			<div class="row">
              				<label class="col-md-4 text-right">Enter Confirm Password <span class="text-danger">*</span></label>
	              			<div class="col-md-8">
	                			<input type="password" name="confirm_user_password" id="confirm_user_password" class="form-control" />
	                		</div>
            			</div>
          			</div>
          			<div class="form-group">
            			<div class="row">
              				<label class="col-md-4 text-right">Enter Nick Name <span class="text-danger">*</span></label>
	              			<div class="col-md-8">
	                			<input type="text" name="user_name" id="user_name" class="form-control" />
	                		</div>
            			</div>
          			</div>
          			<div class="form-group">
            			<div class="row">
              				<label class="col-md-4 text-right">Enter Email Address <span class="text-danger">*</span></label>
	              			<div class="col-md-8">
								<input type="text" name="user_email_address" id="user_email_address" class="form-control"  />
	                		</div>
            			</div>
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
					</div>
					<div class="form-group" align="center">
						<input type="hidden" name='page' value='register' />
						<input type="hidden" name="action" value="register" />
						<input type="submit" name="user_register" id="user_register" class="btn btn-info" value="Register" />
					</div>
	
	        	<!-- Modal footer -->
	        	<div class="modal-footer">
	        		<input type="hidden" name="online_exam_id" id="online_exam_id" />

	        		<input type="hidden" name="page" value="exam" />

	        		<input type="hidden" name="action" id="action" value="Add" />

	        		<input type="submit" name="button_action" id="button_action" class="btn btn-success btn-sm" value="Add" />

	          		<button type="button" class="btn btn-danger btn-sm" data-dismiss="modal">Close</button>
	        	</div>
        	</div>
    	</form>
  	</div>
</div>

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
	
	var dataTable = $('#user_data_table').DataTable({
		"processing" : true,
		"serverSide" : true,
		"order" : [],
		"ajax" : {
			url:"ajax_action.php",
			type:"POST",
			data:{action:'fetch', page:'user'}
		},
		"columnDefs":[
			{
				"targets":[0,6],
				"orderable":false,
			},
		],
	});

	$(document).on('click', '.details', function(){
		var user_id = $(this).attr('id');
		$.ajax({
	      	url:"ajax_action.php",
	      	method:"POST",
	      	data:{action:'fetch_data', user_id:user_id, page:'user'},
	      	success:function(data)
	      	{
	        	$('#user_details').html(data);
	        	$('#detailModal').modal('show');
	      	}
	    });
	});


	$('#user_register').click(function(){
		var user_role = document.getElementById('user_role').value;
		var user_login_id = document.getElementById('user_login_id').value;
		var user_password = document.getElementById('user_password').value;
		var confirm_user_password = document.getElementById('confirm_user_password').value;
		var user_name = document.getElementById('user_name').value;
		var user_email_address = document.getElementById('user_email_address').value;
	if (user_role == 'Student'){
		var user_gender = document.getElementById('user_gender').value;
		var user_birthday = document.getElementById('user_birthday').value;
				$.ajax({
			url:"ajax_action.php",
			method:"POST",
			data:{action:'register', page:'user', user_role:user_role, user_login_id:user_login_id, user_password:user_password, confirm_user_password:confirm_user_password, user_name:user_name, user_email_address:user_email_address, user_gender:user_gender, user_birthday:user_birthday},
			dataType:"json",
			success:function(data)
			{
	        	$('#user_add').html(data);
	        	$('#formModal').modal('show');
			}
		})
	}else{
		var user_course_no = document.getElementById('user_course_no').value;
			$.ajax({
			url:"ajax_action.php",
			method:"POST",
			data:{action:'register', page:'user', user_role:user_role, user_login_id:user_login_id, user_password:user_password, confirm_user_password:confirm_user_password, user_name:user_name, user_email_address:user_email_address, user_image:user_image, user_course_no:user_course_no},
			dataType:"json",
			success:function(data)
			{
	        	$('#user_add').html(data);
	        	$('#formModal').modal('show');
			}
		})
	}

	});

	function reset_form()
	{
		$('#modal_title').text('Add User Details');
		$('#button_action').val('Add');
		$('#action').val('Add');
		$('#user_form')[0].reset();
		$('#user_form').parsley().reset();
	}

	$('#add_button').click(function(){
		reset_form();
		$('#formModal').modal('show');
		$('#message_operation').html('');
	});

	var date = new Date();

	date.setDate(date.getDate());

	$('#online_exam_datetime').datetimepicker({
		startDate :date,
		format: 'yyyy-mm-dd hh:ii',
		autoclose:true
	});
	
	document.getElementById("user_gender").disabled = true;
	document.getElementById("user_birthday").disabled = true;
	document.getElementById("user_course_no").disabled = true;

	window.ParsleyValidator.addValidator('checkemail', {
		validateString: function(value){
			return $.ajax({
			url:'ajax_action.php',
			method:'post',
			data:{page:'user', action:'check_email', email:value},
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
				url:'ajax_action.php',
				method:'post',
				data:{page:'user', action:'check_loginid', loginid:value},
				dataType:"json",
				async: false,
				success:function(data)
				{
					return true;
				}
		});
    }
  });
  
	$('#user_form').parsley();

	$('#user_form').on('submit', function(event){
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

		var user_role = document.getElementById('user_role').value;
		var user_login_id = document.getElementById('user_login_id').value;
		var user_password = document.getElementById('user_password').value;
		var confirm_user_password = document.getElementById('confirm_user_password').value;
		var user_name = document.getElementById('user_name').value;
		var user_email_address = document.getElementById('user_email_address').value;
	if (user_role == 'Student'){
		var user_gender = document.getElementById('user_gender').value;
		var user_birthday = document.getElementById('user_birthday').value;
	}else{
		var user_course_no = document.getElementById('user_course_no').value;
	}

    if($('#user_form').parsley().validate())
    {
      $.ajax({
        url:'ajax_action.php',
        method:"POST",
        data:{page:'user', action:'register', user_role:user_role, user_login_id:user_login_id, user_password:user_password, confirm_user_password:confirm_user_password, user_name:user_name, user_email_address:user_email_address, user_gender:user_gender, user_birthday:user_birthday, user_course_no:user_course_no},
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
           // $('#message').html('<div class="alert alert-success">Please check your email</div>');
            $('#user_form')[0].reset();
            $('#user_form').parsley().reset();
          }

          $('#user_register').attr('disabled', false);

          $('#user_register').val('Register');
        }
      })
    }
	});
	
	var user_id = '';

	$(document).on('click', '.edit', function(){
		user_id = $(this).attr('id');

		reset_form();

		$.ajax({
			url:"ajax_action.php",
			method:"POST",
			data:{action:'edit_fetch', user_id:user_id, page:'user'},
			dataType:"json",
			success:function(data)
			{
				$('#user_role').val(data.user_role);

				$('#user_login_id').val(data.user_login_id);

				$('#user_password').val(data.user_password);

				$('#total_question').val(data.total_question);

				$('#user_name').val(data.user_name);

				$('#user_email_address').val(data.user_email_address);

				$('#user_gender').val(user_gender);

				$('#user_birthday').val(user_birthday);

				$('#user_id').val(user_id);

				$('#modal_title').text('Edit User Details');

				$('#button_action').val('Edit');

				$('#action').val('Edit');

				$('#formModal').modal('show');
			}
		})
	});
	
	$(document).on('click', '.delete', function(){
		user_id = $(this).attr('id');
		$('#deleteModal').modal('show');
	});

	$('#ok_button').click(function(){
		$.ajax({
			url:"ajax_action.php",
			method:"POST",
			data:{user_id:user_id, action:'delete', page:'user'},
			dataType:"json",
			success:function(data)
			{
				$('#message_operation').html('<div class="alert alert-success">'+data.success+'</div>');
				$('#deleteModal').modal('hide');
				dataTable.ajax.reload();
			}
		})
	});
	
});



</script>

