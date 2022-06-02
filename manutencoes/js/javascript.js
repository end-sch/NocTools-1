    var info;
    var iClass;
    var timer;

window.onload = function() {

  if (detectmob() == false) { //desktop
    $('#trueTh').css("display","none");
  } else { //mobile
    $('#falseTh').css("display","none");
    $('#tblManut').css("width","1200px");
  }
  
  loadTable();
  Esconde();

//top
$('#back-to-top').fadeOut();

$(window).scroll(function () {
      if ($(this).scrollTop() > 50) {
        $('#back-to-top').fadeIn();
      } else {
        $('#back-to-top').fadeOut();
      }
    });
    // scroll body to 0px on click
    $('#back-to-top').click(function () {
      $('body,html').animate({
        scrollTop: 0
      }, 400);
      return false;
    });

//fecha top


  $(window).on("click", function () {
    $('#cabecalho').removeClass('d-none d-print-block');
    clearTimeout(timer);
    Esconde();
  });

  $("#bodyManut").on("click", 'td', function () {
    $("#bodyManut").find('.change').removeClass('table-dark change');
    var linha = $(this).parent();
    linha.addClass('table-dark change');
    var rowId = $(this).parent().attr('id');
    var rowLog = $(this).parent().attr('log');

    $("#botoes").show().html('<button id="btnEditar" class="btn btn-info"><i class="fas fa-edit"></i>  Editar</button>&nbsp<button id="btnExcluir" class="btn btn-danger"><i class="fas fa-trash-alt"></i>  Excluir</button>&nbsp<button id="btnLog" class="btn btn-secondary"><i class="fas fa-info-circle"></i>  Log</button>');
      $("#btnEditar").on("click", function() {
          linha.each(function () {
            var id = rowId;
            var log = rowLog;
            var pop = $(this).find("td").eq(0).text();
            var horainicio = $(this).find("td").eq(1).text();
            var previsao = $(this).find("td").eq(2).text();
            var horafim = $(this).find("td").eq(3).text();
            var cidade = $(this).find("td").eq(4).text();
            var tecnico = $(this).find("td").eq(5).text();
            var at = $(this).find("td").eq(6).text();
            var status = $(this).find("td").eq(7).text();
            var obs = $(this).find("td").eq(8).text();

            Formulario(id, pop, horainicio, previsao, horafim, cidade, tecnico, at, status, obs, log);
            });

        });
      $("#btnExcluir").on("click", function() {
          Excluir(rowId);
        });
      $("#btnLog").on("click", function() {
          Log(rowId);
        });
  });

  $("#btnAdicionar").on("click", function() {
    Formulario();
  });

$("#search").on("keyup", function() {
  var value = this.value.toLowerCase().trim();
  $("#bodyManut tr").css("display", function() {
            return this.innerText.toLowerCase().indexOf(value) > -1 ? "":"none"
        });
});

}

function Formulario(id, pop, horainicio, previsao, horafim, cidade, tecnico, at, status, obs, log) {


if (horainicio == null) {

$.ajax({
    type: "POST",
    url:'now.php',
    dataType: "html",
    success: function(response){
      $('#horainicio').val(response);
      $('#previsao').val('0001-01-01T00:00');
      $('#horafim').val('0001-01-01T00:00');
      $('#status').val("Acionar Técnico");
      }
  });

} else {

  var i = horainicio;
  var horainicio = i.split(' ')[0].split('-')[2]+"-"+i.split(' ')[0].split('-')[1]+"-"+i.split(' ')[0].split('-')[0]+"T"+i.split(' ')[1];

  var p = previsao;
  if (p == "") {
    var previsao = '0001-01-01T00:00';
  } else {
    var previsao = p.split(' ')[0].split('-')[2]+"-"+p.split(' ')[0].split('-')[1]+"-"+p.split(' ')[0].split('-')[0]+"T"+p.split(' ')[1];
  }

  var c = horafim;
  if (c == "") {
    var horafim = '0001-01-01T00:00';
  } else {
    var horafim = c.split(' ')[0].split('-')[2]+"-"+c.split(' ')[0].split('-')[1]+"-"+c.split(' ')[0].split('-')[0]+"T"+c.split(' ')[1];
  }
}

  
  $('#rowId').val(id);
  $('#pop').val(pop);
  $('#horainicio').val(horainicio);
  $('#previsao').val(previsao);
  $('#horafim').val(horafim);
  $('#cidade').val(cidade);
  $('#tecnico').val(tecnico);
  $('#at').val(at);
  $('#status').val(status);
  $('#obs').val(obs);
  $('#log').val(log);

  $("#btnCancelar").on("click", loadTable);
  $("#btnSalvar").on("click", function () {
    Salvar();
    return false;
  });

  $('#formulario').removeClass('d-none d-print-block');
  $('#cabecalho').show().html("");

      if (detectmob() == true) { //é mobile

        $('#tabela').addClass('d-none d-print-block');
        $('footer').css("display","none");

      }

}

