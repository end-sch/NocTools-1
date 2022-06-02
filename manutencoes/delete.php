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

$delete = $link->prepare("DELETE FROM situacao WHERE id = :id ");
$delete->bindParam(':id',$id);
$delete->execute();

if ($delete->rowCount() > 0) {
	echo 'Deleted';
	exit;
} else {
	echo 'Error';
	exit;
}