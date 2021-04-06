<?php
	session_start();
	//Check if token exist and valid
	if (isset($_COOKIE["Token"])){
		$conn = mysqli_connect("localhost", "root", "","onlineshop");
		$compareToken = $conn->prepare("SELECT UserID, Token FROM remembermetoken;");
		$compareToken->execute();
		$checkToken= $compareToken->get_result();
		
		if ($checkToken->num_rows == 0){
			
		}else{
			while ($row = $checkToken->fetch_assoc()){
				if (password_verify($_COOKIE["Token"], $row["Token"])){
					$_SESSION["userid"] = $row["UserID"];
				}
			}
		}
	}
?>
<!DOCTYPE html>
<html>
<head>
 <title>Favourite || Online Store</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <link rel="stylesheet" href="css/bootstrap.min.css">
  <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
  <link rel="stylesheet" href="css/material-components-web.css">
  <link rel="stylesheet" type="text/css" href="css/style.css">
  <script src="script/jquery-3.4.1.min.js"></script>
  <script src="script/popper.min.js"></script>
  <script src="script/bootstrap.min.js"></script>
  <script src="script/ProductDisplay.js"></script>
</head>

<body>
<?php
	if (!isset($_SESSION["userid"])){
		header("location:Login.php");
        die;
	}
	else {
		//The Navbar after login
		echo
		"<nav class='navbar navbar-expand-md navbar-light fixed-top bg-light'>
			<button class='navbar-toggler mdc-icon-button material-icons ml-1' type='button' data-toggle='collapse' data-target='#dropdownSearch' aria-controls='dropdownSearch' aria-expanded='false' aria-label='Toggle search bar'>search</button>
			<a class='navbar-brand' href='MainPage.php'>Online Store</a>
			<div class='d-flex order-md-1 ml-auto'>
				<ul class='navbar-nav'>	
					<li class='nav-item dropdown'>			
						<a class='nav-link dropdown-toggle d-flex align-items-center' href='#' id='UserMenu' data-toggle='dropdown' aria-haspopup='true' aria-expanded='false'><i class='material-icons'>person</i>".$_SESSION["userid"]."</a>
						<div class='dropdown-menu dropdown-menu-right' aria-labelledby='UserMenu'>
							<a class='dropdown-item d-flex align-items-center' href='PersonalInfo.php'><i class='material-icons mr-2'>assignment_ind</i>My Page</a>					
							<a class='dropdown-item d-flex align-items-center active' href='Favourite.php'><i class='material-icons mr-2'>favorite</i>Favourite List</a>					
							<a class='dropdown-item d-flex align-items-center' href='Cart.php'><i class='material-icons mr-2'>shopping_cart</i>Shopping Cart</a>
							<div class='dropdown-divider'></div>
							<a class='dropdown-item d-flex align-items-end' href='Logout.php'><i class='material-icons mr-2'>exit_to_app</i>Logout</a>					
						</div>
					</li>
				</ul>
			</div>
			<div class='collapse navbar-collapse' id='dropdownSearch'>
				<form class='w-100' method='get' action='MainPage.php'>
					<div class='input-group w-100'>
						<input type='search' placeholder='Search...' class='form-control border border-right-0' name='search'>
						<span class='input-group-append'>
						  <button type='submit' class='btn btn-outline-secondary material-icons border border-left-0'>search</button>
						</span>
					</div>
				</form>					
			</div>
		</nav>";
	}
