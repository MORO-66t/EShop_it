<?php
class Eloquent
{
	public $connection;
	
	public function __construct()
	{
		$this->connection = new PDO('mysql:host='.$GLOBALS['DBHOST'].';dbname='.$GLOBALS['DBNAME'].';charset=utf8', $GLOBALS['DBUSER'], $GLOBALS['DBPASS']);
		$this->connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		$this->connection->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
	}

	public function selectData($columnName, $tableName, $whereValue = 0, $inColumn = 0, $inValue = 0, $formatBy = 0, $paginate = 0)
	{
		try
		{
			// -- SELECT FROM TABLE -- //
			if($columnName == "*")
			{
				$sql1 = "SELECT ";
				$sql2 = "*";
			}
			else
			{
				$sql1 = "SELECT ";
				foreach($columnName AS $ca1Column => $ca1Value)
				{
					# $ca1ColumnUpper = strtoupper($ca1Value);
					@$sql2 .= "`$ca1Value`, ";
				}
				$sql2 = rtrim(@$sql2, ", ");
			}
			$sql3 = " FROM `$tableName`";
			// -- SELECT FROM TABLE -- //
			
			// -- FORMAT -- //
			if(@$formatBy['GROUP'])
				$sql6 = " GROUP BY `" . $formatBy['GROUP'] . "`";
			else
				$sql6 = "";
			
			if(@$formatBy['ASC'])
				$sql7 = " ORDER BY `" . $formatBy['ASC'] . "` ASC";
			else if(@$formatBy['DESC'])
				$sql7 = " ORDER BY `" . $formatBy['DESC'] . "` DESC";
			else
				$sql7 = "";
			// -- FORMAT -- //
			
			if($inValue != 0)
			{
				$sql4 = " WHERE `$inColumn` IN (";
				#  ('ONE_VALUE', 'ANOTHER_VALUE');
				foreach($inValue AS $in1Column => $in1Value)
				{
					@$sql5 .= "'$in1Value', ";
				}
				$sql5 = rtrim(@$sql5, ", ");
				$sql5 = $sql5 . ")";
			}
			
			// -- PAGINATION HANDLER -- //
			if($paginate != 0)
				$sql8 = " LIMIT " . $paginate['POINT'] . ", " . $paginate['LIMIT'];
			else
				$sql8 = "";
			// -- PAGINATION HANDLER -- //
			
			// -- WHERE -- //
			if($whereValue != 0)
			{
				$sql4 = " WHERE ";
				
				foreach($whereValue AS $wa1Column => $wa1Value)
				{
					@$sql5 .= $wa1Column . " = " . "'" . $wa1Value . "' AND ";
				}
				$sql5 = trim($sql5); $sql5 = rtrim($sql5, "AND"); $sql5 = trim($sql5); // NIRU //
				
				$preSQL = $sql1 . $sql2 . $sql3 . $sql4 . $sql5 . $sql6 . $sql7 . $sql8;
			}
			else
			{
				if($inValue != 0)
				{
					$preSQL = $sql1 . $sql2 . $sql3 . $sql4 . $sql5 . $sql6 . $sql7 . $sql8;
				}
				else
				{
					$preSQL = $sql1 . $sql2 . $sql3 . $sql6 . $sql7 . $sql8;
				}
			}
			// -- WHERE -- //
			
			$query = $this->connection->prepare($preSQL);
			$query->execute();
			$dataSelected = $query->fetchAll(PDO::FETCH_ASSOC);
			
			return $dataSelected;
		}
		catch(Exception $e) 
		{
			return 0;
		}
	}
	
		
}
