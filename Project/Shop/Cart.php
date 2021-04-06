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
 <title>Shopping Cart || Online Store</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="stylesheet" href="css/bootstrap.min.css">
  <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
  <link rel="stylesheet" href="css/material-components-web.css">
  <link rel="stylesheet" type="text/css" href="css/style.css">
  <script src="script/jquery-3.4.1.min.js"></script>
  <script src="script/popper.min.js"></script>
  <script src="script/bootstrap.min.js"></script>
  <script src="script/bootstrap-confirmation.min.js"></script>
  <style type="text/css">
	@media screen and (max-width: 768px) {
		.Delete {
			margin-top: 15px;
			width: 100%;
		}
		#Buy {
			margin-top: 15px;
			width: 100%;
		}
	}
  </style>
</head>
<body>
<?php
	if (isset($_SESSION["userid"]) && isset($_SESSION["Cart"])){
		if (sizeof($_SESSION["Cart"]) > 0){
			$conn = mysqli_connect("localhost", "root", "","onlineshop");
			if ($conn->connect_error)  {
				die("Connection failed: " . $conn->connect_error);
			}
			foreach($_SESSION["Cart"] as $product => $value){
				$query = $conn->prepare("SELECT Item_ID, User FROM `cart` WHERE Item_ID = ? AND User = ?;");
				$query->bind_param("is", $product, $_SESSION["userid"]);
		
		
			$query->execute();
			$result = $query->get_result();
			if ($result->num_rows == 0) {
				$sql = $conn->prepare("INSERT INTO `cart` (`ID`, `QTY`, `Item_ID`, `User`) VALUES (NULL, ?, ?, ?)");		
				$sql->bind_param("iis",$_SESSION["Cart"][$product]["QTY"], $product, $_SESSION["userid"]);
				$sql->execute();
			}
			}
		}
		unset($_SESSION["Cart"]);
	}
	
	if (!isset($_SESSION["userid"])){
		//header("location:Login.php");
        //die;
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
							<a class='dropdown-item d-flex align-items-center active' href='Cart.php'><i class='material-icons mr-2'>shopping_cart</i>Shopping Cart</a>
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
		<h1>Shopping Cart</h1>
	</div>  
  
	<div class="container">
	<?php
		$conn = mysqli_connect("localhost", "root", "","onlineshop");
		if ($conn->connect_error)  {
			die("Connection failed: " . $conn->connect_error);
		}
		if (isset($_SESSION["userid"])){
		$query = $conn->prepare("SELECT QTY, Product_ID, Name, Image_Path, Stock, Price FROM `cart` INNER JOIN `product` ON `cart`.`Item_ID` = `product`.`Product_ID` WHERE User = ?");
		$query->bind_param("s",$_SESSION["userid"]);
		$query->execute();
		$result = $query->get_result();
		
		if ($result->num_rows == 0)
			echo "<p class='text-center'>There is no item in cart yet!</p>";
		else {
			echo
			"<div class='row Header'>
				<div class='col-md-1 text-right'>
					<input class='form-check-input' type='checkbox' value='' id='checkAll'>
				</div>
				<div class='col-md-5'>Items</div>
				<div class='col-md-3'>Quantity</div>
				<div class='col-md-2'>Total</div>
			</div>
			<hr class='Header'>";
			
			while($row=$result->fetch_assoc()) {
				echo
				"<div class='d-flex row align-items-center justify-content-between' data-itemid='".$row["Product_ID"]."'>
					<div class='col-md-1 text-md-right'>
						<input class='form-check-input' type='checkbox' value='' data-itemid='" . $row["Product_ID"] . "'";
						if ($row["Stock"] == 0)
							echo "disabled";
						echo ">
					</div>
					<div class='col-md-2'";
					if ($row["Stock"] == 0)
						echo "style='opacity:0.4;'";
					echo "><img src='images/" . $row["Image_Path"] . "' class='img-fluid' data-itemid='".$row["Product_ID"]."'></div>
					<div class='col d-sm-block d-md-none text-muted mb-1'";
					if ($row["Stock"] == 0)
						echo "style='opacity:0.4;'";
					echo ">Item</div>
					<div class='col-md-3 productInfo' data-itemid='".$row["Product_ID"]."'";
					if ($row["Stock"] == 0)
						echo "style='opacity:0.4;'";
					echo ">" . 
						$row["Name"] . "<br>
						<small class='text-muted' data-itemid='" . $row["Product_ID"] . "' data-price='" . $row["Price"] . "'>$" . number_format((float)$row["Price"], 2, '.', '') . "</small>";
						if ($row["Stock"] == 0)
						echo "<br><small>OUT OF STOCK</small>";
					echo "</div>
					<div class='col d-sm-block d-md-none text-muted my-2'";
					if ($row["Stock"] == 0)
						echo "style='opacity:0.4;'";
					echo ">Quantity</div>
					<div class='col-md-3'";
					if ($row["Stock"] == 0)
						echo "style='opacity:0.4;'";
					echo ">
						<div class='input-group qty'>
							<div class='input-group-prepend'>
								<button type='button' class='btn material-icons subQuantity' data-itemid='" . $row["Product_ID"] . "'";
								if ($row["Stock"] == 0)
									echo "disabled";
								echo ">remove</button>
							</div>
							<input type='text' class='form-control' id='quantity' value='";
							if ($row["Stock"] == 0)
								echo 0;
							else echo $row["QTY"];
							echo "' data-itemid='".$row["Product_ID"]."' max='".$row["Stock"]."'";
							if ($row["Stock"] == 0)
								echo "disabled";
							echo ">
							<div class='input-group-append'>
								<button type='button' class='btn material-icons addQuantity' data-itemid='".$row["Product_ID"]."'";
							if ($row["Stock"] == 0)
								echo "disabled";
							echo ">add</button>
							</div>							
						</div>	
					</div>
					<div class='col d-sm-block d-md-none text-muted my-2'";
					if ($row["Stock"] == 0)
						echo "style='opacity:0.4;'";
					echo ">Total</div>
					<div class='col-md-2'";
					if ($row["Stock"] == 0)
						echo "style='opacity:0.4;'";
					echo ">
						<span id='total' data-itemid='".$row["Product_ID"]."'>$";
						if ($row["Stock"] == 0)
							echo "0.00";
						else echo number_format((float)($row["QTY"] * $row["Price"]), 2, '.', '');
						echo"</span>
					</div>
					<div class='col-md-1'>
						<button type='button' data-itemid='".$row["Product_ID"]."' class='btn btn-outline-danger Delete' data-toggle='confirmation'>Delete</button>
					</div>
				</div>
				<hr data-itemid='".$row["Product_ID"]."'>";
			}
			echo
			"<div class='row justify-content-center justify-content-md-start align-items-center total'>
				<div class='col-md-6'></div>
				<div class='col-3 text-md-right'>Total: </div>
				<div class='col-2' id='grandTotal'>$0.00</div>
				<div class='col-md-1'><input type='button' class='btn btn-success btn-lg' value='Buy' id='Buy' disabled></div>
			</div>";
		}
		}else{
			$query = "SELECT Product_ID, Name, Image_Path, Stock, Price FROM `product`";
			$result = $conn->query($query);
			
			if (!isset($_SESSION["Cart"])){
				echo "<p class='text-center'>There is no item in cart yet!</p>";
			}else if (sizeof($_SESSION["Cart"]) == 0){
				echo "<p class='text-center'>There is no item in cart yet!</p>";
			}else{
			echo
			"<div class='row Header'>
				<div class='col-md-1 text-right'>
					<input class='form-check-input' type='checkbox' value='' id='checkAll'>
				</div>
				<div class='col-md-5'>Items</div>
				<div class='col-md-3'>Quantity</div>
				<div class='col-md-2'>Total</div>
			</div>
			<hr class='Header'>";
			
			while($row=$result->fetch_assoc()) {
				if (array_key_exists($row["Product_ID"],$_SESSION["Cart"])){
				echo
				"<div class='d-flex row align-items-center justify-content-between' data-itemid='".$row["Product_ID"]."'>
					<div class='col-md-1 text-md-right'>
						<input class='form-check-input' type='checkbox' value='' data-itemid='" . $row["Product_ID"] . "'";
						if ($row["Stock"] == 0)
							echo "disabled";
						echo ">
					</div>
					<div class='col-md-2'";
					if ($row["Stock"] == 0)
						echo "style='opacity:0.4;'";
					echo "><img src='images/" . $row["Image_Path"] . "' class='img-fluid' data-itemid='".$row["Product_ID"]."'></div>
					<div class='col d-sm-block d-md-none text-muted mb-1'";
					if ($row["Stock"] == 0)
						echo "style='opacity:0.4;'";
					echo ">Item</div>
					<div class='col-md-3 productInfo' data-itemid='".$row["Product_ID"]."'";
					if ($row["Stock"] == 0)
						echo "style='opacity:0.4;'";
					echo ">" . 
						$row["Name"] . "<br>
						<small class='text-muted' data-itemid='" . $row["Product_ID"] . "' data-price='" . $row["Price"] . "'>$" . number_format((float)$row["Price"], 2, '.', '') . "</small>";
						if ($row["Stock"] == 0)
						echo "<br><small>OUT OF STOCK</small>";
					echo "</div>
					<div class='col d-sm-block d-md-none text-muted my-2'";
					if ($row["Stock"] == 0)
						echo "style='opacity:0.4;'";
					echo ">Quantity</div>
					<div class='col-md-3'";
					if ($row["Stock"] == 0)
						echo "style='opacity:0.4;'";
					echo ">
						<div class='input-group qty'>
							<div class='input-group-prepend'>
								<button type='button' class='btn material-icons subQuantity' data-itemid='" . $row["Product_ID"] . "'";
								if ($row["Stock"] == 0)
									echo "disabled";
								echo ">remove</button>
							</div>
							<input type='text' class='form-control' id='quantity' value='";
							if ($row["Stock"] == 0)
								echo 0;
							else echo $_SESSION["Cart"][$row["Product_ID"]]["QTY"];
							echo "' data-itemid='".$row["Product_ID"]."' max='".$row["Stock"]."'";
							if ($row["Stock"] == 0)
								echo "disabled";
							echo ">
							<div class='input-group-append'>
								<button type='button' class='btn material-icons addQuantity' data-itemid='".$row["Product_ID"]."'";
							if ($row["Stock"] == 0)
								echo "disabled";
							echo ">add</button>
							</div>							
						</div>	
					</div>
					<div class='col d-sm-block d-md-none text-muted my-2'";
					if ($row["Stock"] == 0)
						echo "style='opacity:0.4;'";
					echo ">Total</div>
					<div class='col-md-2'";
					if ($row["Stock"] == 0)
						echo "style='opacity:0.4;'";
					echo ">
						<span id='total' data-itemid='".$row["Product_ID"]."'>$";
						if ($row["Stock"] == 0)
							echo "0.00";
						else echo number_format((float)($_SESSION["Cart"][$row["Product_ID"]]["QTY"] * $row["Price"]), 2, '.', '');
						echo"</span>
					</div>
					<div class='col-md-1'>
						<button type='button' data-itemid='".$row["Product_ID"]."' class='btn btn-outline-danger Delete' data-toggle='confirmation'>Delete</button>
					</div>
				</div>
				<hr data-itemid='".$row["Product_ID"]."'>";
				}
			}
			echo
			"<div class='row justify-content-center justify-content-md-start align-items-center total'>
				<div class='col-md-6'></div>
				<div class='col-3 text-md-right'>Total: </div>
				<div class='col-2' id='grandTotal'>$0.00</div>
				<div class='col-md-1'><input type='button' class='btn btn-success btn-lg' value='Buy' id='Buy' disabled></div>
			</div>";
			}
		}
	?>		
	</div>
</div>

<div class="alert alert-success buy-alert">
	Success!
</div>

<div class="modal fade" id="confirmModal" tabindex="-1" role="dialog" aria-labelledby="confirmModalLabel" aria-hidden="true">
  <div class="modal-dialog mw-100 w-50" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="confirmModalLabel">Confirmation</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <p>Please check your ordered items: </p>
		<div id="cart-item">
		</div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">No</button>
        <button type="button" class="btn btn-success" id="ConfirmOrder">Yes</button>
      </div>
    </div>
  </div>
</div>

<script src="script/cart.js"></script>

</body>
</html>