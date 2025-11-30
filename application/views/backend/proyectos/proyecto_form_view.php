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
						
						
							<div class="col-md-6">
								<form method="post" class="form-horizontal row-border row" id="validate_1" action="<?php echo base_url() ?>backend/proyectos/<?php echo $action ?>/">
									<div class="widget box">
										<div class="widget-header">
											<h4>Información del proyecto</h4>
										</div>
										<div class="widget-content">
											<div class="form-group row">
												<label class="control-label col-md-4">Nombre <span class="required">*</span></label>
												<div class="col-md-8">
													<input type="text" name="pro_name" value="<?php if(isset($pro_name)) echo $pro_name ?>" class="form-control required" placeholder="Ingrese nombre de proyecto">
												</div>
											</div>
											<div class="form-group row">
												<label class="control-label col-md-4">Cliente <span class="required">*</span></label>
												<div class="col-md-8">
													<select name="cli_id" id="" class="select2-select-00 col-md-12 full-width-fix required">
														<option value=""></option>
														<?php foreach ($clientes as $item): ?>
															<?php if($cli_id == $item->cli_id) $selected = "selected"; else $selected = "" ?>
															<option <?php echo $selected ?> value="<?php echo $item->cli_id ?>"><?php echo $item->cli_name ?></option>
														<?php endforeach; ?>
													</select>
												</div>
											</div>
											<div class="form-group row">
												<label class="control-label col-md-4">Coordinador <span class="required">*</span></label>
												<div class="col-md-8">
													<select name="coo_id" id="" class="select2-select-00 col-md-12 full-width-fix required">
														<option value=""></option>
														<?php foreach ($coordinadores as $item): ?>
															<?php if($coo_id == $item->usu_id) $selected = "selected"; else $selected = "" ?>
															<option <?php echo $selected ?> value="<?php echo $item->usu_id ?>"><?php echo $item->usu_ap ?> <?php echo $item->usu_am ?> <?php echo $item->usu_nombre ?></option>
														<?php endforeach; ?>
													</select>
												</div>
											</div>
											<?php
											if($pro_tipo_horario == "Continuo"){
												$required_continuo = "checked";
												$required_partido = "";
											}elseif($pro_tipo_horario == "Partido"){
												$required_continuo = "";
												$required_partido = "checked";
											}
											?>
											<div class="form-group row">
												<label class="control-label col-md-4">Tipo de horario</label>
												<div class="col-md-8">
													<label class="radio-inline"><input type="radio" value="Continuo" name="pro_tipo_horario" <?php echo $required_continuo ?> class="uniform"> Continuo</label>
													<label class="radio-inline"><input type="radio" value="Partido" name="pro_tipo_horario" <?php echo $required_partido ?> class="uniform"> Partido</label>
													<label for="gender" class="has-error help-block" generated="true" style="display:none;"></label>
												</div>
											</div>
											<div class="form-group row">
												<label class="control-label col-md-4">Descripción</label>
												<div class="col-md-8">
													<textarea class="auto form-control" name="pro_description" rows="3" style="overflow: hidden; word-wrap: break-word; resize: horizontal; height: 99px;"><?php if(isset($pro_description)) echo $pro_description ?></textarea>
												</div>
											</div>
											<div class="form-group row">
												<?php
												if($pro_state == 1){
													$required_1 = "checked";
													$required_2 = "";
												}else{
													$required_1 = "";
													$required_2 = "checked";
												}
												?>
												<label class="control-label col-md-4">Estado</label>
												<div class="col-md-8">
													<label class="radio-inline"><input type="radio" value="1" name="pro_state" <?php echo $required_1 ?> class="uniform"> Activo</label>
													<label class="radio-inline"><input type="radio" value="0" name="pro_state" <?php echo $required_2 ?> class="uniform"> Inactivo</label>
													<label for="gender" class="has-error help-block" generated="true" style="display:none;"></label>
												</div>
											</div>
											<div class="form-actions row" style="margin-bottom:-15px">
												<div class="col-md-6">
													<input value="Aceptar" class="btn btn-primary btn-block" type="submit" name="submit">
												</div>
												<div class="col-md-6">
													<input value="Cerrar" class="btn btn-success btn-block" type="button" onclick="location.href='<?php echo base_url() ?>backend/proyectos/index/1'">
												</div>											
											</div>
											<input type="hidden" name="pro_id" value="<?php echo $pro_id ?>">
										</div>
										
									</div>
								</form>
							</div>


							<div class="col-md-6">
								<div class="widget box position-relative row-only-mobile">
									<?php if($pro_id == ''): ?>
										<div class="overlay-insert-first"><h2>Para añadir trabajadores<br>al proyecto primero créelo!</h2></div>
									<?php endif; ?>
									<div class="widget-header">
										<h4>Trabajadores del proyecto</h4>
									</div>
									<div class="widget-content">
										<div class="row">
											<div class="form-group col-md-12">
												<label class="control-label">Trabajador *</label>
												<div class="">
													<select id="usu_id_project" name="usu_id" class="select2-select-00 col-md-12 full-width-fix required" placeholder="- Seleccione un item -">
														<option value=""></option>
														<?php foreach ($trabajadores as $item): ?>
															<option value="<?php echo $item->usu_id ?>"><?php echo $item->usu_ap ?> <?php echo $item->usu_am ?> <?php echo $item->usu_nombre ?></option>
														<?php endforeach; ?>
													</select>
												</div>
											</div>
										</div><!-- row -->
										<div class="form-group mt10">
											<div class="">
												<input 
													value="Añadir" 
													class="btn btn-info" 
													type="button" 
													name="btn-add" 
													id="btn-add"
													onclick="ajax_aniadir_trabajador_a_proyecto('<?php echo base_url() ?>backend/proyectos/aniadir_trabajador','<?php echo $pro_id ?>','script', '<?php echo base_url() ?>backend/proyectos/')";
													/>
											</div>
										</div>

										<table class="table table-striped table-bordered table-hover table-checkable" style="margin-top:2rem;">
											<thead>
												<tr>
													<th class="align-center">
														#
													</th>
													<th>Apellidos y nombres</th>
													<th class="align-center" width="60">Acción</th>
												</tr>
											</thead>
											<tbody id="script">
												<?php if(count($lista_trabajadores_proyecto)>0): $i = 1; ?>
													<?php foreach($lista_trabajadores_proyecto as $item): ?>
													<tr>
														<td class="align-center"><?php echo $i; ?></td>
														<td>
															<?php echo $item->usu_ap ?> <?php echo $item->usu_am ?> <?php echo $item->usu_nombre ?>
															<?php echo $this->usuario_modelo->getId($item->usu_id)->usu_estado==0?"<i class='fa fa-warning color-orange icon-parpadeo' title='Trabajador inactivo'></i>":""; ?>
														</td>
														<td class="text-center">
															<ul class="table-controls">
																<li><a href="javascript:void(0)" onclick="ajax_eliminar_trabajador_proyecto('<?php echo base_url() ?>backend/proyectos/eliminar_trabajador','<?php echo $item->pro_id ?>','<?php echo $item->usu_id ?>','script', '<?php echo base_url() ?>backend/proyectos/')" class="bs-tooltip" title="Eliminar"><i class="icon-remove"></i></a> </li>
															</ul>
														</td>
													</tr>
													<?php $i++; endforeach; ?>
												<?php else: ?>
													<tr><td align="center" colspan="4">No existe trabajadores!</td></tr>
												<?php endif; ?>
											</tbody>
										</table>


									</div>
								</div>
							</div>
						
					</div>
				</div>
			</div>
			<!-- /.container -->

		</div>
	</div>
