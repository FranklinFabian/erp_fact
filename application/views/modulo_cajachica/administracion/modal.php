<form action="<?php echo site_url('Cmcajachica_administracion/update');?>" id="form" method="post">
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
                                    Cuenta:
                                </label><br>
                                <select id="id_cuenta" name="item[id_cuenta]" class="form-control select2_general" style="width: 100%; display: block;z-index: 9999;margin-top: 100px;" required>
                                    <option></option>
                                    <?php foreach ($cuentas as $cuenta) {
                                        if ($cuenta['id'] == $item['id_cuenta']){ ?>
                                            <option value="<?php echo $cuenta['id'] ?>" selected>  <?php echo $cuenta['codigo'] . " - " . $cuenta['nombre']; ?> </option>
                                        <?php } else { ?>
                                            <option value="<?php echo $cuenta['id'] ?>">  <?php echo $cuenta['codigo'] . " - " . $cuenta['nombre'] ?> </option>
                                        <?php } ?>
                                    <?php } ?>
                                </select>
                            </div>
                        </div>
                        <div class="col-lg-6 col-sm-6">
                            <div class="form-group">
                                <label for="message-text" class="form-control-label">
                                    Solicitante:
                                </label><br>
                                <select id="id_solicitante" name="item[id_solicitante]" class="form-control select2_general" style="width: 100%" required>
                                    <option></option>
                                    <?php foreach ($solicitantes as $solicitante) {
                                        if ($solicitante['id'] == $item['id_solicitante']){ ?>
                                            <option value="<?php echo $solicitante['id'] ?>" selected>  <?php echo $solicitante['nombre']; ?> </option>
                                        <?php } else { ?>
                                            <option value="<?php echo $solicitante['id'] ?>">  <?php echo $solicitante['nombre'] ?> </option>
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
                                    Monto:
                                </label><br>
                                <input type="text" id="monto" name="item[monto]" class="form-control" placeholder="Ingrese el monto" value="<?php if ( $type == 'update') { echo $item['monto']; }?>">
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-lg-12 col-sm-12">
                            <div class="form-group">
                                <label for="message-text" class="form-control-label">
                                    Descripción:
                                </label><br>
                                <textarea class="form-control" tabindex="10" id="descripcion" name="item[descripcion]" placeholder="Descripción" rows="1" autocomplete="off"><?php if ( $type == 'update') { echo $item['descripcion']; }?></textarea>
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

    /*Funciones de Validación*/
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

    


    $('#monto').mask("#.##0,00", {reverse: true});

</script>
