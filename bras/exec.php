<?php
include('auth.php');

$comando=$_POST["comando"];
$parametro=$_POST["parametro"];

	switch ($comando) {
		case "ip":
		$send = "show subscriber address ".$parametro." extensive";
		break;
		case "usr":
		$send = "show subscriber user-name ".$parametro." extensive";
		break;
        case "rota":
        $send = "show route ".$parametro." detail";
        break;
		}

//total de usuarios
$summary = "show subscribers summary | match PPPoE";

$total_a = ($ssh_bng_a->exec($summary));
$total_a = explode(':', $total_a);

$total_b = ($ssh_bng_b->exec($summary));
$total_b = explode(':', $total_b);

$total = ($total_a[1]+$total_b[1]);

//Outro Output
$output_a = ($ssh_bng_a->exec($send));
$output_b = ($ssh_bng_b->exec($send));

if (strlen($output_a) > strlen($output_b) ) {
    $output = $output_a;
    $bng = 'BNG-A';
} else {
    $output = $output_b;
    $bng = 'BNG-B';
}

$pedacos = explode('Interface' , $output);
$pedacos = explode('Interface' , $output);
$pp0 = preg_replace('[: |\\n]', '', $pedacos[1]);

ob_start(); //Start output buffer
echo nl2br($output);
$status = ob_get_contents(); //Grab output
ob_end_clean(); //Discard output buffer

//Separa usuario do output
$user = explode('User Name: ', $status);
$user = explode('<br />', $user[1]);

//Cria JSON
    $arr = array( 'pp0' => $pp0,
        'bng' => $bng,
        'total_a' => $total_a[1],
        'total_b' => $total_b[1],
    	'total' => $total,
    	'send' => $send,
        'output' => $status,
        'user' => $user[0]
          );
    echo json_encode($arr);

$ssh_bng_a->exec('exit');
$ssh_bng_b->exec('exit');

?>