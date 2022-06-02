    var info;
    var iClass;
    var timer;

window.onload = function() {

$('#refresh').click(function () {
  $('body').fadeOut().fadeIn("slow", function() {
    load();
    loadReject();
    loadDuplicadas();
    loadAuth();
  })
});

load();
loadReject();
loadDuplicadas();
loadAuth();
}

function load() {
  $.ajax({
     type: 'POST',
     cache: false,
     dataType: 'JSON',
     url: 'load1.php',
     success: function(response) {

      $.each(response,function(key,item){
          switch (item.reply) {
            case 'Access-Accept':
            $('#acpt1').show().html(item.total);
            break;
            case 'Access-Reject':
            $('#rjct1').show().html(item.total);
            break;
            case 'Interim-Update':
            $('#int1').show().html(item.total);
            break;
          }
      });
    }
  });

    $.ajax({
     type: 'POST',
     cache: false,
     dataType: 'JSON',
     url: 'load5.php',
     success: function(response) {

      $.each(response,function(key,item){
          switch (item.reply) {
            case 'Access-Accept':
            $('#acpt5').show().html(item.total);
            break;
            case 'Access-Reject':
            $('#rjct5').show().html(item.total);
            break;
            case 'Interim-Update':
            $('#int5').show().html(item.total);
            break;
          }
      });
    }
  });

    $.ajax({
     type: 'POST',
     cache: false,
     dataType: 'JSON',
     url: 'load30.php',
     success: function(response) {

      $.each(response,function(key,item){
          switch (item.reply) {
            case 'Access-Accept':
            $('#acpt30').show().html(item.total);
            break;
            case 'Access-Reject':
            $('#rjct30').show().html(item.total);
            break;
            case 'Interim-Update':
            $('#int30').show().html(item.total);
            break;
          }
      });
    }
  });

}

function loadReject() {
  $.ajax({
     type: 'POST',
     cache: false,
     url: 'loadReject.php',
     success: function(response) {
      $('#reject').show().html(response);
      
    }
  });

}

function loadDuplicadas() {
  $.ajax({
     type: 'POST',
     cache: false,
     url: 'loadDuplicadas.php',
     success: function(response) {
      $('#duplicadas').show().html(response);
      
    }
  });

}

function loadAuth() {
  $.ajax({
     type: 'POST',
     cache: false,
     url: 'loadAuth.php',
     success: function(response) {
      $('#auth').show().html(response);
      
    }
  });

}