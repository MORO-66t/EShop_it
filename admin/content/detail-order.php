<?php

include("Eloquent.php");

$eloquent = new Eloquent;


## ===*=== [F]ETCH ORDERED ITEMS DATA ===*=== ##
if(isset($_REQUEST['id']))
{
	#== CREATE A SESSION BASED ON ID
	$_SESSION['SMCB_details_data'] = $_REQUEST['id'];
}

$columnName = [
    "order_items.product_id",
    "order_items.prod_quantity",
    "products.product_name",
    "product_images.image_name",
    "products.product_price",
	"products.category_id",
    "order_items.size",
    "order_items.color"
	
];

$tableName = [
    "MAIN" => "order_items",
    "1" => "products",
    "2" => "product_images"
];

$joinType = "Right";
$onCondition = [
    "1" => ["order_items.product_id", "products.id"],
    "2" => ["products.id", "product_images.product_id"]
];

$whereValue = ["order_items.order_id" => @$_SESSION['SMCB_details_data']];

$orderdetailsResult = $eloquent->selectJoinData($columnName, $tableName, $joinType, $onCondition, @$whereValue);


## ===*=== [F]ETCH ORDERED ITEMS DATA ===*=== ##
?>
<!--=*= DETAIL ORDER SECTION START =*=-->
<div class="wrapper">
	<div class="row">
		<div class="col-sm-12">
			<ul class="breadcrumb panel">
				<li> <a href="dashboard.php"> <i class="fa fa-home"></i> Home </a> </li>
				<li> <a href="dashboard.php"> Dashboard </a> </li>
				<li class="active"> Order Details </li>
			</ul>
			<section class="panel">
				<header class="panel-heading">
					ORDER DETAILS
				</header>
				<div class="panel-body">
					<div class="adv-table">
						<table class="display table table-bordered table-striped" id="dynamic-table">
							<thead>
							<tr>
                                    <th style="width: 5%"> # </th>
                                    <th style="width: 10%"> Item ID </th>
                                    <th style="width: 30%"> Item Name </th>
                                    <th style="width: 15%"> Item Image </th>
                                    <th style="width: 10%"> Item Price </th>
                                    <th style="width: 10%"> Item Qty. </th>
                                    <th style="width: 10%"> Size </th>  <!-- New column for size -->
                                    <th style="width: 10%"> Color </th> <!-- New column for color -->
                                    <th style="width: 15%"> Action </th>
                                </tr>
							</thead>
							<tbody>
								
								<?php 
									#== DETAILS ORDER DATA TABLE
									$n = 1;
									$displayedProducts = []; 
									foreach ($orderdetailsResult as $eachRow) 
									{
										$productId = $eachRow["product_id"];
										$columnName = $tableName  = $whereValue = null;
										// print_r($eachRow);
$columnName = "*";
	$tableName = "categories";
	$whereValue['id'] = $eachRow['category_id'];
	$subcategoryList = $eloquent->selectData($columnName, $tableName, $whereValue);
	if ($subcategoryList[0]['category_name'] == 'سماعات')
	{
		$subcategoryList[0]['category_name'] = 'ساعات';
	}
                                        // Check if the product has already been displayed
                                        if (!in_array($productId, $displayedProducts)) {
                                            // Add productId to the displayed list
                                            $displayedProducts[] = $productId;
										echo '
										<tr class="gradeA">
											<td>'. $n .'</td>
											<td>'. $eachRow["product_id"] .'</td>
											<td>'. $eachRow["product_name"] .'</td>
											<td class="center">
													<img src="'.$eachRow["image_name"] .'" class="img-circle" style="border: 1px outset green; height: 48px; width: 45px;"/>
												
											
											</td>
											<td>'. $eachRow["product_price"] .' &dollar;</td>
											<td>'. $eachRow["prod_quantity"] .'</td>
											<td>'. $eachRow["size"] .'</td>  <!-- Display size -->
                                            <td>'. $eachRow["color"] .'</td> <!-- Display color -->
											<td class="center">
												<a href="?aid='. $eachRow["product_id"] .'" class="btn btn-danger btn-xs disabled" style="width: 76px;">
													<i class="fa fa-trash-o"></i> Delete
												</a>												
												<a href="list-order.php" class="btn btn-warning btn-xs" style="width: 76px;">
													<i class="fa fa-chevron-circle-left"></i> List Back
												</a>
											</td>
										</tr>
										';
										$n++;
									}
								}
								?> 
								
							</tbody>        
							<tfoot>
								<tr>
									<th> # </th>
									<th> Item ID </th>
									<th> Item Name </th>
									<th> Item Image </th>
									<th> Item Price </th>
									<th> Item Qty. </th>
									<th> Action </th>
								</tr>
							</tfoot>
						</table>
					</div>
				</div>
			</section>
		</div>
	</div>
</div>
<!--=*= DETAIL ORDER SECTION END =*=-->						