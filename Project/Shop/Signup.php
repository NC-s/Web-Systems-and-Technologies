<!DOCTYPE html>
<html>
<head>
 <title>Signup || Online Store</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <link rel="stylesheet" href="css/bootstrap.min.css">
  <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
  <link rel="stylesheet" href="css/material-components-web.css">
  <link rel="stylesheet" type="text/css" href="css/style.css">
  <script src="script/jquery-3.4.1.min.js"></script>
  <script src="script/popper.min.js"></script>
  <script src="script/bootstrap.min.js"></script>
</head>
<body>

<nav class='navbar navbar-expand navbar-light fixed-top bg-light'>
	<a class='navbar-brand ml-md-1' href='MainPage.php'>Online Store</a>

	<form class='w-100' method='get' action='MainPage.php'>
		<div class='input-group w-100'>
			<input type='search' placeholder='Search...' class='form-control border border-right-0' name='search'>
			<span class='input-group-append'>
			  <button type='submit' class='btn btn-outline-secondary material-icons border border-left-0'>search</button>
			</span>
		</div>
	</form>
</nav>

<div class="container-fluid">

	<div class="jumbotron text-center">
		<h1>Welcome!</h1>
	</div>
  
	<div class="container">
	
		<form>
		  <div class="form-group">
			<label for="UserID">User ID</label>
			<input type="text" class="form-control" id="UserID" maxlength="20" onchange="checkUsername(this.value)">
			<small id="NameErr"></small>
		  </div>
		  <div class="form-group">
			<label for="Password">Password</label>
			<input type="password" class="form-control" id="Password" maxlength="20" onkeyup="checkpassword(this.value)">
			<small class="form-text text-muted" id="PasswordHint">Your password must be 8-20 characters long.</small>
		  </div>
		  <div class="form-group">
			<label for="ConfirmPassword">Confirm Password</label>
			<input type="password" class="form-control" id="ConfirmPassword" maxlength="20" onkeyup="checkconfirmpassword(this.value)">
			<small id="confirmpasswordErr"></small>
		  </div>
		  <div class="form-group">
			<label for="Email">Contact E-mail address</label>
			<input type="email" class="form-control" id="Email" onchange="checkEmail(this.value)">
			<small id="EmailErr"></small>
		  </div>
		  <div class="form-group">
			<label for="Address">Address</label>
			<input type="text" class="form-control" id="Address" onchange="checkAddress(this.value)">
			<small id="AddressErr"></small>
		  </div>
		  
		  <div class="form-group">
			<label for="Role">Role</label>
			<select id="Role" class="form-control" id="Role" onchange="checkRole(this.value)">
			<option value="Select">---Select---</option>
			<option value="Student">Student</option>
			<option value="Teacher">Teacher</option>
			</select>
			<small id="RoleErr"></small>
		  </div>
		  
		  <div class="form-group">
			<label for="Gender">Gender</label>
			<select id="Gender" class="form-control" id="Gender" onchange="checkGender(this.value)">
			<option value="N.A.">---Select---</option>
			<option value="Male">Male</option>
			<option value="Female">Female</option>
			</select>
			<small id="GenderErr"></small>
		  </div>
		  <div class="form-group">
			<label for="Birthday">Birthday</label>
			<input type="date" class="form-control" id="Birthday">
		  </div>
		  <div class="form-group">
			<label for="Course">Course</label>
			<input type="text" class="form-control" id="Course" onchange="checkCourse(this.value)">
		  </div>
		  
		  <button type="button" class="btn btn-primary btn-block" id="UserSignup">Submit</button>
		  <hr>
		  <small class="form-text text-secondary text-center">Have an account? <a href="Login.php">Login</a>
		</form>	
		
	</div>

</div>

