/*
 * custom.js
 *
 * Place your code here that you need on all your pages.
 */

"use strict";

$(document).ready(function(){

	//===== Sidebar Search (Demo Only) =====//
	$('.sidebar-search').submit(function (e) {
		//e.preventDefault(); // Prevent form submitting (browser redirect)

		$('.sidebar-search-results').slideDown(200);
		return false;
	});

	$('.sidebar-search-results .close').click(function() {
		$('.sidebar-search-results').slideUp(200);
	});

	//===== .row .row-bg Toggler =====//
	$('.row-bg-toggle').click(function (e) {
		e.preventDefault(); // prevent redirect to #

		$('.row.row-bg').each(function () {
			$(this).slideToggle(200);
		});
	});

	//===== Sparklines =====//

	$("#sparkline-bar").sparkline('html', {
		type: 'bar',
		height: '35px',
		zeroAxis: false,
		barColor: App.getLayoutColorCode('red')
	});

	$("#sparkline-bar2").sparkline('html', {
		type: 'bar',
		height: '35px',
		zeroAxis: false,
		barColor: App.getLayoutColorCode('green')
	});

	//===== Refresh-Button on Widgets =====//

	$('.widget .toolbar .widget-refresh').click(function() {
		var el = $(this).parents('.widget');

		App.blockUI(el);
		window.setTimeout(function () {
			App.unblockUI(el);
			noty({
				text: '<strong>Widget updated.</strong>',
				type: 'success',
				timeout: 1000
			});
		}, 1000);
	});

	//===== Fade In Notification (Demo Only) =====//
	setTimeout(function() {
		$('#sidebar .notifications.demo-slide-in > li:eq(1)').slideDown(500);
	}, 3500);

	setTimeout(function() {
		$('#sidebar .notifications.demo-slide-in > li:eq(0)').slideDown(500);
	}, 7000);

	//hidden sidebar
	//$("#container").addClass("fixed-header sidebar-closed");

	jQuery(".btn-fill").click(function(){
		var nombres = ['CARLOS', 'ANA', 'LUIS', 'MARCO', 'BEATRIZ', 'JAVIER', 'BERNARDO','CARLA', 'NORMA', 'CAROLINA'][Math.floor(Math.random() * 10)];
		var ap = ['ALARCON', 'CHOQUE', 'MARTINEZ', 'MORALES', 'ALABE', 'MONTECINOS', 'MAMANI','GARCIA','AGUILAR','HUARACHI','MIRANDA','QUISPE'][Math.floor(Math.random() * 12)];
		var am = ['RODRIGUES', 'PONCE', 'LLUSCO', 'PARDO', 'CAMARA', 'HUANCA', 'GONZALES','CHURA','CHALLAPA','APAZA','BELZU','CALANI'][Math.floor(Math.random() * 12)];
		var ci = ['43223473', '12343823', '2342425', '42432321', '24243334', '42423337', '14142323'][Math.floor(Math.random() * 7)];
		var ci_ext = ['LP', 'OR', 'CB', 'BN', 'PA', 'TJ', 'CH', 'SC', 'PT'][Math.floor(Math.random() * 9)];
		var fecha_nac = ['10-08-2001', '25-11-1995', '15-02-1977', '11-12-2005', '05-08-2006'][Math.floor(Math.random() * 5)];

		var telefono = ['25222341', '25234322', '25242423', '25243224', '25243335', '25223336', '25214237'][Math.floor(Math.random() * 7)];
		var celular = ['72223485', '62343296', '72424207', '72432218', '62433323', '72233334', '72142345'][Math.floor(Math.random() * 7)];
		var direccion = "Zona sud Oeste";
		var username_1 = Math.floor((Math.random() * 10000) + 1);
		var username_2 = ['01', '02', '03', '04', '05', '06', '07'][Math.floor(Math.random() * 7)];

		var email = "test"+username_1+"@test.com";
		var pass = "12345";

		jQuery("#usu_nombre").val(nombres);
		jQuery("#usu_ap").val(ap);
		jQuery("#usu_am").val(am);
		jQuery("#usu_ci").val(ci);
		jQuery("#usu_ci_ext").val(ci_ext);
		jQuery("#fecha").val(fecha_nac);
		jQuery("#usu_email").val(email);
		jQuery("#usu_telefono").val(telefono);
		jQuery("#usu_celular").val(celular);
		jQuery("#usu_direccion").val(direccion+', casa #'+username_2+username_1);
		jQuery("#username").val("user"+Math.floor((Math.random() * 10000) + 1));

		jQuery("#usu_password").val(pass);
		jQuery("#cpass1").val(pass);
	});




	var today = new Date();
	var date = today.getFullYear() + '-' + (today.getMonth() + 1) + '-' + today.getDate();
	var time = today.getHours() + ':' + today.getMinutes();
	var currentDateTime = date + ' ' + time;
	//como setear https://xdsoft.net/jqplugins/datetimepicker/
	jQuery('.datetimepicker').datetimepicker({
		startDate: currentDateTime,
		format:'Y-m-d H:i',
		allowTimes:[
			'00:00', '00:15', '00:30',
			'01:00', '01:15', '01:30',
			'02:00', '02:15', '02:30',
			'03:00', '03:15', '03:30',
			'04:00', '04:15', '04:30',
			'05:00', '05:15', '05:30',
			'06:00', '06:15', '06:30',
			'07:00', '07:15', '07:30',
			'08:00', '08:15', '08:30',
			'09:00', '09:15', '09:30',
			'10:00', '10:15', '10:30',
			'11:00', '11:15', '11:30',
			'12:00', '12:15', '12:30',
			'13:00', '13:15', '13:30',
			'14:00', '14:15', '14:30',
			'15:00', '15:15', '15:30',
			'16:00', '16:15', '16:30',
			'17:00', '17:15', '17:30',
			'18:00', '18:15', '18:30',
			'19:00', '19:15', '19:30',
			'20:00', '20:15', '20:30',
			'21:00', '21:15', '21:30',
			'22:00', '22:15', '22:30',
			'23:00', '23:15', '23:30',
		]
	});

	jQuery('.timepicker').clockpicker({
		placement: 'bottom',
		align: 'right',
		autoclose: true,
		//'default': '20:48'
	});

	jQuery('.more-info').on('click', function(){
		var tra_id = jQuery(this).data('traid');
		jQuery('#row-more-info-'+tra_id).slideToggle();
		jQuery(this).find('i').toggleClass("icon-eye-open icon-eye-close");
	});
});





