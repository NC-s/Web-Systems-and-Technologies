<?php
	if (isset($_POST["orderno"])) {
		$conn = mysqli_connect("localhost", "root", "","onlineshop");
		if ($conn->connect_error)  {
			die("Connection failed: " . $conn->connect_error);
		}
		
		$sql = $conn->prepare("UPDATE `productinorder` SET `Finished` = '1' WHERE Order_No = ?");
		$sql->bind_param("i",$_POST["orderno"]);
		$sql->execute();
		
		echo "Success!";
	}
?>