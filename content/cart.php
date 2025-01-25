<?php

$eloquent = new Eloquent;

if(isset($_POST['update_cart']))
{
	$columnValue = $tableName = $whereValue = null;
	$tableName = "shopcarts";
	$columnValue["quantity"] = $_POST['quantity'];
	$whereValue["id"] = $_POST['cart_id'];
	$updateCartItem = $eloquent->updateData($tableName, $columnValue, @$whereValue);
}


if(isset($_POST['remove_cart']))
{
	$tableName = $whereValue = null;
	$tableName = "shopcarts";
	$whereValue["id"] = $_POST['remove_id'];
	$deleteCart = $eloquent->deleteData($tableName, @$whereValue);
}


## ===*=== [F]ETCH CART PRODUCTS DATA FOR USER'S VISUALIZATION ===*=== ##
$columnName = $tableName = $joinType = $onCondition = $whereValue = $formatBy = $paginate = null;
$columnName["1"] = "shopcarts.quantity";
$columnName["2"] = "shopcarts.id";
$columnName["3"] = "products.product_name";
$columnName["4"] = "products.product_price";
$columnName["5"] = "shopcarts.size";
$columnName["6"] = "shopcarts.color";
$tableName["MAIN"] = "shopcarts";
$joinType = "INNER";
$tableName["1"] = "products";
$onCondition["1"] = ["shopcarts.product_id", "products.id"];
$whereValue["shopcarts.customer_id"] = @$_SESSION['SSCF_login_id'];
$formatBy["DESC"] = "shopcarts.id";
$myShopcartItems = $eloquent->selectJoinData($columnName, $tableName, $joinType, $onCondition, @$whereValue, @$formatBy, @$paginate);

$columnName = $tableName = $joinType = $onCondition = $whereValue = $formatBy = $paginate = null;
$columnName["1"] = "shopcarts.quantity";
$columnName["2"] = "shopcarts.id";
$columnName["3"] = "products.product_name";
$columnName["4"] = "products.product_price";
$columnName["5"] =  "product_images.image_name ";
$columnName["6"] = "shopcarts.size";
$columnName["7"] = "shopcarts.color";
$tableName["MAIN"] = "shopcarts";
$joinType = "INNER";
$tableName["1"] = "products";
$tableName["2"] = "product_images";
$onCondition["1"] = ["shopcarts.product_id", "products.id"];
$onCondition["2"] = ["products.id" , "product_images.product_id"];
$whereValue["shopcarts.customer_id"] = @$_SESSION['SSCF_login_id'];
$formatBy["DESC"] = "shopcarts.id";
$mypho = $eloquent->selectJoinData($columnName, $tableName, $joinType, $onCondition, @$whereValue, @$formatBy, @$paginate);
?>

