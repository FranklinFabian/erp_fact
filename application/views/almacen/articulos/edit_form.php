<!--Edit unit edit  start -->
<div class="content-wrapper">
    <section class="content-header">
        <div class="header-icon">
            <i class="pe-7s-note2"></i>
        </div>
        <div class="header-title">
            <h1>Editar articulo</h1>
            <small>Editar articulo</small>
            <ol class="breadcrumb">
                <li><a href="#"><i class="pe-7s-home"></i>Hogar</a></li>
                <li><a href="#">Articulo</a></li>
                <li class="active">Editar articulo</li>
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
                            <h4>Editar articulo</h4>
                        </div>
                    </div>
                    <?php echo form_open_multipart('Cma_articulo/update', array('class' => 'form-vertical', 'id' => 'update')) ?>
                    <div class="panel-body">
                        <div class="form-group row">
                            <label for="nombre" class="col-sm-3 col-form-label">Nombre<i class="text-danger">*</i></label>
                            <div class="col-sm-6">
                                <input class="form-control" name ="nombre" id="nombre" type="text" placeholder="Nombre"  required value="{nombre}">
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="id_unidad" class="col-sm-3 col-form-div">Unidad<i class="text-danger">*</i></label>
                            <div class="col-sm-6">
                                <?php echo form_dropdown('id_unidad', $unidades, $id_unidad,'class="form-control" style="width:100%"') ?>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="stock_minimo" class="col-sm-3 col-form-label">Stock mínimo</label>
                            <div class="col-sm-6">
                                <input class="form-control" name ="stock_minimo" id="stock_minimo" type="text" placeholder="Stock mínimo" value="{stock_minimo}">
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="monto_minimo" class="col-sm-3 col-form-label"> Monto minimo </label>
                            <div class="col-sm-6">
                                <input class="form-control" name ="monto_minimo" id="monto_minimo" type="text" placeholder="Monto minimo"  required="" value="{monto_minimo}">
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="monto_maximo" class="col-sm-3 col-form-label"> Monto maximo</label>
                            <div class="col-sm-6">
                                <input class="form-control" name ="monto_maximo" id="monto_maximo" type="text" placeholder="Monto maximo"  required="" value="{monto_maximo}">
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="monto_venta" class="col-sm-3 col-form-label"> Monto venta</label>
                            <div class="col-sm-6">
                                <input class="form-control" name ="monto_venta" id="monto_venta" type="text" placeholder="Monto venta"  required="" value="{monto_venta}">
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
                                <input type="submit" id="add" class="btn btn-success btn-large" name="add" value="<?php echo display('save_changes') ?>" />
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



