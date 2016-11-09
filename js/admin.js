$(function(){

	$(".editar_texto_input").dblclick(function(){

		// variables
		var content 	= $(this);
		var item 		= content.data('item');
		var texto 		= content.find(item).text();
		var id 			= content.data('id');
		var campo 		= content.data('campo');
		var styles 		= (content.data('style'))?content.data('style'):'';
		var item_class 	= (content.data('itemclass'))?content.data('itemclass'):'';

		// crear input o textarea
		var input = focusInTexto( content, texto, 'input', styles);

		// destruir textarea y enviar para guardar
		content.focusout(function(){

			var texto_final = focusOutTexto(content, input, item, item_class)
			guardarTexto(texto_final, id, campo);
		});

	});

	$(".editar_texto_area").dblclick(function(){

		// variables
		var content 	= $(this);
		var item 		= content.data('item');
		var texto 		= content.find(item).text();
		var id 			= content.data('id');
		var campo 		= content.data('campo');
		var styles 		= (content.data('style'))?content.data('style'):'';
		var item_class 	= (content.data('itemclass'))?content.data('itemclass'):'';

		// crear input o textarea
		var input = focusInTexto( content, texto, 'textarea', styles);
		
		// destruir textarea y enviar para guardar
		content.focusout(function(){

			var texto_final = focusOutTexto(content, input, item, item_class)
			guardarTexto(texto_final, id, campo);

		});

	});

	$("#btn_imagen_banner").on('click', function(e){
		e.preventDefault();

		$("#file_imagen_banner").trigger('click');
		$("#file_imagen_banner").on('change', function(){

			var datos = new FormData( $("#form_imagen_banner")[0] );
			$.ajax({
				url: Routing.generate('ajax_guardar_imagen_banner'),
				data: datos,
				dataType: 'json',
				method: 'post',
				contentType:false,
			  	processData:false,
			  	cache:false
			}).success(function(json){
				if(json.result)
				{
					location.reload(true);
				}

			});

		});
	});

	$(".btn_eliminar_foto_banner").on('click', function(e){
		e.preventDefault();
		var btn = $(this);
		var id = btn.data('id');

		if(confirm('¿Realmente desea eliminar la imagen?'))
		{
			$.ajax({
				url: Routing.generate('ajax_eliminar_imagen_banner'),
				data: {'id': id},
				dataType: 'json',
				method: 'post',
			}).success(function(json){
				if(json.result)
				{
					location.reload(true);
				}
			
			});

		}

	});

});

function focusInTexto(content, texto, area, styles)
{
	// input o textarea
	var campo_texto = '';
	if(area == 'input')
		campo_texto = '<input type="text" id="texto_generico" value="'+texto+'" style="'+styles+'">';
	else if(area == 'textarea')
		campo_texto = '<textarea id="texto_generico" rows="5" style="'+styles+'">'+texto+'</textarea>';

	// insertar en el contenido y agregar focus
	content.html(campo_texto);
	$("#texto_generico").focus();

	return $("#texto_generico");
}

function focusOutTexto(content, texto, item, item_class)
{
	var texto_real = texto.val();
	content.html('<'+item+' class="'+item_class+'">'+texto_real+'</'+item+'>');
	return texto_real;
}

function guardarTexto(texto, id, campo)
{
	var arr = {
		'texto': texto,
		'id': id,
		'campo': campo
	}

	$.ajax({
		url: Routing.generate('ajax_guardar_texto'),
		data: arr,
		dataType: 'json',
		method: 'post',
	}).success(function(json){
		if(json.result)
		{
			console.log('guardado');
		}

	});
}