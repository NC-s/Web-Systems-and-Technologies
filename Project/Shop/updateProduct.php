<?php
	$conn = mysqli_connect("localhost", "root", "","onlineshop");
	if ($conn->connect_error)  {
		die("Connection failed: " . $conn->connect_error);
	}
			
	if (isset($_POST["itemid"])) {
		if ($_POST["itemid"] != "0") {			
			$query = $conn->prepare("SELECT * FROM `product` WHERE Product_ID = ?");
			$query->bind_param("i",$_POST["itemid"]);
			$query->execute();
			$result = $query->get_result();
			while($row=$result->fetch_assoc()) {
				$curName = $row["Name"];
				$curInfo = $row["Description"];
				$curStock = $row["Stock"];
				$curPrice = $row["Price"];
				$curCat = $row["Category"];
			}
			if ($_POST["ProdName"] != $curName) {
				$sql = $conn->prepare("UPDATE `product` SET `Name` = ? WHERE Product_ID = ?");
				$sql->bind_param("si", $_POST["ProdName"], $_POST["itemid"]);
				$sql->execute();
			}
			if ($_POST["ProdInfo"] != $curInfo) {
				$sql = $conn->prepare("UPDATE `product` SET `Description` = ? WHERE Product_ID = ?");
				$sql->bind_param("si", $_POST["ProdInfo"], $_POST["itemid"]);
				$sql->execute();
			}
			if ($_POST["Price"] != $curPrice) {
				$sql = $conn->prepare("UPDATE `product` SET `Price` = ? WHERE Product_ID = ?");
				$sql->bind_param("sd", $_POST["Price"], $_POST["itemid"]);
				$sql->execute();
			}
			if ($_POST["Stock"] != $curStock) {
				$sql = $conn->prepare("UPDATE `product` SET `Stock` = ? WHERE Product_ID = ?");
				$sql->bind_param("si", $_POST["Stock"], $_POST["itemid"]);
				$sql->execute();
			}
			if ($_POST["Category"] != $curCat) {
				$sql = $conn->prepare("UPDATE `product` SET `Category` = ? WHERE Product_ID = ?");
				$sql->bind_param("si", $_POST["Category"], $_POST["itemid"]);
				$sql->execute();		
			}
			
			if (!empty($_FILES["imgUpload"]["name"])) {
				$target_dir = "images/";
				$target_file = $target_dir . basename($_FILES["imgUpload"]["name"]);
				$imageFileType = pathinfo($target_file,PATHINFO_EXTENSION);
				
				if (!file_exists($target_dir)) {
					mkdir($target_dir, 0777, true);
				}

				move_uploaded_file($_FILES["imgUpload"]["tmp_name"], $target_dir.$_POST["itemid"].".".$imageFileType);
				$Path = $_POST["itemid"].".".$imageFileType;
				$sql = $conn->prepare("UPDATE `product` SET `Image_Path` = ? WHERE Product_ID = ?");
				$sql->bind_param("si", $Path, $_POST["itemid"]);
				$sql->execute();	
				echo "Image editted";
			}
			
		}
		else {
			$query = "SELECT MAX(Product_ID) FROM `product`";
			$result = $conn->query($query);
			$row=$result->fetch_assoc();
			$new = $row["MAX(Product_ID)"] + 1;
			
			if (!empty($_FILES["imgUpload"]["name"])) {
				$target_dir = "images/";
				$target_file = $target_dir . basename($_FILES["imgUpload"]["name"]);
				$imageFileType = pathinfo($target_file,PATHINFO_EXTENSION);

				if (!file_exists($target_dir)) {
					mkdir($target_dir, 0777, true);
				}
				move_uploaded_file($_FILES["imgUpload"]["tmp_name"], $target_dir.$new.".".$imageFileType);
			}			

			// $sql = "INSERT INTO `product` (`Product_ID`, `Name`, `Description`, `Image_Path`, `Stock`, `Price`, `Category`, `Shop`)
					// VALUES ('".$new."', '".$_POST["ProdName"]."', '".$_POST["ProdInfo"]."', '".$new.".".$imageFileType."', '".$_POST["Stock"]."', '".$_POST["Price"]."', '".$_POST["Category"]."', '".$_POST["shopid"]."')";
			// $conn->query($sql);
			$sql = $conn->prepare("INSERT INTO `product` (`Product_ID`, `Name`, `Description`, `Image_Path`, `Stock`, `Price`, `Category`, `Shop`)
					VALUES (?,?,?,?,?,?,?,?)");
			$Path = $new.".".$imageFileType;
			$sql->bind_param("isssidsi",$new,$_POST["ProdName"],$_POST["ProdInfo"],$Path,$_POST["Stock"],$_POST["Price"],$_POST["Category"],$_POST["shopid"]);
			$sql->execute();
			echo "Create Success!";
		}
	}
				
			
				
		
?>