<?php
require_once 'db.php';

try {
	$link = new PDO( RAD_DB_DRIVER . ':host=' . RAD_DB_HOST . ';dbname=' . RAD_DB_NAME, RAD_DB_USER, RAD_DB_PASS );
} catch ( PDOException $Exception ) {
	die( $Exception->getMessage() );
}

$query = ("SELECT id,pop,DATE_FORMAT(horainicio, '%d-%m-%Y %H:%i') AS custom_inicio,DATE_FORMAT(previsao, '%d-%m-%Y %H:%i') AS custom_previsao,DATE_FORMAT(horafim, '%d-%m-%Y %H:%i') AS custom_fim,cidade,tecnico,at,status,obs,log FROM situacao ORDER BY (status != 'Online') DESC, (status = 'Manutenção Programada'), id DESC");
$loadTable = $link->prepare( $query );
$loadTable->execute();

$rowcount = 0;

	while($rowcount < 70) {
		$row = $loadTable->fetch( PDO::FETCH_ASSOC );

	switch ($row['status']) {
		case "Online":
			$corRow = 'table-success';
			break;
		case "Acionar Técnico":
			$corRow = 'table-danger';
			break;
		case "Manutenção Programada":
			$corRow = 'table-info';
			break;
		default:
			$corRow = 'table-warning';
			break;
		}
	 
	$horaInicio = $row['custom_inicio'];
 
	if (($row['custom_previsao']) === '01-01-0001 00:00') {
		$previsao = "";} else {
			$previsao = $row['custom_previsao'];
		}
 
	if (($row['custom_fim']) === '01-01-0001 00:00') {
		$horaFim = "";} else {
			$horaFim = $row['custom_fim'];
		}

    echo '<tr class="d-flex '.$corRow.'" id="'.$row['id'].'" log="'.$row['log'].'">';
		echo '<td class="col-2">'.$row['pop'].'</td>';
		echo '<td class="col-1 text-center">'.$horaInicio.'</td>';
		echo '<td class="col-1 text-center">'.$previsao.'</td>';
		echo '<td class="col-1 text-center">'.$horaFim.'</td>';
		echo '<td class="col-1 text-center">'.$row['cidade'].'</td>';
		echo '<td class="col-1 text-center">'.$row['tecnico'].'</td>';
		echo '<td class="col-1 text-center">'.$row['at'].'</td>';
		echo '<td class="col-1 text-center">'.$row['status'].'</td>';
		echo '<td class="col-3 text-justify">'.$row['obs'].'</td>';
	echo '</tr>';

	++$rowcount;
    }
?>