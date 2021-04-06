<?php
	session_start();
	//Check if token exist and valid
	if (isset($_COOKIE["Token"])){
		$conn = mysqli_connect("localhost", "root", "","onlineshop");
		$compareToken = $conn->prepare("SELECT UserID, Token FROM remembermetoken;");
		$compareToken->execute();
		$checkToken= $compareToken->get_result();
		
		if ($checkToken->num_rows == 0){
			
		}else{
			while ($row = $checkToken->fetch_assoc()){
				if (password_verify($_COOKIE["Token"], $row["Token"])){
					$_SESSION["userid"] = $row["UserID"];
				}
			}
		}
	}
?>
<!DOCTYPE html>
<html>
<head>
 <title>My Page || Online Store</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <link rel="stylesheet" href="css/bootstrap.min.css">
  <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
  <link rel="stylesheet" href="css/material-components-web.css">
  <link rel="stylesheet" type="text/css" href="css/style.css">
  <script src="script/jquery-3.4.1.min.js"></script>
  <script src="script/popper.min.js"></script>
  <script src="script/bootstrap.min.js"></script>
  <style type="text/css">
	.shop {
		margin-left: -13px;
	}
	
 	@media screen and (max-width: 768px) {
		label:empty {
			display: none;
		}
	}
	
  </style>
</head>
<body>
<?php
	{
		//The Navbar after login
		echo
		"<nav class='navbar navbar-expand-md navbar-light fixed-top bg-light'>
			<button class='navbar-toggler mdc-icon-button material-icons ml-1' type='button' data-toggle='collapse' data-target='#dropdownSearch' aria-controls='dropdownSearch' aria-expanded='false' aria-label='Toggle search bar'>search</button>
			<a class='navbar-brand' href='MainPage.php'>Online Store</a>
			<div class='d-flex order-md-1 ml-auto'>
				<ul class='navbar-nav'>	
					<li class='nav-item dropdown'>			
						<a class='nav-link dropdown-toggle d-flex align-items-center' href='#' id='UserMenu' data-toggle='dropdown' aria-haspopup='true' aria-expanded='false'><i class='material-icons'>person</i></a>
						<div class='dropdown-menu dropdown-menu-right' aria-labelledby='UserMenu'>
							<a class='dropdown-item d-flex align-items-center' href='PersonalInfo.php'><i class='material-icons mr-2'>assignment_ind</i>My Page</a>					
							<div class='dropdown-divider'></div>			
						</div>
					</li>
				</ul>
			</div>
			<div class='collapse navbar-collapse' id='dropdownSearch'>
				<form class='w-100' method='get' action='MainPage.php'>
					<div class='input-group w-100'>
						<input type='search' placeholder='Search...' class='form-control border border-right-0' name='search'>
						<span class='input-group-append'>
						  <button type='submit' class='btn btn-outline-secondary material-icons border border-left-0'>search</button>
						</span>
					</div>
				</form>					
			</div>
		</nav>";
	}
	
	$conn = mysqli_connect("localhost", "root", "","onlineshop");
	if ($conn->connect_error)  {
		die("Connection failed: " . $conn->connect_error);
	}

?>

<div class="container-fluid">

	<div class="jumbotron text-center">
		<h1>Welcome! </h1>
	</div>
  
  
  <div class="container">

		<ul class='nav nav-tabs' role='tablist' id='tab'>
			<li class='nav-item'>
				<a class='nav-link active' data-toggle='tab' href='#General' role='tab' aria-selected='true'>General Information</a>
			</li>
		</ul>

		<div class='tab-content'>
		
			<div class='tab-pane fade show active' id='General' role='tabpanel'>
				<div class="row mb-3">
					<div class="col"><hr></div>
					<div class="col-inline"><small class="text-muted">Personal Information</small></div>
					<div class="col"><hr></div>
				</div>
			
				<form id='personalInfo'>
						
					<div class="form-group row">
						<label for="userID" class="col-md-3 col-form-label"></label>
						<div class="col">
							<input type="text" readonly class="form-control-plaintext">
						</div>
						<input type="button" class="btn btn-outline-primary mr-3" id="changePasswordRequest" value="Change Password">
					</div>
					
					<div class="form-group row" id="UserID" style="display:none;">
						<label for="inputUserID" class="col-md-3 col-form-label">UserID</label>
						<div class="col">
							<input type="text" class="form-control" name="userID" id="inputUserID" placeholder="Current UserID">
							<small class="form-text text-muted">Input UserID to perform any changes</small>
						</div>
					</div>

					<div class="form-group row" id="password" style="display:none;">
						<label for="inputPassword" class="col-md-3 col-form-label">Password</label>
						<div class="col">
							<input type="password" class="form-control" name="password" id="inputPassword" placeholder="Current password">
							<small class="form-text text-muted">Input password to perform any changes</small>
						</div>
					</div>
					<div id="changePassword" style="display:none;">
						<div class="form-group row">
							<label for="inputNewPassword" class="col-md-3 col-form-label">New Password</label>
							<div class="col">
								<input type="password" class="form-control" name="newPassword" maxlength="20" id="inputNewPassword">
								<small class="form-text text-muted" id="PasswordHint">Your password must be 8-20 characters long.</small>
						</div></div>
						<div class="form-group row">
							<label for="inputConfirmPassword" class="col-md-3 col-form-label">Confirm New Password</label>
							<div class="col">
								<input type="password" class="form-control" name="confirmPassword" maxlength="20" id="inputConfirmPassword" disabled>
								<small class="form-text text-muted" id="ConfirmPasswordHint"></small>
						</div></div>
					</div>
					
				</form>
				
				<div class="row my-3">
					<div class="col"><hr></div>
					<div class="col-inline"><small class="text-muted">Shop Information</small></div>
					<div class="col"><hr></div>
				</div>
			</div>

			<div class='tab-pane fade' id='Purchased' role='tabpanel'>
			</div>
			</div>	  
	</div>

