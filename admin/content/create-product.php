<?php
include("Eloquent.php");

$eloquent = new Eloquent;

## ===*=== [F]ETCH CATEGORY DATA ===*=== ##
$columnName = $tableName = null;
$columnName = "*";
$tableName = "categories";
$categoryList = $eloquent->selectData($columnName, $tableName);
## ===*=== [F]ETCH CATEGORY DATA ===*=== ##

if (isset($_POST['create_product'])) {
    $uploadedImages = [];

    // Imgur API credentials
    $imgurClientId = '1176aaa06c43d6b'; // Replace with your Imgur Client ID

    // Check and handle each uploaded file
    foreach ($_FILES['product_images']['tmp_name'] as $key => $tmp_name) {
            $imageData = file_get_contents($tmp_name);
            $base64Image = base64_encode($imageData);
            $fileName = $_FILES['product_images']['name'][$key];

            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, 'https://api.imgur.com/3/image');
            curl_setopt($ch, CURLOPT_POST, true);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_HTTPHEADER, [
                'Authorization: Client-ID ' . $imgurClientId,
            ]);
            curl_setopt($ch, CURLOPT_POSTFIELDS, [
                'image' => $base64Image,
                'type' => 'base64',
                'name' => $fileName,
            ]);

            $response = curl_exec($ch);
            curl_close($ch);

            $responseBody = json_decode($response, true);
            if (isset($responseBody['success']) && $responseBody['success']) {
                // Add the Imgur link to the array of uploaded images
                $uploadedImages[] = $responseBody['data']['link'];
            } else {
                echo 'Imgur API error: ' . ($responseBody['data']['error'] ?? 'Unknown error') . '<br>';
            }

    }

    if (!empty($uploadedImages)) {
        $tableName = "products";
        $columnValue = [
            "category_id" => $_POST['category_id'],
            "subcategory_id" => $_POST['subcategory_id'],
            "product_name" => $_POST['product_name'],
            "product_summary" => $_POST['product_summary'],
            "product_details" => $_POST['product_details'],
            "product_quantity" => $_POST['product_quantity'],
            "product_price" => $_POST['product_price'],
            "product_status" => $_POST['product_status'],
            "product_featured" => $_POST['product_featured'],
            "size" => $_POST['product_sizes'],
            "color" => $_POST['product_colors'],
            "created_at" => date("Y-m-d H:i:s")
        ];

        $createProduct = $eloquent->insertData($tableName, $columnValue);

        if ($createProduct['NO_OF_ROW_INSERTED'] > 0) {
            $productId = $createProduct['LAST_INSERT_ID'];
            echo "Product created with ID: " . $productId . "<br>";

            foreach ($uploadedImages as $imageLink) {
                $imageData = [
                    "product_id" => $productId,
                    "image_name" => $imageLink
                ];
                $insertImage = $eloquent->insertData("product_images", $imageData);

                // Debug image insertion
                if ($insertImage['NO_OF_ROW_INSERTED'] > 0) {
                    echo "Image inserted: " . $imageLink . "<br>";
                } else {
                    echo "Failed to insert image: " . $imageLink . "<br>";
                }
            }
        } else {
            echo "Failed to create product.<br>";
        }
    } else {
        echo "No valid images uploaded.<br>";
    }
}

## ===*=== [I]NSERT PRODUCT DATA ===*=== ##
?>
<!--=*= CREATE PRODUCT SECTION START =*=-->
<div class="wrapper">
    <div class="row">
        <div class="col-lg-12">
            <ul class="breadcrumb panel">
                <li><a href="dashboard.php"><i class="fa fa-home"></i> Home</a></li>
                <li><a href="dashboard.php">Dashboard</a></li>
                <li class="active">Create Product</li>
            </ul>
            <section class="panel">
                <header class="panel-heading">
                    CREATE PRODUCTS
                </header>
                <div class="panel-body">

                    <?php 
						#== INSERT CONFIRMATION MESSAGE
						if(isset($_POST['create_product'])) 
						{
							if(@$createProduct > 0)
							{
								echo '<div class="alert alert-success fade in"> 
											<button type="button" class="close close-sm" data-dismiss="alert"> <i class="fa fa-times"></i> </button>
											THE PRODUCT DATA IS <strong> INSERTED SUCCESSFULLY </strong>
										</div>';
							}
							else
							{
								echo '<div class="alert alert-warning fade in"> 
											<button type="button" class="close close-sm" data-dismiss="alert"> <i class="fa fa-times"></i> </button> 
											SOMETHING WENT WRONG TO INSERT DATA! <strong> PLEASE RECHECK </strong>
										</div>';
							}
						}
					?>

                    <form class="form-horizontal" method="post" action="" enctype="multipart/form-data">
                        <div class="form-group ">
                            <label for="ProductStatus" class="control-label col-lg-2">Category</label>
                            <div class="col-lg-7">

                                <select name="category_id" id="category_id" class="form-control" required>
                                    <option value="">Select a Category</option>

                                    <?php
										#== CATEGORY LIST DATA
										foreach($categoryList AS $eachRow)
										{
											echo '<option value="'. $eachRow['id'] .'">'. $eachRow['category_name'] .'</option>';
										}
									?>

                                </select>
                            </div>
                        </div>
                        <div class="form-group ">
                            <label for="ProductStatus" class="control-label col-lg-2"> Subcategory </label>
                            <div class="col-lg-7">
                                <select name="subcategory_id" id="subcategory_id" class="form-control" required>
                                    <option value="">Select a Subcategory</option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="ProductName" class="col-lg-2 col-sm-2 control-label"> Product Name </label>
                            <div class="col-lg-7">
                                <input type="text" name="product_name" class="form-control" id="product_name" required>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="ProductSummary" class="col-lg-2 col-sm-2 control-label"> Product Summary
                            </label>
                            <div class="col-lg-10">
                                <div class="form-group">
                                    <div class="col-md-10">
                                        <textarea name="product_summary" class="form-control" id="summerOne" rows="9"
                                            required></textarea>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
    <label for="ProductDetails" class="col-lg-2 col-sm-2 control-label">Product Details</label>
    <div class="col-lg-10">
        <div class="form-group">
            <div class="col-md-10">
                <textarea name="product_details" class="form-control" id="summerTwo" rows="9" required></textarea>
            </div>
        </div>
    </div>
