<?php
$eloquent = new Eloquent;


if(isset($_REQUEST['id']))
{
	$_SESSION['SSCF_product_product_id'] = $_REQUEST['id'];
}

$columnName = $tableName = $whereValue = $inColumn = $inValue = $formatBy = $paginate = null;
$columnName = "*";
$tableName = "product_images";
$whereValue["product_id"] = $_SESSION['SSCF_product_product_id'];
$imagesResult = $eloquent->selectData($columnName, $tableName, @$whereValue, @$inColumn, @$inValue, @$formatBy, @$paginate);


$columnName = $tableName = $whereValue = null;
$columnName = "*";
$tableName = "products";
$whereValue["id"] = $_SESSION['SSCF_product_product_id'];
$productResult = $eloquent->selectData($columnName, $tableName, @$whereValue);



$columnName = $tableName = $whereValue = null;
$columnName["1"] = "categories.id";
$columnName["2"] = "categories.category_name";
$columnName["3"] = "subcategories.id";
$columnName["4"] = "subcategories.subcategory_name";
$tableName["MAIN"] = "products";
$joinType = "INNER";
$tableName["1"] = "categories";
$tableName["2"] = "subcategories";
$onCondition["1"] = ["categories.id", "products.category_id"];
$onCondition["2"] = ["subcategories.id", "products.subcategory_id"];
$whereValue["products.id"] = $_SESSION[''];
$breadcrumbName = $eloquent->selectJoinData($columnName, $tableName, $joinType, $onCondition, @$whereValue, @$formatBy);
?>

<main class="main">
    <nav aria-label="breadcrumb" class="breadcrumb-nav">
        <div class="container">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="index.php"></a></li>
                <li class="breadcrumb-item"><a href="#"></a><?= @$breadcrumbName[0]['category_name']; ?></li>
                <li class="breadcrumb-item active" aria-current="page"><?= @$breadcrumbName[0]['subcategory_name']; ?>
                </li>
            </ol>
        </div>
    </nav>
    <div class="container">
        <div class="row">
            <div class="col-lg-9">
                <div class="product-single-container product-single-default">
                    <div class="row">
                        <div class="col-lg-7 col-md-6 product-single-gallery">
                            <div class="product-slider-container product-item">

                                <div class="product-single-carousel owl-carousel owl-theme">

                                    <?php
                                    echo '
                                    <div class="product-item">
                                        <img class="product-single-image" src="'. $imagesResult[0]['image_name'] .'"
                                        data-zoom-image="'. $imagesResult[0]['image_name'].'">
                                    </div>									
                                    ';
                                    ?>

                                </div>
                                <span class="prod-full-screen"><i class="icon-plus"></i></span>

                            </div>

                            <div class="prod-thumbnail row owl-dots" id='carousel-custom-dots'>

                                <?php
                                echo '
                                <div class="col-3 owl-dot">
                                    <img src="'. $imagesResult[1]['image_name'] .'"/>
                                </div>										
                                ';
                                // print_r($imagesResult);
                                foreach($imagesResult as $eachImage) 
                                {
                                    $image = $eachImage['image_name'];
                                    echo '
                                    <div class="col-3 owl-dot">
                                        <img src="'. $image .'"/>
                                    </div>										
                                    ';
                                    
                                }
                                ?>

                            </div>
                            <!--=*= PRODUCT IMAGE THUMBNAIL END =*=-->
                        </div>
                        <div class="col-lg-5 col-md-6">
                            <div class="product-single-details">
                                <h1 class="product-title">

                                    <?php
										 echo   $productResult[0]['product_name']; 
									?>
                                </h1>
                                <div class="price-box">
                                    <span class="product-price">

                                        <?php

											echo $GLOBALS['CURRENCY'] . " " . $productResult[0]['product_price'];
										?>

                                    </span>
                                </div>
                                <div class="product-desc">
                                </div>
                                <?php
                foreach ($productResult as $eachImage) {
                    $colorString = $eachImage['color'];
                    $sizeString = $eachImage['size'];
                
                    // Process colors
                    if (!empty($colorString)) {
                        if (strpos($colorString, ',') !== false) {
                            $colorArray = explode(',', $colorString);
                            $colorArray = array_map('trim', $colorArray);
                        } else {
                            $colorArray = [$colorString];
                        }
                    
                        echo '<div class="d-flex mb-4 "  style="
                    margin-bottom: 0px !important;
                ">
                <p class="text-dark font-weight-medium mb-0 mr-3">Colors:</p>
                <form id="cart-form">';
        
        foreach ($colorArray as $index => $color) {
            $id = 'color-' . ($index + 1);
            echo '<div class="custom-control custom-radio custom-control-inline">
                    <input type="radio" class="custom-control-input" id="' . $id . '" name="color" value="' . htmlspecialchars($color) . '">
                    <label class="custom-control-label" for="' . $id . '">' . htmlspecialchars($color) . '</label>
                  </div>';
        }

        echo '</form></div>';
    }

    // Process sizes
    if (!empty($sizeString)) {
        if (strpos($sizeString, ',') !== false) {
            $sizeArray = explode(',', $sizeString);
            $sizeArray = array_map('trim', $sizeArray);
        } else {
            $sizeArray = [$sizeString];
        }

        echo '<div class="d-flex mb-4" style="
    margin-bottom: 0px !important;
">
                <p class="text-dark font-weight-medium mb-0 mr-3">Sizes:</p>
                <form>';
        
        foreach ($sizeArray as $index => $size) {
            $id = 'size-' . ($index + 1);
            echo '<div class="custom-control custom-radio custom-control-inline">
                    <input type="radio" class="custom-control-input" id="' . $id . '" name="size" value="' . htmlspecialchars($size) . '">
                    <label class="custom-control-label" for="' . $id . '">' . htmlspecialchars($size) . '</label>
                  </div>';
        }

        echo '</form></div>';
    }
}

