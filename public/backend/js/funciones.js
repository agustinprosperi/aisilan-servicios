function compararHorasContinuas() {
    var horaEntrada = document.getElementById("eve_horario_from").value;
    var horaSalida = document.getElementById("eve_horario_to").value;

    // Solo continuamos si ambos campos tienen valores
    if (horaEntrada && horaSalida) {
        // Convertir las horas a objetos Date para facilitar la comparación
        var dateEntrada = new Date("2000-01-01 " + horaEntrada);
        var dateSalida = new Date("2000-01-01 " + horaSalida);

        if (dateEntrada > dateSalida) {
            alert("La hora de entrada debe ser menor que la hora de salida.");
            // Vaciar el campo de entrada
            document.getElementById("horaEntrada").value = "";
        }
    }
}

/**
 * Solo permite ingresar numeros.
 * onkeypress="return soloNumeros(event);"
 */
function soloNumeros(e){
    tecla = (document.all) ? e.keyCode : e.which;

    //Tecla de retroceso para borrar, siempre la permite
    if (tecla==8 || tecla==127 || tecla==9 || tecla==39|| tecla==37){
        return true;
    }

    // Patron de entrada, en este caso solo acepta numeros
    patron =/[0-9]/;
    tecla_final = String.fromCharCode(tecla);
    return patron.test(tecla_final);
}
/**
 * Solo números
 * onkeypress="return soloNumeros2(event);"
 */
function soloNumeros2(e)
{
var key = window.Event ? e.which : e.keyCode
return ((key >= 48 && key <= 57) || (key==8))
}

/**
 * Solo permite ingresar letras.
 * onkeypress="return soloLetras(event);"
 */
function soloLetras(e){
	key = e.keyCode || e.which;
	tecla = String.fromCharCode(key).toLowerCase();
	letras = " áéíóúabcdefghijklmnñopqrstuvwxyz";
	especiales = "8-37-39-46";

	tecla_especial = false
	for(var i in especiales){
		 if(key == especiales[i]){
			 tecla_especial = true;
			 break;
		 }
	 }

	 if(letras.indexOf(tecla)==-1 && !tecla_especial){
		 return false;
	 }
 }

function validaFechaDDMMAAAA(fecha){
	var dtCh= "-";
	var minYear=1900;
	var maxYear=2100;
	function isInteger(s){
		var i;
		for (i = 0; i < s.length; i++){
			var c = s.charAt(i);
			if (((c < "0") || (c > "9"))) return false;
		}
		return true;
	}
	function stripCharsInBag(s, bag){
		var i;
		var returnString = "";
		for (i = 0; i < s.length; i++){
			var c = s.charAt(i);
			if (bag.indexOf(c) == -1) returnString += c;
		}
		return returnString;
	}
	function daysInFebruary (year){
		return (((year % 4 == 0) && ( (!(year % 100 == 0)) || (year % 400 == 0))) ? 29 : 28 );
	}
	function DaysArray(n) {
		for (var i = 1; i <= n; i++) {
			this[i] = 31
			if (i==4 || i==6 || i==9 || i==11) {this[i] = 30}
			if (i==2) {this[i] = 29}
		}
		return this
	}
	function isDate(dtStr){
		var daysInMonth = DaysArray(12)
		var pos1=dtStr.indexOf(dtCh)
		var pos2=dtStr.indexOf(dtCh,pos1+1)
		var strDay=dtStr.substring(0,pos1)
		var strMonth=dtStr.substring(pos1+1,pos2)
		var strYear=dtStr.substring(pos2+1)
		strYr=strYear
		if (strDay.charAt(0)=="0" && strDay.length>1) strDay=strDay.substring(1)
		if (strMonth.charAt(0)=="0" && strMonth.length>1) strMonth=strMonth.substring(1)
		for (var i = 1; i <= 3; i++) {
			if (strYr.charAt(0)=="0" && strYr.length>1) strYr=strYr.substring(1)
		}
		month=parseInt(strMonth)
		day=parseInt(strDay)
		year=parseInt(strYr)
		if (pos1==-1 || pos2==-1){
			return false
		}
		if (strMonth.length<1 || month<1 || month>12){
			return false
		}
		if (strDay.length<1 || day<1 || day>31 || (month==2 && day>daysInFebruary(year)) || day > daysInMonth[month]){
			return false
		}
		if (strYear.length != 4 || year==0 || year<minYear || year>maxYear){
			return false
		}
		if (dtStr.indexOf(dtCh,pos2+1)!=-1 || isInteger(stripCharsInBag(dtStr, dtCh))==false){
			return false
		}
		return true
	}
	if(isDate(fecha)){
		return true;
	}else{
		return false;
	}
}

