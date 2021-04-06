<?php
session_start();
if (isset($_POST["itemid"]) && isset($_POST["qty"])) {
	$conn = mysqli_connect("localhost", "root", "","onlineshop");
	if ($conn->connect_error)  {
		die("Connection failed: " . $conn->connect_error);
	}
	/*$nameQuery = $conn->prepare("SELECT `Name` FROM `product` WHERE Product_ID = ?;");
	$nameQuery->bind_param("i", $_POST["itemid"]);
	
	$nameQuery->execute();
	$productName = $nameQuery->get_result();
	while($nameRow=$productName->fetch_assoc()){
		$name = $nameRow["Name"];
	}*/
		
	if (isset($_SESSION["userid"])){
		
		$query = $conn->prepare("SELECT Item_ID, User FROM `cart` WHERE Item_ID = ? AND User = ?;");
		$query->bind_param("is", $_POST["itemid"], $_SESSION["userid"]);
		
		
		$query->execute();
        $result = $query->get_result();
		$sql = $conn->prepare("UPDATE `cart` SET `QTY` = ? WHERE `Item_ID` = ? AND `User` = ?");		
		$sql->bind_param("iis",$_POST["qty"],$_POST["itemid"],$_SESSION["userid"]);
		$sql->execute();		
        $conn->close();
        	
	}else{
		if (isset($_SESSION["Cart"])){
			$_SESSION["Cart"][$_POST["itemid"]] = array("QTY" => $_POST["qty"]);
		}else{
			$_SESSION["Cart"][$_POST["itemid"]] = array("QTY" => $_POST["qty"]);
		}
	}
}
?>