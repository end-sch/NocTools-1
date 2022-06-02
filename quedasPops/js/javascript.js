    var info;
    var iClass;
    var timer;

window.onload = function() {

  loadTable();
  Esconde();
  $('#search').hide();

$('#icon').on('click', function() {
  $('#titulo').toggleClass('col-md-7 col-md-10');
  $('#procura').toggleClass('col-md-4 col-md-1');
  $('#search').toggle();
  clearTimeout(timer);
  Esconde();
})

$("#search").on("keyup", function() {
    var value = this.value.toLowerCase().trim();
    $("tbody tr").css("display", function() {
      return this.innerText.toLowerCase().indexOf(value) > -1 ? "":"none"
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

function loadTable() {
  $.ajax({
     type: 'POST',
     cache: false,
     url: 'loadQuedasPops.php',
     async: true,
     success: function(response) {
      $('#voltar i').hide();
        $("#titulo").show().html('<h3>Quedas de clientes por POPs</h3>');
        $("#tabela").show().html(response);
        $('thead').addClass('thead-dark');
        $('tbody tr').addClass('table-primary');
        $('a').on('click', function() {
          var pop = $(this).parent().parent().attr('pop');
          var count = $(this).parent().parent().attr('count');
          extratoPop(pop, count);
        })
      }
  });
}

function extratoPop(pop, count) {

  $.ajax({
       type: 'POST',
       cache: false,
       url: 'loadExtratoPop.php',
       data: "pop=" +pop,
       async: true,
       success: function(response) {

          $("#titulo").html('<h3>Usuários que tiveram quedas hoje, no POP '+pop+'</h3><h4><small class="text-muted">Total de usuários online no POP: '+count+'</small></h4>');
          $('#voltar i').unbind().show().on('click', function() {
                      loadTable();
                    })

          $("#tabela").show().html(response);
          $('thead').addClass('thead-dark');
          $('tbody tr').addClass('table-info');
          $('a').on('click', function() {
            var username = $(this).parent().parent().attr('username');
            var cliente = $(this).parent().parent().attr('cliente');
            extratoCliente(username, cliente, pop, count);
          })
        }
    });
}

function extratoCliente(username, cliente, pop, count) {

  $.ajax({
       type: 'POST',
       cache: false,
       url: 'loadExtratoCliente.php',
       data: "username=" +username,
       async: true,
       success: function(response) {

          $("#titulo").html('<h3>Extrato radius do usuário PPPoE '+username+'</h3><h4><small class="text-muted">('+cliente+')</small></h4>');

          $('#voltar i').unbind().on('click', function() {
                      extratoPop(pop, count);
                    })

          $("#tabela").show().html(response);
          $('thead').addClass('thead-dark');
          $('tbody tr').addClass('table-warning');
        }
    });
}

function Esconde () {
  timer = setTimeout( function() {
    $('#search').hide();
    $('#titulo').removeClass('col-md-7').addClass('col-md-10');
    $('#procura').removeClass('col-md-4').addClass('col-md-1');
  }, 30000);
}