<?php

if (isset($_POST["userid"]) && isset($_POST["itemid"])) {
	$conn = mysqli_connect("localhost", "root", "","onlineshop");
		if ($conn->connect_error)  {
			die("Connection failed: " . $conn->connect_error);
		}
		
		// $query = "SELECT Item_ID, User FROM `favorite` WHERE Item_ID = " . $_POST["itemid"] . " AND User = '" . $_POST["userid"] . "'";
		// $result = $conn->query($query);
		$query = $conn->prepare("SELECT Item_ID, User FROM `favorite` WHERE Item_ID = ? AND User = ?");
		$query->bind_param("is",$_POST["itemid"],$_POST["userid"]);
		$query->execute();
		$result = $query->get_result();
		
		if ($result->num_rows == 0) {
			$sql = $conn->prepare("INSERT INTO `favorite` (`ID`, `Item_ID`, `User`) VALUES (NULL, ?, ?)");		
			$sql->bind_param("is",$_POST["itemid"],$_POST["userid"]);
			$sql->execute();
			echo "favorite";
		}
		else {
			$sql = $conn->prepare("DELETE FROM `favorite` WHERE Item_ID = ? AND User = ?");
			$sql->bind_param("is",$_POST["itemid"],$_POST["userid"]);
			$sql->execute();
			echo "favorite_border";
		}
		
		$conn->close();	
}
?>