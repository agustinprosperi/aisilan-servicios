
<?php require (APPPATH."views/layouts/backend/header.php"); ?>

<link href="https://gitcdn.github.io/bootstrap-toggle/2.2.2/css/bootstrap-toggle.min.css" rel="stylesheet">
<script src="https://gitcdn.github.io/bootstrap-toggle/2.2.2/js/bootstrap-toggle.min.js"></script>

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

					<?php if($eve_id_padre != 0): ?>
					<div class="mb20 alert alert-info font-size-20">
						<strong>Evento principal:</strong> <a class="color-white" title="Editar evento principal" href="<?php echo base_url(); ?>backend/eventos/editar/<?php echo $this->evento_modelo->getId($eve_id_padre)->eve_id ?>/0"><?php echo $this->evento_modelo->getId($eve_id_padre)->eve_name ?> <i class="ml10 fa fa-external-link"></i></a>
					</div>
					<?php endif; ?>

					<div class="widget box">
						<div class="widget-header">
							<h4>Información del evento</h4>
						</div>
						<div class="widget-content">
							<form method="post" class="form-horizontal row-border row validate" action="<?php echo base_url() ?>backend/eventos/<?php echo $action ?>/<?php echo $this->uri->segment(5) ?>">
								<div class="col-md-10">
									<div class="row">
										<div class="col-md-6">
											<div class="form-group">
												<label class="control-label">Nombre <span class="required">*</span></label>
												<div class="">
													<input type="text" name="eve_name" value="<?php if(isset($eve_name)) echo $eve_name ?>" class="form-control required" placeholder="Ingrese nombre del evento">
												</div>
											</div>
										</div>
										<div class="col-md-6">
											<div class="form-group">
												<label class="control-label">Proyecto <span class="required">*</span></label>
												<div class="">
												
													<?php 
													$proyecto = $this->proyecto_modelo->getId($pro_id);
													if($proyecto !== false){
														if($pro_id != 0 && $proyecto->pro_state == 0): ?>
														<div class="alert alert-warning">
															<i class="icon fa fa-warning"></i> El proyecto <strong>"<?php echo $proyecto->pro_name; ?>"</strong> esta inactivo, debe reemplazar por otro.
														</div>
														<?php endif; 
													}elseif($eve_id != '0'){
														echo '<span class="label label-danger mb10 d-inline-block">El proyecto fue eliminado, seleccione otro.</span>';
													}
													?>
													<select 
														name="pro_id"
														class="select2-select-00 col-md-12 full-width-fix required"
														onchange="
															cargar_cliente_name_ajax('<?php echo base_url()."backend/eventos/cargar_cliente_name_ajax/"; ?>', this.value, 'cliente_name');
															cargar_cliente_id_ajax('<?php echo base_url()."backend/eventos/cargar_cliente_id_ajax/"; ?>', this.value, 'cliente_id');

															cargar_coordinador_name_ajax('<?php echo base_url()."backend/eventos/cargar_coordinador_name_ajax/"; ?>', this.value, 'coordinador_name');
															cargar_coordinador_id_ajax('<?php echo base_url()."backend/eventos/cargar_coordinador_id_ajax/"; ?>', this.value, 'coordinador_id');

															cargar_tipo_horario_ajax('<?php echo base_url()."backend/eventos/cargar_tipo_horario_ajax/"; ?>', this.value, 'script_horario');
														"
														placeholder="Seleccione un proyecto"
													>
														<option value=""></option>
														<?php foreach ($proyectos as $item): ?>
															<?php if($pro_id == $item->pro_id) $selected = "selected"; else $selected = "" ?>
															<?php 
															if($item->pro_state == 0 && $pro_id == $item->pro_id) 
																$disabled = ""; 
															elseif($item->pro_state == 0) 
																$disabled = "disabled"; 
															else  
																$disabled = ""; 
															?>
															<option class="<?php echo $item->pro_state==0?"color-red":""; ?>" <?php echo $selected ?> value="<?php echo $item->pro_id ?>" <?php echo $disabled ?>>
																<?php echo $item->pro_name ?>
																<?php if($item->pro_state == 0) echo "<strong>(Inactivo)</strong>"; ?>
															</option>
														<?php endforeach; ?>
													</select>
												</div>
											</div>
										</div>
									</div>
									<div class="row">
										<div class="col-md-6">
											<div class="form-group">
												<label class="control-label">Cliente</label>
												<div id="cliente_name">
													<?php if($cli_id != 0): ?>
														<a href="<?php echo base_url() ?>backend/clientes/editar/<?php echo $cli_id ?>" target="_blank" class="control-label not-bold">
															<?php echo $cli_id?$this->cliente_modelo->getId($cli_id)->cli_name:""; ?><i class='ml10 fa fa-external-link'></i>
														</a>
													<?php echo ($cli_id != 0 && $this->cliente_modelo->getId($cli_id)->cli_state==0)?"<i class='fa fa-warning color-orange icon-parpadeo' title='Cliente inactivo'></i>":""; ?>
													<?php else: ?>
														<i>Ninguno</i>
													<?php endif; ?>
												</div>
											</div>
										</div>
										<div class="col-md-6">
											<div class="form-group">
												<label class="control-label">Coordinador</label>
												<div id="coordinador_name">
													<?php if($coo_id != 0): ?>
														<a href="<?php echo base_url() ?>backend/usuario/editar/<?php echo $coo_id ?>/Coordinador" target="_blank" class="control-label not-bold">
															<?php echo $coo_id?$this->usuario_modelo->getId($coo_id)->usu_ap." ".$this->usuario_modelo->getId($coo_id)->usu_am." ".$this->usuario_modelo->getId($coo_id)->usu_nombre:""; ?><i class='ml10 fa fa-external-link'></i>
														</a>
													<?php echo ($coo_id != 0 && $this->usuario_modelo->getId($coo_id)->usu_estado==0)?"<i class='fa fa-warning color-orange icon-parpadeo' title='Coordinador inactivo'></i>":""; ?>
												    <?php else: ?>
														<i>Ninguno</i>
													<?php endif; ?>
												</div> 
											</div>
										</div>
									</div>
									<div class="row">
										<div class="col-md-6">
											<div class="form-group">
												<?php
												if($eve_state == 0){
													$required_0 = "checked";
													$required_1 = "";
													$required_2 = "";
												}if($eve_state == 1){
													$required_0 = "";
													$required_1 = "checked";
													$required_2 = "";
												}if($eve_state == 2){
													$required_0 = "";
													$required_1 = "";
													$required_2 = "checked";
												}
												?>
												<label class="control-label">Estado</label>
												<div class="">
													<label class="radio-inline"><input type="radio" value="1" name="eve_state" <?php echo $required_1 ?> > Activo</label>
													<label class="radio-inline"><input type="radio" value="0" name="eve_state" <?php echo $required_0 ?> > Inactivo</label>
													<label class="radio-inline"><input type="radio" value="2" name="eve_state" <?php echo $required_2 ?> > Cerrado</label>
													<label for="gender" class="has-error help-block" generated="true" style="display:none;"></label>
												</div>
											</div>
										</div>

										
						
										<div class="col-md-6 d-flex">
											<?php if($eve_id_padre == '0'): ?>
											<div class="form-group mr40">
												<?php
												if($eve_tipo == 'Simple'){
													$required_simple = "checked";
													$required_multiple = "";
												}
												if($eve_tipo == 'Multiple'){
													$required_simple = "";
													$required_multiple = "checked";
												}
												?>
												<label class="control-label">Tipo de evento </label>
												<div class="d-flex flex-column">
													<label class="radio mb3"><input class="eve_tipo" type="radio" value="Simple" name="eve_tipo" <?php echo $required_simple ?> class="uniform"> Simple</label>
													<label class="radio mb3"><input class="eve_tipo" type="radio" value="Multiple" name="eve_tipo" <?php echo $required_multiple ?> class="uniform"> Multiple</label>
													<label for="gender" class="has-error help-block" generated="true" style="display:none;"></label>
												</div>
											</div>
											<script type="text/javascript">
												jQuery('.eve_tipo').change(function(){
													if(jQuery(this).val() == "Simple"){
														jQuery("#trabajadores").show();
														jQuery("#eve-btn-cerrar").attr('href','<?php echo base_url(); ?>backend/eventos/index/1/Simple');
														<?php if($action == 'editar'): ?>
														jQuery("#ver-subeventos").hide();
														<?php endif; ?>
													}else{
														jQuery("#trabajadores").hide();
														jQuery("#eve-btn-cerrar").attr('href','<?php echo base_url(); ?>backend/eventos/index/1/Multiple');
														<?php if($action == 'editar'): ?>
														jQuery("#ver-subeventos").show();
														<?php endif; ?>
													}
												});
											</script>
											<?php else: ?>
												<input name="eve_tipo" type="hidden" value="Simple" />
											<?php endif; ?>
											<div class="form-group">
												<?php
												if($eve_imputacion == 'Red de teatros'){
													$required_ninguno = "";
													$required_red = "checked";
													$required_terceros = "";
												}elseif($eve_imputacion == 'Terceros'){
													$required_ninguno = "";
													$required_red = "";
													$required_terceros = "checked";
												}else{
													$required_ninguno = "checked";
													$required_red = "";
													$required_terceros = "";
												}
												?>
												<label class="control-label">Imputación</label>
												<div class="d-flex flex-column">
													<label class="radio position-relative mb3">
														<input class="eve_imputacion " type="radio" value="" name="eve_imputacion" <?php echo $required_ninguno ?> class="uniform"> Ninguno
													</label>
													<label class="radio position-relative mb3">
														<input class="eve_imputacion " type="radio" value="Red de teatros" name="eve_imputacion" <?php echo $required_red ?> class="uniform"> Red de teatros
													</label>
													<label class="radio position-relative">
														<input class="eve_imputacion " type="radio" value="Terceros" name="eve_imputacion" <?php echo $required_terceros ?> class="uniform"> Terceros
													</label>
												</div>
												<label for="gender" class="has-error help-block" generated="true" style="display:none;"></label>
											</div>
										</div>
											
											
									</div>
									

									<div class="row">
										<div class="col-md-6">
											<label class="control-label text-left">Fecha del evento <span class="required">*</span></label>
												<input type="text" id="eve_date" name="eve_date" value="<?php echo $eve_date ?>" class="form-control required" placeholder="Fecha del evento" readonly>

												<script>
													$(function() {
														$('#eve_date').daterangepicker({
															autoUpdateInput: false,
															timePicker: false,
															singleDatePicker: true,
															showDropdowns: true,
															cancelLabel: 'Limpiar',
															applyLabel: 'Aplicar',
															locale: {
																format: 'YYYY-MM-DD',
																cancelLabel: 'Limpiar',
																applyLabel: 'Aplicar',
																"daysOfWeek": [
																	"Do",
																	"Lu",
																	"Ma",
																	"Mi",
																	"Ju",
																	"Vi",
																	"Sa"
																],
																"monthNames": [
																	"Enero",
																	"Febrero",
																	"Marzo",
																	"Abril",
																	"Mayo",
																	"Junio",
																	"Julio",
																	"Agosto",
																	"Septiembre",
																	"Octubre",
																	"Noviembre",
																	"Diciembre"
																],
																"firstDay": 1
															},
															
														});

														$('#eve_date').on('apply.daterangepicker', function(ev, picker) {
															$(this).val(picker.startDate.format('YYYY-MM-DD'));
														});
													});
												</script>
										</div>
										<div class="col-md-6">
											<div class="form-group">
												<label class="control-label">Descripción</label>
												<div class="">
													<textarea class="auto form-control" name="eve_description" rows="2" style="overflow: hidden; word-wrap: break-word; resize: horizontal;" maxlength="255"><?php if(isset($eve_description)) echo $eve_description ?></textarea>
												</div>
											</div>
										</div>
									</div>
											
									<div id="script_horario"></div>
											
											
											
								</div>
								<div class="col-md-2">
									<div class="form-actions">
										<input value="Guardar" class="btn btn-primary btn-block" type="submit" name="submit">
										<?php 
										if($eve_tipo == "Multiple" && $eve_id_padre == 0)
											$cerrar_url = base_url()."backend/eventos/index/1/Multiple";
										elseif($eve_tipo == "Simple" && $eve_id_padre == 0)
											$cerrar_url = base_url()."backend/eventos/index/1/Simple";
										else
											$cerrar_url = base_url()."backend/eventos/index/1/Multiple/".$eve_id_padre;
										?>
										<a id="eve-btn-cerrar" class="btn btn-success btn-block mb30" href='<?php echo $cerrar_url; ?>'>
											Cerrar
										</a>
										
										<?php if($eve_tipo == "Multiple" && $eve_id_padre == 0): ?>
										<a id="ver-subeventos" class="btn btn-primary btn-block" href='<?php echo base_url() ?>backend/eventos/index/1/<?php echo $eve_tipo ?>/<?php echo $eve_id ?>'>
											Ver Subeventos
										</a>
										<?php endif; ?>
									</div>
								</div>
								<input type="hidden" name="eve_id" value="<?php echo $eve_id ?>">
								<input type="hidden" name="cli_id" value="<?php echo $cli_id ?>" id="cliente_id">
								<input type="hidden" name="coo_id" value="<?php echo $coo_id ?>" id="coordinador_id">
								<input type="hidden" name="eve_tipo_horario" value="<?php echo $eve_tipo_horario; ?>" class="input-tipo-horario">

								
								<input type="hidden" id="eve_id_padre" name="eve_id_padre" value="<?php echo $eve_id_padre; ?>">
							</form>
						</div>
					</div><!-- widget box -->
					<!-- /Validation Example 1 -->
					
					<div class="widget box position-relative" id="trabajadores" style="display:<?php echo $eve_tipo=="Simple"?"block":"none"; ?>">
						<?php if($eve_id == '0'): ?>
							<div class="overlay-insert-first"><h2>Para añadir trabajadores<br>al evento primero créelo!</h2></div>
							
						<?php endif; ?>
							<div id="on-overlay-if-change-project" class="overlay-insert-first" style="display:none;"><h2>Para añadir trabajadores<br>al evento primero guarde los cambios</h2></div>
						<div class="widget-header">
							<h4>Trabajadores del evento</h4>
							<!-- Button trigger modal -->
							<button
									type="button" class="btn btn-info btn-sm float-right" 
									data-toggle="modal" 
									data-target="#tareaTrabajadorModal" 
									style="margin-top:4px;margin-right:-7px"
								>Seleccione trabajador</button>
							
						</div>
						<div class="widget-content">
							<?php if(count($lista_trabajadores_evento)>0): $i = 1; ?>
							<table class="table table-striped table-bordered table-hover table-checkable">
								<thead>
									<tr>
										<th class="text-center" width="40">#</th>
										<th>
											<div class="row">
												<div class="col-md-4">Apellidos y nombres</div>
												<div class="col-md-4">Tareas asignadas</div>
												<div class="col-md-4">Tareas validadas</div>
											</div>
										</th>
										<th class="align-center" width="80">Acción</th>
									</tr>
								</thead>
								<tbody>
									
										<?php foreach($lista_trabajadores_evento as $item): ?>
										<tr id="tra_id_<?php echo $item->tra_id; ?>">
											<td class="text-center"><?php echo $i; ?></td>
											<td>
												<?php 
												if($eve_tipo_horario == "Partido"){
													$tareas_morning = $this->evento_modelo->getListaTareasByEveIdTraId($item->eve_id, $item->tra_id, 'morning');
													$tareas_afternoon = $this->evento_modelo->getListaTareasByEveIdTraId($item->eve_id, $item->tra_id, 'afternoon'); 
													$tareas_night = $this->evento_modelo->getListaTareasByEveIdTraId($item->eve_id, $item->tra_id, 'night'); 

													$tareas_registrada_morning = $this->evento_modelo->getListaTareasRegistradasByEveIdTraId($item->eve_id, $item->tra_id, 'morning');
													$tareas_registrada_afternoon = $this->evento_modelo->getListaTareasRegistradasByEveIdTraId($item->eve_id, $item->tra_id, 'afternoon'); 
													$tareas_registrada_night = $this->evento_modelo->getListaTareasRegistradasByEveIdTraId($item->eve_id, $item->tra_id, 'night'); 

													$tareas_validada_morning = $this->evento_modelo->getListaTareasRegistradaValidadaByEveIdTraId($item->eve_id, $item->tra_id, 'morning');
													$tareas_validada_afternoon = $this->evento_modelo->getListaTareasRegistradaValidadaByEveIdTraId($item->eve_id, $item->tra_id, 'afternoon'); 
													$tareas_validada_night = $this->evento_modelo->getListaTareasRegistradaValidadaByEveIdTraId($item->eve_id, $item->tra_id, 'night'); 
												}else{
													$tareas_continuo = $this->evento_modelo->getListaTareasByEveIdTraId($item->eve_id, $item->tra_id, 'Continuo');
													$tareas_registrada_continuo = $this->evento_modelo->getListaTareasRegistradasByEveIdTraId($item->eve_id, $item->tra_id, 'Continuo');

													$tareas_validada_continuo = $this->evento_modelo->getListaTareasRegistradaValidadaByEveIdTraId($item->eve_id, $item->tra_id, 'Continuo');
												}
												?>
												<div class="row">
													<div class="col-md-4">
														<div class="tra_name">
															<a title="Editar tareas asignadas" href="<?php echo base_url() ?>backend/eventos/lista_tareas_trabajador/<?php echo $item->eve_id ?>/<?php echo $item->tra_id ?>">
																<?php echo $item->usu_ap ?> <?php echo $item->usu_am ?> <?php echo $item->usu_nombre ?> 
															</a>
															<?php echo $item->usu_estado==0?"<i class='fa fa-warning color-orange icon-parpadeo' title='Trabajador inactivo'></i>":""; ?>
															<a title="Editar trabajador" target="_blank" href="<?php echo base_url(); ?>backend/usuario/editar/<?php echo $item->tra_id ?>/Trabajador">
																<i class='ml10 fa fa-external-link'></i>
															</a>
														</div>
													</div>
													<div class="col-md-4">
														<?php 
														if($eve_tipo_horario == "Partido") echo count($tareas_morning) + count($tareas_afternoon) + count($tareas_night); 
														else echo count($tareas_continuo);
														?>
													</div>
													<div class="col-md-4">
													<?php 
													if($eve_tipo_horario == "Partido"){
														$sum = count($tareas_registrada_morning) + count($tareas_registrada_afternoon) + count($tareas_registrada_night); 
														$sum_val = count($tareas_validada_morning) + count($tareas_validada_afternoon) + count($tareas_validada_night); 
													}else{
														$sum = count($tareas_registrada_continuo);
														$sum_val = count($tareas_validada_continuo);
													}
													
													if($sum > 0) 
														echo $sum_val." de ".$sum; 
													else 
														echo '<span class="label label-warning font-size-14">Ninguna registrada</span>';
													?>
													</div>
												</div>
												
												<div id="row-more-info-<?php echo $item->tra_id ?>" class="pb10 row-more-info" style="display:<?php echo (isset($_GET['open'])&&$_GET['open']==$item->tra_id)?"block":"none"; ?>;">
													<?php if($eve_tipo_horario == "Partido"): ?>
													<div class="row">
														<div class="col-md-5">
															<?php if(count($tareas_morning) > 0): ?>
															<table class="w-100 mb10">
																<thead>
																	<tr>
																		<th>Tareas asignadas &ndash; Mañana</th>
																		<th width="100">Horas</th>
																	</tr>
																</thead>
																<tbody>
																	<?php foreach($tareas_morning as $tar): ?>
																	<tr>
																		<td><?php 
																			echo getTareaByNombres($tar->eve_tar_ids);
																			modal_notas_de_tarea($tar);
																			?>
																		</td>
																		<td><?php echo date('H:i', strtotime($tar->eve_tar_horario_from)); echo " - "; echo date('H:i', strtotime($tar->eve_tar_horario_to)); ?></td>
																	</tr>
																	<?php endforeach; ?>
																</tbody>
															</table>
															<?php endif; ?>
														</div>
														<div class="col-md-7">
															<?php if(count($tareas_registrada_morning) > 0): ?>
															<table class="w-100 mb10">
																<thead>
																	<tr>
																		<th width="50%">Tareas registradas &ndash; Mañana</th>
																		<th width="50%">Horas</th>
																	</tr>
																</thead>
																<tbody>
																	<?php foreach($tareas_registrada_morning as $tar): ?>
																	<tr>
																		<td>
																			<span title="ID: <?php echo $tar->eve_tar_id ?>"><?php echo getTareaByNombres($tar->eve_tar_ids);?></span>
																			<?php modal_notas_del_trabajdor($tar); ?>
																		</td>
																		<td class="d-flex align-items-center">
																			<?php $notificaciones = $this->notificacion_modelo->getNotificacionesByEveTarId($tar->eve_tar_id); ?>
																			<div class="mr10"><?php echo date('H:i', strtotime($tar->eve_tar_horario_from)); echo " - "; echo date('H:i', strtotime($tar->eve_tar_horario_to)); ?></div>
																			<div><input 
																					id="ck-validar-<?php echo $tar->eve_tar_id ?>"
																					class="toggle" 
																					type="checkbox" 
																					data-toggle="toggle" 
																					data-on="OK" 
																					data-off="<?php echo ($tar->eve_validar==2)?"Invalidada":"Validar"; ?>" 
																					value="checked"
																					<?php echo ($tar->eve_validar==1)?"checked":""; ?>
																					onchange="ajax_validar_tarea('<?php echo base_url()."backend/tareas/ajax_validar_tarea/"; ?>', '<?php echo $tar->eve_tar_id ?>', this.checked, 'script_validar');"
																					<?php echo ($tar->eve_validar==2)?"disabled":""; ?>
																				>
																			</div>
																			<div>
																				<span 
																				    class="notifications-menu position-relative"
																					data-toggle="modal" 
																					data-target="#notaParaTrabajadorModal-<?php echo $tar->eve_tar_id ?>"
																					title="Enviar mensaje al trabajador"
																					onclick="document.getElementById('form-sms-<?php echo $tar->eve_tar_id ?>').reset();"
																				>
																					<i class="fa fa-envelope-o cursor icon-email" aria-hidden="true"></i>
																					<?php if(count($notificaciones) > 0): ?>
																					<span class="label label-warning"><?php echo count($notificaciones) ?></span>
																					<?php endif; ?>
																				</span>
																				
																				<?php modal_notas_para_trabajador($tar, $eve_id, $notificaciones); ?>
																			</div>
																		</td>
																	</tr>
																	<?php endforeach; ?>
																</tbody>
															</table>
															<?php elseif(count($tareas_morning) > 0 && count($tareas_registrada_morning) == 0): ?>
																<div class="alert alert-warning">
																	<i class="icon fa fa-warning mr10"></i>El trabajador aún no registro tareas de la mañana.
																</div>
															<?php endif; ?>
														</div>
													</div><!-- row -->
													<div class="row">
														<div class="col-md-5">
															<?php if(count($tareas_afternoon) > 0): ?>
															<table class="w-100 mb10">
																<thead>
																	<tr>
																		<th>Tareas asignadas &ndash; Tarde</th>
																		<th width="100">Horas</th>
																	</tr>
																</thead>
																<tbody>
																	<?php foreach($tareas_afternoon as $tar): ?>
																	<tr>
																		<td><?php 
																			echo getTareaByNombres($tar->eve_tar_ids);
																			modal_notas_de_tarea($tar);
																			?>
																		</td>
																		<td><?php echo date('H:i', strtotime($tar->eve_tar_horario_from)); echo " - "; echo date('H:i', strtotime($tar->eve_tar_horario_to)); ?></td>
																	</tr>
																	<?php endforeach; ?>
																</tbody>
															</table>
															<?php endif; ?>
														</div>
														<div class="col-md-7">
															<?php if(count($tareas_registrada_afternoon) > 0): ?>
															<table class="w-100 mb10">
																<thead>
																	<tr>
																		<th width="50%">Tareas registradas &ndash; Tarde</th>
																		<th width="50%">Horas</th>
																	</tr>
																</thead>
																<tbody>
																	<?php foreach($tareas_registrada_afternoon as $tar): ?>
																	<tr>
																		<td>
																			<span title="ID: <?php echo $tar->eve_tar_id ?>"><?php echo getTareaByNombres($tar->eve_tar_ids);?></span>
																			<?php modal_notas_del_trabajdor($tar); ?>
																		</td>
																		<td class="d-flex align-items-center">
																			<?php $notificaciones = $this->notificacion_modelo->getNotificacionesByEveTarId($tar->eve_tar_id); ?>
																			<div class="mr10"><?php echo date('H:i', strtotime($tar->eve_tar_horario_from)); echo " - "; echo date('H:i', strtotime($tar->eve_tar_horario_to)); ?></div>
																			<div><input 
																					id="ck-validar-<?php echo $tar->eve_tar_id ?>"
																					class="toggle" 
																					type="checkbox" 
																					data-toggle="toggle" 
																					data-on="OK" 
																					data-off="<?php echo ($tar->eve_validar==2)?"Invalidada":"Validar"; ?>" 
																					value="checked"
																					<?php echo ($tar->eve_validar==1)?"checked":""; ?>
																					onchange="ajax_validar_tarea('<?php echo base_url()."backend/tareas/ajax_validar_tarea/"; ?>', '<?php echo $tar->eve_tar_id ?>', this.checked, 'script_validar');"
																					<?php echo ($tar->eve_validar==2)?"disabled":""; ?>
																				>
																			</div>
																			<div>
																				<span 
																				    class="notifications-menu position-relative"
																					data-toggle="modal" 
																					data-target="#notaParaTrabajadorModal-<?php echo $tar->eve_tar_id ?>"
																					title="Enviar mensaje al trabajador"
																					onclick="document.getElementById('form-sms-<?php echo $tar->eve_tar_id ?>').reset();"
																				>
																					<i class="fa fa-envelope-o cursor icon-email" aria-hidden="true"></i>
																					<?php if(count($notificaciones) > 0): ?>
																					<span class="label label-warning"><?php echo count($notificaciones) ?></span>
																					<?php endif; ?>
																				</span>
																				
																				<?php modal_notas_para_trabajador($tar, $eve_id, $notificaciones); ?>
																			</div>
																		</td>
																	</tr>
																	<?php endforeach; ?>
																</tbody>
															</table>
															<?php elseif(count($tareas_afternoon) > 0 && count($tareas_registrada_afternoon) == 0): ?>
																<div class="alert alert-warning">
																	<i class="icon fa fa-warning mr10"></i>El trabajador aún no registro tareas de la tarde.
																</div>
															<?php endif; ?>
														</div>
													</div><!-- row -->
													<div class="row">
														<div class="col-md-5">
															<?php if(count($tareas_night ) > 0): ?>
															<table class="w-100">
																<thead>
																	<tr>
																		<th>Tareas asignadas &ndash; Noche</th>
																		<th width="100">Horas</th>
																	</tr>
																</thead>
																<tbody>
																	<?php foreach($tareas_night as $tar): ?>
																	<tr>
																		<td><?php 
																			echo getTareaByNombres($tar->eve_tar_ids);
																			modal_notas_de_tarea($tar);
																			?>
																		</td>
																		<td><?php echo date('H:i', strtotime($tar->eve_tar_horario_from)); echo " - "; echo date('H:i', strtotime($tar->eve_tar_horario_to)); ?></td>
																	</tr>
																	<?php endforeach; ?>
																</tbody>
															</table>
															<?php endif; ?>
														</div>
														<div class="col-md-7">
															<?php if(count($tareas_registrada_night ) > 0): ?>
															<table class="w-100">
																<thead>
																	<tr>
																		<th width="50%">Tareas registradas &ndash; Noche</th>
																		<th width="50%">Horas</th>
																	</tr>
																</thead>
																<tbody>
																	<?php foreach($tareas_registrada_night as $tar): ?>
																	<tr>
																		<td>
																			<span title="ID: <?php echo $tar->eve_tar_id ?>"><?php echo getTareaByNombres($tar->eve_tar_ids);?></span>
																			<?php modal_notas_del_trabajdor($tar); ?>
																		</td>
																		<td class="d-flex align-items-center">
																			<?php $notificaciones = $this->notificacion_modelo->getNotificacionesByEveTarId($tar->eve_tar_id); ?>
																			<div class="mr10"><?php echo date('H:i', strtotime($tar->eve_tar_horario_from)); echo " - "; echo date('H:i', strtotime($tar->eve_tar_horario_to)); ?></div>
																			<div><input 
																					id="ck-validar-<?php echo $tar->eve_tar_id ?>"
																					class="toggle" 
																					type="checkbox" 
																					data-toggle="toggle" 
																					data-on="OK" 
																					data-off="<?php echo ($tar->eve_validar==2)?"Invalidada":"Validar"; ?>" 
																					value="checked"
																					<?php echo ($tar->eve_validar==1)?"checked":""; ?>
																					onchange="ajax_validar_tarea('<?php echo base_url()."backend/tareas/ajax_validar_tarea/"; ?>', '<?php echo $tar->eve_tar_id ?>', this.checked, 'script_validar');"
																					<?php echo ($tar->eve_validar==2)?"disabled":""; ?>
																				>
																			</div>
																			<div>
																				<span 
																				    class="notifications-menu position-relative"
																					data-toggle="modal" 
																					data-target="#notaParaTrabajadorModal-<?php echo $tar->eve_tar_id ?>"
																					title="Enviar mensaje al trabajador"
																					onclick="document.getElementById('form-sms-<?php echo $tar->eve_tar_id ?>').reset();"
																				>
																					<i class="fa fa-envelope-o cursor icon-email" aria-hidden="true"></i>
																					<?php if(count($notificaciones) > 0): ?>
																					<span class="label label-warning"><?php echo count($notificaciones) ?></span>
																					<?php endif; ?>
																				</span>
																				
																				<?php modal_notas_para_trabajador($tar, $eve_id, $notificaciones); ?>
																			</div>
																		</td>
																	</tr>
																	<?php endforeach; ?>
																</tbody>
															</table>
															<?php elseif(count($tareas_night) > 0 && count($tareas_registrada_night) == 0): ?>
																<div class="alert alert-warning">
																	<i class="icon fa fa-warning mr10"></i>El trabajador aún no registro tareas de la noche.
																</div>
															<?php endif; ?>
														</div>
													</div><!-- row -->
													<?php else: // horario continuo ?>
													<div class="row">
														<div class="col-md-5">
															<?php if(count($tareas_continuo ) > 0): ?>
															<table class="w-100 mb10">
																<thead>
																	<tr>
																		<th>Tareas asignadas</th>
																		<th width="100">Horas</th>
																	</tr>
																</thead>
																<tbody>
																	<?php foreach($tareas_continuo as $tar): ?>
																	<tr>
																		<td><?php 
																			echo getTareaByNombres($tar->eve_tar_ids);
																			modal_notas_de_tarea($tar);
																			?>
																		</td>
																		<td><?php echo date('H:i', strtotime($tar->eve_tar_horario_from)); echo " - "; echo date('H:i', strtotime($tar->eve_tar_horario_to)); ?></td>
																	</tr>
																	<?php endforeach; ?>
																</tbody>
															</table>
															<?php endif; ?>
														</div>
														<div class="col-md-7">
															<?php if(count($tareas_registrada_continuo ) > 0): ?>
															<table class="w-100 mb10">
																<thead>
																	<tr>
																		<th width="50%">Tareas registradas</th>
																		<th width="50%">Horas</th>
																	</tr>
																</thead>
																<tbody>
																	<?php foreach($tareas_registrada_continuo as $tar): ?>
																	<tr>
																		<td>
																			<span title="ID: <?php echo $tar->eve_tar_id ?>"><?php echo getTareaByNombres($tar->eve_tar_ids);?></span>
																			<?php modal_notas_del_trabajdor($tar); ?>
																		</td>
																		<td class="d-flex align-items-center">
																			<?php $notificaciones = $this->notificacion_modelo->getNotificacionesByEveTarId($tar->eve_tar_id); ?>
																			<div class="mr10"><?php echo date('H:i', strtotime($tar->eve_tar_horario_from)); echo " - "; echo date('H:i', strtotime($tar->eve_tar_horario_to)); ?></div>
																			<div><input 
																					id="ck-validar-<?php echo $tar->eve_tar_id ?>"
																					class="toggle" 
																					type="checkbox" 
																					data-toggle="toggle" 
																					data-on="OK" 
																					data-off="<?php echo ($tar->eve_validar==2)?"Invalidada":"Validar"; ?>" 
																					value="checked"
																					<?php echo ($tar->eve_validar==1)?"checked":""; ?>
																					onchange="ajax_validar_tarea('<?php echo base_url()."backend/tareas/ajax_validar_tarea/"; ?>', '<?php echo $tar->eve_tar_id ?>', this.checked, 'script_validar');"
																					<?php echo ($tar->eve_validar==2)?"disabled":""; ?>
																				>
																			</div>
																			<div>
																				<span 
																				    class="notifications-menu position-relative"
																					data-toggle="modal" 
																					data-target="#notaParaTrabajadorModal-<?php echo $tar->eve_tar_id ?>"
																					title="Enviar mensaje al trabajador"
																					onclick="document.getElementById('form-sms-<?php echo $tar->eve_tar_id ?>').reset();"
																				>
																					<i class="fa fa-envelope-o cursor icon-email" aria-hidden="true"></i>
																					<?php if(count($notificaciones) > 0): ?>
																					<span class="label label-warning"><?php echo count($notificaciones) ?></span>
																					<?php endif; ?>
																				</span>
																				
																				<?php modal_notas_para_trabajador($tar, $eve_id, $notificaciones); ?>
																			</div>
																		</td>
																	</tr>
																	<?php endforeach; ?>
																</tbody>
															</table>
															<?php elseif(count($tareas_continuo) > 0 && count($tareas_registrada_continuo) == 0): ?>
																El trabajador aún no registro tareas.						<?php endif; ?>
														</div>
													</div><!-- row -->
													<?php endif; // fin horario continuo ?>
													<div id="script_validar"></div>
												</div><!-- row-more-info -->
											</td>
											<td class="text-center">
												<ul class="table-controls">
													<li>
														<span title="Ver más" class="more-info cursor" data-traid="<?php echo $item->tra_id ?>"><i class="icon-eye-open"></i></span>
													</li>
													<li><a 
															title="Editar tareas asignadas"	
															href="<?php echo base_url() ?>backend/eventos/lista_tareas_trabajador/<?php echo $item->eve_id ?>/<?php echo $item->tra_id ?>" 
															class="bs-tooltip" 
															title="Editar">
																<i class="icon-pencil"></i>
														</a>
													</li>
													<li>
														<a 
															href="<?php echo base_url() ?>backend/eventos/eliminar_trabajador/<?php echo $item->eve_id ?>/<?php echo $item->tra_id ?>" 
															onclick="return confirm('¿Estás seguro de eliminar al trabajador?')"
															class="bs-tooltip" 
															title="Eliminar">
																<i class="icon-remove"></i>
														</a>
													</li>
													<!--<li class="dropdown">
														<a href="#" class="dropdown-toggle" data-toggle="dropdown">
															<img src="<?php echo base_url(); ?>public/backend/img/icon-three-dots.svg" width="10" style="max-width:inherit" />
															<i class="icon-caret-down small"></i>
														</a>
														<ul class="dropdown-menu">
															<li><a href="http://localhost/aisilan3/backend/admin"><i class="icon-user"></i>Leido</a></li>
															<li><a href="http://localhost/aisilan3/backend/login/logout"><i class="icon-key"></i>No leido</a></li>
														</ul>
													</li>-->
												</ul>
											</td>
										</tr>
										<?php $i++; endforeach; ?>
									
								</tbody>
							</table>
							<?php else: ?>
								<tr><td align="center" colspan="8">No existe trabajadores!</td></tr>
							<?php endif; ?>
						</div>
					</div>
					
				</div>
			</div>
		</div>
		<!-- /.container -->

	</div>
