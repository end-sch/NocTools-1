window.onload = function() {

 $('#response').show().html('<img src="../img/logo_bitcom.png" class="rounded mx-auto d-block img-fluid max-width: 50% max-height: 50%" alt="logo"/>');
 
// Função Submit

$('#equipamento').on('change', function () {
            var caso = $('option:selected').attr('caso');
            var tipo = $('option:selected').attr('tipo');
            var marca = $('option:selected').attr('marca');
            var ip = $('option:selected').attr('ip');
            var vlan = $('option:selected').attr('vlan');

            var data = 'tipo=' + tipo + '&marca=' + marca + '&ip=' + ip + '&vlan=' + vlan;

            switch (caso) {
              case '1':
              oltHuawei(data);
              break;
              case '2':
              oltZTE(data);
              break;
              case '3':
              olt4840e(data);
              break;
            }
            
        }); 

}

//OLT Huawei

function oltHuawei (data) {
  $('#formulario').show().html(`
  <div class="form-group">
  <br/>
    <label for="comando"><small class="text-muted"><b>*Escolha o comando:</b></small></label>
    <select size="3" class="form-control custom-select" id="comando">
      <option value="mostrar">Mostrar ONUs não provisionadas</option>
      <option value="provisionar">Provisionar novas ONUs</option>
      <option value="remover">Remover ONUs provisionadas</option>
    </select>
  </div>
  <div id="continuar"></div>`);

  $('#comando').on('change', function () {
    var acao = $('#comando').val();

    if (acao === 'mostrar') {
      $('#continuar').show().html("");
      var data1 = data + '&acao=' + acao;
      ajaxOLTHuawei(data1);
       
    } else {

      $('#continuar').show().html(`
        <div>
            <label><small class="text-muted"><b>*Parametro:</b></small></label><br/>
            <div class="input-group">
              <input type="text" class="form-control" placeholder="Digite o Serial Number da ONU." id="parametro">&nbsp
              <div class="input-group-append">
                &nbsp<button id="enviar" class="btn btn-primary rounded-left" type="submit">Enviar</button>
                &nbsp<button id="limpar" class="btn btn-danger" type="reset">Limpar</button>
              </div>
            </div>
            <br/>
        </div>`);


      if (acao === 'provisionar') {

        $('#continuar').prepend(`<label><small class="text-muted"><b>*Modo:</b></small></label><br/>
          <div class="form-check form-check-inline">
          <input class="form-check-input" type="radio" name="modo" value="bridge" checked="yes">
          <label class="form-check-label" for="inlineRadio1">Bridge</label>
        </div>
        <div class="form-check form-check-inline">
          <input class="form-check-input" type="radio" name="modo" value="router">
          <label class="form-check-label" for="inlineRadio2">Router</label>
        </div>
        <div>
          <label><small class="text-muted"><b>Descrição:</b></small></label><br/>
              <div class="input-group">
              <input type="text" class="form-control" value="Digite uma descrição para a ONU." id="desc">
              </div>
        </div>`);

      }


      $('#enviar').click(function () {
        var modo = $("input[name='modo']:checked").val();
        var parametro = $('#parametro').val();
        var desc = $('#desc').val();
        var data1 = data + '&modo=' + modo + '&acao=' + acao + '&parametro=' + parametro + '&desc=' + desc;

        if (parametro === "") {
        	alert("Insira o Serial Number");
        } else {
        	ajaxOLTHuawei(data1);
    	}

      })

      $('#limpar').click(function () {
        limpar();
      })

      }
    })
}

