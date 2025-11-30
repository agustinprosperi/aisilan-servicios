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
								<h4 class="left"><i class="icon-reorder"></i> <?php echo $titulo_form; ?></h4>

								<div class="toolbar no-padding">
									<div class="btn-group">
										<span class="btn btn-xs widget-collapse"><i class="icon-angle-down"></i></span>
									</div>
								</div>

								<!--<div class="toolbar" style="margin-right: 25px; ">
									<a href="<?php //echo base_url()."backend/unidad_educativa/insertar/"; ?>" class="btn btn-xs btn-info">Nuevo Registro</a>
								</div>-->
							</div>
							<div class="widget-content">

								<form name="formdelete" id="formdelete" action="<?php echo base_url() ?>backend/unidad_educativa/eliminar" method="post">

								<table class="table table-striped table-bordered table-hover table-checkable datatable" data-display-length="25">
									<thead>
										<tr>
											<th class="checkbox-column">
												<input type="checkbox" class="uniform">
											</th>
											<th>Nombre</th>
											<th>Teléfono</th>
											<th>Dirección</th>
											<th>Estado</th>
											<th class="align-center">Acción</th>
										</tr>
									</thead>
									<tbody>
										<?php foreach($unidad_educativa as $valor): ?>
										<tr>
											<td class="checkbox-column">
												<input name="seleccion[]" value="<?php echo $valor->ue_id ?>" type="checkbox" class="uniform checkeados">
											</td>
											<td>
												<a href="<?php echo base_url() ?>backend/unidad_educativa/editar/<?php echo $valor->ue_id ?>">
													<?php echo $valor->ue_nombre ?>
												</a>
											</td>

											<td><?php echo $valor->ue_telefono ?></td>
											<td><?php echo $valor->ue_direccion ?></td>

											<td>
												<?php if($valor->ue_estado == 1): ?>
													<span class="icon-check" style="cursor:pointer"></span>
												<?php else: ?>
													<span class="icon-check-empty" style="cursor:pointer"></span>
												<?php endif; ?>
											</td>

											<td class="align-center">
												<ul class="table-controls">
													<li><a href="<?php echo base_url() ?>backend/unidad_educativa/editar/<?php echo $valor->ue_id ?>" class="bs-tooltip" title="Editar"><i class="icon-pencil"></i></a> </li>
													<!--<li><a href="<?php echo base_url() ?>backend/unidad_educativa/eliminar/DEL/<?php //echo $valor->ue_id ?>" class="bs-tooltip confirm-dialog-delete" title="Eliminar definitivamente"><i class="icon-remove"></i></a>
													</li>-->

												</ul>
											</td>
										</tr>
										<?php endforeach; ?>
									</tbody>
								</table>

								<button name="btn_eliminar" class="list-group-item confirm-dialog-delete-various" data-modal="true" data-text="" data-layout="top" title="Elimianar registros seleccionados">Eliminar definitivamente</button>
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
