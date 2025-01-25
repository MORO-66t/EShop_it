<?php
$eloquent = new Eloquent;


## ===*=== [I]NSERT TO THE SHIPPING DATA ===*=== ##
if(isset($_POST['proceed_to_payment']))
{
	if(@$_SESSION['SSCF_login_id'] > 0)
	{
		$tableName = $columnValue = null;
		$tableName = "shippings";
		$columnValue["shipcstmr_name"] = $_POST['shipadd_fname'];
		$columnValue["customer_id"] = $_SESSION['SSCF_login_id'];
		$columnValue["order_id"] = $_SESSION['SSCF_orders_order_id'];
		$columnValue["shipcstmr_mobile"] = $_POST['shipadd_phn'];
		$columnValue["shipcstmr_profession"] = " "; 
		$columnValue["shipcstmr_streetadd"] = $_POST['shipadd_stadd'];
		$columnValue["shipcstmr_city"] = $_POST['shipadd_cty'];
		$columnValue["shipcstmr_zip"] = $_POST['shipadd_zopc'] = 0;
		$columnValue["shipcstmr_country"] = $_POST['shipadd_cntry'];
		$columnValue["created_at"] = date("Y-m-d H:i:s");
		$columnValue["notice"] = $_POST['notice'];
		$shipaddResult = $eloquent->insertData($tableName, $columnValue);
		
		$_SESSION['SSC_last_shipadd_id'] = $shipaddResult['LAST_INSERT_ID'];
		$_SESSION['SSC_last_insert_id_no'] = $shipaddResult['NO_OF_ROW_INSERTED'];
	}
}
## ===*=== [I]NSERT TO THE SHIPPING DATA ===*=== ##


##===*=== #==================# GO FOR PAYMENT SECTION START #==================# ===*===##
if(isset($_POST['proceed_to_payment']) )
{
	#== GET ORDER DETAILS FROM DATABASE
	$columnName = $tableName = $whereValue = null;
	$columnName = "*";
	$tableName = "orders";
	$whereValue['id'] = $_SESSION['SSCF_orders_order_id'];
	$orderDetailsToPay = $eloquent->selectData($columnName, $tableName, $whereValue);
	
	$_SESSION['SSCF_orders_grand_total'] = $orderDetailsToPay[0]['grand_total'];
	$post_data = array();
	$post_data['total_amount'] = $orderDetailsToPay[0]['grand_total'];
	$post_data['currency'] = "ج.م";
	$post_data['tran_id'] = $orderDetailsToPay[0]['id'];

	#== [C]USTOMER INFORMATION | REQUIRED
	$post_data['cus_name'] = $_SESSION['SSCF_login_user_name'];
	$post_data['cus_email'] = $_SESSION['SSCF_login_user_email'];
	$post_data['cus_add1'] = $_SESSION['SSCF_login_user_address'];
	$post_data['cus_add2'] = "";
	$post_data['cus_city'] = "";
	$post_data['cus_state'] = "";
	$post_data['cus_postcode'] = "";
	$post_data['cus_country'] = "Egypt";
	$post_data['cus_phone'] = $_SESSION['SSCF_login_user_mobile'];
	$post_data['cus_fax'] = "";
	
	#== [S]HIPMENT INFORMATION | REQUIRED
	$post_data['ship_name'] = @$_SESSION['SSCF_ship_cstmr_name'];
	$post_data['ship_add1 '] = @$_SESSION['SSCF_ship_cstmr_addr'];
	$post_data['ship_add2'] = "";
	$post_data['ship_city'] = @$_SESSION['SSCF_ship_cstmr_city'];
	$post_data['ship_state'] = "";
	$post_data['ship_postcode'] = @$_SESSION['SSCF_ship_cstmr_zip'];
	$post_data['ship_country'] = @$_SESSION['SSCF_ship_cstmr_cntry'];
	
	#== [O]PTIONAL PARAMETERS | REQUIRED
	$post_data['value_a'] = "ref001";
	$post_data['value_b'] = "ref002";
	$post_data['value_c'] = "ref003";
	$post_data['value_d'] = "ref004";
	
	$_SESSION['payment_values'] = array();
	$_SESSION['payment_values']['tran_id'] = $post_data['tran_id'];
	$_SESSION['payment_values']['amount'] = $post_data['total_amount'];
	$_SESSION['payment_values']['currency'] = $post_data['currency'];
	#== [I]NTEGRATE PAYMENT GATEWAY END
}
##===*=== #==================# GO FOR PAYMENT SECTION END #==================# ===*===##