echo '<div class="product-action product-all-icons">
        <div class="d-flex d-block d-inline">
            <div class="product-single-qty">
            <span> How many do you need?</span>
                <input id="quantity-input" class="horizontal-quantity form-control" type="number" value="1" min="1" />
            </div>
            <form method="post" action="" id="cart-form" onsubmit="updateFormData()">
                <input type="hidden" name="cart_product_id" value="' . $_SESSION[''] . '" />
                <input type="hidden" id="hidden-quantity" name="cart_product_quantity" value="1" />
                <input type="hidden" id="hidden-color" name="cart_product_color" value="" />
                <input type="hidden" id="hidden-size" name="cart_product_size" value="" />
                <button type="submit" name="add_to_cart" class="paction add-cart" title="Add to Cart" style="margin-left: 7px; padding-top: 6px;">
                    <span>Add to the cart</span>
                </button>
            </form>
        </div>
      </div>';
?>
                                <script>
                                function updateFormData() {
                                    var quantity = document.getElementById('quantity-input').value;
                                    document.getElementById('hidden-quantity').value = quantity;

                                    // Get selected color
                                    var color = document.querySelector('input[name="color"]:checked');
                                    if (color) {
                                        document.getElementById('hidden-color').value = color.value;
                                    }

                                    // Get selected size
                                    var size = document.querySelector('input[name="size"]:checked');
                                    if (size) {
                                        document.getElementById('hidden-size').value = size.value;
                                    }
                                }
                                </script>


                                <script>
                                function updateQuantity() {
                                    var quantity = document.getElementById('quantity-input').value;
                                    document.getElementById('hidden-quantity').value = quantity;
                                }
                                </script>


                            </div>
                        </div>
                    </div>
                </div>
                <div class="product-single-tabs">
                    <ul class="nav nav-tabs" role="tablist">
                        <li class="nav-item">
                            <a class="nav-link active" id="product-tab-desc" data-toggle="tab"
                                href="#product-desc-content" role="tab" aria-controls="product-desc-content"
                                aria-selected="true">Description</a>
                        </li>
                        <style>
                            .x3nfvp2 .x1j61x8r .x1fcty0u .xdj266r {
                                display: inline;

                            }
                            img {
                                display: inline !important;
                            }
                        </style>
                    </ul>
                    <div class="tab-content">
                        <div class="tab-pane fade show active" id="product-desc-content" role="tabpanel"
                            aria-labelledby="product-tab-desc">
                            <div class="product-desc-content text-justify">
                                <div class="tab-content">
                                    <div class="tab-pane fade show active" id="product-desc-content" role="tabpanel"
                                        aria-labelledby="product-tab-desc">
                                        <div class="product-desc-content text-justify" style="direction: rtl; text-align: right;">
                                            <?php
                                                $prodDescription = htmlspecialchars_decode($productResult[0]['product_details']);
                                                echo $prodDescription;
                                                ?>
                                        </div>
                                    </div>
                                </div>
                                <!-- <?php 
                                    
									$prodDescription = htmlspecialchars_decode($productResult[0]['product_details']);
									
									$getData = strip_tags($prodDescription, '<p><li>');
									$listItem = explode('<li>', $getData);
									
									echo $listItem[0];
									
									$onlyListItem = array_shift($listItem);
									
									foreach($listItem AS $eachList)
									{
										echo '<li style="list-style: none;"><i class="icon-ok"></i> '.$eachList.'</li>';
									}
								?> -->

                            </div>
                        </div>
                       
                    </div>
                </div>
            </div>
            
        </div>
    </div>

    </div>
</main>
