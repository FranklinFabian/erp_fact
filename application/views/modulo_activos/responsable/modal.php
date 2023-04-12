<form action="<?php echo site_url('Cmactivos_responsable/update');?>" id="form" method="post">
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
                                    Tipo de Responsable:
                                </label><br>
                                <select id="id_tipo_responsable" name="item[id_tipo_responsable]" class="form-control select2_general" style="width: 100%">
                                    <option></option>
                                    <?php foreach ($tipo_responsables as $tipo_responsable) {
                                        if ($tipo_responsable['id'] == $item['id_tipo_responsable']){ ?>
                                            <option value="<?php echo $tipo_responsable['id'] ?>" selected>  <?php echo $tipo_responsable['nombre']; ?> </option>
                                        <?php } else { ?>
                                            <option value="<?php echo $tipo_responsable['id'] ?>">  <?php echo $tipo_responsable['nombre'] ?> </option>
                                        <?php } ?>
                                    <?php } ?>
                                </select>
                            </div>
                        </div>
                        <div class="col-lg-6 col-sm-6">
                            <div class="form-group">
                                <label for="message-text" class="form-control-label">
                                    Empresa:
                                </label><br>
                                <select id="id_empresa" name="item[id_empresa]" class="form-control select2_general" style="width: 100%"  >
                                    <option></option>
                                    <?php foreach ($empresas as $empresa) {
                                        if ($empresa['id'] == $item['id_empresa']){ ?>
                                            <option value="<?php echo $empresa['id'] ?>" selected>  <?php echo $empresa['nombre']; ?> </option>
                                        <?php } else { ?>
                                            <option value="<?php echo $empresa['id'] ?>">  <?php echo $empresa['nombre'] ?> </option>
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
                                    Nombre:
                                </label><br>
                                <input type="text" id="nombre" name="item[nombre]" class="form-control" placeholder="Ingrese el nombre" value="<?php if ( $type == 'update') { echo $item['nombre']; }?>">
                            </div>
                        </div>
                        <div class="col-lg-6 col-sm-6">
                            <div class="form-group">
                                <label for="message-text" class="form-control-label">
                                    CI:
                                </label><br>
                                <input type="text" id="ci" name="item[ci]" class="form-control" placeholder="Ingrese el ci" value="<?php if ( $type == 'update') { echo $item['ci']; }?>">
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-lg-6 col-sm-6">
                            <div class="form-group">
                                <label for="message-text" class="form-control-label">
                                    Cargo:
                                </label><br>
                                <input type="text" id="cargo" name="item[cargo]" class="form-control" placeholder="Ingrese el cargo" value="<?php if ( $type == 'update') { echo $item['cargo']; }?>">
                            </div>
                        </div>
                        <div class="col-lg-6 col-sm-6 ">
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


</script>
