<!-- Edit Profile Page Start -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="header-icon"><i class="pe-7s-user"></i></div>
        <div class="header-title">
            <h1>Actualizar Perfil</h1>
            <small>Tú Perfil</small>
            <ol class="breadcrumb">
                <li><a href="#"><i class="pe-7s-home"></i><?php echo display('home') ?></a></li>
                <li><a href="#">Perfil</a></li>
                <li class="active"><?php echo 'Actualizar Perfil' ?></li>
            </ol>
        </div>
    </section>
    <!-- Main content -->
    <section class="content">
        <div class="row">
            <div class="col-sm-12 col-md-4">
            </div>
            <div class="col-sm-12 col-md-4">

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
            <?php echo form_open_multipart('Admin_dashboard/update_profile', array('id' => 'insert_product'))?>
                <div class="card">
                    <div class="card-header">
                        <div class="card-header-menu">
                            <i class="fa fa-bars"></i>
                        </div>
                        <div class="card-header-headshot" style="background-image: url({logo});"></div>
                    </div>
                    <div class="card-content">
                        <div class="card-content-member">
                            <h4 class="m-t-0">{first_name} {last_name}</h4>
                        </div>
                        <div class="card-content-languages">
                            <div class="card-content-languages-group">
                                <div>
                                    <h4><?php echo 'Nombres' ?>:</h4>
                                </div>
                                <div>
                                    <ul>
                                        <input type="text" placeholder="<?php echo display('first_name') ?>" class="form-control" id="first_name" name="first_name" value="{first_name}" required />
                                    </ul>
                                </div>
                            </div>
                            <div class="card-content-languages-group">
                                <div>
                                    <h4><?php echo 'Apellidos' ?>:</h4>
                                </div>
                                <div>
                                    <ul>
                                        <li><input type="text" placeholder="<?php echo display('last_name') ?>" class="form-control" id="last_name" name="last_name" value="{last_name}" required  /></li>
                                    </ul>
                                </div>
                            </div>
                            <div class="card-content-languages-group">
                                <div>
                                    <h4><?php echo display('email') ?>:</h4>
                                </div>
                                <div>
                                    <ul>
                                        <li><input type="email" placeholder="<?php echo display('email') ?>" class="form-control" id="user_name" name="user_name" value="{user_name}" required /></li>
                                    </ul>
                                </div>
                            </div>
                            <div class="card-content-languages-group">
                                <div>
                                    <h4><?php echo 'Imagen' ?>:</h4>
                                </div>
                                <div>
                                    <ul>
                                        <li><input type="file" id="logo" name="logo" value="{logo}" /></li>
                                        <input type="hidden" name="old_logo" value="{logo}" />
                                    </ul>
                                </div>
                            </div>
                            <hr>
                            <div class="text-center">
                                <button type="submit" class="btn btn-success btn-sm"><i class="fa fa-check"></i> Actualizar Perfil</button>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer">
                    </div>
                </div>
                <?php echo form_close()?>
            </div>
        </div>
    </section> <!-- /.content -->
</div> <!-- /.content-wrapper -->
<!-- Edit Profile Page End -->