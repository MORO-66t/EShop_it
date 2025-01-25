<?php
class HomeController extends Controller{
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

            if (!empty($eachProduct['image_name'])) {

                $productImage = $eachProduct['image_name'];

            }
            echo '

            <div class="col-6 col-md-3">

                <div class="product">

                    <figure class="product-image-container">

                        <a href="product.php?id=' . $eachProduct['id'] . '" class="home-image">

                            <img src="' . $productImage . '" alt="product" style="width: 277px; height: 277px;">

                        </a>

                        <a href="product.php?id=' . $eachProduct['id'] . '" class="btn-quickview">More Details</a>

                    </figure>

                    <div class="product-details">

                        <!--<div class="ratings-container">

                            <div class="product-ratings">

                                <span class="ratings" style="width:80%"></span>

                            </div>

                        </div>-->

                        <h2 class="product-title">

                            <a href="product.php?id=' . $eachProduct['id'] . '">' . $eachProduct['product_name'] . '</a>

                        </h2>

                        <div class="price-box">

                            <span class="product-price">' . '$' . " " . $eachProduct['product_price'] . '</span>

                        </div>

                        <div class="product-action">

                            <form method="post" action="">

                                <input type="hidden" name="cart_product_id" value="' . $eachProduct['id'] . '"/>

                                <input type="hidden" name="cart_product_quantity" value="1"/>

                                <button name="add_to_cart" class="paction add-cart" type="submit" title="Add to Cart" style="margin-left: 7px; padding-top: 6px;">

                                    <strong><span>Add to the cart</span> </strong>

                                </button>

                            </form>

                        </div>

                    </div>

                </div>

            </div>';

        }

    }
}