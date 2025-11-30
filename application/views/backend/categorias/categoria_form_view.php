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
								<form method="post" class="form-horizontal row-border" id="validate_1" action="<?php echo base_url() ?>backend/categorias/<?php echo $action ?>/">


									<div class="col-md-5">

										<div class="form-group">
											<label class="control-label ">Nombre <span class="required">*</span></label>
											<div class="">
												<input type="text" name="cat_name" value="<?php if(isset($cat_name)) echo $cat_name ?>" class="form-control required" placeholder="Ingrese de categoria">
											</div>
										</div>
										<div class="form-group">
											<label class="control-label ">Sigla <span class="required">*</span></label>
											<div class="">
												<input type="text" name="cat_sigla" value="<?php if(isset($cat_sigla)) echo $cat_sigla ?>" class="form-control required">
											</div>
										</div>
										<div class="form-group">
											<?php
											if($cat_state == 1){
												$required_1 = "checked";
												$required_2 = "";
											}else{
												$required_1 = "";
												$required_2 = "checked";
											}
											 ?>
											<label class="control-label ">Estado</label>
											<div class="">
												<label class="radio-inline"><input type="radio" value="1" name="cat_state" <?php echo $required_1 ?> class="uniform"> Activo</label>
												<label class="radio-inline"><input type="radio" value="0" name="cat_state" <?php echo $required_2 ?> class="uniform"> Inactivo</label>
												<label for="gender" class="has-error help-block" generated="true" style="display:none;"></label>
											</div>
										</div>

									</div>


									<div class="col-md-5">
										
										<div class="form-group">
											<label class="control-label ">Descripción</label>
											<div class="">
												<textarea class="auto form-control" name="cat_description" rows="3" style="overflow: hidden; word-wrap: break-word; resize: horizontal; height: 99px;"><?php if(isset($cat_description)) echo $cat_description ?></textarea>
											</div>
										</div>
									</div>

									<div class="col-md-2">
										<div class="form-actions">
											<input value="Aceptar" class="btn btn-primary btn-block" type="submit" name="submit">
											<input value="Aceptar + Nuevo" class="btn btn-info btn-block" type="submit" name="submit-nuevo">
											<input value="Cancelar" class="btn btn-success btn-block" type="button" onclick="location.href='<?php echo base_url() ?>backend/categorias/index/1'">
										</div>
									</div>
									<input type="hidden" name="cat_id" value="<?php echo $cat_id ?>">
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
