/*
 * form_validation.js
 *
 * Demo JavaScript used on Validation-pages.
 */

"use strict";

$(document).ready(function(){

	//===== Validation =====//
	// @see: for default options, see assets/js/plugins.form-components.js (initValidation())

	$.extend( $.validator.defaults, {
		invalidHandler: function(form, validator) {
			var errors = validator.numberOfInvalids();
			if (errors) {
				var message = errors == 1
				? 'Tiene 1 campo vacío. Debe ingresar información.'
				: 'Tiene ' + errors + ' campos vacíos. Debe ingresar información.';
				noty({
					text: message,
					type: 'error',
					timeout: 4000
				});
			}
		}
	});

	$("#validate_1").validate();
	$("#validate_2").validate();
	$("#validate_3").validate();
	$("#validate_4").validate();
	$("#validate_5").validate();
	$("#validate_6").validate();
	$("#validate_7").validate();
	$("#validate_8").validate();
	$("#validate_9").validate();
	$("#validate_10").validate();

	$(".validate").validate();
	$(".validate2").validate();
	$(".validate3").validate();
	$(".validate4").validate();
	$(".validate5").validate();

});