## ===*=== [F]ETCH SHIPPING DATA ===*=== ##
$tableName = $columnName = $whereValue =  null;
$columnName = "*";
$tableName = "shippings";
$whereValue["id"] = $_SESSION['SSC_last_shipadd_id'];
$shipcstmResult = $eloquent->selectData($columnName, $tableName, $whereValue);

#== CREATE SESSION ON SHIPPING DATA WHICH IS USED ON PAYMENT GATEWAY INTEGRATION
$_SESSION['SSCF_ship_cstmr_id'] = $shipcstmResult[0]['id'];
$_SESSION['SSCF_ship_cstmr_order_id'] = $shipcstmResult[0]['order_id'];
$_SESSION['SSCF_ship_cstmr_name'] = $shipcstmResult[0]['shipcstmr_name'];
$_SESSION['SSCF_ship_cstmr_addr'] = $shipcstmResult[0]['shipcstmr_streetadd'];
$_SESSION['SSCF_ship_cstmr_city'] = $shipcstmResult[0]['shipcstmr_city'];
$_SESSION['SSCF_ship_cstmr_zip'] = $shipcstmResult[0]['shipcstmr_zip'];
$_SESSION['SSCF_ship_cstmr_cntry'] = $shipcstmResult[0]['shipcstmr_country'];
## ===*=== [F]ETCH SHIPPING DATA ===*=== ##
// include_once(" Controller.php");
// include_once(" HomeController.php");
// include_once(" SSLCommerz.php");
// include_once(" InvoiceValue.php");



// $sslc = new SSLCommerz();
$eloquent = new Eloquent;
// $getAmount = new InvoiceValue;


################### PAYMENT VERIFICATION ###################
#== CREATE SESSION AGAINST NEW VARIBALES
$tran_id = $_SESSION['payment_values']['tran_id'];						
$amount = $_SESSION['payment_values']['amount'];
$currency = $_SESSION['payment_values']['currency'];
$fetch_data = $_POST;
// $validation = $sslc->orderValidate($tran_id, $amount, $currency, $fetch_data);
$_SESSION['SSCF_transaction_id'] = @$fetch_data['bank_tran_id'];
################### PAYMENT VERIFICATION ###################

## ===*=== [I]NSERT DATA TO INVOICE TABLE FOR ////CASH ON DELIVERY/// ===*=== ##
if(True)
{
	if($_POST['payment_values'] = 1)
	{
		#== INSERT INVOICE TABLE DATA
		$tableName = $columnValue = null;
		$tableName = "invoices";
		$columnValue["invoice_id"] = 'COD#' . rand(10000, 99999);
		$columnValue["customer_id"] = @$_SESSION['SSCF_login_id'];
		$columnValue["shipping_id"] = @$_SESSION['SSCF_ship_cstmr_id'];
		$columnValue["order_id"] = @$_SESSION['SSCF_orders_order_id'];
		$columnValue["transaction_amount"] = $_SESSION['SSCF_orders_grand_total'];
		$columnValue["created_at"] = date("Y-m-d H:i:s");
		$invoiceCOD = $eloquent->insertData($tableName, $columnValue);
		
		if($invoiceCOD['LAST_INSERT_ID'] > 0)
		{
			#== FETCH INOVICE DATA FOR CASH ON DELIVERY INVOICE ID
			$columnName = $tableName = $whereValue =  null;
			$columnName = "*";
			$tableName = "invoices";
			$whereValue['id'] = $invoiceCOD['LAST_INSERT_ID'];
			$invoiceresultCOD = $eloquent->selectData($columnName, $tableName, $whereValue);
			
			#== UPDATE ORDERS DATA
			$tableName = $columnValue = $whereValue =  null;
			$tableName = "orders";
			$columnValue["payment_method"] = "Cash On Delivery";
			$columnValue["transaction_id"] = 'COD#' . @$_SESSION['SSCF_login_id'];
			$columnValue["transaction_status"] = "Unpaid";
			$whereValue["id"] = $_SESSION['SSCF_orders_order_id'];
			$ordersUpdate = $eloquent->updateData($tableName, $columnValue, @$whereValue);
		}
	}
}
## ===*=== [I]NSERT DATA TO INVOICE TABLE FOR CASH ON DELIVERY ===*=== ##


