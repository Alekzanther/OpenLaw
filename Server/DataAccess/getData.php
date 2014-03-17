<?php
include_once $_SERVER['DOCUMENT_ROOT'] . '/OpenLaw/Server/DataAccess/dataAccess.php';
$view = dataAccess::global_instance();
echo($view->getData($_GET['type']));
?>