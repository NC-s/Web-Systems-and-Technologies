<?php
session_start();
if (isset($_POST["itemid"])) {
	if (isset($_SESSION["userid"])){
		$conn = mysqli_connect("localhost", "root", "","onlineshop");
		if ($conn->connect_error)  {
			die("Connection failed: " . $conn->connect_error);
		}
		
		$sql = $conn->prepare("DELETE FROM `cart` WHERE Item_ID = ? AND User = ?");
		$sql->bind_param("is",$_POST["itemid"],$_POST["userid"]);
		$sql->execute();
		
		echo "Success!";
		$conn->close();	
	}else{
		if (isset($_SESSION["Cart"])){
			if (array_key_exists($_POST["itemid"],$_SESSION["Cart"])) {
				unset($_SESSION["Cart"][$_POST["itemid"]]);
				echo "Success!";
			}
		}
	}
}
?>