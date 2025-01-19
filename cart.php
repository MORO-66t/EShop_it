<?php

include(" View.php");

$view = new View;

$view->loadContent("include", "session");
 include("top.php")
$view->loadContent("content", "cart");
 