## ===*=== [F]ETCH INVOICE TABLE DATA BY JOIN QUERY ===*=== ##
$columnName = $tableName = $joinType = $onCondition = $whereValue = null;
$columnName["1"] = "orders.transaction_id";
$columnName["2"] = "orders.transaction_status";
$columnName["3"] = "orders.sub_total";
$columnName["4"] = "orders.tax";
$columnName["5"] = "orders.discount_amount";
$columnName["6"] = "orders.grand_total";
$columnName["7"] = "products.product_name";
$columnName["8"] = "products.product_summary";
$columnName["9"] = "products.product_price";
$columnName["10"] = "order_items.prod_quantity";
$tableName["MAIN"] = "order_items";
$joinType = "INNER";
$tableName["1"] = "orders";
$tableName["2"] = "products";
$onCondition["1"] = ["order_items.order_id ", "orders.id"];
$onCondition["2"] = ["order_items.product_id", "products.id"];
$whereValue["order_items.order_id"] = $_SESSION['LAST_ORDER_ID'];
$getdetailsResult = $eloquent->selectJoinData($columnName, $tableName, $joinType, $onCondition, @$whereValue);
## ===*=== [F]ETCH INVOICE TABLE DATA BY JOIN QUERY ===*=== ##


## ===*=== [F]ETCH SHIPPINGS DATA FOR INVOICE DETAILS ===*=== ##
$tableName = $whereValue= null;
$columnName = "*";
$tableName = "shippings";
$whereValue['id'] = $_SESSION['SSCF_ship_cstmr_id'];
$shippingDetails = $eloquent->selectData($columnName, $tableName, $whereValue);
## ===*=== [F]ETCH SHIPPINGS DATA FOR INVOICE DETAILS ===*=== ##


## ===*=== [F]ETCH CUSTOMER DATA WHO IS CONFIRMED PRODUCT'S ORDER ===*=== ##
$columnName = $tableName = $whereValue = null;
$columnName = "*";
$tableName = "customers";
$whereValue["id"] = $_SESSION['SSCF_login_id'];
$customerResult = $eloquent->selectData($columnName, $tableName, $whereValue);
## ===*=== [F]ETCH CUSTOMER DATA WHO IS CONFIRMED PRODUCT'S ORDER ===*=== ##

?>
?>