$.datetimepicker.setLocale('es');






$(function() {
	$('.datetimes').daterangepicker({
	  timePicker: true,
	  startDate: moment().startOf('hour'),
	  endDate: moment().startOf('hour').add(32, 'hour'),
	  locale: {
		format: 'M/DD hh:mm A'
	  }
	});
	
	// Configurar el formato de salida
    var outputFormat = "YYYY-MM-DD";
	$('.daterangepickerfilter').daterangepicker({
		startDate: moment().subtract(6, 'days'),
        endDate: moment(),
		autoUpdateInput: false,
		locale: {
			cancelLabel: 'Limpiar',
			applyLabel: 'Aplicar',
			format: outputFormat,
			"daysOfWeek": [
				"Do",
				"Lu",
				"Ma",
				"Mi",
				"Ju",
				"Vi",
				"Sa"
			],
			"monthNames": [
				"Enero",
				"Febrero",
				"Marzo",
				"Abril",
				"Mayo",
				"Junio",
				"Julio",
				"Agosto",
				"Septiembre",
				"Octubre",
				"Noviembre",
				"Diciembre"
			],
			"firstDay": 1
		}
	});
  
	// Actualizar el input con el formato de salida al seleccionar un rango de fechas
    $('.daterangepickerfilter').on('apply.daterangepicker', function(ev, picker) {
        $(this).val(picker.startDate.format(outputFormat) + ' - ' + picker.endDate.format(outputFormat));
    });

    // Limpiar el input al borrar la selección
    $('.daterangepickerfilter').on('cancel.daterangepicker', function(ev, picker) {
        $(this).val('');
    });



	$(".modal").draggable({
		handle: ".modal-header"
	});

	// Centrar el modal vertical y horizontalmente
	function centerModal() {
		var modal = $(this);
		modal.css('display', 'block');
		var modalDialog = modal.find('.modal-dialog');
		var marginY = ($(window).height() - modalDialog.height()) / 2;
		var marginX = ($(window).width() - modalDialog.width()) / 2;
		modalDialog.css({
			'margin-top': marginY,
			'margin-left': marginX
		});
	}

	$('.modal').on('show.bs.modal', centerModal);
	
	//Con este codigo evito que el usuario cierre la ventana haciendo clic fuera del modal
	//es decir obligo al usuario a usar el boton cerrar
	jQuery('.modal').modal({backdrop: 'static',keyboard: false, show: false});
});