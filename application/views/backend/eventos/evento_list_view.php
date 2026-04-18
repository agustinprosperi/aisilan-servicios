	<?php require (APPPATH."views/layouts/backend/header.php"); ?>
	<?php $this->load->helper('url'); ?>
	<?php setlocale(LC_ALL, 'spanish'); ?>
	<div id="container">

		<?php require (APPPATH."views/layouts/backend/sidebarleft.php"); ?>

		<div id="content">
			<div class="container">

				<?php require (APPPATH."views/layouts/backend/crumbs-page-header.php"); ?>

				<!--=== Page Content ===-->
				<!--=== Managed Tables ===-->

				<!--=== Normal ===-->
				<div class="row">
					<div class="col-md-12">
						<?php echo $this->message->display(); ?>

						<?php if(!empty($eve_id_padre)): ?>
						<?php $_evento_padre = $this->evento_modelo->getId($eve_id_padre); ?>
						<?php if($_evento_padre): ?>
						<div class="mb20 alert alert-info font-size-20">
							<strong>Evento principal:</strong> <a class="color-white" href="<?php echo base_url(); ?>backend/eventos/editar/<?php echo $_evento_padre->eve_id ?>/0"><?php echo $_evento_padre->eve_name ?></a>
						</div>
						<?php endif; ?>
						<?php endif; ?>

						<div class="widget box">
							<div class="widget-header">
								
								<div class="toolbar left d-flex">
									<?php echo uri_current("eventos", $this->uri->segment(4), $this->evento_modelo, 'index', 'close', $this->uri->segment(5, "Simple"), $this->uri->segment(6)!=null?$this->uri->segment(6):"", $this->session->userdata("usu_tipo_actual")); ?>
								
									<form class="filter-date ml20 d-flex mb0" method="post" action="<?php echo current_url(); ?>">
										<input type="text" id="date_range_filter" name="date_range_filter" value="<?php echo htmlspecialchars($date_filter_value ?? '', ENT_QUOTES); ?>" class="form-control daterangefilter">
										<input type="submit" value="Filtrar" class="btn btn-primary btn-info ml10">
										<?php if(!empty($date_filter_value)): ?>
											<button type="submit" name="limpiar_filtro" value="1" class="btn btn-default ml5" title="Limpiar filtro">&times; Limpiar</button>
										<?php endif; ?>
									</form>

									<?php $_search_base = base_url().'backend/eventos/index/'.($sw??'').'/'.($eve_tipo??'Simple').'/'.($eve_id_padre??0).'/1'; ?>
									<form class="filter-search ml20 d-flex mb0" method="get" action="<?php echo $_search_base; ?>">
										<input type="text" name="search_text" value="<?php echo htmlspecialchars($search_text ?? '', ENT_QUOTES); ?>" class="form-control" placeholder="Buscar..." style="min-width:180px">
										<button type="submit" class="btn btn-primary ml10"><i class="icon-search"></i></button>
										<?php if(!empty($search_text)): ?>
											<a href="<?php echo $_search_base?>" class="btn btn-default ml5" title="Limpiar búsqueda">&times;</a>
										<?php endif; ?>
									</form>
									
								</div>

								<?php if(verificarPermiso("eve_nuevo")): ?>
									<div class="toolbar">
										<!--<a href="<?php echo base_url()."backend/eventos/insertar_tarea/"; ?>" class="btn btn-primary btn-info mb-2" data-toggle="modal" 
																	data-target="#crearEventoModal" >Crear Evento</a>-->
										<a href="<?php echo base_url()."backend/eventos/insertar_tarea/0/".$this->uri->segment(6); ?>" class="btn btn-primary btn-info mb-2">Nuevo Evento</a>
									</div>
								<?php endif; ?>
							</div>
							<div class="widget-content">

								<form 
									class="table-responsive" 
									name="formdelete" 
									id="formdelete" 
									action="<?php echo base_url() ?>backend/eventos/eliminar" 
									data-url="<?php echo base_url() ?>backend/eventos/activar" 
									data-url-cerrar="<?php echo base_url() ?>backend/eventos/cerrar" 
									method="post"
								>

									<table id="tabla_eventos" class="table table-striped table-bordered table-hover table-checkable">
										<thead>
											<?php
											$_cs = isset($sort) ? $sort : 'eve_date';
											$_cd = isset($sort_dir) ? $sort_dir : 'DESC';
											$_search_qs = !empty($search_text) ? '&search_text='.urlencode($search_text) : '';
											$_sort_base = current_url() . '?';
											if(!function_exists('_sort_link')){
												function _sort_link($label, $field, $current_sort, $current_dir, $base_url, $extra_qs = '') {
													$is_active = ($current_sort === $field);
													$next_dir  = ($is_active && $current_dir === 'ASC') ? 'DESC' : 'ASC';
													$icon = '';
													if($is_active) {
														$icon = ($current_dir === 'ASC') ? ' <i class="icon-angle-up"></i>' : ' <i class="icon-angle-down"></i>';
													}
													return "<a href='{$base_url}sort={$field}&dir={$next_dir}{$extra_qs}' style='color:inherit;white-space:nowrap'>{$label}{$icon}</a>";
												}
											}
											?>
											<tr>
												<?php if($this->session->userdata("usu_tipo_actual") != "Trabajador"): ?>
												<th class="checkbox-column">
													<input type="checkbox" class="uniform">
												</th>
												<?php endif; ?>
												<th><?php echo _sort_link('ID', 'eve_id', $_cs, $_cd, $_sort_base, $_search_qs); ?></th>
												<th width="25%"><?php echo _sort_link('Evento', 'eve_name', $_cs, $_cd, $_sort_base, $_search_qs); ?> / <?php echo _sort_link('Fecha', 'eve_date', $_cs, $_cd, $_sort_base, $_search_qs); ?></th>
												<th><?php echo _sort_link('Imputación', 'eve_imputacion', $_cs, $_cd, $_sort_base, $_search_qs); ?></th>
												<th><?php echo _sort_link('Proyecto', 'pro_name', $_cs, $_cd, $_sort_base, $_search_qs); ?></th>
												
												<th><?php echo _sort_link('Coordinador', 'coordinador', $_cs, $_cd, $_sort_base, $_search_qs); ?></th>
												<th>Validación<br>de Tareas</th>
												<th class="align-center"><?php echo _sort_link('Estado', 'eve_state', $_cs, $_cd, $_sort_base, $_search_qs); ?></th>
												<th class="align-center">Acción</th>
											</tr>
										</thead>
										<tbody>
											<?php foreach($lista as $valor): ?>
											<tr>
											<?php if($this->session->userdata("usu_tipo_actual") != "Trabajador"): ?>
												<td class="checkbox-column">
													<input name="seleccion[]" value="<?php echo $valor->eve_id ?>" type="checkbox" class="uniform checkeados">
												</td>
												<?php endif; ?>
												<td><?php echo $valor->eve_id; ?></td>
												<td>
													<?php if(verificarPermiso("eve_editar")): ?>
													<a href="<?php echo base_url() ?>backend/eventos/editar/<?php echo $valor->eve_id ?>">
													<?php endif; ?>
														<?php echo $valor->eve_name ?>
													<?php if(verificarPermiso("eve_editar")): ?>
													</a>
														<div><?php echo formato_fecha($valor->eve_date); ?></div>
													<?php endif; ?>
												</td>
												<td><?php echo $valor->eve_imputacion; ?></td>
												<td>
													<?php if($this->proyecto_modelo->getId($valor->pro_id) != false): ?>
														<?php echo $this->proyecto_modelo->getId($valor->pro_id)->pro_name; ?>
														<?php if($this->proyecto_modelo->getId($valor->pro_id)->pro_state==0) echo "<i class='fa fa-warning color-orange icon-parpadeo' title='Proyecto inactivo'></i>"; ?>
													<?php else: ?>
														<span class="label label-danger mb5 d-inline-block">El proyecto fue eliminado.</span>
													<?php endif; ?>
													<div>
														<?php $_cli_obj = $this->cliente_modelo->getId($valor->cli_id); ?>
														<i><u>Cliente:</u> <?php echo $_cli_obj ? htmlspecialchars($_cli_obj->cli_name) : ""; ?></i>
														<?php echo ($_cli_obj && $_cli_obj->cli_state==0) ? "<i class='fa fa-warning color-orange icon-parpadeo' title='Cliente inactivo'></i>" : ""; ?>
													</div>
												</td>
												<td nowrap="nowrap">
													<a href="<?php echo base_url() ?>backend/usuario/editar/<?php echo $valor->coo_id ?>/Coordinador" target="_blank">
													<?php 
													if($valor->coo_id != '' or $valor->coo_id != NULL){
														echo $this->usuario_modelo->getId($valor->coo_id)->usu_ap??"";
														echo " "; 
														echo $this->usuario_modelo->getId($valor->coo_id)->usu_am??"";
														echo " ";
														echo $this->usuario_modelo->getId($valor->coo_id)->usu_nombre??"";
													}
													?><i class='ml10 fa fa-external-link'></i>
													</a>
													<?php $_coo_obj = $this->usuario_modelo->getId($valor->coo_id); echo ($_coo_obj && $_coo_obj->usu_estado==0) ? "<i class='fa fa-warning color-orange icon-parpadeo' title='Coordinador inactivo'></i>" : ""; ?>
												</td>
												<td nowrap="nowrap">
													<?php if($valor->eve_tipo=="Simple"): ?>
														<?php 
														$numero_tareas = count($this->evento_modelo->getTareasRegistradasValidadas($valor->eve_id));
														$validas = count($this->evento_modelo->getTareasRegistradasValidadas($valor->eve_id, 1));
														$novalidas = count($this->evento_modelo->getTareasRegistradasValidadas($valor->eve_id, 0));
														?>
														<?php if($numero_tareas == 0): ?>
															<span class="label label-warning">Ninguna registrada</span>
														<?php elseif($numero_tareas == $validas): ?>
															<span class="label label-success">Todas validadas</span>
														<?php else: ?>
															<span class="label label-danger" title=" Tareas válidas: <?php echo $validas ?> de <?php echo $numero_tareas ?>"><?php echo $validas ?> de <?php echo $numero_tareas ?></span>
														<?php endif; ?>
													<?php else: ?>
														<?php 
														$numero_tareas = count($this->evento_modelo->getTareasRegistradasValidadas_EventoMultiple($valor->eve_id));
														$validas = count($this->evento_modelo->getTareasRegistradasValidadas_EventoMultiple($valor->eve_id, 1));
														$novalidas = count($this->evento_modelo->getTareasRegistradasValidadas_EventoMultiple($valor->eve_id, 0));
														?>
														<?php if($numero_tareas == 0): ?>
															<span class="label label-warning">Ninguna registrada</span>
														<?php elseif($numero_tareas == $validas): ?>
															<span class="label label-success">Todas validadas</span>
														<?php else: ?>
															<span class="label label-danger" title=" Tareas válidas: <?php echo $validas ?> de <?php echo $numero_tareas ?>"><?php echo $validas ?> de <?php echo $numero_tareas ?></span>
														<?php endif; ?>
													<?php endif; ?>
												</td>
												<td class="align-center">
													<?php if($valor->eve_state == 2): ?>
														<span class="icon-lock" title="Cerrado"></span>
													<?php elseif($valor->eve_state == 1): ?>
														<span class="icon-check" title="Activo"></span>
													<?php else: ?>
														<span class="icon-check-empty" title="Inactivo"></span>
													<?php endif; ?>
												</td>
												<td class="text-center">
													<ul class="table-controls">
														<li><a href="javascript:void(0)" 
																data-toggle="modal" 
																data-target="#clonarEventoModal" 
																data-eveid="<?php echo $valor->eve_id ?>"
																data-proid="<?php echo $valor->pro_id ?>"
																data-evedate="<?php echo $valor->eve_date ?>"
																data-evetipo="<?php /*echo $this->uri->segment(5, 'Simple');*/ echo $valor->eve_tipo ?>"
																data-evename="<?php echo $valor->eve_name ?>"

																data-eveidpadre="<?php echo $valor->eve_id_padre ?>"

																class="bs-tooltip clonarEvento" title="Clonar"><i class="icon-copy"></i></a> </li>
														
														<?php if(verificarPermiso("eve_editar")): ?>
															<?php if($valor->eve_tipo == "Multiple"): ?>
															<li><a href="<?php echo base_url() ?>backend/eventos/index/1/Multiple/<?php echo $valor->eve_id ?>/" class="bs-tooltip" title="Ver sub eventos"><i class="icon-folder-open"></i></a> </li>
															<?php endif; ?>
															<li><a href="<?php echo base_url() ?>backend/eventos/editar/<?php echo $valor->eve_id ?>/<?php echo $valor->eve_id_padre ?>" class="bs-tooltip" title="Editar"><i class="icon-pencil"></i></a> </li>
														<?php endif; ?>
														<?php if(verificarPermiso("eve_eliminar")): ?>
															<?php if($this->uri->segment(4) !== '0'): ?>
																<li><a href="<?php echo base_url() ?>backend/eventos/eliminar/LOG/<?php echo $valor->eve_id ?>" class="bs-tooltip confirm-dialog-inactive" title="Desactivar"><i class="icon-trash"></i></a> </li>
															<?php else: ?>
																<li><a href="<?php echo base_url() ?>backend/eventos/eliminar/DEL/<?php echo $valor->eve_id ?>" class="bs-tooltip confirm-dialog-delete" title="Eliminar definitivamente"><i class="icon-remove"></i></a> </li>
															<?php endif; ?>
														<?php endif; ?>
													</ul>
												</td>
												
											</tr>
											<?php endforeach; ?>
										</tbody>
									</table>

									<?php if($total_pages > 1): ?>
										<nav class="nav-pagination">
											<p class="text-muted">Mostrando <?php echo ($current_page - 1) * $per_page + 1; ?>-<?php echo min($current_page * $per_page, $total); ?> de <?php echo $total; ?> registros</p>
											<ul class="pagination">
												<?php
												$sw_url    = $this->uri->segment(4);
												$tipo_url  = $this->uri->segment(5, 'Simple');
												$padre_url = !empty($eve_id_padre) ? $eve_id_padre : '0';
												$_sort_qs  = '?sort='.urlencode($_cs).'&dir='.urlencode($_cd).(!empty($search_text) ? '&search_text='.urlencode($search_text) : '');
												$base_page_url = base_url().'backend/eventos/index/'.$sw_url.'/'.$tipo_url.'/'.$padre_url.'/';
												?>
												<li class="<?php echo ($current_page <= 1) ? 'disabled' : ''; ?>">
													<a href="<?php echo $base_page_url.($current_page - 1).$_sort_qs; ?>">← Ant</a>
												</li>
												<?php
												$window = 2;
												$p_start = max(1, $current_page - $window);
												$p_end   = min($total_pages, $current_page + $window);
												if($p_start > 1): ?>
													<li><a href="<?php echo $base_page_url.'1'.$_sort_qs; ?>">1</a></li>
													<?php if($p_start > 2): ?><li class="disabled"><a>...</a></li><?php endif; ?>
												<?php endif; ?>
												<?php for($p = $p_start; $p <= $p_end; $p++): ?>
													<li class="<?php echo ($p == $current_page) ? 'active' : ''; ?>">
														<a href="<?php echo $base_page_url.$p.$_sort_qs; ?>"><?php echo $p; ?></a>
													</li>
												<?php endfor; ?>
												<?php if($p_end < $total_pages): ?>
													<?php if($p_end < $total_pages - 1): ?><li class="disabled"><a>...</a></li><?php endif; ?>
													<li><a href="<?php echo $base_page_url.$total_pages.$_sort_qs; ?>"><?php echo $total_pages; ?></a></li>
												<?php endif; ?>
												<li class="<?php echo ($current_page >= $total_pages) ? 'disabled' : ''; ?>">
													<a href="<?php echo $base_page_url.($current_page + 1).$_sort_qs; ?>">Próx →</a>
												</li>
											</ul>
										</nav>
									<?php endif; ?>

									<?php if(verificarPermiso("eve_eliminar")): ?>
										<?php if($this->uri->segment(4) !== '0'): ?>
											<button name="btn_eliminar" class="confirm-dialog-inactive-various btn btn-info" data-modal="true" data-text="" data-layout="top" title="Desactivar eventos seleccionados"><i class="icon-remove"></i> Desactivar</button>
										<?php else: ?>
											<button name="btn_eliminar" class="confirm-dialog-delete-various btn btn-danger" data-modal="true" data-text="" data-layout="top" title="Elimianar eventos seleccionados"><i class="icon-remove"></i> Eliminar definitivamente</button>
											<button name="" class="confirm-dialog-activar-various btn btn-default" data-modal="true" data-text="" data-layout="top" title="Activar eventos seleccionados"><span class="icon-check" title="Activo"></span> Activar</button>
										<?php endif; ?>
										<button name="" class="confirm-dialog-cerrar-various btn btn-default" data-modal="true" data-text="" data-layout="top" title="Cerrar eventos seleccionados"><span class="icon-lock" title="Cerrado"></span> Cerrar</button>
									<?php endif; ?>

									<input type="hidden" name="eve_tipo" value="<?php echo $this->uri->segment(5, "Simple") ?>" />

								</form>

							</div>
						</div>
					</div>
				</div>
				<!-- /Normal -->




			</div>
			<!-- /.container -->

		</div>
	</div>

