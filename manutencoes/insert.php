<?php
include ("db.php");

$pop = $_POST['pop'];
$horainicio = $_POST['horainicio'];
$previsao = $_POST['previsao'];
$horafim = $_POST['horafim'];
$cidade = $_POST['cidade'];
$tecnico = $_POST['tecnico'];
$at = $_POST['at'];
$status = $_POST['status'];
$obs = $_POST['obs'];
$log = $_POST['log'];

try {
	$link = new PDO( RAD_DB_DRIVER . ':host=' . RAD_DB_HOST . ';dbname=' . RAD_DB_NAME, RAD_DB_USER, RAD_DB_PASS );
} catch ( PDOException $Exception ) {
	die( $Exception->getMessage() );
}

	$insert = $link->prepare('INSERT INTO situacao (pop,horainicio,previsao,horafim,cidade,tecnico,at,status,obs,log) VALUES (:pop, :horainicio, :previsao, :horafim, :cidade, :tecnico, :at, :status, :obs, :log)' );

	$insert->bindParam(':pop',$pop);
	$insert->bindParam(':horainicio',$horainicio);
	$insert->bindParam(':previsao',$previsao);
	$insert->bindParam(':horafim',$horafim);
	$insert->bindParam(':cidade',$cidade);
	$insert->bindParam(':tecnico',$tecnico);
	$insert->bindParam(':at',$at);
	$insert->bindParam(':status',$status);
	$insert->bindParam(':obs',$obs);
	$insert->bindParam(':log',$log);

	$insert->execute();
	if ($insert->rowCount() == 1) {
		echo 'Inserted';
		exit;
	} else {
		echo 'Error';
		exit;
		}
?>
