<?php
include("content/PageController.php");

$pageControl = new PageController;
$eloquent = new Eloquent;


if(isset($_REQUEST['id']))
{
	$_SESSION['category_subcategory_id'] = $_REQUEST['id'];
}

$categoryDetails = $pageControl->fetchData('products', 'subcategory_id', $_SESSION['category_subcategory_id']);
if(!empty($categoryDetails))
{
	#== (nod = Number of Data) 
	$nod = count($categoryDetails);
	#== (rpp = Result Per Page)
	if($nod > 8) {
		$rpp = 24;
		} else {
		$rpp = $nod;
	}
	#== (nop = Number of Page)
	$nop = ceil($nod/$rpp);
	
	#== IF THE PAGE IS NOT SET THEN ITS RENDERING FROM PAGE NO 1
	if(!isset($_GET['page'])) {
		$page = 1;
		} else {
		$page = $_GET['page'];
	}
	
	#== TEXT WILL BE RETURN THE CUMULATIVE VALUE OF DATA
	$text = 0;
	if($text >= $nod) {
		$text = $nod;
		} else if($text <= $nod) {
		$text = $rpp * $page;
	}
	
	#== (cp = Current Page) DEFINE THE DATA DISPLAYED LIMIT
	$cp = ($page -1)*$rpp;	
	$categoryDetails = $pageControl->paginateData('products', 'subcategory_id', $_SESSION['category_subcategory_id'], $cp, $rpp);

	$previous = $page - 1;
	$next = $page + 1;
	
	#== EMPTY VARIABLE WHICH RETURNS THE NUMBER OF PAGES
	$pageNumber = '';														
	for($i = 1; $i <= $nop; $i++)
	{
		$pageNumber .= '	<li class="page-item">
		<a class="page-link active" href="category.php?page='.$i.'">
		'.$i.'<span class="sr-only">(current)</span>
		</a>
		</li>
		';
	}
}


$columnName= $tableName= $whereValue= null;
$columnName["1"] = "categories.id";
$columnName["2"] = "categories.category_name";
$columnName["3"] = "subcategories.subcategory_name";
$columnName["4"] = "subcategories.subcategory_banner";
$tableName["MAIN"] = "subcategories";
$joinType = "INNER";
$tableName["1"] = "categories";
$onCondition["1"] = ["subcategories.category_id", "categories.id"];
$whereValue["subcategories.id"] = $_SESSION['category_subcategory_id'];
$categoryResult = $eloquent->selectJoinData($columnName, $tableName, $joinType, $onCondition, @$whereValue);
?>