<div class="alert alert-success">
  Your password has been reseted.
</div>


<script>
	$(document).ready(function() {
		
		$('textarea').each(function () {
			$(this).css({				
				'height': 'auto',
				'overflow-y': 'hidden'
			})
		}).on('input', function () {
			this.style.height = 'auto';
			this.style.height = (this.scrollHeight) + 'px';
		});
		
		$("#changePasswordRequest").click(function() {
			if ($("#changePasswordRequest").val() != "Save") {	
				$("#UserID").slideDown();
				$("#password").slideDown();
				$("#changePassword").slideDown();
				$("#changePasswordRequest").val("Save");	
			}
			else {
				updateInfo();
			}
		});
		
		$("input").not("[type=search]").blur(function() {
			if ($(this).val() == "") {
				$(this).addClass("invalid");
				$(this).next("small").removeClass("text-muted");
				$(this).next("small").text("This field should not be blank!");
			}
		});
		
		$("input").not("[type=search]").keyup(function(e) {
			if (e.keyCode == 8) {
				if ($(this).val() == "") {
					$(this).addClass("invalid");
					$(this).next("small").removeClass("text-muted");
					$(this).next("small").text("This field should not be blank!");
				};
				if ($(this).is("#inputNewPassword")) {					
					if ($(this).val() != "") {
						if ($("#inputNewPassword").val().length < 8) {
							$("#PasswordHint").removeClass("text-muted");
							$("#PasswordHint").text("Your password must be 8-20 characters long.");
							$("#inputNewPassword").addClass("invalid");
						}
					}
				};
			}
			else {
				$(this).next("small").text("");
				
				if ($("#inputPassword").val() != "") {
					$("#inputPassword").next("small").addClass("text-muted");
					$("#inputPassword").removeClass("invalid");
					$("#inputPassword").next("small").text("Input password to perform any changes");
				};
				if ($("#inputNewPassword").val().length >= 8) {
					$('#inputConfirmPassword').prop('disabled', false);
					$('#inputNewPassword').removeClass("invalid");
					$("#PasswordHint").addClass("text-muted");
					$("#PasswordHint").text("");
				}
				else {
					$("#PasswordHint").text("Your password must be 8-20 characters long.");
				};
				if ($("#inputConfirmPassword").val() == $("#inputNewPassword").val()) {
					$("#inputConfirmPassword").removeClass("invalid");
					$("#ConfirmPasswordHint").addClass("text-muted");
					$("#ConfirmPasswordHint").text("");
				};
				if ($(this).is("#inputAddress"))
					$(this).removeClass("invalid");
			}
		});
		
		$("#inputConfirmPassword").change(function() {
			if ($(this).val() != $("#inputNewPassword").val()) {
				$("#ConfirmPasswordHint").removeClass("text-muted");
				$("#ConfirmPasswordHint").text("Those password didn't match. Try again.");
				$("#inputConfirmPassword").addClass("invalid");
			}
		});
		
		function updateInfo() {
			var valid = 1;
			$("input").not("[type=search]").each(function() {
				if ($(this).hasClass("invalid"))
					valid = 0;
			});
				
			$.post( "updatePw.php", {
				info: $("#personalInfo").serialize()
			},
			function(data) {
				if (data.indexOf("Success") != -1) {						
					$("#password").hide();
					$("#inputPassword").val("");
					$("#changePassword").hide();
					$("#inputNewPassword").val("");
					$("#inputConfirmPassword").val("");
					$("input:text:visible").prop("readonly", true);
					$("input:text:visible").addClass("form-control-plaintext");
					$("input:text:visible").removeClass("form-control");
					$("input:button").val("Edit");
					$("#changePasswordRequest").val("Change Password");
					$(".alert").fadeIn();
					setTimeout(function() {
						$(".alert").fadeOut();
					}, 3500);
				}
				else {
					$("#inputPassword").addClass("invalid");
					$("#inputPassword").next("small").removeClass("text-muted");
					$("#inputPassword").next("small").text("Your password is incorrect.");
				}
			});	
		}	
		
	});
</script>

</body>
</html>