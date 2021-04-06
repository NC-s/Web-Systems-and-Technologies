<?php
if (isset($_GET["userid"])) {
	$conn = mysqli_connect("localhost", "root", "","onlineshop");
	$checkUserID = $conn->prepare("SELECT User_ID FROM users WHERE User_ID = ?;");
	$checkUserID->bind_param("s",$_GET["userid"]);
	$checkUserID->execute();
	
	$result = $checkUserID->get_result();
	if (!($result->num_rows == 0)){
		echo "<font color='red'>User ID already exists. Please enter a different User ID.</font>";
	}
	$conn->close();	
}
?>