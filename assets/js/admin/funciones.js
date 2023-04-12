//****************** YOUR CUSTOMIZED JAVASCRIPT **********************//

function enviar_formulario_ajax(directorio,pagina,datos,divres){
	var direccion = directorio + pagina.toLowerCase() + ".php";//alert(direccion+'\n\n'+JSON.stringify(variables)+'\n\n'+nombre_div);
	$.ajax({
		type: "POST",
		data: datos,
        url: direccion,
		beforeSend: function(){
			$("#" + divres).html('<div class="progress"><div class="progress-bar progress-bar-striped active" role="progressbar" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100" style="width: 100%">Cargando...</div></div>');
		},
		success: function(response) {
			$("#" + divres).html(response);
		}
	});
	return false;
}

function enviar_formulario_ajax_clase(directorio,pagina,datos,divres){
	var direccion = directorio + pagina.toLowerCase() + ".php";//alert(direccion+'\n\n'+JSON.stringify(variables)+'\n\n'+nombre_div);
	$.ajax({
		type: "POST",
		data: datos,
        url: direccion,
		beforeSend: function(){
			$("." + divres).html('<div class="progress"><div class="progress-bar progress-bar-striped active" role="progressbar" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100" style="width: 100%">Cargando...</div></div>');
		},
		success: function(response) {
			$("." + divres).html(response);
		}
	});
	return false;
}

function ver_modal_vue(variables,pagina)

{

	jQuery('#ver_modal_vue').modal('show');

	jQuery.ajax({

		url: pagina,

		data: variables,

		type: 'post',

		beforeSend: function(resp) {

			$("#ver_modal_vue .modal-content").html('<div class="progress"><div class="progress-bar progress-bar-striped active" role="progressbar" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100" style="width: 100%">Cargando...</div></div>');

		},

		success: function(response)

		{

			jQuery('#ver_modal_vue .modal-content').html(response);

		}

	});

}

function ver_modal(variables,pagina)

{

	jQuery('#ver_modal').modal('show');

	jQuery.ajax({

		url: pagina,

		data: variables,

		type: 'post',

		beforeSend: function(resp) {

			$("#ver_modal .modal-content").html('<div class="progress"><div class="progress-bar progress-bar-striped active" role="progressbar" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100" style="width: 100%">Cargando...</div></div>');

		},

		success: function(response)

		{

			jQuery('#ver_modal .modal-content').html(response);

		}

	});

}

function ver_modal_ancho(variables,pagina)

{

	jQuery('#ver_modal_ancho').modal('show');

	jQuery.ajax({

		url: pagina,

		data: variables,

		type: 'post',

		beforeSend: function(resp) {

			$("#ver_modal_ancho .modal-content").html('<div class="progress"><div class="progress-bar progress-bar-striped active" role="progressbar" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100" style="width: 100%">Cargando...</div></div>');

		},

		success: function(response)

		{

			jQuery('#ver_modal_ancho .modal-content').html(response);

		}

	});

}



function mensajes_alerta(mensaje,tipo,titulo,posicion){

	toastr.options = {

	  "closeButton": true,

	  "debug": false,

	  "positionClass": posicion,

	  "onclick": null,

	  "showDuration": "1000",

	  "hideDuration": "1000",

	  "timeOut": "5000",

	  "extendedTimeOut": "1000",

	  "showEasing": "swing",

	  "hideEasing": "linear",

	  "showMethod": "fadeIn",

	  "hideMethod": "fadeOut"

	}

	toastr[tipo](mensaje, titulo)

}

function ImagenPrevia(id_file,id_previo) {

	var oFReader = new FileReader();

	oFReader.readAsDataURL(document.getElementById(id_file).files[0]);



	oFReader.onload = function (oFREvent) {

		document.getElementById(id_previo).src = oFREvent.target.result;

	};

}
