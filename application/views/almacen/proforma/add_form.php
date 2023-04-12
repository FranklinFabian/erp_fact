
<script src="<?php echo base_url() ?>my-assets/js/admin_js/json/proforma.js" type="text/javascript"></script>
<!-- Add Product Start -->
<div class="content-wrapper">
    <section class="content-header">
        <div class="header-icon">
            <i class="pe-7s-note2"></i>
        </div>
        <div class="header-title">
            <h1>Nueva proforma</h1>
            <small>Añadir nueva proforma</small>
            <ol class="breadcrumb">
                <li><a href="index.html"><i class="pe-7s-home"></i>Hogar</a></li>
                <li><a href="#">Proforma</a></li>
                <li class="active">Nueva proforma</li>
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
                    <?php if($this->permission1->method('administrar_almacen_proforma','read')->access()){ ?>
                        <a href="<?php echo base_url('Cma_proforma/administrar') ?>" class="btn btn-primary m-b-5 m-r-2"><i class="ti-align-justify"> </i>Administrar proforma</a>
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
                            <h4>Nueva proforma</h4>
                        </div>
                    </div>
                    <?php echo form_open_multipart('Cma_proforma/insert', array('class' => 'form-vertical', 'id' => 'insert', 'name' => 'insert')) ?>
                    <div class="panel-body">

                        <div class="row">

                            <div class="col-sm-4">
                                <div class="form-group row">
                                    <label for="date" class="col-sm-4 col-form-label">Fecha<i class="text-danger">*</i></label>
                                    <div class="col-sm-8">
                                        <?php

                                        $fecha = date('d-m-Y');

                                        ?>
                                        <input class="form-control" type="text" size="50" name="fecha" id="fecha" required value="<?php echo $fecha; ?>" />
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-4">
                                <div class="form-group row">
                                    <select  name="id_cliente[]" class="form-control dont-select-me" required="" " >
                                    <option value=""> Seleccione un cliente</option>
                                    <?php if ($clientes) { ?>
                                        {clientes}
                                        <option value="{idcliente}"">{idcliente} - {razon_social}</option>
                                        {/clientes}
                                    <?php } ?>
                                    </select>
                                </div>
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
                                <tbody id="item">
                                    <tr class="">
                                        <td>
                                            <select  name="id_articulo[]" class="form-control dont-select-me" required="" onchange="precio(event)" >
                                                <option value=""> Seleccione un opción </option>
                                                <?php if ($articulos) { ?>
                                                    {articulos}
                                                    <option value="{id}" value2="{monto_venta}">{codigo} - {nombre}</option>
                                                    {/articulos}
                                                <?php } ?>
                                            </select>

                                        </td>

                                        <td class="">
                                            <input  type="text" class="form-control text-right" name="costo[]" placeholder="0.00"  required  min="0"  onblur="calcular(this)" />
                                        </td>

                                        <td class="">
                                            <input  type="text" class="form-control text-right" name="cantidad[]" required  min="0" onblur="calcular2(this)"/>
                                        </td>

                                        <td class="">
                                            <input  type="text" class="form-control text-right" name="total[]" required  min="0" />
                                        </td>

                                        <td> <button type="button" id="add_purchase_item" class="btn btn-info" name="add-invoice-item" onClick="additem('item');"  /><i class="fa fa-plus-square" aria-hidden="true"></i></button> <button class="btn btn-danger red" type="button" value="<?php echo display('delete') ?>" onclick="deleteRow(this)" ><i class="fa fa-trash" aria-hidden="true"></i></button>
                                        </td>
                                    </tr>
                                </tbody>

                            </table>
                            <script>
                                const selects = document.querySelectorAll(".dont-select-me");
                                for (const select of selects) {
                                    select.addEventListener("change", function (event) {
                                        if (event.target === select) {
                                            const container = select.closest(".row");
                                            const input = container.querySelector("input");
                                            console.log(input);
                                        }
                                    });
                                }
                            </script>
                        </div>


                        <br>
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
<!-- Add Product End -->

<script type="text/javascript">

    $(function(){
        $("#fecha").datepicker({ dateFormat:'dd-mm-yy' });

    });

    window.onload = function () {
        var text_input = document.getElementById('fecha');
        text_input.focus();
        text_input.select();
    }
</script>

