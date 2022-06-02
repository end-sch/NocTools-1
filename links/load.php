<?php
require_once 'db.php';

try {
	$link = new PDO( RAD_DB_DRIVER . ':host=' . RAD_DB_HOST . ';dbname=' . RAD_DB_NAME, RAD_DB_USER, RAD_DB_PASS );
} catch ( PDOException $Exception ) {
	die( $Exception->getMessage() );
}

$query = ("SELECT * FROM links ORDER BY acesso ASC");
$loadTable = $link->prepare( $query );
$loadTable->execute();

	while($row = $loadTable->fetch( PDO::FETCH_ASSOC )) {
		echo '<tr id="'.$row['id'].'">';
		echo '<td>'.$row['acesso'].'</td>';
		echo '<td><a href="'.$row['url'].'" target="_blank">'.$row['url'].'</a></td>';
		echo '<td>'.$row['usuario'].'</td>';
		echo '<td>'.$row['senha'].'</td>';
		echo '<td>'.$row['obs'].'</td>';
		echo '<td><i class="fas fa-edit btnEditar"></i><i class="fas fa-trash-alt btnExcluir"></i></td>';
		echo '</tr>';
    }
?>