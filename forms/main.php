<?php
require_once('../sessao.php');
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <title>Bitcom Auto Forms</title>
        <link rel="icon" href="img/favicon.ico" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
        <meta http-equiv="Content-Type" content="text/html" charset="utf-8">
        <script src="https://cdnjs.cloudflare.com/ajax/libs/vue/2.1.8/vue.js"></script>
        <script src="../libs/jquery-3.4.1.min.js"></script>
        <link href="../libs/bootstrap-4.3.1/css/bootstrap.min.css" rel="stylesheet" />
        <script src="../libs/bootstrap-4.3.1/js/bootstrap.min.js"></script>
        <script src="js/javascript.js"></script>
        
    </head>
    <div class="container-fluid">
        <body class="p-3">
            <div class="row col-md-12">

				<div class="col-md-4" style="background-color:#f2f2f2">
                    <label for="selecao"><small class="text-muted">Selecione uma das opções abaixo:</small></label>
                    <select id="selecao" class="form-control border-info">
                    	<option value="0">Selecione uma opção</option>
                        <option value="1">Cadastrar Interface Juniper (S-Vlan)</option>
                        <option value="2">Cadastrar Interface Juniper (Interface)</option>
                        <option value="3">ONU ZTE</option>
                        <option value="4">OLT Intelbras</option>
                    </select>
                </br>
                </div>
            </div>

            <div class="row col-md-12" id="app">
                <div class="col-md-4" style="background-color:#f2f2f2">
					<div id="formulario">
					</div>
				</div>

				<div class="col-md-1">
				</div>
				<div class="col-md-7">
					<small><div id="resposta">
					</div></small>
				</div>

            </div>

        </body>
        <footer>
            <div class="row fixed-bottom p-2" style="background-color:#f2f2f2">
                <div class="col-md-12 text-right">
                    <small>Noc - dezembro/2020 - v0.99</small>
                </div>
            </div>
        </footer>
    </div>
</html>