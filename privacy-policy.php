<?php
include("app/Http/Controllers/View.php");

$view = new View;

$view->loadContent("include", "top");
$view->loadContent("content", "privacy-policy");
$view->loadContent("include", "tail");