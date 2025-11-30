<!-- Header -->
	<header class="header navbar navbar-fixed-top" role="banner">
		<!-- Top Navigation Bar -->
		<div class="container">

			<!-- Only visible on smartphones, menu toggle -->
			<ul class="nav navbar-nav">
				<li class="nav-toggle"><a href="javascript:void(0);" title=""><i class="icon-reorder"></i></a></li>
				<li class="logo-mobile">
					<a class="" href="http://localhost/aisilan3//backend"><img src="<?php echo base_url(); ?>/public/backend/img/uploads/GZkZ7WQwbz1.png" alt="logo" width="100"></a>
				</li>
			</ul>

			<!-- Logo -->
			<a id="logo" class="navbar-brand" href="<?php echo base_url()."/backend" ?>"><img src="<?php echo base_url().helperGetEmpresa('institucion_modelo', 'getLogo', $this->session->userdata("ue_id_actual")); ?>" alt="logo" width="70%"></a>
			<!-- /logo -->

			<!-- Sidebar Toggler -->
			<a href="#" class="toggle-sidebar bs-tooltip" data-placement="bottom" data-original-title="Navegación">
				<i class="icon-reorder"></i>
			</a>
			<!-- /Sidebar Toggler -->

			<!-- Top Left Menu -->
			<ul class="nav navbar-nav navbar-left hidden-xs hidden-sm">
				<li class="date_current"><a>
					<i class="icon-calendar"></i> 
					<?php $meses = array("Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre"); $dias = array("Domingo","Lunes","Martes","Miercoles","Jueves","Viernes","Sábado"); ?>
					<?php echo $dias[date('w')].", ".date('d')." de ".$meses[date('n')-1]. " del ".date('Y') ; ?>
				</a></li>
			</ul>
			<!-- /Top Left Menu -->

			<!-- Top Right Menu -->
			<ul class="nav navbar-nav navbar-right">
				
				<!-- User notifications -->
				<li class="dropdown notifications-menu">
					<a href="#" class="dropdown-toggle position-relative" data-toggle="dropdown" aria-expanded="true" title="Ver notificaciones">
						<i class="fa fa-bell-o"></i>
						<span class="label label-warning"><?php echo count(helperGetNotificacionesMenu()); ?></span>
					</a>
					<ul class="dropdown-menu">
						<?php if(count(helperGetNotificacionesMenu()) > 0): ?>
						<li>
							
							<ul class="menu">
								<?php foreach(helperGetNotificacionesMenu(10) as $item): ?>
								<li>
									<a class="ancla" href="<?php echo base_url(); ?>backend/notificaciones/index/#not-<?php echo $item->not_id ?>" title="Click para ver más"><?php echo notificacion_tipo_menu($item->not_type); ?> <?php echo $item->not_message; ?></a>
								</li>
								<?php  endforeach; ?>
							</ul>
						</li>
						<li class="footer"><a href="<?php echo base_url() ?>backend/notificaciones/index">Ver todas las notificaciones</a></li>
						<?php else: ?>
						<li class="ac">No existe notificaciones...</li>
						
						<?php endif; ?>
					</ul>
				</li>
				<!-- User notifications -->
				<!--
				<li class="dropdown notifications-menu">
					<a href="#" class="dropdown-toggle position-relative" data-toggle="dropdown" aria-expanded="true">
						<i class="fa fa-comments"></i>
						<span class="label label-warning">9</span>
					</a>
					<ul class="dropdown-menu">
						<li class="header">Mensajes</li>
						<li>
							<ul class="menu">
								<li>
									<a href="#"><i class="fa fa-users text-aqua"></i> 5 new members joined today </a>
								</li>
								<li>
									<a href="#"><i class="fa fa-warning text-yellow"></i> Very long description here that may not fit into the page and may cause design problems </a>
								</li>
								<li>
									<a href="#"><i class="fa fa-users text-red"></i> 5 new members joined </a>
								</li>
								<li>
									<a href="#"><i class="fa fa-shopping-cart text-green"></i> 25 sales made </a>
								</li>
								<li>
									<a href="#"><i class="fa fa-user text-red"></i> You changed your username </a>
								</li>
							</ul>
						</li>
						<li class="footer"><a href="#">Ver todos</a></li>
					</ul>
				</li>-->
				
				<!-- User Login Dropdown -->
				<li class="user_info welcome">
					<a>Bienvenido, <?php echo $this->session->userdata('usu_ap')." ".$this->session->userdata('usu_am')." ".$this->session->userdata('usu_nombre') ?> !</a>
				</li>
				<li class="dropdown user">
					<a href="#" class="dropdown-toggle" data-toggle="dropdown">
						<i class="icon-male"></i>
						<span class="username"><?php echo $this->session->userdata('username'); ?></span>
						<i class="icon-caret-down small"></i>
					</a>
					<ul class="dropdown-menu">
						<li><a href="<?php echo base_url() ?>backend/admin"><i class="icon-user"></i>Editar mi perfil</a></li>
						<li><a href="<?php echo base_url() ?>backend/login/logout"><i class="icon-key"></i>Salir del sistema</a></li>
					</ul>
				</li>
				<!-- /user login dropdown -->
			</ul>
			<!-- /Top Right Menu -->
		</div>
		<!-- /top navigation bar -->


	</header> <!-- /.header -->
