<?php
	$conn = mysqli_connect("localhost", "root", "","onlineshop");
	if ($conn->connect_error)  {
		die("Connection failed: " . $conn->connect_error);
	}
	$invalid = 0;
	// $query = "SELECT `product`.*, `shops`.`Title`, `shops`.`Info` FROM `product` INNER JOIN `shops` ON `product`.`Shop` = `shops`.`Shop_ID` WHERE `product`.`Product_ID` = " . $_GET["id"];			
	// $result = $conn->query($query);
	$query = $conn->prepare("SELECT `product`.*, `shops`.`Title`, `shops`.`Info` FROM `product` INNER JOIN `shops` ON `product`.`Shop` = `shops`.`Shop_ID` WHERE `product`.`Product_ID` = ?");			
	$query->bind_param("i",$_GET["id"]);
	$query->execute();
	$result = $query->get_result();
	
	if ($result->num_rows == 0) {
		$invalid = 1;
	}
	else {
		while($row=$result->fetch_assoc()){
			$name = $row["Name"];
			$info = $row["Description"];
			$image = $row["Image_Path"];
			$stock = $row["Stock"];
			$price = $row["Price"];
			$category = $row["Category"];
			$shopName = $row["Title"];
			$shopID = $row["Shop"];
			$shopInfo = $row["Info"];
		}	
	}	
?>

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
 <title><?php if ($invalid == 0) echo $name; else echo "Error"?> || Online Store</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <?php
	if ($invalid == 1) {
		echo '<meta http-equiv="Refresh" content="5; url=MainPage.php" />';
	}
  ?>
  <link rel="stylesheet" href="css/bootstrap.min.css">
  <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
  <link rel="stylesheet" href="css/material-components-web.css">
  <link rel="stylesheet" type="text/css" href="css/style.css">
  <script src="script/jquery-3.4.1.min.js"></script>
  <script src="script/popper.min.js"></script>
  <script src="script/bootstrap.min.js"></script>
  <script src="script/ProductDisplay.js"></script>
  <style type="text/css">
	h2 {
		font-size: 24px;
		color: #4f5963;
	}
	a#shopname {
		color: #212529;
	}

	.cat {
		font-size: 14px;
		letter-spacing: 4px;
		text-transform: uppercase;
	}
	.outOfStockOverlay {
		opacity: 0;
		position: absolute;
		top: 50%;
		left: 50%;
		transform: translate(-50%, -50%);
		-ms-transform: translate(-50%, -50%);
	}
	.btn {
		height: initial;
	}
  </style>
</head>
<body>
<?php
	if (!isset($_SESSION["userid"])){
		// The Navbar before login
		echo
		"<nav class='navbar navbar-expand-md navbar-light fixed-top bg-light'>
			<button class='navbar-toggler mdc-icon-button material-icons ml-1' type='button' data-toggle='collapse' data-target='#dropdownSearch' aria-controls='dropdownSearch' aria-expanded='false' aria-label='Toggle search bar'>search</button>
			<a class='navbar-brand ml-md-1' href='MainPage.php'>Online Store</a>
			<div class='order-md-1 ml-auto mediumNav'>
					<ul class='navbar-nav nav-item'>
						<a href='Cart.php' class='nav-link d-flex align-items-end mr-3 mr-md-2'><i class='material-icons mr-2'>shopping_cart</i>Cart</a>
					</ul>
					<ul class='navbar-nav nav-item'>
						<span class='navbar-text'>|</span>
					</ul>
					<ul class='navbar-nav nav-item'>
						<a href='Signup.php' class='nav-link d-flex align-items-end mx-3 mx-md-2'><i class='material-icons mr-2'>person_add</i>Signup</a>
					</ul>
					<ul class='navbar-nav nav-item'>
						<span class='navbar-text'>|</span>
					</ul>
					<ul class='navbar-nav nav-item'>
						<a href='Login.php' class='nav-link d-flex align-items-end ml-3 ml-md-2'><i class='material-icons mr-2'>vpn_key</i>Login</a>
					</ul>				
			</div>
			<div class='order-md-1 ml-auto smallNav'>
				<ul class='navbar-nav nav-item'>
					<a href='Cart.php' class='nav-link d-flex align-items-end'><i class='material-icons mr-2'>shopping_cart</i></a>
				</ul>	
				<ul class='navbar-nav nav-item'>
					<a href='Signup.php' class='nav-link d-flex align-items-end ml-3' ><i class='material-icons mr-2'>person_add</i></a>
				</ul>
				<ul class='navbar-nav nav-item'>
					<a href='Login.php' class='nav-link d-flex align-items-end ml-3'><i class='material-icons mr-2'>vpn_key</i></a>
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
		$fav = "favorite_border";
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
							<a class='dropdown-item d-flex align-items-center' href='Favourite.php'><i class='material-icons mr-2'>favorite</i>Favourite List</a>					
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
		// $favQuery = "SELECT * FROM `favorite` WHERE User = '".$_SESSION["userid"]."' AND Item_ID = " . $_GET["id"];
		// $favResult= $conn->query($favQuery);
		$favQuery = $conn->prepare("SELECT * FROM `favorite` WHERE User = ? AND Item_ID = ?");
		$favQuery->bind_param("si",$_SESSION["userid"],$_GET["id"]);
		$favQuery->execute();
		$favResult= $favQuery->get_result();
		
		if ($favResult->num_rows == 0) 
			$fav = "favorite_border";
		else $fav = "favorite";
	}
