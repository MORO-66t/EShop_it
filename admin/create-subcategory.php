<?php

include("View.php");


$view = new View;


$view->loadContent("include", "session");
$view->loadContent("include", "top");
$view->loadContent("content", "create-subcategory");
$view->loadContent("include", "tail");
?>