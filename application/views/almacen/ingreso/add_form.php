
<script src="<?php echo base_url() ?>my-assets/js/admin_js/json/almacen.js" type="text/javascript"></script>
<!-- Add Product Start -->
<div class="content-wrapper">
    <section class="content-header">
        <div class="header-icon">
            <i class="pe-7s-note2"></i>
        </div>
        <div class="header-title">
            <h1>Nuevo Ingreso</h1>
            <small>Añadir nuevo ingreso</small>
            <ol class="breadcrumb">
                <li><a href="index.html"><i class="pe-7s-home"></i>Hogar</a></li>
                <li><a href="#">Ingreso</a></li>
                <li class="active">Nuevo ingreso</li>
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
<?php if($this->permission1->method('administrar_almacen_ingreso','read')->access()){ ?>
                    <a href="<?php echo base_url('Cma_ingreso/administrar') ?>" class="btn btn-primary m-b-5 m-r-2"><i class="ti-align-justify"> </i>Administrar ingresos</a>
                     <?php }?>

                </div>
            </div>
        </div>

        <!-- Add Product -->
        <div class="row">
            <div class="col-sm-12">
                <div class="panel panel-bd lobidrag">
                    <div class="panel-heading">
                        <div class="panel-title">
                            <h4>Nuevo ingreso</h4>
                        </div>
                    </div>
                    <?php echo form_open_multipart('Cma_ingreso/insert', array('class' => 'form-vertical', 'id' => 'insert', 'name' => 'insert')) ?>
                    <div class="panel-body">
                        <div class="row">

                            <div class="col-lg-5">
                                <div class="row">

                                    <div class="col-sm-12">
                                        <div class="form-group row">
                                            <label for="date" class="col-sm-4 col-form-label">Fecha: <i class="text-danger">*</i></label>
                                            <div class="col-sm-8">
                                                <?php

                                                $fecha = date('d-m-Y');

                                                ?>
                                                <input class="form-control" type="text" size="50" name="fecha" id="fecha" required value="<?php echo $fecha; ?>" />
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-sm-12">
                                        <div class="form-group row">
                                            <label for="provider" class="col-sm-4 col-form-div"> Proveedor: <i class="text-danger">*</i> </label>
                                            <div class="col-sm-8">
                                                <select name="id_proveedor" class="form-control select2_general" style="width:100%" required>
                                                    <option value=""> Seleccionar una opción </option>
                                                    <?php if ($proveedores) { ?>
                                                        {proveedores}
                                                        <option value="{id}">{nombre} / {nit}</option>
                                                        {/proveedores}
                                                    <?php } ?>
                                                </select>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-sm-12">
                                        <div class="form-group row">
                                            <label for="provider" class="col-sm-4 col-form-div"> Orden de Compra: <i class="text-danger">*</i> </label>
                                            <div class="col-sm-8">
                                                <select name="id_orden" class="form-control select2_general" style="width:100%" required>
                                                    <option value=""> Seleccionar una opción </option>
                                                    <?php if ($ordenes_compra) { ?>
                                                        {ordenes_compra}
                                                        <option value="{id}">{codigo} / {fecha_formateada}</option>
                                                        {/ordenes_compra}
                                                    <?php } ?>
                                                </select>
                                            </div>
                                        </div>
                                    </div>

                                </div>
                            </div>

                            <div class="col-lg-7">
                                <div class="row">
                                    <div class="col-sm-12">
                                        <div class="form-group row">
                                            <label for="glosa" class="col-sm-4 col-form-label"> Glosa: </label>
                                            <div class="col-sm-8">
                                                <textarea class="form-control" name="glosa" id="glosa" rows="3" placeholder="Glosa"></textarea>
                                            </div>
                                        </div>
                                    </div>

                                </div>
                            </div>

                        </div>

                        <div class="form-group row">
                            <div class="col-sm-6">
                                <input type="submit" id="add-product" class="btn btn-primary btn-large" name="add" value="Guardar cambios" />
                            </div>
                        </div>
                    </div>
                    <?php echo form_close() ?>
                </div>
            </div>
        </div>
    </section>
</div>
<!-- Add Product End -->

<script type="text/javascript">

    $(function(){
        $("#fecha").datepicker({ dateFormat:'dd-mm-yy' });

        $('.select2_general').select2({
            placeholder: "Seleccione una opción"
        });
    });

    window.onload = function () {
        var text_input = document.getElementById('fecha');
        text_input.focus();
        text_input.select();
    }
</script>

