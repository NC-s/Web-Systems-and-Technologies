<?php

	if (isset($_POST["userid"]) && isset($_POST["shopname"]) && isset($_POST["shopinfo"])) {
		$conn = mysqli_connect("localhost", "root", "","onlineshop");
		if ($conn->connect_error)  {
			die("Connection failed: " . $conn->connect_error);
		}
		
		$query = $conn->prepare("INSERT INTO `shops` (`Shop_ID`,`Title`, `Info`, `Owner_ID`) VALUES(NULL, ?, ?, ?)");
		$query->bind_param("sss",$_POST["shopname"],$_POST["shopinfo"],$_POST["userid"]);
		$query->execute();
		
		echo "Success!";
		$conn->close();	
	}
?>