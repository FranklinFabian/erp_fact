<form action="<?php echo site_url('adquisiciones/Corden/update');?>" id="form" method="post">
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
                                    Cliente:
                                </label><br>
                                <select id="id_cliente" class="form-control select2_general" style="width: 100%; display: block;z-index: 9999;margin-top: 100px;" required>
                                    <option></option>
                                    <?php foreach ($clientes as $cliente) {
                                        if ($cliente['id'] == $item['id_cliente']){ ?>
                                            <option value="<?php echo $cliente['id'] ?>" selected>  <?php echo $cliente['cid'] . ' - '  . $cliente['razon_social']; ?> </option>
                                        <?php } else { ?>
                                            <option value="<?php echo $cliente['id'] ?>"> <?php echo $cliente['cid'] . ' - '  . $cliente['razon_social']; ?> </option>
                                        <?php } ?>
                                    <?php } ?>
                                </select>
                            </div>
                        </div>
                        <div class="col-lg-6 col-sm-6">
                            <div class="form-group">
                                <label for="message-text" class="form-control-label">
                                    Abonado:
                                </label><br>
                                <select id="id_abonado" name="item[id_abonado]" class="form-control select2_general" style="width: 100%; display: block;z-index: 9999;margin-top: 100px;" <?php if ($type == "new"){?> disabled  <?php } ?> required>
                                    <option></option>
                                    <?php foreach ($abonados as $abonado) {
                                        if ($abonado['id'] == $item['id_abonado']){ ?>
                                            <option value="<?php echo $abonado['id'] ?>" selected>  <?php echo $abonado['id']; ?> </option>
                                        <?php } else { ?>
                                            <option value="<?php echo $abonado['id'] ?>">  <?php echo $abonado['id']; ?> </option>
                                        <?php } ?>
                                    <?php } ?>
                                </select>
                            </div>
                        </div>

                    </div>

                    <div class="row">

                        <div class="col-lg-3 col-sm-3">
                            <div class="form-group">
                                <label for="message-text" class="form-control-label">
                                    Servicios:
                                </label><br>
                                <select id="id_servicio" name="item[id_servicio]" class="form-control select2_general" style="width: 100%; display: block;z-index: 9999;margin-top: 100px;" required>
                                    <option></option>
                                    <?php foreach ($servicios as $servicio) {
                                        if ($servicio['id'] == $item['id_servicio']){ ?>
                                            <option value="<?php echo $servicio['id'] ?>" selected>  <?php echo $servicio['nombre'] . ' - ' . $servicio['costo'] . ' Bs.'; ?> </option>
                                        <?php } else { ?>
                                            <option value="<?php echo $servicio['id'] ?>">  <?php echo $servicio['nombre'] . ' - ' . $servicio['costo'] . ' Bs.'; ?> </option>
                                        <?php } ?>
                                    <?php } ?>
                                </select>
                            </div>
                        </div>

                        <div class="col-lg-3 col-sm-3">
                            <div class="form-group">
                                <label for="message-text" class="form-control-label">
                                    Estado:
                                </label><br>
                                <select id="id_estado_servicio" name="item[id_estado_servicio]" class="form-control select2_general" style="width: 100%; display: block;z-index: 9999;margin-top: 100px;" required>
                                    <option></option>
                                    <?php foreach ($estados_servicio as $estado_servicio) {
                                        if ($estado_servicio['id'] == $item['id_estado_servicio']){ ?>
                                            <option value="<?php echo $estado_servicio['id'] ?>" selected>  <?php echo $estado_servicio['nombre']; ?> </option>
                                        <?php } else { ?>
                                            <option value="<?php echo $estado_servicio['id'] ?>">  <?php echo $estado_servicio['nombre']; ?> </option>
                                        <?php } ?>
                                    <?php } ?>
                                </select>
                            </div>
                        </div>

                        <div class="col-lg-3 col-sm-3">
                            <div class="form-group">
                                <label for="message-text" class="form-control-label">
                                    Cobrado:
                                </label><br>
                                <select id="id_estado_cobro" name="item[id_estado_cobro]" class="form-control select2_general" style="width: 100%; display: block;z-index: 9999;margin-top: 100px;">
                                    <option></option>
                                    <?php foreach ($estados as $estado) {
                                        if ($estado['id'] == $item['id_estado_cobro']){ ?>
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
                        <div class="col-lg-12 col-sm-12">
                            <div class="form-group">
                                <label for="message-text" class="form-control-label">
                                    Nota:
                                </label><br>
                                <textarea class="form-control"  name="item[nota]" id="nota" cols="200" rows="10"><?php if ( $type == 'update') { echo $item['nota']; }?></textarea>

                            </div>
                        </div>
                    </div>





                    <div class="row">
                        <div class="col-lg-4 col-sm-4">
                            <div class="form-group">
                                <label for="message-text" class="form-control-label">
                                    Empleado:
                                </label><br>
                                <select id="id_empleado" name="item[id_empleado]" class="form-control select2_general" style="width: 100%; display: block;z-index: 9999;margin-top: 100px;">
                                    <option></option>
                                    <?php foreach ($empleados as $empleado) {
                                        if ($empleado['id'] == $item['id_empleado']){ ?>
                                            <option value="<?php echo $empleado['id'] ?>" selected>  <?php echo $empleado['first_name'] . ' ' . $empleado['last_name']; ?> </option>
                                        <?php } else { ?>
                                            <option value="<?php echo $empleado['id'] ?>">  <?php echo $empleado['first_name'] . ' ' . $empleado['last_name']; ?> </option>
                                        <?php } ?>
                                    <?php } ?>
                                </select>
                            </div>
                        </div>

                        <div class="col-lg-4 col-sm-4">
                            <div class="form-group">
                                <label for="message-text" class="form-control-label">
                                    Fecha de Inicio:
                                </label><br>
                                <input class="form-control" type="text" size="50" name="item[fecha_inicio]" id="fecha_inicio" placeholder="Ingrese la fecha de Inicio"  value="<?php if ( $type == 'update') { echo date("d-m-Y", strtotime($item['fecha_inicio'])); }?>" />
                            </div>
                        </div>
                        <div class="col-lg-4 col-sm-4">
                            <div class="form-group">
                                <label for="message-text" class="form-control-label">
                                    Fecha de Finalizacion:
                                </label><br>
                                <input class="form-control" type="text" size="50" name="item[fecha_fin]" id="fecha_fin" placeholder="Ingrese la fecha de Fin"  value="<?php if ( $type == 'update') { echo date("d-m-Y", strtotime($item['fecha_fin'])); }?>" />
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

        $(function(){
            $("#fecha_inicio").datepicker({ dateFormat:'dd-mm-yy' });
            $("#fecha_fin").datepicker({ dateFormat:'dd-mm-yy' });

        });

        $('.select2_general').select2({
            placeholder: "Seleccione una opción",
            dropdownParent: $('#form_modal')
        });


    });


    $("#id_cliente").on('change', function () {
        $("#id_abonado").prop("disabled", false);
        abonado($(this).val());
    });

    function abonado (id){
        $("#id_cliente option:selected").each(function () {
            $.get( base_url + '/adquisiciones/Cabonado/listaFiltrada/?id=' + id, function (data) {
                $("#id_abonado").empty();
                $("#id_abonado").append("<option></option>");
                $.each(jQuery.parseJSON(data), function () {
                    $("#id_abonado").append($("<option></option>").val(this['id']).html(this['id']));
                });
            });
        });
    }



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
            } else if (response == 0){
                swal.fire({
                    icon: 'warning',
                    title: 'No se detecto ningun cambio',
                    showConfirmButton: true
                });

            } else{
                swal.fire({
                    icon: 'error',
                    title: 'Error, contactesé con el administrador del sistema',
                    showConfirmButton: true
                });
            };
        });

    });



</script>
