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
                    <div class="widget box">
                        <div class="widget-header">		
                            <div class="toolbar left d-flex">
                                <form class="filter-date d-flex mb0" method="post" action="<?php echo current_url(); ?>">
                                    <input type="text" id="date_range_filter" name="date_range_filter" value="" class="form-control daterangefilter required">
                                    <input type="submit" value="Filtrar" class="btn btn-primary btn-info ml10">
                                </form>
                            </div>
                        </div>
                        <div class="widget-content">

                            <form class="table-responsive" name="formdelete" id="formdelete" action="<?php echo base_url() ?>backend/eventos/eliminar" data-url="<?php echo base_url() ?>backend/eventos/activar" method="post">

                                <table class="table table-striped table-bordered table-hover table-checkable datatable" data-display-length="25">
                                    <thead>
                                        <tr>
                                            <td>#</td>
                                            <th width="15%">EVE ID</th>
                                            <th width="30%">Evento</th>
                                            <th nowrap="nowrap">Fecha</th>
                                            <th>Proyecto</th>
                                            <th class="align-center">Acción</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php $i = 1; ?>
                                        <?php foreach($evetos_lista as $valor): ?>
                                        <tr>
                                            <td><?php echo $i ?></td>
                                            <td><?php echo $valor->eve_id ?></td>
                                            <td>
                                                <a href="<?php echo base_url() ?>backend/eventos/ver/<?php echo $valor->eve_id ?>/<?php echo $valor->eve_tar_id ?>" class="bs-tooltip" title="EVE TAR ID: <?php  echo $valor->eve_tar_id ?>">
                                                    <?php echo $valor->eve_name ?>
                                                </a>
                                            </td>
                                            <td nowrap="nowrap"><?php echo formato_fecha($valor->eve_date) ?></td>
                                            
                                            <td>
                                                <?php 
                                                if($valor->coo_id != '' or $valor->coo_id != NULL){
                                                    $ap = $this->usuario_modelo->getId($valor->coo_id)->usu_ap??"";
                                                    $am = $this->usuario_modelo->getId($valor->coo_id)->usu_am??"";
                                                    $nombre = $this->usuario_modelo->getId($valor->coo_id)->usu_nombre??"";
                                                }
                                                ?>
                                                <?php echo $this->proyecto_modelo->getId($valor->pro_id)->pro_name??""; ?><br>
                                                <i><u>Coordinador:</u> <?php echo $ap." ".$am." ".$nombre; ?></i><br>
                                                <i><u>Cliente:</u> <?php echo $this->cliente_modelo->getId($valor->cli_id)->cli_name??""; ?></i>
                                            </td>
                                            <td class="text-center">
                                                <ul class="table-controls">
                                                    <li><a href="<?php echo base_url() ?>backend/eventos/ver/<?php echo $valor->eve_id ?>" class="bs-tooltip" title="Ver"><i class="icon-eye-open"></i></a> </li>
                                                </ul>
                                            </td>
                                            
                                        </tr>
                                        <?php $i++; endforeach; ?>
                                    </tbody>
                                </table>
                                
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

<script>
$(function() {

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