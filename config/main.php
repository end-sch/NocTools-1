<?php
require_once('../sessao.php');
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <title>Bitcom OLT Management</title>
        <link rel="icon" href="img/favicon.ico" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
        <meta http-equiv="Content-Type" content="text/html" charset="utf-8">
        <script src="../libs/jquery-3.4.1.min.js"></script>
        <link href="../libs/bootstrap-4.3.1/css/bootstrap.min.css" rel="stylesheet" />
        <script src="../libs/bootstrap-4.3.1/js/bootstrap.min.js"></script>
        <script src="js/javascript.js"></script>
    </head>
    <div class="container-fluid">
        <body class="p-3">
            <div class="row col-md-12">

                <div class="col-md-6 form-group" style="background-color:#f2f2f2" id="form">
                    <label for="equip"><small class="text-muted"><b>*Escolha o equipamento:</b></small></label>
                    <!--
                        Caso 1 = OLT Huawei
                        Caso 2 = OLT ZTE
                        Caso 3 = OLT Intelbras 4840E
                    -->
                    <select size="5" class="form-control custom-select" id="equipamento">
                        <option caso="2" tipo="olt" marca="zte" ip="192.168.120.152" vlan="99">OLT ZTE Bitcom - 192.168.120.152</option>'
                        <option caso="2" tipo="olt" marca="zte" ip="192.168.156.56" vlan="3486">OLT ZTE Golden - 192.168.156.56</option>'
                        <option caso="2" tipo="olt" marca="zte" ip="192.168.110.130" vlan="2532">OLT ZTE Netsky - 192.168.110.130</option>'
                        <option caso="1" tipo="olt" marca="huawei" ip="192.168.206.34" vlan="3484">OLT Huawei Inove - 192.168.206.34</option>'
                        <option caso="3" tipo="olt" marca="4840e" ip="192.168.1.1" vlan="3484">OLT Intelbras 4840e</option>'
                    </select>
                    <div id="formulario">
                	</div>
                </div>
            	
                <div class="col-md-6">
                    <div id=response>
                    </div>
                </div>

            </div>
        </body>
        <footer>
            <div class="row fixed-bottom p-2" style="background-color:#f2f2f2">
                <div class="col-md-12 text-right">
                    <small>Noc - setembro/2021 - v1.3</small>
                </div>
            </div>
        </footer>
    </div>
</html>