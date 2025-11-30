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
								<form method="post" class="form-horizontal row-border" id="validate_1" action="<?php echo base_url() ?>backend/tareas/<?php echo $action ?>/">

									<div class="col-md-5">

										<div class="form-group">
											<label class="control-label col-md-4">Nombre <span class="required">*</span></label>
											<div class="col-md-8">
												<input type="text" name="tar_name" value="<?php if(isset($tar_name)) echo $tar_name ?>" class="form-control required" placeholder="Ingrese el nombre de tarea">
											</div>
										</div>
										<div class="form-group">
											<label class="control-label col-md-4">Sigla <span class="required">*</span></label>
											<div class="col-md-8">
												<input type="text" name="tar_sigla" value="<?php if(isset($tar_sigla)) echo $tar_sigla ?>" class="form-control required" placeholder="Ingrese sigla">
											</div>
										</div>
										<div class="form-group">
											<?php
											if($tar_state == 1){
												$required_1 = "checked";
												$required_2 = "";
											}else{
												$required_1 = "";
												$required_2 = "checked";
											}
											 ?>
											<label class="control-label col-md-4">Estado</label>
											<div class="col-md-8">
												<label class="radio-inline"><input type="radio" value="1" name="tar_state" <?php echo $required_1 ?> class="uniform"> Activo</label>
												<label class="radio-inline"><input type="radio" value="0" name="tar_state" <?php echo $required_2 ?> class="uniform"> Inactivo</label>
												<label for="gender" class="has-error help-block" generated="true" style="display:none;"></label>
											</div>
										</div>

									</div>


									<div class="col-md-5">
										<div class="form-group">
											<label class="control-label col-md-4">Categorias *</label>
											<div class="col-md-8">
												<select multiple name="cat_ids[]" class="select2-select-00 col-md-12 full-width-fix required">
													<option value=""></option>
													<?php foreach ($categorias_lista as $item): ?>
														<?php  
														$obj = array_column($categorias_selected, null, 'cat_id')[$item->cat_id] ?? false;
														$selected = $obj?"selected":"";	
														?>
														<option value="<?php echo $item->cat_id ?>" <?php echo $selected ?>><?php echo $item->cat_name ?></option>
													<?php endforeach; ?>
												</select>
											</div>
										</div>
										<div class="form-group">
											<label class="control-label col-md-4">Descripción</label>
											<div class="col-md-8">
												<textarea class="auto form-control" name="tar_description" rows="3" style="overflow: hidden; word-wrap: break-word; resize: horizontal; height: 99px;"><?php if(isset($tar_description)) echo $tar_description ?></textarea>
											</div>
										</div>
									</div>

									<div class="col-md-2">
										<div class="form-actions">
											<input value="Aceptar" class="btn btn-primary btn-block" type="submit" name="submit">
											<input value="Aceptar + Nuevo" class="btn btn-info btn-block" type="submit" name="submit-nuevo">
											<input value="Cancelar" class="btn btn-success btn-block" type="button" onclick="location.href='<?php echo base_url() ?>backend/tareas/index/1'">
										</div>
									</div>
									<input type="hidden" name="tar_id" value="<?php echo $tar_id ?>">
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
