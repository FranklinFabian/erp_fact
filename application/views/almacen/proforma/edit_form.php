<script src="<?php echo base_url() ?>my-assets/js/admin_js/json/proforma.js" type="text/javascript"></script>
<!-- Edit Product Start -->
<div class="content-wrapper">
    <section class="content-header">
        <div class="header-icon">
            <i class="pe-7s-note2"></i>
        </div>
        <div class="header-title">
            <h1>Editar Proforma</h1>
            <small>Edita tu proforma</small>
            <ol class="breadcrumb">
                <li><a href="index.html"><i class="pe-7s-home"></i> Hogar </a></li>
                <li><a href="#">Proforma</a></li>
                <li class="active">Editar proforma</li>
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
        <!-- Purchase report -->
        <div class="row">
            <div class="col-sm-12">
                <div class="panel panel-bd lobidrag">
                    <div class="panel-heading">
                        <div class="panel-title">
                            <h4>Editar proforma</h4>
                        </div>
                    </div>
                    <?php echo form_open_multipart('Cma_proforma/update', array('class' => 'form-vertical', 'id' => 'update', 'name' => 'update')) ?>
                    <div class="panel-body">
                        <div class="col-sm-4">
                            <input type="hidden" name="id" value="{id}">
                            <div class="col-sm-6">
                                <div class="form-group row">
                                    <label for="date" class="col-sm-4 col-form-label">Fecha<i class="text-danger">*</i></label>
                                    <div class="col-sm-8">
                                        <?php
                                        $date=date_create($fecha);
                                        $fecha = date_format($date,"d-m-Y");
                                        ?>
                                        <input class="form-control" type="text" size="50" name="fecha" id="fecha" value="<?php echo $fecha; ?>" required />
                                    </div>
                                </div>
                            </div>

                           <!-- <div class="col-sm-4">
                                <?php if ($cabecera_cotizacion){?>
                                <div class="form-group row">
                                    <select  name="id_cliente[]" class="form-control dont-select-me" required="" " >
                                    <option value=""> Seleccione un cliente</option>
                                    <?php foreach ($clientes as $cliente) {
                                        if ($cliente['id'] == $cabecera_cotizacion[0]['id_cliente']){ ?>
                                            <option value="<?php echo $cliente['id'] ?>" selected>  <?php echo $cliente['razon_social']; ?> </option>
                                        <?php } else { ?>
                                            <option value="<?php echo $cliente['id'] ?>">  <?php echo $cliente['razon_social'] ?> </option>
                                        <?php } ?>
                                    <?php } ?>
                                    </select>
                                </div>
                                <?php } else {?>
                                    <select  name="id_cliente[]" class="form-control dont-select-me" required="" " >
                                    <option value=""> Seleccione un cliente</option>
                                    <?php if ($clientes) { ?>
                                        {clientes}
                                        <option value="{id}"">{id} - {razon_social}</option>
                                        {/clientes}
                                    <?php } ?>
                                    </select>
                                <?php } ?>
                            </div>-->

                        </div>
                    </div>

                        <div class="table-responsive" style="margin-top: 10px">
                            <table class="table table-bordered table-hover"  id="table">
                                <thead>
                                    <tr>
                                        <!-- <th class="text-center">Proveedor a<i class="text-danger">*</i></th>-->
                                        <th class="text-center">Articulo<i class="text-danger">*</i></th>
                                        <th class="text-center">Precio unitario <i class="text-danger">*</i></th>
                                        <th class="text-center">Cantidad<i class="text-danger">*</i></th>
                                        <th class="text-center">Total<i class="text-danger">*</i></th>
                                        <th class="text-center">Acción<i class="text-danger"></i></th>
                                    </tr>
                                </thead>

                                <?php if ($cotizaciones){?>

                                <tbody id="item">

                                    <?php foreach ($cotizaciones as $cotizacion) {
                                        ?>
                                        <tr class="">

                                            <td>
                                                <select name="id_articulo[]" class="form-control dont-select-me" required="" ">
                                                    <?php foreach ($articulos as $articulo) {
                                                        if ($articulo['id'] == $cotizacion['id_articulo']){ ?>
                                                            <option value="<?php echo $articulo['id'] ?>"  selected>  <?php echo $articulo['nombre']; ?> </option>
                                                        <?php } else { ?>
                                                            <option value="<?php echo $articulo['id'] ?>">  <?php echo $articulo['nombre'] ?> </option>
                                                        <?php } ?>
                                                    <?php } ?>
                                                </select>
                                            </td>

                                            <td class="">
                                                <input type="text" class="form-control text-right" name="costo[]" placeholder="0.00"  required  min="0" value="  <?php echo $cotizacion['costo'] ?>" />
                                            </td>

                                            <td class="">
                                                <input type="text" class="form-control text-right" name="cantidad[]" required  min="0" value="  <?php echo $cotizacion['cantidad'] ?>" />
                                            </td>

                                            <td class="">
                                                <input type="text" class="form-control text-right" name="total[]" required  min="0" value="<?php echo $cotizacion['total'] ?>"/>
                                            </td>

                                            <td> <button type="button" id="add_purchase_item" class="btn btn-info" name="add-invoice-item" onClick="additem('item');" /><i class="fa fa-plus-square" aria-hidden="true"></i></button> <button class="btn btn-danger red" type="button" value="<?php echo display('delete') ?>" onclick="deleteRowEdit(this)"><i class="fa fa-trash" aria-hidden="true"></i></button>
                                            </td>
                                        </tr>

                                    <?php } ?>

                                </tbody>
                                <?php } else {?>
                                    <tbody id="item">
                                    <tr class="">
                                        <td>
                                            <select name="id_articulo[]" class="form-control dont-select-me" required="" onchange="precio(event)">
                                                <option value=""> Seleccione una opción </option>
                                                <?php if ($articulos) { ?>
                                                    {articulos}
                                                    <option value="{id}" value2="{monto_venta}">{codigo} - {nombre}</option>
                                                    {/articulos}
                                                <?php } ?>
                                            </select>
                                        </td>

                                        <td class="">
                                            <input type="text" class="form-control text-right" name="costo[]"  required  min="0" onblur="calcular(this)"/>
                                        </td>

                                        <td class="">
                                            <input type="text" class="form-control text-right" name="cantidad[]" placeholder="0.00"  required  min="0" onblur="calcular2(this)"/>
                                        </td>

                                        <td> <button type="button" id="add_purchase_item" class="btn btn-info" name="add-invoice-item" onClick="additem('item');"  /><i class="fa fa-plus-square" aria-hidden="true"></i></button> <button class="btn btn-danger red" type="button" value="<?php echo display('delete') ?>" onclick="deleteRow(this)" ><i class="fa fa-trash" aria-hidden="true"></i></button>
                                        </td>
                                    </tr>
                                    </tbody>
                                <?php } ?>

                            </table>
                        </div>


                        <br>
                        <div class="form-group row">
                            <div class="col-sm-6">
                                <input type="submit" id="add" class="btn btn-primary btn-large" name="add" value="Guardar cambios" />
                            </div>
                        </div>
                    </div>
                    <?php echo form_close() ?>
                </div>
            </div>
        </div>
    </section>
</div>
<!-- Edit Product End -->
<script type="text/javascript">

    $(function(){
        $("#fecha").datepicker({ dateFormat:'dd-mm-yy' });

    });

</script>


