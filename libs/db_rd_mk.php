<?php

$host="IP";
$database="database";
$port="port";
$user="db_user";
$pass="db_pass";

$connection = pg_connect("host=$host dbname=$database port=$port user=$user password=$pass") or die(pg_last_error());

?>