<!-- Modal -->
<div class="modal fade" id="clonarEventoModal" role="dialog" aria-labelledby="clonarEventoModalLabel" aria-hidden="true">
  <div id="modal-clonar-evento" class="modal-dialog" role="document" style="width:450px;">
    <form id="form-modal-clonar-evento" method="post" class="modal-content validate" action="<?php echo base_url() ?>backend/eventos/clonar_evento/">
        <div class="modal-header">
            <h5 class="modal-title">Duplicar Evento</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true" onclick="location.reload();">&times;</span>
            </button>
      	</div>
		  <div class="modal-body">
		  	<label class="control-label text-left">Ingrese nombre</label>
			<div class="mb20">
				<input type="text" id="eve_name" name="eve_name" value="" class="form-control required">
			</div>	
			<div id="wrap-eve-date" style="display:none;">
				<label class="control-label text-left">Seleccione fecha</label>
				<div class="mb20">
					<input type="text" id="eve_date" name="eve_date" value="" class="form-control required">
				</div>	
			</div>
			<div id="wrap-eve-date-range">
				<label class="control-label text-left">Seleccione rango de fechas</label>
				<div>
					<input type="text" id="date_range" name="date_range" value="" class="form-control daterange required">
				</div>			
			</div>
      	</div>
      	<div class="modal-footer">
        	<button type="button" class="btn btn-secondary" data-dismiss="modal" onclick="location.reload();">Cerrar</button>
        	<button type="submit" class="btn btn-primary">Clonar</button>

			<input type="hidden" id="eve_id" name="eve_id" value="">
			<input type="hidden" id="pro_id" name="pro_id" value="">

			<input type="hidden" id="date_start" name="date_start" value="">
			<input type="hidden" id="date_end" name="date_end" value="">
			<input type="hidden" id="eve_tipo" name="eve_tipo" value="">

			<input type="hidden" id="eve_id_padre" name="eve_id_padre" value="">
      	</div>
	</form>
  </div>
