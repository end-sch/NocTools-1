<?php

require_once('../sessao.php');

?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <title>Bitcom Manutenções</title>
        <link rel="icon" href="../img/favicon.ico" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
        <meta http-equiv="Content-Type" content="text/html" charset="utf-8">
        <script src="../libs/jquery-3.4.1.min.js"></script>
        <link href="../libs/bootstrap-4.3.1/css/bootstrap.min.manut.css" rel="stylesheet" />
        <script src="../libs/bootstrap-4.3.1/js/bootstrap.min.js"></script>
        <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.5.0/css/all.css" />
        <script src="js/javascript.js"></script>
    </head>

    <div class="container-fluid mt-2 mb-2">

            <!-- Modal Notificacao-->
            <div class="modal fade" id="notificacao" tabindex="-1" role="dialog">
              <div class="modal-dialog" role="document">
                <div class="modal-content">
                  <div class="modal-body">
                    <div id="info" class="col-md-12"></div>
                  </div>
                </div>
              </div>
            </div>
            <!-- Fim do Modal -->

        <body id="bd">
            <div class="row justify-content-center sticky-top">
                <div class="col-md-12">
                    <div class="card" style="background-color:#f2f2f2">


                        <div id="formulario" sessao="<?php echo $_SESSION['nome'].' - '.$_SESSION['departamento'].'.';?>" class="row justify-content-center d-none d-print-block text-center">

                           <form>
                                <div class="form-row">
                                <div class="form-group col-md-6">
                                    <label for="cidade"><small class="text-muted">Cidade (Obrigatório)</small></label>
                                    <input type="text" id="cidade" class="form-control border-info"/>
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="pop"><small class="text-muted">POP (Obrigatório)</small></label>
                                    <input type="text" id="pop" class="form-control border-info"/>
                                </div>

                                </div>

                                <div class="form-row">
                                  <div class="form-group col-md-4"><label for="horainicio"><small class="text-muted">Data Inicial</small></label><input id="horainicio" type="datetime-local" disabled class="form-control bg-danger border-info"></div>
                                  <div class="form-group col-md-4"><label for="previsao"><small class="text-muted">Previsão de conclusão</small></label><input id="previsao" type="datetime-local" class="form-control border-info"/></div>
                                  <div class="form-group col-md-4"><label for="horafim"><small class="text-muted">Conclusão</small></label><input id="horafim" type="datetime-local" class="form-control border-info"/></div>
                                </div>
                                
                                <div class="form-row">
                                    <div class="form-group col-md-4"><label for="tecnico"><small class="text-muted">Técnico/Setor</small></label><input id="tecnico" type="text" class="form-control border-info"/></div>
                                    <div class="form-group col-md-4"><label for="at"><small class="text-muted">Nº do Atendimento</small></label><input id="at" type="text" class="form-control border-info"/></div>

                                    <div class="form-group col-md-4">
                                        <label for="status"><small class="text-muted">Status</small></label>
                                        <select id="status" class="form-control border-info">
                                            <option value="Acionar Técnico">Acionar Técnico</option>
                                            <option value="Em Andamento">Em Andamento</option>
                                            <option value="Em Manutenção">Em Manutenção</option>
                                            <option value="Manutenção Programada">Manutenção Programada</option>
                                            <option value="Online">Online</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="form-row">
                                    <div class="form-group col-md-12"><label for="obs"><small class="text-muted">Observações</small></label><textarea id="obs" data-auto-size="true" class="form-control border-info"></textarea></div>
                                </div>

                                <div class="form-row">
                                  <div><input id="rowId" type="hidden" class="form-control"/></div>
                                  <div><input id="log" type="hidden" class="form-control"/></div>
                                  <div class="form-group col-md-12 d-flex flex-row-reverse"><button id="btnCancelar" class="btn btn-danger"><i class="fas fa-times-circle"></i>  Cancelar</button>&nbsp<button id="btnSalvar" class="btn btn-success"><i class="fas fa-save"></i>  Salvar</button></div>
                                </div>
                            </form>

                        </div>

                        <div id="cabecalho" class="p-2 row justify-content-center d-none d-print-block">
                            <div class="col-md-12"><br></div>

                            <div class="col-md-6 input-group form-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text"><i class="fas fa-search"></i></span>
                                </div>
                                <input id="search" type="search" name="login" class="form-control" placeholder="Procurar...">
                            </div>

                            <div class="col-md-6">
                                <div class="d-flex justify-content-end">
                                	<div><button id="btnAdicionar" class="btn btn-success"><i class='fas fa-save'></i>  Novo</button>&nbsp</div>
                                    <div id="botoes"></div>
                                </div>
                            </div>
                        </div>

                        <div id="falseTh" class="row justify-content-center">
                            <div class="col-md-12">
                                <table id="ref" class="table table-sm table-bordered">
                                    <thead class="thead-dark text-center">
                                        <tr class="d-flex">
                                            <th class="col-2">POP</th>
                                            <th class="col-1">Abertura</th>
                                            <th class="col-1">Previsão</th>
                                            <th class="col-1">Conclusão</th>
                                            <th class="col-1">Cidade</th>
                                            <th class="col-1">Técnico</th>
                                            <th class="col-1">AT</th>
                                            <th class="col-1">Status</th>
                                            <th class="col-3">Observação</th>
                                        </tr>
                                    </thead>
                                </table>
                            </div>
                        </div>


                    </div>
                </div>
            </div>
            <div id="tabela" class="row justify-content-center">
                <div class="col-md-12 table-responsive">
                	<font size="2">
				    <table id="tblManut" class="table table-sm table-hover">

                        <thead id="trueTh" class="thead-dark text-center">
                            <tr class="d-flex">
                                <th class="col-2">POP</th>
                                <th class="col-1">Abertura</th>
                                <th class="col-1">Previsão</th>
                                <th class="col-1">Conclusão</th>
                                <th class="col-1">Cidade</th>
                                <th class="col-1">Técnico</th>
                                <th class="col-1">AT</th>
                                <th class="col-1">Status</th>
                                <th class="col-3">Observação</th>
                            </tr>
                        </thead>

				        <tbody id="bodyManut">
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
                    <small>Noc - janeiro/2020 - v3.1</small>
                </div>
            </div>
        </footer>
    </div>
</html>