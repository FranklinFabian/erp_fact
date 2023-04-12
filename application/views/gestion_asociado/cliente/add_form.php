<!-- Add Product Start -->
<div class="content-wrapper">
    <section class="content-header">
        <div class="header-icon">
            <i class="pe-7s-note2"></i>
        </div>
        <div class="header-title">
            <h1>Nuevo cliente</h1>
            <small>Añadir nuevo cliente</small>
            <ol class="breadcrumb">
                <li><a href="index.html"><i class="pe-7s-home"></i>Hogar</a></li>
                <li><a href="#">Cliente</a></li>
                <li class="active">Nuevo cliente</li>
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

        <div class="row">
            <div class="col-sm-12">
                <div class="column">
<?php if($this->permission1->method('administrar_gestion_asociado_cliente','read')->access()){ ?>
                    <a href="<?php echo base_url('Cga_cliente/administrar') ?>" class="btn btn-primary m-b-5 m-r-2"><i class="ti-align-justify"> </i>Administrar clientes</a>
                     <?php }?>

                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-sm-12">
                <div class="panel panel-bd lobidrag">
                    <div class="panel-heading">
                        <div class="panel-title">
                            <h4>Nuevo cliente</h4>
                        </div>
                    </div>
                    <?php echo form_open_multipart('Cga_cliente/insert', array('class' => 'form-vertical', 'id' => 'insert', 'name' => 'insert')) ?>
                    <div class="panel-body">
                        <div class="row">
                            <div class="col-lg-6">
                                <div class="form-group row">
                                    <label for="ci" class="col-sm-4 col-form-label">CI:<i class="text-danger">*</i></label>
                                    <div class="col-sm-8">
                                        <input class="form-control" name ="ci" id="ci" type="text" placeholder="CI"  required>
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label for="expedido" class="col-sm-4 col-form-div">Expedido:<i class="text-danger">*</i> </label>
                                    <div class="col-sm-8">
                                        <select name="id_expedido" class="form-control select2_general" style="width:100%" required>
                                            <option></option>
                                            <?php if ($departamentos) { ?>
                                                {departamentos}
                                                <option value="{id}">{nombre}</option>
                                                {/departamentos}
                                            <?php } ?>
                                        </select>
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label for="razon_social" class="col-sm-4 col-form-label">Razon social:<i class="text-danger">*</i></label>
                                    <div class="col-sm-8">
                                        <input class="form-control" name ="razon_social" id="razon_social" type="text" placeholder="Razon social"  required>
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label for="fecha_nacimiento" class="col-sm-4 col-form-label">Fecha de nacimiento:<i class="text-danger">*</i></label>
                                    <div class="col-sm-8">
                                        <input class="form-control fecha" type="text" size="50" name="fecha_nacimiento" id="fecha_nacimiento" required/>
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label for="provider" class="col-sm-4 col-form-div">Genero:<i class="text-danger">*</i> </label>
                                    <div class="col-sm-8">
                                        <select name="genero" class="form-control select2_general" style="width:100%" required>
                                            <option></option>
                                            <option value="Femenino">Femenino</option>
                                            <option value="Masculino">Masculino</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label for="nit" class="col-sm-4 col-form-label">NIT:</label>
                                    <div class="col-sm-8">
                                        <input class="form-control" name ="nit" id="nit" type="text" placeholder="Nit">
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label for="direccion" class="col-sm-4 col-form-label">Dirección:</label>
                                    <div class="col-sm-8">
                                        <input class="form-control" name="direccion" id="direccion" type="text" placeholder="Dirección">
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label for="fotografia" class="col-sm-4 col-form-label">Fotografia:</label>
                                    <div class="col-sm-8">
                                        <input type="file" id="fotografia" name="fotografia" accept="image/jpeg" class="form-control"/>
                                        <small id="msg_foto_2" class="form-text text-success">Solo se admiten fotografias en formato jpg.</small>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="form-group row">
                                    <label for="telefono" class="col-sm-4 col-form-label">Telefono:</label>
                                    <div class="col-sm-8">
                                        <input class="form-control" name ="telefono" id="telefono" type="text" placeholder="Telefono">
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label for="profesion" class="col-sm-4 col-form-div"> Profesión:</label>
                                    <div class="col-sm-8">
                                        <select name="id_profesion" class="form-control select2_general" style="width:100%">
                                            <option></option>
                                            <?php if ($profesiones) { ?>
                                                {profesiones}
                                                <option value="{id}">{nombre}</option>
                                                {/profesiones}
                                            <?php } ?>
                                        </select>
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label for="ocupacion" class="col-sm-4 col-form-div"> Ocupación:</label>
                                    <div class="col-sm-8">
                                        <select name="id_ocupacion" class="form-control select2_general" style="width:100%">
                                            <option></option>
                                            <?php if ($ocupaciones) { ?>
                                                {ocupaciones}
                                                <option value="{id}">{nombre}</option>
                                                {/ocupaciones}
                                            <?php } ?>
                                        </select>
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label for="nivel_educacion" class="col-sm-4 col-form-div"> Nivel de educación:</label>
                                    <div class="col-sm-8">
                                        <select name="id_nivel_educacion" class="form-control select2_general" style="width:100%">
                                            <option></option>
                                            <?php if ($niveles_educacion) { ?>
                                                {niveles_educacion}
                                                <option value="{id}">{nombre}</option>
                                                {/niveles_educacion}
                                            <?php } ?>
                                        </select>
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label for="numero_dependientes" class="col-sm-4 col-form-label">N° Dependientes:</label>
                                    <div class="col-sm-8">
                                        <input class="form-control" name ="numero_dependientes" id="numero_dependientes" type="text" placeholder="N° Dependientes">
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label for="estado_civil" class="col-sm-4 col-form-div">Estado civil:<i class="text-danger">*</i> </label>
                                    <div class="col-sm-8">
                                        <select name="id_estado_civil" class="form-control select2_general" style="width:100%" required>
                                            <option></option>
                                            <?php if ($estados_civiles) { ?>
                                                {estados_civiles}
                                                <option value="{id}">{nombre}</option>
                                                {/estados_civiles}
                                            <?php } ?>
                                        </select>
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label for="fecha_registro" class="col-sm-4 col-form-label">Fecha de registro: <i class="text-danger">*</i></label>
                                    <div class="col-sm-8">
                                        <?php
                                        $fecha = date('d-m-Y');
                                        ?>
                                        <input class="form-control fecha" type="text" size="50" name="fecha_registro" id="fecha_registro" required value="<?php echo $fecha; ?>" />
                                    </div>
                                </div>

                            </div>
                        </div>

                        <div class="form-group row">
                            <div class="col-sm-6">
                                <input type="submit" id="add-product" class="btn btn-primary btn-large" name="add" value="Guardar" />
                            </div>
                        </div>
                    </div>
                    <?php echo form_close() ?>
                </div>
            </div>
        </div>
    </section>
</div>

<script type="text/javascript">

    $(function(){
        $(".fecha").datepicker({ dateFormat:'dd-mm-yy' });

        $('.select2_general').select2({
            placeholder: "Seleccione una opción",
            allowClear: true
        });
    });

    window.onload = function () {
        var text_input = document.getElementById('ci');
        text_input.focus();
        text_input.select();
    }
</script>

