<?php
    session_start();
	include 'config.php';
    $sql = 'SELECT * FROM `user`';
    $result = mysql_query($sql,$link);
    while ($row = mysql_fetch_array($result, MYSQL_BOTH)) 
    {
        echo("Name: " . $row['name'] . " E-mail: " . $row['email'] . "</br>");
    }
?>