<?php
$eloquent = new Eloquent;


## ===*=== [I]NSERT ORDER TABLE'S DATA FROM SHOPCART PAGE ===*=== ##
if(isset($_POST['submit_order']))
{
	#== CREATE ORDERS DATA WHEN SUBMIT PLACED TO ORDER
	$tableName = "orders";
	$columnValue["order_date"] = date("Y-m-d H:i:s");
	$columnValue["sub_total"] = $_POST['cartsub_total'];
	$columnValue["tax"] = $_POST['tax_total'];
	$columnValue["delivery_charge"] = $_POST['delivery_charge'];
	$columnValue["discount_amount"] = $_POST['discount_amount'];
	$columnValue["grand_total"] = $_POST['grand_total'];
	$columnValue["customer_id"] = @$_SESSION['SSCF_login_id'];
	$columnValue["created_at"] = date("Y-m-d H:i:s");
	$saveorderDetails = $eloquent->insertData($tableName, $columnValue);
	
	$_SESSION['LAST_ORDER_ID'] = $saveorderDetails['LAST_INSERT_ID'];
	
	if($saveorderDetails['NO_OF_ROW_INSERTED'] > 0)
	{
		$_SESSION['SSCF_orders_order_id'] = $saveorderDetails['LAST_INSERT_ID'];
		
		#== GET ALL DATA FROM SHOPCART PAGE FOR LOGGED IN USER OR CUSTOMER
		$columnName = $tableName = $joinType = $onCondition = $whereValue = $formatBy = $paginate = null;
		$columnName["1"] = "products.id";
		$columnName["2"] = "products.product_price";
		$columnName["3"] = "shopcarts.quantity";
		$columnName["4"] = "shopcarts.size";
		$columnName["5"] = "shopcarts.color";
		$tableName["MAIN"] = "shopcarts";
		$joinType = "INNER";
		$tableName["1"] = "products";
		$onCondition["1"] = ["shopcarts.product_id", "products.id"];
		$whereValue["shopcarts.customer_id"] = @$_SESSION['SSCF_login_id'];
		$formatBy["DESC"] = "shopcarts.id";
		$shopCartItems = $eloquent->selectJoinData($columnName, $tableName, $joinType, $onCondition, @$whereValue, @$formatBy, @$paginate);
		
		foreach($shopCartItems AS $eachOrderItems)
		{
			#== INSERT DATA TO THE ORDER ITEMS TABLE
			$columnValue = $tableName = null;
			$tableName = "order_items";
			$columnValue["customer_id"] = $_SESSION['SSCF_login_id'];
			$columnValue["order_id"] = $_SESSION['SSCF_orders_order_id'];
			$columnValue["product_id"] = $eachOrderItems['id'];
			$columnValue["product_price"] = $eachOrderItems['product_price'];
			$columnValue["prod_quantity"] = $eachOrderItems['quantity'];
			$columnValue["size"] = $eachOrderItems['size'];
			$columnValue["color"] = $eachOrderItems['color'];
			$columnValue["created_at"] = date("Y-m-d H:i:s");
			$saveorderItems = $eloquent->insertData($tableName, $columnValue);
		}
		
		#== NOW DELETE ALL THE SHOPCART ITEMS DATA AS THEY ARE STORED IN ORDER ITEMS TABLE
		if(@$saveorderItems['NO_OF_ROW_INSERTED'] > 0)
		{
			$tableName = $whereValue = null;
			$tableName = "shopcarts";
			$whereValue["customer_id"] = $_SESSION['SSCF_login_id'];
			$deleteshopcartData = $eloquent->deleteData($tableName, $whereValue);			
			
		}
	}
}
## ===*=== [I]NSERT ORDER TABLE'S DATA FROM SHOPCART PAGE ===*=== ##


