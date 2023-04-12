<form action="<?php echo site_url('Cma_egreso/update_datatable');?>" id="form" method="post">
    <input type="hidden" name="type" value="<?php echo $type; ?>">

    <?php if ($type == "new"){?>
        <input type="hidden" name="item[id_cabecera]" value="<?php if ($type == "new"){ echo $idP; } ?>">
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

                    <div class="form-group">
                        <label for="message-text" class="form-control-label">
                            Grupo:
                        </label><br>
                        <select id="id_grupo" class="form-control select2_general" style="width: 100%">
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


                    <div class="form-group">

                        <div class="row">
                            <div class="col-lg-9">
                                <label for="message-text" class="form-control-label">
                                    Articulo:
                                </label><br>
                                <select name="item[id_articulo]" id="id_articulo" class="form-control select2_general" style="width: 100%" required <?php if ($type == "new"){?> disabled  <?php } ?>>
                                    <option></option>
                                    <?php foreach ($articulos as $articulo) {
                                        if ($articulo['id'] == $item['id_articulo']){ ?>
                                            <option value="<?php echo $articulo['id'] ?>" selected>  <?php echo $articulo['nombre']; ?> </option>
                                        <?php } else { ?>
                                            <option value="<?php echo $articulo['id'] ?>">  <?php echo $articulo['nombre'] ?> </option>
                                        <?php } ?>
                                    <?php } ?>
                                </select>
                            </div>

                            <div class="col-lg-3">
                                <div align="center">
                                    <label for="message-text" class="form-control-label">
                                        Stock Disponible
                                    </label><br>
                                </div>
                                <div align="center">
                                    <span id="stock" style="color:#3A95E4; font-size: 20px;  font-weight: bold; "> <?php if ($type == "update"){ echo $stock; } else{ echo 0; } ?> </span>
                                </div>
                            </div>
                        </div>

                    </div>

                    <div class="form-group">
                        <label for="message-text" class="form-control-label">
                            Proyecto:
                        </label><br>
                        <select name="item[id_proyecto]" class="form-control select2_general" style="width: 100%" required>
                            <option></option>
                            <?php foreach ($proyectos as $proyecto) {
                                if ($proyecto['id'] == $item['id_proyecto']){ ?>
                                    <option value="<?php echo $proyecto['id'] ?>" selected>  <?php echo $proyecto['nombre']; ?> </option>
                                <?php } else { ?>
                                    <option value="<?php echo $proyecto['id'] ?>">  <?php echo $proyecto['nombre'] ?> </option>
                                <?php } ?>
                            <?php } ?>
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="message-text" class="form-control-label">
                            Cuenta Contable:
                        </label><br>
                        <select id="id_cuenta_contable" class="form-control select2_general" style="width: 100%" name="item[id_cuenta_contable]">
                            <option></option>
                            <?php foreach ($cuentas_contables as $cuenta) {
                                if ($cuenta['id'] == $item['id_cuenta']){ ?>
                                    <option value="<?php echo $cuenta['id'] ?>" selected>  <?php echo $cuenta['codigo_formato'] . " - " .  $cuenta['nombre']; ?> </option>
                                <?php } else { ?>
                                    <option value="<?php echo $cuenta['id'] ?>">  <?php echo $cuenta['codigo_formato'] . " - " . $cuenta['nombre'] ?> </option>
                                <?php } ?>
                            <?php } ?>
                        </select>
                    </div>

                    <!-- <div class="form-group">
                        <label for="messagse-text" class="form-control-label">
                            Cuenta Auxiliar:
                        </label><br>
                        <select name="item[id_cuenta_auxiliar]" id="id_cuenta_auxiliar" class="form-control select2_general" style="width: 100%"  <?php if ($type == "new"){?> disabled  <?php } ?>>
                            <option></option>
                            <?php foreach ($cuentas_auxiliares as $cuenta_auxiliar) {
                                if ($cuenta_auxiliar['id'] == $item['id_cuenta_auxiliar']){ ?>
                                    <option value="<?php echo $cuenta_auxiliar['id'] ?>" selected>  <?php echo $cuenta_auxiliar['nombre']; ?> </option>
                                <?php } else { ?>
                                    <option value="<?php echo $cuenta_auxiliar['id'] ?>">  <?php echo $cuenta_auxiliar['nombre'] ?> </option>
                                <?php } ?>
                            <?php } ?>
                        </select>
                    </div> -->

                    <div class="form-group">
                        <label for="message-text" class="form-control-label">
                            Cantidad:
                        </label><br>
                        <input type="number"  id="cantidad" name="item[cantidad]" class="form-control" placeholder="Ingrese la cantidad de egreso" value="<?php if ( $type == 'update') { echo $item['cantidad']; }?>">
                        <span id="mensaje" style="color:red; font-size: 10px;  font-weight: bold; " ></span>
                    </div>

                    <!-- <div class="form-group">
                        <label for="message-text" class="form-control-label">
                            Costo:
                        </label><br>
                        <input type="text" id="costo" name="item[costo]" class="form-control" placeholder="Ingrese la cantidad" value=" <?php if ( $type == 'update') { echo $item['costo']; }?> ">
                    </div> -->

                    <br>

                    <div class="form-group row">
                        <div class="col-sm-12" align="right">
                            <input type="submit" id="boton" class="btn btn-primary btn-large" name="add" value="Guardar cambios" />
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

    $("#id_cuenta_contable").on('change', function () {
        $("#id_cuenta_auxiliar").prop("disabled", false);
        cuenta_auxiliar($(this).val());
    });

    function cuenta_auxiliar (id){
        $("#id_cuenta_contable option:selected").each(function () {
            $.get( base_url + '/Cma_cuentaAuxiliar/lista/?id=' + id, function (data) {
                $("#id_cuenta_auxiliar").empty();
                $("#id_cuenta_auxiliar").append("<option></option>");
                $.each(jQuery.parseJSON(data), function () {
                    $("#id_cuenta_auxiliar").append($("<option></option>").val(this['id']).html(this['nombre']));
                });
            });
        });
    }

    $("#id_grupo").on('change', function () {
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
    }

    $("#id_articulo").on('change', function () {
        $.get( base_url + '/Cma_articulo/stock/?id=' + this.value, function (data) {
            $("#stock").text(data);
        });
    });

    $("#cantidad").on("input", function(){
        var cantidad;
        var articulo;
        var stock;
        stock = $('#stock').text();
        cantidad = parseInt(this.value);
        articulo = $( "#id_articulo" ).val();

        if (!articulo.trim()){

        }else{
            if (cantidad > stock || cantidad == 0){
                $("#mensaje").show();
                $("#mensaje").text("La cantidad ingresada no puede ser cero, ni mayor al stock disponible del articulo");
                $("#boton").prop('disabled', true);
            }else{
                $("#mensaje").hide();
                $("#boton").prop('disabled', false);
            }
        }

    });

    //$('#costo').mask("#.##0,00", {reverse: true});
</script>
