<?php
$host = "localhost";
$user = "geslib";
$password = "geslib";
$database = "geslib";
/* Connect to the db and select a database*/
$dbLink  = mysql_connect($host,$user, $password) or die("Couldn't connect to the database!");
$success = mysql_select_db($database) or die("Error selecting the database! <br> ".mysql_error());
?>
