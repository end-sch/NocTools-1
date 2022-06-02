<?php

include('auth.php');

$bng=$_POST["bng"];
$pp0=$_POST["pp0"];

switch ($bng) {
		case "BNG-A":
		$ssh = $ssh_bng_a;
		break;
		case "BNG-B":
		$ssh = $ssh_bng_b;
		break;
		}

$send = "clear pppoe session ".$pp0;

$ssh->exec($send);

$ssh->exec('exit');

?>