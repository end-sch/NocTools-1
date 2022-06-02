    var info;
    var iClass;

window.onload = function() {

if (sessao !== "NOC") {
  $('body').show().html('<center><h1>Você não tem permissão para acessar esse conteúdo!</h1></center>');
}

  $("#btnAdicionar").on("click", Adicionar);
  loadTable();

  $("#search").on("keyup", function() {
      var value = $(this).val().toLowerCase();
      $("#tbl-corpo tr").filter(function() {
        $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
      });
    });

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
  
}

function Adicionar() {
    $("#tbl-corpo").prepend(
        "<tr>"+
        "<td><input type='text'/></td>"+
        "<td><input type='text'/></td>"+
        "<td><input type='text'/></td>"+
        "<td><input type='text'/></td>"+
        "<td><input type='text'/></td>"+
        "<td><i class='fas fa-save btnSalvar'></i><span>    </span><i class='fas fa-times-circle btnCancelar'></i></td>"+
        "</tr>");
     
        $(".btnSalvar").on("click", Salvar);     
        $(".btnCancelar").on("click", loadTable);
}

function Salvar() {
    var par = $(this).parent().parent(); //tr
    var tdAcesso = par.children("td:nth-child(1)");
    var tdURL = par.children("td:nth-child(2)");
    var tdUsuario = par.children("td:nth-child(3)");
    var tdSenha = par.children("td:nth-child(4)");
    var tdOBS = par.children("td:nth-child(5)");
    var tdBotoes = par.children("td:nth-child(6)");

    var acesso = tdAcesso.children("input[type=text]").val();
    var url = tdURL.children("input[type=text]").val();
    var usuario = tdUsuario.children("input[type=text]").val();
    var senha = tdSenha.children("input[type=text]").val();
    var obs = tdOBS.children("input[type=text]").val();

    var data = "acesso=" +acesso+ "&url=" +url+ "&usuario=" +usuario+ "&senha=" +senha+ "&obs=" +obs;

    $.ajax({
       type: 'POST',
       url: 'insert.php',
       data: data,
       success: function(response) {

            if ($.trim(response) == 'Inserted') {
               loadTable();
               info = 'Item inserido com sucesso.';
               iClass = 'bg-success';
           }

            if ($.trim(response) == 'Error') {
               info = 'Erro ao tentar inserir novo item. Tente novamente mais tarde.';
               iClass = 'bg-danger';
           }

           Notificacao(info, iClass);
        }
    });
}

function Excluir() {
  var id = $(this).parent().parent().attr("id");
    $.ajax({
       type: 'POST',
       url: 'delete.php',
       data: 'id=' + id,
       success: function(response) {

            if ($.trim(response) == 'Deleted') {
               loadTable();
               info = 'Item excluído com sucesso.';
               iClass = 'bg-success';
           }

            if ($.trim(response) == 'Error') {
               info = 'Erro ao tentar excluir o item. Tente novamente mais tarde.';
               iClass = 'bg-danger';
           }

           Notificacao(info, iClass);
        }
    });
}

function Editar() {

  var par = $(this).parent().parent(); //tr
  var tdAcesso = par.children("td:nth-child(1)");
  var tdURL = par.children("td:nth-child(2)");
  var tdUsuario = par.children("td:nth-child(3)");
  var tdSenha = par.children("td:nth-child(4)");
  var tdOBS = par.children("td:nth-child(5)");
  var tdBotoes = par.children("td:nth-child(6)");

  tdAcesso.html("<input type='text' id='txtacesso' value='"+tdAcesso.text()+"'/>");
  tdURL.html("<input type='text' id='txturl' value='"+tdURL.text()+"'/>");
  tdUsuario.html("<input type='text' id='txtusuario' value='"+tdUsuario.text()+"'/>");
  tdSenha.html("<input type='text' id='txtsenha' value='"+tdSenha.text()+"'/>");
  tdOBS.html("<input type='text' id='txtobs' value='"+tdOBS.text()+"'/>");
  tdBotoes.html("<i class='fas fa-save btnSalvar'></i><span>    </span><i class='fas fa-times-circle btnCancelar'></i>");

  $(".btnCancelar").on("click", loadTable);
  $(".btnSalvar").on("click", function (){

    var id = par.attr("id");
    var acesso = tdAcesso.children("input[type=text]").val();
    var url = tdURL.children("input[type=text]").val();
    var usuario = tdUsuario.children("input[type=text]").val();
    var senha = tdSenha.children("input[type=text]").val();
    var obs = tdOBS.children("input[type=text]").val();

    var data = "id=" +id+ "&acesso=" +acesso+ "&url=" +url+ "&usuario=" +usuario+ "&senha=" +senha+ "&obs=" +obs;

    $.ajax({
       type: 'POST',
       url: 'update.php',
       data: data,
       success: function(response) {

            if ($.trim(response) == 'Updated') {
               loadTable();
               info = 'Item atualizado com sucesso.';
               iClass = 'bg-success';
           }

            if ($.trim(response) == 'Error') {
               info = 'Erro ao tentar atualizar o item. Tente novamente mais tarde.';
               iClass = 'bg-danger';
           }

           Notificacao(info, iClass);
        }
    });

  });
}

function loadTable() {
    $.ajax({
       type: 'POST',
       cache: false,
       url: 'load.php',
       async: true,
       success: function(response) {
            $("#tbl-corpo").show().html(response);
            $(".btnSalvar").on("click", Salvar);
            $(".btnEditar").on("click", Editar);
            $(".btnExcluir").bind("click", Excluir);
        }
    });
}

function Notificacao (info, iClass) {
    $('#info').fadeIn(500).html('<div class="text-center text-white '+iClass+'"><h2>'+info+'</h2></div>').delay(1500).fadeOut(500);
}