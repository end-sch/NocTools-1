window.onload = function() {

 $('#explicito').show().html('<img src="../img/logo_bitcom.png" class="rounded mx-auto d-block img-fluid max-width: 50% max-height: 50%" alt="logo"/>');
 
//Funcão limpar
$('#limpar').click(function() {
  setTimeout(function() {
    window.location.reload(true);
  }, 300);
});

// Função Submit
  $('#enviar').click(function () {
      var comando = $('#com').val();
      var parametro = $('#parametro').val();

      $('#desc').show().html("");

        if ( comando === "" || parametro === "") {
          $('#explicito').show().html('<div class="col-md-12"><h1 class="alert alert-danger text-center">Preencha os campos obrigatórios</h1></div>');
          setTimeout(function() {
              window.location.reload(true);
            }, 1500);
              
        } else {
          $('#explicito').slideUp(explicito);
          $('#cabecalho').fadeOut();
          $('#main').show().html('<div class="d-flex justify-content-center">'+
                                   '<strong>Carregando...</strong>'+
                                    '<div class="spinner-border ml-auto" role="status" aria-hidden="true"></div>'+
                                  '</div>');

          //Função SSH JunOS
          var data = 'comando=' + comando + '&parametro=' + parametro;
          $.ajax({
            type: 'POST',
            cache: false,
            dataType: 'JSON',
            url: 'exec.php',
            data: data,
            success: function(response) {
              $('#comando').show().html('<p class="text-white bg-dark"><b>Comando: </b>'+response.send+'</p>');
              $('#total').show().html('<p class="text-white bg-dark"><b>Total BNG-A: </b>'+response.total_a+'; <b>Total BNG-B: </b>'+response.total_b+'; <b>Total: </b>'+response.total+'</p>');
              if (response.pp0.length > 0) {

                $('#main').show().html(
                  '<div id=output class="col-md-6"><h5>Output '+response.bng+':</h5><p class="text-white bg-dark p-2"><small>'+response.output+'</small></p></div>'+
                  '<div class="col-md-6">'+
                    '<ul class="nav nav-tabs">'+
                        '<li class="nav-item"><a href="#extrato" class="nav-link active" role="tab" data-toggle="tab"><h5>Extrato</h5></a></li>'+
                        '<li class="nav-item"><a href="#grafico" class="nav-link" role="tab" data-toggle="tab"><h5>Gráfico</h5></a></li>'+
                    '</ul>'+
                    '<div class="tab-content">'+
                    '<div role="tabpanel" class="tab-pane active" id="extrato"></div>'+
                    '<div role="tabpanel" class="tab-pane" id="grafico">'+
                          '<div class="d-flex justify-content-center"><canvas id="canvas" height="400" width="700"></canvas></div>'+
                          '<div id="progress">'+
                          '<div class="d-flex justify-content-center"><input id="btn-grafico" bng="'+response.bng+'" iface="'+response.pp0+'" type="submit" value="Gerar Gráfico de utilização" class="btn btn-primary" onclick="grafico();"/></div>'+
                          '</div>'+
                    '</div>'+
                    '</div>'
                  );

                $('#desc').show().html(
                  '<div class="col-md-6 d-flex justify-content-end"><input id="btn-discnt" bng="'+response.bng+'" iface="'+response.pp0+'" type="submit" value="Desconectar este usuário" class="btn btn-danger" onclick="desconectar();"/></div>'
                  );

                //Função Extrato do Radius
                    $.ajax({
                    type: 'POST',
                    cache: false,
                    dataType: 'text',
                    url: 'extrato.php',
                    data: 'user=' + response.user,
                    success: function(response) {
                      $('#extrato').show().html(response);
                      }
                    });

          //Fim função SSH JunOS 
             } else {
              $('#main').show().html('<div class="col-md-12"><h5>Output '+response.bng+':</h5><p class="text-white bg-dark p-2"><small>'+response.output+'</small></div>');
             }
            }
           });
      return false;
      }

  });
//Fim função Submit

};

//Função desconectar
function desconectar() {
  var pp0 = $('#btn-grafico').attr('iface');
  var bng = $('#btn-grafico').attr('bng');
  var data = 'pp0=' + pp0 + '&bng=' + bng;
  $.ajax({
    type: 'POST',
    cache: false,
    url: 'desconectar.php',
    data: data,
    success: function(response) {
    $('#explicito').show().html('<div class="col-md-12"><h1 class="alert alert-danger text-center">Usuário desconectado!</h1></div>');
    $('#main').show().html("");
    $('#desc').show().html("");
    setTimeout(
  function() 
  {
    window.location.reload(true);
  }, 2000);
    
    }
  });
}

//Função Gráfico
function grafico(){

  var last_response_len = false;
  var up = [];
  var down = [];
  var x = [];
  var pp0 = $('#btn-grafico').attr('iface');
  var bng = $('#btn-grafico').attr('bng');
  var data = 'pp0=' + pp0 + '&bng=' + bng;
  $.ajax({
    type: 'POST',
    dataType: 'text',
    url: 'grafico.php',
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
        this_response = JSON.parse(this_response);
        var prog = (this_response.x * 2);
        $('#progress').show().html('<div class="progress-bar progress-bar-striped progress-bar-animated d-flex justify-content-start"" role="progressbar" style="width: '+prog+'%;" aria-valuenow="'+prog+'" aria-valuemin="0" aria-valuemax="100">'+prog+'%</div>');
        if (this_response.x > 7) {
          up.shift();
          down.shift();
          x.shift();
          };
        up.push(this_response.up);
        down.push(this_response.down);
        x.push(this_response.x);

//Canvas

var data = {
    "xName": "Tempo",
    "yName": "Bandwidth",
    "cols": x,
    "data": [{ "name": "Upload ("+this_response.up+" Mbps)", "values": up },
             { "name": "Download ("+this_response.down+" Mbps)", "values": down }]
};

var canvas = document.getElementById("canvas");
const context = canvas.getContext('2d');
context.clearRect(0, 0, canvas.width, canvas.height);
chartify(canvas, data);

var settings = {
    "backgroundColor": "", 
    "chartColor": "",
    "chartLinesColor": "",
    "textColor": ""
};

//Fim do Canvas

      }
    },
    success: function(text) {
      $('#progress').show().html('<div class="d-flex justify-content-center"><h5>Fim da coleta!</h5></div>'+
        '<div class="d-flex justify-content-center"><input id="btn-grafico" bng="'+bng+'" iface="'+pp0+'" type="submit" value="Recarregar Gráfico" class="btn btn-primary" onclick="grafico();"/></div>');
      }
  });
          
}

function explicito() {
  $('#explicito').show().html(
    '<div id="comando" class="col-md-6"></div>'+
    '<div id="total" class="col-md-3"></div>' +
    '<div class="col-md-3 d-flex justify-content-end"><button id="nova" class="btn btn-success" type="reset">Nova Pesquisa</button></div>');
    $('#nova').click(function() {
      window.location.reload(true);
    });
}