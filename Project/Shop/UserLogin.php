<?php
session_start();
function randStr(){
	for ($s = '', $i = 0, $z = strlen($a = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789')-1; $i <= 20; $x = rand(0,$z), $s .= $a{$x}, $i++);
	return $s;
}

if (isset($_POST["userid"]) && isset($_POST["password"])) {
	$conn = mysqli_connect("localhost", "root", "","onlineshop");
	$checkUserID = $conn->prepare("SELECT User_ID FROM users WHERE User_ID = ?;");
	$checkUserID->bind_param("s",$_POST["userid"]);
	
	$checkPassword = $conn->prepare("SELECT Password FROM users WHERE User_ID = ?;");
	$checkPassword->bind_param("s",$_POST["userid"]);
	
	$createToken = $conn->prepare("INSERT INTO `remembermetoken` (`Token`, `UserID`, `LoginTime`) VALUES (?, ?, NOW());");
	$token = randStr().strval(time());
	$createToken->bind_param("ss", password_hash($token,PASSWORD_DEFAULT), $_POST["userid"]);
	
		if ($conn->connect_error)  {
			die("Connection failed: " . $conn->connect_error);
		}
		$checkUserID->execute();
		$result = $checkUserID->get_result();
		if ($result->num_rows == 0){
			$_SESSION["LoginFailed"] += 1;
			echo "Incorrect";
		}
		else{
			$checkPassword->execute();
			$result = $checkPassword->get_result();
			if ($result->num_rows == 0){
				
			}else{
			$row = $result->fetch_assoc();
			if (password_verify($_POST["password"],$row["Password"])) {
				$_SESSION['userid'] = $_POST['userid'];
				unset($_SESSION["LoginFailed"]);
				if (isset($_POST["rememberme"])) {
					if ($_POST["rememberme"]){
						$createToken->execute();
						setcookie("Token", $token, time() + (86400 * 30), "/");
					}
				}
			}else{
				$_SESSION["LoginFailed"] += 1;
				echo "Incorrect";
			}			
			}
		}
		
		$conn->close();	
}
?>