	<link href="https://gitcdn.github.io/bootstrap-toggle/2.2.2/css/bootstrap-toggle.min.css" rel="stylesheet">
	<script src="https://gitcdn.github.io/bootstrap-toggle/2.2.2/js/bootstrap-toggle.min.js"></script>

	<?php require (APPPATH."views/layouts/backend/header.php"); ?>

	<div id="container">
		<?php require (APPPATH."views/layouts/backend/sidebarleft.php"); ?>

		<div id="content">
			<div class="container">

				<?php require (APPPATH."views/layouts/backend/crumbs-page-header.php"); ?>

				<!--=== Page Content ===-->
				<div class="row">
					<!--=== Validation Example 1 ===-->
					<div class="col-md-12">
						<?php echo $this->message->display(); ?>
						<div class="widget box">
							<div class="widget-header">
								<h4 class="left"><i class="icon-reorder"></i> Configurar permisos para los diferentes roles</h4>
							</div>
							<div class="widget-content">
								<script type="text/javascript">
									var estado;
									$(function() {
									    $('.sw-permiso').change(function(e) {

									    	if($(this).prop('checked'))
									    		estado = "1";
									    	else
									    		estado = "0";

									    	var ruta,div;
									    	ruta = "<?php echo base_url() ?>backend/usuario/cambiar_permiso";

									    	var parametros = {
												"modulo":$(this).data("modulo"),
												"rol":$(this).data("rol"),
												"estado":estado
											};

									    	$.ajax({
									    		data: parametros,
												url: ruta,
												type: 'post',
												beforeSend: function(){
													$(e.target).parents().eq(1).find(".spinner-ck").show();
												},
												success: function (resp){
													$(e.target).parents().eq(1).find(".spinner-ck").hide();
													$("div#resp").html(resp);
												}
											});

									    });

									    $( ".toggle.btn" ).wrap( "<div class='wrap-sw-permiso'></div>" );
									    $(".wrap-sw-permiso").append("<div class='spinner-ck'></div>");
									});
								</script>

								<table width="100%" class="table-permisos">
								<thead>
									<tr>
										<th></th>
										<th>Administrador</th>
										<th>Coordinador</th>
										<th>Trabajador</th>
									</tr>
								</thead>
								<tbody>
									<tr class="row-title">
										<td class="tab-title">USUARIOS</td>
										<td><input class="sw-permiso" type="checkbox" data-toggle="toggle" data-modulo="usu" data-rol="Administrador" <?php echo permiso("usu", "Administrador") ?>></td>
										<td><input class="sw-permiso" type="checkbox" data-toggle="toggle" data-modulo="usu" data-rol="Coordinador" <?php echo permiso("usu", "Coordinador") ?>></td>
										<td></td>
									</tr>
									<tr class="row-sub-title">
										<td class="tab-sub-title">Administradores</td>
										<td><input class="sw-permiso" type="checkbox" data-toggle="toggle" data-modulo="usu_adm_lista" data-rol="Administrador" <?php echo permiso("usu_adm_lista", "Administrador") ?>></td>
										<td></td>
										<td></td>
									</tr>
									<tr class="row-item">
										<td class="tab-item">* Nuevo</td>
										<td><input class="sw-permiso" type="checkbox" data-toggle="toggle" data-modulo="usu_adm_nuevo" data-rol="Administrador" <?php echo permiso("usu_adm_nuevo", "Administrador") ?>></td>
										<td></td>
										<td></td>
									</tr>
									<tr class="row-item">
										<td class="tab-item">* Editar</td>
										<td><input class="sw-permiso" type="checkbox" data-toggle="toggle" data-modulo="usu_adm_editar" data-rol="Administrador" <?php echo permiso("usu_adm_editar", "Administrador") ?>></td>
										<td></td>
										<td></td>
									</tr>
									<tr class="row-item">
										<td class="tab-item">* Eliminar</td>
										<td><input class="sw-permiso" type="checkbox" data-toggle="toggle" data-modulo="usu_adm_eliminar" data-rol="Administrador" <?php echo permiso("usu_adm_eliminar", "Administrador") ?>></td>
										<td></td>
										<td></td>
									</tr>

									<!-- ---------------------------------------------------------------------------- -->

									<tr class="row-sub-title">
										<td class="tab-sub-title">Coordinadores</td>
										<td><input class="sw-permiso" type="checkbox" data-toggle="toggle" data-modulo="usu_coo_lista" data-rol="Administrador" <?php echo permiso("usu_coo_lista", "Administrador") ?>></td>
										<td></td>
										<td></td>
									</tr>
									<tr class="row-item">
										<td class="tab-item">* Nuevo</td>
										<td><input class="sw-permiso" type="checkbox" data-toggle="toggle" data-modulo="usu_coo_nuevo" data-rol="Administrador" <?php echo permiso("usu_coo_nuevo", "Administrador") ?>></td>
										<td></td>
										<td></td>
									</tr>
									<tr class="row-item">
										<td class="tab-item">* Editar</td>
										<td><input class="sw-permiso" type="checkbox" data-toggle="toggle" data-modulo="usu_coo_editar" data-rol="Administrador" <?php echo permiso("usu_coo_editar", "Administrador") ?>></td>
										<td></td>
										<td></td>
									</tr>
									<tr class="row-item">
										<td class="tab-item">* Eliminar</td>
										<td><input class="sw-permiso" type="checkbox" data-toggle="toggle" data-modulo="usu_coo_eliminar" data-rol="Administrador" <?php echo permiso("usu_coo_eliminar", "Administrador") ?>></td>
										<td></td>
										<td></td>
									</tr>

									<!-- ---------------------------------------------------------------------------- -->

									<tr class="row-sub-title">
										<td class="tab-sub-title">Trabajadores</td>
										<td><input class="sw-permiso" type="checkbox" data-toggle="toggle" data-modulo="usu_tra_lista" data-rol="Administrador" <?php echo permiso("usu_tra_lista", "Administrador") ?>></td>
										<td><input class="sw-permiso" type="checkbox" data-toggle="toggle" data-modulo="usu_tra_lista" data-rol="Coordinador" <?php echo permiso("usu_tra_lista", "Coordinador") ?>></td>
										<td></td>
									</tr>
									<tr class="row-item">
										<td class="tab-item">* Nuevo</td>
										<td><input class="sw-permiso" type="checkbox" data-toggle="toggle" data-modulo="usu_tra_nuevo" data-rol="Administrador" <?php echo permiso("usu_tra_nuevo", "Administrador") ?>></td>
										<td><input class="sw-permiso" type="checkbox" data-toggle="toggle" data-modulo="usu_tra_nuevo" data-rol="Coordinador" <?php echo permiso("usu_tra_nuevo", "Coordinador") ?>></td>
										<td></td>
									</tr>
									<tr class="row-item">
										<td class="tab-item">* Editar</td>
										<td><input class="sw-permiso" type="checkbox" data-toggle="toggle" data-modulo="usu_tra_editar" data-rol="Administrador" <?php echo permiso("usu_tra_editar", "Administrador") ?>></td>
										<td><input class="sw-permiso" type="checkbox" data-toggle="toggle" data-modulo="usu_tra_editar" data-rol="Coordinador" <?php echo permiso("usu_tra_editar", "Coordinador") ?>></td>
										<td></td>
									</tr>
									<tr class="row-item">
										<td class="tab-item">* Eliminar</td>
										<td><input class="sw-permiso" type="checkbox" data-toggle="toggle" data-modulo="usu_tra_eliminar" data-rol="Administrador" <?php echo permiso("usu_tra_eliminar", "Administrador") ?>></td>
										<td><input class="sw-permiso" type="checkbox" data-toggle="toggle" data-modulo="usu_tra_eliminar" data-rol="Coordinador" <?php echo permiso("usu_tra_eliminar", "Coordinador") ?>></td>
										<td></td>
									</tr>

									<!-- ---------------------------------------------------------------------------- -->

									<tr class="row-title">
										<td class="tab-title">CENTROS DE TRABAJO</td>
										<td><input class="sw-permiso" type="checkbox" data-toggle="toggle" data-modulo="cen" data-rol="Administrador" <?php echo permiso("cen", "Administrador") ?>></td>
										<td><input class="sw-permiso" type="checkbox" data-toggle="toggle" data-modulo="cen" data-rol="Coordinador" <?php echo permiso("cen", "Coordinador") ?>></td>
										<td></td>
									</tr>
									<tr class="row-sub-title">
										<td class="tab-sub-title">Nuevo centro de trabajo</td>
										<td><input class="sw-permiso" type="checkbox" data-toggle="toggle" data-modulo="cen_nuevo" data-rol="Administrador" <?php echo permiso("cen_nuevo", "Administrador") ?>></td>
										<td><input class="sw-permiso" type="checkbox" data-toggle="toggle" data-modulo="cen_nuevo" data-rol="Coordinador" <?php echo permiso("cen_nuevo", "Coordinador") ?>></td>
										<td></td>
									</tr>
									<tr class="row-sub-title">
										<td class="tab-sub-title">Lista de centros de trabajo</td>
										<td><input class="sw-permiso" type="checkbox" data-toggle="toggle" data-modulo="cen_lista" data-rol="Administrador" <?php echo permiso("cen_lista", "Administrador") ?>></td>
										<td><input class="sw-permiso" type="checkbox" data-toggle="toggle" data-modulo="cen_lista" data-rol="Coordinador" <?php echo permiso("cen_lista", "Coordinador") ?>></td>
										<td></td>
									</tr>
									<tr class="row-item">
										<td class="tab-item">* Editar</td>
										<td><input class="sw-permiso" type="checkbox" data-toggle="toggle" data-modulo="cen_editar" data-rol="Administrador" <?php echo permiso("cen_editar", "Administrador") ?>></td>
										<td><input class="sw-permiso" type="checkbox" data-toggle="toggle" data-modulo="cen_editar" data-rol="Coordinador" <?php echo permiso("cen_editar", "Coordinador") ?>></td>
										<td></td>
									</tr>
									<tr class="row-item">
										<td class="tab-item">* Eliminar</td>
										<td><input class="sw-permiso" type="checkbox" data-toggle="toggle" data-modulo="cen_eliminar" data-rol="Administrador" <?php echo permiso("cen_eliminar", "Administrador") ?>></td>
										<td><input class="sw-permiso" type="checkbox" data-toggle="toggle" data-modulo="cen_eliminar" data-rol="Coordinador" <?php echo permiso("cen_eliminar", "Coordinador") ?>></td>
										<td></td>
									</tr>






									<tr class="row-title">
										<td class="tab-title">CLIENTES</td>
										<td><input class="sw-permiso" type="checkbox" data-toggle="toggle" data-modulo="cli" data-rol="Administrador" <?php echo permiso("cli", "Administrador") ?>></td>
										<td><input class="sw-permiso" type="checkbox" data-toggle="toggle" data-modulo="cli" data-rol="Coordinador" <?php echo permiso("cli", "Coordinador") ?>></td>
										<td></td>
									</tr>
									<tr class="row-sub-title">
										<td class="tab-sub-title">Nuevo cliente</td>
										<td><input class="sw-permiso" type="checkbox" data-toggle="toggle" data-modulo="cli_nuevo" data-rol="Administrador" <?php echo permiso("cli_nuevo", "Administrador") ?>></td>
										<td><input class="sw-permiso" type="checkbox" data-toggle="toggle" data-modulo="cli_nuevo" data-rol="Coordinador" <?php echo permiso("cli_nuevo", "Coordinador") ?>></td>
										<td></td>
									</tr>
									<tr class="row-sub-title">
										<td class="tab-sub-title">Lista de clientes</td>
										<td><input class="sw-permiso" type="checkbox" data-toggle="toggle" data-modulo="cli_lista" data-rol="Administrador" <?php echo permiso("cli_lista", "Administrador") ?>></td>
										<td><input class="sw-permiso" type="checkbox" data-toggle="toggle" data-modulo="cli_lista" data-rol="Coordinador" <?php echo permiso("cli_lista", "Coordinador") ?>></td>
										<td></td>
									</tr>
									<tr class="row-item">
										<td class="tab-item">* Editar</td>
										<td><input class="sw-permiso" type="checkbox" data-toggle="toggle" data-modulo="cli_editar" data-rol="Administrador" <?php echo permiso("cli_editar", "Administrador") ?>></td>
										<td><input class="sw-permiso" type="checkbox" data-toggle="toggle" data-modulo="cli_editar" data-rol="Coordinador" <?php echo permiso("cli_editar", "Coordinador") ?>></td>
										<td></td>
									</tr>
									<tr class="row-item">
										<td class="tab-item">* Eliminar</td>
										<td><input class="sw-permiso" type="checkbox" data-toggle="toggle" data-modulo="cli_eliminar" data-rol="Administrador" <?php echo permiso("cli_eliminar", "Administrador") ?>></td>
										<td><input class="sw-permiso" type="checkbox" data-toggle="toggle" data-modulo="cli_eliminar" data-rol="Coordinador" <?php echo permiso("cli_eliminar", "Coordinador") ?>></td>
										<td></td>
									</tr>






									<tr class="row-title">
										<td class="tab-title">PROYECTOS</td>
										<td><input class="sw-permiso" type="checkbox" data-toggle="toggle" data-modulo="pro" data-rol="Administrador" <?php echo permiso("pro", "Administrador") ?>></td>
										<td><input class="sw-permiso" type="checkbox" data-toggle="toggle" data-modulo="pro" data-rol="Coordinador" <?php echo permiso("pro", "Coordinador") ?>></td>
										<td><input class="sw-permiso" type="checkbox" data-toggle="toggle" data-modulo="pro" data-rol="Trabajador" <?php echo permiso("pro", "Trabajador") ?>></td>
									</tr>
									<tr class="row-sub-title">
										<td class="tab-sub-title">Nuevo proyecto</td>
										<td><input class="sw-permiso" type="checkbox" data-toggle="toggle" data-modulo="pro_nuevo" data-rol="Administrador" <?php echo permiso("pro_nuevo", "Administrador") ?>></td>
										<td><input class="sw-permiso" type="checkbox" data-toggle="toggle" data-modulo="pro_nuevo" data-rol="Coordinador" <?php echo permiso("pro_nuevo", "Coordinador") ?>></td>
										<td></td>
									</tr>
									<tr class="row-sub-title">
										<td class="tab-sub-title">Lista de proyectos</td>
										<td><input class="sw-permiso" type="checkbox" data-toggle="toggle" data-modulo="pro_lista" data-rol="Administrador" <?php echo permiso("pro_lista", "Administrador") ?>></td>
										<td><input class="sw-permiso" type="checkbox" data-toggle="toggle" data-modulo="pro_lista" data-rol="Coordinador" <?php echo permiso("pro_lista", "Coordinador") ?>></td>
										<td><input class="sw-permiso" type="checkbox" data-toggle="toggle" data-modulo="pro_lista" data-rol="Trabajador" <?php echo permiso("pro_lista", "Trabajador") ?>></td>
									</tr>
									<tr class="row-item">
										<td class="tab-item">* Editar</td>
										<td><input class="sw-permiso" type="checkbox" data-toggle="toggle" data-modulo="pro_editar" data-rol="Administrador" <?php echo permiso("pro_editar", "Administrador") ?>></td>
										<td><input class="sw-permiso" type="checkbox" data-toggle="toggle" data-modulo="pro_editar" data-rol="Coordinador" <?php echo permiso("pro_editar", "Coordinador") ?>></td>
										<td></td>
									</tr>
									<tr class="row-item">
										<td class="tab-item">* Eliminar</td>
										<td><input class="sw-permiso" type="checkbox" data-toggle="toggle" data-modulo="pro_eliminar" data-rol="Administrador" <?php echo permiso("pro_eliminar", "Administrador") ?>></td>
										<td><input class="sw-permiso" type="checkbox" data-toggle="toggle" data-modulo="pro_eliminar" data-rol="Coordinador" <?php echo permiso("pro_eliminar", "Coordinador") ?>></td>
										<td></td>
									</tr>





									<tr class="row-title">
										<td class="tab-title">EVENTOS</td>
										<td><input class="sw-permiso" type="checkbox" data-toggle="toggle" data-modulo="eve" data-rol="Administrador" <?php echo permiso("eve", "Administrador") ?>></td>
										<td><input class="sw-permiso" type="checkbox" data-toggle="toggle" data-modulo="eve" data-rol="Coordinador" <?php echo permiso("eve", "Coordinador") ?>></td>
										<td><input class="sw-permiso" type="checkbox" data-toggle="toggle" data-modulo="eve" data-rol="Trabajador" <?php echo permiso("eve", "Trabajador") ?>></td>
									</tr>
									<tr class="row-sub-title">
										<td class="tab-sub-title">Nuevo evento</td>
										<td><input class="sw-permiso" type="checkbox" data-toggle="toggle" data-modulo="eve_nuevo" data-rol="Administrador" <?php echo permiso("eve_nuevo", "Administrador") ?>></td>
										<td><input class="sw-permiso" type="checkbox" data-toggle="toggle" data-modulo="eve_nuevo" data-rol="Coordinador" <?php echo permiso("eve_nuevo", "Coordinador") ?>></td>
										<td></td>
									</tr>
									<tr class="row-sub-title">
										<td class="tab-sub-title">Lista de eventos</td>
										<td><input class="sw-permiso" type="checkbox" data-toggle="toggle" data-modulo="eve_lista" data-rol="Administrador" <?php echo permiso("eve_lista", "Administrador") ?>></td>
										<td><input class="sw-permiso" type="checkbox" data-toggle="toggle" data-modulo="eve_lista" data-rol="Coordinador" <?php echo permiso("eve_lista", "Coordinador") ?>></td>
										<td></td>
									</tr>
									<tr class="row-item">
										<td class="tab-item">* Editar</td>
										<td><input class="sw-permiso" type="checkbox" data-toggle="toggle" data-modulo="eve_editar" data-rol="Administrador" <?php echo permiso("eve_editar", "Administrador") ?>></td>
										<td><input class="sw-permiso" type="checkbox" data-toggle="toggle" data-modulo="eve_editar" data-rol="Coordinador" <?php echo permiso("eve_editar", "Coordinador") ?>></td>
										<td></td>
									</tr>
									<tr class="row-item">
										<td class="tab-item">* Eliminar</td>
										<td><input class="sw-permiso" type="checkbox" data-toggle="toggle" data-modulo="eve_eliminar" data-rol="Administrador" <?php echo permiso("eve_eliminar", "Administrador") ?>></td>
										<td><input class="sw-permiso" type="checkbox" data-toggle="toggle" data-modulo="eve_eliminar" data-rol="Coordinador" <?php echo permiso("eve_eliminar", "Coordinador") ?>></td>
										<td></td>
									</tr>
									<tr class="row-sub-title">
										<td class="tab-sub-title">Mis eventos</td>
										<td></td>
										<td></td>
										<td><input class="sw-permiso" type="checkbox" data-toggle="toggle" data-modulo="eve_mi_lista" data-rol="Trabajador" <?php echo permiso("eve_mi_lista", "Trabajador") ?>></td>
									</tr>






