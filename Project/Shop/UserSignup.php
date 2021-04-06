<?php
if (isset($_POST["userid"]) && isset($_POST["password"]) && isset($_POST["email"]) && isset($_POST["addr"]) && isset($_POST["role"])) {
//	if(empty(($_POST["Gender"])){
//		$Gender="NULL";
//	}else{
//		if(empty($_POST["Birthday"])){
//			$Birthday="NULL";
//		}
//		if(empty($_POST["Course"])){
//			$Course="NULL";
//		}
//	}

	$conn = mysqli_connect("localhost", "root", "","onlineshop");
	$sql = $conn->prepare("INSERT INTO `users` (`User_ID`, `Password`, `Email`, `Address`, `Role`, `Gender`, `Birthday`, `Course`) VALUES (?,?,?,?,?,?,?,?)");
	$sql->bind_param("ssssssss",$_POST["userid"],password_hash($_POST["password"],PASSWORD_DEFAULT),$_POST["email"],$_POST["addr"],$_POST["role"],$_POST["gender"],$_POST["birthday"],$_POST["course"]);
	
	$sql->execute();
	
	$conn->close();	
}
?>