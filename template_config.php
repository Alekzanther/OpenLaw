<?php
	// Connection's Parameters
	$db_host="databasehost";
	$db_name="databasename";
	$username="username";
	$password="password";
	$db_con=mysql_connect($db_host,$username,$password);
	$connection_string=mysql_select_db($db_name);
	// Connection
	$link = mysql_connect($db_host,$username,$password);
    mysql_select_db($db_name);
	if (!$link) {
		die('Could not connect: ' . mysql_error());
	}
?>