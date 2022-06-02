window.onload = function(){

  $('#sair').on('click', function() {
    window.location.replace("logout.php");
  })
}

window.setInterval(Activity, 120000);

function Activity() {

var x = document.activeElement.id;

		$('iframe').each(function() {
			y = $(this).attr("id");

			if ( y !== x ) {
				if ( typeof y !== "undefined") {
				$(this).attr('src', $(this).attr("src"));
				}
			    
			}
		});
}