function ajaxOLTHuawei (data) {

$('#response').show().html('');
$('#form').prepend(`<div class="d-flex justify-content-center align-middle" id="loading">
                            <strong>Carregando...</strong>
                            <div class="spinner-border ml-auto" role="status" aria-hidden="true"></div>
                            </div>`);

var last_response_len = false;
resposta = document.getElementById("response");

  $.ajax({
          type: 'POST',
          cache: false,
          url: 'oltHuawei.php',
          data: data,
          xhrFields: {
          onprogress: function(e) {

            var this_response, response = e.currentTarget.response;
              if(last_response_len === false)
              {
                  this_response = response;
                  last_response_len = response.length;
              }
              else
              {
                  this_response = response.substring(last_response_len);
                  last_response_len = response.length;
              }
            resposta.innerHTML += '<small><p class="text-white bg-dark p-3">'+this_response+'</p></small>';
            }
          },
          success: function(response) {
          	$('#loading').remove();
            $('#response').show().html('<small><p class="text-white bg-dark p-3">'+response+'</p></small>');
          }
        })
}

//OLT ZTE
function oltZTE (data) {
  $('#formulario').show().html(`
  <div class="form-group">
  <br/>
    <label for="comando"><small class="text-muted"><b>*Escolha o comando:</b></small></label>
    <select size="4" class="form-control custom-select" id="comando">
      <option value="mostrar">Mostrar ONUs não provisionadas</option>
      <option value="provisionar">Provisionar novas ONUs</option>
      <option value="remover">Remover ONUs provisionadas</option>
      <option value="migracao">Migrar ONU de PON na mesma OLT</option>
    </select>
  </div>
  <div id="continuar"></div>`);

  $('#comando').on('change', function () {
    var acao = $('#comando').val();

    if (acao === 'mostrar') {
      $('#continuar').show().html("");
      var data1 = data + '&acao=' + acao;
      ajaxOLTZTE(data1);
       
    } else {

      $('#continuar').show().html(`
        <div>
            <label><small class="text-muted"><b>*Parametro:</b></small></label><br/>
            <div class="input-group">
              <input type="text" class="form-control" placeholder="Digite o Serial Number da ONU." id="parametro">&nbsp
              <div class="input-group-append">
                &nbsp<button id="enviar" class="btn btn-primary rounded-left" type="submit">Enviar</button>
                &nbsp<button id="limpar" class="btn btn-danger" type="reset">Limpar</button>
              </div>
            </div>
            <br/>
        </div>`);


      if (acao === 'provisionar') {

        $('#continuar').prepend(`<label><small class="text-muted"><b>*Modo:</b></small></label><br/>
          <div class="form-check form-check-inline">
          <input class="form-check-input" type="radio" name="modo" value="bridge" checked="yes">
          <label class="form-check-label" for="inlineRadio1">Bridge</label>
        </div>
        <div class="form-check form-check-inline">
          <input class="form-check-input" type="radio" name="modo" value="router">
          <label class="form-check-label" for="inlineRadio2">Router</label>
        </div>
        <div>
          <label><small class="text-muted"><b>Descrição:</b></small></label><br/>
              <div class="input-group">
              <input type="text" class="form-control" value="Digite uma descrição para a ONU." id="desc">
              </div>
        </div>`);

      }

      else if (acao === 'migracao') {

        $('#continuar').prepend(`<label><small class="text-muted"><b>*Modo:</b></small></label><br/>
          <div class="form-check form-check-inline">
          <input class="form-check-input" type="radio" name="modo" value="bridge" checked="yes">
          <label class="form-check-label" for="inlineRadio1">Bridge</label>
        </div>
        <div class="form-check form-check-inline">
          <input class="form-check-input" type="radio" name="modo" value="router">
          <label class="form-check-label" for="inlineRadio2">Router</label>
        </div>`);

      }


      $('#enviar').click(function () {
        var modo = $("input[name='modo']:checked").val();
        var parametro = $('#parametro').val();
        var desc = $('#desc').val();
        var data1 = data + '&modo=' + modo + '&acao=' + acao + '&parametro=' + parametro + '&desc=' + desc;

        if (parametro === "") {
          alert("Insira o Serial Number");
        } else {
          ajaxOLTZTE(data1);
      }

      })

      $('#limpar').click(function () {
        limpar();
      })

      }
    })
}

