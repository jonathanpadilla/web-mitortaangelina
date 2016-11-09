$(function(){

	$("#btn_agregar_image").on('click', function(e){
		e.preventDefault();

		$("#file_foto_galeria").trigger('click');
		$("#file_foto_galeria").on('change', function(){

			var datos = new FormData( $("#form_imagen_galeria")[0] );
			$.ajax({
				url: Routing.generate('ajax_guardar_imagen_galeria'),
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

	$(".btn_eliminar_foto_galeria").on('click', function(e){
		e.preventDefault();
		var btn = $(this);
		var id = btn.data('id');

		if(confirm('¿Realmente desea eliminar la imagen?'))
		{
			$.ajax({
				url: Routing.generate('ajax_eliminar_imagen_galeria'),
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

	$(".lightbox").lightGallery({
		selector: '.item'
	});

});