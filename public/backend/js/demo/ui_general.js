/*
 * general_ui.js
 *
 * Demo JavaScript used on General UI-page.
 */

"use strict";

$(document).ready(function(){

	//===== Date Pickers & Time Pickers & Color Pickers =====//
	$( ".datepicker" ).datepicker({
		defaultDate: +7,
		showOtherMonths:true,
		autoSize: true,
		//appendText: '<span class="help-block">(yyyy-mm-dd)</span>',
		dateFormat: 'yy-mm-dd',
		changeMonth: true,
        changeYear: true,
        firstDay: 1,
        yearRange: "-70:+10"
		});

	$('.inlinepicker').datepicker({
		inline: true,
		showOtherMonths:true
	});

	$('.datepicker-fullscreen').pickadate();
	$('.timepicker-fullscreen').pickatime();

	// Color Picker
	var bodyStyle = $('body')[0].style;
	$('#colorpicker-event').colorpicker().on('changeColor', function(ev) {
		bodyStyle.backgroundColor = ev.color.toHex();
	});

	//===== Notifications =====//
	// @see: for default options, see assets/js/plugins.js (initNoty())

	$('.btn-notification').click(function() {
		var self = $(this);

		noty({
			text: self.data('text'),
			type: self.data('type'),
			layout: self.data('layout'),
			timeout: 2000,
			modal: self.data('modal'),
			buttons: (self.data('type') != 'confirm') ? false : [
				{
					addClass: 'btn btn-primary', text: 'Ok', onClick: function($noty) {
						$noty.close();
						noty({force: true, text: 'You clicked "Ok" button', type: 'success', layout: self.data('layout')});
					}
				}, {
					addClass: 'btn btn-danger', text: 'Cancel', onClick: function($noty) {
						$noty.close();
						noty({force: true, text: 'You clicked "Cancel" button', type: 'error', layout: self.data('layout')});
					}
				}
			]
		});

		return false;
	});

	//===== Slim Progress Bars (nprogress) =====//
	$('.btn-nprogress-start').click(function () {
		NProgress.start();
		$('#nprogress-info-msg').slideDown(200);
	});

	$('.btn-nprogress-set-40').click(function () {
		NProgress.set(0.4);
	});

	$('.btn-nprogress-inc').click(function () {
		NProgress.inc();
	});

	$('.btn-nprogress-done').click(function () {
		NProgress.done();
		$('#nprogress-info-msg').slideUp(200);
	});

	//===== Bootbox (Modals and Dialogs) =====//
	$("a.basic-alert").click(function(e) {
		e.preventDefault();
		bootbox.alert("Hello world!", function() {
			console.log("Alert Callback");
		});
	});

	/*rafa*/

	$("a.confirm-dialog").click(function(e) {
		e.preventDefault();
		bootbox.confirm("Are you sure?", function(confirmed) {
			console.log("Confirmed: "+confirmed);
		});
	});

	/*rafa*/

	/*$(".confirm-dialog2").click(function(e) {
		e.preventDefault();
		bootbox.dialog({
			message: "Are you sure the delete records selected?",

			buttons: {
				danger: {
					label: "Eliminar",
					className: "btn-danger",
					callback: function() {
						var check = $("input[type='checkbox'].checkedos:checked").length;
						if(check == ""){
							alert("Seleccione algunos");
						}else{
							document.forms['formdelete'].submit();
						}
					}
				},
				main: {
					label: "Cancel",
					className: "btn-primary",
					callback: function() {
						bootbox.hideAll();
					}
				}
			}
		});
	});*/

	$("a.confirm-dialog-delete").click(function(e) {
		//capturamos el valor del href seleccionado
		var mihref = $(this).attr("href");
		e.preventDefault();
		bootbox.dialog({
			message: "Esta seguro de eliminar definitivamente el registro seleccionado?",

			buttons: {
				danger: {
					label: "Eliminar",
					className: "btn-danger",
					callback: function() {
						location.href = mihref;
					}
				},
				main: {
					label: "Cancel",
					className: "btn-primary",
					callback: function() {
						bootbox.hideAll();
					}
				}
			}
		});
	});

	$("a.confirm-dialog-inactive").click(function(e) {
		//capturamos el valor del href seleccionado
		var mihref = $(this).attr("href");
		e.preventDefault();
		bootbox.dialog({
			message: "Esta seguro en desactivar el registro seleccionado?",

			buttons: {
				danger: {
					label: "Desactivar",
					className: "btn-warning",
					callback: function() {
						location.href = mihref;
					}
				},
				main: {
					label: "Cancelar",
					className: "btn-primary",
					callback: function() {
						bootbox.hideAll();
					}
				}
			}
		});
	});



















	$(".confirm-dialog-activar-various").click(function(e) {
		var check = $("input[type='checkbox'].checkeados:checked").length;
		//si no hay ni un checked
		if(check == ""){
			e.preventDefault();
			bootbox.alert("Seleccione registros!", function() {
				console.log("Alert Callback");
			});
		}else{
			
			e.preventDefault();
			bootbox.dialog({
				message: "Esta seguro de activar los registros seleccionados?",
				/*title: "Custom title",*/
				buttons: {
					danger: {
						label: "Activar",
						className: "btn-danger",
						callback: function() {
							var action, url;
							url = $("#formdelete").data("url");
							$("#formdelete").attr("action", url);
							document.forms['formdelete'].submit();
						}
					},
					main: {
						label: "Cancelar",
						className: "btn-primary",
						callback: function() {
							bootbox.hideAll();
						}
					}
				}
			});
		}

	});

	$(".confirm-dialog-delete-various").click(function(e) {
		var check = $("input[type='checkbox'].checkeados:checked").length;
		//si no hay ni un checked
		if(check == ""){
			e.preventDefault();
			bootbox.alert("Seleccione registros!", function() {
				console.log("Alert Callback");
			});
		}else{
			// antes de borrar pregunta si se va a borrar
			e.preventDefault();
			bootbox.dialog({
				message: "Esta seguro de eliminar definitivamente los registros seleccionados?",
				/*title: "Custom title",*/
				buttons: {
					danger: {
						label: "Eliminar",
						className: "btn-danger",
						callback: function() {
							var action;
							action = $("#formdelete").attr("action");
							$("#formdelete").attr("action", action+"/DEL");
							document.forms['formdelete'].submit();
						}
					},
					main: {
						label: "Cancelar",
						className: "btn-primary",
						callback: function() {
							bootbox.hideAll();
						}
					}
				}
			});
		}

	});

	$(".confirm-dialog-delete-various2").click(function(e) {
		var check = $("input[type='checkbox'].checkeados:checked").length;
		//si no hay ni un checked
		if(check == ""){
			e.preventDefault();
			bootbox.alert("Seleccione registros!", function() {
				console.log("Alert Callback");
			});
		}else{
			// antes de borrar pregunta si se va a borrar
			e.preventDefault();
			bootbox.dialog({
				message: "Esta seguro de eliminar los registros seleccionados?",
				/*title: "Custom title",*/
				buttons: {
					danger: {
						label: "Eliminar",
						className: "btn-danger",
						callback: function() {
							var action;
							action = $("#formdelete").attr("action");
							$("#formdelete").attr("action", action+"/");
							document.forms['formdelete'].submit();
						}
					},
					main: {
						label: "Cancelar",
						className: "btn-primary",
						callback: function() {
							bootbox.hideAll();
						}
					}
				}
			});
		}

	});

	$(".confirm-dialog-inactive-various").click(function(e) {
		var check = $("input[type='checkbox'].checkeados:checked").length;
		//si no hay ni un checked
		if(check == ""){
			e.preventDefault();
			bootbox.alert("Seleccione registros!", function() {
				console.log("Alert Callback");
			});
		}else{
			// antes de borrar pregunta si se va a borrar
			e.preventDefault();
			bootbox.dialog({
				message: "Esta seguro de desactivar los registros seleccionados?",
				/*title: "Custom title",*/
				buttons: {
					danger: {
						label: "Desactivar",
						className: "btn-warning",
						callback: function() {
							var action;
							action = $("#formdelete").attr("action");
							$("#formdelete").attr("action", action+"/LOG");
							document.forms['formdelete'].submit();
						}
					},
					main: {
						label: "Cancelar",
						className: "btn-primary",
						callback: function() {
							bootbox.hideAll();
						}
					}
				}
			});
		}

	});




	$(".confirm-dialog-inscribir-masa").click(function(e) {
		var check = $("input[type='checkbox'].checkeados:checked").length;
		//si no hay ni un checked
		if(check == ""){
			e.preventDefault();
			bootbox.alert("Seleccione un estudiante por lo menos!", function() {
				console.log("Alert Callback");
			});
		}

	});



	/*
	añadir solo los seleccionados
	*/

	$(".confirm-dialog-aniadir-various").click(function(e) {
		var check = $("input[type='checkbox'].checkeados:checked").length;
		//si no hay ni un checked
		if(check == ""){
			e.preventDefault();
			bootbox.alert("Seleccione un item por lo menos!", function() {
				console.log("Alert Callback");
			});
		}else{
			// antes de borrar pregunta si se va a borrar
			e.preventDefault();
			bootbox.dialog({
				message: "Esta seguro de añadir los registros seleccionados?",
				/*title: "Custom title",*/
				buttons: {
					danger: {
						label: "Aceptar",
						className: "btn-warning",
						callback: function() {
							var action;
							action = $("#formmodulo").attr("action");
							$("#formmodulo").attr("action", action+"/ADD");
							document.forms['formmodulo'].submit();
						}
					},
					main: {
						label: "Cancelar",
						className: "btn-primary",
						callback: function() {
							bootbox.hideAll();
						}
					}
				}
			});
		}

	});











	/**/

	$("a.multiple-buttons").click(function(e) {
		e.preventDefault();
		bootbox.dialog({
			message: "I am a custom dialog",
			title: "Custom title",
			buttons: {
				success: {
					label: "Success!",
					className: "btn-success",
					callback: function() {
						console.log("great success");
					}
				},
				danger: {
					label: "Danger!",
					className: "btn-danger",
					callback: function() {
						console.log("uh oh, look out!");
					}
				},
				main: {
					label: "Click ME!",
					className: "btn-primary",
					callback: function() {
						console.log("Primary button");
					}
				}
			}
		});
	});

	$("a.multiple-dialogs").click(function(e) {
		e.preventDefault();

		bootbox.alert("Prepare for multiboxes in 1 second...");

		setTimeout(function() {
			bootbox.dialog({
				message: "Do you like Melon?",
				title: "Fancy Title",
				buttons: {
					danger: {
						label: "No :-(",
						className: "btn-danger",
						callback: function() {
							bootbox.alert("Aww boo. Click the button below to get rid of all these popups.", function() {
								bootbox.hideAll();
							});
						}
					},
					success: {
						label: "Oh yeah!",
						className: "btn-success",
						callback: function() {
							bootbox.alert("Glad to hear it! Click the button below to get rid of all these popups.", function() {
								bootbox.hideAll();
							});
						}
					}
				}
			});
		}, 2000);
	});

	$("a.programmatic-close").click(function(e) {
		e.preventDefault();
		var box = bootbox.alert("This dialog will automatically close in two seconds...");
		setTimeout(function() {
			box.modal('hide');
		}, 2000);
	});



});
