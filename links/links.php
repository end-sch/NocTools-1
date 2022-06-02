<?php

require_once('../sessao.php');

?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <title>Bitcom NOC Links</title>
        <script type="text/javascript">
        var sessao="<?php echo $_SESSION['departamento'];?>";
        </script>
        <link rel="icon" href="../img/favicon.ico" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
        <meta http-equiv="Content-Type" content="text/html" charset="utf-8">
        <script src="../libs/jquery-3.4.1.min.js"></script>
        <link href="../libs/bootstrap-4.3.1/css/bootstrap.min.css" rel="stylesheet" />
        <script src="../libs/bootstrap-4.3.1/js/bootstrap.min.js"></script>
        <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.5.0/css/all.css" />
        <script src="js/javascript.js"></script>
    </head>

    <div class="container-fluid">
        <body>
            <div class="row justify-content-center" style="background-color:#f2f2f2">
                <div class="col-md-12"><br></div>

                <div class="col-md-6 input-group form-group">
                    <div class="input-group-prepend">
                        <span class="input-group-text"><i class="fas fa-search"></i></span>
                    </div>
                    <input id="search" type="search" name="login" class="form-control" placeholder="Procurar...">
                </div>

                <div class="col-md-6">
                	<button id="btnAdicionar" class="btn btn-success float-right">Novo link</button>
                </div>

            </div>
            <div class="row justify-content-center">
                <div id="info" class="col-md-12"></div>
            </div>
            <div class="row justify-content-center">
                <div class="col-md-12">
                	<font size="2">
					    <table id="tblCadastro" class="table table-hover table-sm">
					        <thead class="thead-dark">
					            <tr>
					                <th><center>Acesso</center></th>
					                <th><center>URL</center></th>
					                <th><center>Usuário</center></th>
					                <th><center>Senha</center></th>
					                <th><center>Observação</center></th>
					                <th><center></center></th>
					            </tr>
					        </thead>
					        <tbody id="tbl-corpo">
					        </tbody>
					    </table>
					</font>
                </div>
            </div>
        </body>
		<footer>
	        <div class="row fixed-bottom" style="background-color:#f2f2f2">
                <div class="col-md-6 d-flex justify-content-end">
                    <button id="back-to-top" class="btn-danger"><i class="fas fa-chevron-circle-up"></i></button>
                </div>
                <div class="col-md-6 text-right">
                    <small>Noc - janeiro/2020 - v1.0</small>
                </div>
            </div>
        </footer>
    </div>
</html>