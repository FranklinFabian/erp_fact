
<style type="text/css">
    .nav-tabs > li.active > a {
      background-color: #3B8104 !important;
      color: #fff !important;
      border-radius: 4;
    }
    .nav-tabs > li> a {
      background-color: #1C93C7 !important;
      color: #fff !important;
      border-radius: 4;
    }
     .error-input{
        border: thin solid #d9534f;
    }
</style>
<!-- Add new customer start -->
<div class="content-wrapper">
    <section class="content-header">
        <div class="header-icon">
            <i class="pe-7s-note2"></i>
        </div>
        <div class="header-title">
            <div class="header-title">
                <h1>Gesti&oacute;n de Restituci&oacute;n de Suministros</h1>
                <small>Agregar Restituci&oacute;n de Suministros</small>
                <ol class="breadcrumb">
                    <li><a href="#"><i class="pe-7s-home"></i> <?php echo display('home') ?></a></li>
                    <li><a href="#"><?php echo display('odeco') ?></a></li>
                    <li class="active">Restituci&oacute;n de Suministros</li>
                </ol>
            </div>
        </div>
    </section>

    <section class="content">
        <!-- Alert Message -->
        <?php

        // seteando la hora actual
        date_default_timezone_set('America/La_Paz');

        //var_dump($get_nummedidor);
        ?>
        <!-- New customer -->
        <div class="row">
            <div class="col-sm-12">
                <div class="panel panel-bd lobidrag">
                    <div class="panel-heading">
                        <div class="panel-title">
                            <h4><?php echo $title; ?> </h4>
                        </div>
                    </div>
                               
                    <div class="panel-body">
                        <ul class="nav nav-tabs">
                         <li class="active"><a href="#"><i class="fa fa-plus"> </i> GENERAR REGISTRO NUEVO</a></li>   
                          <li><a href="<?php echo base_url(); ?>odeco/listar_restituciones"><i class="ti-align-justify"> </i> VER LISTA DE INTERRUPCIONES</a></li>
                        </ul>
                    </div>
                    <form  enctype="multipart/form-data" class="form-horizontal" accept-charset="UTF-8"  id="guardar_datos">
                    <div class="panel-body">
                        <fieldset class="form-group">
                            <div class="row">
                                <legend class="col-form-label col-sm-2 pt-0">Formulario de Nuevo Registro</legend>
                                <div class="col-md-9">
                                    <div class="form-group ">
                                        <label for="nro_restitucion" class="col-sm-2 col-form-label">Nro. Restituci&oacute;n :<i class="text-danger">*</i></label>
                                        <div class="col-sm-2">
                                            <input class="form-control" name ="nro_restitucion" id="nro_restitucion" type="text" value="<?= ($data[0]['NRO_REPOSICION']); ?>" min="0" tabindex="3" readonly="">
                                        </div>
                                        <label for="nro_interrupcion" class="col-sm-2 col-form-label">Nro. Interrupci&oacute;n :<i class="text-danger">*</i></label>
                                        <div class="col-sm-2">
                                            <select class="form-control" name="nro_interrupcion" id="nro_interrupcion" tabindex="5">
                                                <option value="<?= ($data[0]['NRO_INTERRUPCION']); ?>"><?= ($data[0]['NRO_INTERRUPCION']); ?></option>
                                                <?php foreach ($get_interrupciones as $key => $list) { ?>
                                                    <option value="<?php echo $list['NRO_INTERRUPCION'] ?>"><?php echo $list['NRO_INTERRUPCION'] ?></option>
                                                <?php } ?>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="cod_proteccion" class="col-sm-2 col-form-label">C&oacute;digo Protecci&oacute;n :<i class="text-danger">*</i></label>
                                        <div class="col-sm-2">
                                            <select class="form-control" name="cod_proteccion" id="cod_proteccion" tabindex="5" aria-required="true" required="">
                                                <option value="<?= ($data[0]['COD_PROTECCION']); ?>"><?= ($data[0]['COD_PROTECCION']); ?></option>
                                                <?php foreach ($get_proteccion as $key => $list) { ?>
                                                    <option value="<?php echo $list['COD_PROTECCION'] ?>"><?php echo $list['COD_PROTECCION'] ?></option>
                                                <?php } ?>
                                            </select>
                                        </div>
                                        <label for="fecha_inicial" class="col-sm-2 col-form-label">Fecha y Hora Reposici&oacute;n :<i class="text-danger">*</i></label>
                                        <div class="col-sm-2">
                                            <input class="form-control" name ="fecha_inicial" id="fecha_inicial" type="date" value="<?= date('Y-m-d',strtotime($data[0]['FECHA_HORA_REPOS'])); ?>"  required="" tabindex="1">
                                        </div>
                                        <div class="col-sm-2">
                                            <input class="form-control" name ="hora_inicial" id="hora_inicial" type="time" value="<?= date('H:i',strtotime($data[0]['FECHA_HORA_REPOS'])); ?>"   required="" tabindex="1">
                                        </div>
                                    </div>
                                    <div class="form-group ">
                                        <label for="consumidores_bt_1" class="col-sm-2 col-form-label">Consumidores Respuestos BT Calidad-1 :<i class="text-danger">*</i></label>
                                        <div class="col-sm-4">
                                            <input class="form-control" name ="consumidores_bt_1" id="consumidores_bt_1" type="number" value="<?= ($data[0]['CONSUM_REP_BT_1']); ?>" min="0" tabindex="3">
                                        </div>
                                        <label for="consumidores_bt_2" class="col-sm-2 col-form-label">Consumidores Respuestos BT Calidad-2 :<i class="text-danger">*</i></label>
                                        <div class="col-sm-4">
                                            <input class="form-control" name ="consumidores_bt_2" id="consumidores_bt_2" type="number" value="<?= ($data[0]['CONSUM_REP_BT_2']); ?>" min="0" tabindex="3">
                                        </div>
                                    </div>
                                    <div class="form-group ">
                                        <label for="consumidores_mt_1" class="col-sm-2 col-form-label">Consumidores Respuestos MT Calidad-1 :<i class="text-danger">*</i></label>
                                        <div class="col-sm-4">
                                            <input class="form-control" name ="consumidores_mt_1" id="consumidores_mt_1" type="number" value="<?= ($data[0]['CONSUM_REP_MT_1']); ?>" min="0" tabindex="3">
                                        </div>
                                        <label for="consumidores_mt_2" class="col-sm-2 col-form-label">Consumidores Respuestos MT Calidad-2 :<i class="text-danger">*</i></label>
                                        <div class="col-sm-4">
                                            <input class="form-control" name ="consumidores_mt_2" id="consumidores_mt_2" type="number" value="<?= ($data[0]['CONSUM_REP_MT_2']); ?>" min="0" tabindex="3">
                                        </div>
                                    </div>
                                    <div class="form-group ">
                                        <label for="potencia_bt_1" class="col-sm-2 col-form-label">Pot. Respuesta a Consumidores en BT Calidad-1 :</label>
                                        <div class="col-sm-4">
                                            <input class="form-control" name ="potencia_bt_1" id="potencia_bt_1" type="number" value="<?= ($data[0]['KVA_RESPUESTA_BT_1']); ?>" min="0" tabindex="3">
                                        </div>
                                        <label for="potencia_bt_2" class="col-sm-2 col-form-label">Pot. Respuesta a Consumidores en BT Calidad-2 :</label>
                                        <div class="col-sm-4">
                                            <input class="form-control" name ="potencia_bt_2" id="potencia_bt_2" type="number" value="<?= ($data[0]['KVA_RESPUESTA_BT_2']); ?>" min="0" tabindex="3">
                                        </div>
                                    </div>
                                    <div class="form-group ">
                                        <label for="potencia_mt_1" class="col-sm-2 col-form-label">Pot. Respuesta a Consumidores en MT Calidad-1 :</label>
                                        <div class="col-sm-4">
                                            <input class="form-control" name ="potencia_mt_1" id="potencia_mt_1" type="number" value="<?= ($data[0]['KVA_RESPUESTA_MT_1']); ?>" min="0" tabindex="3">
                                        </div>
                                        <label for="potencia_mt_2" class="col-sm-2 col-form-label">Pot. Respuesta a Consumidores en MT Calidad-2 :</label>
                                        <div class="col-sm-4">
                                            <input class="form-control" name ="potencia_mt_2" id="potencia_mt_2" type="number" value="<?= ($data[0]['KVA_RESPUESTA_MT_2']); ?>" min="0" tabindex="3">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="motivo" class="col-sm-2 col-form-label">Motivo :<i class="text-danger">*</i></label>
                                        <div class="col-sm-10">
                                            <textarea class="form-control" name="motivo" id="motivo" rows="3" tabindex="4"><?= ($data[0]['MOTIVO']); ?></textarea>
                                        </div>
                                        <label for="observacion" class="col-sm-2 col-form-label">Observaci&oacute;n :<i class="text-danger">*</i></label>
                                        <div class="col-sm-10">
                                            <textarea class="form-control" name="observacion" id="observacion" rows="3" tabindex="4"><?= ($data[0]['OBSERVACION']); ?></textarea>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </fieldset>
                        <div class="form-group row">
                            <label for="example-text-input" class="col-sm-2 col-form-label"></label>
                            <div class="col-sm-4">
                                <input type="button" class="btn btn-default btn-block" value="Cancelar" onclick="window.history.back();" tabindex="7"/>
                            </div>
                            <div class="col-sm-4">
                                <input type="submit" id="add-customer" class="btn btn-primary btn-block" name="add-customer" value="Modificar Restitucion de Suministro" onclick="ModificarRegistro(event);" tabindex="7"/>
                                
                            </div>
                        </div>
                    </div>
                    </form>
                </div>
            </div>
        </div>
    </section>
