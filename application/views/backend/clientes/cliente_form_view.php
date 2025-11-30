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
						
								<form method="post" class="form-horizontal row-border row" id="validate_1" action="<?php echo base_url() ?>backend/clientes/<?php echo $action ?>/">
									<div class="col-md-5">
										<div class="widget box">
											<div class="widget-header">
												<h4>Información de cliente</h4>
											</div>
											<div class="widget-content">
												<div class="form-group row">
													<label class="control-label col-md-4">Nombre <span class="required">*</span></label>
													<div class="col-md-8">
														<input type="text" name="cli_name" value="<?php if(isset($cli_name)) echo $cli_name ?>" class="form-control required" placeholder="Ingrese nombre de cliente">
													</div>
												</div>
												<div class="form-group row">
													<label class="control-label col-md-4">Contacto <span class="required">*</span></label>
													<div class="col-md-8">
														<input type="text" name="cli_contact" value="<?php if(isset($cli_contact)) echo $cli_contact ?>" class="form-control required" placeholder="Ingrese nombre contacto">
													</div>
												</div>
												<div class="form-group row">
													<label class="control-label col-md-4">Móvil <span class="required">*</span></label>
													<div class="col-md-8">
														<input type="text" name="cli_phone" value="<?php if(isset($cli_phone)) echo $cli_phone ?>" class="form-control required" placeholder="Ingrese Móvil">
													</div>
												</div>
												<div class="form-group row">
													<label class="control-label col-md-4">CIF <span class="required">*</span></label>
													<div class="col-md-8">
														<input type="text" name="cli_cif" value="<?php if(isset($cli_cif)) echo $cli_cif ?>" class="form-control required" placeholder="Ingrese CIF">
													</div>
												</div>
												<div class="form-group row">
													<label class="control-label col-md-4">E-Mail <span class="required">*</span></label>
													<div class="col-md-8">
														<input type="email" name="cli_mail" value="<?php if(isset($cli_mail)) echo $cli_mail ?>" class="form-control required" placeholder="Ingrese email">
													</div>
												</div>
												<div class="form-group row">
													<label class="control-label col-md-4">Descripción</label>
													<div class="col-md-8">
														<textarea class="auto form-control" name="cli_description" rows="3" style="overflow: hidden; word-wrap: break-word; resize: horizontal; height: 99px;"><?php if(isset($cli_description)) echo $cli_description ?></textarea>
													</div>
												</div>
												<div class="form-group row">
													<?php
													if($cli_state == 1){
														$required_1 = "checked";
														$required_2 = "";
													}else{
														$required_1 = "";
														$required_2 = "checked";
													}
													 ?>
													<label class="control-label col-md-4">Estado</label>
													<div class="col-md-8">
														<label class="radio-inline"><input type="radio" value="1" name="cli_state" <?php echo $required_1 ?> class="uniform"> Activo</label>
														<label class="radio-inline"><input type="radio" value="0" name="cli_state" <?php echo $required_2 ?> class="uniform"> Inactivo</label>
														<label for="gender" class="has-error help-block" generated="true" style="display:none;"></label>
													</div>
												</div>
											</div>
										</div>
									</div>

									<div class="col-md-5">
										<div class="widget box">
											<div class="widget-header">
												<h4>Centros de Trabajo</h4>
											</div>
											<div class="widget-content">
												<div class="row">
												<?php foreach($centros_lista as $item): ?>
													<div class="custom-control custom-checkbox col-md-6">
														<?php 
														$obj = array_column($centros, null, 'cen_id')[$item->cen_id] ?? false;
														$checked = $obj?"checked":"";
														?>
														<input  class="custom-control-input" 
																type="checkbox" 
																id="ck<?php echo $item->cen_id ?>" 
																value="<?php echo $item->cen_id ?>" 
																name="centros[]" 
																<?php echo $checked ?> <?php echo $item->cen_state==0?"disabled":""; ?>
																
															>
														<label for="ck<?php echo $item->cen_id ?>" class="custom-control-label">
															<?php echo $item->cen_name; ?>
															<?php echo $item->cen_state==0?"<i class='fa fa-warning color-orange icon-parpadeo' title='Centro inactivo'></i>":""; ?>
														</label>
													</div>
												<?php endforeach; ?>
												</div>
											</div>
										</div>
									</div>

									<div class="col-md-2">
										<div class="form-actions">
											<input value="Aceptar" class="btn btn-primary btn-block" type="submit" name="submit">
											<input value="Aceptar + Nuevo" class="btn btn-info btn-block" type="submit" name="submit-nuevo">
											<input value="Cancelar" class="btn btn-success btn-block" type="button" onclick="location.href='<?php echo base_url() ?>backend/clientes/index/1'">
										</div>
									</div>
									<input type="hidden" name="cli_id" value="<?php echo $cli_id ?>">
								</form>
							
						<!-- /Validation Example 1 -->
					</div>
				</div>
			</div>
			<!-- /.container -->

		</div>
	</div>

	<script>
		//validar que por lo menos un checkbox este marcado
		document.getElementById('validate_1').addEventListener('submit', function(event) {
			var checkboxes = document.querySelectorAll('input[type="checkbox"]');
			var seleccionado = false;
			for (var i = 0; i < checkboxes.length; i++) {
				if (checkboxes[i].checked) {
					seleccionado = true;
					break;
				}
			}
			if (!seleccionado) {
				alert('Por favor, selecciona al menos un centro de trabajo.');
				event.preventDefault(); // Evita que el formulario se envíe
			}
		});
	</script>