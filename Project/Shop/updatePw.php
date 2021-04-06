<?php
	if (isset($_POST["info"])) {
		$info = array();
		parse_str($_POST["info"], $info);
		
		$userID = $info["userID"];
		$pw = $info["password"];
		$new = $info["newPassword"];
		$newConfirm = $info["confirmPassword"];
		
		if ($pw=='') 
			echo "You shoule enter your password to perform any changes";
		else {
			$conn = mysqli_connect("localhost", "root", "","online_examination");
			if ($conn->connect_error)  {
				die("Connection failed: " . $conn->connect_error);
			}
			$query = $conn->prepare("SELECT * FROM `users` WHERE user_login_id = ?");
			$query->bind_param("s", $userID);
			$query->execute();
			$result = $query->get_result();
			
			
			while($row=$result->fetch_assoc()){
				$curPassword = $row["Password"];
				$curEmail = $row["Email"];
			}
			if (!password_verify($pw,$curPassword))
				echo "Incorrect password!";
			else {
				if ($new != '') 
					if ($newConfirm != '') 
						if ($new == $newConfirm) {
							$sql = $conn->prepare("UPDATE `users` SET `user_password` = ? WHERE `users`.user_login_id = ?");
							$sql->bind_param("ss", password_hash($new,PASSWORD_DEFAULT), $userID);
							$sql->execute();
							echo "Success";
						}
						else echo "The confirm password is not the same as new password";
					else echo "Please confirm your new password";
			}
		}					
	}
?>