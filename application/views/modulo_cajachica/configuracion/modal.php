<form action="<?php echo site_url('Cmcajachica_configuracion/update');?>" id="form" method="post">
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
                                    Monto Mensual Asignado:
                                </label><br>
                                <input type="text" id="nombre" name="item[monto_maximo]" class="form-control" placeholder="Ingrese el monto maximo" value="<?php if ( $type == 'update') { echo $item['monto_maximo']; }?>">
                            </div>
                        </div>

                        <div class="col-lg-6 col-sm-6">
                            <div class="form-group">
                                <label for="message-text" class="form-control-label">
                                    Porcentaje:
                                </label><br>
                                <input type="text" id="porcentaje_minimo" name="item[porcentaje_minimo]" class="form-control" placeholder="Ingrese el porcentaje" value="<?php if ( $type == 'update') { echo $item['porcentaje_minimo']; }?>">
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