## ===*=== [I]NSERT DATA FOR NEW USER ===*=== ##
if(isset($_POST['customerRegistration']))
{
	if(!empty($_POST['acc_Firstname']) && !empty($_POST['acc_Lastname']) && !empty($_POST['acc_Emailadd']) && !empty($_POST['acc_Setpass']) && !empty($_POST['acc_Setmobile']) &&
	!empty($_POST['acc_Setaddress']))
	{
		$tableName = $columnValue = null;
		$tableName = "customers";
		$columnValue["customer_name"] = $_POST['acc_Firstname'] . " " . $_POST['acc_Lastname'];
		$columnValue["customer_email"] = $_POST['acc_Emailadd'];
		$columnValue["customer_password"] = sha1($_POST['acc_Setpass']);
		$columnValue["customer_mobile"] = $_POST['acc_Setmobile'];
		$columnValue["customer_address"] = $_POST['acc_Setaddress'];
		$columnValue["created_at"] = date("Y-m-d H:i:s");
		
		$registerCustomer = $eloquent->insertData($tableName, $columnValue);
	}
}
## ===*=== [I]NSERT DATA FOR NEW USER ===*=== ##
?>

<!--=*= ORDER SUBMISSION SECTION START =*=-->
<main class="main">
	<nav aria-label="breadcrumb" class="breadcrumb-nav mb-2">
		<div class="container">
			<ol class="breadcrumb">
				<li class="breadcrumb-item"><a href="index.php">Home</a></li>
				<li class="breadcrumb-item active" aria-current="page">Orders & Shipping</li>
			</ol>
		</div>
	</nav>
	<div class="container">
		<div class="row">
			<div class="col-lg-12">
					<div class="col-lg-5 offset-lg-2">
						<ul class="checkout-steps">
							<li>
								<h2 class="step-title mb-2">Purchase Information</h2>
								<form action="payments.php" method="post">
									<div class="form-group required-field">
										<label>Full Name  </label>
										<input type="text" id="f1" name="shipadd_fname" class="form-control">
									</div>
									<div class="form-group required-field">
										<label>Detailed Address: City - Area - Street </label>
										<input type="text" id="f3" name="shipadd_stadd" class="form-control">
									</div>
									<div class="form-group required-field">
										<label>Governorate</label>
										<input type="text" id="f4" name="shipadd_cty" class="form-control">
									</div>
									<div class="form-group">
										<!-- <label>Country</label> -->
										<input type="text" name="shipadd_cntry" class="form-control" value="ُEgypt" hidden>
									</div>
									<div class="form-group required-field">
										<label>Phone Number </label>
										<div class="form-control-tooltip">
											<input type="حاخىث" id="f6" name="shipadd_phn" class="form-control">
											<span class="input-tooltip" data-toggle="tooltip" title="For delivery questions." data-placement="right">
												<i class="icon-question-circle"></i>
											</span>
										</div>
									</div>
									<div class="form-group required-field">
										<label>Notes (Optional) </label>
										<div class="form-control-tooltip">
											<input type="text" id="f6" name="notice" class="form-control">
											<span class="input-tooltip" data-toggle="tooltip" title="For delivery questions." data-placement="right">
												<i class="icon-question-circle"></i>
											</span>
										</div>
									</div>
										<div id="error-message"></div>
									<button type="submit" name="proceed_to_payment" id="save-data" class="btn btn-sm btn-warning float-right"> 
										Confirm Information
									</button>
								</form>
							</li>
						</ul>
					</div>
				</div>
			</div>
		</div>
	</div>
	
	<div class="mb-6">
		<!-- CREATE A EMPTY SPACE BETWEEN CONTENT -->
	</div>
</main>
<!--=*= ORDER SUBMISSION SECTION START =*=-->

<!--=*= FORM VALIDATION SCRIPT START =*=-->
<script type="text/javascript">
	$(document).ready(function(){
		$('#save-data').click(function(e){
			
			var fName = $("#f1").val();
			var lName = $("#f2").val();
			var stAdd = $("#f3").val();
			var city = $("#f4").val();
			var zipCode = $("#f5").val();
			var phone = $("#f6").val();
			
			if(fName == '' || lName == '' || stAdd == '' || city == '' || zipCode == '' || phone == '') {
				e.preventDefault();				
				$("#error-message").html('<div class="alert alert-warning alert-dismissible fade show" role="alert">All fields <b>*</b> are required!<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>').slideDown();
			} else {
				return true;
			}
		});
	});
</script>
<!--=*= FORM VALIDATION SCRIPT END =*=-->
