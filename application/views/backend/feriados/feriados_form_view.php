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

							<?php if(isset($_GET['fer_type']) and $_GET['fer_type'] == "Local"): ?>
							<div class="provincia-name">
								<div>
									<strong>Provincia</strong>: <?php echo $this->provincia_modelo->getId($_GET['prov_id'])->prov_name; ?>
								</div>
								<div>
									<strong>Localidad</strong>: <?php echo $this->localidad_modelo->getId($_GET['loc_id'])->loc_name; ?>
								</div>
							</div>
							<?php endif; ?>
						
					
							<div class="col-md-3">
								<div class="widget box row-border row">
									<div class="widget-header">
										<h4><?php echo $titulo_form; ?></h4>
									</div>
									<div class="widget-content">
										<form method="post" class="form-horizontal" id="validate_1" action="<?php echo base_url() ?>backend/feriados/<?php echo $action ?>/">
											<div class="form-group">
												<label class="control-label">Nombre <span class="required">*</span></label>
												<div class="">
													<input type="text" name="fer_name" value="<?php if(isset($fer_name)) echo $fer_name ?>" class="form-control required" placeholder="Ingrese nombre de día festivo">
												</div>
											</div>
											<div class="form-group">
												<label class="control-label">Día <span class="required">*</span></label>
												<div class="">
													<select name="fer_day" id="" class="select2-select-00 col-md-12 full-width-fix required">
														<option value=""></option>
														<?php for ($i = 1; $i <= 31; $i++): ?>
															<?php if($i >= 1 and $i <= 9) $dia = "0".$i; else $dia = $i; ?>
															<?php if($fer_day == $dia) $selected = "selected"; else $selected = "" ?>
															<option <?php echo $selected ?> value="<?php echo $dia ?>"><?php echo $dia ?></option>
														<?php endfor; ?>
													</select>
												</div>
											</div>
											<div class="form-group">
												<label class="control-label">Mes <span class="required">*</span></label>
												<div class="">
													<select name="fer_month" id="" class="select2-select-00 col-md-12 full-width-fix required">
														<option value=""></option>
														<?php foreach (mes() as $key => $item): ?>
															<?php if($fer_month == $key) $selected = "selected"; else $selected = "" ?>
															<option <?php echo $selected ?> value="<?php echo $key ?>"><?php echo $item ?></option>
														<?php endforeach; ?>
													</select>
												</div>
											</div>
											<div class="form-group">
												<label class="control-label">Año <span class="required">*</span></label>
												<div class="">
													<input type="number" name="fer_year" value="<?php if(isset($fer_year)) echo $fer_year ?>" class="form-control required" placeholder="Ingrese año, ejemplo: 2024">
												</div>
											</div>

											
											<div class="form-actions" style="margin-top:3rem;margin-bottom:-1.5rem;">
												<?php if(verificarPermiso("fer_nuevo") or verificarPermiso("fer_editar")): ?>
												<input value="Aceptar" class="btn btn-primary btn-block" type="submit" name="submit">
												<?php endif; ?>
												<?php if($_GET['fer_type'] == "Nacional"): ?>
													<input value="Cancelar" class="btn btn-success btn-block" type="button" onclick="location.href='<?php echo base_url() ?>backend/feriados/index/?fer_type=<?php echo $_GET['fer_type'] ?>'">
												<?php elseif($_GET['fer_type'] == "Local"): ?>
													<input value="Cancelar" class="btn btn-success btn-block" type="button" onclick="location.href='<?php echo base_url() ?>backend/feriados/index/?fer_type=<?php echo $_GET['fer_type'] ?>&prov_id=<?php echo $_GET['prov_id'] ?>&loc_id=<?php echo $_GET['loc_id'] ?>'">
												<?php endif; ?>
											</div>
											
											<input type="hidden" name="fer_id" value="<?php echo $fer_id ?>">
											<input type="hidden" name="fer_type" value="<?php echo isset($_GET['fer_type'])?$_GET['fer_type']:""; ?>">
											<?php //if($_GET['fer_type'] == 'Local'): ?>
												<input type="hidden" name="prov_id" value="<?php echo isset($_GET['prov_id'])?$_GET['prov_id']:"0"; ?>">
												<input type="hidden" name="loc_id" value="<?php echo isset($_GET['loc_id'])?$_GET['loc_id']:"0"; ?>">
											<?php //endif; ?>
										</form>
									</div>
								</div>
							</div>


							<div class="col-md-9">

								<div class="widget box position-relative">
									
									<div class="widget-content">

										<form class="d-flex align-items-center wrap-filter flex-end" name="form-filter" id="form-filter" action="<?php echo base_url() ?>backend/feriados/index/" method="get">
												<select id="filter-month" name="fer_month" id="" class="select2-select-00 required mr-1" placeholder="Mes" style="width:150px">
													<option value=""></option>
													<?php foreach (mes() as $key => $item): ?>
														<?php if(isset($_GET['fer_month']) and $_GET['fer_month'] == $key) $selected = "selected"; else $selected = "" ?>
														<option <?php echo $selected ?> value="<?php echo $key ?>"><?php echo $item ?></option>
													<?php endforeach; ?>
												</select>
												<div class="d-inline-block mr-1" >
													<input id="filter-year" type="number" name="fer_year" value="<?php if(isset($_GET['fer_year'])) echo $_GET['fer_year'] ?>" class=" required" placeholder="Año" style="width:70px;">
												</div>

												<input type="hidden" value="<?php echo $_GET['fer_type'] ?>" name="fer_type" />

												<input type="submit" class="btn btn-info" value="Filtrar">
										</form>

										<form class="table-responsive" name="formdelete" id="formdelete" action="<?php echo base_url() ?>backend/feriados/eliminar" method="post">
											<table class="table table-striped table-bordered table-hover table-checkable">
												<thead>
													<tr>
														<th class="checkbox-column">
															<input type="checkbox" class="uniform">
														</th>
														<th width="80">Año</th>
														<th width="120">Mes</th>
														<th width="50">Día</th>
														<th>Nombre</th>
														<th>Tipo</th>
														<th class="align-center" width="100">Acción</th>
													</tr>
												</thead>
												<tbody>
													<?php if(count($feriados) > 0): ?>
														<?php foreach($feriados as $item): ?>
														<tr>
															<td class="checkbox-column">
																<input name="seleccion[]" value="<?php echo $item->fer_id ?>" type="checkbox" class="uniform checkeados">
															</td>
															<td><?php echo $item->fer_year ?></td>
															<td><?php echo mes($item->fer_month) ?></td>
															<td><?php echo $item->fer_day ?></td>
															<td><?php echo $item->fer_name ?></td>
															<td><?php echo $item->fer_type ?></td>
															<td>
																<?php if($_GET['fer_type'] == "Nacional"): ?>
																<ul class="table-controls">
																	<?php if(verificarPermiso("fer_editar")): ?>
																	<li><a href="<?php echo base_url() ?>backend/feriados/editar/<?php echo $item->fer_id ?>/?fer_type=<?php echo $_GET['fer_type'] ?>" class="bs-tooltip" title="Editar"><i class="icon-pencil"></i></a> </li>
																	<?php endif; ?>
																	<?php if(verificarPermiso("fer_eliminar")): ?>
																	<li><a href="<?php echo base_url() ?>backend/feriados/eliminar/DEL/<?php echo $item->fer_id ?>/?fer_type=<?php echo $_GET['fer_type'] ?>" class="bs-tooltip confirm-dialog-delete" title="Eliminar definitivamente"><i class="icon-remove"></i></a> </li>
																	<?php endif; ?>
																</ul>
																<?php elseif($_GET['fer_type'] == "Local"): ?>
																<ul class="table-controls">
																	<?php if(verificarPermiso("fer_editar")): ?>
																	<li><a href="<?php echo base_url() ?>backend/feriados/editar/<?php echo $item->fer_id ?>/?fer_type=<?php echo $_GET['fer_type'] ?>&prov_id=<?php echo $_GET['prov_id'] ?>&loc_id=<?php echo $_GET['loc_id'] ?>" class="bs-tooltip" title="Editar"><i class="icon-pencil"></i></a> </li>
																	<?php endif; ?>
																	<?php if(verificarPermiso("fer_eliminar")): ?>
																	<li><a href="<?php echo base_url() ?>backend/feriados/eliminar/DEL/<?php echo $item->fer_id ?>/?fer_type=<?php echo $_GET['fer_type'] ?>&prov_id=<?php echo $_GET['prov_id'] ?>&loc_id=<?php echo $_GET['loc_id'] ?>" class="bs-tooltip confirm-dialog-delete" title="Eliminar definitivamente"><i class="icon-remove"></i></a> </li>
																	<?php endif; ?>
																</ul>
																<?php endif; ?>
															</td>
														</tr>
														<?php endforeach; ?>
													<?php else: ?>
														<tr><td colspan='10' align="center">NO EXISTE REGISTROS</td></tr>
													<?php endif; ?>
												</tbody>
											</table>
											<?php if(verificarPermiso("fer_eliminar")): ?>
											<div style="margin-top:2rem;">
												<button name="btn_eliminar" class="confirm-dialog-delete-various btn btn-success" data-modal="true" data-text="" data-layout="top" title="Elimianar registros seleccionados">Eliminar seleccionados</button>
											</div>
											<?php endif; ?>
										</form>
									</div>
								</div>
							</div>

							
						
					</div>
				</div>
			</div>
			<!-- /.container -->

		</div>
	</div>
