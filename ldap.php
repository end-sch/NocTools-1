<?php

    $adServer = "ldap://server-ip";

    $ldap = ldap_connect($adServer);
    $username = $_POST['login'];
    $password = $_POST['senha'];

    $ldaprdn = 'DOMAIN' . "\\" . $username;

    ldap_set_option($ldap, LDAP_OPT_PROTOCOL_VERSION, 3);
    ldap_set_option($ldap, LDAP_OPT_REFERRALS, 0);

    $bind = @ldap_bind($ldap, $ldaprdn, $password);

    $agora = date("d/m/Y - H:m:s");

    if ($bind) {
        $filter="(sAMAccountName=$username)";
        $result = ldap_search($ldap,"dc=domain,dc=local",$filter);
        ldap_sort($ldap,$result,"sn");
        $info = ldap_get_entries($ldap, $result);
        for ($i=0; $i<$info["count"]; $i++)
        {
            if($info['count'] > 1)
                break;
            echo "Logado";
            $log = "Login Accepted: ".$agora."  -  ".$username."\n";
            session_start();
			$_SESSION['login'] = $username;
			$_SESSION['senha'] = $password;
            $_SESSION['nome'] = $info[$i]["givenname"][0]." ".$info[$i]["sn"][0];
            $_SESSION['departamento'] = $info[$i]["department"][0];
        }
        @ldap_close($ldap);
    } else {
        echo "Usuário ou senha inválidos.";
        $log = "Login Rejected: ".$agora."  -  ".$username."\n";
    }

//Log file
$filename = 'log/access-log.txt';

if (is_writable($filename)) {

    if (!$handle = fopen($filename, 'a')) {
//         echo "Não foi possível abrir o arquivo ($filename)";
         exit;
    }

    if (fwrite($handle, $log) === FALSE) {
//        echo "Não foi possível escrever no arquivo ($filename)";
        exit;
    }

//    echo "Sucesso: Escrito ($log) no arquivo ($filename)";

    fclose($handle);

} else {
//    echo "O arquivo $filename não pode ser alterado";
}

?>