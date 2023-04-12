<form action="<?php echo site_url('Cga_pago/update_datatable');?>" id="form" method="post">
    <input type="hidden" name="type" value="<?php echo $type; ?>">

    <?php if ($type == "new"){?>
        <input type="hidden" name="item[id_suscripcion]" value="<?php if ($type == "new"){ echo $idP; } ?>">
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
                            Monto:
                        </label><br>
                        <input type="text" id="importe_pagado" name="item[importe_pagado]" class="form-control" placeholder="Ingrese el monto a cancelar" value="<?php if ( $type == 'update') { echo $item['importe_pagado']; }?>">
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
    var id =  "<?php echo $idP;?>";
    var costo_certificado = "<?php echo $costo_certificado;?>";

    $('#importe_pagado').mask("#.##0,00", {reverse: true});

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

    $("#importe_pagado").on("change", function() {
        var importe_actual = parseInt($(this).val());
        $.get( base_url + '/Cga_pago/monto_pagado/?id=' + id, function (data) {
            if (data){
                var monto_inscrito = parseInt(data) + importe_actual;
                if (monto_inscrito > parseInt(costo_certificado)){
                    swal.fire({
                        icon: 'warning',
                        title: 'El monto ingresado no puede ser mayor al costo del certificado',
                        showConfirmButton: false,
                        timer: 3000
                    }).then(function(result) {
                        $("#importe_pagado").val('');
                    });
                }
            }else{
                if (importe_actual > parseInt(costo_certificado)){
                    swal.fire({
                        icon: 'warning',
                        title: 'El monto ingresado no puede ser mayor al costo del certificado',
                        showConfirmButton: false,
                        timer: 3000
                    }).then(function(result) {
                        $("#importe_pagado").val('');
                    });
                }
            }
        });
    });

</script>
