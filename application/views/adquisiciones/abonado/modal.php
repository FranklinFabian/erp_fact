<form action="<?php echo site_url('adquisiciones/Cabonado/update');?>" id="form" method="post" target="_blank">
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
                        <div class="col-lg-8 col-sm-8">
                            <div class="form-group">
                                <label for="message-text" class="form-control-label">
                                    Cliente:
                                </label><br>
                                <select id="id_cliente" name="item[id_cliente]" class="form-control select2_general" style="width: 100%; display: block;z-index: 9999;margin-top: 100px;" required>
                                    <option></option>
                                    <?php foreach ($clientes as $cliente) {
                                        if ($cliente['id'] == $item['id_cliente']){ ?>
                                            <option value="<?php echo $cliente['id'] ?>" selected>  <?php echo $cliente['cid'] . " - " . $cliente['razon_social']; ?> </option>
                                        <?php } else { ?>
                                            <option value="<?php echo $cliente['id'] ?>">  <?php echo $cliente['cid'] . " - " . $cliente['razon_social']; ?> </option>
                                        <?php } ?>
                                    <?php } ?>
                                </select>
                            </div>
                        </div>

                        <div class="col-lg-4 col-sm-4">
                            <div class="form-group">
                                <label for="message-text" class="form-control-label">
                                        Edad del Cliente:
                                </label><br>
                                <span id="edad">
                                    <?php if ( $type == 'update') { echo $item['edad'] . ' años.'; }?>
                                </span>
                            </div>
                        </div>

                    </div>

                    <div class="row">
                        <div class="col-lg-4 col-sm-4">
                            <div class="form-group">
                                <label for="message-text" class="form-control-label">
                                    Categoria:
                                </label><br>
                                <select id="id_categoria" name="item[id_categoria]" class="form-control select2_general" style="width: 100%; display: block;z-index: 9999;margin-top: 100px;" required>
                                    <option></option>
                                    <?php foreach ($categorias as $categoria) {
                                        if ($categoria['id'] == $item['id_categoria']){ ?>
                                            <option value="<?php echo $categoria['id'] ?>" selected>  <?php echo $categoria['nombre']; ?> </option>
                                        <?php } else { ?>
                                            <option value="<?php echo $categoria['id'] ?>">  <?php echo $categoria['nombre']; ?> </option>
                                        <?php } ?>
                                    <?php } ?>
                                </select>
                            </div>
                        </div>

                        <div class="col-lg-4 col-sm-4">
                            <div class="form-group">
                                <label for="message-text" class="form-control-label">
                                    Localidad:
                                </label><br>
                                <select id="id_localidad" class="form-control select2_general" style="width: 100%; display: block;z-index: 9999;margin-top: 100px;" required>
                                    <option></option>
                                    <?php foreach ($localidades as $localidad) {
                                        if ($localidad['id'] == $item['id_localidad']){ ?>
                                            <option value="<?php echo $localidad['id'] ?>" selected>  <?php echo $localidad['nombre']; ?> </option>
                                        <?php } else { ?>
                                            <option value="<?php echo $localidad['id'] ?>">  <?php echo $localidad['nombre']; ?> </option>
                                        <?php } ?>
                                    <?php } ?>
                                </select>
                            </div>
                        </div>
                        <div class="col-lg-4 col-sm-4">
                            <div class="form-group">
                                <label for="message-text" class="form-control-label">
                                    Zona:
                                </label><br>
                                <select id="id_zona" name="item[id_zona]" class="form-control select2_general" style="width: 100%; display: block;z-index: 9999;margin-top: 100px;" <?php if ($type == "new"){?> disabled  <?php } ?> required>
                                    <option></option>
                                    <?php foreach ($zonas as $zona) {
                                        if ($zona['id'] == $item['id_zona']){ ?>
                                            <option value="<?php echo $zona['id'] ?>" selected>  <?php echo $zona['nombre']; ?> </option>
                                        <?php } else { ?>
                                            <option value="<?php echo $zona['id'] ?>">  <?php echo $zona['nombre']; ?> </option>
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
                                    Dirección:
                                </label><br>
                                <input type="text" id="direccion" name="item[direccion]" class="form-control" placeholder="Ingrese la Dirección" value="<?php if ( $type == 'update') { echo $item['direccion']; }?>">
                            </div>
                        </div>
                        <div class="col-lg-6 col-sm-6">
                            <div class="form-group">
                                <label for="message-text" class="form-control-label">
                                    Número:
                                </label><br>
                                <input type="text" id="numero" name="item[numero]" class="form-control" placeholder="S/N" value="<?php if ( $type == 'update') { echo $item['numero']; }?>">
                            </div>
                        </div>
                    </div>


                    <div class="row">
                        <div class="col-lg-4 col-sm-4">
                            <div class="form-group">
                                <label for="message-text" class="form-control-label">
                                    Transformador:
                                </label><br>
                                <select id="id_transformador" class="form-control select2_general" style="width: 100%; display: block;z-index: 9999;margin-top: 100px;" required>
                                    <option></option>
                                    <?php foreach ($transformadores as $transformador) {
                                        if ($transformador['id'] == $item['id_transformador']){ ?>
                                            <option value="<?php echo $transformador['id'] ?>" selected>  <?php echo $transformador['nombre']; ?> </option>
                                        <?php } else { ?>
                                            <option value="<?php echo $transformador['id'] ?>">  <?php echo $transformador['nombre']; ?> </option>
                                        <?php } ?>
                                    <?php } ?>
                                </select>
                            </div>
                        </div>
                        <div class="col-lg-4 col-sm-4">
                            <div class="form-group">
                                <label for="message-text" class="form-control-label">
                                    Poste:
                                </label><br>
                                <select id="id_poste" name="item[id_poste]" class="form-control select2_general" style="width: 100%; display: block;z-index: 9999;margin-top: 100px;" <?php if ($type == "new"){?> disabled  <?php } ?> required>
                                    <option></option>
                                    <?php foreach ($postes as $poste) {
                                        if ($poste['id'] == $item['id_poste']){ ?>
                                            <option value="<?php echo $poste['id'] ?>" selected>  <?php echo $poste['nombre']; ?> </option>
                                        <?php } else { ?>
                                            <option value="<?php echo $poste['id'] ?>">  <?php echo $poste['nombre']; ?> </option>
                                        <?php } ?>
                                    <?php } ?>
                                </select>
                            </div>
                        </div>
                        <div class="col-lg-2 col-sm-4 ">
                            <div class="form-group">
                                <label for="message-text" class="form-control-label">
                                    Distancia Poste:

                                <input type="text" id="distancia_poste" name="item[distancia_poste]" class="form-control" placeholder="Ingrese la distancia" value="<?php if ( $type == 'update') { echo $item['distancia_poste']; }?>">
                            </div>

                        </div>
                        <div class="col-lg-2 col-sm-4 ">
                            </label><br>
                            <select id="distancia" name="item[id_distancia]" class="form-control select2_general" style="width: 100%; display: block;z-index: 9999;margin-top: 100px;" required>
                                <option ></option>
                                <?php foreach ($distancias as $distancia) {
                                    if ($distancia['id'] == $item['id_distancia']){ ?>
                                        <option value="<?php echo $distancia['id'] ?>" selected >  <?php echo $distancia['nombre']; ?> </option>
                                    <?php } else { ?>
                                        <option value="<?php echo $distancia['id'] ?>" >  <?php echo $distancia['nombre']; ?> </option>
                                    <?php } ?>
                                <?php } ?>
                            </select>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-lg-4 col-sm-4">
                            <div class="form-group">
                                <label for="message-text" class="form-control-label">
                                    Medidor:
                                </label><br>
                                <input type="text" id="medidor" name="item[medidor]" class="form-control" placeholder="Ingrese el Medidor" value="<?php if ( $type == 'update') { echo $item['medidor']; }?>">
                            </div>
                        </div>
                        <div class="col-lg-4 col-sm-4">
                            <div class="form-group">
                                <label for="message-text" class="form-control-label">
                                    Lectura:
                                </label><br>
                                <input type="text" id="lectura" name="item[lectura]" class="form-control" placeholder="Ingrese la Lectura" value="<?php if ( $type == 'update') { echo $item['lectura']; }?>">
                            </div>
                        </div>
                        <div class="col-lg-4 col-sm-4">
                            <div class="form-group">
                                <label for="message-text" class="form-control-label">
                                    Multiplicador:
                                </label><br>
                                <input type="text" id="multiplicador" name="item[multiplicador]" class="form-control" placeholder="1" value="<?php if ( $type == 'update') { echo $item['multiplicador']; }?>">
                            </div>
                        </div>
                    </div>


                    <div class="row">
                        <div class="col-lg-3 col-sm-3">
                            <div class="form-group">
                                <label for="message-text" class="form-control-label">
                                    Suministro:
                                </label><br>
                                <select id="id_suministro" name="item[id_suministro]" class="form-control select2_general" style="width: 100%; display: block;z-index: 9999;margin-top: 100px;" required>
                                    <option></option>
                                    <?php foreach ($suministros as $suministro) {
                                        if ($suministro['id'] == $item['id_suministro']){ ?>
                                            <option value="<?php echo $suministro['id'] ?>" selected>  <?php echo $suministro['nombre']; ?> </option>
                                        <?php } else { ?>
                                            <option value="<?php echo $suministro['id'] ?>">  <?php echo $suministro['nombre']; ?> </option>
                                        <?php } ?>
                                    <?php } ?>
                                </select>
                            </div>
                        </div>

                        <div class="col-lg-3 col-sm-3">
                            <div class="form-group">
                                <label for="message-text" class="form-control-label">
                                    Consumidor:
                                </label><br>
                                <select id="id_consumidor" name="item[id_consumidor]" class="form-control select2_general" style="width: 100%; display: block;z-index: 9999;margin-top: 100px;" required>
                                    <option></option>
                                    <?php foreach ($consumidores as $consumidor) {
                                        if ($consumidor['id'] == $item['id_consumidor']){ ?>
                                            <option value="<?php echo $consumidor['id'] ?>" selected>  <?php echo $consumidor['nombre']; ?> </option>
                                        <?php } else { ?>
                                            <option value="<?php echo $consumidor['id'] ?>">  <?php echo $consumidor['nombre']; ?> </option>
                                        <?php } ?>
                                    <?php } ?>
                                </select>
                            </div>
                        </div>

                        <div class="col-lg-3 col-sm-3">
                            <div class="form-group">
                                <label for="message-text" class="form-control-label">
                                    Medicion:
                                </label><br>
                                <select id="id_medicion" name="item[id_medicion]" class="form-control select2_general" style="width: 100%; display: block;z-index: 9999;margin-top: 100px;" required>
                                    <option></option>
                                    <?php foreach ($mediciones as $medicion) {
                                        if ($medicion['id'] == $item['id_medicion']){ ?>
                                            <option value="<?php echo $medicion['id'] ?>" selected>  <?php echo $medicion['nombre']; ?> </option>
                                        <?php } else { ?>
                                            <option value="<?php echo $medicion['id'] ?>">  <?php echo $medicion['nombre']; ?> </option>
                                        <?php } ?>
                                    <?php } ?>
                                </select>
                            </div>
                        </div>

                        <div class="col-lg-3 col-sm-3">
                            <div class="form-group">
                                <label for="message-text" class="form-control-label">
                                    Liberación:
                                </label><br>
                                <select id="id_liberacion" name="item[id_liberacion]" class="form-control select2_general" style="width: 100%; display: block;z-index: 9999;margin-top: 100px;" required>
                                    <option></option>
                                    <?php foreach ($liberaciones as $liberacion) {
                                        if ($liberacion['id'] == $item['id_liberacion']){ ?>
                                            <option value="<?php echo $liberacion['id'] ?>" selected>  <?php echo $liberacion['nombre']; ?> </option>
                                        <?php } else { ?>
                                            <option value="<?php echo $liberacion['id'] ?>">  <?php echo $liberacion['nombre']; ?> </option>
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
                                    Existe Inquilino:
                                </label><br>
                                <select id="id_existe_inquilino" name="item[id_existe_inquilino]" class="form-control select2_general" style="width: 100%; display: block;z-index: 9999;margin-top: 100px;" required>
                                    <option></option>
                                    <?php foreach ($estados as $estado) {
                                        if ($estado['id'] == $item['id_existe_inquilino']){ ?>
                                            <option value="<?php echo $estado['id'] ?>" selected>  <?php echo $estado['nombre']; ?> </option>
                                        <?php } else { ?>
                                            <option value="<?php echo $estado['id'] ?>">  <?php echo $estado['nombre']; ?> </option>
                                        <?php } ?>
                                    <?php } ?>
                                </select>
                            </div>
                        </div>

                        <div id="campos_inquilino" style =" <?php if ( $type == 'update' && $item['id_existe_inquilino'] ==  1){ }else{ echo "display:none";}?> "  >
                            <div class="col-lg-3 col-sm-3">
                                <div class="form-group">
                                    <label for="message-text" class="form-control-label">
                                        CI Inquilino:
                                    </label><br>
                                    <input type="text" id="ci_inquilino" name="item[ci_inquilino]" class="form-control" placeholder="Ingrese el CI" value="<?php if ( $type == 'update') { echo $item['ci_inquilino']; }?>">
                                </div>
                            </div>

                            <div class="col-lg-3 col-sm-3">
                                <div class="form-group">
                                    <label for="message-text" class="form-control-label">
                                        Nombre Inquilino:
                                    </label><br>
                                    <input type="text" id="nombre_inquilino" name="item[nombre_inquilino]" class="form-control" placeholder="Ingrese el nombre" value="<?php if ( $type == 'update') { echo $item['nombre_inquilino']; }?>">
                                </div>
                            </div>


                            <div class="col-lg-3 col-sm-3">
                                <div class="form-group">
                                    <label for="message-text" class="form-control-label">
                                        Celular Inquilino:
                                    </label><br>
                                    <input type="text" id="cel_inquilino" name="item[cel_inquilino]" class="form-control" placeholder="Ingrese el celular" value="<?php if ( $type == 'update') { echo $item['cel_inquilino']; }?>">
                                </div>
                            </div>

                        </div>






                    </div>




                    <div class="row">
                        <div class="col-lg-6 col-sm-6">
                            <div class="form-group">
                                <label for="message-text" class="form-control-label">
                                    Descuento (Ley 1886):
                                </label><br>
                                <select id="id_ley_adulto" name="item[id_ley_adulto]" class="form-control select2_general" style="width: 100%; display: block;z-index: 9999;margin-top: 100px;" required>
                                    <option></option>
                                    <?php foreach ($estados as $estado) {
                                        if ($estado['id'] == $item['id_ley_adulto']){ ?>
                                            <option value="<?php echo $estado['id'] ?>" selected>  <?php echo $estado['nombre']; ?> </option>
                                        <?php } else { ?>
                                            <option value="<?php echo $estado['id'] ?>">  <?php echo $estado['nombre']; ?> </option>
                                        <?php } ?>
                                    <?php } ?>
                                </select>
                            </div>
                        </div>

                        <div class="col-lg-2 col-sm-2">
                            <div class="form-group">
                                <label for="message-text" class="form-control-label">
                                    Gestion:
                                </label><br>
                                <select id="id_gestion" name="item[id_gestion]" class="form-control select2_general" style="width: 100%; display: block;z-index: 9999;margin-top: 100px;" required>
                                    <option></option>
                                    <?php foreach ($gestiones as $gestion) {
                                        if ($gestion['id'] == $item['id_gestion']){ ?>
                                            <option value="<?php echo $gestion['id'] ?>" selected>  <?php echo $gestion['gestion']; ?> </option>
                                        <?php } else { ?>
                                            <option value="<?php echo $gestion['id'] ?>">  <?php echo $gestion['gestion']; ?> </option>
                                        <?php } ?>
                                    <?php } ?>
                                </select>
                            </div>
                        </div>

                    </div>

                    <div class="row">
                        <div class="col-lg-6 col-sm-6">
                            <div class="form-group">

                            </div>
                        </div>

                        <div class="col-lg-6 col-sm-6">
                            <div class="form-group">
                                <label for="message-text" class="form-control-label">
                                    &nbsp;
                                </label><br>
                                <input type="submit" id="add" class="btn btn-primary right-side" name="add" value="<?php echo display('save_changes') ?>" />
                            </div>
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

        });

        $('.select2_general').select2({
            placeholder: "Seleccione una opción",
            dropdownParent: $('#form_modal')
        });


    });

    $("#id_existe_inquilino").change(function () {
        if(this.value == 1){
            $("#campos_inquilino").show()
        }else{
            $("#campos_inquilino").hide()
        }

    });

    $("#id_cliente").on('change', function () {
        $.get( base_url + '/adquisiciones/Ccliente/getEdad/?id=' + this.value, function (data) {
            $("#edad").text(data + ' años');
        });
    });

    $("#id_localidad").on('change', function () {
        $("#id_zona").prop("disabled", false);
        zona($(this).val());
    });

    function zona (id){
        $("#id_localidad option:selected").each(function () {
            $.get( base_url + '/adquisiciones/Czona/listaFiltrada/?id=' + id, function (data) {
                $("#id_zona").empty();
                $("#id_zona").append("<option></option>");
                $.each(jQuery.parseJSON(data), function () {
                    $("#id_zona").append($("<option></option>").val(this['id']).html(this['nombre']));
                });
            });
        });
    }


    $("#id_transformador").on('change', function () {
        $("#id_poste").prop("disabled", false);
        poste($(this).val());
    });

    function poste (id){
        $("#id_transformador option:selected").each(function () {
            $.get( base_url + '/adquisiciones/Cposte/listaFiltrada/?id=' + id, function (data) {
                $("#id_poste").empty();
                $("#id_poste").append("<option></option>");
                $.each(jQuery.parseJSON(data), function () {
                    $("#id_poste").append($("<option></option>").val(this['id']).html(this['nombre']));
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
