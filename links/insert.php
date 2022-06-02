<?php
include ("db.php");

$acesso = $_POST['acesso'];
$url = $_POST['url'];
$usuario = $_POST['usuario'];
$senha = $_POST['senha'];
$obs = $_POST['obs'];

try {
	$link = new PDO( RAD_DB_DRIVER . ':host=' . RAD_DB_HOST . ';dbname=' . RAD_DB_NAME, RAD_DB_USER, RAD_DB_PASS );
} catch ( PDOException $Exception ) {
	die( $Exception->getMessage() );
}

	$insert = $link->prepare('INSERT INTO links (acesso,url,usuario,senha,obs) VALUES (:acesso, :url, :usuario, :senha, :obs)' );

	$insert->bindParam(':acesso',$acesso);
	$insert->bindParam(':url',$url);
	$insert->bindParam(':usuario',$usuario);
	$insert->bindParam(':senha',$senha);
	$insert->bindParam(':obs',$obs);

	$insert->execute();
	if ($insert->rowCount() == 1) {
		echo 'Inserted';
		exit;
		} else {
			echo 'Error';
			exit;
		}
?>
