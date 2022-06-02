<?php

include ("../libs/db_rd_mk.php");

$query = "SELECT clientes.nome_razaosocial, r.username, r.calledstationid, r.totalquedas 
FROM (
	SELECT 
		COUNT(username) AS totalquedas,
		username,
		calledstationid		
	FROM acct.mk_radacct_rel
	WHERE acctstopdate = current_date
	GROUP BY username, calledstationid
		) AS r
		LEFT JOIN clientes
			ON r.username = clientes.username
ORDER BY r.totalquedas DESC";

$result = pg_query($connection, $query) or die(pg_last_error());

if($result) {

	echo '<thead>
			<tr>
				<th><b><center>Cliente</center></b></td>
				<th><b><center>Usuario PPPoE</center></b></td>
				<th><b><center>POP</center></b></td>
				<th><b><center>Total de autenticações Hoje</br>(00:00hrs até agora)</center></b></td>
			</tr>
		</thead>
		<tbody>';

	$rowcount = 0;

        while($rowcount < 70) {
        	($row = pg_fetch_row($result));

	    	echo '<tr username="'.$row[1].'" cliente="'.$row[0].' - '.$row[1].'">';
	    	echo '<td>'.$row[0].' - '.$row[1].'</td>';
			echo '<td><a><center><i class="fas fa-search"></i> '.$row[1].'</center></a></td>';
			echo '<td><center>'.$row[2].'</center></td>';
			echo '<td><center>'.$row[3].'</center></td>';
			echo '</tr>';

		++$rowcount;
	}

	echo '</tbody>';
}

pg_close($connection) or die(pg_last_error());
?>