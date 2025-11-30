<?php

header( "Pragna: public");
header( "Expires: 0");
header( "Cache-Control: must-revalidate, post-check=0, pre-check=0");
header( "Content-Type: application/force-download");
header( "Content-Type: application/octet-stream");
header( "Content-Type: application/download");
header( "Content-Type: application/vnd.ms-excel");
header( 'Content-Disposition: attachment; filename='.$filename.'.xls');
?>
<style>
    .table-xls thead th,
    .table-xls tbody th,
    .table-xls tbody td{
        border:1px solid #000000;
        padding:5px 10px;
    }
    .table-xls thead th{
        background:#e9e9e9;
    }
</style>
<h1>Reportes</h1>
<?php if($date_range): ?>
<p><strong>Fecha: </strong><?php echo $date_range; ?></p>
<?php endif; ?>

<?php if($cli_id): ?>
<p><strong>Cliente: </strong><?php $cliente = $this->cliente_modelo->getId($cli_id); echo $cliente->cli_name ?></p>
<?php endif; ?>

<?php if($cen_id): ?>
<p><strong>Centro: </strong><?php $centro = $this->centro_modelo->getId($cen_id); echo $centro->cen_name ?></p>
<?php endif; ?>

<?php if($pro_id): ?>
<p><strong>Proyecto: </strong><?php $proyecto = $this->proyecto_modelo->getId($pro_id); echo $proyecto->pro_name ?></p>
<?php endif; ?>

<?php if($eve_id): ?>
<p><strong>Evento: </strong><?php $evento = $this->evento_modelo->getId($eve_id); echo $evento->eve_name ?></p>
<?php endif; ?>

<?php if($tar_id): ?>
<p><strong>Tarea: </strong><?php $tarea = $this->tarea_modelo->getId($tar_id); echo $tarea->tar_name ?></p>
<?php endif; ?>

<?php if($tra_id): ?>
<p><strong>Trabajador: </strong><?php $trabajador = $this->usuario_modelo->getId($tra_id); echo $trabajador->usu_ap." ".$trabajador->usu_am." ".$trabajador->usu_nombre; ?></p>
<?php endif; ?>
<table class="table-xls">
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
            <th nowrap="nowrap" title="<?php echo $item->eve_tar_id ?>"><?php echo $item->eve_date; ?></th>
            <td nowrap="nowrap" title="<?php echo $item->eve_tar_id ?>"><?php echo $item->usu_ap." ".$item->usu_am. " ".$item->usu_nombre; ?></td>
            
            <td nowrap="nowrap"><?php echo $item->cli_name; ?></td>
            <td nowrap="nowrap"><?php echo $item->cen_name; ?></td>
            <td nowrap="nowrap"><?php echo $item->pro_name; ?></td>
            <td nowrap="nowrap"><?php echo $item->eve_name; ?></td>
            <td nowrap="nowrap"><?php echo $item->eve_imputacion; ?></td>
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
                ?>
            </td>
            <?php endif;//$_GET['key'] ?>
            <!-- TIPO DE HORA -->
            <td nowrap="nowrap">
                <?php 
                $horquilla = $this->horquillahoraria_modelo->getId($item->hor_id);
                
                $resu['hora_dia'] = 0;
                $resu['hora_noche'] = 0;
                $resu['hora_madrugada'] = 0;
                if($item->eve_tipo_horario == "Continuo" and $item->eve_validar==1){
                    //$resutado = calcularHorasDiaNocheRango($item->eve_tra_ck_horario_from, $item->eve_tra_ck_horario_to);
                    $resu = calculoX(
                                    $item->eve_tar_horario_from, 
                                    $item->eve_tar_horario_to,
                                    $horquilla,
                                    $feriados
                                );

                    if($resu['tipo_hora_madrugada']) echo "<div>".$resu['tipo_hora_madrugada']."</div>";
                    if($resu['tipo_hora_dia']) echo "<div>".$resu['tipo_hora_dia']."</div>";
                    if($resu['tipo_hora_noche']) echo "<div>".$resu['tipo_hora_noche']."</div>";
                    
                    
                }elseif($item->eve_tipo_horario == "Partido"){

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

                    $resu_night= array(
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

                    if($item->eve_tar_type == 'morning')
                        $resu_morning  = calculoX(
                                                $item->eve_tar_horario_from, 
                                                $item->eve_tar_horario_to,
                                                $horquilla,
                                                $feriados
                                            );
                    if($item->eve_tar_type == 'afternoon')
                        $resu_afternoon = calculoX(
                                                $item->eve_tar_horario_from, 
                                                $item->eve_tar_horario_to,
                                                $horquilla,
                                                $feriados
                                            );
                    if($item->eve_tar_type == 'night')
                        $resu_night    = calculoX(
                                                $item->eve_tar_horario_from, 
                                                $item->eve_tar_horario_to,
                                                $horquilla,
                                                $feriados
                                            );
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
                    //if($madrugada['hora']) { echo "<div>"; echo $x1 = numeroFormateado($madrugada['hora']); echo "</div>"; }
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
                }elseif($item->eve_tipo_horario == "Partido"){
                    //if($madrugada['hora']) echo "<div>".($suma_horas_madrugada = numeroFormateado((float)remove_word_repeat($madrugada['horquilla'])*$madrugada['hora']))."</div>";
                    if($dia['hora']) echo "<div>".($suma_horas_dia = numeroFormateado((float)remove_word_repeat($dia['horquilla'])*$dia['hora']))."</div>";
                    if($noche['hora']) echo "<div>".($suma_horas_noche = numeroFormateado((float)remove_word_repeat($noche['horquilla'])*$noche['hora']))."</div>";
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
