<?php

class Controller

{

	public $connection;

	

	### CONNECTION MANAGER

	public function __construct()

	{

		$this->connection = new PDO('mysql:host='.$GLOBALS['DBHOST'].';dbname='.$GLOBALS['DBNAME'].';charset=utf8', $GLOBALS['DBUSER'], $GLOBALS['DBPASS']);

		$this->connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

		$this->connection->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);

	}
}
    ?>