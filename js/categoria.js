$(function(){
    $('#fotos').mixItUp();

    $(".lightbox").lightGallery({
		selector: '.item'
	});

	// buscar imagen
	$("#btn_buscar_imagen").on('click', function(e){
		e.preventDefault();

		$("#file_foto").trigger('click');

		$("#file_foto").change(function(){
			var filename = $(this).val().split('\\').pop();
			$(".nombre_imagen").text(filename);
		});
	});

	$(".btn_guardar_imagen").on('click', function(){

		var datos = new FormData( $("#form_subir_foto_categoria")[0] );
		$.ajax({
			url: Routing.generate('ajax_guardar_imagen_categoria'),
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

	$(".btn_eliminar_imagen").on('click', function(e){
		e.preventDefault();
		var btn = $(this);
		var id	= btn.data('id');

		if(confirm('¿Realmente desea eliminar la imagen?'))
		{
			$.ajax({
				url: Routing.generate('ajax_eliminar_imagen_categoria'),
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