function validarFecha(fecha)
{
	if(validaFechaDDMMAAAA(fecha) == false)
	{
		alert("Fecha no válida");
		$("#fecha").val("");
	}
}
/*upper case*/
function pulsar(obj) {
	obj.value=obj.value.toUpperCase();
}


function valor_entre_uno_y_cien(valor)
{

	if(valor < 1 || valor > 100)
		alert("Ingrese un valor comprendido entre 1 y 100");
}

function valor_entre_cero_y_cien(valor,ids)
{

	if(valor < 0 || valor > 100){
		alert("Ingrese un valor comprendido entre 0 y 100");
		$("#"+ids+"").focus();
	}
	return false;
}

function ajax_aniadir_trabajador_a_proyecto(ruta, pro_id, div, rutabase) // yes
{
	if($('#usu_id_project').val() != ''){
		var parametros = {
						"pro_id" : pro_id,
						"usu_id" : $('#usu_id_project').val(),
						"wor_ids" : $('#wor_id_project').val(),
					};

		$.ajax({
				data:  parametros,
				url:   ruta,
				type:  'post',
				beforeSend: function () {
					//$("#done").css("display","inline-block");
				},
				success:  function (response) {
					$("#"+div+"").html(response);
					$('#usu_id_project').val(null).trigger('change.select2');
					$("#wor_id_project").select2("val", "");
					ajax_actualizar_combobox_trabajador_proyecto(rutabase+'cargar_trabajador_ajax', pro_id, 'usu_id_project');
				}
		});
	}else	
		alert("Los campos con asteriscos son obligatorios...");

	//console.log(wor_id_project);
}
//sirve
function ajax_eliminar_trabajador_proyecto(ruta, pro_id, usu_id, div, rutabase) // yes
{ 
	if(confirm("Eliminar al trabajador del proyecto?")){
		var parametros = {
			"pro_id" : pro_id,
			"usu_id" : usu_id,
		};

		$.ajax({
			data:  parametros,
			url:   ruta,
			type:  'post',
			beforeSend: function () {
				//$("#done").css("display","inline-block");
			},
			success:  function (response) {
				$("#"+div+"").html(response);
				ajax_actualizar_combobox_trabajador_proyecto(rutabase+'cargar_trabajador_ajax', pro_id, 'usu_id_project');
			}
		});
	}
}
//sirve
function ajax_actualizar_combobox_trabajador_proyecto(ruta, pro_id, div) // yes
{
	var parametros = {
		"pro_id" : pro_id,
	};

	$.ajax({
		data:  parametros,
		url:   ruta,
		type:  'post',
		beforeSend: function () {
			//$("#done").css("display","inline-block");
		},
		success:  function (response) {
			$("#"+div+"").html(response);
		}
	});
}

//sirve
function cargar_localidades(ruta, prov_id, div)
{
	//document.getElementById('ins_sub_especialidad').selectedIndex = 0;
	var parametros = {
		"prov_id":prov_id
	};
	$.ajax({
		data: parametros,
		url: ruta,
		type: 'post',
		beforeSend: function(){
			//$('#loading_doc_ins').css('display','block');
		},
		success: function (resp){
			//$('#loading_doc_ins').css('display','none');
			$('#'+div).html(resp);
		}
	});
}

