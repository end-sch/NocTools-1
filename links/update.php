<?php
require_once 'db.php';

$id = $_POST['id'];
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

	$update = $link->prepare( 'UPDATE links SET acesso = :acesso, url = :url, usuario = :usuario, senha = :senha, obs = :obs WHERE id = :id' );

	$update->bindParam(':id',$id);
	$update->bindParam(':acesso',$acesso);
	$update->bindParam(':url',$url);
	$update->bindParam(':usuario',$usuario);
	$update->bindParam(':senha',$senha);
	$update->bindParam(':obs',$obs);

	$update->execute();
	if ($update->rowCount() == 1) {
		echo 'Updated';
		exit;
	} else {
		echo 'Error';
		exit;
		}

?>