<?php
include_once("Eloquent.php");

$eloquent = new Eloquent;


if( isset($_POST['try_login']) )
{
	$columnName = "*";
	$tableName = "admins";
	$whereValue["admin_email"] = $_POST['username'];
	$whereValue["admin_password"] = sha1($_POST['password']);
	$userLogin = $eloquent->selectData($columnName, $tableName, @$whereValue);
	if(!empty($userLogin))
	{
 		$_SESSION['SMC_login_time'] = date("Y-m-d H:i:s");
		$_SESSION['SMC_login_id'] = $adminData[0]['id'];
		$_SESSION['SMC_login_admin_name'] = $adminData[0]['admin_name'];
		$_SESSION['SMC_login_admin_email'] = $adminData[0]['admin_email'];
		$_SESSION['SMC_login_admin_image'] = $adminData[0]['admin_image'];
		$_SESSION['SMC_login_admin_status'] = $adminData[0]['admin_status'];
		$_SESSION['SMC_login_admin_type'] = "Root Admin";

		echo '<meta http-equiv="Refresh" content="0; url=list-category.php" />';
	}
}
?>

<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0">
		<meta name="description" content="Back End Development">
		<meta name="author" content="Mohammed Raga">
		
		<title>Admin Login | SuperShop</title>
		<link href="assets/css/style.css" rel="stylesheet">
		<link href="assets/css/style-responsive.css" rel="stylesheet">
		
		<!--=*= DISABLE IMAGE DRAG PROPERTIES =*=-->
	</head>
	
	<body class="login-body">
		<div class="container">
			<form class="form-signin" method="post" action="">
				<div class="form-signin-heading text-center">
					<h1 class="sign-title"> Sign In </h1>
					<img class="disable" src="../public/assets/images/favicon/loginBackEnd.png" alt="" style="height: 126px;"/>
				</div>
				<div class="login-wrap">
					<input name="username" type="email" class="form-control" placeholder="Email ID" >
					<input name="password" type="password" class="form-control" placeholder="Password" >
					<button name="try_login" class="btn btn-lg btn-login btn-block" type="submit">
						<i class="fa fa-check"></i>
					</button>
					<div class="registration"> Not a member yet? <a href="registration.php"> Signup </a></div>
				</div>
			</form>
		</div>	
		
		<!--=*= JS FILES SOURCE START =*=-->
		<script src=".assets/js/jquery-3.5.1.min.js"></script>
		<script src=".assets/js/bootstrap.min.js"></script>
		<script src=".assets/js/modernizr.min.js"></script>
		<!--=*= JS FILES SOURCE END =*=-->
		
	</body>
</html>		