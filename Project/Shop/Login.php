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
	if (!isset($_SESSION["LoginFailed"])){
		$_SESSION["LoginFailed"] = 0;
	}
?>
<!DOCTYPE html>
<html>
<head>
 <title>Login || Online Store</title>
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
	.form-row {
		margin-top: -18px;
		margin-bottom: 4px;
	}
	.alert {
		position: initial;
		width: 100%;
		bottom: initial;
		left: initial;
		display: block;
	}
  </style>
  <?php
	if (isset($_SESSION["userid"])) {
		echo '<meta http-equiv="Refresh" content="5; url=MainPage.php" />';
	}
  ?>
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
		<h1>Welcome! <?php if (isset($_SESSION["userid"])) echo $_SESSION["userid"];?></h1>
	</div>
  
	<div class="container">
		<?php 
		if (isset($_SESSION["LoginFailed"])){ 
			if ($_SESSION["LoginFailed"] > 0 && $_SESSION["LoginFailed"] < 5 && !isset($_COOKIE["DisableLogin"])){ 
				echo "<div class='alert alert-danger'>";
				echo "Incorrect User ID or Password. Attempts left: ".(5-$_SESSION["LoginFailed"]);
				echo "</div>";
			}else if ($_SESSION["LoginFailed"] >= 5){
				echo "<div class='alert alert-danger'>";
				echo "Too many attempts. Please try again later.";
				echo "</div>";
				setcookie("DisableLogin", "SET", time()+180, "/");
			}
		}
		if (isset($_COOKIE["DisableLogin"])){
			echo "<div class='alert alert-danger'>";
			echo "Too many attempts. Please try again later.";
			echo "</div>";
		}
		?>
		<form <?php if (isset($_SESSION["userid"])) echo "style='display:none;'";?>>
		  <div class="form-group">
			<label for="UserID">User ID</label>
			<input type="text" class="form-control" id="UserID" placeholder="Enter User ID">
		  </div>
		  <div class="form-group">
			<label for="Password">Password</label>
			<input type="password" class="form-control" id="Password" placeholder="Password">
		  </div>
		<label id="LoginError"><font color="red">
		
		</font></label>
		  <div class="form-row">
			<div class="col">
				<div class="form-group form-check">
					<input type="checkbox" class="form-check-input" id="RememberMe">
					<label class="form-check-label" for="RememberMe">Keep me signed in</label>
				</div>
			</div>	
		  </div>	  
		  <button type="submit" class="btn btn-primary btn-block" id="UserLogin">Login</button>
		  <hr>
		  <small class="form-text text-secondary text-center">Don't have an account? <a href="Signup.php">Sign up</a>
		  <small class="form-text text-secondary text-center">Forget password? <a href="Resetpw.php">Reset password</a>
		</form>	
		
	</div>

</div>

<?php
	
	if (isset($_SESSION["userid"])) {
		echo "<h1>You have logged in successfully</h1><br>";
		echo "You will be redirected to our homepage in 5 seconds, Click <a href='MainPage.php'>here</a> to get started now.";
		
	}
?>
</small>
</div>



<script>
	$(document).ready(function() {
		<?php 
			if (isset($_SESSION["LoginFailed"])){ 
				if ($_SESSION["LoginFailed"] >= 5 || isset($_COOKIE["DisableLogin"])){
					echo '$("#UserLogin").attr("class", "btn btn-secondary btn-block");';
					echo '$("#UserLogin").attr("disabled", true);';
					$_SESSION["LoginFailed"] = 0;
				}
			}
		?>
		$("#UserLogin").click(function() {
			$.post( "UserLogin.php", {
				userid: $("#UserID").val(),
				password: $('#Password').val(),
				rememberme: $('#RememberMe').prop('checked')
			});
		});
		

		
	});	
</script>

</body>
</html>