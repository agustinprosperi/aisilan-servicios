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
                    
                    <form class="filters d-flex" action="<?php echo base_url() ?>backend/reportes/index/" method="get">
                        <div>
                            <div class="d-flex mb10 filter-fields">
                                <input type="text" name="date_range" value="<?php echo isset($_GET['date_range'])?$_GET['date_range']:$date_range; ?>" readonly class="daterangepickerfilter form-control mr10" placeholder="Ingrese rango de fecha">
                                
                                <select name="cli_id" class="select2-select-00 full-width-fix mr10" placeholder="Cliente">
                                    <option value=""></option>
                                    <?php foreach ($clientes as $item): ?>
                                        <?php $selected = $cli_id == $item->cli_id?"selected":""; ?>
                                        <option <?php echo $selected; ?> value="<?php echo $item->cli_id ?>">
                                            <?php echo $item->cli_name ?>
                                            <?php echo $item->cli_state==0?"(Inactivo)":""; ?>
                                        </option>
                                    <?php endforeach; ?>
                                </select>

                                <select  name="cen_id" class="select2-select-00 full-width-fix mr10" placeholder="Centro">
                                    <option value=""></option>
                                    <?php foreach ($centros as $item): ?>
                                        <?php $selected = $cen_id == $item->cen_id?"selected":""; ?>
                                        <option <?php echo $selected; ?> value="<?php echo $item->cen_id ?>">
                                            <?php echo $item->cen_name ?>
                                            <?php echo $item->cen_state==0?"(Inactivo)":""; ?>
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                                
                                <select 
                                    name="tra_id" 
                                    class="select2-select-00 full-width-fix mr10" 
                                    placeholder="Trabajador"
                                    <?php echo $this->session->userdata('usu_tipo_actual') != "Trabajador"?"":"disabled"; ?>
                                >
                                    <option value=""></option>
                                    <?php foreach ($trabajadores as $item): ?>
                                        <?php 
                                        if($tra_id == $item->usu_id or $this->session->userdata('usu_id_actual') == $item->usu_id)
                                            $selected = "selected";
                                        else
                                            $selected = ""; 
                                        ?>
                                        <option <?php echo $selected; ?> value="<?php echo $item->usu_id ?>">
                                            <?php echo $item->usu_ap ?> <?php echo $item->usu_am ?> <?php echo $item->usu_nombre ?>
                                            <?php echo $item->usu_estado==0?"(Inactivo)":""; ?>
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                                
                            </div>

                            <div class="d-flex filter-fields">
                                <select  name="pro_id" class="select2-select-00 full-width-fix mr10" placeholder="Proyecto">
                                    <option value=""></option>
                                    <?php foreach ($proyectos as $item): ?>
                                        <?php $selected = $pro_id == $item->pro_id?"selected":""; ?>
                                        <option <?php echo $selected; ?> value="<?php echo $item->pro_id ?>">
                                            <?php echo $item->pro_name ?>
                                            <?php echo $item->pro_state==0?"(Inactivo)":""; ?>
                                        </option>
                                    <?php endforeach; ?>
                                </select>

                                <select  name="eve_id" class="select2-select-00 full-width-fix mr10" placeholder="Evento">
                                    <option value=""></option>
                                    <?php foreach ($eventos as $item): ?>
                                        <?php $selected = $eve_id == $item->eve_id?"selected":""; ?>
                                        <option <?php echo $selected; ?> value="<?php echo $item->eve_id ?>">
                                            <?php echo $item->eve_name ?>
                                            <?php echo $item->eve_state==0?"(Inactivo)":""; ?>
                                        </option>
                                    <?php endforeach; ?>
                                </select>

                                <select  name="eve_imputacion" class="select2-select-00 full-width-fix mr10" placeholder="Imputación">
                                    <option value=""></option>
                                    
                                    <option value="Red de teatros" <?php echo isset($_GET['eve_imputacion']) && $_GET['eve_imputacion']=='Red de teatros'?"selected":"" ?>>Red de teatros</option>
                                    <option value="Terceros" <?php echo isset($_GET['eve_imputacion']) && $_GET['eve_imputacion']=='Terceros'?"selected":"" ?>>Terceros</option>
                                    
                                </select>

                                <select  name="eve_state" class="select2-select-00 full-width-fix mr10" placeholder="Estado de eventos">
                                    <option value=""></option>
                                    <option value="none" <?php echo (!isset($_GET['eve_state']) or $_GET['eve_state']=='' or $_GET['eve_state']=='none')?"selected":"" ?>>Eventos activos, inactivos, cerrados</option>
                                    <option value="1" <?php echo isset($_GET['eve_state']) && $_GET['eve_state']=='1'?"selected":"" ?>>Eventos activos</option>
                                    <option value="0" <?php echo isset($_GET['eve_state']) && $_GET['eve_state']=='0'?"selected":"" ?>>Eventos inactivos</option>
                                    <option value="2" <?php echo isset($_GET['eve_state']) && $_GET['eve_state']=='2'?"selected":"" ?>>Eventos cerrados</option>                                    
                                </select>

                                <select  name="tar_id" class="select2-select-00 full-width-fix mr10" placeholder="Tareas">
                                    <option value=""></option>
                                    <?php foreach ($tareas as $item): ?>
                                        <?php $selected = $tar_id == $item->tar_id?"selected":""; ?>
                                        <option <?php echo $selected; ?> value="<?php echo $item->tar_id ?>">
                                            <?php echo $item->tar_name ?>
                                            <?php echo $item->tar_state==0?"(Inactivo)":""; ?>
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                        </div>
                        <div>
                            <div class="mb10"><input type="submit" value="Filtrar" class="btn btn-primary w-100"></div>
                            <div class="mb10"><a href="<?php echo base_url(); ?>backend/reportes/index/" class="btn btn-info w-100">Limpiar</a></div>
                        </div>
                    </form>
                    
                    <div class="wrap-table-sticky">
                        <table class="table table-striped table-bordered table-hover table-sticky" style="width:auto!important;">
                            <thead>
                                <tr>
                                    
                                    <th nowrap="nowrap" class="pin">Fecha</th>
                                    <th nowrap="nowrap">Trabajador</th>
                                    <!--<th nowrap="nowrap" class="name">Trabajador</th>-->
                                    <th nowrap="nowrap">Cliente</th>
                                    <th nowrap="nowrap">Centro</th>
                                    <th nowrap="nowrap">Proyecto</th>
                                    <th nowrap="nowrap">Eventos</th>
                                    <th nowrap="nowrap">Imputación</th>
                                    <?php if(isset($_GET['key'])): ?>
                                    <th>Tipo Evento</th>
                                    <?php endif; ?>
                                    <th nowrap="nowrap">Tarea</th>
                                    <?php if(isset($_GET['key'])): ?>
                                    <th>EVE_TRA_ID</th>
                                    <th>HORA</th> 
                                    <?php endif; ?>
                                    <th nowrap="nowrap">Tipo de hora</th>
                                   
                                    
                                    <th nowrap="nowrap">Horas<br>Intranet</th>
                                    <th nowrap="nowrap">Multiplicador</th>
                                    <th nowrap="nowrap">Horas<br>Computadas</th>
                                    <th nowrap="nowrap">Minutos<br>Computados</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php 
                                $suma_horas_intranet = 0;
                                $suma_horas_computadas = 0;
                                $suma_minutos_computados = 0;
                                foreach($reporte_tareas as $item):
                                    $feriados = $this->feriado_modelo->getFeriado_GetOnlyFecha($item->eve_date, $item->prov_id, $item->loc_id);
                                ?>
                                <tr>
                                    <th nowrap="nowrap">
                                        <span class="bs-tooltip" title="EVE ID: <?php  echo $item->eve_id ?>"><?php echo $item->eve_date; ?></span>
                                    </th>
                                    <td nowrap="nowrap">
                                        <span class="bs-tooltip" title="TRA ID: <?php  echo $item->tra_id ?>"><?php echo $item->usu_ap." ".$item->usu_am. " ".$item->usu_nombre; ?></span>
                                        <?php echo $item->usu_estado==0?"<i class='fa fa-warning color-orange icon-parpadeo' title='Trabajdor inactivo'></i>":""; ?>
                                        <a title="Editar trabajador" target="_blank" href="<?php echo base_url(); ?>backend/usuario/editar/<?php echo $item->tra_id ?>/Trabajador">
                                            <i class='ml10 fa fa-external-link'></i>
                                        </a>
                                    </td>
                                    
                                    <td nowrap="nowrap">
                                        <?php echo $item->cli_name; ?>
                                        <?php echo $item->cli_state==0?"<i class='fa fa-warning color-orange icon-parpadeo' title='Cliente inactivo'></i>":""; ?>
                                    </td>
                                    <td nowrap="nowrap">
                                        <?php echo $item->cen_name; ?>
                                        <?php echo $item->cen_state==0?"<i class='fa fa-warning color-orange icon-parpadeo' title='Centro de trabajo inactivo'></i>":""; ?>
                                    </td>
                                    <td nowrap="nowrap">
                                        <?php echo $item->pro_name; ?>
                                        <?php echo $item->pro_state==0?"<i class='fa fa-warning color-orange icon-parpadeo' title='Proyecto inactivo'></i>":""; ?>
                                    </td>
                                    <td nowrap="nowrap">
                                        <span class="bs-tooltip" title="EVE ID: <?php  echo $item->eve_id ?>"><?php echo $item->eve_name; ?></span>
                                        <?php echo $item->eve_state==0?"<i class='fa fa-warning color-orange icon-parpadeo' title='Evento inactivo'></i>":""; ?>
                                        <a title="Editar Evento" target="_blank" href="<?php echo base_url(); ?>backend/eventos/editar/<?php echo $item->eve_id ?>">
                                            <i class='ml10 fa fa-external-link'></i>
                                        </a>
                                    </td>
                                    <td nowrap="nowrap">
                                        <?php echo $item->eve_imputacion; ?>
                                    </td>
                                    <?php if(isset($_GET['key'])): ?>
                                    <td><?php echo $item->eve_tipo_horario; ?></td>
                                    <?php endif; ?>
                                    <!-- TAREAS -->
                                    <td nowrap="nowrap">
                                        <?php 
                                        $tarea = $this->tarea_modelo->getId($item->eve_tar_ids);
                                        echo $tarea->tar_name;
                                        ?>
                                    </td>
                                    <?php if(isset($_GET['key'])): ?>
                                    <!-- EVE TRA ID -->
                                    <td><?php echo $item->eve_tar_id; ?></td>
                                    <!-- HORA -->
                                    <td nowrap="nowrap">
                                        <?php 
                                        $horquilla = $this->horquillahoraria_modelo->getId($item->hor_id);
                                        $resu = array();
                                        if($item->eve_tipo_horario == "Continuo" and $item->eve_validar == 1){
                                            echo $item->eve_tar_horario_from; ?><br><?php echo $item->eve_tar_horario_to; 
                                            
                                        }elseif($item->eve_tipo_horario == "Partido"){
                                            if($item->eve_tar_type=='morning'){ echo "<div>Mañana: <br>".$item->eve_tar_horario_from; ?><br><?php echo $item->eve_tar_horario_to."</div>"; }
                                            if($item->eve_tar_type=='afternoon'){ echo "<div>Tarde: <br>".$item->eve_tar_horario_from; ?><br><?php echo $item->eve_tar_horario_to."</div>"; }
                                            if($item->eve_tar_type=='night'){ echo "<div>Noche: <br>".$item->eve_tar_horario_from; ?><br><?php echo $item->eve_tar_horario_to."</div>"; }
                                        }
                                        print_r($feriados);
                                        ?>
                                    </td>
                                    <?php endif;//$_GET['key'] ?>
                                    <!-- TIPO DE HORA -->
                                    <td nowrap="nowrap">
                                        <?php 
                                        $horquilla = $this->horquillahoraria_modelo->getId($item->hor_id);
                                        //print_r($horquilla);//exit;
                                        
                                        $resu['hora_dia'] = 0;
                                        $resu['hora_noche'] = 0;
                                        //$resu['hora_madrugada'] = 0;
                                        //obtener feriados de una prov_id y loc_id
                                        
                                        if($item->eve_tipo_horario == "Continuo" and $item->eve_validar==1){
                                            //$resutado = calcularHorasDiaNocheRango($item->eve_tra_ck_horario_from, $item->eve_tra_ck_horario_to);
                                            $resu = calculoX(
                                                            $item->eve_tar_horario_from, 
                                                            $item->eve_tar_horario_to,
                                                            $horquilla,
                                                            $feriados
                                                        );

                                            //if($resu['tipo_hora_madrugada']) echo "<div>".$resu['tipo_hora_madrugada']."</div>";
                                            if($resu['tipo_hora_dia']) echo "<div>".$resu['tipo_hora_dia']."</div>";
                                            if($resu['tipo_hora_noche']) echo "<div>".$resu['tipo_hora_noche']."</div>";
                                            
                                            
                                        }elseif($item->eve_tipo_horario == "Partido" and $item->eve_validar==1){

                                            $resu_morning = array(
                                                'hora_madrugada' => 0,
                                                'hora_dia' => 0,
                                                'hora_noche' => 0,

                                                'tipo_hora_madrugada' => '',
                                                'tipo_hora_dia' => '',
                                                'tipo_hora_noche' => '',

                                                'horquilla_madrugada' => '',
                                                'horquilla_dia' => '',
                                                'horquilla_noche' => '',
                                            );

                                            $resu_afternoon = array(
                                                //'hora_madrugada' => 0,
                                                'hora_dia' => 0,
                                                'hora_noche' => 0,

                                                //'tipo_hora_madrugada' => '',
                                                'tipo_hora_dia' => '',
                                                'tipo_hora_noche' => '',

                                                'horquilla_madrugada' => '',
                                                'horquilla_dia' => '',
                                                'horquilla_noche' => '',
                                            );

                                            $resu_night= array(
                                                //'hora_madrugada' => 0,
                                                'hora_dia' => 0,
                                                'hora_noche' => 0,

                                                //'tipo_hora_madrugada' => '',
                                                'tipo_hora_dia' => '',
                                                'tipo_hora_noche' => '',

                                                'horquilla_madrugada' => '',
                                                'horquilla_dia' => '',
                                                'horquilla_noche' => '',
                                            );

                                            if($item->eve_tar_type == 'morning'){
                                                $resu_morning  = calculoX(
                                                                        $item->eve_tar_horario_from, 
                                                                        $item->eve_tar_horario_to,
                                                                        $horquilla,
                                                                        $feriados
                                                                    );
                                                                    //echo "de morning";
                                                //print_r($resu_morning);echo "<br>";
                                            }
                                            //print_r($horquilla);echo "<br>";

                                            if($item->eve_tar_type == 'afternoon'){
                                                $resu_afternoon = calculoX(
                                                                        $item->eve_tar_horario_from, 
                                                                        $item->eve_tar_horario_to,
                                                                        $horquilla,
                                                                        $feriados
                                                                    );
                                                                    //echo "de afternoon";
                                                //print_r($resu_afternoon);echo "<br>";
                                            }

                                            if($item->eve_tar_type == 'night'){
                                                $resu_night    = calculoX(
                                                                        $item->eve_tar_horario_from, 
                                                                        $item->eve_tar_horario_to,
                                                                        $horquilla,
                                                                        $feriados
                                                                    );
                                                                    //echo "de night";
                                                //print_r($resu_night);
                                            }

                                            $madrugada = array();
                                            $dia = array();
                                            $noche = array();

                                            //$madrugada['hora'] = $resu_morning['hora_madrugada'] + $resu_afternoon['hora_madrugada'] + $resu_night['hora_madrugada'];
                                            $dia['hora'] = $resu_morning['hora_dia'] + $resu_afternoon['hora_dia'] + $resu_night['hora_dia'];
                                            $noche['hora'] = $resu_morning['hora_noche'] + $resu_afternoon['hora_noche'] + $resu_night['hora_noche'];
                                            //$noche['hora'] = 99;
                                            
                                            //$madrugada['tipo_hora'] = $resu_morning['tipo_hora_madrugada'].' '.$resu_afternoon['tipo_hora_madrugada'].' '.$resu_night['tipo_hora_madrugada'];
                                            $dia['tipo_hora'] = $resu_morning['tipo_hora_dia'].' '.$resu_afternoon['tipo_hora_dia'].' '.$resu_night['tipo_hora_dia'];
                                            $noche['tipo_hora'] = $resu_morning['tipo_hora_noche'].' '.$resu_afternoon['tipo_hora_noche'].' '.$resu_night['tipo_hora_noche'];

                                            //$madrugada['horquilla'] = $resu_morning['horquilla_madrugada'].' '.$resu_afternoon['horquilla_madrugada'].' '.$resu_night['horquilla_madrugada'];
                                            $dia['horquilla'] = $resu_morning['horquilla_dia'].' '.$resu_afternoon['horquilla_dia'].' '.$resu_night['horquilla_dia'];
                                            $noche['horquilla'] = $resu_morning['horquilla_noche'].' '.$resu_afternoon['horquilla_noche'].' '.$resu_night['horquilla_noche'];

                                            //imprimir tipo de hora
                                            //if($madrugada['tipo_hora']) echo "<div>".remove_word_repeat($madrugada['tipo_hora'])."</div>";
                                            if($dia['tipo_hora']) echo "<div>".remove_word_repeat($dia['tipo_hora'])."</div>";
                                            if($noche['tipo_hora']) echo "<div>".remove_word_repeat($noche['tipo_hora'])."</div>";
                                        
                                        }
                                        ?>
                                    </td>
                                    <!-- HORAS INTRANET -->
                                    <td nowrap="nowrap" class="text-center">
                                    <?php 
                                        $x1 = $x2 = $x3 = 0;
                                        if($item->eve_tipo_horario == "Continuo"){
                                            //if($resu['hora_madrugada']) { echo "<div>"; echo $x1 = numeroFormateado($resu['hora_madrugada']); echo "</div>"; }
                                            if($resu['hora_dia']){ echo "<div>"; echo $x2 = numeroFormateado($resu['hora_dia']); echo "</div>"; }
                                            if($resu['hora_noche']){ echo "<div>"; echo $x3 = numeroFormateado($resu['hora_noche']); echo "</div>"; }
                                        }elseif($item->eve_tipo_horario == "Partido"){
                                            //echo $madrugada['hora'];
                                            //if($madrugada['hora']) { echo "<div>"; echo $x1 = numeroFormateado($madrugada['hora']); echo "</div>"; } //3:53
                                            if($dia['hora']) { echo "<div>"; echo $x2 = numeroFormateado($dia['hora']); echo "</div>"; }
                                            if($noche['hora']) { echo "<div>"; echo $x3 = numeroFormateado($noche['hora']); echo "</div>"; }
                                        }
                                        //echo "<strong>";
                                        $suma_horas_intranet += numeroFormateado($x1 + $x2 + $x3);
                                        //echo "</strong>";
                                    ?>
                                    </td>
                                    <!-- MULTIPLICADOR -->
                                    <td nowrap="nowrap" class="text-center">
                                    <?php 
                                        if($item->eve_tipo_horario == "Continuo"){
                                            //if($resu['horquilla_madrugada']){ echo "<div>"; echo $resu['horquilla_madrugada']; echo "</div>"; }
                                            if($resu['horquilla_dia']){ echo "<div>"; echo $resu['horquilla_dia']; echo "</div>"; }
                                            if($resu['horquilla_noche']){ echo "<div>"; echo $resu['horquilla_noche']; echo "</div>"; }
                                        }elseif($item->eve_tipo_horario == "Partido"){
                                            //if($madrugada['horquilla']){ echo "<div>"; echo remove_word_repeat($madrugada['horquilla']); echo "</div>"; }
                                            if($dia['horquilla']){ echo "<div>"; echo remove_word_repeat($dia['horquilla']); echo "</div>"; }
                                            if($noche['horquilla']){ echo "<div>"; echo remove_word_repeat($noche['horquilla']); echo "</div>"; }
                                        }
                                    ?>
                                    </td>
                                    <!-- HORAS COMPUTADAS -->
                                    <td nowrap="nowrap" class="text-center">
                                    <?php 
                                        $suma_horas_madrugada = 0;
                                        $suma_horas_dia = 0;
                                        $suma_horas_noche = 0;

                                        $suma_horas = 0;

                                        if($item->eve_tipo_horario == "Continuo"){
                                            
                                            //if($resu['horquilla_madrugada']) echo "<div>".($suma_horas_madrugada = numeroFormateado($resu['horquilla_madrugada'] * $resu['hora_madrugada']))."</div>";
                                            if($resu['horquilla_dia']) echo "<div>".($suma_horas_dia = numeroFormateado($resu['horquilla_dia'] * $resu['hora_dia']))."</div>";
                                            if($resu['horquilla_noche']) echo "<div>".($suma_horas_noche = numeroFormateado($resu['horquilla_noche'] * $resu['hora_noche']))."</div>";
                                            $suma_horas = $suma_horas_madrugada + $suma_horas_dia + $suma_horas_noche;
                                        }elseif($item->eve_tipo_horario == "Partido"){/////////////////////////////////////////
                                            //if($madrugada['hora']) echo "<div>".($suma_horas_madrugada = numeroFormateado( (float)remove_word_repeat($madrugada['horquilla']) * $madrugada['hora']) )."</div>";
                                            if($dia['hora']) echo "<div>".($suma_horas_dia = numeroFormateado( (float)remove_word_repeat($dia['horquilla']) * $dia['hora']) )."</div>";
                                            if($noche['hora']) echo "<div>".($suma_horas_noche = numeroFormateado( (float)remove_word_repeat($noche['horquilla']) * $noche['hora']) )."</div>";
                                            $suma_horas = $suma_horas_madrugada + $suma_horas_dia + $suma_horas_noche;
                                        }
                                        //echo "<strong>";
                                        $suma_horas_computadas += $suma_horas;
                                        //echo "</strong>";
                                    ?>
                                    </td>
                                    <!-- MINUTOS COMPUTADOS -->
                                    <td nowrap="nowrap" class="text-center">
                                    <?php 
                                        echo ($minutos_computados = $suma_horas*60);
                                        //echo "<div><strong>";
                                        $suma_minutos_computados += $minutos_computados;
                                        //echo "</strong></div>";
                                    ?>
                                    </td>
                                </tr>
                                <?php endforeach; ?>
                                <tr>
                            </tbody>
                            <tfoot>
                                <tr>
                                    <th>&nbsp;</th><!-- FECHA -->
                                    <th>&nbsp;</th><!-- TRABAJADOR -->
                                    <th>&nbsp;</th><!-- CLIENTE -->
                                    <th>&nbsp;</th><!-- CENTRO -->
                                    <th>&nbsp;</th><!-- PROYECTO -->
                                    <th>&nbsp;</th><!-- EVENTOS -->
                                    <th>&nbsp;</th><!-- IMPUTACION -->
                                    <?php if(isset($_GET['key'])): ?>
                                    <th>&nbsp;</th><!-- TIPO DE EVENTO -->
                                    <?php endif; ?>
                                    <th>&nbsp;</th><!-- TAREA -->
                                    <?php if(isset($_GET['key'])): ?>
                                    <th>&nbsp;</th><!-- EVE_TRA_ID -->
                                    <th>&nbsp;</th><!-- HORA -->
                                    <?php endif; ?>
                                    <th nowrap="nowrap">SUMATORIA =></th><!-- TIPO NORA -->
                                    <th class="text-center"><?php echo $suma_horas_intranet; ?></th><!-- HORAS INTRANET -->
                                    <th>&nbsp;</th><!-- MULTIPLICADOR -->
                                    <th class="text-center"><?php echo $suma_horas_computadas; ?></th><!-- HORAS COMPUTADAS -->
                                    <th class="text-center"><?php echo $suma_minutos_computados ?></th><!-- MINUTOS COMPUTADOS -->
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
            </div>
            <!-- /Normal -->


        </div>
        <!-- /.container -->

    </div>
</div>
