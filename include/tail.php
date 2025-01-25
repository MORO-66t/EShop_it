<?php
	$eloquent = new Eloquent;
	$columnName = $tableName = $whereValue = null;

	$columnName = "*";

	$tableName = "categories";

	$whereValue['category_status'] = "Active";

	$categoryMenu = $eloquent->selectData($columnName, $tableName, @$whereValue);

?>

<style>
	.footer {
	background-color: #181f25;
	color: #fff;
	/* padding: 60px 0; */
	font-size: 14px;
	line-height: 24px;
	font-family: "cairo", sans-serif;
	border-radius: 15px;
	margin: 0 10 0 10 !important;
	
    margin-left: 20px;
    margin-right: 20px;
	padding :  0px  0px 20px 0px ;
}
</style>
			 <footer class="footer" id="footer">
				 <div class="container my-5">
  <!-- Footer -->
  <footer class="text-center text-white" >
    <!-- Grid container -->
    <div class="container">
      <!-- Section: Links -->
      <section class="mt-5">
        <!-- Grid row-->
        <div class="row text-center d-flex justify-content-center pt-5">
          <!-- Grid column -->
          <div class="col-md-2">
            <h4 class="text-uppercase font-weight-bold">
              <a href="privacy-policy.php" class="text-white">Privacy Policy</a>
            </h6>
          </div>
          <!-- Grid column -->

          <!-- Grid column -->
          <div class="col-md-2">
            <h4 class="text-uppercase font-weight-bold">
              <a href="delivery-policy.php" class="text-white">Shipping Policy</a>
            </h6>
          </div>
          <!-- Grid column -->

          <!-- Grid column -->
          <div class="col-md-2">
            <h4 class="text-uppercase font-weight-bold">
              <a href="refund-policy.php" class="text-white">Exchange and Return Policy</a>
            </h6>
          </div>
          <!-- Grid column -->

          <!-- Grid column -->
          <div class="col-md-2">
            <h4 class="text-uppercase font-weight-bold">
              <a href="Terms-condition.php" class="text-white">Terms of Use</a>
            </h6>
          </div>
          <!-- Grid column -->

          
        </div>
        <!-- Grid row-->
      </section>
      <!-- Section: Links -->

      <hr class="my-5" />

      <!-- Section: Text -->
      <section class="mb-5">
        <div class="row d-flex justify-content-center">
          <div class="col-lg-8">
            <h2 style="color: #fff; text-align: center !important">
              😉High-quality products and exceptional service 
              
            </h2>
            <h2 style="color: #fff; text-align: center !important;">
             😊  Shop with confidence, delivery to your doorstep
              
            </h2>
          </div>
        </div>
      </section>

    </div>
  </footer>

</div>
				</div>
			</footer> 
		</div> 
		<a id="scroll-top" href="#top" title="Top" role="button">

			<i class="icon-angle-up"></i>

		</a>

<style>
.toast-container {position: fixed; top: 20px; right: 20px; z-index: 10000;} .toast {display: flex; align-items: center; padding: 16px; margin-bottom: 10px; border-radius: 4px; color: #fff; font-family: Arial, sans-serif; box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1); animation: fadeIn 0.5s, fadeOut 0.5s 2.5s;} .toast-success {background-color: #28a745;} .toast-warning {background-color: #ffc107;} .toast-title {font-weight: bold; margin-right: 10px;} .toast-message {flex: 1;} .toast-close {background: none; border: none; color: #fff; font-size: 20px; cursor: pointer;} @keyframes fadeIn {from {opacity: 0;} to {opacity: 1;}} @keyframes fadeOut {from {opacity: 1;} to {opacity: 0;}}
</style>

	<!--=*= JS SOURCE FILES =*=-->

	<script src="assets/js/bootstrap.bundle.min.js"></script>

	<script src="assets/js/toastr.min.js"></script>

	<script src="assets/js/plugins.min.js"></script>

	<script src="assets/js/nouislider.min.js"></script>

	<script src="assets/js/main.js"></script>

	<!--=*= JS SOURCE FILES =*=-->



	<!--=*= MULTIPLE JS MANIPULATION SCRIPT =*=-->



	<!--# AUTO SEARCH COMPLETE #-->

	<script type="text/javascript">

		$(document).ready(function(){

			$('#search').keyup(function(){

				var data = $(this).val();

				

				if(data!='') {

					$.ajax({

						url: 'auto-search.php',

						type: 'POST',

						data: {search: data},

						success: function(response) {

							$('#show-list').html(response);

						}

					});

					} else {

					$('#show-list').html('');

				}

			});

			$(document).on('click', '.loadData', function() {

				$('#search').val($(this).text());

				$('#show-list').html('');

			});

		});

	</script>

	<!--# AUTO SEARCH COMPLETE #-->



	<!--# ADD TO CART MESSAGE #-->

	<script type="text/javascript">

		function success_toast(details, title) {

			toastr.options = {

				"closeButton": true,

				"debug": false,

				"newestOnTop": false,

				"progressBar": false,

				"positionClass": "toast-top-right",

				"preventDuplicates": false,

				"onclick": null,

				"showDuration": "300",

				"hideDuration": "1000",

				"timeOut": "3000",

				"extendedTimeOut": "1000",

				"showEasing": "swing",

				"hideEasing": "linear",

				"showMethod": "fadeIn",

				"hideMethod": "fadeOut"

			}

			//toastr["success"]("Your product is added to cart successfully!", "Congratulation")

			toastr["success"](details, title) 

		}			

		

		function warning_toast(details, title) {

			toastr.options = {

				"closeButton": true,

				"debug": false,

				"newestOnTop": false,

				"progressBar": false,

				"positionClass": "toast-top-right",

				"preventDuplicates": false,

				"onclick": null,

				"showDuration": "300",

				"hideDuration": "1000",

				"timeOut": "3000",

				"extendedTimeOut": "1000",

				"showEasing": "swing",

				"hideEasing": "linear",

				"showMethod": "fadeIn",

				"hideMethod": "fadeOut"

			}

			toastr["warning"](details, title) 

		}

	</script>



	<?php

		#== PRODUCT ADDED TO THE CART ITEMS MESSAGE

		if(isset($_POST['add_to_cart']))

		{

			if($_SESSION['ADD_TO_CART_RESULT'] > 0) {

				echo '<script type="text/javascript"> 

				success_toast("Your product is added to cart successfully!", "CONGRATULATION")

				</script>';

				

				} else {

				echo '<script type="text/javascript"> 

				warning_toast("Please <b> register </b> an account first!", "DEAR CUSTOMER")

				</script>';

			}

		}
	?>


	<script type="text/javascript">

		$("img").mousedown(function(){

			return false;

		});	

	</script>

	</body>

</html>