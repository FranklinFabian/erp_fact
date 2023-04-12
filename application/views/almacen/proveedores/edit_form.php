<!--Edit unit edit  start -->
<div class="content-wrapper">
    <section class="content-header">
        <div class="header-icon">
            <i class="pe-7s-note2"></i>
        </div>
        <div class="header-title">
            <h1>Editar proveedor</h1>
            <small>Editar proveedor</small>
            <ol class="breadcrumb">
                <li><a href="#"><i class="pe-7s-home"></i>Hogar</a></li>
                <li><a href="#">Proveedor</a></li>
                <li class="active">Editar proveedor</li>
            </ol>
        </div>
    </section>

    <section class="content">

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

        <!-- New customer -->
        <div class="row">
            <div class="col-sm-12">
                <div class="panel panel-bd lobidrag">
                    <div class="panel-heading">
                        <div class="panel-title">
                            <h4>Editar proveedor</h4>
                        </div>
                    </div>
                    <?php echo form_open_multipart('Cma_proveedor/update', array('class' => 'form-vertical', 'id' => 'update')) ?>
                    <div class="panel-body">

                        <div class="form-group row">
                            <label for="nombre" class="col-sm-3 col-form-label">Nombre<i class="text-danger">*</i></label>
                            <div class="col-sm-6">
                                <input class="form-control" name ="nombre" id="nombre" type="text" placeholder="Nombre"  required="" value="{nombre}">
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="direccion" class="col-sm-3 col-form-label">Dirección</label>
                            <div class="col-sm-6">
                                <input class="form-control" name ="direccion" id="direccion" type="text" placeholder="Dirección" value="{direccion}">
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="telefono" class="col-sm-3 col-form-label">Telefono</label>
                            <div class="col-sm-6">
                                <input class="form-control" name ="telefono" id="telefono" type="text" placeholder="Telefono" value="{telefono}">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="correo" class="col-sm-3 col-form-label">Correo</label>
                            <div class="col-sm-6">
                                <input class="form-control" name ="correo" id="correo" type="text" placeholder="Correo" value="{correo}">
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="designation" class="col-sm-3 col-form-div"> Ciudad <i class="text-danger">*</i></label>
                            <div class="col-sm-6">
                                <?php echo form_dropdown('id_ciudad', $departamentos, $id_ciudad,'class="form-control" style="width:100%"') ?>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="nit" class="col-sm-3 col-form-label"> Nit </label>
                            <div class="col-sm-6">
                                <input class="form-control" name ="nit" id="nit" type="text" placeholder="Nit" value="{nit}">
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="banco" class="col-sm-3 col-form-label"> Banco </label>
                            <div class="col-sm-6">
                                <input class="form-control" name ="banco" id="banco" type="text" placeholder="Banco" value="{banco}">
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="cuenta" class="col-sm-3 col-form-label"> Cuenta </label>
                            <div class="col-sm-6">
                                <input class="form-control" name ="cuenta" id="cuenta" type="text" placeholder="Cuenta" value="{cuenta}">
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="descripcion" class="col-sm-3 col-form-label">Descripción</label>
                            <div class="col-sm-6">
                                <textarea class="form-control" tabindex="4" id="descripcion" name="descripcion" placeholder="Descripción" rows="1" autocomplete="off">{descripcion}</textarea>
                            </div>
                        </div>

                        <input type="hidden" value="{id}" name="id">

                        <div class="form-group row">
                            <label for="example-text-input" class="col-sm-4 col-form-label"></label>
                            <div class="col-sm-6">
                                <input type="submit" id="edit" class="btn btn-success btn-large" name="edit" value="Guardar cambios" />
                            </div>
                        </div>

                    </div>
                    <?php echo form_close() ?>
                </div>
            </div>
        </div>

    </section>
</div>
<!-- Edit unit edit end -->



