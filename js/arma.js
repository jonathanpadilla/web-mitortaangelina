$(function(){

    $.validator.addMethod("valueNotEquals", function(value, element, arg){
        return arg != value;
     }, "Seleccione una opción");
    // validar formulario
    var form_arma = $("#form_arma");
    form_arma.validate({
        errorPlacement: function errorPlacement(error, element) { element.after(error); },
        rules: {
            txt_cantidad: {
                required: true,
                number: true
            },
            select_evento: {
                valueNotEquals: 'default'
            },
            select_relleno: {
                valueNotEquals: 'default'
            },
            select_sabor: {
                valueNotEquals: 'default'
            },
            select_cobertura: {
                valueNotEquals: 'default'
            }
        },
        messages: {
            txt_cantidad: {
                required: "Ingrese la cantidad de personas.",
                number: "Solo numeros."
            },
            select_evento: {
                valueNotEquals: "Seleccione un tipo de evento."
            },
            select_relleno: {
                valueNotEquals: "Seleccione un relleno."
            },
            select_sabor: {
                valueNotEquals: "Seleccione un sabor."
            },
            select_cobertura: {
                valueNotEquals: "Seleccione una cobertura."
            }
        }
    });

    // cargar wizzard
	$("#arma-torta").steps({
	    headerTag: "h3",
	    bodyTag: "section",
	    autoFocus: true,
	    labels: {
            cancel: "Cancelar",
            current: "current step:",
            pagination: "Pagination",
            finish: "Listo",
            next: "Siguiente",
            previous: "Anterior",
            loading: "cargando..."
        },
        onStepChanging: function (event, currentIndex, newIndex)
        {
            form_arma.validate().settings.ignore = ":disabled,:hidden";
            return form_arma.valid();
        },
        onFinishing: function (event, currentIndex)
        {
            form_arma.validate().settings.ignore = ":disabled";
            return form_arma.valid();
        },
        onFinished: function (event, currentIndex)
        {
            $("#m_observacion").text($("#txt_observacion").val());
            $('#modal_confirmar').foundation('open');
        }
	});

    // PIZARRA DE PEDIDOS
    $(".list_cantidad_personas").hide();
    $(".list_evento").hide();
    $(".list_relleno").hide();
    $(".list_sabor").hide();
    $(".list_cobertura").hide();
    // 1. tamaño
    $("#txt_cantidad").keyup(function(){
        llenarPizarra('Torta para '+$(this).val()+ (($(this).val() == 1)?' persona': ' personas'), 'list_cantidad_personas');
    });
    $("#txt_cantidad").change(function(){
        llenarPizarra('Torta para '+$(this).val()+ (($(this).val() == 1)?' persona': ' personas'), 'list_cantidad_personas');
    });

    // 2. evento
    $("#select_evento").change(function(){
        llenarPizarra('Evento '+$("#select_evento option:selected").text(), 'list_evento');
    });

    // 3. relleno
    $("#select_relleno").change(function(){
        llenarPizarra('Relleno '+$("#select_relleno option:selected").text(), 'list_relleno');
    });

    // 4. sabor
    $("#select_sabor").change(function(){
        llenarPizarra('Sabor '+$("#select_sabor option:selected").text(), 'list_sabor');
    });

    // 5. cobertura
    $("#select_cobertura").change(function(){
        llenarPizarra('Cobertura '+$("#select_cobertura option:selected").text(), 'list_cobertura');
    });

    $("#btn_enviar_pedido").on('click', function(){


        var form = $("#form_arma, #form_informacion").serialize();
        // var form2 = $("").serialize();

        // console.log(form1);
        // console.log(form2);

        $.ajax({
            url: $("#form_informacion").attr('action'),
            data: form,
            dataType: 'json',
            method: 'post',
        }).success(function(json){
            if(json.result)
            {
                location.reload(true);
            }
        
            // console.log(json);
        });
        
    });

    
});

function llenarPizarra(texto, item)
{
    $("."+item).text(texto);
    $("."+item).show("fast");
}