</div>

<!-- Modal -->
<div class="modal fade" id="tareaTrabajadorModal" role="dialog" aria-labelledby="tareaTrabajadorModal" aria-hidden="true">
  <div class="modal-dialog modal-dialog-500" role="document">
    <form id="formTareaTrabajadorModal" method="post" class="modal-content validate2" action="" >
        <div class="modal-header">
            <h5 class="modal-title" id="trabajadorModalLabel">Seleccione un trabajador</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true" onclick="location.reload();">&times;</span>
            </button>
      	</div>
      	<div class="modal-body">
			<div class="form-group">
				<label class="control-label">Trabajador *</label>
				<div class="">
					<select 
						id="tra_id" 
						name="tra_id" 
						class="select2-select-00 col-md-12 full-width-fix required" 
						placeholder="- Seleccione Trabajador -"
						
					>
						<option value=""></option>
						<?php foreach ($trabajadores as $item): ?>
							<option value="<?php echo $item->usu_id ?>"><?php echo $item->usu_ap ?> <?php echo $item->usu_am ?> <?php echo $item->usu_nombre ?></option>
						<?php endforeach; ?>
					</select>
				</div>
			</div>
      	</div>
      	<div class="modal-footer">
        	<button type="button" class="btn btn-secondary" data-dismiss="modal" onclick="location.reload();">Cancelar</button>
        	<button type="submit" class="btn btn-primary">Aceptar</button>

			<input type="hidden" id="eve_id" name="eve_id" value="<?php echo $eve_id ?>">
			
      	</div>
		<script>
			jQuery('#tra_id').on('change', function(){
				var tra_id = jQuery(this).val();
				jQuery('#formTareaTrabajadorModal').attr("action", "<?php echo base_url() ?>backend/eventos/lista_tareas_trabajador/<?php echo $eve_id ?>/"+tra_id)
			})
		</script>
	</form>
  </div>
</div>


<!-- Modal -->
<div class="modal fade" id="notaTrabajadorModal" role="dialog" aria-labelledby="notaTrabajadorModal" aria-hidden="true">
  <div class="modal-dialog modal-dialog-500" role="document">
    <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="trabajadorModalLabel">Notas del trabajador</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true" onclick="location.reload();">&times;</span>
            </button>
      	</div>
      	<div class="modal-body">
			
      	</div>
      	<div class="modal-footer">
        	<button type="button" class="btn btn-secondary" data-dismiss="modal" onclick="location.reload();">Cerrar</button>
      	</div>
	</div>
  </div>
</div>
<!-- end Modal -->