function ajaxOLTZTE (data) {

$('#response').show().html('');
$('#form').prepend(`<div class="d-flex justify-content-center align-middle" id="loading">
                            <strong>Carregando...</strong>
                            <div class="spinner-border ml-auto" role="status" aria-hidden="true"></div>
                            </div>`);

var last_response_len = false;
resposta = document.getElementById("response");

  $.ajax({
          type: 'POST',
          cache: false,
          url: 'oltZTE.php',
          data: data,
          xhrFields: {
          onprogress: function(e) {

            var this_response, response = e.currentTarget.response;
              if(last_response_len === false)
              {
                  this_response = response;
                  last_response_len = response.length;
              }
              else
              {
                  this_response = response.substring(last_response_len);
                  last_response_len = response.length;
              }
            resposta.innerHTML += '<small><p class="text-white bg-dark p-3">'+this_response+'</p></small>';
            }
          },
          success: function(response) {
            $('#loading').remove();
            $('#response').show().html('<small><p class="text-white bg-dark p-3">'+response+'</p></small>');
          }
        })
}


//OLT 4840E
function olt4840e (data) {
  $('#formulario').show().html(`
  <div class="form-group">
  <br/>
    <label for="comando"><small class="text-muted"><b>*Escolha o comando:</b></small></label>
    <select size="4" class="form-control custom-select" id="comando">
      <option value="remover">Agrupar, listar e remover ONUs</option>
    </select>
  </div>
  <div id="continuar"></div>`);

  $('#comando').on('change', function () {
    var acao = $('#comando').val();

    if (acao === 'mostrar') {
      $('#continuar').show().html("");
      var data1 = data + '&acao=' + acao;
      ajaxOLTZTE(data1);
       
    } else {

      $('#continuar').show().html(`
        <div>
            <label><small class="text-muted"><b>*Parametro:</b></small></label><br/>
            <div class="input-group">
              <input type="text" class="form-control" placeholder="Digite o IP da OLT" id="parametro">&nbsp
              <div class="input-group-append">
                &nbsp<button id="enviar" class="btn btn-primary rounded-left" type="submit">Enviar</button>
                &nbsp<button id="limpar" class="btn btn-danger" type="reset">Limpar</button>
              </div>
            </div>
            <br/>
        </div>`);


      $('#enviar').click(function () {
        var parametro = $('#parametro').val();
        var data1 = data + '&parametro=' + parametro;

        if (parametro === "") {
          alert("Digite o IP da OLT");
        } else {
          ajaxOLT4840E(data1);
      }

      })

      $('#limpar').click(function () {
        limpar();
      })

      }
    })
}

function ajaxOLT4840E (data) {

$('#response').show().html('');
$('#form').prepend(`<div class="d-flex justify-content-center align-middle" id="loading">
                            <strong>Carregando...</strong>
                            <div class="spinner-border ml-auto" role="status" aria-hidden="true"></div>
                            </div>`);

var last_response_len = false;
resposta = document.getElementById("response");

  $.ajax({
          type: 'POST',
          cache: false,
          url: '../cgi-bin/olt-4840e.py',
          data: data,
          xhrFields: {
          onprogress: function(e) {

            var this_response, response = e.currentTarget.response;
              if(last_response_len === false)
              {
                  this_response = response;
                  last_response_len = response.length;
              }
              else
              {
                  this_response = response.substring(last_response_len);
                  last_response_len = response.length;
              }
            resposta.innerHTML += '<small><p class="text-white bg-dark p-3">'+this_response+'</p></small>';
            }
          },
          success: function(response) {
            $('#loading').remove();
            $('#response').show().html('<small><p class="text-white bg-dark p-3">'+response+'</p></small>');
          }
        })
}


//Funcão limpar
function limpar() {
  setTimeout(function() {
    window.location.reload(true);
  }, 300);
};