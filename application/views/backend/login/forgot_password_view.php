<!-- Logo -->
<div class="logo">
		<center class="text-login">
			<h2 class="title-1">SISTEMA</h2>
			<div id="logo-login"><img src="<?php echo base_url().$logo ?>" alt=""></div>
			<br>
			<h4>Perdió su password?</h4>
		</center>
	</div>
	<!-- /Logo -->

	<!-- Login Box -->
	<div class="box">
		<div class="content">
			<!-- Login Formular -->
			<form class="form-vertical" action="<?php echo base_url() ?>backend/login/forgot_password" method="post">
				<br>
				<?php if(isset($mensaje)):?>
				<div class="alert fade in alert-danger" style="">
					<i class="icon-remove close" data-dismiss="alert"></i>
			        	<?php echo $mensaje;?>
				</div>
 				<?php endif;?>

				<!-- Input Fields -->
				<div class="form-group">
					<!--<label for="username">Username:</label>-->
					<div class="input-icon">
                        <i class="icon-email"></i>
						<input type="email" name="email" class="form-control" placeholder="Ingrese su email" autofocus="autofocus" data-rule-required="true" data-msg-required="Ingrese su email" />
					</div>
				</div>
				<!-- /Input Fields -->

				<!-- Form Actions -->
				<div class="form-actions">

					<input type="submit" name="submit" value="Resetear password" class="submit btn btn-primary pull-right"/>
				</div>
			</form>
			<!-- /Login Formular -->


		</div> <!-- /.content -->
		<div class="inner-box">
			<div class="content">
				<a href="<?php echo base_url() ?>backend/login" class="">Regresar al login</a>
			</div>
		</div>

		<!-- /Forgot Password Form -->
	</div>
	<!-- /Login Box -->


