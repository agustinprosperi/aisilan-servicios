	<?php require (APPPATH."views/layouts/backend/header.php"); ?>

	<div id="container">
		<?php require (APPPATH."views/layouts/backend/sidebarleft.php"); ?>
		<!-- /Sidebar -->

		<div id="content">
			<div class="container">

				<?php require (APPPATH."views/layouts/backend/crumbs-page-header.php"); ?>



				<!--=== Page Content ===-->
				<!--=== Statboxes ===-->
				<div class="row row-bg"> <!-- .row-bg -->

					<div class="col-md-12">
						
						<div class="row row-icons">
							<?php if(verificarPermiso("config_institucion")): ?>
							<div class="col-md-3">
								<a href="<?php echo base_url(); ?>backend/institucion/editar/2" class="home-icon">
									<i class="fas fa-school"></i>
									Institución
								</a>
							</div>
							<?php endif; ?>
							<?php if(verificarPermiso("usu_lista")): ?>
							<div class="col-md-3">
								<a href="<?php echo base_url(); ?>backend/usuario/index/1" class="home-icon">
									<i class="fas fa-users"></i>
									Usuarios
								</a>
							</div>
							<?php endif; ?>
							
							<div class="col-md-3">
								<a href="<?php echo base_url(); ?>backend/admin/" class="home-icon">
									<i class="icon-user"></i>
									Perfil
								</a>
							</div>
							
						</div>
					</div>
				</div> <!-- /.row -->

			</div>
			<!-- /.container -->

		</div>
	</div>
