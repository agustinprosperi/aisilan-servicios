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
					
						<div class="row">

								<div class="col-md-4">
									<div class="widget box">
										<div class="widget-header">
											<h4><?php echo $titulo_form; ?></h4>
										</div>
										<div class="widget-content">
											<form method="post" class="form-horizontal" id="validate_1" action="<?php echo base_url() ?>backend/horquillahoraria/<?php echo $action ?>/">
												<div class="form-group row">
													<label class="control-label col-md-6">Nombre <span class="required">*</span></label>
													<div class="col-md-6">
														<input type="text" name="hor_name" value="<?php if(isset($hor_name)) echo $hor_name ?>" class="form-control required" placeholder="Ingrese algun nombre ">
													</div>
												</div>

												<div class="form-group row">
													<label class="control-label col-md-6">Laborable día<span class="required">*</span></label>
													<div class="col-md-6">
														<input type="text" name="hor_laborable" value="<?php if(isset($hor_laborable)) echo $hor_laborable ?>" class="form-control required" placeholder="Ingrese coeficiente">
													</div>
												</div>

												<div class="form-group row">
													<label class="control-label col-md-6">Laborable noche <span class="required">*</span></label>
													<div class="col-md-6">
														<input type="text" name="hor_laborable_nocturno" value="<?php if(isset($hor_laborable_nocturno)) echo $hor_laborable_nocturno ?>" class="form-control required" placeholder="Ingrese coeficiente">
													</div>
												</div>

												<div class="form-group row">
													<label class="control-label col-md-6">Festivo día<span class="required">*</span></label>
													<div class="col-md-6">
														<input type="text" name="hor_festivo" value="<?php if(isset($hor_festivo)) echo $hor_festivo ?>" class="form-control required" placeholder="Ingrese coeficiente">
													</div>
												</div>

												<div class="form-group row">
													<label class="control-label col-md-6">Festivo noche <span class="required">*</span></label>
													<div class="col-md-6">
														<input type="text" name="hor_festivo_nocturno" value="<?php if(isset($hor_festivo_nocturno)) echo $hor_festivo_nocturno ?>" class="form-control required" placeholder="Ingrese coeficiente">
													</div>
												</div>

												<div class="form-group row">
													<?php
													if($hor_state == 1){
														$required_1 = "checked";
														$required_2 = "";
													}else{
														$required_1 = "";
														$required_2 = "checked";
													}
													?>
													<label class="control-label col-md-6">Estado</label>
													<div class="col-md-6">
														<label class="radio-inline"><input type="radio" value="1" name="hor_state" <?php echo $required_1 ?> class="uniform"> Activo</label><br>
														<label class="radio-inline"><input type="radio" value="0" name="hor_state" <?php echo $required_2 ?> class="uniform"> Inactivo</label>
														<label for="gender" class="has-error help-block" generated="true" style="display:none;"></label>
													</div>
												</div>
												
												<div class="form-actions" style="margin-top:3rem;margin-bottom:-1.5rem;">
													<?php if(verificarPermiso("hor_nuevo") or verificarPermiso("hor_editar")): ?>
													<input value="Aceptar" class="btn btn-primary btn-block" type="submit" name="submit">
													<?php endif; ?>
													<input value="Cancelar" class="btn btn-success btn-block" type="button" onclick="location.href='<?php echo base_url() ?>backend/horquillahoraria/index/1'">
												</div>
												
												<input type="hidden" name="hor_id" value="<?php echo $hor_id ?>">
											</form>
										</div>
									</div>
								</div>
								<div class="col-md-8">

									<form class="table-responsive" name="formdelete" id="formdelete" action="<?php echo base_url() ?>backend/horquillahoraria/eliminar" method="post">
										<table class="table table-striped table-bordered table-hover table-checkable">
											<thead>
												<tr>
													<th class="checkbox-column">
														<input type="checkbox" class="uniform">
													</th>
													<th>Nombre</th>
													<th class="align-center">Laborable<br>día</th>
													<th class="align-center">Laborable<br>Noche</th>
													<th class="align-center">Festivo<br>día</th>
													<th class="align-center">Festivo<br>Noche</th>
													<th class="align-center">Estado</th>
													<th class="align-center" width="100">Acción</th>
												</tr>
											</thead>
											<tbody>
												<?php if(count($horquillas) > 0): ?>
													<?php foreach($horquillas as $item): ?>
													<tr>
														<td class="checkbox-column">
															<input name="seleccion[]" value="<?php echo $item->hor_id ?>" type="checkbox" class="uniform checkeados">
														</td>
														<td>
															<?php if(verificarPermiso("hor_editar")): ?>
															<a href="<?php echo base_url() ?>backend/horquillahoraria/editar/<?php echo $item->hor_id ?>" title="Editar">
															<?php endif; ?>
															<?php echo $item->hor_name ?>
															<?php if(verificarPermiso("hor_editar")): ?>
															</a>
															<?php endif; ?>
														</td>
														<td class="align-center"><?php echo $item->hor_laborable ?></td>
														<td class="align-center"><?php echo $item->hor_laborable_nocturno ?></td>
														<td class="align-center"><?php echo $item->hor_festivo ?></td>
														<td class="align-center"><?php echo $item->hor_festivo_nocturno ?></td>
														<td class="align-center">
														<?php if($item->hor_state == 1): ?>
																<span class="icon-check"></span>
															<?php else: ?>
																<span class="icon-check-empty"></span>
															<?php endif; ?>
														</td>
														<td>
															<ul class="table-controls">
																<?php if(verificarPermiso("hor_editar")): ?>
																<li><a href="<?php echo base_url() ?>backend/horquillahoraria/editar/<?php echo $item->hor_id ?>" class="bs-tooltip" title="Editar"><i class="icon-pencil"></i></a> </li>
																<?php endif; ?>
																<?php if(verificarPermiso("hor_eliminar")): ?>
																<li><a href="<?php echo base_url() ?>backend/horquillahoraria/eliminar/DEL/<?php echo $item->hor_id ?>" class="bs-tooltip confirm-dialog-delete" title="Eliminar definitivamente"><i class="icon-remove"></i></a> </li>
																<?php endif; ?>
															</ul>
														</td>
													</tr>
													<?php endforeach; ?>
												<?php else: ?>
													<tr><td colspan='10' align="center">NO EXISTE REGISTROS</td></tr>
												<?php endif; ?>
											</tbody>
										</table>
									</form>
								</div>

						</div>
						
					</div>
				</div>
			</div>
			<!-- /.container -->

		</div>
	</div>
