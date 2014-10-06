<?php
session_start();
include_once $_SERVER['DOCUMENT_ROOT'] . '/OpenLaw/Server/DataAccess/dataAccess.php';
ChromePhp::log("SESSION : " . $_SESSION["username"]);
$view = dataAccess::global_instance();
echo($view->getData($_GET['type']));
?>