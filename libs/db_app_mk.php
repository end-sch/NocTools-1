<?php

$host="IP";
$port="porta";
$user="db_user";
$pass="db_pass";
$database="database";

$connection = pg_connect("host=$host dbname=$database port=$port user=$user password=$pass") or die(pg_last_error());
?>