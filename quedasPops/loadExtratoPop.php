<?php
include ("../libs/db_rd_mk.php");

// Quedas de clientes por POPs
$pop = $_POST['pop'];

$query = "SELECT clientes.nome_razaosocial,
	r.username, 
	r.calledstationid, 
	r.callingstationid,
	r.totalquedas
FROM (
	SELECT 
		username,
		callingstationid,
		calledstationid,
		COUNT(username) AS totalquedas
	FROM acct.mk_radacct_rel
	WHERE acctstopdate = current_date
		AND calledstationid = '{$pop}'
		AND acctstoptime > now()::time - interval '4h'
	GROUP BY username, callingstationid, calledstationid
		) AS r
		LEFT JOIN clientes 
			ON r.username = clientes.username
ORDER BY r.totalquedas DESC";

$result = pg_query($connection, $query) or die(pg_last_error());

if ($result) {

echo '<thead>
		  <tr>
			<th><b><center>Cliente</center></b></td>
			<th><b><center>Usuario PPPoE</center></b></td>
			<th><b><center>POP</center></b></td>
			<th><b><center>MAC</center></b></td>
			<th><b><center>Total de quedas</center></b></td>
		  </tr>
	  </thead>
	  <tbody>';

        while($row = pg_fetch_row($result)) {

		echo '<tr username="'.$row[1].'" cliente="'.$row[0].'">';
		echo '<td><a><i class="fas fa-search"></i> '.$row[1].' - '.$row[0].'</a></td>';
		echo '<td><center>'.$row[1].'</center></td>';
		echo '<td><center>'.$row[2].'</center></td>';
		echo '<td><center>'.$row[3].'</center></td>';
		echo '<td><center>'.$row[4].'</center></td>';
		echo '</tr>';
        }

	echo '</tbody>';
}

pg_close($connection) or die(pg_last_error());
?>