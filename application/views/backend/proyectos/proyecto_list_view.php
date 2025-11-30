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
									<?php echo uri_current("proyectos", $this->uri->segment("4"), $this->proyecto_modelo); ?>
								</div>

								<?php if(verificarPermiso("pro_nuevo")): ?>
								<div class="toolbar">
									<a href="<?php echo base_url()."backend/proyectos/insertar/"; ?>" class="btn btn-primary btn-info mb-2">Nuevo</a>
								</div>
								<?php endif; ?>
							</div>
							<div class="widget-content">

								<form class="table-responsive" name="formdelete" id="formdelete" action="<?php echo base_url() ?>backend/proyectos/eliminar" data-url="<?php echo base_url() ?>backend/proyectos/activar" method="post">

									<table class="table table-striped table-bordered table-hover table-checkable datatable" data-display-length="25">
										<thead>
											<tr>
												<th class="checkbox-column">
													<input type="checkbox" class="uniform">
												</th>
												<th>ID</th>
												<th width="400">Nombre</th>
												<th>Cliente</th>
												<th>Coordinador</th>
												<th># Trab.</th>
												<th class="align-center">Estado</th>
												<th class="align-center">Acción</th>
											</tr>
										</thead>
										<tbody>
											<?php foreach($lista as $valor): ?>
											<tr>
												<td class="checkbox-column">
													<input name="seleccion[]" value="<?php echo $valor->pro_id ?>" type="checkbox" class="uniform checkeados">
												</td>
												<td><?php echo $valor->pro_id; ?></td>
												<td>
													<?php if(verificarPermiso("pro_editar")): ?>
													<a href="<?php echo base_url() ?>backend/proyectos/editar/<?php echo $valor->pro_id ?>">
													<?php endif; ?>
														<?php echo $valor->pro_name ?>
													<?php if(verificarPermiso("pro_editar")): ?>
													</a>
													<?php endif; ?>
												</td>
												<td>
													<?php echo $this->cliente_modelo->getId($valor->cli_id)->cli_name??""; ?>
													<?php echo $this->cliente_modelo->getId($valor->cli_id)->cli_state==0?"<i class='fa fa-warning color-orange icon-parpadeo' title='Cliente inactivo'></i>":""; ?>
												</td>
												<td>
													<?php 
													if($valor->coo_id != '' or $valor->coo_id != NULL){
														echo $this->usuario_modelo->getId($valor->coo_id)->usu_ap??"";
														echo " "; 
														echo $this->usuario_modelo->getId($valor->coo_id)->usu_am??"";
														echo " ";
														echo $this->usuario_modelo->getId($valor->coo_id)->usu_nombre??"";
													}
													?>
													<?php echo $this->usuario_modelo->getId($valor->coo_id)->usu_estado==0?"<i class='fa fa-warning color-orange icon-parpadeo' title='Coordinador inactivo'></i>":""; ?>
												</td>
												<td class="align-center">
													<?php 
													$trabajadores = $this->proyecto_modelo->getListaTrabajadoresDeProyecto($valor->pro_id);
													echo count($trabajadores);
													?>
												</td>
												<td class="align-center">
													<?php if($valor->pro_state == 1): ?>
														<span class="icon-check"></span>
													<?php else: ?>
														<span class="icon-check-empty"></span>
													<?php endif; ?>
												</td>
												<td class="text-center">
													<ul class="table-controls">
														<?php if(verificarPermiso("pro_editar")): ?>
														<li><a href="<?php echo base_url() ?>backend/proyectos/editar/<?php echo $valor->pro_id ?>" class="bs-tooltip" title="Editar"><i class="icon-pencil"></i></a> </li>
														<?php endif; ?>
														<?php if(verificarPermiso("pro_eliminar")): ?>
															<?php if($this->uri->segment(4) !== '0'): ?>
																<li><a href="<?php echo base_url() ?>backend/proyectos/eliminar/LOG/<?php echo $valor->pro_id ?>" class="bs-tooltip confirm-dialog-inactive" title="Desactivar"><i class="icon-trash"></i></a> </li>
															<?php else: ?>
																<li><a href="<?php echo base_url() ?>backend/proyectos/eliminar/DEL/<?php echo $valor->pro_id ?>" class="bs-tooltip confirm-dialog-delete" title="Eliminar definitivamente"><i class="icon-remove"></i></a> </li>
															<?php endif; ?>
														<?php endif; ?>
													</ul>
												</td>
												
											</tr>
											<?php endforeach; ?>
										</tbody>
									</table>
									<?php if(verificarPermiso("pro_eliminar")): ?>
										<?php if($this->uri->segment(4) !== '0'): ?>
										<button name="btn_eliminar" class="list-group-item confirm-dialog-inactive-various btn-info" data-modal="true" data-text="" data-layout="top" title="Desactivar registros seleccionados">Desactivar</button>
										<?php else: ?>
										<button name="btn_eliminar" class="confirm-dialog-delete-various btn btn-danger" data-modal="true" data-text="" data-layout="top" title="Elimianar registros seleccionados">Eliminar definitivamente</button>
										<button name="" class="confirm-dialog-activar-various btn " data-modal="true" data-text="" data-layout="top" title="Activar registros seleccionados">Activar</button>
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
