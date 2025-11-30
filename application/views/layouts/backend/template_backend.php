<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0, user-scalable=0" />
	<title><?php echo $this->layout->getTitle(); ?></title>
	<meta name="description" content="<?php echo $this->layout->getDescripcion(); ?>">
	<meta name="keywords" content="<?php echo $this->layout->getKeywords(); ?>" />

	<!--=== CSS ===-->

	<!-- Bootstrap -->
	<link href="<?php echo base_url(); ?>public/backend/css/bootstrap.css" rel="stylesheet" type="text/css" />

	<!-- jQuery UI -->
	<!--<link href="<?php //echo base_url(); ?>public/backend/js/plugins/jquery-ui/jquery-ui-1.10.2.custom.css" rel="stylesheet" type="text/css" />-->
	<!--[if lt IE 9]>
		<link rel="stylesheet" type="text/css" href="<?php //echo base_url(); ?>public/backend/js/plugins/jquery-ui/jquery.ui.1.10.2.ie.css"/>
	<![endif]-->

	<!-- Theme -->
	<link href="<?php echo base_url(); ?>public/backend/css/main.css" rel="stylesheet" type="text/css" />
	<link href="<?php echo base_url(); ?>public/backend/css/plugins.css" rel="stylesheet" type="text/css" />

	<link href="<?php echo base_url(); ?>public/backend/css/responsive.css" rel="stylesheet" type="text/css" />
	<link href="<?php echo base_url(); ?>public/backend/css/icons.css" rel="stylesheet" type="text/css" />
	<link href="<?php echo base_url(); ?>public/backend/js/plugins/datepicker/datetimepicker.css" rel="stylesheet" type="text/css" />

	<link rel="stylesheet" href="<?php echo base_url(); ?>public/backend/css/fontawesome/font-awesome.min.css" type="text/css"/>
	<!--[if IE 7]>
		<link rel="stylesheet" href="<?php echo base_url(); ?>public/backend/css/fontawesome/font-awesome-ie7.min.css">
	<![endif]-->

	<!--[if IE 8]>
		<link href="<?php //echo base_url(); ?>public/backend/css/ie8.css" rel="stylesheet" type="text/css" />
	<![endif]-->
	<!--<link href='http://fonts.googleapis.com/css?family=Open+Sans:400,600,700' rel='stylesheet' type='text/css'>-->

	<!--=== JavaScript ===-->

	<script type="text/javascript" src="<?php echo base_url(); ?>public/backend/js/libs/jquery-1.10.2.min.js"></script>
	<script type="text/javascript" src="<?php echo base_url(); ?>public/backend/js/plugins/jquery-ui/jquery-ui-1.10.2.custom.min.js"></script>

	<script type="text/javascript" src="<?php echo base_url(); ?>public/backend/js/bootstrap.min.js"></script>
	<script type="text/javascript" src="<?php echo base_url(); ?>public/backend/js/libs/lodash.compat.min.js"></script>

	<!-- HTML5 shim, for IE6-8 support of HTML5 elements -->
	<!--[if lt IE 9]>
		<script src="<?php echo base_url(); ?>public/backend/js/libs/html5shiv.js"></script>
	<![endif]-->

	<!-- Smartphone Touch Events -->
	<script type="text/javascript" src="<?php echo base_url(); ?>public/backend/js/plugins/touchpunch/jquery.ui.touch-punch.min.js"></script>
	<script type="text/javascript" src="<?php echo base_url(); ?>public/backend/js/plugins/event.swipe/jquery.event.move.js"></script>
	<script type="text/javascript" src="<?php echo base_url(); ?>public/backend/js/plugins/event.swipe/jquery.event.swipe.js"></script>

	<!-- General -->
	<script type="text/javascript" src="<?php echo base_url(); ?>public/backend/js/libs/breakpoints.js"></script>
	<script type="text/javascript" src="<?php echo base_url(); ?>public/backend/js/plugins/respond/respond.min.js"></script>
	<script type="text/javascript" src="<?php echo base_url(); ?>public/backend/js/plugins/cookie/jquery.cookie.min.js"></script>
	<script type="text/javascript" src="<?php echo base_url(); ?>public/backend/js/plugins/slimscroll/jquery.slimscroll.min.js"></script>
	<script type="text/javascript" src="<?php echo base_url(); ?>public/backend/js/plugins/slimscroll/jquery.slimscroll.horizontal.min.js"></script>

	<!-- Page specific plugins -->
	<!-- Charts -->
	<!--[if lt IE 9]>
		<script type="text/javascript" src="<?php echo base_url() ?>public/backend/js/plugins/flot/excanvas.min.js"></script>
	<![endif]-->
	<script type="text/javascript" src="<?php echo base_url(); ?>public/backend/js/plugins/sparkline/jquery.sparkline.min.js"></script>

	<script type="text/javascript" src="<?php echo base_url(); ?>public/backend/js/plugins/flot/jquery.flot.min.js"></script>
	<script type="text/javascript" src="<?php echo base_url(); ?>public/backend/js/plugins/flot/jquery.flot.tooltip.min.js"></script>
	<script type="text/javascript" src="<?php echo base_url(); ?>public/backend/js/plugins/flot/jquery.flot.resize.min.js"></script>
	<script type="text/javascript" src="<?php echo base_url(); ?>public/backend/js/plugins/flot/jquery.flot.time.min.js"></script>
	<script type="text/javascript" src="<?php echo base_url(); ?>public/backend/js/plugins/flot/jquery.flot.orderBars.min.js"></script>
	<script type="text/javascript" src="<?php echo base_url(); ?>public/backend/js/plugins/flot/jquery.flot.pie.js"></script>
	<script type="text/javascript" src="<?php echo base_url(); ?>public/backend/js/plugins/flot/jquery.flot.selection.min.js"></script>
	<script type="text/javascript" src="<?php echo base_url(); ?>public/backend/js/plugins/flot/jquery.flot.growraf.min.js"></script>
	<script type="text/javascript" src="<?php echo base_url(); ?>public/backend/js/plugins/easy-pie-chart/jquery.easy-pie-chart.min.js"></script>

	<!-- Pickers -->
	<script type="text/javascript" src="<?php echo base_url(); ?>public/backend/js/plugins/pickadate/picker.js"></script>
	<script type="text/javascript" src="<?php echo base_url(); ?>public/backend/js/plugins/pickadate/picker.date.js"></script>
	<script type="text/javascript" src="<?php echo base_url(); ?>public/backend/js/plugins/pickadate/picker.time.js"></script>
	<script type="text/javascript" src="<?php echo base_url(); ?>public/backend/js/plugins/bootstrap-colorpicker/bootstrap-colorpicker.min.js"></script>

	<script type="text/javascript" src="<?php echo base_url(); ?>public/backend/js/plugins/datepicker/datetimepicker.js"></script>
	<script type="text/javascript" src="<?php echo base_url(); ?>public/backend/js/plugins/daterangepicker/moment.min.js"></script>
	<script type="text/javascript" src="<?php echo base_url(); ?>public/backend/js/plugins/daterangepicker/daterangepicker.js"></script>
	
	<script type="text/javascript" src="<?php echo base_url(); ?>public/backend/js/plugins/blockui/jquery.blockUI.min.js"></script>

	<script type="text/javascript" src="<?php echo base_url(); ?>public/backend/js/plugins/fullcalendar/fullcalendar.min.js"></script>

	<!-- Forms -->
	<script type="text/javascript" src="<?php echo base_url(); ?>public/backend/js/plugins/typeahead/typeahead.min.js"></script> <!-- AutoComplete -->
	<script type="text/javascript" src="<?php echo base_url(); ?>public/backend/js/plugins/autosize/jquery.autosize.min.js"></script>
	<script type="text/javascript" src="<?php echo base_url(); ?>public/backend/js/plugins/inputlimiter/jquery.inputlimiter.min.js"></script>
	<script type="text/javascript" src="<?php echo base_url(); ?>public/backend/js/plugins/uniform/jquery.uniform.min.js"></script> <!-- Styled radio and checkboxes -->
	<script type="text/javascript" src="<?php echo base_url(); ?>public/backend/js/plugins/tagsinput/jquery.tagsinput.min.js"></script>
	<script type="text/javascript" src="<?php echo base_url(); ?>public/backend/js/plugins/select2/select2.min.js"></script> <!-- Styled select boxes -->
	<script type="text/javascript" src="<?php echo base_url(); ?>public/backend/js/plugins/fileinput/fileinput.js"></script>
	<script type="text/javascript" src="<?php echo base_url(); ?>public/backend/js/plugins/duallistbox/jquery.duallistbox.min.js"></script>
	<script type="text/javascript" src="<?php echo base_url(); ?>public/backend/js/plugins/bootstrap-inputmask/jquery.inputmask.min.js"></script>
	<script type="text/javascript" src="<?php echo base_url(); ?>public/backend/js/plugins/bootstrap-wysihtml5/wysihtml5.min.js"></script>
	<script type="text/javascript" src="<?php echo base_url(); ?>public/backend/js/plugins/bootstrap-wysihtml5/bootstrap-wysihtml5.min.js"></script>
	<script type="text/javascript" src="<?php echo base_url(); ?>public/backend/js/plugins/bootstrap-multiselect/bootstrap-multiselect.min.js"></script>

	<!-- Globalize -->
	<script type="text/javascript" src="<?php echo base_url(); ?>public/backend/js/plugins/globalize/globalize.js"></script>
	<script type="text/javascript" src="<?php echo base_url(); ?>public/backend/js/plugins/globalize/cultures/globalize.culture.de-DE.js"></script>
	<script type="text/javascript" src="<?php echo base_url(); ?>public/backend/js/plugins/globalize/cultures/globalize.culture.ja-JP.js"></script>

	<!-- Form Validation -->
	<script type="text/javascript" src="<?php echo base_url(); ?>public/backend/js/plugins/validation/jquery.validate.js"></script>
	<script type="text/javascript" src="<?php echo base_url(); ?>public/backend/js/plugins/validation/additional-methods.min.js"></script>

	<!-- Noty -->
	<script type="text/javascript" src="<?php echo base_url(); ?>public/backend/js/plugins/noty/jquery.noty.js"></script>
	<script type="text/javascript" src="<?php echo base_url(); ?>public/backend/js/plugins/noty/layouts/top.js"></script>
	<script type="text/javascript" src="<?php echo base_url(); ?>public/backend/js/plugins/noty/themes/default.js"></script>

	<!-- Slim Progress Bars -->
	<script type="text/javascript" src="<?php echo base_url(); ?>public/backend/js/plugins/nprogress/nprogress.js"></script>

	<!-- Bootbox -->
	<script type="text/javascript" src="<?php echo base_url(); ?>public/backend/js/plugins/bootbox/bootbox.js"></script>

	<!-- App -->
	<script type="text/javascript" src="<?php echo base_url(); ?>public/backend/js/app.js"></script>
	<script type="text/javascript" src="<?php echo base_url(); ?>public/backend/js/plugins.js"></script>
	<script type="text/javascript" src="<?php echo base_url(); ?>public/backend/js/plugins.form-components.js"></script>

	<!-- DataTables -->
	<script type="text/javascript" src="<?php echo base_url(); ?>public/backend/js/plugins/datatables/jquery.dataTables.js"></script>
	<script type="text/javascript" src="<?php echo base_url(); ?>public/backend/js/plugins/datatables/tabletools/TableTools.js"></script> <!-- optional -->
	<script type="text/javascript" src="<?php echo base_url(); ?>public/backend/js/plugins/datatables/colvis/ColVis.min.js"></script> <!-- optional -->
	<script type="text/javascript" src="<?php echo base_url(); ?>public/backend/js/plugins/datatables/DT_bootstrap.js"></script>

	<!-- clockpicker -->
	<script type="text/javascript" src="<?php echo base_url(); ?>public/backend/js/plugins/clockpicker/jquery-clockpicker.min.js"></script>
	<link rel="stylesheet" href="<?php echo base_url(); ?>public/backend/js/plugins/clockpicker/jquery-clockpicker.min.css">

	<script>
	$(document).ready(function(){
		"use strict";

		App.init(); // Init layout and core plugins
		Plugins.init(); // Init all plugins
		FormComponents.init(); // Init all form-specific plugins
	});
	</script>

	<!-- Demo JS -->
	<script type="text/javascript" src="<?php echo base_url(); ?>public/backend/js/custom.js"></script>

	<script type="text/javascript" src="<?php echo base_url(); ?>public/backend/js/demo/form_components.js"></script>
	<script type="text/javascript" src="<?php echo base_url(); ?>public/backend/js/demo/ui_general.js"></script>
	<script type="text/javascript" src="<?php echo base_url(); ?>public/backend/js/demo/form_validation.js"></script>
	<script type="text/javascript" src="<?php echo base_url(); ?>public/backend/js/demo/pages_calendar.js"></script>
	<script type="text/javascript" src="<?php echo base_url(); ?>public/backend/js/demo/ui_buttons.js"></script>
	<!--<script type="text/javascript" src="<?php echo base_url(); ?>public/backend/js/demo/charts/chart_bars_vertical.js"></script>-->

	<?php echo $this->layout->css; ?>

	<?php echo $this->layout->js; ?>

	<!--<script src="https://kit.fontawesome.com/e4f868da6e.js"></script>-->
	<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet">

	<script type="text/javascript" src="<?php echo base_url(); ?>public/backend/js/funciones.js?v=3"></script>
	<link href="<?php echo base_url(); ?>public/backend/css/style.css" rel="stylesheet" type="text/css" />

	<!-- Toastr -->
	<link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/css/toastr.min.css">
	<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js"></script>

</head>

<body class="theme-dark">
	<?php echo $content_for_layout; ?>
</body>
</html>
