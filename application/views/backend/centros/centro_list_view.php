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
									<?php echo uri_current("centros", $this->uri->segment("4"), $this->centro_modelo); ?>
								</div>

								<?php if(verificarPermiso("cen_nuevo")): ?>
								<div class="toolbar">
									<a href="<?php echo base_url()."backend/centros/insertar/"; ?>" class="btn btn-primary btn-info">Nuevo</a>
								</div>
								<?php endif; ?>
							</div>
							<div class="widget-content">

								<form class="table-responsive" name="formdelete" id="formdelete" action="<?php echo base_url() ?>backend/centros/eliminar" method="post">

									<table class="table table-striped table-bordered table-hover table-checkable datatable" data-display-length="25">
										<thead>
											<tr>
												<th class="checkbox-column">
													<input type="checkbox" class="uniform">
												</th>
												<th>ID</th>
												<th>Nombre</th>
												<th>Provincia</th>
												<th>Localidad</th>
												<th>Horquilla horaria</th>
												<th class="text-center">Estado</th>
												
												<th class="align-center">Acción</th>
											
											</tr>
										</thead>
										<tbody>
											<?php foreach($lista as $valor): ?>
											<tr>
												<td class="checkbox-column">
													<input name="seleccion[]" value="<?php echo $valor->cen_id ?>" type="checkbox" class="uniform checkeados">
												</td>
												<td><?php echo $valor->cen_id; ?></td>
												<td>
													<?php if(verificarPermiso("cen_editar")): ?>
													<a href="<?php echo base_url() ?>backend/centros/editar/<?php echo $valor->cen_id ?>">
													<?php endif; ?>
														<?php echo $valor->cen_name ?>
													<?php if(verificarPermiso("cen_editar")): ?>
													</a>
													<?php endif; ?>
												</td>
												<td><?php echo $this->provincia_modelo->getId($valor->prov_id)->prov_name; ?></td>
												<td><?php echo $this->localidad_modelo->getId($valor->loc_id)->loc_name; ?></td>
												<td><?php echo $this->horquillahoraria_modelo->getId($valor->hor_id)->hor_name??""; ?></td>
												<td class="text-center">
													<?php if($valor->cen_state == 1): ?>
														<span class="icon-check"></span>
													<?php else: ?>
														<span class="icon-check-empty"></span>
													<?php endif; ?>
												</td>											
												<td class="text-center" >
													<ul class="table-controls">
														<?php if(verificarPermiso("cen_editar")): ?>
														<li><a href="<?php echo base_url() ?>backend/centros/editar/<?php echo $valor->cen_id ?>" class="bs-tooltip" title="Editar"><i class="icon-pencil"></i></a> </li>
														<?php endif; ?>
														<?php if(verificarPermiso("cen_eliminar")): ?>
															<?php if($this->uri->segment(4) !== '0'): ?>
																<li><a href="<?php echo base_url() ?>backend/centros/eliminar/LOG/<?php echo $valor->cen_id ?>" class="bs-tooltip confirm-dialog-inactive" title="Desactivar"><i class="icon-trash"></i></a> </li>
															<?php else: ?>
																<li><a href="<?php echo base_url() ?>backend/centros/eliminar/DEL/<?php echo $valor->cen_id ?>" class="bs-tooltip confirm-dialog-delete" title="Eliminar definitivamente"><i class="icon-remove"></i></a> </li>
															<?php endif; ?>
														<?php endif; ?>
													</ul>
												</td>
												
											</tr>
											<?php endforeach; ?>
										</tbody>
									</table>
									<?php if(verificarPermiso("cen_eliminar")): ?>
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
