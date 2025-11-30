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
									<?php echo uri_current("categorias", $this->uri->segment("4"), $this->categoria_modelo); ?>
								</div>
								<div class="toolbar no-padding">
									<div class="btn-group">
										<span class="btn btn-xs widget-collapse"><i class="icon-angle-down"></i></span>
									</div>
								</div>

								<?php if(verificarPermiso("cat_nuevo")): ?>
								<div class="toolbar" style="margin-right: 25px; ">
									<a href="<?php echo base_url()."backend/categorias/insertar/"; ?>" class="btn btn-primary btn-info mb-2">Nueva Categoría</a>
								</div>
								<?php endif; ?>
								
							</div>
							<div class="widget-content">

								<form class="table-responsive" name="formdelete" id="formdelete" action="<?php echo base_url() ?>backend/categorias/eliminar" method="post">
									<table class="table table-striped table-bordered table-hover table-checkable datatable" data-display-length="25">
										<thead>
											<tr>
												<th class="checkbox-column">
													<input type="checkbox" class="uniform">
												</th>
												<th>ID</th>
												<th>Nombre</th>
												<th class="align-center">Sigla</th>
												
												<th class="align-center">Estado</th>
												<th class="align-center">Acción</th>
											</tr>
										</thead>
										<tbody>
											<?php foreach($lista as $valor): ?>
											<tr>
												<td class="checkbox-column">
													<input name="seleccion[]" value="<?php echo $valor->cat_id ?>" type="checkbox" class="uniform checkeados">
												</td>
												<td><?php echo $valor->cat_id; ?></td>
												<td>
													<?php if(verificarPermiso("cat_nuevo")): ?>
													<a href="<?php echo base_url() ?>backend/categorias/editar/<?php echo $valor->cat_id ?>">
													<?php endif; ?>
														<?php echo $valor->cat_name ?>
													<?php if(verificarPermiso("cat_nuevo")): ?>
													</a>
													<?php endif; ?>
												</td>

												<td class="align-center"><?php echo $valor->cat_sigla; ?></td>
												
												<td class="align-center">
													<?php if($valor->cat_state == 1): ?>
														<span class="icon-check"></span>
													<?php else: ?>
														<span class="icon-check-empty"></span>
													<?php endif; ?>
												</td>
												
												<td class="text-center" >
													<ul class="table-controls">
														<?php if(verificarPermiso("cat_editar")): ?>
														<li><a href="<?php echo base_url() ?>backend/categorias/editar/<?php echo $valor->cat_id ?>" class="bs-tooltip" title="Editar"><i class="icon-pencil"></i></a> </li>
														<?php endif; ?>
													
														<?php if(verificarPermiso("cat_eliminar")): ?>
															<?php if($this->uri->segment(4) !== '0'): ?>
																<li><a href="<?php echo base_url() ?>backend/categorias/eliminar/LOG/<?php echo $valor->cat_id ?>" class="bs-tooltip confirm-dialog-inactive" title="Desactivar"><i class="icon-trash"></i></a> </li>
															<?php else: ?>
																<li><a href="<?php echo base_url() ?>backend/categorias/eliminar/DEL/<?php echo $valor->cat_id ?>" class="bs-tooltip confirm-dialog-delete" title="Eliminar definitivamente"><i class="icon-remove"></i></a> </li>
															<?php endif; ?>
														<?php endif; ?>
													</ul>
												</td>
												
											</tr>
											<?php endforeach; ?>
										</tbody>
									</table>
									<?php if(verificarPermiso("cat_eliminar")): ?>
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