<!--
									<tr class="row-title">
										<td class="tab-title">REPORTES</td>
										<td><input class="sw-permiso" type="checkbox" data-toggle="toggle" data-modulo="rep" data-rol="Administrador" <?php echo permiso("rep", "Administrador") ?>></td>
										<td><input class="sw-permiso" type="checkbox" data-toggle="toggle" data-modulo="rep" data-rol="Coordinador" <?php echo permiso("rep", "Coordinador") ?>></td>
										<td><input class="sw-permiso" type="checkbox" data-toggle="toggle" data-modulo="rep" data-rol="Trabajador" <?php echo permiso("rep", "Trabajador") ?>></td>
									</tr>
								-->


									<tr class="row-title">
										<td class="tab-title">CONFIGURACIONES</td>
										<td><input class="sw-permiso" type="checkbox" data-toggle="toggle" data-modulo="config" data-rol="Administrador" <?php echo permiso("config", "Administrador") ?>></td>
										<td><input class="sw-permiso" type="checkbox" data-toggle="toggle" data-modulo="config" data-rol="Coordinador" <?php echo permiso("config", "Coordinador") ?>></td>
										<td></td>
										
									</tr>
									<tr class="row-sub-title">
										<td class="tab-sub-title">Institución</td>
										<td><input class="sw-permiso" type="checkbox" data-toggle="toggle" data-modulo="institucion" data-rol="Administrador" <?php echo permiso("institucion", "Administrador") ?>></td>
										<td><input class="sw-permiso" type="checkbox" data-toggle="toggle" data-modulo="institucion" data-rol="Coordinador" <?php echo permiso("institucion", "Coordinador") ?>></td>
										<td></td>
										
									</tr>

									<!-- ---------------------------------------------------------------------------- -->

									<tr class="row-sub-title">
										<td class="tab-sub-title">Categorias</td>
										<td><input class="sw-permiso" type="checkbox" data-toggle="toggle" data-modulo="cat_lista" data-rol="Administrador" <?php echo permiso("cat_lista", "Administrador") ?>></td>
										<td><input class="sw-permiso" type="checkbox" data-toggle="toggle" data-modulo="cat_lista" data-rol="Coordinador" <?php echo permiso("cat_lista", "Coordinador") ?>></td>
										<td></td>
									</tr>
									<tr class="row-item">
										<td class="tab-item">* Categoría nueva</td>
										<td><input class="sw-permiso" type="checkbox" data-toggle="toggle" data-modulo="cat_nuevo" data-rol="Administrador" <?php echo permiso("cat_nuevo", "Administrador") ?>></td>
										<td><input class="sw-permiso" type="checkbox" data-toggle="toggle" data-modulo="cat_nuevo" data-rol="Coordinador" <?php echo permiso("cat_nuevo", "Coordinador") ?>></td>
										<td></td>
									</tr>
									<tr class="row-item">
										<td class="tab-item">* Categoría Editar</td>
										<td><input class="sw-permiso" type="checkbox" data-toggle="toggle" data-modulo="cat_editar" data-rol="Administrador" <?php echo permiso("cat_editar", "Administrador") ?>></td>
										<td><input class="sw-permiso" type="checkbox" data-toggle="toggle" data-modulo="cat_editar" data-rol="Coordinador" <?php echo permiso("cat_editar", "Coordinador") ?>></td>
										<td></td>
									</tr>
									<tr class="row-item">
										<td class="tab-item">* Categoría Eliminar</td>
										<td><input class="sw-permiso" type="checkbox" data-toggle="toggle" data-modulo="cat_eliminar" data-rol="Administrador" <?php echo permiso("cat_eliminar", "Administrador") ?>></td>
										<td><input class="sw-permiso" type="checkbox" data-toggle="toggle" data-modulo="cat_eliminar" data-rol="Coordinador" <?php echo permiso("cat_eliminar", "Coordinador") ?>></td>
										<td></td>
									</tr>

									<!-- ---------------------------------------------------------------------------- -->

									<tr class="row-sub-title">
										<td class="tab-sub-title">Tareas</td>
										<td><input class="sw-permiso" type="checkbox" data-toggle="toggle" data-modulo="tar_lista" data-rol="Administrador" <?php echo permiso("tar_lista", "Administrador") ?>></td>
										<td><input class="sw-permiso" type="checkbox" data-toggle="toggle" data-modulo="tar_lista" data-rol="Coordinador" <?php echo permiso("tar_lista", "Coordinador") ?>></td>
										<td></td>
									</tr>
									<tr class="row-item">
										<td class="tab-item">* Tarea Nueva</td>
										<td><input class="sw-permiso" type="checkbox" data-toggle="toggle" data-modulo="tar_nuevo" data-rol="Administrador" <?php echo permiso("tar_nuevo", "Administrador") ?>></td>
										<td><input class="sw-permiso" type="checkbox" data-toggle="toggle" data-modulo="tar_nuevo" data-rol="Coordinador" <?php echo permiso("tar_nuevo", "Coordinador") ?>></td>
										<td></td>
									</tr>
									<tr class="row-item">
										<td class="tab-item">* Tarea Editar</td>
										<td><input class="sw-permiso" type="checkbox" data-toggle="toggle" data-modulo="tar_editar" data-rol="Administrador" <?php echo permiso("tar_editar", "Administrador") ?>></td>
										<td><input class="sw-permiso" type="checkbox" data-toggle="toggle" data-modulo="tar_editar" data-rol="Coordinador" <?php echo permiso("tar_editar", "Coordinador") ?>></td>
										<td></td>
									</tr>
									<tr class="row-item">
										<td class="tab-item">* Tarea Eliminar</td>
										<td><input class="sw-permiso" type="checkbox" data-toggle="toggle" data-modulo="tar_eliminar" data-rol="Administrador" <?php echo permiso("tar_eliminar", "Administrador") ?>></td>
										<td><input class="sw-permiso" type="checkbox" data-toggle="toggle" data-modulo="tar_eliminar" data-rol="Coordinador" <?php echo permiso("tar_eliminar", "Coordinador") ?>></td>
										<td></td>
									</tr>

									<!-- ---------------------------------------------------------------------------- -->

									<tr class="row-sub-title">
										<td class="tab-sub-title">Feriados</td>
										<td><input class="sw-permiso" type="checkbox" data-toggle="toggle" data-modulo="fer_lista" data-rol="Administrador" <?php echo permiso("fer_lista", "Administrador") ?>></td>
										<td><input class="sw-permiso" type="checkbox" data-toggle="toggle" data-modulo="fer_lista" data-rol="Coordinador" <?php echo permiso("fer_lista", "Coordinador") ?>></td>
										<td></td>
									</tr>
									<tr class="row-item">
										<td class="tab-item">* Feriado Nuevo</td>
										<td><input class="sw-permiso" type="checkbox" data-toggle="toggle" data-modulo="fer_nuevo" data-rol="Administrador" <?php echo permiso("fer_nuevo", "Administrador") ?>></td>
										<td><input class="sw-permiso" type="checkbox" data-toggle="toggle" data-modulo="fer_nuevo" data-rol="Coordinador" <?php echo permiso("fer_nuevo", "Coordinador") ?>></td>
										<td></td>
									</tr>
									<tr class="row-item">
										<td class="tab-item">* Feriado Editar</td>
										<td><input class="sw-permiso" type="checkbox" data-toggle="toggle" data-modulo="fer_editar" data-rol="Administrador" <?php echo permiso("fer_editar", "Administrador") ?>></td>
										<td><input class="sw-permiso" type="checkbox" data-toggle="toggle" data-modulo="fer_editar" data-rol="Coordinador" <?php echo permiso("fer_editar", "Coordinador") ?>></td>
										<td></td>
									</tr>
									<tr class="row-item">
										<td class="tab-item">* Feriado Eliminar</td>
										<td><input class="sw-permiso" type="checkbox" data-toggle="toggle" data-modulo="fer_eliminar" data-rol="Administrador" <?php echo permiso("fer_eliminar", "Administrador") ?>></td>
										<td><input class="sw-permiso" type="checkbox" data-toggle="toggle" data-modulo="fer_eliminar" data-rol="Coordinador" <?php echo permiso("fer_eliminar", "Coordinador") ?>></td>
										<td></td>
									</tr>

									<!-- ---------------------------------------------------------------------------- -->

									<tr class="row-sub-title">
										<td class="tab-sub-title">Provincias</td>
										<td><input class="sw-permiso" type="checkbox" data-toggle="toggle" data-modulo="prov_lista" data-rol="Administrador" <?php echo permiso("prov_lista", "Administrador") ?>></td>
										<td><input class="sw-permiso" type="checkbox" data-toggle="toggle" data-modulo="prov_lista" data-rol="Coordinador" <?php echo permiso("prov_lista", "Coordinador") ?>></td>
										<td></td>
									</tr>
									<tr class="row-item">
										<td class="tab-item">* Provincia Nueva</td>
										<td><input class="sw-permiso" type="checkbox" data-toggle="toggle" data-modulo="prov_nuevo" data-rol="Administrador" <?php echo permiso("prov_nuevo", "Administrador") ?>></td>
										<td><input class="sw-permiso" type="checkbox" data-toggle="toggle" data-modulo="prov_nuevo" data-rol="Coordinador" <?php echo permiso("prov_nuevo", "Coordinador") ?>></td>
										<td></td>
									</tr>
									<tr class="row-item">
										<td class="tab-item">* Provincia Editar</td>
										<td><input class="sw-permiso" type="checkbox" data-toggle="toggle" data-modulo="prov_editar" data-rol="Administrador" <?php echo permiso("prov_editar", "Administrador") ?>></td>
										<td><input class="sw-permiso" type="checkbox" data-toggle="toggle" data-modulo="prov_editar" data-rol="Coordinador" <?php echo permiso("prov_editar", "Coordinador") ?>></td>
										<td></td>
									</tr>
									<tr class="row-item">
										<td class="tab-item">* Provincia Eliminar</td>
										<td><input class="sw-permiso" type="checkbox" data-toggle="toggle" data-modulo="prov_eliminar" data-rol="Administrador" <?php echo permiso("prov_eliminar", "Administrador") ?>></td>
										<td><input class="sw-permiso" type="checkbox" data-toggle="toggle" data-modulo="prov_eliminar" data-rol="Coordinador" <?php echo permiso("prov_eliminar", "Coordinador") ?>></td>
										<td></td>
									</tr>

									<!-- ---------------------------------------------------------------------------- -->

									<tr class="row-sub-title">
										<td class="tab-sub-title">Localidades</td>
										<td><input class="sw-permiso" type="checkbox" data-toggle="toggle" data-modulo="loc_lista" data-rol="Administrador" <?php echo permiso("loc_lista", "Administrador") ?>></td>
										<td><input class="sw-permiso" type="checkbox" data-toggle="toggle" data-modulo="loc_lista" data-rol="Coordinador" <?php echo permiso("loc_lista", "Coordinador") ?>></td>
										<td></td>
									</tr>
									<tr class="row-item">
										<td class="tab-item">* Localidad Nueva</td>
										<td><input class="sw-permiso" type="checkbox" data-toggle="toggle" data-modulo="loc_nuevo" data-rol="Administrador" <?php echo permiso("loc_nuevo", "Administrador") ?>></td>
										<td><input class="sw-permiso" type="checkbox" data-toggle="toggle" data-modulo="loc_nuevo" data-rol="Coordinador" <?php echo permiso("loc_nuevo", "Coordinador") ?>></td>
										<td></td>
									</tr>
									<tr class="row-item">
										<td class="tab-item">* Localidad Editar</td>
										<td><input class="sw-permiso" type="checkbox" data-toggle="toggle" data-modulo="loc_editar" data-rol="Administrador" <?php echo permiso("loc_editar", "Administrador") ?>></td>
										<td><input class="sw-permiso" type="checkbox" data-toggle="toggle" data-modulo="loc_editar" data-rol="Coordinador" <?php echo permiso("loc_editar", "Coordinador") ?>></td>
										<td></td>
									</tr>
									<tr class="row-item">
										<td class="tab-item">* Localidad Eliminar</td>
										<td><input class="sw-permiso" type="checkbox" data-toggle="toggle" data-modulo="loc_eliminar" data-rol="Administrador" <?php echo permiso("loc_eliminar", "Administrador") ?>></td>
										<td><input class="sw-permiso" type="checkbox" data-toggle="toggle" data-modulo="loc_eliminar" data-rol="Coordinador" <?php echo permiso("loc_eliminar", "Coordinador") ?>></td>
										<td></td>
									</tr>

									<!-- ---------------------------------------------------------------------------- -->

									<tr class="row-sub-title">
										<td class="tab-sub-title">Horquilla horarias</td>
										<td><input class="sw-permiso" type="checkbox" data-toggle="toggle" data-modulo="hor_lista" data-rol="Administrador" <?php echo permiso("hor_lista", "Administrador") ?>></td>
										<td><input class="sw-permiso" type="checkbox" data-toggle="toggle" data-modulo="hor_lista" data-rol="Coordinador" <?php echo permiso("hor_lista", "Coordinador") ?>></td>
										<td></td>
									</tr>
									<tr class="row-item">
										<td class="tab-item">* Horquilla Nueva</td>
										<td><input class="sw-permiso" type="checkbox" data-toggle="toggle" data-modulo="hor_nuevo" data-rol="Administrador" <?php echo permiso("hor_nuevo", "Administrador") ?>></td>
										<td><input class="sw-permiso" type="checkbox" data-toggle="toggle" data-modulo="hor_nuevo" data-rol="Coordinador" <?php echo permiso("hor_nuevo", "Coordinador") ?>></td>
										<td></td>
									</tr>
									<tr class="row-item">
										<td class="tab-item">* Horquilla Editar</td>
										<td><input class="sw-permiso" type="checkbox" data-toggle="toggle" data-modulo="hor_editar" data-rol="Administrador" <?php echo permiso("hor_editar", "Administrador") ?>></td>
										<td><input class="sw-permiso" type="checkbox" data-toggle="toggle" data-modulo="hor_editar" data-rol="Coordinador" <?php echo permiso("hor_editar", "Coordinador") ?>></td>
										<td></td>
									</tr>
									<tr class="row-item">
										<td class="tab-item">* Horquilla Eliminar</td>
										<td><input class="sw-permiso" type="checkbox" data-toggle="toggle" data-modulo="hor_eliminar" data-rol="Administrador" <?php echo permiso("hor_eliminar", "Administrador") ?>></td>
										<td><input class="sw-permiso" type="checkbox" data-toggle="toggle" data-modulo="hor_eliminar" data-rol="Coordinador" <?php echo permiso("hor_eliminar", "Coordinador") ?>></td>
										<td></td>
									</tr>

									<!-- ---------------------------------------------------------------------------- -->
									
									<tr class="row-sub-title">
										<td class="tab-sub-title">Gestión de permisos</td>
										<td><input class="sw-permiso" type="checkbox" data-toggle="toggle" data-modulo="config_permiso" data-rol="Administrador" <?php echo permiso("config_permiso", "Administrador") ?>></td>
										<td><input class="sw-permiso" type="checkbox" data-toggle="toggle" data-modulo="config_permiso" data-rol="Coordinador" <?php echo permiso("config_permiso", "Coordinador") ?>></td>
										<td></td>
									</tr>


								</tbody>
								</table>
							</div>
						</div>

						<!-- /Validation Example 1 -->
					</div>
				</div>
			</div>
			<!-- /.container -->

		</div>
	</div>
