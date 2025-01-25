<?php
include("Controller.php");
class SearchController extends Controller

{

	public function searchProduct($htmlKeywords)

	{

		$arrayKeywords = explode(" ", $htmlKeywords);

		

		$sql1 = $sql2 = null;

		$sql1 = "

			SELECT * 

			FROM products

			WHERE 

		";

		foreach($arrayKeywords AS $eachKey)

		{

			$sql2 .= "product_name LIKE '%".$eachKey."%' OR ";
			// $sql = "SELECT * FROM products WHERE product_name LIKE '%$search_query%' OR description LIKE '%$search_query%'";

			}

		$sql2 = rtrim($sql2, " OR");

		

		$sql_code = $sql1 . $sql2; 

		

		$query = $this->connection->prepare($sql_code);

		

		$query->execute();

		

		$dataList = $query->fetchAll(PDO::FETCH_ASSOC);

		$totalRowSelected = $query->rowCount();

		

		if($totalRowSelected > 0)

			return $dataList;

		else

			return 0;

	}	

	

	public function searchProductLimit($htmlKeywords, $start, $end)

	{

		$arrayKeywords = explode(" ", $htmlKeywords);

		

		$sql1 = $sql2 = null;

		$sql1 = "

			SELECT * 

			FROM products 

			WHERE 

		";

		foreach($arrayKeywords AS $eachKey)

		{

			$sql2 .= "product_name LIKE '%".$eachKey."%' OR ";

			}

		$sql2 = rtrim($sql2, " OR");

		$sql3 = " LIMIT {$start}, {$end} ";

		

		$sql_code = $sql1 . $sql2 . $sql3; 

		

		$query = $this->connection->prepare($sql_code);

		

		$query->execute();

		

		$pageList = $query->fetchAll(PDO::FETCH_ASSOC);

		$totalRowSelected = $query->rowCount();

		

		if($totalRowSelected > 0)

			return $pageList;

		else

			return 0;

	}

}

?>