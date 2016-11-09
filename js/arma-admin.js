$(function(){

	$(".txt_guardar_nombre").keypress(function(e){
		if(e.which == 13)
		{
			var txt = $(this);
			var tipo = txt.data('tipo');
			var nombre = txt.val();
			
			$.ajax({
				url: Routing.generate('ajax_guardar_paso'),
				data: {tipo:tipo, nombre:nombre},
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

	$(".btn_eliminar_item").on('click', function(e){
		e.preventDefault();
		var btn = $(this);
		var id = btn.data('id');

		$.ajax({
			url: Routing.generate('ajax_eliminar_paso'),
			data: {id:id},
			dataType: 'json',
			method: 'post',
		}).success(function(json){
			if(json.result)
			{
				location.reload(true);
			}
		
		});
		
	});

});