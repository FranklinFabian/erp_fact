<form action="<?php echo site_url('adquisiciones/Clecturacion/update_datatable');?>" id="form" method="post">
    <input type="hidden" name="type" value="<?php echo $type; ?>">

    <?php if ($type == "new"){?>
        <input type="hidden" name="item[id_abonado]" value="<?php if ($type == "new"){ echo $idP; } ?>">
    <?php    }    ?>

    <?php if ($type == "update"){?>
        <input type="hidden" name="id" value="<?php echo $item['id']; ?>">
    <?php    }    ?>
    <div class="row">
        <div class="col-sm-12">
            <div class="panel panel-bd lobidrag">
                <div class="panel-heading">
                    <div class="panel-title">
                        <div class="row">
                            <div class="col-lg-9">
                                <h4>
                                    <?php if ($type == "update"){?>
                                        Editar
                                    <?php }else{ ?>
                                        Nuevo
                                    <?php } ?>
                                    Registro
                                </h4>
                            </div>
                            <div class="col-lg-3">
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">
                            &times
                        </span>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="modal-body">

                    <div class="row">
                        <div class="col-lg-6">
                            <div class="form-group">
                                <label for="message-text" class="form-control-label">
                                    Lectura Anterior:
                                </label><br>
                                <input type="text" id="lectura_anterior" name="item[lectura_anterior]" class="form-control" placeholder="Ingrese la lectura anterior" value="<?php if ( $type == 'update') { echo $item['lectura_anterior']; }?>">
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="form-group">
                                <label for="message-text" class="form-control-label">
                                    Potencia:
                                </label><br>
                                <input type="text" id="potencia" name="item[potencia]" class="form-control" placeholder="Ingrese la potencia" value="<?php if ( $type == 'update') { echo $item['potencia']; }?>">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-6">
                            <div class="form-group">
                                <label for="message-text" class="form-control-label">
                                    Lectura Actual:
                                </label><br>
                                <input type="text" id="lectura_actual" name="item[lectura_actual]" class="form-control" placeholder="Ingrese la lectura actual" value="<?php if ( $type == 'update') { echo $item['lectura_actual']; }?>">
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="form-group">
                                <label for="message-text" class="form-control-label">
                                    Multiplicador:
                                </label><br>
                                <input type="text" id="multiplicador" name="item[multiplicador]" class="form-control" placeholder="Ingrese el multiplicador" value="<?php if ( $type == 'update') { echo $item['multiplicador']; }?>">
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-lg-6">
                            <div class="form-group">
                                <label for="message-text" class="form-control-label">
                                    Consumo:
                                </label><br>
                                <input type="text" id="consumo" name="item[consumo]" class="form-control" placeholder="Ingrese el consumo" value="<?php if ( $type == 'update') { echo $item['consumo']; }?>">
                            </div>
                        </div>

                        <div class="col-lg-6 col-sm-6">
                            <div class="form-group">
                                <label for="message-text" class="form-control-label">
                                    Estimado:
                                </label><br>
                                <select id="estimado" name="item[estimado]" class="form-control select2_general" style="width: 100%; display: block;z-index: 9999;margin-top: 100px;" required>
                                    <option></option>
                                    <?php foreach ($estados_estimados as $estado) {
                                        if ($estado['id'] == $item['estimado']){ ?>
                                            <option value="<?php echo $estado['id'] ?>" selected>  <?php echo $estado['nombre']; ?> </option>
                                        <?php } else { ?>
                                            <option value="<?php echo $estado['id'] ?>">  <?php echo $estado['nombre']; ?> </option>
                                        <?php } ?>
                                    <?php } ?>
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-lg-6 col-sm-6">
                            <div class="form-group">
                                <label for="message-text" class="form-control-label">
                                    Factura:
                                </label><br>
                                <select id="sin_factura" name="item[sin_factura]" class="form-control select2_general" style="width: 100%; display: block;z-index: 9999;margin-top: 100px;" required>
                                    <option></option>
                                    <?php foreach ($estados_facturas as $estado) {
                                        if ($estado['id'] == $item['sin_factura']){ ?>
                                            <option value="<?php echo $estado['id'] ?>" selected>  <?php echo $estado['nombre']; ?> </option>
                                        <?php } else { ?>
                                            <option value="<?php echo $estado['id'] ?>">  <?php echo $estado['nombre']; ?> </option>
                                        <?php } ?>
                                    <?php } ?>
                                </select>
                            </div>
                        </div>

                        <div class="col-lg-6 col-sm-6">
                            <div class="form-group">
                                <label for="message-text" class="form-control-label">
                                    Observada:
                                </label><br>
                                <select id="observada" name="item[observada]" class="form-control select2_general" style="width: 100%; display: block;z-index: 9999;margin-top: 100px;" required>
                                    <option></option>
                                    <?php foreach ($estados_observadas as $estado) {
                                        if ($estado['id'] == $item['observada']){ ?>
                                            <option value="<?php echo $estado['id'] ?>" selected>  <?php echo $estado['nombre']; ?> </option>
                                        <?php } else { ?>
                                            <option value="<?php echo $estado['id'] ?>">  <?php echo $estado['nombre']; ?> </option>
                                        <?php } ?>
                                    <?php } ?>
                                </select>
                            </div>
                        </div>
                    </div>


                    <div class="row">
                        <div class="col-lg-6">
                            <div class="form-group">
                                <label for="message-text" class="form-control-label">
                                    Observación:
                                </label><br>
                                <input type="text" id="observacion" name="item[observacion]" class="form-control" placeholder="Ingrese la observacion" value="<?php if ( $type == 'update') { echo $item['observacion']; }?>">
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="form-group">
                                <label for="message-text" class="form-control-label">
                                    Nota:
                                </label><br>
                                <input type="text" id="nota" name="item[nota]" class="form-control" placeholder="Ingrese la nota" value="<?php if ( $type == 'update') { echo $item['nota']; }?>">
                            </div>
                        </div>
                    </div>



                    <br>

                    <div class="form-group row">
                        <div class="col-sm-12" align="right">
                            <input type="submit" id="add" class="btn btn-primary btn-large" name="add" value="<?php echo display('save_changes') ?>" />
                        </div>
                    </div>

                </div>


            </div>
        </div>
    </div>

