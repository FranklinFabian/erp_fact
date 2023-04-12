<form action="<?php echo site_url('Cmactivos_administracion/update');?>" id="form" method="post">
    <input type="hidden" name="type" value="<?php echo $type; ?>">

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
                        <div class="col-lg-6 col-sm-6">
                            <div class="form-group">
                                <label for="message-text" class="form-control-label">
                                    Servicio:
                                </label><br>
                                <select id="id_servicio" class="form-control select2_general" style="width: 100%; display: block;z-index: 9999;margin-top: 100px;" required>
                                    <option></option>
                                    <?php foreach ($servicios as $servicio) {
                                        if ($servicio['id'] == $item['id_servicio']){ ?>
                                            <option value="<?php echo $servicio['id'] ?>" selected>  <?php echo $servicio['nombre']; ?> </option>
                                        <?php } else { ?>
                                            <option value="<?php echo $servicio['id'] ?>">  <?php echo $servicio['nombre'] ?> </option>
                                        <?php } ?>
                                    <?php } ?>
                                </select>
                            </div>
                        </div>
                        <div class="col-lg-6 col-sm-6">
                            <div class="form-group">
                                <label for="message-text" class="form-control-label">
                                    Grupo:
                                </label><br>
                                <select id="id_grupo" class="form-control select2_general" style="width: 100%" <?php if ($type == "new"){?> disabled  <?php } ?>  required>
                                    <option></option>
                                    <?php foreach ($grupos as $grupo) {
                                        if ($grupo['id'] == $item['id_grupo']){ ?>
                                            <option value="<?php echo $grupo['id'] ?>" selected>  <?php echo $grupo['nombre']; ?> </option>
                                        <?php } else { ?>
                                            <option value="<?php echo $grupo['id'] ?>">  <?php echo $grupo['nombre'] ?> </option>
                                        <?php } ?>
                                    <?php } ?>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-12 col-sm-12">
                            <div class="form-group">
                                <label for="message-text" class="form-control-label">
                                    Cuenta:
                                </label><br>
                                <select id="id_cuenta" name="item[id_cuenta]" class="form-control select2_general" style="width: 100%" <?php if ($type == "new"){?> disabled  <?php } ?> required>
                                    <option></option>
                                    <?php foreach ($cuentas as $cuenta) {
                                        if ($cuenta['id'] == $item['id_cuenta']){ ?>
                                            <option value="<?php echo $cuenta['id'] ?>" selected>  <?php echo $cuenta['codigo'] . ' - ' . $cuenta['nombre']; ?> </option>
                                        <?php } else { ?>
                                            <option value="<?php echo $cuenta['id'] ?>">  <?php echo $cuenta['codigo'] . ' - ' . $cuenta['nombre'] ?> </option>
                                        <?php } ?>
                                    <?php } ?>
                                </select>
                            </div>
                        </div>
                    </div>

                    <hr>

                    <div class="row">
                        <div class="col-lg-6 col-sm-6">
                            <div class="form-group">
                                <label for="message-text" class="form-control-label">
                                    Lugar:
                                </label><br>
                                <select id="id_lugar" class="form-control select2_general" style="width: 100%">
                                    <option></option>
                                    <?php foreach ($lugares as $lugar) {
                                        if ($lugar['id'] == $item['id_lugar']){ ?>
                                            <option value="<?php echo $lugar['id'] ?>" selected>  <?php echo $lugar['nombre']; ?> </option>
                                        <?php } else { ?>
                                            <option value="<?php echo $lugar['id'] ?>">  <?php echo $lugar['nombre'] ?> </option>
                                        <?php } ?>
                                    <?php } ?>
                                </select>
                            </div>
                        </div>
                        <div class="col-lg-6 col-sm-6">
                            <div class="form-group">
                                <label for="message-text" class="form-control-label">
                                    Ubicación:
                                </label><br>
                                <select id="id_ubicacion" class="form-control select2_general" style="width: 100%" name="item[id_ubicacion]" <?php if ($type == "new"){?> disabled  <?php } ?> required>
                                    <option></option>
                                    <?php foreach ($ubicaciones as $ubicacion) {
                                        if ($ubicacion['id'] == $item['id_ubicacion']){ ?>
                                            <option value="<?php echo $ubicacion['id'] ?>" selected>  <?php echo $ubicacion['nombre']; ?> </option>
                                        <?php } else { ?>
                                            <option value="<?php echo $ubicacion['id'] ?>">  <?php echo $ubicacion['nombre'] ?> </option>
                                        <?php } ?>
                                    <?php } ?>
                                </select>
                            </div>
                        </div>
                    </div>

                    <hr>

                    <div class="row">
                        <div class="col-lg-6 col-sm-6">
                            <div class="form-group">
                                <label for="date" class="col-sm-4 col-form-label"> Fecha: </label>
                                <br>
                                <?php
                                if ($type == 'update'){
                                    $date=date_create($item['fecha_alta']);
                                    $fecha_alta = date_format($date,"d-m-Y");
                                }
                                ?>
                                <input class="form-control" type="text" size="50" name="item[fecha_alta]" id="fecha_alta" value="<?php if($type == 'update') { echo $fecha_alta; }else{ echo date("d-m-Y"); } ?>" required />

                            </div>
                        </div>
                        <div class="col-lg-6 col-sm-6">
                            <div class="form-group">
                                <label for="message-text" class="form-control-label">
                                    Articulo Almacen:
                                </label><br>
                                <select id="id_articulo_almacen" class="form-control select2_general" style="width: 100%" name="item[id_articulo_almacen]" <?php if ($type == "new"){?> disabled  <?php } ?> required>
                                    <option></option>
                                    <?php foreach ($almacen as $articulo) {
                                        if ($articulo['id'] == $item['id_articulo_almacen']){ ?>
                                            <option value="<?php echo $articulo['id'] ?>" selected>  <?php echo $articulo['nombre']; ?> </option>
                                        <?php } else { ?>
                                            <option value="<?php echo $articulo['id'] ?>">  <?php echo $articulo['nombre'] ?> </option>
                                        <?php } ?>
                                    <?php } ?>
                                </select>
                            </div>
                        </div>
                    </div>

                    <hr>

                    <div class="row">
                        <div class="col-lg-6 col-sm-6">
                            <div class="form-group">
                                <label for="message-text" class="form-control-label">
                                    Responsable:
                                </label><br>
                                <select id="id_responsable" class="form-control select2_general" style="width: 100%" name="item[id_responsable]">
                                    <option></option>
                                    <?php foreach ($responsables as $responsable) {
                                        if ($responsable['id'] == $item['id_responsable']){ ?>
                                            <option value="<?php echo $responsable['id'] ?>" selected>  <?php echo $responsable['nombre']; ?> </option>
                                        <?php } else { ?>
                                            <option value="<?php echo $responsable['id'] ?>">  <?php echo $responsable['nombre'] ?> </option>
                                        <?php } ?>
                                    <?php } ?>
                                </select>
                            </div>
                        </div>
                        <div class="col-lg-6 col-sm-6">
                            <div class="form-group">
                                <label for="message-text" class="form-control-label">
                                    Unidad:
                                </label><br>
                                <select id="id_unidad" class="form-control select2_general" style="width: 100%" name="item[id_unidad]">
                                    <option></option>
                                    <?php foreach ($unidades as $unidad) {
                                        if ($unidad['id'] == $item['id_unidad']){ ?>
                                            <option value="<?php echo $unidad['id'] ?>" selected>  <?php echo $unidad['nombre']; ?> </option>
                                        <?php } else { ?>
                                            <option value="<?php echo $unidad['id'] ?>">  <?php echo $unidad['nombre'] ?> </option>
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
                                    Cantidad:
                                </label><br>
                                <input type="text" id="cantidad" name="item[cantidad]" class="form-control" placeholder="Ingrese la cantidad de ingreso" value="<?php if ( $type == 'update') { echo $item['cantidad']; }?>">
                            </div>
                        </div>
                        <div class="col-lg-6 col-sm-6">
                            <div class="form-group">
                                <label for="message-text" class="form-control-label">
                                    Costo:
                                </label><br>
                                <input type="text" id="costo" name="item[costo]" class="form-control" placeholder="Ingrese el costo" value="<?php if ( $type == 'update') { echo $item['costo']; }?>">
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-lg-6 col-sm-6">
                            <div class="form-group">
                                <label for="message-text" class="form-control-label">
                                    Descripción:
                                </label><br>
                                <textarea class="form-control" tabindex="10" id="descripcion" name="item[descripcion]" placeholder="Descripción" rows="1" autocomplete="off"><?php if ( $type == 'update') { echo $item['descripcion']; }?></textarea>
                            </div>
                        </div>
                        <div class="col-lg-6 col-sm-6">
                            <div class="form-group">
                                <label for="message-text" class="form-control-label">
                                    Estado
                                </label><br>
                                <select name="item[estado]" id="estado" class="form-control select2_general" style="width:100%" required>
                                    <option value="Activo" <?php if($type == 'update' && $item['estado'] == 'Activo') { ?> selected="selected" <?php } ?> >Activo</option>
                                    <option value="Retirado" <?php if($type == 'update' && $item['estado'] == 'Retirado') { ?> selected="selected" <?php } ?> >Retirado</option>
                                </select>
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

        $("#fecha_alta").datepicker({ dateFormat:'dd-mm-yy' });

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

    /*Combobox Dependiente 2 Niveles*/
    $("#id_servicio").on('change', function () {
        $("#id_grupo").prop("disabled", false);
        grupo($(this).val());
    });

    function grupo (id){
        $("#id_servicio option:selected").each(function () {
            $.get( base_url + '/Cmactivos_grupo/lista/?id=' + id, function (data) {
                $("#id_grupo").empty();
                $("#id_cuenta").empty();
                $("#id_cuenta").prop("disabled", true);
                $("#id_grupo").append("<option></option>");
                if (data){
                    $.each(jQuery.parseJSON(data), function () {
                        $("#id_grupo").append($("<option></option>").val(this['id']).html(this['nombre']));
                    });
                }
            });
        });
    }


    $("#id_grupo").on('change', function () {
        $("#id_cuenta").prop("disabled", false);
        cuenta($(this).val());
    });

    function cuenta (id){
        $("#id_grupo option:selected").each(function () {
            $.get( base_url + '/Cmactivos_cuenta/lista/?id=' + id, function (data) {
                $("#id_cuenta").empty();
                $("#id_cuenta").append("<option></option>");
                if (data){
                    $.each(jQuery.parseJSON(data), function () {
                        $("#id_cuenta").append($("<option></option>").val(this['id']).html(this['codigo'] + ' - ' + this['nombre']));
                    });
                }
            });
        });
    }

    /*Fin Combobox Dependiente 2 Niveles*/

    $("#id_lugar").on('change', function () {
        $("#id_ubicacion").prop("disabled", false);
        ubicacion($(this).val());
    });

    function ubicacion (id){
        $("#id_lugar option:selected").each(function () {
            $.get( base_url + '/Cmactivos_ubicacion/lista/?id=' + id, function (data) {
                $("#id_ubicacion").empty();
                $("#id_ubicacion").append("<option></option>");
                if (data){
                    $.each(jQuery.parseJSON(data), function () {
                        $("#id_ubicacion").append($("<option></option>").val(this['id']).html(this['nombre']));
                    });
                }
            });
        });
    }

    $("#fecha_alta").on('change', function () {
        $("#id_articulo_almacen").prop("disabled", false);
        articulo_almacen($(this).val());
    });

    function articulo_almacen (fecha){
        $("#id_lugar option:selected").each(function () {
            $.get( base_url + '/Cmactivos_administracion/lista_articulo_almacen/?fecha=' + fecha, function (data) {
                $("#id_articulo_almacen").empty();
                $("#id_articulo_almacen").append("<option></option>");
                if (data){
                    $.each(jQuery.parseJSON(data), function () {
                        $("#id_articulo_almacen").append($("<option></option>").val(this['id']).html(this['nombre']));
                    });
                }
            });
        });
    }


    $('#costo').mask("#.##0,00", {reverse: true});

</script>
