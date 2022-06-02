<?php
include('auth.php');
include ("../libs/db_rbx.php");

	$query = mysqli_query($conn_rbx, "SELECT 
									username, framedipaddress
									FROM radacct
									WHERE framedipaddress LIKE '100.64.56.%' AND acctstoptime is NULL
									OR framedipaddress LIKE '100.64.57.%' AND acctstoptime is NULL
									OR framedipaddress LIKE '100.64.58.%' AND acctstoptime is NULL
									OR framedipaddress LIKE '100.64.59.%' AND acctstoptime is NULL
									") or die(mysqli_error($conn_rbx)); 

        if($query) {

$interfaces = array();
$i = 0;

	while($row = mysqli_fetch_assoc($query)) {

		$resposta = $ssh_bng_a->exec('show subscribers address '.$row['framedipaddress'].'  | match pp0. | display json');
		$resposta = explode('"', $resposta);
	    echo $row['username'].' - '.$row['framedipaddress'].' - '.$resposta[3].'<br>';

	    array_push($interfaces, $resposta[3]);

		ob_flush();
		flush();

		$i++;
	}

	$ssh_bng_a->exec('exit');

	if ( $i > 0 ) {

	$botao = serialize($interfaces);
	echo "<br><button id='killA' class='btn btn-danger float-right' bng='BNG-A' ifaces='".$botao."'>Matar Sessoes</button><br><br>";
	
	} else {
		echo '<div class="alert alert-warning"><h4>Nenhum resultado encontrado!</h4></div>';
	}

}

mysqli_close($conn_rbx) or die(mysqli_error($conn_rbx));
?>