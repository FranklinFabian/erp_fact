<!-- Change Password Page Start -->
<div class="content-wrapper">
    <section class="content-header">
        <div class="header-icon"><i class="pe-7s-user"></i></div>
        <div class="header-title">
            <h1>Cambia tu información</h1>
            <small>Cambiar constraseña</small>
            <ol class="breadcrumb">
                <li><a href="#"><i class="pe-7s-home"></i><?php echo display('home') ?></a></li>
                <li><a href="#">Perfil</a></li>
                <li class="active">Cambiar contraseña</li>
            </ol>
        </div>
    </section>
    <!-- Main content -->
    <section class="content">
        <div class="row">
            <div class="col-sm-12 col-md-4">
            </div>
            <div class="col-sm-12 col-md-4 ">
                <!-- Alert Message -->
                <?php
                    $message = $this->session->userdata('message');
                    if (isset($message)) {
                ?>
                <div class="alert alert-info alert-dismissable">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                    <?php echo $message ?>
                </div>
                <?php
                    $this->session->unset_userdata('message');
                    }
                    $error_message = $this->session->userdata('error_message');
                    if (isset($error_message)) {
                ?>
                <div class="alert alert-danger alert-dismissable">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                    <?php echo $error_message ?>
                </div>
                <?php
                    $this->session->unset_userdata('error_message');
                    }
                ?>

                <!-- Login widget -->
                <div class="login-widget">
                    <div class="panel panel-bd">
                        <div class="panel-heading">
                            <h4>Cambiar información</h4>
                        </div>
                            <?php echo form_open_multipart('Admin_dashboard/change_password',array('id' => 'insert_product','class' => 'form-horizontal'))?>
                            <div class="panel-body">
                                <h4 class="text-center">Información anterior</h4>
                                <label for="login-email">Correo electrónico</label>
                                <div class="input-group">
                                    <span class="input-group-addon"><i class="glyphicon glyphicon-envelope"></i></span>
                                    <input type="email" placeholder="Correo electrónico" class="form-control" id="email" name="email" value="" required/>  
                                </div>
                                <label for="login-email">Contraseña anterior</label>
                                <div class="input-group">
                                    <span class="input-group-addon"><i class="glyphicon glyphicon-lock"></i></span>
                                    <input type="password" placeholder="Contraseña anterior" class="form-control" id="old_password" name="old_password" value="" required/>
                                </div>
                                <h4 class="text-center">Información nueva</h4>
                                <label for="login-email">Contraseña nueva</label>
                                <div class="input-group">
                                    <span class="input-group-addon"><i class="glyphicon glyphicon-lock"></i></span>
                                    <input type="password" placeholder="Contraseña nueva" class="form-control" id="password" name="password" value="" required/>
                                </div>
                                <label for="login-email">Repetir contraseña</label>
                                <div class="input-group">
                                    <span class="input-group-addon"><i class="glyphicon glyphicon-lock"></i></span>
                                    <input type="password" placeholder="Repetir contraseña" class="form-control" id="repassword" name="repassword" value="" required/>
                                </div>
                            </div>
                            <div class="panel-footer text-center">
                                <div class="login-btn">
                                    <button type="submit" class="btn btn-success btn-block m-b-10"><i class="fa fa-check"></i> Cambiar contraseña</button>
                                </div>
                            </div>
                        <?php echo form_close()?>
                    </div>
                </div>
            </div>
        </div>
    </section> <!-- /.content -->
</div> <!-- /.content-wrapper -->
<!-- Change Password Page End -->