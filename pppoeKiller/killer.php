<?php
include('auth.php');

echo '<div class="alert alert-info"><h5>Conectando ao Juniper para desconectar clientes...</h5></div>';
ob_flush();
flush();

$ifaces = unserialize($_POST['ifaces']);
$bng = $_POST['bng'];

switch ($bng) {
		case "BNG-A":
		$ssh = $ssh_bng_a;
		break;
		case "BNG-B":
		$ssh = $ssh_bng_b;
		break;
		}

foreach ($ifaces as $iface) {
	if ($iface !== "") {
		echo 'clear pppoe sessions '.$iface.' === ';
		$kill = $ssh->exec('clear pppoe sessions '.$iface);
		echo $kill.'<br/>';
		ob_flush();
		flush();
		}
}

//$ssh->exec('exit');
echo '<br /><div class="alert alert-success"><h5>Usuários desconectados</h5></div>';

?>