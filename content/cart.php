<?php
## ===*=== [C]ALLING CONTROLLER ===*=== ##
include("Controller.php");

$control = new Controller;
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

$_POST['fob'] = 40;
if(isset($_POST['fob']))
{
	if(@$_SESSION['SSCF_login_id'] > 0)
	{
		$columnName = $tableName = $whereValue = null;
		$columnName = "*";
		$tableName = "deliveries";
		$whereValue["customer_id"] = $_SESSION['SSCF_login_id'];
		$availibilityCharge = $eloquent->selectData($columnName, $tableName, @$whereValue);
		
		if(!empty($availibilityCharge))
		{
			$_POST['shipping_method'] = 40;
			$columnValue = $tableName = $whereValue = null;
			$tableName = "deliveries";
			$columnValue["created_at"] = date("Y-m-d H:i:s");
			$columnValue["shipping_charge"] = $_POST['shipping_method'];
			$whereValue["customer_id"] = $_SESSION['SSCF_login_id'];
			$updateCharge = $eloquent->updateData($tableName, $columnValue, @$whereValue);
		}
				else
		{
			$_POST['shipping_method'] = 40;
			$columnValue = $tableName = null;
			$tableName = "deliveries";
			$columnValue["created_at"] = date("Y-m-d H:i:s");
			$columnValue["customer_id"] = $_SESSION['SSCF_login_id'];
			$columnValue["shipping_charge"] = $_POST['shipping_method'];
			$insertCharge = $eloquent->insertData($tableName, $columnValue, @$whereValue);
		}
	}
}
$columnName = $tableName = $whereValue = null;
$columnName = "*";
$tableName = "deliveries";
$deliveryCharge = $eloquent->selectData($columnName, $tableName, @$whereValue);
@$fobCost = $deliveryCharge[0]['shipping_charge'] = 40;
?>

<!--=*= CART SECTION START =*=-->
<main class="main">
	<nav aria-label="breadcrumb" class="breadcrumb-nav mb-1">
		<div class="container">
			<ol class="breadcrumb">
				<li class="breadcrumb-item"><a href="index.php">الرئيسية</a></li>
				<li class="breadcrumb-item active" aria-current="page">سلة المشتريات</li>
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
							echo '<div class="alert alert-success">تم المسح من السلة بنجاح</div>';
						} 
						else 
						{
							echo '<div class="alert alert-danger">لم نستطع الازاله تأكد من عدم وجود خطأ او تواصل معنا</div>';
						}
					}
					
					#== DISCOUNT CONFIRMATION MESSAGE
					if(isset($_POST['discount_amnt']))
					{
						if(@$getDiscount > 0) {
							echo '
							<div class="alert alert-success alert-dismissible fade show" role="alert">
								<strong>Congratulation!</strong> You have get BDT '. @$_SESSION['SSCF_DISCOUNT_AMOUNT'] .' tk discount.
								<button type="button" class="close" data-dismiss="alert" aria-label="Close">
									<span aria-hidden="true">&times;</span>
								</button>
							</div>';
						} 
						else 
						{
							echo '
							<div class="alert alert-danger alert-dismissible fade show" role="alert">
								<strong>Be Careful</strong> and don\'t try to become a fruad...!
								<button type="button" class="close" data-dismiss="alert" aria-label="Close">
									<span aria-hidden="true">&times;</span>
								</button>
							</div>';
						}
					}
				?>
				
				<div class="cart-table-container">
					<table class="table table-cart">
						<thead>
							<tr>
								<th class="product-col">المنتج</th>
								<th class="price-col">السعر</th>
								<th class="qty-col">العدد</th>
								<th class="price-col">السعر الكلي</th>
								<th class="size-col">الحجم</th> <!-- Added Size Header -->
                                <th class="color-col">اللون</th> <!-- Added Color Header -->
								<th >تعديل</th>
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
									if ($eachCartItems["id"] < 142) {
									{
										$image =  $GLOBALS['PRODUCT_DIRECTORY'] . $eachCartItems['image_name'];
									}
									}
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
													<button name="update_cart" type="submit" class="btn btn-sm btn-outline-info">تحديث التغير</button> &nbsp;
													<input type="hidden" name="remove_id" value=" ' . $eachCartItems['id'] . ' " />
													<button name="remove_cart" type="submit" class="btn btn-sm btn-outline-danger">مسح المنتج</button>
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
										<a href="index.php" class="btn btn-outline-success">ارجع لتستمر في التسوق</a>
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
					<h3>الحساب</h3>
					<table class="table table-totals">
						<tbody>
							<tr>
								<td>سعر المنتجات</td>
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
								<td>سعر الشحن </td>
								<td>
									<?= $GLOBALS['CURRENCY'] . " "; ?>
									<span id="charge">
										
										<?php 
											if(@$fobCost <= 0)
											{
												echo 0;
											}
											else 
											{
												echo @$fobCost; 
											}
										?>
										
									</span>
								</td>
							</tr>								
							<?php @$_SESSION['SSCF_DISCOUNT_AMOUNT'] = 0 ;?>
						</tbody>
						<tfoot>
							<tr>
								<td>السعر الكامل</td>
								<td>
									<?= $GLOBALS['CURRENCY'] . " " . $grandTotal = round((($cartSubtotal ) - @$_SESSION['SSCF_DISCOUNT_AMOUNT']) + $fobCost); ?>
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
						
						<?php
							if(!empty(@$fobCost))
							{
						?>
							
						<form action="order.php" method="post">
								
						<?php 
							}
						?>
							<input type="hidden" name="cartsub_total" value="<?php echo $cartSubtotal; ?>">
							<input type="hidden" name="tax_total" value="<?php echo $tax; ?>">
							<input type="hidden" name="discount_amount" value="<?php echo @$_SESSION['SSCF_DISCOUNT_AMOUNT']; ?>">
							<input type="hidden" name="delivery_charge" value="<?php echo @$fobCost; ?>">
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