<main class="main">
	<div class="banner banner-cat" style="background-image: url('<?php echo $GLOBALS['BANNER_DIRECTORY'] . $categoryResult[0]['subcategory_banner']; ?>');">
		<div class="banner-content container">
			<h2 class="banner-subtitle"><span> modern fashion  <?= date("Y"); ?></span></h2>
			<h1 class="banner-title">
				<?= @$categoryResult[0]['subcategory_name']; ?>
			</h1>
			<a href="#" class="btn btn-primary"> shop it now</a>
		</div>
	</div>
	<nav aria-label="breadcrumb" class="breadcrumb-nav">
		<div class="container">
			<ol class="breadcrumb">
				<li class="breadcrumb-item"><a href="index.php">HOME</a></li>
				<li class="breadcrumb-item"><a href="#"><?= @$categoryResult[0]['category_name']; ?></a></li>
				<li class="breadcrumb-item active" aria-current="page"><?= $categoryResult[0]['subcategory_name']; ?></li>
			</ol>
		</div>
	</nav>
	<div class="container">
		<nav class="toolbox horizontal-filter">
			<div class="toolbox-item">
			</nav>
			<div class="row products-body">
				<div class="col-lg-9 main-content">
					<div class="row row-sm category-grid">
						 <?php
							if(!empty($categoryDetails))
							{
								foreach($categoryDetails AS $eachCategory)
								{
									$columnName = $tableName = $whereValue = $inColumn = $inValue = $formatBy = $paginate = null;
									$columnName = "*";
									$tableName = "product_images";
									$whereValue["product_id"] = $eachCategory['id'];
									$paginate["POINT"] = 0;
									$paginate["LIMIT"] = 1;
									$its_photo = $eloquent->selectData($columnName, $tableName, @$whereValue, @$inColumn, @$inValue, @$formatBy, @$paginate);
									if(empty($its_photo[0]['image_name']))
									{
										$productImage = "<img src='public/assets/images/no-product-found.png'>";
									} 
									else 
									{
										$image = $its_photo[0]['image_name'];
											$productImage = $image;
									}
								
									
									echo '
									<div class="col-6 col-md-4 col-xl-3">
										<div class="grid-product">
											<figure class="product-image-container">
												<a href="product.php?id='.$eachCategory['id'].'" class="categoryflexgrid-image">
													<img src="'. $productImage .'" alt="product">
												</a>
												<a href="ajax/product-quick-view.html" class="btn-quickview">More details</a>
											</figure>
											<div class="product-details">
												<div class="ratings-container">
													<div class="product-ratings">
														<span class="ratings" style="width:80%"></span>
													</div>
												</div>
												<h2 class="product-title">
													<a href="product.php?id='.$eachCategory['id'].'">' . $eachCategory['product_name'] . '</a>
												</h2>
												<div class="price-box">
													<span class="product-price">' . $GLOBALS['CURRENCY'] . " " . $eachCategory['product_price'] . '</span>
												</div>
												<div class="product-grid-action d-flex justify-content-center" style="display: inline;">
													<form method="post" action="">
														
															
														<input type="hidden" name="cart_product_id" value="'. $eachCategory['id'] .'"/>
														<input type="hidden" id="hidden-color" name="cart_product_color" value="" />
                <input type="hidden" id="hidden-size" name="cart_product_size" value="" />
														<input type="hidden" name="cart_product_quantity" value="1"/>
														<button type="submit" name="add_to_cart" class="paction add-cart" title="Add to the cart " style="margin-left: 7px; padding-top: 6px;">
															<span>Add to Cart</span>
														</button>
														<button href="#" class="paction add-compare" title="Add to Compare">
															<span>Add to Compare</span>
														</button>
													</form>
												</div>
											</div>
										</div>
									</div>
									';
								}
							}
						?> 
						
					</div>
					<nav class="toolbox toolbox-pagination">
						<div class="toolbox-item toolbox-show">
							
							<?php
								if(!empty($categoryDetails))
								{
									echo '<label>Showing '. ($cp + 1) . '–' . $text . ' of ' . $nod.' results</label>'; 
								}
							?>
							
						</div>
						
						<?php
							if(!empty($categoryDetails))
							{
						?>
							
							<ul class="pagination">
								<li class="page-item">
									
									<a class="page-link page-link-btn" href="category.php?page=<?= $previous ?>">
										<span class="page-link"><i class="icon-angle-left"></i> Previous &nbsp;</span>
									</a>
								</li>
								
								<?php 
									#== PAGINATION NUMBER
									echo $pageNumber;
								?>
								
								<li class="page-item">
									<a class="page-link page-link-btn" href="category.php?page=<?= $next ?>">
										<span class="page-link">&nbsp;Next <i class="icon-angle-right"></i></span>
									</a>
								</li>
							</ul>
							
						<?php
							}
						?>
						
					</nav>
				</div>
				<div class="sidebar-overlay"></div>
				<aside class="sidebar-shop col-lg-3 order-lg-first">
					<div class="sidebar-wrapper">
						<div class="widget">
							<h3 class="widget-title">
								<a data-toggle="collapse" href="#widget-body-2" role="button" aria-expanded="true" aria-controls="widget-body-2">
									
									<?php
										#== SUBCATEGORY CATEGORY NAME
										echo $categoryResult[0]['category_name'];
									?>
									
								</a>
							</h3>
							
						</div>
						
					</div>
				</aside>
			</div>
		</div>
	</div>
	<div class="mb-5">
		<!-- CREATE A EMPTY SPACE BETWEEN CONTENT -->
	</div>
</main>
<!--=*= CATEGORY SECTION START =*=-->		