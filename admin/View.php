<?php
### GLOBAL SESSION
session_start();

### CONFIGURATION FILES
include("site.php");
include("database.php");

### VIEW CLASS
class View
{
	public function loadContent($directory, $page_name)
	{
		include("".$directory."/".$page_name.".php");
	}
}
?>