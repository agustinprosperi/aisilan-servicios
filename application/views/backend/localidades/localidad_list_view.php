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
                        <?php if(verificarPermiso("loc_nuevo")): ?>
                        <div class="widget-header">
                            <div class="toolbar" >
                                <a href="<?php echo base_url()."backend/localidades/insertar/"; ?>" class="btn btn-primary btn-info">Nueva Localidad</a>
                            </div>
                        </div>
                        <?php endif; ?>
                        <div class="widget-content">
                            <form class="table-responsive" name="formdelete" id="formdelete" action="<?php echo base_url() ?>backend/localidades/eliminar" method="post">
                                <table class="table table-striped table-bordered table-hover table-checkable datatable" data-display-length="25">
                                    <thead>
                                        <tr>
                                            
                                            <th width="100">ID</th>
                                            <th>Localidad</th>
                                            <th>Provincia</th>
                                            <th class="align-center" width="150">Acción</th>
                                        
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php foreach($lista as $valor): ?>
                                        <tr>
                                            
                                            <td><?php echo $valor->loc_id; ?></td>
                                            <td>
                                                <?php if(verificarPermiso("loc_editar")): ?>
                                                <a href="<?php echo base_url() ?>backend/localidades/editar/<?php echo $valor->loc_id ?>">
                                                <?php endif; ?>
                                                    <?php echo $valor->loc_name ?>
                                                <?php if(verificarPermiso("loc_editar")): ?>
                                                </a>
                                                <?php endif; ?>
                                            </td>
                                            <td><?php echo $this->provincia_modelo->getId($valor->prov_id)->prov_name??""; ?></td>                                        
                                            <td class="text-center" >
                                                <ul class="table-controls">
                                                    <?php if(verificarPermiso("fer_lista")): ?>
                                                    <li><a href="<?php echo base_url() ?>backend/feriados/index/?fer_type=Local&loc_id=<?php echo $valor->loc_id ?>&prov_id=<?php echo $valor->prov_id ?>" class="bs-tooltip" title="Feriado"><i class="icon-calendar"></i></a> </li>
                                                    <?php endif; ?>

                                                    <?php if(verificarPermiso("loc_editar")): ?>
                                                    <li><a href="<?php echo base_url() ?>backend/localidades/editar/<?php echo $valor->loc_id ?>" class="bs-tooltip" title="Editar"><i class="icon-pencil"></i></a> </li>
                                                    <?php endif; ?>
                                                    <?php if(verificarPermiso("loc_eliminar")): ?>
                                                    <li><a href="<?php echo base_url() ?>backend/localidades/eliminar/DEL/<?php echo $valor->loc_id ?>" class="bs-tooltip confirm-dialog-delete" title="Eliminar definitivamente"><i class="icon-remove"></i></a> </li>
                                                    <?php endif; ?>
                                                </ul>
                                            </td>
                                        </tr>
                                        <?php endforeach; ?>
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
