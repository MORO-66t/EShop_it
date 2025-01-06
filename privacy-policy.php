<?php
include("app/Http/Controllers/View.php");

$view = new View;

 include("top.php")
$view->loadContent("content", "privacy-policy");
 