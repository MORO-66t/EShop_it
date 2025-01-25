<?php
include("Controller.php");

	class PageController extends Controller

	{

		public function fetchData($table, $column, $id)

		{

			$sql_code = "SELECT * FROM {$table} WHERE {$column} = {$id}";

			$query = $this->connection->prepare($sql_code);

			$query->execute();

			$dataList = $query->fetchAll(PDO::FETCH_ASSOC);

			$totalRowSelected = $query->rowCount();

			

			if($totalRowSelected > 0)

				return $dataList;

			else

				return 0;

		}

		public function paginateData($table, $column, $id, $start, $end)

		{

			$sql_code1 = "SELECT * FROM {$table} WHERE {$column} = {$id} LIMIT {$start}, {$end}";

			$query = $this->connection->prepare($sql_code1);

			$query->execute();

			$pageList = $query->fetchAll(PDO::FETCH_ASSOC);

			$totalPageSelected = $query->rowCount();

			

			if($totalPageSelected > 0)

				return $pageList;

			else

				return 0;

		}		
	}

?>