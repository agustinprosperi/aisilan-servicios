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
							<h4>Información del evento</h4>
                            <a  class="btn btn-info float-right mt4" 
                                style="margin-right:-7px;"
                                href='<?php echo base_url() ?>backend/eventos/editar/<?php echo $eve_id ?>'
                            >Retornar al evento</a>
						</div>
						<div class="widget-content">
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label class="control-label">Nombre</label>
                                        <div class=""><?php echo $eve_name ?> <?php echo $_evento->eve_state==0?"<i class='fa fa-warning color-orange icon-parpadeo' title='Evento inactivo'></i>":""; ?></div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label class="control-label">Proyecto</label>
                                        <div class=""><?php echo $proyecto ?> <?php echo $_proyecto->pro_state==0?"<i class='fa fa-warning color-orange icon-parpadeo' title='Proyecto inactivo'></i>":""; ?></div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label class="control-label">Cliente</label>
                                        <div class=""><?php echo $cliente ?> <?php echo $_cliente->cli_state==0?"<i class='fa fa-warning color-orange icon-parpadeo' title='Cliente inactivo'></i>":""; ?></div>
                                    </div>
                                </div>
                            
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label class="control-label">Fecha</label>
                                        <div class=""><?php echo formato_fecha($eve_date) ?></div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label class="control-label">Coordinador</label>
                                        <div class="">
                                            <a href="<?php echo base_url() ?>backend/usuario/editar/<?php echo $coo_id ?>/Coordinador" target="_blank">
                                                <?php echo $coordinador ?><i class='ml10 fa fa-external-link'></i>
                                            </a>
                                            <?php echo $_coordinador->usu_estado==0?"<i class='fa fa-warning color-orange icon-parpadeo' title='Coordinador inactivo'></i>":""; ?>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <?php if($eve_description): ?>
                                    <div class="form-group">
                                        <label class="control-label">Descripción</label>
                                        <div class=""><?php echo $eve_description ?></div>
                                    </div>
                                    <?php endif; ?>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label class="control-label">Trabajador</label>
                                        <div class="">
                                            <a href="<?php echo base_url() ?>backend/usuario/editar/<?php echo $tra_id ?>/Trabajador" target="_blank">
                                                <?php echo $trabajador ?><i class='ml10 fa fa-external-link'></i>
                                            </a>
                                            <?php echo $_trabajador->usu_estado==0?"<i class='fa fa-warning color-orange icon-parpadeo' title='Trabajador inactivo'></i>":""; ?>
                                        </div>
                                    </div>
                                </div>
                            </div>
						</div>
					</div><!-- widget box -->
                    <div class="row">
                    <?php if($eve_tipo_horario == 'Partido'): ?>
                        <div class="col-md-12">
                            <div class="widget box position-relative">
                                <div class="widget-header">
                                    <h4>Tareas asignadas: <span class="not-bold">Mañana</span></h4>
                                    <!-- Button trigger modal -->
                                    <button id="btn-aniadir-trabajador-evento" 
                                            type="button" class="btn btn-info btn-sm float-right" 
                                            data-toggle="modal" 
                                            data-target="#tareaModal" 
                                            onclick="jQuery('#eve_tar_type').val('morning');jQuery('#eve_text_periodo').html('Mañana')"
                                            style="margin-top:4px;margin-right:-7px"
                                        >Añadir</button>
                                </div>
                                <div class="widget-content">
                                    <?php if(count($tareas_morning) > 0): ?>
                                    <table class="table table-striped table-bordered table-hover table-checkable">
                                        <thead>
                                            <tr>
                                                <th width="40%">Tareas / <i class="not-bold">Categorias</i></th>
                                                <th width="15%">Horas</th>
                                                <th width="35%">Notas</th>
                                                <th class="align-center" width="10%">Acción</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php foreach($tareas_morning as $item): ?>
                                            <tr>
                                                <td>
                                                    <span class="box-tar" title="Terea"><?php echo getTareaByNombres($item->eve_tar_ids);?></span><span class="box-cat" title="Categoría"> - <?php echo $item->cat_name ?></span>
                                                </td>
                                                <td nowrap="nowrap"><?php echo date('H:i', strtotime($item->eve_tar_horario_from)); echo " - "; echo date('H:i', strtotime($item->eve_tar_horario_to)); ?></td>
                                                <td <?php if($item->eve_tar_nota): ?>style="background:#ffffa0;" <?php endif; ?>>
                                                    <?php echo $item->eve_tar_nota; ?>
                                                </td>
                                                <td class="text-center">
                                                    <ul class="table-controls">
                                                        <li><a 
                                                                href="javascript:void(0)" 
                                                                data-toggle="modal" 
                                                                data-target="#tareaModal"
                                                                class="bs-tooltip" 
                                                                onclick="ajax_editar_tarea('<?php echo base_url(); ?>backend/eventos/ajax_editar_tarea','<?php echo $item->eve_tar_id ?>','script-modal');"
                                                                title="Editar">
                                                                    <i class="icon-pencil"></i>
                                                            </a>
                                                        </li>
                                                        <li>
                                                            <a 
                                                                href="<?php echo base_url() ?>backend/eventos/eliminar_tarea_trabajador/<?php echo $item->eve_tar_id ?>/<?php echo $eve_id ?>/<?php echo $tra_id ?>"
                                                                class="bs-tooltip" 
                                                                title="Eliminar"
                                                                onclick="return confirm('Esta seguro de eliminar la tarea?');"
                                                                >
                                                                    <i class="icon-remove"></i>
                                                            </a>
                                                        </li>
                                                    </ul>
                                                </td>
                                            </tr>
                                            <?php endforeach; ?>
                                        </tbody>
                                    </table>
                                    <?php else: ?>
                                        <div class="text-center">- No existe tareas -</div>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="widget box position-relative">
                                <div class="widget-header">
                                <h4>Tareas asignadas: <span class="not-bold">Tarde</span></h4>
                                    <!-- Button trigger modal -->
                                    <button id="btn-aniadir-trabajador-evento" 
                                            type="button" class="btn btn-info btn-sm float-right" 
                                            data-toggle="modal" 
                                            data-target="#tareaModal" 
                                            onclick="jQuery('#eve_tar_type').val('afternoon');jQuery('#eve_text_periodo').html('Tarde');"
                                            style="margin-top:4px;margin-right:-7px"
                                        >Añadir</button>
                                </div>
                                <div class="widget-content">
                                    <?php if(count($tareas_afternoon) > 0): ?>
                                    <table class="table table-striped table-bordered table-hover table-checkable">
                                        <thead>
                                            <tr>
                                                <th width="40%">Tareas / <i class="not-bold">Categorias</i></th>
                                                <th width="15%">Horas</th>
                                                <th width="35%">Notas</th>
                                                <th class="align-center" width="10%">Acción</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php foreach($tareas_afternoon as $item): ?>
                                            <tr>
                                                <td>
                                                    <span class="box-tar" title="Terea"><?php echo getTareaByNombres($item->eve_tar_ids);?></span><span class="box-cat" title="Categoría"> - <?php echo $item->cat_name ?></span>
                                                </td>
                                                <td nowrap="nowrap"><?php echo date('H:i', strtotime($item->eve_tar_horario_from)); echo " - "; echo date('H:i', strtotime($item->eve_tar_horario_to)); ?></td>
                                                <td <?php if($item->eve_tar_nota): ?>style="background:#ffffa0;" <?php endif; ?>>
                                                    <?php echo $item->eve_tar_nota; ?>
                                                </td>
                                                <td class="text-center">
                                                    <ul class="table-controls">
                                                        <li>
                                                            <a 
                                                                href="javascript:void(0)" 
                                                                data-toggle="modal" 
                                                                data-target="#tareaModal"
                                                                class="bs-tooltip" 
                                                                onclick="ajax_editar_tarea('<?php echo base_url(); ?>backend/eventos/ajax_editar_tarea','<?php echo $item->eve_tar_id ?>','script-modal');"
                                                                title="Editar">
                                                                    <i class="icon-pencil"></i>
                                                            </a>
                                                        </li>
                                                        <li>
                                                            <a 
                                                                href="<?php echo base_url() ?>backend/eventos/eliminar_tarea_trabajador/<?php echo $item->eve_tar_id ?>/<?php echo $eve_id ?>/<?php echo $tra_id ?>"
                                                                class="bs-tooltip" 
                                                                title="Eliminar"
                                                                onclick="return confirm('Esta seguro de eliminar la tarea?');"
                                                                >
                                                                    <i class="icon-remove"></i>
                                                            </a>
                                                        </li>
                                                    </ul>
                                                </td>
                                            </tr>
                                            <?php endforeach; ?>
                                        </tbody>
                                    </table>
                                    <?php else: ?>
                                        <div class="text-center">- No existe tareas -</div>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div><!-- col -->
                        <div class="col-md-12">
                            <div class="widget box position-relative">
                                <div class="widget-header">
                                <h4>Tareas asignadas: <span class="not-bold">Noche</span></h4>
                                    <!-- Button trigger modal -->
                                    <button id="btn-aniadir-trabajador-evento" 
                                            type="button" class="btn btn-info btn-sm float-right" 
                                            data-toggle="modal" 
                                            data-target="#tareaModal" 
                                            onclick="jQuery('#eve_tar_type').val('night');jQuery('#eve_text_periodo').html('Noche');"
                                            style="margin-top:4px;margin-right:-7px"
                                        >Añadir</button>
                                </div>
                                <div class="widget-content">
                                    <?php if(count($tareas_night) > 0): ?>
                                    <table class="table table-striped table-bordered table-hover table-checkable">
                                        <thead>
                                            <tr>
                                                <th width="40%">Tareas / <i class="not-bold">Categorias</i></th>
                                                <th width="15%">Horas</th>
                                                <th width="35%">Notas</th>
                                                <th class="align-center" width="10%">Acción</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php foreach($tareas_night as $item): ?>
                                            <tr>
                                                <td>
                                                    <span class="box-tar" title="Terea"><?php echo getTareaByNombres($item->eve_tar_ids);?></span><span class="box-cat" title="Categoría"> - <?php echo $item->cat_name ?></span>
                                                </td>
                                                <td nowrap="nowrap"><?php echo date('H:i', strtotime($item->eve_tar_horario_from)); echo " - "; echo date('H:i', strtotime($item->eve_tar_horario_to)); ?></td>
                                                <td <?php if($item->eve_tar_nota): ?>style="background:#ffffa0;" <?php endif; ?>>
                                                    <?php echo $item->eve_tar_nota; ?>
                                                </td>
                                                <td class="text-center">
                                                    <ul class="table-controls">
                                                        <li>
                                                        <a 
                                                                href="javascript:void(0)" 
                                                                data-toggle="modal" 
                                                                data-target="#tareaModal"
                                                                class="bs-tooltip" 
                                                                onclick="ajax_editar_tarea('<?php echo base_url(); ?>backend/eventos/ajax_editar_tarea','<?php echo $item->eve_tar_id ?>','script-modal');"
                                                                title="Editar">
                                                                    <i class="icon-pencil"></i>
                                                            </a>
                                                        </li>
                                                        <li>
                                                            <a 
                                                                href="<?php echo base_url() ?>backend/eventos/eliminar_tarea_trabajador/<?php echo $item->eve_tar_id ?>/<?php echo $eve_id ?>/<?php echo $tra_id ?>"
                                                                class="bs-tooltip" 
                                                                title="Eliminar"
                                                                onclick="return confirm('Esta seguro de eliminar la tarea?');"
                                                                >
                                                                    <i class="icon-remove"></i>
                                                            </a>
                                                        </li>
                                                    </ul>
                                                </td>
                                            </tr>
                                            <?php endforeach; ?>
                                        
                                        </tbody>
                                    </table>
                                    <?php else: ?>
                                        <div class="text-center">- No existe tareas -</div>
                                    <?php endif; ?>
                                </div><!-- widget-content -->
                            </div><!-- widget-->
                        </div><!-- col -->
                    <?php elseif($eve_tipo_horario == 'Continuo'): ?>
                        <div class="col-md-12">
                            <div class="widget box position-relative">
                                <div class="widget-header">
                                    <h4>Tarea</h4>
                                    <!-- Button trigger modal -->
                                    <button id="btn-aniadir-trabajador-evento" 
                                            type="button" class="btn btn-info btn-sm float-right" 
                                            data-toggle="modal" 
                                            data-target="#tareaModal" 
                                            onclick="jQuery('#eve_tar_type').val('Continuo');"
                                            style="margin-top:4px;margin-right:-7px"
                                        >Añadir</button>
                                </div>
                                <div class="widget-content">
                                    <table class="table table-striped table-bordered table-hover table-checkable" style="margin-top:2rem;">
                                        <thead>
                                            <tr>
                                                <th width="35%">Tareas / <i class="not-bold">Categorias</i></th>
                                                <th width="25%">Horas</th>
                                                <th width="30%">Notas</th>
                                                <th class="align-center" width="10%">Acción</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                        <?php if(count($tareas_continue) > 0): ?>
                                            <?php foreach($tareas_continue as $item): ?>
                                                <tr>
                                                    <td>
                                                        <span class="box-tar" title="Terea"><?php echo getTareaByNombres($item->eve_tar_ids);?></span><span class="box-cat" title="Categoría"> - <?php echo $item->cat_name ?></span>   
                                                    </td>
                                                    <td nowrap="nowrap"><?php echo date('H:i', strtotime($item->eve_tar_horario_from)); echo " - "; echo date('H:i', strtotime($item->eve_tar_horario_to)); ?></td>
                                                    <td <?php if($item->eve_tar_nota): ?>style="background:#ffffa0;" <?php endif; ?>>
                                                        <?php echo $item->eve_tar_nota; ?>
                                                    </td>
                                                    <td class="text-center">
                                                        <ul class="table-controls">
                                                            <li>
                                                                <a 
                                                                    href="javascript:void(0)" 
                                                                    data-toggle="modal" 
                                                                    data-target="#tareaModal"
                                                                    class="bs-tooltip" 
                                                                    onclick="ajax_editar_tarea('<?php echo base_url(); ?>backend/eventos/ajax_editar_tarea','<?php echo $item->eve_tar_id ?>','script-modal');"
                                                                    title="Editar">
                                                                        <i class="icon-pencil"></i>
                                                                </a>
                                                            </li>
                                                            <li>
                                                                <a 
                                                                    href="<?php echo base_url() ?>backend/eventos/eliminar_tarea_trabajador/<?php echo $item->eve_tar_id ?>/<?php echo $eve_id ?>/<?php echo $tra_id ?>"
                                                                    class="bs-tooltip" 
                                                                    title="Eliminar"
                                                                    onclick="return confirm('Esta seguro de eliminar la tarea?');"
                                                                    >
                                                                        <i class="icon-remove"></i>
                                                                </a>
                                                            </li>
                                                        </ul>
                                                    </td>
                                                </tr>
                                            <?php endforeach; ?>
                                        <?php else: ?>
                                            <tr><td colspan="4" class="text-center">- No existe tareas -</td></tr>
                                        <?php endif; ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    <?php endif; ?>
                    </div><!-- row -->
					
                        
				</div>
			</div>
		</div>
		<!-- /.container -->

	</div>
