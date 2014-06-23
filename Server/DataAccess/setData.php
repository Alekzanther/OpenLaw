<?php
include_once $_SERVER['DOCUMENT_ROOT'] . '/OpenLaw/Server/DataAccess/dataAccess.php';
$view = dataAccess::global_instance();
$data = $_POST['data'];
$type = $_POST['type'];
echo($view->setData($type, $data));
?>