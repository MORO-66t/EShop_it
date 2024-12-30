<!DOCTYPE html>
<html lang="en">

<head>

    <?php
			$pageName = basename($_SERVER['PHP_SELF']);
			$pageName = str_replace('.php', '', $pageName);

			if($pageName === 'index')
			{
				$pageTitle = ucwords('Online Shopping');
			}
			else
			{
				$strReplace =  str_replace('-', ' ', $pageName);
				$pageTitle = ucwords($strReplace);
			}
		?>

    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <!--//??????  -->
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0">

		<meta name="description" content="SHOPIt is an E-commerce for buying fashion like pants , T-shirts and shoes Or Watches and AIRPODS">

		<meta name="author" content="Mohammed Ragab">

		<link rel="shortcut icon" href="../public/assets/images/favicon/faviconBackEnd.png" type="image/png">

		

		<title>SHOPIt | <?php echo $pageTitle ?> </title>
    <link rel="icon" type="image/icon" href="public/assets/images/favicon/shopit.jpg">

    <link rel="stylesheet" href="public/assets/css/bootstrap.min.css">
    <link rel="stylesheet" href="public/assets/css/toastr.css">
    <link rel="stylesheet" href="public/assets/css/style.min.css">
    <link rel="stylesheet" href="public/assets/css/custom.css">

    <link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Alexandria:wght@100..900&display=swap" rel="stylesheet">

    <script src="public/assets/js/jquery.min.js"></script>

</head>


<body>

    <?php
			include("app/Models/Eloquent.php");
			
			$eloquent = new Eloquent;
			
			

			$columnName = $tableName = $whereValue = null;
			$columnName = "*";
			$tableName = "categories";
			$whereValue['category_status'] = "Active";
			$categoryMenu = $eloquent->selectData($columnName, $tableName, @$whereValue);


            
