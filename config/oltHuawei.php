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
        $ssh->read('#.*>.*#', SSH2::READ_REGEX);
        $ssh->write("enable\n");
        $ssh->setTimeout(1);
        $ssh->write("config\n");
        $ssh->read('#.*(config).*#', SSH2::READ_REGEX);
        $ssh->write("display ont autofind all\n");
        $ssh->setTimeout(1);
        $ssh->write("\n");
        $result = $ssh->read();
        echo nl2br($result);
    break;

    case "provisionar":
        echo "Provisionando ONU com Serial Number: ".$parametro."<br/>"; ob_flush(); flush();
        $ssh->read('#.*>.*#', SSH2::READ_REGEX);
        $ssh->write("enable\n");
        $ssh->setTimeout(1);
        $ssh->write("config\n");
        $ssh->read('#.*config.*#', SSH2::READ_REGEX);

        //Identifica PON
        echo "Identificando interface GPON...<br/>"; ob_flush(); flush();
        $ssh->write("display ont autofind all\n");
        $ssh->setTimeout(1);
        $ssh->write("\n");
        $ssh->write("q \n");
        $result = $ssh->read();

        sleep(3);

        $result = explode("----------------------------------------------------------------------------", $result);
        $result = preg_grep('/'.$parametro.'/', $result);
        $key = array_keys($result);

                $array = explode("\n", $result[$key[0]]);

                    $array2 = preg_grep("/F\/S\/P/", $array);
                    foreach( $array2 as $value ) {
                        $gpon = explode(":", $value);
                        }

        $pon = explode("/", $gpon[1]);

        echo "Interface F/S/P: ".$gpon[1]."<br/>"; ob_flush(); flush();

        //Provisiona
        $ssh->write("interface gpon ".$pon[0]."/".$pon[1]."\n");
        $ssh->read('#.*config.*#', SSH2::READ_REGEX);
        $ssh->write("ont add ".$pon[2]." sn-auth ".$parametro." omci ont-lineprofile-name ".$modo." ont-srvprofile-name ".$modo." desc \"".$desc."\" \n");
        $ssh->setTimeout(3);
        $ssh->write("\n");
        $ssh->read('#.*config.*#', SSH2::READ_REGEX);
        $ssh->write("quit\n");
        $ssh->setTimeout(1);

        //Localiza ID da ONT
        echo "ONU Provisionada. Identificando ID...<br/>";  ob_flush(); flush();
        $ssh->write("display ont info by-sn ".$parametro."\n");
        $ssh->setTimeout(1);
        $ssh->write("\n");
        $ssh->setTimeout(3);
        $ssh->write("q \n");
        $ssh->setTimeout(3);
        $result = $ssh->read();

        {
        sleep(3);
        $array = explode("\n", $result);

            $array2 = preg_grep("/ONT-ID/", $array);
            foreach( $array2 as $value ) {
                $ontid = explode(":", $value);
                }
        }

        echo "ONU ID: ".$ontid[1]."<br/>"; ob_flush(); flush();

        //Configura portas se for bridge
        if ($modo = 'bridge') {
            $ssh->write("interface gpon ".$pon[0]."/".$pon[1]."\n");
            $ssh->setTimeout(3);
            $ssh->write("ont port native-vlan ".$pon[2]." ".$ontid[1]." eth 1 vlan ".$vlan."\n");
            $ssh->setTimeout(3);
            $ssh->write("\n");
            $ssh->write("quit\n");
            $ssh->setTimeout(1);
            echo "Porta configurado no modo Bridge.<br/>";  ob_flush(); flush();
        }

        //Portas de serviço

        echo "Configurando portas de serviço...<br/>";  ob_flush(); flush();
        $ssh->write("service-port vlan ".$vlan." gpon".$gpon[1]."ont".$ontid[1]."gemport 11 multi-service user-vlan ".$vlan." tag-transform translate\n");
        $ssh->setTimeout(5);
        $ssh->read();
        $ssh->write("\n");
        $ssh->setTimeout(3);
        $ssh->write("\n");
        $ssh->write("service-port vlan 4080 gpon".$gpon[1]."ont".$ontid[1]."gemport 12 multi-service user-vlan 4080 tag-transform translate\n");
        $ssh->setTimeout(5);
        $ssh->read();
        $ssh->write("\n");
        $ssh->setTimeout(3);
        $ssh->write("\n");
        $ssh->setTimeout(3);
        $ssh->write("quit\n");
        $ssh->setTimeout(2);
        $ssh->write("quit\n");
        $ssh->setTimeout(2);
        $ssh->write("quit\n");
        $ssh->setTimeout(3);
        $ssh->write("y \n");
        $ssh->setTimeout(3);
        echo "Portas de serviço criadas.<br/>"; ob_flush(); flush();
        echo "ONU provisionada!<br/>"; 
    break;

    case "remover":
        echo "Procurando ONU...<br/>";  ob_flush(); flush();
        $ssh->read('#.*>.*#', SSH2::READ_REGEX);
        $ssh->write("enable\n");
        $ssh->setTimeout(1);
        $ssh->write("config\n");
        $ssh->read('#.*config.*#', SSH2::READ_REGEX);
        $ssh->write("display ont info by-sn ".$parametro." \n");
        $ssh->setTimeout(1);
        $ssh->write("\n");
        $ssh->setTimeout(3);
        $ssh->write("q\n");
        $result = $ssh->read();

        if (preg_match('/The required ONT does not exist/', $result)) {
            echo "Nenhuma ONU encontrada com este Serial Number.";
        } else {
            echo "Excluindo ONU com SN: ".$parametro."<br/>"; ob_flush(); flush();

            $array = explode("\n", $result);

                $array2 = preg_grep("/F\/S\/P/", $array);
                foreach( $array2 as $value ) {
                    $gpon = explode(":", $value);
                    $pon = explode("/", $gpon[1]);
                    }
                $array2 = preg_grep("/ONT-ID/", $array);
                foreach( $array2 as $value ) {
                    $ontid = explode(":", $value);
                    }

            echo "Porta F/S/P: ".$gpon[1]." - ONU ID: ".$ontid[1].".<br/>";  ob_flush(); flush();
            echo "Excluindo Portas de serviço...<br/>";  ob_flush(); flush();
            $ssh->write("undo service-port port ".$gpon[1]." ont ".$ontid[1]."\n");
            $ssh->setTimeout(3);
            $ssh->write("y\n");
            $ssh->setTimeout(3);
            $ssh->read();

            echo "Desprovisionando ONU...<br/>";  ob_flush(); flush();
            $ssh->write("interface gpon ".$pon[0]."/".$pon[1]." \n");
            $ssh->read('#.*config.*#', SSH2::READ_REGEX);
            $ssh->write("ont delete ".$pon[2]." ".$ontid[1]." \n");
            $ssh->setTimeout(5);
            $ssh->read();
            echo "ONU excluída!<br/>";

        }

    break;
}



?>