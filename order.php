<?php

include("app/Http/Controllers/View.php");

$view = new View;

$view->loadContent("include", "session");
 include("top.php")
$view->loadContent("content", "order");
 
