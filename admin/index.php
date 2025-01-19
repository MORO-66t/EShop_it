<?php
### INCLUDE VIEW CLASS
include(" View.php");

## [O]bject Defined 
$view = new View;

## [M]ethod Execute | VIEW CLASS
$view->loadContent("content", "login");
?>