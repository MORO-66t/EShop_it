<?php
$eloquent = new Eloquent;



if(isset($_POST['userRegistration']))
{
	if(!empty($_POST['acc_fname']) && !empty($_POST['acc_lname']) && !empty($_POST['acc_email']) && !empty($_POST['acc_password']) && !empty($_POST['acc_mobile']) &&
	!empty($_POST['acc_address']))
	{
		$tableName = "customers";
		$columnValue["customer_name"] = $_POST['acc_fname'] . " " . $_POST['acc_lname'];
		$columnValue["customer_email"] = $_POST['acc_email'];
		$columnValue["customer_password"] = $_POST['acc_password'];
		$columnValue["customer_mobile"] = $_POST['acc_mobile'];
		$columnValue["customer_address"] = $_POST['acc_address'];
		$columnValue["created_at"] = date("Y-m-d H:i:s");
		
		$registerUser = $eloquent->insertData($tableName, $columnValue);
	}
}

?>


<main class="main">
	<nav aria-label="breadcrumb" class="breadcrumb-nav">
		<div class="container">
			<ol class="breadcrumb">
				<li class="breadcrumb-item"><a href="index.php">HOME</a></li>
				<li class="breadcrumb-item active" aria-current="page">registe new account</li>
			</ol>
		</div>
	</nav>
	<div class="container">
		<div class="row">
			<div class="col-lg-8 order-lg-last dashboard-content">
				<h2> register account</h2>
				
				<?php
					if(isset($_POST['userRegistration']))
					{
						if(@$registerUser > 0)
						{
							echo '<div class="alert alert-success alert-dismissible fade show" role="alert">
										Thank you for registering with <b>E-Shopit</b> Please  
											<a href="login.php"> <b> login</b> </a>
										<button type="button" class="close" data-dismiss="alert" aria-label="Close">
											<span aria-hidden="true">&times;</span>
										</button>
									</div>';
						}
					}
				?>
				
				<form action="" method="post">
					<div class="row">
						<div class="col-sm-12">
							<div class="row">
								<div class="col-md-6">
									<div class="form-group required-field">
										<label for="acc-name" class="font-weight-bold text-dark text-2"> first name </label>
										<input type="text" class="form-control" name="acc_fname" placeholder="type your first name" required>
									</div>
								</div>
								<div class="col-md-6">
									<div class="form-group required-field">
										<label for="acc-mname" class="font-weight-bold text-dark text-2"> last name</label>
										<input type="text" class="form-control"  name="acc_lname" placeholder="type your last name" required>
									</div>
								</div>
							</div>
						</div>
					</div>
					<div class="form-group required-field">
						<label for="acc-email" class="font-weight-bold text-dark text-2">E-mail</label>
						<input type="email" class="form-control"  name="acc_email" placeholder="type your mail address e.g. someone@gmail.com" required>
					</div>
					<div class="row">
						<div class="col-sm-12">
							<div class="row">
								<div class="col-md-7">
									<div class="form-group required-field">
										<label for="acc-password" class="font-weight-bold text-dark text-2"> password </label>
										<input type="password" class="form-control" name="acc_password" placeholder="e.g. some@one#$num%" required>
									</div>					
								</div>									
								<div class="col-md-5">
									<div class="form-group required-field">
										<label for="acc-password" class="font-weight-bold text-dark text-2"> phone number </label>
										<input type="text" class="form-control" name="acc_mobile" placeholder="01*********" required>
									</div>					
								</div>					
							</div>					
						</div>					
					</div>	
					<div class="form-group required-field">
						<label for="acc-email" class="font-weight-bold text-dark text-2">address</label>
						<input type="text" class="form-control" name="acc_address" placeholder="type your address please..." required>
					</div>					
					<div class="mb-2">
					</div>
					<div class="required text-right">* required</div>
					<div class="form-footer">
						<a href="index.php" class="btn btn-outline-warning"><i class="icon-angle-double-left"></i>HOME </a>
						<div class="form-footer-right">
							<button type="submit" name="userRegistration" class="btn btn-outline-success"> register</button>
						</div>
					</div>
				</form>
			</div>
			<aside class="sidebar col-lg-3">
				<div class="widget widget-dashboard">
					<h3 class="widget-title">My Account</h3>
					<ul class="list">
						<li><a href="dashboard.php"> dashboard</a></li>
						<li class="active"><a href="register-account.php"> register new account  </a></li>
						<li><a href="user-password.php"> change password  </a></li>

					</ul>
				</div>
			</aside>
		</div>
	</div>
	<div class="mb-5">
	</div>
</main>