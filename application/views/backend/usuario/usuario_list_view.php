	<?php require (APPPATH."views/layouts/backend/header.php"); ?>

	<div id="container">

		<?php require (APPPATH."views/layouts/backend/sidebarleft.php"); ?>

		<div id="content">
			<div class="container">

				<?php require (APPPATH."views/layouts/backend/crumbs-page-header.php"); ?>

				<!--=== Page Content ===-->
				<!--=== Managed Tables ===-->

				<!--=== Normal ===-->
				<div class="row">
					<div class="col-md-12">
						<?php echo $this->message->display(); ?>
						<div class="widget box">
							<div class="widget-header">
								
								<div class="toolbar left">
									<?php echo uri_current_user("usuario", $this->uri->segment("4"), $this->usuario_modelo, 'index', $this->uri->segment('5')); ?>
								</div>
							
								<?php  
								$aux_nuevo = false;
								$aux_editar = false;
								$aux_eliminar = false;
								switch($usu_tipo){
									case "Administrador":
										if(verificarPermiso("usu_adm_nuevo")) $aux_nuevo = true;
										if(verificarPermiso("usu_adm_editar")) $aux_editar = true;
										if(verificarPermiso("usu_adm_eliminar")) $aux_eliminar = true;
									break;
									case "Coordinador":
										if(verificarPermiso("usu_coo_nuevo")) $aux_nuevo = true;
										if(verificarPermiso("usu_coo_editar")) $aux_editar = true;
										if(verificarPermiso("usu_coo_eliminar")) $aux_eliminar = true;
									break;
									case "Trabajador":
										if(verificarPermiso("usu_tra_nuevo")) $aux_nuevo = true;
										if(verificarPermiso("usu_tra_editar")) $aux_editar = true;
										if(verificarPermiso("usu_tra_eliminar")) $aux_eliminar = true;
									break;
								}
								?>

								<?php if($aux_nuevo): ?>
								<div class="toolbar">
									<a href="<?php echo base_url()."backend/usuario/insertar/".$usu_tipo; ?>" class="btn btn-primary btn-info mb-2">Nuevo</a>
								</div>
								<?php endif; ?>

							</div>
							<div class="widget-content">

								<form class="table-responsive" name="formdelete" id="formdelete" action="<?php echo base_url() ?>backend/usuario/eliminar/null/null/<?php echo $usu_tipo; ?>" method="post">

									<table class="table table-striped table-bordered table-hover table-checkable datatable" data-display-length="50">
										<thead>
											<tr>
												<th class="checkbox-column">
													<input type="checkbox" class="uniform">
												</th>
												<th>ID</th>
												<th>Nombre Completo</th>
												<th>User name</th>
												<th>DNI</th>
												<th>Email</th>
												<th>Teléfono - Móvil</th>
												<th>Tipo</th>
												<th>Estado</th>
												<th>Fecha de Alta</th>
												
												<th class="align-center">Acción</th>
												
											</tr>
										</thead>
										<tbody>
											<?php foreach($lista as $valor): ?>
												
													<tr>
														<td class="checkbox-column">
															<input name="seleccion[]" value="<?php echo $valor->usu_id ?>" type="checkbox" class="uniform checkeados">
														</td>
														<td><?php echo $valor->usu_id; ?></td>
														<td style="padding-right:17px !important;position: relative;">
															<?php if($aux_editar or $this->session->userdata('usu_tipo_actual') == "Super_admin"): ?>
															<a href="<?php echo base_url() ?>backend/usuario/editar/<?php echo $valor->usu_id ?>/<?php echo $usu_tipo; ?>">
															<?php endif; ?>
																<?php echo $valor->usu_ap ?> <?php echo $valor->usu_am ?> <?php echo $valor->usu_nombre ?>
															<?php if($aux_editar or $this->session->userdata('usu_tipo_actual') == "Super_admin"): ?>
															</a>
															<?php endif; ?>
															<?php if($valor->usu_online == 1):  ?>
																<span class="icon-online" title="Usuario Online"></span>
															<?php endif; ?>
														</td>
														<td><?php echo $valor->usu_username ?></td>
														<td><?php echo $valor->usu_dni; ?></td>
														<td><?php echo $valor->usu_email ?></td>
														<td><?php echo $valor->usu_telefono."  ".$valor->usu_celular ?></td>
														<td><?php echo $valor->usu_tipo ?></td>
														<td>
															<?php if($valor->usu_estado == 1): ?>
																<span class="icon-check" title="Activo"></span>
															<?php elseif($valor->usu_estado == 0): ?>
																<span class="icon-check-empty" title="Inactivo"></span>
															<?php elseif($valor->usu_estado == 3): ?>
															<span class="label label-danger">Inhabilitado</span>
															<?php endif; ?>
														</td>
														<td><?php echo date("Y-m-d", strtotime($valor->usu_fecha_registro)); ?></td>
														
														<td class="align-center">
															<ul class="table-controls">
															<?php if($aux_editar or $this->session->userdata('usu_tipo_actual') == "Super_admin"): ?>
																<li><a href="<?php echo base_url() ?>backend/usuario/editar/<?php echo $valor->usu_id ?>/<?php echo $usu_tipo ?>" class="bs-tooltip" title="Editar"><i class="icon-pencil"></i></a> </li>
															<?php endif; ?>
															
																<?php if($aux_eliminar or $this->session->userdata('usu_tipo_actual') == "Super_admin"): ?>
																	<?php if($this->uri->segment(4) !== '0'): ?>
																	<li><a href="<?php echo base_url() ?>backend/usuario/eliminar/LOG/<?php echo $valor->usu_id ?>/<?php echo $usu_tipo ?>" class="bs-tooltip confirm-dialog-inactive" title="Desactivar"><i class="icon-trash"></i></a> </li>
																	<?php else: ?>
																	<li><a href="<?php echo base_url() ?>backend/usuario/eliminar/DEL/<?php echo $valor->usu_id ?>/<?php echo $usu_tipo ?>" class="bs-tooltip confirm-dialog-delete" title="Eliminar definitivamente"><i class="icon-remove"></i></a> </li>
																	<?php endif; ?>
																<?php endif; ?>
															
															</ul>
														</td>
														
													</tr>
												
											<?php endforeach; ?>
										</tbody>
									</table>
									<?php if($aux_eliminar): ?>
										<?php if($this->uri->segment(4) !== '0'): ?>
										<button name="btn_eliminar" class="list-group-item confirm-dialog-inactive-various" data-modal="true" data-text="" data-layout="top" title="Desactivar registros seleccionados">Desactivar</button>
										<?php else: ?>
										<button name="btn_eliminar" class="list-group-item confirm-dialog-delete-various" data-modal="true" data-text="" data-layout="top" title="Elimianar registros seleccionados">Eliminar definitivamente</button>
										<?php endif; ?>
									<?php endif; ?>
								</form>

							</div>
						</div>
					</div>
				</div>
				<!-- /Normal -->


			</div>
			<!-- /.container -->

		</div>
	</div>