?>
<div class="container-fluid">

	<div class="jumbotron text-center">
		<h1>Favourite</h1>
	</div>  
  
 
	
	<?php
		$conn = mysqli_connect("localhost", "root", "","onlineshop");
		if ($conn->connect_error)  {
			die("Connection failed: " . $conn->connect_error);
		}
		// $query = "SELECT `product`.*, `shops`.Title FROM `favorite` INNER JOIN `product` INNER JOIN `shops` ON `product`.`Shop`=`shops`.`Shop_ID` ON `favorite`.`Item_ID` = `product`.`Product_ID` WHERE `favorite`.User = '".$_SESSION["userid"]."'";
		// $result = $conn->query($query);
		
		$query = $conn->prepare("SELECT `product`.*, `shops`.Title FROM `favorite` INNER JOIN `product` INNER JOIN `shops` ON `product`.`Shop`=`shops`.`Shop_ID` ON `favorite`.`Item_ID` = `product`.`Product_ID` WHERE `favorite`.User = ?");
		$query->bind_param("s",$_SESSION["userid"]);
		$query->execute();
		$result=$query->get_result();
		
		if ($result->num_rows == 0) {
			echo "<p class='text-center'>There is no item in your favourite list yet!</p>";
		}
		else {
			echo
			"<div class='row'>
			<div class='col-sm-3 col-md-2'>
				<div class='row ml-2 sticky-top' style='top: 75px;'>";
			
			$query = $conn->prepare("SELECT Category, COUNT(*) FROM `favorite` INNER JOIN `product` INNER JOIN `shops` ON `product`.`Shop`=`shops`.`Shop_ID` ON `favorite`.`Item_ID` = `product`.`Product_ID` WHERE `favorite`.User = ? GROUP BY Category");			
			$query->bind_param("s",$_SESSION["userid"]);
			$query->execute();
			$result = $query->get_result();
			
			while($row=$result->fetch_assoc()){
				echo
				"<div class='col-4 col-sm-12 mb-3'><a href='Favourite.php?category=" . $row["Category"] . "'>" . $row["Category"] . " (" . $row["COUNT(*)"] .")</a></div>";
			}
			
			echo
				"</div>
			</div>
    
			<div class='col'>		  
				<div class='row'>";		
					
			if (empty($_GET)) {
				$query = $conn->prepare("SELECT `product`.*, `shops`.Title FROM `favorite` INNER JOIN `product` INNER JOIN `shops` ON `product`.`Shop`=`shops`.`Shop_ID` ON `favorite`.`Item_ID` = `product`.`Product_ID` WHERE `favorite`.User = ?");
				$query->bind_param("s",$_SESSION["userid"]);
			}else if (isset($_GET['category'])){
					$query = $conn->prepare("SELECT `product`.*, `shops`.Title FROM `favorite` INNER JOIN `product` INNER JOIN `shops` ON `product`.`Shop`=`shops`.`Shop_ID` ON `favorite`.`Item_ID` = `product`.`Product_ID` WHERE `favorite`.User = ? AND Category = ?");
					$query->bind_param("ss",$_SESSION["userid"],$_GET['category']);
			}
			$query->execute();
			$result = $query->get_result();
			
			while($row=$result->fetch_assoc()){
				echo 
				"<div class='col-lg-3 col-sm-6'>
					<a href='ShopDetail.php?id=" . $row["Shop"] . "'><small class='shopName'>" . $row["Title"] . "</small></a>
					<div class='productName'>" . $row["Name"] . "</div>
					<div class='productImgWrapper'>
						<div class='productImg'><img src='images/" . $row["Image_Path"] . "' class='img-fluid m-2'></div>
						<div class='productImgOverlay'>
							<a href='ProductDetail.php?id=" . $row["Product_ID"] ."' class='btn btn-dark productDetail'>
								VIEW DETAIL
							</a>
						</div>
					</div>
					<div class='row align-items-center'>
						<div class='col mr-auto'>$" . number_format((float)$row["Price"], 2, '.', '') . "</div>
						<div>
							<button type='button' data-itemid='" . $row["Product_ID"] . "' data-stock='".$row["Stock"]."' class='mdc-icon-button material-icons cart'>";
							if ($row["Stock"] == 0)
								echo "remove_shopping_cart";
							else echo "add_shopping_cart";
							echo "</button>
							<button type='button' data-itemid='" . $row["Product_ID"] . "' class='mdc-icon-button material-icons fav mr-2'>favorite";
							$favQuery = $conn->prepare("SELECT * FROM `favorite` WHERE User = ? AND Item_ID = ?");
							$favQuery->bind_param("si",$_SESSION["userid"],$row["Product_ID"]);
							$favQuery->execute();
							$favResult= $favQuery->get_result();
							
							if ($favResult->num_rows == 0) 
								echo "_border";
							echo "</button>
						</div>
					</div>
				</div>";
			}
		
		echo
		"</div>	  
	</div>
	</div>";
		}
	?> 
  
</div>

<div class="alert cart-alert">
</div>

</body>
</html>