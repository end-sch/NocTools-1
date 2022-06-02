<?php

include ("../libs/db_rd_mk.php");

$query = "SELECT string_agg(DISTINCT username, ', ') AS username, 
	mac,
	called_station,
COUNT(*) AS total 
FROM radius.radpostauth
WHERE authdate >= (now() - interval '30m')
	AND reply = 'Access-Reject'
GROUP BY mac, called_station
HAVING COUNT(*) > 1
ORDER BY total DESC";

$result = pg_query($connection, $query) or die(pg_last_error());

if ($result) {

echo '<thead>
		  <tr>
		    <th><b><center>Usuários</center></b></th>
		    <th><b><center>MAC</center></b></th>
		    <th><b><center>POP</center></b></th>
		    <th><b><center>Total</center></b></th>
		  </tr>
	  </thead>
	  <tbody>';

    while($row = pg_fetch_row($result)) {
    	echo '<tr>';
		echo '<td><center>'.$row[0].'</center></td>';
		echo '<td><center>'.$row[1].'</center></td>';
		echo '<td><center>'.$row[2].'</center></td>';
		echo '<td><center>'.$row[3].'</center></td>';
	    echo '</tr>';
    }

    echo '</tbody>';
}

pg_close($connection) or die(pg_last_error());
?>