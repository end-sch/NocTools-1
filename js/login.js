window.onload = function() {

	$(document).keypress(function(e){
		if(e.which == 13) {
		formulario();
		}
	})

	$('#enviar').on('click', function () {
		formulario();
	});

}

function formulario () {

	var login = $('#login').val();
	var senha = $('#senha').val();

	if ( login === "" || senha === "") {
		$('#resposta').fadeIn(500).html('<h3>Todos os campos devem ser preenchidos!</h3>').delay(1500).fadeOut(500);
	} else {

	var data = 'login=' + login + '&senha=' + senha

	$.ajax({
	    type: 'POST',
	    cache: false,
	    dataType: 'text',
	    url: 'ldap.php',
	    data: data,
	    success: function(response) {
	    	if ( response === "Logado") {
	    		window.location.href = "main.php";

	    	} else {
	    		$('#resposta').fadeIn(500).html('<h3>'+response+'</h3>').delay(1500).fadeOut(500);
	    	}
	      
	      }
	    });
	}
}