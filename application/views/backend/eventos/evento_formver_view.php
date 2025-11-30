<link href="https://gitcdn.github.io/bootstrap-toggle/2.2.2/css/bootstrap-toggle.min.css" rel="stylesheet">
<script src="https://gitcdn.github.io/bootstrap-toggle/2.2.2/js/bootstrap-toggle.min.js"></script>


<?php require (APPPATH."views/layouts/backend/header.php"); ?>

<div id="container">
	<?php require (APPPATH."views/layouts/backend/sidebarleft.php"); ?>

	<div id="content" style="min-height:900px;">
		<div class="container">

			<?php require (APPPATH."views/layouts/backend/crumbs-page-header.php"); ?>

			<!--=== Page Content ===-->
			<div class="row">
				<!--=== Validation Example 1 ===-->
				<div class="col-md-12">
					<?php echo $this->message->display(); ?>
					<div class="widget box widget-closed">
						<div class="widget-header position-relative">
                            <div class="row">
                                <div class="col-md-6">
                                    <h4>Evento: <span class="not-bold"><?php echo $eve_name ?></span></h4>
                                </div>
                                <div class="col-md-6">
                                    <h4>Fecha: <span class="not-bold"><?php echo formato_fecha($eve_date) ?></span></h4>
                                </div>
                            </div>
							
                            <div class="toolbar no-padding" style="position:absolute; top:1px;right:13px">
                                <div class="btn-group">
                                    <span class="btn btn-xs widget-collapse"><i class="icon-angle-up"></i></span>
                                </div>
                            </div>
						</div>
						<div class="widget-content">
                            <div class="row">
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label class="control-label">Proyecto</label>
                                        <div class=""><?php echo $proyecto ?></div>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label class="control-label">Cliente</label>
                                        <div class=""><?php echo $cliente ?></div>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label class="control-label">Coordinador</label>
                                        <div class=""><?php echo $coordinador ?></div>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label class="control-label">Trabajador</label>
                                        <div class=""><?php echo $trabajador ?></div>
                                    </div>
                                </div>
                                <?php if($eve_description): ?>
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label class="control-label">Descripción</label>
                                        <div class=""><?php echo $eve_description ?></div>
                                    </div>
                                </div>
                                <?php endif; ?>
                            </div>
						</div>
					</div><!-- widget box -->

					<!-- /Validation Example 1 -->
                    <?php if(count($tareas_morning) > 0 or count($tareas_registradas_morning) > 0): ?>
                    <?php $variable_morning = $this->tarea_modelo->verificarQueTodasLasTareasFueronValidadas($eve_id, $tra_id, 'morning'); ?>
					<div class="row" id="table-morning">
                        <div class="col-md-6">
                            <div class="widget box position-relative">
                                <div class="widget-header">
                                    <h4>TAREAS ASIGNADAS &ndash; Turno: <span class="not-bold">Mañana</span></h4>
                                </div>
                                <div class="widget-content">
                                    <?php if(count($tareas_morning) > 0): ?>
                                    <table class="table table-striped table-bordered table-hover table-checkable">
                                        <thead>
                                            <tr>
                                                <th width="30%">Categoria</th>
                                                <th width="30%">Tareas</th>
                                                <th width="15%">Horas</th>
                                                <th width="25%">Notas</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                        
                                            <?php foreach($tareas_morning as $item): ?>
                                                <tr>
                                                    <td><?php echo $item->cat_name ?></div></td>
                                                    <td><?php echo getTareaByNombres($item->eve_tar_ids);?></td>
                                                    <td nowrap="nowrap"><?php echo date('H:i', strtotime($item->eve_tar_horario_from)); echo " - "; echo date('H:i', strtotime($item->eve_tar_horario_to)); ?></td>
                                                    <td <?php if($item->eve_tar_nota): ?>style="background:#ffffa0;" <?php endif; ?>><?php echo $item->eve_tar_nota ?></td>
                                                </tr>
                                            <?php endforeach; ?>
                                        
                                        </tbody>
                                    </table>
                                    <?php else: ?>
                                        <div class="text-center">- No existe tareas asignadas -</div>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div><!-- cpl -->
                        <div class="col-md-6">
                            <div class="widget box position-relative">
                                <div class="widget-header">
                                    <h4>TAREAS REGISTRADAS &ndash; Turno: <span class="not-bold">Mañana</span></h4>
                                    <?php if($variable_morning['registradas'][0]->total != $variable_morning['validadas'][0]->total or count($tareas_registradas_morning) == 0): ?>
                                    <button id="btn-aniadir-trabajador-evento" 
                                            type="button" class="btn btn-info btn-sm float-right" 
                                            data-toggle="modal" 
                                            data-target="#tareaModal" 
                                            onclick="jQuery('#eve_tar_type').val('morning');"
                                            style="margin-top:4px;margin-right:-7px"
                                        >Añadir tarea</button>
                                    <?php endif; ?>
                                </div>
                                <div class="widget-content">
                                    <!-- Button trigger modal -->
                                    <?php if(count($tareas_registradas_morning) > 0): ?>
                                    
                                    <table class="table table-striped table-bordered table-hover table-checkable">
                                        <thead>
                                            <tr>
                                                <th width="20%">Tarea</th>
                                                <th width="15%">Horas</th>
                                                <th width="25%">Notas</th>
                                                <th width="30%">Observaciones</th>
                                                <?php if($variable_morning['registradas'][0]->total != $variable_morning['validadas'][0]->total or $variable_morning['invalidadas'][0]->total > 0): ?>
                                                <th class="align-center" width="10%">Acción</th>
                                                <?php endif; ?>
                                            </tr>
                                        </thead>
                                        <tbody>
                                        
                                            <?php foreach($tareas_registradas_morning as $item): ?>
                                            <tr class="<?php echo $item->eve_validar==1?"tarea-validada":""; echo $item->eve_validar==2?"tarea-observada":""; ?>">
                                                <td title="ID: <?php echo $item->eve_tar_id ?>"><?php echo $item->tar_name;?></td>
                                                <td nowrap="nowrap"><?php echo date('H:i', strtotime($item->eve_tar_horario_from)); echo " - "; echo date('H:i', strtotime($item->eve_tar_horario_to)); ?></td>
                                                <td <?php if($item->eve_tar_nota): ?>style="background:#ffffa0;" <?php endif; ?>><?php echo $item->eve_tar_nota ?></td>
                                                <td>
                                                    <?php 
                                                    echo tarea_observaciones($item->eve_validar);
                                                    
                                                    $notificaciones = $this->notificacion_modelo->getNotificacionesByEveTarId($item->eve_tar_id);
                                                    if(count($notificaciones) > 0):
                                                    ?>
                                                    
                                                    <span data-toggle="modal" data-target="#notaTrabajadorModal-<?php echo $item->eve_tar_id ?>" class="notifications-menu position-relative">
                                                        <i class="fa fa-commenting-o icon-comment cursor" aria-hidden="true"></i>
                                                        <span class="label label-warning"><?php echo count($notificaciones) ?></span>
                                                    </span>
                                                    
                                                    <?php modal_lista_mensajes_trabajador($item, $notificaciones); ?>
                                                    
                                                    <?php endif; ?>
                                                </td>
                                                <?php if($variable_morning['registradas'][0]->total != $variable_morning['validadas'][0]->total or $item->eve_validar == 2): ?>
                                                <td class="text-center">
                                                    <?php if($item->eve_validar == 0 or $item->eve_validar == 2): ?>
                                                    <ul class="table-controls">
                                                        <li><a 
                                                                href="javascript:void(0)" 
                                                                data-toggle="modal" 
                                                                data-target="#tareaModal"
                                                                class="bs-tooltip" 
                                                                title="Editar"
                                                                onclick="ajax_editar_tarea_registrada('<?php echo base_url(); ?>backend/eventos/ajax_editar_tarea_registrada','<?php echo $item->eve_tar_id ?>','script-modal');"
                                                            >
                                                                    <i class="icon-pencil"></i>
                                                            </a>
                                                        </li>
                                                        <li>
                                                            <a 
                                                                href="<?php echo base_url() ?>backend/eventos/eliminar_tarea_registrada_trabajador/<?php echo $item->eve_tar_id ?>/<?php echo $eve_id ?>/<?php echo $tra_id ?>#table-morning"
                                                                class="bs-tooltip" 
                                                                title="Eliminar"
                                                                onclick="return confirm('Esta seguro de eliminar la tarea?');"
                                                            >
                                                                    <i class="icon-remove"></i>
                                                            </a>
                                                        </li>
                                                    </ul>
                                                    <?php endif; ?>
                                                </td>
                                                <?php endif; ?>
                                            </tr>
                                            <?php endforeach; ?>
                                        
                                        </tbody>
                                    </table>
                                    <?php else: ?>
                                        <div class="text-center">- No existe tareas registradas -</div>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div><!-- cpl -->
                    </div>
                    <?php endif; ?>
                    <?php if(count($tareas_afternoon) > 0 or count($tareas_registradas_afternoon) > 0): ?>
                    <?php $variable_afternoon = $this->tarea_modelo->verificarQueTodasLasTareasFueronValidadas($eve_id, $tra_id, 'afternoon'); ?>
                    <div class="row" id="table-afternoon">
                        <div class="col-md-6">
                            <div class="widget box position-relative">
                                <div class="widget-header">
                                    <h4>TAREAS ASIGNADAS &ndash; Turno: <span class="not-bold">Tarde</span></h4>
                                </div>
                                <div class="widget-content">
                                    <?php if(count($tareas_afternoon) > 0): ?>
                                    <table class="table table-striped table-bordered table-hover table-checkable">
                                        <thead>
                                            <tr>
                                                <th width="30%">Categoria</th>
                                                <th width="30%">Tareas</th>
                                                <th width="15%">Horas</th>
                                                <th width="25%">Notas</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                        
                                            <?php foreach($tareas_afternoon as $item): ?>
                                                <tr>
                                                    <td><?php echo $item->cat_name ?></div></td>
                                                    <td><?php echo getTareaByNombres($item->eve_tar_ids);?></td>
                                                    <td nowrap="nowrap"><?php echo date('H:i', strtotime($item->eve_tar_horario_from)); echo " - "; echo date('H:i', strtotime($item->eve_tar_horario_to)); ?></td>
                                                    <td <?php if($item->eve_tar_nota): ?>style="background:#ffffa0;" <?php endif; ?>><?php echo $item->eve_tar_nota ?></td>
                                                </tr>
                                            <?php endforeach; ?>
                                        
                                        </tbody>
                                    </table>
                                    <?php else: ?>
                                        <div class="text-center">- No existe tareas asignadas -</div>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div><!-- cpl -->
                        <div class="col-md-6">
                            <div class="widget box position-relative">
                                <div class="widget-header">
                                    <h4>TAREAS REGISTRADAS &ndash; Turno: <span class="not-bold">Tarde</span></h4>
                                    <?php if($variable_afternoon['registradas'][0]->total != $variable_afternoon['validadas'][0]->total or count($tareas_registradas_afternoon) == 0): ?>
                                    <button id="btn-aniadir-trabajador-evento" 
                                            type="button" class="btn btn-info btn-sm float-right" 
                                            data-toggle="modal" 
                                            data-target="#tareaModal" 
                                            onclick="jQuery('#eve_tar_type').val('afternoon');"
                                            style="margin-top:4px;margin-right:-7px"
                                        >Añadir tarea</button>
                                    <?php endif; ?>
                                </div>
                                <div class="widget-content">
                                    <!-- Button trigger modal -->
                                    <?php if(count($tareas_registradas_afternoon) > 0): ?>
                                    <table class="table table-striped table-bordered table-hover table-checkable">
                                        <thead>
                                            <tr>
                                                <th width="20%">Tarea</th>
                                                <th width="15%">Horas</th>
                                                <th width="25%">Notas</th>
                                                <th width="30%">Observaciones</th>
                                                <?php if($variable_afternoon['registradas'][0]->total != $variable_afternoon['validadas'][0]->total or $variable_afternoon['invalidadas'][0]->total > 0): ?>
                                                <th class="align-center" width="10%">Acción</th>
                                                <?php endif; ?>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php foreach($tareas_registradas_afternoon as $item): ?>
                                                <tr>
                                                <td title="ID: <?php echo $item->eve_tar_id ?>"><?php echo $item->tar_name;?></td>
                                                    <td nowrap="nowrap"><?php echo date('H:i', strtotime($item->eve_tar_horario_from)); echo " - "; echo date('H:i', strtotime($item->eve_tar_horario_to)); ?></td>
                                                    <td <?php if($item->eve_tar_nota): ?>style="background:#ffffa0;" <?php endif; ?>><?php echo $item->eve_tar_nota ?></td>
                                                    <td>
                                                        <?php 
                                                        echo tarea_observaciones($item->eve_validar);
                                                        
                                                        $notificaciones = $this->notificacion_modelo->getNotificacionesByEveTarId($item->eve_tar_id);
                                                        if(count($notificaciones) > 0):
                                                        ?>
                                                        
                                                        <span data-toggle="modal" data-target="#notaTrabajadorModal-<?php echo $item->eve_tar_id ?>" class="notifications-menu position-relative">
                                                            <i class="fa fa-commenting-o icon-comment cursor" aria-hidden="true"></i>
                                                            <span class="label label-warning"><?php echo count($notificaciones) ?></span>
                                                        </span>
                                                        
                                                        <?php modal_lista_mensajes_trabajador($item, $notificaciones); ?>
                                                        
                                                        <?php endif; ?>
                                                    </td>
                                                    <?php if($variable_afternoon['registradas'][0]->total != $variable_afternoon['validadas'][0]->total or $item->eve_validar == 2): ?>
                                                    <td class="text-center">
                                                        <?php if($item->eve_validar == 0 or $item->eve_validar == 2): ?>
                                                        <ul class="table-controls">
                                                            <li><a 
                                                                    href="javascript:void(0)" 
                                                                    data-toggle="modal" 
                                                                    data-target="#tareaModal"
                                                                    class="bs-tooltip" 
                                                                    title="Editar"
                                                                    onclick="ajax_editar_tarea_registrada('<?php echo base_url(); ?>backend/eventos/ajax_editar_tarea_registrada','<?php echo $item->eve_tar_id ?>','script-modal');"
                                                                >
                                                                        <i class="icon-pencil"></i>
                                                                </a>
                                                            </li>
                                                            <li>
                                                                <a 
                                                                    href="<?php echo base_url() ?>backend/eventos/eliminar_tarea_registrada_trabajador/<?php echo $item->eve_tar_id ?>/<?php echo $eve_id ?>/<?php echo $tra_id ?>#table-afternoon"
                                                                    class="bs-tooltip" 
                                                                    title="Eliminar"
                                                                    onclick="return confirm('Esta seguro de eliminar la tarea?');"
                                                                    >
                                                                        <i class="icon-remove"></i>
                                                                </a>
                                                            </li>
                                                        </ul>
                                                        <?php endif; ?>
                                                    </td>
                                                    <?php endif; ?>
                                                </tr>
                                            <?php endforeach; ?>
                                        
                                        </tbody>
                                    </table>
                                    <?php else: ?>
                                        <div class="text-center">- No existe tareas registradas -</div>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div><!-- cpl -->
                    </div>
                    <?php endif; ?>
                    <?php if(count($tareas_night) > 0 or count($tareas_registradas_night) > 0): ?>
                    <?php $variable_night = $this->tarea_modelo->verificarQueTodasLasTareasFueronValidadas($eve_id, $tra_id, 'night'); ?>
                    <div class="row" id="table-night">
                        <div class="col-md-6">
                            <div class="widget box position-relative">
                                <div class="widget-header">
                                    <h4>TAREAS ASIGNADAS &ndash; Turno: <span class="not-bold">Noche</span></h4>
                                </div>
                                <div class="widget-content">
                                    <?php if(count($tareas_night) > 0): ?>
                                    <table class="table table-striped table-bordered table-hover table-checkable">
                                        <thead>
                                            <tr>
                                                <th width="30%">Categoria</th>
                                                <th width="30%">Tareas</th>
                                                <th width="15%">Horas</th>
                                                <th width="25%">Notas</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                        
                                            <?php foreach($tareas_night as $item): ?>
                                                <tr>
                                                    <td><?php echo $item->cat_name ?></div></td>
                                                    <td><?php echo getTareaByNombres($item->eve_tar_ids);?></td>
                                                    <td nowrap="nowrap"><?php echo date('H:i', strtotime($item->eve_tar_horario_from)); echo " - "; echo date('H:i', strtotime($item->eve_tar_horario_to)); ?></td>
                                                    <td <?php if($item->eve_tar_nota): ?>style="background:#ffffa0;" <?php endif; ?>><?php echo $item->eve_tar_nota ?></td>
                                                </tr>
                                            <?php endforeach; ?>
                                        </tbody>
                                    </table>
                                    <?php else: ?>
                                        <div class="text-center">- No existe tareas asignadas -</div>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div><!-- cpl -->
                        <div class="col-md-6">
                            <div class="widget box position-relative">
                                <div class="widget-header">
                                    <h4>TAREAS REGISTRADAS &ndash; Turno: <span class="not-bold">Noche</span></h4>
                                    <?php if($variable_night['registradas'][0]->total != $variable_night['validadas'][0]->total or count($tareas_registradas_night) == 0): ?>
                                    <button id="btn-aniadir-trabajador-evento" 
                                            type="button" class="btn btn-info btn-sm float-right" 
                                            data-toggle="modal" 
                                            data-target="#tareaModal" 
                                            onclick="jQuery('#eve_tar_type').val('night');"
                                            style="margin-top:4px;margin-right:-7px"
                                        >Añadir tarea</button>
                                    <?php endif; ?>
                                </div>
                                <div class="widget-content">
                                    <!-- Button trigger modal -->
                                    <?php if(count($tareas_registradas_night) > 0): ?>
                                    <table class="table table-striped table-bordered table-hover table-checkable">
                                        <thead>
                                            <tr>
                                            <th width="30%">Tarea</th>
                                                <th width="15%">Horas</th>
                                                <th width="20%">Notas</th>
                                                <th width="25%">Observaciones</th>
                                                <?php if($variable_night['registradas'][0]->total != $variable_night['validadas'][0]->total or $variable_night['invalidadas'][0]->total > 0): ?>
                                                <th class="align-center" width="10%">Acción</th>
                                                <?php endif; ?>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php foreach($tareas_registradas_night as $item): ?>
                                                <tr>
                                                <td title="ID: <?php echo $item->eve_tar_id ?>"><?php echo $item->tar_name;?></td>
                                                    <td nowrap="nowrap"><?php echo date('H:i', strtotime($item->eve_tar_horario_from)); echo " - "; echo date('H:i', strtotime($item->eve_tar_horario_to)); ?></td>
                                                    <td <?php if($item->eve_tar_nota): ?>style="background:#ffffa0;" <?php endif; ?>><?php echo $item->eve_tar_nota ?></td>
                                                    <td>
                                                        <?php 
                                                        echo tarea_observaciones($item->eve_validar);
                                                        
                                                        $notificaciones = $this->notificacion_modelo->getNotificacionesByEveTarId($item->eve_tar_id);
                                                        if(count($notificaciones) > 0):
                                                        ?>
                                                        
                                                        <span data-toggle="modal" data-target="#notaTrabajadorModal-<?php echo $item->eve_tar_id ?>" class="notifications-menu position-relative">
                                                            <i class="fa fa-commenting-o icon-comment cursor" aria-hidden="true"></i>
                                                            <span class="label label-warning"><?php echo count($notificaciones) ?></span>
                                                        </span>
                                                        
                                                        <?php modal_lista_mensajes_trabajador($item, $notificaciones); ?>
                                                        
                                                        <?php endif; ?>
                                                    </td>
                                                    <?php if($variable_night['registradas'][0]->total != $variable_night['validadas'][0]->total or $item->eve_validar == 2): ?>
                                                    <td class="text-center">
                                                        <?php if($item->eve_validar == 0 or $item->eve_validar == 2): ?>
                                                        <ul class="table-controls">
                                                            <li><a 
                                                                    href="javascript:void(0)" 
                                                                    data-toggle="modal" 
                                                                    data-target="#tareaModal"
                                                                    class="bs-tooltip" 
                                                                    title="Editar"
                                                                    onclick="ajax_editar_tarea_registrada('<?php echo base_url(); ?>backend/eventos/ajax_editar_tarea_registrada','<?php echo $item->eve_tar_id ?>','script-modal');"
                                                                >
                                                                        <i class="icon-pencil"></i>
                                                                </a>
                                                            </li>
                                                            <li>
                                                                <a 
                                                                    href="<?php echo base_url() ?>backend/eventos/eliminar_tarea_registrada_trabajador/<?php echo $item->eve_tar_id ?>/<?php echo $eve_id ?>/<?php echo $tra_id ?>#table-night"
                                                                    class="bs-tooltip" 
                                                                    title="Eliminar"
                                                                    onclick="return confirm('Esta seguro de eliminar la tarea?');"
                                                                    >
                                                                        <i class="icon-remove"></i>
                                                                </a>
                                                            </li>
                                                        </ul>
                                                        <?php endif; ?>
                                                    </td>
                                                    <?php endif; ?>
                                                </tr>
                                            <?php endforeach; ?>
                                        
                                        </tbody>
                                    </table>
                                    <?php else: ?>
                                        <div class="text-center">- No existe tareas registradas -</div>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div><!-- cpl -->
                    </div>
                    <?php endif; ?>


                    <?php if(count($tareas_continue) > 0 or count($tareas_registradas_continue) > 0): ?>
                    <div class="row" id="table-night">
                        <div class="col-md-6">
                            <div class="widget box position-relative">
                                <div class="widget-header">
                                    <h4>TAREAS ASIGNADAS</h4>
                                </div>
                                <div class="widget-content">
                                    <?php if(count($tareas_continue) > 0): ?>
                                    <table class="table table-striped table-bordered table-hover table-checkable">
                                        <thead>
                                            <tr>
                                                <th width="30%">Categoria</th>
                                                <th width="30%">Tareas</th>
                                                <th width="15%">Horas</th>
                                                <th width="25%">Notas</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                        
                                            <?php foreach($tareas_continue as $item): ?>
                                                <tr>
                                                    <td><?php echo $item->cat_name ?></div></td>
                                                    <td><?php echo getTareaByNombres($item->eve_tar_ids);?></td>
                                                    <td nowrap="nowrap"><?php echo date('H:i', strtotime($item->eve_tar_horario_from)); echo " - "; echo date('H:i', strtotime($item->eve_tar_horario_to)); ?></td>
                                                    <td><?php echo $item->eve_tar_nota ?></td>
                                                </tr>
                                            <?php endforeach; ?>
                                        </tbody>
                                    </table>
                                    <?php else: ?>
                                        <div class="text-center">- No existe tareas asignadas -</div>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div><!-- cpl -->
                        <div class="col-md-6">
                            <div class="widget box position-relative">
                                <div class="widget-header">
                                    <h4>TAREAS REGISTRADAS</h4>
                                    <?php $variable = $this->tarea_modelo->verificarQueTodasLasTareasFueronValidadas($eve_id, $tra_id, 'Continuo'); ?>
                                    <?php if($variable['registradas'][0]->total != $variable['validadas'][0]->total or count($tareas_registradas_continue) == 0): ?>
                                    <button id="btn-aniadir-trabajador-evento" 
                                            type="button" class="btn btn-info btn-sm float-right" 
                                            data-toggle="modal" 
                                            data-target="#tareaModal" 
                                            onclick="jQuery('#eve_tar_type').val('Continuo');"
                                            style="margin-top:4px;margin-right:-7px"
                                        >Añadir tarea</button>
                                    <?php endif; ?>
                                </div>
                                <div class="widget-content">
                                    <!-- Button trigger modal -->
                                    <?php if(count($tareas_registradas_continue) > 0): ?>
                                    <table class="table table-striped table-bordered table-hover table-checkable">
                                        <thead>
                                            <tr>
                                                <th width="20%">Tarea</th>
                                                <th width="15%">Horas</th>
                                                <th width="25%">Notas</th>
                                                <th width="30%">Observaciones</th>
                                                <?php if($variable['registradas'][0]->total != $variable['validadas'][0]->total or $variable['invalidadas'][0]->total > 0): ?>
                                                <th class="align-center" width="10%">Acción</th>
                                                <?php endif; ?>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php foreach($tareas_registradas_continue as $item): ?>
                                            <tr class="<?php echo $item->eve_validar==1?"tarea-validada":""; echo $item->eve_validar==2?"tarea-observada":""; ?>">
                                                <td title="ID: <?php echo $item->eve_tar_id ?>"><?php echo $item->tar_name;?></td>
                                                <td nowrap="nowrap"><?php echo date('H:i', strtotime($item->eve_tar_horario_from)); echo " - "; echo date('H:i', strtotime($item->eve_tar_horario_to)); ?></td>
                                                <td <?php if($item->eve_tar_nota): ?>style="background:#ffffa0;" <?php endif; ?>><?php echo $item->eve_tar_nota ?></td>
                                                <td>
                                                    <?php 
                                                    echo tarea_observaciones($item->eve_validar);
                                                    
                                                    $notificaciones = $this->notificacion_modelo->getNotificacionesByEveTarId($item->eve_tar_id);
                                                    if(count($notificaciones) > 0):
                                                    ?>
                                                    
                                                    <span data-toggle="modal" data-target="#notaTrabajadorModal-<?php echo $item->eve_tar_id ?>" class="notifications-menu position-relative">
                                                        <i class="fa fa-commenting-o icon-comment cursor" aria-hidden="true"></i>
                                                        <span class="label label-warning"><?php echo count($notificaciones) ?></span>
                                                    </span>
                                                    
                                                    <?php modal_lista_mensajes_trabajador($item, $notificaciones); ?>
                                                    
                                                    <?php endif; ?>
                                                </td>
                                                <?php if($variable['registradas'][0]->total != $variable['validadas'][0]->total or $item->eve_validar == 2): ?>
                                                <td class="text-center">
                                                    <?php if($item->eve_validar == 0 or $item->eve_validar == 2): ?>
                                                    <ul class="table-controls">
                                                        <li><a 
                                                                href="javascript:void(0)" 
                                                                data-toggle="modal" 
                                                                data-target="#tareaModal"
                                                                class="bs-tooltip" 
                                                                title="Editar"
                                                                onclick="ajax_editar_tarea_registrada('<?php echo base_url(); ?>backend/eventos/ajax_editar_tarea_registrada','<?php echo $item->eve_tar_id ?>','script-modal');"
                                                            >
                                                                    <i class="icon-pencil"></i>
                                                            </a>
                                                        </li>
                                                        <li>
                                                            <a 
                                                                href="<?php echo base_url() ?>backend/eventos/eliminar_tarea_registrada_trabajador/<?php echo $item->eve_tar_id ?>/<?php echo $eve_id ?>/<?php echo $tra_id ?>#table-morning"
                                                                class="bs-tooltip" 
                                                                title="Eliminar"
                                                                onclick="return confirm('Esta seguro de eliminar la tarea?');"
                                                            >
                                                                    <i class="icon-remove"></i>
                                                            </a>
                                                        </li>
                                                    </ul>
                                                    <?php endif; ?>
                                                </td>
                                                <?php endif; ?>
                                            </tr>
                                            <?php endforeach; ?>
                                        </tbody>
                                    </table>
                                    <?php else: ?>
                                        <div class="text-center">- No existe tareas registradas -</div>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div><!-- cpl -->
                    </div>
                    <?php endif; ?>
				</div>
			</div>
		</div>
		<!-- /.container -->

	</div>
