	<?php require (APPPATH."views/layouts/backend/header.php"); ?>

	<div id="container">
		<?php require (APPPATH."views/layouts/backend/sidebarleft.php"); ?>

		<div id="content">
			<div class="container">
				
				<?php require (APPPATH."views/layouts/backend/crumbs-page-header.php"); ?>

				<form method="post" class="form-horizontal row-border" id="validate_1" action="<?php echo base_url() ?>backend/admin/">

					<!--=== Page Content ===-->
					<div class="row">
						<!--=== Validation Example 1 ===-->
						<div class="col-sm-3">
							<img src="<?php echo base_url() ?>public/backend/img/silueta.jpg" alt="">
							<input type="submit" name="submit" value="Actualizar datos" class="btn btn-primary pull-right">
						</div>
						<div class="col-sm-9">					
							<!-- Tabs-->
							<div class="tabbable tabbable-custom tabbable-full-width">
								<ul class="nav nav-tabs">
									<li class="active"><a href="#tab_overview" data-toggle="tab">Información general</a></li>
									<li><a href="#tab_edit_account" data-toggle="tab">Password y nombre de usuario</a></li>
								</ul>
								<div class="tab-content row">
									<!--=== Overview ===-->
									<div class="tab-pane active" id="tab_overview">

										<div class="col-sm-12">
											<div class="widget">
												<div class="widget-content">
													<div class="row">
														<div class="col-sm-6">
															<div class="form-group">
																<label class="col-sm-4 control-label">Nombres:</label>
																<input onkeyup="pulsar(this)" type="text" name="usu_nombre" value="<?php if(isset($usu_nombre)) echo $usu_nombre ?>" class="required col-sm-8" placeholder="aquí su nombre">												
															</div>

															<div class="form-group">
																<label class="col-sm-4 control-label">Ap. parterno:</label>
																<input onkeyup="pulsar(this)" type="text" name="usu_ap" value="<?php if(isset($usu_ap)) echo $usu_ap ?>" class=" required col-sm-8" placeholder="aquí su apellido paterno">
															</div>

															<div class="form-group">
																<label class="col-sm-4 control-label">Ap. materno:</label>
																<input onkeyup="pulsar(this)" type="text" name="usu_am" value="<?php if(isset($usu_am)) echo $usu_am ?>" class=" required col-sm-8"  placeholder="aquí su apellido materno">
															</div>

															<div class="form-group">
																<label class="control-label col-sm-4">Email</label>
																<input type="text" name="usu_email" value="<?php if(isset($usu_email)) echo $usu_email ?>" class="email col-sm-8" placeholder="aquí su correo electrónico">
															</div>

															<div class="form-group">
																<label class="control-label col-sm-4">Teléfono</label>
																<input type="text" name="usu_telefono" value="<?php if(isset($usu_telefono)) echo $usu_telefono ?>" class="col-sm-8"  placeholder="aquí su teléfono">
															</div>
															<div class="form-group">
																<label class="control-label col-sm-4">Móvil</label>
																<input type="text" name="usu_celular" value="<?php if(isset($usu_celular)) echo $usu_celular ?>" class="col-sm-8" placeholder="aquí su móvil">
															</div>
												
														</div>


														<div class="col-sm-6">
															<div class="form-group">
																<label class="control-label col-sm-4">DNI</label>
																<input type="text" name="usu_dni" value="<?php if(isset($usu_dni)) echo $usu_dni ?>" class="col-sm-" placeholder="aquí su carnet de identidad">						
															</div>

															<div class="form-group">
																<label class="control-label col-sm-4">Cargo</label>
																<input type="text" name="usu_cargo" value="<?php if(isset($usu_cargo)) echo $usu_cargo ?>" class="col-sm-8"  placeholder="aquí el cargo actual">
												
															</div>

															<div class="form-group">
																<label class="control-label col-sm-4">Sucursales</label>
																<div class="col-sm-8">
																	<select id="input18" class="select2-select-00 full-width-fix" multiple size="5" name="suc_id[]">
																	<?php foreach ($lista_sucursal as $valor): ?>
																		<?php if(in_array($valor->suc_id, $suc_id_array)): ?>
																			<?php $selected = "selected"; ?>
																		<?php else: ?>
																			<?php $selected = ""; ?>
																		<?php endif; ?>
																		<option <?php echo $selected ?> value="<?php echo $valor->suc_id ?>"><?php echo $valor->suc_nombre ?></option>
																	<?php endforeach; ?>
																	</select>
																</div>
															</div>
															<div class="form-group">
																<?php 
																if($usu_sw == 1){
																	$required_1 = "checked";
																	$required_2 = "";
																}else{
																	$required_1 = "";
																	$required_2 = "checked";
																}
																 ?>
																<label class="control-label col-sm-4">Activado</label>
																<div class="col-sm-8">
																	<label class="radio"><input type="radio" value="1" name="usu_sw" <?php echo $required_1 ?> class="uniform"> Si</label>
																	<label class="radio"><input type="radio" value="0" name="usu_sw" <?php echo $required_2 ?> class="uniform"> No</label>
																	<label for="gender" class="has-error help-block" generated="true" style="display:none;"></label>
																</div>
															</div>
															<div class="form-group">
																<label class="control-label col-sm-4">Dirección</label>
																<textarea onkeyup="pulsar(this)" class="auto col-sm-8" name="usu_direccion" cols="5" rows="3" style="overflow: hidden; word-wrap: break-word; resize: horizontal; height: 87px;"><?php if(isset($usu_direccion)) echo $usu_direccion ?></textarea>
												
															</div>
														</div>
													</div> <!-- /.row -->
												</div> <!-- /.widget-content -->
											</div> <!-- /.widget -->
										</div> <!-- /.col-sm-9 -->
									</div>
									<!-- /Overview -->

									<!--=== Edit Account ===-->
									<div class="tab-pane" id="tab_edit_account">
										<div class="col-sm-12 form-vertical no-margin">
											<div class="widget">
												<div class="widget-content">
													<div class="form-group">														
														<label class="col-sm-4 control-label">Username</label>
														<input type="text" name="usu_username" value="<?php if(isset($usu_username)) echo $usu_username ?>" class="required col-sm-8">
														
													</div> <!-- /.form-group -->
													<div class="form-group">
														
														<label class="control-label col-sm-4">Contraseña:</label>
														<input type="password" name="usu_password" class="col-sm-8" minlength="5" maxlength="10">
													</div>

													<div class="form-group">
														<label class="control-label col-sm-4">Repetir contraseña:</label>
														<input type="password" name="cpass1" class="col-sm-8 " minlength="5" maxlength="10" equalTo="[name='usu_password']">
															
													</div> <!-- /.row -->
												</div> <!-- /.widget-content -->
											</div> <!-- /.widget -->
											
										</div> <!-- /.col-sm-12 -->
									</div>
									<!-- /Edit Account -->
								</div> <!-- /.tab-content -->
							</div>
							<!--END TABS-->
							
							
						</div>
					</div>
				</form>
			</div>
			<!-- /.container -->

		</div>
	</div>
