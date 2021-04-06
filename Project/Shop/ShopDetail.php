<?php
	$conn = mysqli_connect("localhost", "root", "","onlineshop");
	if ($conn->connect_error)  {
		die("Connection failed: " . $conn->connect_error);
	}
	$invalid = 0;
	$query = $conn->prepare("SELECT * from `shops` WHERE Shop_ID = ?");			
	$query->bind_param("i", $_GET["id"]);
	$query->execute();
	$result = $query->get_result();
	
	//$query = "SELECT DISTINCT Title, Info, Owner_ID from `shops` INNER JOIN `product` ON `shops`.Shop_ID = `product`.Shop WHERE Shop = " . $_GET["id"];			
	//$result = $conn->query($query);
	if ($result->num_rows == 0) {
		$invalid = 1;
	}	
	else {
		while($row=$result->fetch_assoc()){
			$shopName = $row["Title"];
			$shopInfo = $row["Info"];
			$ownerID = $row["Owner_ID"];
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
 <title><?php if ($invalid == 0) echo $shopName; else echo "Error"; ?> || Online Store</title>
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
		<h1 id='shopname'><?php echo $shopName ?></h1>
		<p id='shopinfo'><?php echo $shopInfo ?></p>
	</div>
	
	<?php 
		if (isset($_SESSION["userid"]) && $ownerID == $_SESSION["userid"]) {
			echo 
			"<div class='container'>
	  
				<ul class='nav nav-tabs' role='tablist' id='tab'>
					<li class='nav-item'>
						<a class='nav-link active' data-toggle='tab' href='#General' role='tab' aria-selected='true'>General Information</a>
					</li>
					<li class='nav-item'>
						<a class='nav-link' data-toggle='tab' href='#Product' role='tab' aria-selected='false'>Product</a>
					</li>
					<li class='nav-item'>
						<a class='nav-link' data-toggle='tab' href='#Order' role='tab' aria-selected='false'>Order</a>
					</li>
				</ul>
	  
				<div class='tab-content'>
		
					<div class='tab-pane fade show active' id='General' role='tabpanel'>
						<input type='hidden' id='shopid' value='".$_GET["id"]."'>
						<div class='form-group row'>
							<label for='inputShopName' class='col-sm-3 col-form-label'>Shop name</label>
							<div class='col'>
								<input type='text' readonly class='form-control-plaintext' id='inputShopName' value='".$shopName."'>
								<small for='inputShopName'></small>
							</div>
							<input type='button' class='btn btn-outline-info mr-3' id='changeShopNameRequest' value='Edit'>
						</div>
						<div class='form-group row'>
							<label for='inputInfo' class='col-sm-3 col-form-label'>Infomation</label>
							<div class='col text-justify'>
								<textarea readonly class='form-control-plaintext' id='inputInfo' rows='1'>".$shopInfo."</textarea>
							</div>
							<div class='col-inline'>
								<input type='button' class='btn btn-outline-info mr-3' id='changeInfoRequest' value='Edit'>
							</div>
						</div>
					</div>
		
					<div class='tab-pane fade' id='Product' role='tabpanel'>";			
							// $query = "SELECT * FROM `product` WHERE Shop = ".$_GET["id"];
							// $result = $conn->query($query);
							
							$query = $conn->prepare("SELECT * FROM `product` WHERE Shop = ?");
							$query->bind_param("i",$_GET["id"]);
							$query->execute();
							$result = $query->get_result();
							
							if ($result->num_rows == 0) {
								echo "<p class='text-center' id='noItem'>There is no product in your shop yet!</p>";
							}
							else {
								while($row=$result->fetch_assoc()){
									echo
									"<form data-itemid='".$row["Product_ID"]."' enctype='multipart/form-data'>
										<input type='hidden' name='itemid' value='".$row["Product_ID"]."'>
										<div class='row align-items-center'>	  
											<div class='col-lg-4'>
												<div class='editProductImgWrapper' data-itemid='".$row["Product_ID"]."'>
													<img src='images/".$row["Image_Path"]."' class='img-fluid editProductImg' data-itemid='".$row["Product_ID"]."'>
													<div class='editProductImgOverlay' data-itemid='".$row["Product_ID"]."'>
														<label class='customUpload btn btn-dark' style='font-size:14px;letter-spacing:2px;'>UPLOAD</label>
														<input class='imgUpload' name='imgUpload' type='file' accept='image/*' data-itemid='".$row["Product_ID"]."'>
													</div>
												</div>
											</div>
											<div class='col'>
												<div class='col'>
													<label class='text-muted col-form-label'>Name</label>
													<input type='text' readonly class='form-control-plaintext' name='ProdName' data-itemid='".$row["Product_ID"]."' value='".$row["Name"]."'>
													<small data-itemid='".$row["Product_ID"]."'></small>
												</div>
												<div class='col'>
													<label class='text-muted col-form-label'>Description</label>
													<textarea readonly class='form-control-plaintext' name='ProdInfo' data-itemid='".$row["Product_ID"]."'>".$row["Description"]."</textarea>
												</div>
												<div class='col'>
													<label class='text-muted col-form-label'>Price</label><br>
													<p class='price' data-itemid='".$row["Product_ID"]."'> $".number_format((float)$row["Price"], 2, '.', '')." </p>
													<div class='input-group' data-itemid='".$row["Product_ID"]."' style='display:none;'>
														<div class='input-group-prepend'>
															<span class='input-group-text'>$</span>
														</div>
														<input type='text' class='form-control' name='Price' data-itemid='".$row["Product_ID"]."' value='".number_format((float)$row["Price"], 2, '.', '')."'>
													</div>
													<small data-itemid='".$row["Product_ID"]."' for='Price'></small>
												</div>
												<div class='col'>
													<label class='text-muted col-form-label'>Stock</label>
													<input type='text' readonly class='form-control-plaintext' name='Stock' data-itemid='".$row["Product_ID"]."' value='".$row["Stock"]."'>
													<small data-itemid='".$row["Product_ID"]."' for='Stock'></small>
												</div>
												<div class='col'>
													<label class='text-muted col-form-label'>Category</label>
														<div class='row align-items-center'>
														<div class='col-md-10 col-sm-9'>
														<select class='form-control' name='Category' data-itemid='".$row["Product_ID"]."' style='display:none;'>";
														$categoryList = array("Clothing","Shoes","Consumer Electronics", "Cosmetics", "Games", "Sports", "Toys", "Hobby supplies","Drinks", "Beverage", "Food", "Stationary", "Others");
														for ($i = 0; $i < count($categoryList); $i++) {
															$selected = "";
															if ($categoryList[$i] == $row["Category"]) 
																$selected = "selected";
															echo
															"<option ".$selected.">".$categoryList[$i]."</option>";
														}												
														echo
														"</select>
														<input type='text' readonly class='form-control-plaintext category' data-itemid='".$row["Product_ID"]."' value='".$row["Category"]."'>
														</div>
														<div class='col ml-auto text-right'>
															<button class='btn btn-outline-info editProduct' data-itemid='".$row["Product_ID"]."'>Edit</button>
														</div>
														</div>
												</div>
											</div>
										</div>
									</form>
									<hr>";
								}
							}
						

						echo"
						<div id='addNewProduct' style='display:none;'>
							<form data-itemid='0' enctype='multipart/form-data'>
							<input type='hidden' name='itemid' value='0'>
							<input type='hidden' name='shopid' value='".$_GET["id"]."'>
							<div class='row align-items-center'>	  
								<div class='col-lg-4 text-center'>							
										<label class='customUpload btn btn-dark' style='font-size:14px;letter-spacing:2px;'>UPLOAD</label>
										<input class='imgUpload' name='imgUpload' type='file' data-itemid='0'>													
								</div>
							
								
								<div class='col'>
									<div class='col'>
										<label class='text-muted col-form-label'>Name</label>
										<input type='text' class='form-control' name='ProdName' data-itemid='0' placeholder='Product Name'>
										<small data-itemid='0'></small>
									</div>
									<div class='col'>
										<label class='text-muted col-form-label'>Description</label>
										<textarea class='form-control' name='ProdInfo' data-itemid='0' placeholder='Product Description'></textarea>
									</div>
									<div class='col'>
										<label class='text-muted col-form-label'>Price</label>
										<div class='input-group'>
											<div class='input-group-prepend'>
												<span class='input-group-text'>$</span>
											</div>
											<input type='text' class='form-control' name='Price' data-itemid='0'>
										</div>
										<small data-itemid='0' for='Price'></small>
									</div>
									<div class='col'>
										<label class='text-muted col-form-label'>Stock</label>
										<input type='text' class='form-control' name='Stock' data-itemid='0'>
										<small data-itemid='0' for='Stock'></small>
									</div>
									<div class='col'>
										<label class='text-muted col-form-label'>Category</label>
											<div class='row align-items-center'>
												<div class='col-md-10 col-sm-9'>
													<select class='form-control' name='Category' data-itemid='0'>
														<option selected disabled hidden>Please select...</option>
														<option>Clothing</option>
														<option>Shoes</option>
														<option>Consumer Electronics</option>
														<option>Cosmetics</option>
														<option>Games</option>
														<option>Sports</option>
														<option>Toys</option>
														<option>Hobby supplies</option>
														<option>Drinks</option>														
														<option>Beverage</option>
														<option>Food</option>
														<option>Stationary</option>														
														<option>Others</option>
													</select>
													<small data-itemid='0' for='Category'></small>
												</div>
												<div class='col ml-auto text-right'>
													<button class='btn btn-success editProduct' data-itemid='0'>Save</button>
												</div>
											</div>
									</div>
								</div>				
							</div>
							</form>
						</div>
						  <input type='button' class='btn btn-success btn-block my-3' id='addNewProductRequest' value='Add New'>			  
					</div>
		
		
		
		
		
					<div class='tab-pane fade' id='Order' role='tabpanel'>";
							// $query = "SELECT Order_No, Name, Image_Path, Price, QTY, Order_Date, Buyer, Finished FROM `productinorder` INNER JOIN `product` ON `productinorder`.`Item_ID` = `product`.`Product_ID` WHERE `product`.`Shop` = ".$_GET["id"];
							// $result = $conn->query($query);
							$query = $conn->prepare("SELECT Order_No, Name, Image_Path, Price, QTY, Order_Date, Buyer, Finished FROM `productinorder` INNER JOIN `product` ON `productinorder`.`Item_ID` = `product`.`Product_ID` WHERE `product`.`Shop` = ?");
							$query->bind_param("i",$_GET["id"]);
							$query->execute();
							$result = $query->get_result();
							
							if ($result->num_rows == 0)
								echo "<p class='text-center'>There is no order yet!</p>";
							else {
								echo 
								"<div class='row Header'>
									<div class='col-md-1'></div>
									<div class='col-md-5'>Items</div>
									<div class='col-md-2'>Quantity</div>
									<div class='col-md-2'>Order by</div>
								</div>
								<hr class='Header'>";
								while($row=$result->fetch_assoc()) {
									if ($row["Finished"] == 0) 
										echo "<div class='row align-items-center'>";
									else echo "<div class='row align-items-center' style='opacity:0.4;'>";
									echo
										"<div class='col-md-1'></div>
										<div class='col-md-2'><img src='images/".$row["Image_Path"]."' class='img-fluid'></div>
										<div class='col d-sm-block d-md-none text-muted'>Item</div>
										<div class='col-md-3'>
											".$row["Name"]."<br>
											<small class='text-muted'>$".number_format((float)$row["Price"], 2, '.', '')."</small>
										</div>
										<div class='col d-sm-block d-md-none text-muted'>Quantity</div>
										<div class='col-md-2'>
											<span>".$row["QTY"]."</span>						
										</div>
										<div class='col d-sm-block d-md-none text-muted'>Order by</div>
										<div class='col-md-2'>
											<label>".$row["Buyer"]."</label>
											@".$row["Order_Date"]."
										</div>
										<div class='col-md-1'>
											<button type='button' class='btn btn-outline-secondary orderDone' data-orderno='".$row["Order_No"]."' ";
											if ($row["Finished"] == 1)
												echo "disabled";
											echo ">Done</button>
										</div>
									</div>
									<hr>";
								}
							}
						echo		
						"</div>
				  </div>
			  
			</div>
		</div>";
		}
		else {
			
		
					// $query = "SELECT Category, COUNT(*) FROM `product` WHERE Shop = " . $_GET["id"] . " AND `Stock` <> 0 GROUP BY Category";			
					// $result = $conn->query($query);
					$query = $conn->prepare("SELECT Category, COUNT(*) FROM `product` WHERE Shop = ? AND `Stock` <> 0 GROUP BY Category");			
					$query->bind_param("i",$_GET["id"]);
					$query->execute();
					$result = $query->get_result();
				
					if ($result->num_rows == 0) {
						echo "<p class='text-center'>No result is found.</p>";
						die();
					}
					
					echo 
					"<div class='row'>
					<div class='col-sm-3 col-md-2'>
					<div class='row ml-2 sticky-top' style='top: 75px;'>";
					while($row=$result->fetch_assoc()){
						echo
						"<div class='col-4 col-sm-12 mb-3'><a href='";
						$params = $_GET;
						$params['category'] = $row["Category"];
						if (isset($_GET['page']))
							$params['page'] = 1;
						echo "?" . http_build_query($params);
						echo "'>" . $row["Category"] . " (" . $row["COUNT(*)"] .")</a></div>";
					}

					echo "<div class='col-12 d-block mb-3'><hr></div>
					<div class='col-4 col-sm-12 mb-3'><a class='d-flex align-items-center' href='";
					if (!isset($_GET['sort'])) {
						$url = $_SERVER['REQUEST_URI'];
						echo $url . "&sort=Time&order=DESC";
					}
					else {
						$params = $_GET;
						if ($params['sort'] == "Time")
							if ($params['order'] == "ASC")
								$params['order'] = "DESC";
							else $params['order'] = "ASC";
						else $params['order'] = "DESC";
						$params['sort'] = "Time";
						echo "?" . http_build_query($params);
					}
					echo "'>Time
					<i class='material-icons pt-1'>";
					if (isset($_GET['sort'])) 
						if ($_GET['sort'] == "Time") 
							if ($_GET['order'] == "ASC")
								echo "arrow_drop_up";
							else echo "arrow_drop_down";
						else echo "unfold_more";
					else echo "arrow_drop_up";
					echo "</i></a>
					</div>";

					echo "<div class='col-4 col-sm-12 mb-3'><a class='d-flex align-items-center' href='";
					if (!isset($_GET['sort'])) {
						$url = $_SERVER['REQUEST_URI'];
						echo $url . "&sort=Price&order=ASC";
					}
					else {
						$params = $_GET;
						if ($params['sort'] == "Price")
							if ($params['order'] == "ASC")
								$params['order'] = "DESC";
							else $params['order'] = "ASC";
						else $params['order'] = "ASC";
						$params['sort'] = "Price";
						echo "?" . http_build_query($params);
					}
					echo "'>Price
					<i class='material-icons pt-1'>";
					if (isset($_GET['sort'])) 
						if ($_GET['sort'] == "Price") 
							if ($_GET['order'] == "ASC")
								echo "arrow_drop_up";
							else echo "arrow_drop_down";
						else echo "unfold_more";
					else echo "unfold_more";
					echo "</i></a>
					</div>";

					echo "<div class='col-4 col-sm-12 mb-3'><a class='d-flex align-items-center' href='";
					if (!isset($_GET['sort'])) {
						$url = $_SERVER['REQUEST_URI'];
						echo $url . "&sort=Popular&order=DESC";
					}
					else {
						$params = $_GET;
						if ($params['sort'] == "Popular")
							if ($params['order'] == "ASC")
								$params['order'] = "DESC";
							else $params['order'] = "ASC";
						else $params['order'] = "DESC";				
						$params['sort'] = "Popular";
						echo "?" . http_build_query($params);
					}
					echo "'>Popular
					<i class='material-icons pt-1'>";
					if (isset($_GET['sort'])) 
						if ($_GET['sort'] == "Popular") 
							if ($_GET['order'] == "ASC")
								echo "arrow_drop_up";
							else echo "arrow_drop_down";
						else echo "unfold_more";
					else echo "unfold_more";
					echo "</i></a>
					</div>";

					echo 
					"</div>
				</div>
    
				<div class='col'>";
					$defaultCountSQL =  "SELECT COUNT(*) FROM `Product` INNER JOIN `Shops` ON `product`.Shop = `shops`.`Shop_ID` WHERE `Stock` <> 0 AND Shop_ID = ?";
					if (!(isset($_GET["category"]))) {
						$countTotalQuery = $conn->prepare($defaultCountSQL);
						$countTotalQuery->bind_param("i",$_GET['id']);
					}
					else {
						$countTotalQuery = $conn->prepare($defaultCountSQL." AND Category = ?");
						$countTotalQuery->bind_param("is",$_GET['id'],$_GET['category']);
						
					}
					$countTotalQuery->execute();			
					$countTotalResult = $countTotalQuery->get_result();
					while($countRow=$countTotalResult->fetch_assoc()){
						$totalProduct = $countRow["COUNT(*)"];
					}
					$productPerPage = 12;
					$noOfPage = ceil($totalProduct / $productPerPage);
					if (isset($_GET["page"])) {
						if ($_GET["page"] <= $noOfPage)
							$page = $_GET["page"];
						else {
							$page = 1;
							$params = $_GET;
							$params['page'] = $page;
							header("Location: MainPage.php?".http_build_query($params));
						}
					} else $page = 1;			
					$offset = ($page-1) * $productPerPage;
					$sorting = "";
					echo "Showing " . ($offset + 1) . " - ";
					if ($noOfPage == $page)
						echo $totalProduct;
					else echo ($productPerPage * $page);
					echo " items.";
				
					echo "<div class='row my-2'>";
					
					if (isset($_GET['sort']) && isset($_GET['order'])) {
						switch($_GET['sort']){
							case 'Price':
								$sorting = "ORDER BY Price";
								break;
							case 'Time':
								$sorting = "ORDER BY Product_ID";
								break;
							case 'Popular':
								$sorting = "ORDER BY `sell`";
								break;
							default:
								$sorting = "ORDER BY Product_ID";
						}
						switch($_GET['order']){
							case 'ASC':
								$sorting .= " ASC";
								break;
							case 'DESC':
								$sorting .= " DESC";
								break;
							default:	
						}
					}
					$defaultSQL = "SELECT *, COUNT(case when Order_No IS NULL THEN null else 1 end) as `sell` FROM (`product` INNER JOIN `shops` ON `product`.Shop = `shops`.`Shop_ID`) LEFT JOIN `productinorder` ON Item_ID = `Product_ID` WHERE `Stock` <> 0 AND Shop = ?";
					if (isset($_GET['id'])) {
						$query = $conn->prepare($defaultSQL." GROUP BY Product_ID ".$sorting);
						$query->bind_param("i",$_GET['id']);
					}
					if (isset($_GET['category'])){
						// $query = $conn->prepare("SELECT * FROM `product` INNER JOIN `shops` ON `product`.Shop = `shops`.`Shop_ID` WHERE `Stock` <> 0 AND Category = ? ORDER BY `Product_ID`");
						$query = $conn->prepare($defaultSQL." AND Category = ? GROUP BY Product_ID ".$sorting);
						$query->bind_param("is",$_GET['id'],$_GET['category']);
					}
					
					$query->execute();
					$result = $query->get_result();
					
					while($row=$result->fetch_assoc()){
						echo 
						"<div class='col-lg-3 col-sm-6'>
							<small class='text-muted Category'>" . $row["Category"] . "</small>
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
									<button type='button' class='mdc-icon-button material-icons cart'>add_shopping_cart</button>
									<button type='button' data-itemid='" . $row["Product_ID"] . "' class='mdc-icon-button material-icons fav mr-2'>favorite";
									if (isset($_SESSION["userid"])) {
										// $favQuery = "SELECT * FROM `favorite` WHERE User = '".$_SESSION["userid"]."' AND Item_ID = " . $row["Product_ID"];
										// $favResult= $conn->query($favQuery);
										$favQuery = $conn->prepare("SELECT * FROM `favorite` WHERE User = ? AND Item_ID = ?");
										$favQuery->bind_param("si",$_SESSION["userid"],$row["Product_ID"]);
										$favQuery->execute();
										$favResult= $favQuery->get_result();
										
										if ($favResult->num_rows == 0) 
											echo "_border";
									}
									else echo "_border";
									echo "</button>
								</div>
							</div>
						</div>";
					}
					echo
					"</div>";
					echo "<div class='d-flex text-center justify-content-center'>
						<nav aria-label='Pagination'>
						<ul class='pagination'>
							<li class='page-item ";
							if ($page<= 1) echo "disabled";
							echo "'>
							<a class='page-link' href='";
							if (!isset($_GET['page'])) {
								$url = $_SERVER['REQUEST_URI'];
								$get = parse_url($url, PHP_URL_QUERY);
								echo $url;
								if ($get) echo "&"; else echo "?"; echo "page=".($page - 1);
							}
							else {
								$params = $_GET;							
								$params['page'] = ($page - 1);
								echo "?" . http_build_query($params);
							}	
								
							echo "'><span aria-hidden='true'>&laquo;</span></a>
							</li>";
							for ($i = 1; $i <= $noOfPage; $i++) {
								echo "<li class='page-item ";
								if ($page == $i)
									echo "active";
								echo "'><a class='page-link' href='";						
								if (!isset($_GET['page'])) {
									$url = $_SERVER['REQUEST_URI'];
									$get = parse_url($url, PHP_URL_QUERY);
									echo $url;
									if ($get) echo "&"; else echo "?"; echo "page=".$i;
								}
								else {
									$params = $_GET;							
									$params['page'] = $i;
									echo "?" . http_build_query($params);
								}						
								echo "'>".$i."</a></li>";
							}
							echo "<li class='page-item ";
							if ($page >= $noOfPage) echo "disabled";
							echo "'>
							<a class='page-link' href='";
							if (!isset($_GET['page'])) {
								$url = $_SERVER['REQUEST_URI'];
								$get = parse_url($url, PHP_URL_QUERY);
								echo $url;
								if ($get) echo "&"; else echo "?"; echo "page=".($page + 1);
							}
							else {
								$params = $_GET;							
								$params['page'] = ($page + 1);
								echo "?" . http_build_query($params);
							}
							echo "'><span aria-hidden='true'>&raquo;</span></a>
							</li>
						</ul>
						</nav>	
					</div>				
				</div>
			</div>";
		}
	?>  
</div>

<div class="alert alert-danger">
</div>
	
<div class="alert alert-success">
  Your change has been saved.
</div>

<div class="alert cart-alert">
</div>

<script>
	$(document).ready(function() {

		$('a[data-toggle="tab"]').on('click', function(e) {
			window.localStorage.setItem('activeTab', $(e.target).attr('href'));
		});
		var activeTab = window.localStorage.getItem('activeTab');
		if (activeTab) {
			$('#tab a[href="' + activeTab + '"]').tab('show');
			window.localStorage.removeItem("activeTab");
		}
		
		$("#changeShopNameRequest").click(function() {
			if ($(this).val() != "Save") {
				$("#inputShopName").prop('readonly', function(i,r) {
					$("#inputShopName").toggleClass("form-control-plaintext");
					$("#inputShopName").toggleClass("form-control");
					return !r;
				});				
				$(this).val("Save");
			}
			else updateShop();
		});	

		$("#changeInfoRequest").click(function() {
			if ($(this).val() != "Save") {
				$("#inputInfo").prop('readonly', function(i,r) {
					$("#inputInfo").toggleClass("form-control-plaintext");
					$("#inputInfo").toggleClass("form-control");
					$("#inputInfo").css("resize", "vertical");
					return !r;
				});				
				$(this).val("Save");
			}
			else updateShop();
		});	
		
		function updateShop() {			
			var valid = 1;
			if ($("#inputShopName").val() == "") {
				valid = 0;
				$("#inputShopName").addClass("invalid");
				$("#inputShopName").next("small").text("This field should not be blank!");
			}
			
			if (valid == 1) {
				$.post( "updateShop.php", {
					shopid: $("#shopid").val(),
					shopname: $("#inputShopName").val(),
					shopinfo: $("#inputInfo").val()
				},
				function(data) {
					if (data.indexOf("Success") != -1) {
						$("#inputShopName").prop("readonly", true);
						$("#inputInfo").prop("readonly", true);
						$("#inputShopName").addClass("form-control-plaintext");
						$("#inputInfo").addClass("form-control-plaintext");
						$("#inputShopName").removeClass("form-control");
						$("#inputInfo").removeClass("form-control");
						$("#inputInfo").css("resize", "none");
						$("#changeShopNameRequest").val("Edit");
						$("#changeInfoRequest").val("Edit");
						$("#shopname").text($("#inputShopName").val());
						$("#shopinfo").text($("#inputInfo").val());
						
						$(".alert-success").fadeIn();
						setTimeout(function() {
							$(".alert-success").fadeOut();
						}, 3500);
					}
				});
			}
		}
		
		$(".editProduct").click(function(e) {
			$error = 0;
			e.preventDefault();
			var itemid = $(this).data('itemid');
			
			if ($(this).text() != "Save") {				
			
				$("input[data-itemid=" + itemid + "]").each(function () {
					$(this).prop('readonly', function(i, r) {
						if (r) {
							$(this).toggleClass("form-control-plaintext");
							$(this).toggleClass("form-control");
							return !r;
						}
					})
				});
				
				$("textarea[data-itemid=" + itemid + "]").prop('readonly', function(i,r) {
					$(this).toggleClass("form-control-plaintext");
					$(this).toggleClass("form-control");
					$(this).css("resize", "vertical");
					return !r;
				});
				
				$("input.category[data-itemid=" + itemid + "]").hide();
				$("select[data-itemid=" + itemid + "]").show();
				
				$("p[data-itemid=" + itemid + "]").hide();
				$(".input-group[data-itemid=" + itemid + "]").show();
				

				$(this).text("Save");
				$(".editProductImgOverlay[data-itemid="+itemid+"]").show();
				$(".editProductImgWrapper[data-itemid="+itemid+"]").hover(
					function () {
						$(".editProductImg[data-itemid="+itemid+"]").css("opacity", 0.4);						
						$(".editProductImgOverlay[data-itemid="+itemid+"]").css("opacity", 0.95);
					},
					function() {
						$(".editProductImg[data-itemid="+itemid+"]").css("opacity", 1);
						$(".editProductImgOverlay[data-itemid="+itemid+"]").css("opacity", 0);
					}
				);
			}
			
			else { //Button text not "Save"
				if (itemid == '0') {
					if ($("input:file[data-itemid='0']").val() == "") {
						$error = 1;
						$(".alert-danger").text("Add an image to your new product!");
						$(".alert-danger").fadeIn();
						setTimeout(function() {
							$(".alert-danger").fadeOut();
						}, 3500);
					}
					if ($('select[data-itemid="0"] option:selected').text() == "Please select...") {
						$error = 1;
						$('select[data-itemid="0"]').addClass("invalid");
						$('select[data-itemid="0"]').next("small").text("Please select a category for your product.");
					}
				}
				$('input:text[data-itemid='+itemid+']').each(function() {
					if ($(this).val() == "") {
						$error = 1;
						if ($(this).is("input[name='Price']")) {
							$("small[for='Price'][data-itemid='"+itemid+"']").text("This field should not be blank!");
						}
						else {
							$(this).next("small").text("This field should not be blank!");
						}
						$(this).addClass("invalid");
					}
				});
				
				if ($error == 0) {
					var form = $('form[data-itemid='+itemid+']')[0];
					var formData = new FormData(form);
					
					$.ajax ({
						url: "updateProduct.php",
						data: formData,
						type: "POST",
						processData: false,
						contentType: false,
						success: function() {
							location.reload();
						}
					});
				}
			}
			
		});	

		$('select[data-itemid="0"]').change(function () {
			$(this).removeClass("invalid");
			$(this).next("small").text("");
			$error = 0;
		})
		
		$(".customUpload").click(function () {
			$(this).next('input').trigger('click');
		});			
		
		$(".imgUpload").change(function () {
			var allowTypes = ['xbm','tif','pjp','pjpeg','svgz','jpg','jpeg','ico','tiff','gif','svg','bmp','png','jfif','webp'];
			if ($.inArray($(this).val().split('.').pop().toLowerCase(), allowTypes) == -1){
				$(this).val("");				
				$(".alert-danger").text("The uploaded file is not an image.");
				$(".alert-danger").fadeIn();
				setTimeout(function() {
					$(".alert-danger").fadeOut();
				}, 3500);
			}
			else {
				if ($(this).val().indexOf('C:\fakepath'))
					$str = $(this).val().substring(12);
				else $str = $(this).val();
				$(this).prev('label').text($str);
			}
		});

		$("#addNewProductRequest").click(function() {
			$("#addNewProduct").slideDown();
			$("#addNewProductRequest").slideUp();
			$("#noItem").slideUp();
			$('html, body').animate({scrollTop:$(document).height()}, 'slow');
		});
				
		$("input:text").blur(function() {
			var itemid = $(this).data("itemid");
			if ($(this).val() == "") {
				$(this).addClass("invalid");
				$(this).next("small").removeClass("text-muted");
				if ($(this).is("[name='Price']")) {
						$("small[for='Price'][data-itemid=" + itemid + "]").text("This field should not be blank!");
					}
				else $(this).next("small").text("This field should not be blank!");
			}
		});
		
		$("input:text").keyup(function(e) {
			var itemid = $(this).data("itemid");
			
			if (e.keyCode != 9) {
				if ($(this).val() == "") {
					$error = 1;
					$(this).addClass("invalid");
					if ($(this).is("[name='Price']")) {
						$("small[for='Price'][data-itemid=" + itemid + "]").text("This field should not be blank!");
					}
					else $(this).next("small").text("This field should not be blank!");
				}
				else {
					if ($(this).is("[name='Price']")) {
						var regex = /^[0-9]+[.]?[0-9]*$/;
						if (!$(this).val().match(regex)) {
							$error = 1;
							$(this).addClass("invalid");
							$("small[for='Price'][data-itemid=" + itemid + "]").text("Please enter a numeric value.");
						}
						else {
							$("small[for='Price'][data-itemid=" + itemid + "]").text("");
							$error = 0;
							$(this).removeClass("invalid");
						}
					}
					else if ($(this).is("[name='Stock']")) {
						var regex = /^[0-9]*$/;
						if (!$(this).val().match(regex)) {
							$error = 1;
							$(this).addClass("invalid");
							$(this).next("small").text("Please enter an integer.");
						}
						else {
							$(this).next("small").text("");
							$error = 0;
							$(this).removeClass("invalid");
						}
					}
					else {
						$(this).removeClass("invalid");
						$(this).next("small").text("");
						$error = 0;
					}
				}		
			}				
		});
		
		$(".orderDone").click(function() {
			$.post( "orderDone.php", {
				orderno: $(this).data("orderno")
			},
			function() {
				location.reload();
			});
		});
		

	});
</script>

</body>
</html>