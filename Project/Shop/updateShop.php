<?php

if (isset($_POST["shopid"]) && isset($_POST["shopname"]) && isset($_POST["shopinfo"])) {
	$conn = mysqli_connect("localhost", "root", "","onlineshop");
		if ($conn->connect_error)  {
			die("Connection failed: " . $conn->connect_error);
		}
		
		$query = $conn->prepare("SELECT Title, Info FROM `shops` WHERE Shop_ID = ?");
		$query->bind_param("i",$_POST["shopid"]);
		$query->execute();
		$result = $query->get_result();
		
		while($row=$result->fetch_assoc()){
			$curShopName = $row["Title"];
			$curShopInfo = $row["Info"];
		}
		if ($_POST["shopname"] != $curShopName) {
			$sql = $conn->prepare("UPDATE `shops` SET `Title` = ? WHERE Shop_ID = ?");
			$sql->bind_param("si",$_POST["shopname"],$_POST["shopid"]);
			$sql->execute();
			
			echo "Name Success!";
		}
		if ($_POST["shopinfo"] != $curShopInfo) {
			$sql = $conn->prepare("UPDATE `shops` SET `Info` = ? WHERE Shop_ID = ?");
			$sql->bind_param("si",$_POST["shopinfo"],$_POST["shopid"]);
			$sql->execute();	
			
			echo $_POST["shopid"].": Info: ".$_POST["shopinfo"]." Success!";
		}		
		$conn->close();	
}
?>