<?php
include ("../libs/db_rd_mk.php");

// Extrato cliente
$username = $_POST['username'];

$query = "SELECT 
	(acctstartdate + acctstarttime) AS comeco,
	(acctstopdate + acctstoptime) AS fim,
	((acctstopdate + acctstoptime) - (acctstartdate + acctstarttime)) AS diffe,
	acctterminatecause,
	calledstationid,
	callingstationid,
	framedipaddress	
FROM acct.mk_radacct_rel
WHERE username = '{$username}'
	AND (acctstopdate = current_date
	OR acctstopdate IS NULL)
ORDER BY acctstartdate DESC, acctstarttime DESC";

$result = pg_query($connection, $query) or die(pg_last_error());


if($result) {
        	
echo '<thead>
		  <tr>
		    <th><b><center>Inicio</center></b></td>
		    <th><b><center>Fim</center></b></td>
		    <th><b><center>Duração</center></b></td>
		    <th><b><center>Causa radius</center></b></td>
		    <th><b><center>POP</center></b></td>
		    <th><b><center>MAC</center></b></td>
		    <th><b><center>IP</center></b></td>
		  </tr>
	  </thead>
	  <tbody>';

	while($row = pg_fetch_row($result)) {

		echo '<tr>';
		echo '<td><center>'.$row[0].'</center></td>';
		echo '<td><center>'.$row[1].'</center></td>';
		echo '<td><center>'.$row[2].'</center></td>';
		echo '<td><center>'.$row[3].'</center></td>';
	    echo '<td><center>'.$row[4].'</center></td>';
	    echo '<td><center>'.$row[5].'</center></td>';
	    echo '<td><a href="http://'.$row[6].'" target="_blank"><center>'.$row[6].'</center></a></center></td>';
	    echo '</tr>';

	}

	echo '</tbody>';
}

pg_close($connection) or die(pg_last_error());
?>