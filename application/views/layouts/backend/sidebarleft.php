<div id="sidebar" class="sidebar-fixed">
	<div id="sidebar-content">
		<!--=== Navigation ===-->
		<ul id="nav">
			<li <?php if(isset($this->page_current_index)) echo $this->page_current_index ?>>
				<a href="<?php echo base_url(); ?>backend">
					<i class="icon-dashboard"></i>
					Escritorio
				</a>
			</li>

			<li <?php if(isset($this->page_current_perfil)) echo $this->page_current_perfil ?>>
				<a href="<?php echo base_url(); ?>backend/admin">
					<i class="fa fa-user"></i>
					Perfil de usuario
				</a>
			</li>

			<?php if(verificarPermiso("usu")): ?>
			<li <?php if(isset($this->page_current_usu)) echo $this->page_current_usu ?>>
				<a href="javascript:void(0);">
					<i class="fa fa-users"></i>
					Usuarios
				</a>
				<ul class="sub-menu">
					<?php if(verificarPermiso("usu_adm_lista")): ?>
					<li <?php if(isset($this->current_usuario_administrador)) echo $this->current_usuario_administrador ?>>
						<a href="<?php echo base_url(); ?>backend/usuario/index/1/Administrador">
						<i class="icon-angle-right"></i>
						Lista de administradores
						</a>
					</li>
					<?php endif; ?>
					<?php if(verificarPermiso("usu_coo_lista")): ?>
					<li <?php if(isset($this->current_usuario_coordinador)) echo $this->current_usuario_coordinador ?>>
						<a href="<?php echo base_url(); ?>backend/usuario/index/1/Coordinador">
						<i class="icon-angle-right"></i>
						Lista de coordinadores
						</a>
					</li>
					<?php endif; ?>
					<?php if(verificarPermiso("usu_tra_lista")): ?>
					<li <?php if(isset($this->current_usuario_trabajador)) echo $this->current_usuario_trabajador ?>>
						<a href="<?php echo base_url(); ?>backend/usuario/index/1/Trabajador">
						<i class="icon-angle-right"></i>
						Lista de trabajadores
						</a>
					</li>
					<?php endif; ?>
				</ul>
			</li>
			<?php endif; ?>
			<?php if(verificarPermiso("cen")): ?>
			<li <?php if(isset($this->page_current_centro)) echo $this->page_current_centro ?>>
				<a href="javascript:void(0);">
					<i class="icon-th-large"></i>
					Centros de trabajo
				</a>
				<ul class="sub-menu">
					<?php if(verificarPermiso("cen_nuevo")): ?>
					<li <?php if(isset($this->current_centro_insertar)) echo $this->current_centro_insertar ?>>
						<a href="<?php echo base_url(); ?>backend/centros/insertar">
						<i class="icon-angle-right"></i>
						Nuevo centro
						</a>
					</li>
					<?php endif; ?>
					<?php if(verificarPermiso("cen_lista")): ?>
					<li <?php if(isset($this->current_centro_lista)) echo $this->current_centro_lista ?>>
						<a href="<?php echo base_url(); ?>backend/centros/index/1">
						<i class="icon-angle-right"></i>
						Lista de centros de trabajo
						</a>
					</li>
					<?php endif; ?>
				</ul>
			</li>
			<?php endif; ?>
			<?php if(verificarPermiso("cli")): ?>
			<li <?php if(isset($this->page_current_cliente)) echo $this->page_current_cliente ?>>
				<a href="javascript:void(0);">
					<i class="fa fa-male"></i>
					Clientes
				</a>
				<ul class="sub-menu">
					<?php if(verificarPermiso("cli_nuevo")): ?>
					<li <?php if(isset($this->current_cliente_insertar)) echo $this->current_cliente_insertar ?>>
						<a href="<?php echo base_url(); ?>backend/clientes/insertar">
						<i class="icon-angle-right"></i>
						Nuevo cliente
						</a>
					</li>
					<?php endif; ?>
					<?php if(verificarPermiso("cli_lista")): ?>
					<li <?php if(isset($this->current_cliente_lista)) echo $this->current_cliente_lista ?>>
						<a href="<?php echo base_url(); ?>backend/clientes/index/1">
						<i class="icon-angle-right"></i>
						Lista de clientes
						</a>
					</li>
					<?php endif; ?>
				</ul>
			</li>
			<?php endif; ?>
			<?php if(verificarPermiso("pro")): ?>
			<li <?php if(isset($this->page_current_proyecto)) echo $this->page_current_proyecto ?>>
				<a href="javascript:void(0);">
					<i class="fa fa-book"></i>
					Proyectos
				</a>
				<ul class="sub-menu">
					<?php if(verificarPermiso("pro_nuevo")): ?>
					<li <?php if(isset($this->current_proyecto_insertar)) echo $this->current_proyecto_insertar ?>>
						<a href="<?php echo base_url(); ?>backend/proyectos/insertar">
						<i class="icon-angle-right"></i>
						Nuevo proyecto
						</a>
					</li>
					<?php endif; ?>
					<?php if(verificarPermiso("pro_lista")): ?>
					<li <?php if(isset($this->current_proyecto_lista)) echo $this->current_proyecto_lista ?>>
						<a href="<?php echo base_url(); ?>backend/proyectos/index/1">
						<i class="icon-angle-right"></i>
						Lista de proyectos
						</a>
					</li>
					<?php endif; ?>
				</ul>
			</li>
			<?php endif; ?>
			<?php if(verificarPermiso("eve")): ?>
			<li <?php if(isset($this->page_current_evento)) echo $this->page_current_evento ?>>
				<a href="javascript:void(0);">
					<i class="fa fa-calendar"></i>
					Eventos
				</a>
				<ul class="sub-menu">
					<?php if(verificarPermiso("eve_nuevo")): ?>
					<li <?php if(isset($this->current_evento_insertar)) echo $this->current_evento_insertar ?>>
						<a href="<?php echo base_url(); ?>backend/eventos/insertar_tarea">
						<i class="icon-angle-right"></i>
						Nuevo evento
						</a>
					</li>
					<?php endif; ?>
					<?php if(verificarPermiso("eve_lista") and $this->session->userdata("usu_tipo_actual") != "Trabajador"): ?>
					<li <?php if(isset($this->current_evento_lista_simple)) echo $this->current_evento_lista_simple ?>>
						<a href="<?php echo base_url(); ?>backend/eventos/index/1/Simple">
						<i class="icon-angle-right"></i>
						Eventos simples
						</a>
					</li>
					<?php endif; ?>
					<?php if(verificarPermiso("eve_lista") and $this->session->userdata("usu_tipo_actual") != "Trabajador"): ?>
					<li <?php if(isset($this->current_evento_lista_multiple)) echo $this->current_evento_lista_multiple ?>>
						<a href="<?php echo base_url(); ?>backend/eventos/index/1/Multiple">
						<i class="icon-angle-right"></i>
						Eventos multiples
						</a>
					</li>
					<?php endif; ?>
					<?php if(verificarPermiso("eve_mi_lista")): ?>
					<li <?php if(isset($this->current_evento_lista)) echo $this->current_evento_lista ?>>
						<a href="<?php echo base_url(); ?>backend/eventos/miseventos/">
						<i class="icon-angle-right"></i>
						Mis eventos
						</a>
					</li>
					<?php endif; ?>
				</ul>
			</li>
			<?php endif; ?>
			<?php //if(verificarPermiso("rep")): ?>
			<li <?php if(isset($this->page_current_reporte)) echo $this->page_current_reporte ?>>
				<a href="<?php echo base_url(); ?>backend/reportes/index">
					<i class="fa fa-bar-chart"></i>
					Reporte general
				</a>
				<!--<ul class="sub-menu">
					
					<li <?php if(isset($this->current_reporte_general)) echo $this->current_reporte_general ?>>
						<a href="<?php echo base_url(); ?>backend/reportes/index">
						<i class="icon-angle-right"></i>
							Reporte general
						</a>
					</li>
					
					<li <?php if(isset($this->current_test_lista)) echo $this->current_test_lista ?>>
						<a href="<?php echo base_url(); ?>backend/reportes/test">
						<i class="icon-angle-right"></i>
							Reporte test
						</a>
					</li>
				</ul>-->
			</li>
			<?php //endif; ?>
			<li <?php if(isset($this->page_current_notificaciones)) echo $this->page_current_notificaciones ?>>
				<a href="<?php echo base_url(); ?>backend/notificaciones/index">
					<i class="fa fa-bell-o"></i>
					Notificaciones
				</a>
				<!--<ul class="sub-menu">
					<li <?php if(isset($this->current_notificaciones_lista)) echo $this->current_notificaciones_lista ?>>
						<a href="<?php echo base_url(); ?>backend/notificaciones/index">
						<i class="icon-angle-right"></i>
							Ver Notificaciones
						</a>
					</li>
					
					<li <?php //if(isset($this->current_mensajes_lista)) echo $this->current_mensajes_lista ?>>
						<a href="<?php //echo base_url(); ?>backend/mensajes/index">
						<i class="icon-angle-right"></i>
							Ver mensajes
						</a>
					</li>
				</ul>-->
			</li>
			<?php if(verificarPermiso("config")): ?>
			<li <?php if(isset($this->page_current_setting)) echo $this->page_current_setting ?>>
				<a href="javascript(0);">
					<i class="icon-cogs"></i>
					Configuraciones
				</a>
				<ul class="sub-menu">
					<?php if(verificarPermiso("institucion")): ?>
					<li <?php if(isset($this->current_institucion)) echo $this->current_institucion ?>>
						<a href="<?php echo base_url(); ?>backend/institucion/editar/2">
						<i class="icon-angle-right"></i>
						Institución
						</a>
					</li>
					<?php endif; ?>
					<?php if(verificarPermiso("cat_lista")): ?>
					<li <?php if(isset($this->current_categoria_lista)) echo $this->current_categoria_lista ?>>
						<a href="<?php echo base_url(); ?>backend/categorias/index/1">
						<i class="icon-angle-right"></i>
						Categorías
						</a>
					</li>
					<?php endif; ?>
					<?php if(verificarPermiso("tar_lista")): ?>
					<li <?php if(isset($this->current_tarea_lista)) echo $this->current_tarea_lista ?>>
						<a href="<?php echo base_url(); ?>backend/tareas/index/1">
						<i class="icon-angle-right"></i>
						Tareas
						</a>
					</li>
					<?php endif; ?>
					<?php if(verificarPermiso("fer_lista")): ?>
					<li <?php if(isset($this->current_feriados)) echo $this->current_feriados ?>>
						<a href="<?php echo base_url(); ?>backend/feriados/index/?fer_type=Nacional">
						<i class="icon-angle-right"></i>
						Feriados
						</a>
					</li>
					<?php endif; ?>
					<?php if(verificarPermiso("prov_lista")): ?>
					<li <?php if(isset($this->current_provincia_lista)) echo $this->current_provincia_lista ?>>
						<a href="<?php echo base_url(); ?>backend/provincias/">
						<i class="icon-angle-right"></i>
						Provincias
						</a>
					</li>
					<?php endif; ?>
					<?php if(verificarPermiso("loc_lista")): ?>
					<li <?php if(isset($this->current_localidad_lista)) echo $this->current_localidad_lista ?>>
						<a href="<?php echo base_url(); ?>backend/localidades/">
						<i class="icon-angle-right"></i>
						Localidades
						</a>
					</li>
					<?php endif; ?>
					<?php if(verificarPermiso("hor_lista")): ?>
					<li <?php if(isset($this->current_horquilla_horaria_lista)) echo $this->current_horquilla_horaria_lista ?>>
						<a href="<?php echo base_url(); ?>backend/horquillahoraria/index/1">
						<i class="icon-angle-right"></i>
						Horquilla horaria
						</a>
					</li>
					<?php endif; ?>
					<?php if(verificarPermiso("config_permiso")): ?>
					<li <?php if(isset($this->current_permisos)) echo $this->current_permisos ?>>
						<a href="<?php echo base_url(); ?>backend/usuario/permisos">
							<i class="icon-angle-right"></i>
							Permisos
						</a>
					</li>
					<?php endif; ?>
				</ul>
			</li>
			<?php endif; ?>
		</ul>

		<div class="sidebar-widget align-center">
			<div class="btn-group" data-toggle="buttons" id="theme-switcher">
				<label class="btn active">
					<input type="radio" name="theme-switcher" data-theme="bright"><i class="icon-sun"></i> Claro
				</label>
				<label class="btn">
					<input type="radio" name="theme-switcher" data-theme="dark"><i class="icon-moon"></i> Oscuro
				</label>
			</div>
		</div>



	</div>
	<div id="divider" class="resizeable"></div>
</div>




<!-- Modal dialog -->
<div class="bootbox modal fade in" id="myModal" role="dialog">
	<div class="modal-dialog">
		<div class="modal-content" id="myModal_content">

		</div><!-- /.modal-content -->
	</div><!-- /.modal-dialog -->

</div><!--modal dialog-->
