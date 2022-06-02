<?php
require_once('../sessao.php');
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <title>Bitcom PPPoE Analytics</title>
        <link rel="icon" href="img/favicon.ico" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
        <meta http-equiv="Content-Type" content="text/html" charset="utf-8">
        <script src="../libs/jquery-3.4.1.min.js"></script>
        <link href="../libs/bootstrap-4.3.1/css/bootstrap.min.css" rel="stylesheet" />
        <script src="../libs/bootstrap-4.3.1/js/bootstrap.min.js"></script>
        <script src="js/javascript.js"></script>
        <script type="text/javascript" src="js/chart.js"></script>
    </head>
    <div class="container-fluid">
        <body class="p-3">
            </div>
            <div id="cabecalho" class="row" style="background-color:#f2f2f2">
                <div class="col-md-2">
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                    <label for="comando"><small class="text-muted"><b>*Escolha o comando:</b></small></label>
                    <select size="3" class="form-control custom-select" id="com">
                        <option value="usr">Visualizar sessão por usuário PPPoE</option>'
                        <option value="ip">Visualizar sessão por IP PPPoE</option>'
                        <option value="rota">Visualizar rotas</option>'
                    </select>
                    </div>
                </div>
                <div class="col-md-4">
                    <label><small class="text-muted"><b>*Parametro:</b></small></label><br/>
                    <div class="input-group">
                      <input type="text" class="form-control" placeholder="Digite o Usuario PPPoE, IP, ou Rota" name="parametro" id="parametro">&nbsp
                      <div class="input-group-append">
                        &nbsp<button id="enviar" class="btn btn-primary rounded-left" type="submit">Enviar</button>
                        &nbsp<button id="limpar" class="btn btn-danger" type="reset">Limpar</button>
                      </div>
                    </div>
                </div>
            </div>
            <div class="row" id="explicito"></div>
            <div class="row" id="main"></div>
            <div class="row" id="desc"></div>
        </body>
        <footer>
            <div class="row fixed-bottom p-2" style="background-color:#f2f2f2">
                <div class="col-md-12 text-right">
                    <small>Noc - janeiro/2020 - v1.1</small>
                </div>
            </div>
        </footer>
    </div>
</html>