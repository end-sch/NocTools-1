<?php

include ("../libs/db_rbx.php");

$query = mysqli_query($conn_rbx, "SELECT reply, COUNT(*) AS total  from radpostauth WHERE authdate >= DATE_SUB(NOW(), INTERVAL 5 minute) GROUP BY reply") or die(mysqli_error($conn_rbx));

if ($query->num_rows > 0) {
    $rows = $query->fetch_all(MYSQLI_ASSOC);

    echo json_encode($rows);
} else {
    echo "no results found";
}

mysqli_close($conn_rbx) or die(mysqli_error($conn_rbx));
?>