</div>

                        <div class="form-group">
                            <label for="ProductQuantity" class="col-lg-2 col-sm-2 control-label">Product
                                Quantity</label>
                            <div class="col-lg-7">
                                <input type="number" name="product_quantity" class="form-control" id="product_quantity"
                                    required>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="ProductPrice" class="col-lg-2 col-sm-2 control-label"> Product Price </label>
                            <div class="col-lg-7">
                                <input type="number" step="any" name="product_price" class="form-control"
                                    id="product_price" required>
                            </div>
                        </div>
                        <div class="form-group ">
                            <label for="ProductStatus" class="control-label col-lg-2"> Product Status </label>
                            <div class="col-lg-7">
                                <select name="product_status" class="form-control" required>
                                    <option>Out of Stock</option>
                                    <option>In Stock</option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group ">
                            <label for="ProductStatus" class="control-label col-lg-2"> Product Feature </label>
                            <div class="col-lg-7">
                                <select name="product_featured" class="form-control" required>
                                    <option>NO</option>
                                    <option>YES</option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-lg-2"> Product Sizes </label>
                            <div class="col-lg-7">
                                <input type="text" name="product_sizes" class="form-control" id="product_sizes"
                                    placeholder="Comma-separated sizes" >
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-lg-2"> Product Colors </label>
                            <div class="col-lg-7">
                                <input type="text" name="product_colors" class="form-control" id="product_colors"
                                    placeholder="Comma-separated colors" >
                            </div>
                        </div>
                        <div class="form-group">
        <label class="control-label col-lg-2">Major Image (First)</label>
        <div class="col-lg-7">
            <input type="file" name="product_images[]" class="form-control" required>
        </div>
    </div>

    <!-- Additional Images -->
    <div class="form-group">
        <label class="control-label col-lg-2">Additional Images</label>
        <div class="col-lg-7">
            <input type="file" name="product_images[]" class="form-control" multiple>
        </div>
    </div>
                        <div class="form-group">
                            <label for="ProductName" class="col-lg-2 col-sm-2 control-label"> Product Tags </label>
                            <div class="col-md-7">
                                <input type="tags" name="product_tag" id="tag-input1">
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-lg-offset-2 col-lg-5">
                                <button name="create_product" class="btn btn-success" type="submit"> Save </button>
                                <button class="btn btn-default" type="reset"> Reset </button>
                            </div>
                        </div>
                    </form>
                </div>
            </section>
        </div>
    </div>
</div>
<!--=*= CREATE PRODUCT SECTION END =*=-->


<!--=*= TAGS INPUT START =*=-->
<script type="text/javascript">
var tagInput = new TagsInput({
    selector: 'tag-input1'
});
</script>
<!--=*= TAGS INPUT END =*=-->


<!--=*= AJAX CODE TO LOAD SUBCATEGORY AGAINST CATEGORY =*=-->
<script type="text/javascript">
$(document).ready(function() {
    $("#category_id").change(function() {
        var cat_id = $(this).val();

        if (cat_id != "") {
            $.ajax({
                url: "ajax.php",
                data: {
                    ajax_create_product: "YES",
                    category_id: cat_id
                },
                type: 'POST',
                success: function(response) {
                    var resp = $.trim(response);
                    $("#subcategory_id").html(resp);

                    if (resp == "")
                        $("#subcategory_id").html(
                            "<option value=''> No Subcategory Found </option>");
                }
            });
        } else {
            $("#subcategory_id").html("<option value=''> Select a Subcategory </option>");
        }
    });
});
</script>
<!--=*= AJAX CODE TO LOAD SUBCATEGORY AGAINST CATEGORY =*=-->