<script>
	function checkUsername(name){
		var xhttp; 
		xhttp = new XMLHttpRequest();
		xhttp.onreadystatechange = function() {
			if (this.readyState == 4 && this.status == 200) {
				document.getElementById("NameErr").innerHTML = this.responseText;
				if (this.responseText != "")
					document.getElementById("UserID").classList.add("invalid");
				else document.getElementById("UserID").classList.remove("invalid");
			}
		};
		xhttp.open("GET", "checkUserID.php?userid="+name, true);
		xhttp.send();
	}
	function checkpassword(pw){
		if (pw.length == 0){
			document.getElementById("PasswordHint").innerHTML = "<font color='red'>Please enter your password</font>";
			document.getElementById("Password").classList.add("invalid");
			document.getElementById("ConfirmPassword").disabled = true;
			document.getElementById("confirmpasswordErr").innerHTML = "";
			return false;
		}else{
			if (pw.length < 8){
				document.getElementById("PasswordHint").innerHTML = "<font color='red'>Your password is too short.</font>";
				document.getElementById("Password").classList.add("invalid");
				document.getElementById("ConfirmPassword").disabled = true;
				document.getElementById("confirmpasswordErr").innerHTML = "";
				return false;
			}
		}
		if (pw.length >= 8){
			document.getElementById("Password").classList.remove("invalid");
			document.getElementById("PasswordHint").innerHTML = "";
			document.getElementById("ConfirmPassword").disabled = false;
			return true;
		}
	}
	function checkconfirmpassword(retype){
		var pw = document.getElementById("Password").value;
		if (retype == pw){
			document.getElementById("ConfirmPassword").classList.remove("invalid");
			document.getElementById("confirmpasswordErr").innerHTML = "";
			return true;
		}else{
			document.getElementById("ConfirmPassword").classList.add("invalid");
			document.getElementById("confirmpasswordErr").innerHTML = "<font color='red'>Those password didn't match. Try again.</font>";
			return false;
		}
	}
	function checkEmail(EAddress){
		var re = /^(([^<>()[\]\\.,;:\s@\"]+(\.[^<>()[\]\\.,;:\s@\"]+)*)|(\".+\"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
		if(!EAddress.match(re)){
			document.getElementById("Email").classList.add("invalid");
			document.getElementById("EmailErr").innerHTML = "<font color='red'>Please enter a valid email address</font>";
			return false;
		}else{
			document.getElementById("Email").classList.remove("invalid");
			document.getElementById("EmailErr").innerHTML = "";
			return true;
		}
	}

	function checkAddress(Address){
		if (Address.length <= 0){
			document.getElementById("AddressErr").innerHTML = "<font color='red'>Please enter your address</font>";
			document.getElementById("Address").classList.add("invalid");
			return false;
		}else{
			document.getElementById("AddressErr").innerHTML = "";
			document.getElementById("Address").classList.remove("invalid");
			return true;
		}
	}
	
	function checkRole(Role){
		if (Role != "Teacher" && Role != "Student"){
			document.getElementById("Gender").disabled = true;
			document.getElementById("Birthday").disabled = true;
			document.getElementById("Course").disabled = true;
			
			document.getElementById("RoleErr").innerHTML = "<font color='red'>Please select a valid role. E.g. Teacher/Student</font>";
			document.getElementById("Role").classList.add("invalid");
			return false;
		}else{
			
			if (Role == "Student"){
			document.getElementById("Gender").disabled = false;
			document.getElementById("Birthday").disabled = false;
			document.getElementById("Course").disabled = true;
			
			document.getElementById("RoleErr").innerHTML = "";
			document.getElementById("Role").classList.remove("invalid");
			return true;
			}
		}
			if (Role == "Teacher"){
			document.getElementById("Gender").disabled = true;
			document.getElementById("Birthday").disabled = true;
			document.getElementById("Course").disabled = false;
			
			document.getElementById("RoleErr").innerHTML = "";
			document.getElementById("Role").classList.remove("invalid");
			return true;
			}
		
	}
	
		function checkGender(Gender){
		if (Gender != "Male" && Gender != "Female"){
			document.getElementById("GenderErr").innerHTML = "<font color='red'>Please select a valid gender. E.g. Male/Female</font>";
			document.getElementById("Gender").classList.add("invalid");
			return false;
		}else{
			document.getElementById("GenderErr").innerHTML = "";
			document.getElementById("Gender").classList.remove("invalid");
			return true;
		}
		
	}
	
		function checkCourse(Course){
		if (Course == ""){
			document.getElementById("Course").innerHTML = "N.A.";
		}
		// Need Fix
		
	}
	
	/*function inputvalid(){
		
	}*/
		
	$(document).ready(function() {
		checkCourse(Course);
		document.getElementById("ConfirmPassword").disabled = true;	
		document.getElementById("Gender").disabled = true;
		document.getElementById("Birthday").disabled = true;
		document.getElementById("Course").disabled = true;
		document.getElementById("UserSignup").disabled = true;	
		
		$("input").not("[name='search']").keyup(function () {
			$valid = 1;
			
			if ($valid == 1) {
				checkUsername($("#UserID").val());
				setTimeout(function() {
					if ($("#NameErr").text() == "" &&
						checkpassword($("#Password").val()) && 
						checkconfirmpassword($("#ConfirmPassword").val()) && 
						checkEmail($("#Email").val()) &&
						checkAddress($("#Address").val()) &&
						checkRole($("#Role").val()))
					$('#UserSignup').prop('disabled', false);
					else $('#UserSignup').prop('disabled', true);
				}, 100);
			} else $('#UserSignup').prop('disabled', true);
		});
		
		$("#UserSignup").click(function () {
			if ($("#NameErr").text() == "" &&
			checkpassword($("#Password").val()) && 
			checkconfirmpassword($("#ConfirmPassword").val()) && 
			checkEmail($("#Email").val()) &&
			checkAddress($("#Address").val()) &&
			checkRole($("#Role").val()))
			$.post ( "UserSignup.php", {
				userid: $("#UserID").val(),
				password: $("#Password").val(),
				email: $("#Email").val(),
				addr: $("#Address").val(),
				role: $("#Role").val(),
				gender: $("#Gender").val(),
				birthday: $("#Birthday").val(),
				course: $("#Course").val()
			},
			function(data) {
				window.location.replace("MainPage.php");
			});
		});
	});	
</script>

</body>
</html>