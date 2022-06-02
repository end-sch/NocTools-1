<?php
include ("db.php");

$id = $_POST['id'];
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

	$update = $link->prepare( 'UPDATE situacao SET pop = :pop, previsao = :previsao, horafim = :horafim, cidade = :cidade, tecnico = :tecnico, at = :at, status = :status, obs = :obs, log = :log WHERE id = :id' );

	$update->bindParam(':id',$id);
	$update->bindParam(':pop',$pop);
	$update->bindParam(':previsao',$previsao);
	$update->bindParam(':horafim',$horafim);
	$update->bindParam(':cidade',$cidade);
	$update->bindParam(':tecnico',$tecnico);
	$update->bindParam(':at',$at);
	$update->bindParam(':status',$status);
	$update->bindParam(':obs',$obs);
	$update->bindParam(':log',$log);

	$update->execute();
	if ($update->rowCount() == 1) {
		echo 'Updated';
		exit;
	} else {
		echo 'NoChanges';
		exit;
		}

?>
