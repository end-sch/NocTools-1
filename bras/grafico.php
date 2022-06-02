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

$banda = ($ssh->exec("show interfaces ".$pp0." detail"));

//Quebra por linhas
		ob_start(); //Start output buffer
		echo nl2br($banda);
		$banda = ob_get_contents(); //Grab output
		ob_end_clean(); //Discard output buffer		 
		$banda = explode('<br />' , $banda);
		$upEX = explode(':', $banda[9]);
		$downEX = explode(':', $banda[10]);
//Transforma em inteiro
		$oldUP = intval($upEX[1]);
		$oldDOWN = intval($downEX[1]);


for ($i = 0; $i<50; $i++) {

$banda = ($ssh->exec("show interfaces ".$pp0." detail"));

//Quebra por linhas
		ob_start(); //Start output buffer
		echo nl2br($banda);
		$banda = ob_get_contents(); //Grab output
		ob_end_clean(); //Discard output buffer		 
		$banda = explode('<br />' , $banda);
		$upEX = explode(':', $banda[9]);
		$downEX = explode(':', $banda[10]);
//Transforma em inteiro
		$up1 = intval($upEX[1]);
		$down1 = intval($downEX[1]);
//Retorna diferença
		$up = $up1 - $oldUP;
		$down = $down1 - $oldDOWN;
//Armazena histórico
		$oldUP = $up1;
		$oldDOWN = $down1;
//Converter
		$up = ($up * 8) / (1048576 * 2);
		$down = ($down * 8) / (1048576 * 2);
		$up = round($up, 2);
		$down = round($down, 2);


echo '{"up":"'.$up.'", "down":"'.$down.'", "x":"'.$i.'"}';

flush();
ob_flush();
sleep(2);

}

$ssh->exec('exit');

?>