<!--=*= CART SECTION START =*=-->
<main class="main">
	<nav aria-label="breadcrumb" class="breadcrumb-nav mb-1">
		<div class="container">
			<ol class="breadcrumb">
				<li class="breadcrumb-item"><a href="index.php">Home</a></li>
				<li class="breadcrumb-item active" aria-current="page">Shopping Cart</li>
			</ol>
		</div>
	</nav>
	<div class="container">
		<div class="row">
			<div class="col-lg-8">
				
				<?php 
					#== DELETE CONFIRMATION MESSAGE
					if(isset($_POST['remove_cart']))
					{
						if($deleteCart > 0)
						{
							echo '<div class="alert alert-success">Successfully removed from the cart</div>';
						} 
						else 
						{
							echo '<div class="alert alert-danger">We couldnt remove it. Make sure theres no error or contact us</div>';
						}
					}
				?>
				
				<div class="cart-table-container">
					<table class="table table-cart">
						<thead>
							<tr>
								<th class="product-col">Product</th>
								<th class="price-col">Price</th>
								<th class="qty-col">Quantity</th>
								<th class="price-col">Total Price</th>
								<th class="size-col">Size</th> <!-- Added Size Header -->
                                <th class="color-col">Color</th> <!-- Added Color Header -->
								<th >Update Changes</th>
							</tr>
						</thead>
						<tbody>
							
							<?php
							$displayedProducts = [];
								#== DYNAMIC CART PRODUCT LIST
								foreach($mypho  AS $eachCartItems)
								{
									$productId = $eachCartItems["id"];

                                // Check if the product has already been displayed
                                if (!in_array($productId, $displayedProducts)) {
                                    $displayedProducts[] = $productId;
									$image = $eachCartItems['image_name'];
									
									echo '
									<form method="post" action="">
										<tr class="product-row">
											<td class="product-col">
												<figure class="product-image-container">
													<a href="product.php?id='. $eachCartItems['id'].'" class="shopcart-image">
														<img src="' . $image. '" alt="product">
													</a>
												</figure>
												<h2 class="product-title">
													<a href="product.php?id='. $eachCartItems['id'].'">'.$eachCartItems['product_name'].'</a>
												</h2>
											</td>
											<td>' . $GLOBALS['CURRENCY'] . " " . $eachCartItems['product_price']. '</td>
											<td style="max-width: 60px; class="cart-quantity">
												<input name="quantity" class="form-control" type="number" style=" padding-left: 10px; padding-right: 0px; padding-top: 0px; padding-bottom: 0px;" min="1" value="'.@$eachCartItems['quantity'].'">
											</td>
											<td>' . $GLOBALS['CURRENCY'] . " " . ($eachCartItems['product_price'] * $eachCartItems['quantity']) . '</td>
											<td class="size-col">'. @$eachCartItems['size'] .'</td> <!-- Display Size -->
                                            <td class="color-col">'. @$eachCartItems['color'] .'</td> <!-- Display Color -->
											<td class="bb">
												<div class="d-flex checkout-steps-action">
													<input type="hidden" name="cart_id" value=" ' . $eachCartItems['id'] . ' " />
													<button name="update_cart" type="submit" class="btn btn-sm btn-outline-info">Update التغير</button> &nbsp;
													<input type="hidden" name="remove_id" value=" ' . $eachCartItems['id'] . ' " />
													<button name="remove_cart" type="submit" class="btn btn-sm btn-outline-danger">Remove Product</button>
												</div>
											</td>
										</tr>
									</form>
									';
								}
							}
							?>
							
						</tbody>
						<tfoot>
							<tr>
								<td colspan="8" class="clearfix">
									<div class="float-left">
										<a href="index.php" class="btn btn-outline-success">Return to continue shopping</a>
									</div>
								</td>
							</tr>                    
						</tfoot>
					</table>
				</div>
			</div>
<!-- //////////////////////////////////////////////////////////////// -->

			<div class="col-lg-4">
				<div class="cart-summary">
					<h3>Account</h3>
					<table class="table table-totals">
						<tbody>
							<tr>
								<td>Product Price</td>
								<td>
									
									<?php 
										#== SUBTOTAL PRICE SUMMATION
										$cartSubtotal = 0;
										foreach ($myShopcartItems AS $eachSubtotal)
										{
											$cartSubtotal += ($eachSubtotal['quantity'] * $eachSubtotal['product_price']);
										}
										echo $GLOBALS['CURRENCY'] . " " . $cartSubtotal;
									?>
									
								</td>
							</tr>
							
								<?php $GLOBALS['TAX'] = 0 ; ?>
						
							<tr>
								<td>Shipping Price </td>
								<td>
									<?= $GLOBALS['CURRENCY'] . " "; ?>
									<span id="charge">40</span>
								</td>
							</tr>								
							<?php @$_SESSION['SSCF_DISCOUNT_AMOUNT'] = 0 ;?>
						</tbody>
						<tfoot>
							<tr>
								<td>total Price</td>
								<td>
									<?= $GLOBALS['CURRENCY'] . " " . $grandTotal = round((($cartSubtotal ) - @$_SESSION['SSCF_DISCOUNT_AMOUNT'])); ?>
								</td>
							</tr>
						</tfoot>
					</table>
					<span id="message" style="display: none;">
						<div class="alert alert-warning fade show" role="alert">
							Confirm <strong> Delivery Charge </strong> Prior to Order
						</div>
					</span>
					<div class="checkout-methods">

						<form action="order.php" method="post">

							<input type="hidden" name="cartsub_total" value="<?php echo $cartSubtotal; ?>">
							<input type="hidden" name="tax_total" value="<?php echo $tax; ?>">
							<input type="hidden" name="discount_amount" value="<?php echo @$_SESSION['SSCF_DISCOUNT_AMOUNT']; ?>">
							<input type="hidden" name="delivery_charge" value="40">
							<input type="hidden" name="grand_total" value="<?php echo $grandTotal; ?>">
							<button name="submit_order" id="fEvent" class="btn btn-block btn-sm btn-primary">اكمل للشراء</button>
						</form>
					</div>
				</div>
			</div>
		</div>
	</div>
	<div class="mb-6">
		<!-- CREATE A EMPTY SPACE BETWEEN CONTENT -->
	</div>
</main>

<script type="text/javascript">
	$(document).ready(function(){
		var data = $('#charge').html();
		$('#fEvent').click(function(){
			if(data == 0){
				$('#message').show();
			}
		});
	});
</script>
