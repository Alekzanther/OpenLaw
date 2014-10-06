<?php
session_start();
include_once $_SERVER['DOCUMENT_ROOT'] . '/OpenLaw/Server/DataAccess/dataAccess.php';
$view = dataAccess::global_instance();
$username = $_POST['username'];
$password = $_POST['password'];
echo($view->authenticateUser($username, $password));
?>