//sirve
function cargar_cliente_name_ajax(ruta, pro_id, div) // yes
{
	//prender el overlay en la sección de trabajadores del evento
	$("#on-overlay-if-change-project").show();
	var parametros = {
		"pro_id":pro_id
	};
	$.ajax({
		data: parametros,
		url: ruta,
		type: 'post',
		beforeSend: function(){
			//$('#loading_doc_ins').css('display','block');
		},
		success: function (resp){
			$('#'+div).html(resp);
		}
	});
}

//sirve
function cargar_cliente_id_ajax(ruta, pro_id, div) // yes
{
	var parametros = {
		"pro_id":pro_id
	};
	$.ajax({
		data: parametros,
		url: ruta,
		type: 'post',
		beforeSend: function(){
			//$('#loading_doc_ins').css('display','block');
		},
		success: function (resp){
			$('#'+div).val(resp);
		}
	});
}

//sirve
function cargar_coordinador_name_ajax(ruta, pro_id, div) // yes
{
	var parametros = {
		"pro_id":pro_id
	};
	$.ajax({
		data: parametros,
		url: ruta,
		type: 'post',
		beforeSend: function(){
			//$('#loading_doc_ins').css('display','block');
		},
		success: function (resp){
			$('#'+div).html(resp);
		}
	});
}

//sirve
function cargar_coordinador_id_ajax(ruta, pro_id, div) // yes
{
	var parametros = {
		"pro_id":pro_id
	};
	$.ajax({
		data: parametros,
		url: ruta,
		type: 'post',
		beforeSend: function(){
			//$('#loading_doc_ins').css('display','block');
		},
		success: function (resp){
			$('#'+div).val(resp);
		}
	});
}
//sirve
function cargar_tipo_horario_ajax(ruta, pro_id, div)
{
	var parametros = {
		"pro_id":pro_id
	};
	$.ajax({
		data: parametros,
		url: ruta,
		type: 'post',
		beforeSend: function(){
			//$('#loading_doc_ins').css('display','block');
		},
		success: function (resp){
			$('#'+div).html(resp);
		}
	});
}


/*
function ajax_aniadir_trabajador_a_evento(ruta, pro_id, eve_id, div, rutabase)
{
	var tar_id_project = $('#tar_id_project').val();

	if($('#usu_id_project').val() != '' && tar_id_project.length > 0){
		var parametros = {
						"pro_id" : pro_id,
						"eve_id" : eve_id,
						"usu_id" : $('#usu_id_project').val(),
						"cat_id" : $('#cat_id_project').val(),
						"tar_ids" : $('#tar_id_project').val(),
					};

		$.ajax({
				data:  parametros,
				url:   ruta,
				type:  'post',
				beforeSend: function () {
					//$("#done").css("display","inline-block");
				},
				success:  function (response) {
					$("#"+div+"").html(response);
					$('#usu_id_project').val(null).trigger('change.select2');
					$('#cat_id_project').val(null).trigger('change.select2');
					$("#tar_id_project").select2("val", "");

					ajax_actualizar_combobox_trabajador_evento(rutabase+'cargar_trabajador_ajax', pro_id, eve_id, 'usu_id_project');
				}
		});
	}else	
		alert("Los campos con asteriscos son obligatorios...");

	//console.log(pro_id);
}
*/
//sirve
function ajax_editar_trabajador_evento(ruta, eve_tar_id_init, eve_id, tra_id, div, rutabase){ // yes
	
	jQuery('#form-modal-trabajador').attr("action", rutabase+'aniadir_trabajador/'+eve_id+'/'+tra_id);
	jQuery('#eve_tar_id_init').val(eve_tar_id_init);

	var parametros = {
		"eve_id" : eve_id,
		"tra_id" : tra_id,
		"tipo_horario": jQuery('.input-tipo-horario').val(),
	};

	$.ajax({
		data:  parametros,
		url:   ruta,
		type:  'post',
		beforeSend: function () {
			//$("#done").css("display","inline-block");
		},
		success:  function (response) {
			$("#"+div+"").html(response);
			//ajax_actualizar_combobox_trabajador_evento(rutabase+'cargar_trabajador_ajax', pro_id, eve_id, 'usu_id_project');
		}
	});
	
}
/*
//sirve
function ajax_eliminar_trabajador_evento(ruta, pro_id, eve_id, eve_tra_id, div, rutabase){
	if(confirm("Eliminar al trabajador del evento?")){
		var parametros = {
			"pro_id" : pro_id,
			"eve_id" : eve_id,
			"eve_tra_id" : eve_tra_id,
		};

		$.ajax({
			data:  parametros,
			url:   ruta,
			type:  'post',
			beforeSend: function () {
				//$("#done").css("display","inline-block");
			},
			success:  function (response) {
				$("#"+div+"").html(response);
				ajax_actualizar_combobox_trabajador_evento(rutabase+'cargar_trabajador_ajax', pro_id, eve_id, 'usu_id_project');
			}
		});
	}
}
*/
//sirve
function ajax_cargar_tareas_por_cat_id(ruta, cat_id, div){ // yes

	$("#"+div).select2({
		placeholder: "- Tarea -",
    	allowClear: true,
	});
	
	var parametros = {
		"cat_id" : cat_id,
	};

	$.ajax({
		data:  parametros,
		url:   ruta,
		type:  'post',
		beforeSend: function () {
			//$("#done").css("display","inline-block");
		},
		success:  function (response) {
			$("#"+div+"").html(response);
		}
	});
}
/*
//sirve
function ajax_actualizar_combobox_trabajador_evento(ruta, pro_id, eve_id, div)
{
	var parametros = {
		"pro_id" : pro_id,
		"eve_id" : eve_id,
	};

	$.ajax({
		data:  parametros,
		url:   ruta,
		type:  'post',
		beforeSend: function () {
			//$("#done").css("display","inline-block");
		},
		success:  function (response) {
			$("#"+div+"").html(response);
		}
	});
}
*/

