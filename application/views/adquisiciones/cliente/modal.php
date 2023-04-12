<form action="<?php echo site_url('adquisiciones/Ccliente/update');?>" id="form" method="post">
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
                                    Razón Social:
                                </label><br>
                                <input type="text" id="razon_social" name="item[razon_social]" class="form-control" placeholder="Ingrese la razon social" value="<?php if ( $type == 'update') { echo $item['razon_social']; }?>">
                            </div>
                        </div>

                        <div class="col-lg-6 col-sm-6">
                            <div class="form-group">
                                <label for="message-text" class="form-control-label">
                                    Tipo de documento:
                                </label><br>
                                <!-- <input type="text" id="nit" name="item[nit]" class="form-control" placeholder="Ingrese el NIT" value="<?php if ( $type == 'update') { echo $item['nit']; }?>">y -->
                                <select id="id_tipo_doc" name="item[id_tipo_doc]" class="form-control select2_general" style="width: 100%; display: block;z-index: 9999;margin-top: 100px;" required>
                                    <option></option>
                                    <?php foreach ($documentos as $documento) {
                                        if ($documento['id'] == $item['id_tipo_doc']){ ?>
                                            <option value="<?php echo $documento['id'] ?>" selected>  <?php echo $documento['nombre']; ?> </option>
                                        <?php } else { ?>
                                            <option value="<?php echo $documento['id'] ?>">  <?php echo $documento['nombre']; ?> </option>
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
                                    Número de documento:
                                </label><br>
                                <input type="text" id="numero_doc" name="item[numero_doc]" class="form-control" placeholder="Ingrese el número de documento" value="<?php if ( $type == 'update') { echo $item['numero_doc']; }?>">
                            </div>
                        </div>

                        <div class="col-lg-6 col-sm-6">
                            <div class="form-group">
                                <label for="message-text" class="form-control-label">
                                    Complemento:
                                </label><br>
                                <input type="text" id="complemento" name="item[complemento]" class="form-control" placeholder="Ingrese el complemento" value="<?php if ( $type == 'update') { echo $item['complemento']; }?>">
                            </div>
                        </div>
                    </div>

                    <div class="row">

                        <div class="col-lg-6 col-sm-6">
                            <div class="form-group">
                                <label for="message-text" class="form-control-label">
                                    Sexo:
                                </label><br>
                                <input type="text" id="sexo" name="item[sexo]" class="form-control" placeholder="Ingrese el sexo" value="<?php if ( $type == 'update') { echo $item['sexo']; }?>">
                            </div>
                        </div>

                        <div class="col-lg-6 col-sm-6">
                            <div class="form-group">
                                <label for="message-text" class="form-control-label">
                                    Ocupación:
                                </label><br>
                                <input type="text" id="ocupacion" name="item[ocupacion]" class="form-control" placeholder="Ingrese la ocupación" value="<?php if ( $type == 'update') { echo $item['ocupacion']; }?>">
                            </div>
                        </div>
                    </div>

                    <div class="row">

                        <div class="col-lg-12 col-sm-12">
                            <div class="form-group">
                                <label for="message-text" class="form-control-label">
                                    Dirección:
                                </label><br>
                                <input type="text" id="direccion" name="item[direccion]" class="form-control" placeholder="Ingrese el número la dirección" value="<?php if ( $type == 'update') { echo $item['direccion']; }?>">
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-lg-6 col-sm-6">
                            <div class="form-group">
                                <label for="message-text" class="form-control-label">
                                    Correo Electronico:
                                </label><br>
                                <input type="text" id="correo_electronico" name="item[correo_electronico]" class="form-control" placeholder="Ingrese un correo electronico" value="<?php if ( $type == 'update') { echo $item['correo_electronico']; }?>">
                            </div>
                        </div>
                        <div class="col-lg-2 col-sm-2">
                            <div class="form-group">
                                <label for="message-text" class="form-control-label">
                                    Cod. País:
                                </label><br>
                                 <input type="text" id="codigo_pais" name="item[codigo_pais]" class="form-control" placeholder="Ingrese el codigo de país" value="<?php if ( $type == 'update') { echo $item['codigo_pais']; }?>">
                            </div>
                        </div>
                        <div class="col-lg-4 col-sm-4">
                            <div class="form-group">
                                <label for="message-text" class="form-control-label">
                                    Número Celular:
                                </label><br>
                               <input type="text" id="celular" name="item[celular]" class="form-control" placeholder="Ingrese su número de celular" value="<?php if ( $type == 'update') { echo $item['celular']; }?>">
                            </div>
                        </div>
                    </div>


                    <div class="row">

                        <div class="col-lg-6 col-sm-6">
                            <div class="form-group">
                                <label for="message-text" class="form-control-label">
                                    Fecha de Nacimiento:
                                </label><br>

                                <input class="form-control" type="text" size="50" name="item[nacimiento]" id="nacimiento" placeholder="Ingrese la fecha de Nacimiento" required value="<?php if ( $type == 'update') { echo date("d-m-Y", strtotime($item['nacimiento'])); }?>" />


                            </div>
                        </div>

                        <div class="col-lg-6 col-sm-6">
                            <div class="form-group">
                                <label for="message-text" class="form-control-label">
                                    Teléfono:
                                </label><br>
                                <input type="text" id="telefono" name="item[telefono]" class="form-control" placeholder="Ingrese el Telefono" value="<?php if ( $type == 'update') { echo $item['telefono']; }?>">
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
            $("#nacimiento").datepicker({ dateFormat:'dd-mm-yy' });

            $('.select2_general').select2({
                placeholder: "Seleccione una opción",
                dropdownParent: $('#form_modal')
            });
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




    $(function(){
        $("#fecha").datepicker({ dateFormat:'dd-mm-yy' });

    });



</script>
