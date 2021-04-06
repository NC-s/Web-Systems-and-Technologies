<?php
	if (isset($_POST["info"])) {
		$info = array();
		parse_str($_POST["info"], $info);
		
		$userID = $info["userID"];
		$pw = $info["password"];
		$new = $info["newPassword"];
		$newConfirm = $info["confirmPassword"];
		$email = $info["email"];
		$address = $info["address"];
		
		if ($pw=='') 
			echo "You shoule enter your password to perform any changes";
		else {
			$conn = mysqli_connect("localhost", "root", "","onlineshop");
			if ($conn->connect_error)  {
				die("Connection failed: " . $conn->connect_error);
			}
			$query = $conn->prepare("SELECT * FROM `users` WHERE User_ID = ?");
			$query->bind_param("s", $userID);
			$query->execute();
			$result = $query->get_result();
			
			
			while($row=$result->fetch_assoc()){
				$curPassword = $row["Password"];
				$curEmail = $row["Email"];
				$curAddress = $row["Address"];
			}
			if (!password_verify($pw,$curPassword))
				echo "Incorrect password!";
			else {
				if ($new != '') 
					if ($newConfirm != '') 
						if ($new == $newConfirm) {
							$sql = $conn->prepare("UPDATE `users` SET `Password` = ? WHERE `users`.User_ID = ?");
							$sql->bind_param("ss", password_hash($new,PASSWORD_DEFAULT), $userID);
							$sql->execute();
							echo "Success";
						}
						else echo "The confirm password is not the same as new password";
					else echo "Please confirm your new password";
				if ($email != $curEmail) {
					$sql = $conn->prepare("UPDATE `users` SET `Email` = ? WHERE User_ID = ?");
					$sql->bind_param("ss", $email, $userID);
					$sql->execute();
					echo "Success";
				}
				if ($address != $curAddress) {
					$sql = $conn->prepare("UPDATE `users` SET `Address` = ? WHERE User_ID = ?");
					$sql->bind_param("ss",$address,$userID);
					$sql->execute();
					echo "Success";
				}
			}
		}					
	}
?>