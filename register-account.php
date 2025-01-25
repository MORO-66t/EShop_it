<?php

include_once("View.php");

$view = new View;

$view->loadContent("include", "session");
$view->loadContent("include", "top");
$view->loadContent("content", "register-account");
$view->loadContent("include", "tail");
 
