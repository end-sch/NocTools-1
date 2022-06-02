<?php
require_once('sessao.php');
?>

<!DOCTYPE html>
<html lang="en">
    <head>
      <title>Bitcom NOC Tools</title>
        <link rel="icon" href="img/favicon.ico" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
        <meta http-equiv="Content-Type" content="text/html" charset="utf-8">
        <script src="libs/jquery-3.4.1.min.js"></script>
        <script src="js/main.js"></script>
        <link href="libs/bootstrap-4.3.1/css/bootstrap.min.css" rel="stylesheet" />
        <script src="libs/bootstrap-4.3.1/js/bootstrap.min.js"></script>
        <script src="libs/fontawesome-5.10.1/js/all.min.js"></script>
    </head>
    <div class="container-fluid">
    <body>
      <div class="row p-1 mb-2 bg-info text-white d-flex align-items-center">
          <div class="col-md-6 text-left"><small><i class="fas fa-user-check"></i><?php echo "  Olá ".$_SESSION['nome']."!   (".$_SESSION['departamento'].")"; ?></small></div>
          <div class="col-md-6 text-right"><button id="sair" class="btn btn-sm btn-outline-light">Sair  <i class="fas fa-user-times"></i></button></div>
      </div>
      <div class="row justify-content-center mt-3">
        <div class="col-md-12">
              <ul class="nav nav-tabs">
                <li class="nav-item"><a href="#manutenções" class="nav-link active" role="tab" data-toggle="tab"><h5>Manutenções</h5></a></li>
                <li class="nav-item"><a href="#quedasPops" class="nav-link" role="tab" data-toggle="tab"><h5>Quedas nos POPs</h5></a></li>
                <li class="nav-item"><a href="#ranking" class="nav-link" role="tab" data-toggle="tab"><h5>Ranking Quedas</h5></a></li>
                <li class="nav-item"><a href="#radius" class="nav-link" role="tab" data-toggle="tab"><h5>Radius</h5></a></li>
                <li class="nav-item"><a href="#pppoe" class="nav-link" role="tab" data-toggle="tab"><h5>PPPoE Analytics</h5></a></li>
                <li class="nav-item"><a href="#config" class="nav-link" role="tab" data-toggle="tab"><h5>Config</h5></a></li>
                <li class="nav-item"><a href="#pppoe-killer" class="nav-link" role="tab" data-toggle="tab"><h5>*PPPoE Killer</h5></a></li>
                <li class="nav-item"><a href="#links" class="nav-link" role="tab" data-toggle="tab"><h5>*Links Úteis</h5></a></li>
                <li class="nav-item"><a href="#forms" class="nav-link" role="tab" data-toggle="tab"><h5>Auto-Forms</h5></a></li>
              </ul>
              <div class="tab-content">
                 <div role="tabpanel" class="tab-pane active" id="manutenções">
                  <div class="embed-responsive embed-responsive-1by1">
                    <iframe id="iframe-manutenções" class="embed-responsive-item" src="manutencoes/manutencoes.php"></iframe>
                  </div>
                </div>
                <div role="tabpanel" class="tab-pane" id="quedasPops">
                  <div class="embed-responsive embed-responsive-1by1">
                    <iframe id="iframe-quedasPops" class="embed-responsive-item" src="quedasPops/quedasPops.html"></iframe>
                  </div>
                </div>
                <div role="tabpanel" class="tab-pane" id="ranking">
                  <div class="embed-responsive embed-responsive-1by1">
                    <iframe id="iframe-ranking" class="embed-responsive-item" src="ranking/ranking.html"></iframe>
                  </div>
                </div>
                <div role="tabpanel" class="tab-pane" id="radius">
                  <div class="embed-responsive embed-responsive-1by1">
                    <iframe class="embed-responsive-item" src="radius/radius.html"></iframe>
                  </div>
                </div>
                <div role="tabpanel" class="tab-pane" id="pppoe">
                  <div class="embed-responsive embed-responsive-1by1">
                    <iframe class="embed-responsive-item" src="bras/main.php"></iframe>
                  </div>
                </div>
                <div role="tabpanel" class="tab-pane" id="config">
                  <div class="embed-responsive embed-responsive-1by1">
                    <iframe class="embed-responsive-item" src="config/main.php"></iframe>
                  </div>
                </div>
                <div role="tabpanel" class="tab-pane" id="pppoe-killer">
                  <div class="embed-responsive embed-responsive-1by1">
                    <iframe class="embed-responsive-item" src="pppoeKiller/pppoe-killer.php"></iframe>
                  </div>
                </div>
                <div role="tabpanel" class="tab-pane" id="links">
                  <div class="embed-responsive embed-responsive-1by1">
                    <iframe id="iframe-links" class="embed-responsive-item" src="links/links.php"></iframe>
                  </div>
                </div>
                <div role="tabpanel" class="tab-pane" id="forms">
                  <div class="embed-responsive embed-responsive-1by1">
                    <iframe id="iframe-links" class="embed-responsive-item" src="forms/main.php"></iframe>
                  </div>
                </div>
              </div>

    </body>
    </div>
</html>