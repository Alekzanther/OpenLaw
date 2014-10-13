<?php
session_start();
include_once $_SERVER['DOCUMENT_ROOT'] . '/OpenLaw/Server/DataAccess/dataAccess.php';
$view = dataAccess::global_instance();
ChromePhp::log("SESSION : " . $_SESSION["username"]);
$data = $_POST['data'];
echo($view->createData($data));
?>