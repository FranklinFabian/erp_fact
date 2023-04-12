<!-- Add Product Start -->
<div class="content-wrapper">
    <section class="content-header">
        <div class="header-icon">
            <i class="pe-7s-note2"></i>
        </div>
        <div class="header-title">
            <h1>Nueva orden de trabajo</h1>
            <small>Añadir nueva orden de trabajo</small>
            <ol class="breadcrumb">
                <li><a href="index.html"><i class="pe-7s-home"></i>Hogar</a></li>
                <li><a href="#">Orden de trabajo</a></li>
                <li class="active">Nueva orden de trabajo</li>
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
<?php if($this->permission1->method('administrar_almacen_orden_trabajo','read')->access()){ ?>
                    <a href="<?php echo base_url('Cma_orden_trabajo/administrar') ?>" class="btn btn-primary m-b-5 m-r-2"><i class="ti-align-justify"> </i>  Administrar las ordenes de trabajo </a>
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
                            <h4>Nueva orden de trabajo</h4>
                        </div>
                    </div>
                    <?php echo form_open_multipart('Cma_orden_trabajo/insert', array('class' => 'form-vertical', 'id' => 'insert', 'name' => 'insert')) ?>
                    <div class="panel-body">
                        <div class="row">

                            <div class="col-lg-4">
                                <div class="row">

                                    <div class="col-sm-12">
                                        <div class="form-group row">
                                            <label for="date" class="col-sm-4 col-form-label"><?php echo display('date') ?> : <i class="text-danger">*</i></label>
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
                                                    <option value=""> Seleccione una opciónn </option>
                                                    <?php if ($proveedores) { ?>
                                                        {proveedores}
                                                        <option value="{id}">{nombre}</option>
                                                        {/proveedores}
                                                    <?php } ?>
                                                </select>
                                            </div>
                                        </div>
                                    </div>

                                </div>
                            </div>

                            <div class="col-lg-8">
                                <div class="row">
                                    <div class="col-sm-12">
                                        <div class="form-group row">
                                            <label for="glosa" class="col-sm-4 col-form-label"> Observación: </label>
                                            <div class="col-sm-8">
                                                <textarea class="form-control" name="observacion" id="observacion" rows="3" placeholder="Observación"></textarea>
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

