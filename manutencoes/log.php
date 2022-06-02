<?php

if ( empty( $_POST['id'] ) ) {
	exit;
} else {
	$id = $_POST['id'];
}

require_once 'db.php';

try {
	$link = new PDO( RAD_DB_DRIVER . ':host=' . RAD_DB_HOST . ';dbname=' . RAD_DB_NAME, RAD_DB_USER, RAD_DB_PASS );
} catch ( PDOException $Exception ) {
	die( $Exception->getMessage() );
}

$query = ("SELECT log FROM situacao WHERE id = :id ");
$log = $link->prepare( $query );
$log->bindParam(':id',$id);
$log->execute();

	$row = $log->fetch( PDO::FETCH_ASSOC );

	echo $row['log'];
	
?>