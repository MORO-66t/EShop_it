<?php

session_start();

include("site.php");

include("database.php");

class View

{

	public function loadContent($directory, $page_name)

	{

		include($directory."/".$page_name.".php");

	}

}

?>