</form>

<script>
    $(function() {
        $('.select2_general').select2({
            placeholder: "Seleccione una opción",
            dropdownParent: $('#form_modal')
        });

    });

    $("#form").submit(function(event){
        event.preventDefault(); //prevent default action
        var post_url = $(this).attr("action"); //get form action url
        var request_method = $(this).attr("method"); //get form GET/POST method
        var form_data = $(this).serialize(); //Encode form elements for submission

        $.ajax({
            url : post_url,
            type: request_method,
            dataType: 'json',
            data : form_data,
        }).done(function(response){
            if  (response == 1){
                swal.fire({
                    icon: 'success',
                    title: 'Su trabajo ha sido guardado',
                    showConfirmButton: false,
                    timer: 2000
                }).then(function(result) {
                    $('#form_modal').trigger("reset");
                    $('#form_modal').modal('hide');
                    table.draw();
                });
            };
        });

    });


   /* $("#id_grupo").on('change', function () {
        $("#id_articulo").prop("disabled", false);
        articulo($(this).val());
    });

    function articulo (id){
        $("#id_grupo option:selected").each(function () {
            $.get( base_url + '/Cma_articulo/lista/?id=' + id, function (data) {
                $("#id_articulo").empty();
                $("#id_articulo").append("<option></option>");
                $.each(jQuery.parseJSON(data), function () {
                    $("#id_articulo").append($("<option></option>").val(this['id']).html(this['nombre']));
                });
            });
        });
    }*/

    $('.select2_general').select2({
        placeholder: "Seleccione una opción",
        dropdownParent: $('#form_modal')
    });

    $('#potencia').mask("#.##0,00", {reverse: true});

</script>
