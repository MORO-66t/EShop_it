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

		<style>

                            .x3nfvp2 .x1j61x8r .x1fcty0u .xdj266r {

                                display: inline;



                            }

                            .img {

                                display: inline !important;

                            }

                        </style>
		<meta charset="UTF-8">



		<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0">

		<meta name="description" content="SHOPIt is an E-commerce for buying fashion like pants , T-shirts and shoes Or Watches and AIRPODS">

		<meta name="author" content="Mohammed Ragab">
		

		<title>SHOPIt | <?php echo $pageTitle ?> </title>

		

		<!--=*= CSS FILES SOURCE START =*=-->

		<link href="assets/js/datatable/css/demo_table.css" rel="stylesheet">

		<link href="assets/css/style.css" rel="stylesheet">

		<link href="assets/css/style-responsive.css" rel="stylesheet">

		<link href="assets/css/custom.css" rel="stylesheet">

		<!--=*= CSS FILES SOURCE END =*=-->

		

		<!--=*= JS SOURCE START =*=-->

		<script src="assets//js/jquery-3.5.1.min.js"></script>

		<script src='assets//tagplug/index.js'></script>

		<!--=*= JS SOURCE END =*=-->

	</head>

	

	<body class="sticky-header">

		<section>

			<div class="left-side sticky-left-side">														

				<div class="logo">

					<a href="dashboard.php">

						<img src="../public/assets/images/favicon/logoBackEnd.png" alt="" height="36px">

					</a>

				</div>

				<div class="logo-icon text-center">

					<a href="dashboard.php">

						<img src="../public/assets/images/favicon/logoBackEnd(1).png" alt="" height="34px" width="34px">

					</a>

				</div>

				<div class="left-side-inner">

					

					<!--=*= VISIBLE ON SMALL DEVICES =*=-->

					<div class="visible-xs hidden-sm hidden-md hidden-lg">			

						<div class="media logged-user">

							<img alt="" src="<?php echo $GLOBALS['ADMINS_DIRECTORY'] . $_SESSION['SMC_login_admin_image']; ?>" class="media-object">

							<div class="media-body">

								<h4> <a href="#"> <?php echo $_SESSION['SMC_login_admin_name']; ?> </a> </h4>

								<span> FULL STACK WEB DEVELOPER </span>

							</div>

						</div>

						<h5 class="left-nav-title"> Account Information </h5>

						<ul class="nav nav-pills nav-stacked custom-nav">

							<li>

								<a href="?exit=lock"> <i class="fa fa-user"></i> <span> Lock Screen </span> </a>

							</li>

							<li>

								<a href="?exit=yes"> <i class="fa fa-sign-out"></i> <span> Sign Out </span> </a>

							</li>

						</ul>

					</div>

					<!--=*= VISIBLE ON SMALL DEVICES =*=-->

					

					<ul class="nav nav-pills nav-stacked custom-nav">
						<?php
								echo '

								<li class="menu-list">

									<a href="#"> <i class="fa fa-folder-open"></i> <span> Manage Category </span> </a>

									<ul class="sub-menu-list">

										<li>

											<a href="create-category.php"> Create Category </a>

										</li>

										<li>

											<a href="list-category.php"> List Category </a>

										</li>

									</ul>

								</li>

								';

								echo '

								<li class="menu-list">

									<a href="#"> <i class="fa fa-list-alt"></i> <span> Manage Sub Category </span> </a>

									<ul class="sub-menu-list">

										<li>

											<a href="create-subcategory.php"> Create Sub Category </a>

										</li>

										<li>

											<a href="list-subcategory.php"> Sub Category List </a>

										</li>

									</ul>

								</li>

								';



								echo '

								<li class="menu-list">

									<a href="#"> <i class="fa fa-th"></i> <span> Manage Products </span> </a>

									<ul class="sub-menu-list">

										<li>

											<a href="create-product.php"> Create Products</a>

										</li>

										<li>

											<a href="list-product.php"> Products List </a>

										</li>

									</ul>

								</li>

								';

								echo '

								<li class="menu-list">

									<a href="#"> <i class="fa fa-tags"></i> <span> Manage Orders </span> </a> <i class="fas fa-sort-amount-up-alt"></i>

									<ul class="sub-menu-list">

										<li>

										<a href="list-order.php"> Orders List </a>

										</li>

									</ul>

								</li>';


						?>

						

					</ul>

				</div>

			</div>

				

				

				<!--=*= MAIN CONTENT START =*=-->

				<div class="main-content" >

					<div class="header-section">

						<a class="toggle-btn"> <i class="fa fa-bars"></i> </a>

						

						<form class="searchform" action="" method="post">

							<input type="text" class="form-control" name="keyword" placeholder="Search here..." />

						</form>

						

						<div class="menu-right">

							<ul class="notification-menu">

								<li>

									<a href="#" class="btn btn-default dropdown-toggle" data-toggle="dropdown">

										<img src="<?php echo $GLOBALS['ADMINS_DIRECTORY'] . $_SESSION['SMC_login_admin_image']; ?>" alt="" />

										<?php echo $_SESSION['SMC_login_admin_name']; ?> 

										<span class="caret"></span>

									</a>

									<ul class="dropdown-menu dropdown-menu-usermenu pull-right">

										<li>

											<a href="?exit=lock"><i class="fa fa-user"></i> Lock Screen </a>

										</li>

										<li>

											<a href="?exit=yes"><i class="fa fa-sign-out"></i> Log Out </a>

										</li>

									</ul>

								</li>

							</ul>

						</div>

					</div>																																																