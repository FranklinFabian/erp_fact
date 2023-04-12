<form action="<?php echo site_url('Cmactivos_cuenta/update');?>" id="form" method="post">
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
                                    Cuentas Contables:
                                </label><br>
                                <select id="id_cuenta" class="form-control select2_general" style="width: 100%" name="item[id_cuenta]">
                                    <option></option>
                                    <?php foreach ($cuentas as $cuenta) {
                                        if ($cuenta['id'] == $item['id_cuenta']){ ?>
                                            <option value="<?php echo $cuenta['id'] ?>" selected>  <?php echo $cuenta['codigo_formato'] . " - " .  $cuenta['nombre']; ?> </option>
                                        <?php } else { ?>
                                            <option value="<?php echo $cuenta['id'] ?>">  <?php echo $cuenta['codigo_formato'] . " - " . $cuenta['nombre'] ?> </option>
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
                                    Servicio:
                                </label><br>
                                <select id="id_servicio" class="form-control select2_general" style="width: 100%">
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
                                <select id="id_grupo" name="item[id_grupo]" class="form-control select2_general" style="width: 100%" <?php if ($type == "new"){?> disabled  <?php } ?>  >
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

                    <hr>

                    <div class="row">
                        <div class="col-lg-6 col-sm-6">
                            <div class="form-group">
                                <label for="message-text" class="form-control-label">
                                    Código:
                                </label><br>
                                <input type="text" id="codigo" name="item[codigo]" class="form-control" placeholder="Ingrese el código" value="<?php if ( $type == 'update') { echo $item['codigo']; }?>">
                            </div>
                        </div>
                        <div class="col-lg-6 col-sm-6">
                            <div class="form-group">
                                <label for="message-text" class="form-control-label">
                                    Nombre:
                                </label><br>
                                <input type="text" id="nombre" name="item[nombre]" class="form-control" placeholder="Ingrese el nombre" value="<?php if ( $type == 'update') { echo $item['nombre']; }?>">
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-lg-6 col-sm-6">
                            <div class="form-group">
                                <label for="message-text" class="form-control-label">
                                    Abreviatura:
                                </label><br>
                                <input type="text" id="abreviatura" name="item[abreviatura]" class="form-control" placeholder="Ingrese la abreviatura" value="<?php if ( $type == 'update') { echo $item['abreviatura']; }?>">
                            </div>
                        </div>
                        <div class="col-lg-6 col-sm-6">
                            <div class="form-group">
                                <label for="message-text" class="form-control-label">
                                    Correlativo:
                                </label><br>
                                <input type="text" id="correlativo" name="item[correlativo]" class="form-control" placeholder="Ingrese el correlativo" value="<?php if ( $type == 'update') { echo $item['correlativo']; }?>">
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-lg-6 col-sm-6">
                            <div class="form-group">
                                <label for="message-text" class="form-control-label">
                                    Coeficiente de Depreciación:
                                </label><br>
                                <input type="text" id="coeficiente_depreciacion" name="item[coeficiente_depreciacion]" class="form-control" placeholder="Ingrese el coeficiente de depreciación" value="<?php if ( $type == 'update') { echo $item['coeficiente_depreciacion']; }?>">
                            </div>
                        </div>
                        <div class="col-lg-6 col-sm-6">
                            <div class="form-group">
                                <label for="message-text" class="form-control-label">
                                    Vida Útil:
                                </label><br>
                                <input type="text" id="vida_util" name="item[vida_util]" class="form-control" placeholder="Ingrese la vida_util" value="<?php if ( $type == 'update') { echo $item['vida_util']; }?>">
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
                                    <option value="Inactivo" <?php if($type == 'update' && $item['estado'] == 'Inactivo') { ?> selected="selected" <?php } ?> >Inactivo</option>
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
                $("#id_grupo").append("<option></option>");
                if (data){
                    $.each(jQuery.parseJSON(data), function () {
                        $("#id_grupo").append($("<option></option>").val(this['id']).html(this['nombre']));
                    });
                }
            });
        });
    }


    $('#coeficiente_depreciacion').mask("#.##0,00", {reverse: true});
    $('#vida_util').mask("#.##0,00", {reverse: true});

</script>
