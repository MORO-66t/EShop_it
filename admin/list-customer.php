<?php

include("View.php");


$view = new View;


$view->loadContent("include", "session");
$view->loadContent("include", "top");
$view->loadContent("content", "list-customer");
$view->loadContent("include", "tail");
?>