?>

<div class="container-fluid">
	<?php
		if ($invalid == 1) {
			echo "<p class='text-center'>There is something wrong! Redirecting to homepage within 5 seconds...</p>";
			echo "<p class='text-center'>Click <a href='MainPage.php'>here</a> to get started now.</p>";
			die();
		}
	?>

	<div class="jumbotron text-center">
		<a id='shopname' href="ShopDetail.php?id=<?php echo $shopID ?>"><h1><?php echo $shopName ?></h1></a>
		<p><?php echo $shopInfo?></p>
	</div>  
  
	<div class="container">
		<div class="row">
			<div class="col-lg-4 col-md-6 align-self-center"><img src="images/<?php echo $image ?>" class="img-fluid">
			<div class="outOfStockOverlay btn btn-danger active">Out of Stock</div></div>
			<div class="col d-flex flex-column">
				<div><span class="text-muted cat"><?php echo $category ?></span>
				<h1><?php echo $name?></h1>
				<h2>$<?php echo number_format((float)$price, 2, '.', '')?></h2></div>
				<hr style='width:100%;'>
				<textarea class="text-muted form-control-plaintext" rows='5' style='resize:none;' disabled><?php echo $info ?></textarea>
				<div class="row align-items-center mt-auto">
					<div class="col-inline mr-auto">
						<div class="input-group qty">
							<div class="input-group-prepend">
								<button type="button" class="btn material-icons" id="subQuantity" <?php if ($stock == 0) echo "disabled";?>>remove</button>
							</div>
							<input type="text" class="form-control" id="quantity" value="<?php if ($stock == 0) echo "0"; else echo "1"?>" max='<?php echo $stock ?>' <?php if ($stock == 0) echo "disabled"?>>
							<div class="input-group-append">
								<button type="button" class="btn material-icons" id="addQuantity" <?php if ($stock == 0) echo "disabled";?>>add</button>
							</div>							
						</div>						
					</div>
					
					<div>
						<button type="button" data-itemid='<?php echo $_GET["id"] ?>' data-stock='<?php echo $stock ?>' class="mdc-icon-button material-icons cart"><?php if ($stock != 0) echo "add_shopping_cart"; else echo "remove_shopping_cart"?></button>
						<button type="button" data-itemid='<?php echo $_GET["id"] ?>' class="mdc-icon-button material-icons mr-2 fav"><?php echo $fav ?></button>
					</div>
				</div>
				<small class="<?php if ($stock != 0) echo "text-muted"?> pt-2">In stock: <?php echo $stock ?></small>
			</div>
			</div>
		</div>
	</div>

<div class="alert cart-alert">
</div>

</div>

<script>
	$(document).ready(function() {		
		
		if (<?php echo $stock?> == 0) {
			$(".outOfStockOverlay").css('opacity','0.95');
			$("img").css('opacity','0.4');
		}

		$("input:text").keyup(function() {
			if (parseInt($(this).val()) > parseInt($(this).attr('max'))) {
				$(this).val($(this).attr('max'));
			}
			if (parseInt($(this).val()) <= 0) {
				$(this).val(1);
			}
		});
		
		$("#addQuantity").click(function() {
			$("#quantity").val(parseInt($("#quantity").val())+1);
			$("input:text").keyup();
		});
		
		$("#subQuantity").click(function() {
			$("#quantity").val(parseInt($("#quantity").val())-1);
			$("input:text").keyup();
		});
		
	});	
</script>

</body>
</html>