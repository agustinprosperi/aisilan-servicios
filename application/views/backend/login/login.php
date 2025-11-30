<!-- Logo -->
	<div class="logo">
		<center class="text-login">
			<h2 class="title-1">SISTEMA</h2>
			<div id="logo-login"><img src="<?php echo base_url().$logo ?>" alt=""></div>
		</center>
	</div>
	<!-- /Logo -->

	<!-- Login Box -->
	<div class="box">
		<div class="content">
			<!-- Login Formular -->
			<form class="form-vertical" action="<?php echo base_url() ?>backend/login/very_sesion" method="post">
				<!-- Title -->
				<!--<h3 class="form-title">Ingresar a su cuenta</h3>-->
				<!-- <center><img src="<?php //echo base_url(); ?>public/backend/img/logo0.png" alt="logos" style="margin:auto" /></center> -->
				<!-- Error Message -->
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
						<i class="icon-user"></i>
						<input type="text" name="usu_username" class="form-control" placeholder="Nombre de Usuario" autofocus="autofocus" data-rule-required="true" data-msg-required="Por favor ingrese su User Name." />
					</div>
				</div>
				<div class="form-group">
					<!--<label for="password">Password:</label>-->
					<div class="input-icon">
						<i class="icon-lock"></i>
						<input type="password" name="usu_password" class="form-control" placeholder="Contraseña" data-rule-required="true" data-msg-required="Por favor ingrese su password." />
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
				<a href="<?php echo base_url() ?>backend/login/forgot_password" class="">Perdió su password?</a>
			</div>
		</div>

		<!-- /Forgot Password Form -->
	</div>
	<!-- /Login Box -->

	<!-- Single-Sign-On (SSO) -->
	<!--<div class="single-sign-on">
		<span>or</span>

		<button class="btn btn-facebook btn-block">
			<i class="icon-facebook"></i> Sign in with Facebook
		</button>

		<button class="btn btn-twitter btn-block">
			<i class="icon-twitter"></i> Sign in with Twitter
		</button>

		<button class="btn btn-google-plus btn-block">
			<i class="icon-google-plus"></i> Sign in with Google
		</button>
	</div>-->
	<!-- /Single-Sign-On (SSO) -->

	<!-- Footer -->
	<!--<div class="footer">
		<a href="#" class="sign-up">Don't have an account yet? <strong>Sign Up</strong></a>
	</div>-->
	<!-- /Footer -->