function ajax_verificarUsername(ruta, valor, usu_id, div)
{
	var parametros = {
	    "valor" : valor,
		"usu_id": usu_id
    };

	//alert(usu_id+" asdf");

    $.ajax({
            data:  parametros,
            url:   ruta,
            type:  'post',
            beforeSend: function () {
                $("#done").css("display","inline-block");
            },
            success:  function (response) {
                $("#done").css("display","none");
                $("#"+div+"").html(response);
            }
    });
}
function ajax_verificarEmail(ruta, valor, div)
{
	var parametros = {
	                "valor" : valor
    };

    $.ajax({
            data:  parametros,
            url:   ruta,
            type:  'post',
            beforeSend: function () {
                $("#doneemail").css("display","inline-block");
            },
            success:  function (response) {
                $("#doneemail").css("display","none");
                $("#"+div+"").html(response);
            }
    });
}

function calcularDiferenciaTiempo(input_1_id, input_2_id, fecha_evento_id, output) { // yes
    // Obtener los valores de los inputs
    var horaInicio = document.getElementById(input_1_id).value;
    var horaFin = document.getElementById(input_2_id).value;
    var fecha_evento = document.getElementById(fecha_evento_id).value;

	if(horaInicio != '' && horaFin != '' && fecha_evento != ''){

		// Convertir las horas ingresadas a objetos de fecha
		var inicio = new Date(fecha_evento + " " + horaInicio);
		var fin = new Date(fecha_evento + " " + horaFin);

		if(inicio > fin){
			fin.setDate(fin.getDate() + 1);
		}			

		// Calcular la diferencia en milisegundos
		var diferenciaEnMS = fin - inicio;

		// Convertir la diferencia a días, horas y minutos
		var dias = Math.floor(diferenciaEnMS / (1000 * 60 * 60 * 24));
		var horas = Math.floor((diferenciaEnMS % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
		var minutos = Math.floor((diferenciaEnMS % (1000 * 60 * 60)) / (1000 * 60));

		// Mostrar la diferencia
		var resultado = document.getElementById(output);
		resultado.innerHTML = "";

		if (dias > 0) {
		resultado.innerHTML += dias + " día(s), ";
		}

		if (horas > 0 || dias > 0) {
		resultado.innerHTML += horas + " hora(s), ";
		}

		resultado.innerHTML += minutos + " minuto(s).";
	}else
		if(horaInicio == "")
			document.getElementById(output).innerHTML = "Ingrese 'Hora desde'";
		else if(horaFin == "")
			document.getElementById(output).innerHTML = "Ingrese 'Hora hasta'";
		else if(horaInicio == "" && horaFin == "")
			document.getElementById(output).innerHTML = "Ingrese 'Hora desde' y 'Hora hasta'";
  }

  function periodoJavascript(text){
    if(text == 'morning') return "Mañana";
    if(text == 'afternoon') return "Tarde";
    if(text == 'night') return "Noche";
    if(text == 'continue') return "Continuo";
}




























//sirve
function ajax_editar_tarea_registrada(ruta, eve_tar_id, div) // new
{
	//editar título de modal
	$('#modal-title').html("Editar tarea");
	var parametros = {
		eve_tar_id:eve_tar_id
	};
	$.ajax({
		data: parametros,
		url: ruta,
		type: 'post',
		beforeSend: function(){
			//$('#loading_doc_ins').css('display','block');
		},
		success: function (resp){
			$('#'+div).html(resp);
		}
	});
}
//sirve
function ajax_editar_tarea(ruta, eve_tar_id, div) // new
{
	//editar título de modal
	$('#eve_title').html("Editar tarea");
	$('#eve_text_periodo').html('Mañana')

	var parametros = {
		eve_tar_id:eve_tar_id
	};
	$.ajax({
		data: parametros,
		url: ruta,
		type: 'post',
		beforeSend: function(){
			//$('#loading_doc_ins').css('display','block');
		},
		success: function (resp){
			$('#'+div).html(resp);
		}
	});
}
//sirve
function ajax_validar_tarea(ruta, eve_tar_id, state_ck, div) // new
{
	var parametros = {
		"eve_tar_id" : eve_tar_id,
		"state_ck" : state_ck,
	};

	$.ajax({
		data:  parametros,
		url:   ruta,
		type:  'post',
		beforeSend: function () {
			//$("#done").css("display","inline-block");
		},
		success:  function (response) {
			$("#"+div+"").html(response);
			if(state_ck)
				toastr.success('La tarea fué validada!');
			else
				toastr.info('La tarea no fué validada!');
		},
		error: function(){
			toastr.error('Ocurrio un error, revise su conexión a internet.');
		}
	});
}



$(document).ready(function() {
	toastr.options = {
		'closeButton': true,
		'debug': false,
		'newestOnTop': false,
		'progressBar': false,
		'positionClass': 'toast-top-center',
		'preventDuplicates': false,
		'showDuration': '2000',
		'hideDuration': '1000',
		'timeOut': '4000',
		'extendedTimeOut': '1000',
		'showEasing': 'swing',
		'hideEasing': 'linear',
		'showMethod': 'fadeIn',
		'hideMethod': 'fadeOut',
	}

	$('.more-event').on('click', function(e){
		e.preventDefault();
		$(this).parent('.col-event').find('.event').toggle();
		$(this).toggleClass('open');
	});
});



function checkConnection() {
	if (!navigator.onLine) {
		alert("No hay conexión a Internet");
		return;
	}
}

$(document).ready(function() {
	$(document).on('click', function(e) {
		checkConnection();
		if (!navigator.onLine)
			e.preventDefault();
	});
});

function eliminar_notificacion_ajax(ruta, not_id)
{
	var parametros = {
		"not_id":not_id
	};
	$.ajax({
		data: parametros,
		url: ruta,
		type: 'post',
		beforeSend: function(){
			//$('#loading_doc_ins').css('display','block');
		},
		success: function (resp){
			$('.item-'+not_id).addClass("item-leido");
			//$('#'+div).html(resp);
		}
	});
}