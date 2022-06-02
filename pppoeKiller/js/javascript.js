window.onload = function() {

if (sessao !== "NOC") {
	$('body').show().html('<center><h1>Você não tem permissão para acessar esse conteúdo!</h1></center>');
}

$('#btn-ip').on('click', function () {
	loadIP();

})

$('#btn-relatorio').on('click', function () {
	relatorio();
})

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

function loadIP () {

loadingA();
loadingB();
var last_response_len_A = false;
var last_response_len_B = false;
respostaA = document.getElementById("respostaA");
respostaB = document.getElementById("respostaB");

  $.ajax({
     type: 'POST',
     url: 'loadIPA.php',
     cache: false,
     xhrFields: {
	    onprogress: function(e) {

	    	var this_response, response = e.currentTarget.response;
	        if(last_response_len_A === false)
	        {
	            this_response = response;
	            last_response_len_A = response.length;
	        }
	        else
	        {
	            this_response = response.substring(last_response_len_A);
	            last_response_len_A = response.length;
	        }

	    	respostaA.innerHTML += this_response;
	    	}
	    },

     success: function(response) {
     	$('#btn-ip').text('Gerar novo relatório de IPs').unbind().on('click', function () {
		loadIP();
	})
     	$('#respostaA').show().html(response);
     	var ifaces = $('#killA').attr('ifaces');
     	var bng = $('#killA').attr('bng');
		$('#killA').on('click', function() {
			killPPPoEA(ifaces,bng);
		  })

        }
    });

    $.ajax({
     type: 'POST',
     url: 'loadIPB.php',
     cache: false,
     xhrFields: {
	    onprogress: function(e) {

	    	var this_response, response = e.currentTarget.response;
	        if(last_response_len_B === false)
	        {
	            this_response = response;
	            last_response_len_B = response.length;
	        }
	        else
	        {
	            this_response = response.substring(last_response_len_B);
	            last_response_len_B = response.length;
	        }

	    	respostaB.innerHTML += this_response;
	    	}
	    },

     success: function(response) {
     	$('#btn-ip').text('Gerar novo relatório de IPs').unbind().on('click', function () {
		loadIP();
	})
     	$('#respostaB').show().html(response);
     	var ifaces = $('#killB').attr('ifaces');
     	var bng = $('#killB').attr('bng');
		$('#killB').on('click', function() {
			killPPPoEB(ifaces,bng);
		  })

        }
    });

}


function relatorio () {

loadingA();
loadingB();
var last_response_len_A = false;
var last_response_len_B = false;
respostaA = document.getElementById("respostaA");
respostaB = document.getElementById("respostaB");

  $.ajax({
     type: 'POST',
     url: 'relatorioA.php',
     cache: false,
     xhrFields: {
	    onprogress: function(e) {

	    	var this_response, response = e.currentTarget.response;
	        if(last_response_len_A === false)
	        {
	            this_response = response;
	            last_response_len_A = response.length;
	        }
	        else
	        {
	            this_response = response.substring(last_response_len_A);
	            last_response_len_A = response.length;
	        }

	    	respostaA.innerHTML += this_response;
	    	}
	    },

     success: function(response) {
     	$('#btn-relatorio').text('Gerar novo relatório de plataformas').unbind().on('click', function () {
		relatorio();
	})
     	$('#respostaA').show().html(response);
     	var ifaces = $('#killA').attr('ifaces');
     	var bng = $('#killA').attr('bng');
		$('#killA').on('click', function() {
			killPPPoEA(ifaces,bng);
		  })

        }
    });

    $.ajax({
     type: 'POST',
     url: 'relatorioB.php',
     cache: false,
     xhrFields: {
	    onprogress: function(e) {

	    	var this_response, response = e.currentTarget.response;
	        if(last_response_len_B === false)
	        {
	            this_response = response;
	            last_response_len_B = response.length;
	        }
	        else
	        {
	            this_response = response.substring(last_response_len_B);
	            last_response_len_B = response.length;
	        }

	    	respostaB.innerHTML += this_response;
	    	}
	    },

     success: function(response) {
     	$('#btn-relatorio').text('Gerar novo relatório de plataformas').unbind().on('click', function () {
		relatorio();
	})
     	$('#respostaB').show().html(response);
     	var ifaces = $('#killB').attr('ifaces');
     	var bng = $('#killB').attr('bng');
		$('#killB').on('click', function() {
			killPPPoEB(ifaces,bng);
		  })

        }
    });

}

function loadingA () {
	$('#respostaA').show().html('<div class="alert alert-primary">'+
								'<div class="spinner-border ml-auto" role="status" aria-hidden="true"></div>'+
                                '<strong>Processando...</strong>'+
                                '</div>');
}

function loadingB () {
	$('#respostaB').show().html('<div class="alert alert-primary">'+
								'<div class="spinner-border ml-auto" role="status" aria-hidden="true"></div>'+
                                '<strong>Processando...</strong>'+
                                '</div>');
}

function killPPPoEA(ifaces,bng) {

data = "ifaces=" + ifaces + "&bng=" + bng;

	loadingA();
	var last_response_len_A = false;
	respostaA = document.getElementById("respostaA");

	$.ajax({
    type: 'POST',
    url: 'killer.php',
    data: data,
    xhrFields: {
	    onprogress: function(e) {

	    	var this_response, response = e.currentTarget.response;
	        if(last_response_len_A === false)
	        {
	            this_response = response;
	            last_response_len_A = response.length;
	        }
	        else
	        {
	            this_response = response.substring(last_response_len_A);
	            last_response_len_A = response.length;
	        }

	    	respostaA.innerHTML += this_response;
	    	}
	    },

    success: function(response) {
     	
     	$('#respostaA').show().html(response);

        }
    });
}


function killPPPoEB(ifaces,bng) {

data = "ifaces=" + ifaces + "&bng=" + bng;

	loadingB();
	var last_response_len_B = false;
	respostaB = document.getElementById("respostaB");

	$.ajax({
    type: 'POST',
    url: 'killer.php',
    data: data,
    xhrFields: {
	    onprogress: function(e) {

	    	var this_response, response = e.currentTarget.response;
	        if(last_response_len_B === false)
	        {
	            this_response = response;
	            last_response_len_B = response.length;
	        }
	        else
	        {
	            this_response = response.substring(last_response_len_B);
	            last_response_len_B = response.length;
	        }

	    	respostaB.innerHTML += this_response;
	    	}
	    },

    success: function(response) {
     	
     	$('#respostaB').show().html(response);

        }
    });
}