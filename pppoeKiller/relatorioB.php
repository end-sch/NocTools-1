<?php

	include('auth.php');
	include ("../libs/db_rd_mk.php");

	echo '<h5>Comparativo BNG-B:</h5>';
	
	ob_flush();
	flush();

	//Consulta Juniper
	$array_junos = [];
	$i_junos = 0;

	$resposta = $ssh_bng_b->exec('show subscribers client-type pppoe | match pp0. | no-more');
	$ssh_bng_b->exec('exit');

	//Quebra em linhas o resultado do Juniper
	$linhas = explode("\n" , $resposta);
	$linhas = preg_replace('/\s+/', ' ', $linhas);

	//Cria um array com os usuários do Juniper
	foreach($linhas as $linha) {
	$linha = preg_replace('/\s+/', ' ', $linha);
	$user = explode(" ", $linha);
		if ($user[2] <> '' && $user[2] <> 'default:default') {
			array_push($array_junos, $user[2]);
			$i_junos++;
			}
		}

	echo '<strong>Total Juniper BNG-B: </strong>'.$i_junos.'<br>';
	ob_flush();
	flush();
	//Fim consulta Juniper

	//Consulta Routerbox
	$array_rbx = [];
	$i_rbx = 0;

	$query = "SELECT username FROM radius.radacct WHERE nasipaddress = '192.168.109.46' AND acctstoptime is NULL;";

	$result = pg_query($connection, $query) or die(pg_last_error());

	if($result) {

	    while($row = pg_fetch_row($result)) {
	    	//Cria um array com os usuários do Routerbox
	        array_push($array_rbx, $row[0]);
	        $i_rbx++;
	    	}
		}

	pg_close($connection) or die(pg_last_error());

	echo '<strong>Total MKSolutions BNG-B: </strong>'.$i_rbx.'<br>';
	ob_flush();
	flush();
	//Fim consulta Routerbox

		if ($i_junos > $i_rbx) {

	echo '<strong>Diferença: </strong>'.($i_junos - $i_rbx).'<br><br>';
	ob_flush();
	flush();

		//Compara os arrays de usuários do Juniper e do Routerbox
		$diferenca = array_diff($array_junos, $array_rbx);

		//Consulta as interfaces da resposta do Juniper em busca das interfaces para os usuários inexistentes
		$interfaces = array();
		echo '<h4>Inconsistências:</h4>';
		foreach ($diferenca as $pppoe) {
			$fl_array = preg_grep(".$pppoe.", $linhas);
			//Executa ações
			foreach ($fl_array as $interface) {
				$interface = explode(" ", $interface);
				echo 'User: '.$interface[2].' | clear pppoe sessions '.$interface[0].'<br>';
				array_push($interfaces, $interface[0]);
				ob_flush();
				flush();
				}
			}
			$botao = serialize($interfaces);
			echo "<br><button id='killB' class='btn btn-danger float-right' bng='BNG-B' ifaces='".$botao."'>Matar Sessoes</button><br><br>";
		}

?>