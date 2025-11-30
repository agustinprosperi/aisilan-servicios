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
                            <h4><?php echo $titulo_form ?></h4>
                        </div>
                        <div class="widget-content">
                            <form method="post" class="form-horizontal row-border" id="validate_1" action="<?php echo base_url() ?>backend/localidades/<?php echo $action ?>/">
                                <div class="col-md-10">
                                <div class="form-group">
                                        <label class="control-label col-md-4">Nombre <span class="required">*</span></label>
                                        <div class="col-md-8">
                                            <input type="text" name="loc_name" value="<?php if(isset($loc_name)) echo $loc_name ?>" class="form-control required" placeholder="Ingrese nombre de localidad">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="control-label col-md-4">Provincia <span class="required">*</span></label>
                                        <div class="col-md-8">
                                            <select name="prov_id" id="" class="select2-select-00 col-md-12 full-width-fix required">
                                                <option value=""></option>
                                                <?php foreach ($provincias as $item): ?>
                                                    <?php if($prov_id == $item->prov_id) $selected = "selected"; else $selected = "" ?>
                                                    <option <?php echo $selected ?> value="<?php echo $item->prov_id ?>"><?php echo $item->prov_name ?></option>
                                                <?php endforeach; ?>
                                            </select>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-2">
                                    <div class="form-actions">
                                        <input value="Aceptar" class="btn btn-primary btn-block" type="submit" name="submit">
                                        <input value="Aceptar + Nuevo" class="btn btn-info btn-block" type="submit" name="submit-nuevo">
                                        <input value="Cancelar" class="btn btn-success btn-block" type="button" onclick="location.href='<?php echo base_url() ?>backend/localidades/index/'">
                                    </div>
                                </div>
                                <input type="hidden" name="loc_id" value="<?php echo $loc_id ?>">
                            </form>
                        </div>
                    </div>
                    <!-- /Validation Example 1 -->
                </div>
            </div>
        </div>
        <!-- /.container -->

    </div>
</div>
