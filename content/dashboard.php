<?php

$eloquent = new Eloquent;


## ===*=== [U]PDATE CUSTOMER ACCOUNT INFORMATION ===*=== ##
if(isset($_POST['update_accinfo']))
{
	$tableName = "customers";
	$columnValue["customer_name"] = $_POST['upcstmr_name'];
	$columnValue["customer_email"] = $_POST['upcstmr_email'];
	$columnValue["customer_mobile"] = $_POST['upcstmr_phn'];
	$columnValue["customer_address"] = $_POST['upcstmr_add'];
	$whereValue["id"] = $_SESSION['SSCF_login_id'] ;
	$updatecustomerData = $eloquent->updateData($tableName, $columnValue, @$whereValue);
}
## ===*=== [U]PDATE CUSTOMER ACCOUNT INFORMATION ===*=== ##


## ===*=== [F]ETCH SHIPPING DATA WHEN USER LOGED IN AND HAVE SUBMITTED ===*=== ##
if(@$_SESSION['SSCF_login_id'] > 0)
{
	$columnName = $tableName = $whereValue = null;
	$columnName = "*";
	$tableName = "shippings";
	$whereValue["shippings.customer_id"] = $_SESSION['SSCF_login_id'];
	$cstmrShipDetails = $eloquent->selectData($columnName, $tableName, @$whereValue);		
	
	$columnName = $tableName = $whereValue = null;
	$columnName = "*";
	$tableName = "customers";
	$whereValue["id"] = $_SESSION['SSCF_login_id'];
	$cstmrDetails = $eloquent->selectData($columnName, $tableName, @$whereValue);

}
## ===*=== [F]ETCH SHIPPING DATA WHEN USER LOGED IN AND HAVE SUBMITTED ===*=== ##
?>

<!--=*= DASHBOARD SECTION START =*=-->
<main class="main">
	<nav aria-label="breadcrumb" class="breadcrumb-nav">
		<div class="container">
			<ol class="breadcrumb">
				<li class="breadcrumb-item"><a href="index.php">Home</a></li>
				<li class="breadcrumb-item active" aria-current="page">My Account</li>
			</ol>
		</div>
	</nav>	
	<div class="container">
		<div class="row">
			<div class="col-lg-9 order-lg-last dashboard-content">
				<h2>My Account</h2>
				
				<?php
					#== A GREETING MESSEGE IF USER LOGGED IN
					if(@$_SESSION['SSCF_login_id'] > 0)
					{
						echo '
						<div class="alert alert-success alert-dismissible fade show" role="alert">
							Hello, <strong>'. @$_SESSION['SSCF_login_user_name'] .'</strong> Welcome to your account. You can update and view your information here
							<button type="button" class="close" data-dismiss="alert" aria-label="Close">
								<span aria-hidden="true">&times;</span>
							</button>
						</div>
						';
					}
					
					#== IF ACCOUNT IS UPDATED A SUCCESS MESSAGE WILL BE APPEAR
					if(isset($_POST['update_accinfo']))
					{
						if(@$updatecustomerData > 0)
						echo '
						<div class="alert alert-success alert-dismissible fade show" role="alert">
							Hello, <strong>'. @$_SESSION['SSCF_login_user_name'] .'</strong> Your information has been successfully updated.
							<button type="button" class="close" data-dismiss="alert" aria-label="Close">
								<span aria-hidden="true">&times;</span>
							</button>
						</div>
						';
					}
				?> 
				
				<div class="mb-4">
					<!--=*= CREATE A EMPTY SPACE BETWEEN CONTENT =*=-->
				</div>
				<h3>Account Information</h3>
				<div class="row">
					<div class="col-md-12">
						<div class="card">
							<div class="card-header">
								Contact Information
							</div>
							<div class="card-body">
								
								<?php 
									#== CONTACT INFORMATION
									if(@$_SESSION['SSCF_login_id'] > 0) 
									{
										echo '<p>'. $cstmrDetails[0]['customer_name'] .'<br/>'. $cstmrDetails[0]['customer_email'] .'<br/>'. $cstmrDetails[0]['customer_mobile'] .'</p>';
									} 
									else 
									{
										echo '<p> You have not create an account. <a href="register-account.php" class="text-info"> <b>Register Account</b> </a> </p>';
									}
								?>
								
							</div>
						</div>
					</div>
					
				</div>
				<div class="card">
					<div class="card-header"> Booking Information</div>
					<div class="card-body">
						<div class="row">
							<div class="col-md-6">
								<h4 class="">Delivery Address</h4>
								
								<?php 
									#== REGISTERED CUSTOMER ADDRESS DATA
									if(@$_SESSION['SSCF_login_id'] > 0) {
										echo '<address>' . @$cstmrDetails[0]['customer_address'] . '</address>';
										} else {
										echo '<p> You have not set a default shipping address. </p>';
									}
								?>
								
							</div>
							<div class="col-md-6">
								<h4 class="">Your Last Order</h4>
								
								<?php
									#== SHIPPING ADDRESS DATA
									if(@$_SESSION['SSCF_login_id'] > 0) {
										echo '<address> '. 
										@$cstmrShipDetails[0]['shipcstmr_name'] . '<br/>' .
										@$cstmrShipDetails[0]['shipcstmr_mobile'] . '<br/>' .
										@$cstmrShipDetails[0]['shipcstmr_profession'] . '<br/>' .
										@$cstmrShipDetails[0]['shipcstmr_streetadd'] . '<br/>' .
										@$cstmrShipDetails[0]['shipcstmr_city'] . "-" . @$cstmrShipDetails[0]['shipcstmr_zip'] . '<br/>' .
										@$cstmrShipDetails[0]['shipcstmr_country'] . '<br/>' .
										'</address>';
										} else {
										echo '<p> You have not set a default shipping address. </p>';
									}
								?>
								
							</div>
						</div>
					</div>
				</div>
				<div>
					
					<?php
						#== EDIT ACCOUNT BUTTON
						if(@$_SESSION['SSCF_login_id'] > 0)
						{
					?>
						
						<div class="checkout-discount">
							<h2 class="step-title">
								<a data-toggle="collapse" href="#edit-account" class="collapsed card-edit btn btn-sm btn-outline-info float-right" role="button">
									Edit Account Information
								</a>
							</h2>
							<div class="collapse" id="edit-account">
								<form action="" method="post">
									<div class="row">
										<div class="col-md-12">
											<div class="form-group required-field">
												<input type="text" name="upcstmr_name" class="form-control" name="" value="<?php echo $cstmrDetails[0]['customer_name']; ?>">
											</div>
											<div class="form-group required-field">
												<input type="email" name="upcstmr_email" class="form-control" value="<?php echo $cstmrDetails[0]['customer_email']; ?>">
											</div>
											<div class="form-group required-field">
												<input type="text" name="upcstmr_phn" class="form-control" value="<?php echo $cstmrDetails[0]['customer_mobile']; ?>">
											</div>
											<div class="form-group required-field">
												<input type="text" name="upcstmr_add" class="form-control" value="<?php echo $cstmrDetails[0]['customer_address']; ?>">
											</div>
											<button type="submit" name="update_accinfo" class="btn btn-sm btn-outline-info">Update</button>
										</div>
									</div>
								</form>
							</div>
						</div>
						
					<?php
						}
					?>
					
				</div>
			</div>
			</div>
	</div>
	<div class="mb-5">
		<!-- CREATE A EMPTY SPACE BETWEEN CONTENT -->
	</div>
</main>
<!--=*= DASHBOARD SECTION START =*=-->