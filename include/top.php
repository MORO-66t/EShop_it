<!DOCTYPE html>
<html lang="en">

<head>

    <?php
			$pageName = basename($_SERVER['PHP_SELF']);
			$pageName = str_replace('.php', '', $pageName);

			if($pageName === 'index')
			{
				$pageTitle = ucwords('Online Shopping');
			}
			else
			{
				$strReplace =  str_replace('-', ' ', $pageName);
				$pageTitle = ucwords($strReplace);
			}
		?>

    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0">
    <meta name="description" content="SHOPIt is an E-commerce for buying fashion like pants , T-shirts and shoes Or Watches and AIRPODS">   
    <meta name="author" content="Mohammed Ragab">   
    <link rel="shortcut icon" href="../assets/images/favicon/faviconBackEnd.png" type="image/png">
    <title> Shop It | <?php echo $pageTitle ?> </title>
    <link rel="icon" type="image/icon" href="assets/images/favicon/shopit.jpg">

    <!--=*= CSS SOURCE FILES =*=-->
    <link rel="stylesheet" href="assets/css/bootstrap.min.css">
    <link rel="stylesheet" href="assets/css/toastr.css">
    <link rel="stylesheet" href="assets/css/style.min.css">
    <link rel="stylesheet" href="assets/css/custom.css">
    <!--=*= CSS SOURCE FILES =*=-->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Alexandria:wght@100..900&display=swap" rel="stylesheet">
    <!--=*= JS SOURCE FILES =*=-->
    <script src="assets/js/jquery.min.js"></script>
    <!--=*= JS SOURCE FILES =*=-->
    <style>
         @media screen and (max-width: 991px) {.header-bottom {display: block; margin-top: 10px; padding-top: 10px;} .header-bottom .logo, .header-bottom .cart-dropdown, .sticky-header.fixed .logo, .sticky-header.fixed .cart-dropdown {display: none;} .header-middle {padding-top: 0; padding-bottom: 0;} .d-none {display: block !important;} .menu.sf-arrows .sf-with-ul::after {right: auto;}} @media screen and (max-width: 540px) {.centerOnMobile {text-align: center;} .menu>li>a, .menu li a {font-size: smaller; padding: 0;} .menu li {padding-left: 1rem; padding-right: 1rem;} .d-none {display: block !important;} .cart-quantity {text-align: center !important;} .leonardo, .shpe {display: none !important;} .menu.sf-arrows .sf-with-ul::after {right: auto;}} .sticky-wrapper {position: -webkit-sticky; top: 0; z-index: 1000; background-color: white; padding-top: 10px;} .header-menu {z-index: 10000;} .header {padding: 10px; background-color: #f8f9fa; border-bottom: 1px solid #ddd;} body {font-family: "Alexandria", sans-serif; font-optical-sizing: auto; font-weight: 400; font-style: normal;} .menu>li>a {font-family: "Alexandria", sans-serif; font-optical-sizing: auto; font-weight: 400; font-style: normal;} .menu.sf-arrows .sf-with-ul::after {right: auto;} .footer {background-color: #181f25; color: #fff; font-size: 14px; line-height: 24px; font-family: "Cairo", sans-serif; border-radius: 15px; margin: 0 20px; padding: 0px 0px 20px 0px;}
    </style>
</head>


<body>

    <?php
		include("Eloquent.php");
        $eloquent = new Eloquent;
        if (isset($_POST['add_to_cart'])) {

            if (@$_SESSION['SSCF_login_id'] > 0) {
                $columnName = "*";
                $tableName = "shopcarts";
                $whereValue["customer_id"] = $_SESSION['SSCF_login_id'];
                $whereValue["product_id"] = $_POST['cart_product_id'];
                $availabilityInCart = $eloquent->selectData($columnName, $tableName, @$whereValue);
     
                if (!empty($availabilityInCart)) {
                    $columnValue["quantity"] = $_POST['cart_product_quantity'] + $availabilityInCart[0]['quantity'];
                    $whereValue["customer_id"] = $_SESSION['SSCF_login_id'];
                    $whereValue["product_id"] = $_POST['cart_product_id'];
                    $updateCartResult = $eloquent->updateData($tableName, $columnValue, @$whereValue);
                    $_SESSION['ADD_TO_CART_RESULT'] = $updateCartResult;
                } else {
                    try{
                    $columnValue["customer_id"] = @$_SESSION['SSCF_login_id'];
                    $columnValue["product_id"] = $_POST['cart_product_id'];
                    $columnValue["quantity"] = $_POST['cart_product_quantity'];
                    $columnValue["color"] =  $_POST['cart_product_color']?? null ; // Add color data
                    $columnValue["size"] = $_POST['cart_product_size']?? null;
                    $columnValue["created_at"] = date("Y-m-d H:i:s");
                    $addToCartResult = $eloquent->insertData($tableName, $columnValue);
                    $_SESSION['ADD_TO_CART_RESULT'] = $addToCartResult;
                }  catch (Exception $e) {}
                }
            } else {
                $_SESSION['ADD_TO_CART_RESULT'] = 0;
            }
        }
		
        $columnName = $tableName = $whereValue = null;
		$columnName = "*";
		$tableName = "categories";
		$whereValue['category_status'] = "Active";
		$categoryMenu = $eloquent->selectData($columnName, $tableName, @$whereValue);


      $columnName = $tableName = $joinType = $onCondition = $whereValue = $formatBy = null;
      $columnName["1"] = "shopcarts.quantity";
      $columnName["2"] = "products.id";
      $columnName["3"] = "products.product_name";
      $columnName["4"] = "products.product_price";
      // $columnName["5"] = "products.product_master_image";
      $columnName["5"] = "shopcarts.size";
      $columnName["6"] = "shopcarts.color";
      $tableName["MAIN"] = "shopcarts";
      $joinType = "INNER";
      $tableName["1"] = "products";
      $onCondition["1"] = ["shopcarts.product_id", "products.id"];
      $whereValue["shopcarts.customer_id"] = @$_SESSION['SSCF_login_id'];
      $formatBy["DESC"] = "shopcarts.id";
      $myaddcartItems = $eloquent->selectJoinData($columnName, $tableName, $joinType, $onCondition, @$whereValue,
      @$formatBy, @$paginate);

     
    ?> 
        <head>
        <meta charset="utf-8">
        <title>EShopper </title>
        <meta content="width=device-width, initial-scale=1.0" name="viewport">
        <meta content="Free HTML Templates" name="keywords">
        <meta content="Free HTML Templates" name="description">

        <!-- Favicon -->
        <link href="img/favicon.ico" rel="icon">

        <!-- Google Web Fonts -->
        <link rel="preconnect" href="https://fonts.gstatic.com">
        <link
            href="https://fonts.googleapis.com/css2?family=Poppins:wght@100;200;300;400;500;600;700;800;900&display=swap"
            rel="stylesheet">
            <script src="https://cdn.ckeditor.com/ckeditor4/4.16.1/standard/ckeditor.js"></script>

        <!-- Font Awesome -->
        <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.10.0/css/all.min.css" rel="stylesheet">

        <!-- Libraries Stylesheet -->
        <link href="lib/owlcarousel/assets/owl.carousel.min.css" rel="stylesheet">

        <!-- Customized Bootstrap Stylesheet -->
        <link href="css/style.css" rel="stylesheet">
    </head>
<div class="page-wrapper">
<header class="header" id="header">
    <div class="header-middle">
        <div class="container">
            <div class="col-lg-3 d-none d-lg-block" style="padding-right: 5px;padding-left: 5px;">
                <div class="header-left">
                    <a href="index.php" class="logo text-decoration-none">
                        <h1 class="m-0 display-5 font-weight-semi-bold"><span
                                class="text-primary font-weight-bold border px-3 mr-1">E</span><span class="leonardo">SHOPIt</span>
                        </h1>
                    </a>
                </div>
            </div>
            <div class="col-lg-6 col-6 text-left" style="height: 50px;">
                <form action="search.php" method="post">
                    <div class="input-group">
                        <input type="search" class="form-control" name="keywords" id="search"
                            placeholder="Write the word you're searching for " aria-label="Search" required>
                        <div class="input-group-append">
                            <!-- <span class="input-group-text bg-transparent text-primary"> -->
                            <button class=" my-2 my-sm-0" type="submit"><i
                                    class="fa fa-search"></i></button>
                            <!-- </span> -->
                        </div>
                        <div class="list-group list-group-flush list-style" id="show-list">
                        </div>
                    </div>
                </form>
            </div>
            <div class="header-right">
                <div class="header-dropdown dropdown-expanded">
                    <a href="#">My Account</a>
                    <div class="header-menu">
                        <ul>
                            <li><a href="dashboard.php">My Account </a></li>
                            <?php 
					if(@$_SESSION['SSCF_login_id'] > 0) 
					{
						echo '<li><a href="?exit=yes">Log out</a></li>';
					}
					else 
					{
						echo '<li><a href="login.php">Log in</a></li>';	
					} 
				?>
                        </ul>
                    </div>
                </div>
                <div class="dropdown cart-dropdown">
                    <a href="#" class="dropdown-toggle" role="button" data-toggle="dropdown"
                        aria-haspopup="true" aria-expanded="false" data-display="static"
                        style="padding-left: 26px;">
                        <span class="cart-count"> <?php echo count(@$myaddcartItems); ?> </span>
                    </a>
                    <div class="dropdown-menu">
                        <div class="dropdownmenu-wrapper">
                            <div class="dropdown-cart-header">
                                <span><?php echo count(@$myaddcartItems); ?> count</span>
                                <?php
						if(count(@$myaddcartItems) > 0)
						{
							echo '<a href="cart.php"> cart </a>';
						}
						else
						{
							echo '<a href="index.php"> cart </a>';
						}
					?>
                            </div>
                            <div class="dropdown-cart-products">
                                <?php 
						$subTotal = 0;
						foreach(@$myaddcartItems AS $eachCartItem)
						{
                                        $columnName = $tableName = $whereValue = $inColumn = $inValue = $formatBy = $paginate = null;
			                $columnName = "*";
			                $tableName = "product_images";
			                $whereValue["product_id"] = $eachCartItem['id'];
			                $paginate["POINT"] = 0;
			                $paginate["LIMIT"] = 1;
			                $its_photo = $eloquent->selectData($columnName, $tableName, @$whereValue, @$inColumn, @$inValue, @$formatBy, @$paginate);
							$image = $its_photo[0]['image_name'];
				// if ($eachCartItem['id'] < 142) {
				
				// 	$image =  $GLOBALS['PRODUCT_DIRECTORY'] . $its_photo[0]['image_name'];
				// }
							echo '
							<div class="product">
								<div class="product-details">
									<h4 class="product-title">
										<a href="product.php?id='. $eachCartItem['id'] .'">'.$eachCartItem['product_name'].'</a>
									</h4>
									 <span class="cart-product-info">
            <span class="cart-product-qty">'.$eachCartItem['quantity'].'</span> X '.$GLOBALS['CURRENCY']. ' ' . $eachCartItem['product_price'].'
            <br>
            <small>Size: '.$eachCartItem['size'].'</small>
            <br>
            <small>Color: '.$eachCartItem['color'].'</small>
        </span>
        </div>
								<figure class="product-image-container">
									<a href="product.php?id='. $eachCartItem['id'] .'" class="checkout-image">
                                                
										<img src="'. $image.'" alt="product">
									</a>
								</figure>
							</div>
							';
							$subTotal += ($eachCartItem['quantity'] * $eachCartItem['product_price']);
						}
					?>
                            </div>
                            <div class="dropdown-cart-total">
                                <span>Product Price</span>
                                <span
                                    class="cart-total-price"><?php echo $GLOBALS['CURRENCY'] . " " . $subTotal; ?></span>
                            </div>
                            <div class="dropdown-cart-action">
                                <?php
						if(count(@$myaddcartItems) > 0)
						{
							echo '<a href="cart.php" class="btn btn-block"> اطلب الان </a>';
						}
						else
						{
							echo '<a href="index.php" class="btn btn-block"> اطلب الان  </a>';
						}
					?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="header-bottom sticky-header">
        <div class="container">
            <nav class="main-nav">
                <ul class="menu sf-arrows">
                    <li class="active"><a href="index.php">Home</a></li>
                    <?php

			foreach($categoryMenu as $eachCategory)
			{
				echo'
				<li><a href="#" class="sf-with-ul">'.$eachCategory['category_name'].'</a>
				<ul>';
				
				
				$columnName = $tableName = $whereValue = null;
				$columnName = "*";
				$tableName = "subcategories";
				$whereValue['category_id'] = $eachCategory['id'];
				$subcategoryMenu = $eloquent->selectData($columnName, $tableName, @$whereValue);	
				
				foreach($subcategoryMenu as $eachSubcategory)
				{
					echo '<li><a href="category.php?id='.$eachSubcategory['id'].'">'.$eachSubcategory['subcategory_name'].'</a></li>';
				}
				
				echo '</ul>
				</li>';
			}
		?>
                </ul>
            </nav>
        </div>
    </div>
</header>