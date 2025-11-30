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
								<form method="post" class="form-horizontal row-border row" id="validate_1" action="<?php echo base_url() ?>backend/centros/<?php echo $action ?>/">


									<div class="col-md-6">

										<div class="form-group row">
											<label class="control-label col-md-4">Nombre <span class="required">*</span></label>
											<div class="col-md-8">
												<input type="text" name="cen_name" value="<?php if(isset($cen_name)) echo $cen_name ?>" class="form-control required" placeholder="Ingrese nombre del centro de trabajo">
											</div>
										</div>
										<div class="form-group row">
											<label class="control-label col-md-4">Provincia *</label>
											<div class="col-md-8">
												<select id="prov_id" name="prov_id" class="select2-select-00 col-md-12 full-width-fix required"
													onchange="cargar_localidades('<?php echo base_url()."backend/provincias/cargar_localidades/"; ?>', this.value, 'loc_id');"	
													placeholder="- Seleccione un item -"
												>
												<option value="0">- Seleccione un item -</option>
													<?php foreach ($provincias as $item): ?>
														<?php if($prov_id == $item->prov_id) $selected = "selected"; else $selected = "" ?>
														<option value="<?php echo $item->prov_id ?>" <?php echo $selected ?>><?php echo $item->prov_name ?></option>
													<?php endforeach; ?>
												</select>
											</div>
										</div>
										<div class="form-group row">
											<label class="control-label col-md-4">Localidad *</label>
											<div class="col-md-8">
												<select id="loc_id" name="loc_id" class="select2-select-00 col-md-12 full-width-fix required" placeholder="- Seleccione un item -">
													<option value="0">- Seleccione un item -</option>
													<?php foreach ($localidades as $item): ?>
														<?php if($loc_id == $item->loc_id) $selected = "selected"; else $selected = "" ?>
														<option value="<?php echo $item->loc_id ?>" <?php echo $selected ?>><?php echo $item->loc_name ?></option>
													<?php endforeach; ?>
												</select>
											</div>
										</div>
										<div class="form-group row">
											<label class="control-label col-md-4">Horquilla horaria <span class="required">*</span></label>
											<div class="col-md-8">
												<select name="hor_id" id="" class="select2-select-00 col-md-12 full-width-fix required">
													<option value=""></option>
													<?php foreach ($horquillas as $item): ?>
														<?php if($hor_id == $item->hor_id) $selected = "selected"; else $selected = "" ?>
														<option <?php echo $selected ?> value="<?php echo $item->hor_id ?>"><?php echo $item->hor_name ?></option>
													<?php endforeach; ?>
												</select>
											</div>
										</div>
										<div class="form-group row">
											<?php
											if($cen_state == 1){
												$required_1 = "checked";
												$required_2 = "";
											}else{
												$required_1 = "";
												$required_2 = "checked";
											}
											 ?>
											<label class="control-label col-md-4">Estado</label>
											<div class="col-md-8">
												<label class="radio-inline"><input type="radio" value="1" name="cen_state" <?php echo $required_1 ?> class="uniform"> Activo</label>
												<label class="radio-inline"><input type="radio" value="0" name="cen_state" <?php echo $required_2 ?> class="uniform"> Inactivo</label>
												<label for="gender" class="has-error help-block" generated="true" style="display:none;"></label>
											</div>
										</div>

									</div>
									<div class="col-md-4">
										
										<div class="form-group row">
											<label class="control-label col-md-4">Descripción</label>
											<div class="col-md-8">
												<textarea class="auto form-control" name="cen_description" rows="3" style="overflow: hidden; word-wrap: break-word; resize: horizontal; height: 99px;"><?php if(isset($cen_description)) echo $cen_description ?></textarea>
											</div>
										</div>
									</div>

									<div class="col-md-2">
										<div class="form-actions">
											<input value="Aceptar" class="btn btn-primary btn-block" type="submit" name="submit">
											<input value="Aceptar + Nuevo" class="btn btn-info btn-block" type="submit" name="submit-nuevo">
											<input value="Cancelar" class="btn btn-success btn-block" type="button" onclick="location.href='<?php echo base_url() ?>backend/centros/index/1'">
										</div>
									</div>
									<input type="hidden" name="cen_id" value="<?php echo $cen_id ?>">
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
