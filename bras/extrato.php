<?php
include ("../libs/db_rd_mk.php");

$user = $_POST["user"];

$query = "SELECT
	(r.acctstartdate + r.acctstarttime) AS inicio,
	(r.acctstopdate + r.acctstoptime) AS fim,
	((acctstopdate + acctstoptime) - (acctstartdate + acctstarttime)) AS diffe,
	r.acctterminatecause,
	r.calledstationid,
	n.shortname,
	r.callingstationid,
	r.framedipaddress,
	r.framedipv6prefix,
	r.delegatedipv6prefix,
	r.nasipaddress
FROM acct.mk_radacct_rel r
LEFT JOIN radius.nas n
ON r.nasipaddress=n.nasname
WHERE r.username = '$user'

ORDER BY inicio DESC
LIMIT 10";

$result = pg_query($connection, $query) or die(pg_last_error());


if($result) {

echo '<br />
<font size="2">
<table class="table table-sm table-striped table-hover" width="100%" border="1" cellpadding="1" cellspacing="1">
<caption>Extrato 10 sessões PPPoE mais recentes (se disponíveis)</caption>
		<thead class="thead-dark">
			<tr>
				<th width="10%"><b><center>Inicio</center></b></td>
				<th width="10%"><b><center>Fim</center></b></td>
				<th width="10%"><b><center>Duração</center></b></td>
				<th width="10%"><b><center>Causa radius</center></b></td>
				<th width="10%"><b><center>POP</center></b></td>
				<th width="10%"><b><center>BNG</center></b></td>
				<th width="10%"><b><center>MAC</center></b></td>
				<th width="10%"><b><center>IP</center></b></td>
				<th width="10%"><b><center>IPv6</center></b></td>
				<th width="10%"><b><center>IPv6 Delegado</center></b></td>
			</tr>
		</thead>
		<tbody>';

	while($row = pg_fetch_row($result)) {
		$i++;
		echo '<tr>';
		echo '<td><center>'.$row[0].'</center></td>';
		echo '<td><center>'.$row[1].'</center></td>';
		echo '<td><center>'.$row[2].'</center></td>';
		echo '<td><center>'.$row[3].'</center></td>';
		echo '<td><center>'.$row[4].'</center></td>';
		echo '<td><center>'.$row[5].'</center></td>';
		echo '<td><center>'.$row[6].'</center></td>';
		echo '<td><center>'.$row[7].'</center></td>';
		echo '<td><center>'.$row[8].'</center></td>';
		echo '<td><center>'.$row[9].'</center></td>';
		echo '</tr>';
	}

echo '</tbody>
	</table></font>';
}
pg_close($connection) or die(pg_last_error());
?>