<?php

include ("../libs/db_rd_mk.php");

$query = "SELECT tt.calledstationid, 
  tt.total_clientes,
  t4.total_quedas4,
  t4.clientes_com_queda4,
  proportion4,
  tt.total_quedas,
  tt.proportion_hoje  
FROM (
  (SELECT
    calledstationid,
    COUNT(username) AS total_quedas4,
    COUNT(DISTINCT username) as clientes_com_queda4,
    ROUND(COUNT(username) / COUNT(DISTINCT username)) AS proportion4
  FROM acct.mk_radacct_rel
  WHERE acctstopdate = current_date
    AND acctstoptime > now()::time - interval '4h'
  GROUP BY calledstationid) AS t4
  RIGHT JOIN 
  (SELECT
    calledstationid,
    COUNT(DISTINCT username) AS total_clientes,
    SUM(CASE WHEN acctstopdate = current_date THEN 1 END) AS total_quedas,
    ROUND(SUM(CASE WHEN acctstopdate = current_date THEN 1 END) / COUNT(DISTINCT username)) AS proportion_hoje		
  FROM acct.mk_radacct_rel tt
  WHERE (acctstopdate = current_date OR acctstopdate IS NULL)
  GROUP BY calledstationid
  ) AS tt
  ON t4.calledstationid = tt.calledstationid
  )
ORDER BY t4.proportion4 DESC NULLS LAST";


$result = pg_query($connection, $query) or die(pg_last_error());

if ($result) {

    echo '<thead>
            <tr>
              <th><b><center>Nome do POP</center></b></td>
              <th><b><center>Total de clientes</br>(Online hoje)</center></b></td>
              <th><b><center>Total de Quedas</br>(Últimas 4 horas)</center></b></td>
              <th><b><center>Total de Clientes com Quedas</br>(Últimas 4 horas)</center></b></td>
              <th><b><center>Proporção (4hrs)</br>(Quedas/clientes)</center></b></td>
              <th><b><center>Total de Quedas Hoje</br>(00:00hrs até agora)</center></b></td>
              <th><b><center>Proporção (Hoje)</br>(Quedas/clientes)</center></b></td>
            </tr>
        </thead>
        <tbody>';
	  
  while ($row = pg_fetch_row($result)) {
    echo '<tr pop="'.$row[0].'" count="'.$row[1].'" data-toggle="tooltip" data-placement="top" title="Usuários com quedas:  '.$row[3].'" >';
    echo '<td><a><i class="fas fa-search"></i> '.$row[0].'</a></td>';
    echo '<td><center>'.$row[1].'</center></td>';
    echo '<td><center>'.$row[2].'</center></td>';
		echo '<td><center>'.$row[3].'</center></td>';
    echo '<td><center>'.$row[4].'</center></td>';
    echo '<td><center>'.$row[5].'</center></td>';
    echo '<td><center>'.$row[6].'</center></td>';
    echo '</tr>';
  }

  echo '</tbody>';

}

pg_close($connection) or die(pg_last_error());

?>