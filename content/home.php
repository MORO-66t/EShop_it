<?php
$eloquent = new Eloquent;
function productLister($productList)

    {

        if (!is_array($productList)) {

            echo '<p>No products available.</p>';

            return;

        }

        $displayedProductIds = [];
        foreach($productList as $eachProduct)

        {
			 if (in_array($eachProduct['id'], $displayedProductIds)) {

                continue;

            }

			  $displayedProductIds[] = $eachProduct['id'];

            $productImage = "http://www.placehold.it/200x150/EFEFEF/AAAAAA&text=no+image";

            if (!empty($eachProduct['img'])) {

                $productImage = $eachProduct['img'];

            }
            echo '

            <div class="col-6 col-md-3">

                <div class="product">

                    <figure class="product-image-container">

                        <a href="product.php?id=' . $eachProduct['id'] . '" class="home-image">

                            <img src="' . $productImage . '" alt="product" style="width: 277px; height: 277px;">

                        </a>

                        <a href="product.php?id=' . $eachProduct['id'] . '" class="btn-quickview">تفاصيل اكتر</a>

                    </figure>

                    <div class="product-details">

                        <!--<div class="ratings-container">

                            <div class="product-ratings">

                                <span class="ratings" style="width:80%"></span>

                            </div>

                        </div>-->

                        <h2 class="product-title">

                            <a href="product.php?id=' . $eachProduct['id'] . '">' . $eachProduct['name'] . '</a>

                        </h2>

                        <div class="price-box">

                            <span class="product-price">' . $GLOBALS['CURRENCY'] . " " . $eachProduct['price'] . '</span>

                        </div>

                        <div class="product-action">

                            <form method="post" action="">

                                <input type="hidden" name="cart_product_id" value="' . $eachProduct['id'] . '"/>

                                <input type="hidden" name="cart_product_quantity" value="1"/>

                                <button name="add_to_cart" class="paction add-cart" type="submit" title="Add to Cart" style="margin-left: 7px; padding-top: 6px;">

                                    <strong><span>اضف الي السلة</span> </strong>

                                </button>

                            </form>

                        </div>

                    </div>

                </div>

            </div>';

        }

    }

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
    "products.category_id" => 1,    // Men's Category ID
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
    "products.category_id" => 2,    // Women's Category ID
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
    "products.category_id" => 8,    // Watch Category ID
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
							<a class="nav-link active" id="featured-products-tab" data-toggle="tab" href="#featured-products" role="tab" aria-controls="featured-products" aria-selected="true">رجالي</a>
						</li>
					</ul>
					<div class="tab-content">
						<div class="tab-pane fade show active" id="featured-products" role="tabpanel" aria-labelledby="featured-products-tab">
							<div class="row row-sm">
								
							<?php
								#== MEN'S PRODUCT BASE ON LAST ADDED AND IN STOCK
								productLister($menProducts);
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
							<a class="nav-link active" id="featured-products-tab" data-toggle="tab" href="#featured-products" role="tab" aria-controls="featured-products" aria-selected="true">حريمي</a>
						</li>
					</ul>
					<div class="tab-content">
						<div class="tab-pane fade show active" id="featured-products" role="tabpanel" aria-labelledby="featured-products-tab">
							<div class="row row-sm">
								
							<?php
								#== WOMEN'S PRODUCT BASE ON LAST ADDED AND IN STOCK
								productLister($watchProducts);
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
							<a class="nav-link active" id="featured-products-tab" data-toggle="tab" href="#featured-products" role="tab" aria-controls="featured-products" aria-selected="true">ساعات</a>
						</li>
					</ul>
					<div class="tab-content">
						<div class="tab-pane fade show active" id="featured-products" role="tabpanel" aria-labelledby="featured-products-tab">
							<div class="row row-sm">
								
							<?php
								#== WATCH'S PRODUCT BASE ON LAST ADDED AND IN STOCK
								productLister($womenProducts);
							?>
								
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>


</main>