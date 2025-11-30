<!-- Logo -->
<div class="logo">
		<center class="text-login">
			<div id="logo-login"><img src="<?php echo base_url().$logo ?>" alt=""></div>
			<h2 class="title-1">SISTEMA "EDUCA"</h2>


		</center>
	</div>
	<!-- /Logo -->

	<!-- Login Box -->
	<div class="box">
		<div class="content">
			<!-- Login Formular -->
			<form class="form-vertical" action="<?php echo base_url() ?>backend/login/verification_ok" method="post">
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
                        <i class="icon-lock"></i>
						<input type="text" name="usu_code_login" class="form-control" placeholder="Ingrese código" autofocus="autofocus" data-rule-required="true" data-msg-required="Ingrese el código" />
					</div>
				</div>
				<!-- /Input Fields -->

				<!-- Form Actions -->
				<div class="form-actions">

					<input type="submit" name="submit" value="Ingresar" class="submit btn btn-primary pull-right"/>
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


