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
								<h4><?php echo $titulo_form ?></h4>
							</div>
							<div class="widget-content">
								<form method="post" class="form-horizontal row-border row" id="validate_1" action="<?php echo base_url() ?>backend/usuario/<?php echo $action ?>/<?php echo $usu_tipo ?>" enctype='multipart/form-data'>

									<div class="col-md-5">
										<div class="form-group row">
											<label class="control-label col-md-5">Nombres <span class="required">*</span></label>
											<div class="col-md-7">
												<input type="text" name="usu_nombre" id="usu_nombre" value="<?php if(isset($usu_nombre)) echo $usu_nombre ?>" class="form-control required" placeholder="Ingrese su nombre completo" maxlength="30">
											</div>
										</div>
										<div class="form-group row">
											<label class="control-label col-md-5">Apellido paterno <span class="required">*</span></label>
											<div class="col-md-7">
												<input type="text" name="usu_ap" id="usu_ap" value="<?php if(isset($usu_ap)) echo $usu_ap ?>" class="form-control required" placeholder="Ingrese su apellido paterno" maxlength="20">
											</div>
										</div>
										<div class="form-group row">
											<label class="control-label col-md-5">Apellido materno <span class="required">*</span></label>
											<div class="col-md-7">
												<input type="text" name="usu_am" id="usu_am" value="<?php if(isset($usu_am)) echo $usu_am ?>" class="form-control required"  placeholder="Ingrese su apellido materno" maxlength="20">
											</div>
										</div>
										<div class="form-group row">
											<label class="control-label col-md-5">DNI</label>
											<div class="col-md-7">
												<input type="text" id="usu_dni" name="usu_dni" value="<?php if(isset($usu_dni)) echo $usu_dni ?>" class="form-control" placeholder="Ingrese su DNI">
												
											</div>
										</div>
										<div class="form-group row">
											<label class="control-label col-md-5">Teléfono</label>
											<div class="col-md-7">
												<input type="number" name="usu_telefono" id="usu_telefono" value="<?php if(isset($usu_telefono)) echo $usu_telefono ?>" class="form-control digits"  placeholder="Ingrese su teléfono" maxlength="9">
												<span class="help-block">Ej.: 99999</span>
											</div>
										</div>
										<div class="form-group row">
											<label class="control-label col-md-5">Móvil</label>
											<div class="col-md-7">
												<input type="number" name="usu_celular" id="usu_celular" value="<?php if(isset($usu_celular)) echo $usu_celular ?>" class="form-control digits" placeholder="Ingrese su móvil" maxlength="9">
												<span class="help-block">Ej.: 99999</span>
											</div>
										</div>
										<div class="form-group row">
											<label class="control-label col-md-5">Email <span class="required">*</span></label>
											<div class="col-md-7">
												<input type="email" name="usu_email" id="usu_email" value="<?php if(isset($usu_email)) echo $usu_email ?>" class="form-control email required" placeholder="Ingrese su correo electrónico" onblur="ajax_verificarEmail('<?php echo base_url(); ?>backend/usuario/verificarExistenciaEmail/', this.value, 'script')">
												
												<img id="doneemail" src="<?php echo base_url() ?>public/backend/img/ajax-loader.gif" style="display:none;" title="procesando...">
												<label id="email_error" class="has-error" style="display:none;">El "email" ya existe intente con uno diferente.</label>
											</div>
										</div>
										<div class="form-group row">
											<label class="control-label col-md-5">Sexo</label>
											<div class="col-md-7">
												<?php
												if($usu_sexo == "m"){
													$check_max = "checked";
													$check_fem = "";
												}elseif($usu_sexo == "f"){
													$check_max = "";
													$check_fem = "checked";
												}

												?>
												<label class="radio-inline"><input type="radio" <?php echo (isset($check_max))?$check_max:""; ?> value="m" name="usu_sexo" class="uniform"> Masculino</label>
												<label class="radio-inline"><input type="radio" <?php echo (isset($check_fem))?$check_fem:""; ?> value="f" name="usu_sexo" class="uniform"> Femenino</label>
											</div>
										</div>
										<div class="form-group row">
											<label class="control-label col-md-5">Fecha de nacimiento</label>
											<div class="col-md-7">
												<input class="form-control datepicker" type="text" name="usu_fecha_nac" value="<?php echo $usu_fecha_nac ?>" id="fecha_nac" minlength="10" maxlength="10" placeholder="YYYY-MM-DD">
												<span class="help-block">Formato: YYYY-MM-DD</span>
											</div>
										</div>
										<div class="form-group row">
											<?php
											if($usu_estado == 1){
												$required_1 = "checked";
												$required_2 = "";
												$required_3 = "";
											}elseif($usu_estado == 0){
												$required_1 = "";
												$required_2 = "checked";
												$required_3 = "";
											}elseif($usu_estado == 3){
												$required_1 = "";
												$required_2 = "";
												$required_3 = "checked";
											}
											 ?>
											<label class="control-label col-md-5">Estado</label>
											<div class="col-md-7">
												<label class="radio-inline"><input type="radio" value="1" name="usu_estado" <?php echo $required_1 ?> class="uniform"> Activo</label>
												<label class="radio-inline"><input type="radio" value="0" name="usu_estado" <?php echo $required_2 ?> class="uniform"> Inactivo</label>
												
											</div>
										</div>
										<div class="form-group row">
											<label class="control-label col-md-5">Observación</label>
											<div class="col-md-7">
												<textarea class="auto form-control" name="usu_observacion"  id="usu_observacion" rows="3" style="overflow: hidden; word-wrap: break-word; resize: horizontal; height: 99px;" maxlength="255"><?php if(isset($usu_observacion)) echo $usu_observacion ?></textarea>
											</div>
										</div>
									</div>


									<div class="col-md-5">
										<div class="form-group row">
											<label class="col-md-4 control-label">Fotografía</label>
											<div class="col-md-8">
												<?php if($usu_foto == ""): ?>
												<img src="<?php echo base_url() ?>public/backend/img/silueta.jpg" style="height:134px;">
												<?php else: ?>
												<img src="<?php echo base_url()."".$usu_foto ?>" style="height:134px;">

												<?php endif; ?>
												<input type="file" name="usu_foto" accept="image/*" data-style="fileinput" data-inputsize="medium">
												<p class="help-block" style="margin-bottom:0px !important;">Formato (jpeg, png, gif)</p>
												<p class="help-block" style="color:red !important;margin-top:0px !important;">Ancho máximo:500px, Alto máximo: 500px</p>
												<input type="hidden" name="usu_foto_2" value="<?php echo $usu_foto_2 ?>">
											</div>
										</div>

										<div class="form-group row">
											<label class="control-label col-md-4">Fecha de alta <span class="required">*</span></label>
											<div class="col-md-8">
												<input class="form-control required datepicker" type="text" name="usu_fecha_alta" value="<?php echo $usu_fecha_alta ?>" id="fecha_alta" minlength="10" maxlength="10" placeholder="YYYY-MM-DD">
												<span class="help-block">Formato: YYYY-MM-DD</span>
												
											</div>
										</div>
										
										
										<div class="form-group row">
										<?php
											if($usu_tipo === "Administrador"){
												$required_admin = "checked";
												$required_coordinador = "";
												$required_trabajador = "";
											}elseif($usu_tipo === "Coordinador"){
												$required_admin = "";
												$required_coordinador = "checked";
												$required_trabajador = "";
											}elseif($usu_tipo === "Trabajador"){
												$required_admin = "";
												$required_coordinador = "";
												$required_trabajador = "checked";
											}else{
												$required_admin = "";
												$required_coordinador = "";
												$required_trabajador = "";
											}
											 ?>
											<label class="control-label col-md-4">Rol <span class="required">*</span></label>
											<div class="col-md-8">
												<?php if(!empty($required_admin)): ?>
												<label class="radio"><input type="radio" value="Administrador" name="usu_tipo" <?php echo $required_admin ?> class="uniform required"> Administrador</label>
												<?php endif; ?>
												<?php if(!empty($required_coordinador)): ?>
												<label class="radio"><input type="radio" value="Coordinador" name="usu_tipo" <?php echo $required_coordinador ?> class="uniform required"> Coordinador</label>
												<?php endif; ?>
												<?php if(!empty($required_trabajador)): ?>
												<label class="radio"><input type="radio" value="Trabajador" name="usu_tipo" <?php echo $required_trabajador ?> class="uniform required"> Trabajador</label>
												<?php endif; ?>
												<label for="gender" class="has-error help-block" generated="true" style="display:none;"></label>
											</div>
										</div>
										<div class="form-group row">
											<label class="control-label col-md-4">Usuario <span class="required">*</span></label>
											<div class="col-md-8">
												<input 
													type="text" 
													name="usu_username" 
													id="username" 
													value="<?php if(isset($usu_username)) echo $usu_username ?>" 
													class="form-control required" 
													rangelength="5,30" 
													onblur="ajax_verificarUsername('<?php echo base_url(); ?>backend/usuario/verificarExistenciaUsername/', this.value, <?php echo $usu_id ?>, 'script')"
												>
												<img id="done" src="<?php echo base_url() ?>public/backend/img/ajax-loader.gif" style="display:none;" title="procesando...">
												<label id="username_error" class="has-error" style="display:none;">El "usuario" ya existe intente con uno diferente.</label>
											</div>
										</div>
										<div class="form-group row">
											<label class="control-label col-md-4">Contraseña <span class="required">*</span></label>
											<div class="col-md-8">
												<input type="password" name="usu_password" class="form-control <?php if($action=='insertar') echo "required" ?>" minlength="5" placeholder="Ingrese contraseña, deje vacio si no quiere modificar">
											</div>
										</div>
										<div class="form-group row">
											<label class="control-label col-md-4">Repetir <span class="required">*</span></label>
											<div class="col-md-8">
												<input type="password" name="cpass1" class="form-control" minlength="5" equalTo="[name='usu_password']" placeholder="Repetir contraseña">
											</div>
										</div>
									</div>

									<div class="col-md-2">
										<div class="form-actions">
											<input value="Aceptar" class="btn btn-primary btn-block" type="submit" name="submit">
											<input value="Aceptar + Nuevo" class="btn btn-info btn-block" type="submit" name="submit-nuevo">
											<input value="Cancelar" class="btn btn-success btn-block" type="button" onclick="location.href='<?php echo base_url() ?>backend/usuario/index/1/<?php echo $usu_tipo; ?>'">
											<?php if($this->session->userdata("usu_tipo_actual") == "Super_admin"): ?>
											<br>
											<a href="javascript::void();" class="btn-fill">Llenar info</a>
											<?php endif; ?>
										</div>
									</div>
									<input type="hidden" name="usu_id" value="<?php echo $usu_id ?>">
								</form>
							</div>
						</div>
						<!-- /Validation Example 1 -->
					</div>
				</div>
			</div>
			<!-- /.container -->

		</div>
	</div>





<div id="script"></div>