function Salvar() {

	var timestamp = new Date();
	var sessao = $('#formulario').attr('sessao');
	var id = $('#rowId').val();
	var log = $('#log').val();
	var pop = $('#pop').val();
	var horainicio = $('#horainicio').val();
	var previsao = $('#previsao').val();
	var horafim = $('#horafim').val();
	var cidade = $('#cidade').val();
	var tecnico = $('#tecnico').val();
	var at = $('#at').val();
	var status = $('#status').val();
	var obs = $('#obs').val();

  if (id == "") {

  if ( pop.length == 0 || cidade.length == 0) {
    $('#pop').removeClass('border-info').addClass('is-invalid');
    $('#cidade').removeClass('border-info').addClass('is-invalid');
          info = 'Você deve informar os campos obrigatórios.';
          iClass = 'bg-danger';
          Notificacao(info, iClass);
              
        } else {

        var log = '<b>Abertura: </b>'+ timestamp + '<br><b>Usuário: </b>' + sessao;
        var data = 'pop=' + pop + '&horainicio=' + horainicio + '&previsao=' + previsao + '&horafim=' + horafim + '&cidade=' + cidade + '&tecnico=' + tecnico + '&at=' + at + '&status=' + status + '&obs=' + obs + '&log=' + log;

        $.ajax({
                   type: 'POST',
                   cache: false,
                   url: 'insert.php',
                   async: true,
                   data: data,
                   success: function(response) {

                      if ($.trim(response) == 'Inserted') {
                       info = 'Situação inserida.';
                       iClass = 'alert alert-success';
                     }

                      if ($.trim(response) == 'Error') {
                       info = 'Erro ao inserir nova situação. Tente novamente mais tarde.';
                       iClass = 'alert alert-danger';
                     }

                     Notificacao(info, iClass);
                     ReloadPage();
                   }
              });
        }

  } else {
  	var novo = '<b>Cidade: </b>'+ cidade + '<br><b>POP: </b>' + pop + '<br><b>Previsão: </b>'+ previsao + '<br><b>Conclusão: </b>'+ horafim + '<br><b>Técnico: </b>'+ tecnico + '<br><b>AT: </b>'+ at + '<br><b>Status: </b>'+ status + '<br><b>Obs: </b>'+ obs;
  	var log = log + '<hr width = 100%><b>Update: </b>'+ timestamp + '<br><b>Usuário: </b>' + sessao + '<br>' + novo;
      var data = 'id=' + id + '&pop=' + pop + '&previsao='+ previsao + '&horafim='+ horafim + '&cidade='+ cidade + '&tecnico='+ tecnico + '&at='+ at + '&status='+ status + '&obs='+ obs + '&log='+ log ;

      $.ajax({
          type: 'POST',
          url: 'update.php',
          data: data,
          success: function(response) {

             if($.trim(response) == 'Empty') {
               info = 'Os campos são obrigatórios';
               iClass = 'alert alert-danger';
             }

             if($.trim(response) == 'Error') {
               info = 'Algo deu errado durante o update. Tente novamente mais tarde.';
               iClass = 'alert alert-danger';
             }

             if($.trim(response) == 'NoChanges') {
               info = 'Você não fez nenhuma alteração';
               iClass = 'alert alert-info';
             }


             if($.trim(response) == 'Updated') {
              loadTable();
               info = 'As informações foram atualizadas.';
               iClass = 'alert alert-success';

             }
          Notificacao(info, iClass);
          ReloadPage();
          }
        });

  }
}

function Excluir(id) {
$.ajax({
   type: 'POST',
   data: "id="+ id,
   url: 'delete.php',
   success: function(response) {
     if ($.trim(response) == 'Deleted') {
      info = 'A linha foi excluída.';
      iClass = 'alert alert-success';
     }

     if ($.trim(response) == 'Error') {
       info = 'Algo deu errado na exclusão. Tente mais tarde novamente.';
       iClass = 'alert alert-danger';
     }
   Notificacao(info, iClass);
   }
  });
}

function Log(id) {
$.ajax({
   type: 'POST',
   data: "id="+ id,
   url: 'log.php',
   success: function(response) {

  $('#info').show().html('<small><div>'+response+
    '<div class="modal-footer">'+
        '<button type="button" class="btn btn-secondary" data-dismiss="modal">Fechar</button>'+
    '</div>'+
    '</div></small');

$('#notificacao').modal('show');

     }
  });
}

function loadTable() {
  $.ajax({
     type: 'POST',
     cache: false,
     url: 'load.php',
     async: true,
     success: function(response) {
        $("#bodyManut").show().html(response);
        $("btnAdicionar").on("click", Salvar);        
      }
  });
}

function Notificacao (info, iClass) {
  $('#info').show().html('<div class="text-center text-white '+iClass+'"><h2>'+info+'</h2></div>');

$('#notificacao').modal('show');
setTimeout(function () {
    $('#notificacao').modal('hide')
}, 2000);


  loadTable();
}

function Esconde () {
  timer = setTimeout( function() {
    $("#botoes").show().html('');
    $('#cabecalho').addClass('d-none d-print-block');
  }, 30000);
}

function ReloadPage () {
  setTimeout( function () {
    window.location.reload(true);
  }, 2500);
}

function detectmob() { 
 if( navigator.userAgent.match(/Android/i)
 || navigator.userAgent.match(/webOS/i)
 || navigator.userAgent.match(/iPhone/i)
 || navigator.userAgent.match(/iPad/i)
 || navigator.userAgent.match(/iPod/i)
 || navigator.userAgent.match(/BlackBerry/i)
 || navigator.userAgent.match(/Windows Phone/i)
 ){
    return true;
  }
 else {
    return false;
  }
}