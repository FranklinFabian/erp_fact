<!--Edit unit edit  start -->
<div class="content-wrapper">
    <section class="content-header">
        <div class="header-icon">
            <i class="pe-7s-note2"></i>
        </div>
        <div class="header-title">
            <h1>Editar ubicación</h1>
            <small>Editar ubicación</small>
            <ol class="breadcrumb">
                <li><a href="#"><i class="pe-7s-home"></i>Hogar</a></li>
                <li><a href="#">Ubicaciones</a></li>
                <li class="active">Editar ubicaciones</li>
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
                            <h4>Editar ubicación</h4>
                        </div>
                    </div>
                    <?php echo form_open_multipart('Cmactivos_ubicacion/update', array('class' => 'form-vertical', 'id' => 'update')) ?>
                    <div class="panel-body">

                        <div class="form-group row">
                            <label for="id_lugar" class="col-sm-3 col-form-div"> Lugar <i class="text-danger">*</i></label>
                            <div class="col-sm-6">
                                <?php echo form_dropdown('id_lugar', $lugares, $id_lugar,'class="form-control" style="width:100%"') ?>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="nombre" class="col-sm-3 col-form-label">Nombre<i class="text-danger">*</i></label>
                            <div class="col-sm-6">
                                <input class="form-control" name ="nombre" id="nombre" type="text" placeholder="Nombre"  required="" value="{nombre}">
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="estado" class="col-sm-3 col-form-div">Estado<i class="text-danger">*</i></label>
                            <div class="col-sm-6">
                                <select name="estado" id="estado" class="form-control" style="width:100%" required>
                                    <option value="Activo" <?php if($estado == 'Activo') { ?> selected="selected" <?php } ?> >Activo</option>
                                    <option value="Inactivo" <?php if($estado == 'Inactivo') { ?> selected="selected" <?php } ?> >Inactivo</option>
                                </select>
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
                            <div class="col-sm-9" align="right">
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



