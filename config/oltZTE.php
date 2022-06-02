<?php

include('../libs/ClassLoader.php');

$loader = new \Composer\Autoload\ClassLoader();
$loader->addPsr4('phpseclib\\', '../libs/phpseclib-2.0.21');
$loader->register();

use phpseclib\Crypt\RSA;
use phpseclib\Net\SSH2;

$tipo = $_POST['tipo'];
$marca = $_POST['marca'];
$ip = $_POST['ip'];
$vlan = $_POST['vlan'];
$acao = $_POST['acao'];
$parametro = $_POST['parametro'];
$modo = $_POST['modo'];
$desc = $_POST['desc'];

$ssh = new SSH2($ip);
if (!$ssh->login('username', 'password')) {
    exit('Não foi possível se conectar ou logar no equipamento.');
}

switch ($acao) {
//Mostra ONUs não provisionadas
    case "mostrar":
    echo "Procurando ONUs não provisionadas..."; ob_flush(); flush();
        $ssh->setTimeout(3);
        $ssh->write("show gpon onu uncfg\n");
        $result = $ssh->read();
        $result = explode("---------------------------------------------------------------------", $result);
        $result = preg_replace('/olt.*#|| unknown/', '', $result[1]);
        echo '</br>---------------------------------------------------------------------'.nl2br($result);
    break;

    case "provisionar":
        echo "Provisionando ONU com Serial Number: ".$parametro."<br/>"; ob_flush(); flush();

        //Identifica PON
        echo "Identificando interface GPON...<br/>"; ob_flush(); flush();
        $ssh->write("show gpon onu uncfg\n");
        $result = $ssh->read();

        $result = explode("---------------------------------------------------------------------", $result);
        $result = preg_replace('/olt.*#/', '', $result[1]);
        $result = explode("\n", $result);
        $result = preg_grep('/'.$parametro.'/', $result);
        $key = array_keys($result);
        $array = explode(" ", $result[$key[0]]);
        $pon = explode(":", $array[0]);
        $pon = str_replace('gpon-onu_', '', $pon[0]);

        echo "Interface F/S/P: ".$pon."<br/>"; ob_flush(); flush();
        $ssh->write("terminal length 512\n");
        $ssh->write("show gpon onu state gpon-olt_".$pon."\n");
        $ssh->setTimeout(1);
        $result = $ssh->read();

        $result = explode("--------------------------------------------------------------", $result);
        $result = preg_replace('/[0-9]*\/[0-9]*\/[0-9]*:| [A-Za-z]*|ONU Number.*|olt.*#|[0-9]*\([A-Za-z]*\).*/', '', $result[1]);
        $result = explode("\n", $result);
        unset($result[0]);

        $counter = 1;
        $slot = 0;
			foreach( $result as $value ) {
				if ($value > 0) {
					if ($counter == $value) {
						$counter++;
					} else {
						$slot = $counter;
					break;
					}
				}
			}
		if ($slot == 0) {
			$slot = $counter;
			}

		echo "ONU ID: ".$slot."<br/>"; ob_flush(); flush();

		//Provisiona
		echo "Provisionando ONU...<br/>";  ob_flush(); flush();

		if ($modo == 'bridge') {
			$ssh->write("configure terminal\n
			interface gpon-olt_".$pon."\n
			onu ".$slot." type BRIDGE sn ".$parametro."\n
			onu ".$slot." profile line GERAL remote GERAL\n
			exit\n
			interface gpon-onu_".$pon.":".$slot."\n
			description ".$desc."\n
	  		service-port 1 vport 1 user-vlan ".$vlan." vlan ".$vlan."\n
	  		service-port 2 vport 2 user-vlan 4080 vlan 4080\n
			exit\n
			end\n");
		} 
		if ($modo == 'router') {
			$ssh->write("configure terminal\n
			interface gpon-olt_".$pon."\n
			onu ".$slot." type ROUTER sn ".$parametro."\n
			onu ".$slot." profile line GERAL remote ROUTER\n
			exit\n
			interface gpon-onu_".$pon.":".$slot."\n
			description ".$desc."\n
	  		service-port 1 vport 1 user-vlan ".$vlan." vlan ".$vlan."\n
	  		service-port 2 vport 2 user-vlan 4080 vlan 4080\n
			exit\n
			end\n");
		}

		$ssh->setTimeout(2);
		$ssh->read();
		$ssh->write("show running-config interface gpon-onu_".$pon.":".$slot."\n
					show onu running config gpon-onu_".$pon.":".$slot."\n");
		$ssh->setTimeout(2);
		echo "ONU provisionada!<br/><br/><br/>";  ob_flush(); flush();
		$result = $ssh->read();
		$result = preg_replace('/olt.*#/', '', $result);
		echo nl2br($result);


    break;

    case "remover":
        echo "Procurando ONU...<br/>";  ob_flush(); flush();
        $ssh->write("show gpon onu by sn ".$parametro." \n");
        $result = $ssh->read();

	    if (preg_match('/No related information to show/', $result)) {
            echo "Nenhuma ONU encontrada com este Serial Number.";
        } else {
            echo "Excluindo ONU com SN: ".$parametro."<br/>"; ob_flush(); flush();
        	
	        $result = explode("-----------------", $result);
	        $result = preg_replace('/olt.*#/', '', $result[1]);
	        $result = explode(":", $result);
	        $temp = explode("_", $result[0]);
	        $pon = $temp[1];
	        $slot = $result[1];
	        echo "Porta PON: ".$pon." - ONU ID: ".$slot.".<br/>";  ob_flush(); flush();
	        echo "Desprovisionando ONU...<br/>";  ob_flush(); flush();
	        $ssh->write("configure terminal\n
	        	interface gpon-olt_".$pon."\n
	        	no onu ".$slot."\n
	        	end\n");
	        $ssh->setTimeout(2);
	        $ssh->read();
			echo "ONU excluída!<br/>";
		}

    break;

    case "migracao":
        echo "Procurando ONU...<br/>";  ob_flush(); flush();
        $ssh->write("show gpon onu by sn ".$parametro." \n");
        $result = $ssh->read();

	    if (preg_match('/No related information to show/', $result)) {
            echo "Nenhuma ONU encontrada com este Serial Number.";
        } else {
            echo "Excluindo ONU com SN: ".$parametro."<br/>"; ob_flush(); flush();
        	
	        $result = explode("-----------------", $result);
	        $result = preg_replace('/olt.*#/', '', $result[1]);
	        $result = explode(":", $result);
	        $temp = explode("_", $result[0]);
	        $pon = $temp[1];
	        $slot = $result[1];
	        $ssh->write("terminal length 512\n");
	        $ssh->write("show gpon onu detail-info gpon-onu_".$pon.":".$slot."\n");
	        $ssh->setTimeout(2);
	        $result = $ssh->read();
	        $result = explode("\n", $result);
        	$result = preg_grep('/Description:/', $result);
        	$key = array_keys($result);
        	$array = explode('"', $result[$key[0]]);
        	$desc = $array[1];
	        echo "Porta PON: ".$pon." - ONU ID: ".$slot." - Descrição: ".$desc.".<br/>";  ob_flush(); flush();
	        echo "Desprovisionando ONU...<br/>";  ob_flush(); flush();
	        $ssh->write("configure terminal\n
	        	interface gpon-olt_".$pon."\n
	        	no onu ".$slot."\n
	        	end\n");
	        $ssh->setTimeout(2);
	        $ssh->read();
			echo "ONU excluída!<br/>";
		}

        echo "Provisionando ONU com Serial Number: ".$parametro."<br/>"; ob_flush(); flush();

        //Identifica PON
        echo "Identificando interface GPON...<br/>"; ob_flush(); flush();
        $ssh->write("show gpon onu uncfg\n");
        $result = $ssh->read();

        $result = explode("---------------------------------------------------------------------", $result);
        $result = preg_replace('/olt.*#/', '', $result[1]);
        $result = explode("\n", $result);
        $result = preg_grep('/'.$parametro.'/', $result);
        $key = array_keys($result);
        $array = explode(" ", $result[$key[0]]);
        $pon = explode(":", $array[0]);
        $pon = str_replace('gpon-onu_', '', $pon[0]);

        echo "Interface F/S/P: ".$pon."<br/>"; ob_flush(); flush();
        $ssh->write("terminal length 512\n");
        $ssh->write("show gpon onu state gpon-olt_".$pon."\n");
        $ssh->setTimeout(1);
        $result = $ssh->read();

        $result = explode("--------------------------------------------------------------", $result);
        $result = preg_replace('/[0-9]*\/[0-9]*\/[0-9]*:| [A-Za-z]*|ONU Number.*|olt.*#|[0-9]*\([A-Za-z]*\).*/', '', $result[1]);
        $result = explode("\n", $result);
        unset($result[0]);

        $counter = 1;
        $slot = 0;
			foreach( $result as $value ) {
				if ($value > 0) {
					if ($counter == $value) {
						$counter++;
					} else {
						$slot = $counter;
					break;
					}
				}
			}
		if ($slot == 0) {
			$slot = $counter;
			}

		echo "ONU ID: ".$slot."<br/>"; ob_flush(); flush();

		//Provisiona
		if ($modo = 'bridge') {
			echo "Provisionando ONU...<br/>";  ob_flush(); flush();
			$ssh->write("configure terminal\n
			interface gpon-olt_".$pon."\n
			onu ".$slot." type BRIDGE sn ".$parametro."\n
			onu ".$slot." profile line GERAL remote GERAL\n
			exit\n
			interface gpon-onu_".$pon.":".$slot."\n
			description ".$desc."\n
	  		service-port 1 vport 1 user-vlan ".$vlan." vlan ".$vlan."\n
	  		service-port 2 vport 2 user-vlan 4080 vlan 4080\n
			exit\n
			end\n");
			$ssh->setTimeout(2);
			$ssh->read();
		}

		$ssh->write("show running-config interface gpon-onu_".$pon.":".$slot."\n
					show onu running config gpon-onu_".$pon.":".$slot."\n");
		$ssh->setTimeout(2);
		echo "ONU provisionada!<br/><br/><br/>";  ob_flush(); flush();
		$result = $ssh->read();
		$result = preg_replace('/olt.*#/', '', $result);
		echo nl2br($result);

    break;
}



?>