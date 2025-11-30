<!DOCTYPE html>
<html lang="en">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
	<meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0, user-scalable=0" />

	<title><?php echo $this->layout->getTitle(); ?></title>
	<meta name="description" content="<?php echo $this->layout->getDescripcion(); ?>">
	<meta name="keywords" content="<?php echo $this->layout->getKeywords(); ?>" />

	<!--=== CSS ===-->

	<!-- Bootstrap -->
	<link href="<?php echo base_url(); ?>public/backend/css/bootstrap.min.css" rel="stylesheet" type="text/css" />

	<!-- Theme -->
	<link href="<?php echo base_url(); ?>public/backend/css/main.css" rel="stylesheet" type="text/css" />
	<link href="<?php echo base_url(); ?>public/backend/css/plugins.css" rel="stylesheet" type="text/css" />
	<link href="<?php echo base_url(); ?>public/backend/css/responsive.css" rel="stylesheet" type="text/css" />
	<link href="<?php echo base_url(); ?>public/backend/css/icons.css" rel="stylesheet" type="text/css" />

	<!-- Login -->
	<link href="<?php echo base_url(); ?>public/backend/css/login.css" rel="stylesheet" type="text/css" />

	<link rel="stylesheet" href="<?php echo base_url(); ?>public/backend/css/fontawesome/font-awesome.min.css">
	<!--[if IE 7]>
		<link rel="stylesheet" href="<?php echo base_url(); ?>public/backend/css/fontawesome/font-awesome-ie7.min.css">
	<![endif]-->

	<!--[if IE 8]>
		<link href="<?php echo base_url(); ?>public/backend/css/ie8.css" rel="stylesheet" type="text/css" />
	<![endif]-->
	<link href='http://fonts.googleapis.com/css?family=Open+Sans:400,600,700' rel='stylesheet' type='text/css'>

	<!--=== JavaScript ===-->

	<script type="text/javascript" src="<?php echo base_url(); ?>public/backend/js/libs/jquery-1.10.2.min.js"></script>

	<script type="text/javascript" src="<?php echo base_url(); ?>public/backend/js/bootstrap.min.js"></script>
	<script type="text/javascript" src="<?php echo base_url(); ?>public/backend/js/libs/lodash.compat.min.js"></script>

	<!-- HTML5 shim, for IE6-8 support of HTML5 elements -->
	<!--[if lt IE 9]>
		<script src="<?php echo base_url(); ?>public/backend/js/libs/html5shiv.js"></script>
	<![endif]-->

	<!-- Beautiful Checkboxes -->
	<script type="text/javascript" src="<?php echo base_url(); ?>public/backend/js/plugins/uniform/jquery.uniform.min.js"></script>

	<!-- Form Validation -->
	<script type="text/javascript" src="<?php echo base_url(); ?>public/backend/js/plugins/validation/jquery.validate.min.js"></script>

	<!-- Slim Progress Bars -->
	<script type="text/javascript" src="<?php echo base_url(); ?>public/backend/js/plugins/nprogress/nprogress.js"></script>

	<!-- App -->
	<script type="text/javascript" src="<?php echo base_url(); ?>public/backend/js/login.js"></script>
	<script>
	$(document).ready(function(){
		"use strict";

		Login.init(); // Init login JavaScript
	});
	</script>

	<?php echo $this->layout->css; ?> 

	<?php echo $this->layout->js; ?>
</head>

<body class="login">

	<?php echo $content_for_layout; ?>
	
</body>
</html>