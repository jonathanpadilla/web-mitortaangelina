$(function(){

	var map = new GMaps({
	    div: "#map",
	    lat: -37.454337, 
	    lng: -72.332854,
	    zoom: 16,
	    scrollwheel: false,
	    draggable: false
	});
	map.addMarker({
	    lat: -37.454337, 
	    lng: -72.332854,
	    title: "Mi Torta Angelina"
	});

	$('#btn-enviar').click(function(e) {
        var form = $('#contacto');
        form.validate({
            rules: {
                nombre: {
					required: true,
					minlength: 3
				},
                correo: {
                    required: true,
                    email: true
                },
                telefono: {
                    required: true
                },               
                mensaje: {
                    required: true,
                    minlength: 10
                }
            },
            messages: {
                nombre: {
                    required: 'Ingrese su nombre',
                    minlength: 'Debe ingresar almenos 3 caracteres'
                },
                correo: {
                    required: 'Debe ingresar un correo electronico válido',
                    email: 'Debe ingresar un correo válido'
                },
                telefono: {
                    required: 'Debe ingresar un numero de teléfono'
                },
                mensaje: {
                    required: 'Campo requerido',
                    minlength: 'Debe ingresar almenos 10 caracteres'
                }
            },
            errorPlacement: function(error, element) {
                if (element.is(":radio") || element.is(":checkbox")) {
                    element.closest('.option-group').after(error);
                }
                else {
                    error.insertAfter(element);
                }
            }
        });

        e.preventDefault();

        if (form.valid(true)) {
                            
            var data = form.serialize();
            
            $.ajax({
              url: Routing.generate('ajax_enviar_contacto'),
              data: data,
              method:'post',
              dataType:'json'
            }).success(function(data){
                if(data.result)
                {
                    $("#nombre").val('');
                    $("#mail").val('');
                    $("#mensaje").val('');
                    $("#mensaje").parent().append('<span style="color:#7ee87e;font-size: 13px;margin-left: 8px;margin-top: -15px;position: absolute;">Enviado exitosamente.</span>');
                }
            });
            // setTimeout(function() {
            //     // window.location.href = "dashboard.html";
            // }, 2000);
        }
            
    });

});