<form action="<?php echo site_url('adquisiciones/Cposte/update');?>" id="form" method="post">
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
                        <div class="col-lg-12 col-sm-12">
                            <div class="form-group">
                                <label for="message-text" class="form-control-label">
                                    Centro de Transformación:
                                </label><br>
                                <select id="id_centro_transformacion" name="item[id_centro_transformacion]" class="form-control select2_general" style="width: 100%; display: block;z-index: 9999;margin-top: 100px;" required>
                                    <option></option>
                                    <?php foreach ($transformadores as $transformador) {
                                        if ($transformador['id'] == $item['id_centro_transformacion']){ ?>
                                            <option value="<?php echo $transformador['id'] ?>" selected>  <?php echo $transformador['nombre']; ?> </option>
                                        <?php } else { ?>
                                            <option value="<?php echo $transformador['id'] ?>">  <?php echo $transformador['nombre']; ?> </option>
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
                                    Descripción:
                                </label><br>
                                <input type="text" id="nombre" name="item[nombre]" class="form-control" placeholder="Ingrese la descripción" value="<?php if ( $type == 'update') { echo $item['nombre']; }?>">
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-lg-12 col-sm-12">
                            <div class="form-group">
                                <label for="message-text" class="form-control-label">
                                    Codigo Poste:
                                </label><br>
                                <input type="text" id="cod_poste" name="item[cod_poste]" class="form-control" placeholder="Ingrese el codigo de poste" value="<?php if ( $type == 'update') { echo $item['cod_poste']; }?>">
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
