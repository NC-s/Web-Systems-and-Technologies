<?php

if (isset($_POST["userid"]) && isset($_POST["itemid"]) && isset($_POST["qty"])) {
	$conn = mysqli_connect("localhost", "root", "","onlineshop");
		if ($conn->connect_error)  {
			die("Connection failed: " . $conn->connect_error);
		}
		$itemid = $_POST["itemid"];
		$qty = $_POST["qty"];
		for ($i = 0; $i < count($itemid); $i++) {
			// $query = "INSERT INTO `productinorder` (`Order_No`, `QTY`, `Order_Date`, `Item_ID`, `Buyer`) VALUES (NULL, '".$qty[$i]."', CURRENT_DATE(), '".$itemid[$i]."', '".$_POST["userid"]."')";
			// $conn->query($query);
			// $query = "DELETE FROM `cart` WHERE Item_ID = " . $itemid[$i] . " AND User = '" . $_POST["userid"] . "'";
			// $conn->query($query);
			// $query = "UPDATE `product` SET `Stock` = `Stock` - ".$qty[$i]." WHERE `product`.`Product_ID` = " . $itemid[$i];
			// $conn->query($query);
			$query = $conn->prepare("INSERT INTO `productinorder` (`Order_No`, `QTY`, `Order_Date`, `Item_ID`, `Buyer`) VALUES (NULL, ?, CURRENT_DATE(), ?, ?)");
			$query->bind_param("iis",$qty[$i],$itemid[$i],$_POST["userid"]);
			$query->execute();
			
			$query = $conn->prepare("DELETE FROM `cart` WHERE Item_ID = ? AND User = ?");
			$query->bind_param("is",$itemid[$i],$_POST["userid"]);
			$query->execute();
			
			$query = $conn->prepare("UPDATE `product` SET `Stock` = `Stock` - ? WHERE `product`.`Product_ID` = ?");
			$query->bind_param("ii", $qty[$i], $itemid[$i]);
			$query->execute();
		}
		echo "Success!";		
		$conn->close();	
}
?>