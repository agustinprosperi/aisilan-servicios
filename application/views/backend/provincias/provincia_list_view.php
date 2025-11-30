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
                        <?php if(verificarPermiso("prov_nuevo")): ?>
                        <div class="widget-header">
                            <div class="toolbar" >
                                <a href="<?php echo base_url()."backend/provincias/insertar/"; ?>" class="btn btn-primary btn-info">Nueva Provincia</a>
                            </div>
                        </div>
                        <?php endif; ?>
                        <div class="widget-content">

                            <form name="formdelete" id="formdelete" action="<?php echo base_url() ?>backend/provincias/eliminar" method="post">

                            <table class="table table-striped table-bordered table-hover table-checkable datatable" data-display-length="25">
                                <thead>
                                    <tr>
                                        
                                        <th width="100">ID</th>
                                        <th>Provincia</th>
                                        <th class="align-center" width="150">Acción</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach($lista as $valor): ?>
                                    <tr>
                                        
                                        <td><?php echo $valor->prov_id; ?></td>
                                        <td>
                                            <?php if(verificarPermiso("prov_editar")): ?>
                                            <a href="<?php echo base_url() ?>backend/provincias/editar/<?php echo $valor->prov_id ?>">
                                            <?php endif; ?>
                                                <?php echo $valor->prov_name ?>
                                            <?php if(verificarPermiso("prov_editar")): ?>
                                            </a>
                                            <?php endif; ?>
                                        </td>
                                        
                                        <td class="text-center" >
                                            <ul class="table-controls">
                                                <?php if(verificarPermiso("prov_editar")): ?>
                                                <li><a href="<?php echo base_url() ?>backend/provincias/editar/<?php echo $valor->prov_id ?>" class="bs-tooltip" title="Editar"><i class="icon-pencil"></i></a> </li>
                                                <?php endif; ?>
                                                <?php if(verificarPermiso("prov_eliminar")): ?>
                                                <li><a href="<?php echo base_url() ?>backend/provincias/eliminar/DEL/<?php echo $valor->prov_id ?>" class="bs-tooltip confirm-dialog-delete" title="Eliminar definitivamente"><i class="icon-remove"></i></a> </li>
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
