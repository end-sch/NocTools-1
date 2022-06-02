<?php

include ("../libs/db_rd_mk.php");

$query = "SELECT COUNT(*) AS total
FROM acct.mk_radacct_rel
WHERE acctstartdate = current_date";

$result = pg_query($connection, $query) or die(pg_last_error());

if ($result) {

echo '<thead>
		  <tr>
		    <th><b><center>Total</center></b></th>
		  </tr>
	  </thead>
	  <tbody>';

    while($row = pg_fetch_row($result)) {
    	echo '<tr>';
		echo '<td><center>'.$row[0].'</center></td>';
	    echo '</tr>';
    }

    echo '</tbody>';
}

pg_close($connection) or die(pg_last_error());
?>