</div>



















<!-- Modal -->
<div class="modal fade" id="tareaModal" role="dialog" aria-labelledby="tareaModal" aria-hidden="true">
  <div class="modal-dialog modal-dialog-500" role="document">
    <form id="form-modal-trabajador" method="post" class="modal-content validate2" action="<?php echo base_url() ?>backend/eventos/aniadir_editar_tarea_trabajador/" >
        <div class="modal-header">
            <?php if($eve_tipo_horario == "Partido"): ?>
            <h5 class="modal-title"><span id="eve_title">Nueva area</span> - Turno: <span id="eve_text_periodo" class="not-bold"></span></h5>
            <?php else: ?>
            <h5 class="modal-title"><span id="eve_title">Nueva area</span></h5>
            <?php endif; ?>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true" onclick="location.reload();">&times;</span>
            </button>
      	</div>
      	<div class="modal-body">
            
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="control-label">Categoría <span class="required">*</span></label>
                            <select 
                                id="eve_tar_cat" 
                                name="eve_tar_cat" 
                                class="select2-select-00 col-md-12 full-width-fix required"
                                placeholder="- Categoría -"
                                onchange="ajax_cargar_tareas_por_cat_id('<?php echo base_url() ?>backend/categorias/ajax_cargar_tareas_por_cat_id',this.value, 'eve_tar_task');"
                            >
                                <option value=""></option>
                                <?php foreach ($categorias as $item): ?>
                                    <option value="<?php echo $item->cat_id ?>"><?php echo $item->cat_name ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="control-label">Tareas <span class="required">*</span></label>
                            <select multiple id="eve_tar_task" name="eve_tar_task[]" class="select2-select-00 col-md-12 full-width-fix required" placeholder="- Tarea -">
                                <option value=""></option>
                                <?php foreach ($tareas as $item): ?>
                                    <option value="<?php echo $item->tar_id ?>"><?php echo $item->tar_name ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </div>
                    
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="control-label">Hora desde <span class="required">*</span></label>
                            <input  type="text" 
                                    id="eve_tar_horario_from" 
                                    name="eve_tar_horario_from" 
                                    value="" 
                                    class="form-control timepicker required" 
                                    placeholder="Desde"
                                    onblur="calcularDiferenciaTiempo('eve_tar_horario_from', 'eve_tar_horario_to', 'eve_date', 'wrap_calculo_horas')"
                                    readonly
                                >
                            <div id="wrap_calculo_horas" class="font-style-italic"></div>
                        </div>
                        
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="control-label">Hora hasta <span class="required">*</span></label>
                            <input  type="text" 
                                    id="eve_tar_horario_to" 
                                    name="eve_tar_horario_to" 
                                    value="" 
                                    class="form-control timepicker required" 
                                    placeholder="Hasta"
                                    onblur="calcularDiferenciaTiempo('eve_tar_horario_from', 'eve_tar_horario_to', 'eve_date', 'wrap_calculo_horas')"
                                    readonly
                                >
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="form-group">
                            <label class="control-label">Notas</label>
                            <textarea id="eve_tar_nota" name="eve_tar_nota" rows="5" class="form-control" placeholder="Ingrese notas en relación a la tarea" maxlength="255"></textarea>
                        </div>
                    </div>
                </div>
            		
      	</div>
      	<div class="modal-footer">
        	<button type="button" class="btn btn-secondary" data-dismiss="modal" onclick="location.reload();">Cerrar</button>
        	<button type="submit" class="btn btn-primary">Guardar</button>

            <input type="hidden" id="eve_tar_id" name="eve_tar_id" value="">
			<input type="hidden" id="pro_id" name="pro_id" value="<?php echo $pro_id ?>">

			<input type="hidden" id="eve_id" name="eve_id" value="<?php echo $eve_id ?>">
			<input type="hidden" id="eve_date" name="eve_date" value="<?php echo $eve_date ?>">
			<input type="hidden" id="eve_tar_type" name="eve_tar_type" value="">

            <input type="hidden" id="tra_id" name="tra_id" value="<?php echo $tra_id ?>">

			<input type="hidden" name="eve_tipo_horario" value="<?php echo $eve_tipo_horario; ?>" class="input-tipo-horario">
      	</div>
		
	</form>
  </div>
</div>

<div id="script-modal"></div>