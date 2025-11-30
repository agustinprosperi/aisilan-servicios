<?php require (APPPATH."views/layouts/backend/header.php"); ?>

<div id="container">
    <?php require (APPPATH."views/layouts/backend/sidebarleft.php"); ?>

    <div id="content">
        <div class="container">
            
            <?php require (APPPATH."views/layouts/backend/crumbs-page-header.php"); ?>

            <form method="post" class="form-horizontal row-border" id="validate_1" action="<?php echo base_url() ?>backend/admin/<?php echo $action ?>">

                <!--=== Page Content ===-->
                <?php echo $this->message->display(); ?>
                <div class="row">
                    <!--=== Validation Example 1 ===-->
                    <div class="col-sm-3">
                        <img src="<?php echo base_url() ?>public/backend/img/silueta.jpg" alt=""><br>
                        
                    </div>
                    <div class="col-sm-9">                  
                        <!-- Tabs-->
                        <div class="tabbable tabbable-custom tabbable-full-width">
                            <ul class="nav nav-tabs">
                                <li class="active"><a href="#tab_overview" data-toggle="tab">Información general</a></li>
                                <li><a href="#tab_edit_account" data-toggle="tab">Password y nombre de usuario</a></li>
                            </ul>
                            <?php 
                            $admin_permiso = (($this->session->userdata("usu_tipo_actual") == "Super_admin") or ($this->session->userdata("usu_tipo_actual") == "Administrador" ))?true:false;
                            ?>
                            <div class="tab-content row">
                                <!--=== Overview ===-->
                                <div class="tab-pane active" id="tab_overview">

                                    <div class="col-sm-12">
                                        <div class="widget">
                                            <div class="widget-content">
                                                <div class="row">
                                                    <div class="col-sm-6">
                                                        <div class="form-group">
                                                            <label class="col-sm-4 control-label">Nombres:</label>
                                                            <?php if($admin_permiso): ?>
                                                            <input onkeyup="pulsar(this)" type="text" name="usu_nombre" value="<?php if(isset($usu_nombre)) echo $usu_nombre ?>" class="required col-sm-8" placeholder="nombre">                                                
                                                            <?php else: ?>
                                                            <?php if(isset($usu_nombre)) echo "<span class='control-label'>".$usu_nombre."</span>"; ?>
                                                            <?php endif; ?>
                                                        </div>

                                                        <div class="form-group">
                                                            <label class="col-sm-4 control-label">Ap. parterno:</label>
                                                            <?php if($admin_permiso): ?>
                                                            <input onkeyup="pulsar(this)" type="text" name="usu_ap" value="<?php if(isset($usu_ap)) echo $usu_ap ?>" class=" required col-sm-8" placeholder="apellido paterno">
                                                            <?php else: ?>
                                                            <?php if(isset($usu_nombre)) echo "<span class='control-label'>".$usu_ap."</span>"; ?>
                                                            <?php endif; ?>
                                                        </div>

                                                        <div class="form-group">
                                                            <label class="col-sm-4 control-label">Ap. materno:</label>
                                                            
                                                            <?php if($admin_permiso): ?>
                                                            <input onkeyup="pulsar(this)" type="text" name="usu_am" value="<?php if(isset($usu_am)) echo $usu_am ?>" class=" required col-sm-8"  placeholder="apellido materno">
                                                            <?php else: ?>
                                                            <?php if(isset($usu_nombre)) echo "<span class='control-label'>".$usu_am."</span>"; ?>
                                                            <?php endif; ?>
                                                        </div>

                                                        <div class="form-group">
                                                            <label class="control-label col-sm-4">Email</label>
                                                            <input type="text" name="usu_email" value="<?php if(isset($usu_email)) echo $usu_email ?>" class="email col-sm-8" placeholder="correo electrónico">
                                                        </div>

                                                        <div class="form-group">
                                                            <label class="control-label col-sm-4">Teléfono</label>
                                                            <input type="text" name="usu_telefono" value="<?php if(isset($usu_telefono)) echo $usu_telefono ?>" class="col-sm-8"  placeholder="teléfono">
                                                        </div>
                                                        
                                            
                                                    </div>


                                                    <div class="col-sm-6 pass">
                                                        <div class="form-group">
                                                            <label class="control-label col-sm-4">Móvil</label>
                                                            <input type="text" name="usu_celular" value="<?php if(isset($usu_celular)) echo $usu_celular ?>" class="col-sm-8" placeholder="Móvil">
                                                        </div>
                                                        <div class="form-group">
                                                            <label class="control-label col-sm-4">DNI</label>
                                                            <input type="text" name="usu_dni" value="<?php if(isset($usu_dni)) echo $usu_dni ?>" class="col-sm-8" placeholder="DNI">
                                                        </div>

                                                        <div class="form-group">
                                                            <label class="control-label col-sm-4">Dirección</label>
                                                            <textarea onkeyup="pulsar(this)" class="auto col-sm-8" name="usu_direccion" cols="5" rows="3" style="overflow: hidden; word-wrap: break-word; resize: horizontal; height: 87px;"><?php if(isset($usu_direccion)) echo $usu_direccion ?></textarea>
                                            
                                                        </div>
                                                        
                                                    </div>
                                                </div> <!-- /.row -->
                                            </div> <!-- /.widget-content -->
                                        </div> <!-- /.widget -->
                                    </div> <!-- /.col-sm-9 -->
                                </div>
                                <!-- /Overview -->

                                <!--=== Edit Account ===-->
                                <div class="tab-pane" id="tab_edit_account">
                                    <div class="col-sm-12 form-vertical no-margin">
                                        <div class="widget">
                                            <div class="widget-content">
                                                <div class="form-group">                                                        
                                                    <label class="col-sm-4 control-label">Username *</label>
                                                    <input <?php if($action != "insertar_admin") echo "readonly" ?> type="text" name="usu_username" value="<?php if(isset($usu_username)) echo $usu_username; else echo ""; ?>" class="required col-sm-8">
                                                    
                                                </div> <!-- /.form-group -->
                                                <div class="form-group">
                                                    
                                                    <label class="control-label col-sm-4">Contraseña:</label>
                                                    <input type="password" name="usu_password" class="col-sm-8" minlength="5" maxlength="10" value="">
                                                </div>

                                                <div class="form-group">
                                                    <label class="control-label col-sm-4">Repetir contraseña:</label>
                                                    <input type="password" name="cpass1" class="col-sm-8 " minlength="5" maxlength="10" equalTo="[name='usu_password']">
                                                        
                                                </div> <!-- /.row -->
                                            </div> <!-- /.widget-content -->
                                        </div> <!-- /.widget -->
                                        
                                    </div> <!-- /.col-sm-12 -->
                                </div>
                                <!-- /Edit Account -->
                            </div> <!-- /.tab-content -->

                            <div>
                                <input type="submit" name="submit" value="<?php echo $button_text ?>" class="btn btn-primary">
                            </div>
                        </div>
                        <!--END TABS-->
                        
                        
                    </div>
                </div>
                <input type="hidden" name="usu_id" value="<?php if(isset($usu_id)) echo $usu_id  ?>">
            </form>
        </div>
        <!-- /.container -->

    </div>
</div>