</div>
<script>
jQuery('.clonarEvento').on('click', function(){
	jQuery('#eve_id').val(jQuery(this).data('eveid'));
	jQuery('#pro_id').val(jQuery(this).data('proid'));
	jQuery('#date_start').val(jQuery(this).data('evedate'));
	jQuery('#date_end').val(jQuery(this).data('evedate'));
	jQuery('#eve_tipo').val(jQuery(this).data('evetipo'));
	jQuery('#eve_name').val('CLON - ' + jQuery(this).data('evename'));

	jQuery('#eve_id_padre').val(jQuery(this).data('eveidpadre'));
	
	jQuery('.daterange').daterangepicker({
		startDate: jQuery(this).data('evedate'),
		endDate: jQuery(this).data('evedate'),
		opens: 'center',
		locale: {
			format: 'YYYY-MM-DD',
			cancelLabel: 'Cancelar',
			applyLabel: 'Aceptar',
		}
	}, function(start, end, label) {
		//console.log("A new date selection was made: " + start.format('YYYY-MM-DD') + ' to ' + end.format('YYYY-MM-DD'));
		jQuery('#date_start').val(start.format('YYYY-MM-DD'));
		jQuery('#date_end').val(end.format('YYYY-MM-DD'));
	});

	if(jQuery(this).data('evetipo') == "Multiple"){
		$('#wrap-eve-date').show();
		$('#wrap-eve-date-range').hide();
	}else{
		$('#wrap-eve-date-range').show();
		$('#wrap-eve-date').hide();
	}
});

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

	jQuery('.daterangefilter').daterangepicker({
		startDate: jQuery(this).data('evedate'),
		endDate: jQuery(this).data('evedate'),
		opens: 'center',
		locale: {
			format: 'YYYY-MM-DD',
			cancelLabel: 'Cancelar',
			applyLabel: 'Aceptar',
		}
	});

});
</script>