<?php 
	// }  
	if(true)
	{
		if($_POST['payment_values'] = 1)
		{
		?>
		
		<!--=*= INVOICE TABLE FOR CASH ON DELIVERY =*=-->
		<main class="main">
			<nav aria-label="breadcrumb" class="breadcrumb-nav mb-2 printClose">
				<div class="container">
					<ol class="breadcrumb">
						<li class="breadcrumb-item"><a href="index.php">Home</a></li>
						<li class="breadcrumb-item active" aria-current="page">invoice</li>
					</ol>
				</div>
			</nav>
			<div class="container">
				<div class="text-center printClose">
				<ul class="checkout-progress-bar">
					<li><span>Orders & Shipping</span></li>	
					<li><span>Payment Integration</span></li>	
					<li class="active"><span>Review &amp; Status</span></li>
				</ul>
				</div>
				<div class="text-right">
					<button type="submit" onclick="print_current_page()" target="_blank" class="btn btn-sm btn-outline-warning printClose">&#128438; Print the invoice</button>
				</div>
				<br/>
				<div class="row">
					<div class="col-md-12">
						<div class="invoice-header">
							<div class="row">
								<div class="col-md-3 col-xs-2">
									<div class="invoice-title">
										<h1>invoice</h1>
										<img class="logo-print" src="public/assets/images/favicon/logoFrontEnd.png" alt="" style="width: 220px; height: 60px;">
									</div>
								</div>
								<div class="invoice-info  col-md-9 col-xs-10">
									<div style="padding-left: 340px;">
										<div class="row">
											<div class="col-md-6 col-sm-6 text-left">
												<?php 
													echo' <p> '. $customerResult[0]['customer_name'] .'<br>'. $customerResult[0]['customer_address'] .'</p>';
												?>
											</div>
											<div class="col-md-6 col-sm-6 text-left">
												<?php 
													echo '<p>Phone: '. $customerResult[0]['customer_mobile'] .'<br> Email : '. $customerResult[0]['customer_email'] .'</p>';
												?>
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>
						<div class="row invoice-to">
							<div class="col-md-9 col-sm-4 pull-left">
								<h4>Invoice To:</h4>
								
								<?php
									echo '<h2>'. @$shippingDetails[0]['shipcstmr_name'] .'</h2>
									<p>'. @$shippingDetails[0]['shipcstmr_profession'] .'<br>'.'+88' .
											@$shippingDetails[0]['shipcstmr_mobile'] .'<br>'.
											@$shippingDetails[0]['shipcstmr_streetadd'] .'<br>'.
											@$shippingDetails[0]['shipcstmr_city'] . "-" . @$shippingDetails[0]['shipcstmr_zip'] .'<br>'.
											@$shippingDetails[0]['shipcstmr_country'] .'<br>
									</p>';
								?>
								
							</div>
							<div class="col-md-3 col-sm-5 pull-right">
								<!-- <div class="row">
									<div class="col-md-4 col-sm-5 inv-label">Invoice #</div>
									<div class="col-md-8 col-sm-7"><= $invoiceresultCOD[0]['invoice_id'];?></div>
								</div> -->
								<div class="row">
									<div class="col-md-4 col-sm-5 inv-label">Order Time</div>
									<div class="col-md-8 col-sm-7"><?= date("M-d-Y H:i:s A");?></div>
								</div>
								<br>
								<div class="row">
									<div class="col-md-12 inv-label">
										<h3 class="inv-label">Total Price</h3>
										<h2 style="font-size: 40px; font-weight: bold">
											<?= $GLOBALS['CURRENCY'] . " " . @$getdetailsResult[0]['grand_total']; ?>
										</h2>
									</div>
								</div>
							</div>
						</div>
						<table class="table table-invoice" >
							<thead>
								<tr>
									<th>#</th>
									<th>Product Description</th>
									<th class="text-center">Unit Price</th>
									<th class="text-center">Quantity</th>
									<th class="text-center">Total Price</th>
								</tr>
							</thead>
							<tbody>
								
								<?php
									$n = 1;
									foreach($getdetailsResult AS $eachData)
									{
										echo'
										<tr>
											<td>'. $n .'</td>
											<td>
												<div style="font-weight: bold;">'. $eachData['product_name'] .'</div>
												<div style="margin-bottom: -10px;">'. $eachData['product_summary'] .'</div>
											</td>
											<td class="text-center">'. $eachData['product_price'] .'</td>
											<td class="text-center">'. $eachData['prod_quantity'] .'</td>
											<td class="text-center">'. $eachData['prod_quantity'] * $eachData['product_price'] .'</td>
										</tr>';
										$n++;
									}
								?>
								
							</tbody>
						</table>
						<div class="row">
							<div class="col-md-8 col-xs-7 payment-method">
							<h3>+ Shipping Price : <?= $GLOBALS['CURRENCY'] . "40 " ?></h3>
								<strong> </strong>
								<h3 class="inv-label itatic">Thank you for trusting us 😘</h3>
							</div>
							<div class="col-md-4 col-xs-5 invoice-block pull-right">
								<ul class="unstyled amounts">
									
									<li class="grand-total">Total Price : 
										<?php echo $GLOBALS['CURRENCY'] . " " . $getdetailsResult[0]['grand_total']; ?>
									</li>
								</ul>
							</div>
						</div>
					</div>
				</div>
				<div class="row">
					<div class="col-lg-12">
						<div class="checkout-steps-action">
							<a href="index.php" class="btn btn-outline-success float-right printClose">Ship the order now</a>
						</div>
					</div>
				</div>
			</div>
			<div class="mb-6">
				<!-- CREATE A EMPTY SPACE BETWEEN CONTENT -->
			</div>
		</main>
		<!--=*= INVOICE TABLE FOR CASH ON DELIVERY =*=-->
		
		<?php
		}
	} ?>
<!--=*= EDIT SHIPPING DETAILS MODAL END =*=-->


<!--=*= SCRIPT TO PRINT DOCUMENT START =*=-->
<script type="text/javascript">
function print_current_page(){
	window.print();
}
</script>

<style>
@media print {
	#header, #footer, .printClose {display: none;}
}
</style>