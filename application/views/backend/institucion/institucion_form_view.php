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
								<form method="post" class="form-horizontal row-border" id="validate_1" action="<?php echo base_url() ?>backend/institucion/<?php echo $action ?>/"  enctype='multipart/form-data'>

									<div class="form-group">
										<div class="col-md-12">
											<div class="row">
												<div class="col-sm-6">
													<div class="form-group">
														<label class="control-label col-md-5">Nombre de la Institución. *</label>
														<div class="col-md-7">
															<input onkeyup="pulsar(this)" type="text" name="ue_nombre" value="<?php if(isset($ue_nombre)) echo $ue_nombre ?>" class="form-control required" maxlength="100">
														</div>
													</div>
												</div>
												<div class="col-sm-6">
													<div class="form-group">
														<label class="control-label col-md-5">Ciudad donde reside la Institución *</label>
														<div class="col-md-7">
															<input onkeyup="pulsar(this)" type="text" name="ue_residencia" value="<?php if(isset($ue_residencia)) echo $ue_residencia ?>" class="form-control required" maxlength="50">
														</div>
													</div>
												</div>

											</div>
										</div>
									</div>

									<div class="form-group">
										<div class="col-md-12">
											<div class="row">
												<div class="col-sm-6">
													<div class="form-group">
														<label class="control-label col-md-5">Teléfono </label>
														<div class="col-md-7">
															<input type="text" name="ue_telefono" value="<?php if(isset($ue_telefono)) echo $ue_telefono ?>" class="form-control digits"  minlength="8" maxlength="8">
															<span class="help-block">Ej.: 25299999</span>
														</div>
													</div>
												</div>
												<div class="col-sm-6">
													<div class="form-group">
														<label class="control-label col-md-5">Email de la Institución</label>
														<div class="col-md-7">
															<input type="email" name="ue_email" value="<?php if(isset($ue_email)) echo $ue_email ?>" class="form-control">
														</div>
													</div>
												</div>
											</div>
										</div>
									</div>

									<div class="form-group">
										<div class="col-md-12">
											<div class="row">
												<div class="col-sm-6">
													<div class="form-group">
														<label class="control-label col-md-5">Dirección</label>
														<div class="col-md-7">
															<input type="text" name="ue_direccion" value="<?php if(isset($ue_direccion)) echo $ue_direccion ?>" class="form-control" maxlength="255">
														</div>
													</div>
												</div>
												<div class="col-sm-6">
													<div class="form-group">
														<label class="control-label col-md-5">Rector de la institución</label>
														<div class="col-md-7">
															<input type="text" name="ue_director" value="<?php if(isset($ue_director)) echo $ue_director ?>" class="form-control" maxlength="100">
														</div>
													</div>
													<input type="hidden" name="ue_estado" value="<?php echo $ue_estado; ?>">
												</div>
											</div>
										</div>
									</div>

									<div class="form-group">
										<div class="col-md-12">
											<div class="row">
												<div class="col-sm-6">
													<div class="form-group">
														<label class="col-md-3 control-label">Logo</label>
														<div class="col-md-9">
															<?php if($ue_logo == ""): ?>
															<img src="<?php echo base_url() ?>public/backend/img/logo-general.jpg" style="height:134px;">
															<?php else: ?>
															<img src="<?php echo base_url()."".$ue_logo ?>">

															<?php endif; ?>
															<input type="file" name="ue_logo" accept="image/*" data-style="fileinput" data-inputsize="medium">
															<p class="help-block" style="margin-bottom:0px !important;">Formato (jpeg, png, gif)</p>
																<p class="help-block" style="color:red !important;margin-top:0px !important;">Ancho máximo:500px, Alto máximo: 500px</p>    
															<input type="hidden" name="ue_logo_2" value="<?php echo $ue_logo_2 ?>">
														</div>
													</div>
												</div>
											</div>
										</div>
									</div>

									<div class="form-actions">
										<input type="hidden" name="ue_id" value="<?php if(isset($ue_id)) echo $ue_id ?>">
										<input type="submit" name="submit" value="Guardar" class="btn btn-primary pull-right">
									</div>

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
