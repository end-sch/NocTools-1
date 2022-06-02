<?php

require_once('../sessao.php');

?>

<!DOCTYPE html>
<html lang="en">
	<head>
      <title>PPPoE Killer</title>
	    <script type="text/javascript">
	    var sessao="<?php echo $_SESSION['departamento'];?>";
	    </script>
        <link rel="icon" href="img/favicon.ico" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
        <meta http-equiv="Content-Type" content="text/html" charset="utf-8">
        <script src="../libs/jquery-3.4.1.min.js"></script>
        <script src="js/javascript.js"></script>
        <link href="../libs/bootstrap-4.3.1/css/bootstrap.min.css" rel="stylesheet" />
        <script src="../libs/bootstrap-4.3.1/js/bootstrap.min.js"></script>
        <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.5.0/css/all.css" />
	</head>
	<div class="conteiner-fluid mt-2 mb-2 p-2">
		<body>
			<div class="row justify-content-center mb-2">

				<div class="col-md-11 align-self-center d-flex justify-content-end">
                    <button id="btn-relatorio" class="btn btn-success">Gerar relatório plataformas</button>&nbsp
                    <button id="btn-ip" class="btn btn-info">Gerar relatório de IPs</button>
                </div>
						
			</div>

			<div class="row justify-content-around mt-5">

				<div class="col-md-5 align-self-start border border-info"><div id="respostaA" class="mt-3 mb-3"></div></div>
                <div class="col-md-5 align-self-start border border-info"><div id="respostaB" class="mt-3 mb-3"></div></div>
						
			</div>

		</body>
		<footer>
        <div class="row fixed-bottom" style="background-color:#f2f2f2">
                <div class="col-md-6 d-flex justify-content-end">
                    <button id="back-to-top" class="btn-danger"><i class="fas fa-chevron-circle-up"></i></button>
                </div>
                <div class="col-md-6 text-right">
                    <small>Noc - Fevereiro/2020 - v2.1</small>
                </div>
            </div>
        </footer>
	</div>
</html>