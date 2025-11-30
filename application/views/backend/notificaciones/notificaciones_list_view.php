<?php require (APPPATH."views/layouts/backend/header.php"); ?>

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

                    <section class="notifications">
                        <div class="title">
                            <h2>Hoy</h2>
                        </div>
                        <div class="wrap-notifications">
                            <?php if(count($notificaciones_hoy) > 0): ?>
                                <?php foreach($notificaciones_hoy as $item): ?>
                                <div id="not-<?php echo $item->not_id; ?>" class="item item-<?php echo $item->not_id ?>">
                                    <div class="thumb" title="not_id: <?php echo $item->not_id ?>">
                                        <?php if($item->usu_foto == "public/backend/img/silueta.jpg"): ?>
                                            <img src="<?php echo base_url() ?>public/backend/img/avatar.png">
                                        <?php else: ?>
                                            <img src="<?php echo base_url().$item->usu_foto; ?>">
                                        <?php endif; ?>
                                    </div>
                                    <?php 
                                    if($item->not_type == 0){
                                        $type = "info";
                                        $type_text = '<span class="label label-info"><i class="fa fa-info-circle color-white" aria-hidden="true"></i> Informativo</span>';
                                    }
                                    if($item->not_type == 1){
                                        $type = "warning";
                                        $type_text = '<span class="label label-warning"><i class="fa fa-warning color-white" aria-hidden="true"></i> Advertencia</span>';
                                    }
                                    if($item->not_type == 2){
                                        $type = "error";
                                        $type_text = '<span class="label label-danger"><i class="fa fa-times-circle color-white" aria-hidden="true"></i> Error de tarea</span>';
                                    }
                                    if($this->session->userdata("usu_tipo_actual") != "Trabajador")
                                        $ir_link = " <a title='Ir a la tarea' class='ml10' href='".base_url()."backend/eventos/editar/$item->eve_id/?open=$item->tra_id#tra_id_$item->tra_id'><i class='fa fa-external-link'></i></a>";
                                    else
                                        $ir_link = " <a title='Ir a la tarea' class='ml10' href='".base_url()."backend/eventos/ver/$item->eve_id/'><i class='fa fa-external-link'></i></a>";
                                    ?>
                                    <div class="cont <?php echo $type ?>">
                                        
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="message">
                                                    <?php echo $type_text ?>, <i class="fa fa-clock"></i> <?php echo date("H:i", strtotime($item->created_at)); ?>, <?php echo formato_fecha($item->created_at); ?>
                                                    <div class="inner-message">
                                                        <i class="fa fa-file-text"></i> <?php echo $item->not_message; ?> <?php echo $ir_link ?>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6 col-event">
                                                    <span>Evento:</span> <i><?php echo $item->eve_name; ?></i> &mdash; <a href="#" class="more-event"><span class="more">Ver más</span><span class="less">Ver menos</span>...</a>
                                                    <div class="event" style="display:none;">
                                                        <strong>Fecha</strong>: <?php echo formato_fecha($item->eve_date); ?><br>
                                                        <strong>Trabajador:</strong><?php echo $item->usu_ap." ".$item->usu_am." ".$item->usu_nombre ?>
                                                    </div>
                                            </div>
                                        </div>
                                    </div>
                                    <?php if($this->session->userdata("usu_id_actual") !== $item->origen_id): ?>
                                    <div class="actions">
                                        <button 
                                            class="btn btn-success"
                                            onClick="eliminar_notificacion_ajax('<?php echo base_url()."backend/notificaciones/eliminar_notificacion_ajax/"; ?>', '<?php echo $item->not_id; ?>')"
                                        >Marcar como leído</button>
                                    </div>
                                    <?php endif; ?>
                                </div><!-- item -->
                                <?php endforeach; ?>
                            <?php else: ?>    
                                No existe notificaciones para hoy
                            <?php endif; ?>
                        </div>
                        

                        <?php if(count($notificaciones_ayer) > 0): ?>
                        <div class="title">
                            <h2>Ayer</h2>
                        </div>
                        <div class="wrap-notifications">
                            <?php foreach($notificaciones_ayer as $item): ?>
                            <div id="not-<?php echo $item->not_id; ?>" class="item item-<?php echo $item->not_id ?>">
                                <div class="thumb" title="not_id: <?php echo $item->not_id ?>">
                                    <?php if($item->usu_foto == "public/backend/img/silueta.jpg"): ?>
                                        <img src="<?php echo base_url() ?>public/backend/img/avatar.png">
                                    <?php else: ?>
                                        <img src="<?php echo base_url().$item->usu_foto; ?>">
                                    <?php endif; ?>
                                </div>
                                <?php 
                                if($item->not_type == 0){
                                    $type = "info";
                                    $type_text = '<span class="label label-info"><i class="fa fa-info-circle color-white" aria-hidden="true"></i> Informativo</span>';
                                }
                                if($item->not_type == 1){
                                    $type = "warning";
                                    $type_text = '<span class="label label-warning"><i class="fa fa-warning color-white" aria-hidden="true"></i> Advertencia</span>';
                                }
                                if($item->not_type == 2){
                                    $type = "error";
                                    $type_text = '<span class="label label-danger"><i class="fa fa-times-circle color-white" aria-hidden="true"></i> Error de tarea</span>';
                                }
                                if($this->session->userdata("usu_tipo_actual") != "Trabajador")
                                    $ir_link = " <a title='Ir a la tarea' class='ml10' href='".base_url()."backend/eventos/editar/$item->eve_id/?open=$item->tra_id#tra_id_$item->tra_id'><i class='fa fa-external-link'></i></a>";
                                else
                                    $ir_link = " <a title='Ir a la tarea' class='ml10' href='".base_url()."backend/eventos/ver/$item->eve_id/'><i class='fa fa-external-link'></i></a>";
                                ?>
                                <div class="cont <?php echo $type ?>">
                                    
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="message">
                                                <?php echo $type_text ?>, <i class="fa fa-clock"></i> <?php echo date("H:i", strtotime($item->created_at)); ?>, <?php echo formato_fecha($item->created_at); ?>
                                                <div class="inner-message">
                                                    <i class="fa fa-file-text"></i> <?php echo $item->not_message ?> <?php echo $ir_link ?>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6 col-event">
                                                <span>Evento:</span> <i><?php echo $item->eve_name; ?></i> &mdash; <a href="#" class="more-event"><span class="more">Ver más</span><span class="less">Ver menos</span>...</a>
                                                <div class="event" style="display:none;">
                                                    <strong>Fecha</strong>: <?php echo formato_fecha($item->eve_date); ?><br>
                                                    <strong>Trabajador:</strong><?php echo $item->usu_ap." ".$item->usu_am." ".$item->usu_nombre ?>
                                                </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="actions">
                                    <button 
                                        class="btn btn-success"
                                        onClick="eliminar_notificacion_ajax('<?php echo base_url()."backend/notificaciones/eliminar_notificacion_ajax/"; ?>', '<?php echo $item->not_id; ?>')"
                                    >Marcar como leído</button>
                                </div>
                            </div><!-- item -->
                            <?php endforeach; ?>
                        </div>
                        <?php endif; ?>

                        <?php if(count($notificaciones_ni_hoy_ayer) > 0): ?>
                        <div class="title">
                            <h2>Hace 2 dias hacia atras</h2>
                        </div>
                        <div class="wrap-notifications">
                            <?php foreach($notificaciones_ni_hoy_ayer as $item): ?>
                            <div id="not-<?php echo $item->not_id; ?>" class="item item-<?php echo $item->not_id ?>">
                                <div class="thumb" title="not_id: <?php echo $item->not_id ?>">
                                    <?php if($item->usu_foto == "public/backend/img/silueta.jpg"): ?>
                                        <img src="<?php echo base_url() ?>public/backend/img/avatar.png">
                                    <?php else: ?>
                                        <img src="<?php echo base_url().$item->usu_foto; ?>">
                                    <?php endif; ?>
                                </div>
                                <?php 
                                if($item->not_type == 0){
                                    $type = "info";
                                    $type_text = '<span class="label label-info"><i class="fa fa-info-circle color-white" aria-hidden="true"></i> Informativo</span>';
                                }
                                if($item->not_type == 1){
                                    $type = "warning";
                                    $type_text = '<span class="label label-warning"><i class="fa fa-warning color-white" aria-hidden="true"></i> Advertencia</span>';
                                }
                                if($item->not_type == 2){
                                    $type = "error";
                                    $type_text = '<span class="label label-danger"><i class="fa fa-times-circle color-white" aria-hidden="true"></i> Error de tarea</span>';
                                }
                                if($this->session->userdata("usu_tipo_actual") != "Trabajador")
                                    $ir_link = " <a title='Ir a la tarea' class='ml10' href='".base_url()."backend/eventos/editar/$item->eve_id/?open=$item->tra_id#tra_id_$item->tra_id'><i class='fa fa-external-link'></i></a>";
                                else
                                    $ir_link = " <a title='Ir a la tarea' class='ml10' href='".base_url()."backend/eventos/ver/$item->eve_id/'><i class='fa fa-external-link'></i></a>";
                                ?>
                                <div class="cont <?php echo $type ?>">
                                    
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="message">
                                                <?php echo $type_text ?>, <i class="fa fa-clock"></i> <?php echo date("H:i", strtotime($item->created_at)); ?>, <?php echo formato_fecha($item->created_at); ?>
                                                <div class="inner-message">
                                                    <i class="fa fa-file-text"></i> <?php echo $item->not_message ?><?php echo $ir_link ?>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6 col-event">
                                                <span>Evento:</span> <i><?php echo $item->eve_name; ?></i> &mdash; <a href="#" class="more-event"><span class="more">Ver más</span><span class="less">Ver menos</span>...</a>
                                                <div class="event" style="display:none;">
                                                    <strong>Fecha</strong>: <?php echo formato_fecha($item->eve_date); ?><br>
                                                    <strong>Trabajador:</strong><?php echo $item->usu_ap." ".$item->usu_am." ".$item->usu_nombre ?>
                                                </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="actions">
                                    <button 
                                        class="btn btn-success"
                                        onClick="eliminar_notificacion_ajax('<?php echo base_url()."backend/notificaciones/eliminar_notificacion_ajax/"; ?>', '<?php echo $item->not_id; ?>')"
                                    >Marcar como leído</button>
                                </div>
                            </div><!-- item -->
                            <?php endforeach; ?>
                        </div>
                        <?php endif; ?>
                    </section>
                </div>
            </div>
            <!-- /Normal -->


        </div>
        <!-- /.container -->

    </div>
</div>