</div>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
<script src="<?php echo base_url() ?>assets/js/moment.min.js" type="text/javascript"></script>
<script type="text/javascript">
//Registrar Datos en la Base de Datos
function ModificarRegistro(obj){
    obj.preventDefault();
    //validar campos del formulario
    var correcto = true;
      if(!campoVacio($("select[name='nro_interrupcion']")) || !campoVacio($("select[name='cod_proteccion']")) || !campoVacio($("#fecha_inicial")) || !campoVacio($("#hora_inicial")) || !campoVacio($("#consumidores_bt_1"))|| !campoVacio($("#consumidores_bt_2"))|| !campoVacio($("#consumidores_mt_1"))|| !campoVacio($("#consumidores_mt_2"))|| !campoVacio($("#motivo"))|| !campoVacio($("#observacion")))
         correcto = false;
      if(correcto==true){
        var nro_interrupcion = $("#nro_interrupcion").val();
        var cod_proteccion = $("select[name='cod_proteccion']").val();
        var fecha_reposicion = $("#fecha_inicial").val() +' ' + $("#hora_inicial").val();
        var consumidores_bt_1 = $("#consumidores_bt_1").val();
        var consumidores_bt_2 = $("#consumidores_bt_2").val();
        var consumidores_mt_1 = $("#consumidores_mt_1").val();
        var consumidores_mt_2 = $("#consumidores_mt_2").val();
        var potencia_bt_1 = $("#potencia_bt_1").val();
        var potencia_bt_2 = $("#potencia_bt_2").val();
        var potencia_mt_1 = $("#potencia_mt_1").val();
        var potencia_mt_2 = $("#potencia_mt_2").val();
        var motivo = $("#motivo").val();
        var observacion = $("#observacion").val();
        var nro_restitucion = '<?= ($data[0]['NRO_REPOSICION']); ?>';

        // Add record
        $.ajax({
            data: {nro_restitucion,nro_interrupcion,cod_proteccion,fecha_reposicion,consumidores_bt_1,consumidores_bt_2,consumidores_mt_1,consumidores_mt_2,potencia_bt_1,potencia_bt_2,potencia_mt_1,potencia_mt_2,motivo,observacion},
            url: '<?php echo base_url(); ?>odeco/modificar_restitucion',
            type: 'POST',
            dataType: 'json'
            })
        .done(function(response)
            {
                Swal.fire(
                        {
                            icon: 'success',
                            title: 'Se modific&oacute; exitosamente el Registro'
                        }).then(function (){
                            window.location.href ="<?php echo base_url(); ?>odeco/listar_restituciones";
                        });
                
            })
        .fail(function(response)
            {
                Swal.fire({
                            icon: 'error',
                            title: 'Hubo Problemas al Modificar el Registro'
                        }).then(function (){
                            //type: 'warning'
                            window.location.href ="<?php echo base_url(); ?>odeco/listar_restituciones";
                        });
            });
    }else{
        Swal.fire({
        icon: 'error',
        title: 'Debe llenar todos los campos requeridos'
        });
    }
}
//validar campos
function campoVacio(obj)
{
    var correcto = true;
        if(obj.val()==''){
            obj.addClass("error-input");
            correcto = false;
        }else{
            obj.removeClass("error-input")
        }
    return correcto;
}
 
</script>