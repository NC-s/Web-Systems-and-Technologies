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
 <title>Online Store</title>
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

	<div class="jumbotron text-center">
		<h1>Welcome! </h1>
	</div>  
	<?php
  			$conn = mysqli_connect("localhost", "root", "","onlineshop");
			if ($conn->connect_error)  {
				die("Connection failed: " . $conn->connect_error);
			}
			if (isset($_GET['search'])) {
				$query = $conn->prepare("SELECT Category, COUNT(*) FROM `product` WHERE `Stock` <> 0 AND Name LIKE ? GROUP BY Category");
				$searchString = "%".$_GET['search']."%";
				$query->bind_param("s",$searchString);
				$query->execute();			
				$result = $query->get_result();
			}
			else {
				$query = "SELECT Category, COUNT(*) FROM `product` WHERE `Stock` <> 0 GROUP BY Category";			
				$result = $conn->query($query);
			}
			if ($result->num_rows == 0) {
				echo "<p class='text-center'>No result is found.</p>";
				die();
			}
			echo "<div class='row'>	
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
				$get = parse_url($url, PHP_URL_QUERY);
				echo $url;
				if ($get) echo "&"; else echo "?"; echo "sort=Time&order=DESC";
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
				$get = parse_url($url, PHP_URL_QUERY);
				echo $url;
				if ($get) echo "&"; else echo "?"; echo "sort=Price&order=ASC";
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
				$get = parse_url($url, PHP_URL_QUERY);
				echo $url;
				if ($get) echo "&"; else echo "?"; echo "sort=Popular&order=DESC";
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
		?>

      </div>
    </div>
    
    <div class="col">		
		<?php			
			$defaultCountSQL =  "SELECT COUNT(*) FROM `Product` WHERE `Stock` <> 0";
			if (!(isset($_GET["category"]) || isset($_GET["search"])))
				$countTotalQuery = $conn->prepare($defaultCountSQL);
			else {
				if (isset($_GET["category"])){
					$countTotalQuery = $conn->prepare($defaultCountSQL." AND Category = ?");
					$countTotalQuery->bind_param("s",$_GET['category']);
				}
				if (isset($_GET["search"])){
					$countTotalQuery = $conn->prepare($defaultCountSQL." AND Name LIKE ?");
					$searchString = "%".$_GET['search']."%";
					$countTotalQuery->bind_param("s",$searchString);
				}
				if (isset($_GET["category"]) && isset($_GET["search"])) {
					$countTotalQuery = $conn->prepare($defaultCountSQL." AND Name LIKE ? AND Category = ?");
					$searchString = "%".$_GET['search']."%";
					$countTotalQuery->bind_param("ss",$searchString, $_GET['category']);
				}
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
						

			if (!(isset($_GET["category"]) || isset($_GET["search"]) || isset($_GET["sort"]))) 
				$query = $conn->prepare("SELECT * FROM `product` INNER JOIN `shops` ON `product`.Shop = `shops`.`Shop_ID` WHERE `Stock` <> 0 ORDER BY `Product_ID` LIMIT ".$offset.", ".$productPerPage);
			else {
				$sorting = "";
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
				$defaultSQL = "SELECT *, COUNT(case when Order_No IS NULL THEN null else 1 end) as `sell` FROM (`product` INNER JOIN `shops` ON `product`.Shop = `shops`.`Shop_ID`) LEFT JOIN `productinorder` ON Item_ID = `Product_ID` WHERE `Stock` <> 0";
				if (isset($_GET['category'])){
					// $query = $conn->prepare("SELECT * FROM `product` INNER JOIN `shops` ON `product`.Shop = `shops`.`Shop_ID` WHERE `Stock` <> 0 AND Category = ? ORDER BY `Product_ID`");
					$query = $conn->prepare($defaultSQL." AND Category = ? GROUP BY Product_ID ".$sorting." LIMIT ".$offset.", ".$productPerPage);
					$query->bind_param("s",$_GET['category']);
				}
				if (isset($_GET['search'])){
						// $query = $conn->prepare("SELECT * FROM `product` INNER JOIN `shops` ON `product`.Shop = `shops`.`Shop_ID` WHERE `Stock` <> 0 AND Name LIKE ? ORDER BY `Product_ID`");
						$query = $conn->prepare($defaultSQL." AND Name LIKE ? GROUP BY Product_ID ".$sorting." LIMIT ".$offset.", ".$productPerPage);
						$searchString = "%".$_GET['search']."%";
						$query->bind_param("s",$searchString);
				}
				if (isset($_GET['search']) && isset($_GET['category'])) {
					// $query = $conn->prepare("SELECT * FROM `product` INNER JOIN `shops` ON `product`.Shop = `shops`.`Shop_ID` WHERE `Stock` <> 0 AND Name LIKE ? AND Category = ? ORDER BY `Product_ID`");
					$query = $conn->prepare($defaultSQL." AND Name LIKE ? AND Category = ? GROUP BY Product_ID ".$sorting." LIMIT ".$offset.", ".$productPerPage);
					$searchString = "%".$_GET['search']."%";
					$query->bind_param("ss",$searchString, $_GET['category']);
				}
				if (!isset($_GET['search']) && !isset($_GET['category'])){
					$query = $conn->prepare($defaultSQL." GROUP BY Product_ID ".$sorting." LIMIT ".$offset.", ".$productPerPage);
				}
			}
			$query->execute();			
			$result = $query->get_result();

			echo "Showing " . ($offset + 1) . " - ";
			if ($noOfPage == $page)
				echo $totalProduct;
			else echo ($productPerPage * $page);
			echo " items.";
			echo "<div class='row my-2'>";

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
							<button type='button' data-itemid='" . $row["Product_ID"] . "' class='mdc-icon-button material-icons cart' data-stock='".$row["Stock"]."'>add_shopping_cart</button>
							<button type='button' data-itemid='" . $row["Product_ID"] . "' class='mdc-icon-button material-icons fav mr-2'>favorite";
							if (isset($_SESSION["userid"])) {
								// $favQuery = "SELECT * FROM `favorite` WHERE User = '".$_SESSION["userid"]."' AND Item_ID = " . $row["Product_ID"];
								// $favResult= $conn->query($favQuery);
								
								$favQuery = $conn->prepare("SELECT * FROM `favorite` WHERE User = ? AND Item_ID = ?");
								$favQuery->bind_param("si", $_SESSION["userid"],$row["Product_ID"]);
								$favQuery->execute();
								$favResult = $favQuery->get_result();
								
								if ($favResult->num_rows == 0) 
									echo "_border";
							}
							else echo "_border";
							echo "</button>
						</div>
					</div>
				</div>";
			}
		?>
		</div>
		<div class='d-flex text-center justify-content-center'>
			<nav aria-label="Pagination">
			<ul class="pagination">
				<li class="page-item <?php if ($page<= 1) echo "disabled"?>">
				<a class="page-link" href="
				<?php 
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
					
				?>"><span aria-hidden="true">&laquo;</span></a>
				</li>
				<?php
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
				?>
				<li class="page-item <?php if ($page >= $noOfPage) echo "disabled";?>">
				<a class="page-link" href="
				<?php
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
				?>
					"><span aria-hidden="true">&raquo;</span></a>
				</li>
			</ul>
			</nav>
		</div>	  
	</div>
  </div>
  
</div>

<div class="alert cart-alert">
</div>
</body>
</html>