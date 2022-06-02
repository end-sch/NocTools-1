<?php

include ("../libs/db_rd_mk.php");

$query = "SELECT username,
COUNT(username) AS total 
FROM radius.radacct 
WHERE acctstoptime is NULL 
GROUP BY username 
HAVING COUNT(username) > 1";

$result = pg_query($connection, $query) or die(pg_last_error());

if ($result) {

echo '<thead>
		  <tr>
		    <th><b><center>Usuário</center></b></th>
		    <th><b><center>Total</center></b></th>
		  </tr>
	  </thead>
	  <tbody>';

    while($row = pg_fetch_row($result)) {
    	echo '<tr>';
		echo '<td><center>'.$row[0].'</center></td>';
		echo '<td><center>'.$row[1].'</center></td>';
	    echo '</tr>';
    }

    echo '</tbody>';
}

pg_close($connection) or die(pg_last_error());
?>