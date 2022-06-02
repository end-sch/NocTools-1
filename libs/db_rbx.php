<?php

$host="IP";
$user="db_user";
$pass="db_pass";
$database="database";

$conn_rbx = @mysqli_connect($host, $user, $pass, $database) or die(mysqli_connect_error());
?>