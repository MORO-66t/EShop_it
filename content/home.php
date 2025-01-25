<?php
include("Controller.php");
include("HomeController.php");
$homeCtrl = new HomeController;
$eloquent = new Eloquent;
## ===*=== [F]ETCH MEN'S PRODUCT LIST FOR SHOWING HOME PAGE PRODUCT ===*=== ##
$columnName = $tableName = $whereValue = null;
$columnName = [
    "products.id",
    "products.product_name",
    "products.product_price",
    "product_images.image_name"
];
$tableName = [
    "MAIN" => "products",
    "product_images" => "product_images"
];
$onCondition = [
    "product_images" => ["products.id", "product_images.product_id"]
];
$whereValue = [
    "products.category_id" => 13,    // Men's Category ID
    "products.product_status" => "In Stock"
];
$formatBy = ["DESC" => "products.id"];
$paginate = ["POINT" => 0, "LIMIT" => 8];
$menProducts = $eloquent->selectJoinData($columnName, $tableName, "INNER", $onCondition, $whereValue, $formatBy, $paginate);
## ===*=== [F]ETCH MEN'S PRODUCT LIST FOR SHOWING HOME PAGE PRODUCT ===*=== ##

## ===*=== [F]ETCH WOMEN'S PRODUCT LIST FOR SHOWING HOME PAGE PRODUCT ===*=== ##
$columnName = $tableName = $whereValue = $onCondition = $formatBy = $paginate = null;
$columnName = [
    "products.id",
    "products.product_name",
    "products.product_price",
    "product_images.image_name"
];
$tableName = [
    "MAIN" => "products",
    "product_images" => "product_images"
];
$onCondition = [
    "product_images" => ["products.id", "product_images.product_id"]
];
$whereValue = [
    "products.category_id" => 14,    // Women's Category ID
    "products.product_status" => "In Stock"
];
$formatBy = ["DESC" => "products.id"];
$paginate = ["POINT" => 0, "LIMIT" => 8];
$womenProducts = $eloquent->selectJoinData($columnName, $tableName, "INNER", $onCondition, $whereValue, $formatBy, $paginate);
## ===*=== [F]ETCH WOMEN'S PRODUCT LIST FOR SHOWING HOME PAGE PRODUCT ===*=== ##

## ===*=== [F]ETCH WATCH'S PRODUCT LIST FOR SHOWING HOME PAGE PRODUCT ===*=== ##
$columnName = $tableName = $whereValue = $onCondition = $formatBy = $paginate = null;
$columnName = [
    "products.id",
    "products.product_name",
    "products.product_price",
    "product_images.image_name"
];
$tableName = [
    "MAIN" => "products",
    "product_images" => "product_images"
];
$onCondition = [
    "product_images" => ["products.id", "product_images.product_id"]
];
$whereValue = [
    "products.category_id" => 16,    // Watch Category ID
    "products.product_status" => "In Stock"
];
$formatBy = ["DESC" => "products.id"];
$paginate = ["POINT" => 0, "LIMIT" => 8];
$watchProducts = $eloquent->selectJoinData($columnName, $tableName, "INNER", $onCondition, $whereValue, $formatBy, $paginate);
## ===*=== [F]ETCH WATCH'S PRODUCT LIST FOR SHOWING HOME PAGE PRODUCT ===*=== ##
?>


<div class="container">
		<div class="row">
			<div class="col-lg-12">
				<div class="home-product-tabs">
					<ul class="nav nav-tabs" role="tablist">
						<li class="nav-item">
							<a class="nav-link active" id="featured-products-tab" data-toggle="tab" href="#featured-products" role="tab" aria-controls="featured-products" aria-selected="true">Men's</a>
						</li>
					</ul>
					<div class="tab-content">
						<div class="tab-pane fade show active" id="featured-products" role="tabpanel" aria-labelledby="featured-products-tab">
							<div class="row row-sm">
								
							<?php
								#== MEN'S PRODUCT BASE ON LAST ADDED AND IN STOCK
								$homeCtrl->productLister($menProducts);
							?>
								
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
		<div class="row">
			<div class="col-lg-12">
				<div class="home-product-tabs">
					<ul class="nav nav-tabs" role="tablist">
						<li class="nav-item">
							<a class="nav-link active" id="featured-products-tab" data-toggle="tab" href="#featured-products" role="tab" aria-controls="featured-products" aria-selected="true">Women's</a>
						</li>
					</ul>
					<div class="tab-content">
						<div class="tab-pane fade show active" id="featured-products" role="tabpanel" aria-labelledby="featured-products-tab">
							<div class="row row-sm">
								
							<?php
								#== WOMEN'S PRODUCT BASE ON LAST ADDED AND IN STOCK
								$homeCtrl->productLister($watchProducts);
							?>
								
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
		<div class="row">
			<div class="col-lg-12">
				<div class="home-product-tabs">
					<ul class="nav nav-tabs" role="tablist">
						<li class="nav-item">
							<a class="nav-link active" id="featured-products-tab" data-toggle="tab" href="#featured-products" role="tab" aria-controls="featured-products" aria-selected="true">shoes</a>
						</li>
					</ul>
					<div class="tab-content">
						<div class="tab-pane fade show active" id="featured-products" role="tabpanel" aria-labelledby="featured-products-tab">
							<div class="row row-sm">
								
							<?php
								#== WATCH'S PRODUCT BASE ON LAST ADDED AND IN STOCK
								$homeCtrl->productLister($womenProducts);
							?>
								
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>


</main>