</div>









<!-- Modal -->
<div class="modal fade" id="tareaModal" role="dialog" aria-labelledby="tareaModal" aria-hidden="true">
  <div class="modal-dialog modal-dialog-500" role="document">
    <form id="form-modal-trabajador" method="post" class="modal-content validate2" action="<?php echo base_url() ?>backend/eventos/aniadir_editar_tarea_registrada_trabajador/" >
        <div class="modal-header">
            <h5 class="modal-title" id="modal-title">Nueva Tarea</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true" onclick="location.reload();">&times;</span>
            </button>
      	</div>
      	<div class="modal-body">
            <div class="form-group">
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group">
                            <label class="control-label">Tareas <span class="required">*</span></label>
                            <select id="eve_tar_ids" name="eve_tar_ids" class="select2-select-00 col-md-12 full-width-fix required" placeholder="- Tarea -">
                                <option value=""></option>
                                <?php foreach ($all_tareas as $item): ?>
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
      	</div>
      	<div class="modal-footer">
        	<button type="button" class="btn btn-secondary" data-dismiss="modal" onclick="location.reload();">Cerrar</button>
        	<button type="submit" class="btn btn-primary">Guardar</button>

			<input type="hidden" id="eve_tar_id" name="eve_tar_id" value="">

			<input type="hidden" id="pro_id" name="pro_id" value="<?php echo $pro_id ?>">
            <input type="hidden" id="eve_id" name="eve_id" value="<?php echo $eve_id ?>">
			<input type="hidden" id="eve_date" name="eve_date" value="<?php echo $eve_date ?>">
			<input type="hidden" id="eve_tar_type" name="eve_tar_type" value="">
			<input type="hidden" id="eve_validar" name="eve_validar" value="">

            <input type="hidden" id="tra_id" name="tra_id" value="<?php echo $tra_id ?>">

			<input type="hidden" name="eve_tipo_horario" value="<?php echo $eve_tipo_horario; ?>" class="input-tipo-horario">
      	</div>
		
	</form>
  </div>
  
</div>

<div id="script-modal"></div>
